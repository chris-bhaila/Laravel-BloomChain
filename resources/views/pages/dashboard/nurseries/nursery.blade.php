<div class="fade-up flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 px-6 pt-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold">
            {{ $nursery->name }} 🌱
        </h1>
        <p class="text-gray-600 text-sm sm:text-base">
            {{ $nursery->location ?? 'No location provided' }}
        </p>
    </div>

    <a href="{{ route('plants.create') }}" @click.prevent="
        @if (Auth::user()->subscription_type === 'general' && $nursery->plants()->count() >= 5) toastr.error('Upgrade to premium to add more plants.', 'Plant limit reached!');
        @else
        navigate('{{ route('plants.create') }}', 'nurseries.plants.create') @endif
    " class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm sm:text-base">
        Add Plant
    </a>
</div>

{{-- Nursery Description --}}
<div class="fade-up delay-1 mb-6 text-gray-700 px-6">
    {{ $nursery->description ?? 'No description available.' }}
</div>

{{-- Certificates — belong to the nursery, not individual plants --}}
<div class="fade-up delay-1 mb-8 px-6">
    <h2 class="text-lg sm:text-xl font-semibold mb-3">Certificates</h2>
    <div class="flex sm:flex-row gap-4 rounded-xl p-4 shadow-md">
        <div class="flex flex-col items-center">
            <p class="text-xs sm:text-sm text-gray-500 mb-1">Registration Certificate</p>
            <img src="{{ route('file.view', $nursery->reg_cer) }}" alt="Registration Certificate"
                class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded shadow">
        </div>
        <div class="flex flex-col items-center">
            <p class="text-xs sm:text-sm text-gray-500 mb-1">PAN Certificate</p>
            <img src="{{ route('file.view', $nursery->pan_cer) }}" alt="PAN Certificate"
                class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded shadow">
        </div>
    </div>
</div>


<h2 class="fade-up delay-3 text-xl font-semibold mb-4 px-6">Available Plants</h2>

@if ($nursery->plants->count())
    <div class="fade-up delay-3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6">
        @foreach ($nursery->plants as $plant)
            <div class="bg-white shadow rounded-xl p-5 flex flex-col">

                <div class="flex justify-center mb-3">
                    @if($plant->image)
                        <img src="{{ asset('storage/plants/' . $plant->image) }}" alt="{{ $plant->name }}"
                            class="w-32 h-32 object-cover rounded-lg">
                    @else
                        <div class="w-32 h-32 rounded-lg bg-gray-100 flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
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
    <div class="fade-up delay-3 text-gray-500 mt-10 text-center">
        No plants available in this nursery 🌵
    </div>
@endif