<!-- Recent Orders -->
<div class="mt-4 md:mt-6 bg-white rounded-xl shadow-sm border border-gray-100">
    <div class="p-4 md:p-6">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-4">Recent Orders</h3>
        @while (! isset($orders))
            <!-- Loading Spinner for Orders -->
            <div id="ordersLoading" class="flex justify-center items-center py-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            </div>
        @endwhile
        <div class="overflow-x-auto -mx-4 md:-mx-6 hide-scrollbar">
            <div class="inline-block min-w-full align-middle">
                <table id="recentOrdersTable" class="min-w-full divide-y divide-gray-200 table-fixed md:table-auto">
                    <thead>
                        <tr>
                            <th class="w-20 md:w-auto px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                            <th class="w-32 md:w-auto px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer Name</th>
                            <th class="w-32 md:w-auto px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="w-24 md:w-auto px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="w-24 md:w-auto px-4 md:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <!-- Orders will be populated here -->
                        @if (empty($orders) || $orders == [])
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center">
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                                    </div>
                                </td>
                            </tr>
                        @else
                        @php
                            $statusClasses = [
                                'Received'  => 'text-yellow-800 bg-yellow-100',
                                'Delivered' => 'text-green-800 bg-green-100',
                                'Returned'  => 'text-red-800 bg-red-100',
                            ];
                        @endphp
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="px-4 md:px-6 py-3 text-xs md:text-sm text-gray-900">{{$order['order_id']}}</td>
                                    <td class="px-4 md:px-6 py-3 text-xs md:text-sm text-gray-900">{{ $order['customer_name'] }}</td>
                                    <td class="px-4 md:px-6 py-3 text-xs md:text-sm text-gray-900">{{ $order['shoe_name'] }}</td>
                                    <td class="px-4 md:px-6 py-3 text-xs md:text-sm text-gray-900">
                                        {{ $order['date'] }}
                                    </td>
                                    <td class="px-4 md:px-6 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$order['status']] ?? '' }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
/* Loading spinner animation */
.animate-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}

/* Hide scrollbar but keep functionality */
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}

.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style> 