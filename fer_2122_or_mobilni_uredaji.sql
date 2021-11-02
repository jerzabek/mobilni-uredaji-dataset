-- MySQL dump 10.13  Distrib 8.0.18, for Win64 (x86_64)
--
-- Host: localhost    Database: fer_2122_or_mobilni_uredaji
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.14-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `camera`
--

DROP TABLE IF EXISTS `camera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `camera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `horizontal_resolution` int(11) DEFAULT NULL,
  `vertical_resolution` int(11) DEFAULT NULL,
  `resolution` int(11) DEFAULT NULL,
  `apature` varchar(100) NOT NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  CONSTRAINT `camera_ibfk_1` FOREIGN KEY (`position`) REFERENCES `camera_position` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `camera`
--

LOCK TABLES `camera` WRITE;
/*!40000 ALTER TABLE `camera` DISABLE KEYS */;
INSERT INTO `camera` VALUES (3,'Main standard camera',NULL,NULL,16,'f/1.7',2),(4,'Ultrawide camera',NULL,NULL,5,'f/2.2',2),(5,'Selfie camera',NULL,NULL,25,'f/2.0',1),(6,'Main standard camera',3840,2160,32,'f/1.7',2),(7,'Ultrawide camera',NULL,NULL,8,'f/2.2',2),(8,'Depth sensor camera',NULL,NULL,5,'f/2.2',2),(9,'Selfie camera',NULL,NULL,32,'f/2.0',1),(10,'Standard main camera',NULL,NULL,12,'f/1.6',2),(11,'Ultrawide camera',NULL,NULL,12,'f/2.4',2),(12,'TrueDepth camera',NULL,NULL,12,'f/2.2',2),(13,'Standard main camera',NULL,NULL,108,'f/1.9',2),(14,'Ultrawide camera',NULL,NULL,13,'f/2.4',2),(15,'Macro lense camera',NULL,NULL,5,'f/2.4',2),(16,'Selfie camera',NULL,NULL,20,'f/2.2',1),(21,'Standard main camera',NULL,NULL,12,'f/1.8',2),(22,'Telephoto camera',NULL,NULL,64,'f/2.0',2),(23,'Ultrawide camera',NULL,NULL,12,'f/2.2',2),(24,'Selife camera',NULL,NULL,10,'f/2.2',1),(25,'Standard main camera',NULL,NULL,8,'f/2.4',2),(26,'Selfie camera',NULL,NULL,1,'f/2.4',1),(27,'Standard main camera',NULL,NULL,13,'f/2.2',2),(28,'Selife camera',NULL,NULL,2,'f/2.4',1),(29,'Standard main camera',NULL,NULL,12,'f/2.4',2),(30,'Ultrawide camera',NULL,NULL,16,'f/2.2',2),(31,'Selife camera',NULL,NULL,10,'f/1.9',1);
/*!40000 ALTER TABLE `camera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `camera_position`
--

DROP TABLE IF EXISTS `camera_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `camera_position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `camera_position`
--

LOCK TABLES `camera_position` WRITE;
/*!40000 ALTER TABLE `camera_position` DISABLE KEYS */;
INSERT INTO `camera_position` VALUES (1,'front'),(2,'back');
/*!40000 ALTER TABLE `camera_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `charging_port`
--

DROP TABLE IF EXISTS `charging_port`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `charging_port` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charging_port`
--

LOCK TABLES `charging_port` WRITE;
/*!40000 ALTER TABLE `charging_port` DISABLE KEYS */;
INSERT INTO `charging_port` VALUES (1,'USB-C'),(2,'Lightning'),(3,'Micro USB'),(4,'Proprietary');
/*!40000 ALTER TABLE `charging_port` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'Samsung'),(2,'Qualcomm'),(3,'Apple'),(4,'Xiaomi'),(5,'Texas Instruments'),(6,'Nokia');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone`
--

DROP TABLE IF EXISTS `phone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `release_date` date NOT NULL,
  `brand` int(11) NOT NULL,
  `processor` int(11) NOT NULL,
  `width` double NOT NULL,
  `height` double NOT NULL,
  `thickness` double NOT NULL,
  `screen_size` double NOT NULL,
  `vertical_resolution` int(11) NOT NULL,
  `horizontal_resolution` int(11) NOT NULL,
  `charging_port` int(11) NOT NULL,
  `headphone_jack` tinyint(1) NOT NULL,
  `microsd` tinyint(1) NOT NULL,
  `wireless_charging` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand` (`brand`),
  KEY `processor` (`processor`),
  KEY `charging_port` (`charging_port`),
  CONSTRAINT `phone_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `company` (`id`),
  CONSTRAINT `phone_ibfk_2` FOREIGN KEY (`charging_port`) REFERENCES `charging_port` (`id`),
  CONSTRAINT `phone_ibfk_3` FOREIGN KEY (`processor`) REFERENCES `processor` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone`
--

LOCK TABLES `phone` WRITE;
/*!40000 ALTER TABLE `phone` DISABLE KEYS */;
INSERT INTO `phone` VALUES (2,'Galaxy A40','2019-04-01',1,1,144.3,69.1,7.9,5.9,2280,1080,1,1,1,0),(3,'Galaxy A70','2019-05-01',1,2,164.3,76.7,7.9,6.7,2400,1080,1,1,1,0),(4,'iPhone 13','2021-09-24',3,3,71.5,146.7,7.65,6.1,1170,2532,2,0,0,1),(5,'iPhone 13 Mini','2021-09-24',3,3,64.2,131.5,7.65,5.4,1080,2340,2,0,0,1),(6,'Mi 11','2020-12-28',4,4,164.3,74.6,8.1,6.81,3200,1440,1,0,0,1),(7,'Galaxy Note 20','2020-08-21',1,5,161.6,75.2,8.3,6.7,2400,1080,1,0,0,1),(8,'iPhone 5','2012-09-21',3,6,123.8,58.6,7.6,4,1136,640,2,1,0,0),(9,'Galaxy S4','2013-04-01',1,7,136.6,69.8,7.9,5,1920,1080,3,1,1,0),(10,'Nokia 3310','2000-09-01',6,8,113,48,22,2.4,320,240,4,0,0,0),(11,'Samsung Galaxy S10e','2019-03-08',1,9,142.2,69.9,7.9,5.8,2280,1080,1,1,1,0);
/*!40000 ALTER TABLE `phone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phone_camera`
--

DROP TABLE IF EXISTS `phone_camera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `phone_camera` (
  `phone_id` int(11) NOT NULL,
  `camera_id` int(11) NOT NULL,
  KEY `phone_id` (`phone_id`),
  KEY `camera_id` (`camera_id`),
  CONSTRAINT `phone_camera_ibfk_1` FOREIGN KEY (`camera_id`) REFERENCES `camera` (`id`),
  CONSTRAINT `phone_camera_ibfk_2` FOREIGN KEY (`phone_id`) REFERENCES `phone` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phone_camera`
--

LOCK TABLES `phone_camera` WRITE;
/*!40000 ALTER TABLE `phone_camera` DISABLE KEYS */;
INSERT INTO `phone_camera` VALUES (2,3),(2,5),(2,4),(3,9),(3,8),(3,7),(3,6),(5,10),(5,11),(4,10),(4,11),(4,12),(5,12),(6,13),(6,14),(6,15),(6,16),(7,24),(7,23),(7,22),(7,21),(8,25),(8,26),(9,27),(9,28),(11,29),(11,30),(11,31);
/*!40000 ALTER TABLE `phone_camera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `processor`
--

DROP TABLE IF EXISTS `processor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `processor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `cores` tinyint(4) NOT NULL,
  `clock_speed` double DEFAULT NULL,
  `brand` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `brand` (`brand`),
  CONSTRAINT `processor_ibfk_1` FOREIGN KEY (`brand`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `processor`
--

LOCK TABLES `processor` WRITE;
/*!40000 ALTER TABLE `processor` DISABLE KEYS */;
INSERT INTO `processor` VALUES (1,'Samsung Exynos 7885',8,1.8,1),(2,'Qualcomm Snapdragon 675',8,2,2),(3,'A15 Bionic chip',6,NULL,3),(4,'Qualcomm Snapdragon 888',8,2.8,2),(5,'Exynos 990',8,2.73,1),(6,'Apple A6',2,1.3,3),(7,'Exynos 5410',8,1.6,1),(8,'Texas Instruments MAD2WD1',1,0.13,5),(9,'Snapdragon 855',8,2.73,2);
/*!40000 ALTER TABLE `processor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-02  1:31:43
