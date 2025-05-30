-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 08:54 AM
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
-- Database: `ac`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `warrantyid` varchar(128) NOT NULL,
  `fullname` varchar(256) NOT NULL,
  `nic` varchar(32) NOT NULL,
  `phone` varchar(16) NOT NULL,
  `address` text NOT NULL,
  `purdate` date NOT NULL,
  `modelid` int(64) DEFAULT NULL,
  `dealerid` int(11) DEFAULT NULL,
  `vat` varchar(50) DEFAULT NULL,
  `vat_no` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`warrantyid`, `fullname`, `nic`, `phone`, `address`, `purdate`, `modelid`, `dealerid`, `vat`, `vat_no`) VALUES
('WR-161420', 'ddv', 'vdvv', '0777674308', '432,araliya,pahalagama', '2025-05-22', 0, 100224, '0', '0'),
('WR-258111', 'sdsdsad', 'sdsdsd', '0777674308', 'sdsds', '2025-05-24', 0, 100224, '0', '0'),
('WR-294333', 'chathura', '2000000', '0777674308', 'aaa', '2025-05-17', 151, 100224, '', 'no'),
('WR-315626', 'kasun', '2000000000000', '0777674308', 'ddd', '2025-05-24', 0, 100224, '0', '0'),
('WR-381516', 'chathuri', '200000', '0777674308', 'aaadd', '2025-05-24', 0, 100224, '0', '0'),
('WR-385665', 'ccccc', 'cccc', '0777674308', 'sasacs', '2025-05-22', 141, 100224, '', 'no'),
('WR-418422', 'dv', 'vvvvvvvv', '0777674308', '432,araliya,pahalagama', '2025-05-22', 0, 100224, '0', '0'),
('WR-453560', 'samindya', '20002', '0777674308', 'ggg', '2025-05-24', 0, 100224, '0', '0'),
('WR-467877', 'ascscsac', 'sdsads', '0777674308', 'sdsds', '2025-05-08', 151, 100224, '', 'no'),
('WR-479097', 'chathurrr', '200000', '0777674308', 'dddd', '2025-05-24', 0, 100224, '0', '0'),
('WR-589849', 'cc', 'cc', '0777674308', 'xdfdf', '2025-05-24', 0, 100224, '0', '0'),
('WR-709042', 'chathura', '2000000', '0777674308', 'aaa', '2025-05-08', 140, 100224, '', 'no'),
('WR-786762', 'sdsdd', '1111111', '0777674308', 'scc', '2025-05-24', 0, 100224, '0', '0'),
('WR-861430', 'nimal', '198444545', '0777674308', 'paha;aga,a', '2025-05-12', 140, 100224, '', 'no'),
('WR-911991', 'ccc', 'cc', '0777674308', 'zz', '2025-05-21', 153, 100224, '', 'no'),
('WR-922091', 'sameera', '200000', '0777674308', 'adsdsd', '2025-05-24', 0, 100224, '0', '0'),
('WR-984429', 'xsxsa', '2000000', '0777674308', 'axaax', '2025-05-22', 0, 100224, '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `dealerid` int(11) NOT NULL,
  `modelid` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`dealerid`, `modelid`, `amount`) VALUES
(100223, 140, 9),
(100223, 153, 2),
(100225, 131, 7);

-- --------------------------------------------------------

--
-- Table structure for table `issue`
--

