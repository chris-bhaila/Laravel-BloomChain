@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $nursery = Auth::user()->nursery;
@endphp

<!--Profile verification-->
@if ($user->verification_status === 'unverified')
    <div
        class="fade-up mb-4 sm:mt-1 w-full flex flex-wrap items-center justify-between bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-xl px-6 py-4 shadow-sm gap-4">
        <div>
            <h2 class="text-gray-900 font-bold text-lg leading-snug">
                Verify Your Profile to Set Up Your Nursery
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                Complete your profile verification to create your nursery.
            </p>
        </div>
        <button type="button" onclick="window.location='{{ route('verify') }}'"
            class="flex-shrink-0 flex items-center gap-2 bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-sm font-semibold px-5 py-3 rounded-lg transition-colors duration-150 whitespace-nowrap w-full sm:w-auto justify-center">
            Verify your profile
            <span class="text-lg leading-none">→</span>
        </button>
    </div>
@elseif($nursery === null)
    <div
        class="fade-up mb-4 sm:mt-1 w-full flex flex-wrap items-center justify-between bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl px-6 py-4 shadow-sm gap-4">
        <div>
            <h2 class="text-gray-900 font-bold text-lg leading-snug">
                Create your nursery to get started.
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                You’ll be able to add plants, manage inventory, and track all your nursery activities.
            </p>
        </div>
        <button type="button" onclick="window.location='{{ route('nurseries.create') }}'"
            class="flex-shrink-0 flex items-center gap-2 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white text-sm font-semibold px-5 py-3 rounded-lg transition-colors duration-150 whitespace-nowrap w-full sm:w-auto justify-center">
            Create nursery
            <span class="text-lg leading-none">→</span>
        </button>
    </div>
@elseif($nursery->plants()->count() == 0)
    <div
        class="fade-up mb-4 sm:mt-1 w-full flex flex-wrap items-center justify-between bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-xl px-6 py-4 shadow-sm gap-4">
        <div>
            <h2 class="text-gray-900 font-bold text-lg leading-snug">
                Add first plant to your nursery
            </h2>
            <p class="text-gray-500 text-sm mt-1">
                You’ll be able to add plants, manage inventory, and track all your nursery activities.
            </p>
        </div>
        <button type="button" onclick="window.location='{{ route('plants.create', $nursery->id) }}'"
            class="flex-shrink-0 flex items-center gap-2 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white text-sm font-semibold px-5 py-3 rounded-lg transition-colors duration-150 whitespace-nowrap w-full sm:w-auto justify-center">
            Add your first plant
            <span class="text-lg leading-none">→</span>
        </button>
    </div>
@endif
<!--Header Bar-->
<div
    class="fade-up sm:mt-1 bg-gray-200 w-full flex flex-col sm:flex-row items-start sm:items-center justify-between rounded-xl px-6 py-4">

    {{-- Top on mobile: avatar + name/email --}}
    <div class="flex items-center gap-2 w-full sm:w-auto sm:order-2 justify-start mb-2 lg:mb-0">

        <!-- Avatar Wrapper -->
        <div class="relative">
            @if ($user->avatar)
                    <img src="{{ $user->avatar }}"
                        class="w-12 h-12 sm:w-16 sm:h-16 rounded-full object-cover border-2 lg:border-gray-300">
            @else
                <div
                    class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-green-800 text-white flex items-center justify-center text-lg font-bold border-2 border-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif

            {{-- Verification Badge --}}
            @if ($user->verification_status === 'unverified')
                <span class="absolute -bottom-0 -right-0 bg-red-600 rounded-full p-0.5 sm:p-1 shadow-md"
                    title="Unverified Account">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-white"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="m14.5 9.5-5 5" />
                        <path d="m9.5 9.5 5 5" />
                    </svg>
                </span>
            @elseif($user->verification_status === 'verified')
                <span class="absolute -bottom-0 -right-0 bg-green-600 rounded-full p-0.5 sm:p-1 shadow-md"
                    title="Verified Account">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-white"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
                        <path d="m9 12 2 2 4-4" />
                    </svg>
                </span>
            @endif
        </div>

        <!-- Name and Email -->
        <div class="min-w-0 truncate">
            <p class="text-gray-800 font-semibold truncate flex items-center gap-2">
                {{ $user->name }}
                @if ($user->subscription_type === 'premium')
                    <img width="20" height="20" class="mb-1 -ml-1"
                        src="https://img.icons8.com/ios-filled/50/FAB005/crown.png" alt="crown"
                        title="Premium Member" />
                @elseif($user->subscription_type === 'general')
                    <span class="bg-gray-400 rounded-md font-bold text-white px-2 text-xs -ml-1" title="General Member">
                        Free
                    </span>
                @endif
            </p>
            <p class="text-gray-500 text-sm truncate">{{ $user->email }}</p>
        </div>

    </div>

    {{-- Below on mobile: nursery name --}}
    <div class="mt-2 sm:mt-0 sm:order-1">
        @if ($nursery !== null)
            <h1 class="text-2xl lg:text-4xl font-bold">{{ $nursery->name }}</h1>
        @endif
    </div>

</div>

<!--Main Dashboard-->
<div class="fade-up delay-1 mt-4 bg-gray-200 w-full flex flex-col sm:flex-row justify-between rounded-xl py-4">
    <!-- Full Dashboard Container -->
    <div class="w-full px-4 md:mt-4">

        <!-- Dashboard Heading -->
        <div class="w-full mb-4">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>

        <!-- Dashboard Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="bg-green-800 rounded-xl shadow-lg p-6" style="box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 3px 0px;">
                <h2 class="text-xl mb-3 text-white">Plants</h2>
                <p class="text-white text-5xl sm:text-5xl lg:text-6xl">
                    @if ($nursery !== null)
                        @if ($nursery->plants()->count() > 0)
                            {{ $nursery->plants()->count() }}
                        @else
                            0
                        @endif
                    @else
                        0
                    @endif
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Nurseries</h2>
                <p class="text-gray-500">Total nurseries: 3</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Reviews</h2>
                <p class="text-gray-500">Average rating: 4.5</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-semibold mb-2">Reviews</h2>
                <p class="text-gray-500">Average rating: 4.5</p>
            </div>
        </div>

    </div>
</div>
