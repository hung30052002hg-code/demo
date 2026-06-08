<?php
/**
 * AdminController - Quản lý các chức năng quản trị hệ thống
 * Shoptrasua - Cửa hàng trà sữa online
 */

class AdminController
{
    private $productModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        // Kiểm tra quyền admin trước khi cho phép truy cập
        if (!User::isAdmin()) {
            $_SESSION['redirect_after_login'] = BASE_URL . 'index.php?controller=admin&action=index';
            header('Location: ' . BASE_URL . 'index.php?controller=auth&action=login');
            exit;
        }

        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    /**
     * Trang chủ Dashboard Admin - Thống kê chung
     */
    public function index()
    {
        $orderModel = new Order();
        $stats = [
            'total_products'   => $this->productModel->countAll(),
            'total_categories' => $this->categoryModel->countAll(),
            'total_users'      => $this->userModel->countAll(),
            'total_orders'     => $orderModel->countAll(),
        ];

        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Trang Quản Trị - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/dashboard.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Quản lý danh sách sản phẩm
     */
    public function products()
    {
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Quản Lý Sản Phẩm - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/products.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Thêm sản phẩm mới
     */
    public function addproduct()
    {
        $error = '';
        $success = '';
        $categories = $this->categoryModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
            $price = isset($_POST['price']) ? (int)$_POST['price'] : 0;
            $price_large = isset($_POST['price_large']) ? (int)$_POST['price_large'] : 0;
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_new = isset($_POST['is_new']) ? 1 : 0;

            // Tạo slug đơn giản từ name
            $slug = $this->createSlug($name);

            // Validate
            if (empty($name) || $category_id === 0 || $price <= 0) {
                $error = 'Vui lòng điền đầy đủ các thông tin bắt buộc (Tên, Danh mục, Giá).';
            } else {
                $image = $this->handleImageUpload($error);
                if (empty($error)) {
                    $data = [
                        'category_id' => $category_id,
                        'name'        => $name,
                        'slug'        => $slug,
                        'description' => $description,
                        'price'       => $price,
                        'price_large' => $price_large > 0 ? $price_large : $price + 10000,
                        'image'       => $image,
                        'is_featured' => $is_featured,
                        'is_new'      => $is_new
                    ];

                    $productId = $this->productModel->create($data);
                    if ($productId) {
                        $success = 'Thêm sản phẩm mới thành công!';
                        header('Location: ' . BASE_URL . 'index.php?controller=admin&action=products');
                        exit;
                    } else {
                        $error = 'Đã xảy ra lỗi khi lưu sản phẩm vào cơ sở dữ liệu.';
                    }
                }
            }
        }

        $pageTitle = 'Thêm Sản Phẩm - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/product_form.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Sửa đổi sản phẩm
     */
    public function editproduct($id = null)
    {
        if ($id === null) {
            header('Location: ' . BASE_URL . 'index.php?controller=admin&action=products');
            exit;
        }

        $product = $this->productModel->getById($id);
        if (!$product) {
            header('Location: ' . BASE_URL . 'index.php?controller=admin&action=products');
            exit;
        }

        $error = '';
        $success = '';
        $categories = $this->categoryModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = isset($_POST['name']) ? trim($_POST['name']) : '';
            $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
            $price = isset($_POST['price']) ? (int)$_POST['price'] : 0;
            $price_large = isset($_POST['price_large']) ? (int)$_POST['price_large'] : 0;
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $is_featured = isset($_POST['is_featured']) ? 1 : 0;
            $is_new = isset($_POST['is_new']) ? 1 : 0;

            $slug = $this->createSlug($name);

            if (empty($name) || $category_id === 0 || $price <= 0) {
                $error = 'Vui lòng điền đầy đủ các thông tin bắt buộc.';
            } else {
                $image = $this->handleImageUpload($error, $product['image']);
                if (empty($error)) {
                    $data = [
                        'category_id' => $category_id,
                        'name'        => $name,
                        'slug'        => $slug,
                        'description' => $description,
                        'price'       => $price,
                        'price_large' => $price_large > 0 ? $price_large : $price + 10000,
                        'image'       => $image,
                        'is_featured' => $is_featured,
                        'is_new'      => $is_new
                    ];

                    $result = $this->productModel->update($id, $data);
                    if ($result) {
                        $success = 'Cập nhật sản phẩm thành công!';
                        header('Location: ' . BASE_URL . 'index.php?controller=admin&action=products');
                        exit;
                    } else {
                        $error = 'Đã xảy ra lỗi khi cập nhật sản phẩm.';
                    }
                }
            }
        }

        $pageTitle = 'Sửa Sản Phẩm - ' . $product['name'] . ' - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/product_form.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteproduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            if ($id > 0) {
                $this->productModel->delete($id);
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=admin&action=products');
        exit;
    }

    /**
     * Quản lý đơn hàng (Admin)
     */
    public function orders()
    {
        $orderModel = new Order();
        $orders = $orderModel->getAll();
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Quản Lý Đơn Hàng - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/orders.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Cập nhật trạng thái đơn hàng (Admin)
     */
    public function updateorderstatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $status = isset($_POST['status']) ? trim($_POST['status']) : '';

            if ($id > 0 && !empty($status)) {
                $orderModel = new Order();
                
                if ($status === 'cancelled') {
                    $orderModel->cancelOrder($id);
                } else {
                    $order = $orderModel->getById($id);
                    if ($order) {
                        if ($status === 'completed' && $order['status'] !== 'completed') {
                            $orderModel->updateStatus($id, $status);
                            $orderModel->updatePaymentStatus($id, 'paid');
                            
                            // Tích điểm cho user
                            if (isset($order['points_earned']) && $order['points_earned'] > 0) {
                                $userModel = new User();
                                $user = $userModel->findById($order['user_id']);
                                if ($user) {
                                    $userModel->updatePoints($order['user_id'], $user['points'] + $order['points_earned']);
                                }
                            }
                        } else {
                            $orderModel->updateStatus($id, $status);
                        }
                    }
                }
            }
        }
        header('Location: ' . BASE_URL . 'index.php?controller=admin&action=orders');
        exit;
    }

