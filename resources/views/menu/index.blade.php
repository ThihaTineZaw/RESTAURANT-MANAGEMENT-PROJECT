<x-mainlayout>
    <div class="py-4 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white">Menu Items</h3>
                            <p class="mt-0.5 text-xs text-gray-600 dark:text-gray-400">Manage your restaurant menu.</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ isset($menus) ? $menus->count() : 0 }} items</div>
                            <a href="{{ route('menu.create') }}" class="px-3 py-1.5 text-xs font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                Add Menu Item
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    @if(!isset($menus) || $menus->isEmpty())
                        <div class="rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 p-8 text-center transition-colors duration-200">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white mb-2">No menu items yet</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-4">Add your first menu item to get started.</p>
                            <a href="{{ route('menu.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 transition-colors duration-200">
                                Add First Item
                            </a>
                        </div>
                    @else
                        <div class="overflow-auto rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs transition-colors duration-200">
                                <thead class="bg-gray-50 dark:bg-gray-900 text-left text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 transition-colors duration-200">
                                    <tr>
                                        <th class="px-4 py-2">Item</th>
                                        <th class="px-4 py-2">Categories</th>
                                        <th class="px-4 py-2">Price</th>
                                        <th class="px-4 py-2">Created</th>
                                        <th class="px-4 py-2 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 transition-colors duration-200">
                                    @foreach($menus as $menu)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                            <td class="px-4 py-3">
                                                <div class="flex items-center gap-3">
                                                    <!-- Image Placeholder -->
                                                    <div class="w-12 h-12 rounded-lg bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900 dark:to-primary-800 flex items-center justify-center flex-shrink-0">
                                                        <img src="{{ asset('storage/menus/' . $menu->image) }}" alt="{{ $menu->name ?? 'Menu Item' }}" class="w-10 h-10 p-0.5 rounded-lg object-cover">
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $menu->name ?? 'Menu Item' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                                                    {{ $menu->category->name ?? 'Uncategorized' }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                                ${{ number_format($menu->price ?? 0, 2) }}
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                                {{ optional($menu->created_at)->format('M d, Y') ?? '-' }}
                                            </td>
                                            <td class="px-4 py-3 text-right">
                                                <div class="flex items-center justify-end gap-1">
                                                    <a href="{{ route('menu.edit', $menu) }}" title="Edit" class="p-1.5 text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                    </a>
                                                   <form method="POST" action="{{ route('menu.destroy', $menu) }}" onsubmit="return confirm('Are you sure you want to delete this menu?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-1.5 text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                <div class="p-2">
                    {{ $menus->links() }}
                </div>
            </div>
        </div>
    </div>
</x-mainlayout>
