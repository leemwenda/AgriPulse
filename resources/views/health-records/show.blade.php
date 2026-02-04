<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Health Record Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('health-records.edit', $healthRecord) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('health-records.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
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
                                <a href="{{ route('animals.show', $healthRecord->animal) }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $healthRecord->animal->name }} ({{ $healthRecord->animal->tag_number }})
                                </a>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Record Date</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $healthRecord->record_date->format('M d, Y') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Condition/Diagnosis</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $healthRecord->condition }}</p>
                        </div>
                        @if($healthRecord->treatment)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Treatment</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $healthRecord->treatment }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Doctor/Vet Name</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $healthRecord->doctor_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Vaccination</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                @if($healthRecord->vaccination)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $healthRecord->vaccination }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                        @if($healthRecord->notes)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $healthRecord->notes }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Recorded By</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $healthRecord->recordedBy->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Created At</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $healthRecord->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
