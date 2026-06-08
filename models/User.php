<?php
/**
 * User Model - Quản lý người dùng
 * Shoptrasua - Cửa hàng trà sữa online
 */

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Đăng nhập người dùng
     * @param string $email
     * @param string $password
     * @return array|false Trả về thông tin user nếu thành công, false nếu thất bại
     */
    public function login($email, $password)
    {
        $user = $this->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // Đặt thông tin vào session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['logged_in'] = true;

            return $user;
        }

        return false;
    }

    /**
     * Đăng ký tài khoản mới
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $phone
     * @return int|false ID người dùng mới hoặc false nếu thất bại
     */
    public function register($name, $email, $password, $phone)
    {
        // Kiểm tra email đã tồn tại chưa
        if ($this->findByEmail($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (name, email, password, phone, created_at) 
                VALUES (:name, :email, :password, :phone, NOW())';
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([
                ':name'     => trim($name),
                ':email'    => trim($email),
                ':password' => $hashedPassword,
                ':phone'    => trim($phone),
            ]);

            $userId = (int)$this->db->lastInsertId();

            // Tự động đăng nhập sau khi đăng ký
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = trim($name);
            $_SESSION['user_email'] = trim($email);
            $_SESSION['user_role'] = 'user';
            $_SESSION['logged_in'] = true;

            return $userId;
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Tìm người dùng theo email
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => trim($email)]);
        return $stmt->fetch();
    }

    /**
     * Kiểm tra người dùng đã đăng nhập chưa
     * @return bool
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Kiểm tra người dùng hiện tại có phải admin không
     * @return bool
     */
    public static function isAdmin()
    {
        return self::isLoggedIn() && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }

    /**
     * Đăng xuất
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_role']);
        unset($_SESSION['logged_in']);
    }

    /**
     * Đếm tổng số người dùng
     * @return int
     */
    public function countAll()
    {
        $sql = 'SELECT COUNT(*) FROM users';
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Lấy danh sách tất cả người dùng
     * @return array
     */
    public function getAll()
    {
        $sql = 'SELECT id, name, email, phone, role, created_at FROM users ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Tìm người dùng theo ID
     * @param int $id
     * @return array|false
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch();
    }

    /**
     * Cập nhật số điểm của người dùng
     * @param int $id
     * @param int $points
     * @return bool
     */
    public function updatePoints($id, $points)
    {
        $sql = 'UPDATE users SET points = :points WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':points' => (int)$points,
            ':id'     => (int)$id
        ]);
    }
}
