<?php
/**
 * CartController - Quản lý giỏ hàng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class CartController
{
    private $cart;

    public function __construct()
    {
        $this->cart = new Cart();
    }

    /**
     * Hiển thị trang giỏ hàng
     */
    public function index()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        // Lấy dữ liệu giỏ hàng
        $cartItems = $this->cart->getItems();
        $cartTotal = $this->cart->getTotal();
        $cartCount = $this->cart->getCount();

        // Tiêu đề trang
        $pageTitle = 'Giỏ Hàng - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/cart/index.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Thêm sản phẩm vào giỏ hàng (AJAX endpoint)
     */
    public function add()
    {
        // Chỉ chấp nhận POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(false, 'Phương thức không hợp lệ');
            return;
        }

        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        $size = isset($_POST['size']) ? $_POST['size'] : 'M';
        $ice = isset($_POST['ice']) ? $_POST['ice'] : '100%';
        $sugar = isset($_POST['sugar']) ? $_POST['sugar'] : '100%';
        $toppings = isset($_POST['toppings']) ? $_POST['toppings'] : [];

        // Kiểm tra sản phẩm tồn tại
        $productModel = new Product();
        $product = $productModel->getById($product_id);

        if (!$product) {
            $this->jsonResponse(false, 'Sản phẩm không tồn tại');
            return;
        }

        if ($quantity < 1) {
            $this->jsonResponse(false, 'Số lượng không hợp lệ');
            return;
        }

        // Thêm vào giỏ hàng
        $this->cart->add($product_id, $quantity, $size, $ice, $sugar, $toppings);

        $this->jsonResponse(true, 'Đã thêm "' . $product['name'] . '" vào giỏ hàng!', [
            'cartCount' => $this->cart->getCount(),
            'cartTotal' => $this->cart->getTotal(),
        ]);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ (AJAX endpoint)
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(false, 'Phương thức không hợp lệ');
            return;
        }

        $cartKey = isset($_POST['cart_key']) ? $_POST['cart_key'] : '';
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

        if (empty($cartKey)) {
            $this->jsonResponse(false, 'Thiếu thông tin sản phẩm');
            return;
        }

        $result = $this->cart->update($cartKey, $quantity);

        if ($result) {
            $this->jsonResponse(true, 'Đã cập nhật giỏ hàng', [
                'cartCount' => $this->cart->getCount(),
                'cartTotal' => $this->cart->getTotal(),
                'items'     => $this->cart->getItems(),
            ]);
        } else {
            $this->jsonResponse(false, 'Không thể cập nhật giỏ hàng');
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng (AJAX endpoint)
     */
    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(false, 'Phương thức không hợp lệ');
            return;
        }

        $cartKey = isset($_POST['cart_key']) ? $_POST['cart_key'] : '';

        if (empty($cartKey)) {
            $this->jsonResponse(false, 'Thiếu thông tin sản phẩm');
            return;
        }

        $result = $this->cart->remove($cartKey);

        if ($result) {
            $this->jsonResponse(true, 'Đã xóa sản phẩm khỏi giỏ hàng', [
                'cartCount' => $this->cart->getCount(),
                'cartTotal' => $this->cart->getTotal(),
                'items'     => $this->cart->getItems(),
            ]);
        } else {
            $this->jsonResponse(false, 'Không tìm thấy sản phẩm trong giỏ hàng');
        }
    }

    /**
     * Gửi JSON response
     * @param bool $success
     * @param string $message
     * @param array $data Dữ liệu bổ sung
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
