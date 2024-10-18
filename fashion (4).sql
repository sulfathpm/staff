-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2024 at 05:06 PM
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
-- Database: `fashion`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `COMMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `COMMENTS` text NOT NULL,
  `SENDER_TYPE` enum('ADMIN','CUSTOMER','STAFF') NOT NULL,
  `READ1` enum('SEND','ACCEPTED','REJECTED') NOT NULL DEFAULT 'SEND',
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'sul', 'sul@gmail.com', 'color chnge', 'i wanted my dress to be orange and green but, i got it in yellow and blue', '2024-09-19 23:21:49'),
(3, 'Ann', 'ann@gmail.com', 'color chnge', 'i got the color different from what i ordered', '2024-10-13 02:15:25'),
(4, 'as', 'as@gmail.com', 'fabric change', 'i got the wrong fabric', '2024-10-13 02:45:07'),
(5, 'su', 'sddddddddddddddddddd@gmail.com', 'length', 'i asked for mini dress..i got a tea-length dress', '2024-10-13 02:49:19'),
(6, 'asdfs', 'asdb@gmail.com', 'sleeve length', 'i got sleeveless ..i asked for full length', '2024-10-13 02:54:56'),
(9, 'sulfath', 'sulfath245@gmail.com', 'sleeve length', 'i got 3/4 ..i asked for full length', '2024-10-13 02:57:27'),
(10, 'sulfath', 'sulfath245@gmail.com', 'dress length', 'i got min ..i asked for full length', '2024-10-13 03:33:52'),
(11, 'sulfath', 'sulfath245@gmail.com', 'color ', 'i got the wrong color.but,i still liked it..thank you for your hardwork', '2024-10-13 03:35:22');

-- --------------------------------------------------------

--
-- Table structure for table `customizations`
--

CREATE TABLE `customizations` (
  `OPTION_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `MEASUREMENT_ID` int(11) DEFAULT NULL,
  `COLOR` char(7) DEFAULT NULL,
  `EMBELLISHMENTS` enum('EMBROIDERY','APPLIQUÉ','SEQUIN','BEADS','LACE','FRINGE','PEARL','PIPING','RHINESTONE') DEFAULT NULL,
  `DRESS_LENGTH` enum('MINI','KNEE-LENGTH','TEA-LENGTH','MIDI','MAXI','FULL-LENGTH') DEFAULT NULL,
  `SLEEVE_LENGTH` enum('SLEEVELESS','SHORT','ELBOW','3/4','FULL') DEFAULT NULL,
  `ADDITIONAL_NOTES` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dress`
--

CREATE TABLE `dress` (
  `DRESS_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `FABRIC` varchar(50) NOT NULL,
  `COLOR` varchar(100) NOT NULL,
  `SIZES` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `BASE_PRICE` decimal(10,2) NOT NULL,
  `IMAGE_URL` varchar(255) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dress`
--

INSERT INTO `dress` (`DRESS_ID`, `NAME`, `DESCRIPTION`, `FABRIC`, `COLOR`, `SIZES`, `BASE_PRICE`, `IMAGE_URL`, `CREATED_AT`, `visibility`) VALUES
(1, 'Elegant Evening Dress', 'This strapless champagne satin ball gown \r\nsophisticated look perfect for formal occasions.', 'Satin', 'Champagne', 'XS,S,M,L,XL,XXL', 2000.00, '..\\dress\\elegnt evening dress.jpg', '2024-09-15 08:50:00', 1),
(2, 'casual summer dress', ' Geometric Printed Maxi Dress', 'Chiffon', 'Maroon,White', 'XS,S,M,L,XL,XXL', 1500.00, '..\\dress\\casual summer dress.jpg', '2024-09-15 09:29:26', 1),
(3, 'Bridesmaid Dress', 'Make your bridal party stand out with these stunning bridesmaid dresses.', 'Tulle', 'Blush Pink ', 'XS,S,M,L,XL,XXL', 1200.00, '../dress/bridesmade dress.jpg', '2024-09-15 11:20:34', 1),
(4, 'Cocktail Dress', 'Great option for weddings, cocktail parties, or any occasion requiring a polished, sophisticated look.', 'Combination of tulle and satin', 'Soft lavender or lilac', 'XS,S,M,L,XL,XXL', 2500.00, '..\\dress\\cocktail dress.jpg', '2024-09-15 11:20:34', 1),
(5, 'Bohemian Maxi Dress', 'Perfect outfit for a summer event, beach vacation, or any occasion where a relaxed, stylish look is desired.', 'Chiffon', 'Green , Teal', 'XS,S,M,L,XL,XXL', 1400.00, '..\\dress\\bohemian maxi dress.jpg', '2024-09-15 11:26:11', 1),
(6, 'Saree', 'Ideal for festive events, traditional gatherings, or any occasion where a bright, standout ensemble is desired.', 'Georgette ', 'Mustard yellow', 'XS,S,M,L,XL,XXL', 2100.00, '..\\dress\\saree1.jpg', '2024-09-15 11:26:11', 1),
(7, 'Vintage Lace Dress', 'Ensemble exudes timeless charm and grace, perfect for formal or semi-formal events.', ' floral lace overlay on satin', 'wine-red', 'XS,S,M,L,XL,XXL', 2199.00, '..\\dress\\vintage lace dress.jpg', '2024-09-15 11:36:00', 1),
(8, 'salwar suit', 'Exudes a graceful and traditional appeal, perfect for casual gatherings or festive occasions.', 'Cotton', 'pastel green ', 'XS,S,M,L,XL,XXL', 900.00, '..\\dress\\salwar suit1.jpg', '2024-09-15 11:36:00', 1),
(9, 'Modern A-Line Dress', 'Exudes a breezy yet chic vibe, perfect for outdoor events, summer parties, or even a casual evening outing.', 'Satin', 'sage green', 'XS,S,M,L,XL,XXL', 1400.00, '..\\dress\\modern a line dress.jpg', '2024-09-15 11:41:54', 1),
(10, 'Qipao', 'Perfect for formal occasions, especially events that celebrate Chinese heritage, such as weddings, cultural ceremonies, or elegant dinners.', 'Silk', 'light beige', 'XS,S,M,L,XL,XXL', 2299.00, '..\\dress\\qipao1.png', '2024-09-15 11:41:54', 1),
(11, 'Embroidered Midi Dress', 'Exude elegance in this beautifully crafted navy blue midi dress, featuring intricate floral embroidery across the bodice.', 'Georgette ', 'Navy Blue ', 'XS,S,M,L,XL,XXL', 2100.00, '..\\dress\\Embroidered-Midi-Dress1.jpg', '2024-09-15 11:43:50', 1),
(12, 'Pleated Skater Dress', 'perfect for semi-formal to formal events.', 'Crepe', 'deep emerald green', 'XS,S,M,L,XL,XXL', 1200.00, '..\\dress\\pleated skater dress.jpg', '2024-09-15 11:43:50', 1),
(16, 'Kurti', 'Perfect for everyday wear', 'Cotton', 'Ash', 'XS,S,M,L,XL,XXL', 600.00, '../dress/kurti.jpg', '2024-09-25 06:39:36', 0),
(22, 'Churidar', 'ideal for festive occasions and celebrations', 'Brocade and Silk', 'coral pink and yellow', 'XS,S,M,L,XL,XXL', 800.00, '../dress/churidar.jpg', '2024-09-25 07:25:36', 0);

-- --------------------------------------------------------

--
-- Table structure for table `fabrics`
--

CREATE TABLE `fabrics` (
  `FABRIC_ID` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `IMAGE_URL` varchar(255) DEFAULT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `PRICE_PER_UNIT` decimal(10,2) NOT NULL,
  `AVAILABLE_QUANTITY` decimal(10,2) NOT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `visibility` tinyint(1) DEFAULT 1,
  `STOCK_STATUS` varchar(20) NOT NULL DEFAULT 'In Stock'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fabrics`
