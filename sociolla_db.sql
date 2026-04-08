-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2026 at 03:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sociolla_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(7, 7, 3, 4, '2026-04-05 15:32:43', '2026-04-05 15:32:43'),
(14, 10, 29, 3, '2026-04-06 17:48:58', '2026-04-07 16:46:55'),
(16, 10, 4, 2, '2026-04-06 19:55:34', '2026-04-06 19:55:51'),
(18, 10, 5, 1, '2026-04-07 16:46:05', '2026-04-07 16:46:05'),
(19, 10, 6, 1, '2026-04-07 16:46:21', '2026-04-07 16:46:21'),
(20, 10, 31, 1, '2026-04-07 16:46:34', '2026-04-07 16:46:34'),
(21, 10, 3, 1, '2026-04-07 16:46:45', '2026-04-07 16:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Daily Deals', '2026-04-05 09:53:19', '2026-04-05 09:53:19'),
(2, 'Popular Products', '2026-04-05 09:53:19', '2026-04-05 09:53:19'),
(3, 'Best Seller', '2026-04-05 09:53:19', '2026-04-05 09:53:19'),
(4, 'Trending', '2026-04-05 09:53:19', '2026-04-05 09:53:19');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_05_164958_create_categories_table', 1),
(5, '2026_04_05_165000_create_products_table', 1),
(6, '2026_04_05_165001_create_orders_table', 1),
(7, '2026_04_05_165002_create_order_items_table', 1),
(8, '2026_04_06_180000_update_schema', 2),
(9, '2026_04_06_183000_update_users_schema', 3),
(10, '2026_04_06_184000_add_username_to_users', 4),
(11, '2026_04_06_180001_add_rating_to_orders', 5),
(12, '2026_04_07_011500_add_canceled_to_order_status', 6),
(13, '2026_04_07_043200_add_province_city_to_users_table', 7),
(14, '2026_04_07_045821_add_tracking_status_to_orders_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Not Paid','Packed','Delivered','Completed','Rating','Canceled') DEFAULT 'Not Paid',
  `tracking_status` varchar(255) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_rated` tinyint(1) NOT NULL DEFAULT 0,
  `rating_review` text DEFAULT NULL,
  `rating_image` varchar(255) DEFAULT NULL,
  `rating_stars` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `tracking_status`, `total_amount`, `shipping_address`, `payment_proof`, `payment_method`, `created_at`, `updated_at`, `is_rated`, `rating_review`, `rating_image`, `rating_stars`) VALUES
(7, 5, 'Completed', NULL, 1124675.00, 'tias1234', NULL, 'Bank Transfer', '2026-04-05 17:34:11', '2026-04-05 18:28:24', 0, NULL, NULL, NULL),
(8, 5, 'Completed', NULL, 1574545.00, 'tias1234', NULL, 'COD', '2026-04-05 17:36:35', '2026-04-05 19:45:54', 1, 'yyyy', 'images/reviews/1775439733_whatsapp image 2025-06-06 at 21.24.54_3838d58f.jpg', 4),
(9, 7, 'Packed', NULL, 1419000.00, 'Jl. Merpati Blok S No. 107, SUKMAJAYA KOTA DEPOK, JAWA BARAT, ID 12345', 'http://localhost/sociolla/images/payments/1775438945_download (1).jpg', 'Bank Transfer', '2026-04-05 18:28:48', '2026-04-05 19:47:35', 0, NULL, NULL, NULL),
(10, 10, 'Not Paid', NULL, 420000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-05 19:53:37', '2026-04-05 19:53:37', 0, NULL, NULL, NULL),
(12, 10, 'Not Paid', NULL, 60000.00, 'Jalan Cakra', NULL, 'Bank Transfer', '2026-04-05 20:01:09', '2026-04-05 20:01:09', 0, NULL, NULL, NULL),
(13, 10, 'Packed', NULL, 125000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-05 20:07:30', '2026-04-05 20:46:46', 0, NULL, NULL, NULL),
(14, 10, 'Delivered', NULL, 1230000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-05 20:08:38', '2026-04-05 20:54:16', 0, NULL, NULL, NULL),
(15, 10, 'Completed', NULL, 75000.00, 'Jalan Cakra', 'http://localhost/sociolla/images/payments/1775448094_download (1).jpg', 'Bank Transfer', '2026-04-05 21:01:10', '2026-04-05 21:02:37', 0, NULL, NULL, NULL),
(16, 10, 'Rating', NULL, 220000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-05 21:03:42', '2026-04-05 21:32:44', 1, 'mmmm', 'images/reviews/1775449964_Screenshot (1).png', 5),
(19, 10, 'Not Paid', NULL, 32000.00, 'Jalan Cakra', 'http://localhost/sociolla/images/payments/1775524030_Screenshot (1).png', 'Bank Transfer', '2026-04-06 18:06:54', '2026-04-06 18:07:10', 0, NULL, NULL, NULL),
(21, 10, 'Canceled', NULL, 300000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-06 18:19:44', '2026-04-06 18:19:59', 0, NULL, NULL, NULL),
(22, 10, 'Rating', NULL, 410000.00, 'Jalan Cakra', NULL, 'COD', '2026-04-06 18:30:22', '2026-04-06 18:31:53', 1, 'hmm', 'images/reviews/1775525513_whatsapp image 2025-06-06 at 21.24.54_3838d58f.jpg', 5),
(23, 10, 'Rating', NULL, 38000.00, 'Jalan Cakra Jaya', NULL, 'COD', '2026-04-06 18:43:32', '2026-04-06 18:50:55', 1, 'mmmmm', 'images/reviews/1775526655_download (1).jpg', 5),
(24, 10, 'Canceled', NULL, 112000.00, 'Jalan Cakra Jaya', NULL, 'Bank Transfer', '2026-04-06 20:00:47', '2026-04-06 20:01:14', 0, NULL, NULL, NULL),
(25, 10, 'Canceled', 'Sedang dalam perjalanan menuju rumah user', 45000.00, 'Jalan Cakra Jaya', NULL, 'Bank Transfer', '2026-04-06 21:33:05', '2026-04-06 23:17:30', 0, NULL, NULL, NULL),
(26, 10, 'Delivered', 'Arrived at the customer\'s home', 45000.00, 'Jalan Cakra Jaya, Depok, Jawa Barat', 'http://localhost/sociolla/images/payments/1775542799_download (1).jpg', 'Bank Transfer', '2026-04-06 23:17:38', '2026-04-06 23:54:29', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(7, 7, 2, 5, 224935.00, '2026-04-05 17:34:11', '2026-04-05 17:34:11'),
(8, 8, 2, 7, 224935.00, '2026-04-05 17:36:35', '2026-04-05 17:36:35'),
(9, 9, 8, 11, 129000.00, '2026-04-05 18:28:48', '2026-04-05 18:28:48'),
(10, 10, 32, 7, 60000.00, '2026-04-05 19:53:37', '2026-04-05 19:53:37'),
(12, 12, 32, 1, 60000.00, '2026-04-05 20:01:09', '2026-04-05 20:01:09'),
(13, 13, 29, 1, 125000.00, '2026-04-05 20:07:30', '2026-04-05 20:07:30'),
(14, 14, 7, 3, 410000.00, '2026-04-05 20:08:38', '2026-04-05 20:08:38'),
(15, 15, 31, 1, 75000.00, '2026-04-05 21:01:10', '2026-04-05 21:01:10'),
(16, 16, 2, 1, 220000.00, '2026-04-05 21:03:42', '2026-04-05 21:03:42'),
(19, 19, 4, 1, 32000.00, '2026-04-06 18:06:54', '2026-04-06 18:06:54'),
(21, 21, 32, 5, 60000.00, '2026-04-06 18:19:44', '2026-04-06 18:19:44'),
(22, 22, 7, 1, 410000.00, '2026-04-06 18:30:22', '2026-04-06 18:30:22'),
(23, 23, 3, 1, 38000.00, '2026-04-06 18:43:32', '2026-04-06 18:43:32'),
(24, 24, 6, 2, 56000.00, '2026-04-06 20:00:47', '2026-04-06 20:00:47'),
(25, 25, 1, 1, 45000.00, '2026-04-06 21:33:05', '2026-04-06 21:33:05'),
(26, 26, 1, 1, 45000.00, '2026-04-06 23:17:38', '2026-04-06 23:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image_url` varchar(255) DEFAULT NULL,
  `rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `description`, `price`, `original_price`, `stock`, `image_url`, `rating`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'Solar Smart UV Light Sunscreen SPF50+', 'Carasun', 'A wonderful beauty product for everyday use.', 45000.00, 60000.00, 122, '/sociolla/public/images/carasun.png', 4.80, 1, '2026-04-05 09:53:19', '2026-04-06 23:17:38'),
(2, 'Oil Free Ultra Moisturizing Lotion', 'COSRX', 'A wonderful beauty product for everyday use.', 220000.00, 280000.00, 105, '/sociolla/public/images/cosrx.png', 4.90, 2, '2026-04-05 09:53:19', '2026-04-07 02:06:10'),
(3, 'Cherry Blossom Betaine Micellar Water', 'Glad2Glow', 'A wonderful beauty product for everyday use.', 38000.00, 45000.00, 49, '/sociolla/public/images/glad2glow.png', 4.50, 1, '2026-04-05 09:53:19', '2026-04-06 18:43:32'),
(4, 'Acne Patch Day & Night', 'DermaAngel', 'A wonderful beauty product for everyday use.', 32000.00, 36000.00, 106, '/sociolla/public/images/dermaangel.png', 4.60, 2, '2026-04-05 09:53:19', '2026-04-06 18:06:54'),
(5, 'Niacinamide Moisture Sabi Beet Serum', 'Somethinc', 'A wonderful beauty product for everyday use.', 89000.00, 110000.00, 149, '/sociolla/public/images/somethinc.png', 4.30, 2, '2026-04-05 17:51:26', '2026-04-05 18:10:50'),
(6, 'Colorfit Ultralight Matte Lipstick', 'Wardah', 'A wonderful beauty product for everyday use.', 56000.00, 65000.00, 40, '/sociolla/public/images/wardah.png', 5.00, 3, '2026-04-05 17:51:26', '2026-04-06 20:01:14'),
(7, 'Neo Cushion Matte', 'Laneige', 'A wonderful beauty product for everyday use.', 410000.00, 520000.00, 114, '/sociolla/public/images/laneige.png', 4.60, 3, '2026-04-05 17:51:26', '2026-04-06 18:30:22'),
(8, '5X Ceramide Barrier Repair Moisture Gel', 'Skintific', 'A wonderful beauty product for everyday use.', 129000.00, 165000.00, 0, '/sociolla/public/images/skintific.png', 4.60, 2, '2026-04-05 17:51:26', '2026-04-06 16:53:12'),
(29, 'Miraculous Refining Toner', 'Avoskin', 'A wonderful beauty product for everyday use.', 125000.00, 189000.00, 112, '/sociolla/public/images/avoskin.png', 4.90, 2, '2026-04-05 18:14:15', '2026-04-05 20:13:45'),
(30, 'Powerstay Weightless Liquid Foundation', 'Make Over', 'A wonderful beauty product for everyday use.', 175000.00, 210000.00, 134, '/sociolla/public/images/makeover.png', 4.60, 3, '2026-04-05 18:14:15', '2026-04-05 18:14:15'),
(31, 'Centella Asiatica Face Wash', 'N\'Pure', 'A wonderful beauty product for everyday use.', 75000.00, 90000.00, 96, '/sociolla/public/images/npure.png', 4.70, 2, '2026-04-05 18:14:15', '2026-04-06 18:09:37'),
(32, 'Hydrasoothe Sunscreen Gel SPF45', 'Azarine', 'A wonderful beauty product for everyday use.', 60000.00, 75000.00, 133, '/sociolla/public/images/azarine.png', 4.40, 1, '2026-04-05 18:14:15', '2026-04-06 18:19:59');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7cm9aFqvFDBnrxyw0DdqFX8RY9KaJMTzyG72pZgb', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlFmSjdud25RVTB3R0dMMHpnT0VoaFNudDlpZHBsbW1EYWpUVFpVcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Qvc29jaW9sbGEvcmVnaXN0ZXIiO3M6NToicm91dGUiO3M6ODoicmVnaXN0ZXIiO319', 1775608870),
('nRJYgzqPT9helrXdehWyvk8lkEXWFYzLNKvgH2Ro', 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTDNraGV5WnFEUmdYTkVUOU9Qa1lld3dsZmVCeEE1TDhiRXh0YktnNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly9sb2NhbGhvc3Qvc29jaW9sbGEvYWRtaW4vYmFja3VwIjtzOjU6InJvdXRlIjtzOjEyOiJhZG1pbi5iYWNrdXAiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1775612658);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `role` enum('user','admin','petugas') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `phone`, `gender`, `avatar`, `address`, `province`, `city`, `birth_date`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'admin1234', 'admin1234', 'tiaskusumaaa@gmail.com', NULL, '$2y$12$lEY.F7YkBNsLLnC1mWsrMuHWlkv8fZJ2Gp6rXh6W/h4wAh46DMN2a', '085817091265', NULL, '/sociolla/public/images/users/1775525342.png', 'tias1234', NULL, NULL, NULL, 'admin', NULL, '2026-04-05 13:54:08', '2026-04-06 18:29:02'),
(7, 'petugas123', 'petugas123', 'tug@gmail.com', NULL, '$2y$12$0fA9IQQuThncfSo7ojpLGuoKugNXAJB3bgrACXPq828lpPf9u433W', '085817091265', NULL, '/sociolla/public/images/users/1775438815.jpg', NULL, NULL, NULL, NULL, 'petugas', NULL, '2026-04-05 15:02:38', '2026-04-06 17:51:48'),
(10, 'lala', 'lalala', 'tiasai@gmail.com', NULL, '$2y$12$nYhLNRbwRJEimvwr8lpV8uZL217QZnUHTs2dZNWBZlAFvHmWMIlnO', '08899999999', 'Perempuan', 'avatars/Qap1fAlUEfHWEVqRhFglVlyJcf6U1d6guV2BdAz8.jpg', 'Jalan Cakra Jaya', 'Jawa Barat', 'Depok', '2008-04-16', 'user', NULL, '2026-04-05 19:51:08', '2026-04-06 21:55:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_user_id_foreign` (`user_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
