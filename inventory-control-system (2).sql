-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2021 at 09:20 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory-control-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `memo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `memo`) VALUES
(1, 'Vegetables', 'potato, onion, etc. '),
(3, 'Meat & Seafood', 'beaf, porc, chicken'),
(4, 'Dairy, Eggs & Cheese', 'dairy foods'),
(5, 'Beverages', 'tea, coffee, soda, juice, Kool-Aid, hot chocolate, water, etc.'),
(6, 'Beer, Wine & Spirits', 'alcohol drink');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `product_number` varchar(255) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `sales_price` int(11) NOT NULL,
  `min_qty` int(11) NOT NULL,
  `max_qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `category_id`, `item_name`, `product_number`, `purchase_price`, `sales_price`, `min_qty`, `max_qty`) VALUES
(1, 1, 'Potato', 'Potato-1', 20, 50, 50, 80),
(2, 1, 'Onion', 'Onion-1', 10, 20, 30, 50),
(3, 3, 'Beaf', 'KOBE BEAF - 1 (qty=kg)', 3000, 5000, 5, 10),
(4, 3, 'Salmon', 'Salmon-Norway-001', 1500, 2000, 5, 10),
(5, 4, 'Eggs (12pcs)', 'eggs', 80, 150, 80, 100),
(6, 5, 'Green Tea', 'Shizuoka-green-tea', 200, 300, 30, 50),
(7, 6, 'Red Wine', 'Bourgogne-red', 5000, 8000, 30, 50),
(8, 6, 'White Wine', 'Bourgogne-white', 3500, 5000, 30, 50),
(9, 4, 'Milk', 'Milk-Hokkaido', 100, 150, 50, 100),
(10, 5, 'Coca cola 250ml', 'Coca cola 250ml', 60, 100, 50, 80);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `login_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT 'U'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`login_id`, `username`, `password`, `status`) VALUES
(1, 'jdoe_admin', '$2y$10$dIkCFeF6fsKlG/pj7OvbwOPmtykiDDAhO5yQYLPI63fqM3F2EVzD.', 'A'),
(2, 'test_user', '$2y$10$Mz/hb.i3EzPFTvUt7n6w1uHN1.Rsa8vTsipAE18qfQHBkyvfXYEoO', 'U'),
(3, 'test_user2', '$2y$10$dDHB8sKJhkoScGmO7zJWZuVU39h5MkA.rFaMbr5JwYwOdGQKnMp1a', 'U'),
(4, 'jsmith_admin', '$2y$10$gCjwJnsldn7MTfnsko/3EudfYoRa8BDEKvxBDjlbyTbYUubzGsJ1W', 'U'),
(6, 'jsmith', '$2y$10$mCUcJ/hsS.MxaHOO7tD7jevWyQ5Cl/cerNnaJrxO3RnMNo9hIkNk.', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `in_qty` int(11) NOT NULL,
  `not_received_qty` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'In Transit',
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `item_id`, `order_qty`, `in_qty`, `not_received_qty`, `status`, `order_date`) VALUES
(1, 1, 30, 30, 0, 'Received', '2021-07-21 08:46:08'),
(2, 1, 50, 50, 0, 'Received', '2021-07-21 09:11:01'),
(3, 2, 100, 80, 20, 'In Transit', '2021-07-21 11:43:46'),
(4, 3, 20, 10, 10, 'In Transit', '2021-07-27 13:54:36'),
(5, 1, 20, 0, 20, 'In Transit', '2021-07-27 13:56:08'),
(6, 4, 20, 0, 20, 'In Transit', '2021-07-27 14:56:22'),
(7, 5, 300, 0, 300, 'In Transit', '2021-07-27 14:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `stock_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `details` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `in_qty` int(11) NOT NULL,
  `out_qty` int(11) NOT NULL,
  `sum_qty` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`stock_id`, `item_id`, `details`, `order_number`, `in_qty`, `out_qty`, `sum_qty`, `date`) VALUES
(1, 1, 'Physical Inventory', '-', 20, 0, 20, '2021-07-21 08:24:34'),
(2, 2, 'Physical Inventory', '-', 10, 0, 10, '2021-07-21 08:45:27'),
(3, 1, 'Received', '1', 20, 0, 20, '2021-07-21 08:50:06'),
(4, 1, 'Received', '1', 10, 0, 10, '2021-07-21 11:41:48'),
(5, 2, 'Received', '3', 80, 0, 80, '2021-07-21 11:44:47'),
(6, 3, 'Physical Inventory', '-', 5, 0, 5, '2021-07-21 22:54:57'),
(7, 1, 'Received', '2', 25, 0, 25, '2021-07-21 22:56:01'),
(8, 2, 'Sales', '-', 0, 40, -40, '2021-07-21 22:56:27'),
(9, 1, 'Sales', '-', 0, 40, -40, '2021-07-24 00:10:25'),
(10, 1, 'Received', '2', 25, 0, 25, '2021-07-27 13:46:40'),
(11, 2, 'Sales', '-', 0, 20, -20, '2021-07-27 13:49:29'),
(12, 3, 'Received', '4', 10, 0, 10, '2021-07-27 13:56:56'),
(13, 4, 'Physical Inventory', '-', 5, 0, 5, '2021-07-27 14:48:00'),
(14, 5, 'Physical Inventory', '-', 0, 0, 0, '2021-07-27 14:54:47'),
(15, 6, 'Physical Inventory', '-', 0, 0, 0, '2021-07-27 14:55:03'),
(16, 7, 'Physical Inventory', '-', 0, 0, 0, '2021-07-27 14:55:22'),
(17, 8, 'Physical Inventory', '-', 0, 0, 0, '2021-07-27 14:55:35'),
(18, 9, 'Physical Inventory', '-', 0, 0, 0, '2021-07-27 14:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `department`, `login_id`) VALUES
(1, 'John', 'Doe (Admin)', 'Accounting', 1),
(2, 'test', 'user', 'Inventory', 2),
(3, 'test', 'user 2', 'Sales', 3),
(4, 'John', 'Smith (Admin)', 'Purchase', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `product_number` (`product_number`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`login_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`stock_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
