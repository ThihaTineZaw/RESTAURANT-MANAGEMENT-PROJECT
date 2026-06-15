<x-mainlayout>
    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Tables</h3>
                            <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400">Manage your restaurant tables.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ isset($tables) ? $tables->total() : 0 }} tables</div>
                            <a href="{{ route('tables.create') }}" class="px-3 py-1.5 text-xs font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                Add Table
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    @if(!isset($tables) || $tables->isEmpty())
                        <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 p-8 text-center transition-colors duration-200">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M3 6h18M6 6v12M18 6v12M12 6v12"></path>
                            </svg>
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">No tables yet</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Add your first table to get started.</p>
                            <a href="{{ route('tables.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                Add First Table
                            </a>
                        </div>
                    @else
                        <div class="overflow-auto rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs transition-colors duration-200">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-left text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 transition-colors duration-200">
                                    <tr>
                                        <th class="px-4 py-2">Table</th>
                                        <th class="px-4 py-2">Status</th>
                                        <th class="px-4 py-2">Created</th>
                                        <th class="px-4 py-2 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 transition-colors duration-200">
                                    @foreach($tables as $table)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <!-- Table Icon Placeholder -->
                                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center flex-shrink-0">
                                                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18M3 6h18M6 6v12M18 6v12M12 6v12"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                             
                                                        <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $table->table_number ?? 'Table ' . $table->id }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                         
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ ($table->status ?? 'available') === 'available' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                                    {{ ucfirst($table->status ?? 'available') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                                {{ optional($table->created_at)->format('M d, Y') ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('tables.edit', $table) }}" title="Edit" class="p-1.5 text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('tables.destroy', $table) }}" onsubmit="return confirm('Are you sure you want to delete this table?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1.5 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                @if(isset($tables) && method_exists($tables, 'links'))
                    <div class="p-2">
                        {{ $tables->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-mainlayout>
