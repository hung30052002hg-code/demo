<div class="max-w-7xl mx-auto w-full">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-10 gap-4 animate-fade-in-up">
        <div class="space-y-2">
            <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Trang quản trị</h1>
            <p class="text-3xl font-playfair font-bold text-white">Quản Lý Sản Phẩm</p>
            <div class="w-16 h-1 bg-primary rounded-full"></div>
        </div>
        
        <div class="flex gap-3">
            <a href="<?php echo $adminUrl; ?>action=index" 
               class="px-5 py-3 border border-white/20 hover:border-white/50 text-white text-xs font-bold rounded-xl hover:bg-white/5 transition-all duration-300">
                ← Về Dashboard
            </a>
            <a href="<?php echo $adminUrl; ?>action=addproduct" 
               class="px-5 py-3 bg-primary hover:bg-primary-hover text-white text-xs font-bold rounded-xl transition-all duration-300 hover:shadow-lg hover:shadow-primary/20">
                + Thêm Sản Phẩm Mới
            </a>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-card border border-white/5 rounded-3xl overflow-hidden shadow-2xl animate-fade-in" style="animation-delay: 100ms">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-white/3 text-xs font-bold uppercase tracking-wider text-text-gray">
                        <th class="py-5 px-6">Sản phẩm</th>
                        <th class="py-5 px-6">Danh mục</th>
                        <th class="py-5 px-6">Giá Size M</th>
                        <th class="py-5 px-6">Giá Size L</th>
                        <th class="py-5 px-6 text-center">Nổi bật</th>
                        <th class="py-5 px-6 text-center">Mới</th>
                        <th class="py-5 px-6 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5 text-sm text-text-light">
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="7" class="py-10 text-center text-text-gray">Chưa có sản phẩm nào được đăng bán.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="hover:bg-white/1 transition-colors duration-200">
                                <!-- Name & Image -->
                                 <td class="py-4 px-6 flex items-center gap-3">
                                     <div class="w-10 h-10 bg-white/5 border border-white/10 rounded-lg flex items-center justify-center text-xl flex-shrink-0 overflow-hidden">
                                         <?php if (!empty($product['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $product['image'])): ?>
                                             <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($product['image']); ?>" class="w-full h-full object-cover">
                                         <?php else: ?>
                                             🧋
                                         <?php endif; ?>
                                     </div>
                                     <span class="font-semibold text-white"><?php echo htmlspecialchars($product['name']); ?></span>
                                 </td>
                                
                                <!-- Category -->
                                <td class="py-4 px-6">
                                    <span class="text-xs bg-white/5 border border-white/10 rounded-full px-2.5 py-1 text-text-gray font-medium">
                                        <?php echo htmlspecialchars($product['category_name'] ?? 'Chưa phân loại'); ?>
                                    </span>
                                </td>
                                
                                <!-- Price Size M -->
                                <td class="py-4 px-6 font-semibold text-primary-light">
                                    <?php echo number_format($product['price']); ?>đ
                                </td>
                                
                                <!-- Price Size L -->
                                <td class="py-4 px-6 font-semibold text-primary-light">
                                    <?php echo number_format($product['price_large']); ?>đ
                                </td>
                                
                                <!-- Featured -->
                                <td class="py-4 px-6 text-center">
                                    <?php if ($product['is_featured'] == 1): ?>
                                        <span class="inline-flex w-2.5 h-2.5 rounded-full bg-primary animate-pulse shadow-md shadow-primary/50" title="Sản phẩm nổi bật"></span>
                                    <?php else: ?>
                                        <span class="inline-flex w-2.5 h-2.5 rounded-full bg-white/10" title="Không nổi bật"></span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- New -->
                                <td class="py-4 px-6 text-center">
                                    <?php if ($product['is_new'] == 1): ?>
                                        <span class="text-[10px] bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-bold px-2 py-0.5 rounded-full">NEW</span>
                                    <?php else: ?>
                                        <span class="text-[10px] text-text-gray font-medium">-</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Actions -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex justify-end items-center gap-3">
                                        <!-- Edit button -->
                                        <a href="<?php echo $adminUrl; ?>action=editproduct&id=<?php echo $product['id']; ?>" 
                                           class="text-xs text-text-gray hover:text-white transition-colors duration-200">
                                            Sửa
                                        </a>
                                        <span class="text-white/10">|</span>
                                        <!-- Delete button / form -->
                                        <form action="<?php echo $adminUrl; ?>action=deleteproduct" method="POST" 
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không? Hành động này không thể hoàn tác.');"
                                              class="inline-block">
                                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                                            <button type="submit" class="text-xs text-primary hover:text-primary-light transition-colors duration-200 focus:outline-none">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
