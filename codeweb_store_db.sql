-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2023 at 04:24 AM
-- Server version: 5.7.42
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `halfcarr_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone_no` varchar(20) NOT NULL,
  `additional_info` text,
  `city_name` varchar(50) NOT NULL,
  `delivery_address` varchar(100) NOT NULL,
  `address_state` varchar(20) NOT NULL,
  `address_postal_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `phoneno` varchar(20) NOT NULL,
  `account_status` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `last_name`, `first_name`, `email`, `passkey`, `phoneno`, `account_status`, `created_at`) VALUES
(1, 'olusoji', 'charles', 'sodje.o@gmail.com', '$2y$10$sk.qjNPP.uFLbFdr6KpqNuzknZYIV2exByK/lLSoKneGCCGOSAkKe', '07026790425', '1', '2022-12-07 08:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `agent_id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `other_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `phone_no` varchar(255) NOT NULL,
  `account_status` varchar(1) NOT NULL,
  `deleted` varchar(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `last_name`, `first_name`, `other_name`, `email`, `passkey`, `phone_no`, `account_status`, `deleted`, `created_at`) VALUES
(11, 'Ofoesuwa', 'Charles', 'olusoji', 'sodje.o@gmail.com', '$2y$10$jmdc0hlHOZU24CrWUrZLKOBcw.tayUxdrBlwdBNdXbAtFLrLa59Ta', '08092872865', '1', '0', '2023-05-24 07:38:24'),
(13, 'Okwuelum', 'Grace', 'Ayomide', 'gracede98@gmail.com', '$2y$10$kcRgxJXEdo6z746MRudBdub5LznyQqW7I8L8623VDFmUCsJeXFmEu', '09169632971', '1', '0', '2023-05-25 08:37:53'),
(15, 'IDIKWU', 'BLESSING', 'PEACE', 'bidikwu@gmail.com', '$2y$10$RRpdaTOM9fsbT.9VMlBHFOLKP.6Ugy5/quuoTIGCsyZNkPJOqvlMe', '07016534424', '1', '0', '2023-05-29 10:58:07'),
(16, 'OKWUELUM', 'FLOURISH', 'CHIOMA', 'flourishokwuelum@gmail.com', '$2y$10$qMtmvws2lp5AwYG/JX2W1OiNDq6PWBM74z1.BX6h1gx31ZlnGnkjK', '09027354300', '1', '0', '2023-05-29 11:04:10'),
(18, 'UCHECHUKWU', 'AMARACHI', 'SARAH', 'importantsarah31@gmail.com', '$2y$10$HlfMzDRlxG4NNxieGG87X.0jm8b65OI/U8SSWWBgrz3okrx/MsoCu', '08108582911', '1', '0', '2023-05-29 11:56:52'),
(19, 'AKINOLA', 'DAMILOLA', 'BUNMI', 'damiakinola93@gmail.com', '$2y$10$hy3pYxyXPWgEmawAW3J7Mul0jTwd/FFPNZ1G5KETPdWBy8..sPUn2', '07089675257', '1', '0', '2023-07-03 14:19:04');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `deposit_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_ref` varchar(50) NOT NULL,
  `type` varchar(1) NOT NULL COMMENT '1-order, 2-savings',
  `type_no` varchar(10) NOT NULL COMMENT 'contains wallet_id or order_id',
  `deposit_amount` decimal(10,4) NOT NULL,
  `deposit_status` varchar(1) NOT NULL DEFAULT '0' COMMENT '0-failed, 1-success',
  `deposited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_no` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `payment_method` varchar(1) NOT NULL COMMENT '1-pay with cards, ussd or bank transfers, 2-cash on delivery',
  `placed_successfully` varchar(1) NOT NULL DEFAULT '0' COMMENT '1- true - false',
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-pending,2-awaiting shipment,3-shipped,4-completed,5-cancelled',
  `ordered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `id` int(11) NOT NULL,
  `order_no` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pictures` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `category` int(11) NOT NULL,
  `available_for_installment` varchar(1) NOT NULL DEFAULT '1',
  `duration_of_payment` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `in_stock` int(11) NOT NULL,
  `visibility` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_esperanto_ci NOT NULL COMMENT ' ',
  `deleted` varchar(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `store_id`, `in_stock`, `visibility`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'Owlenz SD150 2400 LUMEN HD LCD PROJECTOR - BLACK', 100000.00, 'projector1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Owlenz SD150 2400 LUMEN HD LCD PROJECTOR - BLACK</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:33:17', '2023-05-08 10:10:37'),
(9, 'Hisense FC66DD 500L Chest Freezer  ', 329000.00, '377.jpeg', '                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 21:33:15', '2023-06-10 12:25:42'),
(10, 'Hisense FC91DD 702L Chest Freezer ', 469000.00, '378.jpeg', '                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 22:38:30', '2023-06-10 12:26:45'),
(11, 'Hisense FC120SH 95L Chest Freezer', 100000.00, '372.jpeg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Power Indicator Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Fast Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-01 22:59:41', '2023-05-08 10:10:37'),
(12, 'Hisense 189DR-RS 190L Standing Freezer ', 213000.00, '781.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 189DR-RS 190L Standing Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-01 23:01:28', '2023-05-08 10:10:37'),
(13, 'Hisense FC320SH 250L Chest Freezer', 209800.00, '452.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC320SH 250L Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-01 23:05:37', '2023-05-08 10:10:37'),
(14, 'LG GR-K25DSLBC 250L Chest Freezer ', 376000.00, '69.jpeg', '<span style=\"font-size: 15.24px;\">LG GR-K25DSLBC 250L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-01 23:07:20', '2023-05-08 10:10:37'),
(15, 'LG GN-304SQ 168L Standing Freezer L265,₦   Out Of Stock', 400000.00, '70.jpeg', '<span style=\"font-size: 15.24px;\">G GN-304SQ 168L Standing Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:11:23', '2023-06-10 12:31:31'),
(16, 'LG GR-K45DSLBC 450L Chest Freezer ', 522000.00, '69.jpeg,62557d55167da.png,62557d54420bf.png', '<span style=\"font-size: 15.24px;\">LG GR-K45DSLBC 450L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-01 23:14:10', '2023-05-08 10:10:37'),
(17, 'Hisense FC180SH 144L Chest Freezer', 115000.00, '191.png,189.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC180SH 144L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:21:33', '2023-06-10 12:23:50'),
(18, 'Hisense FC55DD 420L Double Door Chest Freezer', 319000.00, '194.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC55DD 420L Double Door Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:24:27', '2023-06-10 12:25:14'),
(19, 'Hisense FC390SH 297L Chest Freezer', 224700.00, '193.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Hisense FC390SH 297L Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:26:22', '2023-06-10 12:24:32'),
(20, 'Hisense 212DR 161L Top Freezer Refrigerator ', 178700.00, '215.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 212DR 161L Top Freezer Refrigerator&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:31:01', '2023-06-10 12:21:34'),
(21, 'LG GL-C292RLBN 257L Top Freezer Refrigerator ', 299000.00, '102.jpeg', '<span style=\"font-size: 15.24px;\">LG GL-C292RLBN 257L Top Freezer Refrigerator</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-01 23:34:08', '2023-06-10 12:30:54'),
(22, 'Hisense H20MOMS10 700W 20L Microwave Oven', 47100.00, '202.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H20MOMS10 700W 20L Microwave Oven&nbsp;</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-01 23:55:32', '2023-06-10 12:27:11'),
(23, 'Hisense H36MOMMI 1000W 36L Microwave Oven ', 83500.00, '206.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H36MOMMI 1000W 36L Microwave Oven&nbsp;</span>', 2, '1', 4, 1, 50, '1', '0', '2023-03-01 23:57:28', '2023-05-08 10:10:37'),
(24, 'LG MS2044DMB 700W 20L Microwave Oven ', 55700.00, '80.jpeg', '<span style=\"font-size: 15.24px;\">LG MS2044DMB 700W 20L Microwave Oven&nbsp;</span>', 2, '1', 4, 1, 50, '1', '1', '2023-03-01 23:59:06', '2023-06-10 12:33:02'),
(25, 'LG MH8265CIS 1200W 42L Microwave Oven ', 124000.00, '86.jpeg', '<span style=\"font-size: 15.24px;\">LG MH8265CIS 1200W 42L Microwave Oven</span>', 2, '1', 4, 1, 50, '1', '1', '2023-03-02 00:02:08', '2023-06-10 12:32:21'),
(26, 'LG 43 Inch UQ70 Series UHD 4K Smart TV  ', 222900.00, '473.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch UQ70 Series UHD 4K Smart TV</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 00:04:42', '2023-06-10 12:28:41'),
(27, 'LG 43 Inch LM637 Series FHD Smart TV ', 194000.00, '165.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch LM637 Series FHD Smart TV 194,000&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 00:06:55', '2023-06-10 12:28:09'),
(28, 'Maxi 42 Inch D2010S Series HD Smart TV ', 132300.00, '443.jpeg', '<span style=\"font-size: 15.24px;\">Maxi 42 Inch D2010S Series HD Smart TV</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-02 00:09:02', '2023-05-08 10:10:37'),
(29, 'LG 48 Inch OLED C1 Series UHD 4K Smart TV ', 781000.00, '478.jpeg', '<span style=\"font-size: 15.24px;\">LG 48 Inch OLED C1 Series UHD 4K Smart TV&nbsp;&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 00:14:39', '2023-06-10 12:29:29'),
(30, 'Hisense 43 Inch A4G Series FHD Smart TV ', 167500.00, '251.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-02 00:16:40', '2023-05-08 10:10:37'),
(31, 'Hisense 40 Inch A4G Series FHD Smart TV', 144500.00, '248.jpeg', '<span style=\"font-size: 15.24px;\">&nbsp;Hisense 40 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 00:18:18', '2023-06-10 12:20:32'),
(32, 'Hisense 40 Inch A5100 Series HD TV ', 119900.00, '249.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 40 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 00:20:13', '2023-06-10 12:22:05'),
(33, 'Hisense 43 Inch A5100 Series HD TV ', 138900.00, '252.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-02 00:21:03', '2023-05-08 10:10:37'),
(34, 'Hisense 8KG Tumble Dryer', 113500.00, '188.jpg', '<span style=\"font-size: 15.24px;\">Hisense 8KG Tumble Dryer</span>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 12:07:56', '2023-06-10 12:23:02'),
(35, 'LG F0L2CRV2T2 20/12KG Front Load (Wash & Dry) Washing Machine ', 844300.00, '132.jpeg', '<span style=\"font-size: 15.24px;\">LG F0L2CRV2T2 20/12KG Front Load (Wash &amp; Dry) Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 14:40:31', '2023-06-10 12:30:03'),
(36, 'LG T9585NDHVH 9KG Top Load Washing Machine ', 239700.00, '114.jpeg', '<span style=\"font-size: 15.24px;\">LG T9585NDHVH 9KG Top Load Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '1', '2023-03-02 15:01:29', '2023-06-10 12:33:36'),
(37, 'LG WP-950RC 8KG Top Load Twin Tub Washing Machine ', 165900.00, '115.jpeg', '<span style=\"font-size: 15.24px;\">LG WP-950RC 8KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-02 15:06:05', '2023-05-08 10:10:37'),
(38, 'Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine ', 109900.00, '307.jpeg', '<span style=\"font-size: 15.24px;\">Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-02 15:11:15', '2023-05-08 10:10:37'),
(39, 'Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper', 182000.00, '1.jpeg', '<span style=\"font-size: 15.24px;\">Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper</span>                                        ', 15, '1', 4, 1, 50, '1', '1', '2023-03-03 08:16:20', '2023-06-14 13:49:36'),
(40, 'Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)', 360000.00, '2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)</h1>                                        ', 15, '1', 4, 1, 50, '1', '1', '2023-03-03 08:21:57', '2023-06-14 13:50:05'),
(41, 'Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper', 255000.00, '3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper</h1>                                        ', 15, '1', 4, 1, 50, '1', '1', '2023-03-03 08:23:03', '2023-06-14 13:50:13'),
(42, 'Senwei 4.5kva Key Starter Superb Generator- Sp7800E2', 160000.00, '4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Senwei 4.5kva Key Starter Superb Generator- Sp7800E2</h1>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:24:10', '2023-05-08 10:10:37'),
(43, 'Firman Sumec Firman 10kva Generator Key Start Eco12990ES', 650000.00, '5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Firman Sumec Firman 10kva Generator Key Start Eco12990ES</h1>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:25:10', '2023-05-08 10:10:37'),
(44, 'Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level', 129000.00, '6.jpeg', '<span style=\"font-size: 15.24px;\">Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level</span>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:26:18', '2023-05-08 10:10:37'),
(45, 'Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)', 98000.00, '7.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)</h1>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:27:15', '2023-05-08 10:10:37'),
(46, 'KEMAGE Remote Control Generator 10.5kva Petrol Engine', 400000.00, '8.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">KEMAGE Remote Control Generator 10.5kva Petrol Engine</h1>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:29:39', '2023-05-08 10:10:37'),
(47, 'Sumec Firman 5.5Kva Rugged Generator RD3910EX', 255000.00, '9.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman 5.5Kva Rugged Generator RD3910EX</h1>                                        ', 15, '1', 4, 1, 50, '1', '0', '2023-03-03 08:34:09', '2023-05-08 10:10:37'),
(48, 'Maxi 60*90 (4+2) Burner Gas Cooker INOX', 201200.00, '335.png', '<span style=\"font-size: 15.24px;\">Maxi 60*90 (4+2) Burner Gas Cooker INOX</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 12:14:51', '2023-06-10 12:36:24'),
(49, 'Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood', 114500.00, '324.png', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 12:17:19', '2023-06-10 12:34:34'),
(50, 'Maxi 60*60 4 Burner Gas Cooker Basic Black Gray', 98400.00, '325.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 4 Burner Gas Cooker Basic Black Gray</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 12:20:17', '2023-06-10 12:35:40'),
(51, 'Maxi 60*90 (4+2) Burner Gas Cooker Wood', 202300.00, '638087df2ad9c.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*90 (4+2) Burner Gas Cooker Wood</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 12:22:35', '2023-06-10 12:37:17'),
(52, 'Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x', 65100.00, '182.jpeg', '<span style=\"font-size: 15.24px;\">Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x</span>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-03 12:26:57', '2023-05-08 10:10:37'),
(53, 'LG LHD667 4.2ch 600W Home Theater System ', 182000.00, '44.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD667 4.2ch 600W Home Theater System (2)&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-03 12:29:05', '2023-05-08 10:10:37'),
(54, 'LG LHD687 4.2ch 1250W Home Theater System ', 214000.00, '46.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD687 4.2ch 1250W Home Theater System&nbsp;</span>', 1, '1', 4, 1, 50, '1', '0', '2023-03-03 12:30:31', '2023-05-08 10:10:37'),
(55, 'Century 1.5 LITER BLENDER CB 8231 P-1', 14000.00, '121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Century 1.5 LITER BLENDER CB 8231 P-1</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:07:47', '2023-06-10 12:15:53'),
(56, 'Silver Crest 5000W German Industrial Food Crusher & Blender + Extra Mill Jar', 17490.00, '111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Silver Crest 5000W German Industrial Food Crusher &amp; Blender + Extra Mill Jar</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:13:35', '2023-06-07 10:20:40'),
(57, 'Blender +Toaster + Iron Bundle', 21999.00, '1212.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Blender +Toaster + Iron Bundle</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:20:47', '2023-06-10 12:15:26'),
(58, 'Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)', 36060.00, '12121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)</h1>                                        ', 2, '1', 4, 1, 50, '1', '0', '2023-03-03 13:23:43', '2023-05-08 10:10:37'),
(59, 'HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl', 9082.00, '1111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:26:00', '2023-06-10 12:20:55'),
(60, 'Canon EOS 600D DSLR Camera With 18-55mm Lens', 229999.00, '11.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Canon EOS 600D DSLR Camera With 18-55mm Lens</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-03 13:29:34', '2023-05-08 10:10:37'),
(61, 'Nikon D60 DSLR Camera With 55-200mm', 175000.00, 'nikon.jpeg', '                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-03 13:32:05', '2023-05-08 10:10:37'),
(62, 'Canon Camera 7D Digital Camera With 18 To 55MM Lens', 335000.00, 'canon.jpeg', '<span style=\"font-size: 15.24px;\">Canon Camera 7D Digital Camera With 18 To 55MM Lens</span><br>', 4, '1', 4, 1, 50, '1', '0', '2023-03-03 13:33:50', '2023-05-08 10:10:37'),
(63, 'Nikon D40 Camera With 18-55mm Lens', 130000.00, 'nikon2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Nikon D40 Camera With 18-55mm Lens</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-03 13:38:41', '2023-05-08 10:10:37'),
(64, 'Maimeite Yam Pounder 2L Meat Grinder Cooking Blender', 6999.00, 'yam1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maimeite Yam Pounder 2L Meat Grinder Cooking Blender</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:45:09', '2023-06-10 13:00:39'),
(65, 'HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl', 9082.00, 'yam2.jpeg', '<span style=\"font-size: 15.24px;\">HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl</span>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-03 13:47:37', '2023-06-10 12:18:58'),
(66, 'UC40 Multi-media Mini 800 Lumens Portable LED Projection Micro Home Theater Projector White', 243000.00, 'projector2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">UC40 Multi-media Mini 800 Lumens Portable LED Projection Micro Home Theater Projector White</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:39:36', '2023-05-08 10:10:37'),
(67, 'LY-50 1800 Lumens 1280x800 Home Theater LED Projector With Remote Control, Support AV & USB & VGA & HDMI(Black)', 85840.00, 'projector3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">LY-50 1800 Lumens 1280x800 Home Theater LED Projector With Remote Control, Support AV &amp; USB &amp; VGA &amp; HDMI(Black)</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:40:37', '2023-05-08 10:10:37'),
(68, '72\"X72\" Electric Projector Screen With Remote Control', 48500.00, 'screen1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">72\"X72\" Electric Projector Screen With Remote Control</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:41:38', '2023-05-08 10:10:37'),
(69, '60 X 60 Tripod Projector Screen', 35000.00, 'screen2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">60 X 60 Tripod Projector Screen</h1>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:42:49', '2023-05-08 10:10:37'),
(70, '90\"X90\" Electric Projector Screen With Remote Control', 98000.00, 'screen3.jpeg', '<h2 class=\"\"><b>90\"X90\" Electric Projector Screen With Remote Control                                        </b></h2>', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:43:47', '2023-05-08 10:10:37'),
(71, 'Dell Latitude e7450', 160000.00, 'dell1.jpeg', '<span style=\"font-size: 15.24px;\">Dell Latitude e7450. 8GB Ram, 256 SSD</span>', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:50:45', '2023-05-08 10:10:37'),
(72, 'Dell Latitude e5570', 200000.00, 'E55701.jpeg', 'Dell Latitude e5570, core i7 processor, 8GB ram, 256 SSD, 2Gb dedicated graphics', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:54:51', '2023-05-08 10:10:37'),
(73, 'HP 1040 g4', 260000.00, 'hp1040.png', 'hp 1040 g4 core i5, 16gb ram, 256 ssd, touch screen, face ID, fingerprint scanner', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 15:58:16', '2023-05-08 10:10:37'),
(74, 'Dell Latitude 7820', 200000.00, '7280.png', 'Dell latitude 7820, core i7, 8gb ram, 256 ssd, touch screen', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 16:43:35', '2023-05-08 10:10:37'),
(75, 'Dell e430', 110000.00, 'e430.png', 'Dell e6430 core i5, 8gb ram, 256 ssd, keyboard light', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 16:48:00', '2023-05-08 10:10:37'),
(76, 'hp 8470p', 90000.00, 'hp8470.jpg', 'hp 8470p core i5, 4gb ram, 500 hdd', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 16:58:05', '2023-05-08 10:10:37'),
(77, 'Lenovo T480s', 240000.00, 't840s.jpg', '<div class=\"kEwVtd\" style=\"-webkit-tap-highlight-color: transparent; display: flex; overflow: hidden;\"><div class=\"kEwVtd\" style=\"-webkit-tap-highlight-color: transparent; display: flex; overflow: hidden;\">8TH generation, core i7, 16gb ram, keyboard light, 256 ssd, 14 inches</div></div><div class=\"ZUo4Ze cS4Vcb-pGL6qe-ysgGef\" style=\"-webkit-tap-highlight-color: transparent; padding-right: 16px; padding-left: 16px; font-family: arial, sans-serif; font-size: 14px; line-height: 22px; color: rgba(0, 0, 0, 0.87);\"><div class=\"ZoQenf OiwQwf cS4Vcb-pGL6qe-k1Ncfe\" jsname=\"TdyZKc\" style=\"-webkit-tap-highlight-color: transparent; padding-top: 8px; color: rgb(112, 117, 122); font-family: arial, sans-serif; font-size: 12px; line-height: 16px;\"></div></div>                                        ', 4, '1', 4, 1, 50, '1', '0', '2023-03-06 17:20:02', '2023-05-08 10:10:37'),
(78, 'Duravolt Rechargeable Table Fan With Solar Panel', 26500.00, 'fanvolt.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Duravolt Rechargeable Table Fan With Solar Panel</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 17:40:45', '2023-05-08 10:10:37'),
(79, 'Maimeite 16-Inch Standing Fan With Remote Control - White', 23000.00, 'fan1.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maimeite 16-Inch Standing Fan With Remote Control - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 17:42:16', '2023-05-08 10:10:37'),
(80, 'Ox 18 Inches Industrial Standing Fan - OX 18\'\'', 47000.00, 'fan3.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Ox 18 Inches Industrial Standing Fan - OX 18\'</h1>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-06 17:45:11', '2023-06-10 12:38:01'),
(81, 'Ox Standing Fan Industrial 26\" Inches', 57380.00, 'fan4.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Ox Standing Fan Industrial 26\" Inches</h1>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-06 17:48:06', '2023-06-10 12:38:36'),
(82, 'Professional 61 Keys Keyboard With Adaptor And Keyboard Stand', 155000.00, 'keyboard1.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional 61 Keys Keyboard With Adaptor And Keyboard Stand</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 17:54:27', '2023-05-08 10:10:37'),
(83, 'Yamaha PSR E373 Touch-Sensitive Portable Keyboard With Adapter', 228000.00, 'keyboard2.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha PSR E373 Touch-Sensitive Portable Keyboard With Adapter</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 17:57:05', '2023-05-08 10:10:37'),
(84, 'M Audio Keystation 61-Key II USB Midi Keyboard Controller', 152000.00, 'keyboard3.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">M Audio Keystation 61-Key II USB Midi Keyboard Controller</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 17:58:56', '2023-05-08 10:10:37'),
(85, 'Yamaha PSR-E373 Touch-Sensitive Portable Keyboard With Adapter', 235000.00, 'keyboard4.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha PSR-E373 Touch-Sensitive Portable Keyboard With Adapter</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 18:03:21', '2023-05-08 10:10:37'),
(86, 'Yamaha ARIUS YDP-144WH Digital Piano With Bench - White', 1120000.00, 'piano.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha ARIUS YDP-144WH Digital Piano With Bench - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 18:04:38', '2023-05-08 10:10:37'),
(87, 'M Audio Oxygen 49 USB MIDI Keyboard Controlle', 185000.00, 'keyboard5.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">M Audio Oxygen 49 USB MIDI Keyboard Controlle</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 18:06:04', '2023-05-08 10:10:37'),
(88, 'Behringer Eurodesk Mixer SX3242FX', 688000.00, 'mixer.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Behringer Eurodesk Mixer SX3242FX</h1>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-06 18:12:50', '2023-06-10 12:48:01'),
(89, 'Focusrite Scarlett 18i8 USB 2.0 Audio Interface', 400000.00, 'mixer2.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Focusrite Scarlett 18i8 USB 2.0 Audio Interface</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 18:19:49', '2023-05-08 10:10:37'),
(90, 'Behringer Professional Wah-wah Pedal', 46000.00, 'suspencer.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Behringer Professional Wah-wah Pedal</h1>                                        ', 1, '1', 4, 1, 50, '1', '1', '2023-03-06 18:21:58', '2023-06-10 12:47:45'),
(91, 'Mama\'S Pride Premium Parboiled Rice 50KG Mamaâ€™s Pride @ A Promo Price', 44000.00, 'rice.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Pride Premium Parboiled Rice 50KG Mamaâ€™s Pride @ A Promo Price</h1>                                        ', 6, '1', 4, 1, 50, '1', '0', '2023-03-06 20:47:33', '2023-05-08 10:10:37'),
(92, 'Mama Gold 50kg Rice', 38000.00, 'rice2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Gold 50kg Rice</h1>                                        ', 6, '1', 4, 1, 50, '1', '0', '2023-03-06 20:50:22', '2023-05-08 10:10:37'),
(93, 'Chi Big Bull Rice 50kg @ Promo Price Big Bull Rice 50kg @ Promo Price', 45000.00, 'rice 3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Chi Big Bull Rice 50kg @ Promo Price Big Bull Rice 50kg @ Promo Price</h1>                                        ', 6, '1', 4, 1, 50, '1', '0', '2023-03-06 20:52:45', '2023-05-08 10:10:37'),
(94, 'Mama\'S Choice Nigerian Parboiled Rice 50kg', 37500.00, 'ricee4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Choice Nigerian Parboiled Rice 50kg</h1>                                        ', 6, '1', 4, 1, 50, '1', '0', '2023-03-06 20:54:10', '2023-05-08 10:10:37'),
(95, 'Yamaha Alto Sax', 180000.00, 'sax.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha Alto Sax</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 20:59:33', '2023-05-08 10:10:37'),
(96, 'Alto Saxophone Bag', 35000.00, 'saxbag.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Alto Saxophone Bag</h1>                                        ', 7, '1', 4, 1, 50, '1', '0', '2023-03-06 21:02:37', '2023-05-08 10:10:37'),
(97, 'Yamaha 5 PC DRUMSET WITH BIG PEDAL (BLUE)', 200000.00, 'drumset.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha 5 PC DRUMSET WITH BIG PEDAL (BLUE)</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:13:21', '2023-05-08 10:10:37'),
(98, 'Muslady 8inch Snare Drum Head With Drumsticks Shoulder', 28000.00, 'rolling.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Muslady 8inch Snare Drum Head With Drumsticks Shoulder</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-06 21:14:40', '2023-05-08 10:10:37'),
(99, 'Premier Marching Drum With Accessories - 3 Set', 94000.00, 'drums.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Premier Marching Drum With Accessories - 3 Set</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:17:34', '2023-05-08 10:10:37'),
(100, 'Yamaha 7set Drum (RACK) Wine Red', 410000.00, 'drum3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha 7set Drum (RACK) Wine Red</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:18:43', '2023-05-08 10:10:37'),
(101, 'Professional Single Bass Drum Pedal', 18000.00, 'pedder.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional Single Bass Drum Pedal</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:20:01', '2023-05-08 10:10:37'),
(102, 'Acoustic Box Guitar /Blue', 32000.00, 'guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Acoustic Box Guitar /Blue</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:26:17', '2023-05-08 10:10:37'),
(103, '5 Strings Bass Guitar With Stand Bag And Bell', 90000.00, 'bass guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">5 Strings Bass Guitar With Stand Bag And Bell</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:27:29', '2023-05-08 10:10:37'),
(104, 'Professional 6 Strings Electric Lead Guitar With Pick Bag And Belt', 70000.00, 'lead guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional 6 Strings Electric Lead Guitar With Pick Bag And Belt</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-06 21:28:34', '2023-05-08 10:10:37'),
(105, 'Jbl Charge 5 Portable Waterproof Wireless Bluetooth Speaker', 108000.00, 'jbl.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl Charge 5 Portable Waterproof Wireless Bluetooth Speaker</h1>                                        ', 16, '1', 4, 1, 50, '1', '0', '2023-03-08 09:03:27', '2023-05-08 10:10:37'),
(106, 'Jbl CHARGE 5 - Portable Bluetooth Speaker - Pink', 132000.00, 'jbl2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl CHARGE 5 - Portable Bluetooth Speaker - Pink</h1>                                        ', 16, '1', 4, 1, 50, '1', '0', '2023-03-08 09:16:25', '2023-05-08 10:10:37'),
(107, 'Jbl Pulse 4 - Bluetooth Speaker With Light Show', 222000.00, 'jbl3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl Pulse 4 - Bluetooth Speaker With Light Show</h1>                                        ', 16, '1', 4, 1, 50, '1', '0', '2023-03-08 09:17:35', '2023-05-08 10:10:37'),
(108, 'LG 1 H.P Split Air Conditioner (S4UQ09WA5A2) - White', 219000.00, 'ac1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">LG 1 H.P Split Air Conditioner (S4UQ09WA5A2) - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-08 09:24:04', '2023-05-08 10:10:37'),
(109, 'Hisense 1.5HP LVS Split Unit Air Condition Copper Condenser Gold Fin', 226000.00, 'ac2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Hisense 1.5HP LVS Split Unit Air Condition Copper Condenser Gold Fin</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-08 09:25:02', '2023-05-08 10:10:37'),
(110, 'Challenge 6 Litre Portable Air Cooler/', 72000.00, 'ac3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Challenge 6 Litre Portable Air Cooler/</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-08 09:26:01', '2023-05-08 10:10:37'),
(111, 'Hisense 1HP Inverter Split Ac -100%Copper Condenser', 233000.00, 'ac4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Hisense 1HP Inverter Split Ac -100%Copper Condenser</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-08 09:26:58', '2023-05-08 10:10:37'),
(112, 'Haier Thermocool 1.5HP Air Conditioner Energy Saving', 240000.00, 'ac5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Haier Thermocool 1.5HP Air Conditioner Energy Saving</h1>                                        ', 1, '1', 4, 1, 50, '1', '0', '2023-03-08 09:28:48', '2023-05-08 10:10:37'),
(113, 'XIAOMI A1 Plus, 6.52\" 4G LTE, 2GB/32GB Memory, Fingerprint, Face ID Recognition, Dual 8 MP, F/2.0, (wide)0.08 MP Camera - Black', 55000.00, 'xiomi.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">XIAOMI A1 Plus, 6.52\" 4G LTE, 2GB/32GB Memory, Fingerprint, Face ID Recognition, Dual 8 MP, F/2.0, (wide)0.08 MP Camera - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:32:23', '2023-06-10 12:58:38'),
(114, 'Vivo Y93s 6GB+128GB 6.2\'\' 13MP+2MP Camera Face Wake Dual SIM 4030mAh Smartphone - Red', 64000.00, 'vivo.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vivo Y93s 6GB+128GB 6.2\' 13MP+2MP Camera Face Wake Dual SIM 4030mAh Smartphone - Red</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:33:18', '2023-06-10 12:57:54'),
(115, 'Samsung Galaxy A03 - 6.5\"HD+ - 64GB ROM - 4GB RAM - 48MP - Dual SIM - 4G LTE - Facial Recognition, 5000mAh - Black', 77000.00, 'samsung.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy A03 - 6.5\"HD+ - 64GB ROM - 4GB RAM - 48MP - Dual SIM - 4G LTE - Facial Recognition, 5000mAh - Black</h1>                                        ', 2, '1', 4, 1, 50, '1', '1', '2023-03-08 09:34:20', '2023-06-10 12:39:45'),
(116, 'itel S18 6.6\", 64GB ROM + 2GB RAM (UpTo 4GB), 5000mAh, 4G - Black', 57000.00, 'itel.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">itel S18 6.6\", 64GB ROM + 2GB RAM (UpTo 4GB), 5000mAh, 4G - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:46:09', '2023-06-10 12:49:24'),
(117, 'Tecno POP 5 Pro (BD4h) 6.52\" HD+, 2GB RAM + 32GB ROM, 6000mAh Battery, 8MP + 5MP Camera, 4G LTE, Android 11, Fingerprint -Cyan', 65000.00, 'techno.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Tecno POP 5 Pro (BD4h) 6.52\" HD+, 2GB RAM + 32GB ROM, 6000mAh Battery, 8MP + 5MP Camera, 4G LTE, Android 11, Fingerprint -Cyan</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:47:27', '2023-06-10 12:52:50'),
(118, 'Samsung Galaxy A04s - 6.5\" Android 12 (50/2/2)MP + 5MP Selfie - 4G LTE - Dual Sim - 5000mAh, 4GB/64GB Memory - Black', 92000.00, 'samsung2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy A04s - 6.5\" Android 12 (50/2/2)MP + 5MP Selfie - 4G LTE - Dual Sim - 5000mAh, 4GB/64GB Memory - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:48:35', '2023-06-10 12:44:46'),
(119, 'Nikon D5300 DSLRR Camera With 18-55mm Lens', 340000.00, 'nikon001.jpeg', '<div class=\"-df -j-bet\" style=\"display: flex; justify-content: space-between; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14px;\"><div class=\"-fs0 -pls -prl\" style=\"padding-right: 24px; padding-left: 8px; font-size: 0px;\"><h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem;\">Nikon D5300 DSLRR Camera With 18-55mm Lens</h1></div><a id=\"wishlist\" href=\"https://www.jumia.com.ng/customer/account/login/?tkWl=NI889CM4JLCYVNAFAMZ-338119159&amp;return=%2Fnikon-d5300-dslrr-camera-with-18-55mm-lens-219937747.html\" class=\"btn _def _i _rnd -mas -fsh0 -me-start\" data-simplesku=\"NI889CM4JLCYVNAFAMZ-338119159\" data-track-onclick=\"wishlist\" data-track-onclick-bound=\"true\" style=\"text-decoration: none; color: rgb(246, 139, 30); border-radius: 0px; border: 0px; outline: 0px; font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-weight: 500; text-transform: uppercase; text-align: center; line-height: 1rem; font-size: 0.875rem; cursor: pointer; position: relative; text-indent: 8px; flex-shrink: 0; align-self: flex-start; margin: 8px;\"><svg aria-label=\"Add to wishlist\" viewBox=\"0 0 24 24\" class=\"ic -f-or5\" width=\"24\" height=\"24\"><use xlink:href=\"https://www.jumia.com.ng/assets_he/images/i-icons.5fc0e713.svg#saved-items\"></use></svg></a></div><div class=\"-phs\" style=\"padding-right: 8px; padding-left: 8px; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14px;\"><br class=\"Apple-interchange-newline\"></div>                                        ', 18, '1', 4, 1, 50, '1', '0', '2023-03-08 09:50:15', '2023-05-08 10:10:37'),
(120, 'Lenovo Xiaoxin K11 Pad 11inch 6GM RAM+ 128GB ROM WIFI Edition 7700Mah Tablet PC', 169000.00, 'pad1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Lenovo Xiaoxin K11 Pad 11inch 6GM RAM+ 128GB ROM WIFI Edition 7700Mah Tablet PC</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:58:02', '2023-06-10 13:05:32'),
(121, 'Nokia T20 -10.4â€ (4GB RAM, 64GB ROM) 8MP Camera - 5MP Selfie, LTE - 8200mAh - Ocean Blue', 135000.00, 'tab2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Nokia T20 -10.4â€ (4GB RAM, 64GB ROM) 8MP Camera - 5MP Selfie, LTE - 8200mAh - Ocean Blue</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:58:56', '2023-06-10 12:51:37');
INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `store_id`, `in_stock`, `visibility`, `deleted`, `created_at`, `updated_at`) VALUES
(122, 'Samsung Galaxy Tab A7 Lite, 8.7-Inch 3GB RAM, 32GB ROM Android 11 8MP + 2MP Nano SIM - Grey', 135000.00, 'tab3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A7 Lite, 8.7-Inch 3GB RAM, 32GB ROM Android 11 8MP + 2MP Nano SIM - Grey</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 09:59:58', '2023-06-10 12:45:24'),
(123, 'itel Pad 1 4G (P10001L) 10.1\" Screen, 4GB RAM + 128GB ROM, 6000mAh, Android 12, 5MP + 8MP Camera, 4G Tablet - Blue +Free Case', 110000.00, 'pad5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">itel Pad 1 4G (P10001L) 10.1\" Screen, 4GB RAM + 128GB ROM, 6000mAh, Android 12, 5MP + 8MP Camera, 4G Tablet - Blue +Free Case</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 10:00:57', '2023-06-10 12:50:10'),
(124, 'Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver', 185000.00, 'tab6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver</h1>                                        ', 3, '1', 4, 1, 50, '1', '1', '2023-03-08 10:01:52', '2023-06-10 12:47:09'),
(125, 'Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver', 190000.00, 'foam1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver</h1>                                        ', 5, '1', 4, 1, 50, '1', '1', '2023-03-08 10:54:00', '2023-06-10 12:46:02'),
(126, 'Vitafoam Grand Mattress 6 X 6 X 10 (Nationwide Delivery}', 145000.00, 'foam2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Grand Mattress 6 X 6 X 10 (Nationwide Delivery}</h1>                                        ', 5, '1', 4, 1, 50, '1', '0', '2023-03-08 10:55:24', '2023-05-08 10:10:37'),
(127, 'Vitafoam Vita Grand Mattress 6x5x8 Inches (Nationwide Delivery)', 136000.00, 'foam3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Vita Grand Mattress 6x5x8 Inches (Nationwide Delivery)</h1>                                        ', 5, '1', 4, 1, 50, '1', '0', '2023-03-08 10:56:23', '2023-05-08 10:10:37'),
(128, 'Vitafoam Spring Super Mattress 6x5x8 (Lagos Delivery Only)', 270000.00, 'foam4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Spring Super Mattress 6x5x8 (Lagos Delivery Only)</h1>                                        ', 5, '1', 4, 1, 50, '1', '0', '2023-03-08 10:57:26', '2023-05-08 10:10:37'),
(130, 'Double King 205/65R15 Tyre', 33000.00, 'tyre1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Double King 205/65R15 Tyre</h1>', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:15:06', '2023-05-08 10:10:37'),
(131, 'Maxxis 225 65R17 Rim 17', 79000.00, 'tyre2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maxxis 225 65R17 Rim 17</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:16:24', '2023-06-10 12:48:48'),
(132, 'Michelin 225 50R17 (RIM 17)', 95000.00, 'tyre3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 225 50R17 (RIM 17)</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:19:31', '2023-05-08 10:10:37'),
(133, 'Michelin 245 45R18 (RIM 18) Long Flat', 126000.00, 'tyre4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 245 45R18 (RIM 18) Long Flat</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:20:25', '2023-05-08 10:10:37'),
(134, 'Michelin 245 50R20 (RIM 20)', 187000.00, 'tyre5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 245 50R20 (RIM 20)</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:21:19', '2023-05-08 10:10:37'),
(135, 'Austone 175 65R14', 30000.00, 'tyre6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Austone 175 65R14</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:22:21', '2023-06-10 12:47:28'),
(136, 'Double King 205/7015c', 40000.00, 'tyre6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Double King 205/7015c</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:23:12', '2023-05-08 10:10:37'),
(137, 'Dunlop 265/65 R17', 157000.00, 'tyre7.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Dunlop 265/65 R17</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:24:31', '2023-05-08 10:10:37'),
(138, 'West Lake 205 55R16', 28000.00, 'tyre8.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">West Lake 205 55R16</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:25:57', '2023-05-08 10:10:37'),
(139, 'Gt Radial GT RADAIL 23555R18 (RIM 18)', 62000.00, 'tyre9.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Gt Radial GT RADAIL 23555R18 (RIM 18)</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:36:21', '2023-05-08 10:10:37'),
(140, 'ES 300/330 Android Car Stereo Player With GPS Navigation, Bluetooth, SD, USB Slots Reverse Camera & Cam-box', 103000.00, 'car stereo.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">ES 300/330 Android Car Stereo Player With GPS Navigation, Bluetooth, SD, USB Slots Reverse Camera &amp; Cam-box</h1>                                        ', 10, '1', 4, 1, 50, '1', '0', '2023-03-11 11:40:26', '2023-05-08 10:10:37'),
(141, 'Toyota HD Toyota Corolla 2003/2004/2005/2006~2007 Car Android Navigation Radio Player+Reverse Camera', 62000.00, 'car sterio2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota HD Toyota Corolla 2003/2004/2005/2006~2007 Car Android Navigation Radio Player+Reverse Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:42:51', '2023-06-10 12:57:09'),
(142, 'Toyota COROLLA 2003-2006 ANDROID NAVIGATION PLAYER WITH REVERSE CAMERA', 64000.00, 'sterio3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota COROLLA 2003-2006 ANDROID NAVIGATION PLAYER WITH REVERSE CAMERA</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:44:14', '2023-06-10 12:56:20'),
(143, 'Toyota Corolla 2003 - 2007 Car Android GPS Navigation Stereo Radio Player With Camera', 63000.00, 'sterio4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota Corolla 2003 - 2007 Car Android GPS Navigation Stereo Radio Player With Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:45:21', '2023-06-10 12:55:42'),
(144, 'Toyota Camry 2007 - 2011 8.5 Car Android Player With GPS Navigation, Bluetooth, SD, USB Slots + Reverse Camera', 63000.00, 'sterio5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota Camry 2007 - 2011 8.5 Car Android Player With GPS Navigation, Bluetooth, SD, USB Slots + Reverse Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:46:11', '2023-06-10 12:54:14'),
(145, 'RAV 4 2008-2012 HD ANDROID NAVIGATION RADIO PLAYER', 68000.00, 'sterio6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">RAV 4 2008-2012 HD ANDROID NAVIGATION RADIO PLAYER</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-11 11:47:28', '2023-06-10 12:46:33'),
(146, 'Mrc women styled abaya', 56000.00, 'abaya1c.jpeg,abaya1.jpeg,abaya1b.jpeg', '<div class=\"head col-md-12 col-lg-12 col-sm-9 floatl\" style=\"border: 0px; vertical-align: baseline; position: relative; min-height: 1px; float: left; width: 570px; color: rgb(48, 48, 48); font-family: Lato, sans-serif; font-size: 14px;\"><div class=\"heading floatl\" style=\"border: 0px; vertical-align: baseline; float: left;\"><p class=\"\">mrc styled abaya</p><div><br></div></div></div><div class=\"heading_heart col-lg-12 col-md-12 col-sm-11 col-xs-12 nopadding\" style=\"margin-bottom: 15px; border: 0px; vertical-align: baseline; position: relative; min-height: 1px; float: left; width: 570px; color: rgb(48, 48, 48); font-family: Lato, sans-serif; font-size: 14px;\"><div class=\"discount_old_price floatl\" style=\"margin-right: 20px; border: 0px; vertical-align: baseline; float: left;\"></div></div>', 7, '1', 4, 1, 50, '1', '0', '2023-03-15 06:34:44', '2023-05-08 10:10:37'),
(147, 'Women Modest Middle East Large Loosed Kurti Abaya Muslim Dress With Headscarf', 32000.00, 'abaya2c.jpeg,abaya2b.jpeg,abaya2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Women Modest Middle East Large Loosed Kurti Abaya Muslim Dress With Headscarf&nbsp;</h1>                                        ', 7, '1', 4, 1, 50, '1', '0', '2023-03-15 06:41:49', '2023-05-08 10:10:37'),
(148, 'Toyota Camry 2004 Blue', 1600000.00, 'camry1.jpeg,camry1a.jpeg,camry1c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Camry 2004 Blue</h1><p style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\"><br></p>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-17 16:26:44', '2023-06-10 12:53:29'),
(149, 'Toyota Matrix 2003 Silver', 1900000.00, 'matrix1a.jpeg,matrix1b.jpeg,matrix1c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Matrix 2003 Silver</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-17 16:43:29', '2023-06-10 12:43:08'),
(150, 'Toyota Camry 2008 Black', 2100000.00, 'camry20081a.jpeg,camry20081b.jpeg,camry20081c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Camry 2008 Black</h1>                                        ', 10, '1', 4, 1, 50, '1', '1', '2023-03-17 16:46:38', '2023-06-10 12:55:06'),
(158, 'LG 32 inches LED', 105000.00, 'lg 32 Inches.jpeg', '<ul class=\"feature-list on\" style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; list-style: none; font-size: 14px; line-height: 1.5em; color: rgb(51, 51, 51); font-weight: 600;\"><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">A New Level of Full-HD</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 4px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">Dynamic Color Enhancer</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 4px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">Quad Core Processor, The Origin of Lifelike Images</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 5px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative; height: auto; opacity: 1; transition-duration: 0.3s; transition-property: all; visibility: visible !important;\">Active HDR for Incredible Detail</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 5px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative; height: auto; opacity: 1; transition-duration: 0.3s; transition-property: all; visibility: visible !important;\">Virtual Surround Plus Fills The Space</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 5px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative; height: auto; opacity: 1; transition-duration: 0.3s; transition-property: all; visibility: visible !important;\">Dolby Audioâ„¢ A Movie-like Sound Experience</li></ul>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 13:11:35', '2023-05-28 09:11:35'),
(159, 'LG 32 inches Smart Tv', 150000.00, 'lg 32 smart tv.jpg', '<ul class=\"feature-list on\" style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; list-style: none; font-size: 14px; line-height: 1.5em; color: rgb(51, 51, 51); font-weight: 600;\"><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">Î±5 Gen5 AI Processor - powerful picture processing</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 4px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">Dolby Audioâ„¢ A Movie-like Sound Experience</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 4px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative;\">Active HDR for incredible detail / AI sound</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 5px; margin-bottom: 0px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative; height: auto; opacity: 1; transition-duration: 0.3s; transition-property: all; visibility: visible !important;\">Bluetooth connectivity - wirelessly connect a soundbar, phone, speaker or earphones</li><li style=\"font-family: &quot;LG Smart&quot;, &quot;Segoe UI&quot;, &quot;Microsoft Sans Serif&quot;, sans-serif; margin-top: 5px; padding: 0px 0px 0px 9px; list-style-position: initial; list-style-image: initial; position: relative; height: auto; opacity: 1; transition-duration: 0.3s; transition-property: all; visibility: visible !important;\">[ThinQ AI &amp; WebOS]</li></ul>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 13:14:19', '2023-05-28 09:14:19'),
(160, 'Hisense 32 inches LED', 80000.00, 'Hisense 32 inches LED.jpg', '<p>32 Inches</p><p>LED</p><p>Very Durable</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 13:24:26', '2023-05-28 09:24:26'),
(161, 'Hisense 32 inches Smart Tv', 110000.00, 'Hisense 32 inches LED.jpg', '<p style=\"color: rgb(143, 143, 143); font-family: &quot;Helvetica Neue&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, sans-serif; font-size: 15px;\">Diagonal Class 32 Inches<br>Color Black<br>Picture Quality Full HD<br>Smart Yes<br>HDMI 2<br>USB 2<br>AV 2<br>LAN Connection Yes<br>WIFI Yes</p><p style=\"color: rgb(143, 143, 143); font-family: &quot;Helvetica Neue&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, Oxygen, Ubuntu, Cantarell, &quot;Fira Sans&quot;, &quot;Droid Sans&quot;, sans-serif; font-size: 15px;\">FREE WALL BRACKET</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 13:28:39', '2023-05-28 09:28:39'),
(162, 'TCL 32 Inches LED', 90000.00, 'tcl32l.jpg', '<ul><li data-mce-fragment=\"1\" style=\"box-sizing: inherit; padding: 3px 0px;\"><span style=\"box-sizing: inherit;\">- Product Code 32D3200</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Description HD Non-Smart Digital TV</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Series D3200</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Size 32 Inch</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Frameless No</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Resolution Type HD</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">-Resolution 1366 x 768</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Native Refresh Rate 60Hz</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Viewing Angle 178Â°/178Â°</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Contrast Ratio 3000:1</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Audio Power 2 x 5Watt</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- HDMI Inputs / HDMI 2</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- USB Input 1</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- SPDIF Yes</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Headphone Output Yes</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Bluetooth Yes</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- AV IN Yes</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Remote Control Yes</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Dimension with stand 730.5mm (W) x 481.3mm (H) x 180.2mm (D)</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Dimension without stand 730.5mm (W) x 432.2mm (H) x 74.4mm (D)</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Weight with stand 3.45kg</span><br style=\"box-sizing: inherit;\"><span style=\"box-sizing: inherit;\">- Weight without stand 3.4kg</span></li><li>                                        </li></ul>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 13:52:56', '2023-05-28 09:52:56'),
(163, 'maxi 32 Inches LED', 95000.00, 'maxi32l.jpeg', '<p style=\"box-sizing: inherit; margin-bottom: 40px; line-height: 22px; color: rgb(51, 62, 72); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\"><span style=\"box-sizing: inherit; font-weight: 700;\">MAIN FEATURES:</span></p><ul style=\"box-sizing: inherit; padding-bottom: 20px; list-style-position: outside; list-style-image: none; padding-inline-start: 25px; color: rgb(51, 62, 72); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\"><li style=\"box-sizing: inherit; padding: 3px 0px;\">High class Full HD display that brings you crispy clear images with rich details.</li><li style=\"box-sizing: inherit; padding: 3px 0px;\">Display size 32-inch screen that is perfectly designed to fit any space in your home.</li><li style=\"box-sizing: inherit; padding: 3px 0px;\">High resolution LED panel that offer you brighter colors and stunning picture quality no matter the scene.</li><li style=\"box-sizing: inherit; padding: 3px 0px;\">Dual HDMI, USB and AV ports that makes it possible to watch your favorite contents directly from your USB flash drive or laptop.</li></ul><p style=\"box-sizing: inherit; margin-bottom: 40px; line-height: 22px; color: rgb(51, 62, 72); font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;\">Its sleek design creating a new aesthetic for your living room.</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 15:43:05', '2023-05-28 11:43:05'),
(164, 'Syinix 32 inches LED', 83000.00, 'syi32l.jpg', '32 inches LED Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-28 22:10:11', '2023-05-28 18:10:11'),
(165, 'Hisense 40 inches LED', 130000.00, 'Hisense-40-Inch-Full-HD-LED-TV.jpeg', '<p>40 inches&nbsp;</p><p>LED&nbsp;</p><p>HDMI Port</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:02:03', '2023-05-29 12:02:03'),
(166, 'Hisense 40 inches smart Tv ', 145000.00, 'Hisense-40-Inch-Full-HD-LED-TV.jpeg', '<p>40 inches&nbsp;</p><p>smart Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:04:57', '2023-05-29 12:04:57'),
(167, 'Maxi 40 Inches LED', 120000.00, 'maxi32l.jpeg', '<p>40 inches</p><p>LED</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:07:16', '2023-05-29 12:07:16'),
(168, 'Hisense 43 inches LED', 140000.00, 'hi43led.jpg', '<p>43 inches</p><p>LED</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:12:37', '2023-05-29 12:12:37'),
(169, 'Hisense 43 inches smart Tv', 165000.00, 'hisen32 smart.jpg', '<p>43 inches</p><p>LED</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:14:14', '2023-05-29 12:14:14'),
(170, 'Hisense 43 Inches UHD ', 205000.00, 'hisuhd43.jpg', '<p>UHD</p><p>43 Inches</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:20:13', '2023-05-29 12:20:13'),
(171, 'LG 43 inches LED', 185000.00, 'Lg43led.jpg', 'LED', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:50:23', '2023-05-29 12:50:23'),
(172, 'LG 43 inches Smart Tv', 230000.00, 'Lg43led.jpg', 'LED', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:52:07', '2023-05-29 12:52:07'),
(173, 'LG 43 inches UHD', 245000.00, 'Lg43led.jpg', 'LED', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:53:57', '2023-05-29 12:53:57'),
(174, 'Maxi 43 inches Smart Tv', 155000.00, 'maxi43smart.jpg', 'Smart Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:55:36', '2023-05-29 12:55:36'),
(175, 'Syinix 43 inches Android', 185000.00, 'syi43and.jpg', 'Android Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:57:25', '2023-05-29 12:57:25'),
(176, 'Mewe 43 inches android', 160000.00, 'mewe-43-inch-SMART-TV.jpeg', '<p>43 inches</p><p>Android</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 16:59:28', '2023-05-29 12:59:28'),
(177, 'TCL 43 inches LED', 130000.00, 'tcl43l.png', 'LED', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 17:00:49', '2023-05-29 13:00:49'),
(178, 'TCL 43 Inches smart Tv', 175000.00, 'tcl43l.png', 'Smart Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 17:03:26', '2023-05-29 13:03:26'),
(179, 'Hisense 50 Inches UHD', 230000.00, 'hisense50UHD.jpg', 'Ultra HD 4k', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 17:14:12', '2023-05-29 13:14:12'),
(180, 'Hisense 50 Inches QLED', 245000.00, 'hiseqled50.jpg', 'QLED', 1, '1', 4, 4, 100, '1', '0', '2023-05-29 17:15:32', '2023-05-29 13:15:32'),
(182, 'LG 50 inches UHD Tv', 310000.00, 'lg50uhd.jpg', 'Ultra HD 4K Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:40:18', '2023-05-31 18:40:18'),
(183, 'Maxi 50 Inches Smart Tv', 215000.00, 'maxi50uhd.jpg', '<p>50 inches</p><p>Smart Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:43:28', '2023-05-31 18:43:28'),
(184, 'Mewe 50 inches Android Tv', 215000.00, 'mewe50.jpg', 'Android Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:45:08', '2023-05-31 18:45:08'),
(185, 'Hisense 55 inches UHD Tv', 255000.00, 'hi55uhd.jpg', '<p>Ultra HD 4K Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:47:38', '2023-05-31 18:47:38'),
(186, 'LG 55 Inches UHD Tv', 340000.00, 'lg55uhd.jpg', 'Ultra HD Tv 4K', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:51:36', '2023-05-31 18:51:36'),
(187, 'TCL 55 inches Android Tv', 270000.00, 'tcl55and.jpg', 'Android Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:55:31', '2023-05-31 18:55:31'),
(188, 'TCL 55 inches QLED', 310000.00, 'tcl55ql.jpg', '<p>QLED&nbsp;</p><p>55 inches</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:56:52', '2023-05-31 18:56:52'),
(189, 'MEWE 55 inches Android Tv', 248000.00, 'memwe50and.jpg', '<p>55 inches&nbsp;</p><p>Android Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 22:58:54', '2023-05-31 18:58:54'),
(190, 'Hisense 58 inches UHD Tv', 270000.00, 'hi58.jpeg', 'Ultra HD Tv&nbsp;', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:01:58', '2023-05-31 19:01:58'),
(191, 'Hisense 65 inches UHD Tv', 340000.00, 'hi58.jpeg', '<p>65 Inches&nbsp;</p><p>UHD Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:03:14', '2023-05-31 19:03:14'),
(192, 'Hisense 65 inches QLED TV', 450000.00, 'hi58.jpeg', '65 Inches Tv', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:05:29', '2023-05-31 19:05:29'),
(193, 'Hisense 65 inches QLED Tv 65U6H', 405000.00, 'hi58.jpeg', '<p><span style=\"background-color: rgb(255, 255, 0);\">65 inches&nbsp;</span></p><p><span style=\"background-color: rgb(255, 255, 0);\">QLED Tv</span></p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:08:12', '2023-05-31 19:08:12'),
(194, 'LG 65 Inches UHD Tv', 510000.00, 'lg65.png', '<p>65 Inches</p><p>UHD Tv</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:10:54', '2023-05-31 19:10:54'),
(195, 'LG 65 Inches Nanocell Tv', 640000.00, 'lg65nano.jpg', '65 inches nanocell', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:13:52', '2023-05-31 19:13:52'),
(196, 'LG 65 Inches OLED TV', 1920000.00, 'lgoled65.jpg', '<p>OLED TV&nbsp;</p><p>65 inches&nbsp;</p>', 1, '1', 4, 4, 100, '1', '0', '2023-05-31 23:16:46', '2023-05-31 19:16:46'),
(197, 'MOUKA FOAM', 95000.00, 'flora-755412-mouka-mattress-l-6ft-x-w-4-5ft-x-h-12-13324396429409.jpg', '<h1 class=\"product-meta__title heading h1\" style=\"-webkit-font-smoothing: antialiased; font-size: calc(var(--base-text-font-size) - (var(--default-text-font-size) - 28px)); font-weight: var(--heading-font-weight); font-family: var(--heading-font-family); color: rgb(58, 42, 47); margin-bottom: 14px; line-height: 1.43;\">Flora-755412 Mouka Mattress- L 6ft x 4 x12</h1>', 5, '1', 4, 6, 50, '1', '0', '2023-06-05 10:29:28', '2023-06-05 06:29:28'),
(198, 'Hisense 70 inches UHD Tv', 470000.00, 'hisense50UHD.jpg', '<p>UHD Tv</p><p>70 Inches</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:08:35', '2023-06-05 13:08:35'),
(199, 'LG 70 inches UHD Tv', 680000.00, 'lg70uhd.jpeg', '<p>UHD Tv</p><p>70 Inches&nbsp;</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:13:30', '2023-06-05 13:13:30'),
(200, 'Hisense 75 Inches UHD Tv', 570000.00, 'his75uhd.png', '<p>UHD Tv</p><p>75 Inches&nbsp;</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:19:15', '2023-06-05 13:19:15'),
(201, 'LG 75 Inches UHD Tv', 830000.00, 'lg70uhd.jpeg', '<p>UHD Tv&nbsp;</p><p>75 Inches</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:22:07', '2023-06-05 13:22:07'),
(202, 'LG 82 Inches UHD Tv', 1110000.00, 'lg70uhd.jpeg', '<p>UHD Tv&nbsp;</p><p>82 Inches</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:23:32', '2023-06-05 13:23:32'),
(203, 'Hisense 85 inches UHD Tv', 1060000.00, 'HIS85.jpg', '<p>Ultra HD</p><p>85 Inches&nbsp;</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:27:12', '2023-06-05 13:27:12'),
(204, 'LG XBoom LK72B Sound System', 55000.00, 'lk72b.png', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:31:13', '2023-06-05 13:31:13'),
(205, 'LG XBoom CJ44 Sound System', 135000.00, 'lgcj44.jpeg', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:38:16', '2023-06-05 13:38:16'),
(206, 'LG XBoom CJ45 Sound System', 165000.00, 'lgcj45.png', 'Sound System&nbsp;', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:46:23', '2023-06-05 13:46:23'),
(207, 'LG XBoom CL65 Sound System', 180000.00, 'lgcl65.jpg', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:50:14', '2023-06-05 13:50:14'),
(208, 'LG XBoom CL87 Sound System', 255000.00, 'lgcl87.jpg', 'Sound System', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 17:51:17', '2023-06-05 13:51:17'),
(209, 'LG XBoom CL98 Sound System', 390000.00, 'lgcl98.jpeg', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:54:05', '2023-06-05 13:54:05'),
(210, 'LG LHD667 Home Theatre', 195000.00, 'lglhd667.jpeg', 'Home Theatre', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 17:59:00', '2023-06-05 13:59:00'),
(211, 'LG LHD675 Home Theatre', 215000.00, 'lgld675.jpg', '<u>Home Theatre</u>', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:03:18', '2023-06-05 14:03:18'),
(212, 'LG LHD687 Home Theatre', 240000.00, 'lglhd687.jpg', 'Home Theatre', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:17:31', '2023-06-05 14:17:31'),
(213, 'LG SN5 Sound Bar', 175000.00, 'lgsn55.jpeg', 'Sound bar', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:23:06', '2023-06-05 14:23:06'),
(214, 'LG SJ2 Sound Bar', 110000.00, 'lgsj2.jpeg', 'Sound Bar', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:27:40', '2023-06-05 14:27:40'),
(215, 'Hisense HS218 Sound Bar', 105000.00, 'hs218.jpeg', 'Hisense Sound Bar', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:30:18', '2023-06-05 14:30:18'),
(216, 'Hisense AX3100G Sound Bar', 135000.00, 'hisax3100g.jpeg', 'Hisense Sound Bar', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:32:43', '2023-06-05 14:32:43'),
(217, 'Hisense HA450 Sound System', 145000.00, 'hisha450.jpeg', 'Sound System', 16, '1', 6, 4, 100, '1', '0', '2023-06-05 18:35:08', '2023-06-05 14:36:03'),
(218, 'Hisense HA650 Sound System', 180000.00, 'hisha650.jpg', 'Sound System', 16, '1', 6, 4, 100, '1', '0', '2023-06-05 18:39:17', '2023-06-05 14:39:59'),
(219, 'Hisense Party Rocker 110HP Sound System', 190000.00, 'hispartyrocker.jpg', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:42:15', '2023-06-05 14:42:15'),
(220, 'LG XBoom ON9 Sound System', 250000.00, 'lgon9.jpeg', 'Sound System', 16, '1', 4, 4, 100, '1', '0', '2023-06-05 18:44:59', '2023-06-05 14:44:59'),
(221, 'Hisense Air Conditioner 1HP Normal', 175000.00, 'hisNormal1hp.jpeg', '1 Horse Power AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:48:43', '2023-06-05 14:48:43'),
(222, 'Hisense Air Conditioner 1HP Inverter', 215000.00, 'hisNormal1hp.jpeg', '1HP Inverter AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:51:26', '2023-06-05 14:51:26'),
(223, 'Hisense Air Conditioner 1HP Normal', 195000.00, 'his1.5hp.jpg', 'Air Conditioner', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:54:22', '2023-06-05 14:54:22'),
(224, 'Hisense Air Conditioner 1.5HP Inverter', 235000.00, 'his1.5hp.jpg', 'Inverter AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:55:32', '2023-06-05 14:55:32'),
(225, 'Hisense Air Conditioner 2HP Normal', 280000.00, 'his1.5hp.jpg', '2HP', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:56:34', '2023-06-05 14:56:34'),
(226, 'Hisense Air Conditioner 2HP Inverter', 345000.00, 'his1.5hp.jpg', '<p>2HP&nbsp;</p><p>Power saving Inverter system</p>', 1, '1', 4, 4, 100, '1', '0', '2023-06-05 18:58:04', '2023-06-05 14:58:04'),
(227, 'Yamaha 5 sets drum set', 150000.00, '5-set-yamaha-drum-set.jpg', 'Yamaha 5 sets drum set', 17, '1', 4, 10, 6, '1', '0', '2023-06-05 23:34:45', '2023-06-05 19:34:45'),
(228, 'Yamaha 7 set drum set', 280000.00, 'Yamaha 7 sets drum set.jpg', 'Yamaha 7 sets drum sets', 17, '1', 4, 10, 10, '1', '0', '2023-06-05 23:38:58', '2023-06-05 19:38:58'),
(229, 'Yamaha power Amplifier', 150000.00, 'Yamaha power Amplifier.jpg', 'Yamaha power amplifier', 17, '1', 4, 10, 8, '1', '0', '2023-06-05 23:41:29', '2023-06-05 19:41:29'),
(230, 'Yamaha 16 channel mixer', 150000.00, 'Yamaha 16 channel mixer.jpg', 'Yamaha 16 channel mixer', 17, '1', 4, 10, 15, '1', '0', '2023-06-05 23:44:18', '2023-06-05 19:44:18'),
(231, 'Yamaha keyboard Psr463', 300000.00, 'Yamaha keyboard 463.jpg', 'Yamaha keyboard Psr463', 17, '1', 4, 10, 14, '1', '0', '2023-06-05 23:45:57', '2023-06-05 19:45:57'),
(232, 'Yamaha wireless Microphone', 150000.00, 'Yamaha wireless microphone.jpg', 'Yamaha wireless Microphone', 16, '1', 4, 10, 13, '1', '0', '2023-06-05 23:49:12', '2023-06-05 19:49:12'),
(233, 'Yamaha Keyboard large PSR', 890000.00, 'yamaha keyboard.jpg', 'Yamaha Keyboard PSR', 17, '1', 6, 10, 14, '1', '0', '2023-06-05 23:50:32', '2023-06-05 19:53:04'),
(234, 'yamaha Keyboard psr', 780000.00, 'yamaha keyboard.jpg', 'Yamaha keyboard psr', 17, '1', 4, 10, 16, '1', '0', '2023-06-05 23:54:23', '2023-06-05 19:54:23'),
(235, 'Shure wireless Microphone UH4', 30000.00, 'Shure wireless micrphone.jpg', 'Shure wireless Microphone UH4', 17, '1', 3, 10, 16, '1', '0', '2023-06-05 23:58:16', '2023-06-05 19:58:16'),
(236, 'Shure wireless Microphone SH-378', 16000.00, 'Shure wiress microphone sh378.jpg', 'Shure wireless Microphone SH-37', 16, '1', 3, 10, 11, '1', '0', '2023-06-05 23:59:48', '2023-06-05 19:59:48'),
(237, 'Shure Wireless professional Microphone SH-1500', 30000.00, 'Yamaha professional Microphone Sh-1500.jpg', 'Shure Wireless professional Microphone SH-1500', 17, '1', 3, 10, 9, '1', '0', '2023-06-06 00:01:14', '2023-06-05 20:01:14'),
(238, 'Shure professional wireless  Microphone Large', 65000.00, 'Shure professional wireless mircophone.jpg', 'Shure professional wireless&nbsp; Microphone Large', 17, '1', 3, 10, 10, '1', '0', '2023-06-06 00:03:19', '2023-06-05 20:03:19'),
(239, 'Shure professional wireless  Microphone ', 20000.00, 'Shure professional wireless mircophone.jpg', 'Shure professional wireless&nbsp; Microphone&nbsp;', 17, '1', 3, 10, 7, '1', '0', '2023-06-06 00:04:11', '2023-06-05 20:04:11'),
(240, 'Shure The Vocal Artist UHF', 40000.00, 'Shure the vocal artist uhf.jpg', 'Shure The Vocal Artist UHF', 16, '1', 3, 10, 10, '1', '0', '2023-06-06 00:06:49', '2023-06-05 20:06:49'),
(241, 'shure Wired microphone', 8000.00, 'shure wired microphone.jpg', 'Shure Wired micrphone', 17, '1', 3, 10, 15, '1', '0', '2023-06-06 00:08:14', '2023-06-05 20:08:14'),
(242, 'Shure Wired Micrphone shure PG89', 12000.00, 'shure wired microphone PG89.jpg', 'Shure Wired Micrphone shure PG89', 17, '1', 3, 10, 17, '1', '0', '2023-06-06 00:09:48', '2023-06-05 20:09:48'),
(243, 'Shure Professional Universal DSISA', 40000.00, 'Shure professional universal DS15A.jpg', 'Shure Professional Universal DSISA', 17, '1', 3, 10, 8, '1', '0', '2023-06-06 00:14:41', '2023-06-05 20:14:41'),
(244, 'Shure professional universal ML', 25000.00, 'Shure professional universal ml.jpg', 'Shure professional universal ML', 17, '1', 3, 10, 5, '1', '0', '2023-06-06 00:17:42', '2023-06-05 20:17:42'),
(245, 'JBL by Harman Wireless Micrphone UHF VM.150', 40000.00, 'jBL HARMAN WIRELESS MIRCOPHONE.jpg', 'JBL by Harman Wireless Micrphone UHF VM.150', 17, '1', 3, 10, 13, '1', '0', '2023-06-06 00:23:49', '2023-06-05 20:23:49'),
(246, 'JBL by Harman Wireless Micrphone UHF VM.100', 38000.00, 'jBL HARMAN WIRELESS MIRCOPHONE.jpg', 'JBL by Harman Wireless Micrphone UHF VM.100', 17, '1', 3, 10, 10, '1', '0', '2023-06-06 00:24:24', '2023-06-05 20:24:24'),
(248, 'Beldray Pressing Iron Bel0775 Steam Iron', 42000.00, 'Screenshot_20230607_135012_Chrome~2.jpg', 'Steam Iron', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 13:14:24', '2023-06-07 09:14:24'),
(249, 'Silver Crest 5000W German Industrial Food Crusher & Blender + Extra Mill Jar', 32000.00, 'Silvercrest blender.jpeg', '<span style=\"font-size: 15.24px;\">Silver Crest 5000W German Industrial Food Crusher &amp; Blender + Extra Mill Jar</span>', 2, '1', 4, 3, 10, '1', '0', '2023-06-07 14:23:05', '2023-06-07 10:23:05'),
(250, 'BINATONE BLENDER/GRINDER BLG-595', 44100.00, 'binatone blender.jpg', 'BINATONE BLENDER/GRINDER', 2, '1', 6, 12, 100, '1', '0', '2023-06-07 16:06:25', '2023-06-08 11:37:53'),
(251, 'Hisense Air Conditioner 2HP Standing 2 Tonnes', 385000.00, 'hisstand.jpeg', 'Standing 2 HP AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:40:39', '2023-06-07 15:40:39'),
(252, 'Hisense Air Conditioner 2HP Standing 3 Tonnes', 490000.00, 'hisstand.jpeg', 'Standing AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:44:17', '2023-06-07 15:44:17'),
(253, 'LG 1HP Air Conditioner Smart Inverter', 235000.00, 'lgsmaINver.jpeg', '1HP Air Conditioner', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:47:33', '2023-06-07 15:47:33'),
(254, 'LG Air Conditioner 1HP Dual Inverter', 268000.00, 'lgdual.jpg', 'LG Air Conditioner', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:51:20', '2023-06-07 15:51:20'),
(255, 'LG 1.5HP Air Conditioner Dual Inverter', 295000.00, 'lgdual.jpg', 'LG Air Conditioner', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:53:38', '2023-06-07 15:53:38'),
(256, 'LG 1HP Air Conditioner Standard ', 195000.00, 'hisNormal1hp.jpeg', 'LG Air Conditioner&nbsp;', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:55:45', '2023-06-07 15:55:45'),
(257, 'LG 1.5HP Air Conditioner Standard', 208000.00, 'lgsmaINver.jpeg', 'Air Conditioner Standard', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 19:57:28', '2023-06-07 15:57:28'),
(258, 'TCL 1HP Air Conditioner Normal ', 185000.00, 'tclstandard.jpg', 'TCL AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:02:21', '2023-06-07 16:02:21'),
(259, 'TCL 1.5HP Air Conditioner Normal ', 205000.00, 'tclstandard.jpg', '1.5 HP Air Conditioner', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:04:01', '2023-06-07 16:04:01'),
(260, 'TCL 1HP Air Conditioner Inverter', 230000.00, 'tclacinverter.jpg', '1HP AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:05:15', '2023-06-07 16:05:15'),
(261, 'TCL 1.5HP Air Conditioner Inverter', 245000.00, 'tclacinverter.jpg', '1.5HP AC', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:06:52', '2023-06-07 16:06:52'),
(262, 'Hisense 7.5 Kg Manual Washing Machine  ', 120000.00, 'hiswa.jpg', 'Manual Washing Machine', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:12:48', '2023-06-07 16:12:48'),
(263, 'Hisense 11kg Manual Washing Machine', 165000.00, 'hiswa.jpg', 'Manual Washing Machine', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:14:59', '2023-06-07 16:14:59'),
(264, 'Hisense 8kg Auto Washing Machine', 165000.00, 'his8auto.jpg', '8kg Auto Washing Machine', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:19:05', '2023-06-07 16:19:05'),
(265, 'Hisense 10.5kg Auto Washing Machine', 208000.00, 'his10.5auto.jpeg', 'Automatic Washing Machine', 1, '1', 4, 4, 100, '1', '0', '2023-06-07 20:21:11', '2023-06-07 16:21:11'),
(266, 'BINATONE BLENDER/GRINDER BLG-412', 32600.00, 'binatone 2.jpg', 'BINATONE BLENDER/GRINDER BLG-412', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 15:36:06', '2023-06-08 11:36:06'),
(267, 'BINATONE WATER KETTLE CEJ-3000 BK', 30000.00, 'Kettle 1.jpg', 'BINATONE WATER KETTLE CEJ-3000 BK', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 15:57:32', '2023-06-08 11:57:32'),
(268, 'BINATONE WATER KETTLE CEJ-1780 ', 24600.00, 'CEJ 1780.jpg', 'BINATONE WATER KETTLE CEJ-1780', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:06:06', '2023-06-08 12:06:06'),
(269, 'BINATONE WATER KETTLE CEJ-2005', 25300.00, 'CEJ 2005.jpg', 'BINATONE WATER KETTLE CEJ-2005', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:08:37', '2023-06-08 12:08:37'),
(270, 'BINATONE WATER KETTLE CEJ-1725SS', 29800.00, 'CEJ 1725.jpg', 'BINATONE WATER KETTLE CEJ-1725SS', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:11:48', '2023-06-08 12:11:48'),
(271, 'HISCENCE HO4AFBK1S1 4.5L AIR FRYER', 52000.00, 'AIR 4.5.jpg', 'HISENCE HO4AFBK1S1 4.5L AIR FRYER', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:22:29', '2023-06-08 12:22:29'),
(272, 'HISCENCE HO9AFBK2S5 8.8L AIR FRYER', 78400.00, 'AIR 8.8.jpg', 'HISENCE HO9AFBK2S5 8.8L AIR FRYER', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:24:52', '2023-06-08 12:24:52'),
(273, 'HISCENCE HO6AFBS1S3 6.3L AIR FRYER', 56000.00, 'AIR 6.3.jpg', 'HISENCE HO6AFBS1S3 6.3L AIR FRYER', 2, '1', 4, 12, 100, '1', '0', '2023-06-08 16:27:07', '2023-06-08 12:27:07'),
(274, 'Air Fryer', 38500.00, '1 (3).jpg', 'Kenwood Air Fryer Digital 6.5L Large Capacity UK Standard&nbsp;', 2, '1', 4, 6, 50, '1', '0', '2023-06-09 06:38:48', '2023-06-09 02:38:48'),
(275, 'Airfryer ', 28500.00, '1 (2).jpg', 'Bear 3:6L Air fryer multifunctional oil free Airfryer&nbsp;', 2, '1', 3, 14, 50, '1', '0', '2023-06-09 07:01:56', '2023-06-09 03:01:56'),
(276, 'Suit', 34000.00, 'IMG-20230609-WA0000.jpg', 'Quality Suit', 7, '1', 3, 13, 50, '1', '0', '2023-06-09 08:37:50', '2023-06-09 04:37:50'),
(277, 'LG 43 Inch LM637 Series FHD Smart TV ', 239000.00, 'LG 43.jpg', '<span style=\"font-size: 15.24px;\">LG 43 Inch LM637 Series FHD Smart TV&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:49:02', '2023-06-09 12:49:02'),
(278, 'LG 43 Inch UQ70 Series UHD 4K Smart TV  ', 249000.00, 'LG TV 2.jpg', '<span style=\"font-size: 15.24px;\">LG 43 Inch UQ70 Series UHD 4K Smart TV&nbsp;&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:50:56', '2023-06-09 12:50:56'),
(279, 'LG 48 Inch OLED C1 Series UHD 4K Smart TV ', 791000.00, 'LG 48.jpg', '<span style=\"font-size: 15.24px;\">LG 48 Inch OLED C1 Series UHD 4K Smart TV&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:53:52', '2023-06-09 12:53:52'),
(280, 'Hisense 40 Inch A4G Series FHD Smart TV', 145500.00, 'HISENCE TV.jpg', '<span style=\"font-size: 15.24px;\">Hisense 40 Inch A4G Series FHD Smart TV</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:55:50', '2023-06-09 12:55:50'),
(281, 'Hisense 40 Inch A5100 Series HD TV ', 129000.00, 'HISENCE 40.jpg', '<span style=\"font-size: 15.24px;\">Hisense 40 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:57:34', '2023-06-09 12:57:34'),
(282, 'Hisense FC66DD 500L Chest Freezer  ', 339000.00, 'CHEST FREEZER 1.png', '<span style=\"font-size: 15.24px;\">Hisense FC66DD 500L Chest Freezer&nbsp;&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 16:59:17', '2023-06-09 12:59:17'),
(283, 'Hisense FC91DD 702L Chest Freezer ', 479000.00, 'CHEST FREEZER 2.jpg', '<span style=\"font-size: 15.24px;\">Hisense FC91DD 702L Chest Freezer&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:00:46', '2023-06-09 13:00:46'),
(284, 'LG GN-304SQ 168L Standing Freezer L265', 275400.00, 'STAND FREEZ LG.jpg', '<span style=\"font-size: 15.24px;\">LG GN-304SQ 168L Standing Freezer L265</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:07:43', '2023-06-09 13:07:43'),
(285, 'Hisense FC180SH 144L Chest Freezer', 129000.00, 'CHEST FREEZER 3.jpg', '<span style=\"font-size: 15.24px;\">Hisense FC180SH 144L Chest Freezer</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:10:57', '2023-06-09 13:10:57'),
(286, 'Hisense FC55DD 420L Double Door Chest Freezer', 329000.00, 'CHEST FREEZER 4.jpg', '<span style=\"font-size: 15.24px;\">Hisense FC55DD 420L Double Door Chest Freezer</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:12:56', '2023-06-09 13:12:56'),
(287, 'Hisense FC390SH 297L Chest Freezer', 234000.00, 'CHEST FREEZER 5.jpg', '<span style=\"font-size: 15.24px;\">Hisense FC390SH 297L Chest Freezer</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-09 17:14:33', '2023-06-15 03:11:52'),
(288, 'Hisense 212DR 161L Top Freezer Refrigerator ', 188000.00, 'HISENSE REFRIGE.jpg', '<span style=\"font-size: 15.24px;\">Hisense 212DR 161L Top Freezer Refrigerator&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:16:19', '2023-06-09 13:16:19'),
(289, 'LG GL-C292RLBN 257L Top Freezer Refrigerator ', 309000.00, 'LG REFRIGERATOR.jpg', '<span style=\"font-size: 15.24px;\">LG GL-C292RLBN 257L Top Freezer Refrigerator&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-09 17:18:06', '2023-06-09 13:18:06'),
(290, 'Hisense H20MOMS10 700W 20L Microwave Oven', 57000.00, 'micro 1.png', '<span style=\"font-size: 15.24px;\">Hisense H20MOMS10 700W 20L Microwave Oven</span>', 2, '1', 4, 12, 50, '1', '0', '2023-06-10 14:24:57', '2023-06-10 10:24:57'),
(291, 'LG MS2044DMB 700W 20L Microwave Oven ', 74000.00, 'micro 2.jpg', '<span style=\"font-size: 15.24px;\">LG MS2044DMB 700W 20L Microwave Oven&nbsp;</span>', 2, '1', 4, 12, 50, '1', '0', '2023-06-10 14:27:04', '2023-06-10 10:27:04'),
(292, 'LG MH8265CIS 1200W 42L Microwave Oven ', 134000.00, 'micro 3.jpg', '<span style=\"font-size: 15.24px;\">LG MH8265CIS 1200W 42L Microwave Oven&nbsp;</span>', 2, '1', 4, 12, 50, '1', '0', '2023-06-10 14:28:31', '2023-06-10 10:28:31'),
(293, 'Hisense 8KG Tumble Dryer', 124000.00, 'washin ma 1.jpg', '<span style=\"font-size: 15.24px;\">Hisense 8KG Tumble Dryer</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 14:30:58', '2023-06-10 10:36:52'),
(294, 'LG F0L2CRV2T2 20/12KG Front Load (Wash & Dry) Washing Machine ', 854000.00, 'washin ma 2.jpg', '<span style=\"font-size: 15.24px;\">LG F0L2CRV2T2 20/12KG Front Load (Wash &amp; Dry) Washing Machine&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 14:35:32', '2023-06-10 10:35:32'),
(295, 'LG T9585NDHVH 9KG Top Load Washing Machine ', 249000.00, 'washin ma 3.jpg', '<span style=\"font-size: 15.24px;\">LG T9585NDHVH 9KG Top Load Washing Machine&nbsp;</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 14:38:42', '2023-06-10 10:38:42'),
(296, 'Maxi 60*90 (4+2) Burner Gas Cooker INOX', 245000.00, 'gas burner 1.png', '<span style=\"font-size: 15.24px;\">Maxi 60*90 (4+2) Burner Gas Cooker INOX</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-10 14:41:53', '2023-06-15 03:15:15'),
(297, 'Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood', 124500.00, 'gas burner 2.png', '<span style=\"font-size: 15.24px;\">Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 14:44:31', '2023-06-10 10:44:31'),
(298, 'Maxi 60*60 4 Burner Gas Cooker Basic Black Gray', 108000.00, 'gas burner 3.jpg', '<span style=\"font-size: 15.24px;\">Maxi 60*60 4 Burner Gas Cooker Basic Black Gray</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 14:46:16', '2023-06-10 10:46:16');
INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `store_id`, `in_stock`, `visibility`, `deleted`, `created_at`, `updated_at`) VALUES
(299, 'Maxi 60*90 (4+2) Burner Gas Cooker Wood', 247500.00, 'gas burner 4.png', '<span style=\"font-size: 15.24px;\">Maxi 60*90 (4+2) Burner Gas Cooker Wood</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-10 14:47:59', '2023-06-15 03:15:41'),
(300, 'JBL by Harman Wireless Micrphone UHF VM.380', 60000.00, 'Jbl by harman wireless micrphone uhf.jpg', 'JBL by Harman Wireless Micrphone UHF VM.380', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 14:56:38', '2023-06-10 10:56:38'),
(301, 'Power wired micrphone Ak 145', 8000.00, 'power wired  microphone.jpg', 'Power wired micrphone Ak 145', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:06:13', '2023-06-10 11:06:13'),
(302, 'Power wired micrphone  FB-168', 8000.00, 'power wired  microphone.jpg', 'Power wired micrphone&nbsp; FB-168', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:06:13', '2023-06-10 11:06:13'),
(303, 'Power wired micrphone  FB-218', 12000.00, 'power wired  microphone.jpg', 'Power wired micrphone&nbsp; FB-218', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:06:16', '2023-06-10 11:06:16'),
(304, 'Hoffner Cookware set 7 Pieces', 29000.00, 'hoff7.jpeg', '7 pieces cooking set&nbsp;', 2, '1', 4, 8, 100, '1', '0', '2023-06-10 15:10:05', '2023-06-10 11:10:05'),
(305, 'Shure wireless mricophone system UT 883', 38000.00, 'shure wireless micrpohne system ut883.jpg', 'Shure wireless mricophone system UT 883', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:11:23', '2023-06-10 11:11:23'),
(306, 'SHBOD wireless micrphone system UK-662', 70000.00, 'shbod wireless mircrophone system uk-62.jpg', 'SHBOD wireless micrphone system UK-662', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:12:21', '2023-06-10 11:12:21'),
(307, 'HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl', 18000.00, 'yam pounder 1.jpg', '<span style=\"font-size: 15.24px;\">HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl</span>', 2, '1', 4, 12, 50, '1', '0', '2023-06-10 15:15:44', '2023-06-10 11:15:44'),
(308, 'HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl', 18000.00, 'yam pounder 1.jpg', '<span style=\"font-size: 15.24px;\">HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl</span>', 2, '1', 4, 12, 50, '1', '1', '2023-06-10 15:27:24', '2023-06-10 11:28:32'),
(309, 'sonymax 12 channels Mixer', 120000.00, 'Sonymax 12 channels mixer.jpg', 'sonymax 12 channels Mixer', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:27:34', '2023-06-10 11:27:34'),
(310, 'Sonymax  powered Mixer 4 channels ', 90000.00, 'SonyMax powered mixer 4 channels.jpg', 'Sonymax&nbsp; powered Mixer 4 channels&nbsp;', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:29:17', '2023-06-10 11:29:17'),
(311, 'New Arrival , 2 Layers Dish Drainer ', 10300.00, 'newarrival2lay.jpeg', 'Dish Drainer', 2, '1', 4, 8, 100, '1', '0', '2023-06-10 15:29:34', '2023-06-10 11:29:34'),
(312, 'Sonymax powered Mixer 8 channels pc8800usb', 100000.00, 'sonymax powered mixer 8 channels pc8800uSB.jpg', 'Sonymax powered Mixer 8 channels pc8800usb', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:30:20', '2023-06-10 11:30:20'),
(313, 'Maimeite Yam Pounder 2L Meat Grinder Cooking Blender', 15000.00, 'yam pound.jpg', '<span style=\"font-size: 15.24px;\">Maimeite Yam Pounder 2L Meat Grinder Cooking Blender</span>', 2, '1', 4, 12, 50, '1', '0', '2023-06-10 15:30:50', '2023-06-10 11:30:50'),
(314, 'Sonymax professional sound system speaker TT15', 150000.00, 'Sonymax porfessional sound system  speaker TN5.jpg', 'Sonymax professional sound system speaker TT15', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:31:32', '2023-06-10 11:31:32'),
(315, 'Sonymax professional sound system speaker TT55', 250000.00, 'Sonymax porfessional sound system  speaker TN55.jpg', 'Sonymax professional sound system speaker TT55', 17, '1', 6, 10, 100, '1', '0', '2023-06-10 15:32:15', '2023-06-10 11:32:15'),
(316, 'SonyxBoss 15 woofer portable rechargeable P.A system 3000W', 70000.00, 'SonyxBoss 15 wooper portable  Rechargeable P.A system 3000w.jpg', 'SonyxBoss 15 woofer portable rechargeable P.A system 3000W', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:33:58', '2023-06-10 11:33:58'),
(317, 'ZoomBao Kettle 5 Litres', 7500.00, 'zoombao5l.jpeg', '5 Litres Kettle', 2, '1', 4, 8, 100, '1', '0', '2023-06-10 15:35:03', '2023-06-10 11:35:03'),
(318, 'SonyxBoss 10 woofer portable rechargeable', 45000.00, 'Sonymax 10 channels Mixer.jpg', 'SonyxBoss 10 woofer portable rechargeable', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:35:36', '2023-06-10 11:35:36'),
(319, 'SonyxBoss 12 woofer portable rechargeable', 60000.00, 'Sonyxboss 12 woofer portale recharged.jpg', 'SonyxBoss 12 woofer portable rechargeable', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:36:05', '2023-06-10 11:36:05'),
(320, 'SonyxBoss 8 woofer portable rechargeable', 38000.00, 'Sonymax 8 woofer portable rechargeable.jpg', 'SonyxBoss 8 woofer portable rechargeable', 17, '1', 4, 10, 100, '1', '0', '2023-06-10 15:36:56', '2023-06-10 11:36:56'),
(321, 'Century 1.5 LITER BLENDER CB 8231 P-1', 30000.00, 'century blender.jpg', '<span style=\"font-size: 15.24px;\">Century 1.5 LITER BLENDER CB 8231 P-1</span><br>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 15:38:16', '2023-06-10 11:38:16'),
(322, 'Divy sound Megaphone USB-rechargeable', 15000.00, 'Divy sound megaphone USB-Rechargeable.jpg', 'Divy sound Megaphone USB-rechargeable', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:44:43', '2023-06-10 11:44:43'),
(323, 'Divy sound Megaphone USB-bluetooth', 10000.00, 'Divy sound megaphone USB-Bluetooth.jpg', 'Divy sound Megaphone USB-bluetooth', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:44:56', '2023-06-10 11:44:56'),
(324, 'wster wireless Microphone hif -speaker', 10500.00, 'wster wireless microphone hif- speaker.jpg', 'wster wireless Microphone hif -speaker', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:46:09', '2023-06-10 11:46:09'),
(325, 'Sound Master wireless Microphone -Iphone', 17000.00, 'sound master wireless micrphone for iphone.jpg', 'Sound Master wireless Microphone -Iphone', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:47:23', '2023-06-10 11:47:23'),
(326, 'Suit ', 70000.00, 'IMG-20230610-WA0038.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:48:24', '2023-06-10 11:48:24'),
(327, 'Suit ', 70000.00, 'IMG-20230610-WA0053.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:49:53', '2023-06-10 11:49:53'),
(328, 'Suit ', 70000.00, 'IMG-20230610-WA0002.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:50:56', '2023-06-10 11:50:56'),
(329, 'Bova Lavalier Microphone type USB/AUX', 10000.00, 'Bova lavalier Microphone USb-Aux.jpg', 'Bova Lavalier Microphone type USB/AUX', 17, '1', 3, 10, 100, '1', '0', '2023-06-10 15:51:37', '2023-06-10 11:51:37'),
(330, 'Maimeite 16-Inch Standing Fan With Remote Control - White', 31000.00, 'stand fan 1.jpg', '<span style=\"font-size: 15.24px;\">Maimeite 16-Inch Standing Fan With Remote Control - White</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 15:53:53', '2023-06-10 11:53:53'),
(331, 'Suit ', 70000.00, 'IMG-20230610-WA0032.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:54:26', '2023-06-10 11:54:26'),
(332, 'Suit ', 70000.00, 'IMG-20230610-WA0037.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:55:11', '2023-06-10 11:55:11'),
(333, 'Suit ', 70000.00, 'IMG-20230610-WA0051.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:56:06', '2023-06-10 11:56:06'),
(334, 'Suit ', 70000.00, 'IMG-20230610-WA0026.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-10 15:56:52', '2023-06-10 11:56:52'),
(335, 'Suit ', 70000.00, 'IMG-20230610-WA0026.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:57:45', '2023-06-10 11:57:45'),
(336, 'Duravolt Rechargeable Table Fan With Solar Panel', 36500.00, 'solar fan.jpg', '<span style=\"font-size: 15.24px;\">Duravolt Rechargeable Table Fan With Solar Panel</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 15:58:56', '2023-06-10 11:58:56'),
(337, 'Suit ', 70000.00, 'IMG-20230610-WA0045.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 15:59:07', '2023-06-10 11:59:07'),
(338, 'Suit ', 70000.00, 'IMG-20230610-WA0023.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 16:00:12', '2023-06-10 12:00:12'),
(339, 'Ox Standing Fan Industrial 18\" Inches', 55000.00, 'stand fan 2.jpg', '<span style=\"font-size: 15.24px;\">Ox Standing Fan Industrial 18\" Inches</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 16:00:45', '2023-06-10 12:00:45'),
(340, 'Suit ', 70000.00, 'IMG-20230610-WA0039.jpg', 'New', 7, '1', 4, 15, 100, '1', '0', '2023-06-10 16:01:13', '2023-06-10 12:01:13'),
(341, 'Ox Standing Fan Industrial 26\" Inches', 65000.00, 'stand fan 3.jpg', '<span style=\"font-size: 15.24px;\">Ox Standing Fan Industrial 26\" Inches</span>', 1, '1', 4, 12, 50, '1', '0', '2023-06-10 16:01:48', '2023-06-10 12:01:48'),
(342, 'Suit ', 70000.00, 'IMG-20230610-WA0049.jpg', '&nbsp;New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 16:02:50', '2023-06-10 12:02:50'),
(343, 'Suit ', 70000.00, 'IMG-20230610-WA0044.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 16:04:02', '2023-06-10 12:04:02'),
(344, 'Suit ', 70000.00, 'IMG-20230610-WA0042.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 16:04:49', '2023-06-10 12:04:49'),
(345, 'Sneakers ', 35000.00, 'IMG-20230610-WA0020.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-10 16:06:35', '2023-06-10 12:06:35'),
(346, 'Suit ', 70000.00, 'IMG-20230610-WA0026.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 19:12:15', '2023-06-10 15:12:15'),
(347, 'Sneakers ', 35000.00, 'IMG-20230610-WA0029.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 19:13:27', '2023-06-10 15:13:27'),
(348, 'Sneakers ', 35000.00, 'IMG-20230610-WA0021.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-10 19:15:20', '2023-06-10 15:15:20'),
(349, 'Sneakers', 35000.00, 'IMG-20230610-WA0041.jpg', 'New&nbsp;', 7, '1', 4, 15, 10, '1', '0', '2023-06-10 19:16:16', '2023-06-10 15:16:16'),
(350, 'Sneakers ', 35000.00, 'IMG-20230610-WA0024.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-10 19:17:08', '2023-06-10 15:17:08'),
(351, 'Sneakers ', 35000.00, 'IMG-20230610-WA0001.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-10 19:18:14', '2023-06-10 15:18:14'),
(352, 'Sneakers ', 35000.00, 'IMG-20230610-WA0035.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-10 19:19:07', '2023-06-10 15:19:07'),
(353, 'Sneakers ', 35000.00, 'IMG-20230610-WA0017.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-10 19:19:56', '2023-06-10 15:19:56'),
(354, 'Suit ', 70000.00, 'IMG-20230610-WA0010.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-10 19:22:45', '2023-06-10 15:22:45'),
(355, 'Track', 25000.00, 'IMG-20230610-WA0201.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:52:59', '2023-06-11 09:52:59'),
(356, 'Track ', 25000.00, 'IMG-20230610-WA0202.jpg', 'New&nbsp;', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:53:57', '2023-06-11 09:53:57'),
(357, 'Track', 25000.00, 'IMG-20230610-WA0203.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:54:48', '2023-06-11 09:54:48'),
(358, 'Track', 25000.00, 'IMG-20230610-WA0204.jpg', 'New&nbsp;', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:55:32', '2023-06-11 09:55:32'),
(359, 'Track', 25000.00, 'IMG-20230610-WA0205.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:56:31', '2023-06-11 09:56:31'),
(360, 'Track', 25000.00, 'IMG-20230610-WA0206.jpg', 'New&nbsp;', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:57:13', '2023-06-11 09:57:13'),
(361, 'Track', 25000.00, 'IMG-20230610-WA0207.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:57:54', '2023-06-11 09:57:54'),
(362, 'Track', 25000.00, 'IMG-20230610-WA0208.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:58:44', '2023-06-11 09:58:44'),
(363, 'Track', 25000.00, 'IMG-20230610-WA0209.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 13:59:35', '2023-06-11 09:59:35'),
(364, 'Track', 25000.00, 'IMG-20230610-WA0094.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 14:00:30', '2023-06-11 10:00:30'),
(365, 'Suit', 45000.00, 'IMG-20230610-WA0071.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:04:15', '2023-06-11 10:04:15'),
(366, 'Suit', 45000.00, 'IMG-20230408-WA0043.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:05:25', '2023-06-11 10:05:25'),
(367, 'Suit', 45000.00, 'IMG-20230408-WA0045.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:06:13', '2023-06-11 10:06:13'),
(368, 'Suit', 45000.00, 'IMG-20230408-WA0044.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:07:06', '2023-06-11 10:07:06'),
(369, 'Suit', 45000.00, 'IMG-20230408-WA0046.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:08:21', '2023-06-11 10:08:21'),
(370, 'Suit', 45000.00, 'IMG-20230408-WA0047.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:09:15', '2023-06-11 10:09:15'),
(371, 'Suit', 45000.00, 'IMG-20230408-WA0049.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:10:14', '2023-06-11 10:10:14'),
(372, 'Suit', 45000.00, 'IMG-20230408-WA0048.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:11:22', '2023-06-11 10:11:22'),
(373, 'Suit', 45000.00, 'IMG-20230408-WA0050.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:12:11', '2023-06-11 10:12:11'),
(374, 'Suit', 45000.00, 'IMG-20230408-WA0052.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:13:00', '2023-06-11 10:13:00'),
(375, 'Suit', 45000.00, 'IMG-20230408-WA0052.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:13:22', '2023-06-11 10:13:22'),
(376, 'Suit', 45000.00, 'IMG-20230408-WA0053.jpg', 'New&nbsp;', 7, '1', 4, 15, 10, '1', '0', '2023-06-11 14:14:46', '2023-06-11 10:14:46'),
(377, 'Suit', 45000.00, 'IMG-20230408-WA0055.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:15:45', '2023-06-11 10:15:45'),
(378, 'Suit', 45000.00, 'IMG-20230408-WA0056.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:16:37', '2023-06-11 10:16:37'),
(379, 'Suit', 45000.00, 'IMG-20230408-WA0057.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:17:24', '2023-06-11 10:17:24'),
(380, 'Suit', 45000.00, 'IMG-20230408-WA0058.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:18:06', '2023-06-11 10:18:06'),
(381, 'Suit', 45000.00, 'IMG-20230408-WA0060.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:19:01', '2023-06-11 10:19:01'),
(382, 'Suit', 45000.00, 'IMG-20230408-WA0061.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:20:19', '2023-06-11 10:20:19'),
(383, 'Suit ', 45000.00, 'IMG-20230408-WA0063.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:21:35', '2023-06-11 10:21:35'),
(384, 'Suit', 45000.00, 'IMG-20230408-WA0064.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:22:32', '2023-06-11 10:22:32'),
(385, 'Suit ', 45000.00, 'IMG-20230408-WA0065.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:23:32', '2023-06-11 10:23:32'),
(386, 'Suit', 45000.00, 'IMG-20230408-WA0066.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:24:26', '2023-06-11 10:24:26'),
(387, 'Suit', 45000.00, 'IMG-20230408-WA0069.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:25:23', '2023-06-11 10:25:23'),
(388, 'Suit ', 45000.00, 'IMG-20230408-WA0067.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:26:18', '2023-06-11 10:26:18'),
(389, 'Suit ', 70000.00, 'IMG-20230408-WA0106.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:31:03', '2023-06-11 10:31:03'),
(390, 'Suit', 70000.00, 'IMG-20230408-WA0110.jpg', 'New&nbsp;', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:31:52', '2023-06-11 10:31:52'),
(391, 'Suit ', 70000.00, 'IMG-20230408-WA0117.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:32:46', '2023-06-11 10:32:46'),
(392, 'Suit', 70000.00, 'IMG-20230408-WA0104.jpg', 'New&nbsp;', 7, '1', 4, 15, 10, '1', '0', '2023-06-11 14:33:41', '2023-06-11 10:33:41'),
(393, 'Suit ', 70000.00, 'IMG-20230408-WA0094.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:34:29', '2023-06-11 10:34:29'),
(394, 'Suit', 70000.00, 'IMG-20230408-WA0093.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:35:13', '2023-06-11 10:35:13'),
(395, 'Suit ', 70000.00, 'IMG-20230408-WA0092.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:36:17', '2023-06-11 10:36:17'),
(396, 'Suit', 70000.00, 'IMG-20230408-WA0091.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:37:05', '2023-06-11 10:37:05'),
(397, 'Suit ', 70000.00, 'IMG-20230408-WA0090.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:37:54', '2023-06-11 10:37:54'),
(398, 'Suit ', 70000.00, 'IMG-20230408-WA0095.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:39:11', '2023-06-11 10:39:11'),
(399, 'Suit', 70000.00, 'IMG-20230408-WA0087.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:40:32', '2023-06-11 10:40:32'),
(400, 'Suit', 70000.00, 'IMG-20230408-WA0091.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:41:42', '2023-06-11 10:41:42'),
(401, 'Suit ', 70000.00, 'IMG-20230408-WA0099.jpg', 'New', 7, '1', 4, 15, 50, '1', '0', '2023-06-11 14:42:56', '2023-06-11 10:42:56'),
(402, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0161.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-11 14:44:43', '2023-06-11 10:44:43'),
(403, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0162.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 14:45:37', '2023-06-11 10:45:37'),
(404, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0163.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:47:11', '2023-06-11 10:47:11'),
(405, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0164.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:49:30', '2023-06-11 10:49:30'),
(406, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0165.jpg', 'New', 7, '1', 4, 15, 10, '1', '0', '2023-06-11 14:51:19', '2023-06-11 10:51:19'),
(407, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0166.jpg', 'New&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:52:46', '2023-06-11 10:52:46'),
(408, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0167.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:54:01', '2023-06-11 10:54:01'),
(409, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0168.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:56:18', '2023-06-11 10:56:18'),
(410, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0169.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:57:41', '2023-06-11 10:57:41'),
(411, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0170.jpg', 'New&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 14:58:55', '2023-06-11 10:58:55'),
(412, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0171.jpg', 'New&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:00:17', '2023-06-11 11:00:17'),
(413, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0172.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:01:11', '2023-06-11 11:01:11'),
(414, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0173.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:02:19', '2023-06-11 11:02:19'),
(415, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0174.jpg', 'New&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:04:17', '2023-06-11 11:04:17'),
(416, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0175.jpg', 'Top quality Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:07:07', '2023-06-11 11:07:07'),
(417, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0176.jpg', 'Quality corporate Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:08:58', '2023-06-11 11:08:58'),
(418, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0178.jpg', 'Quality corporate Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:10:09', '2023-06-11 11:10:09'),
(419, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0179.jpg', 'Quality corporate Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:10:57', '2023-06-11 11:10:57'),
(420, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0180.jpg', 'Quality corporate Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:11:49', '2023-06-11 11:11:49'),
(421, 'Corporate Shoes ', 26000.00, 'IMG-20230610-WA0181.jpg', 'Quality corporate Italian shoes&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:12:36', '2023-06-11 11:12:36'),
(422, 'Stork Jean ', 7000.00, 'IMG-20230610-WA0154(1).jpg', 'Quality&nbsp;', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:17:03', '2023-06-11 11:17:03'),
(423, 'Lacoste Shirts ', 11000.00, 'IMG-20230610-WA0150.jpg', 'Lacoste long sleeve shirts', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:18:55', '2023-06-11 11:18:55'),
(424, 'Italian Pants', 10000.00, 'IMG-20230610-WA0101.jpg', 'New', 7, '1', 3, 15, 10, '1', '0', '2023-06-11 15:22:34', '2023-06-11 11:22:34'),
(425, 'Italian Pants', 10000.00, 'IMG-20230610-WA0112.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 15:23:42', '2023-06-11 11:23:42'),
(426, 'Italian Pants', 10000.00, 'IMG-20230610-WA0113.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 15:25:20', '2023-06-11 11:25:20'),
(427, 'Italian Pants', 10000.00, 'IMG-20230610-WA0114.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 15:27:57', '2023-06-11 11:27:57'),
(428, 'Italian Pants', 10000.00, 'IMG-20230610-WA0115.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 15:28:45', '2023-06-11 11:28:45'),
(429, 'Italian Pants', 10000.00, 'IMG-20230610-WA0116.jpg', 'New', 7, '1', 3, 15, 50, '1', '0', '2023-06-11 15:29:37', '2023-06-11 11:29:37'),
(430, 'MAXI EM10 1.25kVa Generator', 125000.00, 'gen 1.jpg', 'MAXI EM10 1.25kVa', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:30:43', '2023-06-12 06:42:34'),
(431, 'MAXI 25EK 3.1kVa Generator', 199000.00, 'gen 2.jpg', 'MAXI 25EK 3.1kVa', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:33:00', '2023-06-12 06:43:52'),
(432, 'MAXI 20EK 2.5kVa Generator', 184000.00, 'gen 3.jpg', 'MAXI 20EK 2.5kVa', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:35:09', '2023-06-12 06:44:11'),
(433, 'MAXI 28EK 3.5kVa Generator', 204000.00, 'gen 4.jpg', 'MAXI 28EK 3.5kVa', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:37:45', '2023-06-12 06:43:31'),
(434, 'MAXI 50EK 6.25kVa Generator', 357000.00, 'gen 5.jpg', 'MAXI 50EK 6.25kVa', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:40:36', '2023-06-12 06:43:02'),
(435, 'HISENSE FLOOR STANDING AC 2.0HP', 395000.00, 'AC 1.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Self-Diagnosis And Auto Protection Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Easy Cleaning Panel And Pp Filter</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Anti-Cold Air Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Smart Running</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:54:03', '2023-06-12 06:54:03'),
(436, 'HISENSE FLOOR STANDING AC 3.0HP', 590000.00, 'AC 2.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Self-Diagnosis And Auto Protection Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Easy Cleaning Panel And Pp Filter</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Anti-Cold Air Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Smart Running</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Auto-Restart Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">24-Hours Timer</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:56:10', '2023-06-12 06:56:10'),
(437, 'HISENSE FLOOR STANDING AC 5.0HP', 810000.00, 'AC 3.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 10:59:00', '2023-06-12 06:59:00'),
(438, 'HISENSE PORTABLE AC 1.5HP', 198000.00, 'AC 4.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">User-Friendly Control and Display</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Self-Diagnosis &amp; Auto Protection</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Independent Dehumidifier</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Self-Evaporative Movement System</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 11:03:08', '2023-06-12 07:03:08'),
(439, 'HISENSE SPLIT AC 1.0HP', 172000.00, 'AC 5.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 11:05:42', '2023-06-12 07:05:42'),
(440, 'HISENSE SPLIT AC 1.0HP INVERTER', 217000.00, 'AC 6.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">INVERTER</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 11:08:36', '2023-06-12 07:08:36'),
(441, 'HISENSE SPLIT AC 1.5HP', 187000.00, 'AC 7.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super Cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Gold Fin</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><br>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 11:11:24', '2023-06-12 07:11:24'),
(442, 'Hisense Split AC 2.0HP Black Mirror', 308000.00, 'AC 8.jpg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Super cooling</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Black mirror</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">2.0 HP</span>', 1, '1', 6, 12, 50, '1', '0', '2023-06-12 11:26:56', '2023-06-12 07:26:56'),
(443, 'Female shoe ', 25000.00, 'IMG-20230614-WA0013.jpg', 'Quality&nbsp;', 7, '1', 3, 16, 50, '1', '0', '2023-06-14 20:54:53', '2023-06-14 16:54:53'),
(444, 'Female Shoe ', 11000.00, 'IMG-20230614-WA0003.jpg', 'Nice', 7, '1', 3, 16, 50, '1', '0', '2023-06-14 20:56:46', '2023-06-14 16:56:46'),
(445, 'Sneakers ', 10000.00, 'IMG-20230614-WA0004.jpg', 'New', 7, '1', 3, 16, 50, '1', '0', '2023-06-15 05:48:29', '2023-06-15 01:48:29'),
(446, 'Gangan', 30000.00, 'IMG-20230617-WA0011.jpg,IMG-20230617-WA0010.jpg', 'Apala drums', 17, '1', 3, 17, 50, '1', '0', '2023-06-17 16:17:34', '2023-06-17 12:17:34'),
(447, 'Mouka Foam 4.5 Ã—8 inches', 38000.00, 'Super-Flora-Blue-735x735-1.jpg', 'New', 2, '1', 4, 6, 10, '1', '0', '2023-06-19 19:18:59', '2023-06-19 15:18:59'),
(448, 'Mouka Foam 4. 5Ã— 10 inches', 45000.00, '148257_1659363424.jpg', 'New', 2, '1', 4, 6, 50, '1', '0', '2023-06-19 19:21:34', '2023-06-19 15:21:34'),
(449, 'iPhone 11 Pro', 346800.00, 'iphone11.png', '<h3 class=\"sc-11b83ql-0 iSRVuX\" style=\"box-sizing: inherit; margin-top: var(--bs-gutter-y); font-weight: 400; line-height: 32px; font-size: 24px; color: rgb(100, 103, 119); flex-shrink: 0; width: 685.612px; max-width: 100%; padding-right: calc(var(--bs-gutter-x)*0.5); padding-left: calc(var(--bs-gutter-x)*0.5); font-family: Poppins, sans-serif;\">Apple iPhone 11 Pro - 4GB RAM-64GB ROM - iOS 13 - 5.8\" - Space Grey</h3>', 3, '1', 6, 3, 20, '1', '0', '2023-06-27 15:23:44', '2023-06-27 11:23:44'),
(450, 'IPhone 11', 326400.00, 'iphone11a.png', '<h3 class=\"sc-11b83ql-0 iSRVuX\" style=\"box-sizing: inherit; margin-top: var(--bs-gutter-y); font-weight: 400; line-height: 32px; font-size: 24px; color: rgb(100, 103, 119); flex-shrink: 0; width: 685.612px; max-width: 100%; padding-right: calc(var(--bs-gutter-x)*0.5); padding-left: calc(var(--bs-gutter-x)*0.5); font-family: Poppins, sans-serif;\">Apple IPhone 11 - 6.1Inch - 128GB ROM, 4GB RAM - IOS 13 - 3110mAh</h3>', 3, '1', 6, 18, 20, '1', '0', '2023-06-27 15:28:07', '2023-06-27 11:28:07'),
(451, 'IPhone 11', 285600.00, 'ACcD3d5jZUcbTgDG-IPHONE 11 Red.png', '<h3 class=\"sc-11b83ql-0 iSRVuX\" style=\"box-sizing: inherit; margin-top: var(--bs-gutter-y); font-weight: 400; line-height: 32px; font-size: 24px; color: rgb(100, 103, 119); flex-shrink: 0; width: 685.612px; max-width: 100%; padding-right: calc(var(--bs-gutter-x)*0.5); padding-left: calc(var(--bs-gutter-x)*0.5); font-family: Poppins, sans-serif;\">Apple IPhone 11 6.1-Inch Liquid Retina (4GB RAM, 128GB Red</h3>', 3, '1', 6, 18, 23, '1', '0', '2023-06-27 15:30:04', '2023-06-27 11:30:04'),
(452, 'I Phone 11', 285600.00, 'iphone11a.png', '<h3 class=\"sc-11b83ql-0 iSRVuX\" style=\"box-sizing: inherit; margin-top: var(--bs-gutter-y); font-weight: 400; line-height: 32px; font-size: 24px; color: rgb(100, 103, 119); flex-shrink: 0; width: 685.612px; max-width: 100%; padding-right: calc(var(--bs-gutter-x)*0.5); padding-left: calc(var(--bs-gutter-x)*0.5); font-family: Poppins, sans-serif;\">Apple IPhone 11 6.1-Inch Liquid Retina (4GB RAM, 128GB Red</h3>', 3, '1', 6, 18, 100, '1', '0', '2023-07-03 14:50:06', '2023-07-03 10:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `category_name`) VALUES
(1, 'electronics'),
(2, 'home & kitchen'),
(3, 'phone & tablets'),
(4, 'computer & accessories'),
(5, 'furniture'),
(6, 'groceries'),
(7, 'fashion'),
(8, 'health & beauty'),
(9, 'gaming'),
(10, 'automotive & industrial'),
(11, 'books & stationary'),
(12, 'baby, kids & toys'),
(13, 'sports & fitness'),
(15, 'generator'),
(16, 'sound system'),
(17, 'musical system'),
(18, 'photography');

-- --------------------------------------------------------

--
-- Table structure for table `savings_history`
--

CREATE TABLE `savings_history` (
  `id` int(11) NOT NULL,
  `wallet_no` varchar(10) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `paid_for` int(11) NOT NULL COMMENT 'days || weeks || months',
  `payment_status` varchar(1) DEFAULT '0' COMMENT '0-failure, 1-successful',
  `deposited_by` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-user, 2-agent',
  `deposited_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `savings_products`
