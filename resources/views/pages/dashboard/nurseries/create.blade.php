<h1 class="text-2xl font-bold mb-6">Add Nursery 🌿</h1>

<form method="POST" action="{{ route('dashboard.nurseries.store') }}" class="bg-white shadow rounded-xl p-6 space-y-5" enctype="multipart/form-data">
    @csrf

    {{-- Nursery Name --}}
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
            Nursery Name
        </label>
        <input type="text" name="name" id="name" value="{{ old('name') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('name') border-red-500 @enderror"
            required>
        @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Phone Number --}}
    <div class="mb-4">
        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
            Phone Number
        </label>
        <input type="number" name="phone" id="phone" value="{{ old('phone') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none no-spinner @error('phone') border-red-500 @enderror"
            required>
        @error('phone')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nursery Email --}}
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
            Nursery Email
        </label>
        <input type="email" name="email" id="email" value="{{ old('email') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('email') border-red-500 @enderror"
            required>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Location --}}
    <div class="mb-4">
        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
            Location
        </label>
        <input type="text" name="location" id="location" value="{{ old('location') }}"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('location') border-red-500 @enderror">
        @error('location')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Registration Certificate --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Registration Certificate
        </label>
        <label for="reg-cer"
            class="flex items-center justify-between w-full border rounded-lg px-4 py-2 text-sm text-gray-700 cursor-pointer
                hover:bg-gray-100 focus:ring-2 focus:ring-green-500 focus:outline-none @error('reg-cer') border-red-500 @enderror">
            <span id="reg-cer-name">Choose file</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0-8l-3 3m3-3l3 3"/>
            </svg>
        </label>
        <input type="file" name="reg-cer" id="reg-cer" class="hidden"
            onchange="document.getElementById('reg-cer-name').textContent = this.files[0]?.name || 'Choose file'">
        @error('reg-cer')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- PAN Certificate --}}
    <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">
            PAN Certificate
        </label>
        <label for="pan-cer"
            class="flex items-center justify-between w-full border rounded-lg px-4 py-2 text-sm text-gray-700 cursor-pointer
                hover:bg-gray-100 focus:ring-2 focus:ring-green-500 focus:outline-none @error('pan-cer') border-red-500 @enderror">
            <span id="pan-cer-name">Choose file</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0-8l-3 3m3-3l3 3"/>
            </svg>
        </label>
        <input type="file" name="pan-cer" id="pan-cer" class="hidden"
            onchange="document.getElementById('pan-cer-name').textContent = this.files[0]?.name || 'Choose file'">
        @error('pan-cer')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    {{-- Description --}}
    <div class="mb-4">
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
            Description
        </label>
        <textarea name="description" id="description" rows="4"
            class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
        @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('nursery.show') }}"
            class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            Cancel
        </a>
        <button type="submit"
            class="px-4 py-2 bg-green-500 text-white rounded border border-green-500
                hover:bg-white hover:text-green-500 transition duration-300
                focus:ring-2 focus:ring-green-500 focus:outline-none">
            Add Nursery
        </button>
    </div>

</form>