<x-cashier-layout>
    <div class="flex flex-col lg:flex-row h-screen overflow-hidden">
     

        <!-- Right Side - Column 6: Empty -->
        <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 flex flex-col overflow-hidden">
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center text-gray-500 dark:text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">Right Side Empty</p>
                </div>
            </div>
        </div>

           <!-- Left Side - Column 6: Categories with Tags and Items -->
        <div class="w-full lg:w-2/3 bg-gray-50 dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden">
            <!-- Categories Tags -->
            <div class="p-4 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700" id="category-tags">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Categories</h2>
                <div class="flex flex-wrap gap-2">
                    <!-- <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-primary-600 dark:text-primary-400 bg-primary-100 dark:bg-primary-900 cursor-pointer">
                        All Items
                    </span> -->

                    @foreach($categories as $category)
                        <button id="{{$category->id}}" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium cursor-pointer bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white text-center">
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>
            </div>

             

            <!-- Items Grid Below Categories -->
            <div class="flex-1 p-4 overflow-y-auto">
                <div id='no-menu'></div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20 text-center" id="menu-list">
                    
                </div>
            </div>

          
        </div>
        
    </div>
   


</x-cashier-layout>
