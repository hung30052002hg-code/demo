<?php
/**
 * Contact Model - Quản lý liên hệ và góp ý từ khách hàng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Contact
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Gửi liên hệ mới
     * @param array $data
     * @return int|false ID liên hệ mới hoặc false
     */
    public function create($data)
    {
        $sql = 'INSERT INTO contacts (name, email, subject, message, created_at)
                VALUES (:name, :email, :subject, :message, NOW())';
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute([
                ':name'    => trim($data['name']),
                ':email'   => trim($data['email']),
                ':subject' => isset($data['subject']) ? trim($data['subject']) : null,
                ':message' => trim($data['message'])
            ]);
            return (int)$this->db->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Lấy toàn bộ danh sách liên hệ (cho admin)
     * @return array
     */
    public function getAll()
    {
        $sql = 'SELECT * FROM contacts ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
