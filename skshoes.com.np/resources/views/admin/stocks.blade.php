@extends('admin.layouts.app')

@section('title', 'Stocks')

@section('content')
    @if (isset($msg['error']))
        <span class="text-red-500 text-sm">{{ $msg['error'] }}</span>
    @endif
    @php
$articleId = request('article');
$shoe = $articleId ? \App\Models\Shoe::where('article_id', $articleId)->first() : null;
    @endphp
    @if ($shoe)
        <div class="px-2 sm:px-3 lg:px-4 max-w-7xl mx-auto">
            <div class="bg-gradient-to-r from-white to-gray-50 border-b shadow-sm rounded-lg">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center">
                            <span class="text-gray-600 text-sm font-medium mr-2">Shoe name:</span>
                            <h2 class="text-lg font-semibold text-gray-900 transition-all duration-300 ease-in-out">
                                <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-md">
                                    {{ $shoe->shoe_name }}
                                </span>
                            </h2>
                        </div>
                        <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-lg">
                            ID: {{ $articleId }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="p-2 sm:p-3 lg:p-4 mt-0 sm:mt-1 max-w-7xl mx-auto">
        <!-- Product Selection Section -->
        <div class="bg-white rounded-lg shadow p-3 sm:p-4 lg:p-5 mb-3 sm:mb-4">
            <form method="POST" action="{{ route('admin.stocks.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4 lg:gap-6">
                    <div class="space-y-1 sm:space-y-2">
                        <label class="block text-sm font-medium">Search Article:</label>
                        <div class="relative">
                            <input type="text" id="article_search" placeholder="Search for an article..."
                                class="w-full h-[42px] rounded-md border shadow-sm text-sm lg:text-base px-3"
                                autocomplete="off" value="{{ request('article_name') }}">
                            <input type="hidden" name="article_id" id="selected_article_id"
                                value="{{ request('article') }}">

                            <!-- Search Results Dropdown -->
                            <div id="search_results"
                                class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg border border-gray-200 hidden">
                            </div>
                        </div>
                        @error('article_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium">Select Type Group:</label>
                        <select name="price_id" id="price_group"
                            class="w-full h-[42px] rounded-md border shadow-sm text-sm lg:text-base px-2">
                            <option value="" disabled selected>Select Price Group</option>
                            @if (isset($formattedData) && count($formattedData) > 0)
                                @foreach ($formattedData as $priceId => $grouping)
                                    <option value="{{ $priceId }}" {{ $priceId == request('price_id') ? 'selected' : ''}}>
                                        @foreach($grouping as $key => $value)
                                            {{ $value ?? 'N/A' }} |
                                        @endforeach
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('price_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium">EU Size:</label>
                        <div class="flex gap-2">
                            <input type="number" name="size" value="{{ old('size') }}" min="25" max="100"
                                class="w-full h-[42px] rounded-md border shadow-sm text-sm lg:text-base px-3"
                                placeholder="EU Size">
                            <button type="submit" class="bg-indigo-600 text-white h-[42px] px-4 rounded-md text-sm lg:text-base 
                                                                    hover:bg-indigo-700 transition-colors duration-200 
                                                                    flex items-center justify-center gap-2 
                                                                    whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Add</span>
                            </button>
                        </div>
                        @error('size')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </form>
        </div>

        <!-- Stock Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Stock Id
                            </th>
                            <th scope="col"
                                class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Price Group
                            </th>
                            <th scope="col"
                                class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Size
                            </th>
                            <th scope="col"
                                class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                            <th scope="col"
                                class="px-3 sm:px-4 lg:px-6 py-2 sm:py-3 text-left text-xs lg:text-sm font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="stock_table_body">
                        @if (isset($stocks) && $stocks != [] && ! empty($stocks))
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td class="px-4 py-3">{{ $stock['id'] }}</td>
                                    <td class="px-4 py-3">
                                        @if(is_array($stock['product_grouping']))
                                            {{ implode(', ', $stock['product_grouping']) }}
                                        @else
                                            {{ $stock['product_grouping'] ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">EU {{ $stock['size'] }}</td>
                                    <td class="px-4 py-3">
                                        <input type="number" value="{{ $stock['stock'] }}" min="0"
                                            class="stock-input w-20 px-2 py-1 border border-gray-300 rounded-md text-center"
                                            data-stock-id="{{ $stock['id'] }}">
                                    </td>
                                    <td class="px-4 py-3">
                                        <button onclick="updateStock(this.closest('tr').querySelector('.stock-input'))" class="text-red-600 hover:text-red-800 px-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="w-6 h-6 text-blue-500 hover:text-blue-700">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"></path>
                                            </svg>
                                        </button>
                                        <button onclick="deleteStock({{ $stock['id'] }})" class="text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="w-6 h-6 text-red-500 hover:text-red-700">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6l-2 14H7L5 6m4 0V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="px-3 sm:px-4 lg:px-6 py-4 text-center text-gray-500">
                                    Search for an article & Type Group to view stocks
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="success_message">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="error_message">
            {{ session('error') }}
        </div>
    @endif
@endsection

@push('styles')
    <style>
        .search-result-item {
            @apply px-4 py-3 hover:bg-gray-50 cursor-pointer;
        }

        .search-result-item:not(:last-child) {
            @apply border-b border-gray-200;
        }

        #stock_table_body tr {
            @apply hover:bg-gray-50;
        }

        .stock-input {
            @apply w-20 h-[42px] rounded-md border shadow-sm text-sm text-center;
        }

        @media (max-width: 640px) {
            .stock-input {
                @apply w-16;
            }
        }

        .notification {
            animation: slideIn 0.3s ease-out, fadeOut 0.5s ease-in 2.5s forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateY(100%);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
            }

            to {
                opacity: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function hideMessage(elementId) {
                setTimeout(function () {
                    const messageElement = document.getElementById(elementId);
                    if (messageElement) {
                        messageElement.style.display = 'none';
                    }
                }, 5000);
            }

            if (document.getElementById('success_message')) {
                hideMessage('success_message');
            }

            if (document.getElementById('error_message')) {
                hideMessage('error_message');
            }
            
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('article_search');
            const searchResults = document.getElementById('search_results');
            const selectedArticleId = document.getElementById('selected_article_id');
            const priceGroupSelect = document.getElementById('price_group');
            const stockTableBody = document.getElementById('stock_table_body');
            let debounceTimer;

            // Initialize from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const articleParam = urlParams.get('article');
            if (articleParam) {
                // Set the article ID if it exists in URL
                selectedArticleId.value = articleParam;
                // Fetch article details to display name
                fetch(`/admin/discount/article-search?shoe=${articleParam}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            searchInput.value = `${data[0]}`;
                        }
                    });
            }

            // Search input handler
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const searchTerm = this.value;

                if (searchTerm.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                searchResults.innerHTML = '<div class="p-4 text-center text-gray-500">Searching...</div>';
                searchResults.classList.remove('hidden');

                // Use the DiscountController's articleSearch endpoint
                debounceTimer = setTimeout(() => {
                    fetch(`/admin/discount/article-search?shoe=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length === 0) {
                                searchResults.innerHTML = '<div class="p-4 text-center text-gray-500">No articles found</div>';
                                return;
                            }

                            // Display search results 
                            const searchResultsHTML = data.map(articleId => `
                                                    <div class="search-result-item border-b border-gray-200 last:border-b-0 px-3 py-2 hover:bg-gray-50 transition-colors duration-150" data-id="${articleId}">
                                                        <span class="font-medium text-gray-900 text-[15px]">${articleId}</span>
                                                    </div>
                                                `).join('');

                            searchResults.innerHTML = searchResultsHTML;

                            // Add click handlers to results
                            document.querySelectorAll('.search-result-item').forEach(item => {
                                item.addEventListener('click', function () {
                                    const articleId = this.dataset.id;
                                    searchInput.value = `${articleId}`;
                                    selectedArticleId.value = articleId;
                                    searchResults.classList.add('hidden');

                                    // Update URL and reload page to show shoe name
                                    window.location.href = updateQueryStringParameter(window.location.href, 'article', articleId);
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            searchResults.innerHTML = '<div class="p-4 text-center text-red-500">Error searching articles</div>';
                        });
                }, 300);
            });

            priceGroupSelect.addEventListener('change', function () {
                let selectedPrice = this.value;
                if (selectedPrice) {
                    let currentUrl = new URL(window.location.href);
                    currentUrl.searchParams.set('price_id', selectedPrice);
                    window.location.href = currentUrl.toString();
                }
            });

            // Helper function to update URL parameters
            function updateQueryStringParameter(uri, key, value) {

                const re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
                const separator = uri.indexOf('?') !== -1 ? "&" : "?";
                if (uri.match(re)) {
                    return uri.replace(re, '$1' + key + "=" + value + '$2');
                }
                return uri + separator + key + "=" + value;
            }

            // Close search results when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });

            // Handle keyboard navigation
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    searchResults.classList.add('hidden');
                }
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent form submission

                    const firstResult = searchResults.querySelector('.search-result-item');
                    if (firstResult) {
                        firstResult.click(); // Simulate click on the first result
                    }
                }
            });

            function loadArticleData(articleId, priceId = null) {
                fetch(`/api/stockdata?article=${articleId}${priceId ? `&price_id=${priceId}` : ''}`)
                    .then(response => response.json())
                    .then(data => {
                        updatePriceGroups(data);
                        if (priceId) {
                            updateStockTable(data);
                        }
                    })
                    .catch(handleError);
            }

            function updatePriceGroups(data) {
                priceGroupSelect.innerHTML = '<option value="">Select Price Group</option>';
                Object.entries(data).forEach(([priceId, details]) => {
                    priceGroupSelect.innerHTML += `
                                            <option value="${priceId}">
                                                ${details.group_name || `Price Group ${priceId}`}
                                            </option>
                                        `;
                });
            }

            function updateStockTable(data) {
                if (!Array.isArray(data) || data.length === 0) {
                    stockTableBody.innerHTML = `
                                            <tr>
                                                <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                                    No stock data available
                                                </td>
                                            </tr>
                                        `;
                    return;
                }

                stockTableBody.innerHTML = data.map(stock => `
                                        <tr>
                                            <td class="px-4 py-3">${searchInput.value}</td>
                                            <td class="px-4 py-3">${priceGroupSelect.options[priceGroupSelect.selectedIndex].text}</td>
                                            <td class="px-4 py-3">EU ${stock.size}</td>
                                            <td class="px-4 py-3">
                                                <input type="number" 
                                                       value="${stock.stock}" 
                                                       min="0"
                                                       class="stock-input"
                                                       data-stock-id="${stock.id}"
                                                       onchange="updateStock(this)">
                                            </td>
                                            <td class="px-4 py-3">
                                                <button onclick="deleteStock(${stock.id})" 
                                                        class="text-red-600 hover:text-red-800">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    `).join('');
            }

            function handleError(error) {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="p-4 text-center text-red-500">Error occurred while searching</div>';
            }

            // Price group change handler
            priceGroupSelect.addEventListener('change', function () {
                const articleId = selectedArticleId.value;
                const priceId = this.value;
                if (articleId && priceId) {
                    loadArticleData(articleId, priceId);
                }
            });
        });

        // Ensure CSRF token is included in the header
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        function updateStock(input) {
            const stockId = input.getAttribute('data-stock-id');
            const stockValue = input.value;

            console.log('Updating stock ID:', stockId, 'with value:', stockValue); // Log stock ID and value

            // Send the update request
            fetch(`/admin/stocks/${stockId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken // Use the CSRF token here
                },
                body: JSON.stringify({
                    stock: stockValue,
                    // Include other necessary fields if needed
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Stock updated successfully', 'success');
                } else {
                    showNotification('Error updating stock: ' + (data.message || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                console.error('Error updating stock:', error); // Log the error
                showNotification('Error updating stock', 'error');
            });
        }

        function deleteStock(stockId) {
            if (!confirm('Are you sure you want to delete this stock?')) return;

            fetch(`/admin/stocks/${stockId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => {
                    console.log('Response status:', response.status); // Log the response status
                    return response.json();
                })
                .then(data => {
                    console.log('Delete response:', data); // Log the response data
                    if (data.success) {
                        // Remove the stock row from the table
                        const row = document.querySelector(`[data-stock-id="${stockId}"]`).closest('tr');
                        if (row) {
                            row.remove();
                        }
                        showNotification('Stock deleted successfully', 'success');
                    } else {
                        // Show error message if deletion was not successful
                        showNotification('Error deleting stock: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(() => showNotification('Error deleting stock', 'error'));
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `notification ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-4 py-2 rounded-lg fixed bottom-4 right-4`;
            notification.innerText = message;

            document.body.appendChild(notification);

            // Automatically remove the notification after a few seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endpush