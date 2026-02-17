<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <!-- Add Inter font for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .form-input,
        .form-textarea,
        .form-select {
            @apply bg-white border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm transition duration-150 ease-in-out shadow-sm;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            @apply border-indigo-500 ring-2 ring-indigo-100 outline-none;
        }

        .form-input:hover,
        .form-textarea:hover,
        .form-select:hover {
            @apply border-gray-300;
        }

        .btn-primary {
            @apply bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 focus:ring-4 ring-indigo-200 transition duration-150 ease-in-out font-medium text-sm;
        }

        .btn-secondary {
            @apply bg-white text-gray-700 border border-gray-300 px-4 py-2.5 rounded-lg hover:bg-gray-50 focus:ring-4 ring-gray-200 transition duration-150 ease-in-out font-medium text-sm;
        }

        .card {
            @apply bg-white rounded-xl shadow-sm border border-gray-200 p-6;
        }

        .section-title {
            @apply text-lg font-semibold text-gray-900 mb-4;
        }

        .upload-box {
            border: 2px dashed #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .upload-box:hover {
            border-color: #93c5fd;
            background-color: #f0f9ff;
        }

        .upload-icon {
            width: 48px;
            height: 48px;
            margin-bottom: 10px;
            color: #64748b;
        }

        .add-image-btn,
        .add-video-btn {
            background-color: #e0e7ff;
            color: #4f46e5;
            padding: 6px 16px;
            border-radius: 6px;
            margin-top: 10px;
            font-size: 14px;
        }

        .section-card {
            @apply bg-white rounded-xl shadow-sm border-2 border-gray-100 p-6 hover:border-gray-200 transition-colors duration-200;
        }

        .type-popover {
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .type-tag {
            display: inline-flex;
            align-items: center;
            background: #e8e8e8;
            padding: 4px 8px;
            border-radius: 16px;
            margin: 4px;
        }

        .type-suggestion {
            cursor: pointer;
            padding: 4px 8px;
        }

        .type-suggestion:hover {
            background: #f0f0f0;
        }

        .product-action-btn:focus {
            outline: none;
            background-color: #F3F4F6;
        }

        #productActionDropdown:focus {
            outline: none;
            ring-color: #6366F1;
            ring-offset-width: 2px;
            ring-width: 2px;
        }

        .dropdown-menu {
            @apply absolute right-0 mt-2 w-56 rounded-lg shadow-lg bg-white border-2 border-gray-100 divide-y divide-gray-100 focus:outline-none transform opacity-0 scale-95 transition duration-100 ease-out;
        }

        .dropdown-menu.active {
            @apply opacity-100 scale-100;
        }

        .media-upload-box {
            @apply border-2 border-dashed border-gray-200 rounded-lg p-4 text-center hover:border-indigo-500 hover:bg-indigo-50 transition-all duration-200 cursor-pointer;
        }

        .form-group {
            position: relative;
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: #9CA3AF;
        }

        .form-input:hover::placeholder,
        .form-textarea:hover::placeholder {
            color: #6B7280;
        }

        .form-select {
            background-image: none;
        }

        /* Add subtle shadow on focus */
        .form-input:focus,
        .form-textarea:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Add animation for hover and focus states */
        .form-input,
        .form-textarea,
        .form-select {
            transition: all 0.2s ease-in-out;
        }

        [x-cloak] {
            display: none !important;
        }

        .media-upload-box {
            min-height: 50px;
            height: 100%;
        }

        .image-preview-1,
        .image-preview-2,
        .image-preview-3,
        .image-preview-4,
        .image-preview-5,
        .image-preview-6 {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

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
    </style>

    <!-- Add Cropper.js CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

    <!-- Add Cropper.js JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <!-- Add modal for image cropping -->
    <div id="cropModal" class="fixed inset-0 bg-black bg-opacity-50 z-[100] hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Crop Image</h3>
                        <button type="button" onclick="closeCropModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="relative" style="height: 400px;">
                        <img id="cropperImage" src="" class="max-w-full">
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeCropModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                            Cancel
                        </button>
                        <button type="button" onclick="applyCrop()" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Crop & Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cropper-container {
            max-height: 400px;
        }

        /* Ensure crop modal stays on top */
        #cropModal {
            z-index: 100;
        }

        /* Ensure edit modal stays below crop modal */
        #editModal {
            z-index: 50;
        }
    </style>

</head>

