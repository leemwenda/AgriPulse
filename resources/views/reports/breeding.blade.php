<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Breeding Report') }}
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Breedings</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalBreedings ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Currently Pregnant</p>
                    <p class="text-2xl font-bold text-green-600">{{ $pregnantCount ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Successful Births</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $birthCount ?? 0 }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Success Rate</p>
                    <p class="text-2xl font-bold text-orange-600">{{ number_format($successRate ?? 0, 1) }}%</p>
                </div>
            </div>

            <!-- Upcoming Births -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Upcoming Births</h3>
                    @if(isset($upcomingBirths) && $upcomingBirths->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Animal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expected Birth</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Days Remaining</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bull</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($upcomingBirths as $breeding)
                                @php
                                    $daysRemaining = now()->diffInDays($breeding->expected_birth_date, false);
                                @endphp
                                <tr class="{{ $daysRemaining < 0 ? 'bg-red-50 dark:bg-red-900/20' : ($daysRemaining <= 7 ? 'bg-yellow-50 dark:bg-yellow-900/20' : '') }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('animals.show', $breeding->animal) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $breeding->animal->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $breeding->service_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $breeding->expected_birth_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        @if($daysRemaining < 0)
                                            <span class="text-red-600">{{ abs($daysRemaining) }} days overdue</span>
                                        @elseif($daysRemaining == 0)
                                            <span class="text-orange-600">Due today!</span>
                                        @else
                                            <span class="text-green-600">{{ $daysRemaining }} days</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $breeding->bull_name ?? '-' }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">No upcoming births scheduled.</p>
                    @endif
                </div>
            </div>

            <!-- Breeding Status Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Breeding Status Summary</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $pendingCount ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pending</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-green-600">{{ $pregnantCount ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Pregnant</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-blue-600">{{ $birthCount ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Gave Birth</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-4 rounded-lg text-center">
                            <p class="text-2xl font-bold text-red-600">{{ $failedCount ?? 0 }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Failed</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
