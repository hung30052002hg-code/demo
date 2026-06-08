<?php
/**
 * Cart Model - Giỏ hàng dựa trên Session
 * Shoptrasua - Cửa hàng trà sữa online
 */

class Cart
{
    /**
     * Khởi tạo giỏ hàng trong session nếu chưa có
     */
    public function __construct()
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     * @param int $product_id
     * @param int $quantity
     * @param string $size Kích thước: 'M' hoặc 'L'
     * @param string $ice Mức đá: '100%', '70%', '50%', '0%'
     * @param string $sugar Mức đường: '100%', '70%', '50%', '30%', '0%'
     * @param array $toppings Mảng ID của các topping đi kèm
     * @return bool
     */
    public function add($product_id, $quantity = 1, $size = 'M', $ice = '100%', $sugar = '100%', $toppings = [])
    {
        $product_id = (int)$product_id;
        $quantity = max(1, (int)$quantity);
        $size = in_array($size, ['M', 'L']) ? $size : 'M';
        $ice = in_array($ice, ['100%', '70%', '50%', '0%']) ? $ice : '100%';
        $sugar = in_array($sugar, ['100%', '70%', '50%', '30%', '0%']) ? $sugar : '100%';

        // Chuẩn hóa và sắp xếp topping IDs
        if (!is_array($toppings)) {
            $toppings = [];
        }
        $toppings = array_map('intval', $toppings);
        sort($toppings);
        $toppingsStr = implode(',', $toppings);

        // Tạo key duy nhất cho sản phẩm + size + đá + đường + toppings
        $cartKey = $product_id . '_' . $size . '_' . str_replace('%', '', $ice) . '_' . str_replace('%', '', $sugar) . '_' . $toppingsStr;

        if (isset($_SESSION['cart'][$cartKey])) {
            // Sản phẩm đã có trong giỏ cùng cấu hình → tăng số lượng
            $_SESSION['cart'][$cartKey]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới kèm cấu hình tùy biến
            $_SESSION['cart'][$cartKey] = [
                'product_id' => $product_id,
                'quantity'   => $quantity,
                'size'       => $size,
                'ice'        => $ice,
                'sugar'      => $sugar,
                'toppings'   => $toppings,
            ];
        }

        return true;
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     * @param string $cartKey Key của sản phẩm trong giỏ (product_id_size_ice_sugar_toppings)
     * @return bool
     */
    public function remove($cartKey)
    {
        if (isset($_SESSION['cart'][$cartKey])) {
            unset($_SESSION['cart'][$cartKey]);
            return true;
        }
        return false;
    }

    /**
     * Cập nhật số lượng sản phẩm
     * @param string $cartKey Key của sản phẩm trong giỏ
     * @param int $quantity Số lượng mới
     * @return bool
     */
    public function update($cartKey, $quantity)
    {
        $quantity = (int)$quantity;

        if ($quantity <= 0) {
            return $this->remove($cartKey);
        }

        if (isset($_SESSION['cart'][$cartKey])) {
            $_SESSION['cart'][$cartKey]['quantity'] = $quantity;
            return true;
        }

        return false;
    }

    /**
     * Lấy tất cả sản phẩm trong giỏ kèm thông tin chi tiết từ DB
     * @return array
     */
    public function getItems()
    {
        $items = [];

        if (empty($_SESSION['cart'])) {
            return $items;
        }

        $db = Database::getInstance();

        foreach ($_SESSION['cart'] as $cartKey => $cartItem) {
            $sql = 'SELECT * FROM products WHERE id = :id';
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $cartItem['product_id']]);
            $product = $stmt->fetch();

            if ($product) {
                // Xác định giá gốc theo size
                $basePrice = ($cartItem['size'] === 'L') ? $product['price_large'] : $product['price'];

                // Tìm thông tin chi tiết và giá của các topping đi kèm
                $toppingsDetails = [];
                $toppingPriceSum = 0;
                if (!empty($cartItem['toppings'])) {
                    $placeholders = implode(',', array_fill(0, count($cartItem['toppings']), '?'));
                    $sqlToppings = "SELECT id, name, price FROM products WHERE id IN ($placeholders)";
                    $stmtToppings = $db->prepare($sqlToppings);
                    $stmtToppings->execute($cartItem['toppings']);
                    $toppingsList = $stmtToppings->fetchAll();
                    foreach ($toppingsList as $topping) {
                        $toppingsDetails[] = [
                            'id'    => $topping['id'],
                            'name'  => $topping['name'],
                            'price' => $topping['price']
                        ];
                        $toppingPriceSum += $topping['price'];
                    }
                }

                // Đơn giá cuối cùng = Giá sản phẩm theo size + Tổng giá các topping đi kèm
                $finalPrice = $basePrice + $toppingPriceSum;

                $items[] = [
                    'cart_key'         => $cartKey,
                    'product_id'       => $cartItem['product_id'],
                    'name'             => $product['name'],
                    'image'            => $product['image'],
                    'size'             => $cartItem['size'],
                    'ice'              => $cartItem['ice'] ?? '100%',
                    'sugar'            => $cartItem['sugar'] ?? '100%',
                    'toppings'         => $toppingsDetails,
                    'price'            => $finalPrice,
                    'quantity'         => $cartItem['quantity'],
                    'subtotal'         => $finalPrice * $cartItem['quantity'],
                ];
            } else {
                // Sản phẩm không còn tồn tại → xóa khỏi giỏ
                unset($_SESSION['cart'][$cartKey]);
            }
        }

        return $items;
    }

    /**
     * Tính tổng tiền giỏ hàng
     * @return int
     */
    public function getTotal()
    {
        $total = 0;
        $items = $this->getItems();

        foreach ($items as $item) {
            $total += $item['subtotal'];
        }

        return $total;
    }

    /**
     * Đếm tổng số lượng sản phẩm trong giỏ
     * @return int
     */
    public function getCount()
    {
        $count = 0;

        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }

        return $count;
    }

    /**
     * Xóa toàn bộ giỏ hàng
     * @return void
     */
    public function clear()
    {
        $_SESSION['cart'] = [];
    }
}
