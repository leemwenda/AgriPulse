<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Breeding Records') }}
            </h2>
            <a href="{{ route('breeding.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                + Add Record
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            <!-- Filters -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('breeding.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Animal</label>
                            <select name="animal_id" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                <option value="">All Animals</option>
                                @foreach($animals ?? [] as $animal)
                                    <option value="{{ $animal->id }}" {{ request('animal_id') == $animal->id ? 'selected' : '' }}>
                                        {{ $animal->name }} ({{ $animal->tag_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="pregnant" {{ request('status') == 'pregnant' ? 'selected' : '' }}>Pregnant</option>
                                <option value="gave_birth" {{ request('status') == 'gave_birth' ? 'selected' : '' }}>Gave Birth</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                            <input type="date" name="from_date" value="{{ request('from_date') }}"
                                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Breeding Records Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($breedings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Animal</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Service Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Bull Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Expected Birth</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actual Birth</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($breedings as $breeding)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <a href="{{ route('animals.show', $breeding->animal) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $breeding->animal->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{ $breeding->service_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $breeding->bull_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $breeding->expected_birth_date ? $breeding->expected_birth_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $breeding->pregnancy_status == 'pregnant' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'gave_birth' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $breeding->pregnancy_status == 'failed' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $breeding->pregnancy_status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $breeding->actual_birth_date ? $breeding->actual_birth_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('breeding.show', $breeding) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('breeding.edit', $breeding) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                        @if(Auth::user()->isAdmin())
                                        <form action="{{ route('breeding.destroy', $breeding) }}" method="POST" class="inline" onsubmit="return confirm('Delete this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $breedings->links() }}
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No breeding records</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start tracking breeding activities.</p>
                        <div class="mt-6">
                            <a href="{{ route('breeding.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                + Add Record
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
