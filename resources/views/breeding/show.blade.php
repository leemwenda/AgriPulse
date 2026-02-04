<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Breeding Record Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('breeding.edit', $breeding) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('breeding.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Animal</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                <a href="{{ route('animals.show', $breeding->animal) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $breeding->animal->name }} ({{ $breeding->animal->tag_number }})
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Service Date</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $breeding->service_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Bull Name/ID</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $breeding->bull_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Pregnancy Status</p>
                            <p class="text-lg font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $breeding->pregnancy_status == 'pregnant' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $breeding->pregnancy_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $breeding->pregnancy_status == 'gave_birth' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $breeding->pregnancy_status == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $breeding->pregnancy_status)) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Expected Birth Date</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $breeding->expected_birth_date ? $breeding->expected_birth_date->format('M d, Y') : 'N/A' }}
                                @if($breeding->expected_birth_date && $breeding->pregnancy_status == 'pregnant')
                                    @php
                                        $daysUntil = now()->diffInDays($breeding->expected_birth_date, false);
                                    @endphp
                                    @if($daysUntil > 0)
                                        <span class="text-sm text-gray-500">({{ $daysUntil }} days remaining)</span>
                                    @elseif($daysUntil < 0)
                                        <span class="text-sm text-red-500">({{ abs($daysUntil) }} days overdue)</span>
                                    @else
                                        <span class="text-sm text-orange-500">(Due today!)</span>
                                    @endif
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Actual Birth Date</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $breeding->actual_birth_date ? $breeding->actual_birth_date->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        @if($breeding->notes)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $breeding->notes }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recorded By</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $breeding->recordedBy->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $breeding->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
