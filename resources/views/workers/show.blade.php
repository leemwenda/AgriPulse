<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Worker Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('workers.edit', $worker) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('workers.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200">
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
                            <p class="text-sm text-gray-500 dark:text-gray-400">Full Name</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $worker->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Email</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $worker->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Role</p>
                            <p class="text-lg font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $worker->user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($worker->user->role) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="text-lg font-medium">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $worker->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($worker->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Phone</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $worker->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Hire Date</p>
                            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ $worker->hire_date ? $worker->hire_date->format('M d, Y') : 'N/A' }}
                            </p>
                        </div>
                        @if($worker->address)
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Address</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $worker->address }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Account Created</p>
                            <p class="text-gray-900 dark:text-gray-100">{{ $worker->user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
