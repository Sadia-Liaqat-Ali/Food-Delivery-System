-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2025 at 12:10 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodsystemdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblrestaurants_delivery`
--

CREATE TABLE `tblrestaurants_delivery` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` enum('restaurant','rider') DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrestaurants_delivery`
--

INSERT INTO `tblrestaurants_delivery` (`id`, `name`, `type`, `contact`, `address`, `status`, `created_at`, `password`) VALUES
(1, 'Vings Foods Imp', 'restaurant', '+923456788098', 'Punjab Attock', 'open', '2025-06-22 00:37:23', '12345'),
(2, 'Ali Baba Resturant', 'restaurant', '12345', 'Lahore Punjab Street 2 chock farmoli', 'active', '2025-06-22 00:57:01', 'ali baba'),
(3, 'Multani Dera', 'restaurant', '12345', 'Bazaar Chowk, Multan', 'active', '2025-06-22 21:45:49', 'Multani Dera');

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `user_type` enum('admin','customer','rider') NOT NULL,
  `verification_code` varchar(6) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `name`, `email`, `password`, `mobile`, `address`, `user_type`, `verification_code`, `is_verified`, `created_at`) VALUES
(8, 'Sadia', 'sadia@gmail.com', '$2y$10$EZmnyH.QBzXV5Z8miiuoT.Y4ljhT5hLfxvWJ12jswtHKB5pgje2PC', '12345', 'PWD Mareee Road', 'customer', '458042', 0, '2025-08-19 21:12:17'),
(10, 'Diya Shezadi', 'diya@gmail.com', '$2y$10$b/9POGGOT.RMfOqwSgiGIu/btdORe4aBcyWOjuEh3pgvbQT1ClaQ2', '123456', 'Attock', 'customer', '845400', 0, '2025-08-19 21:19:21'),
(11, 'Ahmad', 'user@gmail.com', '$2y$10$E/Kv0QAGQCte4wy0TH0ZBOi725oFr9PrCT3XL9POtWp80GL94FTCm', '123456', 'PWD islamabad', 'rider', '263764', 0, '2025-08-19 21:20:33'),
(12, 'admin', 'admin@gmail.com', '$2y$10$RLZadxO26d43toR5mdTAf.SmaVX8mh/iTwt9Mixe..ZLXxU1DIwXe', '123456', 'PWD Mareee Road', 'admin', '913873', 0, '2025-08-19 21:35:41');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`id`, `customer_id`, `food_id`, `added_at`) VALUES
(25, 10, 2, '2025-08-19 21:29:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`id`, `food_id`, `customer_id`, `customer_name`, `rating`, `comment`, `created_at`) VALUES
(10, 6, 10, 'Diya Shezadi', 5, 'very yummy, Sweet and delicious juice. I Love itt!', '2025-08-19 21:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_foods`
--

CREATE TABLE `tbl_foods` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `discount` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_foods`
--

INSERT INTO `tbl_foods` (`id`, `restaurant_id`, `menu_id`, `name`, `price`, `image`, `discount`) VALUES
(2, 2, 9, 'Multani Burger', 15500, '../img/bg.jpg', 5),
(3, 2, 9, 'Spicy Chicken Biryani ', 3000, '../img/8a67fac79d245d4dedd6001d1b671b34.jpg', 4),
(4, 2, 9, 'Chocolate Lava Cake', 5000, '../img/1746078778_tiramisu.jpeg', 9),
(5, 2, 10, 'Malai Boti Roll ', 2500, '../img/1746078695_jalebi.jpeg', 3),
(6, 2, 11, 'Milk Juice', 600, '../img/assortment-milkshake-glasses-tray-with-chocolate-fruits.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `restaurant_id`, `name`, `type`) VALUES
(9, 2, 'Super Fast Food Menu', 'weekly'),
(10, 2, 'Daily Menu', 'daily'),
(11, 2, 'Viral Shakes', 'monthly');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_price` decimal(10,2) NOT NULL,
  `delivery_charges` decimal(10,2) DEFAULT 300.00,
  `payment_method` varchar(50) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`id`, `customer_id`, `food_id`, `quantity`, `total_price`, `delivery_charges`, `payment_method`, `full_name`, `city`, `address`, `payment_proof`, `order_date`, `status`) VALUES
