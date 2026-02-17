@extends('admin.layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="p-0">
    <!-- Main Content Card -->
    <div class="bg-white shadow-sm">
        <div class=" top-[3.5rem] left-0 right-0 z-30 w-full bg-gray-100 border-b border-gray-200 sm:relative sm:top-auto sm:left-auto sm:right-auto">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center px-4 py-1.5 bg-gray-100 space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-3 space-y-1 sm:space-y-0">
                    <div class="flex items-center space-x-1">
                        <h1 class="text-base font-semibold text-gray-800 whitespace-nowrap">Order ID -</h1>
                        <span class="text-base text-gray-700">{{ $order->id }}</span>
                    </div>
                    <div class="h-0.5 sm:h-3.5 sm:w-px sm:bg-gray-300"></div>
                    <div class="flex items-center space-x-1">
                        <h2 class="text-base font-semibold text-gray-800 whitespace-nowrap">Article ID -</h2>
                        <span class="text-base text-gray-700">{{ $order->article_id }}</span>
                    </div>
                    <div class="h-0.5 sm:h-3.5 sm:w-px sm:bg-gray-300"></div>
                    <div class="flex items-center">
                        <h2 class="text-base font-semibold text-gray-800">{{ $order->product }}</h2>
                    </div>
                </div>

                <!-- Right section: status + back button -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-2 sm:space-y-0 sm:space-x-2">
                    <span class="px-2 py-0.5 rounded-full text-sm font-medium whitespace-nowrap {{ 
                            match ($order->status) {
                                'Received' => 'bg-yellow-100 text-yellow-800',
                                'Delivered' => 'bg-green-100 text-green-800',
                                'Returned' => 'bg-red-100 text-red-800',
                                default => 'bg-gray-100 text-gray-800'
                            }
                        }}">
                        {{ $order->status }}
                    </span>
                    <a href="{{ route('admin.orders') }}"
                        class="inline-flex items-center px-2 py-0.5 bg-white border border-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-50">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content with adjusted margin and scrolling -->
        <div class="mt-[140px] sm:mt-0 overflow-y-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 lg:gap-8 p-6">
                <!-- Left Column - Product Image -->
                <div class="lg:col-span-3">
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        @if($order->product_image)
                        <img src="{{ $order->product_image }}"
                            alt="{{ $order->product }}"
                            class="w-full h-auto rounded-lg shadow-sm object-cover"
                            onerror="this.onerror=null; this.src='{{ asset('assets/images/products/placeholder.jpg') }}';">
                        @else
                        <div class="aspect-square rounded-lg bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Details -->
                <div class="lg:col-span-9">
                    <!-- Customer Details Section -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 lg:p-6 mb-4">
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200">Customer Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4">
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Customer Name:</span>
                                <span class="font-medium">{{ $order->customer_name }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Discount:</span>
                                <span class="font-medium">Rs. {{ $order->discounted_amount ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Address:</span>
                                <span class="font-medium">{{ $order->address ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Discount Code:</span>
                                <span class="font-medium">{{ $order->discount_code ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Nearest Mark:</span>
                                <span class="font-medium">{{ $order->nearest_mark ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Total Amount:</span>
                                <span class="font-medium">Rs. {{ $order->total_amount }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Phone Number:</span>
                                <span class="font-medium">{{ $order->phone_number ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Payment Method:</span>
                                <span class="font-medium">{{ $order->payment_method }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Email:</span>
                                <span class="font-medium">{{ $order->email ?? '-' }}</span>
                            </div>
                            <div class="flex space-x-4">
                                <span class="text-gray-600 min-w-[120px]">Transaction ID:</span>
                                <span class="font-medium">{{ $order->transactionId ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Product Details and Order Date Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                        <!-- Product Details -->
                        <div class="bg-white rounded-lg border border-gray-200 p-4 lg:p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200">Product Details</h3>
                            <div class="grid grid-cols-1 gap-y-4">

                                @foreach ($order->grouping as $group)
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[80px]">{{ Str::headline($group['key']) }}</span>
                                    <span class="font-medium">{{ Str::headline($group['value']) }}</span>
                                </div>
                                @endforeach
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[80px]">Size</span>
                                    <span class="font-medium">{{ $order->size }}</span>
                                </div>
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[80px]">Category</span>
                                    <span class="font-medium">{{ $order->category }}</span>
                                </div>
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[80px]">Color</span>
                                    <span class="font-medium">{{ $order->color }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Date -->
                        <div class="bg-white rounded-lg border border-gray-200 p-4 lg:p-6">
                            <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200">Order Date</h3>
                            <div class="space-y-4">
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[100px]">Ordered at:</span>
                                    <span class="font-medium">{{ $order->ordered_at }}</span>
                                </div>
                                <div class="w-full h-px bg-gray-100"></div>
                                <div class="flex space-x-4">
                                    <span class="text-gray-600 min-w-[100px]">Confirmed at:</span>
                                    <span class="font-medium {{ $order->confirmed_at ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $order->confirmed_at ?? '-' }}
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 mt-6 pt-4 border-t border-gray-200">
                                    <div class="relative w-full">
                                        <select id="orderStatus"

                                            class="w-full bg-white border border-gray-300 text-gray-700 py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="" disabled {{ $order->status === null ? 'selected' : '' }}>Select Status</option>
                                            <option value="Received" {{ $order->status === 'Received' ? 'selected' : '' }}>Received</option>
                                            <option value="Delivered" {{ $order->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Returned" {{ $order->status === 'Returned' ? 'selected' : '' }}>Returned</option>
                                            <option value="Rejected" {{ $order->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('success', '{{ session('
            success ') }}');
    });
</script>
@elseif (session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showToast('error', '{{ session('
            error ') }}');
    });
</script>
@endif

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-4 right-4 transform translate-y-full opacity-0 transition-all duration-300 z-50">
    <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4 flex items-center space-x-3">
        <div id="toastIcon" class="flex-shrink-0"></div>
        <div id="toastMessage" class="text-sm font-medium"></div>
    </div>
</div>
<!-- Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
        <h3 class="text-lg font-semibold mb-4">Confirm Status Change</h3>
        <p class="text-gray-600 mb-4">Are you sure you want to change the order status to <span id="newStatus" class="font-medium"></span>?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded hover:bg-gray-200">
                Cancel
            </button>
            <button onclick="confirmStatusChange()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded hover:bg-indigo-700">
                Confirm
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let pendingStatusChange = null;
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('orderStatus');
        let previousValue = select.value;

        select.addEventListener('change', function() {
            handleOrderAction(select.value, previousValue);
        });
    });
    // AJAX handling for order actions
    async function handleOrderAction(status, prev) {
        if (!status) return;

        const select = document.getElementById('orderStatus');
        const originalValue = select.value;

        // Store the status change for confirmation
        pendingStatusChange = {
            status,
            prev
        };

        if (status == "Rejected") {
            // Show confirmation modal
            document.getElementById('newStatus').textContent = status;
            document.getElementById('confirmationModal').classList.remove('hidden');
        } else {
            confirmStatusChange();
        }
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        const select = document.getElementById('orderStatus');
        pendingStatusChange = null;
    }

    async function confirmStatusChange() {
        if (!pendingStatusChange) return;

        const select = document.getElementById('orderStatus');

        // select.disabled = true;
        console.log(pendingStatusChange);
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const bearerToken = localStorage.getItem('auth_token');
            const response = await fetch(`{{ route('orderUpdate', $order->id) }}`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${bearerToken}`,
                    'X-CSRF-Token': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: pendingStatusChange.status,
                    currentStatus: pendingStatusChange.prev
                })
            });

            const data = await response.json();

            if (response.ok) {
                const message = data.success || `Order status updated to ${pendingStatusChange.status}`;
                showToast('success', message);
                // console.log('Status ' + pendingStatusChange.status + ' prev ' + pendingStatusChange.prev);
                select.value = pendingStatusChange.status;

            } else {
                throw new Error(data.message || 'Failed to update order status');
            }
        } catch (error) {
            showToast('error', error.message);
        } finally {
            // select.disabled = false;
            closeModal();
            pendingStatusChange = null;
        }
    }

    // Toast notification function
    function showToast(type, message) {
        const toast = document.getElementById('toast');
        const toastIcon = document.getElementById('toastIcon');
        const toastMessage = document.getElementById('toastMessage');

        // Set icon based on type
        const icons = {
            success: `<svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                         </svg>`,
            error: `<svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>`
        };

        toastIcon.innerHTML = icons[type];
        toastMessage.textContent = message;

        // Show toast
        toast.classList.remove('translate-y-full', 'opacity-0');

        // Hide toast after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-y-full', 'opacity-0');
        }, 25000);
    }

    // Calendar positioning for mobile
    function adjustCalendarPosition() {
        const isMobile = window.innerWidth < 640;
        const calendars = document.querySelectorAll('#calendarFrom, #calendarTo');

        calendars.forEach(calendar => {
            if (isMobile) {
                const rect = calendar.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const bottomSpace = viewportHeight - rect.bottom;

                calendar.style.position = 'fixed';
                calendar.style.left = '1rem';
                calendar.style.right = '1rem';
                calendar.style.width = 'auto';

                if (bottomSpace < 300) {
                    calendar.style.bottom = '1rem';
                    calendar.style.top = 'auto';
                } else {
                    calendar.style.top = `${rect.top}px`;
                    calendar.style.bottom = 'auto';
                }
            } else {
                calendar.style.position = 'absolute';
                calendar.style.width = '16rem';
                calendar.style.left = '';
                calendar.style.right = '';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        window.addEventListener('resize', adjustCalendarPosition);
        adjustCalendarPosition();
    });
</script>
@endpush