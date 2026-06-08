<?php
/**
 * Order Model - Quản lý đơn hàng và thống kê doanh số
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Order
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tạo đơn hàng mới kèm theo chi tiết sản phẩm
     * @param array $orderData Dữ liệu chung đơn hàng
     * @param array $items Chi tiết giỏ hàng
     * @return int|false ID đơn hàng mới hoặc false
     */
    public function create($orderData, $items)
    {
        try {
            $this->db->beginTransaction();

            // 1. Chèn thông tin chung đơn hàng
            $sqlOrder = 'INSERT INTO orders (user_id, total_money, status, payment_method, payment_status, shipping_fee, points_earned, points_spent, shipping_address, phone, note, created_at)
                         VALUES (:user_id, :total_money, :status, :payment_method, :payment_status, :shipping_fee, :points_earned, :points_spent, :shipping_address, :phone, :note, NOW())';
            $stmtOrder = $this->db->prepare($sqlOrder);
            $stmtOrder->execute([
                ':user_id'          => (int)$orderData['user_id'],
                ':total_money'      => (int)$orderData['total_money'],
                ':status'           => $orderData['status'] ?? 'pending',
                ':payment_method'   => trim($orderData['payment_method']),
                ':payment_status'   => $orderData['payment_status'] ?? 'unpaid',
                ':shipping_fee'     => (int)($orderData['shipping_fee'] ?? 30000),
                ':points_earned'    => (int)($orderData['points_earned'] ?? 0),
                ':points_spent'     => (int)($orderData['points_spent'] ?? 0),
                ':shipping_address' => trim($orderData['shipping_address']),
                ':phone'            => trim($orderData['phone']),
                ':note'             => isset($orderData['note']) ? trim($orderData['note']) : null
            ]);

            $orderId = (int)$this->db->lastInsertId();

            // 1.5. Khấu trừ điểm tích lũy của user nếu có tiêu
            if (isset($orderData['points_spent']) && $orderData['points_spent'] > 0) {
                $sqlUpdatePoints = 'UPDATE users SET points = points - :points WHERE id = :user_id';
                $stmtUpdatePoints = $this->db->prepare($sqlUpdatePoints);
                $stmtUpdatePoints->execute([
                    ':points'  => (int)$orderData['points_spent'],
                    ':user_id' => (int)$orderData['user_id']
                ]);
            }

            // 2. Chèn chi tiết các sản phẩm trong đơn hàng
            $sqlItem = 'INSERT INTO order_items (order_id, product_id, quantity, size, sugar_level, ice_level, toppings, price)
                        VALUES (:order_id, :product_id, :quantity, :size, :sugar_level, :ice_level, :toppings, :price)';
            $stmtItem = $this->db->prepare($sqlItem);

            // Cập nhật tồn kho sản phẩm
            $sqlUpdateStock = 'UPDATE products SET stock_quantity = stock_quantity - :qty WHERE id = :id';
            $stmtUpdateStock = $this->db->prepare($sqlUpdateStock);

            foreach ($items as $item) {
                // Thu thập tên topping dạng chuỗi
                $toppingNames = null;
                if (!empty($item['toppings'])) {
                    $toppingNames = implode(', ', array_column($item['toppings'], 'name'));
                }

                // Thêm chi tiết đơn
                $stmtItem->execute([
                    ':order_id'     => $orderId,
                    ':product_id'   => (int)$item['product_id'],
                    ':quantity'     => (int)$item['quantity'],
                    ':size'         => $item['size'],
                    ':sugar_level'  => $item['sugar'] ?? '100%',
                    ':ice_level'    => $item['ice'] ?? '100%',
                    ':toppings'     => $toppingNames,
                    ':price'        => (int)$item['price']
                ]);

                // Trừ tồn kho sản phẩm tương ứng (Trừ tồn kho của sản phẩm gốc)
                $stmtUpdateStock->execute([
                    ':qty' => (int)$item['quantity'],
                    ':id'  => (int)$item['product_id']
                ]);
            }

            $this->db->commit();
            return $orderId;

        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Lấy danh sách tất cả đơn hàng (cho admin)
     * @return array
     */
    public function getAll()
    {
        $sql = 'SELECT o.*, u.name AS user_name, u.email AS user_email 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                ORDER BY o.created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Lấy danh sách đơn hàng của một người dùng
     * @param int $userId
     * @return array
     */
    public function getUserOrders($userId)
    {
        $sql = 'SELECT * FROM orders WHERE user_id = :user_id ORDER BY created_at DESC';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => (int)$userId]);
        return $stmt->fetchAll();
    }

    /**
     * Lấy chi tiết một đơn hàng theo ID
     * @param int $id
     * @return array|false
     */
    public function getById($id)
    {
        $sql = 'SELECT o.*, u.name AS user_name, u.email AS user_email 
                FROM orders o 
                JOIN users u ON o.user_id = u.id 
                WHERE o.id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => (int)$id]);
        return $stmt->fetch();
    }

    /**
     * Lấy các sản phẩm trong đơn hàng
     * @param int $orderId
     * @return array
     */
    public function getItems($orderId)
    {
        $sql = 'SELECT oi.*, p.name AS product_name, p.image AS product_image 
                FROM order_items oi 
                JOIN products p ON oi.product_id = p.id 
                WHERE oi.order_id = :order_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':order_id' => (int)$orderId]);
        return $stmt->fetchAll();
    }

    /**
     * Cập nhật trạng thái đơn hàng
     * @param int $id
     * @param string $status
     * @return bool
     */
    public function updateStatus($id, $status)
    {
        $sql = 'UPDATE orders SET status = :status WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id'     => (int)$id
        ]);
    }

    /**
     * Cập nhật trạng thái thanh toán
     * @param int $id
     * @param string $payment_status
     * @return bool
     */
    public function updatePaymentStatus($id, $payment_status)
    {
        $sql = 'UPDATE orders SET payment_status = :payment_status WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':payment_status' => $payment_status,
            ':id'             => (int)$id
        ]);
    }

    /**
     * Đếm tổng số đơn hàng
     * @return int
     */
    public function countAll()
    {
        $sql = 'SELECT COUNT(*) FROM orders';
        $stmt = $this->db->query($sql);
        return (int)$stmt->fetchColumn();
    }

    /**
     * Thống kê sản phẩm bán chạy nhất
     * @param int $limit
     * @return array
     */
    public function getBestSellers($limit = 5)
    {
        $sql = 'SELECT p.id, p.name, SUM(oi.quantity) AS total_sold, SUM(oi.quantity * oi.price) AS total_revenue
                FROM order_items oi
                JOIN products p ON oi.product_id = p.id
                JOIN orders o ON oi.order_id = o.id
                WHERE o.status = "completed"
                GROUP BY oi.product_id
                ORDER BY total_sold DESC
                LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Thống kê khách hàng tiềm năng (chi tiêu nhiều nhất)
     * @param int $limit
     * @return array
     */
    public function getTopCustomers($limit = 5)
    {
        $sql = 'SELECT u.id, u.name, u.email, COUNT(o.id) AS total_orders, SUM(o.total_money) AS total_spent
                FROM orders o
                JOIN users u ON o.user_id = u.id
                WHERE o.status = "completed"
                GROUP BY o.user_id
                ORDER BY total_spent DESC
                LIMIT :limit';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Hủy đơn hàng, hoàn lại kho và hoàn lại điểm tích lũy đã tiêu
     * @param int $orderId
     * @return bool
     */
    public function cancelOrder($orderId)
    {
        try {
            $this->db->beginTransaction();

            // 1. Lấy thông tin đơn hàng
            $order = $this->getById($orderId);
            if (!$order || $order['status'] === 'cancelled') {
                $this->db->rollBack();
                return false;
            }

            // 2. Cập nhật trạng thái đơn thành cancelled
            $sqlStatus = 'UPDATE orders SET status = "cancelled" WHERE id = :id';
            $stmtStatus = $this->db->prepare($sqlStatus);
            $stmtStatus->execute([':id' => $orderId]);

            // 3. Hoàn lại tồn kho sản phẩm
            $items = $this->getItems($orderId);
            $sqlUpdateStock = 'UPDATE products SET stock_quantity = stock_quantity + :qty WHERE id = :id';
            $stmtUpdateStock = $this->db->prepare($sqlUpdateStock);

            foreach ($items as $item) {
                $stmtUpdateStock->execute([
                    ':qty' => (int)$item['quantity'],
                    ':id'  => (int)$item['product_id']
                ]);
            }

            // 4. Hoàn lại điểm tích lũy đã dùng (nếu có)
            if (isset($order['points_spent']) && $order['points_spent'] > 0) {
                $sqlUpdatePoints = 'UPDATE users SET points = points + :points WHERE id = :user_id';
                $stmtUpdatePoints = $this->db->prepare($sqlUpdatePoints);
                $stmtUpdatePoints->execute([
                    ':points'  => (int)$order['points_spent'],
                    ':user_id' => (int)$order['user_id']
                ]);
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            return false;
        }
    }
}
