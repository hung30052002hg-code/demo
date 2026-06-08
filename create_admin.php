<?php
/**
 * Script tự động tạo/khôi phục tài khoản Admin bằng code PHP
 * Shoptrasua - Cửa hàng trà sữa online
 */

// Định nghĩa hằng số
define('BASE_URL', '/Shoptrasua/');
define('ROOT_PATH', __DIR__ . '/');

// Include các file cấu hình và database cần thiết
require_once ROOT_PATH . 'config/database.php';
require_once ROOT_PATH . 'models/Database.php';

$success = false;
$message = '';
$error = '';

try {
    // 1. Kết nối database thông qua Singleton PDO
    $db = Database::getInstance();

    // 2. Tự động kiểm tra và thêm cột 'role' vào bảng 'users' nếu chưa tồn tại
    // Điều này giúp tránh lỗi nếu cơ sở dữ liệu cũ chưa được nâng cấp
    $checkRoleColumn = $db->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($checkRoleColumn->rowCount() == 0) {
        $db->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) DEFAULT 'user' AFTER phone");
    }

    // 3. Thông tin tài khoản admin muốn tạo/cập nhật
    $adminName = 'Admin';
    $adminEmail = 'admin@shoptrasua.vn';
    $adminPasswordPlain = 'admin123'; // Mật khẩu plain text để mã hóa
    $adminPhone = '0901234567';
    $adminRole = 'admin';

    // Mã hóa mật khẩu an toàn bằng bcrypt thông qua password_hash
    $hashedPassword = password_hash($adminPasswordPlain, PASSWORD_DEFAULT);

    // 4. Kiểm tra tài khoản admin đã tồn tại theo email chưa
    $stmtCheck = $db->prepare("SELECT id FROM users WHERE email = :email");
    $stmtCheck->execute([':email' => $adminEmail]);
    $existingUser = $stmtCheck->fetch();

    if ($existingUser) {
        // Nếu đã tồn tại -> Cập nhật lại mật khẩu và quyền admin
        $stmtUpdate = $db->prepare("
            UPDATE users 
            SET name = :name, password = :password, phone = :phone, role = :role 
            WHERE id = :id
        ");
        $stmtUpdate->execute([
            ':name'     => $adminName,
            ':password' => $hashedPassword,
            ':phone'    => $adminPhone,
            ':role'     => $adminRole,
            ':id'       => $existingUser['id']
        ]);
        $message = "Tài khoản admin mẫu đã tồn tại và vừa được **cập nhật lại thông tin mới thành công**!";
    } else {
        // Nếu chưa tồn tại -> Thêm mới tài khoản
        $stmtInsert = $db->prepare("
            INSERT INTO users (name, email, password, phone, role, created_at) 
            VALUES (:name, :email, :password, :phone, :role, NOW())
        ");
        $stmtInsert->execute([
            ':name'     => $adminName,
            ':email'    => $adminEmail,
            ':password' => $hashedPassword,
            ':phone'    => $adminPhone,
            ':role'     => $adminRole
        ]);
        $message = "Tài khoản admin mới vừa được **tạo thành công**!";
    }
    
    $success = true;

} catch (PDOException $e) {
    $error = "Lỗi kết nối hoặc thực thi truy vấn: " . $e->getMessage() . "<br><br>*Gợi ý: Hãy chắc chắn rằng bạn đã khởi động MySQL trong XAMPP và tạo cơ sở dữ liệu `shoptrasua`.*";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khởi Tạo Tài Khoản Admin - CHUS TEA</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0A0A0A;
            color: #FFFFFF;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-[#1A1A1A] border border-white/5 rounded-3xl p-8 sm:p-10 shadow-2xl relative overflow-hidden">
        <!-- Background radial glow -->
        <div class="absolute -top-20 -right-20 w-48 h-48 rounded-full bg-red-600/10 blur-3xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center space-y-3 mb-8">
            <span class="text-3xl font-playfair font-bold text-red-600">CHUS <span class="text-white">TEA</span></span>
            <h1 class="text-xl font-bold pt-2">Khởi Tạo Tài Khoản Quản Trị</h1>
            <p class="text-xs text-gray-400">Thiết lập tài khoản admin thông qua code PHP tự động.</p>
        </div>

        <!-- Result Box -->
        <?php if ($success): ?>
            <!-- Success Status -->
            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-2xl p-6 text-center space-y-4 mb-6">
                <span class="text-5xl block">✅</span>
                <h2 class="text-base font-bold text-emerald-400">Thiết lập thành công!</h2>
                <p class="text-xs text-gray-300 leading-relaxed"><?php echo $message; ?></p>
            </div>

            <!-- Admin Credentials Table -->
            <div class="bg-white/3 border border-white/5 rounded-2xl p-5 mb-8 space-y-3">
                <div class="flex justify-between items-center text-xs border-b border-white/5 pb-2">
                    <span class="text-gray-400">Email đăng nhập:</span>
                    <strong class="text-white"><?php echo htmlspecialchars($adminEmail); ?></strong>
                </div>
                <div class="flex justify-between items-center text-xs border-b border-white/5 pb-2">
                    <span class="text-gray-400">Mật khẩu mẫu:</span>
                    <strong class="text-red-400"><?php echo htmlspecialchars($adminPasswordPlain); ?></strong>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-gray-400">Quyền truy cập:</span>
                    <span class="bg-red-600/20 text-red-500 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Administrator</span>
                </div>
            </div>

            <!-- Redirection Actions -->
            <div class="space-y-3">
                <a href="<?php echo BASE_URL; ?>index.php?controller=auth&action=login" 
                   class="block text-center w-full bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl py-4 text-sm transition-all duration-300 hover:shadow-lg hover:shadow-red-600/20 transform hover:-translate-y-0.5">
                    ĐI ĐẾN ĐĂNG NHẬP
                </a>
                <p class="text-[10px] text-gray-500 text-center leading-normal">
                    ⚠️ <strong>Lưu ý bảo mật:</strong> Hãy xóa file <code>create_admin.php</code> ra khỏi thư mục dự án sau khi đăng nhập thành công để tránh nguy cơ xâm nhập trái phép.
                </p>
            </div>

        <?php else: ?>
            <!-- Error Status -->
            <div class="bg-red-600/10 border border-red-600/20 rounded-2xl p-6 text-center space-y-4 mb-6">
                <span class="text-5xl block">❌</span>
                <h2 class="text-base font-bold text-red-500">Khởi tạo thất bại!</h2>
                <p class="text-xs text-gray-300 leading-relaxed text-left"><?php echo $error; ?></p>
            </div>

            <a href="create_admin.php" 
               class="block text-center w-full bg-white/5 border border-white/10 hover:border-white/20 text-white font-semibold rounded-xl py-4 text-sm transition-all duration-300">
                Thử lại quy trình
            </a>
        <?php endif; ?>
    </div>
</body>
</html>
