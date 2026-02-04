<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Transaction') }}
            </h2>
            <a href="{{ route('financial.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
                ← Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('financial.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        <!-- Type -->
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Transaction Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="income" {{ old('type', $transaction->type) == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ old('type', $transaction->type) == 'expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                                <optgroup label="Income Categories">
                                    <option value="Milk Sales" {{ old('category', $transaction->category) == 'Milk Sales' ? 'selected' : '' }}>Milk Sales</option>
                                    <option value="Animal Sales" {{ old('category', $transaction->category) == 'Animal Sales' ? 'selected' : '' }}>Animal Sales</option>
                                    <option value="Other Income" {{ old('category', $transaction->category) == 'Other Income' ? 'selected' : '' }}>Other Income</option>
                                </optgroup>
                                <optgroup label="Expense Categories">
                                    <option value="Feed" {{ old('category', $transaction->category) == 'Feed' ? 'selected' : '' }}>Feed</option>
                                    <option value="Veterinary" {{ old('category', $transaction->category) == 'Veterinary' ? 'selected' : '' }}>Veterinary</option>
                                    <option value="Labor" {{ old('category', $transaction->category) == 'Labor' ? 'selected' : '' }}>Labor</option>
                                    <option value="Equipment" {{ old('category', $transaction->category) == 'Equipment' ? 'selected' : '' }}>Equipment</option>
                                    <option value="Utilities" {{ old('category', $transaction->category) == 'Utilities' ? 'selected' : '' }}>Utilities</option>
                                    <option value="Maintenance" {{ old('category', $transaction->category) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="Other Expense" {{ old('category', $transaction->category) == 'Other Expense' ? 'selected' : '' }}>Other Expense</option>
                                </optgroup>
                            </select>
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Amount ($) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="amount" id="amount" value="{{ old('amount', $transaction->amount) }}" required
                                   step="0.01" min="0"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Transaction Date -->
                        <div class="mb-4">
                            <label for="transaction_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="transaction_date" id="transaction_date" 
                                   value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d')) }}" required
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('transaction_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('description', $transaction->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('financial.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Update Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
