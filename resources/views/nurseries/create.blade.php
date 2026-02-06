<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold mb-6">Add Nursery 🌿</h1>

        <form method="POST" action="{{ route('nurseries.store') }}"
              class="bg-white shadow rounded-xl p-6 space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nursery Name</label>
                <input type="text" name="name"
                       class="w-full mt-1 rounded-lg border-gray-300"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium">Location</label>
                <input type="text" name="location"
                       class="w-full mt-1 rounded-lg border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium">Description</label>
                <textarea name="description" rows="4"
                          class="w-full mt-1 rounded-lg border-gray-300"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('nurseries.index') }}"
                   class="px-4 py-2 rounded-lg border">
                    Cancel
                </a>

                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Save Nursery
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
