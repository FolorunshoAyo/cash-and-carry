-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2023 at 05:09 PM
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

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `recipient_name`, `recipient_phone_no`, `additional_info`, `city_name`, `delivery_address`, `address_state`, `address_postal_code`) VALUES
(1, 'Shodiya Folorunsho', '07087857141', 'Once you get to lastma office towards laspotech, ask for akasolori. ', 'Ikorodu', 'Plot 3a, Olaoluwa Ige St. Ayonnusi Estate.', 'Lagos', '3465');

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
(6, 'Shodiya', 'Folorunsho', 'Ayomide', 'folushoayomide11@gmail.com', '$2y$10$otyYgyEY7m5kB2qx4Dg9iestM5DW8TTFZYXWNF3LPvc3O/4q1mpTG', '07087857141', '1', '0', '2023-04-26 08:13:22');

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
  `payment_method` varchar(1) NOT NULL COMMENT '1-pay with cards, ussd or bank transfers, 2-cash on delivery',
  `placed_successfully` varchar(1) NOT NULL DEFAULT '0' COMMENT '1- true - false',
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-pending,2-awaiting shipment,3-shipped,4-completed,5-cancelled',
  `ordered_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `store_id`, `in_stock`, `visibility`, `created_at`, `updated_at`) VALUES
(1, 'Owlenz SD150 2400 LUMEN HD LCD PROJECTOR - BLACK', '100000.00', 'projector1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Owlenz SD150 2400 LUMEN HD LCD PROJECTOR - BLACK</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 15:33:17', '2023-05-08 10:10:37'),
(9, 'Hisense FC66DD 500L Chest Freezer  ', '329000.00', '377.jpeg', '                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 21:33:15', '2023-05-08 10:10:37'),
(10, 'Hisense FC91DD 702L Chest Freezer ', '469000.00', '378.jpeg', '                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 22:38:30', '2023-05-08 10:10:37'),
(11, 'Hisense FC120SH 95L Chest Freezer', '100000.00', '372.jpeg', '<span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Power Indicator Function</span><br style=\"font-family: Poppins; font-size: 14px; color: rgba(38, 40, 43, 0.6);\"><span style=\"color: rgba(38, 40, 43, 0.6); font-family: Poppins; font-size: 12px;\">Fast Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 22:59:41', '2023-05-08 10:10:37'),
(12, 'Hisense 189DR-RS 190L Standing Freezer ', '213000.00', '781.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 189DR-RS 190L Standing Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:01:28', '2023-05-08 10:10:37'),
(13, 'Hisense FC320SH 250L Chest Freezer', '209800.00', '452.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC320SH 250L Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:05:37', '2023-05-08 10:10:37'),
(14, 'LG GR-K25DSLBC 250L Chest Freezer ', '376000.00', '69.jpeg', '<span style=\"font-size: 15.24px;\">LG GR-K25DSLBC 250L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:07:20', '2023-05-08 10:10:37'),
(15, 'LG GN-304SQ 168L Standing Freezer L265,₦   Out Of Stock', '400000.00', '70.jpeg', '<span style=\"font-size: 15.24px;\">G GN-304SQ 168L Standing Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:11:23', '2023-05-08 10:10:37'),
(16, 'LG GR-K45DSLBC 450L Chest Freezer ', '522000.00', '69.jpeg,62557d55167da.png,62557d54420bf.png', '<span style=\"font-size: 15.24px;\">LG GR-K45DSLBC 450L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:14:10', '2023-05-08 10:10:37'),
(17, 'Hisense FC180SH 144L Chest Freezer', '115000.00', '191.png,189.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC180SH 144L Chest Freezer&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:21:33', '2023-05-08 10:10:37'),
(18, 'Hisense FC55DD 420L Double Door Chest Freezer', '319000.00', '194.jpeg', '<span style=\"font-size: 15.24px;\">Hisense FC55DD 420L Double Door Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:24:27', '2023-05-08 10:10:37'),
(19, 'Hisense FC390SH 297L Chest Freezer', '224700.00', '193.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Hisense FC390SH 297L Chest Freezer</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:26:22', '2023-05-08 10:10:37'),
(20, 'Hisense 212DR 161L Top Freezer Refrigerator ', '178700.00', '215.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 212DR 161L Top Freezer Refrigerator&nbsp;</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:31:01', '2023-05-08 10:10:37'),
(21, 'LG GL-C292RLBN 257L Top Freezer Refrigerator ', '299000.00', '102.jpeg', '<span style=\"font-size: 15.24px;\">LG GL-C292RLBN 257L Top Freezer Refrigerator</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-01 23:34:08', '2023-05-08 10:10:37'),
(22, 'Hisense H20MOMS10 700W 20L Microwave Oven', '47100.00', '202.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H20MOMS10 700W 20L Microwave Oven&nbsp;</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-01 23:55:32', '2023-05-08 10:10:37'),
(23, 'Hisense H36MOMMI 1000W 36L Microwave Oven ', '83500.00', '206.jpeg', '<span style=\"font-size: 15.24px;\">Hisense H36MOMMI 1000W 36L Microwave Oven&nbsp;</span>', 2, '1', 4, 1, 50, '1', '2023-03-01 23:57:28', '2023-05-08 10:10:37'),
(24, 'LG MS2044DMB 700W 20L Microwave Oven ', '55700.00', '80.jpeg', '<span style=\"font-size: 15.24px;\">LG MS2044DMB 700W 20L Microwave Oven&nbsp;</span>', 2, '1', 4, 1, 50, '1', '2023-03-01 23:59:06', '2023-05-08 10:10:37'),
(25, 'LG MH8265CIS 1200W 42L Microwave Oven ', '124000.00', '86.jpeg', '<span style=\"font-size: 15.24px;\">LG MH8265CIS 1200W 42L Microwave Oven</span>', 2, '1', 4, 1, 50, '1', '2023-03-02 00:02:08', '2023-05-08 10:10:37'),
(26, 'LG 43 Inch UQ70 Series UHD 4K Smart TV  ', '222900.00', '473.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch UQ70 Series UHD 4K Smart TV</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-02 00:04:42', '2023-05-08 10:10:37'),
(27, 'LG 43 Inch LM637 Series FHD Smart TV ', '194000.00', '165.jpeg', '<span style=\"font-size: 15.24px;\">LG 43 Inch LM637 Series FHD Smart TV 194,000&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:06:55', '2023-05-08 10:10:37'),
(28, 'Maxi 42 Inch D2010S Series HD Smart TV ', '132300.00', '443.jpeg', '<span style=\"font-size: 15.24px;\">Maxi 42 Inch D2010S Series HD Smart TV</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:09:02', '2023-05-08 10:10:37'),
(29, 'LG 48 Inch OLED C1 Series UHD 4K Smart TV ', '781000.00', '478.jpeg', '<span style=\"font-size: 15.24px;\">LG 48 Inch OLED C1 Series UHD 4K Smart TV&nbsp;&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:14:39', '2023-05-08 10:10:37'),
(30, 'Hisense 43 Inch A4G Series FHD Smart TV ', '167500.00', '251.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:16:40', '2023-05-08 10:10:37'),
(31, 'Hisense 40 Inch A4G Series FHD Smart TV', '144500.00', '248.jpeg', '<span style=\"font-size: 15.24px;\">&nbsp;Hisense 40 Inch A4G Series FHD Smart TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:18:18', '2023-05-08 10:10:37'),
(32, 'Hisense 40 Inch A5100 Series HD TV ', '119900.00', '249.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 40 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:20:13', '2023-05-08 10:10:37'),
(33, 'Hisense 43 Inch A5100 Series HD TV ', '138900.00', '252.jpeg', '<span style=\"font-size: 15.24px;\">Hisense 43 Inch A5100 Series HD TV&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 00:21:03', '2023-05-08 10:10:37'),
(34, 'Hisense 8KG Tumble Dryer', '113500.00', '188.jpg', '<span style=\"font-size: 15.24px;\">Hisense 8KG Tumble Dryer</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-02 12:07:56', '2023-05-08 10:10:37'),
(35, 'LG F0L2CRV2T2 20/12KG Front Load (Wash & Dry) Washing Machine ', '844300.00', '132.jpeg', '<span style=\"font-size: 15.24px;\">LG F0L2CRV2T2 20/12KG Front Load (Wash &amp; Dry) Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 14:40:31', '2023-05-08 10:10:37'),
(36, 'LG T9585NDHVH 9KG Top Load Washing Machine ', '239700.00', '114.jpeg', '<span style=\"font-size: 15.24px;\">LG T9585NDHVH 9KG Top Load Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 15:01:29', '2023-05-08 10:10:37'),
(37, 'LG WP-950RC 8KG Top Load Twin Tub Washing Machine ', '165900.00', '115.jpeg', '<span style=\"font-size: 15.24px;\">LG WP-950RC 8KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 15:06:05', '2023-05-08 10:10:37'),
(38, 'Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine ', '109900.00', '307.jpeg', '<span style=\"font-size: 15.24px;\">Hisense WM753-WSQB 7.5KG Top Load Twin Tub Washing Machine&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-02 15:11:15', '2023-05-08 10:10:37'),
(39, 'Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper', '182000.00', '1.jpeg', '<span style=\"font-size: 15.24px;\">Elepaq 4.5KVA Key Start Generator - SV7800E2 100% Copper</span>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:16:20', '2023-05-08 10:10:37'),
(40, 'Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)', '360000.00', '2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 12kVa, SV22000E2 Key Start Generator (complete Copper Coil)</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:21:57', '2023-05-08 10:10:37'),
(41, 'Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper', '255000.00', '3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Elepaq 6.5KVA Constant Elepaq Key Start Generator - SV8800E2 100% Copper</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:23:03', '2023-05-08 10:10:37'),
(42, 'Senwei 4.5kva Key Starter Superb Generator- Sp7800E2', '160000.00', '4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Senwei 4.5kva Key Starter Superb Generator- Sp7800E2</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:24:10', '2023-05-08 10:10:37'),
(43, 'Firman Sumec Firman 10kva Generator Key Start Eco12990ES', '650000.00', '5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Firman Sumec Firman 10kva Generator Key Start Eco12990ES</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:25:10', '2023-05-08 10:10:37'),
(44, 'Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level', '129000.00', '6.jpeg', '<span style=\"font-size: 15.24px;\">Senwei 4.5KVA Manul Start Generator SV5200. - Low Noise Level</span>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:26:18', '2023-05-08 10:10:37'),
(45, 'Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)', '98000.00', '7.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman Generator SPG2200 1.8KVA -Red 100% Copper (Strong)</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:27:15', '2023-05-08 10:10:37'),
(46, 'KEMAGE Remote Control Generator 10.5kva Petrol Engine', '400000.00', '8.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">KEMAGE Remote Control Generator 10.5kva Petrol Engine</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:29:39', '2023-05-08 10:10:37'),
(47, 'Sumec Firman 5.5Kva Rugged Generator RD3910EX', '255000.00', '9.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Sumec Firman 5.5Kva Rugged Generator RD3910EX</h1>                                        ', 15, '1', 4, 1, 50, '1', '2023-03-03 08:34:09', '2023-05-08 10:10:37'),
(48, 'Maxi 60*90 (4+2) Burner Gas Cooker INOX', '201200.00', '335.png', '<span style=\"font-size: 15.24px;\">Maxi 60*90 (4+2) Burner Gas Cooker INOX</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 12:14:51', '2023-05-08 10:10:37'),
(49, 'Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood', '114500.00', '324.png', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 (3+1) Burner Gas Cooker IGL Wood</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 12:17:19', '2023-05-08 10:10:37'),
(50, 'Maxi 60*60 4 Burner Gas Cooker Basic Black Gray', '98400.00', '325.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*60 4 Burner Gas Cooker Basic Black Gray</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 12:20:17', '2023-05-08 10:10:37'),
(51, 'Maxi 60*90 (4+2) Burner Gas Cooker Wood', '202300.00', '638087df2ad9c.jpeg', '<span style=\"color: rgb(38, 40, 43); font-family: Poppins; font-size: 18px;\">Maxi 60*90 (4+2) Burner Gas Cooker Wood</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 12:22:35', '2023-05-08 10:10:37'),
(52, 'Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x', '65100.00', '182.jpeg', '<span style=\"font-size: 15.24px;\">Hisense HS212 2.1ch 120W Soundbar with wireless subwoofer x</span>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-03 12:26:57', '2023-05-08 10:10:37'),
(53, 'LG LHD667 4.2ch 600W Home Theater System ', '182000.00', '44.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD667 4.2ch 600W Home Theater System (2)&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-03 12:29:05', '2023-05-08 10:10:37'),
(54, 'LG LHD687 4.2ch 1250W Home Theater System ', '214000.00', '46.jpeg', '<span style=\"font-size: 15.24px;\">LG LHD687 4.2ch 1250W Home Theater System&nbsp;</span>', 1, '1', 4, 1, 50, '1', '2023-03-03 12:30:31', '2023-05-08 10:10:37'),
(55, 'Century 1.5 LITER BLENDER CB 8231 P-1', '14000.00', '121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Century 1.5 LITER BLENDER CB 8231 P-1</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:07:47', '2023-05-08 10:10:37'),
(56, 'Silver Crest 5000W German Industrial Food Crusher & Blender + Extra Mill Jar', '17490.00', '111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Silver Crest 5000W German Industrial Food Crusher &amp; Blender + Extra Mill Jar</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:13:35', '2023-05-08 10:10:37'),
(57, 'Blender +Toaster + Iron Bundle', '21999.00', '1212.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Blender +Toaster + Iron Bundle</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:20:47', '2023-05-08 10:10:37'),
(58, 'Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)', '36060.00', '12121.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Binatone Stainless Steel Blender/Grinder With Stick - (BLG-605ss)</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:23:43', '2023-05-08 10:10:37'),
(59, 'HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl', '9082.00', '1111.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">HAN RIVER 2L Blender/Yam Pounder And Multifunctional Food Machine Bowl</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:26:00', '2023-05-08 10:10:37'),
(60, 'Canon EOS 600D DSLR Camera With 18-55mm Lens', '229999.00', '11.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Canon EOS 600D DSLR Camera With 18-55mm Lens</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-03 13:29:34', '2023-05-08 10:10:37'),
(61, 'Nikon D60 DSLR Camera With 55-200mm', '175000.00', 'nikon.jpeg', '                                        ', 4, '1', 4, 1, 50, '1', '2023-03-03 13:32:05', '2023-05-08 10:10:37'),
(62, 'Canon Camera 7D Digital Camera With 18 To 55MM Lens', '335000.00', 'canon.jpeg', '<span style=\"font-size: 15.24px;\">Canon Camera 7D Digital Camera With 18 To 55MM Lens</span><br>', 4, '1', 4, 1, 50, '1', '2023-03-03 13:33:50', '2023-05-08 10:10:37'),
(63, 'Nikon D40 Camera With 18-55mm Lens', '130000.00', 'nikon2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Nikon D40 Camera With 18-55mm Lens</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-03 13:38:41', '2023-05-08 10:10:37'),
(64, 'Maimeite Yam Pounder 2L Meat Grinder Cooking Blender', '6999.00', 'yam1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maimeite Yam Pounder 2L Meat Grinder Cooking Blender</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:45:09', '2023-05-08 10:10:37'),
(65, 'HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl', '9082.00', 'yam2.jpeg', '<span style=\"font-size: 15.24px;\">HAN RIVER 2L Yam Pounder And Multifunctional Food Machine Bowl</span>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-03 13:47:37', '2023-05-08 10:10:37'),
(66, 'UC40 Multi-media Mini 800 Lumens Portable LED Projection Micro Home Theater Projector White', '243000.00', 'projector2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">UC40 Multi-media Mini 800 Lumens Portable LED Projection Micro Home Theater Projector White</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 15:39:36', '2023-05-08 10:10:37'),
(67, 'LY-50 1800 Lumens 1280x800 Home Theater LED Projector With Remote Control, Support AV & USB & VGA & HDMI(Black)', '85840.00', 'projector3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">LY-50 1800 Lumens 1280x800 Home Theater LED Projector With Remote Control, Support AV &amp; USB &amp; VGA &amp; HDMI(Black)</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 15:40:37', '2023-05-08 10:10:37'),
(68, '72\"X72\" Electric Projector Screen With Remote Control', '48500.00', 'screen1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">72\"X72\" Electric Projector Screen With Remote Control</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 15:41:38', '2023-05-08 10:10:37'),
(69, '60 X 60 Tripod Projector Screen', '35000.00', 'screen2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">60 X 60 Tripod Projector Screen</h1>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 15:42:49', '2023-05-08 10:10:37'),
(70, '90\"X90\" Electric Projector Screen With Remote Control', '98000.00', 'screen3.jpeg', '<h2 class=\"\"><b>90\"X90\" Electric Projector Screen With Remote Control                                        </b></h2>', 4, '1', 4, 1, 50, '1', '2023-03-06 15:43:47', '2023-05-08 10:10:37'),
(71, 'Dell Latitude e7450', '160000.00', 'dell1.jpeg', '<span style=\"font-size: 15.24px;\">Dell Latitude e7450. 8GB Ram, 256 SSD</span>', 4, '1', 4, 1, 50, '1', '2023-03-06 15:50:45', '2023-05-08 10:10:37'),
(72, 'Dell Latitude e5570', '200000.00', 'E55701.jpeg', 'Dell Latitude e5570, core i7 processor, 8GB ram, 256 SSD, 2Gb dedicated graphics', 4, '1', 4, 1, 50, '1', '2023-03-06 15:54:51', '2023-05-08 10:10:37'),
(73, 'HP 1040 g4', '260000.00', 'hp1040.png', 'hp 1040 g4 core i5, 16gb ram, 256 ssd, touch screen, face ID, fingerprint scanner', 4, '1', 4, 1, 50, '1', '2023-03-06 15:58:16', '2023-05-08 10:10:37'),
(74, 'Dell Latitude 7820', '200000.00', '7280.png', 'Dell latitude 7820, core i7, 8gb ram, 256 ssd, touch screen', 4, '1', 4, 1, 50, '1', '2023-03-06 16:43:35', '2023-05-08 10:10:37'),
(75, 'Dell e430', '110000.00', 'e430.png', 'Dell e6430 core i5, 8gb ram, 256 ssd, keyboard light', 4, '1', 4, 1, 50, '1', '2023-03-06 16:48:00', '2023-05-08 10:10:37'),
(76, 'hp 8470p', '90000.00', 'hp8470.jpg', 'hp 8470p core i5, 4gb ram, 500 hdd', 4, '1', 4, 1, 50, '1', '2023-03-06 16:58:05', '2023-05-08 10:10:37'),
(77, 'Lenovo T480s', '240000.00', 't840s.jpg', '<div class=\"kEwVtd\" style=\"-webkit-tap-highlight-color: transparent; display: flex; overflow: hidden;\"><div class=\"kEwVtd\" style=\"-webkit-tap-highlight-color: transparent; display: flex; overflow: hidden;\">8TH generation, core i7, 16gb ram, keyboard light, 256 ssd, 14 inches</div></div><div class=\"ZUo4Ze cS4Vcb-pGL6qe-ysgGef\" style=\"-webkit-tap-highlight-color: transparent; padding-right: 16px; padding-left: 16px; font-family: arial, sans-serif; font-size: 14px; line-height: 22px; color: rgba(0, 0, 0, 0.87);\"><div class=\"ZoQenf OiwQwf cS4Vcb-pGL6qe-k1Ncfe\" jsname=\"TdyZKc\" style=\"-webkit-tap-highlight-color: transparent; padding-top: 8px; color: rgb(112, 117, 122); font-family: arial, sans-serif; font-size: 12px; line-height: 16px;\"></div></div>                                        ', 4, '1', 4, 1, 50, '1', '2023-03-06 17:20:02', '2023-05-08 10:10:37'),
(78, 'Duravolt Rechargeable Table Fan With Solar Panel', '26500.00', 'fanvolt.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Duravolt Rechargeable Table Fan With Solar Panel</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:40:45', '2023-05-08 10:10:37'),
(79, 'Maimeite 16-Inch Standing Fan With Remote Control - White', '23000.00', 'fan1.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maimeite 16-Inch Standing Fan With Remote Control - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:42:16', '2023-05-08 10:10:37'),
(80, 'Ox 18 Inches Industrial Standing Fan - OX 18\'\'', '47000.00', 'fan3.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Ox 18 Inches Industrial Standing Fan - OX 18\'</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:45:11', '2023-05-08 10:10:37'),
(81, 'Ox Standing Fan Industrial 26\" Inches', '57380.00', 'fan4.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Ox Standing Fan Industrial 26\" Inches</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:48:06', '2023-05-08 10:10:37'),
(82, 'Professional 61 Keys Keyboard With Adaptor And Keyboard Stand', '155000.00', 'keyboard1.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional 61 Keys Keyboard With Adaptor And Keyboard Stand</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:54:27', '2023-05-08 10:10:37'),
(83, 'Yamaha PSR E373 Touch-Sensitive Portable Keyboard With Adapter', '228000.00', 'keyboard2.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha PSR E373 Touch-Sensitive Portable Keyboard With Adapter</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:57:05', '2023-05-08 10:10:37'),
(84, 'M Audio Keystation 61-Key II USB Midi Keyboard Controller', '152000.00', 'keyboard3.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">M Audio Keystation 61-Key II USB Midi Keyboard Controller</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 17:58:56', '2023-05-08 10:10:37'),
(85, 'Yamaha PSR-E373 Touch-Sensitive Portable Keyboard With Adapter', '235000.00', 'keyboard4.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha PSR-E373 Touch-Sensitive Portable Keyboard With Adapter</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:03:21', '2023-05-08 10:10:37'),
(86, 'Yamaha ARIUS YDP-144WH Digital Piano With Bench - White', '1120000.00', 'piano.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha ARIUS YDP-144WH Digital Piano With Bench - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:04:38', '2023-05-08 10:10:37'),
(87, 'M Audio Oxygen 49 USB MIDI Keyboard Controlle', '185000.00', 'keyboard5.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">M Audio Oxygen 49 USB MIDI Keyboard Controlle</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:06:04', '2023-05-08 10:10:37'),
(88, 'Behringer Eurodesk Mixer SX3242FX', '688000.00', 'mixer.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Behringer Eurodesk Mixer SX3242FX</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:12:50', '2023-05-08 10:10:37'),
(89, 'Focusrite Scarlett 18i8 USB 2.0 Audio Interface', '400000.00', 'mixer2.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Focusrite Scarlett 18i8 USB 2.0 Audio Interface</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:19:49', '2023-05-08 10:10:37'),
(90, 'Behringer Professional Wah-wah Pedal', '46000.00', 'suspencer.jpg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Behringer Professional Wah-wah Pedal</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 18:21:58', '2023-05-08 10:10:37'),
(91, 'Mama\'S Pride Premium Parboiled Rice 50KG Mamaâ€™s Pride @ A Promo Price', '44000.00', 'rice.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Pride Premium Parboiled Rice 50KG Mamaâ€™s Pride @ A Promo Price</h1>                                        ', 6, '1', 4, 1, 50, '1', '2023-03-06 20:47:33', '2023-05-08 10:10:37'),
(92, 'Mama Gold 50kg Rice', '38000.00', 'rice2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Gold 50kg Rice</h1>                                        ', 6, '1', 4, 1, 50, '1', '2023-03-06 20:50:22', '2023-05-08 10:10:37'),
(93, 'Chi Big Bull Rice 50kg @ Promo Price Big Bull Rice 50kg @ Promo Price', '45000.00', 'rice 3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Chi Big Bull Rice 50kg @ Promo Price Big Bull Rice 50kg @ Promo Price</h1>                                        ', 6, '1', 4, 1, 50, '1', '2023-03-06 20:52:45', '2023-05-08 10:10:37'),
(94, 'Mama\'S Choice Nigerian Parboiled Rice 50kg', '37500.00', 'ricee4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Mama Choice Nigerian Parboiled Rice 50kg</h1>                                        ', 6, '1', 4, 1, 50, '1', '2023-03-06 20:54:10', '2023-05-08 10:10:37'),
(95, 'Yamaha Alto Sax', '180000.00', 'sax.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha Alto Sax</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 20:59:33', '2023-05-08 10:10:37'),
(96, 'Alto Saxophone Bag', '35000.00', 'saxbag.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Alto Saxophone Bag</h1>                                        ', 7, '1', 4, 1, 50, '1', '2023-03-06 21:02:37', '2023-05-08 10:10:37'),
(97, 'Yamaha 5 PC DRUMSET WITH BIG PEDAL (BLUE)', '200000.00', 'drumset.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha 5 PC DRUMSET WITH BIG PEDAL (BLUE)</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:13:21', '2023-05-08 10:10:37'),
(98, 'Muslady 8inch Snare Drum Head With Drumsticks Shoulder', '28000.00', 'rolling.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Muslady 8inch Snare Drum Head With Drumsticks Shoulder</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-06 21:14:40', '2023-05-08 10:10:37'),
(99, 'Premier Marching Drum With Accessories - 3 Set', '94000.00', 'drums.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Premier Marching Drum With Accessories - 3 Set</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:17:34', '2023-05-08 10:10:37'),
(100, 'Yamaha 7set Drum (RACK) Wine Red', '410000.00', 'drum3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Yamaha 7set Drum (RACK) Wine Red</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:18:43', '2023-05-08 10:10:37'),
(101, 'Professional Single Bass Drum Pedal', '18000.00', 'pedder.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional Single Bass Drum Pedal</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:20:01', '2023-05-08 10:10:37'),
(102, 'Acoustic Box Guitar /Blue', '32000.00', 'guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Acoustic Box Guitar /Blue</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:26:17', '2023-05-08 10:10:37'),
(103, '5 Strings Bass Guitar With Stand Bag And Bell', '90000.00', 'bass guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">5 Strings Bass Guitar With Stand Bag And Bell</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:27:29', '2023-05-08 10:10:37'),
(104, 'Professional 6 Strings Electric Lead Guitar With Pick Bag And Belt', '70000.00', 'lead guitar.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Professional 6 Strings Electric Lead Guitar With Pick Bag And Belt</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-06 21:28:34', '2023-05-08 10:10:37'),
(105, 'Jbl Charge 5 Portable Waterproof Wireless Bluetooth Speaker', '108000.00', 'jbl.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl Charge 5 Portable Waterproof Wireless Bluetooth Speaker</h1>                                        ', 16, '1', 4, 1, 50, '1', '2023-03-08 09:03:27', '2023-05-08 10:10:37'),
(106, 'Jbl CHARGE 5 - Portable Bluetooth Speaker - Pink', '132000.00', 'jbl2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl CHARGE 5 - Portable Bluetooth Speaker - Pink</h1>                                        ', 16, '1', 4, 1, 50, '1', '2023-03-08 09:16:25', '2023-05-08 10:10:37'),
(107, 'Jbl Pulse 4 - Bluetooth Speaker With Light Show', '222000.00', 'jbl3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Jbl Pulse 4 - Bluetooth Speaker With Light Show</h1>                                        ', 16, '1', 4, 1, 50, '1', '2023-03-08 09:17:35', '2023-05-08 10:10:37'),
(108, 'LG 1 H.P Split Air Conditioner (S4UQ09WA5A2) - White', '219000.00', 'ac1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">LG 1 H.P Split Air Conditioner (S4UQ09WA5A2) - White</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-08 09:24:04', '2023-05-08 10:10:37'),
(109, 'Hisense 1.5HP LVS Split Unit Air Condition Copper Condenser Gold Fin', '226000.00', 'ac2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Hisense 1.5HP LVS Split Unit Air Condition Copper Condenser Gold Fin</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-08 09:25:02', '2023-05-08 10:10:37'),
(110, 'Challenge 6 Litre Portable Air Cooler/', '72000.00', 'ac3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Challenge 6 Litre Portable Air Cooler/</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-08 09:26:01', '2023-05-08 10:10:37'),
(111, 'Hisense 1HP Inverter Split Ac -100%Copper Condenser', '233000.00', 'ac4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Hisense 1HP Inverter Split Ac -100%Copper Condenser</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-08 09:26:58', '2023-05-08 10:10:37'),
(112, 'Haier Thermocool 1.5HP Air Conditioner Energy Saving', '240000.00', 'ac5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Haier Thermocool 1.5HP Air Conditioner Energy Saving</h1>                                        ', 1, '1', 4, 1, 50, '1', '2023-03-08 09:28:48', '2023-05-08 10:10:37'),
(113, 'XIAOMI A1 Plus, 6.52\" 4G LTE, 2GB/32GB Memory, Fingerprint, Face ID Recognition, Dual 8 MP, F/2.0, (wide)0.08 MP Camera - Black', '55000.00', 'xiomi.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">XIAOMI A1 Plus, 6.52\" 4G LTE, 2GB/32GB Memory, Fingerprint, Face ID Recognition, Dual 8 MP, F/2.0, (wide)0.08 MP Camera - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:32:23', '2023-05-08 10:10:37'),
(114, 'Vivo Y93s 6GB+128GB 6.2\'\' 13MP+2MP Camera Face Wake Dual SIM 4030mAh Smartphone - Red', '64000.00', 'vivo.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vivo Y93s 6GB+128GB 6.2\' 13MP+2MP Camera Face Wake Dual SIM 4030mAh Smartphone - Red</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:33:18', '2023-05-08 10:10:37'),
(115, 'Samsung Galaxy A03 - 6.5\"HD+ - 64GB ROM - 4GB RAM - 48MP - Dual SIM - 4G LTE - Facial Recognition, 5000mAh - Black', '77000.00', 'samsung.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy A03 - 6.5\"HD+ - 64GB ROM - 4GB RAM - 48MP - Dual SIM - 4G LTE - Facial Recognition, 5000mAh - Black</h1>                                        ', 2, '1', 4, 1, 50, '1', '2023-03-08 09:34:20', '2023-05-08 10:10:37'),
(116, 'itel S18 6.6\", 64GB ROM + 2GB RAM (UpTo 4GB), 5000mAh, 4G - Black', '57000.00', 'itel.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">itel S18 6.6\", 64GB ROM + 2GB RAM (UpTo 4GB), 5000mAh, 4G - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:46:09', '2023-05-08 10:10:37'),
(117, 'Tecno POP 5 Pro (BD4h) 6.52\" HD+, 2GB RAM + 32GB ROM, 6000mAh Battery, 8MP + 5MP Camera, 4G LTE, Android 11, Fingerprint -Cyan', '65000.00', 'techno.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Tecno POP 5 Pro (BD4h) 6.52\" HD+, 2GB RAM + 32GB ROM, 6000mAh Battery, 8MP + 5MP Camera, 4G LTE, Android 11, Fingerprint -Cyan</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:47:27', '2023-05-08 10:10:37'),
(118, 'Samsung Galaxy A04s - 6.5\" Android 12 (50/2/2)MP + 5MP Selfie - 4G LTE - Dual Sim - 5000mAh, 4GB/64GB Memory - Black', '92000.00', 'samsung2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy A04s - 6.5\" Android 12 (50/2/2)MP + 5MP Selfie - 4G LTE - Dual Sim - 5000mAh, 4GB/64GB Memory - Black</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:48:35', '2023-05-08 10:10:37'),
(119, 'Nikon D5300 DSLRR Camera With 18-55mm Lens', '340000.00', 'nikon001.jpeg', '<div class=\"-df -j-bet\" style=\"display: flex; justify-content: space-between; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14px;\"><div class=\"-fs0 -pls -prl\" style=\"padding-right: 24px; padding-left: 8px; font-size: 0px;\"><h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem;\">Nikon D5300 DSLRR Camera With 18-55mm Lens</h1></div><a id=\"wishlist\" href=\"https://www.jumia.com.ng/customer/account/login/?tkWl=NI889CM4JLCYVNAFAMZ-338119159&amp;return=%2Fnikon-d5300-dslrr-camera-with-18-55mm-lens-219937747.html\" class=\"btn _def _i _rnd -mas -fsh0 -me-start\" data-simplesku=\"NI889CM4JLCYVNAFAMZ-338119159\" data-track-onclick=\"wishlist\" data-track-onclick-bound=\"true\" style=\"text-decoration: none; color: rgb(246, 139, 30); border-radius: 0px; border: 0px; outline: 0px; font-family: Roboto, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-weight: 500; text-transform: uppercase; text-align: center; line-height: 1rem; font-size: 0.875rem; cursor: pointer; position: relative; text-indent: 8px; flex-shrink: 0; align-self: flex-start; margin: 8px;\"><svg aria-label=\"Add to wishlist\" viewBox=\"0 0 24 24\" class=\"ic -f-or5\" width=\"24\" height=\"24\"><use xlink:href=\"https://www.jumia.com.ng/assets_he/images/i-icons.5fc0e713.svg#saved-items\"></use></svg></a></div><div class=\"-phs\" style=\"padding-right: 8px; padding-left: 8px; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif; font-size: 14px;\"><br class=\"Apple-interchange-newline\"></div>                                        ', 18, '1', 4, 1, 50, '1', '2023-03-08 09:50:15', '2023-05-08 10:10:37'),
(120, 'Lenovo Xiaoxin K11 Pad 11inch 6GM RAM+ 128GB ROM WIFI Edition 7700Mah Tablet PC', '169000.00', 'pad1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Lenovo Xiaoxin K11 Pad 11inch 6GM RAM+ 128GB ROM WIFI Edition 7700Mah Tablet PC</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:58:02', '2023-05-08 10:10:37'),
(121, 'Nokia T20 -10.4â€ (4GB RAM, 64GB ROM) 8MP Camera - 5MP Selfie, LTE - 8200mAh - Ocean Blue', '135000.00', 'tab2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Nokia T20 -10.4â€ (4GB RAM, 64GB ROM) 8MP Camera - 5MP Selfie, LTE - 8200mAh - Ocean Blue</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:58:56', '2023-05-08 10:10:37');
INSERT INTO `products` (`product_id`, `name`, `price`, `pictures`, `details`, `category`, `available_for_installment`, `duration_of_payment`, `store_id`, `in_stock`, `visibility`, `created_at`, `updated_at`) VALUES
(122, 'Samsung Galaxy Tab A7 Lite, 8.7-Inch 3GB RAM, 32GB ROM Android 11 8MP + 2MP Nano SIM - Grey', '135000.00', 'tab3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A7 Lite, 8.7-Inch 3GB RAM, 32GB ROM Android 11 8MP + 2MP Nano SIM - Grey</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 09:59:58', '2023-05-08 10:10:37'),
(123, 'itel Pad 1 4G (P10001L) 10.1\" Screen, 4GB RAM + 128GB ROM, 6000mAh, Android 12, 5MP + 8MP Camera, 4G Tablet - Blue +Free Case', '110000.00', 'pad5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">itel Pad 1 4G (P10001L) 10.1\" Screen, 4GB RAM + 128GB ROM, 6000mAh, Android 12, 5MP + 8MP Camera, 4G Tablet - Blue +Free Case</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 10:00:57', '2023-05-08 10:10:37'),
(124, 'Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver', '185000.00', 'tab6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver</h1>                                        ', 3, '1', 4, 1, 50, '1', '2023-03-08 10:01:52', '2023-05-08 10:10:37'),
(125, 'Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver', '190000.00', 'foam1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Samsung Galaxy Tab A8, 10.5-Inch 3GB RAM, 32GB ROM Android 11 8MP + 5MP Nano SIM - Silver</h1>                                        ', 5, '1', 4, 1, 50, '1', '2023-03-08 10:54:00', '2023-05-08 10:10:37'),
(126, 'Vitafoam Grand Mattress 6 X 6 X 10 (Nationwide Delivery}', '145000.00', 'foam2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Grand Mattress 6 X 6 X 10 (Nationwide Delivery}</h1>                                        ', 5, '1', 4, 1, 50, '1', '2023-03-08 10:55:24', '2023-05-08 10:10:37'),
(127, 'Vitafoam Vita Grand Mattress 6x5x8 Inches (Nationwide Delivery)', '136000.00', 'foam3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Vita Grand Mattress 6x5x8 Inches (Nationwide Delivery)</h1>                                        ', 5, '1', 4, 1, 50, '1', '2023-03-08 10:56:23', '2023-05-08 10:10:37'),
(128, 'Vitafoam Spring Super Mattress 6x5x8 (Lagos Delivery Only)', '270000.00', 'foam4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Vitafoam Spring Super Mattress 6x5x8 (Lagos Delivery Only)</h1>                                        ', 5, '1', 4, 1, 50, '1', '2023-03-08 10:57:26', '2023-05-08 10:10:37'),
(129, '4.5*6*8 Vita Grand Mattress', '91000.00', 'foam5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">4.5*6*8 Vita Grand Mattress (Lagos, Ogun, Ibadan)</h1>                                        ', 5, '1', 4, 1, 50, '1', '2023-03-08 10:58:35', '2023-05-08 10:10:37'),
(130, 'Double King 205/65R15 Tyre', '33000.00', 'tyre1.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Double King 205/65R15 Tyre</h1>', 10, '1', 4, 1, 50, '1', '2023-03-11 11:15:06', '2023-05-08 10:10:37'),
(131, 'Maxxis 225 65R17 Rim 17', '79000.00', 'tyre2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Maxxis 225 65R17 Rim 17</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:16:24', '2023-05-08 10:10:37'),
(132, 'Michelin 225 50R17 (RIM 17)', '95000.00', 'tyre3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 225 50R17 (RIM 17)</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:19:31', '2023-05-08 10:10:37'),
(133, 'Michelin 245 45R18 (RIM 18) Long Flat', '126000.00', 'tyre4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 245 45R18 (RIM 18) Long Flat</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:20:25', '2023-05-08 10:10:37'),
(134, 'Michelin 245 50R20 (RIM 20)', '187000.00', 'tyre5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Michelin 245 50R20 (RIM 20)</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:21:19', '2023-05-08 10:10:37'),
(135, 'Austone 175 65R14', '30000.00', 'tyre6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Austone 175 65R14</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:22:21', '2023-05-08 10:10:37'),
(136, 'Double King 205/7015c', '40000.00', 'tyre6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Double King 205/7015c</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:23:12', '2023-05-08 10:10:37'),
(137, 'Dunlop 265/65 R17', '157000.00', 'tyre7.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Dunlop 265/65 R17</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:24:31', '2023-05-08 10:10:37'),
(138, 'West Lake 205 55R16', '28000.00', 'tyre8.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">West Lake 205 55R16</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:25:57', '2023-05-08 10:10:37'),
(139, 'Gt Radial GT RADAIL 23555R18 (RIM 18)', '62000.00', 'tyre9.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Gt Radial GT RADAIL 23555R18 (RIM 18)</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:36:21', '2023-05-08 10:10:37'),
(140, 'ES 300/330 Android Car Stereo Player With GPS Navigation, Bluetooth, SD, USB Slots Reverse Camera & Cam-box', '103000.00', 'car stereo.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">ES 300/330 Android Car Stereo Player With GPS Navigation, Bluetooth, SD, USB Slots Reverse Camera &amp; Cam-box</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:40:26', '2023-05-08 10:10:37'),
(141, 'Toyota HD Toyota Corolla 2003/2004/2005/2006~2007 Car Android Navigation Radio Player+Reverse Camera', '62000.00', 'car sterio2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota HD Toyota Corolla 2003/2004/2005/2006~2007 Car Android Navigation Radio Player+Reverse Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:42:51', '2023-05-08 10:10:37'),
(142, 'Toyota COROLLA 2003-2006 ANDROID NAVIGATION PLAYER WITH REVERSE CAMERA', '64000.00', 'sterio3.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota COROLLA 2003-2006 ANDROID NAVIGATION PLAYER WITH REVERSE CAMERA</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:44:14', '2023-05-08 10:10:37'),
(143, 'Toyota Corolla 2003 - 2007 Car Android GPS Navigation Stereo Radio Player With Camera', '63000.00', 'sterio4.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota Corolla 2003 - 2007 Car Android GPS Navigation Stereo Radio Player With Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:45:21', '2023-05-08 10:10:37'),
(144, 'Toyota Camry 2007 - 2011 8.5 Car Android Player With GPS Navigation, Bluetooth, SD, USB Slots + Reverse Camera', '63000.00', 'sterio5.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Toyota Camry 2007 - 2011 8.5 Car Android Player With GPS Navigation, Bluetooth, SD, USB Slots + Reverse Camera</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:46:11', '2023-05-08 10:10:37'),
(145, 'RAV 4 2008-2012 HD ANDROID NAVIGATION RADIO PLAYER', '68000.00', 'sterio6.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">RAV 4 2008-2012 HD ANDROID NAVIGATION RADIO PLAYER</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-11 11:47:28', '2023-05-08 10:10:37'),
(146, 'Mrc women styled abaya', '56000.00', 'abaya1c.jpeg,abaya1.jpeg,abaya1b.jpeg', '<div class=\"head col-md-12 col-lg-12 col-sm-9 floatl\" style=\"border: 0px; vertical-align: baseline; position: relative; min-height: 1px; float: left; width: 570px; color: rgb(48, 48, 48); font-family: Lato, sans-serif; font-size: 14px;\"><div class=\"heading floatl\" style=\"border: 0px; vertical-align: baseline; float: left;\"><p class=\"\">mrc styled abaya</p><div><br></div></div></div><div class=\"heading_heart col-lg-12 col-md-12 col-sm-11 col-xs-12 nopadding\" style=\"margin-bottom: 15px; border: 0px; vertical-align: baseline; position: relative; min-height: 1px; float: left; width: 570px; color: rgb(48, 48, 48); font-family: Lato, sans-serif; font-size: 14px;\"><div class=\"discount_old_price floatl\" style=\"margin-right: 20px; border: 0px; vertical-align: baseline; float: left;\"></div></div>', 7, '1', 4, 1, 50, '1', '2023-03-15 06:34:44', '2023-05-08 10:10:37'),
(147, 'Women Modest Middle East Large Loosed Kurti Abaya Muslim Dress With Headscarf', '32000.00', 'abaya2c.jpeg,abaya2b.jpeg,abaya2.jpeg', '<h1 class=\"-fs20 -pts -pbxs\" style=\"padding-top: 8px; padding-bottom: 4px; font-weight: 400; font-size: 1.25rem; color: rgb(40, 40, 40); font-family: Roboto, -apple-system, &quot;system-ui&quot;, &quot;Segoe UI&quot;, &quot;Helvetica Neue&quot;, Arial, sans-serif;\">Women Modest Middle East Large Loosed Kurti Abaya Muslim Dress With Headscarf&nbsp;</h1>                                        ', 7, '1', 4, 1, 50, '1', '2023-03-15 06:41:49', '2023-05-08 10:10:37'),
(148, 'Toyota Camry 2004 Blue', '1600000.00', 'camry1.jpeg,camry1a.jpeg,camry1c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Camry 2004 Blue</h1><p style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\"><br></p>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-17 16:26:44', '2023-05-08 10:10:37'),
(149, 'Toyota Matrix 2003 Silver', '1900000.00', 'matrix1a.jpeg,matrix1b.jpeg,matrix1c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Matrix 2003 Silver</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-17 16:43:29', '2023-05-08 10:10:37'),
(150, 'Toyota Camry 2008 Black', '2100000.00', 'camry20081a.jpeg,camry20081b.jpeg,camry20081c.jpeg', '<h1 itemprop=\"name\" style=\"-webkit-font-smoothing: antialiased; font-family: Roboto, sans-serif; color: rgb(48, 58, 75);\">Toyota Camry 2008 Black</h1>                                        ', 10, '1', 4, 1, 50, '1', '2023-03-17 16:46:38', '2023-05-08 10:10:37'),
(157, 'Iphone 13 - Pink', '600000.00', 'iphone-13.jpg', 'Iphone 13 - Pink', 3, '1', 4, 2, 50, '1', '2023-04-30 21:34:02', '2023-05-08 10:10:37');

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
  `deposited_at` timestamp NOT NULL DEFAULT current_timestamp()
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
  `target_amount` decimal(10,4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1' COMMENT '1-pending, 2-granted, 3-rejected',
  `requested_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `items_sold` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `agent_id`, `name`, `owner_name`, `owner_email`, `owner_phone`, `reg_no`, `items_sold`, `created_at`) VALUES
