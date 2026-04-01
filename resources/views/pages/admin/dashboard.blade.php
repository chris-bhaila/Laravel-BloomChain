<div class="fade-up flex flex-col gap-4">

    {{-- Header --}}
    <div class="bg-gray-200 rounded-xl px-6 py-4">
        <p class="text-sm text-gray-500">Welcome back,</p>
        <h1 class="text-2xl font-bold text-gray-900">{{ Auth::user()->name }}</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-green-800 rounded-xl p-5">
            <p class="text-sm text-green-200 mb-1">Total Users</p>
            <p class="text-4xl font-bold text-white">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-sm text-gray-400 mb-1">Nurseries</p>
            <p class="text-4xl font-bold text-gray-900">{{ $totalNurseries }}</p>
        </div>
        <div class="col-span-2 bg-white border border-gray-200 rounded-xl p-5">
            <p class="text-sm text-gray-400 mb-1">Pending Verifications</p>
            <p class="text-4xl font-bold text-gray-900">{{ $pendingVerifications }}</p>
        </div>
    </div>

    {{-- Quick links --}}
    <div class="flex flex-col gap-3">
        <button @click="navigate('{{ route('admin.users') }}', 'users.index', 'Users')"
            class="w-full flex items-center justify-between bg-white border border-gray-200 rounded-xl px-5 py-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-[#16714B]" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                <span class="text-sm font-semibold text-gray-900">Manage Users</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
            </svg>
        </button>

        <button @click="navigate('{{ route('admin.nurseries') }}', 'nurseries.index', 'Nurseries')"
            class="w-full flex items-center justify-between bg-white border border-gray-200 rounded-xl px-5 py-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-[#16714B]" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 5a3 3 0 1 1 3 3m-3-3a3 3 0 1 0-3 3m3-3v1" />
                    <path d="M9 8a3 3 0 1 0 3 3M9 8h1m5 0a3 3 0 1 1-3 3m3-3h-1m-2 3v-1" />
                    <circle cx="12" cy="8" r="2" />
                    <path d="M12 10v12" />
                    <path d="M12 22c4.2 0 7-1.667 7-5-4.2 0-7 1.667-7 5Z" />
                    <path d="M12 22c-4.2 0-7-1.667-7-5 4.2 0 7 1.667 7 5Z" />
                </svg>
                <span class="text-sm font-semibold text-gray-900">Manage Nurseries</span>
            </div>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
            </svg>
        </button>
    </div>

</div>