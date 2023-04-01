-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2023 at 08:56 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codeweb_store_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_phone_no` varchar(20) NOT NULL,
  `additional_info` text DEFAULT NULL,
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agents`
--

INSERT INTO `agents` (`agent_id`, `last_name`, `first_name`, `other_name`, `email`, `passkey`, `phone_no`, `account_status`, `deleted`, `created_at`) VALUES
(4, 'Shodiya', 'Folorunsho', 'Ayomide', 'folushoayomide11@gmail.com', '$2y$10$bdpMM7WcByR0RlvOOfJe9eqNoBvPuHp7I46UANgTGBCAMNNMu8l7W', '07087857141', '1', '0', '2023-03-21 18:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `installment_payments`
--

CREATE TABLE `installment_payments` (
  `payment_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `paid_for` int(11) NOT NULL COMMENT 'day || week || month',
  `payment_status` varchar(1) DEFAULT NULL COMMENT '0-failure, 1-successful',
  `deposited_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `payment_confirmed` varchar(1) NOT NULL DEFAULT '0',
  `status` varchar(1) NOT NULL COMMENT '1-pending,2-awaiting shipment,3-shipped,4-completed,5-cancelled',
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders_products`
--

CREATE TABLE `orders_products` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
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
  `active` varchar(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `active`, `created_at`, `updated_at`) VALUES
(9, 'Hisense FC66DD 500L Chest Freezer  ', '329000.00', '377.jpeg', '                                        ', 1, '1', 6, '1', '2023-03-01 21:33:15', '2023-03-06 03:33:11'),
(10, 'Hisense FC91DD 702L Chest Freezer ', '469000.00', '378.jpeg', '                                        ', 1, '1', 6, '1', '2023-03-01 22:38:30', '2023-03-06 03:33:11'),
(11, 'Hisense FC120SH 95L Chest Freezer', '100000.00', '372.jpeg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Power Indicator Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Fast Freezer</span>                                        ', 1, '1', 6, '1', '2023-03-01 22:59:41', '2023-03-06 03:33:11'),
(12, 'Hisense 189DR-RS 190L Standing Freezer ', '213000.00', '781.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 189DR-RS 190L Standing Freezer&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:01:28', '2023-03-06 03:33:11'),
(13, 'Hisense FC320SH 250L Chest Freezer', '209800.00', '452.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC320SH 250L Chest Freezer</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:05:37', '2023-03-06 03:33:11'),
(14, 'LG GR-K25DSLBC 250L Chest Freezer ', '376000.00', '69.jpeg', '<span style=\"font-size: 15.24px;\">LG GR-K25DSLBC 250L Chest Freezer&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:07:20', '2023-03-06 03:33:11'),
(15, 'LG GN-304SQ 168L Standing Freezer L265,₦   Out Of Stock', '400000.00', '70.jpeg', '<span style=\"font-size: 15.24px;\">G GN-304SQ 168L Standing Freezer&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:11:23', '2023-03-06 03:33:11'),
(16, 'LG GR-K45DSLBC 450L Chest Freezer ', '522000.00', '69.jpeg,62557d55167da.png,62557d54420bf.png', '<span style=\"font-size: 15.24px;\">LG GR-K45DSLBC 450L Chest Freezer&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:14:10', '2023-03-06 03:33:11'),
(17, 'Hisense FC180SH 144L Chest Freezer', '115000.00', '191.png,189.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC180SH 144L Chest Freezer&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:21:33', '2023-03-06 03:33:11'),
(18, 'Hisense FC55DD 420L Double Door Chest Freezer', '319000.00', '194.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC55DD 420L Double Door Chest Freezer</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:24:27', '2023-03-06 03:33:11'),
(19, 'Hisense FC390SH 297L Chest Freezer', '224700.00', '193.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Hisense FC390SH 297L Chest Freezer</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:26:22', '2023-03-06 03:33:11'),
(20, 'Hisense 212DR 161L Top Freezer Refrigerator ', '178700.00', '215.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 212DR 161L Top Freezer Refrigerator&nbsp;</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:31:01', '2023-03-06 03:33:11'),
(21, 'LG GL-C292RLBN 257L Top Freezer Refrigerator ', '299000.00', '102.jpeg', '<span style=\"font-size: 15.24px;\">LG GL-C292RLBN 257L Top Freezer Refrigerator</span>                                        ', 1, '1', 10, '1', '2023-03-01 23:34:08', '2023-03-06 03:33:11'),
(22, 'Hisense H20MOMS10 700W 20L Microwave Oven', '47100.00', '202.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H20MOMS10 700W 20L Microwave Oven&nbsp;</span>                                        ', 2, '1', 6, '1', '2023-03-01 23:55:32', '2023-03-06 03:33:11'),
(23, 'Hisense H36MOMMI 1000W 36L Microwave Oven ', '83500.00', '206.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H36MOMMI 1000W 36L Microwave Oven&nbsp;</span>', 2, '1', 6, '1', '2023-03-01 23:57:28', '2023-03-06 03:33:11'),
(24, 'LG MS2044DMB 700W 20L Microwave Oven ', '55700.00', '80.jpeg', '<span style=\"font-size: 15.24px;\">LG MS2044DMB 700W 20L Microwave Oven&nbsp;</span>', 2, '1', 6, '1', '2023-03-01 23:59:06', '2023-03-06 03:33:11'),
(25, 'LG MH8265CIS 1200W 42L Microwave Oven ', '124000.00', '86.jpeg', '<span style=\"font-size: 15.24px;\">LG MH8265CIS 1200W 42L Microwave Oven</span>', 2, '1', 10, '1', '2023-03-02 00:02:08', '2023-03-06 03:33:11'),
(26, 'LG 43 Inch UQ70 Series UHD 4K Smart TV  ', '222900.00', '473.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch UQ70 Series UHD 4K Smart TV</span>                                        ', 1, '1', 10, '1', '2023-03-02 00:04:42', '2023-03-06 03:33:11'),
(27, 'LG 43 Inch LM637 Series FHD Smart TV ', '194000.00', '165.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch LM637 Series FHD Smart TV 194,000&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:06:55', '2023-03-06 03:33:11'),
(28, 'Maxi 42 Inch D2010S Series HD Smart TV ', '132300.00', '443.jpeg', '<span style=\"font-size: 15.24px;\">Maxi 42 Inch D2010S Series HD Smart TV</span>', 1, '1', 10, '1', '2023-03-02 00:09:02', '2023-03-06 03:33:11'),
(29, 'LG 48 Inch OLED C1 Series UHD 4K Smart TV ', '781000.00', '478.jpeg', '<span style=\"font-size: 15.24px;\">LG 48 Inch OLED C1 Series UHD 4K Smart TV&nbsp;&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:14:39', '2023-03-06 03:33:11'),
(30, 'Hisense 43 Inch A4G Series FHD Smart TV ', '167500.00', '251.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:16:40', '2023-03-06 03:33:11'),
(31, 'Hisense 40 Inch A4G Series FHD Smart TV', '144500.00', '248.jpeg', '<span style=\"font-size: 15.24px;\">&nbsp;Hisense 40 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:18:18', '2023-03-06 03:33:11'),
(32, 'Hisense 40 Inch A5100 Series HD TV ', '119900.00', '249.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 40 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:20:13', '2023-03-06 03:33:11'),
(33, 'Hisense 43 Inch A5100 Series HD TV ', '138900.00', '252.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 00:21:03', '2023-03-06 03:33:11'),
(34, 'Hisense 8KG Tumble Dryer', '113500.00', '188.jpg', '<span style=\"font-size: 15.24px;\">Hisense 8KG Tumble Dryer</span>                                        ', 1, '1', 10, '1', '2023-03-02 12:07:56', '2023-03-06 03:33:11'),
(35, 'LG F0L2CRV2T2 20/12KG Front Load (Wash & Dry) Washing Machine ', '844300.00', '132.jpeg', '<span style=\"font-size: 15.24px;\">LG F0L2CRV2T2 20/12KG Front Load (Wash &amp; Dry) Washing Machine&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 14:40:31', '2023-03-06 03:33:11'),
(36, 'LG T9585NDHVH 9KG Top Load Washing Machine ', '239700.00', '114.jpeg', '<span style=\"font-size: 15.24px;\">LG T9585NDHVH 9KG Top Load Washing Machine&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 15:01:29', '2023-03-06 03:33:11'),
(37, 'LG WP-950RC 8KG Top Load Twin Tub Washing Machine ', '165900.00', '115.jpeg', '<span style=\"font-size: 15.24px;\">LG WP-950RC 8KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 15:06:05', '2023-03-06 03:33:11'),
(38, 'Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine ', '109900.00', '307.jpeg', '<span style=\"font-size: 15.24px;\">Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 10, '1', '2023-03-02 15:11:15', '2023-03-06 03:33:11'),
(39, 'Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper', '182000.00', '1.jpeg', '<span style=\"font-size: 15.24px;\">Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper</span>                                        ', 15, '1', 10, '1', '2023-03-03 08:16:20', '2023-03-06 03:33:11'),
(40, 'Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)', '360000.00', '2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:21:57', '2023-03-06 03:33:11'),
(41, 'Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper', '255000.00', '3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:23:03', '2023-03-06 03:33:11'),
(42, 'Senwei 4.5kva Key Starter Superb Generator- Sp7800E2', '160000.00', '4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Senwei 4.5kva Key Starter Superb Generator- Sp7800E2</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:24:10', '2023-03-06 03:33:11'),
(43, 'Firman Sumec Firman 10kva Generator Key Start Eco12990ES', '650000.00', '5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Firman Sumec Firman 10kva Generator Key Start Eco12990ES</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:25:10', '2023-03-06 03:33:11'),
(44, 'Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level', '129000.00', '6.jpeg', '<span style=\"font-size: 15.24px;\">Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level</span>                                        ', 15, '1', 10, '1', '2023-03-03 08:26:18', '2023-03-06 03:33:11'),
(45, 'Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)', '98000.00', '7.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:27:15', '2023-03-06 03:33:11'),
(46, 'KEMAGE Remote Control Generator 10.5kva Petrol Engine', '400000.00', '8.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">KEMAGE Remote Control Generator 10.5kva Petrol Engine</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:29:39', '2023-03-06 03:33:11'),
(47, 'Sumec Firman 5.5Kva Rugged Generator RD3910EX', '255000.00', '9.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman 5.5Kva Rugged Generator RD3910EX</h1>                                        ', 15, '1', 10, '1', '2023-03-03 08:34:09', '2023-03-06 03:33:11'),
(48, 'Maxi 60*90 (4+2) Burner Gas Cooker INOX', '201200.00', '335.png', '<span style=\"font-size: 15.24px;\">Maxi 60*90 (4+2) Burner Gas Cooker INOX</span>                                        ', 2, '1', 10, '1', '2023-03-03 12:14:51', '2023-03-06 03:33:11'),
(49, 'Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood', '114500.00', '324.png', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood</span>                                        ', 2, '1', 10, '1', '2023-03-03 12:17:19', '2023-03-06 03:33:11'),
(50, 'Maxi 60*60 4 Burner Gas Cooker Basic Black Gray', '98400.00', '325.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 4 Burner Gas Cooker Basic Black Gray</span>                                        ', 2, '1', 10, '1', '2023-03-03 12:20:17', '2023-03-06 03:33:11'),
(51, 'Maxi 60*90 (4+2) Burner Gas Cooker Wood', '202300.00', '638087df2ad9c.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*90 (4+2) Burner Gas Cooker Wood</span>                                        ', 2, '1', 10, '1', '2023-03-03 12:22:35', '2023-03-06 03:33:11'),
(52, 'Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x', '65100.00', '182.jpeg', '<span style=\"font-size: 15.24px;\">Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x</span>                                        ', 1, '1', 3, '1', '2023-03-03 12:26:57', '2023-03-06 03:33:11'),
(53, 'LG LHD667 4.2ch 600W Home Theater System ', '182000.00', '44.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD667 4.2ch 600W Home Theater System (2)&nbsp;</span>', 1, '1', 10, '1', '2023-03-03 12:29:05', '2023-03-06 03:33:11'),
(54, 'LG LHD687 4.2ch 1250W Home Theater System ', '214000.00', '46.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD687 4.2ch 1250W Home Theater System&nbsp;</span>', 1, '1', 10, '1', '2023-03-03 12:30:31', '2023-03-06 03:33:11'),
(55, 'Century 1.5 LITER BLENDER CB 8231 P-1', '14000.00', '121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Century 1.5 LITER BLENDER CB 8231 P-1</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:07:47', '2023-03-06 03:33:11'),
(56, 'Silver Crest 5000W German Industrial Food Crusher & Blender + Extra Mill Jar', '17490.00', '111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Silver Crest 5000W German Industrial Food Crusher &amp; Blender + Extra Mill Jar</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:13:35', '2023-03-06 03:33:11'),
(57, 'Blender +Toaster + Iron Bundle', '21999.00', '1212.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Blender +Toaster + Iron Bundle</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:20:47', '2023-03-06 03:33:11'),
(58, 'Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)', '36060.00', '12121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:23:43', '2023-03-06 03:33:11'),
(59, 'HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl', '9082.00', '1111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:26:00', '2023-03-06 03:33:11'),
(60, 'Canon EOS 600D DSLR Camera With 18-55mm Lens', '229999.00', '11.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Canon EOS 600D DSLR Camera With 18-55mm Lens</h1>                                        ', 4, '1', 10, '1', '2023-03-03 13:29:34', '2023-03-06 03:33:11'),
(61, 'Nikon D60 DSLR Camera With 55-200mm', '175000.00', 'nikon.jpeg', '                                        ', 4, '1', 10, '1', '2023-03-03 13:32:05', '2023-03-06 03:33:11'),
(62, 'Canon Camera 7D Digital Camera With 18 To 55MM Lens', '335000.00', 'canon.jpeg', '<span style=\"font-size: 15.24px;\">Canon Camera 7D Digital Camera With 18 To 55MM Lens</span><br>', 4, '1', 10, '1', '2023-03-03 13:33:50', '2023-03-06 03:33:11'),
(63, 'Nikon D40 Camera With 18-55mm Lens', '130000.00', 'nikon2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Nikon D40 Camera With 18-55mm Lens</h1>                                        ', 4, '1', 10, '1', '2023-03-03 13:38:41', '2023-03-06 03:33:11'),
(64, 'Maimeite Yam Pounder 2L Meat Grinder Cooking Blender', '6999.00', 'yam1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maimeite Yam Pounder 2L Meat Grinder Cooking Blender</h1>                                        ', 2, '1', 3, '1', '2023-03-03 13:45:09', '2023-03-06 03:33:11'),
(65, 'HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl', '9082.00', 'yam2.jpeg', '<span style=\"font-size: 15.24px;\">HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl</span>                                        ', 2, '1', 3, '1', '2023-03-03 13:47:37', '2023-03-06 03:33:11');

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
(15, 'generator');

-- --------------------------------------------------------

--
-- Table structure for table `savings_history`
--

CREATE TABLE `savings_history` (
  `savings_id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `date_paid` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `savings_requests`
--

CREATE TABLE `savings_requests` (
  `id` int(11) NOT NULL,
  `savings_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `product_id(s)` varchar(255) NOT NULL,
  `quantity(ies)` varchar(255) NOT NULL,
  `type_of_savings` varchar(1) NOT NULL COMMENT '1-half savings, 2-normal savings',
  `installment_type` varchar(1) NOT NULL COMMENT '1-daily, 2-weekly, 3-monthly ',
  `duration_of_savings` int(11) NOT NULL COMMENT 'days || weeks || months ',
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(1) NOT NULL COMMENT '1-pending, 2-approved, 3-rejected',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `store_wallets`
--

CREATE TABLE `store_wallets` (
  `wallet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `current_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `target_amount` decimal(10,2) NOT NULL,
  `type` varchar(1) NOT NULL COMMENT '1-daily, 2-weekly, 3-monthly',
  `paid_for` int(11) DEFAULT NULL COMMENT 'day || week || month',
  `duration` int(11) NOT NULL COMMENT 'days || weeks || months',
  `next_due_date` date DEFAULT NULL,
  `completed` varchar(1) NOT NULL DEFAULT '0' COMMENT '0-in progress, 1-completed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `last_name`, `first_name`, `email`, `phone_no`, `passkey`, `is_email_verified`, `account_status`, `created_at`, `updated_at`) VALUES
(2, 'Shodiya', 'Folorunsho', 'folushoayomide11@gmail.com', '07087857141', '$2y$10$WJbugvbfrfUQHRlIK2cv/OONM3Mbdgh0XUj86uJnVKmSy6Sj0cc12', '1', '1', '2023-03-16 11:17:55', '2023-03-16 12:18:46');

-- --------------------------------------------------------

--
-- Table structure for table `users_addresses`
--

CREATE TABLE `users_addresses` (
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `active` varchar(1) NOT NULL COMMENT '0-false, 1-true'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wallets_products`
--

CREATE TABLE `wallets_products` (
  `id` int(11) NOT NULL,
  `wallet_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
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
-- Indexes for table `installment_payments`
--
ALTER TABLE `installment_payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `wallet_id` (`wallet_id`);

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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `products_ibfk_1` (`category`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `savings_history`
--
ALTER TABLE `savings_history`
  ADD PRIMARY KEY (`savings_id`);

--
-- Indexes for table `savings_requests`
--
ALTER TABLE `savings_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_request_ibfk_1` (`user_id`),
  ADD KEY `savings_request_ibfk_2` (`agent_id`),
  ADD KEY `savings_request_ibfk_3` (`product_id(s)`);

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
-- Indexes for table `wallets_products`
--
ALTER TABLE `wallets_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_id` (`wallet_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `savings_history`
--
ALTER TABLE `savings_history`
  MODIFY `savings_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savings_requests`
--
ALTER TABLE `savings_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `store_wallets`
--
ALTER TABLE `store_wallets`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wallets_products`
--
ALTER TABLE `wallets_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `product_categories` (`category_id`);

--
-- Constraints for table `savings_requests`
--
ALTER TABLE `savings_requests`
  ADD CONSTRAINT `savings_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `savings_requests_ibfk_2` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`);

--
-- Constraints for table `store_wallets`
--
ALTER TABLE `store_wallets`
  ADD CONSTRAINT `store_wallets_ibfk_1` FOREIGN KEY (`agent_id`) REFERENCES `agents` (`agent_id`),
  ADD CONSTRAINT `store_wallets_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `wallets_products`
--
ALTER TABLE `wallets_products`
  ADD CONSTRAINT `wallets_products_ibfk_1` FOREIGN KEY (`wallet_id`) REFERENCES `store_wallets` (`wallet_id`),
  ADD CONSTRAINT `wallets_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
