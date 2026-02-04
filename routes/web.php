<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\MilkProductionController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\BreedingController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Animals Management
    Route::resource('animals', AnimalController::class);

    // Milk Production
    Route::resource('milk-production', MilkProductionController::class);
    Route::get('/milk-production-quick', [MilkProductionController::class, 'quickRecord'])->name('milk-production.quick');
    Route::post('/milk-production-quick', [MilkProductionController::class, 'storeQuickRecords'])->name('milk-production.quick.store');

    // Health Records
    Route::resource('health-records', HealthRecordController::class);
    Route::get('/vaccinations', [HealthRecordController::class, 'vaccinations'])->name('health-records.vaccinations');

    // Breeding Management
    Route::resource('breeding', BreedingController::class);
    Route::post('/breeding/{breeding}/update-status', [BreedingController::class, 'updateStatus'])->name('breeding.update-status');
    Route::get('/upcoming-births', [BreedingController::class, 'upcomingBirths'])->name('breeding.upcoming-births');

    // Financial Management
    Route::resource('financial', FinancialController::class);
    Route::get('/financial-summary', [FinancialController::class, 'summary'])->name('financial.summary');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/milk-production', [ReportController::class, 'milkProduction'])->name('reports.milk-production');
    Route::get('/reports/animal-health', [ReportController::class, 'animalHealth'])->name('reports.animal-health');
    Route::get('/reports/breeding', [ReportController::class, 'breeding'])->name('reports.breeding');
    Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('/reports/comprehensive', [ReportController::class, 'comprehensive'])->name('reports.comprehensive');

    // Worker Management (Admin only - will add middleware later)
    Route::resource('workers', WorkerController::class);
    Route::post('/workers/{worker}/update-status', [WorkerController::class, 'updateStatus'])->name('workers.update-status');
    Route::post('/workers/{worker}/reset-password', [WorkerController::class, 'resetPassword'])->name('workers.reset-password');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
