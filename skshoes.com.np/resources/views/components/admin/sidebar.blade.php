<div id="sidebar" class="bg-white h-[calc(100vh-3rem)] fixed top-12 left-0 overflow-y-auto transition-transform duration-300 ease-in-out shadow-lg z-40 w-64 -translate-x-full">
    <nav class="mt-2">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('admin.orders') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.orders*') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Orders</span>
        </a>

        <a href="{{ route('admin.products') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.products') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span>Products</span>
        </a>

        <a href="{{ route('admin.categories') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.categories') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <span>Categories</span>
        </a>

        <a href="{{ route('admin.stocks') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.stocks') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span>Stocks</span>
        </a>

        <a href="{{ route('admin.discount') }}" class="flex items-center p-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 space-x-2 {{ request()->routeIs('admin.discount') ? 'bg-blue-50 text-blue-600' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Discount</span>
        </a>
    </nav>
</div>