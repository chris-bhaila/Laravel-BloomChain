<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">My Nurseries 🌱</h1>

            <a href="{{ route('dashboard.nurseries', ['page' => 'create']) }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                + Add Nursery
            </a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($nurseries->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($nurseries as $nursery)
                    <a href="{{ route('nursery.show', $nursery->id) }}"
                        class="bg-white shadow rounded-xl p-5 hover:shadow-[0_6px_25px_rgba(0,0,0,0.5)] transition-shadow duration-300">
                        <h2 class="text-lg font-semibold">{{ $nursery->name }}</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ $nursery->location ?? 'No location' }}
                        </p>

                        <p class="mt-3 text-gray-700 text-sm line-clamp-3">
                            {{ $nursery->description ?? 'No description' }}
                        </p>

                        <div class="mt-4 flex justify-between text-sm text-gray-500">
                            <span>Plants: {{ $nursery->plants_count ?? '0' }}</span>
                            <span>{{ $nursery->created_at->format('d M Y') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-500 mt-20">
                No nurseries yet 🌵<br>
                Add your first one!
            </div>
        @endif

    </div>
</x-app-layout>