(7, 10, 2, 1, '14725.00', '300.00', 'Credit Card', 'Diya Shezadi', 'Attock', 'PWD Mareee Road', '1755638741_831899362433875605.jpg', '2025-08-19 21:25:41', 'Delivered'),
(8, 10, 3, 1, '2880.00', '300.00', 'Credit Card', 'Diya Shezadi', 'Attock', 'PWD Mareee Road', '1755638741_831899362433875605.jpg', '2025-08-19 21:25:41', 'Pending'),
(9, 10, 4, 1, '4550.00', '300.00', 'Credit Card', 'Diya Shezadi', 'Attock', 'PWD Mareee Road', '1755638741_831899362433875605.jpg', '2025-08-19 21:25:41', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_promotions`
--

CREATE TABLE `tbl_promotions` (
  `id` int(11) NOT NULL,
  `restaurant_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_promotions`
--

INSERT INTO `tbl_promotions` (`id`, `restaurant_id`, `message`, `created_at`) VALUES
(1, 2, 'Special offer: Get 20% discount on all Pizza orders this weekend!', '2025-06-22 16:10:29'),
(2, 1, '🔥 Limited Time Offer at Vings Food! Enjoy a 20% discount on all crispy wings and combo meals this weekend only. Order now and treat your taste buds!', '2025-06-22 20:12:08'),
(3, 2, '💸 Payment received for Order #3.', '2025-06-22 21:26:03'),
(4, 2, '💸 Payment received for Order #4 - Multani Burger (Qty: 1) | Total Rs. 1819.', '2025-06-22 21:46:34'),
(5, 2, 'Limited time offer: Buy 1 Get 1 Free on all Burgers every Friday!', '2025-06-22 21:53:42'),
(7, 2, 'Discount of 5% applied on item: Multani Burger', '2025-08-18 01:58:34'),
(8, 2, 'Discount of 9% applied on item: Chocolate Lava Cake', '2025-08-18 01:58:38'),
(9, 2, 'Special Offer 🎉: 4% OFF on Spicy Chicken Biryaniiii', '2025-08-18 05:43:51'),
(10, 2, '💸 Payment received for Order #5 - Chocolate Lava Cake (Qty: 1) | Total Rs. 4850.', '2025-08-18 18:00:47'),
(11, 2, '💸 Payment received for Order #7 - Multani Burger (Qty: 1) | Total Rs. 15025.', '2025-08-19 21:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rider_applications`
--

CREATE TABLE `tbl_rider_applications` (
  `id` int(11) NOT NULL,
  `rider_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT 'pending',
  `applied_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_rider_applications`
--

INSERT INTO `tbl_rider_applications` (`id`, `rider_id`, `restaurant_id`, `status`, `applied_at`, `name`, `email`) VALUES
(6, 11, 1, 'pending', '2025-08-19 21:43:43', 'Ahmad', 'user@gmail.com'),
(7, 11, 2, 'approved', '2025-08-19 21:43:46', 'Ahmad', 'user@gmail.com'),
(8, 11, 3, 'approved', '2025-08-19 21:43:49', 'Ahmad', 'user@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblrestaurants_delivery`
--
ALTER TABLE `tblrestaurants_delivery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_customer` (`customer_id`),
  ADD KEY `fk_cart_food` (`food_id`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `tbl_foods`
--
ALTER TABLE `tbl_foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_promotions`
--
ALTER TABLE `tbl_promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rider_applications`
--
ALTER TABLE `tbl_rider_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rider_user` (`rider_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblrestaurants_delivery`
--
ALTER TABLE `tblrestaurants_delivery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_foods`
--
ALTER TABLE `tbl_foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_promotions`
--
ALTER TABLE `tbl_promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_rider_applications`
--
ALTER TABLE `tbl_rider_applications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD CONSTRAINT `fk_cart_customer` FOREIGN KEY (`customer_id`) REFERENCES `tblusers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_food` FOREIGN KEY (`food_id`) REFERENCES `tbl_foods` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD CONSTRAINT `tbl_feedback_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `tbl_foods` (`id`),
  ADD CONSTRAINT `tbl_feedback_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `tblusers` (`id`);

--
-- Constraints for table `tbl_rider_applications`
--
ALTER TABLE `tbl_rider_applications`
  ADD CONSTRAINT `fk_rider_user` FOREIGN KEY (`rider_id`) REFERENCES `tblusers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
