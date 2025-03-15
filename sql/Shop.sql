-- phpMyAdmin SQL Dump
-- version 4.7.4
-- Host: 127.0.0.1
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `Shop`
CREATE DATABASE IF NOT EXISTS `Shop`;
USE `Shop`;

-- Table: `admin`
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(125) NOT NULL,
  `lastName` varchar(125) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` varchar(20) NOT NULL,
  `confirmCode` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admin` (`firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `type`, `confirmCode`) VALUES
('admin', 'admin', 'admin@gmail.com', '6464651', 'okay', '12345678', 'admin', '852963');

-- Table: `cart`
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: `orders`
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `oplace` text NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `dstatus` varchar(10) NOT NULL DEFAULT 'no',
  `odate` date NOT NULL,
  `ddate` date NOT NULL,
  `delivery` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Table: `products`
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pName` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `item` varchar(100) NOT NULL,
  `pCode` varchar(20) NOT NULL,
  `picture` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `products` (`pName`, `price`, `stock`, `description`, `available`, `category`, `type`, `item`, `pCode`, `picture`) 
VALUES
('Royal Blue Kurta', 2499, 10, 'Elegant royal blue kurta with intricate embroidery.', 1, 'Kurta', 'Ethnic', 'Mens Wear', 'RBK001', 'royal_blue_kurta.jpg'),
('Golden Sherwani', 7999, 5, 'Premium golden sherwani for wedding occasions.', 1, 'Sherwani', 'Wedding', 'Mens Wear', 'GS002', 'golden_sherwani.jpg'),
('Classic Short Kurta', 1499, 15, 'Classic short kurta, perfect for casual ethnic looks.', 1, 'Short Kurta', 'Casual', 'Mens Wear', 'CSK003', 'classic_short_kurta.jpg'),
('Jodhpuri Suit Black', 9999, 8, 'Elegant Jodhpuri suit in black with gold detailing.', 1, 'Jodhpuri Suit', 'Formal', 'Mens Wear', 'JSB004', 'jodhpuri_suit_black.jpg'),
('Designer Jacket', 3499, 12, 'Designer Nehru jacket in vibrant colors.', 1, 'Jackets', 'Festive', 'Mens Wear', 'DJ005', 'designer_jacket.jpg'),
('Silk Safa', 1299, 20, 'Luxurious silk safa for weddings.', 1, 'Safa Duppata', 'Wedding', 'Accessories', 'SS006', 'silk_safa.jpg'),
('Embroidered Mojadi', 1999, 10, 'Traditional mojadi with hand embroidery.', 1, 'Mojadi', 'Footwear', 'Mens Wear', 'EM007', 'embroidered_mojadi.jpg'),
('Pearl Mala', 999, 25, 'Elegant pearl mala for wedding and traditional outfits.', 1, 'Mala', 'Jewelry', 'Accessories', 'PM008', 'pearl_mala.jpg');

-- Table: `user`
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(120) NOT NULL,
  `password` varchar(100) NOT NULL,
  `confirmCode` varchar(10) NOT NULL,
  `activation` varchar(10) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`firstName`, `lastName`, `email`, `mobile`, `address`, `password`, `confirmCode`, `activation`) VALUES
('Jo', 'Castaneda', 'joanmcastaneda@gmail.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '69a9dc1da83c4c3e58a5ecb7c9de78fa', '0', 'yes'),
('KO', 'KOOOO', 'ko@w.com', '123', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '25d55ad283aa400af464c76d713c07ad', '289477', 'no'),
('Czyke', 'Correa', 'czyke@yahoo.com', '09368790811', 'ADDRESS 1 BLK 15 LOT 17 DRIVE ST.', '7c09a95be9c2e9612c2bda758fc17e42', '0', 'yes');


--
-- Indexes for dumped tables

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

-- /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
-- /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
-- /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
