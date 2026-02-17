<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SK Shoes - Premium Footwear Store</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
        <style>
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            /* Swiper mobile optimization */
            .swiper-container {
                width: 100%;
                height: 100%;
            }

            @media (max-width: 768px) {
                .swiper-slide {
                    width: 100% !important;
                }

                .swiper-pagination {
                    transform: translateX(-50%);
                    left: 50% !important;
                }
            }
        </style>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Security & CSRF Protection -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <meta name="title" content="SK Shoes - Premium Footwear Store">
    <meta name="description" content="Discover premium handmade shoes at SK Shoes. Quality footwear for lasting impressions. Explore our collection now!">
    <meta name="keywords" content="premium shoes, handmade footwear, SK Shoes, quality shoes, stylish shoes, shoes, premium footwear, SK Shoes, latest products, buy shoes online, stylish shoes, comfortable shoes, shoe collection, footwear for every occasion 
        @if(isset($latests))
            @foreach ($latests as $latest) {{ $latest->shoe_name }}, {{ $latest->category_name }}{{ !$loop->last ? ', ' : '' }} @endforeach
        @endif">
    <meta name="author" content="SK Shoes">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph (OG) Meta Tags - For Facebook & LinkedIn -->
    <meta property="og:title" content="SK Shoes - Premium Footwear Store">
    <meta property="og:description" content="Explore our collection of premium handmade shoes that combine style, quality, and comfort.">
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="SK Shoes">
    <meta property="og:locale" content="en_US">

    <!-- Apple (iOS) Meta Tags -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    <link rel="mask-icon" href="{{ asset('assets/images/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <!-- Android & Chrome Meta Tags -->
    <meta name="theme-color" content="#ffffff">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="manifest" href="/manifest.json">

    <!-- Structured Data (Google Rich Snippets) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "SK Shoes",
        "url": "https://skshoes.com",
        "logo": "{{ asset('assets/images/logo.png') }}",
        "description": "Premium handmade shoes with style, comfort, and quality.",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+977-123456789",
            "contactType": "customer service"
        },
        "sameAs": [
            "https://www.facebook.com/SKShoes",
            "https://www.instagram.com/SKShoes"
        ]
    }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon.png') }}">

 
</head>

