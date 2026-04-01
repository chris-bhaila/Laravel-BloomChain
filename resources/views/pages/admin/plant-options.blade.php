<div class="fade-up flex flex-col gap-4">

    {{-- Header --}}
    <div class="bg-gray-200 rounded-xl px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-900">Plant Options</h1>
        <p class="text-sm text-gray-500 mt-1">Manage available options for plant fields</p>
    </div>

    {{-- Add new option --}}
    <div class="bg-white border border-gray-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-gray-900 mb-3">Add new option</p>
        <form action="{{ route('admin.plant-options.store') }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <div>
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Type</label>
                <select name="type"
                    class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none cursor-pointer">
                    <option value="" disabled selected>-- Select Type --</option>
                    <option value="category"             {{ old('type') == 'category'             ? 'selected' : '' }}>Category</option>
                    <option value="best_season"          {{ old('type') == 'best_season'          ? 'selected' : '' }}>Best Season</option>
                    <option value="location"             {{ old('type') == 'location'             ? 'selected' : '' }}>Location</option>
                    <option value="sunlight_requirement" {{ old('type') == 'sunlight_requirement' ? 'selected' : '' }}>Sunlight Requirement</option>
                    <option value="water_requirement"    {{ old('type') == 'water_requirement'    ? 'selected' : '' }}>Water Requirement</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-medium text-gray-500 uppercase tracking-wide block mb-1">Value</label>
                <input type="text" name="value" value="{{ old('value') }}" placeholder="e.g. tropical"
                    class="w-full border-2 border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:border-green-700 outline-none">
                <p class="text-xs text-gray-400 mt-1">Spaces will be converted to underscores automatically.</p>
            </div>
            <button type="submit"
                class="w-full bg-green-800 text-white text-sm font-semibold py-3 rounded-xl">
                Add Option
            </button>
        </form>
    </div>

    {{-- Options list grouped by type --}}
    @foreach ([
        'category'             => 'Category',
        'best_season'          => 'Best Season',
        'location'             => 'Location',
        'sunlight_requirement' => 'Sunlight Requirement',
        'water_requirement'    => 'Water Requirement',
    ] as $type => $label)
        <div class="bg-white border border-gray-200 rounded-xl p-4">
            <p class="text-sm font-semibold text-gray-900 mb-3">{{ $label }}</p>
            @if ($options->get($type)?->count())
                <div class="flex flex-col gap-2">
                    @foreach ($options->get($type) as $option)
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-2.5">
                            <span class="text-sm text-gray-900">
                                {{ ucwords(str_replace('_', ' ', $option->value)) }}
                            </span>
                            <form action="{{ route('admin.plant-options.destroy', $option) }}" method="POST"
                                onsubmit="return confirm('Delete this option?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs font-semibold">Delete</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-xs text-gray-400">No options yet.</p>
            @endif
        </div>
    @endforeach

</div>