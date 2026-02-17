<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products - SK Shoes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @php
        $shoeNames = collect($Shoes)->pluck('shoe_name')->unique()->implode(', ');
        $categories = collect($Shoes)->pluck('category_name')->unique()->implode(', ');
        $colors = $Shoes->pluck('shoe_color')->unique()->implode(', ');
        $prices = $Shoes->pluck('price')->sort()->unique()->values();

        $minPrice = $prices->first();
        $maxPrice = $prices->last();
    @endphp
    <!-- SEO Meta Tags -->
    <meta name="title" content="Products - SK Shoes">
    <meta name="description" content="Explore our collection of {{ $shoeNames }} in colors like {{ $colors }}, across categories such as {{ $categories }}. Prices range from Rs. {{ $minPrice }} to Rs. {{ $maxPrice }}.">
    <meta name="keywords" content="{{ $shoeNames }}, {{ $colors }}, {{ $categories }}, Rs {{ $minPrice }} - Rs {{ $maxPrice }}, shoes, boot, footwear, premium shoes, SK Shoes, latest products, buy shoes online, online footwear, sk shoes, sk">
    <link rel="canonical" href="{{ request()->url() }}">
    
    <!-- Open Graph (OG) Meta Tags - For Facebook & LinkedIn -->
    <meta property="og:title" content="Products - SK Shoes">
    <meta property="og:description" content="Discover a wide range of premium shoes at SK Shoes. Shop now for the best selection!">
    <meta property="og:image" content="{{ asset('assets/images/logo.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
