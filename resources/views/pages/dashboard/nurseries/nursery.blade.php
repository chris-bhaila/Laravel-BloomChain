<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">
                    {{ $nursery->name }} 🌱
                </h1>
                <p class="text-gray-600">
                    {{ $nursery->location ?? 'No location provided' }}
                </p>
            </div>

            {{-- Add Plant Button For Each Nursrey --}}
            <a href="{{ route('plants.create', $nursery->id) }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                + Add Plant
            </a>
        </div>

        {{-- Nursery Description --}}
        <div class="mb-8 text-gray-700">
            {{ $nursery->description ?? 'No description available.' }}
        </div>

        <h2 class="text-xl font-semibold mb-4">Available Plants</h2>

        @if($nursery->plants->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($nursery->plants as $plant)
                    <div class="bg-white shadow rounded-xl p-5">
                        <h3 class="text-lg font-semibold">
                            {{ $plant->name }}
                        </h3>

                        <p class="text-sm text-gray-600 mt-1">
                            {{ $plant->category ?? 'No type specified' }}
                        </p>

                        <p class="mt-3 text-gray-700 text-sm line-clamp-3">
                            {{ $plant->description ?? 'No description' }}
                        </p>

                        <div class="mt-4 text-sm text-gray-500">
                            Added on {{ $plant->created_at->format('d M Y') }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-gray-500 mt-10">
                No plants available in this nursery 🌵
            </div>
        @endif

    </div>
</x-app-layout>
