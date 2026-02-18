<!-- resources/views/pages/dashboard/dashboard.blade.php -->

<x-app-layout title="Dashboard">

    <div x-data="dashboardApp()" class="flex h-screen">

        <!-- Mobile Backdrop Overlay -->
        <div
            x-show="mobileSidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-30 lg:hidden"
            style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside
            :class="[
                mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                sidebarOpen ? 'lg:w-56' : 'lg:w-14',
            ]"
            class="fixed inset-y-0 left-0 z-40 w-64
                   lg:relative lg:inset-auto lg:z-auto lg:flex-shrink-0
                   bg-gray-200 text-white flex flex-col
                   transition-all duration-300 overflow-hidden lg:rounded-lg lg:my-4 lg:ml-3">

            <!-- Header: Logo + Toggle button -->
            <div class="relative flex items-center h-14 px-3 shrink-0"
                :class="sidebarOpen ? 'justify-between' : 'lg:space-between'">

                <!-- Logo (expanded) -->
                <img
                    src="{{ asset('images/BloomChainText.png') }}"
                    alt="Logo"
                    x-show="sidebarOpen || mobileSidebarOpen"
                    x-transition:enter="transition-opacity duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="w-36 object-contain">

                <!-- Logo (collapsed, desktop only) -->
                <img
                    src="{{ asset('images/BloomChainLogo.png') }}"
                    alt="Logo"
                    x-show="!sidebarOpen && !mobileSidebarOpen"
                    class="hidden lg:block w-7 object-contain">

                <!-- Desktop toggle button (expanded) -->
                <button
                    @click="toggleSidebar()"
                    x-show="sidebarOpen"
                    class="hidden lg:flex items-center justify-center w-7 h-7 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-300 transition-colors shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <!-- Desktop toggle button (collapsed) -->
                <button
                    @click="toggleSidebar()"
                    x-show="!sidebarOpen"
                    class="hidden lg:flex items-center justify-center w-7 h-7 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-300 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Mobile close button -->
                <button
                    @click="mobileSidebarOpen = false"
                    class="lg:hidden text-gray-500 hover:text-gray-700 p-1 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-2 space-y-1 mt-2 overflow-y-auto">

                <h2
                    x-show="sidebarOpen || mobileSidebarOpen"
                    class="text-gray-400 text-xs font-semibold uppercase tracking-wider mx-2 mb-1">
                    Menu
                </h2>

                <!-- Dashboard -->
                <a
                    href="{{ route('dashboard') }}"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('profile') ? 'text-black' : 'text-gray-500'
                    ]"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">

                    <span
                        :class="isActive('profile') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all">
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('profile') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-6 h-6 shrink-0 transition-colors"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>

                    <span
                        x-show="sidebarOpen || mobileSidebarOpen"
                        x-transition
                        :class="isActive('profile') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Dashboard
                    </span>
                </a>

                <!-- Profile -->
                <a
                    href="{{ route('dashboard', ['page' => 'profile']) }}"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('profile') ? 'text-black' : 'text-gray-500'
                    ]"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">

                    <span
                        :class="isActive('profile') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all">
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('profile') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-6 h-6 shrink-0 transition-all"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                        <path d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        <circle cx="10" cy="8" r="5" />
                    </svg>

                    <span
                        x-show="sidebarOpen || mobileSidebarOpen"
                        x-transition
                        :class="isActive('profile') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Profile
                    </span>
                </a>

                <!-- Settings -->
                <a
                    href="{{ route('dashboard', ['page' => 'settings']) }}"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('settings') ? 'text-black' : 'text-gray-500'
                    ]"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">

                    <span
                        :class="isActive('settings') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all">
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('settings') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-6 h-6 shrink-0 transition-all"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>

                    <span
                        x-show="sidebarOpen || mobileSidebarOpen"
                        x-transition
                        :class="isActive('settings') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Settings
                    </span>
                </a>

                <!-- Add Nursery -->
                <a
                    href="{{ route('dashboard.nurseries', ['page' => 'create']) }}"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('nurseries.create') ? 'text-black' : 'text-gray-500'
                    ]"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">

                    <span
                        :class="isActive('nurseries.create') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all">
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('nurseries.create') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-6 h-6 shrink-0 transition-colors"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M14 9.536V7a4 4 0 0 1 4-4h1.5a.5.5 0 0 1 .5.5V5a4 4 0 0 1-4 4 4 4 0 0 0-4 4c0 2 1 3 1 5a5 5 0 0 1-1 3" />
                        <path d="M4 9a5 5 0 0 1 8 4 5 5 0 0 1-8-4" />
                        <path d="M5 21h14" />
                    </svg>

                    <span
                        x-show="sidebarOpen || mobileSidebarOpen"
                        x-transition
                        :class="isActive('nurseries.create') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Add Nursery
                    </span>
                </a>

                <!-- List Nursery -->
                <a
                    href="{{ route('dashboard.nurseries') }}"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('nurseries.index') ? 'text-black' : 'text-gray-500'
                    ]"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">

                    <span
                        :class="isActive('nurseries.index') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all">
                    </span>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('nurseries.index') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-6 h-6 shrink-0 transition-colors"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1" />
                        <path d="M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1" />
                        <circle cx="12" cy="8" r="2" />
                        <path d="M12 10v12" />
                        <path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z" />
                        <path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z" />
                    </svg>

                    <span
                        x-show="sidebarOpen || mobileSidebarOpen"
                        x-transition
                        :class="isActive('nurseries.index') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        List Nursery
                    </span>
                </a>

            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-auto bg-white">

            <!-- Mobile Top Bar -->
            <div class="lg:hidden flex items-center gap-3 px-4 py-3 border-b border-gray-200 bg-white sticky top-0 z-20">
                <button
                    @click="mobileSidebarOpen = true"
                    class="text-gray-600 hover:text-gray-900 p-1 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img src="{{ asset('images/BloomChainText.png') }}" alt="Logo" class="w-32 object-contain">
            </div>

            <div class="max-w-8xl mx-auto py-6 px-4 lg:py-10 lg:mt-4">
                @include('pages.dashboard.' . $page, [
                    'nurseries' => $nurseries ?? null,
                    'nursery'   => $nursery ?? null,
                ])
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardApp', () => ({
                sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
                mobileSidebarOpen: false,
                currentPage: '{{ $page ?? "profile" }}',

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarOpen', this.sidebarOpen);
                },

                isActive(page) {
                    return this.currentPage === page;
                }
            }))
        })
    </script>

</x-app-layout>