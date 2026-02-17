<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
    {{-- Include Header Component --}}
    <x-admin.header />
    
    <!-- Main Layout -->
    <div class="flex pt-16">
        {{-- Include Sidebar Component --}}
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 lg:ml-0 transition-all duration-300 ease-in-out">
            <div class="p-4 md:p-6 max-w-[1600px] mx-auto">
                <form id="filterForm" action="{{route('admin.dashboard')}}" method="get">
                    {{-- Date Range Section --}}
                    @include('admin.dashboard.partials._date_range')

                    {{-- Stats Cards Section --}}
                    @include('admin.dashboard.partials._stats_cards')

                    {{-- Charts Section --}}
                    @include('admin.dashboard.partials._charts')
                </form>
                {{-- Recent Orders Section --}}
                @include('admin.dashboard.partials._recent_orders')
            </div>
        </div>
    </div>

    {{-- Include Password Modal Component --}}
    {{-- <x-admin.change-password-modal /> --}}

    {{-- Include Dashboard Scripts --}}
    @include('admin.dashboard.partials._scripts')

    {{-- Include Dashboard Styles --}}
    @include('admin.dashboard.partials._styles')
</body>
</html>
