<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Trang quản trị</h1>
            <p class="text-3xl font-playfair font-bold text-white">Quản Lý Đơn Hàng</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=index" 
               class="px-5 py-3 border border-white/20 hover:border-white/50 text-white text-xs font-bold rounded-xl hover:bg-white/5 transition-all duration-300">
                ← Về Dashboard
            </a>
            <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=export" 
               class="px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-emerald-600/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Xuất Báo Cáo CSV</span>
            </a>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl animate-fade-in" style="animation-delay: 100ms">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/3 text-xs font-bold uppercase tracking-wider text-text-gray">
                        <th class="py-5 px-6">Mã đơn</th>
                        <th class="py-5 px-6">Khách hàng</th>
                        <th class="py-5 px-6">Tổng tiền</th>
                        <th class="py-5 px-6">Phương thức</th>
                        <th class="py-5 px-6">Thanh toán</th>
                        <th class="py-5 px-6">Ngày đặt</th>
                        <th class="py-5 px-6">Cập nhật trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm text-text-light">
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="7" class="py-10 text-center text-text-gray">Chưa có đơn hàng nào được đặt.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="hover:bg-white/1 transition-colors duration-200">
                                <!-- Order ID -->
                                <td class="py-4 px-6 font-bold text-white">
                                    #<?php echo $order['id']; ?>
                                </td>
                                
                                <!-- Customer Info -->
                                <td class="py-4 px-6 space-y-0.5">
                                    <span class="font-semibold text-white block"><?php echo htmlspecialchars($order['user_name']); ?></span>
                                    <span class="text-xs text-text-gray block">SĐT: <?php echo htmlspecialchars($order['phone']); ?></span>
                                    <span class="text-xs text-text-gray block line-clamp-1">Đ/C: <?php echo htmlspecialchars($order['shipping_address']); ?></span>
                                </td>
                                
                                <!-- Total money -->
                                <td class="py-4 px-6 font-bold text-primary-light">
                                    <?php echo number_format($order['total_money']); ?>đ
                                </td>
                                
                                <!-- Method -->
                                <td class="py-4 px-6 text-xs text-text-gray">
                                    <?php echo $order['payment_method'] === 'ONLINE' ? 'Trực tuyến' : 'Tiền mặt (COD)'; ?>
                                </td>
                                
                                <!-- Payment Status -->
                                <td class="py-4 px-6">
                                    <?php if ($order['payment_status'] === 'paid'): ?>
                                        <span class="inline-flex bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full px-2 py-0.5 text-xs font-semibold">Đã thanh toán</span>
                                    <?php else: ?>
                                        <span class="inline-flex bg-white/5 border border-white/10 text-text-gray rounded-full px-2 py-0.5 text-xs font-semibold">Chưa thanh toán</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Date -->
                                <td class="py-4 px-6 text-xs text-text-gray">
                                    <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                                </td>
                                
                                <!-- Change Status -->
                                <td class="py-4 px-6">
                                    <form action="<?php echo BASE_URL; ?>index.php?controller=admin&action=updateorderstatus" method="POST" class="flex gap-2">
                                        <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                                        <select name="status" onchange="this.form.submit()" 
                                                class="bg-white/5 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-primary/50 transition-colors cursor-pointer">
                                            <option value="pending" <?php echo ($order['status'] === 'pending') ? 'selected' : ''; ?>>Đang chờ duyệt</option>
                                            <option value="processing" <?php echo ($order['status'] === 'processing') ? 'selected' : ''; ?>>Đang pha chế</option>
                                            <option value="shipped" <?php echo ($order['status'] === 'shipped') ? 'selected' : ''; ?>>Đang giao hàng</option>
                                            <option value="completed" <?php echo ($order['status'] === 'completed') ? 'selected' : ''; ?>>Đã hoàn thành</option>
                                            <option value="cancelled" <?php echo ($order['status'] === 'cancelled') ? 'selected' : ''; ?>>Đã hủy đơn</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
