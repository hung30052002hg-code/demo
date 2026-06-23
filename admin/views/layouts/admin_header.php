<?php
$userPoints = 0;
if (User::isLoggedIn()) {
    $userModel = new User();
    $currentUser = $userModel->findById($_SESSION['user_id']);
    $userPoints = $currentUser ? (int)$currentUser['points'] : 0;
}
$currentAction = isset($_GET['action']) ? strtolower($_GET['action']) : 'index';

// Tự động phát hiện nếu đang chạy độc lập từ thư mục admin/
$isSeparateAdmin = (strpos($_SERVER['SCRIPT_NAME'], '/admin/index.php') !== false || strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false);
$adminUrl = $isSeparateAdmin ? BASE_URL . 'admin/index.php?' : BASE_URL . 'index.php?controller=admin&';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Trang Quản Trị - CHUS TEA">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Trang Quản Trị - CHUS TEA'; ?></title>
    
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
    <style>
        /* CSS tuỳ chỉnh cho Admin Layout */
        .admin-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        @media (max-width: 1023px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="bg-[#121212] text-text-light font-inter min-h-screen flex overflow-hidden">
    
    <!-- Lớp phủ cho Mobile -->
    <div id="adminOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden backdrop-blur-sm transition-opacity duration-300"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside id="adminSidebar" class="admin-sidebar fixed inset-y-0 left-0 z-50 w-72 bg-[#1A1A1A] border-r border-white/5 flex flex-col h-screen shadow-2xl lg:relative lg:transform-none">
        <!-- Sidebar Header -->
        <div class="h-20 flex items-center justify-between px-6 border-b border-white/5 shrink-0">
            <a href="<?php echo $adminUrl; ?>action=index" class="flex items-center space-x-2 group">
                <span class="text-2xl font-playfair font-bold tracking-wider">
                    <span class="text-primary group-hover:text-primary-light transition-colors duration-300">CHUS</span>
                    <span class="text-text-light"> ADMIN</span>
                </span>
            </a>
            <button id="closeSidebar" class="lg:hidden p-2 rounded-full text-text-gray hover:text-white hover:bg-white/5 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Sidebar Navigation -->
        <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
            
            <div class="text-xs font-semibold text-text-gray uppercase tracking-widest px-4 mb-3 mt-2">Tổng quan</div>
            
            <a href="<?php echo $adminUrl; ?>action=index" 
               class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-300 <?php echo $currentAction === 'index' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-text-gray hover:bg-white/5 hover:text-white'; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                <span class="font-medium">Bảng Điều Khiển</span>
            </a>

            <div class="text-xs font-semibold text-text-gray uppercase tracking-widest px-4 mb-3 mt-8">Quản lý cửa hàng</div>

            <a href="<?php echo $adminUrl; ?>action=orders" 
               class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-300 <?php echo in_array($currentAction, ['orders']) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-text-gray hover:bg-white/5 hover:text-white'; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                <span class="font-medium">Đơn Hàng</span>
            </a>

            <a href="<?php echo $adminUrl; ?>action=products" 
               class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-300 <?php echo in_array($currentAction, ['products', 'addproduct', 'editproduct']) ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-text-gray hover:bg-white/5 hover:text-white'; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="font-medium">Sản Phẩm</span>
            </a>

            <div class="text-xs font-semibold text-text-gray uppercase tracking-widest px-4 mb-3 mt-8">Báo cáo</div>

            <a href="<?php echo $adminUrl; ?>action=stats" 
               class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-300 <?php echo $currentAction === 'stats' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-text-gray hover:bg-white/5 hover:text-white'; ?>">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span class="font-medium">Thống Kê</span>
            </a>

            <div class="text-xs font-semibold text-text-gray uppercase tracking-widest px-4 mb-3 mt-8">Hệ thống</div>

            <a href="<?php echo BASE_URL; ?>index.php" target="_blank"
               class="flex items-center space-x-3 px-4 py-3.5 rounded-xl transition-all duration-300 text-text-gray hover:bg-white/5 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span class="font-medium">Đến Cửa Hàng</span>
            </a>
            
        </div>

        <!-- Sidebar Footer (User Info) -->
        <div class="p-4 border-t border-white/5 shrink-0">
            <div class="flex items-center p-3 rounded-xl bg-white/5">
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                    <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                </div>
                <div class="ml-3 flex-1 overflow-hidden">
                    <p class="text-sm font-medium text-white truncate"><?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
                    <p class="text-xs text-primary truncate">Quản trị viên</p>
                </div>
                <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=logout" class="p-2 text-text-gray hover:text-red-400 transition-colors" title="Đăng xuất">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT WRAPPER ===== -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden bg-dark">
        <!-- Top Navigation -->
        <header class="h-20 bg-dark/80 backdrop-blur-xl border-b border-white/5 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-30 shrink-0">
            <div class="flex items-center">
                <button id="openSidebar" class="lg:hidden p-2 -ml-2 rounded-xl text-text-gray hover:text-white hover:bg-white/5 transition-colors mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-xl font-semibold text-white hidden sm:block"><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Bảng Điều Khiển'; ?></h1>
            </div>
            
            <div class="flex items-center space-x-3">
                <button class="p-2.5 rounded-full text-text-gray hover:text-white hover:bg-white/5 transition-colors relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-dark"></span>
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 scrollbar-thin scrollbar-thumb-white/10 scrollbar-track-transparent">
