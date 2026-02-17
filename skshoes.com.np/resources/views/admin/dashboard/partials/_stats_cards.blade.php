<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6">
    <!-- Sales Card -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center">
        <div class="h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 flex-shrink-0 relative mr-4">
            <svg class="w-full h-full" viewBox="0 0 36 36">
                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none" stroke="#E5E7EB" stroke-width="3" />
                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                    fill="none" stroke="#22C55E" stroke-width="3"
                    data-progress="sales"
                    stroke-dasharray="{{ $sales_percent ?? '0' }}, 100" />
                <text x="18" y="18.5" class="percentage-text" text-anchor="middle"
                    alignment-baseline="middle" fill="#374151"
                    style="font-size: 8px; font-weight: 600;">
                    {{ $sales_percent ?? '0' }}%
                </text>
            </svg>
        </div>
        <div class="flex-1 text-right">
            <p class="text-sm text-gray-500">Sales</p>
            <h3 class="text-xl md:text-2xl font-bold text-gray-800" data-stat="sales-total">
                Rs. {{ $sales ?? 'Undefined' }}
            </h3>
            <p class="text-xs text-gray-400" data-stat="sales-items">
                Total {{ $sales_number ?? 'Undefined' }} items
            </p>
        </div>
        </div>

    </div>

    <!-- In Progress Card -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center">
            <div class="h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 flex-shrink-0 relative mr-4">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#E5E7EB" stroke-width="3" />
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#3B82F6" stroke-width="3"
                        data-progress="pending"
                        stroke-dasharray="{{ $pending_percent ?? '0' }}, 100" />
                    <text x="18" y="18.5" 
                        data-percentage="pending"
                        class="percentage-text" 
                        text-anchor="middle" 
                        alignment-baseline="middle"
                        fill="#374151"
                        style="font-size: 8px; font-weight: 600;">{{ $pending_percent ?? '0' }}%</text>
                </svg>
            </div>
            <div class="flex-1 text-right">
                <p class="text-sm text-gray-500">In Progress</p>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800" data-stat="pending-total">
                    Rs. {{ $pending ?? 'Undefined' }}
                </h3>
                <p class="text-xs text-gray-400" data-stat="pending-items">Total {{ $pending_number ?? 'Undefined' }} items</p>
            </div>
        </div>
    </div>

    <!-- Returns Card -->
    <div class="bg-white p-4 md:p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center">
            <div class="h-12 w-12 sm:h-14 sm:w-14 md:h-16 md:w-16 flex-shrink-0 relative mr-4">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#E5E7EB" stroke-width="3" />
                    <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                        fill="none" stroke="#EF4444" stroke-width="3"
                        data-progress="returns"
                        stroke-dasharray="{{ $returned_percent ?? '0' }}, 100" />
                    <text x="18" y="18.5" 
                        data-percentage="returns"
                        class="percentage-text" 
                        text-anchor="middle" 
                        alignment-baseline="middle"
                        fill="#374151"
                        style="font-size: 8px; font-weight: 600;">{{ $returned_percent ?? '0' }}%</text>
                </svg>
            </div>
            <div class="flex-1 text-right">
                <p class="text-sm text-gray-500">Returns</p>
                <h3 class="text-xl md:text-2xl font-bold text-gray-800" data-stat="returns-total">
                    Rs. {{ $returned ?? 'Undefined' }}
                </h3>
                <p class="text-xs text-gray-400" data-stat="returns-items">Total {{ $returned_number ?? 'Undefined' }} items</p>
            </div>
        </div>
    </div>
</div>

<script>
// async function updateStatsCards() {
//     try {
//         const response = await $.ajax({
//             url: '/api/dashboard',
//             method: 'GET'
//         });

//         // Update with current totals (not filtered)
//         if (response) {
//             // Sales
//             document.querySelector('[data-stat="sales-total"]').textContent = 
//                 `Rs. ${response.sales.toLocaleString()}`;
//             document.querySelector('[data-stat="sales-items"]').textContent = 
//                 `Total ${response.sales_number} items`;
//             document.querySelector('[data-progress="sales"]').setAttribute(
//                 'stroke-dasharray', `${response.sales_percent}, 100`);
//             document.querySelector('[data-percentage="sales"]').textContent = 
//                 `${response.sales_percent}%`;

//             // Pending/In Progress
//             document.querySelector('[data-stat="pending-total"]').textContent = 
//                 `Rs. ${response.pending.toLocaleString()}`;
//             document.querySelector('[data-stat="pending-items"]').textContent = 
//                 `Total ${response.pending_number} items`;
//             document.querySelector('[data-progress="pending"]').setAttribute(
//                 'stroke-dasharray', `${response.pending_percent}, 100`);
//             document.querySelector('[data-percentage="pending"]').textContent = 
//                 `${response.pending_percent}%`;

//             // Returns
//             document.querySelector('[data-stat="returns-total"]').textContent = 
//                 `Rs. ${response.returned.toLocaleString()}`;
//             document.querySelector('[data-stat="returns-items"]').textContent = 
//                 `Total ${response.returned_number} items`;
//             document.querySelector('[data-progress="returns"]').setAttribute(
//                 'stroke-dasharray', `${response.returned_percent}, 100`);
//             document.querySelector('[data-percentage="returns"]').textContent = 
//                 `${response.returned_percent}%`;
//         }
//     } catch (error) {
//         console.error('Error updating stats cards:', error);
//     }
// }

// // Initialize on page load
// document.addEventListener('DOMContentLoaded', updateStatsCards);

// // Auto refresh every 5 minutes
// setInterval(updateStatsCards, 300000);
// </script> 