CREATE TABLE `issue` (
  `invoiceId` int(11) NOT NULL,
  `orderId` int(11) NOT NULL,
  `issuedBy` int(11) NOT NULL,
  `issueTime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `issue`
--

INSERT INTO `issue` (`invoiceId`, `orderId`, `issuedBy`, `issueTime`) VALUES
(18205, 18456, 100058, '2025-04-30 11:39:36'),
(18206, 18457, 100058, '2025-05-05 09:12:46'),
(18207, 18458, 100058, '2025-05-22 13:33:51');

-- --------------------------------------------------------

--
-- Table structure for table `issue_product_barcode`
--

CREATE TABLE `issue_product_barcode` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `qty` double DEFAULT NULL,
  `price` double DEFAULT NULL,
  `indoor_barcode` varchar(225) DEFAULT '',
  `outdoor_barcode` varchar(225) DEFAULT NULL,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issue_product_barcode`
--

INSERT INTO `issue_product_barcode` (`id`, `invoice_no`, `product_name`, `qty`, `price`, `indoor_barcode`, `outdoor_barcode`, `date`) VALUES
(2, 'INV/000026', 'Wholesale- Hisense Inverter 9000 BTU', 2, 0, '00001', NULL, '2025-05-21'),
(3, 'INV/000026', 'Wholesale- Hisense Inverter 9000 BTU', 2, 0, '00002', NULL, '2025-05-21'),
(4, 'INV/000026', 'Hisense Inverter 12000 BTU', 2, 0, '00003', NULL, '2025-05-21'),
(5, 'INV/000026', 'Hisense Inverter 12000 BTU', 2, 0, '00004', NULL, '2025-05-21'),
(6, 'INV000019', 'Wholesale- Hisense Inverter 9000 BTU', 1, 0, '12121212', NULL, '2025-05-21'),
(7, 'INV000019', 'Hisense Non Inverter 9000 BTU', 1, 0, '13131313', NULL, '2025-05-21'),
(8, 'INV/000031', 'Wholesale- Hisense Inverter 9000 BTU', 1, NULL, '78787878', NULL, '2025-05-21'),
(9, 'INV000016', 'Wholesale- Hisense Inverter 12000 BTU', 1, 0, '44444', '555555', '2025-05-22'),
(10, 'INV/000024', 'Wholesale- Hisense Inverter 9000 BTU', 1, 0, '4444', '45554', '2025-05-22'),
(11, 'INV/000024', 'Hisense Inverter 12000 BTU', 1, 0, '56565', '6555', '2025-05-22'),
(12, 'INV/000048', 'Wholesale- Hisense Inverter 12000 BTU', 1, 0, '122223233', '145454545', '2025-05-22'),
(13, 'INV/000049', 'Hisense Inverter 12000 BTU', 1, 0, '41111', '45545', '2025-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `id` int(11) NOT NULL,
  `warrantyid` varchar(128) NOT NULL,
  `contactname` varchar(256) NOT NULL,
  `contactno` varchar(16) NOT NULL,
  `techid` int(11) NOT NULL,
  `dealerid` int(11) NOT NULL,
  `jobtype` varchar(8) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0-nonapp, 1-pending, 2- completed',
  `timeadded` datetime NOT NULL,
  `timeapproved` datetime DEFAULT NULL,
  `timecompleted` datetime DEFAULT NULL,
  `addedby` int(11) NOT NULL,
  `approvedby` int(11) DEFAULT 0,
  `completedby` int(11) NOT NULL DEFAULT 0,
  `lastupdate` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `joblog`
--

CREATE TABLE `joblog` (
  `logid` int(11) NOT NULL,
  `jobid` int(11) NOT NULL,
  `description` text NOT NULL,
  `timeadded` datetime NOT NULL,
  `addedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maininventory`
--

CREATE TABLE `maininventory` (
  `modelid` int(11) NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `maininventory`
--

INSERT INTO `maininventory` (`modelid`, `amount`) VALUES
(131, -3),
(132, 5),
(139, 9),
(140, 92),
(141, 28),
(142, 12),
(143, 34),
(144, 117),
(145, 31),
(146, 15),
(147, 16),
(151, 115),
(152, 15),
(153, 10),
(154, 21),
(160, 116),
(161, 34),
(162, 15);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `orderid` int(11) NOT NULL,
  `modelid` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `amountissued` int(11) NOT NULL DEFAULT 0,
  `amountfree` int(11) NOT NULL DEFAULT 0,
  `unitprice` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderid`, `modelid`, `amount`, `amountissued`, `amountfree`, `unitprice`) VALUES
(19204, 18456, 131, 0, 10, 0, 165000.00),
(19206, 18457, 140, 0, 2, 0, 170000.00),
(19211, 18458, 140, 0, 10, 0, 170000.00),
(19212, 18458, 153, 0, 2, 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderid` int(11) NOT NULL,
  `dealerid` int(11) NOT NULL,
  `ordertime` int(11) NOT NULL,
  `addedby` int(11) NOT NULL,
  `issued` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-pending, 1-approved, 2-issued, 3-completed',
  `issuedtime` int(11) DEFAULT 0,
  `issuedby` int(11) NOT NULL DEFAULT 0,
  `lastupdate` int(11) NOT NULL DEFAULT 0,
  `section` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderid`, `dealerid`, `ordertime`, `addedby`, `issued`, `issuedtime`, `issuedby`, `lastupdate`, `section`) VALUES
(18456, 100225, 1746013046, 100058, 3, 1746013176, 100058, 1746013351, 1),
(18457, 100225, 1746436224, 100058, 2, 1746436366, 100058, 1746436366, 2),
(18458, 100223, 1747920765, 100058, 3, 1747920831, 100058, 1747920847, 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `perm_id` int(11) NOT NULL,
  `perm_type` varchar(255) DEFAULT NULL,
  `perm_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`perm_id`, `perm_type`, `perm_desc`) VALUES
(1, 'Orders', 'Add Order'),
(2, 'Orders', 'Edit Order'),
(3, 'Orders', 'Approve Order'),
(4, 'Orders', 'Issue Order'),
(5, 'Orders', 'Complete Order'),
(6, 'Orders', 'Cancel Order'),
(7, 'Job', 'Add Job'),
(8, 'Job', 'Update Job'),
(9, 'Job', 'Complete Job'),
(10, 'Reports', 'Inventory Report'),
(11, 'Reports', 'Pending Jobs Report'),
(12, 'Reports', 'Completed Jobs Report'),
(13, 'Reports', 'Order Details Report'),
(14, 'Reports', 'Sales Reports'),
(15, 'Reports', 'Issued Orders Report'),
(16, 'Reports', 'Pending Orders Report'),
(17, 'Reports', 'Approved Orders Report'),
(18, 'Reports', 'Completed Orders Report'),
(19, 'Reports', 'Orders Summary Report'),
(20, 'Products', 'Update Main Inventory'),
(21, 'Products', 'Manage Products'),
(22, 'Products', 'Manage Main Inventory'),
(23, 'Products', 'Inventory History'),
(24, 'People', 'Manage Dealers'),
(25, 'People', 'Manage Shops'),
(26, 'People', 'Manage Technicians'),
(27, 'People', 'Manage Sales Reps'),
(28, 'People', 'Manage Customers'),
(29, 'People', 'Manage Customers'),
(30, 'People', 'Manage Stores Keepers'),
(31, 'People', 'Manage Directors'),
(32, 'People', 'Manage Operators'),
(33, 'People', 'Manage Passwords'),
(34, 'Details', 'Non-Approved Jobs'),
(35, 'Details', 'Pending Jobs'),
(36, 'Details', 'Completed Jobs');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `model` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `timeadded` int(11) NOT NULL,
  `status` varchar(16) NOT NULL DEFAULT 'Active',
  `pricedefault` decimal(11,2) NOT NULL DEFAULT 0.00,
  `pricesilver` decimal(11,2) NOT NULL DEFAULT 0.00,
  `pricegold` decimal(11,2) NOT NULL DEFAULT 0.00,
  `priceplatinum` decimal(11,2) NOT NULL DEFAULT 0.00,
  `cmb` decimal(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `model`, `timeadded`, `status`, `pricedefault`, `pricesilver`, `pricegold`, `priceplatinum`, `cmb`) VALUES
(131, 'Wholesale- Hisense Inverter 9000 BTU', 1746002172, 'Active', 135000.00, 130000.00, 125000.00, 117000.00, 25.00),
(132, 'Wholesale- Hisense Inverter 12000 BTU', 1746002294, 'Active', 135000.00, 130000.00, 125000.00, 117000.00, 25.00),
(139, 'Hisense Inverter 9000 BTU', 1746166699, 'Active', 170000.00, 165000.00, 155000.00, 155000.00, 25.00),
(140, 'Hisense Inverter 12000 BTU', 1746166879, 'Active', 170000.00, 165000.00, 155000.00, 155000.00, 25.00),
(141, 'Hisense Inverter 18000 BTU', 1746166932, 'Active', 230000.00, 220000.00, 210000.00, 210000.00, 25.00),
(142, 'Hisense Inverter 24000 BTU', 1746166996, 'Active', 285000.00, 275000.00, 265000.00, 265000.00, 25.00),
(143, 'Hisense Non Inverter 9000 BTU', 1746167052, 'Active', 145000.00, 140000.00, 133000.00, 133000.00, 25.00),
(144, 'Hisense Non Inverter 12000 BTU', 1746167111, 'Active', 145000.00, 140000.00, 133000.00, 133000.00, 25.00),
(145, 'Hisense Non Inverter 18000 BTU', 1746167153, 'Active', 210000.00, 205000.00, 195000.00, 195000.00, 25.00),
(146, 'Hisense Non Inverter 24000 BTU', 1746167198, 'Active', 255000.00, 245000.00, 230000.00, 230000.00, 25.00),
(147, 'Hisense Inverter 9000 BTU Compressor', 1746170158, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(151, 'Hisense Inverter 12000 BTU Compressor', 1746170523, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(152, 'Hisense Inverter 18000 BTU Compressor', 1746170581, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(153, 'Hisense Inverter 24000 BTU Compressor', 1746170601, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(154, 'Hisense Non Inverter 9000 BTU Compressor', 1746170650, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(160, 'Hisense Non Inverter 12000 BTU Compressor', 1746170807, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(161, 'Hisense Non Inverter 18000 BTU Compressor', 1746170829, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00),
(162, 'Hisense Non Inverter 24000 BTU Compressor', 1746170857, 'Active', 0.00, 0.00, 0.00, 0.00, 25.00);

-- --------------------------------------------------------

--
-- Stand-in structure for view `product_inventory`
-- (See below for the actual view)
--
CREATE TABLE `product_inventory` (
`dealerid` int(11)
,`modelid` int(11)
,`amount` int(11)
,`model` varchar(128)
,`pricedefault` decimal(11,2)
,`id` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(7, 'Accountant'),
(2, 'Admin'),
(3, 'Dealer'),
(8, 'Director'),
(11, 'Operator'),
(4, 'Salesrep'),
(10, 'Shop'),
(6, 'Stores Keeper'),
(1, 'Super Admin'),
(5, 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `roles_permissions`
--

CREATE TABLE `roles_permissions` (
  `role_id` int(11) NOT NULL,
  `perm_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles_permissions`
--

INSERT INTO `roles_permissions` (`role_id`, `perm_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 34),
(2, 35),
(3, 34),
(3, 35),
(3, 36),
(4, 1),
(5, 7),
(5, 8),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(7, 6),
(7, 7),
(7, 8),
(7, 9),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(7, 14),
(7, 15),
(7, 16),
(7, 17),
(7, 18),
(7, 19),
(7, 20),
(7, 21),
(7, 22),
(7, 23),
(7, 24),
(7, 25),
(7, 26),
(7, 27),
(7, 28),
(7, 29),
(7, 30),
(7, 31),
(7, 32),
(7, 33),
(7, 34),
(7, 35),
(7, 36),
(9, 1),
(9, 2),
(11, 1),
(11, 2),
(11, 3),
(11, 4),
(11, 5),
(11, 6),
(11, 7),
(11, 8),
(11, 9),
(11, 10),
(11, 11),
(11, 12),
(11, 13),
(11, 14),
(11, 15),
(11, 16),
(11, 17),
(11, 18),
(11, 19),
(11, 20),
(11, 21),
(11, 22),
(11, 23),
(11, 24),
(11, 25),
(11, 26),
(11, 27),
(11, 28),
(11, 29),
(11, 30),
(11, 31),
(11, 32);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice`
--

CREATE TABLE `sales_invoice` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `net_total` double DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `invoice_date` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `cash` double DEFAULT 0,
  `card` double DEFAULT 0,
  `cheque` double DEFAULT 0,
  `online` double DEFAULT 0,
  `shop` varchar(50) DEFAULT '',
  `date1` date DEFAULT NULL,
  `date2` date DEFAULT NULL,
  `date3` date DEFAULT NULL,
  `issue` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_invoice`
--

INSERT INTO `sales_invoice` (`id`, `invoice_no`, `total`, `discount`, `net_total`, `balance`, `customer_name`, `invoice_date`, `cash`, `card`, `cheque`, `online`, `shop`, `date1`, `date2`, `date3`, `issue`) VALUES
(1, 'inv/', 10000, 0, 10000, 0, 'chathuara', '2025-05-22 06:27:12', 1000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(2, 'Array', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 135000, 0, 0, NULL, NULL, NULL, NULL, 0),
(3, '', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 135000, 0, 0, NULL, NULL, NULL, NULL, 0),
(4, '', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 135000, 0, 0, NULL, NULL, NULL, NULL, 0),
(5, '', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 135000, 0, 0, NULL, NULL, NULL, NULL, 0),
(6, 'INV/000006', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 135000, 0, 0, NULL, NULL, NULL, NULL, 0),
(7, 'INV/000007', 170000, 0, 170000, 0, 'ccc', '2025-05-22 06:27:12', 160000, 160000, 0, 0, NULL, NULL, NULL, NULL, 0),
(8, 'INV/000007', 170000, 0, 170000, 0, 'ccc', '2025-05-22 06:27:12', 160000, 160000, 0, 0, NULL, NULL, NULL, NULL, 0),
(9, 'INV/000009', 210000, 0, 210000, 0, 'nimal', '2025-05-22 06:27:12', 200000, 10000, 0, 0, NULL, NULL, NULL, NULL, 0),
(10, 'INV/000010', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(11, 'INV/000010', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(12, 'INV/000012', 170000, 0, 170000, 0, 'nimal', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(13, 'INV/000012', 170000, 0, 170000, 0, 'nimal', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(14, 'INV/000014', 135000, 0, 135000, 0, 'nimal', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(15, 'INV/000015', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(16, 'INV000016', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(17, 'INV000016', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(18, 'INV000018', 365000, 0, 365000, 0, 'ascscsac', '2025-05-22 06:27:12', 360000, 5000, 0, 0, NULL, NULL, NULL, NULL, 0),
(19, 'INV000019', 280000, 0, 280000, 0, 'chathura', '2025-05-22 06:27:12', 280000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(20, 'INV/000020', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(21, 'INV/000021', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(22, 'INV/000022', 0, 0, 0, 0, 'chathura sudarshana', '2025-05-22 06:27:12', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(23, 'INV/000023', 275000, 0, 275000, 0, 'nimal', '2025-05-22 06:27:12', 0, 0, 275000, 0, NULL, NULL, NULL, NULL, 0),
(24, 'INV/000024', 305000, 0, 305000, 0, 'nimal', '2025-05-22 08:07:06', 305000, 0, 0, 0, NULL, NULL, NULL, NULL, 1),
(25, 'INV/000025', 270000, 0, 270000, 0, 'ccccc', '2025-05-22 06:27:12', 270000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(26, 'INV/000026', 610000, 0, 610000, 0, 'nimal', '2025-05-22 06:27:12', 610000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(27, 'INV/000027', 170000, 0, 170000, 0, 'chathura', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(28, 'INV/000027', 170000, 0, 170000, 0, 'chathura', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(29, 'INV/000027', 170000, 0, 170000, 0, 'chathura', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(30, 'INV/000030', 170000, 0, 170000, 0, 'nimal', '2025-05-22 06:27:12', 170000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(31, 'INV/000031', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(32, 'INV/000032', 135000, 0, 135000, 0, 'nimal', '2025-05-22 06:27:12', 0, 0, 0, 0, NULL, NULL, NULL, NULL, 0),
(33, 'INV/000033', 135000, 0, 135000, 0, 'chathura', '2025-05-22 06:27:12', 135000, 0, 0, 0, 'admin2', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(34, 'INV/000034', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100226', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(35, 'INV/000034', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100226', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(36, 'INV/000036', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(37, 'INV/000036', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(39, 'INV/000036', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(43, 'INV/000040', 135000, 0, 135000, 0, 'nimal', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(44, 'INV/000044', 135000, 0, 135000, 0, 'chathura', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(45, 'INV/000045', 135000, 0, 135000, 0, 'chathura', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100058', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(46, 'INV/000046', 135000, 0, 135000, 0, 'chathura', '2025-05-21 18:30:00', 135000, 0, 0, 0, '100225', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(47, 'INV/000047', 135000, 0, 135000, 0, 'ascscsac', '2025-05-21 18:30:00', 130000, 5000, 0, 0, '100223', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(48, 'INV/000048', 135000, 0, 135000, 0, 'ccccc', '2025-05-22 13:36:34', 135000, 0, 0, 0, '100223', '2025-05-22', '2025-08-22', '2025-11-22', 1),
(49, 'INV/000049', 170000, 0, 170000, 0, 'chathura', '2025-05-22 13:38:24', 170000, 0, 0, 0, '100058', '2025-05-22', '2025-08-22', '2025-11-22', 1),
(50, 'INV/000050', 170000, 0, 170000, 0, 'chathura', '2025-05-21 18:30:00', 170000, 0, 0, 0, '100223', '2025-05-22', '2025-08-22', '2025-11-22', 0),
(51, 'INV/000051', 135000, 0, 135000, 0, 'chathurrr', '2025-05-23 18:30:00', 135000, 0, 0, 0, '100223', '2025-05-24', '2025-08-24', '2025-11-24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_invoice_item`
--

CREATE TABLE `sales_invoice_item` (
  `id` int(11) NOT NULL,
  `invoice_no` varchar(50) DEFAULT NULL,
  `item_id` varchar(20) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `sub_total` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_invoice_item`
--

INSERT INTO `sales_invoice_item` (`id`, `invoice_no`, `item_id`, `item_name`, `qty`, `price`, `discount`, `sub_total`) VALUES
(1, 'inv/1', '22', 'who', 1, 10000, 0, 10000),
(2, 'INV000016', '132', 'Wholesale- Hisense Inverter 12000 BTU', 1, 135000, 0, 135000),
(3, 'INV000018', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(4, 'INV000018', '141', 'Hisense Inverter 18000 BTU', 1, 230000, 0, 230000),
(5, 'INV000019', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(6, 'INV000019', '143', 'Hisense Non Inverter 9000 BTU', 1, 145000, 0, 145000),
(7, 'INV/000020', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(8, 'INV/000021', '132', 'Wholesale- Hisense Inverter 12000 BTU', 1, 135000, 0, 135000),
(9, 'INV/000023', '132', 'Wholesale- Hisense Inverter 12000 BTU', 1, 135000, 5000, 130000),
(10, 'INV/000023', '144', 'Hisense Non Inverter 12000 BTU', 1, 145000, 0, 145000),
(11, 'INV/000024', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(12, 'INV/000024', '140', 'Hisense Inverter 12000 BTU', 1, 170000, 0, 170000),
(13, 'INV/000025', '131', 'Wholesale- Hisense Inverter 9000 BTU', 2, 135000, 0, 270000),
(14, 'INV/000026', '131', 'Wholesale- Hisense Inverter 9000 BTU', 2, 135000, 0, 270000),
(15, 'INV/000026', '140', 'Hisense Inverter 12000 BTU', 2, 170000, 0, 340000),
(16, 'INV/000027', '139', 'Hisense Inverter 9000 BTU', 1, 170000, 0, 170000),
(17, 'INV/000027', '139', 'Hisense Inverter 9000 BTU', 1, 170000, 0, 170000),
(18, 'INV/000027', '139', 'Hisense Inverter 9000 BTU', 1, 170000, 0, 170000),
(19, 'INV/000030', '140', 'Hisense Inverter 12000 BTU', 1, 170000, 0, 170000),
(20, 'INV/000031', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(21, 'INV/000032', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(22, 'INV/000033', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(23, 'INV/000034', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(24, 'INV/000034', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(25, 'INV/000036', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(26, 'INV/000036', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(28, 'INV/000036', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(32, 'INV/000040', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(33, 'INV/000044', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(34, 'INV/000045', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(35, 'INV/000046', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(36, 'INV/000047', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000),
(37, 'INV/000048', '132', 'Wholesale- Hisense Inverter 12000 BTU', 1, 135000, 0, 135000),
(38, 'INV/000049', '140', 'Hisense Inverter 12000 BTU', 1, 170000, 0, 170000),
(39, 'INV/000050', '140', 'Hisense Inverter 12000 BTU', 1, 170000, 0, 170000),
(40, 'INV/000051', '131', 'Wholesale- Hisense Inverter 9000 BTU', 1, 135000, 0, 135000);

-- --------------------------------------------------------

--
-- Table structure for table `topup`
--

CREATE TABLE `topup` (
  `topupid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `topupdate` date NOT NULL,
  `addedtime` datetime NOT NULL,
  `note` text NOT NULL,
  `addedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `topup`
--

INSERT INTO `topup` (`topupid`, `productid`, `quantity`, `topupdate`, `addedtime`, `note`, `addedby`) VALUES
(600, 132, 100, '2025-04-30', '2025-04-30 14:28:55', '', 100058),
(601, 131, 100, '2025-04-30', '2025-04-30 16:25:59', '', 100058),
(602, 140, 105, '2025-05-02', '2025-05-02 13:16:48', '', 100058),
(603, 151, 105, '2025-05-02', '2025-05-02 13:16:48', '', 100058),
(604, 139, 10, '2025-05-02', '2025-05-02 13:21:45', '', 100058),
(605, 151, 10, '2025-05-02', '2025-05-02 17:31:17', '', 100058),
(606, 140, 115, '2025-05-02', '2025-05-02 17:33:09', '', 100058),
(607, 140, 115, '2025-05-02', '2025-05-02 17:33:28', 'rr', 100058),
(608, 140, 335, '2025-05-02', '2025-05-02 17:34:40', 'ee', 100058),
(609, 131, 100, '2025-05-02', '2025-05-02 17:35:22', 'ee', 100058),
(610, 131, 10, '2025-05-02', '2025-05-02 17:35:53', 'rr', 100058),
(611, 132, 100, '2025-05-02', '2025-05-02 17:36:07', 'qw', 100058),
(612, 139, 10, '2025-05-02', '2025-05-02 17:36:57', 'ee', 100058),
(613, 151, 115, '2025-05-02', '2025-05-02 17:39:27', 'er', 100058),
(614, 140, 105, '2025-05-02', '2025-05-02 17:43:57', '', 100058),
(615, 151, 105, '2025-05-02', '2025-05-02 17:44:32', 'er', 100058),
(616, 152, 18, '2025-05-02', '2025-05-02 17:45:46', 'er', 100058),
(617, 152, 15, '2025-05-02', '2025-05-02 17:46:19', 'er', 100058),
(618, 142, 10, '2025-05-02', '2025-05-02 17:46:59', 'ere', 100058),
(619, 162, 10, '2025-05-02', '2025-05-02 17:47:30', 'erre', 100058),
(620, 152, 13, '2025-05-02', '2025-05-02 17:48:31', 'errr', 100058),
(621, 152, 2, '2025-05-02', '2025-05-02 17:49:28', 'err', 100058),
(622, 152, 4, '2025-05-02', '2025-05-02 17:49:49', 'erre', 100058),
(623, 152, 15, '2025-05-02', '2025-05-02 17:54:07', 'rr', 100058),
(624, 141, 18, '2025-05-02', '2025-05-02 17:54:22', 'erer', 100058),
(625, 152, 18, '2025-05-02', '2025-05-02 17:56:11', 'er', 100058),
(626, 160, 15, '2025-05-02', '2025-05-02 17:57:34', 'er', 100058),
(627, 154, 15, '2025-05-02', '2025-05-02 17:58:02', 'er', 100058),
(628, 144, 115, '2025-05-02', '2025-05-02 17:58:35', 'wer', 100058),
(629, 144, 115, '2025-05-02', '2025-05-02 18:00:51', 'wwe', 100058),
(630, 144, 116, '2025-05-02', '2025-05-02 18:01:10', 'erer', 100058),
(631, 160, 116, '2025-05-02', '2025-05-02 18:01:45', 'ere', 100058),
(632, 161, 12, '2025-05-02', '2025-05-02 18:04:51', 'sa', 100058),
(633, 161, 2, '2025-05-02', '2025-05-02 18:05:12', 'we', 100058),
(634, 161, 1, '2025-05-02', '2025-05-02 18:05:27', 'dd', 100058),
(635, 145, 12, '2025-05-02', '2025-05-02 18:05:42', 'wed', 100058),
(636, 146, 10, '2025-05-02', '2025-05-02 18:06:02', 'df', 100058),
(637, 143, 15, '2025-05-02', '2025-05-02 18:06:35', 'ser', 100058),
(638, 153, 10, '2025-05-02', '2025-05-02 18:07:03', 'fg', 100058),
(639, 139, 10, '2025-05-02', '2025-05-02 18:07:18', 'fgg', 100058),
(640, 147, 10, '2025-05-02', '2025-05-02 18:07:36', 'add', 100058),
(641, 160, 115, '2025-05-02', '2025-05-02 18:15:58', 'we', 100058),
(642, 160, 100, '2025-05-02', '2025-05-02 18:16:56', 'asd', 100058),
(643, 160, 84, '2025-05-02', '2025-05-02 18:17:22', 'za', 100058),
(644, 160, 164, '2025-05-02', '2025-05-02 18:17:41', 'sd', 100058),
(645, 160, 164, '2025-05-02', '2025-05-02 18:18:01', 'ssd', 100058),
(646, 160, 116, '2025-05-02', '2025-05-02 18:18:24', 'assdd', 100058),
(647, 142, 12, '2025-05-02', '2025-05-02 18:26:37', 'ftgh', 100058),
(648, 142, 10, '2025-05-02', '2025-05-02 18:26:57', 'gh', 100058),
(649, 153, 2, '2025-05-02', '2025-05-02 18:27:34', 'hjjk', 100058),
(650, 154, 6, '2025-05-02', '2025-05-02 18:28:16', 'jk', 100058),
(651, 147, 6, '2025-05-02', '2025-05-02 18:29:11', 'hj', 100058),
(652, 143, 19, '2025-05-02', '2025-05-02 18:30:14', 'hj', 100058),
(653, 145, 19, '2025-05-02', '2025-05-02 18:30:46', 'hl', 100058),
(654, 161, 19, '2025-05-02', '2025-05-02 18:31:03', 'jk', 100058),
(655, 162, 5, '2025-05-02', '2025-05-02 18:33:01', 'hj', 100058),
(656, 162, 5, '2025-05-02', '2025-05-02 18:33:21', 'hj', 100058),
(657, 146, 5, '2025-05-02', '2025-05-02 18:33:47', 'hjk', 100058),
(658, 162, 5, '2025-05-02', '2025-05-02 18:34:04', 'kjl', 100058),
(659, 144, 118, '2025-05-02', '2025-05-02 18:35:32', 'fthj', 100058),
(660, 144, 117, '2025-05-02', '2025-05-02 18:35:48', 'jk', 100058),
(661, 151, 10, '2025-05-22', '2025-05-22 19:01:17', '', 100058),
(662, 141, 10, '2025-05-22', '2025-05-22 19:01:17', '', 100058),
(663, 132, 5, '2025-05-22', '2025-05-22 19:01:17', '', 100058);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `fullname` varchar(256) NOT NULL,
  `shopname` varchar(128) NOT NULL,
  `nic` varchar(32) NOT NULL,
  `address` tinytext NOT NULL,
  `phone1` varchar(16) NOT NULL,
  `phone2` varchar(16) NOT NULL,
  `area` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `usertype` varchar(32) NOT NULL,
  `addedby` int(11) NOT NULL,
  `pricing` varchar(16) NOT NULL DEFAULT 'default',
  `repid` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `shopname`, `nic`, `address`, `phone1`, `phone2`, `area`, `email`, `usertype`, `addedby`, `pricing`, `repid`, `role_id`) VALUES
(1, 'admin', '$2y$10$1mpw81BYz1cj.RAq4t482.RoGC/J8RtP0r8mGL1vq.wdabEp5PulO', 'System Admin', '', '', 'No 210-A,\r\nNegombo Road,\r\nVeyangoda', '0719096822', '0703215122', '', 'sameera.d.weerathunga@gmail.com', 'admin', 0, 'default', 0, 2),
(100047, 'Dharmasiri', '$2y$10$7bmg/HKxLSRuO6aB6W1CMeG8Xwj1qiy0uhrOboo.ur4La0dJMbbVC', 'Director', 'jjj', 'jjj', 'jjj', '0000000000', '0000000000', 'Nuwaraeliya', '', 'admin', 1, 'default', 0, 2),
(100048, 'sampath', '$2y$10$LkcTyH5zfr1Erf9G7kNeHeKYYgr3m1L.LKGr7.WaS9DNYfz2f91FG', 'Director', 'jjj', 'jjj', 'jjj', '0000000000', '0000000000', 'Nuwaraeliya', '', 'admin', 1, 'default', 0, 2),
(100049, 'Daminda', '$2y$10$w.6KY6FkVCw/oPCQgIZfkOs7Qw/fCKo3fLshK9RXkdjqXDw6N0ryO', 'Director', 'jjj', 'jjj', 'jjj', '0000000000', '0000000000', 'Nuwaraeliya', '', 'admin', 1, 'default', 0, 2),
(100053, 'Dhammika', '$2y$10$gwo5lzsRH4qgkHWKkJOd1.GqVXmuxF6ORdB9Lh.OWFPFaLF0Uz/Sm', 'Director', 'jjj', 'jjj', 'jjj', '0000000000', '0000000000', 'Nuwaraeliya', '', 'admin', 1, 'default', 0, 2),
(100058, 'sysadmin', '$2y$10$dyAcjJv80EJFbrNmB0mQjODMBIGtu7BXHI0CYnvK30l26AVEq7u1y', 'admin2', 'admin2', '953633231v', '', '', '', '', '', 'admin', 0, 'default', 0, 2),
(100223, 'achouse', '$2y$10$rkvi3cgMQCSk.o/VbSK9/.BU5WzWP3Gv3ktO7vJ0XZ55MAtd9joSa', 'Sameera Dilshan Weerathunga', 'AC House - Ja ela', '882311132v', 'No 170/E/1 Lokilangamuwa\r\nkotugoda', '0777750582', '0777750582', 'Gampaha', '', 'dealer', 100058, 'default', 0, 3),
(100224, 'Globalstar', '$2y$10$G2Bmta6We0CqSGlkWyKdTeoVv31fHgPQdSH6xSa5nOs1di//RC32u', 'Ravindi', 'Global Star Mark Pvt Ltd', '200478300228', 'No:115/6, Horahena Road,\r\nRukmale, Pannipitiya', '0000000001', '0755216725', 'Colombo', 'wkshachinisewmini@gmail.com', 'shop', 100058, 'default', 0, 10),
(100225, 'Aircooler', '$2y$10$KiAuC0o6Efh2IpBiYGO1y.8jybmsRRGy6UpyextqnX3yZk3F6tApC', 'Dimuth Perera', 'D&amp;S Air Cooler &amp; Electronics Pvt Ltd', '872191232V', '4/A, Horahena, Hokandara', '0000000002', '0769980619', 'Colombo', '', 'shop', 100058, 'default', 0, 10),
(100226, 'Kandyshop', '$2y$10$ef0XPkR74OKElbL6avptCeFXeFumy/aEI89Yl60xacZWCTJgZXVBy', 'Roshan Madushanka', 'Kandy Shop', '980902080V', 'No:16/1/A,Polgolla,Gangewaththa', '0000000003', '0778879306', 'Kandy', '', 'shop', 100058, 'default', 0, 10),
(100227, 'Buddhika', '$2y$10$m5ouXibkpNpO0ZFPg8.PfO6lcKUckSyVCEPF30g0nIejFsue.8kGq', 'Buddhika', '', '1111111111111111111111', 'Colombo', '0718824614', '0718824614', 'Colombo', '', 'technician', 100058, 'default', 0, 5),
(100230, 'Prasad', '$2y$10$zj2qVV3j3vfXmlYT3ZmWXe5YBWn511.bnS.gmIf2Gj1OpMfMSde0S', 'Prasad Indika', '', '22222222222222222222', 'Colombo', '0771881550', '0771881550', 'Colombo', '', 'technician', 100058, 'default', 0, 5),
(100231, 'Sampathh', '$2y$10$dsUe9IH2VxXWNmY3A3CcG.QVXkw9i2iYIfXirRwKmoBzwthwZM/KC', 'Sampath', '', '22222222222222222222', 'Colombo', '0776070906', '0776070906', 'Colombo', '', 'technician', 100058, 'default', 0, 5),
(100232, 'Safeek', '$2y$10$fL/eoKCO5R6Sk5.qW7T7d.OdJaIr/VRFW9QOT6Eb3q9/oGdt4.Hp6', 'Safeek', '', '22222222222222222222', 'Colombo', '0755099032', '0755099032', 'Colombo', '', 'technician', 100058, 'default', 0, 5),
(100233, 'Dimuthu', '$2y$10$98dhgxaYy5XEeBtaMCeyhOuU5IS4mprc3ZdXYuGu4Yje.3hX4NyPa', 'Dimuthu', '', '0715739163', 'Colombo', '0715739163', '0715739163', 'Colombo', '', 'technician', 100058, 'default', 0, 5),
(100234, 'Sivarasa', '$2y$10$.1qiVed0Gn3CdfQzsfObjOzijVhaJ5mQX3TOSlqrWlM5KZ88flG26', 'Sivarasa Thavaseelan', 'Sivarasa Thavaseelan', '885646734V', 'Peraelai,Pallai,Kilinochchi', '0767011917', '0779672399', 'Kilinochchi', '', 'shop', 100058, 'gold', 0, 10),
(100235, 'Matheesh', '$2y$10$Noslkcz6QILGWbdUUsqsc.wQWKkJZPC/LKK0HloNTaPIF9j8DWn46', 'Matheesh', 'Matheesh', '22222222222222222222', 'Rukmale', '1111111111', '0771881550', 'Colombo', '', 'shop', 100058, 'platinum', 0, 10);

-- --------------------------------------------------------

--
-- Structure for view `product_inventory`
--
DROP TABLE IF EXISTS `product_inventory`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `product_inventory`  AS SELECT `inventory`.`dealerid` AS `dealerid`, `inventory`.`modelid` AS `modelid`, `inventory`.`amount` AS `amount`, `product`.`model` AS `model`, `product`.`pricedefault` AS `pricedefault`, `product`.`id` AS `id` FROM (`inventory` join `product`) WHERE `product`.`id` = `inventory`.`modelid` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`warrantyid`),
  ADD KEY `model` (`modelid`),
  ADD KEY `customer_ibfk_2` (`dealerid`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`dealerid`,`modelid`),
  ADD KEY `dealerid` (`dealerid`),
  ADD KEY `modelid` (`modelid`);

--
-- Indexes for table `issue`
--
ALTER TABLE `issue`
  ADD PRIMARY KEY (`invoiceId`);

--
-- Indexes for table `issue_product_barcode`
--
ALTER TABLE `issue_product_barcode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warrantyid` (`warrantyid`),
  ADD KEY `techid` (`techid`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `joblog`
--
ALTER TABLE `joblog`
  ADD PRIMARY KEY (`logid`),
  ADD KEY `jobid` (`jobid`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `maininventory`
--
ALTER TABLE `maininventory`
  ADD PRIMARY KEY (`modelid`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orderitems_ibfk_1` (`orderid`),
  ADD KEY `orderitems_ibfk_2` (`modelid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderid`),
  ADD KEY `dealerid` (`dealerid`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`perm_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`),
  ADD UNIQUE KEY `role_name` (`role_name`);

--
-- Indexes for table `roles_permissions`
--
ALTER TABLE `roles_permissions`
  ADD PRIMARY KEY (`role_id`,`perm_id`);

--
-- Indexes for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_invoice_item`
--
ALTER TABLE `sales_invoice_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topup`
--
ALTER TABLE `topup`
  ADD PRIMARY KEY (`topupid`),
  ADD KEY `productid` (`productid`),
  ADD KEY `addedby` (`addedby`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `issue`
--
ALTER TABLE `issue`
  MODIFY `invoiceId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18208;

--
-- AUTO_INCREMENT for table `issue_product_barcode`
--
ALTER TABLE `issue_product_barcode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20770;

--
-- AUTO_INCREMENT for table `joblog`
--
ALTER TABLE `joblog`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `maininventory`
--
ALTER TABLE `maininventory`
  MODIFY `modelid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19213;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18459;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `perm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sales_invoice`
--
ALTER TABLE `sales_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `sales_invoice_item`
--
ALTER TABLE `sales_invoice_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `topup`
--
ALTER TABLE `topup`
  MODIFY `topupid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=664;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100236;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`dealerid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`modelid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`warrantyid`) REFERENCES `customer` (`warrantyid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_ibfk_2` FOREIGN KEY (`techid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `job_ibfk_3` FOREIGN KEY (`addedby`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `joblog`
--
ALTER TABLE `joblog`
  ADD CONSTRAINT `joblog_ibfk_1` FOREIGN KEY (`jobid`) REFERENCES `job` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `joblog_ibfk_2` FOREIGN KEY (`addedby`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `maininventory`
--
ALTER TABLE `maininventory`
  ADD CONSTRAINT `maininve_ibfk_2` FOREIGN KEY (`modelid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`orderid`) REFERENCES `orders` (`orderid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`modelid`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`dealerid`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`addedby`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topup`
--
ALTER TABLE `topup`
  ADD CONSTRAINT `topup_ibfk_1` FOREIGN KEY (`productid`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `topup_ibfk_2` FOREIGN KEY (`addedby`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
