<?php
/**
 * AuthController - Xác thực người dùng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class AuthController
{
    /**
     * Đăng nhập - Hiển thị form (GET) / Xử lý đăng nhập (POST)
     */
    public function login()
    {
        // Nếu đã đăng nhập → chuyển về trang chủ
        if (User::isLoggedIn()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $error = '';
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            // Validate
            if (empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ email và mật khẩu.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } else {
                $userModel = new User();
                $user = $userModel->login($email, $password);

                if ($user) {
                    // Đăng nhập thành công → chuyển hướng
                    $redirect = isset($_SESSION['redirect_after_login'])
                        ? $_SESSION['redirect_after_login']
                        : BASE_URL;
                    unset($_SESSION['redirect_after_login']);
                    header('Location: ' . $redirect);
                    exit;
                } else {
                    $error = 'Email hoặc mật khẩu không chính xác.';
                }
            }
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        $pageTitle = 'Đăng Nhập - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/auth/login.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Đăng ký tài khoản (GET: hiển thị form / POST: xử lý đăng ký)
     */
    public function register()
    {
        // Nếu đã đăng nhập → chuyển về trang chủ
        if (User::isLoggedIn()) {
            header('Location: ' . BASE_URL);
            exit;
        }

        $error = '';
        $success = '';
        $name = '';
        $email = '';
        $phone = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

            // Validate
            if (empty($name) || empty($email) || empty($password)) {
                $error = 'Vui lòng nhập đầy đủ thông tin bắt buộc.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif (mb_strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự.';
            } elseif ($password !== $password_confirm) {
                $error = 'Mật khẩu xác nhận không khớp.';
            } elseif ($phone !== '' && !preg_match('/^[0-9]{9,11}$/', $phone)) {
                $error = 'Số điện thoại không hợp lệ.';
            } else {
                $userModel = new User();

                // Kiểm tra email đã tồn tại
                if ($userModel->findByEmail($email)) {
                    $error = 'Email này đã được sử dụng. Vui lòng chọn email khác.';
                } else {
                    $userId = $userModel->register($name, $email, $password, $phone);

                    if ($userId) {
                        // Đăng ký thành công → chuyển về trang chủ
                        header('Location: ' . BASE_URL);
                        exit;
                    } else {
                        $error = 'Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại.';
                    }
                }
            }
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getAll();

        $pageTitle = 'Đăng Ký - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/auth/register.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        User::logout();

        // Hủy session hoàn toàn
        session_destroy();

        header('Location: ' . BASE_URL);
        exit;
    }
}
