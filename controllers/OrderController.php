<?php
/**
 * OrderController - Quản lý quy trình đặt hàng và theo dõi đơn hàng của khách hàng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class OrderController
{
    private $orderModel;
    private $cart;
    private $categoryModel;

    public function __construct()
    {
        // Yêu cầu đăng nhập trước khi thực hiện đặt hàng
        if (!User::isLoggedIn()) {
            $_SESSION['redirect_after_login'] = BASE_URL . 'index.php?controller=cart&action=index';
            header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
            exit;
        }

        $this->orderModel = new Order();
        $this->cart = new Cart();
        $this->categoryModel = new Category();
    }

    /**
     * Tiến hành thanh toán và đặt hàng
     */
    public function checkout()
    {
        $cartItems = $this->cart->getItems();
        $cartTotal = $this->cart->getTotal();

        if (empty($cartItems)) {
            header('Location: ' . BASE_URL . 'index.php?controller=cart&action=index');
            exit;
        }

        $error = '';
        $categories = $this->categoryModel->getAll();

        $userModel = new User();
        $currentUser = $userModel->findById($_SESSION['user_id']);
        $userPoints = $currentUser ? (int)$currentUser['points'] : 0;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $shipping_address = isset($_POST['shipping_address']) ? trim($_POST['shipping_address']) : '';
            $payment_method = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : 'COD';
            $note = isset($_POST['note']) ? trim($_POST['note']) : '';
            $coupon_code = isset($_POST['coupon_code']) ? trim($_POST['coupon_code']) : '';
            $shipping_fee = isset($_POST['shipping_fee']) ? (int)$_POST['shipping_fee'] : 30000;
            $points_spent = isset($_POST['points_spent']) ? (int)$_POST['points_spent'] : 0;

            // Validate points_spent
            if ($points_spent < 0) {
                $points_spent = 0;
            }
            if ($points_spent > $userPoints) {
                $points_spent = $userPoints;
            }

            // Tính toán mã giảm giá nếu có
            $discount = 0;
            if (!empty($coupon_code)) {
                $couponModel = new Coupon();
                $checkCoupon = $couponModel->isValid($coupon_code, $cartTotal);
                if ($checkCoupon['success']) {
                    $discount = $checkCoupon['discount'];
                }
            }

            // Tính toán giảm giá từ điểm tích lũy
            $points_discount = $points_spent * 1000;
            $max_points_discount = max(0, $cartTotal - $discount);
            if ($points_discount > $max_points_discount) {
                $points_discount = $max_points_discount;
                $points_spent = (int)ceil($points_discount / 1000);
            }

            $finalTotal = max(0, $cartTotal - $discount - $points_discount + $shipping_fee);
            $points_earned = (int)floor(max(0, $cartTotal - $discount - $points_discount) / 10000);

            if (empty($phone) || empty($shipping_address)) {
                $error = 'Vui lòng cung cấp số điện thoại và địa chỉ giao hàng.';
            } else {
                // Tạo dữ liệu đơn hàng
                $orderData = [
                    'user_id'          => $_SESSION['user_id'],
                    'total_money'      => $finalTotal,
                    'status'           => 'pending',
                    'payment_method'   => $payment_method,
                    'payment_status'   => ($payment_method === 'ONLINE') ? 'unpaid' : 'unpaid',
                    'shipping_fee'     => $shipping_fee,
                    'points_earned'    => $points_earned,
                    'points_spent'     => $points_spent,
                    'shipping_address' => $shipping_address,
                    'phone'            => $phone,
                    'note'             => $note
                ];

                // Thực thi tạo đơn hàng trong Database
                $orderId = $this->orderModel->create($orderData, $cartItems);

                if ($orderId) {
                    // Xóa giỏ hàng sau khi đặt hàng thành công
                    $this->cart->clear();

                    // Gửi email xác nhận đơn hàng tự động
                    if (file_exists(ROOT_PATH . 'helpers/Mailer.php')) {
                        require_once ROOT_PATH . 'helpers/Mailer.php';
                        // Gửi mail không chặn luồng hiển thị (gửi bất đồng bộ giả lập bằng cách bắt lỗi hoặc gửi nhanh)
                        try {
                            Mailer::sendOrderEmail($_SESSION['user_email'], $orderId);
                        } catch (Exception $e) {
                            // Bỏ qua lỗi gửi mail để tránh sập luồng đặt hàng
                        }
                    }

                    // Điều hướng
                    if ($payment_method === 'ONLINE') {
                        // Chuyển sang PaymentController để thanh toán online
                        header('Location: ' . BASE_URL . 'index.php?controller=payment&action=pay&order_id=' . $orderId);
                        exit;
                    } else {
                        // COD đặt hàng thành công
                        $_SESSION['checkout_success'] = 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.';
                        header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
                        exit;
                    }
                } else {
                    $error = 'Đã xảy ra lỗi khi tạo đơn hàng. Vui lòng thử lại.';
                }
            }
        }

        $pageTitle = 'Thanh Toán Đơn Hàng - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/order/checkout.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Lịch sử mua hàng của khách hàng
     */
    public function history()
    {
        $orders = $this->orderModel->getUserOrders($_SESSION['user_id']);
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Lịch Sử Mua Hàng - ShopTraSua';

        $successMsg = '';
        if (isset($_SESSION['checkout_success'])) {
            $successMsg = $_SESSION['checkout_success'];
            unset($_SESSION['checkout_success']);
        }

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/order/history.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Chi tiết đơn hàng của người dùng
     */
    public function detail($id = null)
    {
        if ($id === null) {
            header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
            exit;
        }

        $order = $this->orderModel->getById($id);

        // Bảo mật: Không cho khách xem đơn hàng của người khác
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Location: ' . BASE_URL . 'index.php?controller=order&action=history');
            exit;
        }

        $orderItems = $this->orderModel->getItems($id);
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Chi Tiết Đơn Hàng #' . $id . ' - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/order/detail.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Khách hàng xác nhận đã nhận hàng (Hoàn thành đơn hàng)
     */
    public function confirmReceived()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $order = $this->orderModel->getById($id);
            // Bảo mật: Kiểm tra đơn hàng có thuộc về user đang đăng nhập hay không
            if ($order && $order['user_id'] == $_SESSION['user_id']) {
                // Chỉ cho phép xác nhận nhận hàng nếu trạng thái chưa completed và chưa cancelled
                if ($order['status'] !== 'completed' && $order['status'] !== 'cancelled') {
                    $this->orderModel->updateStatus($id, 'completed');
                    $this->orderModel->updatePaymentStatus($id, 'paid');
                    
                    // Tích điểm cho user
                    if (isset($order['points_earned']) && $order['points_earned'] > 0) {
                        $userModel = new User();
                        $user = $userModel->findById($order['user_id']);
                        if ($user) {
                            $userModel->updatePoints($order['user_id'], $user['points'] + $order['points_earned']);
                        }
                    }

                    $_SESSION['checkout_success'] = 'Cảm ơn bạn đã xác nhận nhận hàng! Đơn hàng đã hoàn thành.';
                }
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=order&action=detail&id=' . $id);
        exit;
    }

    /**
     * Khách hàng hủy đơn hàng (chỉ khi trạng thái là pending)
     */
    public function cancel()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $order = $this->orderModel->getById($id);
            // Bảo mật: Kiểm tra đơn hàng có thuộc về user đang đăng nhập hay không
            if ($order && $order['user_id'] == $_SESSION['user_id']) {
                // Chỉ cho phép hủy nếu trạng thái là pending
                if ($order['status'] === 'pending') {
                    if ($this->orderModel->cancelOrder($id)) {
                        $_SESSION['checkout_success'] = 'Hủy đơn hàng thành công!';
                    } else {
                        $_SESSION['checkout_error'] = 'Đã xảy ra lỗi khi hủy đơn hàng.';
                    }
                } else {
                    $_SESSION['checkout_error'] = 'Chỉ có thể hủy đơn hàng ở trạng thái Đang chờ duyệt.';
                }
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=order&action=detail&id=' . $id);
        exit;
    }

    /**
     * AJAX endpoint lấy trạng thái đơn hàng (cho real-time polling)
     */
    public function getStatusAjax()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $order = $this->orderModel->getById($id);
        
        if (!$order || $order['user_id'] != $_SESSION['user_id']) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy đơn hàng']);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'status' => $order['status'],
            'payment_status' => $order['payment_status']
        ]);
        exit;
    }
}
