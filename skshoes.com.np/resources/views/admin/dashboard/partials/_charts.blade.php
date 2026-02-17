<!-- Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
    <!-- Sales Chart -->
    <div class="bg-white p-3 md:p-6 rounded-xl shadow-sm border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
            <h3 class="text-base md:text-lg font-semibold text-gray-800">Total Sales</h3>
            <input type="hidden" id="viewMode" name="period" value="{{ request('period', 'month') }}">
            <!-- Filter Controls -->
            <div class="flex flex-wrap gap-2 mt-2 sm:mt-0">
                <!-- View Toggle -->
                <div class="inline-flex rounded-lg border border-gray-200 p-1 bg-gray-50">
                    <button type="button" class="view-toggle px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                            {{$selected == 'monthly' ? 'active' : ''}}" data-view="monthly"
                        onclick="setViewMode('month')">
                        Monthly
                    </button>
                    <button type="button" class="view-toggle px-4 py-2 text-sm font-medium rounded-md transition-all duration-200
                            {{$selected == 'yearly' ? 'active' : ''}}" data-view="yearly"
                        onclick="setViewMode('year')">
                        Yearly
                    </button>
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="h-60 md:h-64">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Most Sold Items -->
    <div class="bg-white p-3 md:p-6 rounded-xl shadow-sm border border-gray-100">
        <h3 class="text-base md:text-lg font-semibold text-gray-800 mb-3">Most Sold Items</h3>
        <div class="space-y-3 md:space-y-4" id="topProductsList">
            <!-- Products will be dynamically populated -->
            @if ($most_sold || ! empty($most_sold || $most_sold != []))
                @foreach ($most_sold as $item)
                    <div class="flex items-center p-2 border border-gray-100 rounded-lg hover:bg-gray-50 transition-colors">
                        <span class="w-20 md:w-24 text-xs md:text-sm font-medium text-gray-700 truncate"
                            title="{{ $item['shoe_name'] }}">
                            {{ $item['shoe_name'] }}
                        </span>
                        <div class="flex-1 mx-3 h-2.5 bg-gray-100 rounded-full">
                            <div class="h-2.5 bg-blue-500 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                        </div>
                        <span class="w-12 text-xs md:text-sm font-medium text-gray-600 text-right">
                            {{ $item['percentage'] }}%
                        </span>
                    </div>
                @endforeach

            @else
                <div class="flex flex-col items-center justify-center h-48 p-6 text-center">
                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">No Sales Data Available</h4>
                    <p class="text-gray-500">There are currently no items sold to display.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .view-toggle {
        @apply text-gray-600 hover:bg-white hover:shadow-sm;
    }

    .view-toggle.active {
        @apply bg-white text-blue-600 shadow-sm;
    }

    #chartMonthSelect {
        transition: all 0.3s ease;
    }

    #chartMonthSelect.hidden {
        opacity: 0;
        width: 0;
        padding: 0;
        margin: 0;
        border: none;
    }

    /* Loading spinner styles */
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let salesChart;

        function initializeCharts() {
            const salesCtx = document.getElementById('salesChart').getContext('2d');

            salesChart = new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: Object.keys({!! json_encode($total_sales) !!}),
                    datasets: [{
                        label: 'Total Sales',
                        data: Object.values({!! json_encode($total_sales) !!}),
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        borderRadius: 4,
                        barThickness: 'flex'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rs. ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Sales (Rs.)'
                            },
                            ticks: {
                                callback: function (value) {
                                    return 'Rs. ' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        // Initialize charts
        initializeCharts();
    });
</script>