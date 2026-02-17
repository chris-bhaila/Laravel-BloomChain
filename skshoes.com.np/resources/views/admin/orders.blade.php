@extends('admin.layouts.app')

@section('title', 'Orders')

@section('content')
    <div class="p-4">
        <!-- Order Filter Section -->
        <div class="mb-4">
            <!-- Order Title -->
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order</h2>

            <!-- Mobile View: Dropdown for Time Filters -->
            <div class="lg:hidden mb-4">
                <select class="w-full rounded-lg border-2 border-gray-200 py-2 px-3 text-sm" onchange="filterOrders(this.value)">
                    <option value="all">All Time</option>
                    <option value="12months">12 Months</option>
                    <option value="30days">30 Days</option>
                    <option value="7days">7 Days</option>
                    <option value="24hours">24 Hour</option>
                </select>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Desktop View: Time Filters -->
                <div class="hidden lg:flex items-center space-x-2">
                    <button data-filter="all" 
                            class="filter-button px-4 py-1.5 text-sm font-medium rounded-full bg-indigo-100 text-indigo-700">
                        All Time
                    </button>
                    <button data-filter="12months" 
                            class="filter-button px-4 py-1.5 text-sm font-medium rounded-full text-gray-600 hover:bg-gray-100">
                        12 Months
                    </button>
                    <button data-filter="30days" 
                            class="filter-button px-4 py-1.5 text-sm font-medium rounded-full text-gray-600 hover:bg-gray-100">
                        30 Days
                    </button>
                    <button data-filter="7days" 
                            class="filter-button px-4 py-1.5 text-sm font-medium rounded-full text-gray-600 hover:bg-gray-100">
                        7 Days
                    </button>
                    <button data-filter="24hours" 
                            class="filter-button px-4 py-1.5 text-sm font-medium rounded-full text-gray-600 hover:bg-gray-100">
                        24 Hour
                    </button>
                </div>

                <!-- Date and Filter Actions -->
                <div class="flex flex-wrap gap-2 items-center justify-end">
                    <!-- Date Inputs -->
                    <div class="flex items-center gap-2">
                        <!-- From Date -->
                        <div class="relative">
                            <input type="text" id="fromDate" 
                                   class="absolute opacity-0 w-0 h-0"
                                   placeholder="Select date">
                            <button type="button" onclick="fromDatePicker.open()"
                                    class="px-3 py-1.5 text-sm font-medium rounded-lg border-2 border-gray-200 
                                           bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300
                                           flex items-center space-x-2 transition-colors duration-200">
                                <span id="fromDateText">From</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>

                        <!-- To Date -->
                        <div class="relative">
                            <input type="text" id="toDate" 
                                   class="absolute opacity-0 w-0 h-0"
                                   placeholder="Select date">
                            <button type="button" onclick="toDatePicker.open()"
                                    class="px-3 py-1.5 text-sm font-medium rounded-lg border-2 border-gray-200 
                                           bg-white text-gray-600 hover:bg-gray-50 hover:border-gray-300
                                           flex items-center space-x-2 transition-colors duration-200">
                                <span id="toDateText">To</span>
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="applyDateFilter()"
                                class="px-3 py-1.5 text-sm font-medium rounded-lg border-2 border-gray-200 
                                       bg-white text-green-600 hover:bg-gray-50 hover:border-gray-300
                                       flex items-center space-x-2 transition-colors duration-200">
                            <span>Apply</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                        <button type="button" onclick="handleFiltersClick()"
                                class="px-3 py-1.5 text-sm font-medium rounded-lg border border-gray-300 
                                       bg-white text-gray-600 hover:bg-gray-50 flex items-center space-x-1">
                            <span>Filters</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters table -->
        <div id="filters-table" class="bg-white rounded-lg shadow-lg mt-4 hidden transition-all duration-300 ease-in-out">
            <div class="p-4">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Advanced Filters</h2>
                    <button onclick="toggleFilters()" 
                            class="text-gray-500 hover:text-gray-700 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <!-- Status Filter -->
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                        <div class="space-y-1">
                            <label class="flex items-center hover:bg-gray-100 p-1.5 rounded-md transition-colors duration-200">
                                <input type="checkbox" id="status-pending" name="status[]" value="Received"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Received</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-100 p-1.5 rounded-md transition-colors duration-200">
                                <input type="checkbox" id="status-delivered" name="status[]" value="Delivered"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Delivered</span>
                            </label>
                            <label class="flex items-center hover:bg-gray-100 p-1.5 rounded-md transition-colors duration-200">
                                <input type="checkbox" id="status-to-return" name="status[]" value="Returned"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">Returned</span>
                            </label>
                        </div>
                    </div>

                    <!-- Order ID and Article ID Filter Group -->
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                        <!-- Order ID Filter -->
                        <div class="mb-3">
                            <label for="order-id" class="block text-sm font-semibold text-gray-700 mb-2">Order ID</label>
                            <div class="relative">
                                <input type="text" id="order-id" name="order_id"
                                    class="w-full rounded-md border-2 border-gray-200 pl-3 pr-8 py-1.5 text-sm 
                                           focus:border-indigo-500 focus:ring-indigo-500 shadow-sm
                                           hover:border-gray-300 transition-colors duration-200"
                                    placeholder="Enter Order ID">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <!-- Article ID Filter -->
                        <div>
                            <label for="article-id" class="block text-sm font-semibold text-gray-700 mb-2">Article ID</label>
                            <div class="relative">
                                <input type="text" id="article-id" name="article_id"
                                    class="w-full rounded-md border-2 border-gray-200 pl-3 pr-8 py-1.5 text-sm 
                                           focus:border-indigo-500 focus:ring-indigo-500 shadow-sm
                                           hover:border-gray-300 transition-colors duration-200"
                                    placeholder="Enter Article ID">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Name Filter -->
                    <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 sm:col-span-1">
                        <label for="customer-name" class="block text-sm font-semibold text-gray-700 mb-2">Customer Name</label>
                        <div class="relative">
                            <input type="text" id="customer-name" name="customer_name"
                                class="w-full rounded-md border-2 border-gray-200 pl-3 pr-8 py-1.5 text-sm 
                                       focus:border-indigo-500 focus:ring-indigo-500 shadow-sm
                                       hover:border-gray-300 transition-colors duration-200"
                                placeholder="Enter Customer Name">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Actions - Full Width Row -->
                <div class="col-span-full mt-4">
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="resetFilters()"
                            class="w-24 px-4 py-2 text-sm font-medium text-gray-700 border border-gray-300 rounded-md 
                                   hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 
                                   focus:ring-indigo-500 transition-colors duration-200">
                            Reset
                        </button>
                        <button type="button" onclick="applyFilters()"
                            class="w-24 px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent 
                                   rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 
                                   focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Order ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Article ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Customer Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Address</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Nearest Mark</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">More</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- If nothing in the order --}}
                        @if (!isset($orders) || $orders->all() == [])
                            <tr>
                                <td colspan="11" class="px-4 py-4 text-center">
                                    <div class="text-center py-12">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No orders found</h3>
                                        <p class="mt-1 text-sm text-gray-500">No orders match your current filters.</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach($orders as $order)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['order_id'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['article_id'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['shoe_name'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['customer_name'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['address'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['nearest_landmark'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['phone_number'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">RS. {{ $order['price'] }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap
                                                                        @if($order['status'] === 'Pending') bg-yellow-100 text-yellow-800
                                                                        @elseif($order['status'] === 'Delivered') bg-green-100 text-green-800
                                                                        @elseif($order['status'] === 'Returned') bg-red-100 text-red-800
                                                                            @else bg-gray-100 text-gray-800
                                                                        @endif">
                                            {{ $order['status'] ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $order['created_at'] }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.orders.show', $order['order_id']) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
                <div class="overflow-x-auto">
                    <div class="px-4 py-3 border-t border-gray-200">
                        @if($orders->hasPages())
                            <div class="flex items-center justify-between">
                                <!-- Mobile View -->
                                <div class="flex justify-between flex-1 sm:hidden">
                                    @if($orders->onFirstPage())
                                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Previous
                                        </span>
                                    @else
                                        <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Previous
                                        </a>
                                    @endif

                                    @if($orders->hasMorePages())
                                        <a href="{{ $orders->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                                            Next
                                        </a>
                                    @else
                                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                                            Next
                                        </span>
                                    @endif
                                </div>

                                <!-- Desktop View -->
                                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                    <div>
                                        <p class="text-sm text-gray-700">
                                            Showing
                                            <span class="font-medium">{{ $orders->firstItem() ?? 0 }}</span>
                                            to
                                            <span class="font-medium">{{ $orders->lastItem() ?? 0 }}</span>
                                            of
                                            <span class="font-medium">{{ $orders->total() }}</span>
                                            results
                                        </p>
                                    </div>

                                    <div>
                                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                            {{-- Previous Page Link --}}
                                            @if($orders->onFirstPage())
                                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @else
                                                <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Previous</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @endif

                                            {{-- Page Numbers --}}
                                            @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                                                @if($page == $orders->currentPage())
                                                    <span class="relative inline-flex items-center px-4 py-2 border border-indigo-500 bg-indigo-50 text-sm font-medium text-indigo-600">
                                                        {{ $page }}
                                                    </span>
                                                @else
                                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                                        {{ $page }}
                                                    </a>
                                                @endif
                                            @endforeach

                                            {{-- Next Page Link --}}
                                            @if($orders->hasMorePages())
                                                <a href="{{ $orders->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            @else
                                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                                    <span class="sr-only">Next</span>
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </span>
                                            @endif
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    let fromDatePicker;
    let toDatePicker;
    let currentFilter = 'all';

    document.addEventListener('DOMContentLoaded', function() {
        initializeDatePickers();
        initializeTimeFilters();
        initializeRealTimeFiltering();
        // loadOrders('all'); // Initial load
    });

    function initializeDatePickers() {
        const config = {
            dateFormat: "Y-m-d",
            maxDate: "today",
            altInput: true,
            altFormat: "M j, Y",
            animate: true,
            closeOnSelect: true
        };

        fromDatePicker = flatpickr("#fromDate", {
            ...config,
            onChange: function(selectedDates) {
                if (selectedDates[0]) {
                    toDatePicker.set('minDate', selectedDates[0]);
                    document.getElementById('fromDateText').textContent = 
                        `From: ${selectedDates[0].toLocaleDateString()}`;
                }
            }
        });

        toDatePicker = flatpickr("#toDate", {
            ...config,
            onChange: function(selectedDates) {
                if (selectedDates[0]) {
                    fromDatePicker.set('maxDate', selectedDates[0]);
                    document.getElementById('toDateText').textContent = 
                        `To: ${selectedDates[0].toLocaleDateString()}`;
                }
            }
        });
    }

    function updateURLWithFilters(filters) {
        const url = new URL(window.location.href);
        
        // Clear existing filter parameters
        ['timeFrame', 'fromDate', 'toDate', 'status', 'orderId', 'articleId', 'customerName'].forEach(param => {
            url.searchParams.delete(param);
        });

        // Add new filter parameters
        Object.entries(filters).forEach(([key, value]) => {
            if (value && (Array.isArray(value) ? value.length > 0 : value.trim() !== '')) {
                if (Array.isArray(value)) {
                    value.forEach(v => url.searchParams.append(key + '[]', v));
                } else {
                    url.searchParams.set(key, value);
                }
            }
        });

        // Update URL without reloading the page
        window.history.pushState({}, '', url);
    }

    function getFiltersFromURL() {
        const params = new URLSearchParams(window.location.search);
        return {
            timeFrame: params.get('timeFrame') || 'all',
            fromDate: params.get('fromDate') || '',
            toDate: params.get('toDate') || '',
            status: (params.get('status') || '').split(',').filter(Boolean),
            orderId: params.get('orderId') || '',
            articleId: params.get('articleId') || '',
            customerName: params.get('customerName') || ''
        };
    }

    function applyFilters() {
        const filterData = {
            status: Array.from(document.querySelectorAll('input[name="status[]"]:checked')).map(cb => cb.value).join(','),
            orderId: document.getElementById('order-id')?.value?.trim(),
            articleId: document.getElementById('article-id')?.value?.trim(),
            customerName: document.getElementById('customer-name')?.value?.trim(),
            timeFrame: currentFilter,
            fromDate: fromDatePicker.selectedDates[0]?.toISOString().split('T')[0] || '',
            toDate: toDatePicker.selectedDates[0]?.toISOString().split('T')[0] || ''
        };

        // Create URL with filters
        const url = new URL(window.location.href);
        url.search = '';
        
        // Add non-empty filter parameters
        Object.entries(filterData).forEach(([key, value]) => {
            if (value) {
                url.searchParams.set(key, value);
            }
        });

        // Reload page with new filters
        window.location.href = url.toString();
    }

    function resetFilters() {
        // Reset all inputs
        document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.querySelectorAll('input[type="text"]').forEach(input => input.value = '');
        
        // Reset date pickers
        fromDatePicker.clear();
        toDatePicker.clear();
        document.getElementById('fromDateText').textContent = 'From';
        document.getElementById('toDateText').textContent = 'To';
        
        // Reset time filter
        currentFilter = 'all';
        updateFilterButtonStates(document.querySelector('[data-filter="all"]'));
        
        // Reload orders
        loadOrders();
        toggleFilters(); // Hide filters after resetting
    }

    // Utility functions
    function escapeHtml(unsafe) {
        return unsafe
            ? unsafe.replace(/[&<>"']/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            }[char]))
            : '';
    }

    function formatNumber(num) {
        return new Intl.NumberFormat('en-IN').format(num || 0);
    }

    function formatDate(dateStr) {
        return dateStr ? new Date(dateStr).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        }) : '';
    }

    function getStatusClass(status) {
        return {
            'Received': 'bg-yellow-100 text-yellow-800',
            'Delivered': 'bg-green-100 text-green-800',
            'To Return': 'bg-red-100 text-red-800'
        }[status] || 'bg-gray-100 text-gray-800';
    }

    function showLoadingState() {
        const tableBody = document.querySelector('tbody');
        tableBody.innerHTML = `
            <tr>
                <td colspan="11" class="px-4 py-4 text-center">
                    <div class="flex justify-center items-center space-x-2">
                        <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-gray-500">Loading orders...</span>
                    </div>
                </td>
            </tr>
        `;
    }

    function hideLoadingState() {
        // Loading state is automatically replaced when new content is loaded
    }

    function toggleFilters() {
        const filtersTable = document.getElementById('filters-table');
        
        if (!filtersTable.classList.contains('hidden')) {
            // Reset advanced filters only when closing
            resetAdvancedFilters();
        }
        
        filtersTable.classList.toggle('hidden');
    }

    function resetAdvancedFilters() {
        // Reset checkboxes in advanced filters
        document.querySelectorAll('#filters-table input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });

        // Reset text inputs in advanced filters
        document.querySelectorAll('#filters-table input[type="text"]').forEach(input => {
            input.value = '';
        });
    }

    function updateFilterButtonStates(activeButton) {
        document.querySelectorAll('.filter-button').forEach(btn => {
            btn.classList.remove('bg-indigo-100', 'text-indigo-700');
            btn.classList.add('text-gray-600');
        });
        
        if (activeButton) {
            activeButton.classList.add('bg-indigo-100', 'text-indigo-700');
            activeButton.classList.remove('text-gray-600');
        }
    }

    function initializeTimeFilters() {
        document.querySelectorAll('.filter-button').forEach(button => {
            button.addEventListener('click', function() {
                updateFilterButtonStates(this);
                filterOrders(this.dataset.filter);
            });
        });

        const mobileFilter = document.querySelector('select');
        if (mobileFilter) {
            mobileFilter.addEventListener('change', function() {
                filterOrders(this.value);
            });
        }

        // Update the date picker buttons to trigger the calendar
        document.querySelectorAll('[id$="DateText"]').forEach(button => {
            button.parentElement.addEventListener('click', function() {
                const inputId = this.previousElementSibling.id;
                if (inputId === 'fromDate') {
                    fromDatePicker.open();
                } else if (inputId === 'toDate') {
                    toDatePicker.open();
                }
            });
        });
    }

    function applyDateFilter() {
        if (fromDatePicker.selectedDates.length === 0 && toDatePicker.selectedDates.length === 0) {
            alert('Please select at least one date');
            return;
        }
        
        const filterData = {
            timeFrame: 'custom',
            fromDate: fromDatePicker.selectedDates[0]?.toISOString().split('T')[0] || '',
            toDate: toDatePicker.selectedDates[0]?.toISOString().split('T')[0] || ''
        };

        // Create URL and reload page
        const url = new URL(window.location.href);
        url.search = new URLSearchParams(filterData).toString();
        window.location.href = url.toString();
    }

    function handleFiltersClick() {
        const filtersTable = document.getElementById('filters-table');
        filtersTable.classList.toggle('hidden');
    }

    // Add real-time filtering for text inputs
    function initializeRealTimeFiltering() {
        // Remove the real-time filtering logic since we want filters to apply only on button click
        const textInputs = document.querySelectorAll('#filters-table input[type="text"]');
        textInputs.forEach(input => {
            // Clear any existing event listeners
            input.removeEventListener('input', () => {});
        });

        // Remove checkbox change event listeners
        document.querySelectorAll('#filters-table input[type="checkbox"]').forEach(checkbox => {
            checkbox.removeEventListener('change', () => {});
        });
    }

    // Update showErrorMessage function
    function showErrorMessage(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
        errorDiv.role = 'alert';
        errorDiv.innerHTML = `
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">${escapeHtml(message)}</span>
            <button class="absolute top-0 bottom-0 right-0 px-4" onclick="this.parentElement.remove()">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        `;
        document.body.appendChild(errorDiv);
        setTimeout(() => errorDiv.remove(), 5000);
    }

    function filterOrders(timeFrame) {
        const filterData = {
            timeFrame: timeFrame
        };

        // Clear date pickers when using time filter
        fromDatePicker.clear();
        toDatePicker.clear();
        document.getElementById('fromDateText').textContent = 'From';
        document.getElementById('toDateText').textContent = 'To';

        // Create URL and reload page
        const url = new URL(window.location.href);
        url.search = new URLSearchParams(filterData).toString();
        window.location.href = url.toString();
    }

    // Initialize filters from URL on page load
    document.addEventListener('DOMContentLoaded', function() {
        const urlFilters = getFiltersFromURL();
        
        // Set time frame filter
        if (urlFilters.timeFrame) {
            currentFilter = urlFilters.timeFrame;
            const filterButton = document.querySelector(`[data-filter="${urlFilters.timeFrame}"]`);
            if (filterButton) {
                updateFilterButtonStates(filterButton);
            }
            // Update mobile dropdown if it exists
            const mobileFilter = document.querySelector('select');
            if (mobileFilter) {
                mobileFilter.value = urlFilters.timeFrame;
            }
        }

        // Set date filters
        if (urlFilters.fromDate) {
            fromDatePicker.setDate(urlFilters.fromDate);
            document.getElementById('fromDateText').textContent = 
                `From: ${new Date(urlFilters.fromDate).toLocaleDateString()}`;
        }
        if (urlFilters.toDate) {
            toDatePicker.setDate(urlFilters.toDate);
            document.getElementById('toDateText').textContent = 
                `To: ${new Date(urlFilters.toDate).toLocaleDateString()}`;
        }

        // Set status checkboxes
        if (urlFilters.status.length > 0) {
            urlFilters.status.forEach(status => {
                const checkbox = document.querySelector(`input[value="${status}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }
        if (urlFilters.orderId) {
            document.getElementById('order-id').value = urlFilters.orderId;
        }
        if (urlFilters.articleId) {
            document.getElementById('article-id').value = urlFilters.articleId;
        }
        if (urlFilters.customerName) {
            document.getElementById('customer-name').value = urlFilters.customerName;
        }

        // Initialize other components
        initializeDatePickers();
        initializeTimeFilters();
        initializeRealTimeFiltering();
    });

    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        const urlFilters = getFiltersFromURL();
        // Reapply filters from URL without pushing new state
        currentFilter = urlFilters.timeFrame;
        loadOrders();
    });
</script>

<!-- Add jQuery if not already included -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Custom scrollbar styles */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .flatpickr-calendar {
        background: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .flatpickr-day.selected {
        background: #4f46e5 !important;
        border-color: #4f46e5 !important;
    }
    
    .flatpickr-day:hover {
        background: #e0e7ff !important;
    }
</style>
@endpush