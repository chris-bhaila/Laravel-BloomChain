<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <x-admin.header />
    
    <!-- Main Layout -->
    <div class="flex pt-16">
        <x-admin.sidebar />

        <!-- Main Content -->
        <div class="flex-1 -ml-64">
            <!-- Page Content -->
            <div class="p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h1 class="text-2xl font-semibold mb-4">Product Management</h1>
                    <!-- Add your products content here -->
                </div>
            </div>
        </div>
    </div>

    <x-admin.change-password-modal />

    <script>
        // Same JavaScript as dashboard
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mainContent = document.querySelector('.flex-1');
        let sidebarOpen = false;

        sidebarToggle.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            if (sidebarOpen) {
                sidebar.style.transform = 'translateX(0)';
                mainContent.classList.remove('-ml-64');
                mainContent.classList.add('ml-64');
            } else {
                sidebar.style.transform = 'translateX(-100%)';
                mainContent.classList.remove('ml-64');
                mainContent.classList.add('-ml-64');
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
    </script>
</body>
</html>
