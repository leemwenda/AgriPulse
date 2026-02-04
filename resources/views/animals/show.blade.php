<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ $animal->name }} ({{ $animal->tag_number }})
            </h2>
            <div class="space-x-2">
                <a href="{{ route('animals.edit', $animal) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('animals.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            <!-- Animal Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Animal Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tag Number</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->tag_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Name</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Breed</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->breed }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Gender</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $animal->gender == 'female' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($animal->gender) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Date of Birth</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->date_of_birth->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Age</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->age }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Color</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $animal->color ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $animal->status == 'active' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $animal->status == 'sold' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $animal->status == 'deceased' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($animal->status) }}
                                </span>
                            </p>
                        </div>
                        @if($animal->notes)
                        <div class="md:col-span-3">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $animal->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Production Statistics -->
            @if($animal->gender == 'female')
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Milk Production Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Production</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($totalProduction, 1) }} L</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
                            <p class="text-2xl font-bold text-blue-600">{{ number_format($monthProduction, 1) }} L</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Daily Average (This Month)</p>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($avgProduction ?? 0, 1) }} L</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Milk Production -->
            @if($animal->milkProductions->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Milk Production</h3>
                        <a href="{{ route('milk-production.create') }}?animal_id={{ $animal->id }}" class="text-green-600 hover:text-green-800 text-sm">+ Add Record</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Quantity (L)</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($animal->milkProductions as $production)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $production->production_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ number_format($production->quantity_liters, 1) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $production->notes ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Health Records -->
            @if($animal->healthRecords->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Health Records</h3>
                        <a href="{{ route('health-records.create') }}?animal_id={{ $animal->id }}" class="text-green-600 hover:text-green-800 text-sm">+ Add Record</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Condition</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Treatment</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Doctor</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($animal->healthRecords as $record)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $record->record_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $record->condition }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $record->treatment ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $record->doctor_name ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Breeding Records -->
            @if($animal->breedings->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Breeding Records</h3>
                        <a href="{{ route('breeding.create') }}?animal_id={{ $animal->id }}" class="text-green-600 hover:text-green-800 text-sm">+ Add Record</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Service Date</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Bull Name</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Expected Birth</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($animal->breedings as $breeding)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900 dark:text-gray-100">{{ $breeding->service_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $breeding->bull_name ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-500 dark:text-gray-400">{{ $breeding->expected_birth_date ? $breeding->expected_birth_date->format('M d, Y') : '-' }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $breeding->pregnancy_status == 'pregnant' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'gave_birth' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $breeding->pregnancy_status)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
