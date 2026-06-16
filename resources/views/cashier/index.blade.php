<x-cashier-layout>


    <div class="flex flex-col lg:flex-row h-full overflow-hidden">

        <!-- Tables Slide Panel -->
        <div id="tables-panel" class="fixed inset-y-0 left-0 z-50 w-80 bg-white dark:bg-gray-800 shadow-xl transform -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Tables</h2>
                <button id="close-tables-btn" class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-4 overflow-y-auto h-full">
                <div class="grid grid-cols-2 gap-4">
                    @foreach($tables as $table)
                        <button class="table-btn p-4 rounded-xl border-2 transition-all duration-200 {{ ($table->status ?? 'available') === 'available' ? 'bg-green-50 dark:bg-green-900/20 border-green-500 text-green-700 dark:text-green-400 hover:bg-green-100 dark:hover:bg-green-900/30' : 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-500 text-yellow-700 dark:text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-900/30' }}" data-table-id="{{ $table->id }}" data-table-number="{{ $table->table_number ?? 'Table ' . $table->id }}" data-table-status="{{ $table->status }}">
                            <img src="{{ asset('storage/icons/table.png') }}" alt="Table" class="w-12 h-12 mx-auto mb-2">
                            <div class="font-semibold text-sm">{{ $table->table_number ?? 'Table ' . $table->id }}</div>
                            <div class="text-xs mt-1 table-status">{{ ucfirst($table->status ?? 'available') }}</div>
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Overlay -->
        <div id="tables-overlay" class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity duration-300"></div>

        <!-- Item Already Added Modal -->
        <div id="item-already-added" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 max-w-sm w-full mx-4 border border-gray-200 dark:border-gray-700">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Item Already Added</h3>
                    <p class="text-gray-600 dark:text-gray-400">This item is already in your order.</p>
                </div>
                <button id="close-item-alert" class="w-full py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition-colors duration-200">
                    Got it
                </button>
            </div>
        </div>
        <!-- Payment Model Box  -->
        <div id="payment-model-box" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-gray-700">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Receive Amount?</h3>

                    <input type="number" id="payment-amount" class="w-full py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary-600 focus:outline-none mb-4" placeholder="Enter amount">

                    <!-- Payment Method Checkboxes -->
                    <div class="text-left mb-2">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white mb-2">Payment Method</p>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <input type="radio" name="payment-method" value="cash" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:bg-gray-700 dark:border-gray-600" checked>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Cash</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <input type="radio" name="payment-method" value="kbz-pay" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 focus:ring-primary-500 dark:focus:ring-primary-600 dark:bg-gray-700 dark:border-gray-600">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">KBZ Pay</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3">
                    <button id="payment-cancel-btn" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition-colors duration-200">
                        Cancel Payment
                    </button>
                    <button id="payment-confirm-btn-model" class="flex-1 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200">
                        Confirm Payment
                    </button>
                </div>
            </div>
        </div>
        <!-- Order Confirmation Modal -->
        <div id="order-again-confirm" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6 max-w-md w-full mx-4 border border-gray-200 dark:border-gray-700">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Confirm Order?</h3>
                    <p class="text-gray-600 dark:text-gray-400">Are you sure you want to confirm this order? This action cannot be undone.</p>
                </div>
                <div class="flex gap-3">
                    <button id="order-again-cancel-btn" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white font-semibold rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                    <button id="order-again-confirm-btn" class="flex-1 py-2.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200">
                        Confirm Order
                    </button>
                </div>
            </div>
        </div>
        <!-- Right Side - Column 6: Order Table -->
        <div class="w-full lg:w-1/3 bg-white dark:bg-gray-800 flex flex-col overflow-hidden">
            <div class="p-4 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Order</h2>
                    <p id="selected-table" class="text-sm font-semibold text-red-600 dark:text-red-400">No table selected</p>
                </div>
                <button id="open-tables-btn" class="p-1 rounded-lg bg-primary-500 hover:bg-primary-600 text-white transition-colors duration-200">
                    <img src="{{ asset('storage/icons/table.png') }}" alt="Table" class="w-12 h-12">
                </button>
            </div>
            <div class="flex-1 flex flex-col overflow-hidden">
                <div class="flex-1 p-4 overflow-y-auto">
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-200">
                        <table class="w-full divide-gray-200 dark:divide-gray-700 text-xs transition-colors duration-200">
                            <thead class="bg-gray-50 dark:bg-gray-900 text-left text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 transition-colors duration-200 sticky top-0">
                                <tr>
                                     <th class="px-3 py-2">Image</th>   
                                    <th class="px-3 py-2">Menu</th>
                                    
                                    <th class="px-3 py-2 text-center">Qty</th>
                                    <th class="px-3 py-2">Price</th>
                                    <th class="px-3 py-2">Delete</th>
                               
                                </tr>
                            </thead>
                            <tbody id="order-list" class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800 transition-colors duration-200">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="p-3 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Total</span>
                        <span id="total_price" class="text-lg font-bold text-primary-600 dark:text-primary-400">0 Ks</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Received</span>
                        <span id="received_price" class="text-lg font-bold text-primary-600 dark:text-primary-400">0 Ks</span>
                    </div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-gray-900 dark:text-white">Change</span>
                        <span id="change_price" class="text-lg font-bold text-primary-600 dark:text-primary-400">0 Ks</span>
                    </div>

                    <button id="order-confirm-btn" class="w-full py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Order Confirm
                    </button>
                    <button id="order-again-btn" class="hidden w-full py-2 px-4 bg-primary-600 hover:bg-primary-700 mb-4 text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Order Again
                    </button>
                     <button id="order-payment-btn" class="hidden w-full py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Payment
                    </button>

                    <button id="payment-confirm-btn" class="hidden mt-4 w-full py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Payment Confirm
                    </button>
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

            <div id="order_id" class="hidden"></div>

            <!-- Items Grid Below Categories -->
            <div class="flex-1 p-4 overflow-y-auto">
                <div id='no-menu'></div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 pb-20 text-center" id="menu-list">

                </div>
            </div>


        </div>

    </div>



</x-cashier-layout>