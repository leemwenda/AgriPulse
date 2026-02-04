<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilkProductionController extends Controller
{
    /**
     * Display a listing of milk production records
     */
    public function index(Request $request)
    {
        $query = MilkProduction::with(['animal', 'recordedBy']);

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        } elseif ($request->filled('period')) {
            switch ($request->period) {
                case 'today':
                    $query->today();
                    break;
                case 'week':
                    $query->thisWeek();
                    break;
                case 'month':
                    $query->thisMonth();
                    break;
            }
        } else {
            $query->thisMonth(); // Default to current month
        }

        // Filter by animal
        if ($request->filled('animal_id')) {
            $query->where('animal_id', $request->animal_id);
        }

        $productions = $query->latest('production_date')->paginate(20);
        
        // Get statistics
        $totalProduction = $query->sum('quantity_liters');
        $avgProduction = $query->avg('quantity_liters');
        $recordCount = $query->count();

        // Get all active female animals for the filter
        $animals = Animal::active()->female()->orderBy('name')->get();

        return view('milk-production.index', compact(
            'productions',
            'totalProduction',
            'avgProduction',
            'recordCount',
            'animals'
        ));
    }

    /**
     * Show the form for creating a new milk production record
     */
    public function create()
    {
        $animals = Animal::active()->female()->orderBy('name')->get();
        return view('milk-production.create', compact('animals'));
    }

    /**
     * Store a newly created milk production record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'production_date' => 'required|date|before_or_equal:today',
            'quantity_liters' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $validated['recorded_by'] = Auth::id();

        MilkProduction::create($validated);

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production recorded successfully!');
    }

    /**
     * Display the specified milk production record
     */
    public function show(MilkProduction $milkProduction)
    {
        $milkProduction->load(['animal', 'recordedBy']);
        return view('milk-production.show', compact('milkProduction'));
    }

    /**
     * Show the form for editing the specified milk production record
     */
    public function edit(MilkProduction $milkProduction)
    {
        $animals = Animal::active()->female()->orderBy('name')->get();
        return view('milk-production.edit', compact('milkProduction', 'animals'));
    }

    /**
     * Update the specified milk production record
     */
    public function update(Request $request, MilkProduction $milkProduction)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'production_date' => 'required|date|before_or_equal:today',
            'quantity_liters' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $milkProduction->update($validated);

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production updated successfully!');
    }

    /**
     * Remove the specified milk production record
     */
    public function destroy(MilkProduction $milkProduction)
    {
        // Only admins can delete records (will be enforced by middleware/policy)
        $milkProduction->delete();

        return redirect()->route('milk-production.index')
            ->with('success', 'Milk production record deleted successfully!');
    }

    /**
     * Quick record form for daily entry
     */
    public function quickRecord()
    {
        $animals = Animal::active()->female()->orderBy('name')->get();
        $today = today()->format('Y-m-d');
        
        // Get today's existing records
        $todayRecords = MilkProduction::with('animal')
            ->today()
            ->get()
            ->keyBy('animal_id');

        return view('milk-production.quick-record', compact('animals', 'today', 'todayRecords'));
    }

    /**
     * Store multiple quick records
     */
    public function storeQuickRecords(Request $request)
    {
        $validated = $request->validate([
            'production_date' => 'required|date|before_or_equal:today',
            'records' => 'required|array',
            'records.*.animal_id' => 'required|exists:animals,id',
            'records.*.quantity_liters' => 'required|numeric|min:0|max:100',
        ]);

        foreach ($validated['records'] as $record) {
            if ($record['quantity_liters'] > 0) {
                MilkProduction::create([
                    'animal_id' => $record['animal_id'],
                    'production_date' => $validated['production_date'],
                    'quantity_liters' => $record['quantity_liters'],
                    'recorded_by' => Auth::id(),
                ]);
            }
        }

        return redirect()->route('milk-production.index')
            ->with('success', 'Daily milk production recorded successfully!');
    }
}