(1, 6, 'Demo Store', 'Roland Joshua', 'joshuaroland@gmail.com', '0906328976', 'ABC12345689', 0, '2023-04-28 21:11:16'),
(2, 6, 'Palmer Power', 'Shodiya Folorunsho', 'folushoayomide11@gmail.com', '07087857141', 'ABC23456798', 0, '2023-04-29 23:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `store_wallets`
--

CREATE TABLE `store_wallets` (
  `wallet_id` int(11) NOT NULL,
  `wallet_no` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `amount` decimal(10,4) NOT NULL DEFAULT 0.0000,
  `paid_for` int(11) DEFAULT 0 COMMENT 'day || week || month',
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
(3, 'Shodiya', 'Folorunsho', 'folushoayomide11@gmail.com', '07087857141', '$2y$10$gp.IzOy38jl/Aj4CNcnUreDWS3u/4rN.goRss4Tm7RAS8Ekzx3lvm', '1', '1', '2023-04-12 16:25:57', '2023-04-12 09:58:29');

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
-- Dumping data for table `users_addresses`
--

INSERT INTO `users_addresses` (`user_id`, `address_id`, `active`) VALUES
(3, 1, '1');

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `deposit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders_products`
--
ALTER TABLE `orders_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `savings_history`
--
ALTER TABLE `savings_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `savings_products`
--
ALTER TABLE `savings_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `savings_requests`
--
ALTER TABLE `savings_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `store_wallets`
--
ALTER TABLE `store_wallets`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
