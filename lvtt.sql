-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 02, 2023 lúc 04:37 PM
-- Phiên bản máy phục vụ: 10.4.25-MariaDB
-- Phiên bản PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `lvtt`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0: admin, 1: staff',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `code`, `fullname`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '12321', 'Admin', 'admin@gmail.com', NULL, '$2y$10$IreZZBVDGSCMdSBMuOF0g.z0W7UW0oMIJb44JC18ZO6Phjiqm/Lby', 0, NULL, NULL, NULL),
(3, '83961', 'Nguyen Huy Duy Vu', 'nguyenhuyduyvu@gmail.com', NULL, '$2y$10$D/jvn52AImQ0/VbQuLNJ1uuwQSf3Q5sMAwz/hs7TcvGhmsKpw5wiy', 1, NULL, '2023-08-16 09:47:05', '2023-08-16 09:47:05'),
(4, '10187', 'Vô Danh', 'nguyenhuyduyvu123@gmail.com', NULL, '$2y$10$5EMGxa2AF.RFrNxEshuADecF2eFBO4wR3AZMNcH2mdfxFCttljSZG', 1, NULL, '2023-08-16 11:47:41', '2023-08-16 11:47:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brand`
--

CREATE TABLE `brand` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brand`
--

INSERT INTO `brand` (`id`, `name`, `slug`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Xiaomi', 'xiaomi', NULL, '2023-08-25 08:05:50', '2023-08-25 08:05:50'),
(2, 'Samsung', 'samsung', NULL, '2023-08-25 08:06:01', '2023-08-25 08:06:01'),
(3, 'Khác', 'other', NULL, '2023-08-25 08:06:36', '2023-08-25 08:06:36'),
(4, 'Vivo', 'vivo', NULL, '2023-08-25 08:06:49', '2023-08-25 08:06:49'),
(5, 'Lenovo', 'lenovo', NULL, '2023-08-25 08:07:06', '2023-08-25 08:07:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_collection_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `checkItem` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `customer_id`, `product_id`, `product_collection_id`, `quantity`, `checkItem`, `created_at`, `updated_at`) VALUES
(36, 2, 1, 1, 1, 1, '2023-09-08 06:07:43', '2023-09-08 06:07:50'),
(57, 1, 3, 6, 1, 1, '2023-10-02 14:10:55', '2023-10-02 14:11:00'),
(58, 1, 3, 5, 1, 1, '2023-10-02 14:10:57', '2023-10-02 14:11:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `image`, `meta_title`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Điện thoại', 'dien-thoai', 'storage/category/64e8c4290b59a.png', 'Điện thoại thông minh', 'bla bla', NULL, '2023-08-25 08:09:29', '2023-08-25 08:09:29'),
(2, 'Đồng hồ thông minh', 'dong-ho-thong-minh', 'storage/category/64e8c44879bf7.jpg', 'Đồng hồ thông minh', 'bla bla', NULL, '2023-08-25 08:10:00', '2023-08-25 08:10:00'),
(3, 'Gia dụng', 'gia-dung', 'storage/category/64e8c46ba7b30.jpg', 'Đồ gia dụng tiện lợi', 'bla bla', NULL, '2023-08-25 08:10:35', '2023-08-25 08:10:35'),
(4, 'Đồ điện tử', 'do-dien-tu', 'storage/category/64e8c48e86a20.jpg', 'Đồ điện tử', 'bla bla', NULL, '2023-08-25 08:11:10', '2023-08-25 08:11:10'),
(5, 'Khác', 'other', 'storage/category/64e8c4a76fd06.png', 'Những sản phẩm khác', 'bla bla', NULL, '2023-08-25 08:11:35', '2023-08-25 08:11:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` tinyint(4) NOT NULL COMMENT '1 => nam, 2 => nữ, 3 => khác',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer`
--

INSERT INTO `customer` (`id`, `code`, `email`, `email_verified_at`, `password`, `fullname`, `phone`, `gender`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '2898162151', 'nguyenhuyduyvu@gmail.com', NULL, '$2y$10$nIIz0H4hede6LNzJeypK3eVRMY0Y72bBn0FLYIUqC7O0kT.DhUmey', 'Nguyen Huy Duy Vu', '0944970601', 1, 'B9trtX58QnKX5LpsZ38TQYSD9YZlT0bSRi3DPjOzzpcs4uHRAhCVWAd9DCEq', '2023-08-11 07:01:47', '2023-08-11 07:01:47'),
(2, '1638218398', 'nguyenhuyduyvu123@gmail.com', NULL, '$2y$10$E4vCU.vHQnV.LjDJsJNI0Oq7dAyN3CNXygZR1r2Ou9pwTpMZCMi0m', 'Vô Danh', '9876543210', 2, NULL, '2023-09-07 09:49:13', '2023-09-07 09:49:13'),
(3, '2478412389', 'admin@gmail.com', NULL, '$2y$10$398iFwqnE4.j0WYorEptmOR3tdT72QQLNZzBre3m2KOSRe5nYfMyS', 'Admin', '0987654321', 3, NULL, '2023-09-25 15:39:29', '2023-09-25 15:39:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `customer_address`
--

CREATE TABLE `customer_address` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_code` int(10) NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_code` int(10) NOT NULL,
  `wards` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wards_code` int(10) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selected` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=>non-selected,1=>selected',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `customer_address`
--

INSERT INTO `customer_address` (`id`, `customer_id`, `fullname`, `phone`, `province`, `province_code`, `district`, `district_code`, `wards`, `wards_code`, `address`, `selected`, `created_at`, `updated_at`) VALUES
(6, 1, 'Nguyễn Huy Duy Vũ', '0944970601', 'An Giang', 217, 'Thành phố Long Xuyên', 1566, 'Xã Mỹ Hoà Hưng', 510113, 'Mỹ Khánh ', 1, '2023-09-26 13:38:55', '2023-10-02 14:11:21'),
(7, 1, 'Nguyễn Văn b', '0379503424', 'Cần Thơ', 220, 'Quận Ninh Kiều', 1572, 'Phường Xuân Khánh', 550113, 'Hẻm 3, Mậu thân', 0, '2023-09-26 13:40:10', '2023-10-02 14:11:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `grn`
--

CREATE TABLE `grn` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `storekeeper` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receiving_clerk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `grn`
--

INSERT INTO `grn` (`id`, `storekeeper`, `receiving_clerk`, `supplier`, `total_price`, `created_at`, `updated_at`) VALUES
(1, 'Duy Vũ', 'Admin', 'Acb', 1000000000, '2023-08-25 09:17:22', '2023-08-25 09:17:22'),
(2, 'Duy Vũ', 'Admin', 'Samsung ', 2000000000, '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(3, 'Duy Vũ', 'Admin', 'abc', 30000000, '2023-08-25 09:25:36', '2023-08-25 09:25:36'),
(4, 'duy vũ', 'Admin', 'abc', 30000000, '2023-08-25 09:28:40', '2023-08-25 09:28:40'),
(5, 'duy vũ', 'Admin', 'acb', 30000000, '2023-09-03 00:50:42', '2023-09-03 00:50:42'),
(6, 'Duy Vũ', 'Admin', 'abc', 12000000, '2023-09-12 09:39:45', '2023-09-12 09:39:45'),
(7, 'Duy Vũ', 'Admin', 'acb', 500000000, '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(9, 'Duy Vũ', 'Admin', 'ABC', 200000000, '2023-09-26 15:25:01', '2023-09-26 15:25:01'),
(10, 'Duy Vũ', 'Admin', 'ABC', 10000000, '2023-09-28 15:40:25', '2023-09-28 15:40:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `grn_detail`
--

CREATE TABLE `grn_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `grn_id` bigint(20) UNSIGNED NOT NULL,
  `product_code` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `original_price` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `transportation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `grn_detail`
--

INSERT INTO `grn_detail` (`id`, `grn_id`, `product_code`, `quantity`, `original_price`, `price`, `transportation`, `created_at`, `updated_at`) VALUES
(1, 1, 12345, 100, 10000000, 14500000, 'Đường bộ', '2023-08-25 09:17:22', '2023-08-25 09:17:22'),
(2, 2, 11111, 100, 20000000, 24350000, 'Đường bộ', '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(3, 3, 45322, 100, 300000, 310000, 'Đường bộ', '2023-08-25 09:25:36', '2023-08-25 09:25:36'),
(4, 4, 12345, 2, 10500000, 14500000, 'Đường bộ', '2023-08-25 09:28:40', '2023-08-25 09:28:40'),
(5, 4, 45322, 30, 300000, 310000, 'Đường bộ', '2023-08-25 09:28:40', '2023-08-25 09:28:40'),
(6, 5, 12343, 100, 300000, 320000, 'Đường bộ', '2023-09-03 00:50:42', '2023-09-03 00:50:42'),
(7, 6, 54674, 80, 120000, 125000, 'Đường bộ', '2023-09-12 09:39:45', '2023-09-12 09:39:45'),
(8, 7, 34521, 100, 5000000, 5450000, 'Đường bộ', '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(9, 9, 45634, 10, 20000000, 22000000, 'Đường bộ', '2023-09-26 15:25:01', '2023-09-26 15:25:01'),
(10, 10, 9766, 25, 400000, 500000, 'Đường bộ', '2023-09-28 15:40:25', '2023-09-28 15:40:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2023_08_11_125949_create_customer_table', 1),
(3, '2023_08_11_130012_create_admin_table', 1),
(4, '2023_08_12_143312_create_category_table', 2),
(5, '2023_08_12_143319_create_brand_table', 2),
(6, '2023_08_12_143323_create_products_table', 3),
(7, '2023_08_12_144207_create_product_image_table', 3),
(8, '2023_08_12_144223_create_product_collection_table', 3),
(9, '2023_08_14_133613_create_grn_table', 4),
(10, '2023_08_14_133620_create_grn_detail_table', 4),
(11, '2023_08_16_124257_create_category_table', 5),
(12, '2023_08_16_124305_create_brand_table', 5),
(13, '2023_08_16_124314_create_products_table', 5),
(14, '2023_08_16_124322_create_product_image_table', 5),
(15, '2023_08_16_124342_create_product_collection_table', 5),
(16, '2023_08_16_124354_create_product_grn_table', 5),
(17, '2023_08_16_124401_create_product_grn_detail_table', 5),
(18, '2023_08_16_135205_create_permission_tables', 6),
(19, '2023_08_31_131716_create_carts_table', 7),
(20, '2023_08_31_132807_create_customer_address_table', 8),
(21, '2023_08_31_133046_create_order_table', 8),
(22, '2023_08_31_133050_create_order_detail_table', 8),
(23, '2023_09_07_142413_create_order_table', 9),
(24, '2023_09_07_142421_create_order_detail_table', 9),
(25, '2023_09_20_125527_create_review_table', 10),
(26, '2023_09_20_125541_create_reply_review_table', 11),
(27, '2023_09_21_215119_create_wishlist_table', 12);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 1),
(2, 'App\\Models\\Admin', 3),
(3, 'App\\Models\\Admin', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_code` int(11) NOT NULL,
  `district` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_code` int(11) NOT NULL,
  `wards` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wards_code` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` int(11) NOT NULL,
  `status_message` int(11) NOT NULL DEFAULT 0 COMMENT '0=> đặt thành công, 1=>xác nhận đơn hàng, 2=>đang vận chuyển, 3=>giao hàng thành công,4=>hủy đơn hàng',
  `payment_mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_id` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`id`, `customer_id`, `fullname`, `email`, `phone`, `province`, `province_code`, `district`, `district_code`, `wards`, `wards_code`, `address`, `total_price`, `status_message`, `payment_mode`, `payment_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nguyễn Huy Duy Vũ', 'nguyenhuyduyvu@gmail.com', '0944970601', 'An Giang', 217, 'Thành phố Long Xuyên', 1566, 'Xã Mỹ Hoà Hưng', 510113, 'Mỹ Khánh', 29995500, 3, 'Cash On Delivery', 0, '2023-09-07 08:28:16', '2023-09-07 08:28:16'),
(2, 1, 'Nguyễn Huy Duy Vũ', 'nguyenhuyduyvu@gmail.com', '0944970601', 'An Giang', 217, 'Thành phố Long Xuyên', 1566, 'Xã Mỹ Hoà Hưng', 510113, 'Mỹ Khánh', 249930502, 3, 'Cash On Delivery', 0, '2023-09-07 08:37:43', '2023-09-07 08:37:43'),
(4, 1, 'Nguyễn Huy Duy Vũ', 'nguyenhuyduyvu@gmail.com', '0944970601', 'An Giang', 217, 'Thành phố Long Xuyên', 1566, 'Xã Mỹ Hoà Hưng', 510113, 'Mỹ Khánh ', 38870501, 3, 'Cash On Delivery', 0, '2023-09-27 09:43:15', '2023-09-27 09:43:15'),
(5, 1, 'Nguyễn Huy Duy Vũ', 'nguyenhuyduyvu@gmail.com', '0944970601', 'An Giang', 217, 'Thành phố Long Xuyên', 1566, 'Xã Mỹ Hoà Hưng', 510113, 'Mỹ Khánh ', 335500, 0, 'Cash On Delivery', 0, '2023-09-28 14:12:50', '2023-09-28 14:12:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_collection_id` int(20) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `rstatus` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `product_collection_id`, `quantity`, `price`, `rstatus`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 2, 14990000, 1, '2023-09-07 08:28:16', '2023-09-20 08:30:57'),
(2, 2, 2, 4, 10, 24990000, 1, '2023-09-07 08:37:43', '2023-09-20 08:52:09'),
(5, 4, 7, 11, 1, 24350000, 1, '2023-09-27 09:43:15', '2023-09-28 14:04:50'),
(6, 4, 1, 2, 1, 14500000, 1, '2023-09-27 09:43:15', '2023-09-28 14:04:50'),
(7, 5, 4, NULL, 1, 320000, 0, '2023-09-28 14:12:50', '2023-09-28 14:12:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'add product', 'admin', '2023-08-16 07:51:08', '2023-08-16 07:51:08'),
(2, 'edit product', 'admin', '2023-08-16 07:51:14', '2023-08-16 07:51:14'),
(3, 'add category', 'admin', '2023-08-16 07:51:24', '2023-08-16 07:51:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_code` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `small_description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1=hidden,0=visible',
  `rating` double NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `is_trending` tinyint(1) NOT NULL DEFAULT 0,
  `height` int(11) NOT NULL COMMENT 'cm',
  `weight` int(11) NOT NULL COMMENT 'gram',
  `width` int(11) NOT NULL COMMENT 'cm',
  `length` int(11) NOT NULL COMMENT 'cm',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `product_code`, `name`, `slug`, `category_id`, `brand_id`, `image`, `small_description`, `description`, `quantity`, `price`, `status`, `rating`, `is_new`, `is_trending`, `height`, `weight`, `width`, `length`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 12345, 'Xiaomi 12T', 'xiaomi-12t', 1, 1, 'storage/product/64e8d412d629f.png', 'bla bla', '<p>bla bla</p>', 102, 14500000, 0, 5, 1, 0, 8, 600, 15, 30, NULL, '2023-08-25 09:17:22', '2023-09-27 09:57:47'),
(2, 11111, 'Samsung Galaxy S22 ultra ram 8GB, rom 128GB', 'samsung-galaxy-s22-ultra', 1, 2, 'storage/product/64e8d5372391b.jpg', 'bla bla', '<p>hello</p>', 90, 24350000, 0, 4, 1, 0, 8, 600, 15, 30, NULL, '2023-08-25 09:22:15', '2023-09-27 09:52:45'),
(3, 45322, 'Áo thun', 'ao-thun', 5, 3, 'storage/product/64e8d6005d936.jpg', 'bla bla', '<p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Mô tả tổng quan:</span></p><p class=\"ql-align-justify\">Áo thun Unisex Classic Cotton Tee là một sản phẩm thời trang đơn giản nhưng đa dụng, phù hợp cho cả nam và nữ. Được làm từ chất liệu cotton cao cấp, áo thun này đảm bảo sự thoải mái và thoáng mát cho người mặc trong suốt cả ngày.</p><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Màu sắc:</span></p><p class=\"ql-align-center\"><img src=\"data:image/png;base64,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\"></p><p class=\"ql-align-justify\">Có sẵn trong nhiều màu sắc phong cách và dễ kết hợp như đen, trắng, xanh navy, đỏ, và xám.</p><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Chất liệu:</span></p><ul><li class=\"ql-align-justify\">100% cotton với sợi bông tự nhiên mềm mịn.</li><li class=\"ql-align-justify\">Đường may tỉ mỉ và chắc chắn để đảm bảo độ bền.</li></ul><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Kiểu dáng:</span></p><ul><li class=\"ql-align-justify\">Thiết kế unisex, phù hợp cho cả nam và nữ.</li><li class=\"ql-align-justify\">Cổ tròn thoải mái với độ co dãn vừa phải, giúp áo dễ mặc và tháo ra.</li><li class=\"ql-align-justify\">Tay áo ngắn vừa, tạo nên sự thoải mái và phong cách.</li><li class=\"ql-align-justify\">Form áo regular fit, không quá ôm sát cơ thể nhưng cũng không rộng rãi quá mức.</li></ul><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Kích thước:</span></p><ul><li class=\"ql-align-justify\">Sản phẩm có sẵn từ size XS đến XXL, phù hợp cho mọi người.</li></ul><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Các đặc điểm nổi bật:</span></p><ul><li class=\"ql-align-justify\">Chất liệu cotton mềm mịn và thoáng mát.</li><li class=\"ql-align-justify\">Áo thun phù hợp cho cả ngày hè và đông.</li><li class=\"ql-align-justify\">Dễ dàng kết hợp với nhiều trang phục khác nhau.</li><li class=\"ql-align-justify\">Dễ giặt và bảo quản.</li></ul><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Giá cả:</span></p><ul><li class=\"ql-align-justify\">Giá thường dao động từ $15 đến $25 tùy thuộc vào kích thước và màu sắc.</li></ul><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Sản phẩm đi kèm:</span></p><p class=\"ql-align-justify\">Áo thun Unisex Classic Cotton Tee thường không đi kèm với bất kỳ phụ kiện nào, nhưng có thể dễ dàng kết hợp với nhiều loại quần, váy, hoặc phụ kiện thời trang khác.</p><p class=\"ql-align-justify\"><span style=\"color: var(--tw-prose-bold);\">Ứng dụng:</span></p><ul><li class=\"ql-align-justify\">Đi làm hàng ngày.</li><li class=\"ql-align-justify\">Dạo chơi, gặp gỡ bạn bè.</li><li class=\"ql-align-justify\">Sự lựa chọn hoàn hảo cho những người ưa thích phong cách thời trang đơn giản và thoải mái.</li></ul><p class=\"ql-align-justify\">Đó là mô tả chi tiết về một sản phẩm áo thun. Áo thun này thường là một món đồ cơ bản và phổ biến trong tủ quần áo của mọi người.</p>', 130, 310000, 0, 0, 1, 0, 3, 100, 10, 8, NULL, '2023-08-25 09:25:36', '2023-09-28 14:12:13'),
(4, 12343, 'Chảo chống dính', 'chao-chong-dinh', 3, 3, 'storage/product/64f43ad2599f4.jpg', 'bla bla bla', 'bla bla bla\n', 99, 320000, 0, 0, 0, 0, 7, 340, 20, 35, NULL, '2023-09-03 00:50:42', '2023-09-28 14:12:50'),
(5, 54674, 'Quạt Senko', 'quat-senko', 4, 3, 'storage/product/6500945184943.jpg', 'Đẹp', '<p>Đẹp </p><p><br></p>', 80, 125000, 0, 0, 1, 1, 70, 3000, 55, 30, NULL, '2023-09-12 09:39:45', '2023-09-26 15:31:09'),
(6, 34521, 'Xiaomi K30 5G rom 128GB,ram 6GB', 'xiaomi-k30-5g-rom-128gbram-6gb', 1, 1, 'storage/product/650095006739c.jpg', 'bla bla bla', '<p>bla bla</p>', 100, 5450000, 0, 0, 1, 1, 8, 500, 12, 22, NULL, '2023-09-12 09:42:40', '2023-09-26 15:30:05'),
(7, 45634, 'MSI Gaming GE66 Raider', 'msi-gaming-ge66-raider', 5, 3, 'storage/product/6512f7cd7fbd4.jpg', 'bla bla', '<p>bla bla bla bla bla bla</p>', 10, 22000000, 0, 5, 1, 1, 5, 2400, 8, 30, NULL, '2023-09-26 15:25:01', '2023-09-27 16:53:56'),
(8, 9766, 'Xiaomi Mi Band 4', 'xiaomi-mi-band-4', 5, 1, 'storage/product/65159e697ed3e.jpg', 'bla bla bla bla bla bla', '<p>bla bla bla bla bla bla</p>', 25, 500000, 0, 0, 1, 0, 5, 150, 8, 8, NULL, '2023-09-28 15:40:25', '2023-09-28 15:40:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_collection`
--

CREATE TABLE `product_collection` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name_collection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_collection`
--

INSERT INTO `product_collection` (`id`, `product_id`, `name_collection`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'Màu Xanh', 47, 14990000, '2023-08-25 09:17:22', '2023-08-25 09:28:40'),
(2, 1, 'Màu trắng', 55, 14500000, '2023-08-25 09:17:22', '2023-08-25 09:17:22'),
(3, 2, 'Màu trắng', 55, 24350000, '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(4, 2, 'Màu đen', 35, 24990000, '2023-08-25 09:22:15', '2023-09-07 08:37:43'),
(5, 3, 'Màu Trắng', 40, 310000, '2023-08-25 09:25:36', '2023-08-25 09:28:40'),
(6, 3, 'Màu Đen', 40, 310000, '2023-08-25 09:25:36', '2023-08-25 09:28:40'),
(7, 3, 'Màu xám', 50, 320000, '2023-08-25 09:25:36', '2023-08-25 09:28:40'),
(8, 6, 'Màu xanh', 50, 5455000, '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(9, 6, 'Màu tím', 50, 5450000, '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(10, 7, 'RAM 8GB, ROM 256GB', 6, 22000000, '2023-09-26 15:25:01', '2023-09-26 15:25:01'),
(11, 7, 'RAM 16GB, ROM 256GB', 4, 24350000, '2023-09-26 15:25:01', '2023-09-26 15:25:01'),
(12, 8, 'Màu Đen', 10, 500000, '2023-09-28 15:40:25', '2023-09-28 15:40:25'),
(13, 8, 'Màu Vàng', 15, 510000, '2023-09-28 15:40:25', '2023-09-28 15:40:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_image`
--

CREATE TABLE `product_image` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_image`
--

INSERT INTO `product_image` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'storage/product/64e8d412d7ede.jpg', '2023-08-25 09:17:22', '2023-08-25 09:17:22'),
(2, 1, 'storage/product/64e8d412d8886.jpg', '2023-08-25 09:17:22', '2023-08-25 09:17:22'),
(3, 2, 'storage/product/64e8d5372572f.jpg', '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(4, 2, 'storage/product/64e8d537261c3.jpg', '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(5, 2, 'storage/product/64e8d53726a93.png', '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(6, 2, 'storage/product/64e8d53727376.jpg', '2023-08-25 09:22:15', '2023-08-25 09:22:15'),
(7, 3, 'storage/product/64e8d6005ff1e.webp', '2023-08-25 09:25:36', '2023-08-25 09:25:36'),
(8, 3, 'storage/product/64e8d600606e0.jpg', '2023-08-25 09:25:36', '2023-08-25 09:25:36'),
(9, 3, 'storage/product/64e8d60060d80.jpg', '2023-08-25 09:25:36', '2023-08-25 09:25:36'),
(10, 6, 'storage/product/65009500690f3.jpg', '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(11, 6, 'storage/product/65009500699d4.jpg', '2023-09-12 09:42:40', '2023-09-12 09:42:40'),
(12, 8, 'storage/product/65159e698463f.jpg', '2023-09-28 15:40:25', '2023-09-28 15:40:25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reply_review`
--

CREATE TABLE `reply_review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `reply_customer_id` bigint(20) NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Quản trị viên',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reply_review`
--

INSERT INTO `reply_review` (`id`, `review_id`, `reply_customer_id`, `comment`, `name`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'Cám ơn', 'Quản trị viên', '2023-09-20 16:02:11', '2023-09-20 16:02:11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED NOT NULL,
  `rating` double NOT NULL,
  `outstanding_feature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `collection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'None',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Không có bình luận',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id`, `customer_id`, `order_item_id`, `rating`, `outstanding_feature`, `collection`, `comment`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 5, 'Đẹp', 'Màu Xanh', 'Đẹp vkl', '2023-09-20 08:30:57', '2023-09-20 08:30:57'),
(3, 1, 2, 4, 'Nomal', 'Màu đen', 'Đẹp mà', '2023-09-20 08:52:09', '2023-09-20 08:52:09'),
(15, 1, 5, 5, 'None', 'RAM 16GB, ROM 256GB', 'Không có bình luận', '2023-09-28 14:04:49', '2023-09-28 14:04:49'),
(16, 1, 6, 5, 'None', 'Màu trắng', 'Không có bình luận', '2023-09-28 14:04:50', '2023-09-28 14:04:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin', '2023-08-16 07:44:30', '2023-08-16 07:44:30'),
(2, 'writer', 'admin', '2023-08-16 07:47:17', '2023-08-16 07:47:17'),
(3, 'editer', 'admin', '2023-08-16 07:47:24', '2023-08-16 07:47:24'),
(5, 'hello', 'admin', '2023-08-17 09:37:56', '2023-08-17 09:37:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(2, 1),
(2, 2),
(3, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `wishlist`
--

INSERT INTO `wishlist` (`id`, `customer_id`, `product_id`, `created_at`, `updated_at`) VALUES
(16, 1, 1, '2023-09-23 15:20:52', '2023-09-23 15:20:52'),
(17, 1, 4, '2023-09-28 14:08:56', '2023-09-28 14:08:56'),
(18, 1, 2, '2023-10-02 14:04:38', '2023-10-02 14:04:38');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

--
-- Chỉ mục cho bảng `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_product_id_foreign` (`product_id`),
  ADD KEY `carts_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_email_unique` (`email`);

--
-- Chỉ mục cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_address_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `grn`
--
ALTER TABLE `grn`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `grn_detail`
--
ALTER TABLE `grn_detail`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_customer_id_foreign` (`customer_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_order_id_foreign` (`order_id`),
  ADD KEY `order_detail_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Chỉ mục cho bảng `product_collection`
--
ALTER TABLE `product_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_collection_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image_product_id_foreign` (`product_id`);

--
-- Chỉ mục cho bảng `reply_review`
--
ALTER TABLE `reply_review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reply_review_review_id_foreign` (`review_id`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_customer_id_foreign` (`customer_id`),
  ADD KEY `review_order_item_id_foreign` (`order_item_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Chỉ mục cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wishlist_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `brand`
--
ALTER TABLE `brand`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `grn`
--
ALTER TABLE `grn`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `grn_detail`
--
ALTER TABLE `grn_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `product_collection`
--
ALTER TABLE `product_collection`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `reply_review`
--
ALTER TABLE `reply_review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `customer_address`
--
ALTER TABLE `customer_address`
  ADD CONSTRAINT `customer_address_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Các ràng buộc cho bảng `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_detail_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brand` (`id`),
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Các ràng buộc cho bảng `product_collection`
--
ALTER TABLE `product_collection`
  ADD CONSTRAINT `product_collection_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `reply_review`
--
ALTER TABLE `reply_review`
  ADD CONSTRAINT `reply_review_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `review` (`id`);

--
-- Các ràng buộc cho bảng `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `review_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_detail` (`id`);

--
-- Các ràng buộc cho bảng `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
