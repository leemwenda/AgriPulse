<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Breeding Record') }}
            </h2>
            <a href="{{ route('breeding.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('breeding.store') }}">
                        @csrf

                        <!-- Animal -->
                        <div class="mb-4">
                            <label for="animal_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Animal (Female) <span class="text-red-500">*</span>
                            </label>
                            <select name="animal_id" id="animal_id" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Select Animal</option>
                                @foreach($animals as $animal)
                                    <option value="{{ $animal->id }}" {{ old('animal_id', request('animal_id')) == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->name }} ({{ $animal->tag_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('animal_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Date -->
                        <div class="mb-4">
                            <label for="service_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Service Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="service_date" id="service_date" 
                                   value="{{ old('service_date', date('Y-m-d')) }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('service_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bull Name -->
                        <div class="mb-4">
                            <label for="bull_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Bull Name/ID
                            </label>
                            <input type="text" name="bull_name" id="bull_name" value="{{ old('bull_name') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Bull-001 or AI Straw ID">
                            @error('bull_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expected Birth Date -->
                        <div class="mb-4">
                            <label for="expected_birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Expected Birth Date
                            </label>
                            <input type="date" name="expected_birth_date" id="expected_birth_date" 
                                   value="{{ old('expected_birth_date') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Typically 280-285 days from service date for cattle</p>
                            @error('expected_birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pregnancy Status -->
                        <div class="mb-4">
                            <label for="pregnancy_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Pregnancy Status <span class="text-red-500">*</span>
                            </label>
                            <select name="pregnancy_status" id="pregnancy_status" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="pending" {{ old('pregnancy_status') == 'pending' ? 'selected' : '' }}>Pending (Awaiting Confirmation)</option>
                                <option value="pregnant" {{ old('pregnancy_status') == 'pregnant' ? 'selected' : '' }}>Pregnant (Confirmed)</option>
                                <option value="gave_birth" {{ old('pregnancy_status') == 'gave_birth' ? 'selected' : '' }}>Gave Birth</option>
                                <option value="failed" {{ old('pregnancy_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('pregnancy_status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                      placeholder="Any additional notes about this breeding...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('breeding.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Save Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-calculate expected birth date (280 days for cattle)
        document.getElementById('service_date').addEventListener('change', function() {
            const serviceDate = new Date(this.value);
            if (serviceDate) {
                serviceDate.setDate(serviceDate.getDate() + 280);
                document.getElementById('expected_birth_date').value = serviceDate.toISOString().split('T')[0];
            }
        });
    </script>
</x-app-layout>