<body class="bg-gray-50 min-h-screen">
    <x-admin.header />
    <main x-data="app">
        <button type="button" @click="closeToast()" x-show="open" x-transition.duration.300ms
            class="fixed right-4 top-4 z-50 rounded-md bg-green-500 px-4 py-2 text-white transition hover:bg-green-600">
            <div class="flex items-center space-x-2">
                <span class="text-3xl"><i class="bx bx-check"></i></span>
                <p class="font-bold"></p>
            </div>
        </button>
    </main>
    <script>
        let timer;

        document.addEventListener("alpine:init", () => {
            Alpine.data("app", () => ({
                open: false,

                openToast() {
                    if (this.open) return;
                    this.open = true;

                    clearTimeout(timer);

                    timer = setTimeout(() => {
                        this.open = false;
                    }, 5000);
                },

                closeToast() {
                    this.open = false;
                },
            }));
        });
    </script>
    <!-- Main Layout -->
    <div class="flex pt-16 min-h-screen overflow-x-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 p-2 sm:p-4 lg:p-6 w-full transition-transform duration-300 ease-in-out">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex justify-between items-center">

                    <div class="relative">
                        <button id="productActionDropdown" class="btn-primary flex items-center">
                            <span id="currentActionTitle">Add New Product</span>
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div id="productActionMenu" class="dropdown-menu hidden">
                            <div class="py-1">
                                <button class="product-action-btn text-left w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out" data-action="add">
                                    Add New Product
                                </button>
                                <button class="product-action-btn text-left w-full px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out" data-action="manage">
                                    Manage Products
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Product Form -->
            <div id="addProductTab" class="tab-content">
                <div class="card space-y-8">
                    <!-- Basic Information -->
                    <div class="section-card mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Article Number <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                        </svg>
                                    </div>
                                    <input type="text" id="addArticleNumber" required
                                        class="form-input pl-10 w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                                  hover:border-gray-300 transition duration-150 ease-in-out"
                                        placeholder="Enter article number">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="addProductName" required
                                        class="form-input pl-10 w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                                  hover:border-gray-300 transition duration-150 ease-in-out"
                                        placeholder="Enter product name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                    </div>
                                    <select id="categorySelect" required
                                        class="form-select pl-10 w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                            focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                            hover:border-gray-300 transition duration-150 ease-in-out 
                                            bg-white appearance-none">
                                        <option value="" selected disabled>Select category</option>
                                    </select>

                                    <script>
                                        let categoryList;
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Fetch categories from the backend
                                            fetch('/api/categoryList') // Adjust the URL as necessary
                                                .then(response => response.json())
                                                .then(data => {
                                                    categoryList = data.Categories;
                                                    const categorySelect = document.getElementById('categorySelect');
                                                    data.Categories.forEach(category => {
                                                        const option = document.createElement('option');
                                                        option.value = category.name;
                                                        option.textContent = category.name;
                                                        categorySelect.appendChild(option);
                                                    });
                                                })
                                                .catch(error => console.error('Error fetching categories:', error));
                                        });
                                    </script>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Color <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="10" fill="#FF6347" />
                                        </svg>
                                    </div>

                                    <input type="text"
                                        id="addProductColor" required
                                        class="form-input pl-10 pr-10 w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                                  hover:border-gray-300 transition duration-150 ease-in-out"
                                        placeholder="Enter product color">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="section-card mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Description</h2>
                        <div class="form-group">
                            <div class="relative">
                                <textarea id="addDescription" required
                                    class="form-textarea w-full h-32 border-2 border-gray-200 rounded-lg px-4 py-3 text-sm 
                                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                           hover:border-gray-300 transition duration-150 ease-in-out"
                                    placeholder="Enter product description"></textarea>
                                <div class="absolute top-3 right-3">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Media -->
                    <div class="section-card mb-6">


                        <!-- Images Section -->
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Product Images (Max 6)</h3>
                            <div class="grid grid-cols-3 gap-6">
                                <!-- Image 1 - Primary Image -->
                                <div class="media-upload-box group relative border-2 border-dashed border-indigo-200 rounded-xl p-4 hover:border-indigo-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage1" class="hidden image-input" data-slot="1" accept="image/*" required>
                                    <div class="image-preview-1 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-indigo-50 rounded-full p-3 mb-3 border border-indigo-100">
                                            <svg class="w-8 h-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-indigo-600">Primary Image</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button"
                                            class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors"
                                            style="display: none;"
                                            onclick="clearImageUpload(this)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Additional Images 2-6 -->
                                <div class="media-upload-box group relative border-2 border-dashed border-blue-200 rounded-xl p-4 hover:border-blue-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage2" class="hidden image-input" data-slot="2" accept="image/*">
                                    <div class="image-preview-2 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-blue-50 rounded-full p-3 mb-3 border border-blue-100">
                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-blue-600">Image 2</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button"
                                            class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors"
                                            style="display: none;"
                                            onclick="clearImageUpload(this)">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Repeat for images 3-6 with different colors -->
                                <div class="media-upload-box group relative border-2 border-dashed border-purple-200 rounded-xl p-4 hover:border-purple-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage3" class="hidden image-input" data-slot="3" accept="image/*">
                                    <div class="image-preview-3 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-purple-50 rounded-full p-3 mb-3 border border-purple-100">
                                            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-purple-600">Image 3</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button" onclick="clearImageUpload(this)" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors" style="display: none;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="media-upload-box group relative border-2 border-dashed border-green-200 rounded-xl p-4 hover:border-green-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage4" class="hidden image-input" data-slot="4" accept="image/*">
                                    <div class="image-preview-4 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-green-50 rounded-full p-3 mb-3 border border-green-100">
                                            <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-green-600">Image 4</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button" onclick="clearImageUpload(this)" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors" style="display: none;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="media-upload-box group relative border-2 border-dashed border-pink-200 rounded-xl p-4 hover:border-pink-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage5" class="hidden image-input" data-slot="5" accept="image/*">
                                    <div class="image-preview-5 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-pink-50 rounded-full p-3 mb-3 border border-pink-100">
                                            <svg class="w-8 h-8 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-pink-600">Image 5</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button" onclick="clearImageUpload(this)" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors" style="display: none;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="media-upload-box group relative border-2 border-dashed border-orange-200 rounded-xl p-4 hover:border-orange-500 transition-colors duration-200 aspect-square">
                                    <input type="file" id="addImage6" class="hidden image-input" data-slot="6" accept="image/*">
                                    <div class="image-preview-6 hidden absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat"></div>
                                    <div class="upload-content flex flex-col items-center justify-center h-full">
                                        <div class="bg-orange-50 rounded-full p-3 mb-3 border border-orange-100">
                                            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        </div>
                                        <span class="text-sm font-semibold text-orange-600">Image 6</span>
                                        <span class="text-xs text-gray-500 mt-1">Click to upload</span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        <button type="button" onclick="clearImageUpload(this)" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors" style="display: none;">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add helper text -->
                            <div class="mt-4 flex items-center space-x-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Images should be in JPG, PNG format and less than 5MB each</span>
                            </div>
                        </div>

                        <!-- Video Section -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Video (MP4 only)</label>
                            <div class="w-[400px] relative border-2 border-gray-300 border-dashed rounded-lg p-6" id="videoDropzone">
                                <input type="file"
                                    id="video-upload"
                                    name="video-upload"
                                    accept="video/mp4"
                                    class="hidden" required />
                                <div class="text-center upload-content cursor-pointer">
                                    <img class="mx-auto h-12 w-12" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="">

                                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                                        <span>Drag and drop</span>
                                        <span class="text-indigo-600"> or browse</span>
                                        <span>to upload</span>
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500">
                                        MP4 format only (max 50MB)
                                    </p>
                                </div>

                                <div class="video-preview-container hidden relative">
                                    <button type="button"
                                        class="remove-video absolute -top-2 -right-2 bg-red-100 rounded-full p-1 shadow-sm hover:bg-red-200 transition-colors z-[60]">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <video src="" class="mt-4 mx-auto max-h-40 w-full" id="videoPreview" controls></video>
                                </div>
                            </div>
                        </div>

                        <script>
                            const videoDropzone = document.getElementById('videoDropzone');
                            const videoPreview = document.getElementById('videoPreview');
                            const uploadContent = videoDropzone.querySelector('.upload-content');
                            const previewContainer = videoDropzone.querySelector('.video-preview-container');
                            const videoInput = document.getElementById('video-upload');
                            const removeButton = videoDropzone.querySelector('.remove-video');

                            // Handle click on upload area
                            uploadContent.addEventListener('click', (e) => {
                                e.stopPropagation();
                                videoInput.click();
                            });

                            videoDropzone.addEventListener('dragover', e => {
                                e.preventDefault();
                                videoDropzone.classList.add('border-indigo-600');
                            });

                            videoDropzone.addEventListener('dragleave', e => {
                                e.preventDefault();
                                videoDropzone.classList.remove('border-indigo-600');
                            });

                            videoDropzone.addEventListener('drop', e => {
                                e.preventDefault();
                                videoDropzone.classList.remove('border-indigo-600');
                                var file = e.dataTransfer.files[0];
                                validateAndDisplayVideo(file);
                            });

                            removeButton.addEventListener('click', (e) => {
                                e.stopPropagation();
                                clearVideo();
                            });

                            videoInput.addEventListener('change', e => {
                                e.stopPropagation();
                                var file = e.target.files[0];
                                if (file) {
                                    validateAndDisplayVideo(file);
                                }
                            });

                            function validateAndDisplayVideo(file) {
                                // Clear previous error messages
                                const existingError = videoDropzone.querySelector('.error-message');
                                if (existingError) existingError.remove();

                                if (file) {
                                    // Validate file type
                                    if (file.type !== 'video/mp4') {
                                        showErrorMessage('Please select an MP4 video file only');
                                        videoInput.value = '';
                                        return;
                                    }

                                    // Valid file, show preview
                                    const fileURL = URL.createObjectURL(file);
                                    videoPreview.src = fileURL;
                                    uploadContent.classList.add('hidden');
                                    previewContainer.classList.remove('hidden');
                                }
                            }

                            function clearVideo() {
                                videoInput.value = '';
                                videoPreview.src = '';
                                previewContainer.classList.add('hidden');
                                uploadContent.classList.remove('hidden');

                                // Revoke object URL to free up memory
                                if (videoPreview.src) {
                                    URL.revokeObjectURL(videoPreview.src);
                                }
                            }

                            function showErrorMessage(message) {
                                const errorDiv = document.createElement('div');
                                errorDiv.className = 'error-message text-red-500 text-sm mt-2 text-center';
                                errorDiv.textContent = message;
                                videoDropzone.appendChild(errorDiv);
                            }
                        </script>
                    </div>

                    <!-- Base Price -->
                    <div class="section-card mb-6" id="basePriceSection">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Base Price</h2>
                        <div class="form-group w-1/3">
                            <div class="relative">
                                <input type="number"
                                    id="basePrice" required
                                    class="form-input w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                              focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                              hover:border-gray-300 transition duration-150 ease-in-out"
                                    placeholder="Enter base price">
                            </div>
                        </div>
                    </div>

                    <!-- Product Types -->
                    <div class="section-card mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Product Types</h2>
                            <button type="button"
                                id="addBoxBtn"
                                class="add-box-btn bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16M4 12h16" />
                                </svg>
                            </button>
                        </div>
                        <div class="boxes-container space-y-4">
                            <!-- Boxes will be added here -->
                        </div>
                    </div>

                    <!-- Box Template -->
                    <template id="boxTemplate">
                        <div class="type-box border rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-center mb-4">
                                <div class="flex items-center gap-4 w-2/3">
                                    <div class="w-1/3">
                                        <input type="number"
                                            class="form-input w-full box-price"
                                            placeholder="Enter price"
                                            min="0">
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" class="add-type-btn text-sm bg-blue-100 text-blue-600 px-3 py-1 rounded-md hover:bg-blue-200">
                                        Add Type
                                    </button>
                                    <button type="button" class="remove-box-btn text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="types-container space-y-3">
                                <!-- Types will be added here -->
                            </div>
                        </div>
                    </template>

                    <!-- Type Row Template -->
                    <template id="typeRowTemplate">
                        <div class="type-row grid grid-cols-12 gap-4 items-start">
                            <div class="col-span-6">
                                <input type="text" class="form-input w-full type-name" placeholder="Type (e.g., Toe, Leather)">
                            </div>
                            <div class="col-span-6">
                                <div class="flex items-center gap-2">
                                    <input type="text" class="form-input w-full subtype-value" placeholder="Value (e.g., Soft, Pure)">
                                    <button type="button" class="remove-type-btn text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const boxesContainer = document.querySelector('.boxes-container');
                            const addBoxBtn = document.getElementById('addBoxBtn');
                            const basePriceSection = document.getElementById('basePriceSection');
                            const basePrice = document.getElementById('basePrice');

                            // Function to toggle base price section
                            function toggleBasePriceSection(hasBoxes) {
                                if (hasBoxes) {
                                    basePriceSection.classList.add('opacity-50', 'pointer-events-none');
                                    basePrice.value = ''; // Clear base price when boxes are added
                                    basePrice.disabled = true;
                                } else {
                                    basePriceSection.classList.remove('opacity-50', 'pointer-events-none');
                                    basePrice.disabled = false;
                                }
                            }

                            // Function to check if there are any boxes
                            function checkBoxes() {
                                const hasBoxes = boxesContainer.children.length > 0;
                                toggleBasePriceSection(hasBoxes);
                                addBoxBtn.disabled = basePrice.value !== '';
                                addBoxBtn.classList.toggle('opacity-50', basePrice.value !== '');
                            }

                            // Add new box
                            addBoxBtn.addEventListener('click', () => {
                                const boxTemplate = document.getElementById('boxTemplate');
                                const newBox = boxTemplate.content.cloneNode(true);
                                boxesContainer.appendChild(newBox);
                                initializeBox(boxesContainer.lastElementChild);
                                checkBoxes();
                            });

                            // Base price input handler
                            basePrice.addEventListener('input', (e) => {
                                const hasValue = e.target.value !== '';
                                addBoxBtn.disabled = hasValue;
                                addBoxBtn.classList.toggle('opacity-50', hasValue);

                                if (hasValue) {
                                    // Clear all boxes if base price is entered
                                    boxesContainer.innerHTML = '';
                                }
                            });

                            // Initialize box functionality
                            function initializeBox(box) {
                                const addTypeBtn = box.querySelector('.add-type-btn');
                                const removeBoxBtn = box.querySelector('.remove-box-btn');
                                const typesContainer = box.querySelector('.types-container');
                                const priceInput = box.querySelector('.box-price');

                                // Add type
                                addTypeBtn.addEventListener('click', () => {
                                    const typeTemplate = document.getElementById('typeRowTemplate');
                                    const newType = typeTemplate.content.cloneNode(true);
                                    typesContainer.appendChild(newType);
                                    initializeTypeRow(typesContainer.lastElementChild);
                                });

                                // Remove box
                                removeBoxBtn.addEventListener('click', () => {
                                    box.remove();
                                    checkBoxes(); // Check if there are any boxes left
                                });

                                // Validate price
                                priceInput.addEventListener('input', (e) => {
                                    if (e.target.value < 0) {
                                        e.target.value = 0;
                                    }
                                });
                            }

                            // Initialize type row functionality
                            function initializeTypeRow(typeRow) {
                                const removeTypeBtn = typeRow.querySelector('.remove-type-btn');
                                removeTypeBtn.addEventListener('click', () => {
                                    typeRow.remove();
                                });
                            }

                            // Update the click handler for media upload boxes
                            document.querySelectorAll('.media-upload-box').forEach(box => {
                                box.addEventListener('click', function(e) {
                                    // Don't trigger if clicking the remove button
                                    if (!e.target.closest('.remove-image-btn')) {
                                        const input = this.querySelector('.image-input');
                                        if (input) {
                                            input.click();
                                        }
                                    }
                                });
                            });

                            // Update the image input change handler
                            document.querySelectorAll('.image-input').forEach(input => {
                                input.addEventListener('change', function(e) {
                                    const file = e.target.files[0];
                                    if (file) {

                                        const slot = this.dataset.slot;
                                        const box = this.closest('.media-upload-box');
                                        const preview = box.querySelector(`.image-preview-${slot}`);
                                        const uploadContent = box.querySelector('.upload-content');
                                        const removeBtn = box.querySelector('.remove-image-btn');

                                        const reader = new FileReader();
                                        reader.onload = function(e) {
                                            preview.style.backgroundImage = `url(${e.target.result})`;
                                            preview.classList.remove('hidden');
                                            uploadContent.classList.add('hidden');
                                            removeBtn.style.display = 'block';
                                        };
                                        reader.readAsDataURL(file);
                                    }
                                });
                            });

                            // Update the close modal handlers
                            function closeEditModal() {
                                const modal = document.getElementById('editProductModal');
                                if (modal) {
                                    modal.classList.add('hidden');
                                }
                            }

                            // Handle close button clicks (including the X icon)
                            const closeButtons = document.querySelectorAll('.close-modal');
                            closeButtons.forEach(button => {
                                button.addEventListener('click', function(e) {
                                    e.preventDefault();
                                    e.stopPropagation(); // Add this to prevent event bubbling
                                    closeEditModal();
                                });
                            });

                            // Handle click outside modal
                            const modal = document.getElementById('editProductModal');
                            if (modal) {
                                modal.addEventListener('click', function(e) {
                                    if (e.target === modal) {
                                        closeEditModal();
                                    }
                                });

                                // Prevent modal close when clicking inside the modal content
                                const modalContent = modal.querySelector('.bg-white');
                                if (modalContent) {
                                    modalContent.addEventListener('click', function(e) {
                                        e.stopPropagation();
                                    });
                                }
                            }
                        });
                    </script>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit" id="addProduct" class="flex btn-primary bg-lime-400 hover:bg-lime-500 px-6 py-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path d="M17 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zM12 19c-2.76 0-5-2.24-5-5 
                                       0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.76-2.24 5-5 5zm3-9H9V4h6v6z" />
                            </svg> Save
                        </button>
                    </div>
                </div>
            </div>

            <!-- Add this script section before closing div -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <!-- Manage Products Tab -->
            <div id="manageProductTab" class="tab-content hidden">
                <!-- Products Table Section -->
                <div class="bg-white rounded-xl shadow-sm border-2 border-gray-100 overflow-hidden">
                    <!-- Table Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="grid grid-cols-3 gap-6">
                            <!-- Search -->
                            <div class="form-group">
                                <div class="relative">
                                    <input type="text"
                                        id="productSearch"
                                        class="form-input pl-10 w-full"
                                        placeholder="Search products...">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Article No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="productsTableBody">
                                <!-- Table rows will be dynamically inserted here -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="hidden p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search </p>
                    </div>
                </div>
                <div id="paginationControls" class="flex justify-between items-center mt-4">
                    <button id="prevPage" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50" disabled>
                        Previous
                    </button>
                    <span id="currentPage" class="text-sm text-gray-700"></span>
                    <button id="nextPage" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 disabled:opacity-50" disabled>
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>



    <x-admin.change-password-modal />

    <!-- Scripts -->
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize edit mode variables
            const editBasePriceSection = document.getElementById('editBasePriceSection');
            const editBasePrice = document.getElementById('editBasePrice');
            const editBoxesContainer = document.getElementById('editBoxesContainer');
            const editAddBoxBtn = document.getElementById('editAddBoxBtn');
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const mainContent = document.querySelector('.flex-1');
            const overlay = document.createElement('div');
            let sidebarOpen = false;

            document.getElementById('addProduct').addEventListener('click', async function(e) {
                e.preventDefault();
                const boxes = document.querySelectorAll('.type-box');
                const result = [];

                // If no boxes -> use basePrice
                if (boxes.length === 0) {
                    const basePriceValue = document.getElementById('basePrice').value;
                    result.push({
                        grouping: null,
                        price: basePriceValue
                    });
                } else {
                    // loop em
                    boxes.forEach(box => {
                        // Get the price value from the box (Not Roddy Ricch song - The Box)
                        const priceInput = box.querySelector('.box-price');
                        const price = priceInput.value;

                        // Get all type inside the box
                        const typeRows = box.querySelectorAll('.type-row');
                        let grouping = null;

                        // if type -> group em
                        if (typeRows.length > 0) {
                            grouping = {};
                            typeRows.forEach(row => {
                                const typeNameInput = row.querySelector('.type-name');
                                const subtypeInput = row.querySelector('.subtype-value');
                                const typeName = typeNameInput.value.trim();
                                const subtypeValue = subtypeInput.value.trim();

                                // Only non empty types haru
                                if (typeName) {
                                    // Convert to lowercase
                                    grouping[typeName.toLowerCase()] = subtypeValue;
                                }
                            });
                            // No valid type entries -> revert grouping to null
                            if (Object.keys(grouping).length === 0) {
                                grouping = null;
                            }
                        }

                        result.push({
                            grouping,
                            price
                        });
                    });
                }
                const validPrice = result.length > 0 && result.some(item => item.price);
                console.log(validPrice);
                if (validateForm(validPrice)) {
                    const formData = new FormData();
                    formData.append('article_id', document.getElementById('addArticleNumber').value);
                    formData.append('product_name', document.getElementById('addProductName').value);
                    formData.append('category_name', document.getElementById('categorySelect').value);
                    formData.append('product_color', document.getElementById('addProductColor').value);
                    formData.append('shoe_description', document.getElementById('addDescription').value);
                    formData.append('price_combinations', JSON.stringify(result));

                    // For each image, if a file is selected, append the file (assuming one file per input)
                    const imageInputs = [
                        'addImage1', 'addImage2', 'addImage3',
                        'addImage4', 'addImage5', 'addImage6'
                    ];
                    imageInputs.forEach((id, index) => {
                        const input = document.getElementById(id);
                        if (input.files.length > 0) {
                            // Append each image file individually.
                            formData.append(`shoe_image${index + 1}`, input.files[0]);
                        }
                    });

                    // Append the video file, if present
                    const videoInput = document.getElementById('video-upload');
                    if (videoInput.files.length > 0) {
                        formData.append('shoe_video', videoInput.files[0]);
                    }

                    // Retrieve CSRF token from meta tag
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    // Assume you have the bearer token from somewhere (e.g., local storage or a JS variable)
                    const bearerToken = localStorage.getItem('auth_token');

                    try {
                        const response = await fetch('/api/shoes', {
                            method: 'POST',
                            headers: {
                                'Authorization': `Bearer ${bearerToken}`,
                                'X-CSRF-Token': csrfToken
                            },
                            body: formData
                        });
                        const data = await response.json();
                        const toast = document.querySelector('main[x-data="app"] button p');
                        const toastButton = document.querySelector('main[x-data="app"] button');
                        const toastIcon = toastButton.querySelector('span i');

                        const appComponent = Alpine.store || Alpine;
                        const toastComponent = Alpine.$data(document.querySelector('main[x-data="app"]'));

                        if (response.ok) {
                            // Handle success (for example, display a success message or redirect)
                            console.log('Product saved successfully');
                            toastButton.classList.remove('bg-red-500', 'hover:bg-red-600');
                            toastButton.classList.add('bg-green-500', 'hover:bg-green-600');

                            toastIcon.classList.remove('bx-x');
                            toastIcon.classList.add('bx-check');
                            toast.textContent = data.message;
                        } else {
                            // Handle errors
                            toast.textContent = data.error;
                            toastButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                            toastButton.classList.add('bg-red-500', 'hover:bg-red-600');

                            toastIcon.classList.remove('bx-check');
                            toastIcon.classList.add('bx-x');
                        }
                        toastComponent.openToast();
                    } catch (error) {
                        const toast = document.querySelector('main[x-data="app"] button p');
                        const toastButton = document.querySelector('main[x-data="app"] button');
                        const toastIcon = toastButton.querySelector('span i');
                        toastButton.classList.remove('bg-green-500', 'hover:bg-green-600');
                        toastButton.classList.add('bg-red-500', 'hover:bg-red-600');
                        const toastComponent = Alpine.$data(document.querySelector('main[x-data="app"]'));

                        toastIcon.classList.remove('bx-check');
                        toastIcon.classList.add('bx-x');

                        toast.textContent = 'Network error: ' + error.message;
                        toastComponent.openToast();
                    }
                }
            });

            // Create and style overlay
            overlay.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 transition-opacity lg:hidden hidden';
            overlay.setAttribute('aria-hidden', 'true');
            document.body.appendChild(overlay);

            // Sidebar toggle functionality
            sidebarToggle.addEventListener('click', () => {
                sidebarOpen = !sidebarOpen;
                if (sidebarOpen) {
                    sidebar.style.transform = 'translateX(0)';
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', () => {
                sidebarOpen = false;
                sidebar.style.transform = 'translateX(-100%)';
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            });

            // Initialize FilePond for images
            FilePond.create(document.querySelector('input[name="photos[]"]'), {
                allowMultiple: true,
                maxFiles: 6,
                acceptedFileTypes: ['image/*'],
                labelIdle: 'Drag & drop photos or <span class="filepond--label-action">browse</span>',
                stylePanelLayout: 'compact circle',
                imagePreviewHeight: 170,
                imageCropAspectRatio: '1:1',
            });

            // Initialize FilePond for video
            FilePond.create(document.querySelector('input[name="video"]'), {
                allowMultiple: false,
                acceptedFileTypes: ['video/*'],
                labelIdle: 'Drag & drop video or <span class="filepond--label-action">browse</span>',
            });

            // Initialize dropdown and tabs
            const dropdown = document.getElementById('productActionDropdown');
            const menu = document.getElementById('productActionMenu');
            const actionButtons = document.querySelectorAll('.product-action-btn');
            const actionTitle = document.getElementById('currentActionTitle');
            const tabContents = document.querySelectorAll('.tab-content');

            function showTab(tabId, title) {
                tabContents.forEach(content => content.classList.add('hidden'));
                document.getElementById(tabId).classList.remove('hidden');
                actionTitle.textContent = title;
            }

            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('manage') === '1') {
                showTab('manageProductTab', 'Manage Product');
                loadProducts();
            } else {
                showTab('addProductTab', 'Add New Product');
            }

            dropdown.addEventListener('click', () => menu.classList.toggle('hidden'));

            document.addEventListener('click', (e) => {
                if (!dropdown.contains(e.target)) menu.classList.add('hidden');
            });

            actionButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const action = button.getAttribute('data-action');
                    const url = new URL(window.location);
                    if (action === 'manage') {
                        url.searchParams.set('manage', '1');
                        window.history.pushState({}, '', url);
                        showTab('manageProductTab', 'Manage Product');
                        loadProducts();
                    } else if (action === 'add') {
                        url.searchParams.delete('manage');
                        window.history.pushState({}, '', url);
                        showTab('addProductTab', 'Add New Product');
                    }
                    menu.classList.add('hidden');
                });
            });

            // Add Product Form Handlers
            const addTypeBtn = document.querySelector('.add-type-btn');
            const typesContainer = document.querySelector('.types-container');

            if (addTypeBtn && typesContainer) {
                addTypeBtn.addEventListener('click', () => {
                    const typeTemplate = document.getElementById('typeTemplate');
                    const newType = typeTemplate.content.cloneNode(true);
                    typesContainer.appendChild(newType);

                    // Initialize handlers for the new type
                    const typeGroup = typesContainer.lastElementChild;
                    initializeTypeHandlers(typeGroup);
                });
            }

            // Initialize type handlers
            function initializeTypeHandlers(typeGroup) {
                // Remove type button
                const removeTypeBtn = typeGroup.querySelector('.remove-type-btn');
                if (removeTypeBtn) {
                    removeTypeBtn.addEventListener('click', () => typeGroup.remove());
                }

                // Add subtype button
                const addSubtypeBtn = typeGroup.querySelector('.add-subtype-btn');
                const subtypesContainer = typeGroup.querySelector('.subtypes-container');

                // Price validation
                const typePrice = typeGroup.querySelector('.type-price');
                if (typePrice) {
                    typePrice.addEventListener('input', (e) => {
                        if (e.target.value < 0) {
                            e.target.value = 0;
                        }
                    });
                }

                if (addSubtypeBtn && subtypesContainer) {
                    addSubtypeBtn.addEventListener('click', () => {
                        const subtypeTemplate = document.getElementById('subtypeTemplate');
                        const newSubtype = subtypeTemplate.content.cloneNode(true);
                        subtypesContainer.appendChild(newSubtype);
                        initializeSubtypeHandlers(subtypesContainer.lastElementChild);
                    });
                }
            }

            // Initialize subtype handlers
            function initializeSubtypeHandlers(subtypeGroup) {
                const removeSubtypeBtn = subtypeGroup.querySelector('.remove-subtype-btn');
                if (removeSubtypeBtn) {
                    removeSubtypeBtn.addEventListener('click', () => subtypeGroup.remove());
                }
            }

            // Initialize subtype2 handlers
            function initializeSubtype2Handlers(subtype2Group) {
                // Remove subtype2 button
                const removeSubtype2Btn = subtype2Group.querySelector('.remove-subtype2-btn');
                if (removeSubtype2Btn) {
                    removeSubtype2Btn.addEventListener('click', () => subtype2Group.remove());
                }

                // Add subtype3 button
                const addSubtype3Btn = subtype2Group.querySelector('.add-subtype3-btn');
                const subtype3Container = subtype2Group.querySelector('.subtype3-container');

                if (addSubtype3Btn && subtype3Container) {
                    addSubtype3Btn.addEventListener('click', () => {
                        const subtype3Template = document.getElementById('subtype3Template');
                        const newSubtype3 = subtype3Template.content.cloneNode(true);
                        subtype3Container.appendChild(newSubtype3);

                        // Initialize remove handler for the new subtype3
                        const removeSubtype3Btn = subtype3Container.lastElementChild.querySelector('.remove-subtype3-btn');
                        if (removeSubtype3Btn) {
                            removeSubtype3Btn.addEventListener('click', (e) => {
                                e.target.closest('.subtype3-group').remove();
                            });
                        }
                    });
                }
            }

            // Load products function for manage tab
            let currentPage = 1;

            async function loadProducts(page = 1) {
                try {
                    const response = await fetch(`/api/shoes?page=${page}`);
                    const data = await response.json();

                    const tableBody = document.querySelector('#productsTableBody');
                    tableBody.innerHTML = '';

                    data.Shoes.forEach(product => {
                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 transition-colors duration-150';

                        const imageThumbnail = product.shoe_image ? `
                <div class="relative group inline-block">
                    <img src="${product.shoe_image}" alt="${product.shoe_name}" class="h-12 w-12 rounded object-cover">
                </div>
            ` : '<span class="text-gray-400 text-sm">No image</span>';

                        row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    ${product.article_id}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ${product.category_name}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    <div class="max-w-xs truncate">
                        ${product.shoe_name}
                    </div>
                </td>
                <td class="px-6 py-4">
                    ${imageThumbnail}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end space-x-3">
                        <button onclick="editProduct('${product.article_id}')"
                                class="text-blue-600 hover:text-blue-900 transition-colors duration-150"
                                title="Edit">
                            Edit
                        </button>
                        <button onclick="deleteProduct('${product.article_id}')"
                                class="text-red-600 hover:text-red-900 transition-colors duration-150"
                                title="Delete">
                            Delete
                        </button>
                    </div>
                </td>
            `;
                        tableBody.appendChild(row);
                    });

                    // Update pagination controls
                    document.getElementById('currentPage').textContent = `Page ${data.pagination.current_page} of ${data.pagination.last_page}`;
                    document.getElementById('prevPage').disabled = !data.pagination.prev_page_url;
                    document.getElementById('nextPage').disabled = !data.pagination.next_page_url;

                    currentPage = data.pagination.current_page;
                } catch (error) {
                    console.error('Error loading products:', error);
                    const tableBody = document.querySelector('#productsTableBody');
                    tableBody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                    Error loading products. Please try again later.
                </td>
            </tr>
        `;
                }
            }

            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    loadProducts(currentPage - 1);
                }
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                loadProducts(currentPage + 1);
            });

            document.addEventListener('DOMContentLoaded', () => {
                loadProducts();
            });

            // Initialize search and filter functionality
            initializeSearchAndFilter();

            // Add this JavaScript for image handling
            const imageInputs = document.querySelectorAll('.image-input');

            imageInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const slot = this.dataset.slot;

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.querySelector(`.image-preview-${slot}`);
                            const uploadContent = this.closest('.media-upload-box').querySelector('.upload-content');
                            const removeBtn = this.closest('.media-upload-box').querySelector('.remove-image-btn');

                            preview.style.backgroundImage = `url(${e.target.result})`;
                            preview.classList.remove('hidden');
                            uploadContent.classList.add('hidden');
                            removeBtn.style.display = 'block';
                        }.bind(this);

                        reader.readAsDataURL(file);
                    }
                });
            });

            // Remove image functionality
            document.querySelectorAll('.remove-image-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const box = this.closest('.media-upload-box');
                    const input = box.querySelector('.image-input');
                    const preview = box.querySelector('[class^="image-preview-"]');
                    const uploadContent = box.querySelector('.upload-content');

                    input.value = ''; // Clear input
                    preview.style.backgroundImage = '';
                    preview.classList.add('hidden');
                    uploadContent.classList.remove('hidden');
                    this.style.display = 'none';
                });
            });

            // Trigger file input when clicking on upload box
            document.querySelectorAll('.media-upload-box').forEach(box => {
                box.addEventListener('click', function(e) {
                    if (!e.target.closest('.remove-image-btn')) {
                        this.querySelector('.image-input').click();
                    }
                });
            });

            // Add this JavaScript for video handling
            const videoDropzone = document.getElementById('videoDropzone');
            const videoPreview = document.getElementById('videoPreview');
            const uploadContent = videoDropzone.querySelector('.upload-content');
            const previewContainer = videoDropzone.querySelector('.video-preview-container');
            const videoInput = document.getElementById('video-upload');
            const removeButton = videoDropzone.querySelector('.remove-video');

            // Handle click on upload area
            uploadContent.addEventListener('click', (e) => {
                e.stopPropagation();

                videoInput.click();
            });

            videoDropzone.addEventListener('dragover', e => {
                e.preventDefault();
                videoDropzone.classList.add('border-indigo-600');
            });

            videoDropzone.addEventListener('dragleave', e => {
                e.preventDefault();
                videoDropzone.classList.remove('border-indigo-600');
            });

            videoDropzone.addEventListener('drop', e => {
                e.preventDefault();
                videoDropzone.classList.remove('border-indigo-600');
                var file = e.dataTransfer.files[0];
                validateAndDisplayVideo(file);
            });

            removeButton.addEventListener('click', (e) => {
                e.stopPropagation();
                clearVideo();
            });

            videoInput.addEventListener('change', e => {
                e.stopPropagation();
                var file = e.target.files[0];
                if (file) {
                    validateAndDisplayVideo(file);
                }
            });

            function validateAndDisplayVideo(file) {
                // Clear previous error messages
                const existingError = videoDropzone.querySelector('.error-message');
                if (existingError) existingError.remove();

                if (file) {
                    // Validate file type
                    if (file.type !== 'video/mp4') {
                        showErrorMessage('Please select an MP4 video file only');
                        videoInput.value = '';
                        return;
                    }

                    // Valid file, show preview
                    const fileURL = URL.createObjectURL(file);
                    videoPreview.src = fileURL;
                    uploadContent.classList.add('hidden');
                    previewContainer.classList.remove('hidden');
                }
            }

            function clearVideo() {
                videoInput.value = '';
                videoPreview.src = '';
                previewContainer.classList.add('hidden');
                uploadContent.classList.remove('hidden');

                // Revoke object URL to free up memory
                if (videoPreview.src) {
                    URL.revokeObjectURL(videoPreview.src);
                }
            }

            function showErrorMessage(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-red-500 text-sm mt-2 text-center';
                errorDiv.textContent = message;
                videoDropzone.appendChild(errorDiv);
            }

            // Fetch categories from the API
            async function loadCategories() {
                try {
                    const response = await fetch('/api/categories');
                    const data = await response.json();
                    const categorySelect = document.getElementById('categorySelect');
                    const categoryFilter = document.getElementById('categoryFilter');

                    // Clear existing options except the default one
                    categorySelect.innerHTML = '<option value="">Select category</option>';
                    categoryFilter.innerHTML = '<option value="">All Categories</option>';

                    // Add categories to both dropdowns
                    data.Categories.forEach(category => {
                        // Add to product form dropdown
                        const option = document.createElement('option');
                        option.value = category.category_name;
                        option.textContent = category.category_name;
                        categorySelect.appendChild(option);

                        // Add to filter dropdown
                        const filterOption = document.createElement('option');
                        filterOption.value = category.category_name;
                        filterOption.textContent = category.category_name;
                        categoryFilter.appendChild(filterOption);
                    });
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }

            // Call loadCategories when the page loads
            loadCategories();
        });


        function initializeSearchAndFilter() {
            // Search functionality
            const searchInput = document.getElementById('productSearch');
            searchInput.addEventListener('input', (e) => {
                const searchTerm = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#manageProductTab table tbody tr');

                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Category filter
            const categoryFilter = document.getElementById('categoryFilter');
            const categories = fetch('/api/categoryList').then(response => response.json());
            categories.Categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.name;
                option.textContent = category.name;
                categoryFilter.appendChild(option);
            });

            categoryFilter.addEventListener('change', (e) => {
                const category = e.target.value.toLowerCase();
                const rows = document.querySelectorAll('#manageProductTab table tbody tr');

                rows.forEach(row => {
                    const rowCategory = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    row.style.display = !category || rowCategory === category ? '' : 'none';
                });
            });

            // Add sort functionality
            const sortSelect = document.getElementById('sortBy');
            sortSelect.addEventListener('change', (e) => {
                const sortBy = e.target.value;
                const rows = Array.from(document.querySelectorAll('#manageProductTab table tbody tr'));

                rows.sort((a, b) => {
                    const aText = a.querySelector('td:nth-child(2)').textContent;
                    const bText = b.querySelector('td:nth-child(2)').textContent;

                    if (sortBy === 'name') return aText.localeCompare(bText);
                    if (sortBy === 'name-desc') return bText.localeCompare(aText);
                    return 0;
                });

                const tbody = document.querySelector('#manageProductTab table tbody');
                tbody.innerHTML = '';
                rows.forEach(row => tbody.appendChild(row));
            });
        }

        function populateCategoryDropdown() {
            const editCategorySelect = document.getElementById('editCategory');
            editCategorySelect.innerHTML = ''; // Clear existing options if needed

            categoryList.forEach(category => {
                const option = document.createElement('option');
                option.value = category.name;
                option.textContent = category.name;
                editCategorySelect.appendChild(option);
            });
        }

        // Function to handle edit button click
        function editProduct(productId) {
            const modal = document.getElementById('editProductModal');
            modal.classList.remove('hidden');
            // Retrieve CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Assume you have the bearer token from somewhere (e.g., local storage or a JS variable)
            const bearerToken = localStorage.getItem('auth_token');

            // Fetch product details from the backend
            fetch(`/api/shoedetail/${productId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${bearerToken}`,
                        'Accept': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    credentials: 'include',
                }) // Ensure this matches your API route
                .then(response => response.json())
                .then(data => {
                    if (!data || data.error) {
                        console.log('Product not found or error fetching data');
                        return;
                    }

                    const product = data[0]; // Assuming the response is an array of products
                    populateCategoryDropdown();
                    const editCategorySelect = document.getElementById('editCategory');
                    editCategorySelect.value = product.category_name;
                    // Populate basic fields
                    document.getElementById('productIdSpan').textContent = product.article_id;
                    document.getElementById('editProductColor').value = product.shoe_color;
                    document.getElementById('editProductId').value = product.article_id;
                    document.getElementById('editArticleName').value = product.shoe_name;
                    document.getElementById('editCategory').value = product.category_name;
                    document.getElementById('editDescription').value = product.shoe_description;

                    // Handle Images
                    const imagesContainer = document.getElementById('editImagesContainer');
                    imagesContainer.innerHTML = '';

                    // Create image boxes for all 6 slots
                    for (let index = 0; index < 6; index++) {
                        const imageBox = document.createElement('div');
                        imageBox.className = 'media-upload-box group relative border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-gray-300 transition-colors duration-200 aspect-square';

                        const image = product[`shoe_image${index + 1}`];
                        const imagePreview = image ?
                            `<div class="image-preview absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat" 
                                  style="background-image: url('/assets/images/products/${product.article_id}/${image}');">
                             </div>` :
                            `<div class="image-preview absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat hidden"></div>`;

                        imageBox.innerHTML = `
                            <input type="file" class="hidden image-input" data-slot="${index + 1}" accept="image/*">
                            ${imagePreview}
                            <div class="upload-content flex flex-col items-center justify-center h-full ${image ? 'hidden' : ''}">
                                <div class="bg-gray-50 rounded-full p-3 mb-3 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-600">Click to upload</span>
                            </div>
                            <div class="absolute top-3 right-3 z-10 ${!image ? 'hidden' : ''}">
                                <button type="button" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        `;
                        imagesContainer.appendChild(imageBox);
                        initializeImageHandlers(imageBox);
                    }


                    // Handle Video
                    if (product.video) {
                        const editVideoPreview = document.getElementById('editVideoPreview');
                        const editUploadContent = document.querySelector('#editVideoDropzone .upload-content');
                        const editPreviewContainer = document.querySelector('#editVideoDropzone .video-preview-container');

                        // Set the video source
                        editVideoPreview.src = product.video;

                        // Show the video preview and hide the upload content
                        editUploadContent.classList.add('hidden');
                        editPreviewContainer.classList.remove('hidden');
                    } else {
                        // If no video, reset the preview
                        const editUploadContent = document.querySelector('#editVideoDropzone .upload-content');
                        const editPreviewContainer = document.querySelector('#editVideoDropzone .video-preview-container');
                        const editVideoPreview = document.getElementById('editVideoPreview');

                        editVideoPreview.src = '';
                        editUploadContent.classList.remove('hidden');
                        editPreviewContainer.classList.add('hidden');
                    }

                    // Clear any existing boxes
                    editBoxesContainer.innerHTML = '';
                    // Handle base price
                    if (product.prices && product.prices.length > 0) {
                        // Look for the price entry where product_grouping is null
                        const basePriceObj = product.prices.find(priceObj => priceObj.product_grouping === null);
                        if (basePriceObj) {
                            editBasePrice.value = basePriceObj.price;
                        } else {
                            editBasePrice.value = '';
                            product.prices.forEach(priceObj => {
                                const boxTemplate = document.getElementById('editBoxTemplate');
                                const newBox = boxTemplate.content.cloneNode(true);
                                editBoxesContainer.appendChild(newBox);

                                const boxElement = editBoxesContainer.lastElementChild;
                                const priceInput = boxElement.querySelector('.box-price');
                                priceInput.value = priceObj.price;

                                // Add types for this box
                                const typesContainer = boxElement.querySelector('.types-container');
                                // Use Object.entries to iterate over product_grouping object
                                Object.entries(priceObj.product_grouping).forEach(([key, value]) => {
                                    const typeTemplate = document.getElementById('editTypeRowTemplate');
                                    const newType = typeTemplate.content.cloneNode(true);
                                    typesContainer.appendChild(newType);

                                    const typeElement = typesContainer.lastElementChild;
                                    const typeNameInput = typeElement.querySelector('.type-name');
                                    const typeValueInput = typeElement.querySelector('.subtype-value');

                                    // Set the type name as the key and the type value as the value from product_grouping
                                    typeNameInput.value = key;
                                    typeValueInput.value = value;

                                    initializeEditTypeRow(typeElement);
                                });

                                initializeEditBox(boxElement);
                            });
                        }
                    } else {
                        editBasePrice.value = '';
                    }


                    checkEditBoxes();
                })
                .catch(error => {
                    console.error('Error fetching product:', error);
                });
        }

        function createEmptyImageBox() {
            const emptyBox = document.createElement('div');
            emptyBox.className = 'media-upload-box group relative border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-gray-300 transition-colors duration-200';
            emptyBox.innerHTML = `
                <input type="file" class="hidden image-input" accept="image/*">
                <div class="image-preview absolute inset-0 rounded-xl bg-cover bg-center bg-no-repeat hidden"></div>
                <div class="upload-content flex flex-col items-center justify-center h-40">
                    <div class="bg-gray-50 rounded-full p-3 mb-3 border border-gray-100">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-600">Click to upload</span>
                </div>
                <div class="absolute top-3 right-3 z-10 hidden">
                    <button type="button" class="remove-image-btn p-1.5 bg-white rounded-lg shadow-sm border border-gray-200 text-gray-500 hover:text-red-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `;
            return emptyBox;
        }

        function createEmptyVideoBox() {
            return `
                <div class="w-full">
                    <div class="media-upload-box group relative border-2 border-dashed border-gray-200 rounded-xl p-6" id="videoDropzone">
                        <input type="file" 
                               id="video-upload" 
                               name="video-upload" 
                               accept="video/mp4"
                               class="hidden" />
                        <div class="text-center upload-content cursor-pointer">
                            <img class="mx-auto h-12 w-12" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="">

                            <h3 class="mt-2 text-sm font-medium text-gray-900">
                                <span>Drag and drop</span>
                                <span class="text-indigo-600"> or browse</span>
                                <span>to upload</span>
                            </h3>
                            <p class="mt-1 text-xs text-gray-500">
                                MP4 format only (max 50MB)
                            </p>
                        </div>

                        <div class="video-preview-container hidden relative">
                            <button type="button" 
                                    class="remove-video-btn absolute -top-2 -right-2 bg-red-100 rounded-full p-1 shadow-sm hover:bg-red-200 transition-colors z-[60]">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <video src="" class="mt-4 mx-auto max-h-40 w-full" id="videoPreview" controls></video>
                        </div>
                    </div>
                </div>
            `;
        }

        function renderSubtypes(type) {
            let html = '';

            if (type.subtype1 && type.subtype1.length > 0) {
                type.subtype1.forEach(subtype1 => {
                    html += `
                        <div class="subtype-group border-l-2 border-gray-200 pl-4">
                            <div class="flex justify-between items-center mb-3">
                                <input type="text" class="form-input subtype-name w-1/3" value="${subtype1.name}" placeholder="Enter subtype 1">
                                <div class="flex gap-2">
                                    <button type="button" class="add-subtype2-btn bg-green-100 text-green-600 px-3 py-1 rounded-md text-sm">
                                        Add Subtype 2
                                    </button>
                                    <button type="button" class="remove-subtype-btn text-red-600 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="subtype2-container ml-4 space-y-2">
                                ${renderSubtype2Values(subtype1.subtype2)}
                            </div>
                        </div>
                    `;
                });
            }

            return html;
        }

        function renderSubtype2Values(subtype2Items = []) {
            if (!subtype2Items) return '';

            return subtype2Items.map(subtype2 => `
                <div class="subtype2-group border-l-2 border-gray-200 pl-4">
                    <div class="flex justify-between items-center mb-3">
                        <input type="text" class="form-input subtype2-name w-1/3" value="${subtype2.name}" placeholder="Enter subtype 2">
                        <div class="flex gap-2">
                            <button type="button" class="add-subtype3-btn bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm">
                                Add Subtype 3
                            </button>
                            <button type="button" class="remove-subtype2-btn text-red-600 hover:text-red-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="subtype3-container ml-4 space-y-2">
                        ${renderSubtype3Values(subtype2.subtype3)}
                    </div>
                </div>
            `).join('');
        }

        function renderSubtype3Values(subtype3Items = []) {
            if (!subtype3Items) return '';

            return subtype3Items.map(subtype3 => `
                <div class="subtype3-group flex items-center justify-between gap-4">
                    <input type="text" class="form-input subtype3-name w-1/3" value="${subtype3.name}" placeholder="Enter subtype 3">
                    <button type="button" class="remove-subtype3-btn text-red-600 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            `).join('');
        }

        // Make sure to initialize handlers for all buttons after rendering
        function initializeTypeHandlers(typeGroup) {
            // Remove type button
            const removeTypeBtn = typeGroup.querySelector('.remove-type-btn');
            if (removeTypeBtn) {
                removeTypeBtn.addEventListener('click', () => typeGroup.remove());
            }

            // Add subtype button
            const addSubtypeBtn = typeGroup.querySelector('.add-subtype-btn');
            const subtypesContainer = typeGroup.querySelector('.subtypes-container');

            // Price validation
            const typePrice = typeGroup.querySelector('.type-price');
            if (typePrice) {
                typePrice.addEventListener('input', (e) => {
                    if (e.target.value < 0) {
                        e.target.value = 0;
                    }
                });
            }

            if (addSubtypeBtn && subtypesContainer) {
                addSubtypeBtn.addEventListener('click', () => {
                    const subtypeTemplate = document.getElementById('subtypeTemplate');
                    const newSubtype = subtypeTemplate.content.cloneNode(true);
                    subtypesContainer.appendChild(newSubtype);
                    initializeSubtypeHandlers(subtypesContainer.lastElementChild);
                });
            }
        }

        // Initialize subtype handlers
        function initializeSubtypeHandlers(subtypeGroup) {
            const removeSubtypeBtn = subtypeGroup.querySelector('.remove-subtype-btn');
            if (removeSubtypeBtn) {
                removeSubtypeBtn.addEventListener('click', () => subtypeGroup.remove());
            }
        }

        // Initialize subtype2 handlers
        function initializeSubtype2Handlers(subtype2Group) {
            // Remove subtype2 button
            const removeSubtype2Btn = subtype2Group.querySelector('.remove-subtype2-btn');
            if (removeSubtype2Btn) {
                removeSubtype2Btn.addEventListener('click', () => subtype2Group.remove());
            }

            // Add subtype3 button
            const addSubtype3Btn = subtype2Group.querySelector('.add-subtype3-btn');
            const subtype3Container = subtype2Group.querySelector('.subtype3-container');

            if (addSubtype3Btn && subtype3Container) {
                addSubtype3Btn.addEventListener('click', () => {
                    const subtype3Template = document.getElementById('subtype3Template');
                    const newSubtype3 = subtype3Template.content.cloneNode(true);
                    subtype3Container.appendChild(newSubtype3);

                    // Initialize remove handler for the new subtype3
                    const removeSubtype3Btn = subtype3Container.lastElementChild.querySelector('.remove-subtype3-btn');
                    if (removeSubtype3Btn) {
                        removeSubtype3Btn.addEventListener('click', (e) => {
                            e.target.closest('.subtype3-group').remove();
                        });
                    }
                });
            }
        }

        // Update the templates
        document.getElementById('subtypeTemplate').innerHTML = `
            <div class="subtype-group border-l-2 border-gray-200 pl-4">
                <div class="flex justify-between items-center mb-3">
                    <input type="text" class="form-input subtype-name w-1/3" placeholder="Enter subtype 1">
                    <div class="flex gap-2">
                        <button type="button" class="add-subtype2-btn bg-green-100 text-green-600 px-3 py-1 rounded-md text-sm">
                            Add Subtype 2
                        </button>
                        <button type="button" class="remove-subtype-btn text-red-600 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="subtype2-container ml-4 space-y-2">
                    <!-- Subtype 2 items will be added here -->
                </div>
            </div>
        `;

        document.getElementById('subtype3Template').innerHTML = `
            <div class="subtype3-group flex items-center justify-between gap-4">
                <input type="text" class="form-input subtype3-name w-1/3" placeholder="Enter subtype 3">
                <button type="button" class="remove-subtype3-btn text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        `;

        // Add these new functions to handle the actions
        function addNewProductType() {
            // Implement add new product type logic
            console.log('Adding new product type');
        }

        function editProductType(typeIndex) {
            // Implement edit product type logic
            console.log('Editing product type:', typeIndex);
        }

        function deleteProductType(typeIndex) {
            // Implement delete product type logic
            console.log('Deleting product type:', typeIndex);
        }

        function addNewSubtype(typeIndex) {
            // Implement add new subtype logic
            console.log('Adding new subtype for type:', typeIndex);
        }

        function editSubtype(typeIndex, subIndex) {
            // Implement edit subtype logic
            console.log('Editing subtype:', typeIndex, subIndex);
        }

        function deleteSubtype(typeIndex, subIndex) {
            // Implement delete subtype logic
            console.log('Deleting subtype:', typeIndex, subIndex);
        }

        function editSubtype2Value(typeIndex, subIndex, valueIndex) {
            // Implement edit subtype2 value logic
            console.log('Editing subtype2 value:', typeIndex, subIndex, valueIndex);
        }

        function deleteSubtype2Value(typeIndex, subIndex, valueIndex) {
            // Implement delete subtype2 value logic
            console.log('Deleting subtype2 value:', typeIndex, subIndex, valueIndex);
        }

        function addNewSubtype2Value(typeIndex, subIndex) {
            // Implement add new subtype2 value logic
            console.log('Adding new subtype2 value for:', typeIndex, subIndex);
        }


        // Close modal handlers
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal handlers
            function closeEditModal() {
                const modal = document.getElementById('editProductModal');
                if (modal) {
                    modal.classList.add('hidden');
                }
            }

            // Handle close button clicks (including the X icon)
            const closeButtons = document.querySelectorAll('.close-modal');
            closeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Add this to prevent event bubbling
                    closeEditModal();
                });
            });

            // Handle click outside modal
            const modal = document.getElementById('editProductModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        closeEditModal();
                    }
                });

                // Prevent modal close when clicking inside the modal content
                const modalContent = modal.querySelector('.bg-white');
                if (modalContent) {
                    modalContent.addEventListener('click', function(e) {
                        e.stopPropagation();
                    });
                }
            }

            // Handle cancel button in form
            const cancelButton = document.querySelector('#editProductForm .btn-secondary');
            if (cancelButton) {
                cancelButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    closeEditModal();
                });
            }
        });

        // Helper functions for media management
        function removeImage(index) {
            // Add image removal logic here
            console.log('Removing image at index:', index);
        }

        function removeVideo() {
            // Add video removal logic here
            console.log('Removing video');
        }

        // Make sure the add type button in edit modal works
        document.querySelector('#editProductModal .add-type-btn').addEventListener('click', () => {
            const typeTemplate = document.getElementById('typeTemplate');
            const newType = typeTemplate.content.cloneNode(true);
            const typesContainer = document.querySelector('#editProductModal .types-container');
            typesContainer.appendChild(newType);

            // Initialize handlers for the new type
            initializeTypeHandlers(typesContainer.lastElementChild);
        });

        function initializeImageHandlers(imageBox) {
            const input = imageBox.querySelector('.image-input');
            const preview = imageBox.querySelector('.image-preview');
            const uploadContent = imageBox.querySelector('.upload-content');
            const removeBtn = imageBox.querySelector('.remove-image-btn');

            imageBox.addEventListener('click', (e) => {
                if (!e.target.closest('.remove-image-btn')) {
                    input.click();
                }
            });

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    openCropModal(this, preview);
                }
            });

            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                input.value = '';
                preview.style.backgroundImage = '';
                preview.classList.add('hidden');
                uploadContent.classList.remove('hidden');
                this.parentElement.classList.add('hidden');
            });
        }

        function initializeVideoHandlers(videoBox) {
            const removeBtn = videoBox.querySelector('.remove-video-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    clearVideo();
                });
            }
        }


        // Add this function to handle adding new videos
        function addNewVideo() {
            const videoContainer = document.getElementById('editVideoContainer');

            // Check if there's already a video box
            if (videoContainer.children.length === 0) {
                videoContainer.innerHTML = createEmptyVideoBox();
                initializeVideoHandlers(videoContainer.firstElementChild);
            }
        }

        // Initialize video upload functionality
        document.addEventListener('DOMContentLoaded', function() {
            const videoContainer = document.getElementById('editVideoContainer');

            // Create initial empty video box if container is empty
            if (videoContainer && videoContainer.children.length === 0) {
                videoContainer.innerHTML = createEmptyVideoBox();
                initializeVideoHandlers(videoContainer.firstElementChild);
            }
        });

        function initializeVideoHandlers(videoBox) {
            const removeBtn = videoBox.querySelector('.remove-video-btn');
            if (removeBtn) {
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    clearVideo();
                });
            }
        }

        // Video validation function
        function validateVideoUpload(input) {
            const file = input.files[0];
            const videoContainer = input.closest('.media-upload-box');
            const preview = videoContainer.querySelector('.video-preview');
            const uploadContent = videoContainer.querySelector('.upload-content');
            const removeBtn = videoContainer.querySelector('.remove-video-btn');

            // Clear previous error messages
            const existingError = videoContainer.querySelector('.error-message');
            if (existingError) existingError.remove();

            if (file) {
                // Validate file type
                if (file.type !== 'video/mp4') {
                    showErrorMessage(videoContainer, 'Please select an MP4 video file only');
                    input.value = '';
                    return;
                }

                // Valid file, show preview
                const fileURL = URL.createObjectURL(file);
                const video = preview.querySelector('video') || document.createElement('video');
                video.src = fileURL;
                video.className = 'w-full h-40 sm:h-48 lg:h-56 rounded-lg object-cover';
                video.controls = true;

                if (!preview.contains(video)) {
                    preview.appendChild(video);
                }

                preview.classList.remove('hidden');
                uploadContent.classList.add('hidden');
                removeBtn.parentElement.classList.remove('hidden');
            }
        }

        // Helper function to show error messages
        function showErrorMessage(container, message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-500 text-sm mt-2';
            errorDiv.textContent = message;
            container.appendChild(errorDiv);
        }

        // Initialize responsive handlers
        function initializeResponsiveHandlers() {
            // Adjust layout based on screen size
            const updateLayout = () => {
                const isMobile = window.innerWidth < 640; // sm breakpoint
                const typeGroups = document.querySelectorAll('.type-group');

                typeGroups.forEach(group => {
                    const controls = group.querySelector('.flex.justify-between');
                    if (isMobile) {
                        controls.classList.remove('items-center');
                        controls.classList.add('flex-col', 'items-start', 'gap-2');
                    } else {
                        controls.classList.add('items-center');
                        controls.classList.remove('flex-col', 'items-start', 'gap-2');
                    }
                });
            };

            // Call on load and window resize
            updateLayout();
            window.addEventListener('resize', updateLayout);
        }

        // Call this when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeResponsiveHandlers();
        });

        // Update type template for responsive design
        document.getElementById('typeTemplate').innerHTML = `
            <div class="type-group border rounded-lg p-4 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full sm:w-2/3">
                        <div class="w-full sm:w-1/3">
                            <input type="text" 
                                   class="form-input w-full type-name" 
                                   placeholder="Enter type (e.g., Toe, Leather, Sole)">
                        </div>
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <label class="text-sm text-gray-600">Price:</label>
                            <input type="number" 
                                   class="form-input w-32 type-price" 
                                   placeholder="0" 
                                   min="0">
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="add-subtype-btn bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm w-full sm:w-auto">
                            Add Subtype
                        </button>
                        <button type="button" class="remove-type-btn text-red-600 hover:text-red-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="subtypes-container ml-4 space-y-3 mt-4">
                    <!-- Subtypes will be added here -->
                </div>
            </div>
        `;



        // Function to create a new box element
        function createBoxElement() {
            return `
            <div class="type-box border-2 rounded-lg p-6 bg-gray-50 hover:border-indigo-200 transition-colors">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4 w-2/3">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Box Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₹</span>
                                </div>
                                <input type="number" 
                                       class="form-input pl-8 w-full box-price" 
                                       placeholder="Enter price" 
                                       min="0">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="add-type-btn text-sm bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200 transition-colors">
                            Add Type
                        </button>
                        <button type="button" class="remove-box-btn text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="types-container space-y-3">
                    <!-- Types will be added here -->
                </div>
            </div>
        `;
        }

        // Function to create a new type row element
        function createTypeRowElement() {
            return `
            <div class="type-row grid grid-cols-12 gap-4 items-start bg-white p-4 rounded-lg border border-gray-100">
                <div class="col-span-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" class="form-input w-full type-name" placeholder="e.g., Toe, Leather">
                </div>
                <div class="col-span-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                    <div class="flex items-center gap-2">
                        <input type="text" class="form-input w-full subtype-value" placeholder="e.g., Soft, Pure">
                    </div>
                </div>
                <div class="col-span-1 pt-7">
                    <button type="button" class="remove-type-btn text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded-md transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        }

        // Function to toggle base price section in edit mode
        function toggleEditBasePriceSection(hasBoxes) {
            if (hasBoxes) {
                editBasePriceSection.classList.add('opacity-50', 'pointer-events-none');
                editBasePrice.value = '';
                editBasePrice.disabled = true;
            } else {
                editBasePriceSection.classList.remove('opacity-50', 'pointer-events-none');
                editBasePrice.disabled = false;
            }
        }

        // Function to check boxes in edit mode
        function checkEditBoxes() {
            const hasBoxes = editBoxesContainer.children.length > 0;
            toggleEditBasePriceSection(hasBoxes);
        }

        // Add new box in edit mode
        editAddBoxBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Clear base price when adding boxes
            editBasePrice.value = '';
            editBasePrice.disabled = true;
            editBasePriceSection.classList.add('opacity-50', 'pointer-events-none');

            // Create new box
            const boxHTML = `
            <div class="type-box border-2 rounded-lg p-6 bg-gray-50 hover:border-indigo-200 transition-colors mb-4">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4 w-2/3">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Box Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">₹</span>
                                </div>
                                <input type="number" 
                                       class="form-input pl-8 w-full box-price" 
                                       placeholder="Enter price" 
                                       min="0">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="add-type-btn text-sm bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200 transition-colors">
                            Add Type
                        </button>
                        <button type="button" class="remove-box-btn text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="types-container space-y-3">
                    <!-- Types will be added here -->
                </div>
            </div>
        `;

            // Add the new box to the container
            editBoxesContainer.insertAdjacentHTML('beforeend', boxHTML);

            // Get the newly added box
            const newBox = editBoxesContainer.lastElementChild;

            // Initialize the new box's functionality
            initializeEditBox(newBox);
        });

        // Make sure this code is inside DOMContentLoaded event
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize existing boxes if any
            const existingBoxes = editBoxesContainer.querySelectorAll('.type-box');
            existingBoxes.forEach(box => initializeEditBox(box));
        });

        // Base price input handler in edit mode
        editBasePrice.addEventListener('input', (e) => {
            const hasValue = e.target.value !== '';

            if (hasValue) {
                // Clear boxes when base price is entered
                editBoxesContainer.innerHTML = '';
                editAddBoxBtn.disabled = true;
                editAddBoxBtn.classList.add('opacity-50');
            } else {
                // Enable Add Box button when base price is empty
                editAddBoxBtn.disabled = false;
                editAddBoxBtn.classList.remove('opacity-50');
            }
            checkEditBoxes();
        });

        // Initialize box functionality in edit mode
        function initializeEditBox(box) {
            const addTypeBtn = box.querySelector('.add-type-btn');
            const removeBoxBtn = box.querySelector('.remove-box-btn');
            const typesContainer = box.querySelector('.types-container');
            const priceInput = box.querySelector('.box-price');

            // Add type
            addTypeBtn.addEventListener('click', () => {
                const typeHTML = createTypeRowElement();
                const tempContainer = document.createElement('div');
                tempContainer.innerHTML = typeHTML;
                const newType = tempContainer.firstElementChild;
                typesContainer.appendChild(newType);
                initializeEditTypeRow(newType);
            });

            // Remove box
            removeBoxBtn.addEventListener('click', () => {
                box.remove();
                checkEditBoxes();
            });

            // Validate price
            priceInput.addEventListener('input', (e) => {
                if (e.target.value < 0) {
                    e.target.value = 0;
                }
            });
        }

        // Initialize type row functionality in edit mode
        function initializeEditTypeRow(typeRow) {
            const removeTypeBtn = typeRow.querySelector('.remove-type-btn');
            removeTypeBtn.addEventListener('click', () => {
                typeRow.remove();
            });
        }

        // Update the editProduct function to handle base price and product types
        // window.editProduct = function(productId) {
        //     const modal = document.getElementById('editProductModal');
        //     modal.classList.remove('hidden');

        //     fetch('/data/products.json')
        //         .then(response => response.json())
        //         .then(data => {
        //             const product = data.products.find(p => p.id === productId);
        //             if (!product) return;

        //             // Handle base price
        //             if (product.basePrice) {
        //                 editBasePrice.value = product.basePrice;
        //                 editBoxesContainer.innerHTML = ''; // Clear boxes if base price exists
        //             } else {
        //                 editBasePrice.value = '';
        //             }

        //             // Handle product types (boxes)
        //             editBoxesContainer.innerHTML = ''; // Clear existing boxes
        //             if (product.boxes && product.boxes.length > 0) {
        //                 product.boxes.forEach(box => {
        //                     const boxHTML = createBoxElement();
        //                     const tempContainer = document.createElement('div');
        //                     tempContainer.innerHTML = boxHTML;
        //                     const newBox = tempContainer.firstElementChild;
        //                     editBoxesContainer.appendChild(newBox);

        //                     const priceInput = newBox.querySelector('.box-price');
        //                     priceInput.value = box.price;

        //                     // Add types for this box
        //                     const typesContainer = newBox.querySelector('.types-container');
        //                     box.types.forEach(type => {
        //                         const typeHTML = createTypeRowElement();
        //                         const tempTypeContainer = document.createElement('div');
        //                         tempTypeContainer.innerHTML = typeHTML;
        //                         const newType = tempTypeContainer.firstElementChild;

        //                         const typeNameInput = newType.querySelector('.type-name');
        //                         const typeValueInput = newType.querySelector('.subtype-value');

        //                         typeNameInput.value = type.name;
        //                         typeValueInput.value = type.value;

        //                         typesContainer.appendChild(newType);
        //                         initializeEditTypeRow(newType);
        //                     });

        //                     initializeEditBox(newBox);
        //                 });
        //             }

        //             checkEditBoxes();
        //         })
        //         .catch(error => {
        //             console.error('Error fetching product:', error);
        //         });
        // };

        // Add this JavaScript function
        function clearImageUpload(button) {
            const box = button.closest('.media-upload-box');
            const input = box.querySelector('.image-input');
            const preview = box.querySelector('[class^="image-preview-"]');
            const uploadContent = box.querySelector('.upload-content');

            // Clear the file input
            input.value = '';

            // Reset the preview
            preview.style.backgroundImage = '';
            preview.classList.add('hidden');

            // Show the upload content
            uploadContent.classList.remove('hidden');

            // Hide the remove button
            button.style.display = 'none';

            // Prevent the click from triggering the file input
            event.stopPropagation();
        }

        // Update the image input change handler
        document.querySelectorAll('.image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const box = this.closest('.media-upload-box');
                    const preview = box.querySelector('.image-preview');
                    const uploadContent = box.querySelector('.upload-content');
                    const removeBtn = box.querySelector('.remove-image-btn');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.style.backgroundImage = `url(${e.target.result})`;
                        preview.classList.remove('hidden');
                        uploadContent.classList.add('hidden');
                        removeBtn.parentElement.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        // // Add this to initialize video handlers
        // const editVideoDropzone = document.getElementById('editVideoDropzone');
        // const editVideoInput = document.getElementById('edit-video-upload');
        // const editVideoPreview = document.getElementById('editVideoPreview');
        // const editUploadContent = editVideoDropzone.querySelector('.upload-content');
        // const editPreviewContainer = editVideoDropzone.querySelector('.video-preview-container');
        // const editRemoveButton = editVideoDropzone.querySelector('.video-preview-container .remove-video');

        // // Handle click on upload area
        // editUploadContent.addEventListener('click', (e) => {
        //     e.stopPropagation();
        //     editVideoInput.click();
        // });

        // editVideoDropzone.addEventListener('dragover', e => {
        //     e.preventDefault();
        //     editVideoDropzone.classList.add('border-indigo-600');
        // });

        // editVideoDropzone.addEventListener('dragleave', e => {
        //     e.preventDefault();
        //     editVideoDropzone.classList.remove('border-indigo-600');
        // });

        // editVideoDropzone.addEventListener('drop', e => {
        //     e.preventDefault();
        //     editVideoDropzone.classList.remove('border-indigo-600');
        //     var file = e.dataTransfer.files[0];
        //     validateAndDisplayEditVideo(file);
        // });

        // editRemoveButton.addEventListener('click', (e) => {
        //     console.log('Click hudaixa');
        //     e.stopPropagation();
        //     clearEditVideo();
        // });

        // editVideoInput.addEventListener('change', e => {
        //     e.stopPropagation();
        //     var file = e.target.files[0];
        //     if (file) {
        //         validateAndDisplayEditVideo(file);
        //     }
        // });

        // function validateAndDisplayEditVideo(file) {
        //     // Clear previous error messages
        //     const existingError = editVideoDropzone.querySelector('.error-message');
        //     if (existingError) existingError.remove();

        //     if (file) {
        //         // Validate file type
        //         if (file.type !== 'video/mp4') {
        //             showEditErrorMessage('Please select an MP4 video file only');
        //             editVideoInput.value = '';
        //             return;
        //         }

        //         // Validate file size (50MB)
        //         if (file.size > 50 * 1024 * 1024) {
        //             showEditErrorMessage('Video size should not exceed 50MB');
        //             editVideoInput.value = '';
        //             return;
        //         }

        //         // Valid file, show preview
        //         const fileURL = URL.createObjectURL(file);
        //         editVideoPreview.src = fileURL;
        //         editUploadContent.classList.add('hidden');
        //         editPreviewContainer.classList.remove('hidden');
        //     }
        // }

        // function clearEditVideo() {
        //     editVideoInput.value = '';
        //     editVideoPreview.src = 'Clicked';
        //     editPreviewContainer.classList.add('hidden');
        //     editUploadContent.classList.remove('hidden');

        //     // Revoke object URL to free up memory
        //     if (editVideoPreview.src) {
        //         URL.revokeObjectURL(editVideoPreview.src);
        //     }
        // }

        function showEditErrorMessage(message) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-500 text-sm mt-2 text-center';
            errorDiv.textContent = message;
            editVideoDropzone.appendChild(errorDiv);
        }

        // Add this function to handle adding new boxes
        function addNewBox() {
            // Clear base price when adding boxes
            const editBasePrice = document.getElementById('editBasePrice');
            const editBasePriceSection = document.getElementById('editBasePriceSection');
            const editBoxesContainer = document.getElementById('editBoxesContainer');

            editBasePrice.value = '';
            editBasePrice.disabled = true;
            editBasePriceSection.classList.add('opacity-50', 'pointer-events-none');

            // Create new box
            const boxHTML = `
            <div class="type-box border-2 rounded-lg p-6 bg-gray-50 hover:border-indigo-200 transition-colors mb-4">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-4 w-2/3">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Box Price</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rs. </span>
                                </div>
                                <input type="number" 
                                       class="form-input pl-8 w-full box-price" 
                                       placeholder="Enter price" 
                                       min="0">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" class="add-type-btn text-sm bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200 transition-colors">
                            Add Type
                        </button>
                        <button type="button" class="remove-box-btn text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-md transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="types-container space-y-3">
                    <!-- Types will be added here -->
                </div>
            </div>
        `;

            // Add the new box to the container
            editBoxesContainer.insertAdjacentHTML('beforeend', boxHTML);

            // Get the newly added box
            const newBox = editBoxesContainer.lastElementChild;

            // Initialize the new box's functionality
            initializeEditBox(newBox);
        }

        // Add this to your script section
        // document.addEventListener('DOMContentLoaded', function() {
        //     const editProductForm = document.getElementById('editProductForm');
        //     const editProductModal = document.getElementById('editProductModal');

        //     // Handle form submission
        //     editProductForm.addEventListener('submit', function(e) {
        //         e.preventDefault(); // Prevent default form submission

        //         // Close the modal
        //         editProductModal.classList.add('hidden');

        //         // Optional: Reset the form
        //         editProductForm.reset();

        //         // Optional: Clear any dynamic content (boxes, etc.)
        //         const editBoxesContainer = document.getElementById('editBoxesContainer');
        //         if (editBoxesContainer) {
        //             editBoxesContainer.innerHTML = '';
        //         }
        //     });

        //     // Handle modal close button
        //     const closeButtons = document.querySelectorAll('.close-modal');
        //     closeButtons.forEach(button => {
        //         button.addEventListener('click', function() {
        //             editProductModal.classList.add('hidden');
        //             editProductForm.reset();
        //             if (editBoxesContainer) {
        //                 editBoxesContainer.innerHTML = '';
        //             }
        //         });
        //     });
        // });

        async function saveEditedProduct(e) {
            e.preventDefault();
            const submitButton = document.querySelector('#editProductForm button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            try {
                // Show loading state
                submitButton.innerHTML = `
            <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Saving...
        `;
                submitButton.disabled = true;
                
                // Gather form data
                const editFormData = new FormData();
                editFormData.append("article_id", document.getElementById('editProductId').value);
                editFormData.append("shoe_name", document.getElementById('editArticleName').value);
                editFormData.append("shoe_color", document.getElementById('editProductColor').value);
                editFormData.append("shoe_description", document.getElementById('editDescription').value);
                editFormData.append("category_name", document.getElementById('editCategory').value);

                // Add box data
                const boxes = [];
                document.querySelectorAll('.type-box').forEach((box) => {
                    const boxPrice = box.querySelector('.box-price').value;
                    const types = [];

                    box.querySelectorAll('.type-row').forEach((typeRow) => {
                        types.push({
                            name: typeRow.querySelector('.type-name').value,
                            value: typeRow.querySelector('.subtype-value').value
                        });
                    });

                    if (types.length > 0) {
                        boxes.push({
                            price: boxPrice,
                            types: types
                        });
                    } else {
                        boxes.push({
                            grouping: null,
                            price: boxPrice
                        });
                    }
                });
                editFormData.append('price_combinations', JSON.stringify(boxes));

                // Handle images
                for (let i = 1; i <= 6; i++) {
                    const imageInput = document.querySelector(`[name="shoe_image${i}"]`);
                    if (imageInput && imageInput.files.length > 0) {
                        editFormData.append(`shoe_image${i}`, imageInput.files[0]);
                    }
                }

                // Handle video
                const videoInput = document.querySelector('[name="shoe_video"]');
                if (videoInput && videoInput.files.length > 0) {
                    editFormData.append('shoe_video', videoInput.files[0]);
                }

                const productId = document.getElementById('editProductId').value;
                // Log all FormData key-value pairs
                for (let pair of editFormData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                for (let i = 1; i <= 6; i++) {
                    const imageInput = document.querySelector(`[name="shoe_image${i}"]`);
                    if (imageInput && imageInput.files.length > 0) {
                        console.log(`Appending shoe_image${i}:`, imageInput.files[0]);
                        editFormData.append(`shoe_image${i}`, imageInput.files[0]);
                    }
                }

                const response = await fetch(`/api/shoes/${productId}`, {
                    method: 'PUT',
                    body: editFormData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                if (data.success) {
                    await Swal.fire({
                        title: 'Success!',
                        text: data.success,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });

                    // Close modal and reset form
                    editProductModal.classList.add('hidden');
                    editProductForm.reset();

                    // Clear boxes
                    const editBoxesContainer = document.getElementById('editBoxesContainer');
                    if (editBoxesContainer) {
                        editBoxesContainer.innerHTML = '';
                    }

                    // Optionally reload products
                    // location.reload();
                } else {
                    throw new Error(data.error || 'Error updating product');
                }

            } catch (error) {
                console.error('Fetch error:', error);
                await Swal.fire({
                    title: 'Error!',
                    text: error.message || 'Something went wrong',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            } finally {
                // Reset submit button
                submitButton.innerHTML = originalButtonText;
                submitButton.disabled = false;
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            const editProductForm = document.getElementById('editProductForm');
            const editProductModal = document.getElementById('editProductModal');

            // Handle form submission with AJAX
            // editProductForm.addEventListener('submit', function(e) {
            //     e.preventDefault();

            //     // Show loading state on submit button
            //     const submitButton = this.querySelector('button[type="submit"]');
            //     const originalButtonText = submitButton.innerHTML;
            //     submitButton.innerHTML = `
            //         <svg class="animate-spin h-5 w-5 text-white inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            //             <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            //             <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            //         </svg>
            //         Saving...
            //     `;
            //     submitButton.disabled = true;

            //     // Gather form data
            //     const editFormData = new FormData();
            //     editFormData.append("article_id", document.getElementById('editProductId').value);
            //     editFormData.append("shoe_name", document.getElementById('editArticleName').value);
            //     editFormData.append("shoe_color", document.getElementById('editProductColor').value);
            //     editFormData.append("shoe_description", document.getElementById('editDescription').value);
            //     editFormData.append("category_name", document.getElementById('editCategory').value);

            //     // Add box data to editFormData
            //     const boxes = [];
            //     document.querySelectorAll('.type-box').forEach((box, boxIndex) => {
            //         const boxPrice = box.querySelector('.box-price').value;
            //         const types = [];

            //         box.querySelectorAll('.type-row').forEach((typeRow, typeIndex) => {
            //             types.push({
            //                 name: typeRow.querySelector('.type-name').value,
            //                 value: typeRow.querySelector('.subtype-value').value
            //             });
            //         });
            //         if (box.length > 0) {
            //             boxes.push({
            //                 price: boxPrice,
            //                 types: types
            //             });
            //         } else {
            //             boxes.push({
            //                 grouping: null,
            //                 price: boxPrice
            //             });
            //         }
            //     });

            //     editFormData.append('price_combinations', JSON.stringify(boxes));

            //     // For images and videos
            //     for (let i = 1; i <= 6; i++) {
            //         const imageInput = document.querySelector(`[name="shoe_image${i}"]`);
            //         if (imageInput && imageInput.files.length > 0) {
            //             editFormData.append(`shoe_image${i}`, imageInput.files[0]);
            //         }
            //     }

            //     const videoInput = document.querySelector('[name="shoe_video"]');
            //     if (videoInput && videoInput.files.length > 0) {
            //         editFormData.append('shoe_video', videoInput.files[0]);
            //     }

            //     // Get the product ID
            //     const productId = document.getElementById('editProductId').value;

            //     // Make the AJAX request
            //     fetch(`/api/shoes/${productId}`, {
            //         method: 'PUT',
            //         body: editFormData,
            //         headers: {
            //             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            //             'Accept': 'application/json',
            //         }
            //     })
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.success) {
            //             // Show success message
            //             Swal.fire({
            //                 title: 'Success!',
            //                 text: 'Product updated successfully',
            //                 icon: 'success',
            //                 confirmButtonText: 'OK'
            //             }).then(() => {
            //                 // Close modal and reset form
            //                 editProductModal.classList.add('hidden');
            //                 editProductForm.reset();

            //                 // Clear boxes container
            //                 const editBoxesContainer = document.getElementById('editBoxesContainer');
            //                 if (editBoxesContainer) {
            //                     editBoxesContainer.innerHTML = '';
            //                 }

            //                 // Optionally refresh the products list/table
            //                 // location.reload(); // Or implement a more elegant refresh
            //             });
            //         } else {
            //             throw new Error(data.message || 'Error updating product');
            //         }
            //     })
            //     .catch(error => {
            //         // Show error message
            //         Swal.fire({
            //             title: 'Error!',
            //             text: error.message || 'Something went wrong',
            //             icon: 'error',
            //             confirmButtonText: 'OK'
            //         });
            //     })
            //     .finally(() => {
            //         // Reset button state
            //         submitButton.innerHTML = originalButtonText;
            //         submitButton.disabled = false;
            //     });
            // });

            // Handle modal close button
            const closeButtons = document.querySelectorAll('.close-modal');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    editProductModal.classList.add('hidden');
                    editProductForm.reset();
                    const editBoxesContainer = document.getElementById('editBoxesContainer');
                    if (editBoxesContainer) {
                        editBoxesContainer.innerHTML = '';
                    }
                });
            });
        });

        // Add this to your <head> section if not already present
        // <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <script>
        // Add delete product function
        async function deleteProduct(productId) {
            // Show confirmation dialog
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "This product will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444', // Red color
                cancelButtonColor: '#6B7280', // Gray color
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            });

            if (result.isConfirmed) {
                try {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Get CSRF token
                    const token = document.querySelector('meta[name="csrf-token"]')?.content;
                    if (!token) {
                        throw new Error('CSRF token not found');
                    }

                    // Send delete request
                    const response = await fetch(`/admin/products/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Failed to delete product');
                    }

                    // Show success message
                    await Swal.fire({
                        title: 'Deleted!',
                        text: 'Product has been deleted successfully.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Reload the page after successful deletion
                    window.location.reload();
                } catch (error) {
                    console.error('Delete Error:', error);
                    // Show error message
                    await Swal.fire({
                        title: 'Error!',
                        text: error.message || 'Failed to delete product. Please try again.',
                        icon: 'error',
                        confirmButtonColor: '#3B82F6'
                    });
                }
            }
        }
    </script>
    <!-- {{-- Update the delete button HTML --}}
    {{-- <button onclick="deleteProduct(${product.id})"
            class="delete-product-btn text-red-600 hover:text-red-900 transition-colors duration-150"
            title="Delete">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
        </svg>
    </button> --}} -->

    <!-- Add these templates at the end of your body tag -->
    <template id="loadingSpinner">
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </template>

    <!-- Type Template -->
    <template id="typeTemplate">
        <div class="type-group border rounded-lg p-4 bg-gray-50">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full sm:w-2/3">
                    <div class="w-full sm:w-1/3">
                        <input type="text"
                            class="form-input w-full type-name"
                            placeholder="Enter type (e.g., Toe, Leather, Sole)">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <label class="text-sm text-gray-600">Price:</label>
                        <input type="number"
                            class="form-input w-32 type-price"
                            placeholder="0"
                            min="0">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="button" class="add-subtype-btn bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm w-full sm:w-auto">
                        Add Subtype
                    </button>
                    <button type="button" class="remove-type-btn text-red-600 hover:text-red-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="subtypes-container ml-4 space-y-3 mt-4">
                <!-- Subtypes will be added here -->
            </div>
        </div>
    </template>

    <!-- Subtype Template -->
    <template id="subtypeTemplate">
        <div class="subtype-group border-l-2 border-gray-200 pl-4">
            <div class="flex items-center gap-4">
                <div class="w-1/3">
                    <input type="text"
                        class="form-input w-full subtype-name"
                        placeholder="Enter subtype value">
                </div>
                <button type="button" class="remove-subtype-btn text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </template>

    <!-- Edit Product Modal -->
    <div id="editProductModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Product (<span id="productIdSpan"></span>)</h3>
                        <button type="button" class="close-modal text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form id="editProductForm" class="space-y-6" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Shoe Name</label>
                                <input type="text"
                                    id="editArticleName"
                                    class="form-input w-full focus:ring-0 focus:border-gray-100">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select id="editCategory" class="form-input w-full">
                                    <option value="" disabled>Select a category</option>
                                    <!-- Categories will be populated here -->
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="editDescription" class="form-textarea w-full h-24"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                                <input type="text"
                                    id="editProductColor"
                                    class="form-input w-full border-2 border-gray-300 rounded-lg px-4 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-150 ease-in-out"
                                    placeholder="Enter product color">
                            </div>
                        </div>



                        <!-- Media Section -->
                        <div class="space-y-6">
                            <!-- Images Section -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">Product Images</label>


                                </div>
                                <div class="grid grid-cols-3 auto-rows-fr gap-4 w-full" id="editImagesContainer">
                                    <!-- Images will be populated here -->
                                </div>

                            </div>

                            <!-- Video Section -->
                            <div id="editVideoDropzone" class="relative border-2 border-gray-300 border-dashed rounded-lg p-6">
                                <input type="file"
                                    id="edit-video-upload"
                                    name="shoe_video"
                                    accept="video/mp4"
                                    class="hidden" />
                                <div class="text-center upload-content cursor-pointer">
                                    <img class="mx-auto h-12 w-12" src="https://www.svgrepo.com/show/357902/image-upload.svg" alt="">

                                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                                        <span>Drag and drop</span>
                                        <span class="text-indigo-600"> or browse</span>
                                        <span>to upload</span>
                                    </h3>
                                    <p class="mt-1 text-xs text-gray-500">
                                        MP4 format only (max 50MB)
                                    </p>
                                </div>

                                <div class="video-preview-container hidden relative">
                                    <button type="button"
                                        class="remove-video-btn absolute -top-2 -right-2 bg-red-100 rounded-full p-1 shadow-sm hover:bg-red-200 transition-colors z-[60]">
                                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                    <video src="" class="mt-4 mx-auto max-h-40 w-full" id="editVideoPreview" controls></video>
                                </div>
                            </div>





                            <!-- Base Price and Product Types Section -->
                            <div class="space-y-6">
                                <!-- Base Price -->
                                <div class="section-card" id="editBasePriceSection">
                                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Base Price</h2>
                                    <div class="form-group w-1/3">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">₹</span>
                                            </div>
                                            <input type="number"
                                                id="editBasePrice"
                                                class="form-input pl-8 w-full border-2 border-gray-200 rounded-lg px-4 py-2.5 text-sm 
                                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 
                                                  hover:border-gray-300 transition duration-150 ease-in-out"
                                                placeholder="Enter base price">
                                        </div>
                                    </div>
                                </div>

                                <!-- Product Types -->
                                <div class="section-card">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-lg font-semibold text-gray-900">Product Types</h2>
                                        <button type="button"
                                            onclick="addNewBox()"
                                            id="editAddBoxBtn"
                                            class="add-box-btn bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                                            Add Box
                                        </button>
                                    </div>
                                    <div id="editBoxesContainer" class="space-y-4">
                                        <!-- Boxes will be added here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Box Template for Edit Mode -->
                            <template id="editBoxTemplate">
                                <div class="type-box border-2 rounded-lg p-6 bg-gray-50 hover:border-indigo-200 transition-colors">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-4 w-2/3">
                                            <div class="w-1/2">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Box Price</label>
                                                <div class="relative">
                                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">₹</span>
                                                    </div>
                                                    <input type="number"
                                                        class="form-input pl-8 w-full box-price"
                                                        placeholder="Enter price"
                                                        min="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="button" class="add-type-btn text-sm bg-indigo-100 text-indigo-600 px-4 py-2 rounded-md hover:bg-indigo-200 transition-colors">
                                                Add Type
                                            </button>
                                            <button type="button" class="remove-box-btn text-red-600 hover:text-red-700 p-2 hover:bg-red-50 rounded-md transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="types-container space-y-3">
                                        <!-- Types will be added here -->
                                    </div>
                                </div>
                            </template>

                            <!-- Type Row Template for Edit Mode -->
                            <template id="editTypeRowTemplate">
                                <div class="type-row grid grid-cols-12 gap-4 items-start bg-white p-4 rounded-lg border border-gray-100">
                                    <div class="col-span-5">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                                        <input type="text" class="form-input w-full type-name" placeholder="e.g., Toe, Leather">
                                    </div>
                                    <div class="col-span-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Value</label>
                                        <div class="flex items-center gap-2">
                                            <input type="text" class="form-input w-full subtype-value" placeholder="e.g., Soft, Pure">
                                        </div>
                                    </div>
                                    <div class="col-span-1 pt-7">
                                        <button type="button" class="remove-type-btn text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded-md transition-colors">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>




                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" class="close-modal flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Cancel
                                </button>
                                <button type="submit" onclick="saveEditedProduct(event)" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to validate the form
        function validateForm(result) {
            const articleNumber = document.getElementById('addArticleNumber').value.trim();
            const productName = document.getElementById('addProductName').value.trim();
            const category = document.getElementById('categorySelect').value.trim();
            const color = document.getElementById('addProductColor').value.trim();
            const description = document.getElementById('addDescription').value.trim();
            const image1 = document.getElementById('addImage1').files.length > 0;

            if (!articleNumber || !productName || !category || !color || !description || !image1 || !result) {
                alert('Please fill all the required fields before submitting the form.');
                return false;
            }
            return true;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editVideoDropzone = document.getElementById('editVideoDropzone');
            const editVideoInput = document.getElementById('edit-video-upload');
            const editVideoPreview = document.getElementById('editVideoPreview');
            const editUploadContent = editVideoDropzone.querySelector('.upload-content');
            const editPreviewContainer = editVideoDropzone.querySelector('.video-preview-container');
            const editRemoveButton = editVideoDropzone.querySelector('.remove-video-btn');

            // Handle click on upload area
            editUploadContent.addEventListener('click', (e) => {
                e.stopPropagation();
                editVideoInput.click();
            });

            editVideoDropzone.addEventListener('dragover', e => {
                e.preventDefault();
                editVideoDropzone.classList.add('border-indigo-600');
            });

            editVideoDropzone.addEventListener('dragleave', e => {
                e.preventDefault();
                editVideoDropzone.classList.remove('border-indigo-600');
            });

            editVideoDropzone.addEventListener('drop', e => {
                e.preventDefault();
                editVideoDropzone.classList.remove('border-indigo-600');
                const file = e.dataTransfer.files[0];
                validateAndDisplayEditVideo(file);
            });

            editRemoveButton.addEventListener('click', (e) => {
                e.stopPropagation();
                clearEditVideo();
            });

            editVideoInput.addEventListener('change', e => {
                e.stopPropagation();
                const file = e.target.files[0];
                if (file) {
                    validateAndDisplayEditVideo(file);
                }
            });

            function validateAndDisplayEditVideo(file) {
                // Clear previous error messages
                const existingError = editVideoDropzone.querySelector('.error-message');
                if (existingError) existingError.remove();

                if (file) {
                    // Validate file type
                    if (file.type !== 'video/mp4') {
                        showEditErrorMessage('Please select an MP4 video file only');
                        editVideoInput.value = '';
                        return;
                    }

                    // Valid file, show preview
                    const fileURL = URL.createObjectURL(file);
                    editVideoPreview.src = fileURL;
                    editUploadContent.classList.add('hidden');
                    editPreviewContainer.classList.remove('hidden');
                }
            }

            function clearEditVideo() {
                editVideoInput.value = '';
                editVideoPreview.src = '';
                editPreviewContainer.classList.add('hidden');
                editUploadContent.classList.remove('hidden');

                // Revoke object URL to free up memory
                if (editVideoPreview.src) {
                    URL.revokeObjectURL(editVideoPreview.src);
                }
            }

            function showEditErrorMessage(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message text-red-500 text-sm mt-2 text-center';
                errorDiv.textContent = message;
                editVideoDropzone.appendChild(errorDiv);
            }
        });
    </script>
    <script>
        let cropper;
        let currentImageInput;
        let currentPreviewElement;

        function openCropModal(input, previewElement) {
            currentImageInput = input;
            currentPreviewElement = previewElement;
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('cropperImage').src = e.target.result;
                    document.getElementById('cropModal').classList.remove('hidden');

                    // Initialize cropper
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(document.getElementById('cropperImage'), {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 1,
                        responsive: true,
                        restore: false,
                        modal: true,
                        guides: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
                reader.readAsDataURL(file);
            }
        }

        function closeCropModal() {
            document.getElementById('cropModal').classList.add('hidden');
            if (cropper) {
                cropper.destroy();
            }
        }

        function applyCrop() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 800
                });

                // Get the original file type from the input
                const originalFile = currentImageInput.files[0];
                const originalType = originalFile.type;

                // Convert to blob with original type
                canvas.toBlob((blob) => {
                    const file = new File([blob], originalFile.name, {
                        type: originalType,
                        lastModified: Date.now()
                    });

                    // Create a new FileList
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    currentImageInput.files = dataTransfer.files;

                    // Update preview
                    const previewUrl = URL.createObjectURL(blob);
                    currentPreviewElement.style.backgroundImage = `url(${previewUrl})`;
                    currentPreviewElement.classList.remove('hidden');
                    currentPreviewElement.parentElement.querySelector('.upload-content').classList.add('hidden');
                    currentPreviewElement.parentElement.querySelector('.remove-image-btn').style.display = 'block';

                    closeCropModal();
                }, originalType);
            }
        }

        // Modify the existing image upload handling
        document.querySelectorAll('.image-input').forEach(input => {
            input.addEventListener('change', function(e) {
                const slot = this.dataset.slot;
                const previewElement = document.querySelector(`.image-preview-${slot}`);
                openCropModal(this, previewElement);
            });
        });
    </script>
</body>

</html>