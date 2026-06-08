<?php
/**
 * WishlistController - Quản lý sản phẩm yêu thích (Wishlist) của người dùng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class WishlistController
{
    private $wishlistModel;
    private $categoryModel;

    public function __construct()
    {
        // Yêu cầu đăng nhập để sử dụng tính năng yêu thích
        if (!User::isLoggedIn()) {
            if ($this->isAjaxRequest()) {
                $this->jsonResponse(false, 'Vui lòng đăng nhập để sử dụng tính năng yêu thích.');
            }
            $_SESSION['redirect_after_login'] = BASE_URL . 'index.php?controller=product&action=index';
            header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
            exit;
        }

        $this->wishlistModel = new Wishlist();
        $this->categoryModel = new Category();
    }

    /**
     * Hiển thị danh sách sản phẩm yêu thích
     */
    public function index()
    {
        $wishlistItems = $this->wishlistModel->getByUserId($_SESSION['user_id']);
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Sản Phẩm Yêu Thích - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/wishlist/index.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Bật/Tắt trạng thái yêu thích sản phẩm (AJAX endpoint)
     */
    public function toggle()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(false, 'Phương thức yêu cầu không hợp lệ.');
        }

        $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        if ($productId <= 0) {
            $this->jsonResponse(false, 'ID sản phẩm không hợp lệ.');
        }

        $userId = $_SESSION['user_id'];
        $isFavorited = $this->wishlistModel->isFavorited($userId, $productId);

        if ($isFavorited) {
            // Đã thích -> Xóa thích
            $result = $this->wishlistModel->remove($userId, $productId);
            if ($result) {
                $this->jsonResponse(true, 'Đã xóa sản phẩm khỏi danh sách yêu thích.', ['favorited' => false]);
            } else {
                $this->jsonResponse(false, 'Không thể thực thi xóa yêu thích.');
            }
        } else {
            // Chưa thích -> Thêm thích
            $result = $this->wishlistModel->add($userId, $productId);
            if ($result) {
                $this->jsonResponse(true, 'Đã thêm sản phẩm vào danh sách yêu thích!', ['favorited' => true]);
            } else {
                $this->jsonResponse(false, 'Không thể thực thi thêm yêu thích.');
            }
        }
    }

    /**
     * Kiểm tra có phải AJAX request không
     */
    private function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * Trả về kết quả JSON
     */
    private function jsonResponse($success, $message, $data = [])
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message,
        ], $data), JSON_UNESCAPED_UNICODE);
        exit;
    }
}
