-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 30, 2025 at 09:49 AM
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
-- Database: `niki_mart`
--

-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `id` varchar(2) NOT NULL,
  `name` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`id`, `name`) VALUES
('01', 'Nikia'),
('02', 'Mahaa'),
('04', 'Junia'),
('4', 'Junia'),
('5', 'Litaa'),
('6', 'Jaja');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(3) NOT NULL,
  `id_voucher` char(6) DEFAULT NULL,
  `name` varchar(25) DEFAULT NULL,
  `unit_price` int(6) DEFAULT NULL,
  `stock` smallint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `id_voucher`, `name`, `unit_price`, `stock`) VALUES
(0, 'V02', 'NABATI KEJU', 2000, 37),
(1, 'V01', 'ABC ORANGE 525ML', 13500, -3),
(2, 'V01', 'I/F BISC.WNDRLND 300', 20900, 10),
(6, 'V01', 'Sunlight 250 ml', 9000, -25),
(7, NULL, 'HANDBODY MARINA', 20000, -74);

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` varchar(10) NOT NULL,
  `id_cashier` varchar(2) DEFAULT NULL,
  `total` int(8) NOT NULL,
  `pay` int(7) NOT NULL,
  `change_money` int(5) NOT NULL,
  `status` enum('completed','not completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `date`, `code`, `id_cashier`, `total`, `pay`, `change_money`, `status`) VALUES
(1, '2025-11-29 14:22:44', 'TRX0002', '02', 38900, 38900, 0, 'completed'),
(2, '2025-11-30 05:02:14', 'TRX0001', '01', 19300, 60000, 0, ''),
(4, '2025-11-30 04:14:55', 'TRX0003', '01', 20000, 20000, 0, 'completed'),
(5, '2025-11-30 01:54:09', 'TRX0004', '02', 128030, 0, 0, ''),
(6, '2025-11-30 02:28:23', 'TRX0005', '02', 8000, 8000, 0, 'completed'),
(7, '2025-11-30 03:16:12', 'TRX0006', '01', 6300, 0, 0, ''),
(8, '2025-11-30 04:07:41', 'TRX0007', '04', 144900, 150000, 5100, 'completed'),
(9, '2025-11-30 04:17:38', 'TRX0008', '01', 9450, 0, 0, ''),
(10, '2025-11-30 04:36:12', 'TRX0009', '01', 8000, 0, 0, ''),
(11, '2025-11-30 05:27:29', 'TRX0010', '04', 29260, 0, 0, ''),
(12, '2025-11-30 04:47:48', 'TRX0011', '01', 8000, 0, 0, ''),
(13, '2025-11-30 04:58:27', 'TRX0012', '02', 400, 0, 0, ''),
(14, '2025-11-30 05:10:42', 'TRX0013', '01', 400, 0, 0, ''),
(15, '2025-11-30 05:12:41', 'TRX0014', '01', 400, 0, 0, ''),
(16, '2025-11-30 05:13:36', 'TRX0015', '01', 9450, 0, 0, ''),
(17, '2025-11-30 05:20:56', 'TRX0016', '6', 100000, 0, 0, ''),
(18, '2025-11-30 07:04:01', 'TRX0017', '02', 12600, 12600, 0, 'completed'),
(19, '2025-11-30 07:15:07', 'TRX0018', '01', 0, 0, 0, ''),
(20, '2025-11-30 07:19:27', 'TRX0019', '01', 0, 0, 0, ''),
(21, '2025-11-30 07:22:21', 'TRX0020', '01', 0, 0, 0, ''),
(22, '2025-11-30 07:23:34', 'TRX0021', '01', 0, 0, 0, ''),
(23, '2025-11-30 07:27:04', 'TRX0022', '01', 0, 0, 0, ''),
(24, '2025-11-30 07:32:37', 'TRX0023', '01', 0, 0, 0, ''),
(25, '2025-11-30 07:40:46', 'TRX0024', '04', 400, 0, 0, ''),
(26, '2025-11-30 07:43:37', 'TRX0025', '01', 0, 0, 0, ''),
(27, '2025-11-30 07:47:36', 'TRX0026', '5', 400, 400, 0, 'completed'),
(28, '2025-11-30 07:48:03', 'TRX0027', '5', 2000000, 0, 0, ''),
(29, '2025-11-30 07:49:57', 'TRX0028', '5', 47250, 50000, 2750, 'completed'),
(30, '2025-11-30 07:57:11', 'TRX0029', '04', 100800, 0, 0, ''),
(31, '2025-11-30 07:58:12', 'TRX0030', '5', 12600, 0, 0, ''),
(32, '2025-11-30 08:01:24', 'TRX0031', '02', 72600, 0, 0, ''),
(33, '2025-11-30 08:19:22', 'TRX0032', '5', 126800, 128000, 1200, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id_transactions` int(3) NOT NULL,
  `id_product` int(3) NOT NULL,
  `unit_price` int(6) NOT NULL,
  `discount` double NOT NULL,
  `qty` int(5) NOT NULL,
  `sub_total` mediumint(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id_transactions`, `id_product`, `unit_price`, `discount`, `qty`, `sub_total`) VALUES
(1, 1, 5000, 30, 2, 18900),
(1, 2, 20900, 80, 5, 20900),
(2, 0, 1, 400, 80, 400),
(2, 1, 13500, 30, 2, 18900),
(4, 0, 1, 0, 0, 0),
(4, 7, 1, 20000, 0, 20000),
(5, 1, 12, 9450, 30, 113400),
(5, 2, 1, 14630, 30, 14630),
(6, 0, 1, 8000, 80, 8000),
(7, 6, 1, 6300, 30, 6300),
(8, 6, 23, 6300, 30, 144900),
(9, 1, 1, 9450, 30, 9450),
(10, 0, 1, 8000, 80, 8000),
(11, 2, 2, 14630, 30, 29260),
(12, 0, 1, 8000, 80, 8000),
(13, 0, 1, 400, 80, 400),
(14, 0, 1, 400, 80, 400),
(15, 0, 1, 400, 80, 400),
(16, 1, 1, 9450, 30, 9450),
(17, 7, 5, 20000, 0, 100000),
(18, 6, 2, 6300, 30, 12600),
(25, 0, 1, 400, 80, 400),
(27, 0, 1, 400, 80, 400),
(28, 7, 100, 20000, 0, 2000000),
(29, 1, 5, 9450, 30, 47250),
(30, 0, 2, 400, 80, 800),
(30, 7, 5, 20000, 0, 100000),
(31, 6, 2, 6300, 30, 12600),
(32, 6, 2, 6300, 30, 12600),
(32, 7, 3, 20000, 0, 60000),
(33, 0, 400, 80, 2, 800),
(33, 6, 6300, 30, 20, 126000);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` char(6) NOT NULL,
  `name` varchar(25) NOT NULL,
  `discount` double NOT NULL,
  `max_discount` int(7) NOT NULL,
  `expired` datetime NOT NULL,
  `status` enum('active','not_active','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `name`, `discount`, `max_discount`, `expired`, `status`) VALUES
('V01', 'Kemerdekaan', 30, 10000, '2025-11-30 23:00:19', 'active'),
('V02', 'Cuci Gudang', 80, 100000, '2025-11-30 21:04:19', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cashier`
--
ALTER TABLE `cashier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vouchers` (`id_voucher`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cashier` (`id_cashier`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id_transactions`,`id_product`),
  ADD UNIQUE KEY `id_transactions` (`id_transactions`,`id_product`),
  ADD KEY `fk_product` (`id_product`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_vouchers` FOREIGN KEY (`id_voucher`) REFERENCES `vouchers` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_cashier` FOREIGN KEY (`id_cashier`) REFERENCES `cashier` (`id`);

--
-- Constraints for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_transactions` FOREIGN KEY (`id_transactions`) REFERENCES `transactions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
