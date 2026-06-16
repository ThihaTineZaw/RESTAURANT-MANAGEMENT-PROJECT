<x-layout-master>
    <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto space-y-6">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden transition-colors duration-200">
                <div class="px-6 py-5 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Table</h3>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update the table details.</p>
                        </div>
                        <a href="{{ route('tables.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('tables.update', $table) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-6">
                            <label for="table_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Table Number</label>
                            <input type="text" id="table_number" name="table_number" value="{{ old('table_number', $table->table_number) }}" required
                                   class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                            @error('table_number')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select id="status" name="status" required
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors duration-200">
                                <option value="available" {{ old('status', $table->status) === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="unavailable" {{ old('status', $table->status) === 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('tables.index') }}" class="px-6 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-3 text-sm font-medium text-white bg-primary-600 rounded-xl hover:bg-primary-700 focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                                Update Table
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout-master>
