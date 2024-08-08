-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 03, 2024 at 10:30 PM
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
-- Database: `cakery`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Phone` bigint(10) NOT NULL,
  `Password` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `UserName`, `Name`, `Email`, `Phone`, `Password`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', 1234567890, 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `billing_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `delivery_date` date DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `message_on_cake` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`billing_id`, `order_id`, `first_name`, `email`, `phone_number`, `delivery_date`, `address`, `city`, `state`, `pincode`, `message_on_cake`) VALUES
(6, 6, 'pal', 'pal@gmail.com', '01234567890', NULL, 'saraspur', 'ahmedabad', 'gujarat', '380825', 'Happy Birthday'),
(7, 7, 'pal', 'pal@gmail.com', '01234567890', NULL, 'saraspur', 'ahmedabad', 'gujarat', '380825', 'Happy Birthday'),
(8, 8, 'pal', 'pal@gmail.com', '01234567890', NULL, 'saraspur', 'ahmedabad', 'gujarat', '380825', 'Happy Birthday'),
(9, 9, 'pal rathod', 'pal@gmail.com', '01234567890', '2024-08-05', 'saraspur', 'ahmedabad', 'gujarat', '380825', 'Happy Birthday'),
(10, 10, 'pal rathod', 'pal@gmail.com', '01234567890', '2024-08-03', 'saraspur', 'ahmedabad', 'gujarat', '380825', 'Happy Birthday');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `qnt` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(10) NOT NULL,
  `cat_name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `cat_name`) VALUES
(1, 'birthday cake'),
(2, 'Engagement Cake'),
(3, 'Pastry'),
(4, 'Anniversary Cake');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `inquiry_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`inquiry_id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'pal', 'pal@gmail.com', 'test inquiry', '2024-08-03 13:44:13');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int(10) NOT NULL,
  `item_name` varchar(30) NOT NULL,
  `item_des` varchar(200) NOT NULL,
  `item_img` varchar(255) NOT NULL,
  `quantity` bigint(50) NOT NULL,
  `weight` varchar(30) NOT NULL,
  `price` int(30) NOT NULL,
  `category_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_des`, `item_img`, `quantity`, `weight`, `price`, `category_id`) VALUES
(7, 'Chocolate cake', 'test test', 'chococake1.jpg', 1, '1.5', 1000, 3),
(9, 'cup cake', 'test', 'cupcake1.jpg', 1, '1', 500, 1),
(11, 'Birthday Strawberry Cake', 'Available in a variety of flavors like rich chocolate, classic vanilla, and indulgent red velvet.', 'birthday2.jpg', 1, '1 kg', 1000, 1),
(12, 'Anniversary cake', 'No egg cake. Available in chocolate, strawberry and vanilla flavours.', 'QL4TMJpu.jpeg', 10, '1.5', 1500, 4),
(13, 'Anniversary cake', 'No egg cake. Available in chocolate, strawberry and vanilla flavours.', 'anniversary1.jpg', 1, '1.5', 1500, 4),
(14, 'Anniversary cake', 'No egg cake. Available in chocolate, strawberry and vanilla flavours.', '25th-Anniversary-Cake.jpg', 1, '2', 1300, 4),
(15, 'Anniversary cake', 'No egg cake. Available in chocolate, strawberry and vanilla flavours.', 'anniersary2.jpg', 1, '1.5', 1000, 4),
(16, 'Birthday Strawberry Cake', 'Eggless cake available. Available in chocolate flavor.', 'birthday6.jpg', 1, '1', 1000, 1),
(17, 'Birthday Strawberry Cake', 'Eggless cake available. Available in chocolate flavor.', 'birthday6.jpg', 1, '1', 1000, 1),
(18, 'Pastry', 'Eggless pastry. Available in chocolate and vanilla flavor.', 'pastry4.jpg', 100, '200 gm', 200, 3),
(19, 'Pastry', 'Eggless pastry. Available in chocolate and vanilla flavor.', 'pastry3.jpg', 100, '200 gm', 250, 3),
(20, 'Chocolate Pastry', 'Eggless pastry.', 'pastry2.jpg', 100, '200 gm', 250, 3),
(21, 'Pastry', 'Eggless pastry. Available in chocolate and vanilla flavor.', 'pastry1.jpg', 100, '200 gm', 250, 3),
(22, 'Engagement Cake', 'Eggless cake. Available in chocolate, strawberry and vanilla. in 2 or 3 Layers.', 'engage1.jpg', 100, '3 kg', 3000, 2),
(23, 'Engagement Cake', 'Eggless cake. Available in chocolate, strawberry and vanilla. in 2 or 3 Layers.', 'engage2.jpg', 100, '2.5 kg', 2800, 2),
(24, 'Engagement Cake', 'Eggless cake. Available in chocolate, strawberry and vanilla.', 'engage3.jpg', 100, '2 kg', 2000, 2),
(25, 'Engagement Cake', 'Eggless cake. Available in chocolate, strawberry and vanilla.', 'engage4.jpg', 100, '2.5 kg', 2500, 2),
(26, 'Anniversary cake', 'Eggless cake. Available in chocolate, strawberry and vanilla.', 'anniversary3.jpg', 100, '1.5 kg', 1500, 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `payment_mode` varchar(50) NOT NULL,
  `admin_remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `order_status`, `payment_mode`, `admin_remark`) VALUES
(6, 1, '2024-08-01 07:58:18', 1000.00, 'Completed', 'COD', 'compeleted'),
(7, 1, '2024-08-01 07:58:40', 1000.00, 'Processing', 'COD', 'processing'),
(8, 1, '2024-08-01 15:32:37', 500.00, 'Pending', 'COD', NULL),
(9, 1, '2024-08-03 11:57:16', 1500.00, 'Completed', 'COD', 'completed'),
(10, 1, '2024-08-03 18:53:05', 1200.00, 'Pending', 'COD', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `weight` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `item_id`, `quantity`, `price`, `weight`) VALUES
(5, 6, 7, 1, 1000.00, 1.50),
(6, 7, 7, 1, 1000.00, 1.50),
(7, 8, 9, 1, 500.00, 1.00),
(8, 9, 9, 1, 500.00, 1.00),
(9, 9, 15, 1, 1000.00, 1.50),
(10, 10, 15, 1, 1000.00, 1.50),
(11, 10, 18, 1, 200.00, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) NOT NULL,
  `Firstname` varchar(30) NOT NULL,
  `Lastname` varchar(30) NOT NULL,
  `Phone` bigint(10) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `join_date` date NOT NULL DEFAULT current_timestamp(),
  `Password` varchar(100) NOT NULL,
  `Cpassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `Firstname`, `Lastname`, `Phone`, `Email`, `join_date`, `Password`, `Cpassword`) VALUES
(1, 'pal', 'rathod', 7894561230, 'pal@gmail.com', '2024-07-01', '827ccb0eea8a706c4c34a16891f84e7b', '81dc9bdb52d04dc20036dbd8313ed055'),
(2, 'priya', 'rathod', 7894561230, 'priya@gmail.com', '2024-07-02', '81dc9bdb52d04dc20036dbd8313ed055', '81dc9bdb52d04dc20036dbd8313ed055'),
(3, 'sachin', 'tadvi', 7896541230, 'sachin@gmail.com', '2024-07-04', '81dc9bdb52d04dc20036dbd8313ed055', '81dc9bdb52d04dc20036dbd8313ed055'),
(4, 'nirali', 'patel', 9874563210, 'nirali@gmail.com', '2024-07-02', '81dc9bdb52d04dc20036dbd8313ed055', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`billing_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`inquiry_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `billing_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `inquiry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
