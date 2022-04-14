CREATE DATABASE  IF NOT EXISTS `mestrado` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `mestrado`;
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
-- Table structure for table `rider1`
--

DROP TABLE IF EXISTS `rider1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider1` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider1`
--

LOCK TABLES `rider1` WRITE;
/*!40000 ALTER TABLE `rider1` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider10`
--

DROP TABLE IF EXISTS `rider10`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider10` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider10`
--

LOCK TABLES `rider10` WRITE;
/*!40000 ALTER TABLE `rider10` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider10` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider11`
--

DROP TABLE IF EXISTS `rider11`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider11` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider11`
--

LOCK TABLES `rider11` WRITE;
/*!40000 ALTER TABLE `rider11` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider11` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider12`
--

DROP TABLE IF EXISTS `rider12`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider12` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider12`
--

LOCK TABLES `rider12` WRITE;
/*!40000 ALTER TABLE `rider12` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider12` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider13`
--

DROP TABLE IF EXISTS `rider13`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider13` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider13`
--

LOCK TABLES `rider13` WRITE;
/*!40000 ALTER TABLE `rider13` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider13` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider14`
--

DROP TABLE IF EXISTS `rider14`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider14` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider14`
--

LOCK TABLES `rider14` WRITE;
/*!40000 ALTER TABLE `rider14` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider14` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider15`
--

DROP TABLE IF EXISTS `rider15`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider15` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider15`
--

LOCK TABLES `rider15` WRITE;
/*!40000 ALTER TABLE `rider15` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider15` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider16`
--

DROP TABLE IF EXISTS `rider16`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider16` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider16`
--

LOCK TABLES `rider16` WRITE;
/*!40000 ALTER TABLE `rider16` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider16` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider17`
--

DROP TABLE IF EXISTS `rider17`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider17` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider17`
--

LOCK TABLES `rider17` WRITE;
/*!40000 ALTER TABLE `rider17` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider17` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider18`
--

DROP TABLE IF EXISTS `rider18`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider18` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider18`
--

LOCK TABLES `rider18` WRITE;
/*!40000 ALTER TABLE `rider18` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider18` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider19`
--

DROP TABLE IF EXISTS `rider19`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider19` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider19`
--

LOCK TABLES `rider19` WRITE;
/*!40000 ALTER TABLE `rider19` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider19` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider2`
--

DROP TABLE IF EXISTS `rider2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider2` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider2`
--

LOCK TABLES `rider2` WRITE;
/*!40000 ALTER TABLE `rider2` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider20`
--

DROP TABLE IF EXISTS `rider20`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider20` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider20`
--

LOCK TABLES `rider20` WRITE;
/*!40000 ALTER TABLE `rider20` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider20` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider21`
--

DROP TABLE IF EXISTS `rider21`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider21` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider21`
--

LOCK TABLES `rider21` WRITE;
/*!40000 ALTER TABLE `rider21` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider21` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider22`
--

DROP TABLE IF EXISTS `rider22`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider22` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider22`
--

LOCK TABLES `rider22` WRITE;
/*!40000 ALTER TABLE `rider22` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider22` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider23`
--

DROP TABLE IF EXISTS `rider23`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider23` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider23`
--

LOCK TABLES `rider23` WRITE;
/*!40000 ALTER TABLE `rider23` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider23` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider24`
--

DROP TABLE IF EXISTS `rider24`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider24` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider24`
--

LOCK TABLES `rider24` WRITE;
/*!40000 ALTER TABLE `rider24` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider24` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider25`
--

DROP TABLE IF EXISTS `rider25`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider25` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider25`
--

LOCK TABLES `rider25` WRITE;
/*!40000 ALTER TABLE `rider25` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider25` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider26`
--

DROP TABLE IF EXISTS `rider26`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider26` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider26`
--

LOCK TABLES `rider26` WRITE;
/*!40000 ALTER TABLE `rider26` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider26` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider27`
--

DROP TABLE IF EXISTS `rider27`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider27` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider27`
--

LOCK TABLES `rider27` WRITE;
/*!40000 ALTER TABLE `rider27` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider27` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider28`
--

DROP TABLE IF EXISTS `rider28`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider28` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider28`
--

LOCK TABLES `rider28` WRITE;
/*!40000 ALTER TABLE `rider28` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider28` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider29`
--

DROP TABLE IF EXISTS `rider29`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider29` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider29`
--

LOCK TABLES `rider29` WRITE;
/*!40000 ALTER TABLE `rider29` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider29` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider3`
--

DROP TABLE IF EXISTS `rider3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider3` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider3`
--

LOCK TABLES `rider3` WRITE;
/*!40000 ALTER TABLE `rider3` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider4`
--

DROP TABLE IF EXISTS `rider4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider4` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider4`
--

LOCK TABLES `rider4` WRITE;
/*!40000 ALTER TABLE `rider4` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider5`
--

DROP TABLE IF EXISTS `rider5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider5` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider5`
--

LOCK TABLES `rider5` WRITE;
/*!40000 ALTER TABLE `rider5` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider6`
--

DROP TABLE IF EXISTS `rider6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider6` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider6`
--

LOCK TABLES `rider6` WRITE;
/*!40000 ALTER TABLE `rider6` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider7`
--

DROP TABLE IF EXISTS `rider7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider7` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider7`
--

LOCK TABLES `rider7` WRITE;
/*!40000 ALTER TABLE `rider7` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider8`
--

DROP TABLE IF EXISTS `rider8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider8` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider8`
--

LOCK TABLES `rider8` WRITE;
/*!40000 ALTER TABLE `rider8` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rider9`
--

DROP TABLE IF EXISTS `rider9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rider9` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `creator` varchar(45) DEFAULT NULL,
  `nodes` text,
  `datetime` varchar(45) DEFAULT NULL,
  `latitude_inicial` varchar(45) DEFAULT NULL,
  `longitude_inicial` varchar(45) DEFAULT NULL,
  `latitude_final` varchar(45) DEFAULT NULL,
  `longitude_final` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `distance` varchar(45) DEFAULT NULL,
  `speed` varchar(45) DEFAULT NULL,
  `cadence` varchar(45) DEFAULT NULL,
  `heartrate` varchar(45) DEFAULT NULL,
  `elevation_gain` varchar(45) DEFAULT NULL,
  `elevation_loss` varchar(45) DEFAULT NULL,
  `temperature` varchar(45) DEFAULT NULL,
  `calories` varchar(45) DEFAULT NULL,
  `total_trackpoints` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rider9`
--

LOCK TABLES `rider9` WRITE;
/*!40000 ALTER TABLE `rider9` DISABLE KEYS */;
/*!40000 ALTER TABLE `rider9` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stats`
--

DROP TABLE IF EXISTS `stats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stats` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `total_riders` varchar(45) NOT NULL,
  `total_activities` varchar(45) NOT NULL,
  `total_datasets` varchar(45) NOT NULL,
  `time_extract` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stats`
--

LOCK TABLES `stats` WRITE;
/*!40000 ALTER TABLE `stats` DISABLE KEYS */;
/*!40000 ALTER TABLE `stats` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-14 13:23:44
