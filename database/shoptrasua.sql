-- ========================================
-- ShopTraSua - Cơ sở dữ liệu
-- Cửa hàng trà sữa online
-- ========================================

SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Tạo database
CREATE DATABASE IF NOT EXISTS shoptrasua
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE shoptrasua;

-- ========================================
-- Bảng người dùng
-- ========================================
DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    role VARCHAR(20) DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Bảng danh mục
-- ========================================
DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    icon VARCHAR(50) DEFAULT NULL,
    description TEXT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Bảng sản phẩm
-- ========================================
DROP TABLE IF EXISTS products;
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    description TEXT DEFAULT NULL,
    price INT NOT NULL DEFAULT 0,
    price_large INT NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    is_new TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- Dữ liệu danh mục
-- ========================================
INSERT INTO categories (id, name, slug, icon, description) VALUES
(1, 'Trà Sữa Truyền Thống', 'tra-sua-truyen-thong', '🧋', 'Các loại trà sữa truyền thống với hương vị đậm đà, quen thuộc'),
(2, 'Trà Sữa Đặc Biệt', 'tra-sua-dac-biet', '⭐', 'Trà sữa phiên bản đặc biệt với công thức độc quyền'),
(3, 'Trà Trái Cây', 'tra-trai-cay', '🍊', 'Trà kết hợp trái cây tươi, thanh mát và bổ dưỡng'),
(4, 'Cà Phê', 'ca-phe', '☕', 'Cà phê pha chế theo phong cách hiện đại'),
(5, 'Đá Xay', 'da-xay', '🧊', 'Thức uống đá xay mát lạnh, tuyệt vời cho mùa hè'),
(6, 'Topping', 'topping', '🧁', 'Các loại topping thêm vào đồ uống yêu thích');

-- ========================================
-- Dữ liệu sản phẩm
-- ========================================
INSERT INTO products (id, category_id, name, slug, description, price, price_large, image, is_featured, is_new) VALUES

-- Trà Sữa Truyền Thống (category_id = 1)
(1, 1, 'Trà Sữa Trân Châu Đen', 'tra-sua-tran-chau-den',
    'Trà sữa thơm béo kết hợp trân châu đen dai giòn, vị ngọt thanh tự nhiên. Một trong những thức uống được yêu thích nhất tại cửa hàng.',
    45000, 55000, 'tra_sua_tran_chau_duong_den.png', 1, 0),

(2, 1, 'Trà Sữa Matcha', 'tra-sua-matcha',
    'Trà xanh matcha Nhật Bản hòa quyện cùng sữa tươi, tạo nên hương vị đậm đà và thanh mát. Thích hợp cho người yêu thích trà xanh.',
    50000, 60000, 'tra_sua_matcha.png', 1, 0),

(3, 1, 'Trà Sữa Khoai Môn', 'tra-sua-khoai-mon',
    'Khoai môn tươi xay nhuyễn kết hợp trà sữa, mang đến vị ngọt bùi tự nhiên và màu tím pastel bắt mắt.',
    48000, 58000, 'tra_sua_khoai_mon.png', 1, 0),

(4, 1, 'Trà Sữa Socola', 'tra-sua-socola',
    'Socola nguyên chất kết hợp trà sữa béo ngậy, tạo nên thức uống ngọt ngào dành cho các tín đồ chocolate.',
    45000, 55000, 'tra_sua_socola.png', 0, 0),

(5, 1, 'Trà Sữa Caramel', 'tra-sua-caramel',
    'Trà sữa với lớp caramel thơm lừng, vị ngọt đắng hài hòa. Topping caramel cháy giòn tan trên miệng.',
    50000, 60000, 'tra_sua_caramel.png', 0, 0),

(6, 1, 'Trà Sữa Oolong', 'tra-sua-oolong',
    'Trà oolong cao cấp pha cùng sữa tươi, hương trà đậm và thanh, hậu vị ngọt dịu tự nhiên.',
    42000, 52000, 'tra_sua_oolong.png', 1, 0),

(7, 1, 'Hồng Trà Sữa', 'hong-tra-sua',
    'Hồng trà đậm vị kết hợp sữa tươi béo ngậy, công thức truyền thống với hương thơm quyến rũ.',
    40000, 50000, 'hong_tra_sua.png', 0, 0),

-- Trà Sữa Đặc Biệt (category_id = 2)
(8, 2, 'Trà Sữa Pudding', 'tra-sua-pudding',
    'Trà sữa đặc biệt với pudding trứng mềm mịn, béo ngậy. Sự kết hợp hoàn hảo giữa trà sữa và topping cao cấp.',
    52000, 62000, 'tra_sua_pudding.png', 1, 1),

