-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2023 at 05:29 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create the shop_db database if it doesn't exist
CREATE DATABASE IF NOT EXISTS shop;

-- Switch to the shop_db database
USE shop;
--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `baby`
--

CREATE TABLE `baby` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `baby`
--

INSERT INTO `baby` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Vicks Baby Rub-25ml', 'Balm', 264, 300, '4.png');

-- --------------------------------------------------------

--
-- Table structure for table `beauty`
--

CREATE TABLE `beauty` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `beauty`
--

INSERT INTO `beauty` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Beauty Formulas Charchol Face Scurb', 'Scrub', 385, 550, '9.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`id`, `name`, `oprice`, `price`, `image`) VALUES
(1, 'Thermometer Digital LCD', 120, 160, 'tttttt.png');

-- --------------------------------------------------------

--
-- Table structure for table `drink`
--

CREATE TABLE `drink` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drink`
--

INSERT INTO `drink` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'SMC Fruity Tasty Saline', 'SMC Enterprise Limited', 5, 6, '7.png');

-- --------------------------------------------------------

--
-- Table structure for table `herbal`
--

CREATE TABLE `herbal` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `herbal`
--

INSERT INTO `herbal` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Adovas 100ml', 'Herbal cough syrup [Vasakarista]', 63, 70, '6.png');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 2, 'Rezaul Karim', 'sayem010ahmed@gmail.com', '01871468781', 'jhfjhfiytuymnvbnvhgdghd;ljlyuhjgdghfdgfsbvcjkgujjfhjytff');

-- --------------------------------------------------------

--
-- Table structure for table `mother`
--

CREATE TABLE `mother` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mother`
--

INSERT INTO `mother` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Brest Pump', 'Pump', 180, 192, '5.png');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(2, 2, 'Suruvy', '01718434558', 'hjgdgfstgfsgfs@hgyd.ghyfgt', 'cash on delivery', 'flat no. tghgfjh, jfhgdfd, jgdfhdhfd, gfdsgfsdgf - 1340', ', Napa (1) , Sergel 20 (1) ', 74, '10-Feb-2023', 'completed'),
(3, 2, 'lojhkjbhkj', '354561261', 'ljhkjkjbg@hjgu.jhg', 'cash on delivery', 'flat no. 54654, knvbhhvg, juyfuhv, oiughvgb - 564654', ', Napa (1) , Sergel 20 (1) ', 74, '10-Feb-2023', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `personal`
--

CREATE TABLE `personal` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personal`
--

INSERT INTO `personal` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'One Time Bandage Box', 'Strip', 90, 100, 'one time.png'),
(2, 'Dental Floss Toothpick', 'Dental Floss', 99, 120, '2.png');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Napa', 'Paracetamol 500mg', 10, 12, 'napa.png'),
(2, 'Sergel 20', 'Esomeprazole Magnesium Trihydrate', 64, 70, 'sergel 20.png'),
(3, 'Monas 10', 'Montelukast 10mg', 250, 262, 'monas 10.png');

-- --------------------------------------------------------

--
-- Table structure for table `products1`
--

CREATE TABLE `products1` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products1`
--

INSERT INTO `products1` (`id`, `name`, `price`, `image`) VALUES
(4, 'Rezaul Karim', 3, 'AfraMedicalBeauty_SRPackaging.jpg'),
(5, 'Ismail Khan', 1256, '317967404_1267133607187543_4394549876529562280_n.jpg'),
(6, 'user A', 254, '327348654_1352257095312791_3515925743086110929_n.jpg'),
(7, 'hhiyt', 554, 'pexels-julie-viken-593451.jpg'),
(9, 'hgffdhg', 256974, 'Lab-Notebook-Table-of-Contents-TemplateLab.com_.jpg'),
(10, 'kyhryet', 564, 'medical-pills-bottle-aerial-viewwhite-pills-pill-bottlesmedicine-small-bottle_387864-9105.jpg'),
(11, 'tttttt', 546, '06012022_113815.Helena Atik true DSLR - Copy - Copy.jpg'),
(12, 'yyyy', 243, '09012022_170530.Helena Atik true DSLR.PORTRAIT - Copy - Copy.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sexual`
--

CREATE TABLE `sexual` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sexual`
--

INSERT INTO `sexual` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Vigogel 15gm tube', 'Tila Jadeed [Madar, Mace arillus, Nutmeg nut]', 158, 180, 'Vigogel.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Rezaul Karim', 'sayem010amed@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin'),
(2, 'Ismail Khan', 'aronnokhan999@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vitamins`
--

CREATE TABLE `vitamins` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vitamins`
--

INSERT INTO `vitamins` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Rex', 'Betacarotene + Vitamin C + Vitamin E (Anti-Oxidant Vitamins and Minerals)', 81, 90, 'Rex.png');

-- --------------------------------------------------------

--
-- Table structure for table `women`
--

CREATE TABLE `women` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `gname` varchar(100) NOT NULL,
  `oprice` int(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `women`
--

INSERT INTO `women` (`id`, `name`, `gname`, `oprice`, `price`, `image`) VALUES
(1, 'Novelon Lite', 'Drospirenone + Ethinylestradiol', 382, 425, '3.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baby`
--
ALTER TABLE `baby`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `beauty`
--
ALTER TABLE `beauty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drink`
--
ALTER TABLE `drink`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `herbal`
--
ALTER TABLE `herbal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mother`
--
ALTER TABLE `mother`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products1`
--
ALTER TABLE `products1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sexual`
--
ALTER TABLE `sexual`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vitamins`
--
ALTER TABLE `vitamins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `women`
--
ALTER TABLE `women`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `baby`
--
ALTER TABLE `baby`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `beauty`
--
ALTER TABLE `beauty`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drink`
--
ALTER TABLE `drink`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `herbal`
--
ALTER TABLE `herbal`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mother`
--
ALTER TABLE `mother`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products1`
--
ALTER TABLE `products1`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `sexual`
--
ALTER TABLE `sexual`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vitamins`
--
ALTER TABLE `vitamins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `women`
--
ALTER TABLE `women`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
