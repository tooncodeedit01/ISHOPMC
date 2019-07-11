-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2019 at 02:10 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ishop`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `www` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `alert` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `promotion_tm` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `promotion_tw` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `truewallet_phone` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `truewallet_email` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `truewallet_password` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `website` varchar(255) DEFAULT 'shop.hakko.pw',
  `me` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'https://www.facebook.com/itorkungth',
  `truewallet_msg` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `truewallet_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `title`, `description`, `icon`, `name`, `www`, `alert`, `promotion_tm`, `promotion_tw`, `truewallet_phone`, `truewallet_email`, `truewallet_password`, `website`, `me`, `truewallet_msg`, `truewallet_name`) VALUES
(1, 'iSHOPMC.INFO | ขายไอดีแท้ Minecraft', 'iSHOPMC.INFO, เว็บขายไอดีแท้, ขายไอดีแท้มายคราฟ, ร้านขายIDแท้, ร้านขายไอดี, IDแท้, IDแท้Minecraft, ไอดีแท้มายคราฟ 10บาท, ไอดีแท้มายคราฟถูกๆ, ไอดีMinecraft', 'https://ishopmc.info/favicon.ico', 'iSHOPMC.INFO', 'https://ishopmc.info/', 'เว็บขายไอดีแท้มายคราฟ ISHOPMC.INFO ได้แน่นอน 100,000%', '1', '1.2', '0649085379', 'truewallet@wallet.com', 'password', 'ishopmc.info', 'https://www.facebook.com/MRNaronglit/', '2019', 'ประยุท จันโอชา');

-- --------------------------------------------------------

--
-- Table structure for table `log_shop`
--

CREATE TABLE `log_shop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `lore` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `time` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `log_topup`
--

CREATE TABLE `log_topup` (
  `id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `transaction` varchar(14) NOT NULL,
  `time` int(11) NOT NULL,
  `point` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `username` varchar(255) NOT NULL,
  `status` varchar(7) DEFAULT 'fail'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `lore` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dist` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`id`, `name`, `lore`, `dist`, `price`, `img`) VALUES
(1, 'ไอดีแท้มือ2', 'เปลี่ยนไม่ได้ อาจโดนแบนบางเซิร์ฟ', 'NFA.txt', '10.00', 'http://www.pngmart.com/files/7/Minecraft-PNG-Photo.png'),
(2, 'ไอดีแท้มือ2', 'เปลี่ยนได้หมด นอกจากเมล์ รับประกัน 5ชม.', 'SEMI.txt', '65.00', 'http://www.stickpng.com/assets/images/580b57fcd9996e24bc43c2fc.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `point` decimal(10,2) NOT NULL,
  `ban` varchar(255) NOT NULL DEFAULT 'false',
  `rank` varchar(255) NOT NULL DEFAULT 'member'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `ip`, `point`, `ban`, `rank`) VALUES
(1, 'admin', '12345', '127.0.0.1', '0.00', 'false', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_shop`
--
ALTER TABLE `log_shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log_topup`
--
ALTER TABLE `log_topup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `log_shop`
--
ALTER TABLE `log_shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_topup`
--
ALTER TABLE `log_topup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
