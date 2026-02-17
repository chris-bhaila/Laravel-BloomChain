@if (session('error'))
    <script>
        window.location.href = '../';
    </script>
@endif
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Shopping Cart - SK Shoes</title>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body>
    <x-header />
    {{-- For Success message --}}
    @if (session('success'))
        <main x-data="app" x-init="openToast()">
            <button type="button" @click="closeToast()" x-show="open" x-transition.duration.300ms
                class="fixed right-4 top-4 z-50 rounded-md bg-green-500 px-4 py-2 text-white transition hover:bg-green-600">
                <div class="flex items-center space-x-2">
                    <span class="text-3xl"><i class="bx bx-check"></i></span>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </button>
        </main>
    @endif
    {{-- For Error message --}}
    @if (session('error'))
        <main x-data="app" x-init="openToast()">
            <button type="button" @click="closeToast()" x-show="open" x-transition.duration.300ms
                class="fixed right-4 top-4 z-50 rounded-md bg-red-500 px-4 py-2 text-white transition hover:bg-red-600">
                <div class="flex items-center space-x-2">
                    <span class="text-3xl"><i class="bx bx-x"></i></span>
                    <p class="font-bold">{{ session('error') }}</p>
                </div>
            </button>
        </main>
    @endif
    <script>
        let timer;

        document.addEventListener("alpine:init", () => {
            Alpine.data("app", () => ({
                open: false,

                openToast() {
                    if (this.open) return;
                    this.open = true;
                },

                closeToast() {
                    this.open = false;
                },
            }));
        });
    </script>

    <div class="bg-gray-100 min-h-screen py-4">
        <div class="container mx-auto px-4">
            <div class="flex items-center gap-4 mb-4">
                <a href="{{ url()->previous() != route('cookie') ? url()->previous() : route('products') }}" class="text-blue-500 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <h1 class="text-2xl font-semibold">Shopping Cart</h1>
            </div>

            <div class="flex flex-col md:flex-row gap-4">
                <div class="md:w-3/4">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Cart Items</h2>
                            <button onclick="showClearCartModal()" 
                                    class="text-red-500 hover:text-red-600 text-sm font-medium flex items-center gap-1"
                                    id="clear-cart-btn"
                                    disabled>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Clear Cart
                            </button>
                        </div>
                        <!-- Hide table on mobile, show cards instead -->
                        <div class="hidden md:block">
                            <table class="w-full">
                                <thead>
                                    <tr>
                                        <th class="text-left font-semibold">Product</th>
                                        {{-- <th class="text-left font-semibold">Price</th> --}}
                                        <th class="text-left font-semibold">Type</th>
                                        <th class="text-left font-semibold">Total</th>
                                        <th class="text-left font-semibold"></th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items-table">
                                    <!-- Cart items for desktop will be populated here -->
                                </tbody>
                            </table>
                        </div>
                        <!-- Mobile cart items -->
                        <div class="md:hidden">
                            <div id="cart-items-mobile" class="space-y-4">
                                <!-- Cart items for mobile will be populated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Add payment info/disclaimer below cart items -->
                    <div class="bg-blue-50 rounded-lg shadow-sm p-4 mb-4">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M17.707 9.293a1 1 0 010 1.414l-7 7a1 1 0 01-1.414 0l-7-7A.997.997 0 012 10V5a3 3 0 013-3h5c.256 0 .512.098.707.293l7 7zM5 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <p class="font-medium text-gray-800">Secure Payment Options:</p>
                                <p class="text-gray-600 text-sm mt-1">
                                    We offer multiple secure payment methods for your convenience:
                                </p>
                                <ul class="mt-2 space-y-1 text-sm text-gray-600">
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        eSewa - Fast and secure digital payments
                                    </li>
                                    {{-- <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Khalti - Trusted digital wallet service
                                    </li> --}}
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Cash on Delivery
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/4">
                    <!-- City Selection -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-3">
                        <h2 class="text-lg font-semibold mb-2">Delivery Location</h2>
                        <div class="flex gap-2 mb-2">
                            <select id="city" 
                                    class="border rounded-lg px-2 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" selected disabled>Select a city</option>
                                <!-- Cities will be populated here -->
                            </select>
                        </div>
                    </div>

                    <!-- Discount Codes Section -->
                    <div class="bg-white rounded-lg shadow-md p-4 mb-3">
                        <h2 class="text-lg font-semibold mb-2">Discount Codes</h2>
                        <div class="flex gap-2 mb-2">
                            <input type="text" 
                                   id="discount-code" 
                                   class="border rounded-lg px-2 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                   placeholder="Enter code">
                            <button onclick="applyDiscount()" 
                                    class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 transition-colors duration-300">
                                Apply
                            </button>
                        </div>
                        <div id="applied-discounts" class="space-y-2">
                            <!-- Applied discount codes will appear here -->
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-lg font-semibold mb-4">Summary</h2>
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span id="subtotal">Rs. 0</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Discount</span>
                            <span id="discount" class="text-red-500">- Rs. 0</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Shipping</span>
                            <span id="shipping">Rs. 0</span>
                        </div>
                        <hr class="my-2">
                        <div class="flex justify-between mb-2">
                            <span class="font-semibold">Total</span>
                            <span class="font-semibold" id="total">Rs. 0</span>
                        </div>

                        <!-- New Shipping Form -->
                        <form method="POST" action="/checkout" class="mt-6">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                    <input type="text" 
                                           id="name" 
                                           name="customer_name" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your full name">
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" 
                                           id="phone" 
                                           name="phone_number" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your phone number">
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your email">
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea id="address" 
                                              name="address" 
                                              required
                                              rows="2"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="Enter your delivery address"></textarea>
                                </div>

                                <div>
                                    <label for="landmark" class="block text-sm font-medium text-gray-700 mb-1">Nearest Landmark</label>
                                    <input type="text" 
                                           id="landmark" 
                                           name="nearest_landmark" 
                                           required
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter nearest landmark">
                                    <p class="mt-1 text-sm text-gray-500">
                                        Famous places nearby (e.g., temples, schools, hospitals, shopping centers)
                                    </p>
                                </div>
                            </div>
                        </form>

                        <button id="checkout-btn" title=""
                                class="bg-blue-500 text-white py-2 px-4 rounded-lg mt-4 w-full hover:bg-blue-600 transition-colors duration-300 disabled:opacity-50">
                            Checkout
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method Modal -->
    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Select Payment Method</h2>
                <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <button onclick="processPayment('esewa')" class="payment-method-btn p-4 border rounded-lg hover:border-blue-500 transition-colors duration-300">
                    <img src="{{ asset('assets/images/esewa.png') }}" alt="eSewa" class="w-full h-20 object-contain mb-2">
                    <span class="block text-center font-medium">Pay with eSewa</span>
                </button>
                {{-- <button onclick="processPayment('khalti')" class="payment-method-btn p-4 border rounded-lg hover:border-blue-500 transition-colors duration-300">
                    <img src="{{ asset('assets/images/khalti.png') }}" alt="Khalti" class="w-full h-20 object-contain mb-2">
                    <span class="block text-center font-medium">Pay with Khalti</span>
                </button> --}}
                <div class="payment-method-btn p-4 border rounded-lg sm:col-span-2 cursor-pointer hover:border-blue-500 transition-colors duration-300" onclick="processPayment('cod')">
                    <div class="flex items-center justify-center h-20 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="block text-center font-medium">Cash on Delivery</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Clear Cart Confirmation Modal -->
    <div id="clear-cart-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <svg class="mx-auto mb-4 h-12 w-12 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h2 class="text-xl font-semibold mb-2">Clear Shopping Cart?</h2>
                <p class="text-gray-600 mb-6">Are you sure you want to remove all items from your cart? This action cannot be undone.</p>
                <div class="flex justify-center gap-4">
                    <button onclick="closeClearCartModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button onclick="clearCart()" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>

      <!-- Update the empty cart toast notification -->
      <div id="empty-cart-toast" class="fixed right-2 md:right-4 top-4 z-50 hidden w-[calc(100%-1rem)] md:w-auto max-w-[90%] md:max-w-none">
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-3 md:p-4 rounded-lg shadow-lg" role="alert">
            <div class="flex items-center">
                <svg class="h-4 w-4 md:h-5 md:w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="font-medium text-sm md:text-base">Your cart is now empty</p>
            </div>
        </div>
    </div>

    <!--Footer -->
    <x-footer />

    <script>
    let cartData = null;
    let appliedDiscounts = new Map();

    document.addEventListener('DOMContentLoaded', function() {
        // Fetch cart data
        fetchCartData();
        
        // Event delegation for dynamic elements
        document.addEventListener('click', function(e) {
            const removeButton = e.target.closest('.remove-item');
            if (removeButton) {
                const cartItem = removeButton.closest('[data-item-id]');
                const itemKey = cartItem.getAttribute('data-item-id');
                if (itemKey) {
                    removeItem(itemKey);
                }
            }
        });

        // Add event listener for clear cart button
        document.getElementById('clear-cart-btn').addEventListener('click', showClearCartModal);

        // Load cities
        loadCities();
        toggleButton();
    });

    const form = document.querySelector("form");
    const checkoutBtn = document.getElementById("checkout-btn");
    const delivery_location = document.getElementById("city");
    
    form.addEventListener("input", toggleButton);
    delivery_location.addEventListener('change', toggleButton);
    
    function toggleButton() {
        const inputs = form.querySelectorAll("input, textarea");
        let isFormValid = true;

        inputs.forEach(input => {
            if (input.value.trim() === "") {
                isFormValid = false;
            }
        });

        if (delivery_location.value === "") {
            isFormValid = false;
        }
        checkoutBtn.disabled = !isFormValid;
        checkoutBtn.title = checkoutBtn.disabled ? "Fill all fields and Select a Delivery Location to proceed" : "";
    }

    async function fetchCartData() {
        try {
            const response = await fetch('/cookie');
            const data = await response.json();
            cartData = {
                items: data.cartItems
            };
            renderCart();
            await updateCartTotals();
        } catch (error) {
            console.error('Error loading cart data:', error);
        }
    }

    function renderCart() {
        const cartItemsTable = document.getElementById('cart-items-table');
        const cartItemsMobile = document.getElementById('cart-items-mobile');
        
        if (!cartData.items.length) {
            const emptyMessage = `
                <div class="py-4 md:py-8 text-center px-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 md:h-16 w-12 md:w-16 mx-auto text-gray-400 mb-2 md:mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg md:text-xl font-semibold text-gray-700 mb-1 md:mb-2">Your cart is empty</h3>
                    <p class="text-sm md:text-base text-gray-500 mb-3 md:mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('products') }}" class="inline-block bg-blue-500 text-white px-4 md:px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors text-sm md:text-base">
                        Continue Shopping
                    </a>
                </div>
            `;
            cartItemsTable.innerHTML = `<tr><td colspan="5">${emptyMessage}</td></tr>`;
            cartItemsMobile.innerHTML = emptyMessage;
            document.getElementById('clear-cart-btn').disabled = true;
            return;
        }


        document.getElementById('clear-cart-btn').disabled = false;

        // Render desktop table
        cartItemsTable.innerHTML = cartData.items.map(item => `
            <tr class="border-b" data-item-id="${item.key}">
                <td class="py-4">
                    <div class="flex items-center">
                        <img class="h-16 w-16 mr-4 rounded-lg object-cover" 
                             src="${item.image}" 
                             alt="${item.shoe_name}">
                        <div>
                            <span class="font-semibold">${item.shoe_name}</span>
                            <p class="text-sm text-gray-500">Size: ${item.size}</p>
                        </div>
                    </div>
                </td>
                <td class="py-4">${Array.isArray(item.type) ? item.type.join(', ') : 'N/A'}</td>
                <td class="py-4 font-semibold">Rs. ${item.price.toLocaleString()}</td>
                <td class="py-4">
                    <button class="remove-item text-red-500 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </td>
            </tr>
        `).join('');

        // Render mobile cards
        cartItemsMobile.innerHTML = cartData.items.map(item => `
            <div class="bg-gray-50 rounded-lg p-4" data-item-id="${item.key}">
                <div class="flex items-start space-x-4">
                    <img class="h-20 w-20 rounded-lg object-cover" 
                         src="${item.image}" 
                         alt="${item.shoe_name}">
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-semibold">${item.shoe_name}</h3>
                                <p class="text-sm text-gray-500">Size: ${item.size}</p>
                                <p class="text-sm text-gray-500">${item.type || 'N/A'}</p>
                            </div>
                            <button class="remove-item text-red-500 hover:text-red-600 p-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-gray-600">Price:</span>
                            <span class="font-semibold">Rs. ${item.price.toLocaleString()}</span>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function removeItem(itemKey) {
        fetch(`/cookie/${itemKey}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                cartData.items = cartData.items.filter(item => item.key !== itemKey);
                renderCart();
                updateCartTotals();
                
                // Show empty cart toast if cart is now empty
                if (cartData.items.length === 0) {
                    const toast = document.getElementById('empty-cart-toast');
                    toast.classList.remove('hidden');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 3000);
                }
            } else {
                console.error('Failed to remove item');
            }
        })
        .catch(error => {
            console.error('Error removing item:', error);
        });
    }

    async function updateCartTotals() {
    if (!cartData.items.length) {
        // Reset all totals to 0 when cart is empty
        document.getElementById('subtotal').textContent = 'Rs. 0';
        document.getElementById('discount').textContent = '- Rs. 0';
        document.getElementById('shipping').textContent = 'Rs. 0';
        document.getElementById('total').textContent = 'Rs. 0';
        document.getElementById('checkout-btn').disabled = true;
        document.getElementById('clear-cart-btn').disabled = true;
        return;
    }

        try {
            const items = cartData.items.map(item => ({
                price_id: item.price_id,
                size: item.size
            }));
            const citySelect = document.getElementById('city');
            const selectedCity = citySelect.value;
            const discountCodes = Array.from(appliedDiscounts.keys());
            const queryParams = new URLSearchParams({
                price_id: JSON.stringify(items),
                city: selectedCity || '',
                discount: discountCodes[0] || ''
            });

            const response = await fetch(`/api/cart?${queryParams}`);
            const contentType = response.headers.get("content-type");

            if (contentType && contentType.indexOf("application/json") !== -1) {
                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                if (data.message) {
                    alert(data.message);
                }

                document.getElementById('subtotal').textContent = `Rs. ${data.subTotal.toLocaleString()}`;
                document.getElementById('discount').textContent = `- Rs. ${data.discount.toLocaleString()}`;
                document.getElementById('shipping').textContent = `Rs. ${data.shipping.toLocaleString()}`;
                document.getElementById('total').textContent = `Rs. ${data.total.toLocaleString()}`;

                document.getElementById('checkout-btn').disabled = false;
                document.getElementById('clear-cart-btn').disabled = false;
                toggleButton();
            } else {
                console.log("Non-JSON response received. Cookies cleared.");
                alert("Product or Size is Unavailable So Cart was Cleared");
                location.reload();
            }

        } catch (error) {
            console.error('Error updating cart totals:', error);
            alert('Failed to update cart totals. Please try again.');
        }
    }

    async function applyDiscount() {
        const codeInput = document.getElementById('discount-code');
        const code = codeInput.value.trim().toUpperCase();
        
        if (!code) {
            alert('Please enter a discount code');
            return;
        }

        try {
            // Get the first item's price_id for validation
            const firstItem = cartData.items[0];
            if (!firstItem) {
                alert('Cart is empty');
                return;
            }

            // Validate discount code with backend
            const response = await fetch(`/api/discountcheck?price_id=${firstItem.price_id}&discount_code=${code}`);
            const data = await response.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            if (data.Discounted) {
                appliedDiscounts.clear();
                // Store the discount code and percentage
                appliedDiscounts.set(code, {
                    code: code,
                    percentage: data.Discounted.percentage
                });
                renderAppliedDiscounts();
                await updateCartTotals();
                codeInput.value = '';
            } else {
                alert(data.message || 'This discount code cannot be applied to your cart');
            }
        } catch (error) {
            console.error('Error applying discount:', error);
            alert('Failed to apply discount code. Please try again.');
        }
    }

    function renderAppliedDiscounts() {
        const container = document.getElementById('applied-discounts');
        container.innerHTML = Array.from(appliedDiscounts.values()).map(discount => `
            <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                <div>
                    <span class="text-sm font-medium">${discount.code}</span>
                    <span class="text-xs text-gray-500 ml-2">(${discount.percentage} off)</span>
                </div>
                <button onclick="removeDiscount('${discount.code}')" 
                        class="text-red-500 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `).join('');
    }

    function removeDiscount(code) {
        if (appliedDiscounts.has(code)) {
            appliedDiscounts.delete(code);
            renderAppliedDiscounts();
            updateCartTotals();
        }
    }

    // Add event listener for Enter key on discount input
    document.getElementById('discount-code').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            applyDiscount();
        }
    });

    // Function to get applied discount codes for order submission
    function getAppliedDiscountCodes() {
        return Array.from(appliedDiscounts.keys());
    }

    // Add form validation
    function validateForm() {
        const form = document.querySelector('form');
        const name = form.querySelector('#name').value.trim();
        const phone = form.querySelector('#phone').value.trim();
        const email = form.querySelector('#email').value.trim();
        const city = form.querySelector('#city').value.trim();
        const address = form.querySelector('#address').value.trim();
        const landmark = form.querySelector('#landmark').value.trim();

        let errors = [];

        // Name validation
        if (!name) {
            errors.push('Name is required');
        } else if (name.length < 3) {
            errors.push('Name must be at least 3 characters long');
        }

        // Phone validation
        const phoneRegex = /^[0-9]{10}$/;
        if (!phone) {
            errors.push('Phone number is required');
        } else if (!phoneRegex.test(phone)) {
            errors.push('Please enter a valid 10-digit phone number');
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            errors.push('Email is required');
        } else if (!emailRegex.test(email)) {
            errors.push('Please enter a valid email address');
        }

        // City validation
        if (!city) {
            errors.push('Please select a city');
        }

        // Address validation
        if (!address) {
            errors.push('Address is required');
        } else if (address.length < 10) {
            errors.push('Please enter a more detailed address');
        }

        // Landmark validation
        if (!landmark) {
            errors.push('Nearest landmark is required');
        }

        // Display errors if any
        const errorContainer = document.getElementById('form-errors');
        if (errorContainer) {
            errorContainer.remove();
        }

        if (errors.length > 0) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'form-errors';
            errorDiv.className = 'bg-red-50 text-red-500 p-3 rounded-lg mb-4';
            errorDiv.innerHTML = `
                <ul class="list-disc pl-4">
                    ${errors.map(error => `<li>${error}</li>`).join('')}
                </ul>
            `;
            form.insertBefore(errorDiv, form.firstChild);
            return false;
        }

        return true;
    }

    // Update the checkout button click handler
    document.getElementById('checkout-btn').addEventListener('click', function(e) {
        e.preventDefault();

        if (!validateForm()) {
            return;
        }

        // Store discount codes in the form
        const discountCodes = getAppliedDiscountCodes();
        const form = document.querySelector('form');
        
        // Remove any existing discount code inputs
        form.querySelectorAll('input[name="discount_codes[]"]').forEach(input => input.remove());
        
        // Add current discount codes to the form
        discountCodes.forEach(code => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'discount_codes[]';
            input.value = code;
            form.appendChild(input);
        });

        showPaymentModal();
    });

    // Add real-time validation for phone number
    document.getElementById('phone').addEventListener('input', function(e) {
        const phoneRegex = /^[0-9]*$/;
        if (!phoneRegex.test(e.target.value)) {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
        }
        if (e.target.value.length > 10) {
            e.target.value = e.target.value.slice(0, 10);
        }
    });

    // Add real-time validation for email
    document.getElementById('email').addEventListener('blur', function(e) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(e.target.value.trim())) {
            e.target.classList.add('border-red-500');
        } else {
            e.target.classList.remove('border-red-500');
        }
    });

    function showPaymentModal() {
        if (!cartData || !cartData.items || cartData.items.length === 0) {
            return;
        }
        const modal = document.getElementById('payment-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closePaymentModal() {
        const modal = document.getElementById('payment-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function processPayment(method) {
        const form = document.querySelector('form');

        function addHiddenInput(name, value) {
            let input = form.querySelector(`input[name="${name}"]`);
            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                form.appendChild(input);
            }
            input.value = value;
        }
        addHiddenInput('method', method);
        const items = cartData.items.map(item => ({
            price_id: item.price_id,
            size: item.size
        }));
        let discount = getAppliedDiscountCodes();
        let city = document.getElementById('city').value;
        addHiddenInput('price_id', JSON.stringify(items));
        addHiddenInput('discount_code', discount);
        addHiddenInput('city', city);
        form.submit();
    }

    function showClearCartModal() {
        const modal = document.getElementById('clear-cart-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeClearCartModal() {
        const modal = document.getElementById('clear-cart-modal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    function clearCart() {
        fetch('/cookie', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                cartData.items = [];
                renderCart();
                updateCartTotals();
                closeClearCartModal();
            }
        })
        .catch(error => {
            console.error('Error clearing cart:', error);
        });
    }

    document.getElementById('checkout-btn').addEventListener('click', showPaymentModal);

    // Load cities from JSON file
    async function loadCities() {
        try {
            const response = await fetch('/data/city.json');
            const data = await response.json();
            const citySelect = document.getElementById('city');
            
            data.City.forEach(city => {
                const option = document.createElement('option');
                option.value = city.name;
                option.textContent = city.name;  // Removed the shipping cost display
                citySelect.appendChild(option);
            });

            // Add change event listener to update totals when city changes
            citySelect.addEventListener('change', updateCartTotals);
        } catch (error) {
            console.error('Error loading cities:', error);
        }
    }
    </script>
</body>
</html> 