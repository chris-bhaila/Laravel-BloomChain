<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold mb-6">Add Nursery 🌿</h1>

        <form method="POST" action="{{ route('dashboard.nurseries.store') }}"
            class="bg-white shadow rounded-xl p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block font-medium">Nursery Name</label>
                <input type="text" name="name" id="name"
                    class="w-full mt-1 rounded-lg border-gray-300 p-2" required>
            </div>

            <div>
                <label for="phone" class="block font-medium">Phone Number</label>
                <input type="number" name="phone" id="phone"
                    class="w-full mt-1 rounded-lg border-gray-300 no-spinner p-2" required>
            </div>

            <div>
                <label for="email" class="block font-medium">Nursery Email</label>
                <input type="text" name="email" id="email"
                    class="w-full mt-1 rounded-lg border-gray-300 p-2" required>
            </div>

            <div>
                <label for="location" class="block font-medium">Location</label>
                <input type="text" name="location" id="location"
                    class="w-full mt-1 rounded-lg border-gray-300 p-2">
            </div>

            <div>
                <label for="description" class="block font-medium">Description</label>
                <textarea name="description" id="description" rows="4"
                        class="w-full mt-1 rounded-lg border-gray-300 p-2"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('dashboard.nurseries', ['page' => 'index']) }}"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 p-2">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Add Nursery
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
