<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Milk Production Report') }}
            </h2>
            <a href="{{ route('reports.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back to Reports
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Today's Production</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($todayProduction ?? 0, 1) }} L</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This Week</p>
                    <p class="text-2xl font-bold text-blue-600">{{ number_format($weekProduction ?? 0, 1) }} L</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format($monthProduction ?? 0, 1) }} L</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Daily Average</p>
                    <p class="text-2xl font-bold text-orange-600">{{ number_format($avgDailyProduction ?? 0, 1) }} L</p>
                </div>
            </div>

            <!-- Top Producers -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Top Producing Animals (This Month)</h3>
                    @if(isset($topProducers) && $topProducers->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rank</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Animal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Production</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Records</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Daily Avg</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($topProducers as $index => $producer)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                        #{{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('animals.show', $producer->animal) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $producer->animal->name }} ({{ $producer->animal->tag_number }})
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                        {{ number_format($producer->total_production, 1) }} L
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $producer->record_count }} days
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($producer->total_production / max($producer->record_count, 1), 1) }} L
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">No production data available for this month.</p>
                    @endif
                </div>
            </div>

            <!-- Recent Production Records -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Production Records</h3>
                    @if(isset($recentProductions) && $recentProductions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Animal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Recorded By</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentProductions as $production)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $production->production_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $production->animal->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                        {{ number_format($production->quantity_liters, 1) }} L
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $production->recordedBy->name ?? 'N/A' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">No recent production records.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
