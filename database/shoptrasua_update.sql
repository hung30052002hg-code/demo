-- ========================================
-- ShopTraSua - Bản cập nhật Database tính năng mở rộng
-- Cập nhật cấu trúc bảng và thêm các bảng mới
-- ========================================

USE shoptrasua;

-- 1. Bổ sung cột stock_quantity cho bảng products (Quản lý tồn kho)
-- Nếu chưa có cột stock_quantity thì thêm vào
SET @dbname = DATABASE();
SET @tablename = "products";
SET @columnname = "stock_quantity";
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_name = @tablename
     AND column_name = @columnname
     AND table_schema = @dbname) = 0,
  "ALTER TABLE products ADD COLUMN stock_quantity INT NOT NULL DEFAULT 100 AFTER image;",
  "SELECT 1;"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- 2. Tạo bảng quản lý đơn hàng
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_money INT NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50) NOT NULL DEFAULT 'COD',
    payment_status ENUM('unpaid', 'paid') DEFAULT 'unpaid',
    shipping_fee INT NOT NULL DEFAULT 30000,
    shipping_address TEXT NOT NULL,
    phone VARCHAR(20) NOT NULL,
    note TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tạo bảng chi tiết đơn hàng
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    size ENUM('M', 'L') DEFAULT 'M',
    sugar_level VARCHAR(20) DEFAULT '100%',
    ice_level VARCHAR(20) DEFAULT '100%',
    toppings VARCHAR(255) DEFAULT NULL,
    price INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tạo bảng đánh giá và bình luận sản phẩm
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tạo bảng sản phẩm yêu thích (Wishlist)
CREATE TABLE IF NOT EXISTS wishlists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_product (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tạo bảng thư liên hệ và phản hồi
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tạo bảng mã giảm giá (Coupons)
CREATE TABLE IF NOT EXISTS coupons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(20) UNIQUE NOT NULL,
    discount_value INT NOT NULL,
    min_order_value INT DEFAULT 0,
    expiry_date DATE NOT NULL,
    status TINYINT DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tạo bảng đăng ký nhận tin tức (Newsletter)
CREATE TABLE IF NOT EXISTS newsletters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Chèn dữ liệu mẫu cho mã giảm giá
INSERT IGNORE INTO coupons (code, discount_value, min_order_value, expiry_date, status) VALUES
('STARBUCKS10', 10000, 50000, '2026-12-31', 1),
('CHUSTEAFREE', 20000, 100000, '2026-12-31', 1),
('WELCOME50', 50000, 200000, '2026-12-31', 1);

-- 9. Bổ sung cấu trúc tùy chọn trà sữa và phí ship giao hàng
ALTER TABLE order_items ADD COLUMN sugar_level VARCHAR(20) DEFAULT '100%' AFTER size;
ALTER TABLE order_items ADD COLUMN ice_level VARCHAR(20) DEFAULT '100%' AFTER sugar_level;
ALTER TABLE order_items ADD COLUMN toppings VARCHAR(255) DEFAULT NULL AFTER ice_level;
ALTER TABLE orders ADD COLUMN shipping_fee INT NOT NULL DEFAULT 30000 AFTER payment_status;
