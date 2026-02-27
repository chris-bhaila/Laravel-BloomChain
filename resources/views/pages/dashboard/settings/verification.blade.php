<div class="bg-white p-4 flex flex-col rounded-xl shadow mb-2">
    <h2 class="text-2xl font-bold mb-4">Verify Your Account</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form action="{{ route('verify.store') }}" method="POST" class="flex flex-col gap-4">
        @csrf

        <div>
            <label class="font-semibold">Phone</label>
            <input type="text" name="phone" value="{{ old('phone') }}"
                class="w-full border-2 rounded-xl p-2 mt-1 @error('phone') border-red-500 @enderror"
                placeholder="+9779800000000" />
            @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="font-semibold">Address</label>
            <input type="text" name="address" value="{{ old('address') }}"
                class="w-full border-2 rounded-xl p-2 mt-1 @error('address') border-red-500 @enderror"
                placeholder="Kathmandu, Nepal" />
            @error('address') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
            class="bg-blue-500 text-white rounded-xl p-3 font-bold hover:bg-blue-600 transition duration-150">
            Verify Account
        </button>
    </form>
</div>