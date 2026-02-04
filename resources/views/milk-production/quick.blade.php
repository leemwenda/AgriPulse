<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Quick Milk Recording') }}
            </h2>
            <a href="{{ route('milk-production.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Quickly record milk production for multiple animals at once. Enter the quantity for each animal that produced milk today.
                    </p>

                    <form method="POST" action="{{ route('milk-production.quick.store') }}">
                        @csrf

                        <!-- Date -->
                        <div class="mb-6">
                            <label for="production_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Production Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="production_date" id="production_date" 
                                   value="{{ old('production_date', date('Y-m-d')) }}" required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-64 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <!-- Animals List -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Animal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tag #</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Breed</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity (L)</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($animals as $animal)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $animal->name }}
                                            <input type="hidden" name="records[{{ $loop->index }}][animal_id]" value="{{ $animal->id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $animal->tag_number }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $animal->breed }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" name="records[{{ $loop->index }}][quantity_liters]" 
                                                   step="0.1" min="0" max="100"
                                                   class="w-24 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="0.0">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="text" name="records[{{ $loop->index }}][notes]" 
                                                   class="w-40 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="Optional notes">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No female animals found. <a href="{{ route('animals.create') }}" class="text-blue-600 hover:text-blue-800">Add animals first</a>.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($animals->count() > 0)
                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('milk-production.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Save All Records
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
