-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: family_finance_database
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `budgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `limit_amount` decimal(10,2) NOT NULL,
  `period_type` enum('monthly','yearly') NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `family_id` (`family_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `budgets_ibfk_1` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`),
  CONSTRAINT `budgets_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

LOCK TABLES `budgets` WRITE;
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` enum('expense','income') NOT NULL,
  `is_global` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `idx_type` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Jedzenie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(2,'Transport','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(3,'Zakwaterowanie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(4,'Rozrywka','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(5,'Zdrowie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(6,'Ubrania i obuwie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(7,'Edukacja','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(8,'Dom i mieszkanie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(9,'Hobby','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(10,'Technologia','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(11,'Podróże','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(12,'Sport','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(13,'Kosmetyki i higiena','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(14,'Zwierzaki','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(15,'Opłaty i rachunki','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(16,'Prezenty i okazje','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(17,'Darowizny i wsparcie','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(18,'Finanse i inwestycje','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(19,'Ubezpieczenia','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(20,'Inne wydatki','expense',1,'2025-10-18 19:22:33','2025-10-18 19:22:33'),(21,'Przychody z pracy','income',1,'2025-10-18 19:22:45','2025-10-18 19:22:45'),(22,'Przychody dodatkowe','income',1,'2025-10-18 19:22:45','2025-10-18 19:22:45'),(23,'Inwestycje','income',1,'2025-10-18 19:22:45','2025-10-18 19:22:45'),(24,'Darowizny i prezenty','income',1,'2025-10-18 19:22:45','2025-10-18 19:22:45'),(25,'Sprzedaż rzeczy używanych','income',1,'2025-10-18 19:22:45','2025-10-18 19:22:45');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exchange_rates`
--

