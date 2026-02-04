<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WorkerController extends Controller
{
    /**
     * Display a listing of workers
     */
    public function index(Request $request)
    {
        $query = Worker::with('user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->active(); // Default to active workers
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $workers = $query->latest()->paginate(15);

        return view('workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new worker
     */
    public function create()
    {
        return view('workers.create');
    }

    /**
     * Store a newly created worker
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'hire_date' => 'required|date|before_or_equal:today',
        ]);

        // Create user account
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'worker',
        ]);

        // Create worker profile
        Worker::create([
            'user_id' => $user->id,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'hire_date' => $validated['hire_date'],
            'status' => 'active',
        ]);

        return redirect()->route('workers.index')
            ->with('success', 'Worker added successfully!');
    }

    /**
     * Display the specified worker
     */
    public function show(Worker $worker)
    {
        $worker->load([
            'user.milkProductions' => function($query) {
                $query->latest()->take(10);
            },
            'user.healthRecords' => function($query) {
                $query->latest()->take(10);
            },
            'user.breedings' => function($query) {
                $query->latest()->take(10);
            },
            'user.financialTransactions' => function($query) {
                $query->latest()->take(10);
            }
        ]);

        // Statistics
        $totalRecords = $worker->user->milkProductions->count() +
                       $worker->user->healthRecords->count() +
                       $worker->user->breedings->count() +
                       $worker->user->financialTransactions->count();

        return view('workers.show', compact('worker', 'totalRecords'));
    }

    /**
     * Show the form for editing the specified worker
     */
    public function edit(Worker $worker)
    {
        $worker->load('user');
        return view('workers.edit', compact('worker'));
    }

    /**
     * Update the specified worker
     */
    public function update(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $worker->user_id,
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'hire_date' => 'required|date|before_or_equal:today',
            'status' => 'required|in:active,inactive',
        ]);

        // Update user
        $worker->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update worker profile
        $worker->update([
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'hire_date' => $validated['hire_date'],
            'status' => $validated['status'],
        ]);

        return redirect()->route('workers.show', $worker)
            ->with('success', 'Worker updated successfully!');
    }

    /**
     * Remove the specified worker
     */
    public function destroy(Worker $worker)
    {
        // Delete user account (will cascade delete worker profile)
        $worker->user->delete();

        return redirect()->route('workers.index')
            ->with('success', 'Worker deleted successfully!');
    }

    /**
     * Update worker status
     */
    public function updateStatus(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $worker->update($validated);

        return redirect()->back()
            ->with('success', 'Worker status updated successfully!');
    }

    /**
     * Reset worker password
     */
    public function resetPassword(Request $request, Worker $worker)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $worker->user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()
            ->with('success', 'Password reset successfully!');
    }
}
