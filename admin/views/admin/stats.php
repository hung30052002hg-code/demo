<div class="max-w-7xl mx-auto w-full">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-12 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Trang quản trị</h1>
            <p class="text-3xl font-playfair font-bold text-white">Thống Kê Doanh Số</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        <a href="<?php echo $adminUrl; ?>action=index" 
           class="px-5 py-2.5 border border-white/20 hover:border-white/50 text-white text-xs font-bold rounded-xl hover:bg-white/5 transition-all duration-300">
            ← Về Dashboard
        </a>
    </div>

    <!-- Stats Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-stretch">
        
        <!-- Left Column: Best Sellers -->
        <div class="bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl flex flex-col justify-between animate-fade-in">
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-white/5">
                    <h2 class="text-base font-bold text-white">🔥 Top 5 Sản Phẩm Bán Chạy</h2>
                    <span class="text-xs text-text-gray">Tính trên đơn hoàn thành</span>
                </div>
                
                <div class="space-y-6">
                    <?php if (empty($bestSellers)): ?>
                        <p class="text-sm text-text-gray py-6 text-center">Chưa có dữ liệu thống kê sản phẩm bán chạy.</p>
                    <?php else: ?>
                        <?php 
                        // Lấy số lượng bán cao nhất để tính tỷ lệ %
                        $maxSold = (int)$bestSellers[0]['total_sold'];
                        foreach ($bestSellers as $product): 
                            $percent = $maxSold > 0 ? round(((int)$product['total_sold'] / $maxSold) * 100) : 0;
                        ?>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-semibold text-white"><?php echo htmlspecialchars($product['name']); ?></span>
                                    <span class="text-text-gray font-medium"><?php echo $product['total_sold']; ?> cốc / <strong class="text-primary-light"><?php echo number_format($product['total_revenue']); ?>đ</strong></span>
                                </div>
                                <!-- Progress bar -->
                                <div class="w-full h-2 bg-white/5 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-primary to-primary-light rounded-full transition-all duration-1000" 
                                         style="width: <?php echo $percent; ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="pt-6 border-t border-white/5 text-[10px] text-text-gray italic">
                * Thống kê bán chạy tự động gợi ý các sản phẩm phù hợp cho thuật toán AI của cửa hàng.
            </div>
        </div>

        <!-- Right Column: Top Spenders -->
        <div class="bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl flex flex-col justify-between animate-fade-in" style="animation-delay: 100ms">
            <div class="space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-white/5">
                    <h2 class="text-base font-bold text-white">💎 Khách Hàng Tiềm Năng</h2>
                    <span class="text-xs text-text-gray">Top 5 chi tiêu nhiều nhất</span>
                </div>
                
                <div class="space-y-5">
                    <?php if (empty($topCustomers)): ?>
                        <p class="text-sm text-text-gray py-6 text-center">Chưa có dữ liệu khách hàng tiềm năng.</p>
                    <?php else: ?>
                        <?php foreach ($topCustomers as $customer): ?>
                            <div class="flex items-center justify-between bg-white/3 border border-white/5 p-4 rounded-2xl hover:border-primary/20 transition-all duration-300">
                                <div class="space-y-0.5">
                                    <span class="font-bold text-white text-sm block"><?php echo htmlspecialchars($customer['name']); ?></span>
                                    <span class="text-xs text-text-gray block"><?php echo htmlspecialchars($customer['email']); ?></span>
                                </div>
                                <div class="text-right">
                                    <span class="text-primary-light font-bold text-sm block"><?php echo number_format($customer['total_spent']); ?>đ</span>
                                    <span class="text-[10px] text-text-gray block">Đã đặt: <?php echo $customer['total_orders']; ?> đơn</span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="pt-6 border-t border-white/5 text-[10px] text-text-gray italic">
                * Có thể sử dụng dữ liệu này để gửi email tri ân khách hàng tiềm năng định kỳ.
            </div>
        </div>

    </div>
</div>
