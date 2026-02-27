@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
    $nursery = Auth::user()->nursery;
    $transaction = Auth::user()->transactions()->latest()->first();
@endphp
<div class="text-center lg:m-12">
    {{-- <p class="text-green-800 text-2xl uppercase tracking-widest mb-2.5">
        Welcome Back!
    </p> --}}

    @if ($user->avatar)
        <img src="{{ $user->avatar }}"
            class="fade-up w-30 h-30 rounded-full mx-auto mb-5 border-4 border-white-800 object-cover">
    @else
        <div class="w-30 h-30 rounded-full mx-auto mb-5 bg-green-800 fade-up
                                flex items-center justify-center text-white text-5xl font-bold">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    @endif

    <h1 class="fade-up delay-2 text-gray-800 mb-2.5 text-3xl font-semibold">
        {{ $user->name }}
    </h1>

    <p class="fade-up delay-3 text-gray-500 mb-8 text-base">
        {{ $user->email }}
    </p>

    <div class="fade-up delay-4 bg-gray-50 rounded-xl p-5 mb-5 text-left">
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Google ID:</span>
            <span>{{ $user->google_id ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Name:</span>
            <span>{{ $user->name }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Email:</span>
            <span>{{ $user->email }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Phone Number:</span>
            @if($user->phone)
                <span>{{ $user->phone }}</span>
            @else
                <span class="text-red-500">Not Set</span>
            @endif
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Joined:</span>
            <span>{{ $user->created_at->format('M d, Y') }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Verification status:</span>
            @if($user->verification_status === 'unverified')
                <span class="text-red-500">{{ ucfirst($user->verification_status) }}</span>
            @else
                <span>{{ ucfirst($user->verification_status) }}</span>
            @endif
        </div>
        @if ($nursery != null)
            <div class="flex justify-between mb-4 pb-4 border-b">
                <span class="font-semibold text-gray-600">Nursery name:</span>
                <span class="font-bold">{{ $nursery->name }}</span>
            </div>
        @endif
        <div class="flex justify-between">
            <span class="font-semibold text-gray-600">Subscription type:</span>
            <span class="flex items-center gap-1">
                {{ ucfirst($user->subscription_type) }}
                @if ($user->subscription_type === 'premium')
                            <img width="16" height="16" src="https://img.icons8.com/ios-filled/50/FAB005/crown.png" alt="crown"
                                title="Premium Member" class="mb-0.5 lg:-mb-0.5" />

                        </span>
                    </div>
                    <div class="flex justify-between mb-4 mt-4 pt-4 border-t pb-4 border-b">
                        <span class="font-semibold text-gray-600">Current plan (Recently purchased):</span>
                        <span>{{ $transaction ? ucwords($transaction->plan, '-') : 'General' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-semibold text-gray-600">Renewal date:</span>
                        <span>{{ $transaction ? $transaction->renewal_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                @endif
    </div>