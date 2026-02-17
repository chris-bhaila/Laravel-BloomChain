<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discounts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="bg-gray-100">
    <x-admin.header />

    <!-- Main Layout -->
    <div class="flex pt-16 min-h-screen overflow-x-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 p-2 sm:p-4 lg:p-6 w-full transition-transform duration-300 ease-in-out">
            <div class="bg-white rounded-lg shadow-lg p-3 sm:p-4 lg:p-6 overflow-x-auto">
                <!-- Add Discount Form -->
                <form id="discountForm" class="space-y-4 sm:space-y-6">
                    @if($edit)
                    <input type="hidden" id="editing" name="editing" value="{{ $edit->discount_code }}">
                    <input type="hidden" name="status" value="{{ $edit->status }}">
                    @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Code</label>
                            <input type="text" id="discountCode"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                placeholder-gray-400 hover:border-indigo-300"
                                placeholder="Enter discount code" name="discount_code"
                                pattern="[A-Za-z0-9]+" value="{{ old('discount_code', $edit->discount_code ?? '') }}"
                                title="Discount code should contain only letters and numbers"
                                required {{ isset($edit) ? 'disabled' : '' }}>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Use</label>
                            <input type="number" id="maximumUse" name="maximum_use"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                placeholder-gray-400 hover:border-indigo-300"
                                placeholder="Enter maximum uses" value="{{ old('maximum_use', $edit->maximum_use ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                            <input type="date" id="expiryDate" name="expiry_date"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                hover:border-indigo-300" value="{{ old('expiry_date', $edit->expiry_date ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Discount Percentage</label>
                            <input type="number" id="discountPercentage" max="100" name="percentage"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                placeholder-gray-400 hover:border-indigo-300"
                                placeholder="Enter percentage" value="{{ old('percentage', $edit->percentage ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Amount</label>
                            <input type="number" id="maximumAmount" name="maximum_amount"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                placeholder-gray-400 hover:border-indigo-300"
                                placeholder="Enter maximum amount" value="{{ old('maximum_amount', $edit->maximum_amount ?? '') }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Validity</label>
                            <select id="validityType" name="validityType"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                hover:border-indigo-300">
                                <option value="">Select validity type</option>
                                <option value="all" {{ old('validityType', isset($edit) && $edit->category_name == null && $edit->article_id == null ? 'selected' : '') }}>All Products</option>
                                <option value="category" {{ old('validityType', isset($edit) && $edit->category_name ? 'selected' : '') }}>Specific Category</option>
                                <option value="article" {{ old('validityType', isset($edit) && $edit->article_id ? 'selected' : '') }}>Specific Article</option>
                            </select>
                        </div>

                        <div id="categorySelectContainer" class="{{ isset($edit) && $edit->category_name ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Category</label>
                            <select id="validCategories" name="validCategories"
                                class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                bg-white shadow-sm transition duration-150 ease-in-out
                                hover:border-indigo-300">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->category_name }}" {{ old('validCategories', $edit->category_name ?? '') == $category->category_name ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="articleSelectContainer" class="{{ isset($edit) && $edit->article_id ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Select Article</label>
                            <div class="relative">
                                <div class="flex space-x-2">
                                    <div class="relative flex-1">
                                        <input type="text" id="validArticle" name="validArticle"
                                            class="block w-full rounded-md border-2 border-indigo-100 px-4 py-2.5
                                            focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                            bg-white shadow-sm transition duration-150 ease-in-out
                                            placeholder-gray-400 hover:border-indigo-300"
                                            placeholder="Search article ID"
                                            value="{{ old('validArticle', $edit->article_id ?? '') }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div id="articleSearchResults" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg hidden">
                                    <ul class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                        <!-- Search results will be populated here -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit"
                            class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                            transition duration-150 ease-in-out transform hover:-translate-y-0.5
                            shadow-md hover:shadow-lg">
                            {{ isset($edit) ? 'Edit Discount' : 'Add Discount'}}
                        </button>
                        <button type="button" onclick="clearForm()" class="ml-3 w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-gray-500 text-white rounded-md hover:bg-gray-600 
                                        focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2
                                        transition duration-150 ease-in-out transform hover:-translate-y-0.5
                                        shadow-md hover:shadow-lg">
                            Clear Form
                        </button>
                    </div>
                </form>

                <!-- Discounts Table -->
                <div class="mt-6 sm:mt-8 -mx-3 sm:mx-0">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">S. No</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Discount Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Discount %</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Max Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Max Use</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Validity Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Valid For</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">Expiry Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody id="discountsTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Table content will be populated by JavaScript -->
                                @foreach ($discounts as $discount)
                                <tr id="discountRow-{{ $discount->discount_code }}" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $discount->discount_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $discount->percentage }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $discount->maximum_amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $discount->maximum_use }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                        @if(! $discount->category_name && ! $discount->article_id)
                                        All Products
                                        @elseif($discount->category_name)
                                        Category
                                        @elseif($discount->article_id)
                                        Article
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">
                                        @if(! $discount->category_name && ! $discount->article_id)
                                        All Products
                                        @elseif($discount->category_name)
                                        {{ $discount->category_name }}
                                        @elseif($discount->article_id)
                                        {{ $discount->article_id }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-r border-gray-200">{{ $discount->expiry_date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="border-r pr-3">
                                                @if ($discount->status == 'active')
                                                <button onclick="updateDiscountStatus('{{ $discount->discount_code }}', 'inactive')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 
                                                                    rounded-full text-xs font-medium hover:bg-green-200 transition-colors
                                                                    duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                                    focus:ring-green-500 min-w-[90px] justify-center">
                                                    <span class="h-2 w-2 bg-green-400 rounded-full mr-2"></span>
                                                    Active
                                                </button>
                                                @else
                                                <button onclick="updateDiscountStatus('{{ $discount->discount_code }}', 'active')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 
                                                                    rounded-full text-xs font-medium hover:bg-gray-200 transition-colors
                                                                    duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                                    focus:ring-gray-500 min-w-[90px] justify-center">
                                                    <span class="h-2 w-2 bg-gray-400 rounded-full mr-2"></span>
                                                    Inactive
                                                </button>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2">
                                                <button onclick="window.location.href='{{ url('admin/discount') }}?editing={{ $discount->discount_code }}'"
                                                    class="inline-flex items-center px-3 py-1.5 bg-blue-100 text-blue-700 
                                                                rounded-full text-xs font-medium hover:bg-blue-200 transition-colors
                                                                duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                                focus:ring-blue-500 min-w-[90px] justify-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </button>
                                                <button onclick="deleteDiscount('{{ $discount->discount_code }}')"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-100 text-red-700 
                                                                            rounded-full text-xs font-medium hover:bg-red-200 transition-colors
                                                                            duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                                                            focus:ring-red-500 min-w-[90px] justify-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.change-password-modal />

    <script>
        // Update sidebar toggle logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mainContent = document.querySelector('.flex-1');
        let sidebarOpen = false;

        sidebarToggle.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(0)';
            } else {
                sidebar.style.transform = 'translateX(-100%)';
            }
        });

        // Add profile dropdown functionality
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });

        // Mobile search functionality
        const searchButton = document.querySelector('button[type="button"].md\\:hidden');
        const mobileSearch = document.getElementById('mobile-search');

        searchButton?.addEventListener('click', () => {
            mobileSearch.classList.toggle('hidden');
        });

        // Add this helper function at the top of your script section
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Add this new function to manage field states
        function updateFieldStates(categoryField, articleField, fromField) {
            const validCategories = document.getElementById(categoryField);
            const validArticle = document.getElementById(articleField);

            // If called from category field
            if (fromField === 'category') {
                if (validCategories.value && validCategories.value !== "") {
                    validArticle.disabled = true;
                    validArticle.value = '';
                    validArticle.classList.add('bg-gray-100');
                } else {
                    validArticle.disabled = false;
                    validArticle.classList.remove('bg-gray-100');
                }
            }

            // If called from article field
            if (fromField === 'article') {
                if (validArticle.value.trim()) {
                    validCategories.disabled = true;
                    validCategories.value = '';
                    validCategories.classList.add('bg-gray-100');
                } else {
                    validCategories.disabled = false;
                    validCategories.classList.remove('bg-gray-100');
                }
            }
        }

        // Add this event listener for the validity type dropdown
        document.getElementById('validityType').addEventListener('change', function() {
            const categoryContainer = document.getElementById('categorySelectContainer');
            const articleContainer = document.getElementById('articleSelectContainer');
            const validCategories = document.getElementById('validCategories');
            const validArticle = document.getElementById('validArticle');

            // Reset both fields
            validCategories.value = '';
            validArticle.value = '';

            // Hide both containers initially
            categoryContainer.classList.add('hidden');
            articleContainer.classList.add('hidden');

            // Show appropriate container based on selection
            switch (this.value) {
                case 'category':
                    categoryContainer.classList.remove('hidden');
                    break;
                case 'article':
                    articleContainer.classList.remove('hidden');
                    break;
                case 'all':
                    // Both containers remain hidden
                    break;
            }
        });

        // Update the form submission handler to handle "all" products correctly
        document.getElementById('discountForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const validityType = document.getElementById('validityType').value;
            let categoryName = null;
            let articleId = null;

            switch (validityType) {
                case 'all':
                    categoryName = 'all';
                    articleId = 'all';
                    break;
                case 'category':
                    categoryName = document.getElementById('validCategories').value;
                    break;
                case 'article':
                    articleId = document.getElementById('validArticle').value;
                    break;
            }
            if (categoryName == null && articleId == null) {
                categoryName = 'all';
                articleId = 'all';
            }
            const formData = {
                discount_code: document.getElementById('discountCode').value,
                percentage: parseFloat(document.getElementById('discountPercentage').value),
                maximum_use: parseInt(document.getElementById('maximumUse').value),
                maximum_amount: parseFloat(document.getElementById('maximumAmount').value),
                expiry_date: document.getElementById('expiryDate').value,
                article_id: articleId,
                category_name: categoryName
            };

            try {
                const response = await fetch("{{ isset($edit) ? route('admin.discount.update', $edit->discount_code) : route('admin.discount.store') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    console.error('Error response:', data);
                    throw new Error(data.error || 'Failed to create/update discount');
                }
                if (data.error) {
                    showNotification(data.error, 'error');
                } else {
                    showNotification(data.success);
                }

                setTimeout(() => {
                    const newUrl = window.location.origin + window.location.pathname;
                    window.history.replaceState({}, document.title, newUrl);
                    window.location.reload();
                }, 2000);
            } catch (error) {
                showNotification(error.message, 'error');
            }
        });

        // Update the edit discount function to handle the new validity structure
        // function editDiscount(discount) {
        //     // Update URL to show discount code being edited
        //     window.history.pushState({}, '', `/admin/discount?editing=${discount.discount_code}`);

        //     document.getElementById('discountCode').value = discount.discount_code;
        //     document.getElementById('discountCode').readOnly = true;
        //     document.getElementById('maximumUse').value = discount.maximum_use;
        //     document.getElementById('maximumAmount').value = discount.maximum_amount;
        //     document.getElementById('discountPercentage').value = discount.percentage;
        //     document.getElementById('expiryDate').value = discount.expiry_date;

        //     const validityType = document.getElementById('validityType');
        //     const categoryContainer = document.getElementById('categorySelectContainer');
        //     const articleContainer = document.getElementById('articleSelectContainer');

        //     if (discount.category_name === 'all') {
        //         validityType.value = 'all';
        //         categoryContainer.classList.add('hidden');
        //         articleContainer.classList.add('hidden');
        //     } else if (discount.category_name) {
        //         validityType.value = 'category';
        //         categoryContainer.classList.remove('hidden');
        //         articleContainer.classList.add('hidden');
        //         document.getElementById('validCategories').value = discount.category_name;
        //     } else if (discount.article_id) {
        //         validityType.value = 'article';
        //         categoryContainer.classList.add('hidden');
        //         articleContainer.classList.remove('hidden');
        //         document.getElementById('validArticle').value = discount.article_id;
        //     }

        //     const submitButton = document.querySelector('button[type="submit"]');
        //     submitButton.textContent = 'Update Discount';

        //     // Update form submission handler
        //     const form = document.getElementById('discountForm');
        //     form.onsubmit = async (e) => {
        //         e.preventDefault();

        //         const validityType = document.getElementById('validityType').value;
        //         let categoryName = null;
        //         let articleId = null;

        //         switch (validityType) {
        //             case 'all':
        //                 categoryName = 'all';
        //                 articleId = 'all';
        //                 break;
        //             case 'category':
        //                 categoryName = document.getElementById('validCategories').value;
        //                 break;
        //             case 'article':
        //                 articleId = document.getElementById('validArticle').value;
        //                 break;
        //         }

        //         const formData = {
        //             percentage: parseFloat(document.getElementById('discountPercentage').value),
        //             maximum_use: parseInt(document.getElementById('maximumUse').value),
        //             maximum_amount: parseFloat(document.getElementById('maximumAmount').value),
        //             expiry_date: document.getElementById('expiryDate').value,
        //             article_id: articleId,
        //             category_name: categoryName
        //         };

        //         try {
        //             const response = await fetch(`/admin/discount/update/${discount.discount_code}`, {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'Accept': 'application/json',
        //                     'X-CSRF-TOKEN': getCsrfToken()
        //                 },
        //                 body: JSON.stringify(formData)
        //             });

        //             const data = await response.json();

        //             if (!response.ok) {
        //                 throw new Error(data.error || 'Failed to update discount');
        //             }
        //             if (data.error) {
        //                 showNotification(data.error, 'error');
        //             } else {
        //                 showNotification(data.success);
        //             }
        //             setTimeout(() => {
        //                 window.history.pushState({}, '', '/admin/discount');
        //                 window.location.reload();
        //             }, 1500);
        //         } catch (error) {
        //             showNotification(error.message, 'error');
        //         }
        //     };
        // }

        // Update status function
        async function updateDiscountStatus(discountCode, newStatus) {
            try {
                const button = event.currentTarget;
                const originalContent = button.innerHTML;
                button.disabled = true;

                console.log('Updating status:', discountCode, newStatus);

                const response = await fetch(`/admin/discount/${discountCode}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                });

                console.log('Response status:', response.status);
                const responseData = await response.json();
                console.log('Response data:', responseData);

                if (!response.ok) {
                    throw new Error(responseData.error || 'Failed to update status');
                }

                if (responseData.error) {
                    showNotification(responseData.error, 'error');
                } else {
                    showNotification(responseData.success);
                }

                // Update button appearance without page reload
                const buttonContainer = button.parentElement;
                if (newStatus === 'active') {
                    buttonContainer.innerHTML = `
                        <button onclick="updateDiscountStatus('${discountCode}', 'inactive')"
                            class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-700 
                                    rounded-full text-xs font-medium hover:bg-green-200 transition-colors
                                    duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-green-500 min-w-[90px] justify-center">
                            <span class="h-2 w-2 bg-green-400 rounded-full mr-2"></span>
                            Active
                        </button>`;
                } else {
                    buttonContainer.innerHTML = `
                        <button onclick="updateDiscountStatus('${discountCode}', 'active')"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 
                                    rounded-full text-xs font-medium hover:bg-gray-200 transition-colors
                                    duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 
                                    focus:ring-gray-500 min-w-[90px] justify-center">
                            <span class="h-2 w-2 bg-gray-400 rounded-full mr-2"></span>
                            Inactive
                        </button>`;
                }


            } catch (error) {
                console.error('Error updating status:', error);
                showNotification(error.message || 'Failed to update status', 'error');
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        }

        // Delete discount function
        async function deleteDiscount(discountCode) {
            if (!confirm('Are you sure you want to delete this discount?')) return;

            try {
                const button = event.currentTarget;
                const originalContent = button.innerHTML;
                button.disabled = true;
                button.innerHTML = `
                    <svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;

                console.log('Deleting discount code:', discountCode);

                const response = await fetch(`/admin/discount/${discountCode}/delete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });

                console.log('Response status:', response.status);
                const responseData = await response.json();
                console.log('Response data:', responseData);

                if (!response.ok) {
                    throw new Error(responseData.error || 'Failed to delete discount');
                }

                // Remove the row from the table
                const row = button.closest('tr');
                if (row) {
                    row.remove();
                }

                showNotification('Discount deleted successfully');

            } catch (error) {
                console.error('Error deleting discount:', error);
                showNotification(error.message || 'Failed to delete discount', 'error');
                button.disabled = false;
                button.innerHTML = originalContent;
            }
        }

        // Notification function
        function showNotification(message, type = 'success') {
            // Remove any existing notifications first
            const existingNotifications = document.querySelectorAll('.notification');
            existingNotifications.forEach(notification => notification.remove());

            // Create new notification
            const notification = document.createElement('div');
            notification.className = `notification fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            notification.textContent = message;

            // Add to document
            document.body.appendChild(notification);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 30000);
        }

        // Add debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Update the article search functionality
        const searchArticles = debounce(async (searchTerm) => {
            if (!searchTerm || searchTerm.length < 2) {
                document.getElementById('articleSearchResults').classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`/admin/discount/article-search?shoe=${encodeURIComponent(searchTerm)}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }

                const articles = await response.json();
                const resultsContainer = document.getElementById('articleSearchResults');
                const resultsList = resultsContainer.querySelector('ul');

                if (articles && articles.length > 0) {
                    const resultsHtml = articles.map(article => `
                        <li class="article-option cursor-pointer px-4 py-2 hover:bg-indigo-50 text-gray-900">
                            ${article}
                        </li>
                    `).join('');

                    resultsList.innerHTML = resultsHtml;
                    resultsContainer.classList.remove('hidden');

                    // Update click handlers to include field state management
                    document.querySelectorAll('.article-option').forEach(option => {
                        option.addEventListener('click', () => {
                            document.getElementById('validArticle').value = option.textContent.trim();
                            resultsContainer.classList.add('hidden');
                            updateFieldStates('validCategories', 'validArticle', 'article');
                        });
                    });
                } else {
                    resultsList.innerHTML = '<li class="px-4 py-2 text-gray-500">No articles found</li>';
                    resultsContainer.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Error searching articles:', error);
                showNotification(`Failed to search articles: ${error.message}`, 'error');
            }
        }, 300);

        // Update the validArticle input event listener
        document.getElementById('validArticle').addEventListener('input', function(e) {
            searchArticles(e.target.value);
            updateFieldStates('validCategories', 'validArticle', 'article');
        });

        // Add change event listener for validCategories
        document.getElementById('validCategories').addEventListener('change', function() {
            updateFieldStates('validCategories', 'validArticle', 'category');
        });

        // Update the reset form function
        function clearForm() {
            const editing = document.getElementById('editing');

            if (editing) {
                // In editing mode: Keep discountCode, clear others
                document.getElementById("maximumUse").value = "";
                document.getElementById("expiryDate").value = "";
                document.getElementById("discountPercentage").value = "";
                document.getElementById("maximumAmount").value = "";
                document.getElementById("validityType").value = "";

                // Reset selects
                const validityType = document.getElementById("validityType");
                if (validityType) validityType.selectedIndex = 0;

                const validCategories = document.getElementById("validCategories");
                if (validCategories) validCategories.selectedIndex = 0;

                // Clear article input
                const validArticle = document.getElementById("validArticle");
                if (validArticle) validArticle.value = "";

                // Hide conditional containers
                document.getElementById("categorySelectContainer").classList.add("hidden");
                document.getElementById("articleSelectContainer").classList.add("hidden");

                // Clear article search results if needed
                const articleResults = document.getElementById("articleSearchResults");
                if (articleResults) articleResults.classList.add("hidden");

            } else {
                // Not editing: reset everything
                const form = document.getElementById('discountForm');
                form.reset();

                document.getElementById("discountCode").value = "";
                document.getElementById("maximumUse").value = "";
                document.getElementById("expiryDate").value = "";
                document.getElementById("discountPercentage").value = "";
                document.getElementById("maximumAmount").value = "";
                document.getElementById("validityType").value = "";

                // Reset selects
                const validCategories = document.getElementById("validCategories");
                if (validCategories) validCategories.selectedIndex = 0;

                const validArticle = document.getElementById("validArticle");
                if (validArticle) validArticle.value = "";

                // Hide conditional inputs
                document.getElementById("categorySelectContainer").classList.add("hidden");
                document.getElementById("articleSelectContainer").classList.add("hidden");

                const articleResults = document.getElementById("articleSearchResults");
                if (articleResults) articleResults.classList.add("hidden");
            }
        }

        // Add styles for notifications
        const styles = document.createElement('style');
        styles.textContent = `
            .notification {
                transition: all 0.3s ease-in-out;
                animation: slideIn 0.3s ease-out;
            }

            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(styles);

        // Initial load
        fetchDiscounts();
    </script>

    <!-- Add responsive styles for the header/navbar -->
    <style>
        /* Add these styles */
        #sidebar {
            position: fixed;
            z-index: 40;
            height: calc(100vh - 4rem);
        }

        @media (max-width: 640px) {
            #mobile-search {
                width: 100vw;
                left: 0;
                padding: 0.5rem;
            }

            .navbar-content {
                padding-left: 0.5rem;
                padding-right: 0.5rem;
            }
        }

        /* Add these new styles */
        #articleSearchResults {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        #articleSearchResults ul {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
        }

        #articleSearchResults ul::-webkit-scrollbar {
            width: 6px;
        }

        #articleSearchResults ul::-webkit-scrollbar-track {
            background: transparent;
        }

        #articleSearchResults ul::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 3px;
        }
    </style>
</body>

</html>