    /**
     * Xem thống kê doanh số và biểu đồ (Admin)
     */
    public function stats()
    {
        $orderModel = new Order();
        $bestSellers = $orderModel->getBestSellers(5);
        $topCustomers = $orderModel->getTopCustomers(5);
        
        $categories = $this->categoryModel->getAll();
        $pageTitle = 'Thống Kê Báo Cáo - ShopTraSua';

        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/admin/stats.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Xuất báo cáo đơn hàng ra file CSV
     */
    public function export()
    {
        $orderModel = new Order();
        $orders = $orderModel->getAll();

        // Cấu hình header tải xuống file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=BaoCaoDonHang_' . date('Ymd_His') . '.csv');
        
        // Output stream
        $output = fopen('php://output', 'w');
        
        // Ghi BOM để Excel hiểu UTF-8
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // Ghi dòng tiêu đề cột
        fputcsv($output, ['Mã Đơn Hàng', 'Khách Hàng', 'Email', 'Tổng Tiền (VND)', 'Phương Thức', 'Thanh Toán', 'Trạng Thái Đơn', 'Ngày Đặt']);
        
        // Ghi dữ liệu
        foreach ($orders as $order) {
            $paymentStatusText = ($order['payment_status'] === 'paid') ? 'Đã thanh toán' : 'Chưa thanh toán';
            $statusTexts = [
                'pending'    => 'Đang chờ duyệt',
                'processing' => 'Đang pha chế',
                'shipped'    => 'Đang giao hàng',
                'completed'  => 'Đã hoàn thành',
                'cancelled'  => 'Đã hủy đơn'
            ];
            $statusText = $statusTexts[$order['status']] ?? 'Không xác định';

            fputcsv($output, [
                $order['id'],
                $order['user_name'],
                $order['user_email'],
                $order['total_money'],
                $order['payment_method'],
                $paymentStatusText,
                $statusText,
                date('d/m/Y H:i', strtotime($order['created_at']))
            ]);
        }
        
        fclose($output);
        exit;
    }

    /**
     * Hàm helper tạo slug đơn giản từ tên tiếng Việt
     */
    private function createSlug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    /**
     * Xử lý tải ảnh sản phẩm lên server
     * @param string $error Biến tham chiếu lưu lỗi nếu có
     * @param string|null $oldImage Tên ảnh cũ để xóa hoặc giữ nguyên làm mặc định
     * @return string Tên tệp ảnh mới tải lên hoặc ảnh cũ
     */
    private function handleImageUpload(&$error, $oldImage = null)
    {
        if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
            return $oldImage ?? 'product_1.jpg';
        }

        $file = $_FILES['image'];
        
        // 1. Kiểm tra lỗi upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $error = 'Lỗi tải tệp tin lên server (Mã lỗi: ' . $file['error'] . ').';
            return $oldImage ?? 'product_1.jpg';
        }

        // 2. Kiểm tra định dạng (MIME type / extension)
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts)) {
            $error = 'Định dạng tệp không được hỗ trợ. Chỉ nhận JPG, JPEG, PNG, GIF, WEBP.';
            return $oldImage ?? 'product_1.jpg';
        }

        // 3. Kiểm tra dung lượng (giới hạn 2MB)
        $maxSize = 2 * 1024 * 1024;
        if ($file['size'] > $maxSize) {
            $error = 'Dung lượng ảnh quá lớn. Vui lòng tải ảnh nhỏ hơn 2MB.';
            return $oldImage ?? 'product_1.jpg';
        }

        // 4. Tạo thư mục uploads nếu chưa có
        $uploadDir = ROOT_PATH . 'public/uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // 5. Tạo tên file duy nhất tránh trùng lặp
        $newFileName = uniqid('product_', true) . '.' . $ext;
        $destPath = $uploadDir . $newFileName;

        // 6. Lưu file
        if (move_uploaded_file($file['tmp_name'], $destPath)) {
            // Xóa ảnh cũ nếu nó không phải là ảnh mặc định
            if ($oldImage && $oldImage !== 'product_1.jpg') {
                $oldImagePath = $uploadDir . $oldImage;
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            return $newFileName;
        } else {
            $error = 'Không thể lưu tệp ảnh lên máy chủ.';
            return $oldImage ?? 'product_1.jpg';
        }
    }
}
