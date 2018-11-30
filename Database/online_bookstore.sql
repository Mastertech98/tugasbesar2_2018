-- MySQL dump 10.16  Distrib 10.1.31-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: online_bookstore
-- ------------------------------------------------------
-- Server version	10.1.31-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `access_info`
--

DROP TABLE IF EXISTS `access_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_info` (
  `token` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_browser` varchar(150) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `expiry_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_info`
--

LOCK TABLES `access_info` WRITE;
/*!40000 ALTER TABLE `access_info` DISABLE KEYS */;
INSERT INTO `access_info` VALUES ('2380704',12,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0','::1','2018-11-30 14:56:38'),('2226538',1,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:63.0) Gecko/20100101 Firefox/63.0','::1','2018-11-30 15:01:14');
/*!40000 ALTER TABLE `access_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `author` varchar(32) NOT NULL,
  `synopsis` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'Nota Hidup','Light R. D. B.','Buku ajaib yang berisi nama-nama orang yang terpilih. Jika namamu tertulis di buku ini maka kamu adalah salah satu orang yang beruntung.'),(2,'Bis Fantastis & Cara Menemukannya','Neue Salamander','Buku ini adalah buku ajaib yang berisi tentang dongeng-dongeng di masa lampau. Salah satu cerita dari buku ini adalah tentang bis ajaib.'),(3,'Orang Asia Kaya Gila','Kevin Kwan','Kisah cinta seorang biasa dengan orang terkaya di Singapura'),(4,'Pacar Cina Kaya Raya','Kevin Kwan','Kelanjutan dari kisah cinta Rachel Chu dengan Nick Young'),(5,'Masalah Orang Kaya','Kevin Kwan','Berada di dekat kematian nenek Nick Young, terjadi banyak drama di keluarganya. Dengan warisan yang sangat banyak, apakah yang akan terjadi dengan kisah cinta Rachel dan Nick?'),(6,'Permainan Lapar','Suzanne Collins','Anda lapar? Tapi ingin main? Permainan Lapar solusinya! Novel ini menceritakan tentang anak-anak remaja yang lapar tapi ingin main sehingga membahayakan satu sama lain. Temukan kelanjutan ceritanya pada buku Permainan Lapar ini!');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `book_id` int(11) NOT NULL,
  `buyer_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `comments` varchar(256) DEFAULT NULL,
  `rating` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (1,2,1,10,'2018-09-28',NULL,NULL),(2,1,1,1,'2018-09-30','Buku ini keren! Nama Rogi dan Lani, temanku, ada di sini, keberuntungan hebat menanti mereka! ( ^_^)',5),(3,1,2,1,'2018-10-01','Aku membeli buku ini atas rekomendasi Tayo, aku menemukan namaku sendiri di buku ini. Aku tidak tahu harus senang atau sedih ( \'_\')',4),(4,1,1,2,'2018-10-25','',3),(5,2,1,2,'2018-10-25','',3),(6,3,1,1,'2018-10-26','Ntaps!',5),(7,4,1,1,'2018-10-26','',3),(8,4,1,1,'2018-10-26','',3),(9,4,1,1,'2018-10-26','Bukunya bagus bet uwoo',5),(10,4,1,1,'2018-10-26','Aku gak suka buku ini! dia rasis bangett.. Aku sebagai orang cina sungguh tersinggung dan ingin menuntut pembuat buku ini untuk tidak membawa2 ras ke dalam cerita karangannya',1),(11,4,1,10000,'2018-10-26',NULL,NULL),(12,5,1,200,'2018-10-26','Bukunya sbenernya bagus sih, tapi gak tau ya kenapa menurut saya cerita ini terlalu mengada-ngada. Saya sebagai orang kaya tidak meraskan masalah ini. Saya sudah membeli 200 buku untuk keluarga besar saya, dan jujur 150/200 anggotak keluarga saya kecewa. S',1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(8) NOT NULL,
  `password` varchar(16) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `address` varchar(256) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `card` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'tayotayo','tayotayo','Tayo the Little Bus','tayo@littlebus.com','120 Garage Street, Unit B. Korea.','081234567890',NULL),(2,'ROGreen','rogreen','Tayo the Little Bus','rogreen@littlebus.com','120 Garage Street, Unit B. Korea.','081234567890',NULL),(9,'alda','alda','Shevalda','alda@email.com','bandung','08123456789',464165604180),(11,'guest','guest','Guest','guest@hotmail.co.id','jakarta','08987654321',121234345656),(12,'anon','anon','anon','anon@mail.com','indonesia','099887766',464165604180);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-30 15:57:00
