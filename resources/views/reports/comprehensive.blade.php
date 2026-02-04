<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Comprehensive Farm Report') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Farm Overview -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Farm Overview</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $totalAnimals ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Animals</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $activeAnimals ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Active Animals</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ $totalWorkers ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Workers</p>
                        </div>
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-orange-600">{{ $pregnantAnimals ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pregnant</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Production Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Milk Production Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Today</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($todayProduction ?? 0, 1) }} L</p>
                        </div>
                        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">This Week</p>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($weekProduction ?? 0, 1) }} L</p>
                        </div>
                        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($monthProduction ?? 0, 1) }} L</p>
                        </div>
                        <div class="border border-gray-200 dark:border-gray-700 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total (All Time)</p>
                            <p class="text-2xl font-bold text-gray-600">{{ number_format($totalProduction ?? 0, 1) }} L</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Financial Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Income</p>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($totalIncome ?? 0, 2) }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</p>
                            <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses ?? 0, 2) }}</p>
                        </div>
                        <div class="{{ ($netProfit ?? 0) >= 0 ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }} p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Net Profit/Loss</p>
                            <p class="text-2xl font-bold {{ ($netProfit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                ${{ number_format($netProfit ?? 0, 2) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health & Breeding Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Health Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Total Health Records</span>
                                <span class="font-medium text-blue-600">{{ $totalHealthRecords ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">This Month</span>
                                <span class="font-medium text-green-600">{{ $monthHealthRecords ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Vaccinations</span>
                                <span class="font-medium text-purple-600">{{ $vaccinationCount ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Breeding Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Total Breedings</span>
                                <span class="font-medium text-blue-600">{{ $totalBreedings ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Currently Pregnant</span>
                                <span class="font-medium text-green-600">{{ $pregnantAnimals ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Successful Births</span>
                                <span class="font-medium text-purple-600">{{ $birthCount ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">Success Rate</span>
                                <span class="font-medium text-orange-600">{{ number_format($breedingSuccessRate ?? 0, 1) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Detailed Reports</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('reports.milk-production') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">Milk Production</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">View detailed report →</p>
                        </a>
                        <a href="{{ route('reports.animal-health') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">Animal Health</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">View detailed report →</p>
                        </a>
                        <a href="{{ route('reports.breeding') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">Breeding</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">View detailed report →</p>
                        </a>
                        <a href="{{ route('reports.financial') }}" class="block p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">Financial</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">View detailed report →</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
