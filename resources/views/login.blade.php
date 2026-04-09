<x-app-layout>
    <div class="min-h-screen w-full overflow-y-auto hide-scrollbar bg-green-950 overflow-x-hidden" style="scrollbar-width: none;">

        {{-- Top banner + Login Panel combined --}}
        <div class="relative h-28 overflow-hidden">

            <div class="absolute inset-0 bg-cover bg-center"
                style="background-image: url('{{ asset('images/Login-bg-image.jpeg') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-green-950/30 to-green-950/85"></div>

            {{-- Login Panel pinned to top --}}
            <div class="absolute top-0 left-0 right-0 z-10 flex items-center px-4 justify-between">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/BloomChain.png') }}" alt="Logo" class="h-20 w-auto object-contain">
                </div>
                <a href="{{ route('google.redirect') }}"
                    class="flex items-center justify-center gap-3 px-3 py-2.5 bg-white border-[1.5px] border-green-100 text-green-900 rounded-full shadow-sm 
            hover:border-green-400 hover:shadow-green-400 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34-4.8-50H272v95.2h146.9c-6.3 34-25 62.9-53.1 82l85.7 66.6c50-46.1 78-114 78-193.8z" />
                        <path fill="#34A853" d="M272 544.3c71.7 0 132-23.8 176-64.6l-85.7-66.6c-23.8 16-54.2 25.5-90.3 25.5-69.3 0-128-46.9-149-110.1l-87.1 67.4c44 87.7 134.3 148.4 236.1 148.4z" />
                        <path fill="#FBBC05" d="M123 323.1c-10-29.4-10-61.4 0-90.8l-87.1-67.4c-38.3 76.7-38.3 167.8 0 244.5l87.1 67.3z" />
                        <path fill="#EA4335" d="M272 107.6c37.5 0 71 12.9 97.4 34.6l73-73C404 24 344.8 0 272 0 170.2 0 80 60.7 36 148.4l87.1 67.4c21-63.2 79.7-110.1 148.9-110.1z" />
                    </svg>
                    <span class="text-sm font-normal tracking-wide">Sign In</span>
                </a>
            </div>

            {{-- Tagline pinned to bottom --}}
            <div class="absolute bottom-0 left-0 right-0 z-10 px-5 pb-6">
                <div class="w-8 h-0.5 bg-gradient-to-r from-green-300 to-transparent rounded-full mb-2"></div>
                <h1 class="text-2xl font-light italic text-white leading-tight">
                    Where every plant tells a <span class="not-italic font-semibold text-green-300">story.</span>
                </h1>
            </div>

        </div>

        {{-- Nursery list --}}
        <div class="px-4 pt-4 pb-4 flex flex-col gap-5">
            <p class="text-lg font-bold tracking-[1px] uppercase text-green-400/50">Featured Nurseries</p>

            @foreach ($nurseries as $nursery)
            <div>
                @if ($nursery->plants->count())
                <p class="text-white font-semibold text-lg mb-2">{{ $nursery->name }}</p>
                @endif
                <div class="flex gap-3 overflow-x-auto pb-1"
                    style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
                    @foreach ($nursery->plants as $plant)
                    <div class="shrink-0 w-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden ring-1 ring-white/15">
                        <div class="h-48 bg-green-800/30">
                            @if ($plant->image)
                            <img src="{{ asset('storage/plants/' . $plant->image) }}"
                                alt="{{ $plant->name }}" loading="lazy" class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-green-300/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                        d="M12 22V12m0 0C12 7 8 4 4 5c0 4 2.5 7 8 7zm0 0c0-5 4-8 8-7-1 4-3 7-8 7" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="p-2">
                            <p class="text-white text-md font-semibold truncate">{{ $plant->name }}</p>
                            <p class="text-green-300/50 text-xs italic truncate mb-1">({{ $plant->scientific_name }})</p>
                            <div class="flex flex-wrap gap-1 mb-1">
                                @if ($plant->category)
                                <span class="text-xs bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ ucfirst($plant->category) }}</span>
                                @endif
                                @if ($plant->best_season)
                                <span class="text-xs bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ ucfirst($plant->best_season) }}</span>
                                @endif
                            </div>
                            <p class="text-green-300 text-sm font-semibold">
                                <span class="line-through">Rs. {{ number_format($plant->offer_price, 0) }}</span>
                                Rs. {{ number_format($plant->selling_price, 0) }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

    </div>
</x-app-layout>