<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add Cropper.js CSS and JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
</head>
<body class="bg-gray-100">
    <x-admin.header />
    
    <!-- Main Layout -->
    <div class="flex pt-16 min-h-screen overflow-x-hidden">
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 p-2 sm:p-4 lg:p-6 w-full transition-transform duration-300 ease-in-out">
            <div class="p-2 sm:p-4 lg:p-8">
                <div class="max-w-[calc(100%-2rem)] mx-auto">
                    <!-- Add/Edit Category Card -->
                    <div class="bg-white rounded-lg shadow-lg mb-4 sm:mb-8 overflow-hidden border border-gray-200">
                        <div class="flex justify-between items-center p-3 sm:p-4 lg:p-6 border-b bg-white">
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">
                                {{ isset($editCategory) ? 'Edit Category' : 'Add Category' }}
                            </h2>
                            <div class="flex space-x-3">
                                <button type="button" onclick="resetForm()" 
                                        class="px-4 py-2 lg:px-6 lg:py-2.5 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 text-sm lg:text-base font-medium shadow-sm hover:shadow transition-all">
                                    Cancel
                                </button>
                                <button type="submit" form="categoryForm"
                                        class="px-4 py-2 lg:px-6 lg:py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm lg:text-base font-medium shadow-sm hover:shadow-md transition-all">
                                    {{ isset($editCategory) ? 'Update Category' : 'Add Category' }}
                                </button>
                            </div>
                        </div>
                        
                        <form id="categoryForm" 
                              action="{{ isset($editCategory) ? route('admin.categories.update', $editCategory->id) : ''}}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="p-3 sm:p-4 lg:p-6 bg-white">
                            @csrf
                            @if(isset($editCategory))
                                @method('PUT')
                            @endif

                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6 lg:gap-8">
                                <!-- Thumbnail Section -->
                                <div class="w-full sm:w-1/3 space-y-3 sm:space-y-4">
                                    <h3 class="font-semibold text-gray-900 text-base lg:text-lg">Thumbnail</h3>
                                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-3 sm:p-4 lg:p-6 text-center hover:border-gray-400 transition-colors bg-gray-50 relative">
                                        <div class="space-y-2">
                                            <div class="mx-auto h-24 w-24 sm:h-32 sm:w-32 lg:h-40 lg:w-40 flex items-center justify-center relative">
                                                <img id="preview" 
                                                     src="{{ isset($editCategory) ? asset($editCategory->image) : '' }}" 
                                                     class="{{ isset($editCategory) && $editCategory->image ? '' : 'hidden' }} max-h-full object-cover" 
                                                     alt="Category thumbnail">
                                                <button type="button" 
                                                        id="clearImage" 
                                                        class="{{ isset($editCategory) && $editCategory->image ? '' : 'hidden' }} absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 hover:bg-red-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                                <div id="placeholder" class="{{ isset($editCategory) && $editCategory->image ? 'hidden' : '' }} text-gray-500">
                                                    <svg class="mx-auto h-8 w-8 sm:h-10 sm:w-10 lg:h-12 lg:w-12" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    <p class="text-xs sm:text-sm font-medium">Drag and drop image here<br>or click to upload</p>
                                                </div>
                                            </div>
                                            <input type="file" id="thumbnail" name="category_image" class="hidden" accept="image/*">
                                            <button type="button" onclick="document.getElementById('thumbnail').click()" 
                                                    class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm font-semibold">
                                                {{ isset($editCategory) ? 'Change Image' : 'Add Image' }}
                                            </button>
                                        </div>
                                    </div>
                                    @error('category_image')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- General Information -->
                                <div class="w-full sm:w-2/3 space-y-3 sm:space-y-4">
                                    <h3 class="font-semibold text-gray-900 text-base lg:text-lg">General Information</h3>
                                    <div class="max-w-2xl">
                                        <label for="categoryName" class="block text-sm lg:text-base font-medium text-gray-900">
                                            Category Name
                                        </label>
                                        <input type="text" 
                                               id="categoryName" 
                                               name="category_name" 
                                               value="{{ isset($editCategory) ? $editCategory->name : old('category_name') }}"
                                               class="mt-1 block w-full rounded-md border-2 border-indigo-100 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm lg:text-base text-gray-900 bg-gray-50 hover:border-indigo-300 transition-colors p-2.5 @error('category_name') border-red-300 @enderror"
                                               placeholder="Enter category name"
                                               required>
                                        @error('category_name')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="categoryFeature" 
                                               name="feature" 
                                               class="rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5"
                                               value="1">
                                        <label for="categoryFeature" class="ml-2 text-sm text-gray-700">
                                            Feature this category
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Categories List -->
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
                        <div class="p-3 sm:p-4 lg:p-6 border-b bg-white">
                            <h2 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900">Categories List</h2>
                        </div>
                        
                        <!-- Mobile view for table -->
                        <div class="block sm:hidden">
                            <div class="divide-y divide-gray-200" id="mobile-categories">
                                <!-- Mobile categories will be dynamically inserted here -->
                            </div>
                        </div>

                        <!-- Desktop view for table -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Featured</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Categories will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-admin.change-password-modal />

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-full max-w-md shadow-xl rounded-xl bg-white modal-content">
            <div class="modal-header border-b border-gray-200 -mx-6 px-6 pb-4 mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Edit Category</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <form id="editForm" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                
                <div class="form-group bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label for="editCategoryName" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                    <input type="text" 
                           name="new_categoryName" 
                           id="editCategoryName" 
                           class="mt-1 block w-full rounded-lg border-2 border-gray-200 bg-white px-4 py-3 text-gray-900 shadow-sm transition-all duration-200 hover:border-indigo-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:ring-opacity-50"
                           required>
                </div>
                
                <div class="form-group bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Image</label>
                    <div class="mt-2 relative w-32 h-32 mx-auto">
                        <img id="currentImage" 
                             class="w-full h-full object-cover rounded-lg border-2 border-gray-200 shadow-sm" 
                             src="" 
                             alt="Current category image">
                    </div>
                </div>
                
                <div class="form-group bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <label for="editThumbnail" class="block text-sm font-medium text-gray-700 mb-2">New Image (optional)</label>
                    <input type="file" 
                           name="category_image" 
                           id="editThumbnail" 
                           accept="image/*"
                           class="mt-1 block w-full text-gray-700">
                </div>
                
                <div class="form-group bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="editCategoryFeature" 
                               name="feature" 
                               class="rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5"
                               value="1">
                        <label for="editCategoryFeature" class="ml-2 text-sm text-gray-700">
                            Feature this category
                        </label>
                    </div>
                </div>
                
                <div class="modal-footer border-t border-gray-200 -mx-6 px-6 pt-4 mt-4 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="closeEditModal()"
                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors shadow-sm hover:shadow">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-sm hover:shadow-md">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Crop Modal -->
    <div id="cropModal" class="fixed inset-0 bg-gray-900/50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-6 border w-full max-w-4xl shadow-xl rounded-xl bg-white">
            <div class="modal-header border-b border-gray-200 -mx-6 px-6 pb-4 mb-4">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-gray-900">Crop Image</h3>
                    <button onclick="closeCropModal()" class="text-gray-400 hover:text-gray-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="max-h-[60vh] overflow-hidden">
                    <img id="cropperImage" class="max-w-full" src="" alt="Image to crop">
                </div>
            </div>
            <div class="modal-footer border-t border-gray-200 -mx-6 px-6 pt-4 mt-4 flex justify-end space-x-3">
                <button type="button" 
                        onclick="closeCropModal()"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors shadow-sm hover:shadow">
                    Cancel
                </button>
                <button type="button" 
                        onclick="applyCrop()"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium transition-colors shadow-sm hover:shadow-md">
                    Apply Crop
                </button>
            </div>
        </div>
    </div>

    <script>
        // Updated sidebar toggle functionality
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mainContent = document.querySelector('.flex-1');
        const overlay = document.createElement('div');
        let sidebarOpen = false;

        // Create and style overlay
        overlay.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 transition-opacity lg:hidden hidden';
        overlay.setAttribute('aria-hidden', 'true');
        document.body.appendChild(overlay);

        function updateSidebarState() {
            if (window.innerWidth >= 1024) {
                // Desktop view
                overlay.classList.add('hidden');
                sidebar.style.transform = sidebarOpen ? 'translateX(0)' : 'translateX(-100%)';
                // Remove content margin adjustments
                mainContent.classList.remove('lg:ml-64', 'lg:ml-0');
            } else {
                // Mobile view
                if (sidebarOpen) {
                    sidebar.style.transform = 'translateX(0)';
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        }

        // Initial state
        updateSidebarState();

        // Toggle sidebar
        sidebarToggle.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            updateSidebarState();
        });

        // Close sidebar when clicking overlay
        overlay.addEventListener('click', () => {
            sidebarOpen = false;
            updateSidebarState();
        });

        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebarOpen) {
                sidebarOpen = false;
                updateSidebarState();
            }
        });

        // Handle resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 1024) {
                sidebarOpen = false;
            }
            updateSidebarState();
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

        // Add thumbnail preview functionality
        const thumbnailInput = document.getElementById('thumbnail');
        const previewImg = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');
        const clearImageBtn = document.getElementById('clearImage');

        // Add these variables at the top of your script section
        let cropper;
        let currentImageInput;
        let currentPreviewElement;

        // Add these new functions for image cropping
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
                    currentPreviewElement.src = previewUrl;
                    currentPreviewElement.classList.remove('hidden');
                    document.getElementById('placeholder').classList.add('hidden');
                    document.getElementById('clearImage').classList.remove('hidden');

                    closeCropModal();
                }, originalType);
            }
        }

        // Modify the existing thumbnail input event listener
        thumbnailInput.addEventListener('change', function(event) {
            openCropModal(this, previewImg);
        });

        // Add event listener for edit thumbnail
        document.getElementById('editThumbnail').addEventListener('change', function(event) {
            openCropModal(this, document.getElementById('currentImage'));
        });

        // AJAX Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load categories on page load
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const editCategory = urlParams.get('edit');
            if (editCategory) {
                editCategory(editCategory);
            }
            loadCategories();
        });

        // Function to load all categories via AJAX
        function loadCategories() {
            $.ajax({
                url: '/admin/categories/data',
                type: 'GET',
                success: function(response) {
                    console.log('Categories loaded:', response); // Debug log
                    const tbody = document.querySelector('tbody');
                    const mobileContainer = document.getElementById('mobile-categories');
                    
                    tbody.innerHTML = '';
                    mobileContainer.innerHTML = '';
                    
                    if (response.Categories && Array.isArray(response.Categories)) {
                        response.Categories.forEach(category => {
                            addCategoryToTable(category);
                        });
                    } else {
                        console.error('Invalid response format:', response);
                    }
                },
                error: function(xhr) {
                    console.error('Error loading categories:', xhr); // Debug log
                    showNotification('Failed to load categories', 'error');
                }
            });
        }

        // Function to add category to table
        function addCategoryToTable(category) {
            // Add to desktop view
            const tbody = document.querySelector('tbody');
            const tr = document.createElement('tr');
            tr.className = 'hover:bg-gray-50 transition-colors';
            tr.setAttribute('data-category-name', category.name);
            
            tr.innerHTML = `
                <td class="px-3 sm:px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm lg:text-base font-medium text-gray-900">
                    ${category.name}
                </td>
                <td class="px-3 sm:px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                    <img src="${category.image_url}" alt="${category.name}" 
                         class="h-10 w-10 lg:h-12 lg:w-12 rounded-full object-cover ring-2 ring-gray-200 hover:ring-indigo-500 transition-all">
                </td>
                <td class="px-3 sm:px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                    <div class="flex flex-row gap-2 lg:gap-3">
                        <button onclick="editCategory('${category.name}')" 
                                class="px-3 py-1.5 lg:px-4 lg:py-2 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm lg:text-base font-medium transition-all shadow-sm hover:shadow">
                            Edit
                        </button>
                        <button onclick="deleteCategory('${category.name}')" 
                                class="px-3 py-1.5 lg:px-4 lg:py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm lg:text-base font-medium transition-all shadow-sm hover:shadow">
                            Delete
                        </button>
                    </div>
                </td>
                <td class="px-3 sm:px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                    <input type="checkbox" onchange="toggleFeature('${category.name}', this)" 
                           class="rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5 lg:h-6 lg:w-6 cursor-pointer"
                           ${category.featured ? 'checked' : ''}>
                </td>
            `;
            tbody.appendChild(tr);

            // Add mobile view
            const mobileContainer = document.getElementById('mobile-categories');
            const mobileDiv = document.createElement('div');
            mobileDiv.className = 'p-4 space-y-4 border-b border-gray-200';
            mobileDiv.setAttribute('data-category-name', category.name);
            
            mobileDiv.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="${category.image_url}" alt="${category.name}" 
                             class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-200">
                        <span class="font-medium text-gray-900 text-base">${category.name}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <label class="text-sm text-gray-600">Feature</label>
                        <input type="checkbox" onchange="toggleFeature('${category.name}', this)" 
                               class="rounded text-indigo-600 focus:ring-indigo-500 h-4 w-4"
                               ${category.featured ? 'checked' : ''}>
                    </div>
                </div>
                <div class="flex justify-end space-x-2">
                    <button onclick="editCategory('${category.name}')" 
                            class="px-3 py-1.5 bg-indigo-100 text-indigo-700 rounded-md hover:bg-indigo-200 text-sm font-medium transition-all">
                        Edit
                    </button>
                    <button onclick="deleteCategory('${category.name}')" 
                            class="px-3 py-1.5 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm font-medium transition-all">
                        Delete
                    </button>
                </div>
            `;
            mobileContainer.appendChild(mobileDiv);
        }

        // Update category function with AJAX
        function editCategory(categoryName) {
            $.ajax({
                url: `/admin/categories/data`,
                type: 'GET',
                success: function(response) {
                    const category = response.Categories.find(cat => cat.name === categoryName);
                    if (category) {
                        $('#editCategoryName').val(category.name);
                        $('#currentImage').attr('src', category.image_url);
                        $('#editCategoryFeature').prop('checked', category.featured);
                        $('#editForm').data('originalName', category.name);
                        $('#editModal').removeClass('hidden');
                    } else {
                        showNotification('Category not found', 'error');
                    }
                },
                error: function(xhr) {
                    console.error('Error loading category:', xhr);
                    showNotification('Failed to load category details', 'error');
                }
            });
        }

        function closeEditModal() {
            $('#editModal').addClass('hidden');
            $('#editForm')[0].reset();
        }

        // Update form submission for adding new category
        $('#categoryForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData();
            
            // Get form values
            const categoryName = $('#categoryName').val();
            const categoryImage = $('#thumbnail')[0].files[0];
            // Set feature to 0 if unchecked, 1 if checked
            const feature = $('#categoryFeature').is(':checked') ? 1 : 0;
            
            console.log('Form submission values:', {
                categoryName,
                hasImage: !!categoryImage,
                feature
            });
            
            if (!categoryName) {
                showNotification('Category name is required', 'error');
                return;
            }
            
            if (!categoryImage) {
                showNotification('Category image is required', 'error');
                return;
            }
            
            // Build form data with explicit feature value
            formData.append('category_name', categoryName);
            formData.append('category_image', categoryImage);
            formData.append('feature', feature); // Always send 0 or 1
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            
            $.ajax({
                url: '/admin/categories',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Category added:', response);
                    showNotification('Category added successfully!', 'success');
                    resetForm();
                    loadCategories();
                },
                error: function(xhr) {
                    console.error('Add category error:', xhr);
                    const errorMessage = xhr.responseJSON?.error || 'Unknown error';
                    console.error('Error details:', errorMessage);
                    showNotification('Failed to add category: ' + errorMessage, 'error');
                }
            });
        });

        // Update edit form submission to also handle feature properly
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = new FormData();
            const originalName = form.data('originalName');
            
            // Get form values
            const newCategoryName = $('#editCategoryName').val();
            const newCategoryImage = $('#editThumbnail')[0].files[0];
            const feature = $('#editCategoryFeature').is(':checked') ? 1 : 0;
            
            // Build form data
            formData.append('_method', 'PUT');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            formData.append('new_categoryName', newCategoryName);
            formData.append('feature', feature); // Always send 0 or 1
            if (newCategoryImage) {
                formData.append('category_image', newCategoryImage);
            }
            
            $.ajax({
                url: `/admin/categories/${originalName}`,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Update success:', response);
                    showNotification('Category updated successfully!', 'success');
                    closeEditModal();
                    loadCategories();
                },
                error: function(xhr) {
                    console.error('Update error:', xhr);
                    showNotification('Failed to update category: ' + (xhr.responseJSON?.error || 'Unknown error'), 'error');
                }
            });
        });

        // Delete category function with AJAX
        function deleteCategory(categoryName) {
            if (!confirm('Are you sure you want to delete this category?')) return;

            $.ajax({
                url: `/admin/categories/${categoryName}`,
                type: 'DELETE',
                success: function(response) {
                    showNotification('Category deleted successfully!', 'success');
                    loadCategories();
                },
                error: function(xhr) {
                    showNotification('Failed to delete category', 'error');
                }
            });
        }

        // Update toggleFeature function to ensure proper value
        function toggleFeature(categoryName, checkbox) {
            const featureValue = checkbox.checked ? 1 : 0; // Explicitly set to 1 or 0
            
            $.ajax({
                url: `/admin/categories/${categoryName}`,
                type: 'POST',
                data: {
                    _method: 'PUT',
                    feature: featureValue,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log('Feature update success:', response);
                    showNotification('Feature status updated!', 'success');
                },
                error: function(xhr) {
                    console.error('Feature update error:', xhr);
                    checkbox.checked = !checkbox.checked; // Revert checkbox state
                    showNotification('Failed to update feature status', 'error');
                }
            });
        }

        // Helper function to show notifications
        function showNotification(message, type = 'success') {
            const notification = $(`
                <div class="fixed bottom-4 left-4 right-4 sm:bottom-8 sm:right-8 sm:left-auto sm:w-96 px-4 py-3 rounded-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } shadow-lg transform transition-all duration-300 translate-y-full z-50">
                    <div class="flex items-center justify-between">
                        <span class="flex-1">${message}</span>
                        <button class="ml-4 hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
            `).appendTo('body');

            // Slide in
            setTimeout(() => notification.removeClass('translate-y-full'), 100);

            // Auto dismiss after 5 seconds
            setTimeout(() => {
                notification.addClass('translate-y-full');
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Reset form helper - updated to reset titles
        function resetForm() {
            const form = $('#categoryForm');
            form[0].reset();
            
            // Reset image preview
            $('#preview').addClass('hidden').attr('src', '');
            $('#placeholder').removeClass('hidden');
            $('#clearImage').addClass('hidden');
            
            // Remove error states
            form.find('.border-red-300').removeClass('border-red-300');
            form.find('.text-red-500').remove();
            
            // Reset form action and method
            form.attr('action', '');
            form.find('input[name="_method"]').remove();
            
            // Reset form title and button text
            $('.text-lg.sm\\:text-xl.lg\\:text-2xl.font-bold').text('Add Category');
            $('button[type="submit"]').text('Add Category');
            
            // Clear URL parameter
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete('edit');
            window.history.pushState({}, '', currentUrl);
        }

        // Clear image button functionality
        $('#clearImage').on('click', function() {
            $('#thumbnail').val('');
            $('#preview').addClass('hidden').attr('src', '');
            $('#placeholder').removeClass('hidden');
            $(this).addClass('hidden');
        });

        // Add drag and drop support for image upload
        const dropZone = document.querySelector('.border-dashed');
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            
            const file = e.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const input = document.getElementById('thumbnail');
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });

        // Add escape key handler for modal
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !$('#editModal').hasClass('hidden')) {
                closeEditModal();
            }
        });

        // Close modal when clicking outside
        $('#editModal').on('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Preview new image before upload
        $('#editThumbnail').on('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#currentImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>

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
        
        /* Keep existing styles */
        .transition-colors {
            transition: all 0.2s ease-in-out;
        }
        
        @media (min-width: 1024px) {
            .main-container {
                padding-left: calc(2rem + 16px);
                max-width: calc(100% - 4rem);
            }
        }
        
        @media (min-width: 1536px) {
            .table-container {
                max-width: 1400px;
                margin: 0 auto;
            }
        }
        
        .shadow-lg {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        .notification-enter {
            transform: translateX(100%);
        }
        .notification-enter-active {
            transform: translateX(0);
            transition: transform 300ms ease-out;
        }
        .notification-exit {
            transform: translateX(0);
        }
        .notification-exit-active {
            transform: translateX(100%);
            transition: transform 300ms ease-out;
        }

        /* Edit Modal Styles */
        #editModal {
            backdrop-filter: blur(4px);
        }

        #editModal .modal-content {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-10%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Modal form styles */
        #editForm input[type="text"] {
            @apply w-full rounded-lg border-2 border-gray-200 shadow-sm transition-colors duration-200;
            @apply focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50;
            @apply px-4 py-3 text-gray-900;
            @apply hover:border-indigo-300;
            @apply bg-gray-50;
            @apply text-base;
        }

        #editForm input[type="file"] {
            @apply file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0;
            @apply file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700;
            @apply hover:file:bg-indigo-100 cursor-pointer;
        }

        #editForm label {
            @apply block text-sm font-medium text-gray-700 mb-1;
        }

        #editForm .form-group {
            @apply mb-4;
        }

        /* Modal header and footer styles */
        #editModal .modal-header {
            @apply border-b border-gray-200 pb-4 mb-4;
        }

        #editModal .modal-footer {
            @apply border-t border-gray-200 pt-4 mt-4;
        }

        /* Add Cropper Modal Styles */
        #cropModal {
            backdrop-filter: blur(4px);
        }

        #cropModal .modal-content {
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-10%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Ensure the cropper image container has a max height */
        #cropModal .modal-body {
            max-height: 70vh;
            overflow: hidden;
        }

        #cropperImage {
            max-width: 100%;
            max-height: 60vh;
        }
    </style>
</body>
</html> 