</head>
<body class="bg-gray-100">
    <x-header />

    <div class="mx-4 sm:mx-8 py-4">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Sidebar - Made smaller -->
            <div id="filter-sidebar" 
                 class="w-full md:w-1/5 bg-white rounded-lg shadow-md py-2 px-4 md:p-4 h-fit">
                <!-- Filter Header with Collapse Icon -->
                <div id="collapse-filters" class="flex justify-between items-center mb-1">
                    <h1 class="text-lg font-bold text-gray-800">Filters</h1>
                    <button class="md:hidden p-1 hover:bg-gray-100 rounded-md">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-gray-500" 
                             id="collapse-arrow"
                             xmlns="http://www.w3.org/2000/svg" 
                             fill="none" 
                             viewBox="0 0 24 24" 
                             stroke="currentColor">
                            <path stroke-linecap="round" 
                                  stroke-linejoin="round" 
                                  stroke-width="2" 
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
                
                <!-- Filter Content Container -->
                <div id="filter-content" class="space-y-6">
                    <!-- Price Range Filter -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Price Range</h3>
                        <div class="mb-4">
                            <div class="flex justify-between mb-2">
                                <span id="minPrice" class="text-gray-600">Rs. 0</span>
                                <span id="maxPrice" class="text-gray-600">Rs. 100,000</span>
                            </div>
                            <div class="relative">
                                <input type="range" 
                                       id="price-range" 
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-gray-900"
                                       min="0" 
                                       max="100000" 
                                       value="100000"
                                       step="1000">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex-1">
                                <label class="text-sm text-gray-600 mb-1 block">Min</label>
                                <input type="number" 
                                       id="min-price-input" 
                                       class="w-full px-2 py-1.5 border rounded-md focus:outline-none focus:ring-1 focus:ring-gray-900"
                                       min="0" 
                                       max="100000" 
                                       value="0">
                            </div>
                            <div class="flex-1">
                                <label class="text-sm text-gray-600 mb-1 block">Max</label>
                                <input type="number" 
                                       id="max-price-input" 
                                       class="w-full px-2 py-1.5 border rounded-md focus:outline-none focus:ring-1 focus:ring-gray-900"
                                       min="0" 
                                       max="100000" 
                                       value="100000">
                            </div>
                        </div>
                    </div>

                    <!-- Visual Separator -->
                    <div class="h-px bg-gray-200 my-6"></div>

                    <!-- Categories Filter -->
                    <div class="mb-6 pt-2">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Categories</h3>
                        <div class="space-y-2.5" id="categories-list">
                            <!-- Categories will be dynamically inserted here -->
                        </div>
                    </div>

                    <!-- Visual Separator -->
                    <div class="h-px bg-gray-200 my-6"></div>

                    <!-- Sizes Filter -->
                    <div class="mb-6 pt-2">
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Sizes</h3>
                        <div class="grid grid-cols-2 gap-2" id="sizes-list">
                            <!-- Sizes will be dynamically inserted here -->
                        </div>
                        <div class="pt-3">
                            <button type="button" class="text-xs text-gray-500 underline" onclick="resetSizes()">Reset Sizes</button>
                        </div>
                    </div>

                    <!-- Apply Filters Button -->
                    <button id="apply-filters" onclick="applyFilters(false)"
                            class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-gray-800 transition-colors duration-200">
                        Apply Filters
                    </button>
                </div>
            </div>

            <!-- Main Content - Adjusted width -->
            <div class="w-full md:w-4/5">
                <div class="bg-white rounded-lg shadow-md p-4">
                    <div class="flex justify-between items-center mb-6 gap-2">
                        <h1 class="text-2xl font-bold text-gray-800">Our Products</h1>
                        <div class="flex items-center gap-4">
                            <span class="text-gray-600">Sort by:</span>
                            <select id="sort-select" class="border rounded-md px-3 py-1.5">
                                <option value="latest">Latest</option>
                                <option value="low">Price: Low to High</option>
                                <option value="high">Price: High to Low</option>
                            </select>
                        </div>
                    </div>

                    <!-- Updated grid columns -->
                    <div class="flex flex-col gap-4">
                        <div id="products-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <!-- Products will be dynamically inserted here -->
                        </div>
                        
                        <!-- Add pagination controls -->
                        <div class="flex justify-center items-center gap-2 mt-4">
                            <button id="prev-page" class="px-4 py-2 bg-gray-200 rounded-md disabled:opacity-50">Previous</button>
                            <span id="page-info" class="text-gray-600"></span>
                            <button id="next-page" class="px-4 py-2 bg-gray-200 rounded-md disabled:opacity-50">Next</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Added Contact Section -->


    <x-footer />

    <!-- Product Template - Updated to match welcome page style -->
    <template id="product-template">
        <article class="relative flex flex-col overflow-hidden rounded-lg border group bg-white hover:shadow-xl transition-shadow duration-300">
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
                    <!-- Cart Icon Button - Repositioned -->
                    <button class="cart-icon-btn absolute right-0 top-0 h-8 w-8 bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-800 rounded-full transition-colors duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </div>
            </a>
            <div class="mx-auto mb-2 w-11/12">
                <!-- Buy Now Button - Full Width -->
                <button class="buy-now-btn w-full h-9 bg-orange-500 hover:bg-orange-600 text-white text-sm uppercase rounded-md transition-colors duration-200 font-semibold">
                    Buy Now
                </button>
            </div>
        </article>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Read all filters from URL on page load
            const urlParams = new URLSearchParams(window.location.search);
            
            // Set price range if in URL
            const minPrice = urlParams.get('price_min');
            const maxPrice = urlParams.get('price_max');
            if (minPrice) {
                document.getElementById('min-price-input').value = minPrice;
                document.getElementById('minPrice').textContent = `Rs. ${Number(minPrice).toLocaleString()}`;
            }
            if (maxPrice) {
                document.getElementById('max-price-input').value = maxPrice;
                document.getElementById('price-range').value = maxPrice;
                document.getElementById('maxPrice').textContent = `Rs. ${Number(maxPrice).toLocaleString()}`;
            }
            
            // Set sort if in URL
            const sort = urlParams.get('sort');
            if (sort) {
                const sortSelect = document.getElementById('sort-select');
                // Convert URL parameter to select option value if needed
                switch(sort) {
                    case 'low':
                    case 'high':
                        sortSelect.value = sort;
                        break;
                    default:
                        sortSelect.value = 'latest';
                }
            }
            
            // Set page if in URL
            const page = parseInt(urlParams.get('page'));
            if (page && page > 0) {
                currentPage = page;
            }

            // Load categories first, then apply filters
            fetch('/api/category')
                .then(response => response.json())
                .then(data => {
                    renderCategories(data.Categories);
                    
                    // Now set categories from URL after they're loaded
                    const categories = urlParams.get('categories');
                    if (categories) {
                        const categoryArray = categories.split(',');
                        categoryArray.forEach(category => {
                            const checkbox = document.querySelector(`input[name="category"][value="${category}"]`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                    
                    // Set sizes if in URL
                    const sizes = urlParams.get('sizes');
                    if (sizes) {
                        const sizeArray = sizes.split(',');
                        sizeArray.forEach(size => {
                            const checkbox = document.querySelector(`input[name="size"][value="${size}"]`);
                            if (checkbox) checkbox.checked = true;
                        });
                    }
                    loadProducts();
                })
                .catch(error => console.error('Error loading categories:', error));
            
            // Initialize other components
            initializePriceRange();
            initializeSizes();
            initializeFilterCollapse();
        });

        // Update these variables at the top of your script
        let currentPage = 1;
        let totalPages = 1;

        function loadProducts(categorySlug = null) {
            try {
                data = @json($Shoes);
                pagination = @json($pagination);
                updatePagination(pagination);
                renderProducts(data);
            } catch (error) {
                 console.error('Error loading products:', error);
            }
        }

        function renderProducts(products) {
            const container = document.getElementById('products-grid');
            const template = document.getElementById('product-template');
            
            container.innerHTML = '';

            if (products.length === 0) {
                container.innerHTML = `
                    <div class="col-span-full text-center py-8">
                        <p class="text-gray-500">No products found matching your criteria.</p>
                    </div>
                `;
                return;
            }

            products.forEach(product => {
                const clone = template.content.cloneNode(true);
                
                const productLink = clone.querySelector('.product-link');
                productLink.href = `/products/${product.article_id}`;
                
                const img = clone.querySelector('.product-image');
                img.src = product.shoe_image;
                img.alt = product.shoe_name;
                
                // Hide discount badge for now
                clone.querySelector('.discount-badge').parentElement.classList.add('hidden');
                
                clone.querySelector('.product-name').textContent = product.shoe_name;
                clone.querySelector('.product-price').textContent = `Rs. ${product.price.toLocaleString()}`;
                
                // Hide original price for now
                clone.querySelector('.original-price').style.display = 'none';
                
                // Update cart icon button click handler
                const cartBtn = clone.querySelector('.cart-icon-btn');
                cartBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = `/products/${product.article_id}`;
                });
                
                // Update Buy Now button handler
                const buyNowBtn = clone.querySelector('.buy-now-btn');
                buyNowBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    window.location.href = `/products/${product.article_id}`;
                });
                
                container.appendChild(clone);
            });
        }

        // Price Range Slider functionality
        function initializePriceRange() {
            const priceRange = document.getElementById('price-range');
            const minPriceInput = document.getElementById('min-price-input');
            const maxPriceInput = document.getElementById('max-price-input');
            const minPriceDisplay = document.getElementById('minPrice');
            const maxPriceDisplay = document.getElementById('maxPrice');

            // Update display when slider changes
            priceRange.addEventListener('input', (e) => {
                const value = e.target.value;
                maxPriceInput.value = value;
                maxPriceDisplay.textContent = `Rs. ${Number(value).toLocaleString()}`;
            });

            // Update slider when min input changes
            minPriceInput.addEventListener('change', (e) => {
                const value = parseInt(e.target.value);
                if (value >= 0 && value <= parseInt(maxPriceInput.value)) {
                    minPriceDisplay.textContent = `Rs. ${Number(value).toLocaleString()}`;
                } else {
                    minPriceInput.value = 0;
                    minPriceDisplay.textContent = 'Rs. 0';
                }
            });

            // Update slider when max input changes
            maxPriceInput.addEventListener('change', (e) => {
                const value = parseInt(e.target.value);
                if (value >= parseInt(minPriceInput.value) && value <= 100000) {
                    priceRange.value = value;
                    maxPriceDisplay.textContent = `Rs. ${Number(value).toLocaleString()}`;
                } else {
                    maxPriceInput.value = 100000;
                    priceRange.value = 100000;
                    maxPriceDisplay.textContent = 'Rs. 100,000';
                }
            });

            // Apply filters button click handler
            document.getElementById('apply-filters').addEventListener('click', applyFilters);
        }

        // Update the pagination function
        function updatePagination(paginationData) {
            const prevButton = document.getElementById('prev-page');
            const nextButton = document.getElementById('next-page');
            const pageInfo = document.getElementById('page-info');

            // Update buttons state
            console.log(paginationData);
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === paginationData.last_page;
            pageInfo.textContent = `Page ${currentPage} of ${paginationData.last_page}`;
            totalPages = paginationData.last_page;

            // Update URL with current page while preserving other filters
            const newUrl = new URL(window.location.href);
            newUrl.searchParams.set('page', currentPage);
            window.history.replaceState({}, '', newUrl.toString());
        }

        // Update pagination event listeners
        document.getElementById('prev-page').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                applyFilters(true); // Pass true to indicate pagination change
            }
        });

        document.getElementById('next-page').addEventListener('click', () => {
            if (currentPage < totalPages) {
                currentPage++;
                applyFilters(true); // Pass true to indicate pagination change
            }
        });

        // Modify applyFilters to handle pagination
        function applyFilters(isPagination = false) {
            // Reset to page 1 only if it's not a pagination action
            if (!isPagination) {
                currentPage = 1;
            }
            
            // Get filter values
            const minPrice = parseInt(document.getElementById('min-price-input').value);
            const maxPrice = parseInt(document.getElementById('max-price-input').value);
            const selectedCategories = Array.from(document.querySelectorAll('input[name="category"]:checked'))
                .map(checkbox => checkbox.value);
            const selectedSizes = Array.from(document.querySelectorAll('input[name="size"]:checked'))
                .map(checkbox => checkbox.value);
            const sortBy = document.getElementById('sort-select').value;
            
            // Create new URL object with base path only
            const newUrl = new URL(window.location.origin + window.location.pathname);
            
            // Only add page number if greater than 1
            if (currentPage > 1) {
                newUrl.searchParams.set('page', currentPage);
            }
            
            // Only add price filter if it's not the default range
            if (!isNaN(minPrice) && !isNaN(maxPrice) && (minPrice > 0 || maxPrice < 100000)) {
                if (minPrice > 0) newUrl.searchParams.set('price_min', minPrice);
                if (maxPrice < 100000) newUrl.searchParams.set('price_max', maxPrice);
            }
            
            // Only add categories if any are selected
            if (selectedCategories.length > 0) {
                newUrl.searchParams.set('categories', selectedCategories.join(','));
            }
            
            // Only add sizes if any are selected
            if (selectedSizes.length > 0) {
                newUrl.searchParams.set('sizes', selectedSizes.join(','));
            }
            
            // Only add sort if it's not the default 'latest'
            if (sortBy && sortBy !== 'latest') {
                newUrl.searchParams.set('sort', sortBy);
            }

            window.location.href = newUrl.toString();
        }

        function loadCategories() {
            fetch('/api/category')
                .then(response => response.json())
                .then(data => {
                    console.log("API Response:", data);
                    renderCategories(data.Categories);
                    
                    // Check for category parameter in URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const categorySlug = urlParams.get('category');
                    
                    if (categorySlug) {
                        const categoryCheckbox = document.querySelector(`input[value="${categorySlug}"]`);
                        if (categoryCheckbox) {
                            categoryCheckbox.checked = true;
                            applyFilters();
                        }
                    }
                })
                .catch(error => console.error('Error loading categories:', error));
        }

        function renderCategories(categories) {
            const container = document.getElementById('categories-list');
            container.innerHTML = '';
            
            categories.forEach(category => {
                console.log(category);
                const categoryItem = document.createElement('div');
                categoryItem.className = 'flex items-center mb-2';
                categoryItem.innerHTML = `
                    <label class="flex items-center cursor-pointer group">
                        <input type="checkbox" 
                               class="form-checkbox h-4 w-4 text-gray-900 border-gray-300 rounded focus:ring-gray-900"
                               value="${category.name}"
                               name="category">
                        <span class="ml-2 text-gray-700 group-hover:text-gray-900">
                            ${category['name']}
                        </span>
                    </label>
                `;
                container.appendChild(categoryItem);
            });
        }

        function initializeSizes() {
            const sizes = [
                { eu: "35", available: true },
                { eu: "36", available: true },
                { eu: "37", available: true },
                { eu: "38", available: true },
                { eu: "39", available: true },
                { eu: "40", available: true },
                { eu: "41", available: true },
                { eu: "42", available: true },
                { eu: "43", available: true },
                { eu: "44", available: true },
            ];
            
            renderSizes(sizes);
        }

        function renderSizes(sizes) {
            const container = document.getElementById('sizes-list');
            container.innerHTML = '';

            sizes.forEach(size => {
                const sizeDiv = document.createElement('div');
                sizeDiv.className = 'flex items-center';
                
                const id = `size-${size.eu}`;
                sizeDiv.innerHTML = `
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="${id}" 
                               name="size" 
                               value="${size.eu}"
                               class="h-5 w-5 rounded border-gray-300 text-gray-900 focus:ring-gray-900 cursor-pointer"
                               ${size.available ? '' : 'disabled'}
                        >
                        <label for="${id}" class="ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                            EU ${size.eu}
                        </label>
                    </div>
                `;

                if (!size.available) {
                    const input = sizeDiv.querySelector('input');
                    const label = sizeDiv.querySelector('label');
                    input.classList.add('opacity-50');
                    label.classList.add('opacity-50');
                }

                container.appendChild(sizeDiv);
            });
        }

        function resetSizes() {
            document.querySelectorAll('input[name="size"]').forEach(checkbox => {
                checkbox.checked = false;
            });
        }

        function initializeFilterCollapse() {
            const collapseButton = document.getElementById('collapse-filters');
            const filterContent = document.getElementById('filter-content');
            const collapseArrow = document.getElementById('collapse-arrow');
            let isContentVisible = false;

            collapseButton.addEventListener('click', () => {
                isContentVisible = !isContentVisible;
                
                // Toggle content visibility with slide animation
                if (!isContentVisible) {
                    filterContent.style.maxHeight = '0';
                    filterContent.style.opacity = '0';
                    collapseArrow.style.transform = 'rotate(180deg)';
                } else {
                    filterContent.style.maxHeight = filterContent.scrollHeight + 'px';
                    filterContent.style.opacity = '1';
                    collapseArrow.style.transform = 'rotate(0)';
                }
            });

            // Handle resize
            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) { // md breakpoint
                    filterContent.style.maxHeight = 'none';
                    filterContent.style.opacity = '1';
                    collapseArrow.style.transform = 'rotate(0)';
                    isContentVisible = true;
                }
            });
        }

        // Add event listener for sort changes
        document.getElementById('sort-select').addEventListener('change', () => {
            applyFilters();
        });
    </script>

    <style>
        /* Add these styles for better button interactions */
        .size-btn:focus {
            outline: none;
            ring-2 ring-gray-900 ring-offset-2;
        }

        .size-btn:disabled {
            opacity: 0.7;
        }

        /* Custom checkbox styles */
        input[type="checkbox"] {
            @apply rounded border-gray-300;
        }

        input[type="checkbox"]:checked {
            @apply bg-gray-900 border-gray-900;
        }

        input[type="checkbox"]:focus {
            @apply ring-2 ring-gray-900 ring-offset-2;
        }

        input[type="checkbox"]:disabled {
            @apply bg-gray-100 border-gray-200;
        }

        /* Add smooth transitions for collapse animation */
        #filter-content {
            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            overflow: hidden;
            max-height: 2000px; /* Adjust based on your content */
        }

        #collapse-arrow {
            transition: transform 0.3s ease;
        }

        /* Hide collapse button on desktop */
        @media (min-width: 768px) {
            #collapse-filters {
                display: none;
            }
        }

        /* Hide filter sidebar on mobile on load */
        @media (max-width: 768px) {
            #filter-content {
                max-height: 0;
                opacity: 0;
            }

            #collapse-arrow {
                transform: rotate(180deg);
            }
        }

        /* Additional styling for product cards */
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
        
        article {
            transition: all 0.3s ease;
        }
    </style>
</body>
</html> 