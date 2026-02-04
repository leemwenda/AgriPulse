<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\HealthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthRecordController extends Controller
{
    /**
     * Display a listing of health records
     */
    public function index(Request $request)
    {
        $query = HealthRecord::with(['animal', 'recordedBy']);

        // Filter by animal
        if ($request->filled('animal_id')) {
            $query->where('animal_id', $request->animal_id);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }

        // Filter by type
        if ($request->filled('type')) {
            if ($request->type === 'vaccination') {
                $query->vaccinations();
            } elseif ($request->type === 'treatment') {
                $query->treatments();
            }
        }

        // Search by condition
        if ($request->filled('search')) {
            $query->where('condition', 'like', '%' . $request->search . '%');
        }

        $healthRecords = $query->latest('record_date')->paginate(20);
        $animals = Animal::active()->orderBy('name')->get();

        return view('health-records.index', compact('healthRecords', 'animals'));
    }

    /**
     * Show the form for creating a new health record
     */
    public function create()
    {
        $animals = Animal::active()->orderBy('name')->get();
        return view('health-records.create', compact('animals'));
    }

    /**
     * Store a newly created health record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'record_date' => 'required|date|before_or_equal:today',
            'condition' => 'required|string|max:255',
            'treatment' => 'nullable|string',
            'doctor_name' => 'nullable|string|max:255',
            'vaccination' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['recorded_by'] = Auth::id();

        HealthRecord::create($validated);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record added successfully!');
    }

    /**
     * Display the specified health record
     */
    public function show(HealthRecord $healthRecord)
    {
        $healthRecord->load(['animal', 'recordedBy']);
        return view('health-records.show', compact('healthRecord'));
    }

    /**
     * Show the form for editing the specified health record
     */
    public function edit(HealthRecord $healthRecord)
    {
        $animals = Animal::active()->orderBy('name')->get();
        return view('health-records.edit', compact('healthRecord', 'animals'));
    }

    /**
     * Update the specified health record
     */
    public function update(Request $request, HealthRecord $healthRecord)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'record_date' => 'required|date|before_or_equal:today',
            'condition' => 'required|string|max:255',
            'treatment' => 'nullable|string',
            'doctor_name' => 'nullable|string|max:255',
            'vaccination' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $healthRecord->update($validated);

        return redirect()->route('health-records.index')
            ->with('success', 'Health record updated successfully!');
    }

    /**
     * Remove the specified health record
     */
    public function destroy(HealthRecord $healthRecord)
    {
        // Only admins can delete records (will be enforced by middleware/policy)
        $healthRecord->delete();

        return redirect()->route('health-records.index')
            ->with('success', 'Health record deleted successfully!');
    }

    /**
     * Display vaccination schedule
     */
    public function vaccinations()
    {
        $vaccinations = HealthRecord::with(['animal', 'recordedBy'])
            ->vaccinations()
            ->latest('record_date')
            ->paginate(20);

        return view('health-records.vaccinations', compact('vaccinations'));
    }
}