<body class="bg-gray-100">
    <!-- Include the header component -->
    <x-header />

    <!-- Hero Section -->
    <section class="bg-[url('{{ asset('assets/images/background.png') }}')] py-8 md:py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col-reverse md:flex-row items-center justify-between gap-6 md:gap-8">
                <!-- Text Content - Adjust spacing and text size for mobile -->
                <div class="w-full md:w-1/2 text-center md:text-left pl-2 md:pl-3 lg:pl-4 pr-3 md:pr-4 lg:pr-6">
                    <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-[#49280d]">Quality Footwear, Lasting Impression</h1>
                    <p class="text-sm md:text-base text-gray-900 mt-3 md:mt-4 max-w-xl pl-4">
                        Discover our premium handmade shoes crafted with care for:
                    </p>
                    <ul class="list-disc list-inside text-sm md:text-base text-gray-900 mt-2 space-y-1 pl-4">
                        <li>Timeless style</li>
                        <li>Exceptional quality</li>
                        <li>Lasting comfort</li>
                    </ul>
                    <a href="/products"
                        class="inline-block mt-4 md:mt-6 bg-[#49280d] text-white font-bold px-6 md:px-8 py-3 md:py-4 rounded-lg shadow hover:bg-[#6b4826] transition-colors duration-300">
                        Explore Now
                    </a>
                </div>
                <!-- Carousel - Adjust height and width for mobile -->
                <div class="w-full md:w-1/2 mt-6 md:mt-0">
                    <div class="w-full relative">
                        <div class="swiper progress-slide-carousel swiper-container relative">
                            <div class="swiper-wrapper">
                                <template id="slide-template">
                                    <div class="swiper-slide">
                                        <div class="bg-indigo-50 rounded-2xl h-64 md:h-96 overflow-hidden">
                                            <img src="" alt="" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </template>
                            </div>
                            <div
                                class="swiper-pagination !bottom-2 !top-auto !w-48 md:!w-80 right-0 left-0 mx-auto bg-gray-100/80 rounded-full">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Category -->
    <section class="py-8">
        <div class="container mx-auto px-4">
            <div class="relative flex justify-between items-center mb-8">
                <!-- <h2 class="absolute left-1/2 transform -translate-x-1/2 text-2xl font-bold text-gray-800">Featured Category</h2> -->
                <h2 class="absolute left-1/2 transform -translate-x-1/2 text-lg sm:text-xl md:text-2xl font-bold text-[#49280d]">
                    FEATURED CATEGORY
                </h2>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="category-prev bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="category-next bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <a href="/products"
                        class="text-orange-500 hover:text-orange-600 font-semibold hover:underline flex items-center gap-1">
                        See All
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div id="category-container"
                    class="flex overflow-x-auto gap-6 pb-4 no-scrollbar cursor-grab active:cursor-grabbing scroll-smooth">
                    <!-- Category cards will be dynamically inserted here -->
                    @foreach ($categories as $category)
                        <div class="category-card flex-shrink-0 w-full max-w-[280px] bg-white shadow-lg rounded-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                        <a href="/products?categories={{ $category->category_name }}" class="category-link">
                                <div class="relative">
                                    <img src="/assets/images/categories/{{ $category->category_image }}" alt=""
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-300">
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 category-name">{{ $category->category_name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{-- For The Error Message To be Displayed --}}
                    @error('category')
                        <div class="w-full text-center py-4 text-red-500">Error loading categories</div>
                    @enderror
                    <template id="category-template">
                        <div class="category-card flex-shrink-0 w-full max-w-[280px] bg-white shadow-lg rounded-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                            <a href="/products?category=" class="category-link">
                                <div class="relative">
                                    <img src="" alt=""
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-all duration-300">
                                    </div>
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 category-name"></h3>
                                </div>
                            </a>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Products -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="relative flex justify-between items-center mb-8">
                <!-- <h2 class="absolute left-1/2 transform -translate-x-1/2 text-2xl font-bold text-gray-800">Latest Products</h2> -->
                <h2 class="absolute left-1/2 transform -translate-x-1/2 text-lg sm:text-xl md:text-2xl font-bold text-[#49280d]">
                LATEST PRODUCTS
                </h2>

                <div class="flex items-center gap-4 ml-auto">
                    <button class="product-prev bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="product-next bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <a href="/products"
                        class="text-orange-500 hover:text-orange-600 font-semibold hover:underline flex items-center gap-1">
                        See All
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div id="product-container"
                    class="flex overflow-x-auto gap-6 pb-4 no-scrollbar cursor-grab active:cursor-grabbing scroll-smooth">
                    <!-- Product cards will be dynamically inserted here -->
                    @foreach ($latests as $latest)
                        <article class="relative flex-shrink-0 w-full max-w-[280px] flex flex-col overflow-hidden rounded-lg border group bg-white hover:shadow-xl transition-shadow duration-300">
                            <a href="/products/{{ $latest->article_id }}" class="product-link">
                                <div class="aspect-square overflow-hidden">
                                    <img class="product-image h-full w-full object-cover transition-all duration-300 group-hover:scale-110" 
                                         src="/assets/images/products/{{ $latest->article_id }}/{{ $latest->shoe_image1 }}" 
                                         alt="{{ $latest->shoe_name }} - Premium footwear from SK Shoes">
                                </div>
                                {{-- <div class="absolute top-0 m-2 rounded-full bg-white">
                                    <p class="discount-badge rounded-full bg-black px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-white"></p>
                                </div> --}}
                                <div class="relative my-2 mx-auto flex w-11/12 flex-col items-start justify-between">
                                    <div class="mb-1 flex items-center">
                                        <span class="product-price mr-2 text-base font-bold text-gray-900">{{ $latest->price }}</span>
                                        {{-- <span class="original-price text-sm text-gray-400 line-through"></span> --}}
                                    </div>
                                    
                                    <h3 class="product-name text-sm font-bold text-gray-900 mb-1">{{ $latest->shoe_name }}</h3>
                                    <!-- Cart Icon Button - Updated onclick -->
                                    <button onclick="window.location.href='/products/{{ $latest->article_id }}'" 
                                            class="cart-icon-btn absolute right-0 top-0 h-8 w-8 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 rounded-full transition-colors duration-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </a>
                            <div class="mx-auto mb-2 w-11/12">
                                <!-- Buy Now Button - Updated onclick -->
                                <button onclick="window.location.href='/products/{{ $latest->article_id }}'" 
                                        class="buy-now-btn w-full h-9 bg-orange-500 hover:bg-orange-600 text-white text-sm uppercase rounded-md transition-colors duration-200 font-semibold">
                                    Buy Now
                                </button>
                            </div>
                        </article>
                    @endforeach
                    {{-- For The Error Message To be Displayed --}}
                    @error('category')
                        <div class="w-full text-center py-4 text-red-500">Error loading products</div>
                    @enderror
                    <template id="product-template">
                        <article class="relative flex-shrink-0 w-full max-w-[280px] flex flex-col overflow-hidden rounded-lg border group bg-white hover:shadow-xl transition-shadow duration-300">
                            <a href="" class="product-link">
                                <div class="aspect-square overflow-hidden">
                                    <img class="product-image h-full w-full object-cover transition-all duration-300 group-hover:scale-110" 
                                         src="" 
                                         alt="">
                                </div>
                                <div class="absolute top-0 m-2 rounded-full bg-white">
                                    <p class="discount-badge rounded-full bg-black px-2 py-1 text-[10px] font-bold uppercase tracking-wide text-white"></p>
                                </div>
                                <div class="relative my-2 mx-auto flex w-11/12 flex-col items-start justify-between">
                                    <div class="mb-1 flex items-center">
                                        <span class="product-price mr-2 text-base font-bold text-gray-900"></span>
                                        <span class="original-price text-sm text-gray-400 line-through"></span>
                                    </div>
                                    <h3 class="product-name text-sm text-gray-700 mb-1"></h3>
                                    <!-- Cart Icon Button - Will be updated with correct URL in JavaScript -->
                                    <button class="cart-icon-btn absolute right-0 top-0 h-8 w-8 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 rounded-full transition-colors duration-200 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </a>
                            <div class="mx-auto mb-2 w-11/12">
                                <!-- Buy Now Button - Will be updated with correct URL in JavaScript -->
                                <button class="buy-now-btn w-full h-9 bg-orange-500 hover:bg-orange-600 text-white text-sm uppercase rounded-md transition-colors duration-200 font-semibold">
                                    Buy Now
                                </button>
                            </div>
                        </article>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <!-- Include the footer component -->
    <x-footer />

    <!-- Main JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all components
            initializeData();
            initializeSlider('#category-container');
            initializeSlider('#product-container');

            // Initialize arrow buttons for categories
            const categoryContainer = document.querySelector('#category-container');
            document.querySelector('.category-prev').addEventListener('click', () => {
                categoryContainer.scrollBy({ left: -280, behavior: 'smooth' });
            });
            document.querySelector('.category-next').addEventListener('click', () => {
                categoryContainer.scrollBy({ left: 280, behavior: 'smooth' });
            });

            // Initialize arrow buttons for products
            const productContainer = document.querySelector('#product-container');
            document.querySelector('.product-prev').addEventListener('click', () => {
                productContainer.scrollBy({ left: -280, behavior: 'smooth' });
            });
            document.querySelector('.product-next').addEventListener('click', () => {
                productContainer.scrollBy({ left: 280, behavior: 'smooth' });
            });
        });

        // Update current year in footer
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Fetch and initialize data
        async function initializeData() {
            try {
                // Fetch carousel data
                const carouselData = await fetch('/data/carousel.json').then(res => res.json());
                
                // Initialize carousel with images from JSON
                initializeCarousel(carouselData.hero_carousel);
            } catch (error) {
                console.error('Error initializing data:', error);
            }
        }

        // Initialize carousel with Swiper
        function initializeCarousel(carouselItems) {
            const template = document.getElementById('slide-template');
            const swiperWrapper = document.querySelector('.swiper-wrapper');

            // Clear any existing slides
            swiperWrapper.innerHTML = '';

            // Create slides from carousel items
            carouselItems.forEach(item => {
                const clone = template.content.cloneNode(true);
                const img = clone.querySelector('img');
                img.src = item.image_url;
                img.alt = item.alt_text;
                swiperWrapper.appendChild(clone);
            });

            // Initialize Swiper after adding slides
            var swiper = new Swiper(".progress-slide-carousel", {
                loop: true,
                fraction: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".progress-slide-carousel .swiper-pagination",
                    type: "progressbar",
                },
                // Add responsive breakpoints
                breakpoints: {
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    }
                },
                // Add touch handling improvements
                touchEventsTarget: 'container',
                touchRatio: 1,
                touchAngle: 45,
                grabCursor: true
            });
        }

        // Initialize slider functionality
        function initializeSlider(containerId) {
            const slider = document.querySelector(containerId);
            if (!slider) return;

            let isDown = false;
            let startX;
            let scrollLeft;

            // Only enable mouse sliding for mobile devices
            if (window.innerWidth < 768) {
                slider.addEventListener('mousedown', (e) => {
                    isDown = true;
                    slider.classList.add('active');
                    startX = e.pageX - slider.offsetLeft;
                    scrollLeft = slider.scrollLeft;
                });

                slider.addEventListener('mouseleave', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });

                slider.addEventListener('mouseup', () => {
                    isDown = false;
                    slider.classList.remove('active');
                });

                slider.addEventListener('mousemove', (e) => {
                    if(!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - slider.offsetLeft;
                    const walk = (x - startX) * 2;
                    slider.scrollLeft = scrollLeft - walk;
                });
            }
        }
    </script>

