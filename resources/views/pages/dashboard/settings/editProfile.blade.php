@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

@if(session('success'))
    <div class="mb-4 text-green-600">
        {{ session('success') }}
    </div>
@endif

<h1 class="text-2xl font-bold ml-2 my-2">Edit Profile</h1>

<form method="POST" action="{{ route('editProfile.update') }}"
    class="fade-up bg-white shadow-lg rounded-xl p-6 space-y-5" enctype="multipart/form-data">
    @csrf

    {{-- Avatar --}}
    <div class="mb-4 text-center">

        @if ($user->avatar)
            <img src="{{ $user->avatar_url }}"
                class="fade-up w-30 h-30 rounded-full mx-auto mb-5 border-4 border-white-800 object-cover">
        @else
            <div class="w-30 h-30 rounded-full mx-auto mb-5 bg-green-800 fade-up
                                    flex items-center justify-center text-white text-5xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif

        <label for="avatar"
            class="inline-flex items-center gap-2 cursor-pointer px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm text-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0-8l-3 3m3-3l3 3" />
            </svg>
            <span id="avatar-name">Change Avatar</span>
        </label>
        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*"
            onchange="document.getElementById('avatar-name').textContent = this.files[0]?.name || 'Change Avatar'">

        @error('avatar')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Name --}}
    <div class="mb-4">
        <label class="block mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}"
            class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror">
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-4">
        <label class="block mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
            class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" readonly>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone Number --}}
    <div class="mb-4">
        <label class="block mb-1">Phone Number</label>
        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
            class="w-full border rounded px-3 py-2 @error('phone') border-red-500 @enderror">
        @error('phone')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Address --}}
    <div class="mb-4">
        <label class="block mb-1">Address</label>
        <input type="text" name="address" value="{{ old('address', $user->address) }}"
            class="w-full border rounded px-3 py-2 @error('address') border-red-500 @enderror">
        @error('address')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-black text-white px-4 py-2 rounded hover:bg-black/75 ease-in duration-100">
        Save Changes
    </button>

</form>