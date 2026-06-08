<?php
/**
 * Database Singleton - Quản lý kết nối PDO
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Database
{
    private static $instance = null;

    /**
     * Lấy instance PDO (Singleton pattern)
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            $config = require ROOT_PATH . 'config/database.php';

            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['dbname'],
                $config['charset']
            );

            try {
                self::$instance = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $config['options']
                );
            } catch (PDOException $e) {
                die('Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage());
            }
        }

        return self::$instance;
    }

    // Ngăn chặn clone và construct từ bên ngoài
    private function __construct() {}
    private function __clone() {}
}
