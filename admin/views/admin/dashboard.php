<div class="max-w-7xl mx-auto w-full">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Trang quản trị</h1>
            <p class="text-3xl font-playfair font-bold text-white">Dashboard Quản Trị</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        <div class="text-sm text-text-gray">
            Xin chào, <strong class="text-white"><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong> (Quản trị viên)
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in" style="animation-delay: 100ms">
        <!-- Products Stat Card -->
        <div class="bg-card border border-white/5 rounded-3xl p-8 flex items-center justify-between hover:border-primary/20 transition-all duration-300 shadow-xl group">
            <div class="space-y-2">
                <span class="text-text-gray text-xs font-semibold uppercase tracking-wider block">Sản Phẩm</span>
                <span class="text-4xl font-bold text-white block"><?php echo $stats['total_products']; ?></span>
                <a href="<?php echo $adminUrl; ?>action=products" class="text-xs text-primary hover:text-primary-light font-medium inline-block pt-2">Quản lý sản phẩm →</a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300">
                🧋
            </div>
        </div>

        <!-- Categories Stat Card -->
        <div class="bg-card border border-white/5 rounded-3xl p-8 flex items-center justify-between hover:border-primary/20 transition-all duration-300 shadow-xl group">
            <div class="space-y-2">
                <span class="text-text-gray text-xs font-semibold uppercase tracking-wider block">Danh Mục</span>
                <span class="text-4xl font-bold text-white block"><?php echo $stats['total_categories']; ?></span>
                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" class="text-xs text-primary hover:text-primary-light font-medium inline-block pt-2">Xem danh mục →</a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300">
                ⭐
            </div>
        </div>

        <!-- Orders Stat Card -->
        <div class="bg-card border border-white/5 rounded-3xl p-8 flex items-center justify-between hover:border-primary/20 transition-all duration-300 shadow-xl group">
            <div class="space-y-2">
                <span class="text-text-gray text-xs font-semibold uppercase tracking-wider block">Đơn Hàng</span>
                <span class="text-4xl font-bold text-white block"><?php echo $stats['total_orders']; ?></span>
                <a href="<?php echo $adminUrl; ?>action=orders" class="text-xs text-primary hover:text-primary-light font-medium inline-block pt-2">Quản lý đơn hàng →</a>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300">
                📦
            </div>
        </div>

        <!-- Users Stat Card -->
        <div class="bg-card border border-white/5 rounded-3xl p-8 flex items-center justify-between hover:border-primary/20 transition-all duration-300 shadow-xl group">
            <div class="space-y-2">
                <span class="text-text-gray text-xs font-semibold uppercase tracking-wider block">Thành Viên</span>
                <span class="text-4xl font-bold text-white block"><?php echo $stats['total_users']; ?></span>
                <span class="text-xs text-text-gray block pt-2">Khách hàng đăng ký</span>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform duration-300">
                👤
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-card border border-white/5 rounded-3xl p-8 md:p-10 animate-fade-in-up" style="animation-delay: 200ms">
        <h2 class="text-lg font-bold text-white mb-6 border-b border-white/5 pb-4">Thao Tác Nhanh</h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="<?php echo $adminUrl; ?>action=addproduct" 
               class="p-6 bg-white/3 border border-white/5 rounded-2xl text-center hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 flex flex-col items-center gap-3">
                <span class="text-3xl">➕</span>
                <span class="text-sm font-bold text-white">Thêm Sản Phẩm Mới</span>
                <span class="text-xs text-text-gray">Đăng bán sản phẩm mới lên website</span>
            </a>
            
            <a href="<?php echo $adminUrl; ?>action=products" 
               class="p-6 bg-white/3 border border-white/5 rounded-2xl text-center hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 flex flex-col items-center gap-3">
                <span class="text-3xl">📝</span>
                <span class="text-sm font-bold text-white">Quản Lý Thực Đơn</span>
                <span class="text-xs text-text-gray">Chỉnh sửa, cập nhật giá hoặc xóa trà sữa</span>
            </a>

            <a href="<?php echo $adminUrl; ?>action=stats" 
               class="p-6 bg-white/3 border border-white/5 rounded-2xl text-center hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 flex flex-col items-center gap-3">
                <span class="text-3xl">📊</span>
                <span class="text-sm font-bold text-white">Thống Kê Báo Cáo</span>
                <span class="text-xs text-text-gray">Xem thống kê bán chạy & khách hàng</span>
            </a>

            <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout" 
               class="p-6 bg-white/3 border border-white/5 rounded-2xl text-center hover:border-primary/30 hover:bg-primary/5 transition-all duration-300 flex flex-col items-center gap-3">
                <span class="text-3xl">🚪</span>
                <span class="text-sm font-bold text-white">Đăng Xuất Quản Trị</span>
                <span class="text-xs text-text-gray">Đăng xuất khỏi phiên làm việc hiện tại</span>
            </a>
        </div>
    </div>
</div>
