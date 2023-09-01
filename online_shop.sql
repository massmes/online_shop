-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 01, 2023 at 06:38 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

DROP TABLE IF EXISTS `attributes`;
CREATE TABLE IF NOT EXISTS `attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'جنس', '2023-08-27 18:29:12', '2023-08-27 19:16:32'),
(2, 'رنگ', '2023-08-27 19:05:21', '2023-08-27 19:05:21'),
(3, 'سایز', '2023-08-27 19:05:29', '2023-08-27 19:14:43'),
(4, 'طرح پارچه', '2023-08-29 23:29:48', '2023-08-29 23:29:48'),
(5, 'نوع عدسی', '2023-08-30 20:30:41', '2023-08-30 20:30:41');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_category`
--

DROP TABLE IF EXISTS `attribute_category`;
CREATE TABLE IF NOT EXISTS `attribute_category` (
  `attribute_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `is_filter` tinyint(1) NOT NULL DEFAULT '0',
  `is_variation` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attribute_id`,`category_id`),
  KEY `attribute_category_category_id_foreign` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attribute_category`
--

INSERT INTO `attribute_category` (`attribute_id`, `category_id`, `is_filter`, `is_variation`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, NULL, NULL),
(1, 2, 0, 0, NULL, NULL),
(1, 3, 1, 0, NULL, NULL),
(1, 4, 1, 0, NULL, NULL),
(1, 6, 1, 1, NULL, NULL),
(1, 7, 1, 1, NULL, NULL),
(1, 8, 1, 1, NULL, NULL),
(1, 9, 1, 1, NULL, NULL),
(1, 10, 1, 0, NULL, NULL),
(1, 11, 1, 0, NULL, NULL),
(2, 1, 0, 1, NULL, NULL),
(2, 2, 1, 0, NULL, NULL),
(2, 3, 1, 0, NULL, NULL),
(2, 4, 1, 0, NULL, NULL),
(2, 6, 1, 0, NULL, NULL),
(2, 7, 1, 0, NULL, NULL),
(2, 8, 1, 0, NULL, NULL),
(2, 9, 1, 0, NULL, NULL),
(2, 10, 1, 1, NULL, NULL),
(2, 11, 1, 1, NULL, NULL),
(3, 1, 1, 0, NULL, NULL),
(3, 2, 0, 1, NULL, NULL),
(3, 3, 0, 1, NULL, NULL),
(3, 4, 0, 1, NULL, NULL),
(3, 6, 1, 0, NULL, NULL),
(3, 7, 1, 0, NULL, NULL),
(3, 8, 1, 0, NULL, NULL),
(3, 9, 1, 0, NULL, NULL),
(3, 10, 1, 0, NULL, NULL),
(3, 11, 1, 0, NULL, NULL),
(4, 2, 1, 0, NULL, NULL),
(4, 3, 1, 0, NULL, NULL),
(4, 4, 1, 0, NULL, NULL),
(5, 6, 1, 0, NULL, NULL),
(5, 8, 1, 0, NULL, NULL),
(5, 9, 1, 0, NULL, NULL),
(5, 10, 1, 0, NULL, NULL),
(5, 11, 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `baners`
--

DROP TABLE IF EXISTS `baners`;
CREATE TABLE IF NOT EXISTS `baners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `iamge` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
CREATE TABLE IF NOT EXISTS `brands` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `is_active`, `created_at`, `updated_at`) VALUES
(37, 'Rodenstock', 'Rodenstock', 1, '2023-08-30 20:35:22', '2023-08-30 20:36:32'),
(38, 'Zeiss', 'Zeiss', 1, '2023-08-30 20:35:32', '2023-08-30 20:35:32'),
(39, 'Ray.Ban', 'Ray-Ban', 1, '2023-08-30 20:35:51', '2023-08-30 20:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `slug`, `description`, `is_active`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'مانتو', 3, 'manteau', NULL, 1, NULL, '2023-08-28 00:10:32', '2023-08-29 23:35:41'),
(2, 'پیراهن', 4, 'mens-shirt', NULL, 1, NULL, '2023-08-28 00:37:19', '2023-08-29 23:34:53'),
(3, 'زنانه', 0, 'womens', NULL, 1, NULL, '2023-08-28 00:39:10', '2023-08-29 23:33:24'),
(4, 'مردانه', 0, 'mens', NULL, 1, NULL, '2023-08-28 01:32:21', '2023-08-29 23:31:36'),
(6, 'آفتابی', 0, 'sunglasses', 'asdsd', 1, 'sun', '2023-08-30 20:33:50', '2023-08-30 20:33:50'),
(7, 'طبی', 0, 'eyeweare', 'sadsd', 1, 'glasses', '2023-08-30 20:34:38', '2023-08-30 20:34:38'),
(8, 'آفتابی مردانه', 6, 'mens_sunglasses', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 'sun', '2023-08-30 20:42:39', '2023-08-30 20:42:39'),
(9, 'آفتابی زنانه', 6, 'women_sunglasses', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 'sun', '2023-08-30 20:43:27', '2023-08-30 20:43:27'),
(10, 'طبی زنانه', 7, 'women_eyeglasses', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, NULL, '2023-08-30 20:44:21', '2023-08-30 20:44:21'),
(11, 'طبی مردانه', 7, 'mens_eyelses', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 'eyeweare', '2023-08-30 20:45:57', '2023-08-30 20:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cities_province_id_foreign` (`province_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

DROP TABLE IF EXISTS `coupons`;
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('amount','percentage') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` int UNSIGNED DEFAULT NULL,
  `percentage` int UNSIGNED DEFAULT NULL,
  `max_percentage_amount` int UNSIGNED DEFAULT NULL,
  `expired_at` timestamp NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_08_24_020912_create_categories_table', 1),
(6, '2023_08_24_021129_create_brands_table', 1),
(7, '2023_08_24_021613_create_products_table', 1),
(8, '2023_08_24_022852_create_product_images_table', 1),
(9, '2023_08_24_024656_create_tags_table', 1),
(10, '2023_08_24_024756_create_product_tag_table', 1),
(11, '2023_08_24_025231_create_comments_table', 1),
(12, '2023_08_24_025653_create_product_rates_table', 1),
(13, '2023_08_24_025915_create_attributes_table', 1),
(14, '2023_08_24_030118_create_attribute_category_table', 1),
(15, '2023_08_24_030725_create_product_attributes_table', 1),
(16, '2023_08_24_031128_create_product_variations_table', 1),
(17, '2023_08_24_032122_create_provinces_table', 1),
(18, '2023_08_24_032248_create_cities_table', 1),
(19, '2023_08_24_032521_create_user_addresses_table', 1),
(20, '2023_08_24_033315_create_coupons_table', 1),
(21, '2023_08_24_033940_create_orders_table', 1),
(22, '2023_08_24_034910_create_order_items_table', 1),
(23, '2023_08_24_035337_create_transations_table', 1),
(24, '2023_08_24_040003_create_wishlist_table', 1),
(25, '2023_08_24_040159_create_banners_table', 1),
(26, '2023_08_24_040619_create_contact_us_table', 1),
(27, '2023_08_24_040817_create_settings_table', 1),
(28, '2014_10_12_100000_create_password_resets_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `address_id` bigint UNSIGNED NOT NULL,
  `coupon_id` bigint UNSIGNED DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `total_amount` int UNSIGNED NOT NULL,
  `delivery_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `coupon_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `paying_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `payment_type` enum('pos','cash','shabaNumber0','cardToCard','online') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_address_id_foreign` (`address_id`),
  KEY `orders_coupon_id_foreign` (`coupon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `product_variation_id` bigint UNSIGNED DEFAULT NULL,
  `price` int UNSIGNED NOT NULL,
  `quantity` int UNSIGNED NOT NULL,
  `subtotal` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_product_variation_id_foreign` (`product_variation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `primary_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `delivery_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `delivery_amount_per_product` int UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_brand_id_foreign` (`brand_id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand_id`, `category_id`, `slug`, `primary_image`, `description`, `status`, `is_active`, `delivery_amount`, `delivery_amount_per_product`, `created_at`, `updated_at`) VALUES
(1, 'آفتابی', 37, 9, 'آفتابی', '2023_8_31_0_18_46_639271_Sunglasses-men01.webp', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 1, 25000, 10000, '2023-08-30 20:48:46', '2023-09-01 05:42:57'),
(2, 'آفتابی', 37, 9, 'آفتابی-2', '2023_8_31_0_20_47_494221_Sunglasses-Ladies-04.webp', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 1, 25000, 10000, '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(3, 'طبی', 38, 10, 'طبی', '2023_8_31_0_22_31_130311_Ophthalmic-frame-Ladies-01.webp', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 1, 25000, 10000, '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(4, 'طبی زنانه', 39, 10, 'طبی-زنانه', '2023_8_31_0_24_5_202700_Ophthalmic-frame-Men-02.webp', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.', 1, 1, 25000, 10000, '2023-08-30 20:54:05', '2023-09-01 02:54:43'),
(5, 'آفتابی مردانه', 39, 8, 'آفتابی-مردانه', '2023_9_1_7_28_45_143171_Sunglasses-men04.webp', 'لورم', 1, 1, 65000, 0, '2023-08-30 23:19:39', '2023-09-01 03:58:45'),
(6, 'طبی زنانه', 37, 10, 'طبی-زنانه-2', '2023_8_31_2_53_51_394580_Weeklyـdiscounts06.webp', 'سیسیسی', 1, 1, 150000, 0, '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(7, 'آفتابی', 37, 8, 'آفتابی-3', '2023_8_31_3_53_0_395564_Sunglasses-men02.webp', 'adadsa', 1, 1, 5000, NULL, '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(8, 'آفتابی مردانه', 38, 8, 'آفتابی-مردانه-2', '2023_8_31_4_32_9_892383_mansunglasses02.jpg', 'ثیبثبیشسی', 1, 1, 120000, 0, '2023-08-31 01:02:09', '2023-09-01 00:11:43'),
(9, 'آفتابی مردانه', 38, 8, 'آفتابی-مردانه-3', '2023_9_1_3_58_10_749486_footerimg08.jpg', 'sunglasses', 1, 1, 100000, 0, '2023-09-01 00:28:10', '2023-09-01 04:27:30'),
(10, 'آفتابی زنانه', 39, 9, 'آفتابی-زنانه', '2023_9_1_9_18_15_358770_footerimg04.jpg', 'سشیسشی', 1, 0, 65000, 0, '2023-09-01 05:48:15', '2023-09-01 05:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

DROP TABLE IF EXISTS `product_attributes`;
CREATE TABLE IF NOT EXISTS `product_attributes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_attributes_attribute_id_foreign` (`attribute_id`),
  KEY `product_attributes_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `attribute_id`, `product_id`, `value`, `is_active`, `created_at`, `updated_at`) VALUES
(4, 2, 2, 'قهوه ای', 1, '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(5, 3, 2, '55-18', 1, '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(6, 5, 2, 'ساده', 1, '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(7, 1, 3, 'فلزی', 1, '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(8, 3, 3, '62-15', 1, '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(9, 5, 3, 'طبی', 1, '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(10, 1, 4, 'کایوچو', 1, '2023-08-30 20:54:05', '2023-08-30 20:54:05'),
(11, 3, 4, '55-18', 1, '2023-08-30 20:54:05', '2023-08-30 20:54:05'),
(12, 5, 4, 'ساده', 1, '2023-08-30 20:54:05', '2023-08-30 20:54:05'),
(13, 2, 5, 'طوسی', 1, '2023-08-30 23:19:39', '2023-08-30 23:19:39'),
(14, 3, 5, '62-17', 1, '2023-08-30 23:19:39', '2023-08-30 23:19:39'),
(15, 5, 5, 'پلاریزه', 1, '2023-08-30 23:19:39', '2023-08-30 23:19:39'),
(16, 1, 6, 'کایوچو', 1, '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(17, 3, 6, '58-17', 1, '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(18, 5, 6, 'ساده', 1, '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(19, 2, 7, 'آبی', 1, '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(20, 3, 7, '55', 1, '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(21, 5, 7, 'ساده', 1, '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(22, 2, 8, 'آبی', 1, '2023-08-31 01:02:09', '2023-08-31 01:02:09'),
(23, 3, 8, '62-15', 1, '2023-08-31 01:02:09', '2023-08-31 01:02:09'),
(24, 5, 8, 'پلاریزه', 1, '2023-08-31 01:02:09', '2023-08-31 01:02:09'),
(25, 2, 9, 'خاکستری', 1, '2023-09-01 00:28:10', '2023-09-01 00:28:10'),
(26, 3, 9, '68-19', 1, '2023-09-01 00:28:10', '2023-09-01 00:28:10'),
(27, 5, 9, 'پلاریزه', 1, '2023-09-01 00:28:10', '2023-09-01 00:28:10'),
(40, 2, 1, 'قرمز', 1, '2023-09-01 05:42:57', '2023-09-01 05:42:57'),
(41, 3, 1, '56-15', 1, '2023-09-01 05:42:57', '2023-09-01 05:42:57'),
(42, 5, 1, 'پلاریزه', 1, '2023-09-01 05:42:57', '2023-09-01 05:42:57'),
(46, 2, 10, 'لاجوردی', 1, '2023-09-01 05:50:09', '2023-09-01 05:50:09'),
(47, 3, 10, '70-19', 1, '2023-09-01 05:50:09', '2023-09-01 05:50:09'),
(48, 5, 10, 'ساده', 1, '2023-09-01 05:50:09', '2023-09-01 05:50:09');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(3, 2, '2023_8_31_0_20_47_495960_Sunglasses-Ladies-02.webp', '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(4, 2, '2023_8_31_0_20_47_511956_Sunglasses-Ladies-03.webp', '2023-08-30 20:50:47', '2023-08-30 20:50:47'),
(5, 3, '2023_8_31_0_22_31_131980_Ophthalmic-frame-Ladies-03.webp', '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(6, 3, '2023_8_31_0_22_31_133675_Weeklyـdiscounts06.webp', '2023-08-30 20:52:31', '2023-08-30 20:52:31'),
(7, 4, '2023_8_31_0_24_5_202700_Ophthalmic-frame-Men-02.webp', '2023-08-30 20:54:05', '2023-08-30 20:54:05'),
(11, 6, '2023_8_31_2_53_51_396313_Ophthalmic-frame-Ladies-03.webp', '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(12, 6, '2023_8_31_2_53_51_418930_Ophthalmic-frame-Ladies-04.webp', '2023-08-30 23:23:51', '2023-08-30 23:23:51'),
(13, 7, '2023_8_31_3_53_0_397405_Sunglasses-men01.webp', '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(14, 7, '2023_8_31_3_53_0_399084_Sunglasses-men04.webp', '2023-08-31 00:23:00', '2023-08-31 00:23:00'),
(17, 9, '2023_9_1_3_58_10_749486_footerimg08.jpg', '2023-09-01 00:28:10', '2023-09-01 00:28:10'),
(19, 5, '2023_9_1_7_26_3_145752_Weeklyـdiscounts04.webp', '2023-09-01 03:56:03', '2023-09-01 03:56:03'),
(20, 5, '2023_9_1_7_26_3_150582_Weeklyـdiscounts05.webp', '2023-09-01 03:56:03', '2023-09-01 03:56:03'),
(21, 5, '2023_9_1_7_29_7_644830_Weeklyـdiscounts05.webp', '2023-09-01 03:59:07', '2023-09-01 03:59:07'),
(22, 10, '2023_9_1_9_18_15_360940_oroton.jpg', '2023-09-01 05:48:15', '2023-09-01 05:48:15'),
(23, 10, '2023_9_1_9_18_15_371851_rodenstock-hero.jpg', '2023-09-01 05:48:15', '2023-09-01 05:48:15'),
(24, 10, '2023_9_1_9_18_15_373798_Swarovski-Eyewear.jpg', '2023-09-01 05:48:15', '2023-09-01 05:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `product_rates`
--

DROP TABLE IF EXISTS `product_rates`;
CREATE TABLE IF NOT EXISTS `product_rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `rate` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_rates_user_id_foreign` (`user_id`),
  KEY `product_rates_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tag`
--

DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE IF NOT EXISTS `product_tag` (
  `tag_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tag_id`,`product_id`),
  KEY `product_tag_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_tag`
--

INSERT INTO `product_tag` (`tag_id`, `product_id`, `created_at`, `updated_at`) VALUES
(8, 1, NULL, NULL),
(8, 5, NULL, NULL),
(8, 7, NULL, NULL),
(8, 8, NULL, NULL),
(8, 9, NULL, NULL),
(9, 1, NULL, NULL),
(9, 2, NULL, NULL),
(9, 5, NULL, NULL),
(9, 7, NULL, NULL),
(9, 8, NULL, NULL),
(9, 9, NULL, NULL),
(9, 10, NULL, NULL),
(10, 2, NULL, NULL),
(10, 10, NULL, NULL),
(11, 3, NULL, NULL),
(11, 4, NULL, NULL),
(11, 6, NULL, NULL),
(11, 8, NULL, NULL),
(11, 9, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_variations`
--

DROP TABLE IF EXISTS `product_variations`;
CREATE TABLE IF NOT EXISTS `product_variations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `attribute_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_price` int UNSIGNED DEFAULT NULL,
  `date_on_sale_from` timestamp NULL DEFAULT NULL,
  `date_on_sale_to` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variations_attribute_id_foreign` (`attribute_id`),
  KEY `product_variations_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variations`
--

INSERT INTO `product_variations` (`id`, `attribute_id`, `product_id`, `value`, `price`, `quantity`, `sku`, `sale_price`, `date_on_sale_from`, `date_on_sale_to`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'کایوچو', 550000, 5, 'R55-15', 400000, '2023-11-03 00:37:00', '2023-11-20 20:30:00', '2023-08-30 20:48:46', '2023-09-01 05:42:57', '2023-09-01 05:42:57'),
(2, 1, 1, 'فلزی', 650000, 9, 'R58-18', 500000, '2023-09-23 00:35:54', '2023-10-10 20:30:00', '2023-08-30 20:48:46', '2023-09-01 05:42:57', '2023-09-01 05:42:57'),
(3, 1, 2, 'فلزی', 680000, 3, 'R45980', NULL, NULL, NULL, '2023-08-30 20:50:47', '2023-08-30 20:50:47', NULL),
(4, 2, 3, 'بنفش', 980000, 3, 'Z3456', NULL, NULL, NULL, '2023-08-30 20:52:31', '2023-08-30 20:52:31', NULL),
(5, 2, 4, 'ابلق', 800000, 2, '475', NULL, NULL, NULL, '2023-08-30 20:54:05', '2023-08-30 20:54:05', NULL),
(6, 1, 5, 'فلز _ کایوچو', 950000, 1, 'R25068L', NULL, NULL, NULL, '2023-08-30 23:19:39', '2023-08-30 23:19:39', NULL),
(7, 2, 6, 'طلایی', 980000, 3, 'R5439M', NULL, NULL, NULL, '2023-08-30 23:23:51', '2023-08-30 23:23:51', NULL),
(8, 1, 7, 'فلز', 90000, 6, '54', NULL, NULL, NULL, '2023-08-31 00:23:00', '2023-08-31 00:23:00', NULL),
(9, 1, 7, 'کایوچو', 870000, 10, '8798', NULL, NULL, NULL, '2023-08-31 00:23:00', '2023-08-31 00:23:00', NULL),
(10, 1, 8, 'فیبر کربن', 1580000, 1, '9845', 1000000, '2023-09-02 00:11:20', '2023-09-14 20:30:00', '2023-08-31 01:02:09', '2023-09-01 00:21:14', NULL),
(11, 1, 8, 'فلزی', 1000000, 5, '9878', 350000, '2023-09-04 00:14:24', '2023-09-14 20:30:00', '2023-08-31 01:02:09', '2023-09-01 00:21:14', NULL),
(12, 1, 8, 'پلاستیک', 500000, 9, '125', NULL, NULL, NULL, '2023-08-31 01:02:09', '2023-08-31 01:02:09', NULL),
(13, 1, 9, 'فلزی', 980000, 3, 'Z8975Z', NULL, NULL, NULL, '2023-09-01 00:28:10', '2023-09-01 00:28:10', NULL),
(14, 1, 9, 'کائوچو', 2850000, 1, 'ZWP98', NULL, NULL, NULL, '2023-09-01 00:28:10', '2023-09-01 00:28:10', NULL),
(15, 1, 1, 'فلز', 95000, 2, '54wq', NULL, NULL, NULL, '2023-09-01 05:42:57', '2023-09-01 05:42:57', NULL),
(16, 2, 10, 'لاجوردی', 1000000, 2, 'l23F', NULL, NULL, NULL, '2023-09-01 05:48:15', '2023-09-01 05:50:09', '2023-09-01 05:50:09'),
(17, 1, 10, 'فلزی', 5600000, 2, 'LPG', NULL, NULL, NULL, '2023-09-01 05:50:09', '2023-09-01 05:50:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

DROP TABLE IF EXISTS `provinces`;
CREATE TABLE IF NOT EXISTS `provinces` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `instagram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telegram` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ژاکت', '2023-08-28 23:32:55', '2023-08-28 23:32:55'),
(2, 'کت', '2023-08-28 23:42:31', '2023-08-29 23:28:46'),
(3, 'دامن', '2023-08-29 00:40:12', '2023-08-29 23:28:56'),
(4, 'پیراهن', '2023-08-29 00:40:34', '2023-08-29 23:29:10'),
(8, 'آفتابی مردانه', '2023-08-30 20:31:47', '2023-08-30 20:31:47'),
(9, 'آفتابی', '2023-08-30 20:32:26', '2023-08-30 20:32:26'),
(10, 'آفتابی زنانه', '2023-08-30 20:32:39', '2023-08-30 20:32:39'),
(11, 'طبی', '2023-08-30 20:32:47', '2023-08-30 20:32:47');

-- --------------------------------------------------------

--
-- Table structure for table `transations`
--

DROP TABLE IF EXISTS `transations`;
CREATE TABLE IF NOT EXISTS `transations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `amount` int UNSIGNED NOT NULL,
  `ref_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `gateway_name` enum('zarinpal','pay') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transations_user_id_foreign` (`user_id`),
  KEY `transations_order_id_foreign` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cellphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provider_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_name_unique` (`user_name`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE IF NOT EXISTS `user_addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cellphone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `province_id` bigint NOT NULL,
  `city_id` bigint NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_addresses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`product_id`),
  KEY `wishlist_product_id_foreign` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attribute_category`
--
ALTER TABLE `attribute_category`
  ADD CONSTRAINT `attribute_category_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attribute_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_province_id_foreign` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `user_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_variation_id_foreign` FOREIGN KEY (`product_variation_id`) REFERENCES `product_variations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_rates`
--
ALTER TABLE `product_rates`
  ADD CONSTRAINT `product_rates_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_tag`
--
ALTER TABLE `product_tag`
  ADD CONSTRAINT `product_tag_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variations`
--
ALTER TABLE `product_variations`
  ADD CONSTRAINT `product_variations_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_variations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transations`
--
ALTER TABLE `transations`
  ADD CONSTRAINT `transations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlist_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
