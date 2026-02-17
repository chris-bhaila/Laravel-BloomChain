<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>About Us - SK Shoes</title>
        
        <!-- Updated Meta Tags for SEO -->
        <meta name="description" content="Discover SK Shoes, where craftsmanship meets style. Since 2020, we have been dedicated to creating high-quality footwear that combines comfort and durability.">
        <meta name="keywords" content="SK Shoes, premium footwear, quality shoes, craftsmanship, stylish shoes, comfortable footwear, shoe brand">
        <meta name="author" content="SK Shoes Team">
        <meta name="robots" content="index, follow">
        <meta property="og:title" content="About Us - SK Shoes">
        <meta property="og:description" content="Explore our journey and commitment to quality footwear at SK Shoes.">
        <meta property="og:image" content="{{ asset('assets/images/founder.jpg') }}">
        <meta property="og:url" content="{{ request()->url() }}">
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-gray-100">
        <!-- Include Header -->
        <x-header />
        
        <!-- About Content -->
        <section class="bg-white py-12">
            <div class="w-full max-w-7xl px-4 mx-auto sm:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">About SK Shoes</h2>
                    <p class="text-gray-600 mt-4">Crafting Quality Footwear Since 2020</p>
                </div>
                
                <blockquote class="relative grid items-center bg-orange-50 shadow-xl md:grid-cols-3 rounded-xl mb-12">
                    <img class="hidden object-cover w-full h-full rounded-l-xl md:block" 
                         style="clip-path: polygon(0 0%, 100% 0%, 75% 100%, 0% 100%);" 
                         src="{{ asset('assets/images/founder.jpg') }}" 
                         alt="Founder">

                    <article class="relative p-6 md:p-8 md:col-span-2">
                        <svg class="absolute top-0 right-0 hidden w-24 h-24 -mt-12 -mr-12 text-orange-500/25 md:block" 
                             width="256" height="256" 
                             viewBox="0 0 256 256" 
                             fill="none" 
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M65.44 153.526V149.526H61.44H20.48C11.3675 149.526 4 142.163 4 133.105V51.4211C4 42.3628 11.3675 35 20.48 35H102.4C111.513 35 118.88 42.3628 118.88 51.4211V166.187C118.88 195.935 95.103 220.165 65.44 220.979V153.526ZM198.56 153.526V149.526H194.56H153.6C144.487 149.526 137.12 142.163 137.12 133.105V51.4211C137.12 42.3628 144.487 35 153.6 35H235.52C244.633 35 252 42.3628 252 51.4211V166.187C252 195.935 228.223 220.165 198.56 220.979V153.526Z"
                                  stroke="currentColor" 
                                  stroke-width="8"></path>
                        </svg>

                        <div class="space-y-6">
                            <p class="text-base sm:leading-relaxed md:text-xl text-gray-700">
                                Welcome to SK Shoes, where passion meets craftsmanship. Founded in 2020, we've dedicated ourselves 
                                to creating premium footwear that combines style, comfort, and durability. Our journey began with 
                                a simple vision: to provide our customers with shoes that not only look great but feel exceptional 
                                with every step.
                            </p>

                            <footer class="flex items-center gap-4">
                                <img class="w-12 h-12 rounded-full md:hidden" 
                                     src="{{ asset('assets/images/founder.jpg') }}" 
                                     alt="Founder">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">Name: </h3>
                                    <p class="text-gray-600">Founder & CEO</p>
                                </div>
                            </footer>
                        </div>
                    </article>
                </blockquote>

                <!-- Values Grid -->
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Quality -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Quality First</h3>
                        <p class="text-gray-600">We never compromise on quality, using only the finest materials and craftsmanship.</p>
                    </div>

                    <!-- Innovation -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Innovation</h3>
                        <p class="text-gray-600">We constantly explore new designs and technologies for the best footwear.</p>
                    </div>

                    <!-- Customer Focus -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Customer Focus</h3>
                        <p class="text-gray-600">Your satisfaction is our priority with exceptional service and support.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Include Footer -->
        <x-footer />
    </body>
</html> 