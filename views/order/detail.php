<?php
$successMsg = '';
if (isset($_SESSION['checkout_success'])) {
    $successMsg = $_SESSION['checkout_success'];
    unset($_SESSION['checkout_success']);
}
?>
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Chi tiết giao dịch</h1>
            <p class="text-3xl font-playfair font-bold text-white">Chi Tiết Đơn Hàng #<?php echo $order['id']; ?></p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=history" 
           class="px-5 py-2.5 border border-white/20 hover:border-white/50 text-white text-xs font-bold rounded-xl hover:bg-white/5 transition-all duration-300">
            ← Trở Lại Lịch Sử
        </a>
    </div>

    <!-- Success Message Alert -->
    <?php if (!empty($successMsg)): ?>
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs rounded-xl p-4 mb-8 flex items-start space-x-2 animate-fade-in">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span><?php echo htmlspecialchars($successMsg); ?></span>
        </div>
    <?php endif; ?>

    <!-- Order Progress Tracker (Theo dõi trạng thái đơn hàng trực quan) -->
    <div class="bg-card border border-white/5 rounded-3xl p-8 mb-10 shadow-xl animate-fade-in">
        <h2 class="text-sm font-bold uppercase tracking-wider text-white pb-4 border-b border-white/5 mb-8">Trạng Thái Đơn Hàng</h2>
        
        <?php
        // Đánh giá bước hoạt động hiện tại
        $statusSteps = ['pending', 'processing', 'shipped', 'completed'];
        $currentStepIndex = array_search($order['status'], $statusSteps);
        
        // Nếu bị hủy đơn (cancelled), xử lý riêng biệt
        $isCancelled = ($order['status'] === 'cancelled');
        ?>

        <?php if ($isCancelled): ?>
            <div class="bg-red-500/10 border border-red-500/20 text-red-500 rounded-2xl p-6 text-center flex items-center justify-center gap-3">
                <span class="text-2xl">❌</span>
                <span class="font-bold">Đơn hàng này đã bị hủy bỏ.</span>
            </div>
        <?php else: ?>
            <!-- Progress Stepper HTML -->
            <div class="relative flex flex-col md:flex-row justify-between items-center gap-8 md:gap-4 max-w-3xl mx-auto">
                <!-- Connective lines (Only desktop) -->
                <div class="absolute top-5 left-10 right-10 h-0.5 bg-white/10 -z-10 hidden md:block"></div>
                <div class="absolute top-5 left-10 h-0.5 bg-primary -z-10 hidden md:block transition-all duration-500" 
                     style="width: <?php echo ($currentStepIndex !== false) ? ($currentStepIndex * 33) : 0; ?>%"></div>

                <!-- Step 1: Pending -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                         <?php echo ($currentStepIndex !== false && $currentStepIndex >= 0) ? 'bg-primary border-primary text-white shadow-lg shadow-primary/40' : 'bg-[#1A1A1A] border-white/10 text-text-gray'; ?>">
                        1
                    </div>
                    <span class="text-xs font-semibold mt-3 <?php echo ($currentStepIndex !== false && $currentStepIndex >= 0) ? 'text-white' : 'text-text-gray'; ?>">Đã đặt đơn</span>
                    <span class="text-[10px] text-text-gray mt-1 block">Hệ thống ghi nhận</span>
                </div>

                <!-- Step 2: Processing -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                         <?php echo ($currentStepIndex !== false && $currentStepIndex >= 1) ? 'bg-primary border-primary text-white shadow-lg shadow-primary/40' : 'bg-[#1A1A1A] border-white/10 text-text-gray'; ?>">
                        2
                    </div>
                    <span class="text-xs font-semibold mt-3 <?php echo ($currentStepIndex !== false && $currentStepIndex >= 1) ? 'text-white' : 'text-text-gray'; ?>">Đang pha chế</span>
                    <span class="text-[10px] text-text-gray mt-1 block">Barista chuẩn bị</span>
                </div>

                <!-- Step 3: Shipped -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                         <?php echo ($currentStepIndex !== false && $currentStepIndex >= 2) ? 'bg-primary border-primary text-white shadow-lg shadow-primary/40' : 'bg-[#1A1A1A] border-white/10 text-text-gray'; ?>">
                        3
                    </div>
                    <span class="text-xs font-semibold mt-3 <?php echo ($currentStepIndex !== false && $currentStepIndex >= 2) ? 'text-white' : 'text-text-gray'; ?>">Đang giao hàng</span>
                    <span class="text-[10px] text-text-gray mt-1 block">Shipper vận chuyển</span>
                </div>

                <!-- Step 4: Completed -->
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold border-2 transition-all duration-300
                         <?php echo ($currentStepIndex !== false && $currentStepIndex >= 3) ? 'bg-primary border-primary text-white shadow-lg shadow-primary/40' : 'bg-[#1A1A1A] border-white/10 text-text-gray'; ?>">
                        4
                    </div>
                    <span class="text-xs font-semibold mt-3 <?php echo ($currentStepIndex !== false && $currentStepIndex >= 3) ? 'text-white' : 'text-text-gray'; ?>">Đã hoàn thành</span>
                    <span class="text-[10px] text-text-gray mt-1 block">Thưởng thức trà sữa</span>
                </div>
            </div>
        <?php endif; ?>

        <?php if (($order['status'] === 'shipped' || $order['status'] === 'processing') && !$isCancelled): ?>
            <div class="mt-8 pt-6 border-t border-black/5 flex justify-center md:justify-end">
                <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=confirmReceived&id=<?php echo $order['id']; ?>" 
                   onclick="return confirm('Bạn xác nhận đã nhận được đầy đủ hàng và muốn hoàn thành đơn hàng?');"
                   class="bg-primary hover:bg-primary-hover text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-primary/30 transition-all duration-300 transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                    <span>✔️</span> Đã Nhận Được Hàng (Hoàn Thành Đơn)
                </a>
            </div>
        <?php elseif ($order['status'] === 'pending' && !$isCancelled): ?>
            <div class="mt-8 pt-6 border-t border-black/5 flex justify-center md:justify-end">
                <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=cancel&id=<?php echo $order['id']; ?>" 
                   onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này? Tồn kho sản phẩm và điểm tích lũy đã tiêu sẽ được hoàn trả.');"
                   class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-2xl font-bold text-sm shadow-lg shadow-red-600/30 transition-all duration-300 transform hover:-translate-y-0.5 inline-flex items-center gap-2">
                    <span>❌</span> Hủy Đơn Hàng
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start animate-fade-in-up" style="animation-delay: 100ms">
        
        <!-- Left: Order list products (2 cols) -->
        <div class="lg:col-span-2 bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <h2 class="text-sm font-bold uppercase tracking-wider text-white pb-4 border-b border-white/5">Danh Sách Món Ăn</h2>
            
            <div class="divide-y divide-white/5">
                <?php foreach ($orderItems as $item): ?>
                    <div class="flex items-center py-4 gap-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-white/3 to-transparent border border-white/5 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <?php if (!empty($item['product_image']) && file_exists(ROOT_PATH . 'public/uploads/' . $item['product_image'])): ?>
                                <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($item['product_image']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <span class="text-3xl">🧋</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-grow space-y-1">
                            <h3 class="font-bold text-white text-sm leading-tight"><?php echo htmlspecialchars($item['product_name']); ?></h3>
                            <div class="text-[11px] text-text-gray leading-normal space-y-0.5">
                                <span>Kích cỡ: <strong class="text-white"><?php echo $item['size']; ?></strong></span>
                                <span>| Đường: <strong class="text-white"><?php echo $item['sugar_level'] ?? '100%'; ?></strong></span>
                                <span>| Đá: <strong class="text-white"><?php echo $item['ice_level'] ?? '100%'; ?></strong></span>
                                <?php if (!empty($item['toppings'])): ?>
                                    <div class="text-[10px] text-text-gray mt-0.5">
                                        <span>Toppings: <strong class="text-white"><?php echo htmlspecialchars($item['toppings']); ?></strong></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="text-xs text-text-gray block"><?php echo number_format($item['price']); ?>đ x <?php echo $item['quantity']; ?></span>
                            <span class="font-semibold text-white block text-sm"><?php echo number_format($item['price'] * $item['quantity']); ?>đ</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Price summary block -->
            <div class="pt-6 border-t border-white/5 space-y-2 text-sm text-text-gray">
                <?php
                $itemsTotal = 0;
                foreach ($orderItems as $item) {
                    $itemsTotal += $item['price'] * $item['quantity'];
                }
                $pointsDiscount = ($order['points_spent'] ?? 0) * 1000;
                $couponDiscount = max(0, $itemsTotal - ($order['total_money'] - ($order['shipping_fee'] ?? 30000) + $pointsDiscount));
                ?>
                <div class="flex justify-between">
                    <span>Tạm tính tiền hàng:</span>
                    <span class="text-white"><?php echo number_format($itemsTotal); ?>đ</span>
                </div>
                <?php if ($couponDiscount > 0): ?>
                <div class="flex justify-between">
                    <span>Giảm giá (Coupon):</span>
                    <span class="text-emerald-400">-<?php echo number_format($couponDiscount); ?>đ</span>
                </div>
                <?php endif; ?>
                <?php if ($pointsDiscount > 0): ?>
                <div class="flex justify-between">
                    <span>Giảm giá (Tích điểm):</span>
                    <span class="text-emerald-400">-<?php echo number_format($pointsDiscount); ?>đ</span>
                </div>
                <?php endif; ?>
                <div class="flex justify-between">
                    <span>Phí giao hàng:</span>
                    <span class="text-white"><?php echo number_format($order['shipping_fee'] ?? 30000); ?>đ</span>
                </div>
                <?php if ($order['status'] === 'completed' && ($order['points_earned'] ?? 0) > 0): ?>
                <div class="flex justify-between text-xs text-primary-light">
                    <span>Điểm tích lũy nhận được từ đơn này:</span>
                    <span>+<?php echo number_format($order['points_earned']); ?> điểm</span>
                </div>
                <?php endif; ?>
                <div class="flex justify-between items-center text-base font-bold pt-2 border-t border-white/5">
                    <span class="text-white">Tổng cộng thanh toán:</span>
                    <span class="text-primary-light font-bold text-xl"><?php echo number_format($order['total_money']); ?>đ</span>
                </div>
            </div>
        </div>

        <!-- Right: Shipping Info (1 col) -->
        <div class="bg-card border border-white/5 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl">
            <h2 class="text-sm font-bold uppercase tracking-wider text-white pb-4 border-b border-white/5">Thông Tin Giao Nhận</h2>
            
            <div class="space-y-4 text-xs leading-relaxed text-text-light">
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Người nhận</span>
                    <strong class="text-white text-sm"><?php echo htmlspecialchars($order['user_name']); ?></strong>
                </div>
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Số điện thoại</span>
                    <strong class="text-white text-sm"><?php echo htmlspecialchars($order['phone']); ?></strong>
                </div>
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Địa chỉ giao hàng</span>
                    <p class="text-white text-sm"><?php echo htmlspecialchars($order['shipping_address']); ?></p>
                </div>
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Ghi chú đơn hàng</span>
                    <p class="text-white italic text-sm"><?php echo !empty($order['note']) ? htmlspecialchars($order['note']) : 'Không có ghi chú'; ?></p>
                </div>
                <div class="h-px bg-white/5 my-2"></div>
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Hình thức thanh toán</span>
                    <span class="text-white font-medium"><?php echo $order['payment_method'] === 'ONLINE' ? 'Thanh toán trực tuyến' : 'Thanh toán khi nhận hàng (COD)'; ?></span>
                </div>
                <div class="space-y-1">
                    <span class="text-text-gray block uppercase font-semibold tracking-wider">Trạng thái thanh toán</span>
                    <?php if ($order['payment_status'] === 'paid'): ?>
                        <span class="text-emerald-400 font-bold">Đã thanh toán</span>
                    <?php else: ?>
                        <span class="text-amber-500 font-bold">Chưa thanh toán</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const orderId = <?php echo $order['id']; ?>;
        let currentStatus = '<?php echo $order['status']; ?>';
        let currentPaymentStatus = '<?php echo $order['payment_status']; ?>';

        // Chỉ thực hiện auto-polling nếu đơn hàng chưa hoàn thành (completed) hoặc bị hủy (cancelled)
        if (currentStatus !== 'completed' && currentStatus !== 'cancelled') {
            setInterval(() => {
                fetch('<?php echo BASE_URL; ?>index.php?controller=order&action=getStatusAjax&id=' + orderId)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if (data.status !== currentStatus || data.payment_status !== currentPaymentStatus) {
                                const statusMap = {
                                    'pending': 'Đã đặt đơn (Chờ duyệt)',
                                    'processing': 'Đang pha chế',
                                    'shipped': 'Đang giao hàng',
                                    'completed': 'Đã hoàn thành đơn',
                                    'cancelled': 'Đơn hàng bị hủy bỏ'
                                };
                                
                                const newStatusText = statusMap[data.status] || data.status;
                                
                                if (typeof showToast === 'function') {
                                    showToast('Đơn hàng #' + orderId + ' cập nhật trạng thái: ' + newStatusText, 'info');
                                } else {
                                    alert('Đơn hàng #' + orderId + ' cập nhật trạng thái: ' + newStatusText);
                                }
                                
                                // Reload lại trang để cập nhật giao diện đồ họa
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        }
                    })
                    .catch(err => console.error(err));
            }, 5000); // Polling mỗi 5 giây
        }
    });
</script>
