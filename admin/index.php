<?php
/**
 * Entry Point cho trang quản trị độc lập (Admin Panel)
 * Shoptrasua - Cửa hàng trà sữa online
 */

// Khởi tạo session
session_start();

// Tự động phát hiện đường dẫn gốc của project
$projectPath = str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME'])));
$projectBaseUrl = rtrim($projectPath, '/') . '/';
define('BASE_URL', $projectBaseUrl);
define('ROOT_PATH', dirname(__DIR__) . '/');

// Include các model cần thiết
require_once ROOT_PATH . 'models/Database.php';
require_once ROOT_PATH . 'models/Product.php';
require_once ROOT_PATH . 'models/Category.php';
require_once ROOT_PATH . 'models/Cart.php';
require_once ROOT_PATH . 'models/User.php';
require_once ROOT_PATH . 'models/Order.php';
require_once ROOT_PATH . 'models/Review.php';
require_once ROOT_PATH . 'models/Wishlist.php';
require_once ROOT_PATH . 'models/Contact.php';
require_once ROOT_PATH . 'models/Coupon.php';

// Include AdminController
require_once ROOT_PATH . 'admin/controllers/AdminController.php';

// Khởi động Controller
$action = isset($_GET['action']) ? strtolower(trim($_GET['action'])) : 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$controller = new AdminController();

// Kiểm tra và thực thi action
if (method_exists($controller, $action)) {
    if ($id !== null) {
        $controller->$action($id);
    } else {
        $controller->$action();
    }
} else {
    // Action không tồn tại
    http_response_code(404);
    echo '<h1>404 - Không tìm thấy trang quản trị</h1>';
    echo '<p>Hành động "' . htmlspecialchars($action) . '" không tồn tại.</p>';
    echo '<a href="' . BASE_URL . 'admin/index.php">Về bảng điều khiển</a>';
}
