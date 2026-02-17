<script>
    // Sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.querySelector('.flex-1');
    let sidebarOpen = false;

    // async function fetchProtectedData() {
    //     try {
    //         const response = await fetch('/api/user', {
    //             headers: {
    //                 'Authorization': `Bearer ${token}`,
    //                 'Accept': 'application/json'
    //             },
    //             credentials: 'include'
    //         });

    //         if (response.ok) {
    //             const data = await response.json();
    //             console.log(data);
    //         } else {
    //             localStorage.removeItem('auth_token');
    //             window.location.href = '/admin/';
    //         }
    //     } catch (error) {
    //         console.error('Error:', error);
    //     }
    // }

    // Enhanced toggle functionality
    function initializeViewToggles() {
        const toggles = document.querySelectorAll('.view-toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', async function () {
                // Don't do anything if already active
                if (this.classList.contains('active')) return;

                // Remove active class from all toggles
                toggles.forEach(t => {
                    t.classList.remove('active');
                    t.style.transform = 'scale(1)';
                });

                // Add active class with animation
                this.classList.add('active');
                this.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);

                // Update chart data
                const view = this.dataset.view;
                showLoading();
                await updateChart(view);
                hideLoading();
            });

            // Add hover effect
            toggle.addEventListener('mouseenter', function () {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1.02)';
                }
            });

            toggle.addEventListener('mouseleave', function () {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'scale(1)';
                }
            });
        });
    }

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', () => {
        const token = localStorage.getItem('auth_token');
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');
        const form = document.getElementById('filterForm');
        const viewModeInput = document.getElementById('viewMode');

        initializeViewToggles();

        // Sidebar toggle functionality
        sidebarToggle?.addEventListener('click', () => {
            sidebarOpen = !sidebarOpen;
            sidebar.style.transform = sidebarOpen ? 'translateX(0)' : 'translateX(-100%)';
            mainContent.classList.toggle('ml-64', sidebarOpen);
            mainContent.classList.toggle('-ml-64', !sidebarOpen);
        });

        yearSelect.addEventListener('change', function () {
            toggleMonthSelect();
            form.submit();
        });

        monthSelect.addEventListener('change', function () {
            form.submit();
        });

        window.setViewMode = function (mode) {
            viewModeInput.value = mode;
            form.submit();
        };

        function toggleMonthSelect() {
            if (yearSelect.value === 'All') {
                monthSelect.disabled = true;
                monthSelect.value = 'All';
            } else {
                monthSelect.disabled = false;
            }
        }
    });
</script>