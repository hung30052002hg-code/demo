<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Đơn hàng của bạn</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">Giỏ Hàng</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <div id="cartPageContent" class="animate-fade-in">
        <?php if (empty($cartItems)): ?>
            <!-- Empty Cart State -->
            <div class="bg-card border border-border/10 rounded-3xl p-16 text-center space-y-6 max-w-xl mx-auto">
                <span class="text-7xl inline-block animate-bounce-subtle">🛒</span>
                <h2 class="text-xl font-bold text-text-light">Giỏ hàng của bạn đang trống</h2>
                <p class="text-sm text-text-gray">
                    Hãy thêm những ly trà sữa thơm ngon thượng hạng của CHUS TEA vào giỏ hàng của bạn ngay thôi!
                </p>
                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                   class="inline-block px-8 py-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-full shadow-lg shadow-primary/20 transition-all duration-300">
                    Khám Phá Menu Ngay
                </a>
            </div>
        <?php else: ?>
            <!-- Cart Layout: Items + Sidebar Summary -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Left: Items list -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-card border border-border/10 rounded-3xl overflow-hidden p-6 sm:p-8 space-y-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Danh sách sản phẩm</h2>
                        
                        <div class="divide-y divide-border/10" id="cartItemsContainer">
                            <?php foreach ($cartItems as $item): ?>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center py-6 gap-4 sm:gap-6 first:pt-0 last:pb-0" id="item-row-<?php echo $item['cart_key']; ?>">
                                    <!-- Image -->
                                    <div class="relative w-20 h-20 bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent border border-border/20 rounded-xl flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        <?php if (!empty($item['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $item['image'])): ?>
                                            <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($item['image']); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <span class="text-4xl">🧋</span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Detail info -->
                                    <div class="flex-grow space-y-1">
                                        <h3 class="font-bold text-text-light text-base hover:text-primary transition-colors duration-300">
                                            <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $item['product_id']; ?>">
                                                <?php echo htmlspecialchars($item['name']); ?>
                                            </a>
                                        </h3>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-text-gray">
                                            <span>Kích cỡ: <strong class="text-text-light"><?php echo $item['size']; ?></strong></span>
                                            <span>•</span>
                                            <span>Đường: <strong class="text-text-light"><?php echo $item['sugar']; ?></strong></span>
                                            <span>•</span>
                                            <span>Đá: <strong class="text-text-light"><?php echo $item['ice']; ?></strong></span>
                                            <span>•</span>
                                            <span>Đơn giá: <strong class="text-primary-light"><?php echo number_format($item['price']); ?>đ</strong></span>
                                        </div>
                                        <?php if (!empty($item['toppings'])): ?>
                                            <div class="text-[11px] text-text-gray pt-1 leading-normal">
                                                <span>Toppings: </span>
                                                <span class="text-text-light font-medium">
                                                    <?php 
                                                    $tNames = array_map(function($t) { 
                                                        return htmlspecialchars($t['name']) . ' (+' . number_format($t['price']) . 'đ)'; 
                                                     }, $item['toppings']);
                                                    echo implode(', ', $tNames);
                                                    ?>
                                                </span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <!-- Quantity Selector (AJAX) -->
                                    <div class="flex items-center bg-black/5 dark:bg-white/5 border border-border/20 rounded-lg px-3 py-1.5 justify-between w-28">
                                        <button onclick="updateQty('<?php echo $item['cart_key']; ?>', <?php echo $item['quantity'] - 1; ?>)" 
                                                class="text-text-gray hover:text-primary transition-colors duration-200 focus:outline-none px-1 text-lg font-bold">-</button>
                                        <input type="number" value="<?php echo $item['quantity']; ?>" readonly
                                               class="w-8 text-center bg-transparent border-none text-text-light font-semibold focus:outline-none focus:ring-0 text-sm [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                        <button onclick="updateQty('<?php echo $item['cart_key']; ?>', <?php echo $item['quantity'] + 1; ?>)"
                                                class="text-text-gray hover:text-primary transition-colors duration-200 focus:outline-none px-1 text-lg font-bold">+</button>
                                    </div>
                                    
                                    <!-- Subtotal & Remove -->
                                    <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto mt-2 sm:mt-0">
                                        <span class="font-bold text-text-light text-base sm:w-24 text-right">
                                            <?php echo number_format($item['subtotal']); ?>đ
                                        </span>
                                        <button onclick="removeCartItem('<?php echo $item['cart_key']; ?>')"
                                                class="text-text-gray hover:text-primary transition-colors duration-200 p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5"
                                                aria-label="Xóa sản phẩm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="space-y-6">
                    <div class="bg-card border border-border/10 rounded-3xl p-6 sm:p-8 space-y-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Tóm tắt đơn hàng</h2>
                        
                        <div class="space-y-4 text-sm">
                            <div class="flex justify-between text-text-gray">
                                <span>Tạm tính</span>
                                <span class="text-text-light font-medium" id="summarySubtotal"><?php echo number_format($cartTotal); ?>đ</span>
                            </div>
                            <div class="flex justify-between text-text-gray">
                                <span>Phí giao hàng</span>
                                <span class="text-primary-light font-semibold">Miễn phí</span>
                            </div>
                            <div class="h-px bg-border/10 pt-2"></div>
                            <div class="flex justify-between text-base font-bold pt-2">
                                <span class="text-text-light">Tổng cộng</span>
                                <span class="text-primary-light text-xl" id="summaryTotal"><?php echo number_format($cartTotal); ?>đ</span>
                            </div>
                        </div>
                        
                        <button onclick="checkout()"
                                class="w-full bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                            <span>TIẾN HÀNH ĐẶT HÀNG</span>
                        </button>
                        
                        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                           class="block text-center text-xs text-text-gray hover:text-primary transition-colors duration-300 pt-2">
                            ← Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // AJAX functions specifically embedded for fallback or integration
    function updateQty(cartKey, newQty) {
        if (newQty < 1) {
            removeCartItem(cartKey);
            return;
        }
        
        const formData = new FormData();
        formData.append('cart_key', cartKey);
        formData.append('quantity', newQty);
        
        fetch('<?php echo BASE_URL; ?>index.php?controller=cart&action=update', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload page or update dynamically
                location.reload();
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Đã xảy ra lỗi khi cập nhật giỏ hàng', 'error');
        });
    }

    function removeCartItem(cartKey) {
        const formData = new FormData();
        formData.append('cart_key', cartKey);
        
        fetch('<?php echo BASE_URL; ?>index.php?controller=cart&action=remove', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Đã xảy ra lỗi khi xóa sản phẩm', 'error');
        });
    }

    function checkout() {
        location.href = '<?php echo BASE_URL; ?>index.php?controller=order&action=checkout';
    }
</script>
