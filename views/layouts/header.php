<?php
if (file_exists(__DIR__ . '/../../models/Cart.php')) {
    require_once __DIR__ . '/../../models/Cart.php';
    $cartModel = new Cart();
    $cartCount = $cartModel->getCount();
} else {
    $cartCount = 0;
}
$userPoints = 0;
if (User::isLoggedIn()) {
    $userModel = new User();
    $currentUser = $userModel->findById($_SESSION['user_id']);
    $userPoints = $currentUser ? (int)$currentUser['points'] : 0;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CHUS TEA - Trà Sữa Premium, hương vị đậm đà, trải nghiệm hoàn hảo">
    <title>CHUS TEA - Trà Sữa Premium</title>
    
    <!-- Script chặn flash theme sáng/tối -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const withOpacity = (varName) => {
            return ({ opacityValue }) => {
                if (opacityValue !== undefined) {
                    return `rgba(var(${varName}), ${opacityValue})`;
                }
                return `rgb(var(${varName}))`;
            };
        };

        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: withOpacity('--primary-rgb'),
                        'primary-hover': withOpacity('--primary-hover-rgb'),
                        'primary-light': withOpacity('--primary-light-rgb'),
                        dark: withOpacity('--bg-dark-rgb'),
                        surface: withOpacity('--surface-rgb'),
                        card: withOpacity('--card-rgb'),
                        border: withOpacity('--border-rgb'),
                        'text-gray': withOpacity('--text-gray-rgb'),
                        'text-light': withOpacity('--text-rgb'),
                    },
                    fontFamily: {
                        playfair: ['"Playfair Display"', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css?v=<?php echo time(); ?>">
</head>
<body class="bg-dark text-text-light font-inter min-h-screen transition-colors duration-300">
 
    <!-- ===== NAVBAR ===== -->
    <nav id="navbar" class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
        <div class="navbar-glass bg-surface/70 backdrop-blur-xl border-b border-border/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 lg:h-20">
                    
                    <!-- Logo -->
                    <a href="<?php echo BASE_URL; ?>index.php" class="flex items-center space-x-1 group">
                        <span class="text-2xl lg:text-3xl font-playfair font-bold tracking-wider">
                            <span class="text-primary group-hover:text-primary-light transition-colors duration-300">CHUS</span>
                            <span class="text-text-light"> TEA</span>
                        </span>
                    </a>
                    
                    <!-- Desktop Navigation -->
                    <div class="hidden lg:flex items-center space-x-1">
                        <a href="<?php echo BASE_URL; ?>index.php" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Trang Chủ
                        </a>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Thực Đơn
                        </a>
                        <a href="<?php echo BASE_URL; ?>index.php#about-section" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Về Chúng Tôi
                        </a>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=contact&action=index" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Liên Hệ
                        </a>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=home&action=stores" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Cửa Hàng
                        </a>
                        <?php if (User::isLoggedIn()): ?>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=order&action=history" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                            Đơn Hàng
                        </a>
                        <?php endif; ?>
                        <?php if (User::isAdmin()): ?>
                        <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=index" class="nav-link px-5 py-2 rounded-full text-sm font-medium text-primary hover:text-primary-light hover:bg-primary/5 transition-all duration-300">
                            Trang Quản Trị
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Right Icons -->
                    <div class="flex items-center space-x-2 lg:space-x-3">
                        
                        <!-- Theme Toggle -->
                        <button id="themeToggle" class="p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300" aria-label="Đổi giao diện">
                            <!-- Sun icon -->
                            <svg class="w-5 h-5 sun-icon text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                            </svg>
                            <!-- Moon icon -->
                            <svg class="w-5 h-5 moon-icon text-gray-600 hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                            </svg>
                        </button>
                        
                        <!-- Search Toggle -->
                        <button id="searchToggle" class="p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300" aria-label="Tìm kiếm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        
                        <!-- Wishlist -->
                        <?php if (User::isLoggedIn()): ?>
                            <?php 
                             $wishlistModel = new Wishlist();
                             $wishCount = count($wishlistModel->getByUserId($_SESSION['user_id']));
                            ?>
                            <a href="<?php echo BASE_URL; ?>index.php?controller=wishlist&action=index" class="relative p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300 group" aria-label="Yêu thích">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300 text-red-500 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                <span id="wishlistBadge" class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-primary text-white text-[9px] font-bold rounded-full flex items-center justify-center transition-all duration-300 <?php echo $wishCount > 0 ? 'scale-100' : 'scale-0'; ?>">
                                    <?php echo $wishCount; ?>
                                </span>
                            </a>
                        <?php endif; ?>
 
                        <!-- Cart -->
                        <a href="<?php echo BASE_URL; ?>index.php?controller=cart&action=index" class="relative p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300 group" aria-label="Giỏ hàng">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span id="cartBadge" class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-primary text-white text-[10px] font-bold rounded-full flex items-center justify-center transition-all duration-300 <?php echo $cartCount > 0 ? 'scale-100' : 'scale-0'; ?>">
                                <?php echo $cartCount; ?>
                            </span>
                        </a>
                        
                        <!-- User/Login -->
                        <?php if (User::isLoggedIn()): ?>
                            <div class="relative group flex items-center space-x-1">
                                <span class="text-xs text-text-gray dark:text-gray-300 font-medium hidden md:inline"><?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo number_format($userPoints); ?> điểm)</span>
                                <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout" class="p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300" title="Đăng xuất">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </a>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" class="p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300" aria-label="Tài khoản">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                        
                        <!-- Mobile Menu Toggle -->
                        <button id="mobileMenuBtn" class="lg:hidden p-2.5 rounded-full text-text-gray hover:text-primary hover:bg-primary/5 transition-all duration-300" aria-label="Menu">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                    </div>
            </div>
            
            <!-- Search Bar (Hidden by default) -->
            <div id="searchBar" class="hidden border-t border-border/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <form action="<?php echo BASE_URL; ?>index.php" method="GET" class="relative">
                        <input type="hidden" name="controller" value="product">
                        <input type="hidden" name="action" value="index">
                        <input type="text" name="search" placeholder="Tìm kiếm trà sữa, topping..." 
                                class="w-full bg-black/5 dark:bg-white/5 border border-border/20 rounded-full px-6 py-3 text-text-light placeholder-text-gray focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all duration-300">
                        <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-text-gray hover:text-primary transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- ===== MOBILE MENU OVERLAY ===== -->
    <div id="mobileMenu" class="mobile-menu fixed inset-0 z-[60] lg:hidden">
        <!-- Backdrop -->
        <div class="mobile-menu-backdrop absolute inset-0 bg-black/30 backdrop-blur-sm" id="mobileMenuBackdrop"></div>
        
        <!-- Menu Panel -->
        <div class="mobile-menu-panel absolute right-0 top-0 bottom-0 w-80 max-w-[85vw] bg-surface border-l border-border/10">
            <div class="flex flex-col h-full">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b border-border/10">
                    <span class="text-xl font-playfair font-bold">
                        <span class="text-primary">CHUS</span> TEA
                    </span>
                    <button id="mobileMenuClose" class="p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5 transition-colors duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                
                <!-- Navigation Links -->
                <div class="flex-1 py-6 px-4 space-y-1 overflow-y-auto">
                    <a href="<?php echo BASE_URL; ?>index.php" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span class="font-medium">Trang Chủ</span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=product&action=index" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span class="font-medium">Thực Đơn</span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>index.php#about-section" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium">Về Chúng Tôi</span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=home&action=stores" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-medium">Hệ Thống Cửa Hàng</span>
                    </a>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=cart&action=index" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="font-medium">Giỏ Hàng</span>
                        <?php if ($cartCount > 0): ?>
                        <span class="ml-auto bg-primary text-white text-xs font-bold px-2.5 py-0.5 rounded-full"><?php echo $cartCount; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (User::isAdmin()): ?>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=admin&action=index" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-primary hover:text-primary-light hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="font-medium">Quản Trị</span>
                    </a>
                    <?php endif; ?>
                    <?php if (User::isLoggedIn()): ?>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        <span class="font-medium">Đăng Xuất (<?php echo htmlspecialchars($_SESSION['user_name']); ?>)</span>
                    </a>
                    <?php else: ?>
                    <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" class="mobile-nav-link flex items-center space-x-4 px-4 py-3.5 rounded-xl text-text-light hover:text-primary hover:bg-primary/5 transition-all duration-300">
                        <svg class="w-5 h-5 text-text-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span class="font-medium">Đăng Nhập</span>
                    </a>
                    <?php endif; ?>
                </div>
                
                <!-- Footer -->
                <div class="p-6 border-t border-border/10">
                    <p class="text-xs text-text-gray text-center">© 2024 CHUS TEA. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Spacer for fixed navbar -->
    <div class="h-16 lg:h-20"></div>

