<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Breadcrumb -->
    <nav class="flex text-xs text-text-gray mb-10 space-x-2 animate-fade-in">
        <a href="<?php echo BASE_URL; ?>index.php" class="hover:text-primary transition-colors duration-300">Trang Chủ</a>
        <span>/</span>
        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" class="hover:text-primary transition-colors duration-300">Thực Đơn</a>
        <span>/</span>
        <span class="text-text-light font-medium"><?php echo htmlspecialchars($product['name']); ?></span>
    </nav>

    <!-- Product Details Card -->
    <div class="bg-card border border-border/10 rounded-3xl p-6 sm:p-8 lg:p-12 mb-16 animate-fade-in-up">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            
            <!-- Left: Product Image Showcase -->
            <div class="relative w-full aspect-square max-w-md mx-auto bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent border border-border/20 rounded-2xl flex items-center justify-center overflow-hidden">
                <!-- Hover/Glow effect -->
                <div class="absolute inset-0 bg-primary/5"></div>
                
                <!-- Product Image -->
                <?php if (!empty($product['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $product['image'])): ?>
                    <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($product['image']); ?>" 
                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                         class="w-full h-full object-cover z-10 animate-fade-in">
                <?php else: ?>
                    <div class="text-[10rem] sm:text-[12rem] filter drop-shadow-[0_20px_30px_rgba(78,125,86,0.3)] animate-bounce-subtle z-10">
                        🧋
                    </div>
                <?php endif; ?>
                
                <?php if (isset($product['is_new']) && $product['is_new'] == 1): ?>
                    <span class="absolute top-6 left-6 bg-primary text-white text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full shadow-lg">New</span>
                <?php endif; ?>
            </div>

            <!-- Right: Product Info -->
            <div class="space-y-6">
                <div class="space-y-3">
                    <span class="text-xs text-primary uppercase font-bold tracking-widest"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                    <h1 class="text-3xl sm:text-4xl font-playfair font-bold text-text-light"><?php echo htmlspecialchars($product['name']); ?></h1>
                    
                    <!-- Dynamic Price Display -->
                    <div class="text-2xl sm:text-3xl font-bold text-primary-light pt-2" id="detailPrice" 
                         data-price-m="<?php echo $product['price']; ?>" 
                         data-price-l="<?php echo $product['price_large']; ?>">
                        <?php echo number_format($product['price']); ?>đ
                    </div>
                </div>

                <p class="text-text-gray text-sm sm:text-base leading-relaxed pb-4 border-b border-border/10">
                    <?php echo htmlspecialchars($product['description'] ?? 'Hương vị trà sữa premium được chế biến từ những lá trà chọn lọc thủ công, kết hợp công thức pha chế đặc biệt độc quyền để đem lại hương vị đậm đà và trải nghiệm tinh tế nhất.'); ?>
                </p>

                <!-- Size Selector -->
                <div class="space-y-3">
                    <span class="text-xs font-bold text-text-light uppercase tracking-wider">Kích Cỡ</span>
                    <div class="flex gap-4">
                        <!-- Size M -->
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="size" value="M" checked class="sr-only peer" id="sizeM">
                            <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary/5 rounded-xl p-4 text-center hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300">
                                <span class="block text-sm font-bold text-text-light">Size M</span>
                                <span class="block text-xs text-text-gray mt-1"><?php echo number_format($product['price']); ?>đ</span>
                            </div>
                        </label>
                        <!-- Size L -->
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="size" value="L" class="sr-only peer" id="sizeL">
                            <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary/5 rounded-xl p-4 text-center hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300">
                                <span class="block text-sm font-bold text-text-light">Size L</span>
                                <span class="block text-xs text-text-gray mt-1"><?php echo number_format($product['price_large']); ?>đ</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Sugar Selector -->
                <div class="space-y-3">
                    <span class="text-xs font-bold text-text-light uppercase tracking-wider block">Mức Đường</span>
                    <div class="grid grid-cols-5 gap-2">
                        <?php foreach (['100%', '70%', '50%', '30%', '0%'] as $sLevel): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="sugar" value="<?php echo $sLevel; ?>" <?php echo $sLevel === '100%' ? 'checked' : ''; ?> class="sr-only peer">
                                <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white rounded-xl py-2 text-center text-xs font-semibold text-text-gray hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300">
                                    <?php echo $sLevel; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Ice Selector -->
                <div class="space-y-3">
                    <span class="text-xs font-bold text-text-light uppercase tracking-wider block">Mức Đá</span>
                    <div class="grid grid-cols-4 gap-2">
                        <?php foreach (['100%', '70%', '50%', '0%'] as $iLevel): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="ice" value="<?php echo $iLevel; ?>" <?php echo $iLevel === '100%' ? 'checked' : ''; ?> class="sr-only peer">
                                <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white rounded-xl py-2 text-center text-xs font-semibold text-text-gray hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300">
                                    <?php echo $iLevel === '0%' ? 'Không đá' : $iLevel . ' đá'; ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Toppings Selector (Only show if not Category 6) -->
                <?php if (isset($product['category_id']) && $product['category_id'] != 6 && !empty($toppings)): ?>
                    <div class="space-y-3">
                        <span class="text-xs font-bold text-text-light uppercase tracking-wider block">Thêm Topping</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <?php foreach ($toppings as $top): ?>
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="toppings[]" value="<?php echo $top['id']; ?>" data-price="<?php echo $top['price']; ?>" class="sr-only peer topping-checkbox">
                                    <div class="bg-black/5 dark:bg-white/3 border border-border/20 peer-checked:border-primary peer-checked:bg-primary peer-checked:text-white rounded-xl p-3 text-center hover:bg-black/10 dark:hover:bg-white/5 transition-all duration-300 flex flex-col justify-center items-center h-full">
                                        <span class="block text-xs font-bold leading-tight"><?php echo htmlspecialchars($top['name']); ?></span>
                                        <span class="block text-[10px] text-primary-light peer-checked:text-white mt-1">+<?php echo number_format($top['price']); ?>đ</span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Quantity & Add to Cart -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <!-- Quantity Selector -->
                    <div class="flex items-center bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 sm:w-36 justify-between">
                        <button id="btnMinus" class="text-text-gray hover:text-primary transition-colors duration-200 focus:outline-none px-2 text-xl font-bold">-</button>
                        <input type="number" id="detailQty" value="1" min="1" class="w-12 text-center bg-transparent border-none text-text-light font-semibold focus:outline-none focus:ring-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        <button id="btnPlus" class="text-text-gray hover:text-primary transition-colors duration-200 focus:outline-none px-2 text-xl font-bold">+</button>
                    </div>

                    <!-- Add Button -->
                    <button onclick="triggerAddToCart(<?php echo $product['id']; ?>)"
                            class="flex-1 bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Thêm Vào Giỏ Hàng</span>
                    </button>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Related Products -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="space-y-8 animate-fade-in">
            <div class="space-y-4">
                <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Menu liên quan</h2>
                <p class="text-2xl font-playfair font-bold text-text-light">Sản Phẩm Tương Tự</p>
                <div class="w-16 h-1 bg-primary rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php foreach ($relatedProducts as $index => $relProduct): ?>
                    <div class="product-card group bg-card border border-border/10 rounded-2xl overflow-hidden hover:border-primary/20 transition-all duration-500 flex flex-col h-full"
                         style="animation-delay: <?php echo $index * 100; ?>ms">
                        <!-- Image -->
                        <div class="relative aspect-square bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <?php if (!empty($relProduct['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $relProduct['image'])): ?>
                                <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($relProduct['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($relProduct['name']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out z-10">
                            <?php else: ?>
                                <div class="text-7xl group-hover:scale-110 transition-transform duration-500 ease-out filter drop-shadow-md z-10">
                                    🧋
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $relProduct['id']; ?>" 
                                   class="px-5 py-2.5 bg-white text-black font-semibold rounded-full text-xs hover:bg-primary hover:text-white transition-all duration-300 shadow-xl transform translate-y-4 group-hover:translate-y-0">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow space-y-2">
                                <span class="text-[10px] text-primary uppercase font-bold tracking-wider"><?php echo htmlspecialchars($relProduct['category_name'] ?? ''); ?></span>
                                <h3 class="font-playfair font-bold text-text-light text-base group-hover:text-primary transition-colors duration-300">
                                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $relProduct['id']; ?>">
                                        <?php echo htmlspecialchars($relProduct['name']); ?>
                                    </a>
                                </h3>
                                <p class="text-text-gray text-xs line-clamp-2 leading-relaxed">
                                    <?php echo htmlspecialchars($relProduct['description'] ?? 'Hương vị trà sữa ngon tuyệt, béo ngậy thanh mát.'); ?>
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-border/10">
                                <span class="font-bold text-base text-primary-light">
                                    <?php echo number_format($relProduct['price']); ?>đ
                                </span>
                                <button onclick="addToCart(<?php echo $relProduct['id']; ?>, 1, 'M')"
                                        class="p-2.5 bg-black/5 dark:bg-white/5 hover:bg-primary text-text-light hover:text-white border border-border/20 hover:border-primary rounded-full transition-all duration-300 flex items-center justify-center"
                                        aria-label="Thêm vào giỏ hàng">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- AI Product Recommendations (Apriori Co-Purchase suggestions) -->
    <?php if (!empty($recommendedProducts)): ?>
        <div class="space-y-8 mt-16 animate-fade-in">
            <div class="space-y-4">
                <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Gợi ý từ AI của cửa hàng</h2>
                <p class="text-2xl font-playfair font-bold text-text-light">Sản Phẩm Thường Được Mua Cùng</p>
                <div class="w-16 h-1 bg-primary rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php foreach ($recommendedProducts as $index => $recProduct): ?>
                    <div class="product-card group bg-card border border-border/10 rounded-2xl overflow-hidden hover:border-primary/20 transition-all duration-500 flex flex-col h-full"
                          style="animation-delay: <?php echo $index * 100; ?>ms">
                        <!-- Image -->
                        <div class="relative aspect-square bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <?php if (!empty($recProduct['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $recProduct['image'])): ?>
                                <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($recProduct['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($recProduct['name']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out z-10">
                            <?php else: ?>
                                <div class="text-7xl group-hover:scale-110 transition-transform duration-500 ease-out filter drop-shadow-md z-10">
                                    🧋
                                </div>
                            <?php endif; ?>
                            
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $recProduct['id']; ?>" 
                                   class="px-5 py-2.5 bg-white text-black font-semibold rounded-full text-xs hover:bg-primary hover:text-white transition-all duration-300 shadow-xl transform translate-y-4 group-hover:translate-y-0">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow space-y-2">
                                <span class="text-[10px] text-primary uppercase font-bold tracking-wider"><?php echo htmlspecialchars($recProduct['category_name'] ?? ''); ?></span>
                                <h3 class="font-playfair font-bold text-text-light text-base group-hover:text-primary transition-colors duration-300">
                                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $recProduct['id']; ?>">
                                        <?php echo htmlspecialchars($recProduct['name']); ?>
                                    </a>
                                </h3>
                                <p class="text-text-gray text-xs line-clamp-2 leading-relaxed">
                                    <?php echo htmlspecialchars($recProduct['description'] ?? 'Gợi ý mua kèm hoàn hảo cho ly nước uống của bạn.'); ?>
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-border/10">
                                <span class="font-bold text-base text-primary-light">
                                    <?php echo number_format($recProduct['price']); ?>đ
                                </span>
                                <button onclick="addToCart(<?php echo $recProduct['id']; ?>, 1, 'M')"
                                        class="p-2.5 bg-black/5 dark:bg-white/5 hover:bg-primary text-text-light hover:text-white border border-border/20 hover:border-primary rounded-full transition-all duration-300 flex items-center justify-center"
                                        aria-label="Thêm vào giỏ hàng">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // JS trigger add to cart from details page
    function triggerAddToCart(productId) {
        const qty = parseInt(document.getElementById('detailQty').value) || 1;
        const size = document.querySelector('input[name="size"]:checked').value || 'M';
        
        const sugarEl = document.querySelector('input[name="sugar"]:checked');
        const sugar = sugarEl ? sugarEl.value : '100%';
        
        const iceEl = document.querySelector('input[name="ice"]:checked');
        const ice = iceEl ? iceEl.value : '100%';
        
        const toppings = [];
        document.querySelectorAll('input[name="toppings[]"]:checked').forEach(cb => {
            toppings.push(parseInt(cb.value));
        });

        // Sử dụng hàm addToCartWithOptions có đầy đủ thông số tùy chỉnh
        addToCartWithOptions(productId, qty, size, ice, sugar, toppings);
    }

    // Tự động tính toán lại đơn giá dựa trên size và topping đã chọn
    function updateDetailPrice() {
        const priceEl = document.getElementById('detailPrice');
        if (!priceEl) return;

        const priceM = parseInt(priceEl.dataset.priceM) || 0;
        const priceL = parseInt(priceEl.dataset.priceL) || 0;
        
        const sizeInput = document.querySelector('input[name="size"]:checked');
        const size = sizeInput ? sizeInput.value : 'M';
        let currentPrice = (size === 'L') ? priceL : priceM;
        
        // Cộng dồn giá của từng topping được check
        document.querySelectorAll('input[name="toppings[]"]:checked').forEach(cb => {
            currentPrice += parseInt(cb.dataset.price) || 0;
        });

        // Cập nhật giao diện tiền tệ VND
        priceEl.textContent = new Intl.NumberFormat('vi-VN').format(currentPrice) + 'đ';
    }

    // Gắn sự kiện thay đổi cho các phần tử để tự động kích hoạt tính tiền
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('input[name="size"]').forEach(radio => {
            radio.addEventListener('change', updateDetailPrice);
        });
        document.querySelectorAll('.topping-checkbox').forEach(cb => {
            cb.addEventListener('change', updateDetailPrice);
        });
        
        // Kích hoạt tính thử lần đầu tiên khi tải trang
        updateDetailPrice();
    });
</script>
