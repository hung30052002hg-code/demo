<?php
/**
 * ContactController - Quản lý gửi liên hệ và phản hồi từ người dùng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class ContactController
{
    private $contactModel;
    private $categoryModel;

    public function __construct()
    {
        $this->contactModel = new Contact();
        $this->categoryModel = new Category();
    }

    /**
     * Hiển thị trang liên hệ
     */
    public function index()
    {
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Liên Hệ & Phản Hồi - ShopTraSua';

        $successMsg = '';
        if (isset($_SESSION['contact_success'])) {
            $successMsg = $_SESSION['contact_success'];
            unset($_SESSION['contact_success']);
        }

        $errorMsg = '';
        if (isset($_SESSION['contact_error'])) {
            $errorMsg = $_SESSION['contact_error'];
            unset($_SESSION['contact_error']);
        }

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/contact/index.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Xử lý gửi thư liên hệ (POST)
     */
    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'index.php?controller=contact&action=index');
            exit;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';

        if (empty($name) || empty($email) || empty($message)) {
            $_SESSION['contact_error'] = 'Vui lòng điền đầy đủ các thông tin bắt buộc (Họ tên, Email, Nội dung).';
            header('Location: ' . BASE_URL . 'index.php?controller=contact&action=index');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['contact_error'] = 'Địa chỉ email không hợp lệ.';
            header('Location: ' . BASE_URL . 'index.php?controller=contact&action=index');
            exit;
        }

        $data = [
            'name'    => $name,
            'email'   => $email,
            'subject' => $subject,
            'message' => $message
        ];

        $result = $this->contactModel->create($data);

        if ($result) {
            $_SESSION['contact_success'] = 'Cảm ơn ý kiến đóng góp của bạn! Chúng tôi đã nhận được thông tin và sẽ phản hồi sớm nhất có thể.';
        } else {
            $_SESSION['contact_error'] = 'Đã xảy ra lỗi hệ thống khi gửi phản hồi. Vui lòng thử lại sau.';
        }

        header('Location: ' . BASE_URL . 'index.php?controller=contact&action=index');
        exit;
    }
}
