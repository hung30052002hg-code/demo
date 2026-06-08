<?php
/**
 * Wishlist Model - Quản lý danh sách sản phẩm yêu thích
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Wishlist
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Thêm sản phẩm vào danh sách yêu thích
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function add($userId, $productId)
    {
        $sql = 'INSERT IGNORE INTO wishlists (user_id, product_id, created_at)
                VALUES (:user_id, :product_id, NOW())';
        $stmt = $this->db->prepare($sql);
        try {
            return $stmt->execute([
                ':user_id'    => (int)$userId,
                ':product_id' => (int)$productId
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Xóa sản phẩm khỏi danh sách yêu thích
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function remove($userId, $productId)
    {
        $sql = 'DELETE FROM wishlists WHERE user_id = :user_id AND product_id = :product_id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':user_id'    => (int)$userId,
            ':product_id' => (int)$productId
        ]);
    }

    /**
     * Lấy danh sách sản phẩm yêu thích của người dùng
     * @param int $userId
     * @return array
     */
    public function getByUserId($userId)
    {
        $sql = 'SELECT w.id AS wishlist_id, p.*, c.name AS category_name
                FROM wishlists w
                JOIN products p ON w.product_id = p.id
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE w.user_id = :user_id
                ORDER BY w.created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => (int)$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Kiểm tra xem sản phẩm đã được yêu thích chưa
     * @param int $userId
     * @param int $productId
     * @return bool
     */
    public function isFavorited($userId, $productId)
    {
        $sql = 'SELECT COUNT(*) FROM wishlists WHERE user_id = :user_id AND product_id = :product_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id'    => (int)$userId,
            ':product_id' => (int)$productId
        ]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
