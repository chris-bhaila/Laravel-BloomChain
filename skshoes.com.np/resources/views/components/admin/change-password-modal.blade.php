<!-- Change Password Modal -->
<div id="changePasswordModal" class="hidden fixed inset-0 bg-gradient-to-br from-blue-600 to-cyan-300 overflow-y-auto h-full w-full z-50 flex justify-center items-center">
    <div class="relative mx-auto p-6 w-[448px] bg-white rounded-xl shadow-2xl">
        <div class="mt-1">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-2xl font-semibold text-gray-600">Change Password</h3>
                <button id="closeModal" class="text-gray-400 hover:text-gray-500 transition-colors duration-200">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <hr class="mb-6">
            <div class="mt-4">
                <form id="changePasswordForm" class="space-y-4">
                    <div class="space-y-4">
                        <div class="flex items-center border-2 py-2 px-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="newPassword" name="newPassword" 
                                class="pl-2 outline-none border-none w-full" 
                                placeholder="New Password"
                                required>
                        </div>
                        <div class="flex items-center border-2 py-2 px-3 rounded-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <input type="password" id="confirmPassword" name="confirmPassword" 
                                class="pl-2 outline-none border-none w-full" 
                                placeholder="Confirm New Password"
                                required>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 pt-6">
                        <button type="button" id="cancelPasswordChange" 
                            class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 
                            rounded-md transition-all duration-200 shadow-md">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-5 py-2.5 text-sm font-medium text-white shadow-xl 
                            bg-gradient-to-tr from-blue-600 to-red-400 hover:to-red-700 
                            rounded-md transition-all duration-1000">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Change Password Modal Functionality
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const changePasswordModal = document.getElementById('changePasswordModal');
    const closeModal = document.getElementById('closeModal');
    const cancelPasswordChange = document.getElementById('cancelPasswordChange');
    const changePasswordForm = document.getElementById('changePasswordForm');

    // Open modal
    changePasswordBtn.addEventListener('click', () => {
        changePasswordModal.classList.remove('hidden');
        userDropdown.classList.add('hidden'); // Close dropdown when opening modal
    });

    // Close modal functions
    const closePasswordModal = () => {
        changePasswordModal.classList.add('hidden');
        changePasswordForm.reset(); // Reset form when closing
    };

    closeModal.addEventListener('click', closePasswordModal);
    cancelPasswordChange.addEventListener('click', closePasswordModal);

    // Close modal when clicking outside
    changePasswordModal.addEventListener('click', (e) => {
        if (e.target === changePasswordModal) {
            closePasswordModal();
        }
    });

    // Handle form submission
    changePasswordForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        if (newPassword !== confirmPassword) {
            alert('New passwords do not match!');
            return;
        }

        // Add your password change logic here
        // You can make an API call to your backend

        // For demo purposes:
        alert('Password changed successfully!');
        closePasswordModal();
    });
</script> 