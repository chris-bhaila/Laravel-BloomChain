<div class="fade-up flex flex-col gap-4">

    {{-- Header --}}
    <div class="bg-gray-200 rounded-xl px-6 py-4">
        <h1 class="text-2xl font-bold text-gray-900">Nurseries</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $nurseries->count() }} total</p>
    </div>

    {{-- Nursery list --}}
    <div class="flex flex-col gap-3">
        @foreach ($nurseries as $nursery)
            <button @click="navigate('{{ route('admin.nurseries.show', $nursery) }}', 'nurseries.show', '{{ $nursery->name }}')"
                class="w-full flex items-center gap-4 bg-white border border-gray-200 rounded-xl px-4 py-3 text-left">

                {{-- Icon --}}
                <div class="w-11 h-11 rounded-full bg-green-800 flex items-center justify-center text-white font-bold flex-shrink-0">
                    {{ strtoupper(substr($nursery->name, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $nursery->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $nursery->user->name ?? 'No owner' }}</p>
                </div>

                {{-- Badges --}}
                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium bg-green-100 text-green-800">
                        {{ $nursery->plants->count() }} plants
                    </span>
                    <span @class([
                        'text-xs px-2 py-0.5 rounded-full font-medium',
                        'bg-green-100 text-green-800' => $nursery->is_active,
                        'bg-red-100 text-red-600' => !$nursery->is_active,
                    ])>
                        {{ $nursery->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                {{-- Arrow --}}
                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                </svg>

            </button>
        @endforeach
    </div>

</div>