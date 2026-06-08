<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Sản phẩm của bạn</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-white">Danh Sách Yêu Thích</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <!-- Wishlist Products Grid -->
    <div id="wishlistPageContent" class="animate-fade-in">
        <?php if (empty($wishlistItems)): ?>
            <!-- Empty Wishlist State -->
            <div class="bg-card border border-white/5 rounded-3xl p-16 text-center space-y-6 max-w-xl mx-auto">
                <span class="text-7xl inline-block animate-bounce-subtle">❤️</span>
                <h2 class="text-xl font-bold text-white">Danh sách yêu thích đang trống</h2>
                <p class="text-sm text-text-gray">
                    Hãy thả tim những món đồ uống yêu thích của CHUS TEA để lưu giữ và đặt mua nhanh chóng bất cứ lúc nào nhé!
                </p>
                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                   class="inline-block px-8 py-4 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-full shadow-lg shadow-primary/20 transition-all duration-300">
                    Khám Phá Thực Đơn
                </a>
            </div>
        <?php else: ?>
            <!-- Grid list items -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <?php foreach ($wishlistItems as $index => $product): ?>
                    <div class="product-card group bg-card border border-white/5 rounded-2xl overflow-hidden hover:border-primary/20 transition-all duration-500 flex flex-col h-full animate-fade-in-up"
                         id="wishlist-item-<?php echo $product['id']; ?>"
                         style="animation-delay: <?php echo $index * 100; ?>ms">
                        
                        <!-- Image Area -->
                        <div class="relative aspect-square w-full bg-gradient-to-br from-white/3 to-transparent flex items-center justify-center overflow-hidden">
                            <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <?php if (!empty($product['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $product['image'])): ?>
                                <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out z-10">
                            <?php else: ?>
                                <div class="text-7xl group-hover:scale-110 transition-transform duration-500 ease-out filter drop-shadow-md z-10">
                                    🧋
                                </div>
                            <?php endif; ?>
                            
                            <!-- Remove Wishlist Button (Heart Red) -->
                            <button onclick="toggleWishlist(<?php echo $product['id']; ?>)" 
                                    class="absolute top-4 right-4 z-20 w-9 h-9 rounded-full bg-black/50 backdrop-blur-sm border border-white/10 flex items-center justify-center text-red-500 hover:scale-110 hover:bg-black transition-all duration-300"
                                    title="Xóa khỏi yêu thích">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                            </button>

                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
                                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>" 
                                   class="px-5 py-2.5 bg-white text-black font-semibold rounded-full text-xs hover:bg-primary hover:text-white transition-all duration-300 shadow-xl transform translate-y-4 group-hover:translate-y-0">
                                    Xem Chi Tiết
                                </a>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex-grow space-y-2">
                                <span class="text-[10px] text-primary uppercase font-bold tracking-wider"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                                <h3 class="font-playfair font-bold text-white text-base group-hover:text-primary transition-colors duration-300">
                                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </a>
                                </h3>
                                <p class="text-text-gray text-xs line-clamp-2 leading-relaxed">
                                    <?php echo htmlspecialchars($product['description'] ?? 'Hương vị trà sữa ngon tuyệt, thơm ngậy béo bùi.'); ?>
                                </p>
                            </div>
                            
                            <div class="flex items-center justify-between mt-6 pt-4 border-t border-white/5">
                                <span class="font-bold text-base text-primary-light">
                                    <?php echo number_format($product['price']); ?>đ
                                </span>
                                <button onclick="addToCart(<?php echo $product['id']; ?>, 1, 'M')"
                                        class="p-2.5 bg-white/5 hover:bg-primary text-text-light hover:text-white border border-white/10 hover:border-primary rounded-full transition-all duration-300 flex items-center justify-center"
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
        <?php endif; ?>
    </div>
</div>

<script>
    // Hàm xử lý toggle wishlist (AJAX)
    function toggleWishlist(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);

        fetch('<?php echo BASE_URL; ?>index.php?controller=wishlist&action=toggle', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                
                // Xóa thẻ sản phẩm khỏi giao diện với animation
                const itemEl = document.getElementById('wishlist-item-' + productId);
                if (itemEl) {
                    itemEl.style.transform = 'scale(0.8)';
                    itemEl.style.opacity = '0';
                    setTimeout(() => {
                        itemEl.remove();
                        // Nếu hết sản phẩm yêu thích, tải lại trang để hiển thị trạng thái trống
                        const remaining = document.querySelectorAll('[id^="wishlist-item-"]');
                        if (remaining.length === 0) {
                            location.reload();
                        }
                    }, 300);
                }
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('Đã xảy ra lỗi hệ thống.', 'error');
        });
    }
</script>
