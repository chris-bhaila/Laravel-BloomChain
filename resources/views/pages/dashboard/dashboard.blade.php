<!-- resources/views/dashboard.blade.php -->

<x-app-layout title="Dashboard">

    <div x-data="{ sidebarOpen: true }" class="flex h-screen">

        <!-- Sidebar -->
        <aside x-data="sidebar()"
            :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="bg-black text-white flex flex-col transition-all duration-300 overflow-hidden"
        >
            <!-- Logo -->
            <div class="relative flex items-center justify-center h-14">

                <!-- Expanded -->
                <img
                    src="{{ asset('images/BloomChainText.png') }}"
                    alt="Logo"
                    :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                    class="absolute w-45 object-contain transition-opacity duration-300"
                >

                <!-- Collapsed -->
                <img
                    src="{{ asset('images/BloomChainLogo.png') }}"
                    alt="Logo"
                    :class="!sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                    class="absolute w-8 object-contain transition-opacity duration-300"
                >
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-2 space-y-2 mt-4">

            <!-- Profile -->
            <a
                href="{{ route('dashboard') }}"
                :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-700 transition"
            >
                <!-- SVG icon -->
                <svg
                    class="w-6 h-6 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5.121 17.804A13.937 13.937 0 0112 15
                        c2.28 0 4.419.568 6.879 1.804
                        M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>

                <!-- Label -->
                <span
                    x-show="sidebarOpen"
                    x-transition
                    class="whitespace-nowrap"
                >
                    Profile
                </span>
            </a>

            <!-- Settings -->
            <a
                href="{{ route('dashboard', ['page' => 'settings']) }}"
                :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-700 transition"
            >
                <!-- SVG icon -->
                <svg
                    class="w-6 h-6 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10.325 4.317a9.043 9.043 0 013.35 0
                        l.53 2.122a1 1 0 00.95.69h2.224
                        a1 1 0 01.832 1.555l-1.347 1.962
                        a1 1 0 000 1.118l1.347 1.962
                        a1 1 0 01-.832 1.555h-2.224
                        a1 1 0 00-.95.69l-.53 2.122
                        a9.043 9.043 0 01-3.35 0
                        l-.53-2.122a1 1 0 00-.95-.69H6.151
                        a1 1 0 01-.832-1.555l1.347-1.962
                        a1 1 0 000-1.118L5.319 8.684
                        a1 1 0 01.832-1.555h2.224
                        a1 1 0 00.95-.69l.53-2.122z"
                    />
                </svg>

                <!-- Label -->
                <span
                    x-show="sidebarOpen"
                    x-transition
                    class="whitespace-nowrap"
                >
                    Settings
                </span>
            </a>

            <!--Add Nursery-->
            <a
                href="{{ route('dashboard.nurseries', ['page' => 'create']) }}"
                :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-700 transition"
            >
                <!-- SVG icon -->
                <svg
                    class="w-6 h-6 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 20v-6"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7 10c0 4 5 4 5 4s5 0 5-4
                        -5-6-5-6-5 2-5 6z"
                    />
                </svg>

                <!-- Label -->
                <span
                    x-show="sidebarOpen"
                    x-transition
                    class="whitespace-nowrap"
                >
                    Add Nursery
                </span>
            </a>

            <!--List Nursery-->
            <a
                href="{{ route('dashboard.nurseries', ['page' => 'index']) }}"
                :class="sidebarOpen ? 'justify-start' : 'justify-center'"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-700 transition"
            >
                <!-- SVG icon -->
                <svg
                    class="w-6 h-6 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 6h10M4 12h10M4 18h10"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M17 7c2-2 3-2 3-2s0 1-2 3
                        -3 2-3 2 0-1 2-3z"
                    />
                </svg>


                <!-- Label -->
                <span
                    x-show="sidebarOpen"
                    x-transition
                    class="whitespace-nowrap"
                >
                    List Nursery
                </span>
            </a>

        </nav>


            <!-- Toggle -->
            <div class="p-4 border-t border-gray-700">
                <button @click="toggle()"
                    @click="sidebarOpen = !sidebarOpen"
                    class="flex items-center justify-center w-full bg-blue-600 py-2 rounded"
                >
                    <svg
                        :class="{'rotate-180': sidebarOpen, 'rotate-0': !sidebarOpen}"
                        class="w-6 h-6 transition-transform dutation-600"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                    <path stroke-linecap="roung" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>

                    <span x-show="sidebarOpen" x-transition class="ml-2">
                        Toggle
                    </span>
                </button>
            </div>
        </aside>


        <!-- Main content -->
        <main class="flex-1 overflow-auto p-6 bg-gray-100">
            <div class="max-w-8xl mx-auto py-10 px-4">
                @include('pages.dashboard.' . $page, [
                    'nurseries' => $nurseries ?? null,
                    'nursery'   => $nursery ?? null,
                ])
            </div>
        </main>
    </div>

<!--This script ensures that the sidebar doesn't automatically open when switching to a different section-->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebar', () => ({
                sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || false,

                toggle() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarOpen', this.sidebarOpen);
                }
            }))
        })
    </script>
</x-app-layout>
