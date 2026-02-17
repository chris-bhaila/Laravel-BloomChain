<div class="bg-white shadow-xl rounded-2xl p-8">

    <h1 class="text-2xl font-bold mb-6">
        Add Plant to {{ $nursery->name }} 🌱
    </h1>

    <form method="POST" action="{{ route('plants.store', $nursery->id) }}">
        @csrf

        {{-- Plant Name --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Plant Name *
            </label>
            <input type="text" name="name"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"
                required>
        </div>

        {{-- Scientific Name --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Scientific Name
            </label>
            <input type="text" name="scientific_name"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>

        {{-- Category --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Category
            </label>
            <input type="text" name="category" placeholder="Indoor / Outdoor / Flowering / etc."
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>

        {{-- Price & Stock --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Price
                </label>
                <input type="number" step="0.01" name="price"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Stock Quantity
                </label>
                <input type="number" name="stock_quantity" min="0"
                    class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Description
            </label>
            <textarea name="description" rows="4"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
        </div>

        {{-- Sunlight Requirement --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Sunlight Requirement
            </label>
            <input type="text" name="sunlight_requirement" placeholder="Full Sun / Partial Shade / Low Light"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>

        {{-- Water Requirement --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Water Requirement
            </label>
            <input type="text" name="water_requirement" placeholder="Daily / Weekly / Moderate"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500 focus:outline-none">
        </div>

        {{-- Buttons --}}
        <div class="flex justify-end gap-4">
            <a href="{{ route('nursery.show', $nursery->id) }}"
                class="px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                Cancel
            </a>

            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Save Plant
            </button>
        </div>

    </form>

</div>
