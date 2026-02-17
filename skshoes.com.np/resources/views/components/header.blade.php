<nav @class([
    'shadow-sm relative',
    'border-b-2 border-b-[#49280d]' => !Request::is('/'),
])>

  <div class="absolute inset-0 bg-[url('/assets/images/background.png')] bg-cover bg-start opacity-100 bg-no-repeat"></div>
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-3 mb-0 relative z-10">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{ asset('assets/images/logo.png') }}" class="h-16" alt="S.K. Shoes Logo" />
      <span class="hidden sm:block self-center font-futura text-2xl font-extrabold text-[#49280d] dark:text-[#49280d] tracking-wide">
        S.K. SHOES
      </span>
    </a>


    <div class="flex items-center md:order-3 gap-4">
      <!-- Search Button for Mobile -->
      <button data-collapse-toggle="navbar-search" type="button" 
              class="md:hidden text-black bg-white/90 hover:bg-white focus:outline-none focus:ring-4 focus:ring-gray-200 rounded-lg text-sm p-2.5 me-1" 
              aria-controls="navbar-search" 
              aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
      </button>
      <!-- Search input for Desktop -->
      <div class="relative hidden md:block">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </div>
        <input type="text" 
               id="desktop-search-input"
               class="block w-full p-2 ps-10 text-sm text-black font-semibold border-2 border-gray-300 rounded-lg bg-white/90 hover:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
               placeholder="Search products...">
        <div id="desktop-search-results" class="absolute z-50 right-0 w-[300px] mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-96 overflow-y-auto">
            <!-- Search results will be populated here -->
        </div>
      </div>
      <!-- Mobile Search Input (Hidden by default) -->
      <div class="items-center justify-between fixed left-0 right-0 md:hidden hidden bg-white dark:bg-gray-800 p-4 shadow-lg z-50" id="navbar-search" style="top: 72px;">
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-5 h-5 text-black dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="text" 
                 id="mobile-search-input"
                 class="block w-full p-3 ps-12 text-base text-black font-semibold border border-gray-300 rounded-lg bg-white/90 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white placeholder-black" 
                 placeholder="Search products..."
                 autocomplete="off">
          <div id="mobile-search-results" class="absolute z-50 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden max-h-96 overflow-y-auto">
              <!-- Search results will be populated here -->
          </div>
        </div>
      </div>
      <!-- Cart Dropdown -->
      <div class="relative">
        <a href="{{ route('cart') }}" class="relative flex items-center justify-center bg-white/90 hover:bg-white p-2.5 rounded-lg shadow-sm border-2 border-gray-300 transition-all duration-200" id="cart-icon">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center font-semibold shadow-sm">0</span>
        </a>
      </div>
      <!-- Mobile menu button -->
      <button data-collapse-toggle="navbar-solid-bg" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-black rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2" aria-controls="navbar-solid-bg" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
    </div>

    <div id="navbar-solid-bg" class="hidden fixed md:relative top-20 left-0 right-0 z-40 md:bg-transparent md:top-auto md:left-auto md:right-auto md:z-auto w-full md:block md:w-auto md:order-2">
      <ul class="flex flex-col font-bold p-4 md:p-0 mt-4 rounded-lg bg-[#f3e0c7] md:space-x-7 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
        <li>
          <a href="/" class="block py-2 px-3 md:p-0 text-base text-[#49280d] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-[#49280d] md:dark:hover:text-blue-500 dark:hover:bg-[#e6cdaa] dark:hover:text-[#49280d] md:dark:hover:bg-transparent tracking-wide">HOME</a>
        </li>
        <li>
          <a href="{{ route('products') }}" class="block py-2 px-3 md:p-0 text-base text-[#49280d] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-[#49280d] md:dark:hover:text-blue-500 dark:hover:bg-[#e6cdaa] dark:hover:text-[#49280d] md:dark:hover:bg-transparent tracking-wide">PRODUCT</a>
        </li>
        <li>
          <a href="{{ route('about') }}" class="block py-2 px-3 md:p-0 text-base text-[#49280d] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-[#49280d] md:dark:hover:text-blue-500 dark:hover:bg-[#e6cdaa] dark:hover:text-[#49280d] md:dark:hover:bg-transparent tracking-wide">ABOUT</a>
        </li>
        <li>
          <a href="{{ route('contact') }}" class="block py-2 px-3 md:p-0 text-base text-[#49280d] rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-[#49280d] md:dark:hover:text-blue-500 dark:hover:bg-[#e6cdaa] dark:hover:text-[#49280d] md:dark:hover:bg-transparent tracking-wide">CONTACT US</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Add this script section at the end of the file -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    initializeCart();
    initializeNavToggle();
    initializeSearchToggle();

    // Listen for cart updates from any page
    document.addEventListener('cartUpdated', function() {
      initializeCart(); // Refresh cart when updated
    });
  });

  // Cart functionality
  function handleAddToCart(productId) {
    fetch('/cookie', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        article_id: productId
      })
    })
    .then(response => response.json())
    .then(data => {
      initializeCart(); // Refresh cart after adding item
      // Add animation to cart count
      const cartCount = document.querySelector('.cart-count');
      cartCount.classList.add('scale-125');
      setTimeout(() => cartCount.classList.remove('scale-125'), 300);
    })
    .catch(error => console.error('Error adding to cart:', error));
  }

  function initializeCart() {
    fetch('/cookie')
      .then(response => response.json())
      .then(data => {
        const cartCount = document.querySelector('.cart-count');
        if (data.cartItems && data.cartItems.length > 0) {
          cartCount.textContent = data.cartItems.length;
          updateCartPreview(data.cartItems);
          document.getElementById('clear-cart-btn')?.removeAttribute('disabled');
        } else {
          cartCount.textContent = '0';
          updateCartPreview([]);
          document.getElementById('clear-cart-btn')?.setAttribute('disabled', 'disabled');
        }
      })
      .catch(error => console.error('Error loading cart:', error));
  }

  function updateCartPreview(cartItems) {
    const cartPreview = document.getElementById('cart-preview');
    const cartTotal = document.getElementById('cart-total');
    
    if (!cartItems || cartItems.length === 0) {
      cartPreview.innerHTML = '<p class="text-gray-500 text-center py-2">Your cart is empty</p>';
      cartTotal.textContent = 'Rs. 0';
      return;
    }

    let total = 0;
    cartPreview.innerHTML = cartItems.map(item => {
      total += parseFloat(item.price);
      return `
        <div class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded">
          <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-cover rounded">
          <div class="flex-1">
            <h4 class="text-sm font-medium">${item.name}</h4>
            <p class="text-sm text-gray-500">Rs. ${parseFloat(item.price).toLocaleString()}</p>
          </div>
          <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700 p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      `;
    }).join('');

    cartTotal.textContent = `Rs. ${total.toLocaleString()}`;
  }

  function removeFromCart(itemId) {
    fetch(`/cookie/${itemId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => response.json())
    .then(() => {
      initializeCart(); // Refresh cart after removing item
    })
    .catch(error => console.error('Error removing from cart:', error));
  }

  // Existing navigation and search toggle functions
  // function initializeNavToggle() {
  //   const toggleButton = document.querySelector('[data-collapse-toggle="navbar-solid-bg"]');
  //   const navMenu = document.getElementById('navbar-solid-bg');

  //   toggleButton.addEventListener('click', function() {
  //     // Toggle the 'hidden' class
  //     navMenu.classList.toggle('hidden');
      
  //     // Update aria-expanded attribute
  //     const isExpanded = navMenu.classList.contains('hidden') ? 'false' : 'true';
  //     toggleButton.setAttribute('aria-expanded', isExpanded);
  //   });
  // }
  function initializeNavToggle() {
    const toggleButton = document.querySelector('[data-collapse-toggle="navbar-solid-bg"]');
    const navMenu = document.getElementById('navbar-solid-bg');

    let isMenuOpen = false;

    toggleButton.addEventListener('click', function () {
      navMenu.classList.toggle('hidden');
      isMenuOpen = !navMenu.classList.contains('hidden');
      toggleButton.setAttribute('aria-expanded', isMenuOpen ? 'true' : 'false');

      if (isMenuOpen) {
        document.addEventListener('click', closeOnOutsideClick);
        document.addEventListener('touchstart', closeOnOutsideClick);
        document.addEventListener('scroll', closeOnScroll, { passive: true });
      } else {
        cleanup();
      }
    });

    function closeOnOutsideClick(event) {
      if (!navMenu.contains(event.target) && !toggleButton.contains(event.target)) {
        closeMenu();
      }
    }

    function closeOnScroll() {
      closeMenu();
    }

    function closeMenu() {
      navMenu.classList.add('hidden');
      toggleButton.setAttribute('aria-expanded', 'false');
      isMenuOpen = false;
      cleanup();
    }

    function cleanup() {
      document.removeEventListener('click', closeOnOutsideClick);
      document.removeEventListener('touchstart', closeOnOutsideClick);
      document.removeEventListener('scroll', closeOnScroll);
    }
  }


  function initializeSearchToggle() {
    const searchButton = document.querySelector('[data-collapse-toggle="navbar-search"]');
    const searchBar = document.getElementById('navbar-search');
    const searchInput = searchBar.querySelector('input');

    searchButton.addEventListener('click', function() {
      // Toggle the 'hidden' class
      searchBar.classList.toggle('hidden');
      
      // Update aria-expanded attribute
      const isExpanded = !searchBar.classList.contains('hidden');
      searchButton.setAttribute('aria-expanded', isExpanded);

      // Focus input when opened
      if (isExpanded) {
        setTimeout(() => {
          searchInput.focus();
          document.body.classList.add('search-open');
        }, 100);
      } else {
        document.body.classList.remove('search-open');
      }
    });

    // Close search on backdrop click
    document.addEventListener('click', function(event) {
      if (!searchBar.classList.contains('hidden') && 
          !searchBar.contains(event.target) && 
          !searchButton.contains(event.target)) {
        searchButton.click();
      }
    });

    // Close search on escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape' && !searchBar.classList.contains('hidden')) {
        searchButton.click();
      }
    });
  }

  // Make cart functions globally available
  window.handleAddToCart = handleAddToCart;
  window.removeFromCart = removeFromCart;
</script>

<style>

  /* Add Sunborn font */
  @font-face {
    font-family: 'Sunborn';
    src: url('/assets/fonts/Sunborn.otf') format('opentype');
    font-weight: normal;
    font-style: normal;
  }

  /* Add Aubette font */
  @font-face {
    font-family: 'Aubette';
    src: url('/assets/fonts/Aubette.otf') format('opentype');
    font-weight: normal;
    font-style: normal;
  }

  /* Add Sunborn font to logo text */
  .self-center.text-2xl.font-extrabold.text-black.dark\:text-white.tracking-wide {
    font-family: 'Sunborn', sans-serif;
  }

  /* Add Sunborn font to navigation menu items */
  #navbar-solid-bg ul li a {
    font-family: 'Sunborn', sans-serif;
  }


  /* Cart-specific styles */
  .cart-count {
    transition: transform 0.2s ease-in-out;
  }
  
  .scale-125 {
    transform: scale(1.25);
  }

  /* Existing styles */
  html {
    scroll-behavior: smooth;
  }

  /* Ensure smooth scrolling works */
  html {
    scroll-behavior: smooth;
  }

  /* Add active state for contact link */
  a[href="#contact"].active {
    color: #1d4ed8; /* blue-700 */
  }

  /* Improved search toggle animation */
  #navbar-search {
    transition: all 0.3s ease-in-out;
    transform-origin: top;
  }

  #navbar-search.hidden {
    transform: translateY(-10px);
    opacity: 0;
  }

  #navbar-search:not(.hidden) {
    transform: translateY(0);
    opacity: 1;
  }

  /* Prevent body scroll when search is open */
  body.search-open {
    overflow: hidden;
  }

  /* Add these styles at the end of the existing styles */
  nav + div, 
  nav + section,
  nav + main {
    margin-top: 0.5rem !important; /* Overrides any other margins */
    padding-top: 0.5rem !important;
  }

  /* Search results scrollbar styling */
  #desktop-search-results, #mobile-search-results {
    scrollbar-width: thin;
    scrollbar-color: #CBD5E0 #EDF2F7;
  }

  #desktop-search-results::-webkit-scrollbar,
  #mobile-search-results::-webkit-scrollbar {
    width: 6px;
  }

  #desktop-search-results::-webkit-scrollbar-track,
  #mobile-search-results::-webkit-scrollbar-track {
    background: #EDF2F7;
  }

  #desktop-search-results::-webkit-scrollbar-thumb,
  #mobile-search-results::-webkit-scrollbar-thumb {
    background-color: #CBD5E0;
    border-radius: 3px;
  }

  /* Add to your existing styles */
  #mobile-search-results {
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
    position: fixed;
    left: 0;
    right: 0;
    top: calc(72px + 4rem); /* Adjust based on your navbar height + search input height */
    max-height: calc(100vh - 72px - 4rem);
    background: white;
    z-index: 1000;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    touch-action: pan-y;
    overflow-y: auto;
  }

  #navbar-search {
    position: fixed;
    left: 0;
    right: 0;
    background: white;
    z-index: 1001;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  /* Prevent pull-to-refresh on mobile */
  body.search-open {
    overscroll-behavior-y: contain;
    position: fixed;
    width: 100%;
    height: 100%;
  }

  /* Smooth scrolling for search results */
  #mobile-search-results {
    scroll-behavior: smooth;
  }

  /* Add active state for touch feedback */
  .search-result-item:active {
    background-color: rgba(0,0,0,0.05);
  }

  /* Add smooth momentum scrolling */
  .smooth-scroll {
    -webkit-overflow-scrolling: touch;
    scroll-behavior: smooth;
  }

  /* Add this for better touch feedback */
  .search-result-item {
    touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
  }
</style>

<script>
    function initializeSearch() {
        const desktopInput = document.getElementById('desktop-search-input');
        const mobileInput = document.getElementById('mobile-search-input');
        const desktopResults = document.getElementById('desktop-search-results');
        const mobileResults = document.getElementById('mobile-search-results');

        let debounceTimer;

        function debounce(func, wait) {
            return function(...args) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => func.apply(this, args), wait);
            };
        }

        function performSearch(searchTerm, resultsContainer) {
            if (searchTerm.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }

            // Show loading state
            resultsContainer.innerHTML = '<div class="p-4 text-center text-gray-500">Searching...</div>';
            resultsContainer.classList.remove('hidden');

            // Use the /api endpoint since it's already working with search
            fetch(`/api/shoes?search=${encodeURIComponent(searchTerm)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.Shoes && data.Shoes.length > 0) {
                        const resultsHtml = data.Shoes.map(shoe => `
                            <a href="/products/${shoe.article_id}" 
                               class="search-result-item block p-4 hover:bg-gray-50 border-b last:border-b-0 active:bg-gray-100"
                               ontouchstart="this.classList.add('active')"
                               ontouchend="this.classList.remove('active')">
                                <div class="flex items-center gap-4">
                                    <img src="${shoe.shoe_image}" 
                                         alt="${shoe.shoe_name}" 
                                         onerror="this.src='/assets/images/no-image.png'" 
                                         class="w-16 h-16 object-cover rounded-lg border">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900 truncate">${shoe.shoe_name}</h3>
                                        <p class="text-sm text-gray-500">${shoe.category_name}</p>
                                        <p class="text-sm font-semibold text-gray-900">Rs. ${shoe.price?.toLocaleString() ?? 'N/A'}</p>
                                    </div>
                                </div>
                            </a>
                        `).join('');
                        
                        resultsContainer.innerHTML = resultsHtml;
                    } else {
                        resultsContainer.innerHTML = `
                            <div class="p-4 text-center text-gray-500">
                                <p>No products found</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <p>Error performing search. Please try again.</p>
                        </div>
                    `;
                });
        }

        const debouncedSearch = debounce((searchTerm, resultsContainer) => {
            performSearch(searchTerm, resultsContainer);
        }, 300);

        // Desktop search
        desktopInput.addEventListener('input', (e) => {
            debouncedSearch(e.target.value, desktopResults);
        });

        // Mobile search
        mobileInput.addEventListener('input', (e) => {
            debouncedSearch(e.target.value, mobileResults);
        });

        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            if (!desktopInput.contains(e.target) && !desktopResults.contains(e.target)) {
                desktopResults.classList.add('hidden');
            }
            if (!mobileInput.contains(e.target) && !mobileResults.contains(e.target)) {
                mobileResults.classList.add('hidden');
            }
        });

        // Handle keyboard navigation
        [desktopInput, mobileInput].forEach(input => {
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    const results = input.id.includes('desktop') ? desktopResults : mobileResults;
                    results.classList.add('hidden');
                }
            });
        });

        // Add touch handling for mobile
        let touchStartY = 0;
        let touchEndY = 0;
        const mobileSearchBar = document.getElementById('navbar-search');
        const mobileSearchInput = document.getElementById('mobile-search-input');
        const mobileResultsContainer = document.getElementById('mobile-search-results');

        // Touch start handler
        mobileSearchBar.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });

        // Touch move handler
        mobileSearchBar.addEventListener('touchmove', function(e) {
            touchEndY = e.touches[0].clientY;
            const deltaY = touchEndY - touchStartY;

            // If scrolling up and at top of results, allow body scroll
            if (deltaY > 0 && mobileResultsContainer.scrollTop === 0) {
                document.body.style.overflow = 'auto';
            } else if (deltaY < 0) {
                // If scrolling down, prevent body scroll
                document.body.style.overflow = 'hidden';
            }
        }, { passive: true });

        // Touch end handler
        mobileSearchBar.addEventListener('touchend', function() {
            // Reset touch coordinates
            touchStartY = 0;
            touchEndY = 0;
        }, { passive: true });

        // Prevent body scroll when focusing on search input
        mobileSearchInput.addEventListener('focus', function() {
            document.body.style.overflow = 'hidden';
        });

        // Allow body scroll when blurring search input
        mobileSearchInput.addEventListener('blur', function() {
            document.body.style.overflow = 'auto';
        });

        // Update mobile results container styles
        if (mobileResultsContainer) {
            mobileResultsContainer.style.maxHeight = '60vh';
            mobileResultsContainer.style.overscrollBehavior = 'contain';
        }
    }

    // Initialize search when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeSearch();
        // Make sure this doesn't conflict with your existing DOMContentLoaded listeners
    });

    function initializeTouchScroll() {
        const mobileResults = document.getElementById('mobile-search-results');
        let startY = 0;
        let startScrollTop = 0;
        let touchInProgress = false;

        mobileResults.addEventListener('touchstart', function(e) {
            touchInProgress = true;
            startY = e.touches[0].pageY;
            startScrollTop = mobileResults.scrollTop;

            // Add smooth scrolling class
            mobileResults.classList.add('smooth-scroll');
        }, { passive: true });

        mobileResults.addEventListener('touchmove', function(e) {
            if (!touchInProgress) return;

            const touch = e.touches[0];
            const deltaY = startY - touch.pageY;
            const newScrollTop = startScrollTop + deltaY;

            // Check if we're at the top or bottom of the scroll container
            if (newScrollTop < 0) {
                // At the top, allow some resistance
                mobileResults.scrollTop = newScrollTop / 3;
            } else if (newScrollTop > mobileResults.scrollHeight - mobileResults.clientHeight) {
                // At the bottom, allow some resistance
                const overscroll = newScrollTop - (mobileResults.scrollHeight - mobileResults.clientHeight);
                mobileResults.scrollTop = mobileResults.scrollHeight - mobileResults.clientHeight + (overscroll / 3);
            } else {
                // Normal scrolling
                mobileResults.scrollTop = newScrollTop;
            }
        }, { passive: true });

        mobileResults.addEventListener('touchend', function() {
            touchInProgress = false;
            
            // Remove smooth scrolling class after touch ends
            setTimeout(() => {
                mobileResults.classList.remove('smooth-scroll');
            }, 300);

            // Bounce back if overscrolled
            if (mobileResults.scrollTop < 0) {
                mobileResults.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } else if (mobileResults.scrollTop > mobileResults.scrollHeight - mobileResults.clientHeight) {
                mobileResults.scrollTo({
                    top: mobileResults.scrollHeight - mobileResults.clientHeight,
                    behavior: 'smooth'
                });
            }
        }, { passive: true });

        // Prevent body scroll when searching
        const mobileSearchInput = document.getElementById('mobile-search-input');
        mobileSearchInput.addEventListener('focus', function() {
            document.body.style.overflow = 'hidden';
        });

        // Handle scroll lock when search results are showing
        const searchResults = document.getElementById('mobile-search-results');
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.target.classList.contains('hidden')) {
                    document.body.style.overflow = 'auto';
                } else {
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        observer.observe(searchResults, {
            attributes: true,
            attributeFilter: ['class']
        });
    }

    // Call the initialization function
    initializeTouchScroll();
</script>