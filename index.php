<?php
/**
 * Front Controller - Điểm vào chính của ứng dụng
 * Shoptrasua - Cửa hàng trà sữa online
 */

// Khởi tạo session
session_start();

// Tự động phát hiện đường dẫn gốc (BASE_URL) để chạy tương thích cả trên localhost và hosting
$basePath = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($basePath, '/') . '/');
define('ROOT_PATH', __DIR__ . '/');

// Lấy controller và action từ URL
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// Chuẩn hóa tên controller
$controllerName = strtolower($controllerName);
$action = strtolower($action);

// Tạo tên class controller
$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = ROOT_PATH . 'controllers/' . $controllerClass . '.php';

// Kiểm tra file controller có tồn tại không
if (file_exists($controllerFile)) {
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

    // Include và khởi tạo controller
    require_once $controllerFile;
    $controller = new $controllerClass();

    // Kiểm tra action có tồn tại không
    if (method_exists($controller, $action)) {
        if ($id !== null) {
            $controller->$action($id);
        } else {
            $controller->$action();
        }
    } else {
        // Action không tồn tại - hiển thị trang 404
        http_response_code(404);
        echo '<h1>404 - Không tìm thấy trang</h1>';
        echo '<p>Hành động "' . htmlspecialchars($action) . '" không tồn tại.</p>';
        echo '<a href="' . BASE_URL . '">Về trang chủ</a>';
    }
} else {
    // Controller không tồn tại - hiển thị trang 404
    http_response_code(404);
    echo '<h1>404 - Không tìm thấy trang</h1>';
    echo '<p>Trang bạn tìm kiếm không tồn tại.</p>';
    echo '<a href="' . BASE_URL . '">Về trang chủ</a>';
}
