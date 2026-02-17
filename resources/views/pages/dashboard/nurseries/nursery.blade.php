<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold">
            {{ $nursery->name }} 🌱
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">
            {{ $nursery->location ?? 'No location provided' }}
        </p>
    </div>

    <a href="{{ route('plants.create', $nursery->id) }}"
       class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base">
        + Add Plant
    </a>
</div>

{{-- Nursery Description --}}
<div class="mb-6 text-gray-700">
    {{ $nursery->description ?? 'No description available.' }}
</div>

{{-- Certificates — belong to the nursery, not individual plants --}}
<div class="mb-8">
    <h2 class="text-lg sm:text-xl font-semibold mb-3">Certificates</h2>
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="flex flex-col items-center">
            <p class="text-xs sm:text-sm text-gray-500 mb-1">Registration Certificate</p>
            <img src="{{ route('nursery.file', $nursery->reg_cer) }}"
                 alt="Registration Certificate"
                 class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded shadow">
        </div>
        <div class="flex flex-col items-center">
            <p class="text-xs sm:text-sm text-gray-500 mb-1">PAN Certificate</p>
            <img src="{{ route('nursery.file', $nursery->pan_cer) }}"
                 alt="PAN Certificate"
                 class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded shadow">
        </div>
    </div>
</div>


<h2 class="text-xl font-semibold mb-4">Available Plants</h2>

@if($nursery->plants->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($nursery->plants as $plant)
            <div class="bg-white shadow rounded-xl p-5 flex flex-col">
                
                <div class="flex justify-center mb-3">
                    <img src="{{ route('plants.file', $plant->image) }}"
                         alt="{{ $plant->name }}"
                         class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded">
                </div>

                <h3 class="text-lg font-semibold text-center sm:text-left">
                    {{ $plant->name }}
                </h3>

                <p class="text-sm text-gray-600 mt-1 text-center sm:text-left">
                    {{ $plant->category ?? 'No type specified' }}
                </p>

                <p class="mt-2 text-gray-700 text-sm line-clamp-3">
                    {{ $plant->description ?? 'No description' }}
                </p>

                <div class="mt-2 text-sm text-gray-500 text-center sm:text-left">
                    Added on {{ $plant->created_at->format('d M Y') }}
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="text-gray-500 mt-10 text-center">
        No plants available in this nursery 🌵
    </div>
@endif