--

CREATE TABLE `savings_products` (
  `id` int(11) NOT NULL,
  `savings_id` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `savings_products`
--

INSERT INTO `savings_products` (`id`, `savings_id`, `product_id`, `quantity`) VALUES
(1, '6519839413', 185, 1);

-- --------------------------------------------------------

--
-- Table structure for table `savings_requests`
--

CREATE TABLE `savings_requests` (
  `id` int(11) NOT NULL,
  `savings_id` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `type_of_savings` varchar(1) NOT NULL COMMENT '1-normal savings, 2-half savings',
  `installment_type` varchar(1) NOT NULL COMMENT '1-daily, 2-weekly, 3-monthly ',
  `duration_of_savings` int(11) NOT NULL COMMENT 'days || weeks || months ',
  `installment_amount` decimal(10,4) NOT NULL,
  `target_amount` decimal(18,4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-pending, 2-granted, 3-rejected',
  `requested_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `savings_requests`
--

INSERT INTO `savings_requests` (`id`, `savings_id`, `user_id`, `agent_id`, `type_of_savings`, `installment_type`, `duration_of_savings`, `installment_amount`, `target_amount`, `status`, `requested_at`) VALUES
(1, '6519839413', 22, 11, '1', '2', 17, 18000.0000, 306000.0000, '1', '2023-06-28 10:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `owner_name` varchar(255) NOT NULL,
  `owner_email` varchar(255) NOT NULL,
  `owner_phone` varchar(20) NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `items_sold` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `agent_id`, `name`, `owner_name`, `owner_email`, `owner_phone`, `reg_no`, `items_sold`, `created_at`) VALUES
(1, 6, 'Demo Store', 'Roland Joshua', 'joshuaroland@gmail.com', '0906328976', 'ABC12345689', 0, '2023-04-28 21:11:16'),
(2, 6, 'Palmer Power', 'Shodiya Folorunsho', 'folushoayomide11@gmail.com', '07087857141', 'ABC23456798', 0, '2023-04-29 23:28:06'),
(3, 11, 'Masowo integrated global', 'Omoregbe Igbimosa', 'Igbimosaomoregbe@gmail.com', '08032729944', '11110', 0, '2023-05-24 20:15:14'),
(4, 12, 'Masawo Integrated Global', 'Omoregbe Igbimosa', 'igbimosaomoregbe@gmail.com', '08032729944', '11110', 0, '2023-05-28 12:45:13'),
(5, 13, 'God Love Venture ', 'Ugwueje Emmanuel', 'emmanuelugwueje@gmail.com', '08101024216', 'RNL 560, Sabo Market Ikorodu ', 0, '2023-06-05 09:53:03'),
(6, 18, 'FAUSAK AND SONS', 'Jimoh Afusat', 'fausakjimoh@gmail.com', '08028394611', '0001', 0, '2023-06-05 10:15:01'),
(8, 13, 'Unllins Vivid', 'Nwafor Happiness', 'tipla1000@gmail.com', '07032505582', 'No 4, Laketu Ikorodu', 0, '2023-06-05 14:21:51'),
(10, 13, 'GodsLead Musicals ', 'okeke Ebuka', 'ebukaokeke618@gmail.com', '0815223281', 'No 2, shoyebo str off laketu market ikd', 0, '2023-06-05 14:54:13'),
(11, 13, 'EOU Concept Limited ', 'Ugwu Catherine', 'catherineugwu001@gmail.com', '08033210534', 'Block A, Ayangunre Market Sabo Ikorodu Lagos State', 0, '2023-06-07 06:22:01'),
(12, 15, 'Fouani', 'Fouani Nigeria Limited Victor', 'cic@fouani.com', '08092872865', '0001', 0, '2023-06-07 15:17:58'),
(13, 18, 'SENSAY\'S PLACE', 'Moses Daniel', 'sensayplace@gmail.com', '09022747737', 'Lagos Island ', 0, '2023-06-09 06:50:07'),
(14, 18, 'Excellent Movement Stores', 'Nebechi Eucharia', 'excellentmovement@gmail.com', '07013459388', '0002 Balogun Market ', 0, '2023-06-09 06:54:42'),
(15, 18, 'SENSAY\'S PLACE', 'DANIEL MOSES', 'danieleleojo57@gmail.com', '08163038156', '61,Progress Plaza,Mandalas Lagos Island', 0, '2023-06-10 14:44:41'),
(16, 18, 'STIZEE\'S  COLLECTION ', 'EHIBE CELESTINA', 'damssel081@gmail.com', '08189420717', '5 OKO FILLING OKE LASPOTECH IKORODU ', 0, '2023-06-14 20:07:10'),
(17, 11, 'Immakulate drumz and drums', 'Adebayo Emmanuel', 'Smallzidane99@gmail.com', '08176116915', '00023', 0, '2023-06-17 16:11:26'),
(18, 11, 'altmall', 'altmall alternate bank', 'sodje.o@gmail.com', '08092872865', '1212', 0, '2023-06-27 15:25:06');

-- --------------------------------------------------------

--
-- Table structure for table `store_wallets`
--

CREATE TABLE `store_wallets` (
  `wallet_id` int(11) NOT NULL,
  `wallet_no` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` decimal(18,4) NOT NULL DEFAULT '0.0000',
  `paid_for` int(11) DEFAULT '0' COMMENT 'day || week || month',
  `next_due_date` date DEFAULT NULL,
  `completed` varchar(1) NOT NULL DEFAULT '0' COMMENT '0-in progress, 1-completed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `passkey` varchar(255) NOT NULL,
  `is_email_verified` varchar(1) NOT NULL DEFAULT '0',
  `account_status` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `last_name`, `first_name`, `email`, `phone_no`, `passkey`, `is_email_verified`, `account_status`, `created_at`, `updated_at`) VALUES
(4, 'Ofoesuwa', 'Charles', 'sodje.o@gmail.com', '08092872865', '$2y$10$CnrkZtLy500F2Y21dulw9.L.JDztlqShtsoUBVfT3sHMZSHYYjXDG', '1', '1', '2023-05-09 20:16:46', '2023-05-10 01:54:36'),
(5, 'Ofoesuwa', 'Charles', 'sodje.o@outlook.com', '07026790425', '$2y$10$SwvGaKvfLgX70DwJhI/RxO5dHJBypvcM3IRouQKRBxp8ebEQ30ThC', '0', '1', '2023-05-09 20:31:33', '2023-05-09 16:31:33'),
(7, 'Judith ', 'Nwatu', 'nwatujudith12@gmail.com', '08058612451', '$2y$10$BUJi.nHFpzvWWe1HwV.qqeqBG.5wGJEVQ3zBSGYAAeX2wQndIZ7RS', '1', '1', '2023-05-17 08:11:21', '2023-05-17 04:15:15'),
(8, 'Olajumoke ', 'Oginni ', 'olajumokeoginni807@gmail.com', '09127063204', '$2y$10$kwP6IldPpRQkj0feOpnOpeUbBPQuU8nEAY/reIfNtLDQ7KBam/Ch.', '1', '1', '2023-05-24 13:14:13', '2023-05-24 09:14:56'),
(9, 'Okwuelum', 'Flourish', 'gracede98@gmail.com', '09027354300', '$2y$10$S7.4Y2DoR3dy.3U8jofiw.dIYWZnmia2jru8AmCT7tPihIczqgtLS', '1', '1', '2023-05-25 08:43:25', '2023-05-25 04:44:22'),
(10, 'Gbolahan ', 'Akanni ', 'judeakannigbolahan@gmail.com', '08141652626', '$2y$10$roLHn8vGRSv3ecQrMgFKeumdxx0VL1eDhdYeU89cZglH.R7v6tAfm', '0', '1', '2023-06-10 06:15:28', '2023-06-10 02:15:28'),
(11, 'Othowowa', 'Believe', 'beliefothos@gmail.com', '08034625884', '$2y$10$gRqz/meKytcGhwqKcQB81.xr9OLtgJXqleM4xqNVyWIeT9eclHERO', '0', '1', '2023-06-13 14:00:08', '2023-06-13 10:00:08'),
(12, 'Olorunsuyi', 'Oluwasanu', 'jonackson@gmail.com', '08069592092', '$2y$10$3s9lYvmNTmWsYSxXEsKZ/OBaLTZcM7UCSJmBnTU3TB2iNuj8lsgMO', '1', '1', '2023-06-13 20:37:58', '2023-06-13 16:40:17'),
(13, 'Nwinyinya', 'David', 'nwinyinyadavid123@gmail.com', '07018146587', '$2y$10$QaAe9QBuwLVnmNEZR2rEKOs.dydnmx.IrKsDjtdJL/LO3xgRI9dnW', '1', '1', '2023-06-14 14:03:22', '2023-06-14 10:04:40'),
(14, 'SUNDAY ', 'EZEKIEL ', 'scoperjimson3@gmail.com', '08144672494', '$2y$10$0FKPZcRzS7nltvuI5HfSWuzo0y3uK33J4sPzgoLXQWmGfoApYJIDu', '1', '1', '2023-06-14 14:04:48', '2023-06-14 10:06:05'),
(15, 'Blessing ', 'Ogechukwu ', 'ogechris34@yahoo.com', '07069521987', '$2y$10$BFrRim0bSl/FQd7dAps8i.pGc6rDqPnARvvkTh3Fv4xEXHPyryN6G', '0', '1', '2023-06-14 14:16:54', '2023-06-14 10:16:54'),
(16, 'Peter ', 'Olubusuyi Timilehin ', 'peterolubusuyi@yahoo.com', '08033953969', '$2y$10$1ppsMuFjPru8mlEz911Zq.KBmrt.CzOMUXXtv/6zbRVLH8zb/3KdO', '1', '1', '2023-06-14 15:44:10', '2023-06-14 11:46:04'),
(17, 'Blessing', 'Okoye', 'okoyeblessing1995@gmail.com', '08141369492', '$2y$10$nvxdJkdmqUiVSGtuoIQnWuwtERoRStIAWkyxq1SvQqD1om17Jeo1e', '0', '1', '2023-06-15 22:08:43', '2023-06-15 18:08:43'),
(18, 'Yusuf', 'Mariam', 'yusufmariam2002@gmail.com', '08135624475', '$2y$10$q7oxiAWk3FiczMLxDLdGwec8bmm2JeL.8DnraUrTTPGavSKXDvK62', '1', '1', '2023-06-16 10:47:25', '2023-06-16 06:48:18'),
(19, 'Oluwafemi', 'Adelaja', 'adexphemzy@gmail.com', '08188692723', '$2y$10$95oFSTplx2XPiPGWpgCRBugbnsaLW8vt4o.fSzh2sixtW6vZGhVwy', '1', '1', '2023-06-21 14:09:11', '2023-06-21 10:11:30'),
(20, 'SALAKO', 'RICHARD', 'hardeygoka123rd@gmail.com', '09027030750', '$2y$10$CTAd0q7YlLfGlfd1X9tlceXE8nZ8k3UO.rFlMBayM3mCRBvyiC6f.', '1', '1', '2023-06-24 16:56:04', '2023-06-26 13:46:18'),
(21, 'SALAKO', 'RICHARD', 'Aliciabrightsmith@gmail.com', '08118059934', '$2y$10$hi5nNf/FZZ4ecP/cbIRnOOfZ1IIrFzJP7IAsYVjclfy/8W4kI0xHa', '0', '1', '2023-06-24 17:05:25', '2023-06-24 13:05:25'),
(22, 'Isiaka', 'Rasheed', 'olascash90@gmail.com', '08052946833', '$2y$10$.DYhkGWcp.eOjfqqt0WrNuIcpaEaQEo.U6dqNposZvWS2qIw/qRZO', '1', '1', '2023-06-27 12:03:42', '2023-06-27 14:23:18'),
(30, 'Folorunsho', 'Shodiya', 'folushoayomide11@gmail.com', '07087857141', '$2y$10$PVb.r/51DEnAXRxDquayg.xdn0jEkg4ZQpnf7eFbcpyKm/DVbhhr2', '1', '1', '2023-06-29 06:41:53', '2023-07-03 03:45:37'),
(31, 'Samuel', 'Ayadi', 'samuelayadi499@gmail.com', '', '', '1', '1', '2023-07-05 16:16:56', '2023-07-05 12:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `users_addresses`
--

CREATE TABLE `users_addresses` (
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `active` varchar(1) NOT NULL COMMENT '0-false, 1-true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`agent_id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`deposit_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_products`
--
ALTER TABLE `orders_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_ibfk_1` (`category`),
  ADD KEY `products_ibfk_2` (`store_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `savings_history`
--
ALTER TABLE `savings_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savings_products`
--
ALTER TABLE `savings_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `savings_requests`
--
ALTER TABLE `savings_requests`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `savings_request_ibfk_1` (`user_id`),
  ADD KEY `savings_request_ibfk_2` (`agent_id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agent_id` (`agent_id`);

--
-- Indexes for table `store_wallets`
--
ALTER TABLE `store_wallets`
  ADD PRIMARY KEY (`wallet_id`),
  ADD KEY `store_wallets_ibfk_1` (`agent_id`),
  ADD KEY `store_wallets_ibfk_3` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `deposit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=453;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `savings_history`
--
ALTER TABLE `savings_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings_products`
--
ALTER TABLE `savings_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `savings_requests`
--
ALTER TABLE `savings_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `store_wallets`
--
ALTER TABLE `store_wallets`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `deposits_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `product_categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`);

--
-- Constraints for table `savings_products`
--
ALTER TABLE `savings_products`
  ADD CONSTRAINT `savings_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `savings_requests`
--
ALTER TABLE `savings_requests`
  ADD CONSTRAINT `savings_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `savings_requests_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`);

--
-- Constraints for table `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`);

--
-- Constraints for table `store_wallets`
--
ALTER TABLE `store_wallets`
  ADD CONSTRAINT `store_wallets_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`),
  ADD CONSTRAINT `store_wallets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
