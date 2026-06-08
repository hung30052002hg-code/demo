<div class="max-w-md mx-auto px-4 py-20 animate-fade-in-up">
    <!-- Card Container -->
    <div class="bg-card border border-border/10 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
        <!-- Background radial glow -->
        <div class="absolute -top-20 -right-20 w-48 h-48 rounded-full bg-primary/10 blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-48 h-48 rounded-full bg-primary/5 blur-3xl pointer-events-none"></div>

        <!-- Logo/Header -->
        <div class="text-center space-y-3 mb-8 relative z-10">
            <span class="text-3xl font-playfair font-bold">
                <span class="text-primary">CHUS</span> TEA
            </span>
            <h1 class="text-xl font-bold text-text-light pt-2">Đăng ký tài khoản</h1>
            <p class="text-xs text-text-gray">Tạo tài khoản thành viên để tận hưởng nhiều đặc quyền hấp dẫn.</p>
        </div>

        <!-- Display Error/Success Messages -->
        <?php if (!empty($error)): ?>
            <div class="bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-xl p-4 mb-6 flex items-start space-x-2 animate-fade-in">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php elseif (!empty($success)): ?>
            <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs rounded-xl p-4 mb-6 flex items-start space-x-2 animate-fade-in">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span><?php echo htmlspecialchars($success); ?></span>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form action="<?php echo BASE_URL; ?>index.php?controller=auth&action=register" method="POST" class="space-y-4 relative z-10">
            <!-- Full Name -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-semibold text-text-light uppercase tracking-wider">Họ và tên *</label>
                <input type="text" name="name" id="name" required value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>"
                       placeholder="Nguyễn Văn A"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-text-light uppercase tracking-wider">Địa chỉ Email *</label>
                <input type="email" name="email" id="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       placeholder="name@gmail.com"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Phone -->
            <div class="space-y-1.5">
                <label for="phone" class="text-xs font-semibold text-text-light uppercase tracking-wider">Số điện thoại</label>
                <input type="text" name="phone" id="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>"
                       placeholder="0909123456"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-xs font-semibold text-text-light uppercase tracking-wider">Mật khẩu *</label>
                <input type="password" name="password" id="password" required placeholder="Tối thiểu 6 ký tự"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Confirm Password -->
            <div class="space-y-1.5">
                <label for="password_confirm" class="text-xs font-semibold text-text-light uppercase tracking-wider">Xác nhận mật khẩu *</label>
                <input type="password" name="password_confirm" id="password_confirm" required placeholder="Nhập lại mật khẩu"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 mt-4 flex items-center justify-center">
                ĐĂNG KÝ NGAY
            </button>
        </form>

        <!-- Switch to Login -->
        <div class="text-center pt-8 text-xs text-text-gray relative z-10 border-t border-border/10 mt-6">
            <span>Đã có tài khoản? </span>
            <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" class="text-primary hover:text-primary-light font-semibold underline transition-colors duration-300">Đăng nhập</a>
        </div>
    </div>
</div>
