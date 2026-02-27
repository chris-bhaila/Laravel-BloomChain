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

<form method="POST" action="{{ route('editProfile.update') }}" class="fade-up bg-white shadow rounded-xl p-6 space-y-5">
    @csrf

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

    <button class="bg-black text-white px-4 py-2 rounded">
        Save Changes
    </button>

</form>