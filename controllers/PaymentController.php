<?php
/**
 * PaymentController - Quản lý thanh toán trực tuyến (VNPAY Sandbox)
 * Shoptrasua - Cửa hàng trà sữa online
 */

class PaymentController
{
    private $orderModel;
    private $categoryModel;

    public function __construct()
    {
        if (!User::isLoggedIn()) {
            header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
            exit;
        }

        $this->orderModel = new Order();
        $this->categoryModel = new Category();
    }

    /**
     * Hiển thị trang quét mã QR thanh toán thủ công
     */
    public function pay()
    {
        $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        $order = $this->orderModel->getById($orderId);

        if (!$order || $order['user_id'] != $_SESSION['user_id'] || $order['payment_status'] === 'paid') {
            header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
            exit;
        }

        // Thông tin cấu hình tài khoản nhận tiền
        $bankInfo = [
            'bank_name' => 'Ví điện tử MoMo',
            'account_number' => '*******410',
            'account_name' => 'VU LE PHI HUNG',
            'memo' => 'DH' . $order['id']
        ];

        // Lấy danh mục sản phẩm phục vụ cho header layout
        $categories = $this->categoryModel->getAll();

        // Tiêu đề trang
        $pageTitle = 'Thanh Toán Đơn Hàng #' . $order['id'] . ' - CHUS TEA';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/payment/pay.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Xác nhận khách hàng đã chuyển khoản thành công
     */
    public function confirm()
    {
        $orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        $order = $this->orderModel->getById($orderId);

        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
            exit;
        }

        // Cập nhật trạng thái thanh toán và đơn hàng
        $this->orderModel->updatePaymentStatus($orderId, 'paid');
        $this->orderModel->updateStatus($orderId, 'processing');

        // Tạo thông báo flash
        $_SESSION['checkout_success'] = 'Cảm ơn bạn! Yêu cầu xác nhận chuyển khoản cho đơn hàng #' . $orderId . ' đã được ghi nhận. Chúng tôi đang chuẩn bị món ăn/nước uống cho bạn!';

        // Chuyển hướng về trang lịch sử đơn hàng
        header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
        exit;
    }
}