--

INSERT INTO `fabrics` (`FABRIC_ID`, `NAME`, `IMAGE_URL`, `DESCRIPTION`, `PRICE_PER_UNIT`, `AVAILABLE_QUANTITY`, `CREATED_AT`, `visibility`, `STOCK_STATUS`) VALUES
(1, 'Lace', '../fabrics/lace.jpeg', 'Delicate and romantic, perfect for bridal and special occasions.', 500.00, 30.00, '2024-09-18 15:24:26', 1, 'Out of Stock'),
(2, 'Silk', '..\\fabric\\silk.jpg', 'Luxurious and elegant, perfect for evening wear.', 700.00, 0.00, '2024-09-19 07:49:27', 1, 'Low Stock'),
(3, 'Cotton', '..\\fabric\\cotton1.jpg', 'Comfortable and breathable, ideal for casual dresses.', 300.00, 30.00, '2024-09-19 07:51:47', 1, 'In Stock'),
(4, 'Modal Silk', '..\\fabric\\modal silk.jpg', 'Exceptionally soft and durable, ideal for casual dresses.', 900.00, 20.00, '2024-09-19 07:51:47', 1, 'Low Stock'),
(5, 'Chiffon', '..\\fabric\\chiffon1.jpg', 'Lightweight and sheer, perfect for airy and flowy dresses.', 350.00, 15.00, '2024-09-19 07:54:32', 1, 'Low Stock'),
(6, 'Tweed', '..\\fabric\\tweed.webp', 'Warm and textured, perfect for stylish and cozy outfits.', 1200.00, 9.00, '2024-09-19 07:54:32', 1, 'Out of Stock'),
(7, 'Velvet', '..\\fabric\\velvet1.jpg', 'Soft and plush, ideal for luxurious evening gowns.', 500.00, 12.00, '2024-09-19 07:57:41', 1, 'Low Stock'),
(8, 'Denim', '..\\fabric\\denim1.jpg', 'Durable and stylish, ideal for casual and trendy outfits.', 500.00, 10.00, '2024-09-19 07:57:41', 1, 'Low Stock'),
(9, 'Satin', '..\\fabric\\satin2.jpg', 'Smooth and glossy, ideal for elegant evening dresses.', 800.00, 13.00, '2024-09-19 07:59:54', 1, 'Low Stock'),
(10, 'Linen', '..\\fabric\\linen2.webp', 'Breathable and lightweight, perfect for summer dresses.', 600.00, 14.00, '2024-09-19 07:59:54', 1, 'Low Stock'),
(11, 'Tulle', '..\\fabric\\tulle.webp', 'Delicate and airy, perfect for adding volume to dresses.', 660.00, 11.00, '2024-09-19 08:02:13', 1, 'Low Stock'),
(12, 'Crepe', '..\\fabric\\crepe.jpg', 'Elegant and textured, ideal for sophisticated dresses.', 400.00, 19.00, '2024-09-19 08:02:13', 1, 'Low Stock'),
(15, 'Georgette', '../fabrics/georgette.jpg', ' lightweight, sheer fabric  and it works well for both casual and formal styles.\r\n\r\n\r\n\r\n\r\n\r\n\r\n', 700.00, 30.00, '2024-10-10 21:06:52', 0, 'In Stock');

