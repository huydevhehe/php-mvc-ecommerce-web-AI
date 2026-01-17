-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 04, 2025 lúc 07:32 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `my_store`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`id`, `username`, `password`, `role`, `created_at`, `fullname`) VALUES
(1, 'huydzhehe7', '$2y$12$0pvvN.fEPLLUfcOvMsdXeu22iMTVtEsM9j4ZsrljUBA983B3JVKRm', 'user', '2025-06-04 03:04:50', NULL),
(2, 'huydzhehe3', '$2y$12$ceI6AzQc6/xSVpAY7kP7/.s5iCmXZP.rstwt89Ulnbo4wBQ8yqMke', 'user', '2025-06-04 03:37:23', NULL),
(3, 'huydzhehe4', '$2y$12$/tvGSYsyIVpdLk1rpM3ceu9AGslkjs1u4ZXZyidnKrjw5kr.JmnRe', 'user', '2025-06-04 03:40:04', NULL),
(4, 'huydzhehe5', '$2y$12$jbPSyqSB35Y43qA9dJmqKu5z4QSVFUY6ZFUXCO6d.lNmtCspntzLK', 'user', '2025-06-04 03:41:29', NULL),
(5, 'huydzhehe6', '$2y$12$7i.9F2EMH9S1TWbvSOyg.u4V86/BBjMMgXRhqtC6T4XPuy64uP4dq', 'user', '2025-06-04 03:42:55', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'dth', 'czzxc'),
(2, 'shoppe', 'ok'),
(4, 'đồ chiên xào', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_percent` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `usage_limit` int(11) DEFAULT 0,
  `used_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount_codes`
--

INSERT INTO `discount_codes` (`id`, `code`, `discount_percent`, `is_active`, `created_at`, `usage_limit`, `used_count`) VALUES
(2, 'huydza', 20, 1, '2025-06-17 01:57:40', 1, 1),
(6, 'huydz1', 10, 1, '2025-06-17 02:32:08', 1, 1),
(8, 'huydz3', 10, 1, '2025-06-17 03:03:06', 1, 1),
(12, 'huydz', 20, 1, '2025-06-17 03:39:47', 1, 1),
(14, 'qq', 40, 1, '2025-06-17 03:52:42', 1, 1),
(15, 'qa', 40, 1, '2025-06-17 03:56:45', 3, 3),
(16, 'ok', 20, 1, '2025-06-17 15:01:13', 4, 2),
(17, 'kk', 20, 1, '2025-06-18 09:26:15', 2, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` float NOT NULL DEFAULT 0,
  `status` varchar(100) NOT NULL DEFAULT 'Chờ xử lý',
  `discount_code` varchar(50) DEFAULT NULL,
  `discount_amount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `phone`, `email`, `address`, `created_at`, `total`, `status`, `discount_code`, `discount_amount`) VALUES
(17, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nguyenquochuyc7@gmail.com', 'giao đâu củn được', '2025-06-14 18:50:38', 67, '3', NULL, 0),
(18, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 05:34:02', 12, '3', NULL, 0),
(19, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 05:44:08', 70, '3', NULL, 0),
(20, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 05:44:56', 78, '3', NULL, 0),
(21, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 06:01:27', 67, '3', NULL, 0),
(22, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 06:18:44', 78, '3', NULL, 0),
(23, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 06:21:12', 67, '3', NULL, 0),
(24, NULL, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-15 06:23:03', 70, '3', NULL, 0),
(25, 2, 'nguyen huy ', '012345678', 'contep636@gmail.com', 'acb ạodhajisd', '2025-06-16 15:04:47', 67, '3', NULL, 0),
(26, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-16 17:07:58', 78, '3', NULL, 0),
(27, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-16 17:10:50', 12, '3', NULL, 0),
(28, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-16 17:43:21', 70, '3', NULL, 0),
(29, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 19:00:36', 67, '3', NULL, 0),
(30, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-16 19:32:15', 10.8, '3', 'huydz1', 1),
(31, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:03:43', 10.8, '3', 'huydz3', 1),
(32, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:18:33', 54600, '3', 'qa', 23400),
(33, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:26:03', 54.6, '3', 'qa', 23),
(34, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:40:04', 62.4, '3', 'huydz', 16),
(35, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:47:17', 56, '3', 'qa', 14),
(36, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:52:55', 42, '3', 'qq', 28),
(37, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 20:57:02', 42, '3', 'qa', 28),
(38, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-16 21:23:13', 40.2, '3', 'qa', 27),
(39, 1, 'Nguyễn Quốc Huy ', '0123456789', 'swminh0918195615@gmail.com', 'giao đâu củn được', '2025-06-17 07:11:39', 40.2, '3', 'qa', 27),
(40, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-17 07:49:34', 227, '3', '', 0),
(41, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-17 08:11:55', 116, '3', 'ok', 29),
(42, 2, 'nguyen huy ', '012345678', 'nhochuy900@gmail.com', 'acb ạodhajisd', '2025-06-17 08:16:15', 285, '3', '', 0),
(43, 1, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-18 01:53:45', 116, '3', 'ok', 29),
(44, 2, 'nguyen huy ', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', '2025-06-18 02:27:35', 172, '3', 'kk', 43),
(45, 1, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-18 02:52:42', 12, '3', '', 0),
(46, 1, 'Nguyễn Quốc Huy ', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', '2025-06-18 03:38:30', 20, '3', '', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(19, 17, 7, 1, 67.00),
(20, 18, 21, 1, 12.00),
(21, 19, 22, 1, 70.00),
(22, 20, 8, 1, 78.00),
(23, 21, 7, 1, 67.00),
(24, 22, 8, 1, 78.00),
(25, 23, 7, 1, 67.00),
(26, 24, 22, 1, 70.00),
(27, 25, 7, 1, 67.00),
(28, 26, 8, 1, 78.00),
(29, 27, 21, 1, 12.00),
(30, 25, 1, 1, 67000.00),
(31, 25, 7, 1, 67000.00),
(32, 28, 22, 1, 70.00),
(33, 29, 7, 1, 67.00),
(34, 30, 21, 1, 12.00),
(35, 31, 21, 1, 12.00),
(36, 32, 8, 1, 78.00),
(37, 33, 8, 1, 78.00),
(38, 34, 8, 1, 78.00),
(39, 35, 22, 1, 70.00),
(40, 36, 22, 1, 70.00),
(41, 37, 22, 1, 70.00),
(42, 38, 7, 1, 67.00),
(43, 39, 7, 1, 67.00),
(44, 40, 7, 1, 67.00),
(45, 40, 8, 1, 78.00),
(46, 40, 21, 1, 12.00),
(47, 40, 22, 1, 70.00),
(48, 41, 8, 1, 78.00),
(49, 41, 7, 1, 67.00),
(50, 42, 7, 1, 67.00),
(51, 42, 22, 2, 70.00),
(52, 42, 8, 1, 78.00),
(53, 43, 7, 1, 67.00),
(54, 43, 8, 1, 78.00),
(55, 44, 7, 1, 67.00),
(56, 44, 8, 1, 78.00),
(57, 44, 22, 1, 70.00),
(58, 45, 21, 1, 12.00),
(59, 46, 23, 1, 20.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
(7, 'Bò rán', 'hh', 67.00, 'uploads/68240d3dad276_images.jfif', 2),
(8, 'Comboo', 'df', 78.00, 'uploads/68297e6a7abae_68240dbc727bb_3.jfif', 2),
(21, 'Trâu rán', 'aa', 12.00, 'uploads/684b9563a796f_3e9c071b-bcbd-4199-9da4-4149ede89c43.jpg', 1),
(22, 'vịt rán ', 'mmm', 70.00, 'uploads/684ddae33697e_68240dc8d6093_4.jfif', 2),
(23, 'Cá mập rán ', 'ádaasdadasd', 20.00, 'uploads/68521fff76422_takoyaki.jpg', 4),
(24, 'Cá lòng tong rán ', 'okashdajhsd', 40.00, 'uploads/6852201acfac9_pizaa.jpg', 4),
(25, 'Cá lóc rán', 'ádasdasd', 30.00, 'uploads/685220309c01b_com tron.png', 4),
(26, 'Chuột chiên xù', 'ádasdasds', 50.00, 'uploads/685220495df0d_sumdim.jpg', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 7, 25, 5, 'ok', '2025-06-16 23:48:34'),
(2, 2, 7, 25, 5, 'ok', '2025-06-16 23:48:45'),
(3, 1, 22, 24, 5, 'ok', '2025-06-16 23:49:16'),
(4, 2, 7, 25, 5, 'ok good', '2025-06-16 23:51:58'),
(5, 2, 8, 26, 5, 'quá ok', '2025-06-17 00:08:29'),
(6, 2, 21, 27, 5, 'vé ri rút', '2025-06-17 00:11:36'),
(7, 2, 1, 25, 5, 'Tốt lắm', '2025-06-17 00:19:23'),
(8, 2, 7, 25, 5, 'Rất tốt', '2025-06-17 00:21:02'),
(9, 2, 22, 28, 3, 'mém ok', '2025-06-17 00:43:45'),
(10, 2, 7, 38, 5, 'quá tẹt', '2025-06-17 04:24:04'),
(11, 1, 7, 39, 5, 'bé minh cute', '2025-06-17 14:12:13'),
(12, 1, 7, 43, 5, 'quá ok ', '2025-06-18 09:29:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `fullname`, `password`, `created_at`, `phone`, `email`, `address`, `role`) VALUES
(1, 'huydzhehe', 'Nguyễn Quốc Huy ', '$2y$10$GrvHzpjhUHFWxPYkkq.IxeFK5Tcy9SHSsot8XzzPaREx/O8yj0.jy', '2025-06-14 08:15:00', '0123456789', 'nhochuy900@gmail.com', 'giao đâu củn được', 'admin'),
(2, 'huydzhehe1', 'nguyen huy ', '$2y$10$N0EHeoL66Rjz44CuEWx/xenfxezs8OhPoaEcdrTs9zKNxf5woqiVm', '2025-06-14 08:29:42', '012345678', 'contep123@gmail.com', 'acb ạodhajisd', 'user');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
