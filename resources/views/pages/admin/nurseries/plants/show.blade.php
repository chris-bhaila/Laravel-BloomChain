@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div x-data="{ editing: false }" x-init="$watch('editing', val => {
    document.querySelector('.mobile-topbar').style.display = val ? 'none' : 'flex'
})">

    {{-- View mode --}}
    <div x-show="!editing">

        {{-- Image --}}
        <div class="w-full h-52 bg-green-950 flex items-center justify-center overflow-hidden">
            @if ($plant->image)
                <img src="{{ asset('storage/plants/' . $plant->image) }}" alt="{{ $plant->name }}"
                    class="max-h-52 w-auto object-contain">
            @else
                <svg class="w-12 h-12 text-white opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            @endif
        </div>

        {{-- Content --}}
        <div class="px-4 py-5">

            {{-- Name, category, prices --}}
            <div class="flex justify-between items-start mb-2">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">{{ $plant->name }}</h2>
                    @if ($plant->scientific_name)
                        <p class="text-xs text-gray-400 italic mt-0.5">{{ $plant->scientific_name }}</p>
                    @endif
                    <span class="inline-block mt-1 text-xs bg-green-100 text-green-800 px-3 py-0.5 rounded-full">
                        {{ $plant->category ?? 'Uncategorized' }}
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 font-medium">Offer Price: <span
                            class="text-xl font-semibold text-green-800">Rs.
                            {{ number_format($plant->offer_price, 0) ?? '—' }}</span></p>
                    <p class="text-xs text-gray-400 font-medium">Selling Price: <span
                            class="text-xl font-semibold text-green-800">Rs.
                            {{ number_format($plant->selling_price, 0) ?? '—' }}</span></p>
                </div>
            </div>

            {{-- Description --}}
            @if ($plant->description)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Description</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $plant->description }}</p>
                </div>
            @endif

            {{-- Stats grid --}}
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Stock</p>
                    <p class="text-base font-semibold text-gray-900">{{ $plant->stock_quantity ?? '—' }} units</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Added</p>
                    <p class="text-base font-semibold text-gray-900">{{ $plant->created_at->format('d M Y') }}</p>
                </div>
                @if ($plant->best_season)
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Best Season</p>
                        <p class="text-base font-semibold text-gray-900">{{ ucfirst($plant->best_season) }}</p>
                    </div>
                @endif
                @if ($plant->location)
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Location</p>
                        <p class="text-base font-semibold text-gray-900">{{ ucfirst($plant->location) }}</p>
                    </div>
                @endif
                @if ($plant->sunlight_requirement)
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Sunlight</p>
                        <p class="text-base font-semibold text-gray-900">
                            {{ ucwords(str_replace('_', ' ', $plant->sunlight_requirement)) }}</p>
                    </div>
                @endif
                @if ($plant->water_requirement)
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-wide mb-1">Water</p>
                        <p class="text-base font-semibold text-gray-900">{{ ucfirst($plant->water_requirement) }}</p>
                    </div>
                @endif
            </div>

            {{-- Delete / Edit --}}
            <div class="mt-4 flex gap-3">
                <form action="{{ route('admin.nurseries.plants.destroy', [$nursery, $plant]) }}" method="POST"
                    class="w-1/2" onsubmit="return confirm('Are you sure you want to delete this plant?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-50 text-red-600 font-semibold text-sm py-3 rounded-xl">
                        Delete plant
                    </button>
                </form>
                <button type="button" @click="editing = true"
                    class="w-1/2 bg-green-800 text-white text-sm font-semibold py-3 rounded-xl">
                    Edit
                </button>
            </div>
        </div>
    </div>

    {{-- Edit mode --}}
    <div x-show="editing">
        <form action="{{ route('admin.nurseries.plants.update', [$nursery, $plant]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Image upload --}}
            <div x-data="{ sizeError: false }">
                <label
                    class="relative block w-full h-40 bg-green-900 flex flex-col items-center justify-center gap-2 cursor-pointer overflow-hidden">
                    @if ($plant->image)
                        <img src="{{ asset('storage/plants/' . $plant->image) }}" alt="{{ $plant->name }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-60">
                    @endif
                    <svg class="w-7 h-7 text-white opacity-50 relative z-10" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M17 8l-5-5-5 5M12 3v12" />
                    </svg>
                    <span class="text-xs text-white opacity-70 relative z-10">Tap to change image</span>
                    <input type="file" name="plant_image" class="hidden" accept="image/*"
                        @change="
                            const file = $event.target.files[0];
                            if (file && file.size > 2 * 1024 * 1024) {
                                sizeError = true;
                                $event.target.value = '';
                            } else {
                                sizeError = false;
                            }
                        ">
                </label>
                <p x-show="sizeError" class="text-red-500 text-xs mt-1">Image must be under 2MB.</p>
            </div>

            {{-- Fields --}}
            <div class="px-4 py-5 flex flex-col gap-4">

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name', $plant->name) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Scientific
                        Name</label>
                    <input type="text" name="scientific_name"
                        value="{{ old('scientific_name', $plant->scientific_name) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Category</label>
                    <select name="category"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="" disabled>-- Select Option --</option>
                        <option value="flowering"
                            {{ old('category', $plant->category) == 'flowering' ? 'selected' : '' }}>Flowering
                        </option>
                        <option value="succulents"
                            {{ old('category', $plant->category) == 'succulents' ? 'selected' : '' }}>Succulents
                        </option>
                        <option value="herbs"
                            {{ old('category', $plant->category) == 'herbs' ? 'selected' : '' }}>Herbs</option>
                        <option value="trees"
                            {{ old('category', $plant->category) == 'trees' ? 'selected' : '' }}>Trees</option>
                        <option value="aquatic"
                            {{ old('category', $plant->category) == 'aquatic' ? 'selected' : '' }}>Aquatic</option>
                        <option value="bonsai"
                            {{ old('category', $plant->category) == 'bonsai' ? 'selected' : '' }}>Bonsai</option>
                        <option value="foliage"
                            {{ old('category', $plant->category) == 'foliage' ? 'selected' : '' }}>Foliage</option>
                    </select>
                </div>

                <div>
                    <label
                        class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Location</label>
                    <select name="location"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="" disabled>-- Select Option --</option>
                        <option value="indoor" {{ old('location', $plant->location) == 'indoor' ? 'selected' : '' }}>
                            Indoor</option>
                        <option value="outdoor"
                            {{ old('location', $plant->location) == 'outdoor' ? 'selected' : '' }}>Outdoor</option>
                        <option value="both" {{ old('location', $plant->location) == 'both' ? 'selected' : '' }}>
                            Both</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Selling
                            Price (Rs.)</label>
                        <input type="number" name="selling_price"
                            value="{{ old('selling_price', intval($plant->selling_price)) }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                    </div>
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Offer Price
                            (Rs.)</label>
                        <input type="number" name="offer_price"
                            value="{{ old('offer_price', intval($plant->offer_price)) }}"
                            class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                    </div>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Stock
                        Quantity</label>
                    <input type="number" name="stock_quantity" min="0"
                        value="{{ old('stock_quantity', $plant->stock_quantity) }}"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Best
                        Season</label>
                    <select name="best_season"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="" disabled>-- Select Option --</option>
                        <option value="summer"
                            {{ old('best_season', $plant->best_season) == 'summer' ? 'selected' : '' }}>Summer</option>
                        <option value="autumn"
                            {{ old('best_season', $plant->best_season) == 'autumn' ? 'selected' : '' }}>Autumn</option>
                        <option value="winter"
                            {{ old('best_season', $plant->best_season) == 'winter' ? 'selected' : '' }}>Winter</option>
                        <option value="spring"
                            {{ old('best_season', $plant->best_season) == 'spring' ? 'selected' : '' }}>Spring</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Sunlight
                        Requirement</label>
                    <select name="sunlight_requirement"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="" disabled>-- Select Option --</option>
                        <option value="full_sun"
                            {{ old('sunlight_requirement', $plant->sunlight_requirement) == 'full_sun' ? 'selected' : '' }}>
                            Full Sun</option>
                        <option value="partial_shade"
                            {{ old('sunlight_requirement', $plant->sunlight_requirement) == 'partial_shade' ? 'selected' : '' }}>
                            Partial Shade</option>
                        <option value="full_shade"
                            {{ old('sunlight_requirement', $plant->sunlight_requirement) == 'full_shade' ? 'selected' : '' }}>
                            Full Shade</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Water
                        Requirement</label>
                    <select name="water_requirement"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                        <option value="" disabled>-- Select Option --</option>
                        <option value="low"
                            {{ old('water_requirement', $plant->water_requirement) == 'low' ? 'selected' : '' }}>
                            Low</option>
                        <option value="moderate"
                            {{ old('water_requirement', $plant->water_requirement) == 'moderate' ? 'selected' : '' }}>
                            Moderate</option>
                        <option value="high"
                            {{ old('water_requirement', $plant->water_requirement) == 'high' ? 'selected' : '' }}>
                            High</option>
                    </select>
                </div>

                <div>
                    <label
                        class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none resize-none">{{ old('description', $plant->description) }}</textarea>
                </div>

                <div class="flex items-center py-3 gap-3">
                    <button type="button" @click="editing = false"
                        class="w-1/2 bg-gray-100 text-gray-600 text-sm font-semibold py-3 rounded-xl">
                        Cancel
                    </button>
                    <button type="submit"
                        class="w-1/2 bg-green-800 text-white text-sm font-semibold py-3 rounded-xl">
                        Save
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        const topbar = document.querySelector('.mobile-topbar');
        if (topbar) topbar.style.display = 'flex';
    });
</script>
