<?php
/**
 * Category Model - Quản lý danh mục sản phẩm
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Category
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Lấy tất cả danh mục
     * @return array
     */
    public function getAll()
    {
        $sql = 'SELECT * FROM categories ORDER BY id ASC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Lấy danh mục theo ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        $sql = 'SELECT * FROM categories WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch();
    }

    /**
     * Đếm tổng số danh mục
     * @return int
     */
    public function countAll()
    {
        $sql = 'SELECT COUNT(*) FROM categories';
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }
}
