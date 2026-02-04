<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use App\Models\HealthRecord;
use App\Models\Breeding;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Milk production report
     */
    public function milkProduction(Request $request)
    {
        // Today's production
        $todayProduction = MilkProduction::whereDate('production_date', today())->sum('quantity_liters');
        
        // This week's production
        $weekProduction = MilkProduction::whereBetween('production_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('quantity_liters');
        
        // This month's production
        $monthProduction = MilkProduction::whereBetween('production_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('quantity_liters');
        
        // Average daily production
        $avgDailyProduction = MilkProduction::whereBetween('production_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->selectRaw('AVG(daily_total) as avg')
            ->fromSub(function($query) {
                $query->from('milk_production')
                    ->selectRaw('production_date, SUM(quantity_liters) as daily_total')
                    ->whereBetween('production_date', [now()->startOfMonth(), now()->endOfMonth()])
                    ->groupBy('production_date');
            }, 'daily_totals')
            ->value('avg') ?? 0;

        // Top producers this month
        $topProducers = MilkProduction::select('animal_id')
            ->selectRaw('SUM(quantity_liters) as total_production')
            ->selectRaw('COUNT(*) as record_count')
            ->whereBetween('production_date', [now()->startOfMonth(), now()->endOfMonth()])
            ->with('animal')
            ->groupBy('animal_id')
            ->orderByDesc('total_production')
            ->take(10)
            ->get();

        // Recent production records
        $recentProductions = MilkProduction::with(['animal', 'recordedBy'])
            ->latest('production_date')
            ->take(20)
            ->get();

        return view('reports.milk-production', compact(
            'todayProduction',
            'weekProduction',
            'monthProduction',
            'avgDailyProduction',
            'topProducers',
            'recentProductions'
        ));
    }

    /**
     * Animal health report
     */
    public function animalHealth(Request $request)
    {
        // Total health records
        $totalRecords = HealthRecord::count();
        
        // This month's records
        $monthRecords = HealthRecord::whereBetween('record_date', [now()->startOfMonth(), now()->endOfMonth()])->count();
        
        // Vaccination count
        $vaccinationCount = HealthRecord::where('condition', 'like', '%vaccination%')
            ->orWhere('condition', 'like', '%vaccine%')
            ->count();
        
        // Treatment count
        $treatmentCount = HealthRecord::whereNotNull('treatment')->count();

        // Recent health records
        $recentRecords = HealthRecord::with(['animal', 'recordedBy'])
            ->latest('record_date')
            ->take(20)
            ->get();

        // Common conditions
        $commonConditions = HealthRecord::select('condition')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('condition')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        return view('reports.animal-health', compact(
            'totalRecords',
            'monthRecords',
            'vaccinationCount',
            'treatmentCount',
            'recentRecords',
            'commonConditions'
        ));
    }

    /**
     * Breeding report
     */
    public function breeding(Request $request)
    {
        // Total breedings
        $totalBreedings = Breeding::count();
        
        // Currently pregnant
        $pregnantCount = Breeding::where('pregnancy_status', 'pregnant')->count();
        
        // Successful births
        $birthCount = Breeding::where('pregnancy_status', 'gave_birth')->count();
        
        // Failed
        $failedCount = Breeding::where('pregnancy_status', 'failed')->count();
        
        // Pending
        $pendingCount = Breeding::where('pregnancy_status', 'pending')->count();
        
        // Success rate
        $completedBreedings = $birthCount + $failedCount;
        $successRate = $completedBreedings > 0 ? ($birthCount / $completedBreedings) * 100 : 0;

        // Upcoming births (pregnant animals with expected birth date)
        $upcomingBirths = Breeding::with('animal')
            ->where('pregnancy_status', 'pregnant')
            ->whereNotNull('expected_birth_date')
            ->orderBy('expected_birth_date')
            ->get();

        return view('reports.breeding', compact(
            'totalBreedings',
            'pregnantCount',
            'birthCount',
            'failedCount',
            'pendingCount',
            'successRate',
            'upcomingBirths'
        ));
    }

    /**
     * Financial report
     */
    public function financial(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month');

        $query = FinancialTransaction::whereYear('transaction_date', $year);
        
        if ($month) {
            $query->whereMonth('transaction_date', $month);
        }

        // Income and expenses
        $totalIncome = (clone $query)->income()->sum('amount');
        $totalExpenses = (clone $query)->expense()->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;

        // Income by category
        $incomeByCategory = FinancialTransaction::select('category', DB::raw('SUM(amount) as total'))
            ->income()
            ->whereYear('transaction_date', $year)
            ->when($month, function($q) use ($month) {
                $q->whereMonth('transaction_date', $month);
            })
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Expenses by category
        $expensesByCategory = FinancialTransaction::select('category', DB::raw('SUM(amount) as total'))
            ->expense()
            ->whereYear('transaction_date', $year)
            ->when($month, function($q) use ($month) {
                $q->whereMonth('transaction_date', $month);
            })
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        // Monthly trend
        $monthlyTrend = FinancialTransaction::select(
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expenses')
            )
            ->whereYear('transaction_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent transactions
        $recentTransactions = $query->with('recordedBy')
            ->latest('transaction_date')
            ->take(20)
            ->get();

        return view('reports.financial', compact(
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'incomeByCategory',
            'expensesByCategory',
            'monthlyTrend',
            'recentTransactions',
            'year',
            'month'
        ));
    }

    /**
     * Comprehensive farm report
     */
    public function comprehensive(Request $request)
    {
        // Animals summary
        $totalAnimals = Animal::count();
        $activeAnimals = Animal::where('status', 'active')->count();
        
        // Workers count
        $totalWorkers = \App\Models\Worker::count();
        
        // Pregnant animals
        $pregnantAnimals = Breeding::where('pregnancy_status', 'pregnant')->count();

        // Milk production
        $todayProduction = MilkProduction::whereDate('production_date', today())->sum('quantity_liters');
        $weekProduction = MilkProduction::whereBetween('production_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('quantity_liters');
        $monthProduction = MilkProduction::whereBetween('production_date', [now()->startOfMonth(), now()->endOfMonth()])->sum('quantity_liters');
        $totalProduction = MilkProduction::sum('quantity_liters');

        // Financial summary
        $totalIncome = FinancialTransaction::where('type', 'income')->sum('amount');
        $totalExpenses = FinancialTransaction::where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpenses;

        // Health summary
        $totalHealthRecords = HealthRecord::count();
        $monthHealthRecords = HealthRecord::whereBetween('record_date', [now()->startOfMonth(), now()->endOfMonth()])->count();
        $vaccinationCount = HealthRecord::where('condition', 'like', '%vaccination%')
            ->orWhere('condition', 'like', '%vaccine%')
            ->count();

        // Breeding summary
        $totalBreedings = Breeding::count();
        $birthCount = Breeding::where('pregnancy_status', 'gave_birth')->count();
        $completedBreedings = $birthCount + Breeding::where('pregnancy_status', 'failed')->count();
        $breedingSuccessRate = $completedBreedings > 0 ? ($birthCount / $completedBreedings) * 100 : 0;

        return view('reports.comprehensive', compact(
            'totalAnimals',
            'activeAnimals',
            'totalWorkers',
            'pregnantAnimals',
            'todayProduction',
            'weekProduction',
            'monthProduction',
            'totalProduction',
            'totalIncome',
            'totalExpenses',
            'netProfit',
            'totalHealthRecords',
            'monthHealthRecords',
            'vaccinationCount',
            'totalBreedings',
            'birthCount',
            'breedingSuccessRate'
        ));
    }
}
