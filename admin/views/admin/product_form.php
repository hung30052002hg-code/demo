<?php
$isEdit = isset($product) && !empty($product);
$actionUrl = $isEdit 
    ? $adminUrl . 'action=editproduct&id=' . $product['id'] 
    : $adminUrl . 'action=addproduct';
?>

<div class="max-w-3xl mx-auto w-full animate-fade-in-up">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-white/5">
        <h1 class="text-2xl font-playfair font-bold text-white">
            <?php echo $isEdit ? 'Sửa Sản Phẩm' : 'Thêm Sản Phẩm Mới'; ?>
        </h1>
        <a href="<?php echo $adminUrl; ?>action=products" 
           class="text-xs text-text-gray hover:text-white transition-colors duration-300">
            ← Quay lại danh sách
        </a>
    </div>

    <!-- Error Alert -->
    <?php if (!empty($error)): ?>
        <div class="bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-xl p-4 mb-6 flex items-start space-x-2 animate-fade-in">
            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span><?php echo htmlspecialchars($error); ?></span>
        </div>
    <?php endif; ?>

    <!-- Form Container -->
    <div class="bg-card border border-white/5 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden">
        <form action="<?php echo $actionUrl; ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Product Name -->
            <div class="space-y-2">
                <label for="name" class="text-xs font-semibold text-text-light uppercase tracking-wider">Tên sản phẩm *</label>
                <input type="text" name="name" id="name" required 
                       value="<?php echo $isEdit ? htmlspecialchars($product['name']) : ''; ?>"
                       placeholder="Nhập tên sản phẩm..."
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Select -->
                <div class="space-y-2">
                    <label for="category_id" class="text-xs font-semibold text-text-light uppercase tracking-wider">Danh mục *</label>
                    <select name="category_id" id="category_id" required
                            class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                    <?php echo ($isEdit && $product['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['icon'] . ' ' . $cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price Size M -->
                <div class="space-y-2">
                    <label for="price" class="text-xs font-semibold text-text-light uppercase tracking-wider">Giá Size M (VND) *</label>
                    <input type="number" name="price" id="price" required min="0" step="1000"
                           value="<?php echo $isEdit ? htmlspecialchars($product['price']) : ''; ?>"
                           placeholder="Ví dụ: 45000"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price Size L -->
                <div class="space-y-2">
                    <label for="price_large" class="text-xs font-semibold text-text-light uppercase tracking-wider">Giá Size L (VND)</label>
                    <input type="number" name="price_large" id="price_large" min="0" step="1000"
                           value="<?php echo $isEdit ? htmlspecialchars($product['price_large']) : ''; ?>"
                           placeholder="Bỏ trống = Giá M + 10k"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>

                <!-- Switches (Featured & New) -->
                <div class="flex items-center gap-8 pt-4">
                    <!-- Featured -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="sr-only peer"
                               <?php echo ($isEdit && $product['is_featured'] == 1) ? 'checked' : ''; ?>>
                        <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary relative"></div>
                        <span class="text-xs font-semibold text-text-light uppercase tracking-wider">Nổi bật</span>
                    </label>

                    <!-- New -->
                    <label class="flex items-center space-x-3 cursor-pointer">
                        <input type="checkbox" name="is_new" value="1" class="sr-only peer"
                               <?php echo ($isEdit && $product['is_new'] == 1) ? 'checked' : ''; ?>>
                        <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary relative"></div>
                        <span class="text-xs font-semibold text-text-light uppercase tracking-wider">MỚI</span>
                    </label>
                </div>
            </div>

            <!-- Product Image -->
            <div class="space-y-2">
                <label for="image" class="text-xs font-semibold text-text-light uppercase tracking-wider block">Hình ảnh sản phẩm</label>
                
                <?php if ($isEdit && !empty($product['image']) && file_exists(ROOT_PATH . 'public/uploads/' . $product['image'])): ?>
                    <div class="flex items-center space-x-4 mb-3">
                        <div class="w-20 h-20 rounded-xl overflow-hidden border border-black/10 flex-shrink-0">
                            <img src="<?php echo BASE_URL . 'public/uploads/' . htmlspecialchars($product['image']); ?>" alt="Current Image" class="w-full h-full object-cover">
                        </div>
                        <div class="text-xs text-text-gray">
                            <span class="block font-semibold">Ảnh hiện tại:</span>
                            <span class="block"><?php echo htmlspecialchars($product['image']); ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                
                <input type="file" name="image" id="image" accept="image/*"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 transition-all duration-300">
                <p class="text-[10px] text-text-gray italic">Hỗ trợ các định dạng: JPG, JPEG, PNG, GIF, WEBP. Dung lượng tối đa: 2MB.</p>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label for="description" class="text-xs font-semibold text-text-light uppercase tracking-wider">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" 
                          placeholder="Mô tả hương vị trà sữa, thành phần, topping đi kèm..."
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300 resize-none"><?php echo $isEdit ? htmlspecialchars($product['description']) : ''; ?></textarea>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-4 pt-4 border-t border-white/5">
                <button type="submit" 
                        class="flex-1 bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center">
                    <?php echo $isEdit ? 'CẬP NHẬT SẢN PHẨM' : 'THÊM MỚI SẢN PHẨM'; ?>
                </button>
                <a href="<?php echo $adminUrl; ?>action=products" 
                   class="px-8 py-4 bg-white/5 border border-white/10 hover:border-white/20 text-white font-semibold rounded-xl hover:bg-white/10 transition-all duration-300 flex items-center justify-center">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>
