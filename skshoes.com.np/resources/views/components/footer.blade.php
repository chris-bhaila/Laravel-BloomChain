<footer class="relative">
<style>
        @font-face {
            font-family: 'sunborn';
            src: url('/assets/fonts/sunborn.otf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .font-extrabold.tracking-wide {
            font-family: 'sunborn', sans-serif;
        }
    </style>
    <div class="absolute inset-0 bg-[url('/assets/images/background.png')] bg-cover bg-center opacity-100 bg-no-repeat"></div>
    <div class="relative z-10 mx-auto grid max-w-screen-xl gap-y-4 gap-x-8 px-4 py-4 sm:px-10 md:grid-cols-3 xl:px-8">
        <div class="max-w-sm">
            <div class="mb-4 flex items-center">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-10 sm:h-12 w-auto" alt="SK Shoes Logo" />
                <span class="ml-3 text-lg sm:text-xl md:text-2xl font-extrabold text-black dark:text-white tracking-wide">SK Shoes</span>
            </div>
            <div class="mt-2 flex justify-start space-x-4">
                <a href="#" class="text-black hover:text-blue-600 transition-colors duration-200">
                    <svg class="h-5 sm:h-6 w-5 sm:w-6" fill="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/>
                    </svg>
                </a>
                <a href="#" class="text-black hover:text-pink-600 transition-colors duration-200">
                    <svg class="h-5 sm:h-6 w-5 sm:w-6" fill="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
                <a href="#" class="text-black hover:text-[#6a76ac] transition-colors duration-200">
                    <span class="[&>svg]:h-5 [&>svg]:w-5 sm:[&>svg]:h-6 sm:[&>svg]:w-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                            <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
        <div class="">
            <div class="mt-2 mb-1 font-extrabold text-black xl:mb-2 dark:text-white tracking-wide">Company</div>
            <nav aria-label="Footer Navigation" class="text-black">
                <ul class="space-y-2">
                    <li><a class="hover:text-blue-600 hover:underline text-sm font-extrabold tracking-wide" href="{{ route('about') }}">About Us</a></li>
                    <li><a class="hover:text-blue-600 hover:underline text-sm font-extrabold tracking-wide" href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="">
            <div class="mt-2 mb-1 font-extrabold text-black xl:mb-2 dark:text-white tracking-wide">Contact Us</div>
            <div class="flex flex-col text-black space-y-2 text-sm font-extrabold tracking-wide">
                <div class="flex items-center space-x-2">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="break-all">+977 9845998149</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span class="break-all">+977 9823709835</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="break-all">shoessk2024@gmail.com</span>
                </div>
                <div class="flex items-center space-x-2">
                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="break-all">Satungal, Kathmandu</span>
                </div>
            </div>
        </div>
    </div>
    <div class="relative z-10 border-t border-gray-200 dark:border-gray-700 bg-black/10">
        <div class="mx-auto flex max-w-screen-xl flex-col gap-y-2 px-4 py-2 text-center text-black sm:px-10 lg:flex-row lg:justify-between lg:text-left xl:px-8">
            <p class="text-xs sm:text-sm font-extrabold tracking-wide">&copy; SK Shoes | All Rights Reserved</p>
            <p class="-order-1 sm:order-none text-xs sm:text-sm font-extrabold tracking-wide">Quality Footwear, Lasting Impression</p>
            <p class="text-xs sm:text-sm font-extrabold tracking-wide">
                <button onclick="openPrivacyPolicy()" class="hover:text-blue-600 hover:underline">Privacy Policy</button>
                <span> | </span>
                <button onclick="openTermsOfService()" class="hover:text-blue-600 hover:underline">Terms of Service</button>
            </p>
        </div>
    </div>
</footer>

<!-- Privacy Policy Popup -->
<div id="privacyPolicyPopup" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-4 sm:p-6 max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg sm:text-xl font-bold">Privacy Policy</h2>
            <button onclick="closePrivacyPolicy()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="prose text-sm sm:text-base">
            <!-- Add your privacy policy content here -->
            <p>Your privacy is important to us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website.</p>
            <!-- Add more privacy policy content as needed -->
        </div>
    </div>
</div>

<!-- Terms of Service Popup -->
<div id="termsOfServicePopup" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg p-4 sm:p-6 max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg sm:text-xl font-bold">Terms of Service</h2>
            <button onclick="closeTermsOfService()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="prose text-sm sm:text-base">
            <!-- Add your terms of service content here -->
            <p>Please read these Terms of Service carefully before using our website.</p>
            <!-- Add more terms of service content as needed -->
        </div>
    </div>
</div>

<script>
function openPrivacyPolicy() {
    document.getElementById('privacyPolicyPopup').classList.remove('hidden');
    document.getElementById('privacyPolicyPopup').classList.add('flex');
}

function closePrivacyPolicy() {
    document.getElementById('privacyPolicyPopup').classList.remove('flex');
    document.getElementById('privacyPolicyPopup').classList.add('hidden');
}

function openTermsOfService() {
    document.getElementById('termsOfServicePopup').classList.remove('hidden');
    document.getElementById('termsOfServicePopup').classList.add('flex');
}

function closeTermsOfService() {
    document.getElementById('termsOfServicePopup').classList.remove('flex');
    document.getElementById('termsOfServicePopup').classList.add('hidden');
}

// Close popups when clicking outside
document.addEventListener('click', function(event) {
    const privacyPopup = document.getElementById('privacyPolicyPopup');
    const termsPopup = document.getElementById('termsOfServicePopup');
    
    if (event.target === privacyPopup) {
        closePrivacyPolicy();
    }
    if (event.target === termsPopup) {
        closeTermsOfService();
    }
});
</script> 