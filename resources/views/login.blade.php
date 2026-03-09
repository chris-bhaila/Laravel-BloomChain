<x-app-layout>
    <div class="min-h-screen w-screen flex items-center justify-center relative overflow-hidden py-6 px-4">

        {{-- Blurred background --}}
        <div class="absolute inset-0 bg-cover bg-center scale-110 blur-sm"
            style="background-image: url('{{ asset('images/Login-bg-image.jpeg') }}');"></div>

        {{-- Dark overlay --}}
        <div class="absolute inset-0 bg-green-950/40"></div>

        {{-- Main card --}}
        <div class="relative z-10 w-[92%] md:w-[85%] h-[85vh] md:h-[80vh] flex flex-col-reverse md:flex-row rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10">

            {{-- ===================== --}}
            {{-- DESKTOP: Left Panel  --}}
            {{-- ===================== --}}
            <div class="hidden md:flex md:w-2/3 relative overflow-hidden flex-col bg-green-950">
                {{-- Faint bg image --}}
                <div class="absolute inset-0 bg-cover bg-center opacity-20"
                    style="background-image: url('{{ asset('images/Login-bg-image.jpeg') }}');"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-green-950/90 via-green-900/70 to-green-950/90"></div>

                {{-- Header --}}
                <div class="relative z-10 px-8 pt-8 pb-3 shrink-0">
                    <div class="w-10 h-0.5 bg-gradient-to-r from-green-300 to-transparent rounded-full mb-4"></div>
                    <h1 class="text-4xl font-light italic text-white/95 leading-tight tracking-tight">
                        Where every plant<br>tells a <span class="not-italic font-semibold text-green-300">story.</span>
                    </h1>
                    <p class="mt-2 text-[10px] font-light tracking-[3px] uppercase text-white/40">Nursery Management Platform</p>
                </div>

                {{-- Divider --}}
                <div class="relative z-10 mx-8 my-3 h-px bg-gradient-to-r from-white/10 via-white/5 to-transparent shrink-0"></div>

                {{-- Nursery list --}}
                <div class="relative z-10 flex-1 overflow-y-auto px-8 pb-8 flex flex-col gap-6">
                    <p class="text-[10px] font-light tracking-[2px] uppercase text-green-400/50">Featured Nurseries</p>

                    @foreach($nurseries as $nursery)
                        <div>
                            {{-- Nursery name --}}
                            <p class="text-white font-semibold text-base mb-2">{{ $nursery->name }}</p>

                            {{-- Horizontal plant strip --}}
                            <div class="flex gap-3 overflow-x-auto pb-1"
                                 style="scrollbar-width: none; -ms-overflow-style: none;">
                                @foreach($nursery->plants as $plant)
                                    <div class="shrink-0 w-40 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden ring-1 ring-white/15 hover:ring-green-300/40 hover:bg-white/15 transition-all duration-300 cursor-pointer">
                                        {{-- Image --}}
                                        <div class="h-28 bg-green-800/30">
                                            @if($plant->image)
                                                <img src="{{ asset('storage/plants/' . $plant->image) }}"
                                                     alt="{{ $plant->name }}"
                                                     loading="lazy"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center gap-1 text-green-300/50">
                                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                                            d="M12 22V12m0 0C12 7 8 4 4 5c0 4 2.5 7 8 7zm0 0c0-5 4-8 8-7-1 4-3 7-8 7" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Info --}}
                                        <div class="p-2.5">
                                            <p class="text-white text-[12px] font-semibold truncate">{{ $plant->name }}</p>
                                            <p class="text-green-300/50 text-[10px] italic truncate mb-1.5">({{ $plant->scientific_name }})</p>
                                            <div class="flex flex-wrap gap-1 mb-1.5">
                                                @if($plant->location)
                                                    <span class="text-[9px] bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->location }}</span>
                                                @endif
                                                @if($plant->category)
                                                    <span class="text-[9px] bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->category }}</span>
                                                @endif
                                                @if($plant->best_season)
                                                    <span class="text-[9px] bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->best_season }}</span>
                                                @endif
                                            </div>
                                            <p class="text-green-300 text-[12px] font-semibold">Rs. {{ $plant->offer_price }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ========================= --}}
            {{-- MOBILE: Stacked layout   --}}
            {{-- ========================= --}}
            <div class="md:hidden flex flex-col w-full">

                {{-- Top banner --}}
                <div class="relative overflow-hidden h-20 shrink-0">
                    <div class="absolute inset-0 bg-cover bg-center"
                        style="background-image: url('{{ asset('images/Login-bg-image.jpeg') }}');"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-green-950/30 to-green-950/85"></div>
                    <div class="relative z-10 h-full flex flex-col justify-start p-5">
                        <div class="w-8 h-0.5 bg-gradient-to-r from-green-300 to-transparent rounded-full mb-2"></div>
                        <h1 class="text-xl font-light italic text-white/95 leading-tight">
                            Where every plant tells a <span class="not-italic font-semibold text-green-300">story.</span>
                        </h1>
                    </div>
                </div>

                {{-- Mobile nursery list --}}
                <div class="bg-green-950 px-4 pt-4 pb-4 shrink-0 max-h-[28rem] overflow-y-auto flex flex-col gap-5">
                    <p class="text-[10px] font-light tracking-[2px] uppercase text-green-400/50">Featured Nurseries</p>

                    @foreach($nurseries as $nursery)
                        <div>
                            {{-- Nursery name --}}
                            <p class="text-white font-semibold text-sm mb-2">{{ $nursery->name }}</p>

                            {{-- Horizontal plant strip --}}
                            <div class="flex gap-3 overflow-x-auto pb-1"
                                 style="-webkit-overflow-scrolling: touch; scrollbar-width: none; -ms-overflow-style: none;">
                                @foreach($nursery->plants as $plant)
                                    <div class="shrink-0 w-64 bg-white/10 backdrop-blur-sm rounded-2xl overflow-hidden ring-1 ring-white/15">
                                        {{-- Image --}}
                                        <div class="h-48 bg-green-800/30">
                                            @if($plant->image)
                                                <img src="{{ asset('storage/plants/' . $plant->image) }}"
                                                     alt="{{ $plant->name }}"
                                                     loading="lazy"
                                                     class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-green-300/50">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2"
                                                            d="M12 22V12m0 0C12 7 8 4 4 5c0 4 2.5 7 8 7zm0 0c0-5 4-8 8-7-1 4-3 7-8 7" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        {{-- Info --}}
                                        <div class="p-2">
                                            <p class="text-white text-md font-semibold truncate">{{ $plant->name }}</p>
                                            <p class="text-green-300/50 text-xs italic truncate mb-1">({{ $plant->scientific_name }})</p>
                                            <div class="flex flex-wrap gap-1 mb-1">
                                                @if($plant->location)
                                                    <span class="text-xs bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->location }}</span>
                                                @endif
                                                @if($plant->category)
                                                    <span class="text-xs bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->category }}</span>
                                                @endif
                                                @if($plant->best_season)
                                                    <span class="text-xs bg-green-900/50 text-green-300 rounded-full px-1.5 py-0.5">{{ $plant->best_season }}</span>
                                                @endif
                                            </div>
                                            <p class="text-green-300 text-sm font-semibold">Rs. {{ $plant->offer_price }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- ===================== --}}
            {{-- RIGHT: Login Panel   --}}
            {{-- ===================== --}}
            <div class="w-full md:w-1/3 flex-1 relative flex flex-col items-center justify-center px-8 py-6 md:px-10 md:py-12 bg-white/95">

                {{-- Top accent line --}}
                <div class="absolute top-0 left-0 right-0 h-[3px] bg-gradient-to-r from-green-500 via-green-300 to-green-500"></div>

                {{-- Logo --}}
                <div class="relative z-10 flex flex-col items-center md:mb-8">
                    <img src="{{ asset('images/BloomChain.png') }}" alt="Logo" class="h-28 md:h-40 w-auto object-contain">
                </div>

                {{-- Google button --}}
                <a href="{{ route('google.redirect') }}"
                    class="relative z-10 flex items-center justify-center gap-3 -mt-4 w-full px-3 py-2.5 bg-white border-[1.5px] border-green-100 text-green-900 rounded-full shadow-sm hover:border-green-400 hover:shadow-green-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 533.5 544.3" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#4285F4" d="M533.5 278.4c0-17.4-1.6-34-4.8-50H272v95.2h146.9c-6.3 34-25 62.9-53.1 82l85.7 66.6c50-46.1 78-114 78-193.8z"/>
                        <path fill="#34A853" d="M272 544.3c71.7 0 132-23.8 176-64.6l-85.7-66.6c-23.8 16-54.2 25.5-90.3 25.5-69.3 0-128-46.9-149-110.1l-87.1 67.4c44 87.7 134.3 148.4 236.1 148.4z"/>
                        <path fill="#FBBC05" d="M123 323.1c-10-29.4-10-61.4 0-90.8l-87.1-67.4c-38.3 76.7-38.3 167.8 0 244.5l87.1 67.3z"/>
                        <path fill="#EA4335" d="M272 107.6c37.5 0 71 12.9 97.4 34.6l73-73C404 24 344.8 0 272 0 170.2 0 80 60.7 36 148.4l87.1 67.4c21-63.2 79.7-110.1 148.9-110.1z"/>
                    </svg>
                    <span class="text-sm font-normal tracking-wide">Continue with Google</span>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>