<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Page Header -->
    <div class="text-center space-y-4 mb-12 animate-fade-in-up">
        <h1 class="text-xs font-bold tracking-widest text-primary uppercase">Kết nối với chúng tôi</h1>
        <p class="text-3xl sm:text-4xl font-playfair font-bold text-white">Liên Hệ & Phản Hồi</p>
        <div class="w-16 h-1 bg-primary mx-auto rounded-full"></div>
    </div>

    <!-- Alert Notifications -->
    <div class="max-w-5xl mx-auto">
        <?php if (!empty($successMsg)): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs rounded-xl p-4 mb-8 flex items-start space-x-2 animate-fade-in">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span><?php echo htmlspecialchars($successMsg); ?></span>
            </div>
        <?php elseif (!empty($errorMsg)): ?>
            <div class="bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-xl p-4 mb-8 flex items-start space-x-2 animate-fade-in">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><?php echo htmlspecialchars($errorMsg); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Contact Grid: Info + Form -->
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-10 max-w-5xl mx-auto items-stretch animate-fade-in-up">
        
        <!-- Left: Contact Details (2 cols) -->
        <div class="lg:col-span-2 bg-card border border-white/5 rounded-3xl p-8 space-y-8 flex flex-col justify-between shadow-xl">
            <div class="space-y-6">
                <h2 class="text-lg font-bold text-white pb-4 border-b border-white/5">Thông Tin Liên Hệ</h2>
                
                <ul class="space-y-6 text-sm text-text-light">
                    <!-- Address -->
                    <li class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-xl flex-shrink-0">
                            📍
                        </div>
                        <div>
                            <span class="block text-xs text-text-gray font-semibold uppercase tracking-wider mb-1">Địa chỉ cửa hàng</span>
                            <span class="text-white leading-relaxed font-medium">Ngõ 33 Xuân Thị Tứ, Minh Hải, Hải Phòng</span>
                        </div>
                    </li>

                    <!-- Phone -->
                    <li class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-xl flex-shrink-0">
                            📞
                        </div>
                        <div>
                            <span class="block text-xs text-text-gray font-semibold uppercase tracking-wider mb-1">Số điện thoại</span>
                            <span class="text-white leading-relaxed font-medium">0904 050 257</span>
                        </div>
                    </li>

                    <!-- Email -->
                    <li class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-xl flex-shrink-0">
                            ✉️
                        </div>
                        <div>
                            <span class="block text-xs text-text-gray font-semibold uppercase tracking-wider mb-1">Hòm thư hỗ trợ</span>
                            <span class="text-white leading-relaxed font-medium">hello@chustea.vn</span>
                        </div>
                    </li>

                    <!-- Opening Hours -->
                    <li class="flex items-start space-x-4">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 border border-primary/20 flex items-center justify-center text-xl flex-shrink-0">
                            ⏰
                        </div>
                        <div>
                            <span class="block text-xs text-text-gray font-semibold uppercase tracking-wider mb-1">Giờ mở cửa</span>
                            <span class="text-white leading-relaxed font-medium">07:00 AM - 10:30 PM (Hằng ngày)</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Footer brand philosophy -->
            <div class="pt-6 border-t border-white/5 text-xs text-text-gray leading-relaxed">
                * Mọi ý kiến đóng góp của quý khách sẽ giúp CHUS TEA cải thiện chất lượng pha chế và dịch vụ phục vụ tốt hơn mỗi ngày.
            </div>
        </div>

        <!-- Right: Feedback Form (3 cols) -->
        <div class="lg:col-span-3 bg-card border border-white/5 rounded-3xl p-8 sm:p-10 shadow-xl">
            <h2 class="text-lg font-bold text-white pb-4 border-b border-white/5 mb-6">Gửi Thư Phản Hồi</h2>
            
            <form action="<?php echo BASE_URL; ?>index.php?controller=contact&action=submit" method="POST" class="space-y-5">
                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="text-xs font-semibold text-text-light uppercase tracking-wider">Họ và tên *</label>
                    <input type="text" name="name" id="name" required placeholder="Nhập họ và tên..."
                           value="<?php echo User::isLoggedIn() ? htmlspecialchars($_SESSION['user_name']) : ''; ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-xs font-semibold text-text-light uppercase tracking-wider">Địa chỉ Email *</label>
                    <input type="email" name="email" id="email" required placeholder="Nhập địa chỉ email..."
                           value="<?php echo User::isLoggedIn() ? htmlspecialchars($_SESSION['user_email']) : ''; ?>"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>

                <!-- Subject -->
                <div class="space-y-2">
                    <label for="subject" class="text-xs font-semibold text-text-light uppercase tracking-wider">Tiêu đề</label>
                    <input type="text" name="subject" id="subject" placeholder="Góp ý sản phẩm, phản ánh dịch vụ..."
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3.5 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                </div>

                <!-- Message -->
                <div class="space-y-2">
                    <label for="message" class="text-xs font-semibold text-text-light uppercase tracking-wider">Nội dung liên hệ *</label>
                    <textarea name="message" id="message" rows="5" required placeholder="Nêu chi tiết nội dung đóng góp ý kiến hoặc phản hồi của bạn..."
                              class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-text-gray focus:outline-none focus:border-primary/50 transition-all duration-300 resize-none"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    <span>GỬI PHẢN HỒI</span>
                </button>
            </form>
        </div>

    </div>
</div>
