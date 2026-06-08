-- ========================================
-- ShopTraSua - Bản cập nhật Database tính năng tích điểm thành viên
-- ========================================

USE shoptrasua;

-- 1. Bổ sung cột points cho bảng users
ALTER TABLE users ADD COLUMN points INT DEFAULT 0;

-- 2. Bổ sung cột points_earned và points_spent cho bảng orders
ALTER TABLE orders ADD COLUMN points_earned INT DEFAULT 0 AFTER shipping_fee;
ALTER TABLE orders ADD COLUMN points_spent INT DEFAULT 0 AFTER points_earned;
