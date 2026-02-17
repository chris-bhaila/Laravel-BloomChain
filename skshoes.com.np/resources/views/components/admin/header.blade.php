<nav class="bg-white border-b border-gray-200 fixed w-full z-50">
    <div class="flex flex-wrap items-center justify-between p-2">
        <!-- Left Section: Logo and Toggle -->
        <div class="flex items-center">
            <button id="sidebarToggle" class="p-1.5 hover:bg-gray-100 rounded-lg mr-3 text-gray-500 lg:block">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <a href={{ route('admin.dashboard') }} class="flex items-center space-x-2">
                <img src="{{ asset('assets/images/logo.png') }}" class="h-8" alt="SK SHOES Logo" />
                <span class="self-center text-lg md:text-xl font-semibold whitespace-nowrap text-gray-800 hidden sm:block">SK SHOES</span>
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button type="button"
            class="inline-flex items-center p-1.5 ml-3 text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
            id="mobile-menu-button"
            aria-controls="mobile-menu"
            aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Right Section: Notifications and Profile (Hidden on mobile) -->
        <div class="hidden lg:flex items-center space-x-3">
            <!-- Notifications -->
            <div class="relative">
                <button type="button"
                    class="p-2 text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    id="notificationsBtn">
                    <span class="sr-only">View notifications</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <div class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full -top-1 -right-1" id="notification-count">0</div>
                </button>

                <!-- Notifications Dropdown -->
                <div id="notifications-dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg z-50">
                    <div class="p-4 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto notifications-list">
                        <!-- Notifications will be loaded here -->
                        <div class="p-4 text-center text-gray-500">Loading notifications...</div>
                    </div>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative">
                <button type="button"
                    class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300"
                    id="user-menu-button"
                    aria-expanded="false">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full object-cover" src="{{asset('assets/images/profile.png')}}" alt="user photo">
                </button>

                <!-- Dropdown menu -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg hidden"
                    id="user-dropdown">
                    <div class="px-4 py-3 border-b border-gray-100">
                        <span class="block text-sm text-gray-900">User: Admin</span>
                        <span class="block text-sm text-gray-500 truncate">admin@skshoes.com</span>
                    </div>
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <button id="changePasswordBtn"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Change Password
                            </button>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Hidden by default) -->
        <div class="hidden w-full lg:hidden" id="mobile-menu">
            <div class="flex flex-col space-y-4 px-4 pt-4 pb-3 border-t border-gray-200">
                <!-- Mobile Menu Links -->
                <a href="{{ route('admin.dashboard') }}" class="p-2 text-gray-700 hover:bg-gray-100 rounded-lg">Dashboard</a>

                <!-- Notifications -->
                <button type="button"
                    class="flex items-center justify-between w-full p-2 text-gray-700 hover:bg-gray-100 rounded-lg"
                    id="mobile-notificationsBtn">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        Notifications
                    </div>
                    <span class="inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full" id="mobile-notification-count">0</span>
                </button>

                <!-- Profile Section -->
                <div class="flex items-center justify-between p-2">
                    <div class="flex items-center">
                        <img class="w-8 h-8 rounded-full mr-2" src="{{ asset('assets/images/profile.png') }}" alt="user photo">
                        <div>
                            <span class="block text-sm text-gray-900">User: Admin</span>
                            <span class="block text-sm text-gray-500 truncate">admin@skshoes.com</span>
                        </div>
                    </div>
                </div>

                <button id="mobile-changePasswordBtn" class="w-full text-left p-2 text-gray-700 hover:bg-gray-100 rounded-lg">Change Password</button>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left p-2 text-gray-700 hover:bg-gray-100 rounded-lg">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div id="changePasswordModal" class="hidden fixed inset-0 bg-black/50 overflow-y-auto h-full w-full z-50 flex justify-center items-center">
        <div class="relative mx-auto p-5 w-[448px] bg-gradient-to-br from-blue-600 to-cyan-300 rounded-xl shadow-2xl">
            <div class="bg-white/95 backdrop-blur-sm p-5 rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-2xl font-semibold text-gray-600">Change Password</h3>
                    <button id="closeModal" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <hr class="mb-4">
                <form id="changePasswordForm" class="space-y-3">
                    <div class="space-y-3">
                        <div class="flex items-center border-2 py-2 px-3 rounded-md bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="newPassword" name="newPassword"
                                class="pl-2 outline-none border-none w-full"
                                placeholder="New Password"
                                required>
                        </div>
                        <div class="flex items-center border-2 py-2 px-3 rounded-md bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="confirmPassword" name="confirmPassword"
                                class="pl-2 outline-none border-none w-full"
                                placeholder="Confirm New Password"
                                required>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-4">
                        <button type="button" id="cancelPasswordChange"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 
                            rounded-md transition-all duration-200 shadow-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white shadow-xl 
                            bg-gradient-to-tr from-blue-600 to-red-400 hover:to-red-700 
                            rounded-md transition-all duration-1000">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Mobile Notifications Panel -->
    <div id="mobile-notifications-panel" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Notifications</h3>
                <button id="close-mobile-notifications" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="max-h-[60vh] overflow-y-auto notifications-list">
                <!-- Mobile notifications will be loaded here -->
                <div class="p-4 text-center text-gray-500">Loading notifications...</div>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');

        sidebarToggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');

            // Dispatch custom event for content adjustment
            document.dispatchEvent(new CustomEvent('sidebar-toggle'));
        });

        // Profile Dropdown functionality
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');
        let isDropdownOpen = false;

        function toggleDropdown(event) {
            event.stopPropagation();
            isDropdownOpen = !isDropdownOpen;

            if (isDropdownOpen) {
                userDropdown.classList.remove('hidden');
                userMenuButton.setAttribute('aria-expanded', 'true');
            } else {
                userDropdown.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }
        }

        // Toggle dropdown on button click
        userMenuButton?.addEventListener('click', toggleDropdown);

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (isDropdownOpen && !userDropdown.contains(event.target)) {
                isDropdownOpen = false;
                userDropdown.classList.add('hidden');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }
        });

        // Change Password Modal functionality
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const changePasswordModal = document.getElementById('changePasswordModal');
        const closeModal = document.getElementById('closeModal');
        const cancelPasswordChange = document.getElementById('cancelPasswordChange');
        const changePasswordForm = document.getElementById('changePasswordForm');

        // Open modal
        changePasswordBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            changePasswordModal.classList.remove('hidden');
            // Close dropdown when opening modal
            userDropdown.classList.add('hidden');
            isDropdownOpen = false;
        });

        // Close modal functions
        const closePasswordModal = () => {
            changePasswordModal.classList.add('hidden');
            if (changePasswordForm) {
                changePasswordForm.reset();
            }
        };

        closeModal?.addEventListener('click', closePasswordModal);
        cancelPasswordChange?.addEventListener('click', closePasswordModal);

        // Close modal when clicking outside
        changePasswordModal?.addEventListener('click', (e) => {
            if (e.target === changePasswordModal) {
                closePasswordModal();
            }
        });

        // Handle form submission
        changePasswordForm?.addEventListener('submit', (e) => {
            e.preventDefault();

            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            if (newPassword !== confirmPassword) {
                alert('New passwords do not match!');
                return;
            }

            alert('Password changed successfully!');
            closePasswordModal();
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton?.addEventListener('click', () => {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
            mobileMenu.classList.toggle('hidden');
        });


        // Notifications functionality
        const notificationsBtn = document.getElementById('notificationsBtn');
        const mobileNotificationsBtn = document.getElementById('mobile-notificationsBtn');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        const mobileNotificationsPanel = document.getElementById('mobile-notifications-panel');
        const closeMobileNotifications = document.getElementById('close-mobile-notifications');
        const notificationLists = document.querySelectorAll('.notifications-list');
        const notificationCounts = document.querySelectorAll('#notification-count, #mobile-notification-count');
        let isNotificationsOpen = false;

        function toggleDesktopNotifications(event) {
            event.stopPropagation();
            isNotificationsOpen = !isNotificationsOpen;

            if (isNotificationsOpen) {
                notificationsDropdown.classList.remove('hidden');
                loadNotifications();
            } else {
                notificationsDropdown.classList.add('hidden');
            }
        }

        function toggleMobileNotifications(event) {
            event.stopPropagation();
            mobileNotificationsPanel.classList.remove('hidden');
            loadNotifications();
        }

        function closeMobileNotificationsPanel() {
            mobileNotificationsPanel.classList.add('hidden');
        }

        async function loadNotifications() {
            try {
                const response = await fetch('/api/notifications');
                const data = await response.json();

                if (data.notifications && Array.isArray(data.notifications)) {
                    // Update all notification counts
                    notificationCounts.forEach(count => {
                        count.textContent = data.notifications.length || 0;
                    });

                    // Generate notifications HTML
                    const notificationsHTML = data.notifications.length > 0 ?
                        data.notifications.map(notification => `
                            <a href="/admin/orders/${notification.id}" class="block">
                                <div class="p-4 hover:bg-gray-50 border-b border-gray-100">
                                    <div class="flex items-center">
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800">${notification.message}</p>
                                            <p class="text-xs text-gray-500 mt-1">${notification.time}</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        `).join('') :
                        '<div class="p-4 text-center text-gray-500">No notifications</div>';

                    // Update all notification lists
                    notificationLists.forEach(list => {
                        list.innerHTML = notificationsHTML;
                    });

                    // // Add event listeners for "Mark as read" buttons
                    // document.querySelectorAll('.mark-as-read').forEach(button => {
                    //     button.addEventListener('click', async (e) => {
                    //         e.stopPropagation();
                    //         const notificationId = e.target.dataset.id;
                    //         await markAsRead(notificationId);
                    //     });
                    // });
                }
            } catch (error) {
                console.error('Error loading notifications:', error);
                notificationLists.forEach(list => {
                    list.innerHTML = '<div class="p-4 text-center text-red-500">Error loading notifications</div>';
                });
            }
        }

        // async function markAsRead(notificationId) {
        //     try {
        //         const response = await fetch(`/api/notifications/${notificationId}/mark-as-read`, {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        //             }
        //         });

        //         if (response.ok) {
        //             loadNotifications();
        //         }
        //     } catch (error) {
        //         console.error('Error marking notification as read:', error);
        //     }
        // }

        // Event Listeners
        notificationsBtn?.addEventListener('click', toggleDesktopNotifications);
        mobileNotificationsBtn?.addEventListener('click', toggleMobileNotifications);
        closeMobileNotifications?.addEventListener('click', closeMobileNotificationsPanel);

        // Close notifications when clicking outside
        document.addEventListener('click', (event) => {
            if (isNotificationsOpen && !notificationsDropdown.contains(event.target)) {
                isNotificationsOpen = false;
                notificationsDropdown.classList.add('hidden');
            }
        });

        mobileNotificationsPanel?.addEventListener('click', (event) => {
            if (event.target === mobileNotificationsPanel) {
                closeMobileNotificationsPanel();
            }
        });

        // Load initial notifications
        loadNotifications();

        // Optional: Set up periodic updates
        setInterval(loadNotifications, 60000); // Update every minute
    });
</script>