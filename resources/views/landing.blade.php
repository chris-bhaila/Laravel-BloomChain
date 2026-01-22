<x-app-layout>
    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 w-screen h-screen flex justify-center items-center p-5">
        <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-lg w-full text-center">
            <p class="text-indigo-500 text-2xl uppercase tracking-widest mb-2.5">Welcome Back!</p>

            @if(Auth::user()->avatar)
                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-30 h-30 rounded-full mx-auto mb-5 border-4 border-indigo-500 object-cover">
            @else
                <div class="w-30 h-30 rounded-full mx-auto mb-5 bg-indigo-500 flex items-center justify-center text-white text-5xl font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif

            <h1 class="text-gray-800 mb-2.5 text-3xl font-semibold">{{ Auth::user()->name }}</h1>
            <p class="text-gray-500 mb-8 text-base">{{ Auth::user()->email }}</p>

            <div class="bg-gray-50 rounded-xl p-5 mb-5 text-left">
                <div class="flex justify-between mb-4 pb-4 border-b border-gray-200">
                    <span class="font-semibold text-gray-600">Name:</span>
                    <span class="text-gray-800">{{ Auth::user()->name }}</span>
                </div>
                <div class="flex justify-between mb-4 pb-4 border-b border-gray-200">
                    <span class="font-semibold text-gray-600">Email:</span>
                    <span class="text-gray-800">{{ Auth::user()->email }}</span>
                </div>
                <div class="flex justify-between mb-4 pb-4 border-b border-gray-200">
                    <span class="font-semibold text-gray-600">Google ID:</span>
                    <span class="text-gray-800">{{ Auth::user()->google_id ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-semibold text-gray-600">Joined:</span>
                    <span class="text-gray-800">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white border-0 py-3 px-8 rounded-full text-base cursor-pointer transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-indigo-500/40">
                    Logout
                </button>
            </form>
            <a href="{{ route('dashboard') }}">
                <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-500">
                    Dashboard
                </button>
            </a>
        </div>
    </div>
</x-app-layout>
