<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\MilkProduction;
use App\Models\HealthRecord;
use App\Models\Breeding;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        // Total animals count
        $totalAnimals = Animal::active()->count();
        $femaleAnimals = Animal::active()->female()->count();
        $maleAnimals = Animal::active()->male()->count();

        // Milk production statistics
        $todayProduction = MilkProduction::today()->sum('quantity_liters');
        $weekProduction = MilkProduction::thisWeek()->sum('quantity_liters');
        $monthProduction = MilkProduction::thisMonth()->sum('quantity_liters');

        // Average daily production - SQLite compatible
        $avgDailyProduction = 0;
        $monthlyProduction = MilkProduction::thisMonth()->sum('quantity_liters');
        $daysInMonth = now()->daysInMonth;
        if ($monthlyProduction > 0) {
            $avgDailyProduction = $monthlyProduction / $daysInMonth;
        }

        // Health alerts (recent health issues in last 7 days)
        $healthAlerts = HealthRecord::with('animal')
            ->where('record_date', '>=', now()->subDays(7))
            ->latest()
            ->take(5)
            ->get();

        // Upcoming births (next 30 days)
        $upcomingBirths = Breeding::with('animal')
            ->upcomingBirths(30)
            ->orderBy('expected_birth_date')
            ->get();

        // Overdue births
        $overdueBirths = Breeding::with('animal')
            ->pregnant()
            ->whereNotNull('expected_birth_date')
            ->where('expected_birth_date', '<', now())
            ->get();

        // Active pregnancies
        $activePregnancies = Breeding::active()->count();

        // Financial summary for current month
        $monthlyIncome = FinancialTransaction::income()->thisMonth()->sum('amount');
        $monthlyExpenses = FinancialTransaction::expense()->thisMonth()->sum('amount');
        $monthlyProfit = $monthlyIncome - $monthlyExpenses;

        // Recent transactions
        $recentTransactions = FinancialTransaction::with('recordedBy')
            ->latest()
            ->take(5)
            ->get();

        // Top producing animals this month
        $topProducers = MilkProduction::select('animal_id', DB::raw('SUM(quantity_liters) as total_production'))
            ->thisMonth()
            ->groupBy('animal_id')
            ->orderByDesc('total_production')
            ->with('animal')
            ->take(5)
            ->get();

        // Production trend for last 7 days
        $productionTrend = MilkProduction::select(
                DB::raw('DATE(production_date) as date'),
                DB::raw('SUM(quantity_liters) as total')
            )
            ->where('production_date', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'totalAnimals',
            'femaleAnimals',
            'maleAnimals',
            'todayProduction',
            'weekProduction',
            'monthProduction',
            'avgDailyProduction',
            'healthAlerts',
            'upcomingBirths',
            'overdueBirths',
            'activePregnancies',
            'monthlyIncome',
            'monthlyExpenses',
            'monthlyProfit',
            'recentTransactions',
            'topProducers',
            'productionTrend'
        ));
    }
}
