<?php
/**
 * ProductController - Quản lý hiển thị sản phẩm
 * Shoptrasua - Cửa hàng trà sữa online
 */

class ProductController
{
    /**
     * Danh sách sản phẩm - có hỗ trợ lọc theo danh mục và tìm kiếm
     */
    public function index()
    {
        $productModel = new Product();
        $categoryModel = new Category();

        // Lấy tham số lọc
        $category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : null;
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;
        $min_price = isset($_GET['min_price']) && $_GET['min_price'] !== '' ? (int)$_GET['min_price'] : null;
        $max_price = isset($_GET['max_price']) && $_GET['max_price'] !== '' ? (int)$_GET['max_price'] : null;
        $sort_by = isset($_GET['sort_by']) ? trim($_GET['sort_by']) : null;

        // Lấy dữ liệu
        $products = $productModel->getAll($category_id, $search, $min_price, $max_price, $sort_by);
        $categories = $categoryModel->getAll();

        // Lấy tên danh mục hiện tại nếu đang lọc
        $currentCategory = null;
        if ($category_id) {
            $currentCategory = $categoryModel->getById($category_id);
        }

        // Tiêu đề trang
        if ($currentCategory) {
            $pageTitle = $currentCategory['name'] . ' - ShopTraSua';
        } elseif ($search) {
            $pageTitle = 'Tìm kiếm: ' . htmlspecialchars($search) . ' - ShopTraSua';
        } else {
            $pageTitle = 'Thực Đơn - ShopTraSua';
        }

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/products/index.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }

    /**
     * Chi tiết sản phẩm
     * @param int $id ID sản phẩm
     */
    public function detail($id = null)
    {
        if ($id === null) {
            header('Location: ' . BASE_URL . 'index.php?controller=product&action=index');
            exit;
        }

        $productModel = new Product();
        $categoryModel = new Category();

        // Lấy sản phẩm
        $product = $productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            $pageTitle = 'Không tìm thấy sản phẩm - ShopTraSua';
            require_once ROOT_PATH . 'views/layouts/header.php';
            echo '<div class="container py-5 text-center">';
            echo '<h2>Không tìm thấy sản phẩm</h2>';
            echo '<p>Sản phẩm bạn tìm kiếm không tồn tại hoặc đã bị xóa.</p>';
            echo '<a href="' . BASE_URL . 'index.php?controller=product&action=index" class="btn btn-primary">Xem thực đơn</a>';
            echo '</div>';
            require_once ROOT_PATH . 'views/layouts/footer.php';
            return;
        }

        // Lấy sản phẩm liên quan
        $relatedProducts = $productModel->getRelated($product['id'], $product['category_id'], 4);
        // Lấy sản phẩm được AI đề xuất mua kèm (Apriori co-purchase history)
        $recommendedProducts = $productModel->getRecommendedProducts($product['id'], 4);
        
        // Lấy danh sách topping có sẵn
        $toppings = $productModel->getByCategory(6);
        
        $categories = $categoryModel->getAll();

        // Tiêu đề trang
        $pageTitle = $product['name'] . ' - ShopTraSua';

        // Render views
        require_once ROOT_PATH . 'views/layouts/header.php';
        require_once ROOT_PATH . 'views/products/detail.php';
        require_once ROOT_PATH . 'views/layouts/footer.php';
    }
}
