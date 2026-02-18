@php
    use Illuminate\Support\Facades\Auth;

    if (request()->isMethod('post')) {
        Auth::user()->update([
            'name' => request('name'),
            'email' => request('email'),
            'address' => request('address'),
        ]);

        session()->flash('success', 'Profile updated successfully!');
    }

    $user = Auth::user();
@endphp
<div class="text-center">
    <p class="text-green-800 text-2xl uppercase tracking-widest mb-2.5">
        Welcome Back!
    </p>

    @if(Auth::user()->avatar)
        <img src="{{ Auth::user()->avatar }}"
            class="w-30 h-30 rounded-full mx-auto mb-5 border-4 border-white-800 object-cover">
    @else
        <div class="w-30 h-30 rounded-full mx-auto mb-5 bg-green-800
                            flex items-center justify-center text-white text-5xl font-bold">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    @endif

    <h1 class="text-gray-800 mb-2.5 text-3xl font-semibold">
        {{ Auth::user()->name }}
    </h1>

    <p class="text-gray-500 mb-8 text-base">
        {{ Auth::user()->email }}
    </p>

    <div class="bg-gray-50 rounded-xl p-5 mb-5 text-left">
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Name:</span>
            <span>{{ Auth::user()->name }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Email:</span>
            <span>{{ Auth::user()->email }}</span>
        </div>
        <div class="flex justify-between mb-4 pb-4 border-b">
            <span class="font-semibold text-gray-600">Google ID:</span>
            <span>{{ Auth::user()->google_id ?? 'N/A' }}</span>
        </div>
        <div class="flex justify-between">
            <span class="font-semibold text-gray-600">Joined:</span>
            <span>{{ Auth::user()->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow mb-2">

        <h2 class="text-2xl font-bold mb-4">Edit Profile</h2>

        @if(session('success'))
            <div class="mb-4 text-green-600">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST">
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="mb-4">
                <label class="block mb-1">Address</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}"
                    class="w-full border rounded px-3 py-2">
            </div>

            <button class="bg-black text-white px-4 py-2 rounded">
                Save Changes
            </button>
        </form>
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="bg-gradient-to-r from-indigo-500 to-purple-600
                    text-white py-3 px-8 rounded-full">
            Logout
        </button>
    </form>
