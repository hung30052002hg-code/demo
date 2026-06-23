        </div>
    </main>

    <!-- App JS & Admin Scripts -->
    <script>
        // Sidebar Toggle Logic cho Mobile
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('adminOverlay');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        function toggleSidebar() {
            const isOpen = sidebar.classList.contains('open');
            if (isOpen) {
                sidebar.classList.remove('open');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('open');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        if (openBtn) openBtn.addEventListener('click', toggleSidebar);
        if (closeBtn) closeBtn.addEventListener('click', toggleSidebar);
        if (overlay) overlay.addEventListener('click', toggleSidebar);
    </script>
    
    <!-- Toast Container -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3"></div>
    
    <!-- App JS -->
    <script src="<?php echo BASE_URL; ?>public/js/app.js?v=<?php echo time(); ?>"></script>
</body>
</html>
