-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for lost_and_found
CREATE DATABASE IF NOT EXISTS `lost_and_found` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `lost_and_found`;

-- Dumping structure for table lost_and_found.items
CREATE TABLE IF NOT EXISTS `items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('Clothing','Bags','Gadgets','Documents','Accessories','Others') NOT NULL,
  `status` enum('lost','found','claimed') NOT NULL DEFAULT 'lost',
  `image` varchar(255) DEFAULT NULL,
  `date_found` date DEFAULT NULL,
  `reported_by` bigint(20) unsigned NOT NULL,
  `claimed_by` bigint(20) unsigned DEFAULT NULL,
  `claim_date` timestamp NULL DEFAULT NULL,
  `claim_details` text DEFAULT NULL,
  `claim_contact` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `reporter_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `items_reported_by_foreign` (`reported_by`),
  KEY `items_claimed_by_foreign` (`claimed_by`),
  CONSTRAINT `items_claimed_by_foreign` FOREIGN KEY (`claimed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `items_reported_by_foreign` FOREIGN KEY (`reported_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lost_and_found.items: ~17 rows (approximately)
INSERT INTO `items` (`id`, `item_name`, `description`, `category`, `status`, `image`, `date_found`, `reported_by`, `claimed_by`, `claim_date`, `claim_details`, `claim_contact`, `created_at`, `updated_at`, `reporter_name`) VALUES
	(5, 'Cap', 'Vintage-style charcoal baseball cap with "LOS ANGELES" embroidery.', 'Clothing', 'lost', 'images/2pS6Co1jiURi5yzvFGZZmbeU2C2fg5ibAhlo9zmB.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:49:39', '2026-05-11 18:49:39', 'Hazel'),
	(6, 'ADIDAS SAMBA OG', 'Black Adidas Samba sneakers with white stripes and gum soles.', 'Clothing', 'lost', 'images/yNhLJFIQ24tlqakBrItoqWzTItNDnaKwPiXPp90M.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:51:02', '2026-05-11 18:51:02', 'Sey'),
	(7, 'Anker PowerCore 20100', 'Slim black Anker portable power bank with dual USB ports.', 'Accessories', 'lost', 'images/QahztlPlxUUvbisqyP0Jk3QUtf35GUiDGZkmreqe.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:51:59', '2026-05-11 18:51:59', 'Benjie'),
	(8, 'JBL Bluetooth speaker', 'Black cylindrical JBL Bluetooth speaker with orange logo.', 'Accessories', 'lost', 'images/9Q5Xq4POtrJhVgOqeA7MGWW99wRbvkWCcnU18utT.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:53:08', '2026-05-11 18:53:08', 'Jasmin'),
	(9, 'Bucket hat', 'Black The North Face bucket hat with an adjustable cord.', 'Clothing', 'lost', 'images/0wRRMMbuvHIp57x7dUnPO3Vkhyzpt00WN5TJ9Hdr.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:53:48', '2026-05-11 18:53:48', 'Carl'),
	(10, 'Keychain Set', 'A collection of high-end accessories including a Range Rover fob, a Gucci pouch, and Givenchy/Chanel charms.', 'Accessories', 'lost', 'images/r2UUDWPKYQDLWBLPWja3L0c21pChsrYqP0ORoGNF.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:56:18', '2026-05-11 18:56:18', 'Blessy'),
	(11, 'Backpack', 'A classic black canvas backpack featuring the signature white embroidered polo pony logo.', 'Bags', 'lost', 'images/AL8Giy9jubbr6Odpmg2iK77TqgHqQMyI5UmzryZC.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:57:29', '2026-05-11 18:57:29', 'Jonalyn'),
	(12, 'Black Shoes', 'Black leather loafers with a thick, rugged lug sole.', 'Clothing', 'lost', 'images/kKEGuasASjlnpDcHKLM8dLyIAZuRFkvwBxaMMKa3.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 18:59:08', '2026-05-11 18:59:08', 'Rowena'),
	(13, 'Apple Watch with Custom Band', 'A smartwatch with a white bumper case and a two-tone navy and burgundy silicone strap.\r\nName: Perla', 'Accessories', 'lost', 'images/nNs8U7lYjgNE2qE3naNqZKnyEuxCTEBXS4uBzdiO.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:00:01', '2026-05-11 19:00:01', 'Perla'),
	(14, 'Samsung Galaxy S21 Ultra', 'The rear view of a matte black smartphone featuring a prominent quad-camera array.', 'Gadgets', 'lost', 'images/NcwVcCnHMuamVeM2aIx4iVq9M1w270y4yjHuRcE0.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:00:47', '2026-05-17 00:45:36', 'Nerissa'),
	(15, 'Jisulife Handheld Fan', 'High-speed portable turbo fan in matte grey with a digital status display.', 'Accessories', 'found', 'images/1rCssA4mKYe14CLabXMUXeU0CXt1RTcF05qPLfLp.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:03:54', '2026-05-17 00:45:26', 'Ligaya'),
	(16, 'MacBook Pro', 'Slim laptop with a matte black finish and a glossy Apple logo on the lid.', 'Gadgets', 'found', 'images/H9cMzS6P4yAAsp83c5Qj4aPmwqIUvXH2MfShmFuT.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:09:18', '2026-05-17 00:45:17', 'Danica'),
	(17, 'Geek Aire Handheld Fan', 'Portable black fan with a circular blade guard, power indicator lights, and a charging dock.', 'Accessories', 'found', 'images/IFDPYY94t3NONhdgfEMygRlTGXPxhc33H8MmAfyg.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:10:38', '2026-05-17 00:45:06', 'Althea'),
	(18, 'iPhone with Woven Case', 'Smartphone featuring a brown textured fabric case and a triple-lens camera system.', 'Accessories', 'found', 'images/UH2POunS0u9SJfmRScWF4I7caRKt6BZIoiPavdUM.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:11:37', '2026-05-17 00:44:50', 'Bituin'),
	(19, 'Heymister Crossbody Bag', 'Small olive green utility bag with black straps and a white graphic text label.', 'Accessories', 'claimed', 'images/WIYKQcdV2vfTU6M6W7Cv2wCxBSHFnrnMNdHy2qZU.jpg', '2026-05-12', 6, 5, '2026-05-19 05:27:20', 'sssssssssssssssssssssssssssssssssssssssss', 'kimpeemalabago@gamail.com', '2026-05-11 19:13:08', '2026-05-19 05:27:20', 'Cheska'),
	(20, 'AirPods Pro Case', 'Minimalist matte black protective case with a metallic carabiner clip.', 'Accessories', 'found', 'images/MHh3I4vSp2CQXwDJj86oxa6llarXrIIHoZyR1ntD.jpg', '2026-05-12', 6, NULL, NULL, NULL, NULL, '2026-05-11 19:14:35', '2026-05-17 00:44:34', 'Tala'),
	(21, 'Birkenstock Sandals', 'Classic black two-strap Arizona sandals with signature cork footbeds.', 'Clothing', 'claimed', 'images/rO7G80bpFmkpnPzYUR119nYK1kHPQkaQHO69DJda.jpg', '2026-05-12', 6, 5, '2026-05-19 05:02:22', 'fsfsdfsdf', '09454402122', '2026-05-11 19:17:10', '2026-05-19 05:02:22', 'Marikit');

-- Dumping structure for table lost_and_found.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lost_and_found.migrations: ~9 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000001_create_cache_table', 1),
	(2, '0001_01_01_000002_create_jobs_table', 1),
	(3, '2024_01_01_000000_create_users_table', 1),
	(4, '2024_01_02_000000_create_items_table', 1),
	(5, '2024_01_03_000000_create_sessions_table', 1),
	(6, '2024_01_04_000000_add_email_to_users_table', 1),
	(7, '2026_03_15_020321_add_reporter_name_to_items_table', 1),
	(8, '2026_04_28_125440_add_claim_fields_to_items_table', 1),
	(9, '2026_05_01_000000_add_claim_fields_to_items_table', 1);

-- Dumping structure for table lost_and_found.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lost_and_found.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('g6r1qxXdQwlTwscI1Tx6kBKeuvKWbllknNsv1BpM', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.120.0 Chrome/142.0.7444.265 Electron/39.8.8 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWtpWldKN3k0Wm85SUZ1akRHVUM3SVJLWG90bDQ3UllpYlZJblFTdyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImFkbWluLmRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjY7fQ==', 1779198427),
	('PhRIP4sieRWKgePPXkMaqUWsn964GPLLOFWJX7Qs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWIwNEE5NTl3b25OZVlSdkFPazZwOTdTNHYyR1NlTmU5eGZVZVZORiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=', 1779198630);

-- Dumping structure for table lost_and_found.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table lost_and_found.users: ~7 rows (approximately)
INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', NULL, '$2y$12$cPQQYe6EPgPChmi3VL2ejuF5B./kN/zaLate9nMZTRFy.WwhaTDj.', 'admin', NULL, '2026-05-09 03:51:25', '2026-05-09 03:51:25'),
	(2, 'user', NULL, '$2y$12$xOgm9e0UfAZgoMrxxYYPAOeR/P4bM0AIqxtMb1uQK.kWZo5en/pLa', 'user', NULL, '2026-05-09 03:51:25', '2026-05-09 03:51:25'),
	(3, 'benj', 'benjiesolanoy18@gmail.com', '$2y$12$KG.vvgNKg/BKr/1CJEhA5uU6AR4GhHMh6A42JFiPgPjQzDMnHwkG.', 'admin', NULL, '2026-05-09 05:02:43', '2026-05-09 05:02:43'),
	(4, 'Kimpee', 'kimpeemalabago@gamail.com', '$2y$12$eOhrJJfw9sPUW1LD2H45GeqVYiUu/MbL.dII8481e.T.Nc9O.9.Ui', 'admin', NULL, '2026-05-11 18:37:34', '2026-05-11 18:37:34'),
	(5, 'Jasmin', 'kimpeemalabago1@gamail.com', '$2y$12$.K/PawjDzTLUwfA3C3.wY.t7QhR7a//Oahch9OsG3SPl4XSJSbnX.', 'user', NULL, '2026-05-11 18:40:47', '2026-05-11 18:40:47'),
	(6, 'Hazel', 'kimpeemalabago2@gamail.com', '$2y$12$RLo6J.EmfwmPVecCp.MOOOCNpaFFdWYu9KqKcB0mrCYV6ZyAQFEQ.', 'admin', NULL, '2026-05-11 18:43:05', '2026-05-11 18:43:05'),
	(7, 'benjie2', 'kimpeemalabago222@gamail.com', '$2y$12$2gUk/ncfQfGfYCdHUKo8e.Wym.EdK6sSrmU3n/QIPNjLYe4KNN2RG', 'admin', NULL, '2026-05-12 00:07:37', '2026-05-12 00:07:37');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
