<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Financial Report') }}
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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Income</p>
                    <p class="text-2xl font-bold text-green-600">${{ number_format($totalIncome ?? 0, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Expenses</p>
                    <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses ?? 0, 2) }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Net Profit/Loss</p>
                    <p class="text-2xl font-bold {{ ($netProfit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($netProfit ?? 0, 2) }}
                    </p>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">This Month</p>
                    <p class="text-2xl font-bold {{ ($monthlyProfit ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        ${{ number_format($monthlyProfit ?? 0, 2) }}
                    </p>
                </div>
            </div>

            <!-- Income by Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Income by Category</h3>
                        @if(isset($incomeByCategory) && $incomeByCategory->count() > 0)
                        <div class="space-y-3">
                            @foreach($incomeByCategory as $category)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">{{ $category->category }}</span>
                                <span class="font-medium text-green-600">${{ number_format($category->total, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400">No income data available.</p>
                        @endif
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Expenses by Category</h3>
                        @if(isset($expensesByCategory) && $expensesByCategory->count() > 0)
                        <div class="space-y-3">
                            @foreach($expensesByCategory as $category)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-700 dark:text-gray-300">{{ $category->category }}</span>
                                <span class="font-medium text-red-600">${{ number_format($category->total, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 dark:text-gray-400">No expense data available.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Transactions</h3>
                    @if(isset($recentTransactions) && $recentTransactions->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentTransactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $transaction->transaction_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type == 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $transaction->category }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                        {{ $transaction->description ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }}${{ number_format($transaction->amount, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">No transactions found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
