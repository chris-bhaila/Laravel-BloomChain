<div class="bg-white shadow-sm">
    <div class="flex justify-between items-center px-4 py-3">
        <!-- Mobile Menu Button -->
        <button id="sidebar-toggle" class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <!-- Page Title -->
        <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>

        <!-- User Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                <span class="hidden sm:block">Admin User</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="transform opacity-0 scale-95"
                 x-transition:enter-end="transform opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="transform opacity-100 scale-100"
                 x-transition:leave-end="transform opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                <div class="py-1">
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                    <div class="border-t border-gray-100"></div>
                    <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Mobile sidebar toggle
    document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        const content = document.querySelector('.pl-64');
        
        sidebar.classList.toggle('-translate-x-full');
        if (content) {
            content.classList.toggle('pl-0');
            content.classList.toggle('pl-64');
        }
    });
</script> 