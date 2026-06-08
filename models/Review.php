<?php
/**
 * Review Model - Quản lý đánh giá và bình luận sản phẩm
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Review
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tạo đánh giá/bình luận mới
     * @param array $data Dữ liệu đánh giá
     * @return int|false ID đánh giá mới hoặc false
     */
    public function create($data)
    {
        $sql = 'INSERT INTO reviews (user_id, product_id, rating, comment, created_at)
                VALUES (:user_id, :product_id, :rating, :comment, NOW())';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':user_id'    => (int)$data['user_id'],
                ':product_id' => (int)$data['product_id'],
                ':rating'     => (int)$data['rating'],
                ':comment'    => isset($data['comment']) ? trim($data['comment']) : null
            ]);
            return (int)$this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Lấy tất cả đánh giá của một sản phẩm
     * @param int $productId
     * @return array
     */
    public function getByProductId($productId)
    {
        $sql = 'SELECT r.*, u.name AS user_name 
                FROM reviews r 
                JOIN users u ON r.user_id = u.id 
                WHERE r.product_id = :product_id 
                ORDER BY r.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => (int)$productId]);
        return $stmt->fetchAll();
    }

    /**
     * Lấy điểm số đánh giá trung bình và tổng số đánh giá
     * @param int $productId
     * @return array [avg_rating, total_reviews]
     */
    public function getAverageRating($productId)
    {
        $sql = 'SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews 
                FROM reviews 
                WHERE product_id = :product_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':product_id' => (int)$productId]);
        $result = $stmt->fetch();
        
        return [
            'avg_rating'    => $result['avg_rating'] !== null ? round((float)$result['avg_rating'], 1) : 0,
            'total_reviews' => (int)$result['total_reviews']
        ];
    }
}
