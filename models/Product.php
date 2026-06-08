<?php
/**
 * Product Model - Quản lý sản phẩm
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Lấy tất cả sản phẩm với bộ lọc tùy chọn nâng cao
     * @param int|null $category_id Lọc theo danh mục
     * @param string|null $search Tìm kiếm theo tên
     * @param int|null $min_price Giá tối thiểu
     * @param int|null $max_price Giá tối đa
     * @param string|null $sort_by Sắp xếp theo: 'price_asc', 'price_desc', 'best_selling', 'rating'
     * @return array
     */
    public function getAll($category_id = null, $search = null, $min_price = null, $max_price = null, $sort_by = null)
    {
        $sql = 'SELECT p.*, c.name AS category_name, COALESCE(avg_rating.rating, 0) AS avg_rating, COALESCE(sold.total_sold, 0) AS total_sold
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                LEFT JOIN (
                    SELECT product_id, AVG(rating) AS rating FROM reviews GROUP BY product_id
                ) avg_rating ON p.id = avg_rating.product_id
                LEFT JOIN (
                    SELECT product_id, SUM(quantity) AS total_sold FROM order_items GROUP BY product_id
                ) sold ON p.id = sold.product_id
                WHERE 1=1';
        $params = [];

        if ($category_id !== null) {
            $sql .= ' AND p.category_id = :category_id';
            $params[':category_id'] = (int)$category_id;
        }

        if ($search !== null && trim($search) !== '') {
            $sql .= ' AND p.name LIKE :search';
            $params[':search'] = '%' . trim($search) . '%';
        }

        if ($min_price !== null && $min_price !== '') {
            $sql .= ' AND p.price >= :min_price';
            $params[':min_price'] = (int)$min_price;
        }

        if ($max_price !== null && $max_price !== '') {
            $sql .= ' AND p.price <= :max_price';
            $params[':max_price'] = (int)$max_price;
        }

        // Xử lý các tùy chọn sắp xếp
        switch ($sort_by) {
            case 'price_asc':
                $sql .= ' ORDER BY p.price ASC';
                break;
            case 'price_desc':
                $sql .= ' ORDER BY p.price DESC';
                break;
            case 'best_selling':
                $sql .= ' ORDER BY total_sold DESC, p.created_at DESC';
                break;
            case 'rating':
                $sql .= ' ORDER BY avg_rating DESC, p.created_at DESC';
                break;
            default:
                $sql .= ' ORDER BY p.created_at DESC';
                break;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    /**
     * Lấy sản phẩm theo ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        $sql = 'SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch();
    }

    /**
     * Lấy sản phẩm nổi bật
     * @param int $limit
     * @return array
     */
    public function getFeatured($limit = 8)
    {
        $sql = 'SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.is_featured = 1 
                ORDER BY p.created_at DESC 
                LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Lấy sản phẩm theo danh mục
     * @param int $category_id
     * @return array
     */
    public function getByCategory($category_id)
    {
        $sql = 'SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id 
                ORDER BY p.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':category_id' => (int)$category_id]);
        return $stmt->fetchAll();
    }

    /**
     * Lấy sản phẩm liên quan
     * @param int $product_id ID sản phẩm hiện tại (để loại trừ)
     * @param int $category_id Danh mục để tìm SP liên quan
     * @param int $limit
     * @return array
     */
    public function getRelated($product_id, $category_id, $limit = 4)
    {
        $sql = 'SELECT p.*, c.name AS category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = :category_id AND p.id != :product_id 
                ORDER BY RAND() 
                LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':category_id', (int)$category_id, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', (int)$product_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Tạo sản phẩm mới
     * @param array $data Dữ liệu sản phẩm
     * @return int|false ID sản phẩm mới hoặc false
     */
    public function create($data)
    {
        $sql = 'INSERT INTO products (category_id, name, slug, description, price, price_large, image, is_featured, is_new, created_at)
                VALUES (:category_id, :name, :slug, :description, :price, :price_large, :image, :is_featured, :is_new, NOW())';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':category_id' => (int)$data['category_id'],
                ':name'        => trim($data['name']),
                ':slug'        => trim($data['slug']),
                ':description' => isset($data['description']) ? trim($data['description']) : null,
                ':price'       => (int)$data['price'],
                ':price_large' => (int)$data['price_large'],
                ':image'       => isset($data['image']) ? trim($data['image']) : 'product_1.jpg',
                ':is_featured' => (int)$data['is_featured'],
                ':is_new'      => (int)$data['is_new']
            ]);
            return (int)$this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Cập nhật thông tin sản phẩm
     * @param int $id ID sản phẩm cần cập nhật
     * @param array $data Dữ liệu cập nhật
     * @return bool
     */
    public function update($id, $data)
    {
        $sql = 'UPDATE products 
                SET category_id = :category_id, name = :name, slug = :slug, description = :description, 
                    price = :price, price_large = :price_large, image = :image, is_featured = :is_featured, is_new = :is_new
                WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([
                ':id'          => (int)$id,
                ':category_id' => (int)$data['category_id'],
                ':name'        => trim($data['name']),
                ':slug'        => trim($data['slug']),
                ':description' => isset($data['description']) ? trim($data['description']) : null,
                ':price'       => (int)$data['price'],
                ':price_large' => (int)$data['price_large'],
                ':image'       => isset($data['image']) ? trim($data['image']) : 'product_1.jpg',
                ':is_featured' => (int)$data['is_featured'],
                ':is_new'      => (int)$data['is_new']
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Xóa sản phẩm theo ID
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = 'DELETE FROM products WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => (int)$id]);
    }

    /**
     * Đếm tổng số sản phẩm
     * @return int
     */
    public function countAll()
    {
        $sql = 'SELECT COUNT(*) FROM products';
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Thuật toán gợi ý sản phẩm mua kèm dựa trên lịch sử giỏ hàng thực tế (Simple AI Recommendation)
     * Lấy danh sách các sản phẩm thường được mua cùng với sản phẩm hiện tại
     * @param int $productId
     * @param int $limit
     * @return array
     */
    public function getRecommendedProducts($productId, $limit = 4)
    {
        // 1. Tìm các sản phẩm được mua cùng nhiều nhất trong bảng order_items
        $sql = 'SELECT oi2.product_id, COUNT(oi2.product_id) AS frequency, p.*, c.name AS category_name
                FROM order_items oi1
                JOIN order_items oi2 ON oi1.order_id = oi2.order_id
                JOIN products p ON oi2.product_id = p.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE oi1.product_id = :product_id1 AND oi2.product_id != :product_id2
                GROUP BY oi2.product_id
                ORDER BY frequency DESC
                LIMIT :limit';
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':product_id1', (int)$productId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id2', (int)$productId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        $recommendations = $stmt->fetchAll();

        // 2. Nếu chưa có lịch sử đơn hàng mua cùng (danh sách trống), 
        // trả về ngẫu nhiên các sản phẩm nổi bật cùng danh mục làm giải pháp fallback
        if (empty($recommendations)) {
            $product = $this->getById($productId);
            if ($product) {
                return $this->getRelated($productId, $product['category_id'], $limit);
            }
        }

        return $recommendations;
    }
}
