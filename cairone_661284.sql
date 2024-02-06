-- Progettazione Web 
DROP DATABASE if exists cairone_661284; 
CREATE DATABASE cairone_661284; 
USE cairone_661284; 
-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: cairone_661284
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `answer`
--

DROP TABLE IF EXISTS `answer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answer` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Question` int(11) DEFAULT NULL,
  `Author` varchar(20) DEFAULT NULL,
  `Body` text,
  `InsertTimestamp` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answer`
--

LOCK TABLES `answer` WRITE;
/*!40000 ALTER TABLE `answer` DISABLE KEYS */;
INSERT INTO `answer` VALUES (1,4,'john_doe','Puoi validare il codice HTML utilizzando strumenti online come il validatore HTML del W3C. Basta inserire l&#039;URL o incollare direttamente il codice per identificare e correggere eventuali errori.','2024-01-09 22:09:22'),(2,9,'bob_jones','No, HTML Ã¨ un linguaggio di markup per strutturare il contenuto web, non orientato agli oggetti','2024-01-09 22:11:22'),(3,9,'bob_jones','Per la programmazione orientata agli oggetti, guarda ad altri linguaggi, non HTML.','2024-01-09 22:11:42'),(4,9,'alice_smith','Esatto, HTML si concentra sulla presentazione dei dati e sulla struttura delle pagine.','2024-01-09 22:12:50'),(5,1,'alice_smith','In PHP, la connessione a un database coinvolge l&#039;utilizzo di estensioni come MySQLi o PDO. Utilizza le funzioni di connessione appropriate e gestisci le eccezioni per una connessione sicura e robusta.','2024-01-09 22:13:11'),(6,12,'alice_smith','Le temporary table, o tabelle temporanee, sono tabelle che vengono create e utilizzate temporaneamente durante l&#039;esecuzione di un programma o di una query in un database','2024-01-09 22:13:51');
/*!40000 ALTER TABLE `answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `Name` varchar(50) NOT NULL,
  `ImgPath` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES ('CSS','../img/CSS.jpg'),('HTML','../img/HTML.jpg'),('JavaScript','../img/JavaScript.jpg'),('MySQL','../img/MySQL.jpg'),('PHP','../img/PHP.jpg');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question`
--

DROP TABLE IF EXISTS `question`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Author` varchar(20) DEFAULT NULL,
  `Body` text,
  `InsertTimestamp` datetime DEFAULT NULL,
  `Category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question`
--

LOCK TABLES `question` WRITE;
/*!40000 ALTER TABLE `question` DISABLE KEYS */;
INSERT INTO `question` VALUES (1,'bob_jones','Come ci si connette a un database?','2024-01-09 22:04:01','PHP'),(2,'bob_jones','Cosa cambia tra DDL e DML?','2024-01-09 22:04:15','MySQL'),(3,'bob_jones','Cosa vuol dire CASCADE?','2024-01-09 22:04:30','MySQL'),(4,'alice_smith','Come faccio a validare il codice HTML?','2024-01-09 22:05:01','HTML'),(5,'alice_smith','Come rimuovo i duplicati su una colonna?','2024-01-09 22:05:16','MySQL'),(6,'alice_smith','Come funziona il z-index?','2024-01-09 22:05:31','CSS'),(7,'alice_smith','Cosa cambia tra MySql e SqlLite?','2024-01-09 22:05:54','MySQL'),(8,'john_doe','Come inserisco una tabella?','2024-01-09 22:06:55','MySQL'),(9,'john_doe','HTML Ã¨ orientato agli oggetti?','2024-01-09 22:07:07','HTML'),(10,'john_doe','Cosa Ã¨ il DOM?','2024-01-09 22:07:20','JavaScript'),(11,'john_doe','Come ridimensiono delle immagini?','2024-01-09 22:07:49','CSS');
/*!40000 ALTER TABLE `question` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `Username` varchar(20) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `AdditionalInfo` varchar(255) DEFAULT NULL,
  `ImgPath` varchar(256) DEFAULT NULL,
  `JoinedDateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('alice_smith','alice_smith@example.com','$2y$10$OXpOgUisUg9WGgpAa2Tb2.9Rahir2hqbgsD5jJyewhaVbmHWrVole','','../img/profiles/frog.png','2024-01-12 17:03:04'),('bob_jones','bob_jones@example.com','$2y$10$.TjxzZIuAA5qQXgJFuyQOeCVAT5nztDusOQn6jyIorc0FNJZifgXe','Front-end developer ','../img/profiles/penguin.png','2024-01-09 22:02:42'),('john_doe','john_doe@example.com','$2y$10$whmST0ajiGJnneL0fTC36uM7DZykASb6MsEmHg7q7/vpzhClCHqUW','Appassionato di fotografia','../img/profiles/car.jpg','2024-01-09 22:00:41');
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

-- Dump completed on 2024-01-12 17:23:53