(9, 2, 'Brown Sugar Boba', 'brown-sugar-boba',
    'Trân châu đường nâu nổi tiếng từ Đài Loan, vân đường nâu hổ phách đẹp mắt, vị ngọt thơm đặc trưng.',
    55000, 65000, 'brown_sugar_boba.png', 1, 1),

(10, 2, 'Trà Sữa Tiger', 'tra-sua-tiger',
    'Trà sữa phiên bản đặc biệt với vân hổ từ đường nâu, trân châu tươi và sữa tươi nguyên chất.',
    58000, 68000, 'tra_sua_tiger.png', 1, 1),

-- Trà Trái Cây (category_id = 3)
(11, 3, 'Trà Đào Cam Sả', 'tra-dao-cam-sa',
    'Trà hoa quả thanh mát với đào tươi, cam vàng và sả thơm. Thức uống detox hoàn hảo cho ngày hè.',
    45000, 55000, 'tra_dao_cam_sa.png', 1, 0),

(12, 3, 'Trà Vải', 'tra-vai',
    'Trà xanh kết hợp vải thiều tươi ngọt, thêm thạch vải giòn mát. Hương vị nhiệt đới tươi mát.',
    42000, 52000, 'tra_vai.png', 0, 0),

(13, 3, 'Trà Chanh Dây', 'tra-chanh-day',
    'Trà hoa quả với chanh dây tươi, vị chua ngọt tự nhiên, giàu vitamin C. Rất tốt cho sức khỏe.',
    40000, 50000, 'tra_chanh_day.png', 0, 1),

-- Cà Phê (category_id = 4)
(14, 4, 'Cà Phê Sữa Đá', 'ca-phe-sua-da',
    'Cà phê phin truyền thống Việt Nam với sữa đặc, đậm đà và thơm lừng. Pha theo công thức đặc biệt.',
    35000, 45000, 'ca_phe_sua_da.png', 0, 0),

(15, 4, 'Cà Phê Caramel', 'ca-phe-caramel',
    'Cà phê espresso kết hợp sốt caramel thơm lừng và sữa tươi. Vị đắng ngọt hài hòa.',
    50000, 60000, 'ca_phe_caramel.png', 0, 0),

(16, 4, 'Cà Phê Mocha', 'ca-phe-mocha',
    'Espresso đậm đà hòa quyện cùng socola và sữa tươi, phủ kem whip béo ngậy trên mặt.',
    55000, 65000, 'ca_phe_mocha.png', 0, 0),

-- Đá Xay (category_id = 5)
(17, 5, 'Matcha Đá Xay', 'matcha-da-xay',
    'Matcha Nhật Bản xay nhuyễn cùng đá, sữa tươi và kem whip. Thức uống mát lạnh cho mùa hè.',
    55000, 65000, 'matcha_da_xay.png', 0, 0),

(18, 5, 'Oreo Đá Xay', 'oreo-da-xay',
    'Kem vanilla xay cùng đá và bánh Oreo giòn rụm. Thức uống yêu thích của các bạn trẻ.',
    52000, 62000, 'oreo_da_xay.png', 0, 0),

(19, 5, 'Chocolate Đá Xay', 'chocolate-da-xay',
    'Socola nguyên chất xay cùng đá và sữa tươi, phủ kem whip và bột cacao. Đậm vị chocolate.',
    50000, 60000, 'chocolate_da_xay.png', 0, 0),

-- Topping (category_id = 6)
(20, 6, 'Trân Châu Đen', 'tran-chau-den',
    'Trân châu đen truyền thống dai giòn, nấu từ bột năng tự nhiên. Topping không thể thiếu cho trà sữa.',
    10000, 10000, 'topping_tran_chau_den.png', 0, 0),

(21, 6, 'Pudding Trứng', 'pudding-trung',
    'Pudding trứng mềm mịn, béo ngậy với hương vanilla. Topping cao cấp cho mọi thức uống.',
    12000, 12000, 'topping_pudding_trung.png', 0, 0),

(22, 6, 'Thạch Rau Câu', 'thach-rau-cau',
    'Thạch rau câu nhiều màu sắc, giòn mát và ít calories. Topping nhẹ nhàng cho đồ uống.',
    8000, 8000, 'topping_thach_rau_cau.png', 0, 0);

-- ========================================
-- Tạo tài khoản admin mẫu
-- Mật khẩu: admin123
-- ========================================
INSERT INTO users (name, email, password, phone, role) VALUES
('Admin', 'admin@shoptrasua.vn', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0901234567', 'admin');
