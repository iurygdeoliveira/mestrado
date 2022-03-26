-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: mestrado
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ride1`
--

DROP TABLE IF EXISTS `ride1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride1` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride1`
--

LOCK TABLES `ride1` WRITE;
/*!40000 ALTER TABLE `ride1` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride10`
--

DROP TABLE IF EXISTS `ride10`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride10` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride10`
--

LOCK TABLES `ride10` WRITE;
/*!40000 ALTER TABLE `ride10` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride10` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride11`
--

DROP TABLE IF EXISTS `ride11`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride11` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride11`
--

LOCK TABLES `ride11` WRITE;
/*!40000 ALTER TABLE `ride11` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride11` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride12`
--

DROP TABLE IF EXISTS `ride12`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride12` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride12`
--

LOCK TABLES `ride12` WRITE;
/*!40000 ALTER TABLE `ride12` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride12` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride13`
--

DROP TABLE IF EXISTS `ride13`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride13` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride13`
--

LOCK TABLES `ride13` WRITE;
/*!40000 ALTER TABLE `ride13` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride13` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride14`
--

DROP TABLE IF EXISTS `ride14`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride14` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride14`
--

LOCK TABLES `ride14` WRITE;
/*!40000 ALTER TABLE `ride14` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride14` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride15`
--

DROP TABLE IF EXISTS `ride15`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride15` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride15`
--

LOCK TABLES `ride15` WRITE;
/*!40000 ALTER TABLE `ride15` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride15` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride16`
--

DROP TABLE IF EXISTS `ride16`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride16` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride16`
--

LOCK TABLES `ride16` WRITE;
/*!40000 ALTER TABLE `ride16` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride16` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride17`
--

DROP TABLE IF EXISTS `ride17`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride17` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride17`
--

LOCK TABLES `ride17` WRITE;
/*!40000 ALTER TABLE `ride17` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride17` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride18`
--

DROP TABLE IF EXISTS `ride18`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride18` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride18`
--

LOCK TABLES `ride18` WRITE;
/*!40000 ALTER TABLE `ride18` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride18` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride19`
--

DROP TABLE IF EXISTS `ride19`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride19` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride19`
--

LOCK TABLES `ride19` WRITE;
/*!40000 ALTER TABLE `ride19` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride19` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride2`
--

DROP TABLE IF EXISTS `ride2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride2` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride2`
--

LOCK TABLES `ride2` WRITE;
/*!40000 ALTER TABLE `ride2` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride20`
--

DROP TABLE IF EXISTS `ride20`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride20` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride20`
--

LOCK TABLES `ride20` WRITE;
/*!40000 ALTER TABLE `ride20` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride20` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride21`
--

DROP TABLE IF EXISTS `ride21`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride21` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride21`
--

LOCK TABLES `ride21` WRITE;
/*!40000 ALTER TABLE `ride21` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride21` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride22`
--

DROP TABLE IF EXISTS `ride22`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride22` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride22`
--

LOCK TABLES `ride22` WRITE;
/*!40000 ALTER TABLE `ride22` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride22` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride23`
--

DROP TABLE IF EXISTS `ride23`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride23` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride23`
--

LOCK TABLES `ride23` WRITE;
/*!40000 ALTER TABLE `ride23` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride23` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride24`
--

DROP TABLE IF EXISTS `ride24`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride24` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride24`
--

LOCK TABLES `ride24` WRITE;
/*!40000 ALTER TABLE `ride24` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride24` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride25`
--

DROP TABLE IF EXISTS `ride25`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride25` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride25`
--

LOCK TABLES `ride25` WRITE;
/*!40000 ALTER TABLE `ride25` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride25` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride26`
--

DROP TABLE IF EXISTS `ride26`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride26` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride26`
--

LOCK TABLES `ride26` WRITE;
/*!40000 ALTER TABLE `ride26` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride26` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride27`
--

DROP TABLE IF EXISTS `ride27`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride27` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride27`
--

LOCK TABLES `ride27` WRITE;
/*!40000 ALTER TABLE `ride27` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride27` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride28`
--

DROP TABLE IF EXISTS `ride28`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride28` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride28`
--

LOCK TABLES `ride28` WRITE;
/*!40000 ALTER TABLE `ride28` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride28` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride29`
--

DROP TABLE IF EXISTS `ride29`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride29` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride29`
--

LOCK TABLES `ride29` WRITE;
/*!40000 ALTER TABLE `ride29` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride29` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride3`
--

DROP TABLE IF EXISTS `ride3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride3` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride3`
--

LOCK TABLES `ride3` WRITE;
/*!40000 ALTER TABLE `ride3` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride4`
--

DROP TABLE IF EXISTS `ride4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride4` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride4`
--

LOCK TABLES `ride4` WRITE;
/*!40000 ALTER TABLE `ride4` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride5`
--

DROP TABLE IF EXISTS `ride5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride5` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride5`
--

LOCK TABLES `ride5` WRITE;
/*!40000 ALTER TABLE `ride5` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride6`
--

DROP TABLE IF EXISTS `ride6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride6` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride6`
--

LOCK TABLES `ride6` WRITE;
/*!40000 ALTER TABLE `ride6` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride7`
--

DROP TABLE IF EXISTS `ride7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride7` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride7`
--

LOCK TABLES `ride7` WRITE;
/*!40000 ALTER TABLE `ride7` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride8`
--

DROP TABLE IF EXISTS `ride8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride8` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride8`
--

LOCK TABLES `ride8` WRITE;
/*!40000 ALTER TABLE `ride8` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ride9`
--

DROP TABLE IF EXISTS `ride9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ride9` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  `totaltime` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `avgspeed` varchar(45) DEFAULT NULL,
  `maxspeed` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `avgheart` varchar(45) DEFAULT NULL,
  `minheart` varchar(45) DEFAULT NULL,
  `maxheart` varchar(45) DEFAULT NULL,
  `avgtemp` varchar(45) DEFAULT NULL,
  `avgcadence` varchar(45) DEFAULT NULL,
  `mincadence` varchar(45) DEFAULT NULL,
  `maxcadence` varchar(45) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `latitude` varchar(45) DEFAULT NULL,
  `longitude` varchar(45) DEFAULT NULL,
  `highest` varchar(45) DEFAULT NULL,
  `lowest` varchar(45) DEFAULT NULL,
  `elevationGain` varchar(45) DEFAULT NULL,
  `elevationLoss` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ride9`
--

LOCK TABLES `ride9` WRITE;
/*!40000 ALTER TABLE `ride9` DISABLE KEYS */;
/*!40000 ALTER TABLE `ride9` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trackpoint`
--

DROP TABLE IF EXISTS `trackpoint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `trackpoint` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `altitude` varchar(255) DEFAULT NULL,
  `distance` varchar(255) DEFAULT NULL,
  `heartrate` varchar(255) DEFAULT NULL,
  `cadence` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `elevation` varchar(255) DEFAULT NULL,
  `speed` varchar(255) DEFAULT NULL,
  `ride_id` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_segment_biking1_idx` (`ride_id`),
  CONSTRAINT `fk_trackpoint_ride` FOREIGN KEY (`ride_id`) REFERENCES `ride6` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trackpoint`
--

LOCK TABLES `trackpoint` WRITE;
/*!40000 ALTER TABLE `trackpoint` DISABLE KEYS */;
/*!40000 ALTER TABLE `trackpoint` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-26  9:26:05
