/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.22-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ecom_putri
-- ------------------------------------------------------
-- Server version	10.6.22-MariaDB-ubu2004

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
-- Table structure for table `api_settings`
--

DROP TABLE IF EXISTS `api_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_settings`
--

LOCK TABLES `api_settings` WRITE;
/*!40000 ALTER TABLE `api_settings` DISABLE KEYS */;
INSERT INTO `api_settings` VALUES (1,'midtrans_enabled','1','2026-04-16 02:08:59','2026-04-16 02:42:32'),(2,'midtrans_server_key','Mid-server-sGSQA-phKTOvLMxVCoyBa5L1','2026-04-16 02:08:59','2026-04-16 02:42:32'),(3,'midtrans_client_key','Mid-client-B5cdcn1MQ69zuuUd','2026-04-16 02:08:59','2026-04-16 02:42:32'),(4,'midtrans_production','0','2026-04-16 02:08:59','2026-04-16 02:08:59'),(5,'rajaongkir_enabled','1','2026-04-16 02:08:59','2026-04-16 02:08:59'),(6,'rajaongkir_api_key','8tv0chej95492f1572625c83r643V2Bl','2026-04-16 02:08:59','2026-04-16 02:08:59'),(7,'rajaongkir_origin_city','391','2026-04-16 02:08:59','2026-04-16 02:10:11'),(8,'shippo_enabled','1','2026-04-16 02:08:59','2026-04-16 02:25:39'),(9,'shippo_api_key','shippo_test_0f13e7e71ef2eaedb0aa10b7f46d6ac3ee98cc38','2026-04-16 02:08:59','2026-04-16 02:27:32'),(10,'shippo_origin_zip','65141','2026-04-16 02:08:59','2026-04-16 02:25:37'),(11,'shippo_origin_country','In','2026-04-16 02:08:59','2026-04-16 02:27:32');
/*!40000 ALTER TABLE `api_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `category_slug` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `author_avatar` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (1,'5 Kesalahan Umum dalam Merawat Monstera','5-kesalahan-umum-merawat-monstera','Pelajari kesalahan-kesalahan yang sering dilakukan pemula dalam merawat Monstera dan cara mengatasinya.','Monstera adalah tanaman yang sangat populer. Namun, banyak pemula yang melakukan kesalahan dalam perawatannya...','Perawatan','perawatan','Dewi Lestari','https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=50&h=50&fit=crop','https://images.unsplash.com/photo-1463320898484-cdee8141c787?w=400&h=300&fit=crop',2500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50','2026-04-14 06:20:50'),(2,'7 Tanaman Indoor Terbaik untuk Pemula','7-tanaman-indoor-terbaik-untuk-pemula','Rekomendasi tanaman indoor yang mudah dirawat dan cocok untuk Anda yang baru memulai hobi berkebun.','Bagi pemula, memilih tanaman indoor yang tepat sangat penting. Berikut rekomendasi tanaman yang tahan banting...','Tanaman Indoor','tanaman-indoor','Budi Santoso','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50&h=50&fit=crop','https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=300&fit=crop',3200,1,'2026-04-14 06:20:50','2026-04-14 06:20:50','2026-04-14 06:20:50'),(3,'Cara Membuat Taman Sukulen Mini','cara-membuat-taman-sukulen-mini','Panduan lengkap membuat taman sukulen mini yang cantik untuk menghiasi meja kerja atau sudut rumah Anda.','Sukulen adalah pilihan tepat untuk taman mini. Mereka tidak membutuhkan banyak air dan perawatan...','Sukulen','sukulen','Sari Wijaya','https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=50&h=50&fit=crop','https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=300&fit=crop',1800,1,'2026-04-14 06:20:50','2026-04-14 06:20:50','2026-04-14 06:20:50');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,2,1,2,'2026-04-14 06:47:46','2026-04-14 06:47:46');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Tanaman Indoor','indoor',NULL,'fa-home','https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400&h=400&fit=crop',120,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(2,'Tanaman Outdoor','outdoor',NULL,'fa-sun','https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=400&fit=crop',85,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(3,'Sukulen & Kaktus','succulent',NULL,'fa-spa','https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=400&fit=crop',60,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(4,'Tanaman Langka','rare',NULL,'fa-gem','https://images.unsplash.com/photo-1463936575829-25148e1db1b8?w=400&h=400&fit=crop',25,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(5,'Kaktus','cactus',NULL,'fa-seedling','',15,1,'2026-04-14 06:20:50','2026-04-14 06:20:50');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `coupons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('percent','fixed') NOT NULL DEFAULT 'percent',
  `value` decimal(10,2) NOT NULL,
  `min_order` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `valid_from` date NOT NULL,
  `valid_until` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupons`
--

LOCK TABLES `coupons` WRITE;
/*!40000 ALTER TABLE `coupons` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_04_14_114933_add_is_admin_to_users_table',1),(6,'2026_04_14_114933_create_categories_table',1),(7,'2026_04_14_114934_create_blog_posts_table',1),(8,'2026_04_14_114934_create_orders_table',1),(9,'2026_04_14_114934_create_products_table',1),(10,'2026_04_14_114935_create_newsletters_table',1),(11,'2026_04_14_114935_create_order_items_table',1),(12,'2026_04_14_133853_create_carts_table',2),(13,'2026_04_14_133853_create_settings_table',2),(14,'2026_04_14_133853_create_wishlists_table',2),(15,'2026_04_15_000001_create_payment_methods_table',3),(16,'2026_04_15_000002_add_payment_method_id_to_orders_table',3),(17,'2026_04_15_000003_create_payment_confirmations_table',3),(18,'2026_04_15_000004_update_orders_status_enum',3),(19,'2026_04_15_000005_add_logo_to_payment_methods_table',4),(20,'2026_04_15_045138_add_google_id_to_users_table',5),(21,'2026_04_15_102855_add_type_to_payment_methods_table',6),(22,'2026_04_16_000001_create_coupons_table',6),(23,'2026_04_16_073302_add_country_to_orders_table',7),(24,'2026_04_16_081751_add_shipping_fields_to_orders_table',8),(25,'2026_04_16_081751_add_weight_to_products_table',8),(26,'2026_04_16_081752_create_api_settings_table',8),(27,'2026_04_16_081752_create_shipping_zones_table',8),(28,'2026_04_16_094958_add_payment_fields_to_orders_table',9),(29,'2026_04_16_101305_add_cancel_reason_to_orders_table',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `newsletters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `newsletters_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (1,'royyanmz87@gmail.com','2026-04-16 03:47:11','2026-04-16 03:47:11');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,'Monstera Deliciosa',350000.00,1,350000.00,'2026-04-15 01:25:01','2026-04-15 01:25:01'),(2,2,'Monstera Deliciosa',350000.00,1,350000.00,'2026-04-15 01:53:58','2026-04-15 01:53:58'),(3,3,'Philodendron Birkin',425000.00,1,425000.00,'2026-04-16 02:47:42','2026-04-16 02:47:42'),(4,3,'Monstera Deliciosa',350000.00,1,350000.00,'2026-04-16 02:47:42','2026-04-16 02:47:42'),(5,4,'Monstera Deliciosa',350000.00,1,350000.00,'2026-04-16 03:02:30','2026-04-16 03:02:30'),(6,5,'Lidah Mertua',85000.00,1,85000.00,'2026-04-16 03:07:48','2026-04-16 03:07:48'),(7,6,'Philodendron Birkin',425000.00,1,425000.00,'2026-04-16 03:28:58','2026-04-16 03:28:58');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Indonesia',
  `postal_code` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_method_id` bigint(20) unsigned DEFAULT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_token` varchar(255) DEFAULT NULL,
  `payment_va_number` varchar(255) DEFAULT NULL,
  `payment_qr_url` text DEFAULT NULL,
  `payment_expired_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','awaiting_confirmation','processing','shipped','completed','cancelled') DEFAULT 'pending',
  `subtotal` decimal(12,2) NOT NULL,
  `discount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_courier` varchar(255) DEFAULT NULL,
  `shipping_service` varchar(255) DEFAULT NULL,
  `shipping_etd` varchar(255) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `coupon_discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_payment_method_id_foreign` (`payment_method_id`),
  CONSTRAINT `orders_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'GH-2026-4246','Muhammad Royyan','royyanmz87@gmail.com','0867123123','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jakarta','Indonesia','65141','BCA - 1234567890 a.n. GreenHaven',1,NULL,NULL,NULL,NULL,NULL,'processing',350000.00,100000.00,0.00,NULL,NULL,NULL,350000.00,NULL,NULL,NULL,0.00,'2026-04-15 01:25:01','2026-04-16 00:05:21'),(2,'GH-2026-2095','Muhammad Royyan','royyanmz87@gmail.com','0867123123','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jateng','Indonesia','65141','Mandiri - 0987654321 a.n. GreenHaven',NULL,NULL,NULL,NULL,NULL,NULL,'processing',350000.00,100000.00,0.00,NULL,NULL,NULL,350000.00,NULL,NULL,NULL,0.00,'2026-04-15 01:53:58','2026-04-15 02:19:21'),(3,'GH-2026-8795','Muhammad Royyan','royyanmz87@gmail.com','+6289510518735','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jawa Timur — East Java','Indonesia','65141','PayPal / Kartu Kredit / E-Wallet',1,'bank_transfer','2acc7566-ad42-4077-b696-fbd898f15b0a','032827789321241783',NULL,'2026-04-17 10:04:36','cancelled',775000.00,175000.00,20000.00,'JNE','REG','8 day',795000.00,NULL,'s',NULL,0.00,'2026-04-16 02:47:42','2026-04-16 03:27:20'),(4,'GH-2026-9672','Muhammad Royyan','royyanmz87@gmail.com','+6289510518735','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jawa Timur — East Java','Indonesia','65141','BRI Virtual Account',1,NULL,NULL,NULL,NULL,NULL,'pending',350000.00,100000.00,0.00,NULL,NULL,NULL,350000.00,NULL,NULL,NULL,0.00,'2026-04-16 03:02:30','2026-04-16 03:24:59'),(5,'GH-2026-4768','Muhammad Royyan','royyanmz87@gmail.com','0867123123','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jawa Timur — East Java','Indonesia','65141','PayPal',1,NULL,NULL,NULL,NULL,NULL,'shipped',85000.00,0.00,45000.00,'JNE','JTR','4 day',130000.00,NULL,NULL,NULL,0.00,'2026-04-16 03:07:48','2026-04-16 03:10:29'),(6,'GH-2026-6904','Muhammad Royyan','royyanmz87@gmail.com','0867123123','Jl. Soekarno Hatta No.30 Kav. 10, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141','Malang','Jawa Timur — East Java','Indonesia','65141','QRIS',3,'qris','5051387c-b78e-4072-a8c1-f4ff13194092',NULL,'https://api.sandbox.midtrans.com/v2/qris/5051387c-b78e-4072-a8c1-f4ff13194092/qr-code','2026-04-16 10:44:02','pending',425000.00,75000.00,14000.00,'JNE','REG','2 day',439000.00,NULL,NULL,NULL,0.00,'2026-04-16 03:28:58','2026-04-16 03:29:03');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_confirmations`
--

DROP TABLE IF EXISTS `payment_confirmations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_confirmations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `payment_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `confirmed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_confirmations_order_id_foreign` (`order_id`),
  KEY `payment_confirmations_user_id_foreign` (`user_id`),
  CONSTRAINT `payment_confirmations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payment_confirmations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_confirmations`
--

LOCK TABLES `payment_confirmations` WRITE;
/*!40000 ALTER TABLE `payment_confirmations` DISABLE KEYS */;
INSERT INTO `payment_confirmations` VALUES (1,1,7,350000.00,'12312','2026-04-15','asd','payment_proofs/BqNQkzXiR7TpIeYuI2V2OzmnIzp7Nm9pfuDargkc.png','confirmed',NULL,'2026-04-16 00:05:21','2026-04-15 01:25:27','2026-04-16 00:05:21'),(2,5,7,130000.00,'12312','2026-04-16',NULL,'payment_proofs/8JnZFyacsurhu7x4qWXq4PxSYuwiHRRxnDAGsqAX.png','confirmed',NULL,'2026-04-16 03:10:11','2026-04-16 03:08:01','2026-04-16 03:10:11');
/*!40000 ALTER TABLE `payment_confirmations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('manual','midtrans') NOT NULL DEFAULT 'manual',
  `account_name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_methods`
--

LOCK TABLES `payment_methods` WRITE;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES (1,'PayPal','manual','GreenHaven',NULL,'1234567890',1,0,'2026-04-14 21:18:55','2026-04-16 03:04:58'),(3,'Bayar Online (VA / E-Wallet / QRIS)','midtrans','-',NULL,'-',1,2,'2026-04-16 03:06:12','2026-04-16 03:06:12');
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `original_price` decimal(12,2) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `height` varchar(255) DEFAULT NULL,
  `light` varchar(255) DEFAULT NULL,
  `care_level` varchar(255) DEFAULT NULL,
  `watering` varchar(255) DEFAULT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `weight` int(11) NOT NULL DEFAULT 500 COMMENT 'gram',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Monstera Deliciosa','monstera-deliciosa',NULL,350000.00,450000.00,20,'https://images.unsplash.com/photo-1614594975525-e45190c55d0b?w=400&h=500&fit=crop','60-80cm','Teduh','Mudah','Sedang','sale',15,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(2,3,'Lidah Mertua','lidah-mertua',NULL,85000.00,NULL,NULL,'https://images.unsplash.com/photo-1599598425947-d35101f97d6c?w=400&h=500&fit=crop','30-40cm','Cerah','Sangat Mudah','Jarang','new',30,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(3,1,'Pakis Kelabu','pakis-kelabu',NULL,275000.00,NULL,NULL,'https://images.unsplash.com/photo-1598542283622-5410a48cf45e?w=400&h=500&fit=crop','40-50cm','Teduh','Sedang','Sering','rare',10,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(4,5,'Kaktus Mini Mix','kaktus-mini-mix',NULL,45000.00,60000.00,25,'https://images.unsplash.com/photo-1509423355108-b389831e6077?w=400&h=500&fit=crop','5-15cm','Cerah','Sangat Mudah','Jarang','indoor',50,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(5,1,'Philodendron Birkin','philodendron-birkin',NULL,425000.00,500000.00,15,'https://images.unsplash.com/photo-1598880940371-c756e015fea1?w=400&h=500&fit=crop','40-50cm','Teduh','Mudah','Sedang','sale',8,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(6,1,'Calathea Orbifolia','calathea-orbifolia',NULL,195000.00,NULL,NULL,'https://images.unsplash.com/photo-1596547609652-9cf5d8d76921?w=400&h=500&fit=crop','30-40cm','Teduh','Sedang','Sering',NULL,12,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(7,2,'Lavender','lavender',NULL,150000.00,NULL,NULL,'https://images.unsplash.com/photo-1550951298-5c7b95a66b6c?w=400&h=500&fit=crop','30-50cm','Cerah','Mudah','Jarang','outdoor',20,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(8,4,'Philodendron Pink Princess','philodendron-pink-princess',NULL,850000.00,NULL,NULL,'https://images.unsplash.com/photo-1616690248297-50d4c8ef0996?w=400&h=500&fit=crop','30-40cm','Teduh','Sedang','Sedang','rare',5,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(9,3,'Echeveria Lola','echeveria-lola',NULL,65000.00,NULL,NULL,'https://images.unsplash.com/photo-1459411552884-841db9b3cc2a?w=400&h=500&fit=crop','10-15cm','Cerah','Sangat Mudah','Jarang',NULL,40,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(10,1,'Rubber Plant','rubber-plant',NULL,295000.00,330000.00,10,'https://images.unsplash.com/photo-1600417148543-515eed049e9d?w=400&h=500&fit=crop','60-80cm','Teduh','Mudah','Sedang','sale',18,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(11,2,'Bonsai Mini','bonsai-mini',NULL,125000.00,NULL,NULL,'https://images.unsplash.com/photo-1566928405-544c44225944?w=400&h=500&fit=crop','20-30cm','Cerah','Sedang','Rutin','outdoor',7,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(12,1,'ZZ Plant','zz-plant',NULL,175000.00,NULL,NULL,'https://images.unsplash.com/photo-1599598425798-6c8ee1b216b7?w=400&h=500&fit=crop','40-60cm','Teduh','Sangat Mudah','Jarang','indoor',25,500,1,'2026-04-14 06:20:50','2026-04-14 06:20:50');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','LongLeaf','2026-04-14 06:46:55','2026-04-14 20:58:27'),(2,'site_logo','','2026-04-14 06:46:55','2026-04-14 06:46:55'),(3,'payment_methods','Transfer Bank BCA\r\nTransfer Bank Mandiri\r\nCOD (Bayar di Tempat)','2026-04-14 06:46:55','2026-04-14 20:58:27');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shipping_zones`
--

DROP TABLE IF EXISTS `shipping_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `shipping_zones` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `countries` text NOT NULL,
  `flat_rate` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shipping_zones`
--

LOCK TABLES `shipping_zones` WRITE;
/*!40000 ALTER TABLE `shipping_zones` DISABLE KEYS */;
INSERT INTO `shipping_zones` VALUES (1,'Indonesia','[\"Indonesia\"]',25000.00,1,1,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(2,'Asia Tenggara (SEA)','[\"Malaysia\",\"Singapore\",\"Thailand\",\"Philippines\",\"Vietnam\",\"Myanmar\",\"Cambodia\",\"Laos\",\"Brunei\",\"Timor-Leste\"]',150000.00,1,2,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(3,'Asia Timur','[\"Japan\",\"South Korea\",\"China\",\"Taiwan\",\"Hong Kong\",\"Macau\",\"Mongolia\"]',250000.00,1,3,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(4,'Asia Selatan & Tengah','[\"India\",\"Pakistan\",\"Bangladesh\",\"Sri Lanka\",\"Nepal\",\"Bhutan\",\"Maldives\",\"Afghanistan\",\"Kazakhstan\",\"Uzbekistan\",\"Turkmenistan\",\"Tajikistan\",\"Kyrgyzstan\"]',280000.00,1,4,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(5,'Timur Tengah','[\"Saudi Arabia\",\"United Arab Emirates\",\"Qatar\",\"Kuwait\",\"Bahrain\",\"Oman\",\"Jordan\",\"Lebanon\",\"Israel\",\"Iraq\",\"Iran\",\"Syria\",\"Yemen\"]',300000.00,1,5,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(6,'Australia & Pasifik','[\"Australia\",\"New Zealand\",\"Papua New Guinea\",\"Fiji\",\"Solomon Islands\",\"Vanuatu\",\"Samoa\",\"Tonga\",\"Kiribati\",\"Micronesia\",\"Palau\",\"Nauru\",\"Tuvalu\",\"Marshall Islands\"]',320000.00,1,6,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(7,'Eropa Barat','[\"United Kingdom\",\"Germany\",\"France\",\"Netherlands\",\"Belgium\",\"Switzerland\",\"Austria\",\"Sweden\",\"Norway\",\"Denmark\",\"Finland\",\"Ireland\",\"Portugal\",\"Spain\",\"Italy\",\"Luxembourg\",\"Iceland\",\"Liechtenstein\",\"Monaco\",\"San Marino\",\"Vatican City\"]',400000.00,1,7,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(8,'Eropa Timur & Tengah','[\"Poland\",\"Czech Republic\",\"Slovakia\",\"Hungary\",\"Romania\",\"Bulgaria\",\"Croatia\",\"Slovenia\",\"Serbia\",\"Bosnia and Herzegovina\",\"Montenegro\",\"North Macedonia\",\"Albania\",\"Kosovo\",\"Greece\",\"Cyprus\",\"Estonia\",\"Latvia\",\"Lithuania\",\"Ukraine\",\"Moldova\",\"Belarus\",\"Russia\"]',420000.00,1,8,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(9,'Amerika Utara','[\"United States\",\"Canada\",\"Mexico\"]',450000.00,1,9,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(10,'Amerika Tengah & Karibia','[\"Guatemala\",\"Belize\",\"Honduras\",\"El Salvador\",\"Nicaragua\",\"Costa Rica\",\"Panama\",\"Cuba\",\"Jamaica\",\"Haiti\",\"Dominican Republic\",\"Puerto Rico\",\"Trinidad and Tobago\",\"Barbados\",\"Bahamas\"]',480000.00,1,10,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(11,'Amerika Selatan','[\"Brazil\",\"Argentina\",\"Chile\",\"Colombia\",\"Peru\",\"Venezuela\",\"Ecuador\",\"Bolivia\",\"Paraguay\",\"Uruguay\",\"Guyana\",\"Suriname\"]',500000.00,1,11,'2026-04-16 01:49:08','2026-04-16 01:49:08'),(12,'Afrika','[\"South Africa\",\"Nigeria\",\"Kenya\",\"Egypt\",\"Ethiopia\",\"Ghana\",\"Tanzania\",\"Uganda\",\"Morocco\",\"Algeria\",\"Tunisia\",\"Libya\",\"Senegal\",\"Ivory Coast\",\"Cameroon\",\"Zimbabwe\",\"Zambia\",\"Mozambique\",\"Madagascar\",\"Angola\",\"Sudan\",\"Somalia\"]',550000.00,1,12,'2026-04-16 01:49:08','2026-04-16 01:49:08');
/*!40000 ALTER TABLE `shipping_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_google_id_unique` (`google_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@greenhaven.id',NULL,NULL,NULL,'$2y$12$dWM7eljQOD5jYezsVOs6auYLDxj2GAlq/DRBWguhC3kSByg5i0Woi',1,NULL,'2026-04-14 06:20:50','2026-04-14 06:20:50'),(2,'Sarah Amelia','sarah@example.com',NULL,NULL,NULL,'$2y$12$fzNLD2hnxbNIywqYTa4ZuuPYFD3pwVxR7t8RaUI3N9q7zuoS1jD.W',0,NULL,'2026-04-14 06:23:55','2026-04-14 06:23:55'),(3,'Budi Santoso','budi@example.com',NULL,NULL,NULL,'$2y$12$6YhE0sMDR.gdpo5lVPVpfuaF0uGbpPZW8wL/13mcrTgNBfgUt69O2',0,NULL,'2026-04-14 06:23:55','2026-04-14 06:23:55'),(4,'Dewi Lestari','dewi@example.com',NULL,NULL,NULL,'$2y$12$KMuIAafX0vIHaVyuMP6mm.vImy766qaAf8ImBn6Z2APZAVSN4Sp7K',0,NULL,'2026-04-14 06:23:55','2026-04-14 06:23:55'),(5,'Michael Chen','michael@example.com',NULL,NULL,NULL,'$2y$12$Q2dwpvGCERIEROmbh5XVe.0cbkdFOoUFs8c3gJsYerxIo1iZk4hE.',0,NULL,'2026-04-14 06:23:55','2026-04-14 06:23:55'),(6,'Rina Susanti','rina@example.com',NULL,NULL,NULL,'$2y$12$GjmR5KZU99a/pwnKOChBOu7rUpThCf3k9WYxiP/PDtenZdGor.O/m',0,NULL,'2026-04-14 06:23:56','2026-04-14 06:23:56'),(7,'Muhammad Royyan','royyanmz87@gmail.com','108571025084442611683','https://lh3.googleusercontent.com/a/ACg8ocLUYHhtq12btRxDK-nbRHrKWYuV2jtK3dWPQVzgdQipApYxmj3y=s96-c','2026-04-15 01:04:07','$2y$12$.NNHpjpnXLLBr8cuNvY6kOVVLfwX19AjJDchWPoFJjCLR9KqEo1oG',0,'46jvr0GdmffJ4OgudE22QUkHw3jKE2clZsO5nblrxCq4wYekMTMACgXmFbfK','2026-04-15 01:04:07','2026-04-15 01:04:07');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlists`
--

DROP TABLE IF EXISTS `wishlists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `wishlists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wishlists_user_id_foreign` (`user_id`),
  KEY `wishlists_product_id_foreign` (`product_id`),
  CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlists`
--

LOCK TABLES `wishlists` WRITE;
/*!40000 ALTER TABLE `wishlists` DISABLE KEYS */;
INSERT INTO `wishlists` VALUES (1,2,1,'2026-04-14 06:47:46','2026-04-14 06:47:46'),(4,7,11,'2026-04-16 03:38:24','2026-04-16 03:38:24');
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

-- Dump completed on 2026-04-16 19:21:57
