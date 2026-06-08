<?php
/**
 * Coupon Model - Quản lý mã giảm giá
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Coupon
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Lấy thông tin coupon theo mã code
     * @param string $code
     * @return array|false
     */
    public function getByCode($code)
    {
        $sql = 'SELECT * FROM coupons WHERE code = :code AND status = 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':code' => strtoupper(trim($code))]);
        return $stmt->fetch();
    }

    /**
     * Kiểm tra tính hợp lệ của mã giảm giá
     * @param string $code
     * @param int $orderValue Giá trị đơn hàng hiện tại
     * @return array [success => bool, message => string, discount => int]
     */
    public function isValid($code, $orderValue)
    {
        $coupon = $this->getByCode($code);
        if (!$coupon) {
            return [
                'success'  => false,
                'message'  => 'Mã giảm giá không tồn tại hoặc đã hết hiệu lực.',
                'discount' => 0
            ];
        }

        // Kiểm tra hạn sử dụng
        $expiryDate = strtotime($coupon['expiry_date']);
        $today = strtotime(date('Y-m-d'));
        if ($today > $expiryDate) {
            return [
                'success'  => false,
                'message'  => 'Mã giảm giá này đã hết hạn sử dụng.',
                'discount' => 0
            ];
        }

        // Kiểm tra giá trị đơn hàng tối thiểu
        if ($orderValue < $coupon['min_order_value']) {
            return [
                'success'  => false,
                'message'  => 'Đơn hàng chưa đạt giá trị tối thiểu ' . number_format($coupon['min_order_value']) . 'đ để áp dụng mã này.',
                'discount' => 0
            ];
        }

        return [
            'success'  => true,
            'message'  => 'Áp dụng mã giảm giá thành công!',
            'discount' => (int)$coupon['discount_value']
        ];
    }
}
