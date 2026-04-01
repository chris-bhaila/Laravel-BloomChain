<div x-data="{ editing: false }" x-init="$watch('editing', val => {
    document.querySelector('.mobile-topbar').style.display = val ? 'none' : 'flex'
})">

    {{-- View mode --}}
    <div x-show="!editing">

        {{-- Avatar --}}
        <div class="flex flex-col items-center py-6 bg-gray-50">
            @if ($user->avatar)
                <img src="{{ $user->admin_avatar_url }}" class="w-20 h-20 rounded-full object-cover border-4 border-white shadow">
            @else
                <div
                    class="w-20 h-20 rounded-full bg-green-800 flex items-center justify-center text-white text-3xl font-bold shadow">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <h2 class="mt-3 text-xl font-bold text-gray-900">{{ $user->name }}</h2>
            <p class="text-sm text-gray-400">{{ $user->email }}</p>
            <div class="flex gap-2 mt-2">
                <span @class([
                    'text-xs px-3 py-1 rounded-full font-medium',
                    'bg-green-100 text-green-800' => $user->verification_status === 'verified',
                    'bg-red-100 text-red-600' => $user->verification_status === 'unverified',
                ])>
                    {{ ucfirst($user->verification_status) }}
                </span>
                <span @class([
                    'text-xs px-3 py-1 rounded-full font-medium',
                    'bg-yellow-100 text-yellow-700' => $user->subscription_type === 'premium',
                    'bg-purple-100 text-purple-700' => $user->subscription_type === 'admin',
                    'bg-gray-100 text-gray-600' => $user->subscription_type === 'general',
                ])>
                    {{ ucfirst($user->subscription_type) }}
                </span>
            </div>
        </div>

        {{-- Info --}}
        <div class="px-4 py-5 flex flex-col gap-3">
            <div class="bg-gray-50 rounded-xl p-4 flex flex-col gap-3">

                <div class="flex justify-between">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Phone</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $user->phone ?? 'Not set' }}</span>
                </div>

                <div class="flex justify-between border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Address</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $user->address ?? 'Not set' }}</span>
                </div>

                <div class="flex justify-between border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Google ID</span>
                    <span
                        class="text-sm font-semibold text-gray-900 truncate ml-4">{{ $user->google_id ?? 'N/A' }}</span>
                </div>

                <div class="flex justify-between border-t border-gray-100 pt-3">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Joined</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</span>
                </div>

                @if ($user->nursery)
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Nursery</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $user->nursery->name }}</span>
                    </div>
                @endif

            </div>

            {{-- Delete --}}
            <div class="mt-4 flex gap-3">
                @if ($user->id !== Auth::id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="w-1/2"
                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-50 text-red-600 font-semibold text-sm py-3 rounded-xl">
                            Delete user
                        </button>
                    </form>
                @endif

                <button @click="editing = true"
                    class="w-1/2 bg-green-800 text-white text-sm font-semibold py-3 rounded-xl">
                    Edit
                </button>
            </div>
        </div>
    </div>

    {{-- Edit mode --}}
    <div x-show="editing">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Fields --}}
            <div class="px-4 py-5 flex flex-col gap-4">

                {{-- Avatar --}}
                <div x-data="{ sizeError: false, cleared: false }">
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Avatar</label>
                    <label
                        class="relative block w-full h-32 bg-gray-100 rounded-xl flex flex-col items-center justify-center gap-2 cursor-pointer overflow-hidden border-2 border-gray-200"
                        :class="cleared ? 'opacity-40 pointer-events-none' : ''">
                        @if ($user->avatar)
                            <img src="{{ $user->admin_avatar_url }}" alt="Avatar"
                                class="absolute inset-0 w-full h-full object-cover opacity-60">
                        @endif
                        <svg class="w-6 h-6 text-gray-600 relative z-10" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                        </svg>
                        <span class="text-xs text-gray-600 relative z-10">Tap to change</span>
                        <input type="file" name="avatar" class="hidden" accept="image/*">
                    </label>
                    <input type="hidden" name="clear_avatar" :value="cleared ? '1' : '0'">
                    <p x-show="sizeError" class="text-red-500 text-xs mt-1">Image must be under 2MB.</p>
                    <button type="button" @click="cleared = !cleared"
                        :class="cleared ? 'bg-gray-100 text-gray-400' : 'bg-red-50 text-red-600'"
                        class="mt-2 w-full text-xs font-semibold py-2 rounded-xl">
                        <span x-text="cleared ? 'Undo clear' : 'Clear avatar'"></span>
                    </button>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Verification
                        Status</label>
                    <select name="verification_status"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="unverified" {{ old('verification_status', $user->verification_status) === 'unverified' ? 'selected' : '' }}>
                            Unverified</option>
                        <option value="verified" {{ old('verification_status', $user->verification_status) === 'verified' ? 'selected' : '' }}>
                            Verified</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Subscription
                        Type</label>
                    <select name="subscription_type"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="general" {{ old('subscription_type', $user->subscription_type) === 'general' ? 'selected' : '' }}>
                            General</option>
                        <option value="premium" {{ old('subscription_type', $user->subscription_type) === 'premium' ? 'selected' : '' }}>
                            Premium</option>
                        <option value="admin" {{ old('subscription_type', $user->subscription_type) === 'admin' ? 'selected' : '' }}>
                            Admin</option>
                    </select>
                </div>

                <div class="flex items-center px-4 py-3 gap-3 border-b border-gray-200">
                    <button type="button" @click="editing = false"
                        class="w-1/2 bg-gray-100 text-gray-600 text-sm font-semibold py-3 rounded-xl">
                        Cancel
                    </button>
                    <button type="submit" class="w-1/2 bg-green-800 text-white text-sm font-semibold py-3 rounded-xl">
                        Save
                    </button>
                </div>


            </div>
        </form>
    </div>
</div>