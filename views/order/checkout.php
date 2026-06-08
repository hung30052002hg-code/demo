<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Thanh toán hóa đơn</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">Xác Nhận Đơn Hàng</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <!-- Error Box -->
    <?php if (!empty($error)): ?>
        <div class="max-w-4xl mx-auto bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-xl p-4 mb-8 flex items-start space-x-2 animate-fade-in">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <!-- Layout: Forms + Order Review -->
    <form action="<?php echo BASE_URL; ?>index.php?controller=order&action=checkout" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        
        <!-- Left Column: Shipping & Payment Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Shipping Info Card -->
            <div class="bg-card border border-border/10 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl animate-fade-in">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Thông Tin Giao Hàng</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Name (Read-only from Session) -->
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-text-light uppercase tracking-wider">Người nhận hàng</label>
                        <input type="text" readonly value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>"
                               class="w-full bg-black/5 dark:bg-white/5 border border-border/10 rounded-xl px-4 py-3.5 text-sm text-text-gray focus:outline-none cursor-not-allowed">
                    </div>
                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="text-xs font-semibold text-text-light uppercase tracking-wider">Số điện thoại *</label>
                        <input type="text" name="phone" id="phone" required placeholder="0909xxxxxx"
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                               class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3.5 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- District Selector -->
                    <div class="space-y-2">
                        <label for="shipping_district" class="text-xs font-semibold text-text-light uppercase tracking-wider">Khu Vực Giao Hàng (Hải Phòng) *</label>
                        <select name="shipping_district" id="shipping_district" required onchange="updateShippingFee()"
                                class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3.5 text-sm text-text-light focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-colors">
                            <option value="Hồng Bàng" data-fee="15000" class="bg-surface text-text-light">Quận Hồng Bàng (15,000đ)</option>
                            <option value="Ngô Quyền" data-fee="15000" class="bg-surface text-text-light">Quận Ngô Quyền (15,000đ)</option>
                            <option value="Lê Chân" data-fee="20000" class="bg-surface text-text-light">Quận Lê Chân (20,000đ)</option>
                            <option value="Hải An" data-fee="25000" class="bg-surface text-text-light">Quận Hải An (25,000đ)</option>
                            <option value="Kiến An" data-fee="30000" class="bg-surface text-text-light">Quận Kiến An (30,000đ)</option>
                            <option value="Dương Kinh" data-fee="35000" class="bg-surface text-text-light">Quận Dương Kinh (35,000đ)</option>
                            <option value="Đồ Sơn" data-fee="45000" class="bg-surface text-text-light">Quận Đồ Sơn (45,000đ)</option>
                            <option value="Thủy Nguyên" data-fee="30000" class="bg-surface text-text-light">Huyện Thủy Nguyên (30,000đ)</option>
                            <option value="An Dương" data-fee="25000" class="bg-surface text-text-light">Huyện An Dương (25,000đ)</option>
                            <option value="An Lão" data-fee="35000" class="bg-surface text-text-light">Huyện An Lão (35,000đ)</option>
                        </select>
                    </div>
                    <!-- Hidden Shipping Fee Input to pass to POST -->
                    <input type="hidden" name="shipping_fee" id="shippingFeeInput" value="15000">
                </div>

                <!-- Shipping Address -->
                <div class="space-y-2">
                    <label for="shipping_address" class="text-xs font-semibold text-text-light uppercase tracking-wider">Địa chỉ nhận hàng (Số nhà, tên đường, phường/xã) *</label>
                    <input type="text" name="shipping_address" id="shipping_address" required placeholder="Ví dụ: Số 12 Lạch Tray..."
                           value="<?php echo isset($_POST['shipping_address']) ? htmlspecialchars($_POST['shipping_address']) : ''; ?>"
                           class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3.5 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>

                <!-- Note -->
                <div class="space-y-2">
                    <label for="note" class="text-xs font-semibold text-text-light uppercase tracking-wider">Ghi chú đơn hàng</label>
                    <textarea name="note" id="note" rows="3" placeholder="Ít đường, nhiều đá, ghi chú giờ giao hàng..."
                              class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 transition-all duration-300 resize-none"><?php echo isset($_POST['note']) ? htmlspecialchars($_POST['note']) : ''; ?></textarea>
                </div>
            </div>

            <!-- Payment Method Card -->
            <div class="bg-card border border-border/10 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl animate-fade-in" style="animation-delay: 100ms">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Phương Thức Thanh Toán</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- COD -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="COD" checked class="sr-only peer">
                        <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary/5 rounded-2xl p-6 hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300 flex items-start gap-4">
                            <span class="text-3xl">💵</span>
                            <div>
                                <span class="block text-sm font-bold text-text-light">Thanh toán khi nhận hàng</span>
                                <span class="block text-xs text-text-gray mt-1 leading-normal">Thanh toán bằng tiền mặt khi shipper giao trà sữa tới tay bạn.</span>
                            </div>
                        </div>
                    </label>
                    <!-- ONLINE -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="ONLINE" class="sr-only peer">
                        <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary/5 rounded-2xl p-6 hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300 flex items-start gap-4">
                            <span class="text-3xl">💳</span>
                            <div>
                                <span class="block text-sm font-bold text-text-light">Thanh toán qua QR Code</span>
                                <span class="block text-xs text-text-gray mt-1 leading-normal">Quét mã QR qua ví điện tử MoMo hoặc Ngân hàng điện tử (VNPAY/PayOS).</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary & Discount -->
        <div class="space-y-6">
            <!-- Review Products Card -->
            <div class="bg-card border border-border/10 rounded-3xl p-6 sm:p-8 space-y-6 shadow-xl animate-fade-in" style="animation-delay: 200ms">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Hóa Đơn Của Bạn</h2>
                
                <!-- Items list -->
                <div class="max-h-60 overflow-y-auto divide-y divide-border/10 pr-2">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="flex items-center justify-between py-3 text-sm gap-4">
                            <div class="space-y-0.5">
                                <span class="font-bold text-text-light block leading-tight"><?php echo htmlspecialchars($item['name']); ?></span>
                                <span class="text-xs text-text-gray block leading-normal">
                                    Size: <?php echo $item['size']; ?> | Đường: <?php echo $item['sugar']; ?> | Đá: <?php echo $item['ice']; ?> x <?php echo $item['quantity']; ?>
                                </span>
                                <?php if (!empty($item['toppings'])): ?>
                                    <span class="text-[11px] text-text-gray block leading-normal">
                                        Toppings: <?php echo implode(', ', array_column($item['toppings'], 'name')); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <span class="font-semibold text-text-light flex-shrink-0"><?php echo number_format($item['subtotal']); ?>đ</span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Coupon Input Form -->
                <div class="space-y-2 pt-4 border-t border-border/10">
                    <label for="coupon_code" class="text-xs font-semibold text-text-light uppercase tracking-wider block">Mã Giảm Giá (Coupon)</label>
                    <div class="flex gap-2">
                        <input type="text" name="coupon_code" id="coupon_code" placeholder="Ví dụ: STARBUCKS10"
                               class="flex-1 bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-2 text-sm text-text-light focus:outline-none focus:border-primary/50 transition-colors uppercase">
                        <button type="button" onclick="applyCoupon()"
                                class="bg-black/5 dark:bg-white/5 hover:bg-primary/10 border border-border/20 text-text-light font-semibold text-xs px-4 rounded-xl transition-all duration-300">
                            Áp Dụng
                        </button>
                    </div>
                    <span id="couponMessage" class="text-xs block mt-1"></span>
                </div>

                <!-- Loyalty Points Block -->
                <div class="space-y-2 pt-4 border-t border-border/10">
                    <div class="flex justify-between items-center">
                        <label for="apply_points_chk" class="text-xs font-semibold text-text-light uppercase tracking-wider block">Tích điểm đổi quà</label>
                        <span class="text-xs text-text-gray">Bạn có: <strong class="text-text-light" id="availablePoints" data-value="<?php echo $userPoints; ?>"><?php echo number_format($userPoints); ?></strong> điểm</span>
                    </div>
                    <div class="flex gap-2 items-center bg-black/5 dark:bg-white/3 border border-border/10 rounded-xl p-3.5">
                        <input type="checkbox" name="apply_points_chk" id="apply_points_chk" onchange="togglePoints()" class="w-4 h-4 text-primary bg-black/5 dark:bg-white/5 border-border/20 rounded focus:ring-primary focus:ring-2 focus:ring-offset-0">
                        <div class="flex-1 text-xs text-text-gray">
                            <span class="block text-text-light font-medium">Sử dụng điểm đổi quà</span>
                            <span class="block text-[11px] mt-0.5">1 điểm = 1,000đ giảm giá trực tiếp</span>
                        </div>
                        <input type="number" name="points_spent" id="points_spent" min="0" max="<?php echo $userPoints; ?>" value="0" readonly
                               class="w-20 bg-black/5 dark:bg-white/5 border border-border/20 rounded-lg px-2 py-1 text-sm text-center text-text-light focus:outline-none focus:border-primary/50 transition-colors">
                    </div>
                </div>

                <!-- Price Summary -->
                <div class="space-y-3 pt-4 border-t border-border/10 text-sm">
                    <div class="flex justify-between text-text-gray">
                        <span>Tạm tính</span>
                        <span class="text-text-light" id="checkoutSubtotal" data-value="<?php echo $cartTotal; ?>"><?php echo number_format($cartTotal); ?>đ</span>
                    </div>
                    <div class="flex justify-between text-text-gray">
                        <span>Giảm giá (Coupon)</span>
                        <span class="text-emerald-400" id="checkoutDiscount" data-value="0">-0đ</span>
                    </div>
                    <div class="flex justify-between text-text-gray">
                        <span>Giảm giá (Tích điểm)</span>
                        <span class="text-emerald-400" id="pointsDiscount" data-value="0">-0đ</span>
                    </div>
                    <div class="flex justify-between text-text-gray">
                        <span>Phí giao hàng</span>
                        <span class="text-primary-light font-semibold" id="checkoutShippingFee">15,000đ</span>
                    </div>
                    <div class="h-px bg-border/10 pt-2"></div>
                    <div class="flex justify-between text-base font-bold pt-2">
                        <span class="text-text-light">Tổng cộng</span>
                        <span class="text-primary-light text-xl" id="checkoutTotal"><?php echo number_format($cartTotal + 15000); ?>đ</span>
                    </div>
                </div>

                <!-- Submit Order Button -->
                <button type="submit" 
                        class="w-full bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>XÁC NHẬN ĐẶT HÀNG</span>
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    // Hàm tính toán lại tổng tiền từ đầu
    function recalculateTotal() {
        const subtotal = parseInt(document.getElementById('checkoutSubtotal').dataset.value) || 0;
        const fee = parseInt(document.getElementById('shippingFeeInput').value) || 0;
        
        // Giảm giá coupon
        const discountText = document.getElementById('checkoutDiscount').textContent;
        const couponDiscount = parseInt(discountText.replace(/[^\d]/g, '')) || 0;
        
        // Giảm giá tích điểm
        const pointsInput = document.getElementById('points_spent');
        let pointsSpent = pointsInput ? (parseInt(pointsInput.value) || 0) : 0;
        
        // Đảm bảo số điểm sử dụng không vượt quá giới hạn hóa đơn còn lại
        const maxPointsNeeded = Math.floor((subtotal - couponDiscount) / 1000);
        if (pointsSpent > maxPointsNeeded) {
            pointsSpent = maxPointsNeeded;
            if (pointsInput) pointsInput.value = pointsSpent;
        }
        
        const pointsDiscount = pointsSpent * 1000;
        document.getElementById('pointsDiscount').textContent = '-' + pointsDiscount.toLocaleString('vi-VN') + 'đ';
        
        // Tổng cộng cuối cùng
        const finalTotal = Math.max(0, subtotal - couponDiscount - pointsDiscount + fee);
        document.getElementById('checkoutTotal').textContent = finalTotal.toLocaleString('vi-VN') + 'đ';
    }

    // Tự động tính toán lại phí vận chuyển khi chọn khu vực
    function updateShippingFee() {
        const select = document.getElementById('shipping_district');
        const selectedOpt = select.options[select.selectedIndex];
        const fee = parseInt(selectedOpt.dataset.fee) || 0;
        
        document.getElementById('shippingFeeInput').value = fee;
        document.getElementById('checkoutShippingFee').textContent = fee.toLocaleString('vi-VN') + 'đ';
        
        recalculateTotal();
    }

    // Xử lý bật/tắt sử dụng điểm tích lũy
    function togglePoints() {
        const chk = document.getElementById('apply_points_chk');
        const pointsInput = document.getElementById('points_spent');
        if (!chk || !pointsInput) return;
        
        const availablePoints = parseInt(document.getElementById('availablePoints').dataset.value) || 0;
        const subtotal = parseInt(document.getElementById('checkoutSubtotal').dataset.value) || 0;
        
        const discountText = document.getElementById('checkoutDiscount').textContent;
        const couponDiscount = parseInt(discountText.replace(/[^\d]/g, '')) || 0;
        
        const maxPointsNeeded = Math.floor((subtotal - couponDiscount) / 1000);
        
        if (chk.checked) {
            const pointsToUse = Math.min(availablePoints, maxPointsNeeded);
            pointsInput.value = pointsToUse;
        } else {
            pointsInput.value = 0;
        }
        
        recalculateTotal();
    }

    // Xử lý áp dụng mã coupon bằng AJAX
    function applyCoupon() {
        const code = document.getElementById('coupon_code').value.trim();
        const subtotal = parseInt(document.getElementById('checkoutSubtotal').dataset.value) || 0;
        const msgEl = document.getElementById('couponMessage');
        
        if (!code) {
            msgEl.className = 'text-xs text-primary-light block mt-1';
            msgEl.textContent = 'Vui lòng nhập mã giảm giá.';
            return;
        }

        const formData = new FormData();
        formData.append('coupon_code', code);
        formData.append('order_value', subtotal);

        fetch('<?php echo BASE_URL; ?>index.php?controller=cart&action=checkcoupon', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            if (res.status === 404) {
                const mockCoupons = {
                    'STARBUCKS10': { val: 10000, min: 50000 },
                    'CHUSTEAFREE': { val: 20000, min: 100000 },
                    'WELCOME50': { val: 50000, min: 200000 }
                };
                
                const cleanCode = code.toUpperCase();
                if (mockCoupons[cleanCode]) {
                    const c = mockCoupons[cleanCode];
                    if (subtotal >= c.min) {
                        return { success: true, message: 'Áp dụng mã giảm giá thành công!', discount: c.val };
                    } else {
                        return { success: false, message: 'Đơn hàng chưa đạt giá trị tối thiểu ' + c.min.toLocaleString('vi-VN') + 'đ để áp dụng mã này.' };
                    }
                }
                return { success: false, message: 'Mã giảm giá không tồn tại hoặc đã hết hiệu lực.' };
            }
            return res.json();
        })
        .then(data => {
            if (data.success) {
                msgEl.className = 'text-xs text-emerald-400 block mt-1';
                msgEl.textContent = data.message;
                
                const discount = parseInt(data.discount) || 0;
                document.getElementById('checkoutDiscount').textContent = '-' + discount.toLocaleString('vi-VN') + 'đ';
            } else {
                msgEl.className = 'text-xs text-primary-light block mt-1';
                msgEl.textContent = data.message;
                
                document.getElementById('checkoutDiscount').textContent = '-0đ';
            }
            
            // Re-evaluate points if checked
            const chk = document.getElementById('apply_points_chk');
            if (chk && chk.checked) {
                togglePoints();
            } else {
                recalculateTotal();
            }
        })
        .catch(err => {
            console.error(err);
        });
    }

    // Trigger update shipping fee on first load
    document.addEventListener('DOMContentLoaded', () => {
        updateShippingFee();
    });
</script>
