-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 30, 2018 at 04:12 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_info`
--

CREATE TABLE `access_info` (
  `token` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_browser` varchar(150) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `expiry_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_info`
--

INSERT INTO `access_info` (`token`, `user_id`, `user_browser`, `user_ip`, `expiry_time`) VALUES
('5145295', 1, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0', '::1', '2018-11-30 22:38:46');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `comments` varchar(256) DEFAULT NULL,
  `rating` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(8) NOT NULL,
  `password` varchar(16) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `address` varchar(256) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `card` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`, `email`, `address`, `phone_number`, `card`) VALUES
(1, 'tayotayo', 'tayotayo', 'Tayo the Little Bus', 'tayo@littlebus.com', '120 Garage Street, Unit B. Korea.', '081234567890', 121234345656),
(2, 'ROGreen', 'rogreen', 'Tayo the Little Bus', 'rogreen@littlebus.com', '120 Garage Street, Unit B. Korea.', '081234567890', NULL),
(9, 'alda', 'alda', 'Shevalda', 'alda@email.com', 'bandung', '08123456789', 464165604180),
(11, 'guest', 'guest', 'Guest', 'guest@hotmail.co.id', 'jakarta', '08987654321', 121234345656),
(12, 'anon', 'anon', 'anon', 'anon@mail.com', 'indonesia', '099887766', 464165604180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
