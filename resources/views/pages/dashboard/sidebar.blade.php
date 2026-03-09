@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $nursery = Auth::user()->nursery;
@endphp
<x-app-layout title="Dashboard">

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-up>* {
            animation: fadeUp 0.55s ease forwards;
            opacity: 0;
        }

        .fade-up>*:nth-child(1) {
            animation-delay: 0.05s;
        }

        .fade-up>*:nth-child(2) {
            animation-delay: 0.15s;
        }

        .fade-up>*:nth-child(3) {
            animation-delay: 0.25s;
        }

        .fade-up>*:nth-child(4) {
            animation-delay: 0.35s;
        }

        .fade-up>*:nth-child(5) {
            animation-delay: 0.45s;
        }

        .fade-up>*:nth-child(6) {
            animation-delay: 0.55s;
        }

        .fade-up>*:nth-child(7) {
            animation-delay: 0.65s;
        }

        .fade-up>*:nth-child(8) {
            animation-delay: 0.75s;
        }

        .fade-up>*:nth-child(9) {
            animation-delay: 0.85s;
        }

        .fade-up>*:nth-child(10) {
            animation-delay: 0.95s;
        }
    </style>

    <div x-data="dashboardApp()" class="flex h-screen">

        <!-- Mobile Backdrop Overlay -->
        <div x-show="mobileSidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="mobileSidebarOpen = false"
            class="fixed inset-0 bg-black/40 z-30 lg:hidden" style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="[
                mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                sidebarOpen ? 'lg:w-75' : 'lg:w-20',
            ]" class="fixed inset-y-0 left-0 z-40 w-64
                   lg:relative lg:inset-auto lg:z-auto lg:flex-shrink-0
                   bg-white border-r-2 text-white flex flex-col
                   transition-all duration-300 overflow-hidden lg:rounded-2xl lg:my-4 lg:ml-3"
            style="box-shadow: -2px 0px 15px rgba(0,0,0,0.25);">

            <!-- Header: Logo + Toggle -->
            <div class="relative flex items-center h-14 px-3 shrink-0"
                :class="sidebarOpen ? 'justify-between' : 'lg:justify-center'">

                <img src="{{ asset('images/BloomChainText.png') }}" alt="Logo" x-show="sidebarOpen || mobileSidebarOpen"
                    x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-100"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="w-36 object-contain lg:ml-3">

                {{-- Single toggle button for all states --}}
                <button @click="toggleSidebar()"
                    class="hidden lg:flex items-center justify-center w-7 h-7 rounded-md text-gray-500 hover:text-gray-800 hover:bg-gray-300 transition-colors shrink-0">
                    <svg class="w-7 h-7 lg:mb-1" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2" />
                        <path d="M9 3v18" />
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-2 space-y-1 mt-2 overflow-y-auto flex flex-col pb-4">

                <h2 x-show="sidebarOpen || mobileSidebarOpen"
                    class="text-gray-400 text-xs font-semibold uppercase tracking-wider ml-5 mb-1">
                    Menu
                </h2>

                <!-- Dashboard -->
                <a href="{{ route('dashboard', ['page' => 'dashboard']) }}"
                    @click.prevent="navigate('{{ route('dashboard', ['page' => 'dashboard']) }}', 'dashboard')" :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('dashboard') ? 'text-black' : 'text-gray-500'
                    ]" class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                    <span :class="isActive('dashboard') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all"></span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('dashboard') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-7 h-7 shrink-0 transition-colors" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                        :class="isActive('dashboard') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Dashboard
                    </span>
                </a>

                <!-- Profile -->
                <a href="{{ route('dashboard', ['page' => 'profile']) }}"
                    @click.prevent="navigate('{{ route('dashboard', ['page' => 'profile']) }}', 'profile')" :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('profile') ? 'text-black' : 'text-gray-500'
                    ]" class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                    <span :class="isActive('profile') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all"></span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('profile') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-7 h-7 shrink-0 transition-all" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M2 21a8 8 0 0 1 10.821-7.487" />
                        <path
                            d="M21.378 16.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                        <circle cx="10" cy="8" r="5" />
                    </svg>
                    <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                        :class="isActive('profile') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Profile
                    </span>
                </a>

                <!-- Nursery -->
                @if ($nursery !== null)
                    <a href="{{ route('nursery.show') }}"
                        @click.prevent="navigate('{{ route('nursery.show') }}', 'nurseries.nursery')" :class="[
                                (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                                isActive('nurseries.nursery') ? 'text-black' : 'text-gray-500'
                            ]" class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                        <span
                            :class="isActive('nurseries.nursery') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                            class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all"></span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            :class="isActive('nurseries.nursery') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                            class="w-7 h-7 shrink-0 transition-colors" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1" />
                            <path d="M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1" />
                            <circle cx="12" cy="8" r="2" />
                            <path d="M12 10v12" />
                            <path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z" />
                            <path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z" />
                        </svg>
                        <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                            :class="isActive('nurseries.nursery') ? 'text-black' : 'group-hover:text-black'"
                            class="whitespace-nowrap transition-colors text-m">
                            {{ $nursery->name }}
                        </span>
                    </a>
                @endif

                <!-- Settings -->
                <a href="{{ route('settings') }}" @click.prevent="navigate('{{ route('settings') }}', 'settings')"
                    :class="[
                        (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                        isActive('settings') ? 'text-black' : 'text-gray-500'
                    ]" class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                    <span :class="isActive('settings') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all"></span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        :class="isActive('settings') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                        class="w-7 h-7 shrink-0 transition-all" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path
                            d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                        :class="isActive('settings') ? 'text-black' : 'group-hover:text-black'"
                        class="whitespace-nowrap transition-colors text-m">
                        Settings
                    </span>
                </a>

                <!-- Spacer -->
                <div class="flex-1"></div>

                <!-- Subscription -->
                @if($user->verification_status === 'verified')
                    <a href="{{ route('subscription') }}"
                        @click.prevent="navigate('{{ route('subscription') }}', 'payment.subscription')" :class="[
                                (sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0',
                                isActive('subscription') ? 'text-black' : 'text-gray-500'
                            ]" class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                        <span :class="isActive('subscription') ? 'bg-[#16714B]' : 'bg-transparent group-hover:bg-[#16714B]'"
                            class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all"></span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            :class="isActive('subscription') ? 'text-[#16714B]' : 'text-gray-500 group-hover:text-[#16714B]'"
                            class="w-7 h-7 shrink-0 transition-all" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M2 8h20v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2z" />
                            <path d="M2 8l4-4h12l4 4" />
                            <path d="M12 12v4" />
                            <path d="M10 14h4" />
                        </svg>
                        <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                            :class="isActive('subscription') ? 'text-black' : 'group-hover:text-black'"
                            class="whitespace-nowrap transition-colors text-m">
                            Subscription
                        </span>
                    </a>
                @endif

                <!-- Logout -->
                <a href="#" onclick="event.preventDefault(); this.querySelector('form').submit();"
                    :class="(sidebarOpen || mobileSidebarOpen) ? 'justify-start' : 'lg:justify-center lg:px-0'"
                    class="group flex items-center gap-3 px-4 py-2 rounded relative transition font-bold">
                    <span
                        class="absolute left-0 top-0 h-full w-1.5 rounded-r transition-all group-hover:bg-[#16714B]"></span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 shrink-0 text-gray-500 group-hover:text-[#16714B] transition-all" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        viewBox="0 0 24 24">
                        <path d="m16 17 5-5-5-5" />
                        <path d="M21 12H9" />
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    </svg>
                    <span x-show="sidebarOpen || mobileSidebarOpen" x-transition
                        class="whitespace-nowrap transition-colors text-m text-gray-500 group-hover:text-black">
                        Logout
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </a>

            </nav>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-auto bg-white">

            <!-- Mobile Top Bar -->
            <div class="lg:hidden flex items-center justify-between px-4 border-b border-gray-200 bg-white sticky top-0 z-20">
                <button @click="mobileSidebarOpen = true" class="text-gray-600 hover:text-gray-900 p-1 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                        stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <img src="{{ asset('images/BloomChainText.png') }}" alt="Logo" class="w-32 object-contain">
            </div>

            <!-- Loading indicator -->
            <div id="nav-loading"
                class="hidden fixed top-0 left-0 right-0 h-0.5 bg-[#16714B] z-50 transition-all duration-300"
                style="width: 0%;">
            </div>

            <div id="main-content" class="max-w-8xl mx-auto py-6 px-4">
                @include('pages.dashboard.' . $page, [
                    'nurseries' => $nurseries ?? null,
                    'nursery' => $nursery ?? null,
                ])
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardApp', () => ({
                sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
                mobileSidebarOpen: false,
                currentPage: '{{ $page ?? 'profile' }}',
                loading: false,

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarOpen', this.sidebarOpen);
                },

                isActive(page) {
                    return this.currentPage === page;
                },

                navigate(url, page) {
                    if (this.loading) return;
                    this.loading = true;
                    this.mobileSidebarOpen = false;

                    // Show loading bar
                    const bar = document.getElementById('nav-loading');
                    bar.classList.remove('hidden');
                    bar.style.width = '60%';

                    fetch(url, {
                        headers: {
                            'X-Dashboard-Navigate': 'true',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                     })
                           .then(r => {
                            if (!r.ok) throw new Error('Navigation failed');
                            return r.text();
                      })
                         .then(html => {
                            const content = document.getElementById('main-content');
                            content.innerHTML = html;
                            this.currentPage = page;
                            window.history.pushState({ page, url }, '', url);
                        bar.    style.width = '100%';
                            setTimeout(() => {
                                bar.classList.add('hidden');
                                bar.style.width = '0%';
                            }, 300);
                      })
                          .catch(() => {
                            // Fallback to full page navigation on error
                            window.location.href = url;
                        })
                    .finally(() => {
                        this.loading = false;
                    });
                }
            }))
          })
  
        window.addEventListener('pageshow', function(e){
            if(e.persisted){
                window.location.reload();
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                    fetch(e.state.url, {
                        headers: { 'X-Dashboard-Navigate': 'true' }
                   })
                     .then(r => r.text())
                .then(html => {
                    document.getElementById('main-content').innerHTML = html;
                });
            }
        });
    </script>

</x-app-layout>