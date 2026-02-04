<?php

namespace App\Http\Controllers;

use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FinancialController extends Controller
{
    /**
     * Display a listing of financial transactions
     */
    public function index(Request $request)
    {
        $query = FinancialTransaction::with('recordedBy');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        } elseif ($request->filled('period')) {
            switch ($request->period) {
                case 'month':
                    $query->thisMonth();
                    break;
                case 'year':
                    $query->thisYear();
                    break;
            }
        } else {
            $query->thisMonth(); // Default to current month
        }

        $transactions = $query->latest('transaction_date')->paginate(20);

        // Calculate totals
        $totalIncome = (clone $query)->income()->sum('amount');
        $totalExpenses = (clone $query)->expense()->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;

        // Get categories
        $incomeCategories = FinancialTransaction::income()
            ->distinct()
            ->pluck('category');
        
        $expenseCategories = FinancialTransaction::expense()
            ->distinct()
            ->pluck('category');

        return view('financial.index', compact(
            'transactions',
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'incomeCategories',
            'expenseCategories'
        ));
    }

    /**
     * Show the form for creating a new transaction
     */
    public function create()
    {
        $incomeCategories = ['Milk Sales', 'Animal Sales', 'Other Income'];
        $expenseCategories = ['Feed', 'Veterinary', 'Labor', 'Equipment', 'Utilities', 'Other Expenses'];
        
        return view('financial.create', compact('incomeCategories', 'expenseCategories'));
    }

    /**
     * Store a newly created transaction
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date|before_or_equal:today',
        ]);

        $validated['recorded_by'] = Auth::id();

        FinancialTransaction::create($validated);

        return redirect()->route('financial.index')
            ->with('success', 'Transaction recorded successfully!');
    }

    /**
     * Display the specified transaction
     */
    public function show(FinancialTransaction $financial)
    {
        $financial->load('recordedBy');
        return view('financial.show', compact('financial'));
    }

    /**
     * Show the form for editing the specified transaction
     */
    public function edit(FinancialTransaction $financial)
    {
        $incomeCategories = ['Milk Sales', 'Animal Sales', 'Other Income'];
        $expenseCategories = ['Feed', 'Veterinary', 'Labor', 'Equipment', 'Utilities', 'Other Expenses'];
        
        return view('financial.edit', compact('financial', 'incomeCategories', 'expenseCategories'));
    }

    /**
     * Update the specified transaction
     */
    public function update(Request $request, FinancialTransaction $financial)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'transaction_date' => 'required|date|before_or_equal:today',
        ]);

        $financial->update($validated);

        return redirect()->route('financial.index')
            ->with('success', 'Transaction updated successfully!');
    }

    /**
     * Remove the specified transaction
     */
    public function destroy(FinancialTransaction $financial)
    {
        // Only admins can delete transactions (will be enforced by middleware/policy)
        $financial->delete();

        return redirect()->route('financial.index')
            ->with('success', 'Transaction deleted successfully!');
    }

    /**
     * Display financial summary/reports
     */
    public function summary(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        // Monthly summary
        $monthlyIncome = FinancialTransaction::income()
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        $monthlyExpenses = FinancialTransaction::expense()
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->sum('amount');

        // Yearly summary
        $yearlyIncome = FinancialTransaction::income()
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        $yearlyExpenses = FinancialTransaction::expense()
            ->whereYear('transaction_date', $year)
            ->sum('amount');

        // Income by category
        $incomeByCategory = FinancialTransaction::select('category', DB::raw('SUM(amount) as total'))
            ->income()
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->groupBy('category')
            ->get();

        // Expenses by category
        $expensesByCategory = FinancialTransaction::select('category', DB::raw('SUM(amount) as total'))
            ->expense()
            ->whereYear('transaction_date', $year)
            ->whereMonth('transaction_date', $month)
            ->groupBy('category')
            ->get();

        // Monthly trend for the year
        $monthlyTrend = FinancialTransaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
            )
            ->whereYear('transaction_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('financial.summary', compact(
            'monthlyIncome',
            'monthlyExpenses',
            'yearlyIncome',
            'yearlyExpenses',
            'incomeByCategory',
            'expensesByCategory',
            'monthlyTrend',
            'year',
            'month'
        ));
    }
}
