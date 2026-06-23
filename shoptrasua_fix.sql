-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: shoptrasua
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Trà Sữa Truyền Thống','tra-sua-truyen-thong','🧋','Các loại trà sữa truyền thống với hương vị đậm đà, quen thuộc'),(2,'Trà Sữa Đặc Biệt','tra-sua-dac-biet','⭐','Trà sữa phiên bản đặc biệt với công thức độc quyền'),(3,'Trà Trái Cây','tra-trai-cay','🍊','Trà kết hợp trái cây tươi, thanh mát và bổ dưỡng'),(4,'Cà Phê','ca-phe','☕','Cà phê pha chế theo phong cách hiện đại'),(5,'Đá Xay','da-xay','🧊','Thức uống đá xay mát lạnh, tuyệt vời cho mùa hè'),(6,'Topping','topping','🧁','Các loại topping thêm vào đồ uống yêu thích');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL,
  `discount_value` int(11) NOT NULL,
  `min_order_value` int(11) DEFAULT 0,
  `expiry_date` date NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
INSERT INTO `coupons` VALUES (1,'STARBUCKS10',10000,50000,'2026-12-31',1),(2,'CHUSTEAFREE',20000,100000,'2026-12-31',1),(3,'WELCOME50',50000,200000,'2026-12-31',1);
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `size` enum('M','L') DEFAULT 'M',
  `sugar_level` varchar(20) DEFAULT '100%',
  `ice_level` varchar(20) DEFAULT '100%',
  `toppings` varchar(255) DEFAULT NULL,
  `price` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,1,2,'M','100%','100%',NULL,45000),(2,2,1,1,'M','100%','100%',NULL,45000),(3,2,2,1,'M','100%','100%',NULL,50000),(4,2,3,1,'M','100%','100%',NULL,48000),(5,3,1,2,'M','100%','100%',NULL,45000),(6,4,2,2,'M','100%','100%',NULL,50000),(7,5,1,2,'M','100%','100%',NULL,45000),(8,6,12,2,'M','100%','100%',NULL,42000),(9,7,2,2,'L','70%','70%','Trân Châu Đen, Pudding Trứng, Thạch Rau Câu',90000),(10,8,2,1,'M','100%','100%',NULL,50000);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `total_money` int(11) NOT NULL,
  `status` enum('pending','processing','shipped','completed','cancelled') DEFAULT 'pending',
  `payment_method` varchar(50) NOT NULL DEFAULT 'COD',
  `payment_status` enum('unpaid','paid') DEFAULT 'unpaid',
  `shipping_fee` int(11) NOT NULL DEFAULT 30000,
  `points_earned` int(11) DEFAULT 0,
  `points_spent` int(11) DEFAULT 0,
  `shipping_address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,2,80000,'pending','ONLINE','paid',30000,0,0,'dd','0123456789','','2026-06-06 11:39:52'),(2,4,123000,'completed','COD','paid',30000,0,0,'só 33','1923948594','','2026-06-06 20:01:19'),(3,4,105000,'cancelled','ONLINE','unpaid',15000,9,0,'dd','0123456789','','2026-06-07 09:24:21'),(4,4,115000,'processing','ONLINE','paid',15000,10,0,'dd','0123456789','','2026-06-07 09:25:00'),(5,4,105000,'cancelled','COD','unpaid',15000,9,0,'dd','0123456789','','2026-06-07 09:27:58'),(6,4,99000,'processing','ONLINE','paid',15000,8,0,'dd','0123456789','','2026-06-08 01:41:29'),(7,4,175000,'pending','ONLINE','unpaid',15000,16,0,'dd','0123456789','','2026-06-08 16:13:44'),(8,4,65000,'pending','COD','unpaid',15000,5,0,'dd','0123456789','','2026-06-11 01:09:15');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `price_large` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 100,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_new` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Trà Sữa Trân Châu Đen','tra-sua-tran-chau-den','Trà sữa thơm béo kết hợp trân châu đen dai giòn, vị ngọt thanh tự nhiên. Một trong những thức uống được yêu thích nhất tại cửa hàng.',45000,55000,'tra_sua_tran_chau_duong_den.png',97,1,0,'2026-06-06 11:12:38'),(2,1,'Trà Sữa Matcha','tra-sua-matcha','Trà xanh matcha Nhật Bản hòa quyện cùng sữa tươi, tạo nên hương vị đậm đà và thanh mát. Thích hợp cho người yêu thích trà xanh.',50000,60000,'tra_sua_matcha.png',94,1,0,'2026-06-06 11:12:38'),(3,1,'Trà Sữa Khoai Môn','tra-sua-khoai-mon','Khoai môn tươi xay nhuyễn kết hợp trà sữa, mang đến vị ngọt bùi tự nhiên và màu tím pastel bắt mắt.',48000,58000,'tra_sua_khoai_mon.png',99,1,0,'2026-06-06 11:12:38'),(4,1,'Trà Sữa Socola','tra-sua-socola','Socola nguyên chất kết hợp trà sữa béo ngậy, tạo nên thức uống ngọt ngào dành cho các tín đồ chocolate.',45000,55000,'tra_sua_socola.png',100,0,0,'2026-06-06 11:12:38'),(5,1,'Trà Sữa Caramel','tra-sua-caramel','Trà sữa với lớp caramel thơm lừng, vị ngọt đắng hài hòa. Topping caramel cháy giòn tan trên miệng.',50000,60000,'tra_sua_caramel.png',100,0,0,'2026-06-06 11:12:38'),(6,1,'Trà Sữa Oolong','tra-sua-oolong','Trà oolong cao cấp pha cùng sữa tươi, hương trà đậm và thanh, hậu vị ngọt dịu tự nhiên.',42000,52000,'tra_sua_oolong.png',100,1,0,'2026-06-06 11:12:38'),(7,1,'Hồng Trà Sữa','hong-tra-sua','Hồng trà đậm vị kết hợp sữa tươi béo ngậy, công thức truyền thống với hương thơm quyến rũ.',40000,50000,'hong_tra_sua.png',100,0,0,'2026-06-06 11:12:38'),(8,2,'Trà Sữa Pudding','tra-sua-pudding','Trà sữa đặc biệt với pudding trứng mềm mịn, béo ngậy. Sự kết hợp hoàn hảo giữa trà sữa và topping cao cấp.',52000,62000,'tra_sua_pudding.png',100,1,1,'2026-06-06 11:12:38'),(9,2,'Brown Sugar Boba','brown-sugar-boba','Trân châu đường nâu nổi tiếng từ Đài Loan, vân đường nâu hổ phách đẹp mắt, vị ngọt thơm đặc trưng.',55000,65000,'brown_sugar_boba.png',100,1,1,'2026-06-06 11:12:38'),(10,2,'Trà Sữa Tiger','tra-sua-tiger','Trà sữa phiên bản đặc biệt với vân hổ từ đường nâu, trân châu tươi và sữa tươi nguyên chất.',58000,68000,'tra_sua_tiger.png',100,1,1,'2026-06-06 11:12:38'),(11,3,'Trà Đào Cam Sả','tra-dao-cam-sa','Trà hoa quả thanh mát với đào tươi, cam vàng và sả thơm. Thức uống detox hoàn hảo cho ngày hè.',45000,55000,'tra_dao_cam_sa.png',100,1,0,'2026-06-06 11:12:38'),(12,3,'Trà Vải','tra-vai','Trà xanh kết hợp vải thiều tươi ngọt, thêm thạch vải giòn mát. Hương vị nhiệt đới tươi mát.',42000,52000,'tra_vai.png',98,0,0,'2026-06-06 11:12:38'),(13,3,'Trà Chanh Dây','tra-chanh-day','Trà hoa quả với chanh dây tươi, vị chua ngọt tự nhiên, giàu vitamin C. Rất tốt cho sức khỏe.',40000,50000,'tra_chanh_day.png',100,0,1,'2026-06-06 11:12:38'),(14,4,'Cà Phê Sữa Đá','ca-phe-sua-da','Cà phê phin truyền thống Việt Nam với sữa đặc, đậm đà và thơm lừng. Pha theo công thức đặc biệt.',35000,45000,'ca_phe_sua_da.png',100,0,0,'2026-06-06 11:12:38'),(15,4,'Cà Phê Caramel','ca-phe-caramel','Cà phê espresso kết hợp sốt caramel thơm lừng và sữa tươi. Vị đắng ngọt hài hòa.',50000,60000,'ca_phe_caramel.png',100,0,0,'2026-06-06 11:12:38'),(16,4,'Cà Phê Mocha','ca-phe-mocha','Espresso đậm đà hòa quyện cùng socola và sữa tươi, phủ kem whip béo ngậy trên mặt.',55000,65000,'ca_phe_mocha.png',100,0,0,'2026-06-06 11:12:38'),(17,5,'Matcha Đá Xay','matcha-da-xay','Matcha Nhật Bản xay nhuyễn cùng đá, sữa tươi và kem whip. Thức uống mát lạnh cho mùa hè.',55000,65000,'matcha_da_xay.png',100,0,0,'2026-06-06 11:12:38'),(18,5,'Oreo Đá Xay','oreo-da-xay','Kem vanilla xay cùng đá và bánh Oreo giòn rụm. Thức uống yêu thích của các bạn trẻ.',52000,62000,'oreo_da_xay.png',100,0,0,'2026-06-06 11:12:38'),(19,5,'Chocolate Đá Xay','chocolate-da-xay','Socola nguyên chất xay cùng đá và sữa tươi, phủ kem whip và bột cacao. Đậm vị chocolate.',50000,60000,'chocolate_da_xay.png',100,0,0,'2026-06-06 11:12:38'),(20,6,'Trân Châu Đen','tran-chau-den','Trân châu đen truyền thống dai giòn, nấu từ bột năng tự nhiên. Topping không thể thiếu cho trà sữa.',10000,10000,'topping_tran_chau_den.png',100,0,0,'2026-06-06 11:12:38'),(21,6,'Pudding Trứng','pudding-trung','Pudding trứng mềm mịn, béo ngậy với hương vanilla. Topping cao cấp cho mọi thức uống.',12000,12000,'topping_pudding_trung.png',100,0,0,'2026-06-06 11:12:38'),(22,6,'Thạch Rau Câu','thach-rau-cau','Thạch rau câu nhiều màu sắc, giòn mát và ít calories. Topping nhẹ nhàng cho đồ uống.',8000,8000,'topping_thach_rau_cau.png',100,0,0,'2026-06-06 11:12:38');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `points` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','admin@shoptrasua.vn','$2y$10$V.iVoBQAhtBK61D1S/pkxe7oEmwfHZTLZdUYlyxvhAWisRQOgNxi2','0901234567','admin','2026-06-06 11:12:38',0),(2,'abc','abc@gmail.com','$2y$10$OolNz7/5yEKqZVq/4pbYTe81VZ5vGEAGvVDTQI7flFvq3LFd3Rr1C','132456789','user','2026-06-06 11:31:41',0),(3,'abcd','abcd@gmail.com','$2y$10$uGiRR2MP4GlX/IR5bH1EiOIqV0lzlEP1s3DFuTePQuycnpQazdHH.','123456788','user','2026-06-06 12:15:24',0),(4,'abcdd','adcd1@gmail.com','$2y$10$jb8v2qraLaixSoLQYrDnDOoal7F5A/CfV/6cGHf8Ywn0ymusB5f8e','1234456785','user','2026-06-06 20:00:25',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `wishlists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
/*!40000 ALTER TABLE `wishlists` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-11  8:42:31
