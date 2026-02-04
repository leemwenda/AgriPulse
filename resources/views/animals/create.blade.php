<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add New Animal') }}
            </h2>
            <a href="{{ route('animals.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back to Animals
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('animals.store') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tag Number -->
                        <div class="mb-4">
                            <label for="tag_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Tag Number <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="tag_number" id="tag_number" value="{{ old('tag_number') }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., COW-001">
                            @error('tag_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Breed -->
                        <div class="mb-4">
                            <label for="breed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Breed <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="breed" id="breed" value="{{ old('breed') }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Holstein, Jersey, Guernsey">
                            @error('breed')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="mb-4">
                            <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Gender <span class="text-red-500">*</span>
                            </label>
                            <select name="gender" id="gender" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Select Gender</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div class="mb-4">
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date of Birth <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}" required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('date_of_birth')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Color -->
                        <div class="mb-4">
                            <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Color
                            </label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500"
                                   placeholder="e.g., Black and White, Brown">
                            @error('color')
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
                                      placeholder="Any additional notes about this animal...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('animals.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Add Animal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
