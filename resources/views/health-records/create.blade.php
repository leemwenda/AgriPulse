<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add Health Record') }}
            </h2>
            <a href="{{ route('health-records.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('health-records.store') }}">
                        @csrf

                        <!-- Animal -->
                        <div class="mb-4">
                            <label for="animal_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Animal <span class="text-red-500">*</span>
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

                        <!-- Record Date -->
                        <div class="mb-4">
                            <label for="record_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="record_date" id="record_date" 
                                   value="{{ old('record_date', date('Y-m-d')) }}" required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('record_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Condition -->
                        <div class="mb-4">
                            <label for="condition" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Condition/Diagnosis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="condition" id="condition" value="{{ old('condition') }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Mastitis, Fever, Routine Checkup">
                            @error('condition')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Treatment -->
                        <div class="mb-4">
                            <label for="treatment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Treatment
                            </label>
                            <textarea name="treatment" id="treatment" rows="2"
                                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                      placeholder="Describe the treatment given...">{{ old('treatment') }}</textarea>
                            @error('treatment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Doctor Name -->
                        <div class="mb-4">
                            <label for="doctor_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Doctor/Vet Name
                            </label>
                            <input type="text" name="doctor_name" id="doctor_name" value="{{ old('doctor_name') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Dr. Smith">
                            @error('doctor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vaccination -->
                        <div class="mb-4">
                            <label for="vaccination" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Vaccination (if applicable)
                            </label>
                            <input type="text" name="vaccination" id="vaccination" value="{{ old('vaccination') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., FMD Vaccine, Brucellosis">
                            @error('vaccination')
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
                                      placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('health-records.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
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
</x-app-layout>
