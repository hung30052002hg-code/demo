<!-- Hero Section with Slider Carousel -->
<section class="relative min-h-[90vh] flex items-center overflow-hidden py-20 px-4 sm:px-6 lg:px-8 bg-black">
    <!-- Slider Backgrounds -->
    <div id="hero-slider" class="absolute inset-0 z-0">
        <!-- Slide 1: Matcha -->
        <div class="hero-slide active absolute inset-0 bg-gradient-to-br from-neutral-950 via-green-950/20 to-neutral-950" data-slide="0">
            <div class="absolute inset-0 bg-gradient-to-b from-primary/10 via-transparent to-transparent"></div>
        </div>
        <!-- Slide 2: Oolong -->
        <div class="hero-slide absolute inset-0 bg-gradient-to-br from-neutral-950 via-amber-950/20 to-neutral-950" data-slide="1">
            <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 via-transparent to-transparent"></div>
        </div>
        <!-- Slide 3: Fruit Tea -->
        <div class="hero-slide absolute inset-0 bg-gradient-to-br from-neutral-950 via-orange-950/20 to-neutral-950" data-slide="2">
            <div class="absolute inset-0 bg-gradient-to-b from-orange-500/5 via-transparent to-transparent"></div>
        </div>
    </div>
    
    <!-- Animated Bubbles Background (Glassmorphism effect) -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="bubble bubble-1 absolute w-32 h-32 rounded-full bg-primary/5 border border-primary/20 blur-sm top-[20%] left-[10%] animate-float"></div>
        <div class="bubble bubble-2 absolute w-48 h-48 rounded-full bg-primary/3 border border-primary/10 blur-md top-[50%] right-[15%] animate-float-delayed"></div>
    </div>

    <div class="max-w-7xl mx-auto w-full relative z-10">
        
        <!-- Slide Content 1: Matcha -->
        <div class="hero-content-item active grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" data-content="0">
            <!-- Text Content -->
            <div class="text-left space-y-6 lg:max-w-xl animate-fade-in-up">
                <div class="inline-flex items-center space-x-2 bg-primary/10 border border-primary/20 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider text-primary uppercase">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                    </span>
                    <span>Premium Quality</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-playfair font-bold leading-tight tracking-tight text-white">
                    Trà Sữa <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary via-primary-light to-primary-hover">Thượng Hạng</span>
                </h1>
                
                <p class="text-neutral-300 text-base sm:text-lg leading-relaxed">
                    Nơi hương vị thượng hạng gặp gỡ nghệ thuật pha chế tinh tế. Khám phá bộ sưu tập trà sữa độc quyền chuẩn vị Starbucks, được chế biến từ những lá trà chọn lọc và sữa tươi nguyên chất.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                       class="px-8 py-4 bg-primary hover:bg-primary-hover text-white font-semibold rounded-full shadow-lg shadow-primary/25 hover:shadow-primary/40 transform hover:-translate-y-0.5 transition-all duration-300">
                        Khám Phá Ngay
                    </a>
                    <a href="#featured-section" 
                       class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/50 text-white font-semibold rounded-full hover:bg-white/5 transition-all duration-300">
                        Xem Sản Phẩm
                    </a>
                </div>
            </div>
            
            <!-- Feature Visual -->
            <div class="relative flex justify-center items-center lg:justify-end">
                <div class="relative w-72 sm:w-80 h-72 sm:h-80 lg:w-[400px] lg:h-[400px] rounded-full bg-gradient-to-tr from-primary/10 to-transparent flex items-center justify-center border border-white/5 shadow-2xl">
                    <div class="absolute w-[80%] h-[80%] rounded-full border border-primary/20 border-dashed animate-[spin_60s_linear_infinite]"></div>
                    <img src="<?php echo BASE_URL; ?>public/images/hero_bubble_tea.png" 
                         alt="CHUS TEA Premium Bubble Tea" 
                         class="w-[75%] h-[75%] object-cover rounded-full border border-white/10 filter drop-shadow-[0_15px_30px_rgba(78,125,86,0.2)] animate-bounce-subtle z-10 cursor-pointer">
                    
                    <div class="absolute -top-4 -right-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🏆</span>
                        <span class="text-xs font-semibold">Best Seller</span>
                    </div>
                    <div class="absolute -bottom-4 -left-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🌿</span>
                        <span class="text-xs font-semibold">100% Organic</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide Content 2: Oolong Caramel -->
        <div class="hero-content-item grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" data-content="1">
            <div class="text-left space-y-6 lg:max-w-xl">
                <div class="inline-flex items-center space-x-2 bg-amber-500/10 border border-amber-500/20 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider text-amber-500 uppercase">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                    </span>
                    <span>Sweet & Creamy</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-playfair font-bold leading-tight tracking-tight text-white">
                    Trà Sữa Oolong <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 via-amber-400 to-amber-600">Caramel Cháy</span>
                </h1>
                
                <p class="text-neutral-300 text-base sm:text-lg leading-relaxed">
                    Hương vị oolong rang đặc trưng hòa quyện hoàn hảo cùng vị ngọt béo ngậy của sốt caramel đun thủ công. Món trà sữa mang hương vị ấm áp cho ngày mới năng động.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=5" 
                       class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-full shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 transform hover:-translate-y-0.5 transition-all duration-300">
                        Đặt Mua Ngay
                    </a>
                    <a href="#featured-section" 
                       class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/50 text-white font-semibold rounded-full hover:bg-white/5 transition-all duration-300">
                        Xem Sản Phẩm
                    </a>
                </div>
            </div>
            
            <div class="relative flex justify-center items-center lg:justify-end">
                <div class="relative w-72 sm:w-80 h-72 sm:h-80 lg:w-[400px] lg:h-[400px] rounded-full bg-gradient-to-tr from-amber-500/10 to-transparent flex items-center justify-center border border-white/5 shadow-2xl">
                    <div class="absolute w-[80%] h-[80%] rounded-full border border-amber-500/20 border-dashed animate-[spin_60s_linear_infinite]"></div>
                    <img src="<?php echo BASE_URL; ?>public/uploads/tra_sua_caramel.png" 
                         alt="CHUS TEA Caramel Bubble Tea" 
                         class="w-[75%] h-[75%] object-cover rounded-full border border-white/10 filter drop-shadow-[0_15px_30px_rgba(245,158,11,0.2)] animate-bounce-subtle z-10 cursor-pointer">
                    
                    <div class="absolute -top-4 -right-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🔥</span>
                        <span class="text-xs font-semibold">Caramelized</span>
                    </div>
                    <div class="absolute -bottom-4 -left-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🍂</span>
                        <span class="text-xs font-semibold">Oolong Tea</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slide Content 3: Tra Dao Cam Sa -->
        <div class="hero-content-item grid grid-cols-1 lg:grid-cols-2 gap-12 items-center" data-content="2">
            <div class="text-left space-y-6 lg:max-w-xl">
                <div class="inline-flex items-center space-x-2 bg-orange-500/10 border border-orange-500/20 px-4 py-1.5 rounded-full text-xs font-semibold tracking-wider text-orange-500 uppercase">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                    </span>
                    <span>Fresh & Citrus</span>
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-playfair font-bold leading-tight tracking-tight text-white">
                    Trà Đào Cam Sả <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 via-orange-400 to-orange-600">Thanh Mát Tự Nhiên</span>
                </h1>
                
                <p class="text-neutral-300 text-base sm:text-lg leading-relaxed">
                    Sự bùng nổ hương vị thanh mát tự nhiên từ đào chín mọng, cam vàng ngọt chua và sả thơm nồng ấm. Thức uống tuyệt vời giúp sảng khoái tức thì trong những ngày hè.
                </p>
                
                <div class="flex flex-wrap gap-4 pt-4">
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=11" 
                       class="px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-full shadow-lg shadow-orange-500/25 hover:shadow-orange-500/40 transform hover:-translate-y-0.5 transition-all duration-300">
                        Đặt Mua Ngay
                    </a>
                    <a href="#featured-section" 
                       class="px-8 py-4 bg-transparent border border-white/20 hover:border-white/50 text-white font-semibold rounded-full hover:bg-white/5 transition-all duration-300">
                        Xem Sản Phẩm
                    </a>
                </div>
            </div>
            
            <div class="relative flex justify-center items-center lg:justify-end">
                <div class="relative w-72 sm:w-80 h-72 sm:h-80 lg:w-[400px] lg:h-[400px] rounded-full bg-gradient-to-tr from-orange-500/10 to-transparent flex items-center justify-center border border-white/5 shadow-2xl">
                    <div class="absolute w-[80%] h-[80%] rounded-full border border-orange-500/20 border-dashed animate-[spin_60s_linear_infinite]"></div>
                    <img src="<?php echo BASE_URL; ?>public/uploads/tra_dao_cam_sa.png" 
                         alt="CHUS TEA Peach Tea" 
                         class="w-[75%] h-[75%] object-cover rounded-full border border-white/10 filter drop-shadow-[0_15px_30px_rgba(249,115,22,0.2)] animate-bounce-subtle z-10 cursor-pointer">
                    
                    <div class="absolute -top-4 -right-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🍊</span>
                        <span class="text-xs font-semibold">Fresh Fruit</span>
                    </div>
                    <div class="absolute -bottom-4 -left-2 bg-card border border-white/10 px-4 py-2 rounded-2xl flex items-center space-x-2 shadow-lg backdrop-blur-md">
                        <span class="text-xl">🌿</span>
                        <span class="text-xs font-semibold">Real Ingredients</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Navigation Arrows -->
    <button id="prevSlide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-primary hover:border-primary text-white flex items-center justify-center transition-all duration-300 focus:outline-none hidden sm:flex">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    </button>
    <button id="nextSlide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-white/5 border border-white/10 hover:bg-primary hover:border-primary text-white flex items-center justify-center transition-all duration-300 focus:outline-none hidden sm:flex">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </button>

    <!-- Indicators -->
    <div class="absolute bottom-20 left-1/2 -translate-x-1/2 z-20 flex space-x-3">
        <button class="slide-indicator w-8 h-2 rounded-full bg-primary transition-all duration-300 focus:outline-none" data-to="0"></button>
        <button class="slide-indicator w-3 h-2 rounded-full bg-white/20 hover:bg-white/50 transition-all duration-300 focus:outline-none" data-to="1"></button>
        <button class="slide-indicator w-3 h-2 rounded-full bg-white/20 hover:bg-white/50 transition-all duration-300 focus:outline-none" data-to="2"></button>
    </div>
    
    <!-- Wave separator -->
    <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden leading-none z-0">
        <svg class="relative block w-full h-[60px]" fill="none" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C26.9,8.75,57.05,18.3,94.93,25.8,176.62,41.89,248.5,67.66,321.39,56.44Z" class="fill-[#FBF9F6] dark:fill-neutral-900 transition-colors duration-300"></path>
        </svg>
    </div>
</section>

<!-- Category Navigation Grid -->
<section class="py-16 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">
    <div class="text-center space-y-4 mb-12" data-animate="fade-in-up">
        <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Menu Signature</h2>
        <p class="text-3xl font-playfair font-bold text-text-light">Danh Mục Trà Sữa</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
        <?php foreach ($categories as $index => $category): ?>
            <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index&category_id=<?php echo $category['id']; ?>" 
               class="group relative bg-card border border-white/5 rounded-2xl p-6 text-center hover:border-primary/20 transition-all duration-300 hover:shadow-[0_10px_30px_rgba(220,38,38,0.15)] flex flex-col items-center gap-3 overflow-hidden"
               data-animate="fade-in" style="animation-delay: <?php echo $index * 50; ?>ms">
                <!-- Hover Glow -->
                <div class="absolute inset-0 bg-gradient-to-b from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                <span class="text-4xl group-hover:scale-110 transition-transform duration-300 relative z-10"><?php echo htmlspecialchars($category['icon']); ?></span>
                <h3 class="font-medium text-sm text-text-light group-hover:text-white transition-colors duration-300 relative z-10"><?php echo htmlspecialchars($category['name']); ?></h3>
                <span class="text-[10px] text-text-gray group-hover:text-primary transition-colors duration-300 relative z-10">Khám Phá →</span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured-section" class="py-20 bg-surface border-y border-border/10 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div class="space-y-4" data-animate="fade-in-up">
                <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Trải nghiệm thượng hạng</h2>
                <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">Sản Phẩm Nổi Bật</p>
                <div class="w-16 h-1 bg-primary rounded-full"></div>
            </div>
            <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
               class="inline-flex items-center space-x-2 text-sm font-semibold text-primary hover:text-primary-light transition-colors duration-300"
               data-animate="fade-in">
                <span>Xem tất cả thực đơn</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <?php foreach ($featuredProducts as $index => $product): ?>
                <div class="product-card group bg-card border border-border/10 rounded-2xl overflow-hidden hover:border-primary/20 transition-all duration-500 flex flex-col h-full"
                     data-animate="fade-in-up" style="animation-delay: <?php echo $index * 100; ?>ms">
                    <!-- Image Area -->
                    <div class="relative aspect-square w-full bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent flex items-center justify-center overflow-hidden">
                        <!-- Red Glow Hover -->
                        <div class="absolute inset-0 bg-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        
                        <!-- Product Image -->
                        <?php if (!empty($product['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $product['image'])): ?>
                            <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($product['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out z-10">
                        <?php else: ?>
                            <div class="text-7xl group-hover:scale-110 transition-transform duration-500 ease-out filter drop-shadow-md z-10 cursor-pointer">
                                🧋
                            </div>
                        <?php endif; ?>
                        
                        <!-- Tags -->
                        <?php if (isset($product['is_new']) && $product['is_new'] == 1): ?>
                            <span class="absolute top-4 left-4 bg-primary text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-lg">New</span>
                        <?php endif; ?>
                        
                        <!-- Quick View Overlay -->
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                            <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>" 
                               class="px-5 py-2.5 bg-white text-black font-semibold rounded-full text-xs hover:bg-primary hover:text-white transition-all duration-300 shadow-xl transform translate-y-4 group-hover:translate-y-0">
                                Xem Chi Tiết
                            </a>
                        </div>
                    </div>
                    
                    <!-- Content Area -->
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex-grow space-y-2">
                            <span class="text-[10px] text-primary uppercase font-bold tracking-wider"><?php echo htmlspecialchars($product['category_name']); ?></span>
                            <h3 class="font-playfair font-bold text-text-light text-lg group-hover:text-primary transition-colors duration-300">
                                <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>">
                                    <?php echo htmlspecialchars($product['name']); ?>
                                </a>
                            </h3>
                            <p class="text-text-gray text-xs line-clamp-2 leading-relaxed">
                                <?php echo htmlspecialchars($product['description'] ?? 'Hương vị trà sữa premium nguyên chất thơm ngon khó cưỡng.'); ?>
                            </p>
                        </div>
                        
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-border/10">
                            <span class="font-bold text-lg text-primary-light">
                                <?php echo number_format($product['price']); ?>đ
                            </span>
                            <button onclick="addToCart(<?php echo $product['id']; ?>, 1, 'M')"
                                    class="relative z-10 p-2.5 bg-black/5 dark:bg-white/5 hover:bg-primary text-text-light hover:text-white border border-border/20 hover:border-primary rounded-full transition-all duration-300 flex items-center justify-center"
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
</section>

<!-- Brand Philosophy Showcase -->
<section id="about-section" class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <!-- Visual Column -->
        <div class="relative" data-animate="fade-in">
            <div class="relative w-full h-[350px] sm:h-[450px] border border-border/10 rounded-3xl overflow-hidden flex items-center justify-center shadow-xl">
                <img src="<?php echo BASE_URL; ?>public/images/about_tea_leaves.png" 
                     alt="CHUS TEA Fresh Tea Leaves" 
                     class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-700 ease-out">
                <!-- Mini card overlay -->
                <div class="absolute bottom-6 right-6 bg-surface border border-border/10 p-6 rounded-2xl max-w-xs shadow-2xl backdrop-blur-md">
                    <p class="text-xs text-text-gray uppercase tracking-wider font-bold mb-2">Chất lượng hàng đầu</p>
                    <p class="text-sm text-text-light font-medium leading-relaxed">Chúng tôi cam kết sử dụng 100% lá trà tươi tự nhiên và không dùng hương liệu hóa học.</p>
                </div>
            </div>
        </div>
        
        <!-- Text Column -->
        <div class="space-y-6" data-animate="fade-in-up">
            <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Về chúng tôi</h2>
            <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">Nghệ Thuật Trà Sữa Cao Cấp</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
            
            <p class="text-text-gray text-base leading-relaxed">
                Tại CHUS TEA, mỗi ly trà sữa không đơn thuần là một món đồ uống, mà đó là cả một công trình nghệ thuật. Chúng tôi tỉ mỉ nghiên cứu từng công thức, lựa chọn khắt khe từng hạt trân châu, lá trà hữu cơ để mang lại hương vị thượng hạng độc bản.
            </p>
            <p class="text-text-gray text-base leading-relaxed">
                Phong cách tối giản, không gian sang trọng và chất lượng dịch vụ cao cấp là những gì chúng tôi hướng tới để đưa trải nghiệm uống trà sữa của bạn lên một tầm cao mới.
            </p>
            
            <div class="grid grid-cols-3 gap-6 pt-4">
                <div>
                    <p class="text-3xl font-playfair font-bold text-primary">100%</p>
                    <p class="text-xs text-text-gray uppercase font-semibold tracking-wider mt-1">Tự Nhiên</p>
                </div>
                <div>
                    <p class="text-3xl font-playfair font-bold text-primary">20+</p>
                    <p class="text-xs text-text-gray uppercase font-semibold tracking-wider mt-1">Hương Vị</p>
                </div>
                <div>
                    <p class="text-3xl font-playfair font-bold text-primary">15k+</p>
                    <p class="text-xs text-text-gray uppercase font-semibold tracking-wider mt-1">Khách Hàng</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Cards -->
<section class="py-20 bg-surface border-t border-border/10 relative z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center space-y-4 mb-16" data-animate="fade-in-up">
            <h2 class="text-xs font-bold tracking-widest text-primary uppercase">Giá trị cốt lõi</h2>
            <p class="text-3xl font-playfair font-bold text-text-light">Tại Sao Chọn CHUS TEA?</p>
            <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-card/50 dark:bg-card/10 border border-border/25 p-8 rounded-3xl space-y-4 hover:border-primary/20 transition-all duration-300 hover:shadow-xl group"
                 data-animate="fade-in-up" style="animation-delay: 100ms">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                    🍃
                </div>
                <h3 class="text-lg font-bold text-text-light">Nguyên Liệu Tươi Sạch</h3>
                <p class="text-sm text-text-gray leading-relaxed">
                    Lá trà được thu hoạch thủ công tại các cao nguyên chè nổi tiếng, kết hợp sữa tươi thanh trùng giữ trọn vị béo tự nhiên.
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="bg-card/50 dark:bg-card/10 border border-border/25 p-8 rounded-3xl space-y-4 hover:border-primary/20 transition-all duration-300 hover:shadow-xl group"
                 data-animate="fade-in-up" style="animation-delay: 200ms">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                    🏆
                </div>
                <h3 class="text-lg font-bold text-text-light">Công Thức Độc Quyền</h3>
                <p class="text-sm text-text-gray leading-relaxed">
                    Được phát triển bởi các chuyên gia pha chế hàng đầu, tối ưu lượng đường vừa phải, tốt cho sức khỏe người dùng.
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="bg-card/50 dark:bg-card/10 border border-border/25 p-8 rounded-3xl space-y-4 hover:border-primary/20 transition-all duration-300 hover:shadow-xl group"
                 data-animate="fade-in-up" style="animation-delay: 300ms">
                <div class="w-12 h-12 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-300">
                    🚀
                </div>
                <h3 class="text-lg font-bold text-text-light">Giao Hàng Siêu Tốc</h3>
                <p class="text-sm text-text-gray leading-relaxed">
                    Hệ thống vận chuyển tối ưu giúp đồ uống giao đến tay bạn vẫn giữ nguyên độ lạnh và hương vị thơm ngon ban đầu.
                </p>
            </div>
        </div>
        
    </div>
</section>
