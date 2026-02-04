<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Types -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Milk Production Report -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-full">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Milk Production</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">View milk production trends, daily/weekly/monthly summaries, and top producing animals.</p>
                        <a href="{{ route('reports.milk-production') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                            View Report →
                        </a>
                    </div>
                </div>

                <!-- Animal Health Report -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-red-100 dark:bg-red-900 rounded-full">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Animal Health</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Track health conditions, treatments, vaccinations, and identify animals needing attention.</p>
                        <a href="{{ route('reports.animal-health') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                            View Report →
                        </a>
                    </div>
                </div>

                <!-- Breeding Report -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-pink-100 dark:bg-pink-900 rounded-full">
                                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Breeding</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Monitor breeding success rates, pregnancy status, and upcoming births.</p>
                        <a href="{{ route('reports.breeding') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                            View Report →
                        </a>
                    </div>
                </div>

                <!-- Financial Report -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-full">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Financial Summary</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">View income, expenses, profit/loss analysis, and financial trends.</p>
                        <a href="{{ route('reports.financial') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                            View Report →
                        </a>
                    </div>
                </div>

                <!-- Comprehensive Report -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-full">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Comprehensive Report</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Complete farm overview with all key metrics and statistics in one place.</p>
                        <a href="{{ route('reports.comprehensive') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
                            View Report →
                        </a>
                    </div>
                </div>

                <!-- Export Data -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-full">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900 dark:text-gray-100">Export Data</h3>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Export your farm data to PDF or CSV format for external use.</p>
                        <span class="inline-flex items-center text-gray-400">
                            Coming Soon
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
