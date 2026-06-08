<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Title & Subtitle -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Cửa hàng trực tuyến</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-text-light">
            <?php 
            if (isset($currentCategory) && $currentCategory) {
                echo htmlspecialchars($currentCategory['name']);
            } elseif (isset($search) && $search) {
                echo 'Kết quả tìm kiếm: "' . htmlspecialchars($search) . '"';
            } else {
                echo 'Thực Đơn Của Chúng Tôi';
            }
            ?>
        </p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <div class="flex flex-col lg:flex-row gap-10">
        <!-- Sidebar - Filter Categories -->
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-8 animate-fade-in">
            <!-- Mobile Horizontal Categories, Desktop Vertical Sidebar List -->
            <div class="bg-card border border-border/10 rounded-3xl p-6 lg:p-8 space-y-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10 hidden lg:block">Danh Mục</h2>
                
                <!-- Category list -->
                <div class="flex flex-row lg:flex-col gap-2 overflow-x-auto lg:overflow-x-visible pb-4 lg:pb-0 scrollbar-none snap-x snap-mandatory">
                    <!-- "Tất cả" Category -->
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                       class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center lg:space-x-3 
                       <?php echo (!isset($_GET['category_id']) || empty($_GET['category_id'])) ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-text-gray hover:text-text-light hover:bg-primary/5'; ?>">
                        <span class="text-lg hidden lg:inline">✨</span>
                        <span>Tất cả sản phẩm</span>
                    </a>

                    <!-- Loop through Categories -->
                    <?php foreach ($categories as $cat): ?>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index&category_id=<?php echo $cat['id']; ?>" 
                           class="snap-start flex-shrink-0 px-5 py-2.5 rounded-xl text-sm font-medium transition-all duration-300 flex items-center lg:space-x-3 
                           <?php echo (isset($_GET['category_id']) && $_GET['category_id'] == $cat['id']) ? 'bg-primary text-white shadow-lg shadow-primary/25' : 'text-text-gray hover:text-text-light hover:bg-primary/5'; ?>">
                            <span class="text-lg"><?php echo htmlspecialchars($cat['icon']); ?></span>
                            <span><?php echo htmlspecialchars($cat['name']); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Filters & Sorting Widget -->
            <div class="bg-card border border-border/10 rounded-3xl p-6 lg:p-8 space-y-6">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-4 border-b border-border/10">Bộ Lọc & Sắp Xếp</h2>
                
                <form action="<?php echo BASE_URL; ?>index.php" method="GET" class="space-y-4">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    <?php if (isset($_GET['category_id'])): ?>
                        <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>">
                    <?php endif; ?>
                    <?php if (isset($search)): ?>
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                    <?php endif; ?>

                    <!-- Sorting -->
                    <div class="space-y-2">
                        <label for="sort_by" class="text-xs font-semibold text-text-light uppercase tracking-wider block">Sắp xếp theo</label>
                        <select name="sort_by" id="sort_by" 
                                class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light focus:outline-none focus:border-primary/50 transition-colors">
                            <option value="" class="bg-surface text-text-light">Mặc định (Mới nhất)</option>
                            <option value="price_asc" <?php echo isset($sort_by) && $sort_by === 'price_asc' ? 'selected' : ''; ?> class="bg-surface text-text-light">Giá: Thấp đến Cao</option>
                            <option value="price_desc" <?php echo isset($sort_by) && $sort_by === 'price_desc' ? 'selected' : ''; ?> class="bg-surface text-text-light">Giá: Cao đến Thấp</option>
                            <option value="best_selling" <?php echo isset($sort_by) && $sort_by === 'best_selling' ? 'selected' : ''; ?> class="bg-surface text-text-light">Bán chạy nhất</option>
                            <option value="rating" <?php echo isset($sort_by) && $sort_by === 'rating' ? 'selected' : ''; ?> class="bg-surface text-text-light">Được đánh giá cao</option>
                        </select>
                    </div>

                    <!-- Price range -->
                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-text-light uppercase tracking-wider block">Khoảng giá (đ)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="min_price" placeholder="Từ" value="<?php echo isset($min_price) ? htmlspecialchars($min_price) : ''; ?>"
                                   class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-3 py-2 text-xs text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                            <span class="text-text-gray text-xs">-</span>
                            <input type="number" name="max_price" placeholder="Đến" value="<?php echo isset($max_price) ? htmlspecialchars($max_price) : ''; ?>"
                                   class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-3 py-2 text-xs text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 transition-colors [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                        </div>
                    </div>

                    <!-- Submit & Clear Buttons -->
                    <div class="pt-2 flex flex-col gap-2">
                        <button type="submit" 
                                class="w-full py-3.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/25">
                            Áp Dụng Bộ Lọc
                        </button>
                        <?php if (isset($min_price) || isset($max_price) || isset($sort_by)): ?>
                            <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index<?php echo isset($_GET['category_id']) ? '&category_id=' . (int)$_GET['category_id'] : ''; ?>" 
                               class="w-full py-3.5 bg-black/5 dark:bg-white/5 hover:bg-primary/10 border border-border/20 text-text-light text-center text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-300">
                                Xóa Bộ Lọc
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Search Widget (Only on desktop) -->
            <div class="bg-card border border-border/10 rounded-3xl p-8 space-y-4 hidden lg:block">
                <h2 class="text-sm font-bold uppercase tracking-wider text-text-light pb-2 border-b border-border/10">Tìm Kiếm</h2>
                <form action="<?php echo BASE_URL; ?>index.php" method="GET" class="relative mt-4">
                    <input type="hidden" name="controller" value="product">
                    <input type="hidden" name="action" value="index">
                    <input type="text" name="search" placeholder="Nhập tên trà sữa..." value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>"
                           class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-gray hover:text-primary transition-colors duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Products Grid Area -->
        <main class="flex-grow space-y-8">
            <!-- Results count & controls -->
            <div class="flex items-center justify-between bg-card border border-border/10 px-6 py-4 rounded-2xl animate-fade-in">
                <p class="text-xs text-text-gray">
                    Hiển thị <span class="text-text-light font-semibold"><?php echo count($products); ?></span> sản phẩm
                </p>
                <!-- Mobile Search Form -->
                <div class="lg:hidden w-48">
                    <form action="<?php echo BASE_URL; ?>index.php" method="GET" class="relative">
                        <input type="hidden" name="controller" value="product">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="search" placeholder="Tìm kiếm..." value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>"
                               class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-3 py-2 text-xs text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 transition-all duration-300">
                    </form>
                </div>
            </div>

            <!-- Grid -->
            <?php if (empty($products)): ?>
                <!-- Empty State -->
                <div class="bg-card border border-border/10 rounded-3xl p-16 text-center space-y-6 animate-fade-in">
                    <span class="text-6xl inline-block animate-[bounce_3s_infinite]">📭</span>
                    <h2 class="text-xl font-bold text-text-light">Không tìm thấy sản phẩm</h2>
                    <p class="text-sm text-text-gray max-w-md mx-auto">
                        Chúng tôi không tìm thấy sản phẩm nào phù hợp với bộ lọc hoặc từ khóa tìm kiếm của bạn. Hãy thử thay đổi từ khóa hoặc bộ lọc khác.
                    </p>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" 
                       class="inline-block px-6 py-3 bg-primary hover:bg-primary-hover text-white text-sm font-semibold rounded-full transition-all duration-300">
                        Đặt lại bộ lọc
                    </a>
                </div>
            <?php else: ?>
                <!-- Product grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                    <?php foreach ($products as $index => $product): ?>
                        <div class="product-card group bg-card border border-border/10 rounded-2xl overflow-hidden hover:border-primary/20 transition-all duration-500 flex flex-col h-full animate-fade-in-up"
                             style="animation-delay: <?php echo ($index % 6) * 100; ?>ms">
                            <!-- Image -->
                            <div class="relative aspect-square bg-gradient-to-br from-black/5 dark:from-white/3 to-transparent flex items-center justify-center overflow-hidden">
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
                                
                                <?php if (isset($product['is_new']) && $product['is_new'] == 1): ?>
                                    <span class="absolute top-4 left-4 bg-primary text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full shadow-lg">New</span>
                                <?php endif; ?>
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-20">
                                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>" 
                                       class="px-5 py-2.5 bg-white text-black font-semibold rounded-full text-xs hover:bg-primary hover:text-white transition-all duration-300 shadow-xl transform translate-y-4 group-hover:translate-y-0">
                                        Xem Chi Tiết
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-6 flex flex-col flex-grow">
                                <div class="flex-grow space-y-2">
                                    <span class="text-[10px] text-primary uppercase font-bold tracking-wider"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                                    <h3 class="font-playfair font-bold text-text-light text-lg group-hover:text-primary transition-colors duration-300">
                                        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=detail&id=<?php echo $product['id']; ?>">
                                            <?php echo htmlspecialchars($product['name']); ?>
                                        </a>
                                    </h3>
                                    <p class="text-text-gray text-xs line-clamp-2 leading-relaxed">
                                        <?php echo htmlspecialchars($product['description'] ?? 'Hương vị trà sữa premium thơm ngon ngọt ngào khó cưỡng.'); ?>
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
            <?php endif; ?>
        </main>
    </div>
</div>
