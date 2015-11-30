CREATE DATABASE  IF NOT EXISTS `onlinestore` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `onlinestore`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: onlinestore
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.8-MariaDB

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
-- Table structure for table `access`
--

DROP TABLE IF EXISTS `access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access` (
  `Page` varchar(45) NOT NULL,
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`Page`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access`
--

LOCK TABLES `access` WRITE;
/*!40000 ALTER TABLE `access` DISABLE KEYS */;
INSERT INTO `access` VALUES ('Admin','0');
/*!40000 ALTER TABLE `access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `idUser` int(11) NOT NULL,
  `idShirt` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  PRIMARY KEY (`idUser`,`idShirt`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (2,1,1),(2,2,1),(2,5,1),(2,6,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shirts`
--

DROP TABLE IF EXISTS `shirts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shirts` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Description` varchar(500) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Brand` varchar(45) DEFAULT NULL,
  `Size` varchar(45) DEFAULT NULL,
  `Color` varchar(45) DEFAULT NULL,
  `Image` varchar(500) DEFAULT NULL,
  `Quantity` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shirts`
--

LOCK TABLES `shirts` WRITE;
/*!40000 ALTER TABLE `shirts` DISABLE KEYS */;
INSERT INTO `shirts` VALUES (1,'100% cotton simple black shirt',20,'Summer Shirts','M','Black','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','10'),(2,'100% cotton for the summer',15,'Summer Shirts','S','Red','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(3,'Plain blue long sleeved shirt with red stripes',40,'Comfy Clothes','L','Blue','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(4,'Plain Red long sleeved shirt with White stripes',40,'Comfy Clothes','L','Blue','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(5,'Just a shirt',5,'Comfy Clothes','S','White','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(6,'Keep it casual',15,'Kasual','M','Blue','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(7,'Support your favorite team with this Barcelona FC shirt',80,'Football Shirts','M','Blue','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50'),(8,'Support your favorite team with this Barcelona FC shirt',80,'Football Shirts','M','Red','http://splitsider.awlnetwork.com/wp-content/uploads/sites/2/2012/05/tumblr_m4m270iUfv1r6dybk-e1338300619778.jpeg','50');
/*!40000 ALTER TABLE `shirts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `Type` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Tania','Soto Pineda','tania@domain.com','tania',0),(2,'John','Doe','john@domain.com','john',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-29 22:52:55
