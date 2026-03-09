<div class="bg-white shadow-xl rounded-2xl p-8">

    <h1 class="fade-up text-2xl font-bold mb-6">
        Add Plant to {{ $nursery->name }} 🌱
    </h1>

    <form method="POST" action="{{ route('plants.store') }}" enctype="multipart/form-data" class="fade-up delay-1">
        @csrf

        {{-- Plant Name --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Plant Name *
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('name') border-red-500 @enderror"
                required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Scientific Name --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Scientific Name *
            </label>
            <input type="text" name="scientific_name" value="{{ old('scientific_name') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('scientific_name') border-red-500 @enderror"
                required>
            @error('scientific_name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Location --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Location
            </label>
            <select name="location"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('location') border-red-500 @enderror">
                <option value="" disabled selected>-- Select Option --</option>
                <option value="indoor" {{ old('location') == 'indoor' ? 'selected' : '' }}>Indoor</option>
                <option value="outdoor" {{ old('location') == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                <option value="both" {{ old('location') == 'both' ? 'selected' : '' }}>Both</option>
            </select>
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category
            </label>
            <select name="category"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('category') border-red-500 @enderror">
                <option value="" disabled selected>-- Select Option --</option>
                <option value="flowering" {{ old('category') == 'flowering' ? 'selected' : '' }}>Flowering</option>
                <option value="succulents" {{ old('category') == 'succulents' ? 'selected' : '' }}>Succulents</option>
                <option value="herbs" {{ old('category') == 'herbs' ? 'selected' : '' }}>Herbs</option>
                <option value="trees" {{ old('category') == 'trees' ? 'selected' : '' }}>Trees</option>
                <option value="aquatic" {{ old('category') == 'aquatic' ? 'selected' : '' }}>Aquatic</option>
                <option value="bonsai" {{ old('category') == 'bonsai' ? 'selected' : '' }}>Bonsai</option>
                <option value="foliage" {{ old('category') == 'foliage' ? 'selected' : '' }}>Foliage</option>
            </select>
            @error('category')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Price --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Offer Price *
                </label>
                <input type="number" step="0.01" name="offer_price" value="{{ old('offer_price') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('offer_price') border-red-500 @enderror"
                    required>
                @error('offer_price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Selling Price *
                </label>
                <input type="number" step="0.01" name="selling_price" value="{{ old('selling_price') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('selling_price') border-red-500 @enderror"
                    required>
                @error('selling_price')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Stock Quantity --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Stock Quantity *
            </label>
            <input type="number" name="stock_quantity" min="0" value="{{ old('stock_quantity') }}"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('stock_quantity') border-red-500 @enderror"
                required>
            @error('stock_quantity')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Best Season --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Best Season
            </label>
            <select name="best_season"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('best_season') border-red-500 @enderror">
                <option value="" disabled selected>-- Select Option --</option>
                <option value="summer" {{ old('best_season') == 'summer' ? 'selected' : '' }}>Summer</option>
                <option value="autumn" {{ old('best_season') == 'autumn' ? 'selected' : '' }}>Autumn</option>
                <option value="winter" {{ old('best_season') == 'winter' ? 'selected' : '' }}>Winter</option>
                <option value="spring" {{ old('best_season') == 'spring' ? 'selected' : '' }}>Spring</option>
            </select>
            @error('best_season')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea name="description" rows="4"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Sunlight Requirement --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Sunlight Requirement
            </label>
            <select name="sunlight_requirement"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('sunlight_requirement') border-red-500 @enderror">
                <option value="" disabled selected>-- Select Option --</option>
                <option value="full_sun" {{ old('sunlight_requirement') == 'full_sun' ? 'selected' : '' }}>Full Sun
                </option>
                <option value="partial_shade" {{ old('sunlight_requirement') == 'partial_shade' ? 'selected' : '' }}>
                    Partial Shade</option>
                <option value="full_shade" {{ old('sunlight_requirement') == 'full_shade' ? 'selected' : '' }}>Full Shade
                </option>
            </select>
            @error('sunlight_requirement')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Water Requirement --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Water Requirement
            </label>
            <select name="water_requirement"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none @error('water_requirement') border-red-500 @enderror">
                <option value="" disabled selected>-- Select Option --</option>
                <option value="low" {{ old('water_requirement') == 'low' ? 'selected' : '' }}>Low</option>
                <option value="moderate" {{ old('water_requirement') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                <option value="high" {{ old('water_requirement') == 'high' ? 'selected' : '' }}>High</option>
            </select>
            @error('water_requirement')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Plant Image --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Plant Image
            </label>
            <label for="plant_image"
                class="flex items-center justify-between w-full border rounded-lg px-4 py-2 text-sm text-gray-700 cursor-pointer
                    hover:bg-gray-100 focus:ring-2 focus:ring-green-500 focus:outline-none @error('plant_image') border-red-500 @enderror">
                <span id="plant-image-name">Choose file</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v8m0-8l-3 3m3-3l3 3" />
                </svg>
            </label>
            <input type="file" name="plant_image" id="plant_image" class="hidden"
                onchange="document.getElementById('plant-image-name').textContent = this.files[0]?.name || 'Choose file'">
            @error('plant_image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('nursery.show') }}" class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Save Plant
            </button>
        </div>

    </form>

</div>