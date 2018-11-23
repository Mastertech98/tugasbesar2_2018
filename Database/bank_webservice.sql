-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2018 at 05:20 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bank_webservice`
--

-- --------------------------------------------------------

--
-- Table structure for table `nasabah`
--

CREATE TABLE `nasabah` (
  `Nama` varchar(50) NOT NULL,
  `No_Kartu` varchar(30) NOT NULL,
  `Saldo` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nasabah`
--

INSERT INTO `nasabah` (`Nama`, `No_Kartu`, `Saldo`) VALUES
('William Juniarta Hadiman', '121234345656', 10000000),
('Ferdiant Joshua Muis', '345612347678', 20000000);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `No_Kartu_Pengirim` varchar(30) NOT NULL,
  `No_Kartu_Penerima` varchar(30) NOT NULL,
  `Jumlah` bigint(20) NOT NULL,
  `Waktu_Transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`No_Kartu_Pengirim`, `No_Kartu_Penerima`, `Jumlah`, `Waktu_Transaksi`) VALUES
('345612347678', '121234345656', 15000000, '2018-11-22 02:14:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nasabah`
--
ALTER TABLE `nasabah`
  ADD PRIMARY KEY (`No_Kartu`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD KEY `No_Pengirim` (`No_Kartu_Pengirim`),
  ADD KEY `No_Penerima` (`No_Kartu_Penerima`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `No_Penerima` FOREIGN KEY (`No_Kartu_Penerima`) REFERENCES `nasabah` (`No_Kartu`),
  ADD CONSTRAINT `No_Pengirim` FOREIGN KEY (`No_Kartu_Pengirim`) REFERENCES `nasabah` (`No_Kartu`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
