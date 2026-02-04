<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Worker') }}: {{ $worker->user->name }}
            </h2>
            <a href="{{ route('workers.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('workers.update', $worker) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Account Information</h3>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $worker->user->name) }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $worker->user->email) }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                New Password <span class="text-gray-400">(leave blank to keep current)</span>
                            </label>
                            <input type="password" name="password" id="password"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Confirm New Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                        </div>

                        <!-- Role -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Role <span class="text-red-500">*</span>
                            </label>
                            <select name="role" id="role" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="worker" {{ old('role', $worker->user->role) == 'worker' ? 'selected' : '' }}>Worker</option>
                                <option value="admin" {{ old('role', $worker->user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-6 border-gray-200 dark:border-gray-700">

                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Worker Details</h3>

                        <!-- Phone -->
                        <div class="mb-4">
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Phone Number
                            </label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $worker->phone) }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Address
                            </label>
                            <textarea name="address" id="address" rows="2"
                                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('address', $worker->address) }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hire Date -->
                        <div class="mb-4">
                            <label for="hire_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Hire Date
                            </label>
                            <input type="date" name="hire_date" id="hire_date" 
                                   value="{{ old('hire_date', $worker->hire_date ? $worker->hire_date->format('Y-m-d') : '') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('hire_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="active" {{ old('status', $worker->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $worker->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('workers.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Update Worker
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
