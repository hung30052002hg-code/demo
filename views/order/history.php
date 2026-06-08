<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Theo dõi lịch sử</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-white">Đơn Hàng Đã Đặt</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <!-- Success Message Alert -->
    <?php if (!empty($successMsg)): ?>
        <div class="max-w-4xl mx-auto bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs rounded-xl p-4 mb-8 flex items-start space-x-2 animate-fade-in">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span><?php echo htmlspecialchars($successMsg); ?></span>
        </div>
    <?php endif; ?>

    <!-- Orders History Content -->
    <div class="max-w-5xl mx-auto animate-fade-in">
        <?php if (empty($orders)): ?>
            <!-- Empty State -->
            <div class="bg-card border border-white/5 rounded-3xl p-16 text-center space-y-6">
                <span class="text-6xl inline-block animate-bounce-subtle">📋</span>
                <h2 class="text-xl font-bold text-white">Bạn chưa đặt đơn hàng nào</h2>
                <p class="text-sm text-text-gray">
                    Khám phá ngay thực đơn trà sữa thơm ngon và tiến hành đặt đơn hàng đầu tiên của bạn!
                </p>
                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                   class="inline-block px-8 py-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-full shadow-lg shadow-primary/20 transition-all duration-300">
                    Khám Phá Menu
                </a>
            </div>
        <?php else: ?>
            <!-- Orders List Table -->
            <div class="bg-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/3 text-xs font-bold uppercase tracking-wider text-text-gray">
                                <th class="py-5 px-6">Mã đơn</th>
                                <th class="py-5 px-6">Ngày đặt</th>
                                <th class="py-5 px-6">Tổng tiền</th>
                                <th class="py-5 px-6">Trạng thái đơn</th>
                                <th class="py-5 px-6">Thanh toán</th>
                                <th class="py-5 px-6 text-right">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 text-sm text-text-light">
                            <?php foreach ($orders as $order): ?>
                                <tr class="hover:bg-white/1 transition-colors duration-200">
                                    <!-- Order ID -->
                                    <td class="py-4 px-6 font-bold text-white">
                                        #<?php echo $order['id']; ?>
                                    </td>
                                    
                                    <!-- Created Date -->
                                    <td class="py-4 px-6 text-xs text-text-gray">
                                        <?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?>
                                    </td>
                                    
                                    <!-- Total Money -->
                                    <td class="py-4 px-6 font-semibold text-white">
                                        <?php echo number_format($order['total_money']); ?>đ
                                    </td>
                                    
                                    <!-- Order Status Badge -->
                                    <td class="py-4 px-6">
                                        <?php
                                        $statusClasses = [
                                            'pending'    => 'bg-amber-500/10 border-amber-500/20 text-amber-500',
                                            'processing' => 'bg-blue-500/10 border-blue-500/20 text-blue-400',
                                            'shipped'    => 'bg-purple-500/10 border-purple-500/20 text-purple-400',
                                            'completed'  => 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400',
                                            'cancelled'  => 'bg-red-500/10 border-red-500/20 text-red-500'
                                        ];
                                        $statusTexts = [
                                            'pending'    => 'Đang chờ duyệt',
                                            'processing' => 'Đang pha chế',
                                            'shipped'    => 'Đang giao hàng',
                                            'completed'  => 'Đã hoàn thành',
                                            'cancelled'  => 'Đã hủy đơn'
                                        ];
                                        $statusClass = $statusClasses[$order['status']] ?? 'bg-white/5 text-text-gray';
                                        $statusText = $statusTexts[$order['status']] ?? 'Không xác định';
                                        ?>
                                        <span class="inline-flex border rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    
                                    <!-- Payment Status Badge -->
                                    <td class="py-4 px-6">
                                        <?php if ($order['payment_status'] === 'paid'): ?>
                                            <span class="inline-flex bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full px-2.5 py-0.5 text-xs font-medium">Đã thanh toán</span>
                                        <?php else: ?>
                                            <span class="inline-flex bg-white/5 border border-white/10 text-text-gray rounded-full px-2.5 py-0.5 text-xs font-medium">Chưa thanh toán</span>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex justify-end items-center gap-3">
                                            <!-- If unpaid & Online, show button pay -->
                                            <?php if ($order['payment_status'] === 'unpaid' && $order['payment_method'] === 'ONLINE' && $order['status'] !== 'cancelled'): ?>
                                                <a href="<?php echo BASE_URL; ?>index.php?controller=payment&action=pay&order_id=<?php echo $order['id']; ?>" 
                                                   class="text-xs text-primary hover:text-primary-light font-bold transition-colors duration-200">
                                                    Thanh toán ngay
                                                </a>
                                                <span class="text-white/10">|</span>
                                            <?php endif; ?>
                                            
                                            <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=detail&id=<?php echo $order['id']; ?>" 
                                               class="text-xs text-text-gray hover:text-white transition-colors duration-200 font-medium">
                                                Chi tiết
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
