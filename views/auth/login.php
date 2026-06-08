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
            <h1 class="text-xl font-bold text-text-light pt-2">Chào mừng trở lại</h1>
            <p class="text-xs text-text-gray">Đăng nhập tài khoản để đặt trà sữa và nhận ưu đãi độc quyền.</p>
        </div>

        <!-- Display Error Message -->
        <?php if (!empty($error)): ?>
            <div class="bg-primary/10 border border-primary/20 text-primary-light text-xs rounded-xl p-4 mb-6 flex items-start space-x-2 animate-fade-in">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span><?php echo htmlspecialchars($error); ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" method="POST" class="space-y-5 relative z-10">
            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="text-xs font-semibold text-text-light uppercase tracking-wider">Địa chỉ Email</label>
                <input type="email" name="email" id="email" required value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
                       placeholder="yourname@gmail.com"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3.5 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <label for="password" class="text-xs font-semibold text-text-light uppercase tracking-wider">Mật khẩu</label>
                    <a href="#" class="text-xs text-text-gray hover:text-primary transition-colors duration-300">Quên mật khẩu?</a>
                </div>
                <input type="password" name="password" id="password" required placeholder="••••••••"
                       class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-xl px-4 py-3.5 text-sm text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-primary hover:bg-primary-hover text-white font-semibold rounded-xl py-4 transition-all duration-300 hover:shadow-lg hover:shadow-primary/20 transform hover:-translate-y-0.5 mt-2 flex items-center justify-center">
                ĐĂNG NHẬP
            </button>
        </form>

        <!-- Divider -->
        <div class="relative flex items-center justify-center my-8 z-10">
            <div class="absolute w-full border-t border-border/10"></div>
            <span class="relative bg-card px-4 text-xs text-text-gray uppercase tracking-widest">Hoặc</span>
        </div>

        <!-- Social Login UI (Visual only) -->
        <div class="grid grid-cols-2 gap-4 relative z-10">
            <button type="button" class="flex items-center justify-center space-x-2 py-3 border border-border/20 hover:border-primary/30 bg-black/5 dark:bg-white/5 rounded-xl hover:bg-black/10 dark:hover:bg-white/10 text-xs font-medium text-text-light transition-all duration-300">
                <span>Google</span>
            </button>
            <button type="button" class="flex items-center justify-center space-x-2 py-3 border border-border/20 hover:border-primary/30 bg-black/5 dark:bg-white/5 rounded-xl hover:bg-black/10 dark:hover:bg-white/10 text-xs font-medium text-text-light transition-all duration-300">
                <span>Facebook</span>
            </button>
        </div>

        <!-- Switch to Register -->
        <div class="text-center pt-8 text-xs text-text-gray relative z-10">
            <span>Chưa có tài khoản? </span>
            <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=register" class="text-primary hover:text-primary-light font-semibold underline transition-colors duration-300">Đăng ký ngay</a>
        </div>
    </div>
</div>
