<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold">Welcome back, {{ Auth::user()->name }}!</h3>
                    <p class="mt-2">Here's what's happening with your dairy farm today.</p>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Animals -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Animals</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalAnimals }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $femaleAnimals }} Female, {{ $maleAnimals }} Male</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Today's Production -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Today's Production</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($todayProduction, 1) }}L</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This week: {{ number_format($weekProduction, 1) }}L</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Pregnancies -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Pregnancies</p>
                                <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $activePregnancies }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $upcomingBirths->count() }} births expected</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monthly Profit -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 {{ $monthlyProfit >= 0 ? 'bg-green-500' : 'bg-red-500' }} rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Monthly Profit</p>
                                <p class="text-2xl font-semibold {{ $monthlyProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    ${{ number_format($monthlyProfit, 2) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Income: ${{ number_format($monthlyIncome, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts and Upcoming Events -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Health Alerts -->
                @if($healthAlerts->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Health Records</h3>
                        <div class="space-y-3">
                            @foreach($healthAlerts as $alert)
                            <div class="flex items-start p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $alert->animal->name }} ({{ $alert->animal->tag_number }})</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $alert->condition }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $alert->record_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('health-records.index') }}" class="mt-4 inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                            View all health records →
                        </a>
                    </div>
                </div>
                @endif

                <!-- Upcoming Births -->
                @if($upcomingBirths->count() > 0 || $overdueBirths->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Upcoming Births</h3>
                        <div class="space-y-3">
                            @foreach($overdueBirths as $birth)
                            <div class="flex items-start p-3 bg-red-50 dark:bg-red-900/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $birth->animal->name }} - OVERDUE</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Expected: {{ $birth->expected_birth_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            @endforeach
                            
                            @foreach($upcomingBirths->take(5) as $birth)
                            <div class="flex items-start p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $birth->animal->name }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Expected: {{ $birth->expected_birth_date->format('M d, Y') }} ({{ $birth->expected_birth_date->diffForHumans() }})</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('breeding.upcoming-births') }}" class="mt-4 inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                            View all upcoming births →
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Production Chart and Top Producers -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Producers -->
                @if($topProducers->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Producers This Month</h3>
                        <div class="space-y-3">
                            @foreach($topProducers as $index => $producer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $producer->animal->name }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $producer->animal->tag_number }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ number_format($producer->total_production, 1) }}L</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Total</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Transactions -->
                @if($recentTransactions->count() > 0)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Transactions</h3>
                        <div class="space-y-3">
                            @foreach($recentTransactions as $transaction)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if($transaction->type === 'income')
                                        <svg class="h-5 w-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                        </svg>
                                        @else
                                        <svg class="h-5 w-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                        </svg>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $transaction->category }}</p>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $transaction->transaction_date->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('financial.index') }}" class="mt-4 inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                            View all transactions →
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('animals.create') }}" class="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition">
                            <svg class="h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Add Animal</span>
                        </a>
                        
                        <a href="{{ route('milk-production.quick') }}" class="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition">
                            <svg class="h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Record Milk</span>
                        </a>
                        
                        <a href="{{ route('health-records.create') }}" class="flex flex-col items-center p-4 bg-red-50 dark:bg-red-900/20 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition">
                            <svg class="h-8 w-8 text-red-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Add Health Record</span>
                        </a>
                        
                        <a href="{{ route('financial.create') }}" class="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition">
                            <svg class="h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">Add Transaction</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
