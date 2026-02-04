<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    /**
     * Display a listing of animals
     */
    public function index(Request $request)
    {
        $query = Animal::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('tag_number', 'like', "%{$search}%")
                  ->orWhere('breed', 'like', "%{$search}%");
            });
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active'); // Default to active animals
        }

        // Filter by breed
        if ($request->filled('breed')) {
            $query->where('breed', $request->breed);
        }

        $animals = $query->latest()->paginate(15);
        $breeds = Animal::distinct()->pluck('breed');

        return view('animals.index', compact('animals', 'breeds'));
    }

    /**
     * Show the form for creating a new animal
     */
    public function create()
    {
        return view('animals.create');
    }

    /**
     * Store a newly created animal
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tag_number' => 'required|string|unique:animals,tag_number|max:255',
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'color' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Animal::create($validated);

        return redirect()->route('animals.index')
            ->with('success', 'Animal added successfully!');
    }

    /**
     * Display the specified animal
     */
    public function show(Animal $animal)
    {
        $animal->load([
            'milkProductions' => function($query) {
                $query->latest()->take(10);
            },
            'healthRecords' => function($query) {
                $query->latest()->take(10);
            },
            'breedings' => function($query) {
                $query->latest()->take(10);
            }
        ]);

        // Calculate total milk production
        $totalProduction = $animal->milkProductions()->sum('quantity_liters');
        $monthProduction = $animal->milkProductions()->thisMonth()->sum('quantity_liters');
        $avgProduction = $animal->milkProductions()->thisMonth()->avg('quantity_liters');

        return view('animals.show', compact('animal', 'totalProduction', 'monthProduction', 'avgProduction'));
    }

    /**
     * Show the form for editing the specified animal
     */
    public function edit(Animal $animal)
    {
        return view('animals.edit', compact('animal'));
    }

    /**
     * Update the specified animal
     */
    public function update(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'tag_number' => 'required|string|max:255|unique:animals,tag_number,' . $animal->id,
            'breed' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before_or_equal:today',
            'color' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,sold,deceased',
        ]);

        $animal->update($validated);

        return redirect()->route('animals.show', $animal)
            ->with('success', 'Animal updated successfully!');
    }

    /**
     * Remove the specified animal
     */
    public function destroy(Animal $animal)
    {
        // Only admins can delete animals (will be enforced by middleware/policy)
        $animal->delete();

        return redirect()->route('animals.index')
            ->with('success', 'Animal deleted successfully!');
    }
}