-- --------------------------------------------------------

--
-- Table structure for table `measurements`
--

CREATE TABLE `measurements` (
  `MEASUREMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `ORDER_ID` int(11) DEFAULT NULL,
  `SHOULDER` decimal(10,2) DEFAULT NULL,
  `BUST` decimal(10,2) DEFAULT NULL,
  `WAIST` decimal(10,2) DEFAULT NULL,
  `HIP` decimal(10,2) DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ORDER_ID` int(11) NOT NULL,
  `USER_ID` int(11) NOT NULL,
  `DRESS_ID` int(11) DEFAULT NULL,
  `FABRIC_ID` int(11) DEFAULT NULL,
  `OPTION_ID` int(11) DEFAULT NULL,
  `STATUSES` enum('PENDING','IN-PROGRESS','COMPLETED','SHIPPED','DELIVERED','CANCELLED','CART') NOT NULL,
  `SSIZE` varchar(100) NOT NULL,
  `QUANTITY` int(2) NOT NULL,
  `TOTAL_PRICE` decimal(10,2) NOT NULL,
  `ESTIMATED_DELIVERY_DATE` date DEFAULT NULL,
  `ACTUAL_DELIVERY_DATE` date DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_assignments`
--

CREATE TABLE `order_assignments` (
  `ASSIGNMENT_ID` int(11) NOT NULL,
  `ORDER_ID` int(11) NOT NULL,
  `STAFF_ID` int(11) NOT NULL,
  `ASSIGNED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_ID` int(11) NOT NULL,
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORDD` varchar(255) NOT NULL,
  `EMAIL` varchar(100) NOT NULL,
  `PHONE` varchar(15) NOT NULL,
  `USER_TYPE` enum('ADMIN','CUSTOMER','STAFF') NOT NULL,
  `ADDRESSS` text DEFAULT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp(),
  `PROFILE_PICTURE` varchar(255) DEFAULT NULL,
  `blocked` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USER_ID`, `USERNAME`, `PASSWORDD`, `EMAIL`, `PHONE`, `USER_TYPE`, `ADDRESSS`, `CREATED_AT`, `PROFILE_PICTURE`, `blocked`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '', 'ADMIN', NULL, '2024-09-12 19:44:26', NULL, 0),
(2, 'sul', 'sul', 'sul@gmail.com', '76543232', 'CUSTOMER', '', '2024-09-14 11:33:00', NULL, 0),
(4, 'sulfath', 'as', 'sulfth@gmail.com', '9876543', 'CUSTOMER', '', '2024-09-14 11:35:19', NULL, 0),
(6, 'ann', 'aa', 'ann@gmail.com', '763453256', 'CUSTOMER', '', '2024-09-14 11:58:57', NULL, 0),
(7, 'sulfa', 'sult', 'sulfa@gmail.com', '99999888888', 'CUSTOMER', '', '2024-09-14 16:44:56', NULL, 0),
(8, 'ww', 'ww', 'ww@gmail.com', '8765445665', 'CUSTOMER', '', '2024-09-14 16:47:19', NULL, 0),
(9, 'su', 'eee', 'su@gmail.com', '98789789', 'CUSTOMER', '', '2024-09-14 16:49:41', NULL, 0),
(10, 'sa', 'aaq', 'sa@gmail.com', '989898989', 'CUSTOMER', '', '2024-09-14 16:51:16', NULL, 0),
(20, 'aq1', 'aq', 'aq1@gmail.com', '8765445665', 'CUSTOMER', 'abcd', '2024-10-01 21:08:31', NULL, 0),
(22, 'x', 'xx', 'xx@gmail.com', '', 'STAFF', NULL, '2024-10-02 16:59:35', NULL, 0),
(23, 'aa', 'aa', 'aa@gmail.com', '76543232', 'CUSTOMER', 'qqqqqqqqqqqqqq', '2024-10-07 20:51:07', '', 0),
(24, 'aanmary', 'aanmary', 'aanmary@gmail.com', '65566565', 'CUSTOMER', 'qqq', '2024-10-12 20:02:57', 'uploads/profile_670b5cfc3d0947.45236921.jpg', 0),
(25, 'q', 'q', 'q@gmail.com', '', 'STAFF', NULL, '2024-10-13 12:19:18', NULL, 0),
(27, 'qqq', 'qqq', 'qqq@gmail.com', '8777776', 'STAFF', NULL, '2024-10-13 12:41:44', NULL, 0),
(28, 'gg', 'gg', 'gg@gmail.com', '76656656', 'STAFF', NULL, '2024-10-13 12:45:30', NULL, 0),
(29, 'fffg', 'fffg', 'fffg@gmail.com', '766776575', 'STAFF', NULL, '2024-10-13 12:46:48', NULL, 0),
(30, 'ii', 'ii', 'ii@gmail.com', '6666666', 'STAFF', NULL, '2024-10-13 12:49:18', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`COMMENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customizations`
--
ALTER TABLE `customizations`
  ADD PRIMARY KEY (`OPTION_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `MEASUREMENT_ID` (`MEASUREMENT_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`);

--
-- Indexes for table `dress`
--
ALTER TABLE `dress`
  ADD PRIMARY KEY (`DRESS_ID`);

--
-- Indexes for table `fabrics`
--
ALTER TABLE `fabrics`
  ADD PRIMARY KEY (`FABRIC_ID`);

--
-- Indexes for table `measurements`
--
ALTER TABLE `measurements`
  ADD PRIMARY KEY (`MEASUREMENT_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ORDER_ID`),
  ADD KEY `USER_ID` (`USER_ID`),
  ADD KEY `FABRIC_ID` (`FABRIC_ID`),
  ADD KEY `DRESS_ID` (`DRESS_ID`),
  ADD KEY `OPTION_ID` (`OPTION_ID`);

--
-- Indexes for table `order_assignments`
--
ALTER TABLE `order_assignments`
  ADD PRIMARY KEY (`ASSIGNMENT_ID`),
  ADD KEY `ORDER_ID` (`ORDER_ID`),
  ADD KEY `STAFF_ID` (`STAFF_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `COMMENT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customizations`
--
ALTER TABLE `customizations`
  MODIFY `OPTION_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dress`
--
ALTER TABLE `dress`
  MODIFY `DRESS_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `fabrics`
--
ALTER TABLE `fabrics`
  MODIFY `FABRIC_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `measurements`
--
ALTER TABLE `measurements`
  MODIFY `MEASUREMENT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ORDER_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_assignments`
--
ALTER TABLE `order_assignments`
  MODIFY `ASSIGNMENT_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`);

--
-- Constraints for table `customizations`
--
ALTER TABLE `customizations`
  ADD CONSTRAINT `customizations_ibfk_1` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `customizations_ibfk_2` FOREIGN KEY (`MEASUREMENT_ID`) REFERENCES `measurements` (`MEASUREMENT_ID`),
  ADD CONSTRAINT `customizations_ibfk_3` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`);

--
-- Constraints for table `measurements`
--
ALTER TABLE `measurements`
  ADD CONSTRAINT `measurements_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `measurements_ibfk_2` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `measurements_ibfk_3` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`),
  ADD CONSTRAINT `measurements_ibfk_4` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`USER_ID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`FABRIC_ID`) REFERENCES `fabrics` (`FABRIC_ID`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`DRESS_ID`) REFERENCES `dress` (`DRESS_ID`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`OPTION_ID`) REFERENCES `customizations` (`OPTION_ID`);

--
-- Constraints for table `order_assignments`
--
ALTER TABLE `order_assignments`
  ADD CONSTRAINT `order_assignments_ibfk_1` FOREIGN KEY (`ORDER_ID`) REFERENCES `orders` (`ORDER_ID`),
  ADD CONSTRAINT `order_assignments_ibfk_2` FOREIGN KEY (`STAFF_ID`) REFERENCES `users` (`USER_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
