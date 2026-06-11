<x-mainlayout>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto space-y-6">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
                <div class="px-6 py-5 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Category List</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Showing all categories.</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ $categories->count() }} total</div>
                            <a href="{{ route('categories.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors duration-200">
                                Add Category
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if($categories->isEmpty())
                        <div class="rounded-2xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 p-8 text-center text-sm text-gray-600 dark:text-gray-400 transition-colors duration-200">
                            No categories yet. <a href="{{ route('categories.create') }}" class="text-primary-600 dark:text-primary-400 hover:underline">Add your first category</a> to get started.
                        </div>
                    @else
                        <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm transition-colors duration-200">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-left text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 transition-colors duration-200">
                                    <tr>
                                        <th class="px-6 py-3">Name</th>
                                        <th class="px-6 py-3">Created</th>
                                        <th class="px-6 py-3 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 transition-colors duration-200">
                                    @foreach($categories as $category)
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $category->name ?? 'Unnamed' }}</td>
                                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ ($category->created_at)->format('M d, Y') ?? '-' }}</td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <a href="{{ route('categories.edit', $category) }}" class="p-2 text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                    <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            </div>
        </div>
    </div>
</x-mainlayout>
