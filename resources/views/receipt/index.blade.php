<x-layout-master>
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Receipt Management</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">View and print order receipts</p>
        </div>

        <!-- Orders List -->
        <div class="space-y-4">
            @forelse($orders as $order)

          
            
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-4 sm:p-6 transition-all duration-200 hover:shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="space-y-2">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order #{{ str_pad($order->id, 8, '0', STR_PAD_LEFT) }}</h3>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->status === 'PAID' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Table:</span>
                                    <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $order->table_number }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Total:</span>
                                      <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $order->total_price }} Ks</span>
                                </div>
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Date:</span>
                                    <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                @if($order->payment)
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Payment:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $order->payment->payment_method }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <a href="{{ route('receipts.show', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                           
                            <a href="{{ route('receipts.download', $order->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Receipts Found</h3>
                    <p class="text-gray-600 dark:text-gray-400">There are no orders yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</x-layout-master>
