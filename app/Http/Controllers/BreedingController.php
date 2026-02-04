<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Breeding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BreedingController extends Controller
{
    /**
     * Display a listing of breeding records
     */
    public function index(Request $request)
    {
        $query = Breeding::with(['animal', 'recordedBy']);

        // Filter by animal
        if ($request->filled('animal_id')) {
            $query->where('animal_id', $request->animal_id);
        }

        // Filter by pregnancy status
        if ($request->filled('status')) {
            $query->where('pregnancy_status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('service_date', [$request->start_date, $request->end_date]);
        }

        $breedings = $query->latest('service_date')->paginate(20);
        $animals = Animal::active()->female()->orderBy('name')->get();

        // Statistics
        $activePregnancies = Breeding::active()->count();
        $upcomingBirths = Breeding::upcomingBirths(30)->count();
        $successRate = $this->calculateSuccessRate();

        return view('breeding.index', compact(
            'breedings',
            'animals',
            'activePregnancies',
            'upcomingBirths',
            'successRate'
        ));
    }

    /**
     * Show the form for creating a new breeding record
     */
    public function create()
    {
        $animals = Animal::active()->female()->orderBy('name')->get();
        return view('breeding.create', compact('animals'));
    }

    /**
     * Store a newly created breeding record
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'service_date' => 'required|date|before_or_equal:today',
            'bull_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Calculate expected birth date (approximately 283 days for cattle)
        $validated['expected_birth_date'] = Carbon::parse($validated['service_date'])
            ->addDays(283)
            ->format('Y-m-d');
        
        $validated['pregnancy_status'] = 'pending';
        $validated['recorded_by'] = Auth::id();

        Breeding::create($validated);

        return redirect()->route('breeding.index')
            ->with('success', 'Breeding record added successfully!');
    }

    /**
     * Display the specified breeding record
     */
    public function show(Breeding $breeding)
    {
        $breeding->load(['animal', 'recordedBy']);
        return view('breeding.show', compact('breeding'));
    }

    /**
     * Show the form for editing the specified breeding record
     */
    public function edit(Breeding $breeding)
    {
        $animals = Animal::active()->female()->orderBy('name')->get();
        return view('breeding.edit', compact('breeding', 'animals'));
    }

    /**
     * Update the specified breeding record
     */
    public function update(Request $request, Breeding $breeding)
    {
        $validated = $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'service_date' => 'required|date|before_or_equal:today',
            'expected_birth_date' => 'nullable|date|after:service_date',
            'actual_birth_date' => 'nullable|date|after:service_date',
            'bull_name' => 'nullable|string|max:255',
            'pregnancy_status' => 'required|in:pending,pregnant,gave_birth,failed',
            'notes' => 'nullable|string',
        ]);

        $breeding->update($validated);

        return redirect()->route('breeding.index')
            ->with('success', 'Breeding record updated successfully!');
    }

    /**
     * Remove the specified breeding record
     */
    public function destroy(Breeding $breeding)
    {
        // Only admins can delete records (will be enforced by middleware/policy)
        $breeding->delete();

        return redirect()->route('breeding.index')
            ->with('success', 'Breeding record deleted successfully!');
    }

    /**
     * Update pregnancy status
     */
    public function updateStatus(Request $request, Breeding $breeding)
    {
        $validated = $request->validate([
            'pregnancy_status' => 'required|in:pending,pregnant,gave_birth,failed',
            'actual_birth_date' => 'nullable|date|after:service_date',
        ]);

        $breeding->update($validated);

        return redirect()->back()
            ->with('success', 'Pregnancy status updated successfully!');
    }

    /**
     * Display upcoming births
     */
    public function upcomingBirths()
    {
        $upcomingBirths = Breeding::with(['animal', 'recordedBy'])
            ->upcomingBirths(60)
            ->orderBy('expected_birth_date')
            ->get();

        $overdueBirths = Breeding::with(['animal', 'recordedBy'])
            ->pregnant()
            ->whereNotNull('expected_birth_date')
            ->where('expected_birth_date', '<', now())
            ->orderBy('expected_birth_date')
            ->get();

        return view('breeding.upcoming-births', compact('upcomingBirths', 'overdueBirths'));
    }

    /**
     * Calculate breeding success rate
     */
    private function calculateSuccessRate()
    {
        $total = Breeding::whereIn('pregnancy_status', ['gave_birth', 'failed'])->count();
        
        if ($total === 0) {
            return 0;
        }

        $successful = Breeding::gaveBirth()->count();
        
        return round(($successful / $total) * 100, 1);
    }
}
