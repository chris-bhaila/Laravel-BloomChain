<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product['shoes']['shoe_name'] }} - SK Shoes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SEO Meta Tags -->
    <meta name="title" content="{{ $product['shoes']['shoe_name'] }} | SK Shoes">
    <meta name="description" content="{{ $product['shoes']['shoe_description'] }}">
    <meta name="keywords"
        content="{{$product['shoes']['shoe_name']}}, {{ $product['shoes']['category_name'] }}, {{ $product['shoes']['article_id'] }}, premium shoes, quality footwear, SK Shoes, stylish shoes, comfortable shoes, buy shoes online, shoes in Nepal, Nepal shoes">
    <link rel="canonical" href="{{ url()->full() }}">
</head>

<body>
    <x-header />

    <div class="bg-gray-100" id="product-container">
        <div class="container mx-auto px-4 py-8">
            <div class="flex flex-wrap -mx-4">
                <!-- Product Images -->
                <div class="w-full lg:w-1/2 px-4 mb-8">
                    <div id="mainMediaContainer"
                        class="w-full max-w-[500px] h-[400px] mx-auto mb-4 rounded-lg shadow-md overflow-hidden">
                        <img src="" alt="Product Image" class="w-full h-full object-cover" id="mainImage">
                        <video id="mainVideo" class="w-full h-full object-cover hidden" src="" crossorigin="anonymous"
                            muted playsinline loop>
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="flex gap-2 py-2 justify-center overflow-x-auto" id="thumbnailContainer">
                        <!-- Thumbnails will be dynamically inserted here -->
                    </div>
                    <!-- Description -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Description:</h3>
                        <p class="text-gray-700" id="product-description">{{ $product['shoes']['shoe_description'] }}</p>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="w-full lg:w-1/2 px-4">
                    <h2 class="text-3xl font-bold mb-2" id="product-name">{{ $product['shoes']['shoe_name'] }}</h2>
                    <p class="text-gray-600 mb-4" id="product-sku">{{ $product['shoes']['category_name'] }}</p>

                    <!-- Type Selection -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-3">Type:</h3>
                        <div class="flex gap-3" id="type-container">
                            <!-- Type buttons will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-2xl font-bold mr-2" id="product-price"></span>
                        <span class="text-gray-500 line-through" id="product-original-price"></span>
                    </div>

                    <!-- Size Selection -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Size (EU):</h3>
                        <div class="flex flex-wrap gap-2" id="size-container">
                            <!-- Size buttons will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Color Selection (New Section) -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-3">Available Colors:</h3>
                        <div class="flex flex-wrap gap-4" id="color-container">
                            <!-- Color options will be dynamically inserted here -->
                            @foreach ($product['colours'] as $color)
                                <a href="/products/{{$color['article_id']}}" class="group relative flex flex-col items-center">
                                    <div
                                        class="relative mb-2 h-16 w-16 overflow-hidden rounded-lg border-2 border-transparent hover:border-orange-500 transition-colors duration-200">
                                        <img src="{{$color['shoe_image1']}}" alt="{{$color['shoe_color']}}" class="h-full w-full object-cover">
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-orange-500 transition-colors duration-200">
                                        {{$color['shoe_color']}}
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Button -->
                    <div class="mb-6">
                        <button onclick="buyNow()"
                            class="w-full bg-orange-500 flex gap-2 items-center justify-center text-white px-6 py-3 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Similar Products</h2>
                <div class="flex items-center gap-4">
                    <button class="similar-prev bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button class="similar-next bg-white rounded-full p-2 shadow-lg hover:bg-gray-50">
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
                <div id="similar-products"
                    class="flex gap-6 overflow-x-auto pb-4 no-scrollbar cursor-grab active:cursor-grabbing scroll-smooth hide-scrollbar"
                    style="scroll-snap-type: x mandatory; -webkit-overflow-scrolling: touch;">
                    <!-- Similar Products will be dynamically inserted here -->
                    @foreach ($product['similar'] as $s)
                        <article
                            class="relative flex-shrink-0 w-[200px] flex flex-col overflow-hidden rounded-lg border bg-white hover:shadow-xl transition-all duration-300">
                            <a href="/products/{{$s['article_id']}}" class="group">
                                <div class="aspect-square overflow-hidden bg-gray-100">
                                    <img class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                        src='{{$s["shoe_image"]}}' alt='{{$s["shoe_name"]}}' loading="lazy">
                                </div>
                                <div class="p-4">
                                    <div class="mb-2">
                                        <span class="text-base font-bold text-gray-900">
                                            {{ $s['price'] ? 'Rs.'.($s['price']) : 'Contact for price'}}
                                        </span>
                                    </div>
                                    <h3 class="text-sm text-gray-700 line-clamp-2 mb-2">
                                        {{$s['shoe_name']}}
                                    </h3>
                                    <button
                                        class="w-full bg-orange-500 hover:bg-orange-600 text-white text-sm uppercase py-2 rounded-md transition-colors duration-200 font-medium">
                                        View Details
                                    </button>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>



    <x-footer />

    <style>
        /* Add these styles at the end of your existing styles */
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

        article {
            transition: all 0.3s ease;
        }

        article:hover {
            transform: translateY(-2px);
        }

        /* Add these styles to your existing styles */
        .similar-prev,
        .similar-next {
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .similar-prev:hover,
        .similar-next:hover {
            opacity: 1;
        }

        @media (max-width: 640px) {

            .similar-prev,
            .similar-next {
                display: none;
            }
        }

        #mainMediaContainer {
            position: relative;
            background-color: #f8f8f8;
            min-height: 300px;
        }

        @media (max-width: 1024px) {
            #mainMediaContainer {
                height: 350px;
            }
        }

        @media (max-width: 768px) {
            #mainMediaContainer {
                height: 300px;
            }
        }

        @media (max-width: 640px) {
            #mainMediaContainer {
                height: 250px;
            }
        }

        #mainVideo,
        #mainImage {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .video-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #666;
        }

        /* Add these styles to your existing styles */
        .flex.gap-2 video {
            pointer-events: none;
            /* Prevent video controls in thumbnail */
        }

        .video-thumbnail {
            transition: opacity 0.3s ease;
        }

        #mainVideo {
            transition: opacity 0.3s ease;
        }

        #mainImage {
            transition: opacity 0.3s ease;
        }

        /* Add these styles to your existing styles */
        #color-container a {
            position: relative;
            transition: transform 0.2s ease;
        }

        #color-container a:hover {
            transform: translateY(-2px);
        }

        #color-container img {
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        .color-selected {
            position: relative;
        }

        .color-selected::after {
            content: '✓';
            position: absolute;
            top: -8px;
            right: -8px;
            width: 20px;
            height: 20px;
            background-color: #f97316;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
        }

        /* Add these styles to your existing styles */
        .hide-scrollbar {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari and Opera */
        }

        #similar-products>article {
            scroll-snap-align: start;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        #thumbnailContainer {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #thumbnailContainer::-webkit-scrollbar {
            display: none;
        }

        #thumbnailContainer img,
        #thumbnailContainer .video-thumbnail {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
            object-fit: cover;
        }

        @media (min-width: 640px) {

            #thumbnailContainer img,
            #thumbnailContainer .video-thumbnail {
                width: 64px;
                height: 64px;
            }
        }

        .type-selection {
            transition: all 0.3s ease;
        }

        .type-selection:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .type-selection.bg-white:hover {
            background-color: #f3f4f6 !important;
            border-color: #9ca3af !important;
        }

        .type-selection.bg-gray-900:hover {
            background-color: #1f2937 !important;
            border-color: #1f2937 !important;
        }


    </style>

    <script>
        let productData = @json($product); // Add this at the top level of your script

        document.addEventListener('DOMContentLoaded', function () {
            loadProductDetails();
            initializeScrollButtons();
            // Initialize video thumbnails
            const videoThumbnails = document.querySelectorAll('.flex.gap-2 video');
            videoThumbnails.forEach(video => {
                // Set the currentTime to 0.1 seconds to capture the first frame
                video.currentTime = 0.1;
            });
        });

        async function loadProductDetails() {
            try {
                var data = @json($product);
                // Update main image and thumbnails with safety checks
                const mainImage = document.getElementById('mainImage');
                const mainVideo = document.getElementById('mainVideo');
                const thumbnailContainer = document.getElementById('thumbnailContainer');

                if (mainImage && data.images && data.images.length > 0) {
                    mainImage.src = data.images[0];
                    mainImage.alt = data.shoes.shoe_name || 'Product Image';
                    mainImage.classList.remove('hidden');
                    mainVideo.classList.add('hidden');

                }

                // Clear and update thumbnails
                if (thumbnailContainer) {
                    thumbnailContainer.innerHTML = '';

                    // Add images to thumbnails with safety checks
                    if (data.images && Array.isArray(data.images)) {
                        data.images.forEach((imageUrl, index) => {
                            if (imageUrl) {
                                thumbnailContainer.innerHTML += `
                                    <img src="${imageUrl}" 
                                         alt="${data.shoes.shoe_name || 'Product Image'}"
                                         data-src="${imageUrl}"
                                         class="size-14 sm:size-16 object-cover rounded-md cursor-pointer ${index === 0 ? 'opacity-100' : 'opacity-60'} hover:opacity-100 transition duration-300"
                                         onclick="changeMedia('${imageUrl}', 'image')"
                                         onerror="this.onerror=null; this.src='/images/no-image.png';">
                                `;
                            }
                        });
                    }
                    // Ensure the video thumbnail is clickable
                    if (data.video) {
                        const video = document.createElement('video');
                        video.src = data.video; // Set the video source
                        video.currentTime = 0.1; // Set to a small time to capture the first frame

                        video.addEventListener('loadeddata', () => {
                            const canvas = document.createElement('canvas');
                            canvas.width = 320; // Set desired width
                            canvas.height = 180; // Set desired height
                            const context = canvas.getContext('2d');
                            context.drawImage(video, 0, 0, canvas.width, canvas.height);
                            const thumbnailUrl = canvas.toDataURL(); // Get the image data URL

                            // Now you can use thumbnailUrl as the src for your video thumbnail
                            thumbnailContainer.innerHTML += `
                                <img src="${thumbnailUrl}"
                                     alt="${data.shoes.shoe_name || 'Video Thumbnail'}"
                                     data-src="${data.video}"
                                     class="size-14 sm:size-16 object-cover rounded-md cursor-pointer hover:opacity-100 transition duration-300"
                                     onclick="changeMedia('${data.video}', 'video')">
                            `;
                        });
                    }
                }
                
                // Update type selections
                const typeContainer = document.querySelector('.flex.gap-3');
                typeContainer.innerHTML = ''; // Clear existing types

                // Get all available types from product_grouping
                const typeCategories = new Set();
                Object.values(data.product_grouping).forEach(grouping => {
                    if (grouping) {
                        Object.keys(grouping).forEach(category => typeCategories.add(category));
                    }
                });

                // Create sections for each type category
                typeCategories.forEach(category => {
                    // Create category section
                    const categorySection = document.createElement('div');
                    categorySection.className = 'mb-4';
                    categorySection.innerHTML = `
                        <h3 class="text-lg font-semibold mb-3 capitalize">${category}:</h3>
                        <div class="flex flex-wrap gap-2" id="${category}-container"></div>
                    `;
                    typeContainer.appendChild(categorySection);

                    // Get unique values for this category
                    const values = new Set();
                    Object.values(data.product_grouping).forEach(grouping => {
                        if (grouping && grouping[category]) {
                            values.add(grouping[category]);
                        }
                    });

                    // Add buttons for each value
                    const container = categorySection.querySelector(`#${category}-container`);
                    let isFirst = true;
                    values.forEach(value => {
                        const button = document.createElement('button');
                        button.className = `type-selection px-4 py-2 rounded-md border transition-colors duration-200 ${isFirst ? 'bg-gray-900 border-gray-900 text-white' : 'bg-white border-gray-300 text-gray-700'
                            } hover:bg-gray-50`;
                        button.textContent = value;
                        button.onclick = () => selectType(button, category, value, data);
                        container.appendChild(button);

                        // If this is the first button, trigger its selection
                        if (isFirst) {
                            selectType(button, category, value, data);
                            isFirst = false;
                        }
                    });
                });

                // Update initial price and stock
                if (data.prices && data.prices.length > 0) {
                    const initialPriceId = data.prices[0].price_id;
                    updatePriceAndStock(initialPriceId, data);
                }

                // Update color options
                const colorContainer = document.getElementById('color-container');
                if (colorContainer) {
                    colorContainer.innerHTML = '';

                    // Add current color first
                    if (data.shoes && data.images && data.images.length > 0) {
                        colorContainer.innerHTML += `
                            <a href="/products/${data.shoes.article_id}" 
                               class="group relative flex flex-col items-center color-selected">
                                <div class="relative mb-2 h-16 w-16 overflow-hidden rounded-lg border-2 border-orange-500">
                                    <img src="${data.images[0]}" 
                                         alt="${data.shoes.shoe_color}" 
                                         class="h-full w-full object-cover">
                                </div>
                                <span class="text-sm font-medium text-gray-900">
                                    ${data.shoes.shoe_color}
                                </span>
                            </a>
                        `;
                    }

                    // Add other colors if they exist
                    if (data.colours && Array.isArray(data.colours)) {
                        data.colours.forEach(color => {
                            if (color.shoe_image1 && color.article_id !== data.shoes.article_id) {
                                colorContainer.innerHTML += `
                                    <a href="/products/${color.article_id}" 
                                       class="group relative flex flex-col items-center">
                                        <div class="relative mb-2 h-16 w-16 overflow-hidden rounded-lg border-2 border-transparent hover:border-orange-500 transition-colors duration-200">
                                            <img src="${color.shoe_image1}" 
                                                 alt="${color.shoe_color}" 
                                                 class="h-full w-full object-cover">
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-orange-500 transition-colors duration-200">
                                            ${color.shoe_color}
                                        </span>
                                    </a>
                                `;
                            }
                        });
                    }
                }

            } catch (error) {
                console.error('Error fetching product details:', error);
            }
        }

        function updateMetaTags(product) {
            if (!product) return;

            document.title = `${product.shoe_name} | SK Shoes`;

            document.querySelector('meta[name="title"]').setAttribute("content", `${product.shoe_name} | SK Shoes`);
            document.querySelector('meta[name="description"]').setAttribute("content", `Discover ${product.shoe_name} at SK Shoes. ${product.shoe_description}`);
            document.querySelector('meta[name="keywords"]').setAttribute("content", `${product.shoe_name}, premium shoes, ${product.category_name}, quality footwear, SK Shoes, stylish shoes, comfortable shoes, Buy ${product.shoe_name} online, ${product.shoe_name} in Nepal, ${product.shoe_name} Nepal, Nepal shoes`);
        }
        let selectedSize = null;
        let selectedType = null;

        function selectSize(button) {
            document.querySelectorAll('.size-selection').forEach(btn => {
                btn.classList.remove('border-gray-800');
                btn.classList.add('border-gray-300');
            });
            button.classList.remove('border-gray-300');
            button.classList.add('border-gray-800');
            selectedSize = button.dataset.size;
        }

        function selectType(button, category, value, productData) {
            // Get all buttons in the same category
            const categoryContainer = button.parentElement;
            const categoryButtons = categoryContainer.querySelectorAll('.type-selection');

            // Remove active class from all buttons in the same category
            categoryButtons.forEach(btn => {
                btn.classList.remove('bg-gray-900', 'border-gray-900', 'text-white');
                btn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
            });

            // Add active class to selected button
            button.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
            button.classList.add('bg-gray-900', 'border-gray-900', 'text-white');

            // Get all currently selected types
            const selectedTypes = {};
            document.querySelectorAll('.type-selection.bg-gray-900').forEach(selectedButton => {
                const categoryTitle = selectedButton.closest('div').previousElementSibling.textContent.replace(':', '').toLowerCase();
                selectedTypes[categoryTitle] = selectedButton.textContent;
            });

            // Find matching price_id based on selected types
            const matchingPriceId = findPriceIdForTypes(selectedTypes, productData.product_grouping);

            if (matchingPriceId) {
                updatePriceAndStock(matchingPriceId, productData);
            } else {
                updatePriceAndStock(null, productData);
            }
        }

        function findPriceIdForTypes(selectedTypes, productGrouping) {
            if (!productGrouping || Object.keys(selectedTypes).length === 0) {
                return null;
            }

            for (const [priceId, grouping] of Object.entries(productGrouping)) {
                if (!grouping) continue;

                const matches = Object.entries(selectedTypes).every(([category, value]) =>
                    grouping[category] === value
                );

                if (matches) {
                    return priceId;
                }
            }
            return null;
        }

        async function updatePriceAndStock(priceId, productData) {
            if(!priceId && priceId == null) {
                const sizeContainer = document.getElementById('size-container');
                sizeContainer.innerHTML = '';
                document.getElementById('product-price').textContent = 'Not Available.';
            } else {
                // Find the price object based on the priceId
                const price = productData.prices.find(p => p.price_id.toString() === priceId.toString());
                if (price) {
                    document.getElementById('product-price').textContent = `Rs. ${price.price.toLocaleString()}`;
    
                    // Update size options based on the selected priceId
                    const stockDetails = productData.stock_details[priceId];
                    if (stockDetails) {
                        updateSizeOptions(stockDetails);
                    }
                } else {
                    console.error('Price not found for the selected type');
                }
            }
        }

        function updateSizeOptions(stockDetails) {
            const sizeContainer = document.getElementById('size-container');
            sizeContainer.innerHTML = '';

            stockDetails.forEach(sizeData => {
                sizeContainer.innerHTML += `
                    <button 
                        class="size-selection relative w-14 h-10 text-center border rounded-md ${sizeData.stock > 0
                        ? 'border-gray-300 hover:border-gray-800 cursor-pointer'
                        : 'border-gray-200 bg-gray-50 cursor-not-allowed'
                    }"
                        ${sizeData.stock === 0 ? 'disabled' : ''}
                        data-size="${sizeData.size}"
                        onclick="selectSize(this)">
                        ${sizeData.size}
                        ${sizeData.stock === 0 ? `
                            <svg class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-gray-600" width="24" height="24" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke="currentColor" fill="none" d="M18 6L6 18M6 6l12 12"/>
                            </svg>
                        ` : ''}
                    </button>
                `;
            });
        }

        function changeMedia(src, type) {
            const mainImage = document.getElementById('mainImage');
            const mainVideo = document.getElementById('mainVideo');

            // Update all thumbnails to be semi-transparent
            document.querySelectorAll('#thumbnailContainer img, #thumbnailContainer video').forEach(thumb => {
                thumb.classList.remove('opacity-100');
                thumb.classList.add('opacity-60');
            });

            // Find and highlight the clicked thumbnail
            const clickedThumbnail = document.querySelector(`[data-src="${src}"]`);
            if (clickedThumbnail) {
                clickedThumbnail.classList.remove('opacity-60');
                clickedThumbnail.classList.add('opacity-100');
            }

            if (type === 'video') {
                mainImage.classList.add('hidden');
                mainVideo.classList.remove('hidden');
                mainVideo.src = src;
                mainVideo.load();
                mainVideo.play().catch(error => {
                    console.log("Video autoplay failed:", error);
                });
            } else {
                mainVideo.pause();
                mainVideo.classList.add('hidden');
                mainImage.classList.remove('hidden');
                mainImage.src = src;
            }
        }

        function changeImage(src) {
            changeMedia(src, 'image');
        }

        async function buyNow() {
            if (!selectedSize) {
                alert('Please select a size');
                return;
            }

            if (!productData) {
                alert('Product data not loaded properly');
                return;
            }

            try {
                // Get all currently selected types
                const selectedTypes = {};
                document.querySelectorAll('.type-selection.bg-gray-900').forEach(selectedButton => {
                    const categoryTitle = selectedButton.closest('div').previousElementSibling.textContent.replace(':', '').toLowerCase();
                    selectedTypes[categoryTitle] = selectedButton.textContent;
                });
                // Find matching price_id based on selected types
                let priceId;
                if (Object.keys(selectedTypes).length > 0) {
                    priceId = findPriceIdForTypes(selectedTypes, productData.product_grouping);
                }

                // Fallback to first price if no match found
                if (!priceId && productData.prices && productData.prices.length > 0) {
                    priceId = productData.prices[0].price_id;
                }

                if (!priceId) {
                    throw new Error('No valid price ID found');
                }

                // Create URL with query parameters
                const url = new URL('/cookie', window.location.origin);
                url.searchParams.append('price_id', priceId);
                url.searchParams.append('size', selectedSize);

                // Add to cart using cookie endpoint
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const result = await response.json();

                if (result.success) {
                    // Trigger cart update event for header cart count
                    document.dispatchEvent(new CustomEvent('cartUpdated'));

                    // Redirect to cart page
                    window.location.href = '/cart';
                } else {
                    throw new Error(result.error || 'Failed to add item to cart');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                alert(`Failed to add item to cart: ${error.message}`);
            }
        }

        // Add this event listener to handle cart updates
        document.addEventListener('cartUpdated', function () {
            // Refresh the cart count in the header
            fetch('/cookie')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.cartItems ? data.cartItems.length : '0';
                    }
                })
                .catch(error => console.error('Error updating cart:', error));
        });

        function renderSimilarProducts(products) {
            const container = document.getElementById('similar-products');
            const template = document.getElementById('similar-product-template');

            container.innerHTML = '';

            products.forEach(product => {
                const clone = template.content.cloneNode(true);

                const productLink = clone.querySelector('.product-link');
                productLink.href = `/products/${product.slug}`;

                const img = clone.querySelector('.product-image');
                img.src = product.images[0].url;
                img.alt = product.images[0].alt;

                // Hide discount badge if no discount
                const discountBadge = clone.querySelector('.discount-badge').parentElement;
                if (product.discount_percentage) {
                    clone.querySelector('.discount-badge').textContent = `-${product.discount_percentage}%`;
                } else {
                    discountBadge.classList.add('hidden');
                }

                clone.querySelector('.product-name').textContent = product.name;
                clone.querySelector('.product-price').textContent = `Rs. ${product.price.toLocaleString()}`;

                const originalPrice = clone.querySelector('.original-price');
                if (product.original_price) {
                    originalPrice.textContent = `Rs. ${product.original_price.toLocaleString()}`;
                } else {
                    originalPrice.style.display = 'none';
                }

                const addToCartBtn = clone.querySelector('.add-to-cart-btn');
                addToCartBtn.dataset.productId = product.id;
                addToCartBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    addToCart(product.id);
                });

                const buyNowBtn = clone.querySelector('.buy-now-btn');
                buyNowBtn.dataset.productId = product.id;
                buyNowBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    buyNow(product.id);
                });

                container.appendChild(clone);
            });
        }

        function initializeSlider(sliderId) {
            const slider = document.querySelector(sliderId);
            let isDown = false;
            let startX;
            let scrollLeft;

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
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2;
                slider.scrollLeft = scrollLeft - walk;
            });
        }

        // Add this to your existing script
        function initializeScrollButtons() {
            const similarContainer = document.getElementById('similar-products');
            const similarPrevBtn = document.querySelector('.similar-prev');
            const similarNextBtn = document.querySelector('.similar-next');

            if (similarPrevBtn && similarNextBtn) {
                similarPrevBtn.addEventListener('click', () => {
                    similarContainer.scrollBy({
                        left: -300,
                        behavior: 'smooth'
                    });
                });

                similarNextBtn.addEventListener('click', () => {
                    similarContainer.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                });
            }
        }

        // When the page loads, ensure video is properly initialized
        document.addEventListener('DOMContentLoaded', function () {
            const mainVideo = document.getElementById('mainVideo');
            const mainMediaContainer = document.getElementById('mainMediaContainer');

            // Remove fixed dimensions - they're now handled by CSS
            mainMediaContainer.style.width = '100%';

            mainVideo.addEventListener('click', function () {
                if (mainVideo.paused) {
                    mainVideo.play()
                        .catch(error => console.log("Playback failed:", error));
                } else {
                    mainVideo.pause();
                }
            });

            // Handle video loading errors
            mainVideo.addEventListener('error', function (e) {
                console.log("Video error:", e);
            });
        });

        // Add this function to handle color selection
        function selectColor(articleId) {
            window.location.href = `/products/${articleId}`;
        }
    </script>
</body>

</html>