DROP TABLE IF EXISTS `exchange_rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `base_currency` varchar(10) NOT NULL,
  `target_currency` varchar(10) NOT NULL,
  `rate` decimal(18,8) NOT NULL,
  `last_updated` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_rate` (`base_currency`,`target_currency`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exchange_rates`
--

LOCK TABLES `exchange_rates` WRITE;
/*!40000 ALTER TABLE `exchange_rates` DISABLE KEYS */;
/*!40000 ALTER TABLE `exchange_rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `families`
--

DROP TABLE IF EXISTS `families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `families` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_name` varchar(100) NOT NULL,
  `region` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `families`
--

LOCK TABLES `families` WRITE;
/*!40000 ALTER TABLE `families` DISABLE KEYS */;
INSERT INTO `families` VALUES (1,'Rodzina Kowalskich','mazowieckie','2025-10-15 19:12:43'),(2,'Nowak Family','śląskie','2025-10-15 19:12:43'),(3,'Smith Household','małopolskie','2025-10-15 19:12:43'),(4,'Rodzina Wiśniewskich','wielkopolskie','2025-10-15 19:12:43'),(5,'nowa testowa','dolnośląskie','2025-10-17 17:02:09'),(7,'nowa testowaa','kujawsko-pomorskie','2025-10-17 17:06:23'),(8,'test nowej rodziny','wielkopolskie','2025-10-17 17:08:46'),(9,'testowa2','świętokrzyskie','2025-10-17 17:14:11'),(10,'kolejny test','śląskie','2025-10-17 17:25:26'),(11,'rodzina adamsow','podkarpackie','2025-10-17 17:36:54'),(12,'RODZINA USEROW','dolnośląskie','2025-10-17 17:42:02'),(13,'test','dolnośląskie','2025-10-17 19:09:52'),(14,'nowa testowa','kujawsko-pomorskie','2025-10-17 19:39:43'),(15,'nowa testowa','dolnośląskie','2025-10-17 20:00:25'),(17,'TESTPOUID','lubuskie','2025-10-18 09:38:43'),(18,'adifamily','podkarpackie','2025-10-18 10:04:07'),(20,'XD2','łódzkie','2025-10-18 12:20:52'),(21,'emkowscy','świętokrzyskie','2025-10-18 15:56:16'),(22,'zxq','kujawsko-pomorskie','2025-10-18 16:06:10'),(23,'XDDD2','dolnośląskie','2025-10-18 18:12:03'),(24,'test','małopolskie','2025-10-22 17:36:28'),(25,'nowa testowa','kujawsko-pomorskie','2025-10-22 17:50:55'),(26,'test','lubelskie','2025-10-22 17:51:29'),(27,'test nowej rodziny','łódzkie','2025-10-22 17:55:12'),(28,'test','lubuskie','2025-10-22 17:56:23'),(29,'123zc','łódzkie','2025-10-22 17:59:33'),(31,'xd123','kujawsko-pomorskie','2025-10-26 15:13:46');
/*!40000 ALTER TABLE `families` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feedbacks`
--

DROP TABLE IF EXISTS `feedbacks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `type` enum('bug','suggestion','category_proposal','support') NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('new','in_progress','resolved') DEFAULT 'new',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `feedbacks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feedbacks`
--

LOCK TABLES `feedbacks` WRITE;
/*!40000 ALTER TABLE `feedbacks` DISABLE KEYS */;
INSERT INTO `feedbacks` VALUES (1,43,'','asd','asd','2025-10-25 12:18:11','in_progress'),(2,43,'','asd','asd','2025-10-25 12:19:44','new'),(3,43,'','asdasdasd','sadasdas','2025-10-25 12:20:47','new'),(4,43,'','12d','21d','2025-10-25 12:21:17','new'),(5,43,'','asc','123','2025-10-25 12:22:14','new'),(6,43,'','12d','21d','2025-10-25 12:22:28','new'),(7,43,'','12d','21d','2025-10-25 12:23:30','new'),(8,43,'','21d','21d','2025-10-25 12:24:05','new'),(9,43,'','123','asc','2025-10-25 12:24:54','new'),(10,43,'','asc','asc','2025-10-25 12:25:11','new'),(11,43,'','asc','asc','2025-10-25 12:25:47','new'),(12,43,'','asc','asc','2025-10-25 12:27:00','new'),(13,43,'bug','asd','sad','2025-10-25 12:27:11','new'),(14,43,'bug','bład podczas dodawnai transakcji','asd','2025-10-25 12:35:49','in_progress'),(15,43,'suggestion','dodac cos tam','asdafas','2025-10-25 12:35:56','new'),(16,43,'category_proposal','wóda','asdasdasd','2025-10-25 12:36:04','resolved'),(17,43,'support','nie dziala mi','asdasdas','2025-10-25 12:36:10','new'),(18,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:37:18','new'),(19,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:09','new'),(20,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:13','new'),(21,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:15','new'),(22,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:17','new'),(23,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:18','new'),(24,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:19','new'),(25,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:21','resolved'),(26,45,'suggestion','wqqqwc','xzczxc','2025-10-25 12:41:22','resolved'),(27,56,'bug','dsvdsVEQWVQW','V12V12V21EHseWyQwTe5kjje4h','2025-10-25 12:48:11','resolved'),(28,2,'suggestion','ascascas32t','21v12v21v','2025-10-25 13:34:53','resolved'),(29,43,'support','nie dziala mi dodawanie czlownkow rodziny','asebeb','2025-10-25 18:00:14','in_progress');
/*!40000 ALTER TABLE `feedbacks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recurring_transactions`
--

DROP TABLE IF EXISTS `recurring_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recurring_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_template_id` int(11) NOT NULL,
  `frequency` enum('daily','weekly','monthly','yearly') NOT NULL,
  `next_due_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaction_template_id` (`transaction_template_id`),
  CONSTRAINT `recurring_transactions_ibfk_1` FOREIGN KEY (`transaction_template_id`) REFERENCES `transactions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recurring_transactions`
--

LOCK TABLES `recurring_transactions` WRITE;
/*!40000 ALTER TABLE `recurring_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `recurring_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `family_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_global` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=232 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (89,1,NULL,NULL,'Chleb i pieczywo','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(90,1,NULL,NULL,'Owoce','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(91,1,NULL,NULL,'Warzywa','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(92,1,NULL,NULL,'Mięso','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(93,1,NULL,NULL,'Ryby i owoce morza','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(94,1,NULL,NULL,'Nabiał','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(95,1,NULL,NULL,'Przekąski','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(96,1,NULL,NULL,'Słodycze','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(97,1,NULL,NULL,'Fast food','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(98,1,NULL,NULL,'Napoje alkoholowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(99,1,NULL,NULL,'Napoje bezalkoholowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(100,1,NULL,NULL,'Przyprawy i dodatki','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(101,1,NULL,NULL,'Produkty dietetyczne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(102,2,NULL,NULL,'Paliwo','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(103,2,NULL,NULL,'Bilety komunikacji miejskiej','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(104,2,NULL,NULL,'Taxi / Uber / Bolt','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(105,2,NULL,NULL,'Parking','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(106,2,NULL,NULL,'Ubezpieczenie pojazdu','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(107,2,NULL,NULL,'Przeglądy i naprawy','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(108,2,NULL,NULL,'Części samochodowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(109,2,NULL,NULL,'Wypożyczenie auta','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(110,2,NULL,NULL,'Rower i akcesoria','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(111,3,NULL,NULL,'Czynsz','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(112,3,NULL,NULL,'Media','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(113,3,NULL,NULL,'Internet i TV','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(114,3,NULL,NULL,'Remonty i naprawy','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(115,3,NULL,NULL,'Umeblowanie','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(116,3,NULL,NULL,'Sprzątanie','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(117,3,NULL,NULL,'Materiały budowlane','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(118,4,NULL,NULL,'Kino','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(119,4,NULL,NULL,'Teatr','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(120,4,NULL,NULL,'Koncerty','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(121,4,NULL,NULL,'Gry komputerowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(122,4,NULL,NULL,'Sport i fitness','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(123,4,NULL,NULL,'Książki','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(124,4,NULL,NULL,'Streaming','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(125,4,NULL,NULL,'Wycieczki','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(126,4,NULL,NULL,'Hobby i rękodzieło','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(127,5,NULL,NULL,'Wizyta lekarska','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(128,5,NULL,NULL,'Dentysta','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(129,5,NULL,NULL,'Leki','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(130,5,NULL,NULL,'Suplementy','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(131,5,NULL,NULL,'Fizjoterapia','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(132,5,NULL,NULL,'Kosmetologia','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(133,5,NULL,NULL,'Psycholog / Terapia','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(134,6,NULL,NULL,'Buty','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(135,6,NULL,NULL,'Koszule i T-shirty','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(136,6,NULL,NULL,'Spodnie','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(137,6,NULL,NULL,'Kurtki i płaszcze','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(138,6,NULL,NULL,'Bielizna','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(139,6,NULL,NULL,'Dodatki i biżuteria','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(140,7,NULL,NULL,'Szkoła','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(141,7,NULL,NULL,'Kursy i szkolenia','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(142,7,NULL,NULL,'Materiały edukacyjne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(143,7,NULL,NULL,'Egzaminy i certyfikaty','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(144,8,NULL,NULL,'Meble','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(145,8,NULL,NULL,'Dekoracje','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(146,8,NULL,NULL,'Artykuły domowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(147,8,NULL,NULL,'Sprzęt AGD','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(148,8,NULL,NULL,'Sprzęt RTV','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(149,9,NULL,NULL,'Instrumenty muzyczne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(150,9,NULL,NULL,'Materiały plastyczne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(151,9,NULL,NULL,'Modelarstwo','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(152,9,NULL,NULL,'Gry planszowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(153,10,NULL,NULL,'Komputery','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(154,10,NULL,NULL,'Smartfony','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(155,10,NULL,NULL,'Tablety','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(156,10,NULL,NULL,'Akcesoria','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(157,10,NULL,NULL,'Oprogramowanie','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(158,11,NULL,NULL,'Hotele','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(159,11,NULL,NULL,'Bilety lotnicze','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(160,11,NULL,NULL,'Pociągi','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(161,11,NULL,NULL,'Wynajem samochodu','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(162,11,NULL,NULL,'Wycieczki zorganizowane','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(163,12,NULL,NULL,'Siłownia','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(164,12,NULL,NULL,'Kluby sportowe','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(165,12,NULL,NULL,'Sprzęt sportowy','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(166,12,NULL,NULL,'Odzież sportowa','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(167,13,NULL,NULL,'Kosmetyki','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(168,13,NULL,NULL,'Higiena osobista','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(169,13,NULL,NULL,'Perfumy','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(170,13,NULL,NULL,'Akcesoria do makijażu','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(171,14,NULL,NULL,'Karma','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(172,14,NULL,NULL,'Weterynarz','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(173,14,NULL,NULL,'Akcesoria','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(174,15,NULL,NULL,'Telefon','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(175,15,NULL,NULL,'Internet','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(176,15,NULL,NULL,'Prąd','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(177,15,NULL,NULL,'Woda','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(178,15,NULL,NULL,'Gaz','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(179,16,NULL,NULL,'Prezenty dla rodziny','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(180,16,NULL,NULL,'Prezenty dla przyjaciół','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(181,16,NULL,NULL,'Okazje świąteczne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(182,17,NULL,NULL,'Organizacje charytatywne','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(183,17,NULL,NULL,'Pomoc lokalna','2025-10-18 19:23:49','2025-10-18 19:23:49',1),(184,21,NULL,NULL,'Wypłata podstawowa','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(185,21,NULL,NULL,'Premie i bonusy','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(186,21,NULL,NULL,'Nagrody i dodatki','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(187,22,NULL,NULL,'Freelance / Projekty','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(188,22,NULL,NULL,'Sprzedaż rzeczy używanych','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(189,22,NULL,NULL,'Darowizny od znajomych','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(190,22,NULL,NULL,'Inne źródła','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(191,23,NULL,NULL,'Dywidendy','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(192,23,NULL,NULL,'Odsetki bankowe','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(193,23,NULL,NULL,'Kryptowaluty','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(194,23,NULL,NULL,'Akcje i obligacje','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(195,24,NULL,NULL,'Od rodziny','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(196,24,NULL,NULL,'Od przyjaciół','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(197,24,NULL,NULL,'Od organizacji','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(198,25,NULL,NULL,'Odzież','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(199,25,NULL,NULL,'Elektronika','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(200,25,NULL,NULL,'Meble','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(201,25,NULL,NULL,'Książki i multimedia','2025-10-18 19:24:11','2025-10-18 19:24:11',1),(224,1,NULL,58,'test dla zwyklego usera','2025-10-26 14:54:50','2025-10-26 14:54:50',0),(225,1,NULL,58,'test dla usera2','2025-10-26 14:55:16','2025-10-26 14:55:16',0),(226,2,NULL,58,'test dla usera 3','2025-10-26 14:57:06','2025-10-26 14:57:06',0),(227,1,20,43,'test dla rodziny','2025-10-26 14:57:51','2025-10-26 14:57:51',0),(228,2,20,43,'test dla rodziny','2025-10-26 14:58:01','2025-10-26 14:58:01',0),(229,1,20,44,'asdasd','2025-10-26 15:16:36','2025-10-26 15:16:36',0),(230,1,20,43,'asdasf13212','2025-10-26 16:00:44','2025-10-26 16:00:44',0),(231,1,31,61,'1212d1','2025-10-26 16:14:16','2025-10-26 16:14:16',0);
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transaction_items`
--

DROP TABLE IF EXISTS `transaction_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `transaction_id` (`transaction_id`),
  KEY `fk_items_category` (`category_id`),
  KEY `fk_sub_category_idx` (`sub_category_id`),
  CONSTRAINT `fk_items_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_sub_category` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transaction_items`
--

LOCK TABLES `transaction_items` WRITE;
/*!40000 ALTER TABLE `transaction_items` DISABLE KEYS */;
INSERT INTO `transaction_items` VALUES (1,61,1,89,133.00,1),(2,66,2,99,5.00,1),(3,66,2,101,5.00,1),(4,67,1,184,5000.00,1),(5,67,1,89,10.00,2),(6,68,21,184,5000.00,1),(19,79,1,89,4.00,3),(20,79,1,91,4.00,2),(21,79,1,94,4.00,3),(22,79,1,93,13.00,1),(23,80,1,89,4.00,4),(25,82,1,89,3.99,1),(26,82,1,89,0.70,3),(27,82,1,92,20.00,2),(28,82,1,96,0.45,4),(29,83,1,89,4.00,1),(30,83,1,89,4.00,1),(38,88,2,103,3.00,1),(39,89,2,106,555.00,1);
/*!40000 ALTER TABLE `transaction_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `local_category_id` int(11) DEFAULT NULL,
  `type` enum('expense','income') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `payment_method` enum('cash','card','crypto') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `transaction_date` datetime NOT NULL,
  `is_recurring` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `receipt_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  KEY `transactions_ibfk_1` (`family_id`),
  CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`),
  CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `CONSTRAINT_1` CHECK (`category_id` is not null or `local_category_id` is not null)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (35,20,43,21,NULL,'income',5000.00,'PLN','card','','2025-10-19 12:12:00',0,'2025-10-19 12:13:04',NULL),(37,20,43,5,NULL,'expense',1111.00,'USD','cash','','2025-10-19 12:24:00',0,'2025-10-19 12:25:06',NULL),(38,20,43,22,NULL,'income',5.00,'BTC','crypto','test','2025-10-19 12:28:00',0,'2025-10-19 12:29:24',NULL),(39,NULL,45,25,NULL,'income',20.00,'PLN','cash','','2025-10-19 12:56:00',0,'2025-10-19 12:56:32',NULL),(40,NULL,45,7,NULL,'expense',1.00,'PLN','cash','TEST DLA ZWYKLEGO USERA','2025-10-19 13:00:00',0,'2025-10-19 13:01:03',NULL),(41,NULL,45,20,NULL,'expense',1.00,'BTC','crypto','teststst','2025-10-19 13:13:00',1,'2025-10-19 13:14:04',NULL),(42,NULL,45,1,NULL,'income',1.00,'PLN','cash','test123','2025-10-19 13:18:00',1,'2025-10-19 13:18:30',NULL),(43,NULL,45,2,NULL,'income',1.00,'USD','cash','','2025-10-19 13:19:00',0,'2025-10-19 13:19:58',NULL),(44,20,43,3,NULL,'income',3.00,'USD','cash','testczx','2025-10-19 13:21:00',0,'2025-10-19 13:21:25',NULL),(45,20,43,1,NULL,'income',1.00,'PLN','crypto','','2025-10-19 13:24:00',1,'2025-10-19 13:24:50',NULL),(46,20,44,2,NULL,'income',123.00,'PLN','crypto','test przez czlonka rodziny nie admina','2025-10-19 13:36:00',0,'2025-10-19 13:36:58',NULL),(47,20,45,2,NULL,'expense',512.00,'EUR','cash','xdddd','2025-10-19 13:44:00',1,'2025-10-19 13:44:23',NULL),(49,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:17:22',NULL),(50,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:22:45',NULL),(51,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:23:00',NULL),(52,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:23:52',NULL),(53,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:25:33',NULL),(54,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:25:43',NULL),(55,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:44:04',NULL),(56,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:45:05',NULL),(57,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:45:19',NULL),(58,20,43,1,NULL,'expense',129.99,'PLN','cash','sprawdzenie czy poprawnie dodaje elementy transakcji z podkategoria','2025-10-19 18:17:00',0,'2025-10-19 18:47:08',NULL),(59,20,43,1,NULL,'expense',148.00,'PLN','cash','tes123','2025-10-19 18:48:00',0,'2025-10-19 18:48:32',NULL),(60,20,43,1,NULL,'expense',148.00,'PLN','cash','tes123','2025-10-19 18:48:00',0,'2025-10-19 18:49:46',NULL),(61,20,43,1,NULL,'expense',148.00,'PLN','cash','tes123','2025-10-19 18:48:00',0,'2025-10-19 18:50:53',NULL),(62,20,43,1,NULL,'expense',45.00,'PLN','cash','test podkategorii','2025-10-19 18:51:00',0,'2025-10-19 18:51:44',NULL),(63,20,43,1,NULL,'expense',45.00,'PLN','cash','test podkategorii','2025-10-19 18:51:00',0,'2025-10-19 18:53:22',NULL),(64,20,43,1,NULL,'expense',45.00,'PLN','cash','test podkategorii','2025-10-19 18:51:00',0,'2025-10-19 18:54:01',NULL),(65,20,43,2,NULL,'expense',10.00,'PLN','cash','','2025-10-19 18:54:00',0,'2025-10-19 18:55:06',NULL),(66,20,43,2,NULL,'expense',10.00,'PLN','cash','','2025-10-19 18:54:00',0,'2025-10-19 18:58:23',NULL),(67,20,43,1,NULL,'income',5020.00,'PLN','cash','','2025-10-19 19:01:00',0,'2025-10-19 19:01:19',NULL),(68,20,43,21,NULL,'income',5000.00,'PLN','cash','','2025-10-19 19:02:00',0,'2025-10-19 19:02:25',NULL),(79,20,43,1,NULL,'expense',45.00,'PLN','card','zakupy biedra','2025-10-22 19:06:00',0,'2025-10-22 19:07:05',NULL),(80,20,43,1,NULL,'expense',16.00,'PLN','cash','','2025-10-22 19:08:00',0,'2025-10-22 19:08:09',NULL),(82,NULL,55,1,NULL,'expense',47.89,'PLN','card','zakupy w spolem','2025-10-22 19:26:00',0,'2025-10-22 19:27:45',NULL),(83,24,55,1,NULL,'expense',8.00,'PLN','cash','','2025-10-22 19:37:00',0,'2025-10-22 19:37:43',NULL),(88,NULL,61,2,NULL,'income',3.00,'PLN','card','','2025-10-26 16:13:00',0,'2025-10-26 16:13:35',NULL),(89,31,61,2,NULL,'income',555.00,'PLN','cash','','2025-10-26 16:14:00',0,'2025-10-26 16:14:05',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('member','admin') NOT NULL DEFAULT 'member',
  `account_type` enum('standard','premium') NOT NULL DEFAULT 'standard',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `family_role` enum('family_member','family_admin') DEFAULT NULL,
  `UID` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `users_ibfk_1` (`family_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,1,'jan_kowalski','jan.kowalski@email.com','$2a$12$RXYyUxU5oLCs7iCLv1GkDO0TDgaCflw.hlvItcTTRLohqBGB0UTe6','admin','premium','2025-10-15 19:12:43',NULL,''),(26,12,'user2','user2@user2.com','$2y$10$OP55gGNk0eaIL3VUHG5P4uPSCZHwmbQZ/w86ynVnmJq7dwc/TTr1W','member','standard','2025-10-17 17:42:38',NULL,''),(27,18,'uidtest','uidtest@test.com','$2y$10$smODystW//JBhg/1Fm2zq.8YHqx9bm/mjJZNaWGkA3S8FRJi9bf8m','member','standard','2025-10-17 18:47:12','family_member','6xG+dlqHwv'),(28,17,'test1','test1@test.com','$2y$10$1UfrS8Lf0omqCcZkzbRiTeQaaXAbG4.FH/PApQHZk3aJImm9Kd03m','member','standard','2025-10-17 18:49:06','family_member','DnWYTVrY22'),(29,22,'testuid','testuid@mail.com','$2y$10$nl8bOvXxPN.ow6bLvP9xguU/24ZwckN0E5PYrY2tNauMqkdn4DUBO','member','standard','2025-10-17 18:50:53','family_member','WBjiBPzVW)'),(30,13,'test11111','test1111111@test.com','$2y$10$WemY4lq29ly50hR4U2XUvuTO6j2rWHGnCh/dntTqb5I0N4zVxRdSq','member','standard','2025-10-17 19:02:37','family_admin','uZ5=L=3Jyi'),(31,NULL,'testowy1','testowy1@email.com','$2y$10$n8NNGiPC/b7XYja8Uc8cHuuLg.haTGi.5MdENOrw3J/YvCw2b03bu','member','standard','2025-10-17 19:11:41',NULL,'oQA&VD#rz5'),(32,NULL,'test22','test22@mail.com','$2y$10$ApnePW0FI0qJr9BMfrjlFuogPRlpYAr/y5H2CdCgV3OOMorHi6vM2','member','standard','2025-10-17 19:16:34',NULL,'f4o!uTSr)U'),(33,14,'test33','test33@test.com','$2y$10$647C2XnSsI/EPVmCuuldqOnBp1UGlgnhNMPQ05uFBjzJTuDMxwwuq','member','standard','2025-10-17 19:19:30','family_admin','OqPdXVn+hR'),(34,NULL,'qwer','qwer@qwer.com','$2y$10$ql7CWSUgkOjsiSWZ2LB6jOPfBnuwT6Q9izxg9pDFnPsgqiOY3d3OO','member','standard','2025-10-17 19:53:00','family_member','VK@ss9vvBT'),(35,15,'ty1','ty1@ty1.com','$2y$10$siQBYnsAhsbwrdILRIuWvuw6fJ1Q1dSwKRorxQLIUx13B/4Zf4/Ya','member','standard','2025-10-17 19:59:47','family_admin','#2T%yCy2UK'),(36,15,'testzpanelu','nnn@nnn.com','$2y$10$lTCq7LovB3IolsbcljY6H.KhdXi716fHqUHpEACQgsp9IiZvbD2NO','member','standard','2025-10-17 20:06:01','family_member','(382@@pa=S'),(38,NULL,'qw','qw@qw.com','$2y$10$skpv00GDctjPaj/JjrOCHeyKeyLR9ETFurKVc2cMlpnwLfwKiakH.','member','standard','2025-10-18 08:33:52',NULL,'4N6^MchTxy'),(39,17,'testdodawaniapouiddorodziny','testdodawaniapouiddorodziny@mail.com','$2y$10$YukJ4QZi36kM4y0XP9b2KOOYx6jFTktB2uB8TANLhn7n.9K3ef6nm','member','standard','2025-10-18 09:38:32','family_admin','RvDVRZ&ldg'),(40,17,'testdodawaniapouiddorodziny2','testdodawaniapouiddorodziny2@mail.com','$2y$10$mqVoohVSBuBjEy3..tXu6uSNeH6/joGN6k0m7fykynxMRNMNO10T2','member','standard','2025-10-18 09:39:03','family_member','5DN8CR_w&C'),(41,18,'adi','adi@adi.com','$2y$10$Xfnu/B6iygWgOW5KAwCkCeYXpSv.KJnH5.Y7y2yhnRLXfBJFM1DGO','member','standard','2025-10-18 10:03:43','family_member','WlAhpAD!Pe'),(43,20,'adminrodziny','adminrodziny@admin.com','$2y$10$0jIMLyikOR.phVF1D4hk/epIrLO1l6orIPP8OBC7Jv9mEX8yMkkt6','member','standard','2025-10-18 11:48:53','family_admin','$t%5WKRlYf'),(44,20,'czlonekrodziny','czlonekrodziny@czlonek.com','$2y$10$7hReNGqmEq/Qaw0LIkdfYeV3odT8EtJruNMUQ.ri7E4iJjXKg0WdW','member','standard','2025-10-18 11:49:48','family_member','tZHrf-pldz'),(45,20,'czlonekrodziny2','czlonekrodziny2@czlonek2.com','$2y$10$LPWWKEI63I3nLBMaw5ypsegnAQgXjIx842CR7y1ogIkcNYSYh29ni','member','standard','2025-10-18 11:50:58','family_member','KZi(++_i9e'),(55,NULL,'emka2@mail.com','emka2@mail.com','$2y$10$GVgI.ySWapVKzCR4n0WpFu5g24nmKt9N8kxze7Wq1vArXPrKWAwVy','member','standard','2025-10-22 17:24:42',NULL,'cZ2rVZmt*0'),(56,NULL,'asdzxc','asdzxc@mail.com','$2y$10$sAWpYpkFCIMGxOVh4x3/JOvGU5/CUvqYOb7in1XH6Yqz3sbAb6GBq','member','standard','2025-10-25 12:48:03',NULL,'a90S9#d%a8'),(57,NULL,'zxq123','zxq123@mail.com','$2y$10$59BqDpxvFfImLyoXo7ChHOEYKFww53sgElBexin59iE75QOvOsU7i','member','standard','2025-10-25 17:13:28',NULL,'#WlH&)BU%='),(59,20,'dod','dod@mail.com','$2y$10$EnGzNO9aw1FSW1.WgLVKH.9eFrEIIJj0v3qw9mzklEWPAVMDoB2na','member','standard','2025-10-26 15:09:05','family_member','yNJ9=o-24&'),(60,NULL,'testzpanelu3','testzpanelu3@mail.com','$2y$10$XR0v2tPF7D97yqLk2ZlWKOpW2BMxWhZx/ONkfqQrK/nDAJJPByGAK','member','standard','2025-10-26 15:11:03',NULL,'@BQ#Iv+#B9'),(61,NULL,'tester1','tester1@mail.com','$2y$10$L5Qrf2e.VWEzJ26x2gojI.6SVcIU5U141qlK4SXbuG/o7tkDXc0Ru','member','standard','2025-10-26 15:12:47',NULL,'S7lXF6N=zY');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'family_finance_database'
--

--
-- Dumping routines for database 'family_finance_database'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-26 17:21:13