<style>
        /* Add these styles to your existing style section */
        .category-prev,
        .category-next,
        .product-prev,
        .product-next {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        /* Add Aubette font to specific elements */
        h1.text-2xl.md\:text-3xl.lg\:text-4xl.font-bold.text-\[\#49280d\],
        h2.absolute.left-1\/2.transform.-translate-x-1\/2.text-lg.sm\:text-xl.md\:text-2xl.font-bold.text-\[\#49280d\],
        a.inline-block.mt-4.md\:mt-6.bg-\[\#49280d\].text-white.font-bold.px-6.md\:px-8.py-3.md\:py-4.rounded-lg.shadow.hover\:bg-\[\#6b4826\].transition-colors.duration-300 {
            font-family: 'sunborn', sans-serif;
        }

        .category-prev:hover,
        .category-next:hover,
        .product-prev:hover,
        .product-next:hover {
            opacity: 1;
        }

        @media (max-width: 640px) {
            .category-prev,
            .category-next,
            .product-prev,
            .product-next {
                display: none;
            }
        }

        /* Product card hover effects */
        .product-image {
            transition: transform 0.3s ease-in-out;
        }
        
        .add-to-cart-btn {
            transition: all 0.3s ease;
        }
        
        .add-to-cart-btn:hover .bg-gray-100 {
            background-color: rgb(17 24 39);
            color: white;
        }
        
        .add-to-cart-btn:hover .bg-gray-200 {
            background-color: rgb(31 41 55);
            color: white;
        }
        
        /* Smooth hover effects */
        article:hover {
            transform: translateY(-2px);
        }

        /* Category card hover effects */
        .category-card {
            transition: all 0.3s ease;
        }
        
        .category-card:hover {
            transform: translateY(-2px);
        }
        
        /* Container scrollbar styling */
        #category-container::-webkit-scrollbar,
        #product-container::-webkit-scrollbar {
            height: 4px;
        }
        
        #category-container::-webkit-scrollbar-track,
        #product-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }
        
        #category-container::-webkit-scrollbar-thumb,
        #product-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 2px;
        }
        
        #category-container::-webkit-scrollbar-thumb:hover,
        #product-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .swiper-pagination-progressbar-fill {
            background-color: #49280d !important;
        }
    </style>
</body>

</html>