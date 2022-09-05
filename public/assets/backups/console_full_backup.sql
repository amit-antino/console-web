-- MySQL dump 10.13  Distrib 8.0.27, for Linux (x86_64)
--
-- Host: localhost    Database: console
-- ------------------------------------------------------
-- Server version	8.0.27-0ubuntu0.20.04.1

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
-- Position to start replication or point-in-time recovery from
--

-- CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.000002', MASTER_LOG_POS=156;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `log_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` bigint DEFAULT NULL,
  `subject_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint DEFAULT NULL,
  `causer_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `status` enum('read','unread') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_log_name_index` (`log_name`),
  KEY `subject` (`subject_id`,`subject_type`),
  KEY `causer` (`causer_id`,`causer_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `associated_models`
--

DROP TABLE IF EXISTS `associated_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `associated_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_experiment_id` int NOT NULL DEFAULT '0',
  `model_type` int NOT NULL DEFAULT '0',
  `configuration` int NOT NULL DEFAULT '0',
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `associated_models`
--

LOCK TABLES `associated_models` WRITE;
/*!40000 ALTER TABLE `associated_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `associated_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blogs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_header` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_lists`
--

DROP TABLE IF EXISTS `category_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `category_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_lists`
--

LOCK TABLES `category_lists` WRITE;
/*!40000 ALTER TABLE `category_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_categories`
--

DROP TABLE IF EXISTS `chemical_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_categories`
--

LOCK TABLES `chemical_categories` WRITE;
/*!40000 ALTER TABLE `chemical_categories` DISABLE KEYS */;
INSERT INTO `chemical_categories` VALUES (1,0,'Company','','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(2,0,'Simreka','','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(4,0,'Test 4',NULL,'active',0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `chemical_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_classifications`
--

DROP TABLE IF EXISTS `chemical_classifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_classifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_classifications`
--

LOCK TABLES `chemical_classifications` WRITE;
/*!40000 ALTER TABLE `chemical_classifications` DISABLE KEYS */;
INSERT INTO `chemical_classifications` VALUES (1,0,'Compound (Pure Chemical)','Compound (Pure Chemical)','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(2,0,'Commercial (Mixed Chemical)','Commercial (Mixed Chemical)','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(3,0,'Simulated (Mixed Chemical)','Simulated (Mixed Chemical)','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(4,0,'Generic (Mixed/Pure Chemical)','Generic (Mixed/Pure Chemical)','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18'),(5,0,'Other','','active',1,1,NULL,'2021-12-01 11:23:18','2021-12-01 11:23:18');
/*!40000 ALTER TABLE `chemical_classifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_properties`
--

DROP TABLE IF EXISTS `chemical_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_properties` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `product_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `sub_property_id` int DEFAULT NULL,
  `prop_json` json DEFAULT NULL,
  `dynamic_prop_json` json DEFAULT NULL,
  `order_by` int DEFAULT NULL,
  `recommended` enum('on','off') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_properties`
--

LOCK TABLES `chemical_properties` WRITE;
/*!40000 ALTER TABLE `chemical_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `chemical_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_property_masters`
--

DROP TABLE IF EXISTS `chemical_property_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_property_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `property_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_property_masters`
--

LOCK TABLES `chemical_property_masters` WRITE;
/*!40000 ALTER TABLE `chemical_property_masters` DISABLE KEYS */;
INSERT INTO `chemical_property_masters` VALUES (1,0,'Primary Information','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(2,0,'Composition / Associated Chemicals','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(3,0,'Physio-Chemical Properties','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(4,0,'Commercial Information','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(5,0,'Hazard / Material Safety Data Sheets','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(6,0,'Sustainability Information','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(7,0,'Applications / Benefits','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(8,0,'Production Information','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18'),(9,0,'Notes / Files','active',1,1,NULL,'2021-12-01 18:23:18','2021-12-01 18:23:18');
/*!40000 ALTER TABLE `chemical_property_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemical_sub_property_masters`
--

DROP TABLE IF EXISTS `chemical_sub_property_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemical_sub_property_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `property_id` int DEFAULT NULL,
  `sub_property_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fields` json DEFAULT NULL,
  `dynamic_fields` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemical_sub_property_masters`
--

LOCK TABLES `chemical_sub_property_masters` WRITE;
/*!40000 ALTER TABLE `chemical_sub_property_masters` DISABLE KEYS */;
INSERT INTO `chemical_sub_property_masters` VALUES (1,0,1,'Primary Information','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Date\", \"field_type_id\": \"4\"}, {\"id\": \"1\", \"field_name\": \"Time\", \"field_type_id\": \"10\"}, {\"id\": \"2\", \"field_name\": \"Batch Number\", \"field_type_id\": \"1\"}, {\"id\": \"3\", \"field_name\": \"Formulation ID\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-04 06:48:07','2020-11-04 06:48:07'),(2,0,2,'Alloy Composition','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Alloy Composition\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-04 06:50:33','2021-01-12 07:59:40'),(3,0,2,'Chemical Composition','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"chemical_list\", \"field_name\": \"Chemical Composition\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 06:51:41','2021-01-12 07:59:31'),(4,0,3,'a* (Color)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"a* (Color)\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 06:58:33','2020-11-04 06:58:33'),(5,0,3,'Association Parameter','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Association Parameter\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 06:59:09','2020-11-04 06:59:09'),(6,0,3,'Atomic Mass','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Atomic Mass\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:00:52','2020-11-04 07:00:52'),(7,0,3,'Atomic Number','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Atomic Number\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 07:01:30','2020-11-04 07:01:30'),(8,0,3,'b* (Color)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"b* (Color)\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 07:11:36','2020-11-04 07:12:05'),(9,0,3,'Boiling Point','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Boiling Point\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:13:24','2020-11-04 07:13:24'),(10,0,3,'Boiling Point Temeperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Boiling Point Temeperature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 07:14:52','2020-11-04 07:14:52'),(11,0,3,'Born Radius','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"1\", \"field_name\": \"Born Radius\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:17:39','2020-11-04 07:17:39'),(12,0,3,'Bubble Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Bubble Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 07:22:09','2020-11-04 07:22:09'),(13,0,3,'Bubble Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Bubble Temperature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 07:31:43','2020-11-04 07:31:43'),(14,0,3,'Bulk Modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Bulk Modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:33:49','2020-11-04 07:33:49'),(15,0,3,'Candidate Monomer','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Candidate Monomer\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-04 07:35:40','2020-11-04 07:35:40'),(16,0,3,'Charge','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Charge\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 07:36:14','2020-11-04 07:36:14'),(17,0,3,'Charpy Impact','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Charpy Impact\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:36:54','2020-11-04 07:36:54'),(18,0,3,'Coefficient of Thermal Expansion','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Coefficient of Thermal Expansion\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:38:47','2020-11-04 07:38:47'),(19,0,3,'Color','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Color\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-04 07:39:40','2020-11-04 07:39:40'),(20,0,3,'Compressive Modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Compressive Modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 07:42:25','2020-11-04 07:42:25'),(21,0,3,'Contact Angle','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Contact Angle\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:26:40','2020-11-04 08:26:40'),(22,0,3,'cp Aqueous Infinite Dilution','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"21\"], \"field_name\": \"cp Aqueous Infinite Dilution\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 08:28:46','2020-11-04 08:28:46'),(23,0,3,'Critical Compressibility Factor','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Critical Compressibility Factor\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 08:29:53','2020-11-04 08:29:53'),(24,0,3,'Critical Density','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Critical Density\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:47:16','2020-11-04 08:47:16'),(25,0,3,'Critical Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Critical Pressure\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:49:56','2020-11-04 08:49:56'),(26,0,3,'Critical Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Critical Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:50:58','2020-11-04 08:50:58'),(27,0,3,'Critical Volume','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Critical Volume\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:52:48','2020-11-04 08:52:48'),(28,0,3,'Crystallization Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Crystallization Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:53:44','2020-11-04 08:53:44'),(29,0,3,'Density','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"8\", \"field_name\": \"Density\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 08:54:25','2020-11-04 08:54:25'),(30,0,3,'Dew Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Dew Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 08:55:29','2020-11-04 08:55:29'),(31,0,3,'Dew Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Dew Temperature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 08:56:47','2020-11-04 08:56:47'),(32,0,3,'Dielectric Constant','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Dielectric Constant\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 08:59:25','2020-11-04 08:59:25'),(33,0,3,'Diffusion Volume','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"2\", \"field_name\": \"Diffusion Volume\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:03:05','2020-11-04 09:03:05'),(34,0,3,'Dipole Moment','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"1\", \"field_name\": \"Dipole Moment\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:06:18','2020-11-04 09:06:18'),(35,0,3,'Dynamic Viscosity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"31\"], \"field_name\": \"Dynamic Viscosity\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 09:10:10','2020-11-04 09:10:10'),(36,0,3,'Elastic Limit','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Elastic Limit\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:11:51','2020-11-04 09:11:51'),(37,0,3,'Electical Resistivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Electical Resistivity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:12:41','2020-11-04 09:12:41'),(38,0,3,'Elongation','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Elongation\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 09:21:14','2020-11-04 09:21:14'),(39,0,3,'Elongation at Break','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Elongation at Break\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 09:21:36','2020-11-04 09:21:36'),(40,0,3,'Elongation at Yield','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Elongation at Yield\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 09:22:07','2020-11-04 09:22:07'),(41,0,3,'Emissivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Emissivity\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 09:26:28','2020-11-04 09:26:28'),(42,0,3,'Energy LennardJones','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Energy LennardJones\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:27:42','2020-11-04 09:27:42'),(43,0,3,'Energy/kg to extract material','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"6\", \"field_name\": \"Energy/kg to extract material\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:29:57','2020-11-04 09:29:57'),(44,0,3,'Entanglement Molecular Weight','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"42\", \"field_name\": \"Entanglement Molecular Weight\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:33:12','2020-11-04 09:33:12'),(45,0,3,'Enthalpy of combustion','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Enthalpy of combustion\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:34:17','2021-02-04 08:58:38'),(46,0,3,'Enthalpy of formation','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Enthalpy of formation\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:36:25','2021-02-04 08:59:17'),(47,0,3,'Entropy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Entropy\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:37:19','2020-11-04 09:37:19'),(48,0,3,'Expansivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Expansivity\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 09:38:21','2020-11-04 09:38:21'),(49,0,3,'Fatigue Endurance Limit','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Fatigue Endurance Limit\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:39:58','2020-11-04 09:39:58'),(50,0,3,'Fatigue Strength','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Fatigue Strength\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:41:07','2020-11-04 09:41:07'),(51,0,3,'Flexural Modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Flexural Modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:41:36','2020-11-04 09:41:36'),(52,0,3,'Flexural stress(strength) at break','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Flexural stress(strength) at break\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:51:08','2020-11-04 09:51:08'),(53,0,3,'Flexural stress(strength) at yield','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Flexural stress(strength) at yield\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:52:20','2020-11-04 09:52:20'),(54,0,3,'Formula Weight','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"42\", \"field_name\": \"Formula Weight\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:53:00','2020-11-04 09:53:00'),(55,0,3,'Fracture Toughness','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Fracture Toughness\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:53:59','2020-11-04 09:53:59'),(56,0,3,'Free energy, G','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Free energy, G\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 09:57:24','2020-11-04 09:57:24'),(57,0,3,'Fugacity Coefficient of Vapor','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"48\"], \"field_name\": \"Fugacity Coefficient of Vapor\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:01:19','2020-11-04 10:01:19'),(58,0,3,'Gas Permeability Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Gas Permeability Coefficient\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:04:57','2020-11-04 10:04:57'),(59,0,3,'Gas Solubility Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Gas Solubility Coefficient\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:05:26','2020-11-04 10:05:26'),(60,0,3,'Glass Transition Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Glass Transition Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:06:14','2020-11-04 10:06:14'),(61,0,3,'Glass Transition Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Glass Transition Temperature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:07:21','2020-11-04 10:07:21'),(62,0,3,'Gyration Radius','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"1\", \"field_name\": \"Gyration Radius\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:07:58','2020-11-04 10:07:58'),(63,0,3,'Heat Capacity of liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"21\"], \"field_name\": \"Heat Capacity of liquid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:11:21','2021-02-04 08:36:49'),(64,0,3,'Heat Capacity of Solid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"21\"], \"field_name\": \"Heat Capacity of Solid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:13:06','2020-11-04 10:13:06'),(65,0,3,'Heat Capacity Ratio (Cp/Cv)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Heat Capacity Ratio (Cp/Cv)\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 10:13:28','2020-11-04 10:13:28'),(66,0,3,'Heat of Crystallization','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Heat of Crystallization\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:14:10','2020-11-04 10:14:10'),(67,0,3,'Heat Of Fusion At Normal Freezing Point','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Heat Of Fusion At Normal Freezing Point\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:16:19','2020-11-04 10:16:19'),(68,0,3,'Heat of Solid-Solid Phase Transition','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"15\"], \"field_name\": \"Heat of Solid-Solid Phase Transition\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:18:01','2020-11-04 10:18:01'),(69,0,3,'Heat of Sublimation','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"15\"], \"field_name\": \"Heat of Sublimation\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:22:33','2020-11-04 10:22:33'),(70,0,3,'Heat of Vaporization','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"11\", \"12\"], \"field_name\": \"Heat of Vaporization\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:29:32','2021-02-04 09:05:37'),(71,0,3,'Heat Of Vaporization At Normal Boiling Point','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Heat Of Vaporization At Normal Boiling Point\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:32:24','2020-11-04 10:32:24'),(72,0,3,'Helmholtz Free Energy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Helmholtz Free Energy\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:33:27','2020-11-04 10:33:27'),(73,0,3,'Higher Heating Value','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Higher Heating Value\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:33:57','2020-11-04 10:33:57'),(74,0,3,'Ideal Gas Enthalpy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"15\"], \"field_name\": \"Ideal Gas Enthalpy\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:35:41','2020-11-04 10:35:41'),(75,0,3,'Ideal Gas Enthalpy Of Formation At 25C','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"15\"], \"field_name\": \"Ideal Gas Enthalpy Of Formation At 25C\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:36:16','2020-11-04 10:36:16'),(76,0,3,'Ideal Gas Entropy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"42\"], \"field_name\": \"Ideal Gas Entropy\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:37:54','2020-11-04 10:37:54'),(77,0,3,'Ideal Gas Gibbs FreeEnergy Of Formation At 25C','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Ideal Gas Gibbs FreeEnergy Of Formation At 25C\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:38:30','2020-11-04 10:38:30'),(78,0,3,'Ideal Gas Heat Capacity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"15\"], \"field_name\": \"Ideal Gas Heat Capacity\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:39:46','2020-11-04 10:39:46'),(79,0,3,'Ignition Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Ignition Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:40:12','2020-11-04 10:40:12'),(80,0,3,'Interfacial Tension','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"34\", \"field_name\": \"Interfacial Tension\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:42:31','2020-11-04 10:42:31'),(81,0,3,'Internal Energy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Internal Energy\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:43:10','2020-11-04 10:43:10'),(82,0,3,'Inversion Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Inversion Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:43:55','2020-11-04 10:43:55'),(83,0,3,'Izod Impact','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Izod Impact\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:44:34','2020-11-04 10:44:34'),(84,0,3,'Joule Thomson Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Joule Thomson Coefficient\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:45:17','2020-11-04 10:45:17'),(85,0,3,'Kinematic Viscosity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"32\"], \"field_name\": \"Kinematic Viscosity\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 10:46:53','2020-11-04 10:46:53'),(86,0,3,'L* (Color)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"L* (Color)\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 10:50:09','2020-11-04 10:50:09'),(87,0,3,'Length Lennard Jones','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"1\", \"field_name\": \"Length Lennard Jones\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:50:48','2020-11-04 10:50:48'),(88,0,3,'Linear Density','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"40\", \"field_name\": \"Linear Density\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:51:21','2020-11-04 10:51:21'),(89,0,3,'Liquid Volume At 25C','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Liquid Volume At 25C\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 10:54:57','2020-11-04 10:54:57'),(90,0,3,'Lower heating value','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Lower heating value\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:05:04','2020-11-04 11:05:04'),(91,0,3,'Mass Transfer Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"39\", \"field_name\": \"Mass Transfer Coefficient\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:06:54','2020-11-04 11:06:54'),(92,0,3,'Material Characterstics','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Material Characterstics\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-04 11:09:35','2020-11-04 11:09:35'),(93,0,3,'Melt Viscosity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"31\", \"field_name\": \"Melt Viscosity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:11:34','2020-11-04 11:11:34'),(94,0,3,'Melting point','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Melting point\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:16:11','2020-11-04 11:16:11'),(95,0,3,'Melting Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Melting Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:17:53','2020-11-04 11:17:53'),(96,0,3,'Moisture Content','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Moisture Content\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 11:19:06','2020-11-04 11:19:06'),(97,0,3,'Melting Temeprature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Melting Temeprature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:20:05','2020-11-04 11:20:05'),(98,0,3,'Molar Cohesive Energy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"15\"], \"field_name\": \"Molar Cohesive Energy\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:20:39','2020-11-04 11:20:39'),(99,0,3,'Molar Cohesive Energy','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Molar Cohesive Energy\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:21:31','2020-11-04 11:21:31'),(100,0,3,'Molar Heat Capacity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Molar Heat Capacity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:22:12','2020-11-04 11:22:12'),(101,0,3,'Molar Volume','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"2\", \"field_name\": \"Molar Volume\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:23:05','2020-11-04 11:23:05'),(102,0,3,'Molar State','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"41\", \"field_name\": \"Phase (at 1 bar 298k)\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:24:46','2020-11-04 11:24:46'),(103,0,3,'Molecular Weight','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"42\", \"field_name\": \"Molecular Weight\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:25:54','2020-11-04 11:25:54'),(104,0,3,'Parachor','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Parachor\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:26:52','2020-11-04 11:26:52'),(105,0,3,'Partial Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Partial Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:28:07','2020-11-04 11:28:07'),(106,0,3,'Permittivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Permittivity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:33:52','2020-11-04 11:33:52'),(107,0,3,'Poissons Ratio','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Poissons Ratio\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 11:34:31','2020-11-04 11:34:31'),(108,0,3,'Processing information','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Processing information\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 11:36:08','2020-11-04 11:36:08'),(109,0,3,'Refractive Index','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Refractive Index\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 11:37:20','2020-11-04 11:37:20'),(110,0,3,'Relative Density','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Relative Density\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 11:38:07','2020-11-04 11:38:07'),(111,0,3,'Self Diffusion Coefficient Gas','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"32\"], \"field_name\": \"Self Diffusion Coefficient Gas\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:39:15','2020-11-04 11:39:15'),(112,0,3,'Self Diffusion Coefficient Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"32\"], \"field_name\": \"Self Diffusion Coefficient Liquid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:42:50','2020-11-04 11:42:50'),(113,0,3,'Shear Modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Shear Modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:45:26','2020-11-04 11:45:26'),(114,0,3,'Shear Strength','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Shear Strength\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:47:22','2020-11-04 11:47:22'),(115,0,3,'Softening Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Softening Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:47:55','2020-11-04 11:47:55'),(116,0,3,'Solid Phase Transition Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Solid Phase Transition Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:48:41','2020-11-04 11:48:41'),(117,0,3,'Solid Phase Transition Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Solid Phase Transition Temperature\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 11:51:41','2020-11-04 11:51:41'),(118,0,3,'Solubility Parameter','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"8\", \"field_name\": \"Solubility Parameter\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:53:06','2021-02-04 09:03:14'),(119,0,3,'Specific Weight','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"8\", \"field_name\": \"Specific Weight\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:54:29','2020-11-04 11:54:29'),(120,0,3,'Standard Enthalpy Aqueous Dilution','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Enthalpy Aqueous Dilution\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:55:43','2020-11-04 11:55:43'),(121,0,3,'Standard Entropy Gas','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Entropy Gas\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 11:59:12','2020-11-04 11:59:12'),(122,0,3,'Standard Entropy Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Entropy Liquid\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:00:11','2020-11-04 12:00:11'),(123,0,3,'Standard Entropy Solid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Entropy Solid\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:01:34','2020-11-04 12:01:34'),(124,0,3,'Standard Formation Enthalpy Gas','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Formation Enthalpy Gas\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:04:04','2020-11-04 12:04:36'),(125,0,3,'Standard Formation Enthalpy Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Formation Enthalpy Liquid\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:05:27','2020-11-04 12:05:27'),(126,0,3,'Standard Formation Enthalpy Solid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Formation Enthalpy Solid\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:06:36','2020-11-04 12:06:36'),(127,0,3,'Standard Formation Gibbs Energy Gas','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Formation Gibbs Energy Gas\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:07:11','2020-11-04 12:07:11'),(128,0,3,'Standard Formation Gibbs Energy Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Formation Gibbs Energy Liquid\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:08:41','2020-11-04 12:08:41'),(129,0,3,'Standard Gibbs Aqueous Dilution','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"15\", \"field_name\": \"Standard Gibbs Aqueous Dilution\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:09:38','2020-11-04 12:09:38'),(130,0,3,'Sublimation Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Sublimation Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 12:10:26','2020-11-04 12:10:26'),(131,0,3,'Surface Tension','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"34\"], \"field_name\": \"Surface Tension\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 12:11:24','2020-11-04 12:11:24'),(132,0,3,'Tenacity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"38\", \"field_name\": \"Tenacity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:15:23','2020-11-04 12:15:23'),(133,0,3,'Tensile modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Tensile modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:16:05','2020-11-04 12:16:05'),(134,0,3,'Tensile Strength','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Tensile Strength\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:16:29','2020-11-04 12:16:29'),(135,0,3,'Thermal Conductivity of Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"33\"], \"field_name\": \"Thermal Conductivity of Liquid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 12:17:11','2020-11-04 12:17:11'),(136,0,3,'Thermal Conductivity Of Vapo','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"33\"], \"field_name\": \"Thermal Conductivity Of Vapo\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-04 12:19:39','2020-11-04 12:19:39'),(137,0,3,'Thermal Diffusivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"32\", \"field_name\": \"Thermal Diffusivity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:20:09','2020-11-04 12:20:09'),(138,0,3,'Transmittance','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Transmittance\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-04 12:20:43','2020-11-04 12:20:43'),(139,0,3,'Triple Point Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Triple Point Pressure\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:21:10','2020-11-04 12:21:10'),(140,0,3,'Triple Point Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Triple Point Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:21:34','2020-11-04 12:21:34'),(141,0,3,'Vanderwaals Area','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"9\", \"field_name\": \"Vanderwaals Area\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:23:02','2020-11-04 12:23:02'),(142,0,3,'Vanderwaals Volume','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"2\", \"field_name\": \"Vanderwaals Volume\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-04 12:24:53','2020-11-04 12:24:53'),(143,0,3,'Vapor Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\", \"12\"], \"field_name\": \"Vapor Pressure\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:24:25','2020-11-05 05:24:25'),(144,0,3,'Virial Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Virial Coefficient\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:25:07','2020-11-05 05:25:07'),(145,0,3,'Viscosity of Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"31\"], \"field_name\": \"Viscosity of Liquid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:25:51','2020-11-05 05:25:51'),(146,0,3,'Viscosity of Vapor','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"31\"], \"field_name\": \"Viscosity of Vapor\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:26:46','2020-11-05 05:26:46'),(147,0,3,'Volume Change Upon Melting','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Volume Change Upon Melting\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:27:14','2020-11-05 05:27:14'),(148,0,3,'Volume Change Upon Solid Phase Transition','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Volume Change Upon Solid Phase Transition\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:29:38','2020-11-05 05:29:38'),(149,0,3,'Volume Change Upon Sublimation','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"43\"], \"field_name\": \"Volume Change Upon Sublimation\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:30:50','2020-11-05 05:30:50'),(150,0,3,'Volume Change Upon Vaporization','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"2\", \"12\"], \"field_name\": \"Volume Change Upon Vaporization\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:32:59','2020-11-05 05:32:59'),(151,0,3,'Volume Expansion Coefficient','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Volume Expansion Coefficient\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:33:32','2020-11-05 05:33:32'),(152,0,3,'Volume of Liquid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"2\", \"12\"], \"field_name\": \"Volume of Liquid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:34:04','2020-11-05 05:34:04'),(153,0,3,'Volume of Solid','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"2\", \"12\"], \"field_name\": \"Volume of Solid\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:35:03','2020-11-05 05:35:03'),(154,0,3,'Volumetric Heat Capacity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Volumetric Heat Capacity\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:36:43','2020-11-05 05:36:43'),(155,0,3,'Water Solubility at 25C','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"8\", \"field_name\": \"Water Solubility at 25C\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:37:22','2020-11-05 05:37:22'),(156,0,3,'Wear Rate Constant','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"5\"], \"field_name\": \"Wear Rate Constant\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2020-11-05 05:38:21','2020-11-05 05:38:21'),(157,0,3,'Yield Strength','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Yield Strength\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:38:45','2020-11-05 05:38:45'),(158,0,3,'Youngs Modulus','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"chemical_list\", \"field_name\": \"Youngs Modulus\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:39:07','2020-11-05 05:39:07'),(159,0,4,'Annual Market size - mass','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"7\", \"field_name\": \"Annual Market size - mass\", \"field_type_id\": \"5\"}, {\"id\": \"1\", \"field_name\": \"Region\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-05 05:45:23','2020-11-05 05:45:23'),(160,0,4,'Annual Market size - value','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"19\", \"field_name\": \"Annual Market size - value\", \"field_type_id\": \"5\"}, {\"id\": \"1\", \"field_name\": \"Region\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-05 05:46:07','2020-11-05 05:46:07'),(161,0,4,'Annual Market size - volume','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"2\", \"field_name\": \"Annual Market size - volume\", \"field_type_id\": \"5\"}, {\"id\": \"1\", \"field_name\": \"Region\", \"field_type_id\": \"1\"}]','active',2,2,NULL,'2020-11-05 05:46:50','2020-11-05 05:46:50'),(163,0,5,'EU-classification','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"163\", \"field_name\": \"EU-classification\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2020-11-05 05:55:06','2021-03-22 16:40:42'),(164,0,5,'Flash point','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Flash point\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:55:45','2020-11-05 05:55:45'),(165,0,5,'GK Code','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"165\", \"field_name\": \"GK code\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2020-11-05 05:57:43','2021-03-22 16:44:50'),(166,0,5,'H-codes','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"166\", \"field_name\": \"H-codes\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2020-11-05 05:58:21','2021-03-22 16:43:34'),(167,0,5,'Half life(in water)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"14\", \"field_name\": \"Half life(in water)\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 05:59:29','2020-11-05 05:59:29'),(168,0,5,'IDLH','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"18\", \"field_name\": \"IDLH\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:00:05','2020-11-05 06:00:05'),(169,0,5,'LC50 aquatic','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"18\", \"field_name\": \"LC50 aquatic\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:00:31','2021-03-25 14:00:27'),(170,0,5,'LD50','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"17\", \"field_name\": \"LD50\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:01:15','2020-11-05 06:01:15'),(171,0,5,'MAK-CH','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"18\", \"field_name\": \"MAK-CH\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:01:54','2020-11-05 06:01:54'),(172,0,5,'MSDS PDF datasheet','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"MSDS PDF datasheet\", \"field_type_id\": \"11\"}]','active',2,2,NULL,'2020-11-05 06:03:41','2020-11-05 06:03:41'),(173,0,5,'NFPA flammability','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"173\", \"field_name\": \"NFPA flammability\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2020-11-05 06:05:05','2021-03-22 12:33:15'),(174,0,5,'NFPA health','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"174\", \"field_name\": \"NFPA health\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2020-11-05 06:05:37','2021-03-22 12:33:49'),(175,0,5,'NFPA reactivity','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"175\", \"field_name\": \"NFPA reactivity\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2020-11-05 06:05:57','2021-03-22 12:31:56'),(176,0,5,'Oxygen Index','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Oxygen Index\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-05 06:06:15','2020-11-05 06:06:15'),(177,0,5,'P-codes','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"177\", \"field_name\": \"P-codes\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2020-11-05 06:06:41','2021-03-17 08:26:21'),(178,0,5,'Partial Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Partial Pressure\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:07:41','2020-11-05 06:07:41'),(179,0,5,'Partition coefficient, POW, KOW','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Partition coefficient, POW, KOW\", \"field_type_id\": \"12\"}]','active',2,2,NULL,'2020-11-05 06:08:00','2020-11-05 06:08:00'),(180,0,5,'R-codes','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"180\", \"field_name\": \"R-codes\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2020-11-05 06:08:25','2021-03-22 16:43:04'),(181,0,5,'Vapor Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Vapor Pressure\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:08:50','2020-11-05 06:08:50'),(182,0,5,'WGK substance Class','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"182\", \"field_name\": \"WGK substance Class\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2020-11-05 06:09:35','2021-03-22 12:32:53'),(183,0,6,'Carbon Content','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"16\", \"field_name\": \"Carbon Content\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:10:09','2020-11-05 06:10:09'),(184,0,6,'Cumulative Energy Demand','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Cumulative Energy Demand\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:10:42','2020-11-05 06:10:42'),(185,0,6,'Eutrophication potential','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"51\", \"field_name\": \"Eutrophication potential\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:11:18','2021-03-04 11:39:55'),(186,0,6,'Greenhouse Gas Emissions (Carbon Footprint)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"16\", \"field_name\": \"Greenhouse Gas Emissions (Carbon Footprint)\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:12:04','2020-11-05 06:12:04'),(187,0,6,'Land Use- per kg product','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"28\", \"field_name\": \"Land Use- per kg product\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:12:53','2020-11-05 06:12:53'),(188,0,6,'Non Renewable Energy Use (NREU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"25\", \"field_name\": \"Non Renewable Energy Use (NREU)\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:13:19','2020-11-05 06:13:19'),(189,0,6,'Renewable Energy Use (REU','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"26\", \"field_name\": \"Renewable Energy Use (REU\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2020-11-05 06:13:51','2020-11-05 06:13:51'),(190,0,6,'Water Use','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"27\", \"field_name\": \"Water Use\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-11-05 06:14:16','2020-11-05 06:14:16'),(191,0,7,'Applications/ Benefits','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Applications/ Benefits\", \"field_type_id\": \"8\"}]','active',2,2,NULL,'2020-11-05 06:14:49','2020-11-05 06:14:49'),(192,0,9,'Files','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Files\", \"field_type_id\": \"11\"}]','active',2,2,NULL,'2020-11-05 06:15:15','2020-11-05 06:16:01'),(193,0,9,'Images','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Images\", \"field_type_id\": \"11\"}]','active',2,2,NULL,'2020-11-05 06:15:46','2020-11-05 06:15:46'),(194,0,9,'Notes/Comments','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Notes/Comments\", \"field_type_id\": \"8\"}]','active',2,2,NULL,'2020-11-05 06:16:33','2020-11-05 06:16:33'),(195,0,8,'Production information','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Production information\", \"field_type_id\": \"8\"}]','active',2,2,NULL,'2020-11-05 06:17:02','2020-11-05 06:17:02'),(196,0,3,'Heat Capacity of Gas','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": [\"12\", \"21\"], \"field_name\": \"Heat Capacity of Gas\", \"field_type_id\": \"13\"}]','active',2,2,NULL,'2021-02-04 08:39:35','2021-02-04 08:39:35'),(197,0,4,'Price','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"19\", \"field_name\": \"Price\", \"field_type_id\": \"5\"}, {\"id\": \"1\", \"unit_id\": \"7\", \"field_name\": \"Weight\", \"field_type_id\": \"6\"}]','active',2,2,NULL,'2021-03-10 06:22:19','2021-03-10 06:22:19'),(198,0,5,'GHS-Code','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"198\", \"field_name\": \"GHS-Code\", \"field_type_id\": \"7\"}]','active',2,2,NULL,'2021-03-22 14:33:01','2021-03-22 16:44:00');
/*!40000 ALTER TABLE `chemical_sub_property_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chemicals`
--

DROP TABLE IF EXISTS `chemicals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chemicals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `chemical_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_type_id` int NOT NULL DEFAULT '0',
  `molecular_formula` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `classification_id` int DEFAULT NULL,
  `smiles` json DEFAULT NULL,
  `product_brand_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cas_no` json DEFAULT NULL,
  `iupac` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inchi` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inchi_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `vendor_list` json DEFAULT NULL,
  `ec_number` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `own_product` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chemicals`
--

LOCK TABLES `chemicals` WRITE;
/*!40000 ALTER TABLE `chemicals` DISABLE KEYS */;
/*!40000 ALTER TABLE `chemicals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classification_lists`
--

DROP TABLE IF EXISTS `classification_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `classification_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `classification_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classification_lists`
--

LOCK TABLES `classification_lists` WRITE;
/*!40000 ALTER TABLE `classification_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `classification_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `code_statements`
--

DROP TABLE IF EXISTS `code_statements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `code_statements` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` bigint DEFAULT NULL,
  `sub_code_type_id` bigint DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=332 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `code_statements`
--

LOCK TABLES `code_statements` WRITE;
/*!40000 ALTER TABLE `code_statements` DISABLE KEYS */;
INSERT INTO `code_statements` VALUES (1,'Explosive when dry','EUH001',NULL,1,0,0,0,'active',NULL,'2020-10-14 12:44:44','2020-10-14 12:44:44'),(2,'Explosive with or without contact with air','EUH006','Explosive with or without contact with air',1,0,0,0,'active',NULL,'2020-10-14 12:45:13','2020-10-14 12:45:13'),(3,'Reacts violently with water','EUH014','Reacts violently with water',1,0,0,0,'active',NULL,'2020-10-14 12:45:57','2020-10-14 12:45:57'),(4,'In use may form flammable/explosive vapor-air mixture','EUH018','In use may form flammable/explosive vapor-air mixture',1,0,0,0,'active',NULL,'2020-10-14 12:46:34','2020-10-14 12:46:34'),(5,'May form explosive peroxides','EUH019',NULL,1,0,0,0,'active',NULL,'2020-10-14 12:47:02','2020-10-14 12:47:02'),(6,'Contact with water liberates toxic gas','EUH029',NULL,1,0,0,0,'active',NULL,'2020-10-14 12:48:51','2020-10-14 12:48:51'),(7,'Contact with acids liberates toxic gas','EUH031',NULL,1,0,0,0,'active',NULL,'2020-10-14 13:57:34','2020-10-14 13:57:34'),(8,'Contact with acids liberates very toxic gas','EUH032',NULL,1,0,0,0,'active',NULL,'2020-10-14 13:57:51','2020-10-14 13:57:51'),(9,'Risk of explosion if heated under confinement','EUH044',NULL,1,0,0,0,'active',NULL,'2020-10-14 13:58:49','2020-10-14 13:58:49'),(10,'Hazardous to the ozone layer','EUH059','EUH059',1,0,0,0,'active',NULL,'2020-10-14 13:59:28','2020-10-14 13:59:28'),(11,'Repeated exposure may cause skin dryness or cracking','EUH066',NULL,1,0,0,0,'active',NULL,'2020-10-14 14:00:24','2020-10-14 14:00:24'),(12,'Toxic by eye contact','EUH070','Toxic by eye contact',1,0,0,0,'active',NULL,'2020-10-14 14:00:43','2020-10-14 14:00:43'),(13,'Corrosive to the respiratory tract','EUH071','EUH071',1,0,0,0,'active',NULL,'2020-10-14 14:01:04','2020-10-14 14:01:04'),(14,'Explosive when dry','AUH001','AUH001',2,0,0,0,'active',NULL,'2020-10-14 14:03:55','2020-10-14 14:03:55'),(15,'Explosive with or without contact with air','AUH006','Explosive with or without contact with air',2,0,0,0,'active',NULL,'2020-10-14 14:04:18','2020-10-14 14:04:18'),(16,'Reacts violently with water','AUH014','AUH014',2,0,0,0,'active',NULL,'2020-10-14 14:04:36','2020-10-14 14:04:36'),(17,'In use, may form flammable/explosive vapor/air mixture','AUH018','In use, may form flammable/explosive vapor/air mixture',2,0,0,0,'active',NULL,'2020-10-14 14:04:56','2020-10-14 14:04:56'),(18,'May form explosive peroxides','AUH019','AUH019',2,0,0,0,'active',NULL,'2020-10-14 14:06:14','2020-10-14 14:06:14'),(19,'Contact with water liberates toxic gas','AUH029','AUH029',2,0,0,0,'active',NULL,'2020-10-14 14:06:30','2020-10-14 14:06:30'),(20,'Contact with acid liberates toxic gas','AUH031','AUH031',2,0,0,0,'active',NULL,'2020-10-14 14:06:48','2020-10-14 14:06:48'),(21,'Contact with acid liberates very toxic gas','AUH032','AUH032',2,0,0,0,'active',NULL,'2020-10-14 14:07:08','2020-10-14 14:07:08'),(22,'Risk of explosion if heated under confinement','AUH044','AUH044',2,0,0,0,'active',NULL,'2020-10-14 14:07:24','2020-10-14 14:07:24'),(23,'Repeated exposure may cause skin dryness and cracking','AUH066','AUH066',2,0,0,0,'active',NULL,'2020-10-14 14:07:41','2020-10-14 14:07:41'),(24,'Toxic by eye contact','AUH070','AUH070',2,0,0,0,'active',NULL,'2020-10-14 14:07:57','2020-10-14 14:07:57'),(25,'Corrosive to the respiratory tract','AUH071','AUH071',2,0,0,0,'active',NULL,'2020-10-14 14:08:15','2020-10-14 14:08:15'),(26,'If medical advice is needed, have product container or label at hand.','P101','If medical advice is needed, have product container or label at hand.',3,2,0,0,'active',NULL,'2020-10-14 14:08:52','2020-10-14 14:08:52'),(27,'Keep out of reach of children.','P102','Keep out of reach of children.',3,2,0,0,'active',NULL,'2020-10-14 14:09:33','2020-10-14 14:09:33'),(28,'Read label before use','P103','Read label before use',3,2,0,0,'active',NULL,'2020-10-14 14:09:54','2020-10-14 14:09:54'),(29,'Obtain special instructions before use.','P201','P201',3,3,0,0,'active',NULL,'2020-10-14 14:10:28','2020-10-14 14:11:33'),(30,'Do not handle until all safety precautions have been read and understood.','P202','P202',3,3,0,0,'active',NULL,'2020-10-14 14:10:58','2020-10-14 14:11:50'),(31,'Keep away from heat, hot surface, sparks, open flames and other ignition sources. - No smoking.','P210','P210',3,3,0,0,'active',NULL,'2020-10-14 14:12:21','2020-10-14 14:12:21'),(32,'Do not spray on an open flame or other ignition source.','P211','P211',3,3,0,0,'active',NULL,'2020-10-14 14:12:43','2020-10-14 14:12:43'),(33,'Handle under inert gas/... Protect from moisture.','P231+P232','P231+P232',3,3,0,0,'active',NULL,'2020-10-14 14:13:22','2020-10-14 14:13:22'),(34,'Keep cool. Protect from sunlight.','P235+P410','Keep cool. Protect from sunlight.',3,3,0,0,'active',NULL,'2020-10-14 14:13:47','2020-10-14 14:13:47'),(35,'Dispose of contents/container to ...','P501','P501',3,6,0,0,'active',NULL,'2020-10-14 14:14:42','2020-10-14 14:14:42'),(36,'Refer to manufacturer or supplier for information on recovery or recycling','P502','P502',3,6,0,0,'active',NULL,'2020-10-14 14:15:19','2020-10-14 14:15:19'),(37,'IF SWALLOWED:','P301',NULL,3,4,0,0,'active',NULL,'2020-10-14 14:16:04','2020-10-14 14:16:04'),(38,'IF ON SKIN:','P302','P302',3,4,0,0,'active',NULL,'2020-10-14 14:16:23','2020-10-14 14:16:23'),(39,'IF ON SKIN (or hair):','P303','P303',3,4,0,0,'active',NULL,'2020-10-14 14:16:48','2020-10-14 14:16:48'),(40,'IF INHALED:','P304','P304',3,4,0,0,'active',NULL,'2020-10-14 14:17:11','2020-10-14 14:17:11'),(41,'IF IN EYES:','P305','P305',3,4,0,0,'active',NULL,'2020-10-14 14:17:36','2020-10-14 14:17:36'),(42,'In case of fire: Evacuate area. Fight fire remotely due to the risk of explosion.','P370+P380+P375','P370+P380+P375',3,4,0,0,'active',NULL,'2020-10-14 14:18:17','2020-10-14 14:18:17'),(43,'In case of major fire and large quantities: Evacuate area. Fight fire remotely due to the risk of explosion.','P371+P380+P375','P371+P380+P375',3,4,0,0,'active',NULL,'2020-10-14 14:18:52','2020-10-14 14:18:52'),(44,'Store in accordance with ...','P401','P401',3,5,0,0,'active',NULL,'2020-10-14 14:19:27','2020-10-14 14:19:27'),(45,'Store in a dry place.','P402','P402',3,5,0,0,'active',NULL,'2020-10-14 14:19:48','2020-10-14 14:19:48'),(46,'Store in a well-ventilated place.','P403','P403',3,5,0,0,'active',NULL,'2020-10-14 14:20:13','2020-10-14 14:20:13'),(47,'Store in a closed container.','P404','P404',3,5,0,0,'active',NULL,'2020-10-14 14:20:35','2020-10-14 14:20:35'),(48,'Store locked up.','P405','P405',3,5,0,0,'active',NULL,'2020-10-14 14:20:54','2020-10-14 14:20:54'),(49,'Store in corrosive resistant/... container with a resistant inner liner.','P406','P406',3,5,0,0,'active',NULL,'2020-10-14 14:21:28','2020-10-14 14:21:28'),(50,'Maintain air gap between stacks or pallets.','P407','P407',3,5,0,0,'active',NULL,'2020-10-14 14:21:50','2020-10-14 14:21:50'),(51,'Protect from sunlight.','P410','P410',3,5,0,0,'active',NULL,'2020-10-14 14:22:12','2020-10-14 14:22:12'),(52,'Store at temperatures not exceeding ... °C/...°F.','P411','P411',3,5,0,0,'active',NULL,'2020-10-14 14:22:36','2020-10-14 14:22:36'),(53,'Do not expose to temperatures exceeding 50 °C/ 122 °F.','P412','P412',3,5,0,0,'active',NULL,'2020-10-14 14:22:54','2020-10-14 14:22:54'),(54,'Store bulk masses greater than ... kg/...lbs at temperatures not exceeding ... °C/...°F.','P413','P413',3,5,0,0,'active',NULL,'2020-10-14 14:23:28','2020-10-14 14:23:28'),(55,'Store separately.','P420','P420',3,5,0,0,'active',NULL,'2020-10-14 14:23:51','2020-10-14 14:23:51'),(56,'Store contents under ...','P422','P422',3,5,0,0,'active',NULL,'2020-10-14 14:24:10','2020-10-14 14:24:10'),(57,'Store in a dry place. Store in a closed container.','P402+P404','P402+P404',3,5,0,0,'active',NULL,'2020-10-14 14:24:33','2020-10-14 14:24:33'),(58,'Store in a well-ventilated place. Keep container tightly closed.','P403+P233','P403+P233',3,5,0,0,'active',NULL,'2020-10-14 14:24:58','2020-10-14 14:24:58'),(59,'Store in a well-ventilated place. Keep cool.','P403+P235','P403+P235',3,5,0,0,'active',NULL,'2020-10-14 14:25:18','2020-10-14 14:25:18'),(60,'Protect from sunlight. Store in a well-ventilated place.','P410+P403','P410+P403',3,5,0,0,'active',NULL,'2020-10-14 14:25:42','2020-10-14 14:25:42'),(61,'Protect from sunlight. Do not expose to temperatures exceeding 50 °C/122°F.','P410+P412','P410+P412',3,5,0,0,'active',NULL,'2020-10-14 14:26:09','2020-10-14 14:26:09'),(62,'Store at temperatures not exceeding ... °C/...°F. Keep cool.','P411+P235','P411+P235',3,5,0,0,'active',NULL,'2020-10-14 14:26:29','2020-10-14 14:26:29'),(63,'Avoid heating under confinement or reduction of the desensitized agent.','P212','P212',3,3,0,0,'active',NULL,'2020-10-14 14:35:38','2020-10-14 14:35:38'),(64,'Keep away from clothing and other combustible materials.','P220','P220',3,3,0,0,'active',NULL,'2020-10-14 14:36:01','2020-10-14 14:36:01'),(65,'Take any precaution to avoid mixing with combustibles/...','P221','P221',3,3,0,0,'active',NULL,'2020-10-14 14:36:30','2020-10-14 14:36:30'),(66,'Do not allow contact with air.','P222','P222',3,3,0,0,'active',NULL,'2020-10-14 14:38:03','2020-10-14 14:38:03'),(67,'Do not allow contact with water.','P223','P223',3,3,0,0,'active',NULL,'2020-10-14 14:38:25','2020-10-14 14:38:25'),(68,'Keep wetted with ...','P230','P230',3,3,0,0,'active',NULL,'2020-10-14 14:38:45','2020-10-14 14:38:45'),(69,'Handle under inert gas.','P231','P231',3,3,0,0,'active',NULL,'2020-10-14 14:39:05','2020-10-14 14:39:05'),(70,'Protect from moisture.','P232','P232',3,3,0,0,'active',NULL,'2020-10-14 14:39:25','2020-10-14 14:39:25'),(71,'Keep container tightly closed.','P233','P233',3,3,0,0,'active',NULL,'2020-10-14 14:39:56','2020-10-14 14:39:56'),(72,'Keep only in original container.','P234','P234',3,3,0,0,'active',NULL,'2020-10-14 14:40:22','2020-10-14 14:40:22'),(73,'Keep cool.','P235','P235',3,3,0,0,'active',NULL,'2020-10-14 14:40:42','2020-10-14 14:40:42'),(74,'Ground/bond container and receiving equipment.','P240','P240',3,3,0,0,'active',NULL,'2020-10-14 14:41:05','2020-10-14 14:41:05'),(75,'Use explosion-proof [electrical/ventilating/lighting/.../] equipment.','P241','P241',3,3,0,0,'active',NULL,'2020-10-14 14:41:32','2020-10-14 14:41:32'),(76,'Use only non-sparking tools.','P242','P242',3,3,0,0,'active',NULL,'2020-10-14 14:41:52','2020-10-14 14:41:52'),(77,'Take precautionary measures against static discharge.','P243','P243',3,3,0,0,'active',NULL,'2020-10-14 14:42:12','2020-10-14 14:42:12'),(78,'Keep valves and fittings free from oil and grease.','P244','P244',3,3,0,0,'active',NULL,'2020-10-14 14:42:33','2020-10-14 14:42:33'),(79,'Do not subject to grinding/shock/friction/...','P250','P250',3,3,0,0,'active',NULL,'2020-10-14 14:42:50','2020-10-14 14:42:50'),(80,'Do not pierce or burn, even after use.','P251','P251',3,3,0,0,'active',NULL,'2020-10-14 14:43:12','2020-10-14 14:43:12'),(81,'Do not breathe dust/fume/gas/mist/vapors/spray.','P260','P260',3,3,0,0,'active',NULL,'2020-10-14 14:43:34','2020-10-14 14:43:34'),(82,'Avoid breathing dust/fume/gas/mist/vapors/spray.','P261','P261',3,3,0,0,'active',NULL,'2020-10-14 14:44:07','2020-10-14 14:44:07'),(83,'Do not get in eyes, on skin, or on clothing.','P262','P262',3,3,0,0,'active',NULL,'2020-10-14 14:44:27','2020-10-14 14:44:27'),(84,'Avoid contact during pregnancy/while nursing.','P263','P263',3,3,0,0,'active',NULL,'2020-10-14 14:44:46','2020-10-14 14:44:46'),(85,'Wash ... thoroughly after handling.','P264','P264',3,3,0,0,'active',NULL,'2020-10-14 14:45:07','2020-10-14 14:45:07'),(86,'Do not eat, drink or smoke when using this product.','P270','P270',3,3,0,0,'active',NULL,'2020-10-14 14:45:27','2020-10-14 14:45:27'),(87,'Use only outdoors or in a well-ventilated area.','P271','P271',3,3,0,0,'active',NULL,'2020-10-14 14:46:05','2020-10-14 14:46:05'),(88,'Contaminated work clothing should not be allowed out of the workplace.','P272','P272',3,3,0,0,'active',NULL,'2020-10-14 14:46:40','2020-10-14 14:46:40'),(89,'Avoid release to the environment.','P273','P273',3,3,0,0,'active',NULL,'2020-10-14 14:47:01','2020-10-14 14:47:01'),(90,'Wear protective gloves/protective clothing/eye protection/face protection.','P280','P280',3,3,0,0,'active',NULL,'2020-10-14 14:47:27','2020-10-14 14:47:27'),(91,'Use personal protective equipment as required.','P281','P281',3,3,0,0,'active',NULL,'2020-10-14 14:47:56','2020-10-14 14:47:56'),(92,'Wear cold insulating gloves/face shield/eye protection.','P282','P282',3,3,0,0,'active',NULL,'2020-10-14 14:48:18','2020-10-14 14:48:18'),(93,'Wear fire resistant or flame retardant clothing.','P283','P283',3,3,0,0,'active',NULL,'2020-10-14 14:48:38','2020-10-14 14:48:38'),(94,'[In case of inadequate ventilation] Wear respiratory protection.','P284','P284',3,3,0,0,'active',NULL,'2020-10-14 14:48:58','2020-10-14 14:48:58'),(95,'In case of inadequate ventilation wear respiratory protection.','P285','P285',3,3,0,0,'active',NULL,'2020-10-14 14:49:17','2020-10-14 14:49:17'),(96,'Handle under inert gas/... Protect from moisture.','P231+P232','P231+P232',3,3,0,0,'active',NULL,'2020-10-14 14:49:44','2020-10-14 14:49:44'),(97,'Keep cool. Protect from sunlight.','P235+P410','P235+P410',3,3,0,0,'active',NULL,'2020-10-14 14:50:06','2020-10-14 14:50:06'),(98,'IF ON CLOTHING:','P306','IF ON CLOTHING:',3,4,0,0,'active',NULL,'2020-10-15 08:56:28','2020-10-15 08:56:28'),(99,'IF exposed:','P307','P307',3,4,0,0,'active',NULL,'2020-10-15 09:04:54','2020-10-15 09:04:54'),(100,'IF exposed or concerned:','P308','P308',3,4,0,0,'active',NULL,'2020-10-15 09:05:17','2020-10-15 09:05:17'),(101,'IF exposed or if you feel unwell','P309','P309',3,4,0,0,'active',NULL,'2020-10-15 09:05:36','2020-10-15 09:05:36'),(102,'Immediately call a POISON CENTER or doctor/physician.','P310','P310',3,4,0,0,'active',NULL,'2020-10-15 09:05:59','2020-10-15 09:05:59'),(103,'Call a POISON CENTER or doctor/...','P311','P311',3,4,0,0,'active',NULL,'2020-10-15 09:06:19','2020-10-15 09:06:19'),(104,'Call a POISON CENTER or doctor/... if you feel unwell.','P312','P312',3,4,0,0,'active',NULL,'2020-10-15 09:06:43','2020-10-15 09:06:43'),(105,'Get medical advice/attention.','P313','P313',3,4,0,0,'active',NULL,'2020-10-15 09:07:02','2020-10-15 09:07:02'),(106,'Get medical advice/attention if you feel unwell.','P314','P314',3,4,0,0,'active',NULL,'2020-10-15 09:07:20','2020-10-15 09:07:20'),(107,'Get immediate medical advice/attention.','P315','P315',3,4,0,0,'active',NULL,'2020-10-15 09:07:39','2020-10-15 09:07:39'),(108,'Specific treatment is urgent (see ... on this label).','P320','P320',3,4,0,0,'active',NULL,'2020-10-15 09:08:02','2020-10-15 09:08:02'),(109,'Specific treatment (see ... on this label).','P321','P321',3,4,0,0,'active',NULL,'2020-10-15 09:08:30','2020-10-15 09:08:30'),(110,'Specific measures (see ...on this label).','P322','P322',3,4,0,0,'active',NULL,'2020-10-15 09:08:49','2020-10-15 09:08:49'),(111,'Rinse mouth.','P330','P330',3,4,0,0,'active',NULL,'2020-10-15 09:09:14','2020-10-15 09:09:14'),(112,'Do NOT induce vomiting.','P331','Do NOT induce vomiting.',3,4,0,0,'active',NULL,NULL,NULL),(113,'IF SKIN irritation occurs:','P332','IF SKIN irritation occurs:',3,4,0,0,'active',NULL,NULL,NULL),(114,'If skin irritation or rash occurs:','P333','If skin irritation or rash occurs:',3,4,0,0,'active',NULL,NULL,NULL),(115,'Immerse in cool water [or wrap in wet bandages].','P334','Immerse in cool water [or wrap in wet bandages].',3,4,0,0,'active',NULL,NULL,NULL),(116,'Brush off loose particles from skin.','P335','Brush off loose particles from skin.',3,4,0,0,'active',NULL,NULL,NULL),(117,'Thaw frosted parts with lukewarm water. Do not rub affected area.','P336','Thaw frosted parts with lukewarm water. Do not rub affected area.',3,4,0,0,'active',NULL,NULL,NULL),(118,'If eye irritation persists:','P337','If eye irritation persists:',3,4,0,0,'active',NULL,NULL,NULL),(119,'Remove contact lenses, if present and easy to do. Continue rinsing.','P338','Remove contact lenses, if present and easy to do. Continue rinsing.',3,4,0,0,'active',NULL,NULL,NULL),(120,'Remove victim to fresh air and keep at rest in a position comfortable for breathing.','P340','Remove victim to fresh air and keep at rest in a position comfortable for breathing.',3,4,0,0,'active',NULL,NULL,NULL),(121,'If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.','P341','If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',3,4,0,0,'active',NULL,NULL,NULL),(122,'If experiencing respiratory symptoms:','P342','If experiencing respiratory symptoms:',3,4,0,0,'active',NULL,NULL,NULL),(123,'Gently wash with plenty of soap and water.','P350','Gently wash with plenty of soap and water.',3,4,0,0,'active',NULL,NULL,NULL),(124,'Rinse cautiously with water for several minutes.','P351','Rinse cautiously with water for several minutes.',3,4,0,0,'active',NULL,NULL,NULL),(125,'Wash with plenty of water/...','P352','Wash with plenty of water/...',3,4,0,0,'active',NULL,NULL,NULL),(126,'Rinse skin with water [or shower].','P353','Rinse skin with water [or shower].',3,4,0,0,'active',NULL,NULL,NULL),(127,'Rinse immediately contaminated clothing and skin with plenty of water before removing clothes.','P360','Rinse immediately contaminated clothing and skin with plenty of water before removing clothes.',3,4,0,0,'active',NULL,NULL,NULL),(128,'Take off immediately all contaminated clothing.','P361','Take off immediately all contaminated clothing.',3,4,0,0,'active',NULL,NULL,NULL),(129,'Take off contaminated clothing.','P362','Take off contaminated clothing.',3,4,0,0,'active',NULL,NULL,NULL),(130,'Wash contaminated clothing before reuse.','P363','Wash contaminated clothing before reuse.',3,4,0,0,'active',NULL,NULL,NULL),(131,'And wash it before reuse.[Added in 2015 version]','P364','And wash it before reuse.[Added in 2015 version]',3,4,0,0,'active',NULL,NULL,NULL),(132,'In case of fire:','P370','In case of fire:',3,4,0,0,'active',NULL,NULL,NULL),(133,'In case of major fire and large quantities:','P371','In case of major fire and large quantities:',3,4,0,0,'active',NULL,NULL,NULL),(134,'Explosion risk.','P372','Explosion risk.',3,4,0,0,'active',NULL,NULL,NULL),(135,'DO NOT fight fire when fire reaches explosives.','P373','DO NOT fight fire when fire reaches explosives.',3,4,0,0,'active',NULL,NULL,NULL),(136,'Fight fire with normal precautions from a reasonable distance.','P374','Fight fire with normal precautions from a reasonable distance.',3,4,0,0,'active',NULL,NULL,NULL),(137,'Stop leak if safe to do so.','P376','Stop leak if safe to do so.',3,4,0,0,'active',NULL,NULL,NULL),(138,'Leaking gas fire: Do not extinguish, unless leak can be stopped safely.','P377','Leaking gas fire: Do not extinguish, unless leak can be stopped safely.',3,4,0,0,'active',NULL,NULL,NULL),(139,'Use ... to extinguish.','P378','Use ... to extinguish.',3,4,0,0,'active',NULL,NULL,NULL),(140,'Evacuate area.','P380','Evacuate area.',3,4,0,0,'active',NULL,NULL,NULL),(141,'In case of leakage, eliminate all ignition sources.','P381','In case of leakage, eliminate all ignition sources.',3,4,0,0,'active',NULL,NULL,NULL),(142,'Absorb spillage to prevent material damage.','P390','Absorb spillage to prevent material damage.',3,4,0,0,'active',NULL,NULL,NULL),(143,'Collect spillage.','P391','Collect spillage.',3,4,0,0,'active',NULL,NULL,NULL),(144,'IF SWALLOWED: Immediately call a POISON CENTER/doctor/...','P301+P310','IF SWALLOWED: Immediately call a POISON CENTER/doctor/...',3,4,0,0,'active',NULL,NULL,NULL),(145,'IF SWALLOWED: call a POISON CENTER/doctor/... IF you feel unwell.','P301+P312','IF SWALLOWED: call a POISON CENTER/doctor/... IF you feel unwell.',3,4,0,0,'active',NULL,NULL,NULL),(146,'IF SWALLOWED: Rinse mouth. Do NOT induce vomiting.','P301+P330+P331','IF SWALLOWED: Rinse mouth. Do NOT induce vomiting.',3,4,0,0,'active',NULL,NULL,NULL),(147,'IF ON SKIN: Immerse in cool water [or wrap in wet bandages].','P302+P334','IF ON SKIN: Immerse in cool water [or wrap in wet bandages].',3,4,0,0,'active',NULL,NULL,NULL),(148,'Brush off loose particles from skin. Immerse in cool water [or wrap in wet bandages].','P302+P335+P334','Brush off loose particles from skin. Immerse in cool water [or wrap in wet bandages].',3,4,0,0,'active',NULL,NULL,NULL),(149,'IF ON SKIN: Gently wash with plenty of soap and water.','P302+P350','IF ON SKIN: Gently wash with plenty of soap and water.',3,4,0,0,'active',NULL,NULL,NULL),(150,'IF ON SKIN: wash with plenty of water.','P302+P352','IF ON SKIN: wash with plenty of water.',3,4,0,0,'active',NULL,NULL,NULL),(151,'IF ON SKIN (or hair): Take off Immediately all contaminated clothing. Rinse SKIN with water [or shower].','P303+P361+P353','IF ON SKIN (or hair): Take off Immediately all contaminated clothing. Rinse SKIN with water [or shower].',3,4,0,0,'active',NULL,NULL,NULL),(152,'IF INHALED: Call a POISON CENTER/doctor/... if you feel unwell.','P304+P312','IF INHALED: Call a POISON CENTER/doctor/... if you feel unwell.',3,4,0,0,'active',NULL,NULL,NULL),(153,'IF INHALED: Remove person to fresh air and keep comfortable for breathing.','P304+P340','IF INHALED: Remove person to fresh air and keep comfortable for breathing.',3,4,0,0,'active',NULL,NULL,NULL),(154,'IF INHALED: If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.','P304+P341','IF INHALED: If breathing is difficult, remove victim to fresh air and keep at rest in a position comfortable for breathing.',3,4,0,0,'active',NULL,NULL,NULL),(155,'IF IN EYES: Rinse cautiously with water for several minutes. Remove contact lenses if present and easy to do - continue rinsing.','P305+P351+P338','IF IN EYES: Rinse cautiously with water for several minutes. Remove contact lenses if present and easy to do - continue rinsing.',3,4,0,0,'active',NULL,NULL,NULL),(156,'IF ON CLOTHING: Rinse Immediately contaminated CLOTHING and SKIN with plenty of water before removing clothes.','P306+P360','IF ON CLOTHING: Rinse Immediately contaminated CLOTHING and SKIN with plenty of water before removing clothes.',3,4,0,0,'active',NULL,NULL,NULL),(157,'IF exposed: call a POISON CENTER or doctor/physician.','P307+P311','IF exposed: call a POISON CENTER or doctor/physician.',3,4,0,0,'active',NULL,NULL,NULL),(158,'IF exposed or concerned: Call a POISON CENTER/doctor/...','P308+P311','IF exposed or concerned: Call a POISON CENTER/doctor/...',3,4,0,0,'active',NULL,NULL,NULL),(159,'IF exposed or concerned: Get medical advice/attention.','P308+P313','IF exposed or concerned: Get medical advice/attention.',3,4,0,0,'active',NULL,NULL,NULL),(160,'IF exposed or if you feel unwell: call a POISON CENTER or doctor/physician.','P309+P311','IF exposed or if you feel unwell: call a POISON CENTER or doctor/physician.',3,4,0,0,'active',NULL,NULL,NULL),(161,'IF SKIN irritation occurs: Get medical advice/attention.','P332+P313','IF SKIN irritation occurs: Get medical advice/attention.',3,4,0,0,'active',NULL,NULL,NULL),(162,'IF SKIN irritation or rash occurs: Get medical advice/attention.','P333+P313','IF SKIN irritation or rash occurs: Get medical advice/attention.',3,4,0,0,'active',NULL,NULL,NULL),(163,'Brush off loose particles from skin. Immerse in cool water/wrap in wet bandages.','P335+P334','Brush off loose particles from skin. Immerse in cool water/wrap in wet bandages.',3,4,0,0,'active',NULL,NULL,NULL),(164,'IF eye irritation persists: Get medical advice/attention.','P337+P313','IF eye irritation persists: Get medical advice/attention.',3,4,0,0,'active',NULL,NULL,NULL),(165,'IF experiencing respiratory symptoms: Call a POISON CENTER/doctor/...','P342+P311','IF experiencing respiratory symptoms: Call a POISON CENTER/doctor/...',3,4,0,0,'active',NULL,NULL,NULL),(166,'Take off immediately all contaminated clothing and wash it before reuse.','P361+P364','Take off immediately all contaminated clothing and wash it before reuse.',3,4,0,0,'active',NULL,NULL,NULL),(167,'Take off contaminated clothing and wash it before reuse.','P362+P364','Take off contaminated clothing and wash it before reuse.',3,4,0,0,'active',NULL,NULL,NULL),(168,'in case of fire: Stop leak if safe to do so.','P370+P376','in case of fire: Stop leak if safe to do so.',3,4,0,0,'active',NULL,NULL,NULL),(169,'In case of fire: Use ... to extinguish.','P370+P378','In case of fire: Use ... to extinguish.',3,4,0,0,'active',NULL,NULL,NULL),(170,'In case of fire: Evacuate area.','P370+P380','In case of fire: Evacuate area.',3,4,0,0,'active',NULL,NULL,NULL),(171,'In case of fire: Evacuate area. Fight fire remotely due to the risk of explosion.','P370+P380+P375','In case of fire: Evacuate area. Fight fire remotely due to the risk of explosion.',3,4,0,0,'active',NULL,NULL,NULL),(172,'In case of major fire and large quantities: Evacuate area. Fight fire remotely due to the risk of explosion.','P371+P380+P375','In case of major fire and large quantities: Evacuate area. Fight fire remotely due to the risk of explosion.',3,4,0,0,'active',NULL,NULL,NULL),(173,'P240','P240',NULL,3,3,0,0,'active',NULL,'2020-10-28 07:01:48','2020-10-28 07:01:48'),(174,'Explosive when dry','R1','Explosive when dry',5,0,2,2,'active',NULL,'2021-03-17 07:11:54','2021-03-17 07:11:54'),(175,'Risk of explosion by shock, friction, fire, or other sources of ignition','R2','Risk of explosion by shock, friction, fire, or other sources of ignition',5,0,0,0,'active',NULL,NULL,NULL),(176,'Extreme risk of explosion by shock, friction, fire, or other sources of ignition','R3','Extreme risk of explosion by shock, friction, fire, or other sources of ignition',5,0,0,0,'active',NULL,NULL,NULL),(177,'Forms very sensitive explosive metallic compounds','R4','Forms very sensitive explosive metallic compounds',5,0,0,0,'active',NULL,NULL,NULL),(178,'Heating may cause an explosion','R5','Heating may cause an explosion',5,NULL,0,0,'active',NULL,NULL,NULL),(179,'Explosive with or without contact with air','R6','Explosive with or without contact with air',5,0,0,0,'active',NULL,NULL,NULL),(180,'May cause fire','R7','May cause fire',5,NULL,0,0,'active',NULL,NULL,NULL),(181,'Contact with combustible material may cause fire','R8','Contact with combustible material may cause fire',5,NULL,0,0,'active',NULL,NULL,NULL),(182,'Explosive when mixed with combustible material','R9','Explosive when mixed with combustible material',5,NULL,0,0,'active',NULL,NULL,NULL),(183,'Flammable','R10','Flammable',5,NULL,0,0,'active',NULL,NULL,NULL),(184,'Highly flammable','R11','Highly flammable',5,NULL,0,0,'active',NULL,NULL,NULL),(185,'Extremely flammable','R12','Extremely flammable',5,NULL,0,0,'active',NULL,NULL,NULL),(186,'Reacts violently with water','R14','Reacts violently with water',5,NULL,0,0,'active',NULL,NULL,NULL),(187,'Contact with water liberates extremely flammable gases','R15','Contact with water liberates extremely flammable gases',5,NULL,0,0,'active',NULL,NULL,NULL),(188,'Explosive when mixed with oxidising substances','R16','Explosive when mixed with oxidising substances',5,NULL,0,0,'active',NULL,NULL,NULL),(189,'Spontaneously flammable in air','R17','Spontaneously flammable in air',5,NULL,0,0,'active',NULL,NULL,NULL),(190,'Spontaneously flammable in air','R18','Spontaneously flammable in air',5,NULL,0,0,'active',NULL,NULL,NULL),(191,'May form explosive peroxides','R19','May form explosive peroxides',5,NULL,0,0,'active',NULL,NULL,NULL),(192,'Harmful by inhalation','R20','Harmful by inhalation',5,NULL,0,0,'active',NULL,NULL,NULL),(193,'Harmful in contact with skin','R21','Harmful in contact with skin',5,NULL,0,0,'active',NULL,NULL,NULL),(194,'Harmful if swallowed','R22','Harmful if swallowed',5,NULL,0,0,'active',NULL,NULL,NULL),(195,'Toxic by inhalation','R23','Toxic by inhalation',5,NULL,0,0,'active',NULL,NULL,NULL),(196,'Toxic in contact with skin','R24','Toxic in contact with skin',5,NULL,0,0,'active',NULL,NULL,NULL),(197,'Toxic if swallowed','R25','Toxic if swallowed',5,NULL,0,0,'active',NULL,NULL,NULL),(198,'Very toxic by inhalation','R26','Very toxic by inhalation',5,NULL,0,0,'active',NULL,NULL,NULL),(199,'Very toxic in contact with skin','R27','Very toxic in contact with skin',5,NULL,0,0,'active',NULL,NULL,NULL),(200,'Very toxic if swallowed','R28','Very toxic if swallowed',5,NULL,0,0,'active',NULL,NULL,NULL),(201,'Contact with water liberates toxic gas.','R29','Contact with water liberates toxic gas.',5,NULL,0,0,'active',NULL,NULL,NULL),(202,'Can become highly flammable in use','R30','Can become highly flammable in use',5,NULL,0,0,'active',NULL,NULL,NULL),(203,'Contact with acids liberates toxic gas','R31','Contact with acids liberates toxic gas',5,NULL,0,0,'active',NULL,NULL,NULL),(204,'Contact with acids liberates very toxic gas','R32','Contact with acids liberates very toxic gas',5,NULL,0,0,'active',NULL,NULL,NULL),(205,'Danger of cumulative effects','R33','Danger of cumulative effects',5,NULL,0,0,'active',NULL,NULL,NULL),(206,'Causes burns','R34','Causes burns',5,NULL,0,0,'active',NULL,NULL,NULL),(207,'Causes severe burns','R35','Causes severe burns',5,NULL,0,0,'active',NULL,NULL,NULL),(208,'Irritating to eyes','R36','Irritating to eyes',5,NULL,0,0,'active',NULL,NULL,NULL),(209,'Irritating to respiratory system','R37','Irritating to respiratory system',5,NULL,0,0,'active',NULL,NULL,NULL),(210,'Irritating to skin','R38','Irritating to skin',5,NULL,0,0,'active',NULL,NULL,NULL),(211,'Danger of very serious irreversible effects','R39','Danger of very serious irreversible effects',5,NULL,0,0,'active',NULL,NULL,NULL),(212,'Limited evidence of a carcinogenic effect','R40','Limited evidence of a carcinogenic effect',5,NULL,0,0,'active',NULL,NULL,NULL),(213,'Risk of serious damage to eyes','R41','Risk of serious damage to eyes',NULL,NULL,0,0,'active',NULL,NULL,NULL),(214,'May cause sensitisation by inhalation','R42','May cause sensitisation by inhalation',5,NULL,0,0,'active',NULL,NULL,NULL),(215,'May cause sensitisation by skin contact','R43','May cause sensitisation by skin contact',5,NULL,0,0,'active',NULL,NULL,NULL),(216,'Risk of explosion if heated under confinement','R44','Risk of explosion if heated under confinement',5,NULL,0,0,'active',NULL,NULL,NULL),(217,'May cause cancer','R45','May cause cancer',5,NULL,0,0,'active',NULL,NULL,NULL),(218,'May cause inheritable genetic damage','R46','May cause inheritable genetic damage',5,NULL,0,0,'active',NULL,NULL,NULL),(219,'Danger of serious damage to health by prolonged exposure','R48','Danger of serious damage to health by prolonged exposure',5,NULL,0,0,'active',NULL,NULL,NULL),(220,'May cause cancer by inhalation','R49','May cause cancer by inhalation',5,NULL,0,0,'active',NULL,NULL,NULL),(221,'Very toxic to aquatic organisms','R50','Very toxic to aquatic organisms',5,NULL,0,0,'active',NULL,NULL,NULL),(222,'Toxic to aquatic organisms','R51','Toxic to aquatic organisms',5,NULL,0,0,'active',NULL,NULL,NULL),(223,'Harmful to aquatic organisms','R52','Harmful to aquatic organisms',5,NULL,0,0,'active',NULL,NULL,NULL),(224,'May cause long-term adverse effects in the aquatic environment','R53','May cause long-term adverse effects in the aquatic environment',5,NULL,0,0,'active',NULL,NULL,NULL),(225,'Toxic to flora','R54','Toxic to flora',5,NULL,0,0,'active',NULL,NULL,NULL),(226,'Toxic to soil organisms','R56','Toxic to soil organisms',5,NULL,0,0,'active',NULL,NULL,NULL),(227,'Toxic to bees','R57','Toxic to bees',5,NULL,0,0,'active',NULL,NULL,NULL),(228,'May cause long-term adverse effects in the environment','R58','May cause long-term adverse effects in the environment',5,NULL,0,0,'active',NULL,NULL,NULL),(229,'Dangerous for the ozone layer','R59','Dangerous for the ozone layer',5,NULL,0,0,'active',NULL,NULL,NULL),(230,'May impair fertility','R60','May impair fertility',5,NULL,0,0,'active',NULL,NULL,NULL),(231,'May cause harm to the unborn child','R61','May cause harm to the unborn child',5,NULL,0,0,'active',NULL,NULL,NULL),(232,'Possible risk of impaired fertility','R62','Possible risk of impaired fertility',5,NULL,0,0,'active',NULL,NULL,NULL),(233,'Possible risk of harm to the unborn child','R63','Possible risk of harm to the unborn child',5,NULL,0,0,'active',NULL,NULL,NULL),(234,'May cause harm to breast-fed babies','R64','May cause harm to breast-fed babies',5,NULL,0,0,'active',NULL,NULL,NULL),(235,'Harmful: may cause lung damage if swallowed','R65','Harmful: may cause lung damage if swallowed',5,NULL,0,0,'active',NULL,NULL,NULL),(236,'Repeated exposure may cause skin dryness or cracking','R66','Repeated exposure may cause skin dryness or cracking',5,NULL,0,0,'active',NULL,NULL,NULL),(237,'Vapours may cause drowsiness and dizziness','R67','Vapours may cause drowsiness and dizziness',5,NULL,0,0,'active',NULL,NULL,NULL),(238,'Possible risk of irreversible effects','R68','Possible risk of irreversible effects',5,NULL,0,0,'active',NULL,NULL,NULL),(239,'Reacts violently with water, liberating extremely flammable gases','R14/15','Reacts violently with water, liberating extremely flammable gases',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(240,'Contact with water liberates toxic, extremely flammable gases','R15/29','Contact with water liberates toxic, extremely flammable gases',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(241,'Reacts violently with water, liberating toxic, extremely flammable gases','R14/15/29','Reacts violently with water, liberating toxic, extremely flammable gases',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(242,'Harmful by inhalation and in contact with skin','R20/21','Harmful by inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(243,'Harmful by inhalation and if swallowed','R20/22','Harmful by inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(244,'Harmful by inhalation, in contact with skin and if swallowed','R20/21/22','Harmful by inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(245,'Harmful in contact with skin and if swallowed','R21/22','Harmful in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(246,'Toxic by inhalation and in contact with skin','R23/24','Toxic by inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(247,'Toxic by inhalation and if swallowed','R23/25','Toxic by inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(248,'Toxic by inhalation, in contact with skin and if swallowed','R23/24/25','Toxic by inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(249,'Toxic in contact with skin and if swallowed','R24/25','Toxic in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(250,'Very toxic by inhalation and in contact with skin','R26/27','Very toxic by inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(251,'Very toxic by inhalation and if swallowed','R26/28','Very toxic by inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(252,'Very toxic by inhalation, in contact with skin and if swallowed','R26/27/28','Very toxic by inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(253,'Very toxic in contact with skin and if swallowed','R27/28','Very toxic in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(254,'Irritating to eyes and respiratory system','R36/37','Irritating to eyes and respiratory system',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(255,'Irritating to eyes and skin','R36/38','Irritating to eyes and skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(256,'Irritating to eyes, respiratory system and skin','R36/37/38','Irritating to eyes, respiratory system and skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(257,'Irritating to respiratory system and skin','R37/38','Irritating to respiratory system and skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(258,'Toxic: danger of very serious irreversible effects through inhalation','R39/23','Toxic: danger of very serious irreversible effects through inhalation',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(259,'Toxic: danger of very serious irreversible effects in contact with skin','R39/24','Toxic: danger of very serious irreversible effects in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(260,'Toxic: danger of very serious irreversible effects if swallowed','R39/25','Toxic: danger of very serious irreversible effects if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(261,'Toxic: danger of very serious irreversible effects through inhalation and in contact with skin','R39/23/24','Toxic: danger of very serious irreversible effects through inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(262,'Toxic: danger of very serious irreversible effects through inhalation and if swallowed','R39/23/25','Toxic: danger of very serious irreversible effects through inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(263,'Toxic: danger of very serious irreversible effects in contact with skin and if swallowed','R39/24/25','Toxic: danger of very serious irreversible effects in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(264,'Toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed','R39/23/24/25','Toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(265,'Very Toxic: danger of very serious irreversible effects through inhalation','R39/26','Very Toxic: danger of very serious irreversible effects through inhalation',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(266,'Very Toxic: danger of very serious irreversible effects in contact with skin','R39/27','Very Toxic: danger of very serious irreversible effects in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(267,'Very Toxic: danger of very serious irreversible effects if swallowed','R39/28','Very Toxic: danger of very serious irreversible effects if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(268,'Very Toxic: danger of very serious irreversible effects through inhalation and in contact with skin','R39/26/27','Very Toxic: danger of very serious irreversible effects through inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(269,'Very Toxic: danger of very serious irreversible effects through inhalation and if swallowed','R39/26/28','Very Toxic: danger of very serious irreversible effects through inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(270,'Very Toxic: danger of very serious irreversible effects in contact with skin and if swallowed','R39/27/28','Very Toxic: danger of very serious irreversible effects in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(271,'Very Toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed','R39/26/27/28','Very Toxic: danger of very serious irreversible effects through inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(272,'May cause sensitization by inhalation and skin contact','R42/43','May cause sensitization by inhalation and skin contact',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(273,'May cause cancer and heritable genetic damage','R45/46','May cause cancer and heritable genetic damage',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(274,'Harmful: danger of serious damage to health by prolonged exposure through inhalation','R48/20','Harmful: danger of serious damage to health by prolonged exposure through inhalation',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(275,'Harmful: danger of serious damage to health by prolonged exposure in contact with skin','R48/21','Harmful: danger of serious damage to health by prolonged exposure in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(276,'Harmful: danger of serious damage to health by prolonged exposure if swallowed','R48/22','Harmful: danger of serious damage to health by prolonged exposure if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(277,'Harmful: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin','R48/20/21','Harmful: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(278,'Harmful: danger of serious damage to health by prolonged exposure through inhalation and if swallowed','R48/20/22','Harmful: danger of serious damage to health by prolonged exposure through inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(279,'Harmful: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed','R48/21/22','Harmful: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(280,'Harmful: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed','R48/20/21/22','Harmful: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(281,'Toxic: danger of serious damage to health by prolonged exposure through inhalation','R48/23','Toxic: danger of serious damage to health by prolonged exposure through inhalation',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(282,'Toxic: danger of serious damage to health by prolonged exposure in contact with skin','R48/24','Toxic: danger of serious damage to health by prolonged exposure in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(283,'Toxic: danger of serious damage to health by prolonged exposure if swallowed','R48/25','Toxic: danger of serious damage to health by prolonged exposure if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(284,'Toxic: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin','R48/23/24','Toxic: danger of serious damage to health by prolonged exposure through inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(285,'Toxic: danger of serious damage to health by prolonged exposure through inhalation and if swallowed','R48/23/25','Toxic: danger of serious damage to health by prolonged exposure through inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(286,'Toxic: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed','R48/24/25','Toxic: danger of serious damage to health by prolonged exposure in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(287,'Toxic: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed','R48/23/24/25','Toxic: danger of serious damage to health by prolonged exposure through inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(288,'Very toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment','R50/53','Very toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(289,'Toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment','R51/53','Toxic to aquatic organisms, may cause long-term adverse effects in the aquatic environment',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(290,'Harmful to aquatic organisms, may cause long-term adverse effects in the aquatic environment','R52/53','Harmful to aquatic organisms, may cause long-term adverse effects in the aquatic environment',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(291,'Harmful: possible risk of irreversible effects through inhalation','R68/20','Harmful: possible risk of irreversible effects through inhalation',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(292,'Harmful: possible risk of irreversible effects in contact with skin','R68/21','Harmful: possible risk of irreversible effects in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(293,'Harmful: possible risk of irreversible effects if swallowed','R68/22','Harmful: possible risk of irreversible effects if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(294,'Harmful: possible risk of irreversible effects through inhalation and in contact with skin','R68/20/21','Harmful: possible risk of irreversible effects through inhalation and in contact with skin',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(295,'Harmful: possible risk of irreversible effects through inhalation and if swallowed','R68/20/22','Harmful: possible risk of irreversible effects through inhalation and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(296,'Harmful: possible risk of irreversible effects in contact with skin and if swallowed','R68/21/22','Harmful: possible risk of irreversible effects in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(297,'Harmful: possible risk of irreversible effects through inhalation, in contact with skin and if swallowed','R68/20/21/22','Harmful: possible risk of irreversible effects through inhalation, in contact with skin and if swallowed',5,7,0,0,'active',NULL,'2021-03-17 08:20:01','2021-03-17 08:20:01'),(298,'','0','0',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(299,'','1','1',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(300,'','2','2',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(301,'','3','3',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(302,'','4','4',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(303,'','5','5',8,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(304,'','0','0',6,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(305,'','1','1',6,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(306,'','2','2',6,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(307,'','3','3',6,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(308,'','4','4',6,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(309,'','0','0',7,0,2,2,'active',NULL,'2021-03-22 08:42:25','2021-03-22 08:42:25'),(310,'','1','1',7,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(311,'','2','2',7,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(312,'','3','3',7,0,2,2,'active',NULL,'2021-03-22 08:42:25','2021-03-22 08:42:25'),(313,'','0','0',9,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(314,'','1','1',9,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(315,'','2','2',9,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(316,'','3','3',9,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(317,'','4','4',9,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(318,'','0','0',10,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(319,'','1','1',10,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(320,'','2','2',10,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(321,'','3','3',10,0,2,2,'active',NULL,'2021-03-22 08:27:08','2021-03-22 08:27:08'),(322,'','4','4',10,0,2,2,'active',NULL,'2021-03-22 08:37:45','2021-03-22 08:37:45'),(323,'Explosive','GHS01','Explosive',11,0,2,2,'active',NULL,'2021-03-22 10:39:49','2021-03-22 10:39:49'),(324,'Flammable','GHS02',NULL,11,NULL,0,0,'active',NULL,NULL,NULL),(325,'Oxidizing','GHS03','Oxidizing',11,NULL,0,0,'active',NULL,NULL,NULL),(326,'Compressed Gas','GHS04','Compressed Gas',11,NULL,0,0,'active',NULL,NULL,NULL),(327,'Corrosive','GHS05','Corrosive',11,NULL,0,0,'active',NULL,NULL,NULL),(328,'Toxic','GHS06','Toxic',11,NULL,0,0,'active',NULL,NULL,NULL),(329,'Harmful','GHS07','Harmful',11,NULL,0,0,'active',NULL,NULL,NULL),(330,'Health hazard','GHS08','Health hazard',11,NULL,0,0,'active',NULL,NULL,NULL),(331,'Environmental hazard','GHS09','Environmental hazard',11,NULL,0,0,'active',NULL,NULL,NULL);
/*!40000 ALTER TABLE `code_statements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso3` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `iso2` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `capital` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `native` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emoji` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emojiU` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `flag` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wikiDataId` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (82,'Germany','DEU','DE','49','Berlin','EUR','Deutschland','🇩🇪','U+1F1E9 U+1F1EA','1','Q183','active',1,1,NULL,'2021-12-01 14:53:36','2021-12-01 14:53:36'),(101,'India','IND','IN','91','New Delhi','INR','भारत','🇮🇳','U+1F1EE U+1F1F3','1','Q668','active',1,1,NULL,'2021-12-01 14:53:36','2021-12-01 14:53:36'),(156,'Netherlands Antilles','ANT','AN','','','',NULL,NULL,NULL,'1',NULL,'active',1,1,NULL,'2021-12-01 14:53:36','2021-12-01 14:53:36');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criteria_masters`
--

DROP TABLE IF EXISTS `criteria_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `criteria_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteria_masters`
--

LOCK TABLES `criteria_masters` WRITE;
/*!40000 ALTER TABLE `criteria_masters` DISABLE KEYS */;
INSERT INTO `criteria_masters` VALUES (1,0,'Fixed Value','Fixed Value','active',2,2,NULL,'2021-03-05 12:38:49','2021-03-05 12:54:14'),(2,0,'Less Than (<)','Less Than (<)','active',2,2,NULL,'2021-03-05 12:39:31','2021-03-05 12:54:45'),(3,0,'Greater Than (>)','Greater Than (>)','active',2,2,NULL,'2021-03-05 12:55:03','2021-03-05 12:55:03'),(4,0,'Range','Range','active',2,2,NULL,'2021-03-05 12:55:16','2021-03-05 12:55:16'),(5,3,'Crieteria 1',NULL,'active',27,27,NULL,'2021-12-02 10:25:30','2021-12-02 10:25:30'),(6,5,'Fixed Value','Fixed Value','active',28,28,NULL,'2021-12-24 17:11:14','2021-12-24 17:11:14'),(7,5,'Less Than (<)','Less Than (<)','active',28,28,NULL,'2021-12-24 17:11:41','2021-12-24 17:11:41'),(8,5,'Greater Than (>)','Greater Than (>)','active',28,28,NULL,'2021-12-24 17:12:04','2021-12-24 17:12:04'),(9,5,'Range','Range','active',28,28,NULL,'2021-12-24 17:12:26','2021-12-24 17:12:26'),(10,6,'Fixed Value','Fixed Value','active',28,28,NULL,'2021-12-24 17:23:30','2021-12-24 17:23:30'),(11,6,'Less Than (<)','Less Than (<)','active',28,28,NULL,'2021-12-24 17:23:42','2021-12-24 17:23:42'),(12,6,'Greater Than (>)','Greater Than (>)','active',28,28,NULL,'2021-12-24 17:23:55','2021-12-24 17:23:55'),(13,6,'Range','Range','active',28,28,NULL,'2021-12-24 17:24:08','2021-12-24 17:24:08'),(14,1,'Criteria 1',NULL,'active',27,27,NULL,'2021-12-29 10:55:53','2021-12-29 12:51:58');
/*!40000 ALTER TABLE `criteria_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curation_rules`
--

DROP TABLE IF EXISTS `curation_rules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curation_rules` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curation_rules`
--

LOCK TABLES `curation_rules` WRITE;
/*!40000 ALTER TABLE `curation_rules` DISABLE KEYS */;
/*!40000 ALTER TABLE `curation_rules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `currencies`
--

DROP TABLE IF EXISTS `currencies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `currencies` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `Date` date NOT NULL,
  `USD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `JPY` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `BGN` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CZK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `DKK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `GBP` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `HUF` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `PLN` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `RON` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `SEK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CHF` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `ISK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `NOK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `HRK` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `RUB` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `TRY` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `AUD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `BRL` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CAD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `CNY` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `HKD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `IDR` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `ILS` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `INR` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `KRW` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `MXN` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `MYR` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `NZD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `PHP` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `SGD` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `THB` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `ZAR` decimal(12,6) NOT NULL DEFAULT '0.000000',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `currencies`
--

LOCK TABLES `currencies` WRITE;
/*!40000 ALTER TABLE `currencies` DISABLE KEYS */;
INSERT INTO `currencies` VALUES (1,'2021-12-01',1.233800,127.030000,1.955800,26.145000,7.439300,0.906350,357.860000,4.516000,4.872000,10.065300,1.233800,156.300000,10.381000,7.559500,90.817500,9.055400,1.582400,6.511900,1.564000,7.965300,9.565900,17168.200000,3.928900,90.204000,1339.300000,24.354300,4.948200,1.691600,59.296000,1.624600,36.921000,18.512300,2,2,NULL,'2021-01-22 14:55:57','2021-01-22 14:55:57');
/*!40000 ALTER TABLE `currencies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_curations`
--

DROP TABLE IF EXISTS `data_curations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_curations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `data_set_id` int NOT NULL DEFAULT '0',
  `curation_rule_id` int NOT NULL DEFAULT '0',
  `data_set_experiment_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variation_coeficient` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `smoothness_factor` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `csv_file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `output` json DEFAULT NULL,
  `status` enum('pending','failure','success') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_curations`
--

LOCK TABLES `data_curations` WRITE;
/*!40000 ALTER TABLE `data_curations` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_curations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_request_models`
--

DROP TABLE IF EXISTS `data_request_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_request_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `process_experiment_id` int NOT NULL DEFAULT '0',
  `model_id` int NOT NULL DEFAULT '0',
  `simulation_input_id` int NOT NULL DEFAULT '0',
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `flag` int NOT NULL DEFAULT '0',
  `status` enum('requested','under_process','processed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `operation_status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_request_models`
--

LOCK TABLES `data_request_models` WRITE;
/*!40000 ALTER TABLE `data_request_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_request_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_models`
--

DROP TABLE IF EXISTS `dataset_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dataset_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_experiment_id` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `model_id` int NOT NULL DEFAULT '0',
  `filename` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `update_notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `update_parameter` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('requested','under_process','processed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `operation_status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `flag` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_models`
--

LOCK TABLES `dataset_models` WRITE;
/*!40000 ALTER TABLE `dataset_models` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_models` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `datasets`
--

DROP TABLE IF EXISTS `datasets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `datasets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `project_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `experiment_file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experiment_data` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `datasets`
--

LOCK TABLES `datasets` WRITE;
/*!40000 ALTER TABLE `datasets` DISABLE KEYS */;
/*!40000 ALTER TABLE `datasets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `db_backups`
--

DROP TABLE IF EXISTS `db_backups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `db_backups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint NOT NULL DEFAULT '0',
  `minute` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hour` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `month` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day_week` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backup_period` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','success','failed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `db_backups`
--

LOCK TABLES `db_backups` WRITE;
/*!40000 ALTER TABLE `db_backups` DISABLE KEYS */;
/*!40000 ALTER TABLE `db_backups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `energy_property_masters`
--

DROP TABLE IF EXISTS `energy_property_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `energy_property_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `property_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `energy_property_masters`
--

LOCK TABLES `energy_property_masters` WRITE;
/*!40000 ALTER TABLE `energy_property_masters` DISABLE KEYS */;
INSERT INTO `energy_property_masters` VALUES (1,0,'Technical properties','Technical properties','active',1,1,NULL,'2021-12-01 18:23:33','2021-12-01 18:23:33'),(2,0,'Sustainability Information','Sustainability Information','active',1,1,NULL,'2021-12-01 18:23:33','2021-12-01 18:23:33'),(3,0,'Commercial Information','Commercial Information','active',1,1,NULL,'2021-12-01 18:23:33','2021-12-01 18:23:33'),(4,0,'Notes/Files','Notes/Files','active',1,1,NULL,'2021-12-01 18:23:33','2021-12-01 18:23:33'),(5,0,'Electricity',NULL,'active',28,28,NULL,'2021-12-22 13:37:25','2021-12-22 13:38:12');
/*!40000 ALTER TABLE `energy_property_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `energy_sub_property_masters`
--

DROP TABLE IF EXISTS `energy_sub_property_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `energy_sub_property_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `property_id` int DEFAULT NULL,
  `base_unit` bigint DEFAULT NULL,
  `sub_property_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fields` json DEFAULT NULL,
  `dynamic_fields` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `energy_sub_property_masters`
--

LOCK TABLES `energy_sub_property_masters` WRITE;
/*!40000 ALTER TABLE `energy_sub_property_masters` DISABLE KEYS */;
INSERT INTO `energy_sub_property_masters` VALUES (1,0,1,7,'Enthalpy Change of Combustion (Dhcomb)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Combustion (Dhcomb)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-21 12:58:58','2021-02-18 14:08:28'),(2,0,4,0,'Files','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Files\", \"field_type_id\": \"11\"}]','active',2,2,NULL,'2020-12-21 13:00:19','2020-12-21 13:00:19'),(3,0,4,0,'Notes/Comments','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"field_name\": \"Notes/Comments\", \"field_type_id\": \"8\"}]','active',2,2,NULL,'2020-12-21 13:00:51','2020-12-21 13:00:51'),(4,0,3,7,'Price','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"29\", \"field_name\": \"Price\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-21 13:01:37','2021-02-18 14:45:20'),(6,0,1,7,'Enthalpy Change of Vaporization (Dhvap)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Vaporization (Dhvap)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"4\"}]','active',2,2,NULL,'2020-12-22 11:42:13','2021-02-18 14:15:54'),(7,0,1,0,'Pressure','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"5\", \"field_name\": \"Pressure\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 11:42:53','2020-12-24 17:28:47'),(8,0,1,7,'Specific Heat Capacity (Cp)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"21\", \"field_name\": \"Specific Heat Capacity (Cp)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 11:45:21','2021-02-18 14:18:23'),(9,0,1,0,'Temperature','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"12\", \"field_name\": \"Temperature\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 11:47:57','2020-12-24 17:29:36'),(10,0,2,0,'Carbon Content','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"16\", \"field_name\": \"Carbon Content\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 11:51:02','2020-12-24 17:30:00'),(11,0,2,7,'Cummulative Energy Demand','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"23\", \"field_name\": \"Cummulative Energy Demand\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 11:55:42','2021-02-18 14:30:22'),(12,0,2,0,'Energy Content','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"11\", \"field_name\": \"Energy Content\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 12:00:27','2021-02-11 14:27:51'),(13,0,2,0,'Eutrophication potential','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"43\", \"field_name\": \"Eutrophication potential\", \"field_type_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 12:01:46','2020-12-24 17:31:18'),(14,0,2,7,'Greenhouse Gas Emission','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"24\", \"field_name\": \"Greenhouse Gas Emission\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 12:02:46','2021-02-18 14:32:16'),(15,0,2,7,'Land Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"28\", \"field_name\": \"Land Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 12:05:20','2021-02-18 14:38:43'),(16,0,2,7,'Non Renewable Energy Use (NREU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"25\", \"field_name\": \"Select Non Renewable Energy Use (NREU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 12:06:01','2021-02-18 14:40:06'),(17,0,2,7,'Renewable Energy Use (REU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"26\", \"field_name\": \"Renewable Energy Use (REU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 12:06:59','2021-02-18 14:41:39'),(18,0,2,7,'Water Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"27\", \"field_name\": \"Water Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 12:08:00','2021-03-03 11:33:09'),(19,0,1,6,'Enthalpy Change of Combustion (Dhcomb)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Combustion (Dhcomb)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-21 12:58:58','2021-02-18 14:11:34'),(20,0,1,2,'Enthalpy Change of Combustion (Dhcomb)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Combustion (Dhcomb)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-21 12:58:58','2021-02-18 14:11:16'),(21,0,1,2,'Enthalpy Change of Vaporization (Dhvap)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Vaporization (Dhvap)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"5\"}]','active',2,2,NULL,'2020-12-22 11:42:13','2021-02-18 14:17:08'),(22,0,1,6,'Enthalpy Change of Vaporization (Dhvap)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"22\", \"field_name\": \"Enthalpy Change of Vaporization (Dhvap)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"6\"}]','active',2,2,NULL,'2020-12-22 11:42:13','2021-02-18 14:17:24'),(23,0,1,2,'Specific Heat Capacity (Cp)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"21\", \"field_name\": \"Specific Heat Capacity (Cp)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 11:45:21','2021-02-18 14:19:40'),(24,0,1,6,'Specific Heat Capacity (Cp)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"21\", \"field_name\": \"Specific Heat Capacity (Cp)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 11:45:21','2021-02-18 14:20:05'),(25,0,2,2,'Cummulative Energy Demand','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"23\", \"field_name\": \"Cummulative Energy Demand\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 11:55:42','2021-02-18 14:31:03'),(26,0,2,6,'Cummulative Energy Demand','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"23\", \"field_name\": \"Cummulative Energy Demand\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 11:55:42','2021-02-18 14:31:17'),(27,0,2,2,'Greenhouse Gas Emission','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"24\", \"field_name\": \"Greenhouse Gas Emission\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 12:02:46','2021-02-18 14:33:02'),(29,0,2,6,'Greenhouse Gas Emission','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"24\", \"field_name\": \"Greenhouse Gas Emission\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 12:02:46','2021-02-18 14:35:58'),(30,0,2,2,'Land Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"28\", \"field_name\": \"Land Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"1\"}]','active',2,2,NULL,'2020-12-22 12:05:20','2021-02-18 14:39:22'),(31,0,2,6,'Land Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"28\", \"field_name\": \"Land Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 12:05:20','2021-02-18 14:39:33'),(32,0,2,2,'Non Renewable Energy Use (NREU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"25\", \"field_name\": \"Select Non Renewable Energy Use (NREU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 12:06:01','2021-02-18 14:40:48'),(33,0,2,6,'Non Renewable Energy Use (NREU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"25\", \"field_name\": \"Select Non Renewable Energy Use (NREU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 12:06:01','2021-02-18 14:41:00'),(34,0,2,2,'Renewable Energy Use (REU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"26\", \"field_name\": \"Renewable Energy Use (REU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 12:06:59','2021-02-18 14:42:15'),(35,0,2,6,'Renewable Energy Use (REU)','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"26\", \"field_name\": \"Renewable Energy Use (REU)\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 12:06:59','2021-02-18 14:42:27'),(36,0,2,2,'Water Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"27\", \"field_name\": \"Water Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-22 12:08:00','2021-03-03 11:32:54'),(37,0,2,6,'Water Usage','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"27\", \"field_name\": \"Water Usage\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-22 12:08:00','2021-03-03 11:32:36'),(38,0,3,2,'Price','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"29\", \"field_name\": \"Price\", \"field_type_id\": \"5\", \"unit_constant_id\": \"2\"}]','active',2,2,NULL,'2020-12-21 13:01:37','2021-02-18 14:46:54'),(39,0,3,6,'Price','[{\"id\": \"0\", \"field_name\": \"Reference Source\", \"field_type_id\": \"8\"}, {\"id\": \"1\", \"field_name\": \"Keywords\", \"field_type_id\": \"9\"}]','[{\"id\": \"0\", \"unit_id\": \"29\", \"field_name\": \"Price\", \"field_type_id\": \"5\", \"unit_constant_id\": \"3\"}]','active',2,2,NULL,'2020-12-21 13:01:37','2021-02-18 14:47:12');
/*!40000 ALTER TABLE `energy_sub_property_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `energy_utilities`
--

DROP TABLE IF EXISTS `energy_utilities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `energy_utilities` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `energy_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_unit_type` int DEFAULT NULL,
  `vendor_id` int DEFAULT NULL,
  `country_id` bigint DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prop_technical` json DEFAULT NULL,
  `prop_sustain_info` json DEFAULT NULL,
  `prop_comm_info` json DEFAULT NULL,
  `prop_notes` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `energy_utilities`
--

LOCK TABLES `energy_utilities` WRITE;
/*!40000 ALTER TABLE `energy_utilities` DISABLE KEYS */;
/*!40000 ALTER TABLE `energy_utilities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `energy_utility_properties`
--

DROP TABLE IF EXISTS `energy_utility_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `energy_utility_properties` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `energy_id` int DEFAULT NULL,
  `property_id` int DEFAULT NULL,
  `sub_property_id` int DEFAULT NULL,
  `prop_json` json DEFAULT NULL,
  `dynamic_prop_json` json DEFAULT NULL,
  `order_by` int DEFAULT NULL,
  `recommended` enum('on','off') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'on',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `energy_utility_properties`
--

LOCK TABLES `energy_utility_properties` WRITE;
/*!40000 ALTER TABLE `energy_utility_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `energy_utility_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipment_units`
--

DROP TABLE IF EXISTS `equipment_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipment_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `model_id` int NOT NULL DEFAULT '0',
  `equipment_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `outcome` json DEFAULT NULL,
  `condition` json DEFAULT NULL,
  `stream_flow` json DEFAULT NULL,
  `unit_image` int DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment_units`
--

LOCK TABLES `equipment_units` WRITE;
/*!40000 ALTER TABLE `equipment_units` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipment_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `equipments`
--

DROP TABLE IF EXISTS `equipments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `equipment_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `installation_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchased_date` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `vendor_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `country_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipments`
--

LOCK TABLES `equipments` WRITE;
/*!40000 ALTER TABLE `equipments` DISABLE KEYS */;
/*!40000 ALTER TABLE `equipments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_categories`
--

DROP TABLE IF EXISTS `experiment_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_categories`
--

LOCK TABLES `experiment_categories` WRITE;
/*!40000 ALTER TABLE `experiment_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiment_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_classifications`
--

DROP TABLE IF EXISTS `experiment_classifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_classifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_classifications`
--

LOCK TABLES `experiment_classifications` WRITE;
/*!40000 ALTER TABLE `experiment_classifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiment_classifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_condition_masters`
--

DROP TABLE IF EXISTS `experiment_condition_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_condition_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unittype` int NOT NULL DEFAULT '1',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=511 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_condition_masters`
--

LOCK TABLES `experiment_condition_masters` WRITE;
/*!40000 ALTER TABLE `experiment_condition_masters` DISABLE KEYS */;
INSERT INTO `experiment_condition_masters` VALUES (1,0,'Volume','Volume',2,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:03:28'),(2,0,'Temperature','Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:04:08'),(3,0,'Pressure','',5,'active',1,1,NULL,'2020-10-06 15:37:41','2020-10-06 15:37:41'),(4,0,'Residence time','Residence time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:05:16'),(5,0,'Mixing intensity','Mixing intensity',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:07:14'),(6,0,'EG:PTA molar ratio',NULL,43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:07:48'),(7,0,'Throughput',NULL,10,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:08:04'),(8,0,'CatSpec',NULL,18,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:08:33'),(9,0,'Pigment Spec','Pigment Spec',18,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:09:25'),(10,0,'Flow velocity','Flow velocity',34,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:09:42'),(11,0,'Length of the finisher reactor','Length of the finisher reactor',32,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:10:16'),(12,0,'Cross-section Area','Cross-section Area',9,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:10:38'),(13,0,'Height','Height',1,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:11:00'),(14,0,'Radius','Radius',1,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:11:19'),(15,0,'Catalyst Loading','Catalyst Loading',18,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:12:50'),(16,0,'Pigment Specification','Pigment Specification',18,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:13:11'),(17,0,'Molar Ratio','Molar Ratio',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:13:57'),(18,0,'Operating Time','Operating Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:14:28'),(19,0,'L/D Ratio','L/D Ratio',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:14:49'),(20,0,'Outflow Volume','Outflow Volume',2,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:15:07'),(21,0,'Mass Flow','Mass Flow',10,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:15:56'),(22,0,'Volumetric Flow','Volumetric Flow',4,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:16:30'),(23,0,'Molar Flow','Molar Flow',3,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:16:57'),(24,0,'Mass Transfer Coefficient','Mass Transfer Coefficient',39,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:17:22'),(25,0,'Mass Transfer Rate','Mass Transfer Rate',3,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:17:57'),(26,0,'Contact Surface Area','Contact Surface Area',9,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:18:18'),(27,0,'Chemical Amount','Chemical Amount',13,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:18:39'),(28,0,'Length of PFR','Length of PFR',1,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:19:02'),(29,0,'Vapor Phase Mole Fraction','Vapor Phase Mole Fraction',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:19:18'),(30,0,'Condensor Pressure','Condensor Pressure',5,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:19:38'),(31,0,'Condensor Type','Condensor Type',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:20:24'),(32,0,'Reflux Ratio','Reflux Ratio',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:20:44'),(33,0,'Compound mass flow in product stream','Compound mass flow in product stream',10,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:21:14'),(34,0,'Compound fraction in product stream','Compound fraction in product stream',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:21:42'),(35,0,'Reboiler Pressure','Reboiler Pressure',5,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:22:03'),(36,0,'Number of Stages','Number of Stages',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:23:02'),(37,0,'Mixing Time','Mixing Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:22:46'),(38,0,'Mixing Temperature','Mixing Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:23:21'),(39,0,'DIP Time','DIP Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:23:36'),(40,0,'DIP Container Temperature','DIP Container Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:23:55'),(41,0,'Blower Time','Blower Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:24:08'),(42,0,'BLower Temperature','BLower Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:24:24'),(43,0,'Drying Time','Drying Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:24:46'),(44,0,'Drying Temperature','Drying Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:25:04'),(45,0,'Humidity','Humidity',43,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:25:35'),(46,0,'Equipment Volume','Equipment Volume',2,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:26:03'),(47,0,'Processing Time','Processing Time',14,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:26:31'),(48,0,'Processing Temperature','Processing Temperature',12,'active',1,2,NULL,'2020-10-06 15:37:41','2020-10-07 15:26:49'),(49,0,'Volume Level','Volume Level',43,'active',2,1,NULL,'2020-10-07 14:16:12','2021-05-06 09:55:36'),(50,0,'Feed Stage(Dist)','Feed Stage(Dist)',43,'active',2,2,NULL,'2020-10-07 15:28:29','2020-10-07 15:28:29'),(51,0,'Temprature Difference','Temprature Difference',12,'active',2,2,NULL,'2020-10-07 15:29:15','2020-10-08 09:31:49'),(52,0,'Temperature Top','Temperature Top',12,'active',2,2,NULL,'2020-10-07 15:29:45','2020-10-08 09:31:56'),(53,0,'Temperature Bottom','Temperature Bottom',12,'active',2,2,NULL,'2020-10-07 15:30:02','2020-10-08 09:32:04'),(54,0,'Mass Fraction Light component','Mass Fraction Light component',43,'active',2,2,NULL,'2020-10-07 15:30:37','2020-10-08 09:31:42'),(55,0,'Mass Fraction Heavy component','Mass Fraction Heavy component',43,'active',2,2,NULL,'2020-10-07 15:30:59','2020-10-08 09:31:35'),(56,0,'Feed flow rate','Feed flow rate',10,'active',2,2,NULL,'2020-12-28 15:52:31','2020-12-28 15:52:31'),(57,0,'Inlet Temperature of feed','Inlet Temperature of feed',12,'active',2,2,NULL,'2020-12-28 15:52:58','2020-12-28 15:52:58'),(58,0,'Moisture content of feed','Moisture content of feed',17,'active',2,2,NULL,'2020-12-28 15:54:12','2020-12-28 15:54:12'),(59,0,'Specific heat of feed','Specific heat of feed',11,'active',2,2,NULL,'2020-12-28 15:54:47','2020-12-28 15:54:47'),(60,0,'Utility Temperature (Air)',NULL,12,'active',2,2,NULL,'2020-12-28 15:56:57','2020-12-28 15:56:57'),(61,0,'Slurry flow rate','Slurry flow rate',10,'active',2,2,NULL,'2020-12-28 15:57:54','2020-12-28 15:57:54'),(62,0,'Slurry Composition','Slurry Composition',17,'active',2,2,NULL,'2020-12-28 15:58:30','2020-12-28 15:58:30'),(63,0,'Component Densities','Component Densities',8,'active',2,2,NULL,'2020-12-28 15:59:22','2020-12-28 15:59:22'),(64,0,'Crystallizer temperature','Crystallizer temperature',12,'active',2,2,NULL,'2020-12-28 15:59:45','2020-12-28 15:59:45'),(65,0,'Feed composition','Feed composition',17,'active',2,2,NULL,'2020-12-28 16:00:10','2020-12-28 16:00:10'),(66,0,'Feed temperature','Feed temperature',12,'active',2,2,NULL,'2020-12-28 16:01:16','2020-12-28 16:01:16'),(67,0,'Crystallizer diameter','Crystallizer diameter',1,'active',2,2,NULL,'2020-12-28 16:01:56','2020-12-28 16:01:56'),(68,0,'Crystallizer frowth rate','Crystallizer frowth rate',39,'active',2,2,NULL,'2020-12-28 16:02:40','2020-12-28 16:02:40'),(69,0,'Crystallizer type','Crystallizer type',43,'active',2,2,NULL,'2020-12-28 16:03:25','2020-12-28 16:03:25'),(70,0,'feed entering tray','feed entering tray',43,'active',2,2,NULL,'2020-12-28 16:06:40','2020-12-28 16:06:40'),(71,0,'Temperature @ bottom,Top','Temperature @ bottom,Top',12,'active',2,2,NULL,'2020-12-28 16:07:17','2020-12-28 16:07:17'),(72,0,'Antoine constants for components','Antoine constants for components',43,'active',2,2,NULL,'2020-12-28 16:10:05','2020-12-28 16:10:05'),(73,0,'Feed flowrate','Feed flowrate',10,'active',2,2,NULL,'2020-12-28 16:10:37','2020-12-28 16:10:37'),(74,0,'Feed composition','Feed composition',17,'active',2,2,NULL,'2020-12-28 16:10:57','2020-12-28 16:10:57'),(75,0,'specific heat of components','specific heat of components',11,'active',2,2,NULL,'2020-12-28 16:11:42','2020-12-28 16:11:42'),(76,0,'diameter',NULL,1,'active',7,7,NULL,'2021-05-20 13:10:22','2021-05-20 13:10:22'),(77,0,'outlet diameter',NULL,1,'active',7,7,NULL,'2021-05-20 13:11:00','2021-05-20 13:11:00'),(78,0,'n_set',NULL,43,'active',7,7,NULL,'2021-05-20 14:59:29','2021-05-20 14:59:29'),(79,0,'n_reactor',NULL,43,'active',7,7,NULL,'2021-05-20 14:59:44','2021-05-20 14:59:44'),(80,0,'n_roll',NULL,43,'active',7,7,NULL,'2021-05-20 14:59:56','2021-05-20 14:59:56'),(81,0,'Electrode area',NULL,9,'active',7,7,NULL,'2021-05-20 15:13:55','2021-05-20 15:13:55'),(82,0,'Voltage',NULL,53,'active',7,7,NULL,'2021-05-20 15:15:40','2021-05-20 15:15:55'),(83,0,'Current',NULL,52,'active',7,7,NULL,'2021-05-20 15:16:12','2021-05-20 15:16:12'),(84,0,'Efficiency',NULL,43,'active',7,7,NULL,'2021-05-20 15:40:16','2021-05-20 15:40:16'),(85,0,'Water input',NULL,3,'active',7,7,NULL,'2021-05-31 19:20:17','2021-05-31 19:20:17'),(86,0,'\'H\' step duration',NULL,14,'active',7,7,NULL,'2021-06-01 12:11:19','2021-06-01 12:11:19'),(87,0,'\'H with no current\' step duration (before)',NULL,14,'active',7,7,NULL,'2021-06-01 12:11:59','2021-06-01 12:11:59'),(88,0,'\'H with no current\' step duration (after)',NULL,14,'active',7,7,NULL,'2021-06-01 12:12:35','2021-06-01 12:12:50'),(89,0,'\'W\' step duration',NULL,14,'active',7,7,NULL,'2021-06-01 12:13:28','2021-06-01 12:13:28'),(90,0,'\'O\' step duration',NULL,14,'active',7,7,NULL,'2021-06-01 12:15:35','2021-06-01 12:15:35'),(91,0,'Step transition duration',NULL,14,'active',7,7,NULL,'2021-06-01 12:15:52','2021-06-01 12:15:52'),(92,0,'Step shift',NULL,14,'active',7,7,NULL,'2021-06-01 12:17:05','2021-06-01 12:17:05'),(93,0,'Initial height',NULL,1,'active',7,7,NULL,'2021-06-02 19:04:57','2021-06-02 19:04:57'),(94,0,'Initial pressure',NULL,5,'active',7,7,NULL,'2021-06-02 19:05:09','2021-06-02 19:05:09'),(95,0,'Initial mass',NULL,7,'active',7,7,NULL,'2021-06-02 19:15:51','2021-06-02 19:15:51'),(96,0,'time interval',NULL,14,'active',7,7,NULL,'2021-06-23 19:00:27','2021-06-23 19:00:27'),(97,0,'max power',NULL,36,'active',7,7,NULL,'2021-06-30 12:01:51','2021-06-30 12:01:51'),(98,0,'Power input',NULL,36,'active',7,7,NULL,'2021-06-30 15:15:19','2021-06-30 15:15:19'),(99,0,'Contact Time',NULL,62,'active',12,7,NULL,'2021-06-30 18:20:23','2021-07-26 14:53:37'),(100,0,'Mixing Behaviour',NULL,43,'active',12,12,NULL,'2021-07-05 15:43:37','2021-07-05 15:43:37'),(101,0,'Milling Temperature',NULL,12,'active',12,12,NULL,'2021-07-05 15:43:56','2021-07-05 15:43:56'),(102,0,'Dilution',NULL,61,'active',7,7,NULL,'2021-07-23 16:45:58','2021-07-26 14:47:33'),(103,3,'Condition 1',NULL,2,'active',27,27,'2021-12-09 11:46:52','2021-12-02 10:18:36','2021-12-09 11:46:52'),(104,3,'Condition 2',NULL,1,'active',27,27,'2021-12-09 11:46:52','2021-12-02 10:59:42','2021-12-09 11:46:52'),(105,3,'Condition 3',NULL,3,'active',27,27,'2021-12-09 11:46:52','2021-12-02 10:59:55','2021-12-09 11:46:52'),(106,3,'Test Outcome','test description',0,'inactive',0,27,'2021-12-09 11:46:38','2021-12-09 11:00:10','2021-12-09 11:46:38'),(107,3,'Test ','test ',0,'inactive',0,27,'2021-12-09 11:46:42','2021-12-09 11:00:10','2021-12-09 11:46:42'),(108,7,'V0 thickness (mm)',NULL,205,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:20:06'),(109,7,'catalyst weight dosed',NULL,214,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:13:42'),(110,7,'diluent volume hexane',NULL,215,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:21:33'),(111,7,'catalyst concentration',NULL,216,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:22:46'),(112,7,'catalyst volume dosed',NULL,218,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:23:19'),(113,7,'cocatalyst reactor concentration',NULL,217,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:23:44'),(114,7,'cocatalyst dosed volume',NULL,219,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:24:04'),(115,7,'ethylene concentration measured',NULL,220,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:28:08'),(116,7,'hydrogen average concentration',NULL,221,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:27:39'),(117,7,'ethane concentration',NULL,222,'active',0,27,NULL,'2021-12-09 11:05:23','2021-12-22 14:26:54'),(118,7,'butene average concentration',NULL,223,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:13:14'),(119,7,'reaction temperature average',NULL,224,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 15:07:06'),(120,7,'reaction pressure',NULL,225,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:14:05'),(121,7,'kp1',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:15:16'),(122,7,'kp2',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:16:02'),(123,7,'ka1',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:15:37'),(124,7,'ka2',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:16:17'),(125,7,'kd1',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:16:42'),(126,7,'kd2',NULL,61,'active',0,27,NULL,'2021-12-09 11:05:23','2022-01-11 12:17:00'),(127,3,'Test Outcome','test description',0,'active',0,0,NULL,'2021-12-09 11:47:46','2021-12-09 11:47:46'),(128,3,'Test Outcome','test description',0,'inactive',0,27,'2021-12-09 12:50:05','2021-12-09 11:50:35','2021-12-09 12:50:05'),(129,3,'test','test',0,'inactive',0,27,'2021-12-09 12:50:09','2021-12-09 11:50:35','2021-12-09 12:50:09'),(130,3,'Test Outcome','test description',0,'inactive',0,27,'2021-12-09 12:50:13','2021-12-09 11:50:35','2021-12-09 12:50:13'),(131,3,'Test Outcome','test description',0,'active',0,0,NULL,'2021-12-09 12:51:30','2021-12-09 12:51:30'),(132,3,'test','test description',0,'active',0,0,NULL,'2021-12-09 12:51:30','2021-12-09 12:51:30'),(133,3,'Test Outcome','test description',0,'active',0,0,NULL,'2021-12-09 12:51:30','2021-12-09 12:51:30'),(134,3,'test','',2,'active',27,27,NULL,'2021-12-14 13:54:14','2021-12-14 13:54:14'),(135,3,'HH (mean)','',0,'active',27,27,NULL,'2021-12-14 13:54:14','2021-12-14 13:54:14'),(136,3,'test','',2,'active',27,27,NULL,'2021-12-14 13:55:27','2021-12-14 13:55:27'),(137,3,'test','',0,'active',27,27,NULL,'2021-12-14 13:55:27','2021-12-14 13:55:27'),(138,3,'test','',2,'active',27,27,NULL,'2021-12-14 13:56:49','2021-12-14 13:56:49'),(139,3,'test','',2,'active',27,27,NULL,'2021-12-14 13:56:49','2021-12-14 13:56:49'),(140,6,'volume','volume',2,'active',28,28,NULL,'2021-12-16 11:55:05','2021-12-16 11:55:05'),(141,6,'Temperature','Temperature',12,'active',28,28,NULL,'2021-12-16 11:56:40','2021-12-16 11:56:40'),(142,6,'Pressure','Pressure',5,'active',28,28,NULL,'2021-12-16 11:57:22','2021-12-16 11:57:22'),(143,6,'Residence Time','Residence Time',14,'active',28,28,NULL,'2021-12-16 11:58:13','2021-12-16 11:58:13'),(144,6,NULL,NULL,0,'inactive',0,28,'2021-12-16 12:11:28','2021-12-16 12:07:56','2021-12-16 12:11:28'),(145,6,NULL,NULL,0,'inactive',0,28,'2021-12-16 12:11:33','2021-12-16 12:07:56','2021-12-16 12:11:33'),(146,6,NULL,NULL,0,'inactive',0,28,'2021-12-16 12:11:38','2021-12-16 12:07:56','2021-12-16 12:11:38'),(147,6,NULL,NULL,0,'inactive',0,28,'2021-12-16 12:11:42','2021-12-16 12:07:56','2021-12-16 12:11:42'),(148,6,'Mixing Intensity',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:11:57'),(149,6,'EG:PTA molar ratio',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:13:10'),(150,6,'Throughput',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:13:43'),(151,6,'CatSpec',NULL,18,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:14:20'),(152,6,'Pigment Spec',NULL,18,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:14:47'),(153,6,'Flow velocity',NULL,34,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:15:19'),(154,6,'Length of the finisher reactor',NULL,32,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:16:29'),(155,6,'Cross-section Area',NULL,9,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:18:13'),(156,6,'Height',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:19:02'),(157,6,'Radius',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:19:38'),(158,6,'Catalyst Loading',NULL,18,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:20:13'),(159,6,'Pigment Specification',NULL,18,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:20:54'),(160,6,'Molar Ratio',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:21:29'),(161,6,'Operating Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:22:10'),(162,6,'L/D Ratio',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:22:45'),(163,6,'Outflow Volume',NULL,2,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:23:10'),(164,6,'Mass Flow',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:27:15'),(165,6,'Volumetric Flow',NULL,4,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:27:47'),(166,6,'Molar Flow',NULL,3,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:28:20'),(167,6,'Mass Transfer Coefficient',NULL,39,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:47:41'),(168,6,'Mass Transfer Rate',NULL,3,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:48:21'),(169,6,'Contact Surface Area',NULL,9,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:49:06'),(170,6,'Chemical Amount',NULL,13,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:50:31'),(171,6,'Length of PFR',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:51:05'),(172,6,'Vapor Phase Mole Fraction',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:51:40'),(173,6,'Condensor Pressure',NULL,5,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:52:11'),(174,6,'Condensor Type',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:52:48'),(175,6,'Reflux Ratio',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:53:41'),(176,6,'Compound mass flow in product stream',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:54:32'),(177,6,'Compound fraction in product stream',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:55:06'),(178,6,'Reboiler Pressure',NULL,5,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:56:54'),(179,6,'Mixing Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:57:29'),(180,6,'Mixing Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:58:32'),(181,6,'DIP Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:59:03'),(182,6,'DIP Container Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 12:59:35'),(183,6,'Number of Stages',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:00:34'),(184,6,'Blower Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:02:23'),(185,6,'BLower Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:01:46'),(186,6,'Drying Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:02:52'),(187,6,'Drying Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:03:24'),(188,6,'Humidity',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:04:30'),(189,6,'Equipment Volume',NULL,2,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:05:03'),(190,6,'Processing Time',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:05:38'),(191,6,'Processing Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:06:24'),(192,6,'Volume Level',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:06:38'),(193,6,'Feed Stage(Dist)',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:07:12'),(194,6,'Temprature Difference',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:22:03'),(195,6,'Temperature Top',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:22:33'),(196,6,'Temperature Bottom',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:23:13'),(197,6,'Mass Fraction Light component',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:23:58'),(198,6,'Mass Fraction Heavy component',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:24:24'),(199,6,'Feed flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:25:15'),(200,6,'Inlet Temperature of feed',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:25:48'),(201,6,'Moisture content of feed',NULL,17,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:26:33'),(202,6,'Specific heat of feed',NULL,11,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:27:04'),(203,6,'Utility Temperature (Air)',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:27:49'),(204,6,'Slurry flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:28:29'),(205,6,'Slurry Composition',NULL,17,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:44:31'),(206,6,'Component Densities',NULL,8,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:45:08'),(207,6,'Crystallizer temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 13:45:58'),(208,6,'Feed composition',NULL,17,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:55:24'),(209,6,'Feed temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:55:55'),(210,6,'Crystallizer diameter',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:56:32'),(211,6,'Crystallizer frowth rate',NULL,39,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:57:12'),(212,6,'Crystallizer type',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:57:47'),(213,6,'feed entering tray',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:58:17'),(214,6,'Temperature @ bottom,Top',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:59:02'),(215,6,'Antoine constants for components',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 14:59:35'),(216,6,'Feed flowrate',NULL,10,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:00:06'),(217,6,'Feed composition',NULL,17,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:00:35'),(218,6,'specific heat of components',NULL,11,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:01:12'),(219,6,'diameter',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:01:46'),(220,6,'outlet diameter',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:02:14'),(221,6,'n_set',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:03:03'),(222,6,'n_reactor',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:03:30'),(223,6,'n_roll',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:04:03'),(224,6,'Electrode area',NULL,9,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:04:43'),(225,6,'Voltage',NULL,53,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:05:14'),(226,6,'Current',NULL,52,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:05:56'),(227,6,'Efficiency',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:06:29'),(228,6,'Water input',NULL,3,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:07:08'),(229,6,'\'H\' step duration',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:07:41'),(230,6,'\'H with no current\' step duration (before)',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:08:34'),(231,6,'\'H with no current\' step duration (after)',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:09:04'),(232,6,'\'W\' step duration',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:09:35'),(233,6,'\'O\' step duration',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:10:07'),(234,6,'Step transition duration',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:10:48'),(235,6,'Step shift',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:11:32'),(236,6,'Initial height',NULL,1,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:12:05'),(237,6,'Initial pressure',NULL,5,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:12:35'),(238,6,'Initial mass',NULL,7,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:13:18'),(239,6,'time interval',NULL,14,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:13:55'),(240,6,'time interval',NULL,36,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:14:42'),(241,6,'Power input',NULL,36,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:15:10'),(242,6,'Contact Time',NULL,62,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:15:44'),(243,6,'Mixing Behaviour',NULL,43,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:16:13'),(244,6,'Milling Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:16:40'),(245,6,'Dilution',NULL,61,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:17:08'),(246,6,'pH',NULL,61,'active',0,28,NULL,'2021-12-16 12:07:56','2021-12-16 15:17:38'),(247,6,NULL,NULL,0,'inactive',0,28,'2021-12-16 15:17:56','2021-12-16 12:07:56','2021-12-16 15:17:56'),(248,6,'height',NULL,1,'inactive',28,28,'2021-12-16 15:18:07','2021-12-16 12:18:40','2021-12-16 15:18:07'),(249,5,'Volume',NULL,2,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:26:02'),(250,5,'Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:26:52'),(251,5,'Pressure',NULL,5,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:27:28'),(252,5,'Residence time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:28:18'),(253,5,'Residence time',NULL,14,'inactive',0,28,'2021-12-20 18:29:43','2021-12-20 18:20:48','2021-12-20 18:29:43'),(254,5,'Mixing intensity',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:30:06'),(255,5,'EG:PTA molar ratio',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:30:36'),(256,5,'Throughput',NULL,10,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:31:02'),(257,5,'CatSpec',NULL,18,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:31:39'),(258,5,'Pigment Spec',' ',18,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:32:54'),(259,5,'Flow velocity',NULL,34,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:33:19'),(260,5,'Length of the finisher reactor',NULL,32,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:33:55'),(261,5,'Cross-section Area',NULL,9,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:34:22'),(262,5,'Height',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:34:50'),(263,5,'Radius',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:35:20'),(264,5,'Catalyst Loading',NULL,18,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:36:05'),(265,5,'Pigment Specification',NULL,18,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:36:38'),(266,5,'Molar Ratio',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:37:20'),(267,5,'Operating Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:37:49'),(268,5,'L/D Ratio',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:38:11'),(269,5,'Outflow Volume',NULL,2,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:38:53'),(270,5,'Mass Flow',NULL,10,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:40:03'),(271,5,'Volumetric Flow',NULL,4,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:40:37'),(272,5,'Molar Flow',NULL,3,'active',0,28,NULL,'2021-12-20 18:20:48','2021-12-20 18:41:09'),(273,5,'Mass Transfer Coefficient',NULL,39,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:41:37'),(274,5,'Mass Transfer Rate',NULL,10,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:42:23'),(275,5,'Contact Surface Area',NULL,9,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:42:52'),(276,5,'Chemical Amount',NULL,13,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:43:18'),(277,5,'Length of PFR',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:43:52'),(278,5,'Vapor Phase Mole Fraction',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:44:23'),(279,5,'Condensor Pressure',NULL,5,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-20 18:44:56'),(280,5,'Condensor Type',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:53:00'),(281,5,'Reflux Ratio',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:53:32'),(282,5,'Compound mass flow in product stream',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:54:04'),(283,5,'Compound fraction in product stream',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:54:50'),(284,5,'Reboiler Pressure',NULL,5,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:55:53'),(285,5,'Number of Stages',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:56:28'),(286,5,'Mixing Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:57:05'),(287,5,'Mixing Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:57:52'),(288,5,'DIP Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 10:58:28'),(289,5,'DIP Container Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:14:54'),(290,5,'Blower Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:15:50'),(291,5,'BLower Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:26:21'),(292,5,'Drying Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:35:52'),(293,5,'Drying Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:37:42'),(294,5,'Humidity',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:38:18'),(295,5,'Equipment Volume',NULL,2,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:38:55'),(296,5,'Processing Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:39:32'),(297,5,'Processing Temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:40:10'),(298,5,'Volume Level',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:40:55'),(299,5,'Feed Stage(Dist)',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:41:35'),(300,5,'Temprature Difference',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:42:13'),(301,5,'Temperature Top',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:42:44'),(302,5,'Temperature Bottom',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:43:16'),(303,5,'Mass Fraction Light component',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:43:58'),(304,5,'Mass Fraction Heavy component',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:47:34'),(305,5,'Feed flow rate',NULL,3,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:48:13'),(306,5,'Inlet Temperature of feed',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:51:25'),(307,5,'Moisture content of feed',NULL,17,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:52:04'),(308,5,'Specific heat of feed',NULL,11,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:53:21'),(309,5,'Utility Temperature (Air)',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:54:00'),(310,5,'Slurry flow rate',NULL,10,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:54:47'),(311,5,'Slurry Composition',NULL,17,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:55:18'),(312,5,'Component Densities',NULL,8,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 11:59:05'),(313,5,'Crystallizer temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:32:30'),(314,5,'Feed composition',NULL,17,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:33:38'),(315,5,'Feed temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:39:29'),(316,5,'Crystallizer diameter',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:40:24'),(317,5,'Crystallizer frowth rate',NULL,39,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:48:12'),(318,5,'Crystallizer type',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:49:53'),(319,5,'feed entering tray',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:50:44'),(320,5,'Temperature @ bottom,Top',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:51:34'),(321,5,'Antoine constants for components',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:52:13'),(322,5,'Feed flowrate',NULL,10,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:52:54'),(323,5,'Feed composition',NULL,17,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:53:30'),(324,5,'specific heat of components',NULL,11,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:54:05'),(325,5,'diameter',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:54:34'),(326,5,'outlet diameter',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:55:06'),(327,5,'n_set',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:55:42'),(328,5,'n_reactor',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:56:11'),(329,5,'n_roll',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 12:56:41'),(330,5,'Electrode area',NULL,9,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:03:47'),(331,5,'System voltage',NULL,53,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:05:32'),(332,5,'System current',NULL,52,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:06:17'),(333,5,'Efficiency',NULL,43,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:06:52'),(334,5,'Water input',NULL,3,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:07:24'),(335,5,'\'H\' step duration',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:07:56'),(336,5,'\'H with no current\' step duration (before)',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:08:46'),(337,5,'\'H with no current\' step duration (after)',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:09:24'),(338,5,'\'W\' step duration',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:10:04'),(339,5,'\'O\' step duration',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:11:06'),(340,5,'Push time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:16:17'),(341,5,'Step shift',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:17:35'),(342,5,'Initial height',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:18:14'),(343,5,'Initial pressure',NULL,5,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:18:56'),(344,5,'Initial mass',NULL,7,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:19:27'),(345,5,'time interval',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:23:18'),(346,5,'max power',NULL,36,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:23:54'),(347,5,'Power input',NULL,36,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:24:33'),(348,5,'Contact Time',NULL,14,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:25:05'),(349,5,'Environmental_temperature',NULL,12,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:25:39'),(350,5,'Layer 1 thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:27:39'),(351,5,'Layer 1 thermal conductivity',NULL,33,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:28:08'),(352,5,'Layer 1 heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:28:45'),(353,5,'Layer 2 thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:29:14'),(354,5,'Layer 2 thermal conductivity',NULL,33,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:29:48'),(355,5,'Layer 2 heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:30:23'),(356,5,'Layer 3 thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:30:52'),(357,5,'Layer 3 thermal conductivity',NULL,33,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:31:23'),(358,5,'Layer 3 heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:31:52'),(359,5,'Anode thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:32:21'),(360,5,'Anode density',NULL,8,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:33:02'),(361,5,'Anode heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:33:37'),(362,5,'Anode heat transfer coefficient',NULL,204,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:37:02'),(363,5,'Cathode thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:37:40'),(364,5,'Cathode density',NULL,8,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:38:14'),(365,5,'Cathode heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:38:53'),(366,5,'Cathode heat transfer coefficient',NULL,204,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:39:30'),(367,5,'Spacer thickness',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:40:04'),(368,5,'Spacer density',NULL,8,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:40:31'),(369,5,'Spacer heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:41:07'),(370,5,'Peek mandrell diameter',NULL,1,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:41:37'),(371,5,'Peek mandrell density',NULL,8,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:42:04'),(372,5,'Peek mandrell heat capacity',NULL,21,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:42:34'),(373,5,'Peek mandrell heat transfer coefficient',NULL,204,'active',0,28,NULL,'2021-12-20 18:20:49','2021-12-21 13:43:06'),(374,5,'Pump flowrate',NULL,4,'active',28,28,NULL,'2021-12-21 13:44:05','2021-12-21 13:44:05'),(375,5,'Reactor flowrate',NULL,4,'active',28,28,NULL,'2021-12-21 13:44:56','2021-12-21 13:44:56'),(376,8,'Volume',NULL,226,'active',28,28,NULL,'2021-12-23 12:12:51','2022-01-07 16:46:22'),(377,8,'temperature',NULL,227,'active',28,28,NULL,'2021-12-23 12:15:53','2021-12-23 12:15:53'),(378,8,'Pressure',NULL,228,'active',28,28,NULL,'2021-12-23 12:20:37','2021-12-23 12:20:37'),(379,8,'Residence time',NULL,14,'active',28,28,NULL,'2021-12-23 12:21:33','2021-12-23 12:21:33'),(380,8,'Mixing intensity',NULL,43,'active',28,28,NULL,'2021-12-23 12:21:58','2021-12-23 12:21:58'),(381,8,'EG:PTA molar ratio',NULL,61,'active',28,28,NULL,'2021-12-23 12:22:33','2021-12-23 12:22:33'),(382,8,'Throughput',NULL,232,'active',28,28,NULL,'2021-12-23 12:31:12','2022-01-07 16:48:03'),(383,8,'CatSpec',NULL,233,'active',28,28,NULL,'2021-12-23 12:33:59','2021-12-23 12:33:59'),(384,8,'Pigment Spec',NULL,233,'active',28,28,NULL,'2021-12-23 12:35:43','2021-12-23 12:35:43'),(385,8,'Flow velocity',NULL,34,'active',28,28,NULL,'2021-12-23 12:36:05','2022-01-07 16:48:12'),(386,8,'Length of the finisher reactor',NULL,32,'active',28,28,NULL,'2021-12-23 12:36:39','2021-12-23 12:36:39'),(387,8,'Cross-section Area',NULL,9,'active',28,28,NULL,'2021-12-23 12:37:05','2021-12-23 12:37:05'),(388,8,'Height',NULL,1,'active',28,28,NULL,'2021-12-23 12:37:26','2021-12-23 12:37:26'),(389,8,'Radius',NULL,1,'active',28,28,NULL,'2021-12-23 12:37:48','2021-12-23 12:37:48'),(390,8,'Catalyst Loading',NULL,18,'active',28,28,NULL,'2021-12-23 12:46:38','2021-12-23 12:46:38'),(391,8,'Pigment Specification',NULL,18,'active',28,28,NULL,'2021-12-23 12:47:01','2021-12-23 12:47:01'),(392,8,'EG:pigment molar ratio',NULL,61,'active',28,28,NULL,'2021-12-23 12:47:33','2021-12-23 12:47:33'),(393,8,'Operating Time',NULL,14,'active',28,28,NULL,'2021-12-23 12:47:57','2021-12-23 12:47:57'),(394,8,'L/D Ratio',NULL,43,'active',28,28,NULL,'2021-12-23 12:48:56','2021-12-23 12:48:56'),(395,8,'Outflow Volume',NULL,2,'active',28,28,NULL,'2021-12-23 12:49:59','2021-12-23 12:49:59'),(396,8,'EG Mass flow in catalyst flow',NULL,234,'active',28,28,NULL,'2021-12-23 12:52:37','2021-12-23 12:52:37'),(397,8,'Volumetric Flow',NULL,4,'active',28,28,NULL,'2021-12-23 12:54:13','2021-12-23 12:54:13'),(398,8,'Molar Flow',NULL,3,'active',28,28,NULL,'2021-12-23 12:54:35','2021-12-23 12:54:35'),(399,8,'Mass Transfer Coefficient',NULL,39,'active',28,28,NULL,'2021-12-23 12:54:55','2021-12-23 12:54:55'),(400,8,'Mass Transfer Rate',NULL,3,'active',28,28,NULL,'2021-12-23 12:55:19','2021-12-23 12:55:19'),(401,8,'Contact Surface Area',NULL,9,'active',28,28,NULL,'2021-12-23 12:55:41','2021-12-23 12:55:41'),(402,8,'Chemical Amount',NULL,13,'active',28,28,NULL,'2021-12-23 12:56:03','2021-12-23 12:56:03'),(403,8,'Length of PFR',NULL,1,'active',28,28,NULL,'2021-12-23 12:56:30','2021-12-23 12:56:30'),(404,8,'Vapor Phase Mole Fraction',NULL,43,'active',28,28,NULL,'2021-12-23 12:57:11','2021-12-23 12:57:11'),(405,8,'Condensor Pressure',NULL,5,'active',28,28,NULL,'2021-12-23 12:57:34','2021-12-23 12:57:34'),(406,8,'Condensor Type',NULL,43,'active',28,28,NULL,'2021-12-23 13:09:17','2021-12-23 13:09:17'),(407,8,'Reflux Ratio',NULL,61,'active',28,28,NULL,'2021-12-23 13:09:59','2021-12-23 13:09:59'),(408,8,'Compound mass flow in product stream',NULL,10,'active',28,28,NULL,'2021-12-23 13:10:26','2021-12-23 13:10:26'),(409,8,'Compound fraction in product stream',NULL,43,'active',28,28,NULL,'2021-12-23 13:10:48','2021-12-23 13:10:48'),(410,8,'Compound fraction in product stream',NULL,43,'inactive',28,28,'2021-12-23 13:13:24','2021-12-23 13:12:33','2021-12-23 13:13:24'),(411,8,'Reboiler Pressure',NULL,5,'active',28,28,NULL,'2021-12-23 13:13:05','2021-12-23 13:13:05'),(412,8,'Number of Stages',NULL,61,'active',28,28,NULL,'2021-12-23 13:13:51','2021-12-23 13:13:51'),(413,8,'Mixing Time',NULL,14,'active',28,28,NULL,'2021-12-23 13:14:15','2021-12-23 13:14:15'),(414,8,'Mixing Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:14:39','2021-12-23 13:14:39'),(415,8,'DIP Time',NULL,14,'active',28,28,NULL,'2021-12-23 13:15:17','2021-12-23 13:15:17'),(416,8,'DIP Container Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:15:47','2021-12-23 13:15:47'),(417,8,'Blower Time',NULL,14,'active',28,28,NULL,'2021-12-23 13:17:06','2021-12-23 13:17:06'),(418,8,'BLower Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:17:25','2021-12-23 13:17:25'),(419,8,'Drying Time',NULL,14,'active',28,28,NULL,'2021-12-23 13:17:52','2021-12-23 13:17:52'),(420,8,'Drying Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:18:13','2021-12-23 13:18:13'),(421,8,'Humidity',NULL,43,'active',28,28,NULL,'2021-12-23 13:18:39','2021-12-23 13:18:39'),(422,8,'Equipment Volume',NULL,2,'active',28,28,NULL,'2021-12-23 13:19:04','2021-12-23 13:19:04'),(423,8,'Processing Time',NULL,14,'active',28,28,NULL,'2021-12-23 13:19:39','2021-12-23 13:19:39'),(424,8,'Processing Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:20:02','2021-12-23 13:20:02'),(425,8,'Volume Level',NULL,61,'active',28,28,NULL,'2021-12-23 13:20:30','2021-12-23 13:20:30'),(426,8,'Feed Stage(Dist)',NULL,43,'active',28,28,NULL,'2021-12-23 13:20:54','2021-12-23 13:20:54'),(427,8,'Temperature Difference',NULL,227,'active',28,28,NULL,'2021-12-23 13:21:38','2021-12-23 16:28:25'),(428,8,'Temperature Top',NULL,12,'active',28,28,NULL,'2021-12-23 13:22:26','2021-12-23 13:22:26'),(429,8,'Temperature Bottom',NULL,12,'active',28,28,NULL,'2021-12-23 13:22:54','2021-12-23 13:22:54'),(430,8,'Mass Fraction Light component',NULL,43,'active',28,28,NULL,'2021-12-23 13:23:18','2021-12-23 13:23:18'),(431,8,'Mass Fraction Heavy component',NULL,43,'active',28,28,NULL,'2021-12-23 13:24:06','2021-12-23 13:24:06'),(432,8,'Feed flow rate',NULL,10,'active',28,28,NULL,'2021-12-23 13:24:40','2021-12-23 13:24:40'),(433,8,'Inlet Temperature of feed',NULL,12,'active',28,28,NULL,'2021-12-23 13:25:02','2021-12-23 13:25:02'),(434,8,'Moisture content of feed',NULL,17,'active',28,28,NULL,'2021-12-23 13:25:25','2021-12-23 13:25:25'),(435,8,'Specific heat of feed',NULL,11,'active',28,28,NULL,'2021-12-23 13:26:04','2021-12-23 13:26:04'),(436,8,'Utility Temperature (Air)',NULL,12,'active',28,28,NULL,'2021-12-23 13:26:39','2021-12-23 13:26:39'),(437,8,'Slurry flow rate',NULL,7,'active',28,28,NULL,'2021-12-23 13:44:47','2021-12-23 13:44:47'),(438,8,'Slurry Composition',NULL,17,'active',28,28,NULL,'2021-12-23 13:45:18','2021-12-23 13:45:18'),(439,8,'Component Densities',NULL,8,'active',28,28,NULL,'2021-12-23 13:45:36','2021-12-23 13:45:36'),(440,8,'Crystallizer temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:49:50','2021-12-23 13:49:50'),(441,8,'Feed composition',NULL,17,'active',28,28,NULL,'2021-12-23 13:51:11','2021-12-23 13:51:11'),(442,8,'Feed temperature',NULL,12,'active',28,28,NULL,'2021-12-23 13:52:08','2021-12-23 13:52:08'),(443,8,'Crystallizer diameter',NULL,1,'active',28,28,NULL,'2021-12-23 13:52:31','2021-12-23 13:52:31'),(444,8,'Crystallizer frowth rate',NULL,39,'active',28,28,NULL,'2021-12-23 13:53:03','2021-12-23 13:53:03'),(445,8,'Crystallizer type',NULL,43,'active',28,28,NULL,'2021-12-23 13:53:26','2021-12-23 13:53:26'),(446,8,'feed entering tray',NULL,43,'active',28,28,NULL,'2021-12-23 13:53:57','2021-12-23 13:53:57'),(447,8,'Temperature @ bottom,Top',NULL,12,'active',28,28,NULL,'2021-12-23 13:55:23','2021-12-23 13:55:23'),(448,8,'Antoine constants for components',NULL,43,'active',28,28,NULL,'2021-12-23 13:55:49','2021-12-23 13:55:49'),(449,8,'Feed flowrate',NULL,10,'active',28,28,NULL,'2021-12-23 13:56:09','2021-12-23 13:56:09'),(450,8,'Feed composition',NULL,17,'active',28,28,NULL,'2021-12-23 13:56:39','2021-12-23 13:56:39'),(451,8,'specific heat of components',NULL,11,'active',28,28,NULL,'2021-12-23 13:57:04','2021-12-23 13:57:04'),(452,8,'diameter',NULL,230,'active',28,28,NULL,'2021-12-23 13:57:42','2021-12-23 13:57:42'),(453,8,'outlet diameter',NULL,1,'active',28,28,NULL,'2021-12-23 13:58:12','2021-12-23 13:58:12'),(454,8,'n_set',NULL,43,'active',28,28,NULL,'2021-12-23 13:58:34','2021-12-23 13:58:34'),(455,8,'n_reactor',NULL,43,'active',28,28,NULL,'2021-12-23 13:58:56','2021-12-23 13:58:56'),(456,8,'n_roll',NULL,43,'active',28,28,NULL,'2021-12-23 13:59:28','2021-12-23 13:59:28'),(457,8,'Electrode area',NULL,9,'active',28,28,NULL,'2021-12-23 14:04:37','2021-12-23 14:04:37'),(458,8,'Voltage',NULL,53,'active',28,28,NULL,'2021-12-23 14:05:01','2021-12-23 14:05:01'),(459,8,'Current',NULL,52,'active',28,28,NULL,'2021-12-23 14:14:14','2021-12-23 14:14:14'),(460,8,'Efficiency',NULL,43,'active',28,28,NULL,'2021-12-23 14:14:40','2021-12-23 14:14:40'),(461,8,'Water input',NULL,3,'active',28,28,NULL,'2021-12-23 14:15:31','2021-12-23 14:15:31'),(462,8,'\'H\' step duration',NULL,14,'active',28,28,NULL,'2021-12-23 14:16:09','2021-12-23 14:16:09'),(463,8,'\'H with no current\' step duration (before)',NULL,14,'active',28,28,NULL,'2021-12-23 14:16:33','2021-12-23 14:16:33'),(464,8,'\'H with no current\' step duration (after)',NULL,14,'active',28,28,NULL,'2021-12-23 14:19:18','2021-12-23 14:19:18'),(465,8,'\'W\' step duration',NULL,14,'active',28,28,NULL,'2021-12-23 14:20:40','2021-12-23 14:20:40'),(466,8,'\'O\' step duration',NULL,14,'active',28,28,NULL,'2021-12-23 14:21:07','2021-12-23 14:21:07'),(467,8,'Step transition duration',NULL,14,'active',28,28,NULL,'2021-12-23 14:23:33','2021-12-23 14:23:33'),(468,8,'Step shift',NULL,14,'active',28,28,NULL,'2021-12-23 14:24:20','2021-12-23 14:24:20'),(469,8,'Initial height',NULL,1,'active',28,28,NULL,'2021-12-23 14:24:51','2021-12-23 14:24:51'),(470,8,'Initial pressure',NULL,5,'active',28,28,NULL,'2021-12-23 14:25:14','2021-12-23 14:25:14'),(471,8,'Initial mass',NULL,7,'active',28,28,NULL,'2021-12-23 14:25:38','2021-12-23 14:25:38'),(472,8,'time interval',NULL,14,'active',28,28,NULL,'2021-12-23 14:26:02','2021-12-23 14:26:02'),(473,8,'max power',NULL,36,'active',28,28,NULL,'2021-12-23 14:26:39','2021-12-23 14:26:39'),(474,8,'Power input',NULL,36,'active',28,28,NULL,'2021-12-23 14:27:42','2021-12-23 14:27:42'),(475,8,'Contact Time',NULL,62,'active',28,28,NULL,'2021-12-23 14:28:37','2021-12-23 14:28:37'),(476,8,'Mixing Behaviour',NULL,43,'active',28,28,NULL,'2021-12-23 14:29:00','2021-12-23 14:29:00'),(477,8,'Milling Temperature',NULL,12,'active',28,28,NULL,'2021-12-23 14:53:44','2021-12-23 14:53:44'),(478,8,'Dilution',NULL,61,'active',28,28,NULL,'2021-12-23 14:54:09','2021-12-23 14:54:09'),(479,8,'mole fraction light component',NULL,61,'active',28,28,NULL,'2021-12-23 14:54:34','2021-12-23 14:54:34'),(480,8,'temperature diameter',NULL,227,'active',28,28,NULL,'2021-12-23 16:20:33','2022-01-07 16:48:29'),(481,1,'test',NULL,1,'active',27,27,NULL,'2021-12-29 11:10:30','2021-12-29 11:10:30'),(482,7,'reaction time',NULL,235,'active',27,27,NULL,'2022-01-11 11:28:23','2022-01-11 12:14:17'),(483,1,'saa',NULL,2,'active',1,1,NULL,'2022-01-12 15:22:17','2022-01-12 15:22:17'),(484,1,'sasa','sa',1,'active',1,1,NULL,'2022-01-12 15:22:24','2022-01-12 15:22:24'),(485,1,'sa',NULL,3,'active',1,1,NULL,'2022-01-12 15:22:30','2022-01-12 15:22:30'),(486,1,'sasa','sa',1,'active',1,1,NULL,'2022-01-12 15:22:36','2022-01-12 15:22:36'),(487,1,'sasa','as',3,'active',1,1,NULL,'2022-01-12 15:22:44','2022-01-12 15:22:44'),(488,1,'saassa',NULL,2,'active',1,1,NULL,'2022-01-12 15:22:50','2022-01-12 15:22:50'),(489,1,'assa','sasa',3,'active',1,1,NULL,'2022-01-12 15:22:57','2022-01-12 15:22:57'),(490,1,'assa',NULL,2,'active',1,1,NULL,'2022-01-12 15:23:02','2022-01-12 15:23:02'),(491,1,'sasa',NULL,3,'active',1,1,NULL,'2022-01-12 15:23:08','2022-01-12 15:23:08'),(492,1,'sasasa','sasa',1,'active',1,1,NULL,'2022-01-12 15:23:17','2022-01-12 15:23:17'),(493,5,'Layer 1 density',NULL,8,'active',28,28,NULL,'2022-01-18 11:02:33','2022-01-18 11:02:33'),(494,5,'Layer 1 heat transfer coefficient',NULL,204,'active',28,28,NULL,'2022-01-18 11:03:14','2022-01-18 11:03:14'),(495,5,'Layer 2 density',NULL,8,'active',28,28,NULL,'2022-01-18 11:50:37','2022-01-18 11:50:37'),(496,5,'Layer 2 heat transfer coefficient',NULL,204,'active',28,28,NULL,'2022-01-18 11:51:20','2022-01-18 11:51:20'),(497,5,'Layer 3 density',NULL,8,'active',28,28,NULL,'2022-01-18 11:51:20','2022-01-18 11:58:11'),(498,5,'Layer 3 heat transfer coefficient',NULL,204,'active',28,28,NULL,'2022-01-18 12:03:46','2022-01-18 12:03:46'),(499,5,'Mandrell length',NULL,1,'active',28,28,NULL,'2022-01-18 12:04:48','2022-01-18 12:04:48'),(500,5,'Bipolar diameter',NULL,1,'active',28,28,NULL,'2022-01-18 12:05:10','2022-01-18 12:05:10'),(501,5,'Bipolar length',NULL,1,'active',28,28,NULL,'2022-01-18 12:05:34','2022-01-18 12:05:34'),(502,5,'Bipolar length',NULL,8,'inactive',28,28,'2022-01-18 12:14:12','2022-01-18 12:06:44','2022-01-18 12:14:12'),(503,5,'Bipolar density',NULL,8,'active',28,28,NULL,'2022-01-18 12:14:33','2022-01-18 12:14:33'),(504,5,'Bipolar heat capacity',NULL,21,'active',28,28,NULL,'2022-01-18 12:15:29','2022-01-18 12:15:29'),(505,5,'Bipolar heat transfer coefficient',NULL,204,'active',28,28,NULL,'2022-01-18 12:20:44','2022-01-18 12:20:44'),(506,5,'Bipolar porousity',NULL,61,'active',28,28,NULL,'2022-01-18 12:21:49','2022-01-18 12:21:49'),(507,5,'Mixing efficiency',NULL,61,'active',28,28,NULL,'2022-01-18 12:22:23','2022-01-18 12:22:23'),(508,5,'Electrode discharge coefficient',NULL,61,'active',28,28,NULL,'2022-01-18 12:23:30','2022-01-18 12:23:30'),(509,5,'Top relief valve pressure',NULL,5,'active',28,28,NULL,'2022-01-18 12:28:33','2022-01-18 12:28:33'),(510,5,'Floor relieve valve pressure',NULL,5,'active',28,28,NULL,'2022-01-18 12:28:59','2022-01-18 12:28:59');
/*!40000 ALTER TABLE `experiment_condition_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_outcome_masters`
--

DROP TABLE IF EXISTS `experiment_outcome_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_outcome_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `unittype` int NOT NULL DEFAULT '1',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=651 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_outcome_masters`
--

LOCK TABLES `experiment_outcome_masters` WRITE;
/*!40000 ALTER TABLE `experiment_outcome_masters` DISABLE KEYS */;
INSERT INTO `experiment_outcome_masters` VALUES (1,0,'End group (-COOH)','End group (-COOH)1',18,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:34:37'),(2,0,'Sb2O3 concentration','Sb2O3 concentration',18,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:34:49'),(3,0,'Intrinsic Viscosity','Intrinsic Viscosity',18,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:35:06'),(4,0,'DEG %','DEG %',17,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:49:37'),(5,0,'L* value','L* value',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:49:59'),(6,0,'b* value','b* value',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:50:16'),(7,0,'AA','AA',17,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:50:48'),(8,0,'Vinyl','Vinyl',17,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:51:02'),(9,0,'Concentration','Concentration',17,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:51:26'),(10,0,'Chemical Fraction','Chemical Fraction',18,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:51:38'),(11,0,'Equivalent','Equivalent',17,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 15:51:51'),(12,0,'Cumulative Energy Demand','Cumulative Energy Demand',23,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:00:41'),(13,0,'Greenhouse Gas Emissions','Greenhouse Gas Emissions',24,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:01:10'),(14,0,'EHS','EHS',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:01:27'),(15,0,'Water use','Water use',27,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:01:44'),(16,0,'Land use - per kg product','Land use - per kg product',28,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:01:58'),(17,0,'Product Yield','Product Yield',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:02:44'),(18,0,'Pigment/binder ratio and pigment volume concentration (PVC)','Pigment/binder ratio and pigment volume concentration (PVC)',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:03:06'),(19,0,'Particle size and packing of pigments or fillers','Particle size and packing of pigments or fillers',1,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:03:36'),(20,0,'Density','Density',8,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:03:51'),(21,0,'Ph','Ph',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:04:24'),(22,0,'Coating porosity ASTM E1920','Coating porosity ASTM E1920',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:04:38'),(23,0,'Transmittance','Transmittance',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:05:04'),(24,0,'Reflectance','Reflectance',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:05:24'),(25,0,'Coefficient of Friction','Coefficient of Friction',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:06:38'),(26,0,'Corrosion Resistance ASTM G85',NULL,43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:20:21'),(27,0,'Abrasion Resistance ASTM D4060 - 14','Abrasion Resistance ASTM D4060 - 14',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:20:37'),(28,0,'Water Contact Angle','Water Contact Angle',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:21:09'),(29,0,'PV-COST','PV-COST',29,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:20:08'),(30,0,'Spreadability','Spreadability',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:19:12'),(31,0,'Foaming power','Foaming power',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:21:48'),(32,0,'Loss in weight on drying at 105C',NULL,43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:22:01'),(33,0,'Fineness 150 IS sieve',NULL,43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:22:22'),(34,0,'Fineness 75 IS sieve','Fineness 75 IS sieve',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:22:42'),(35,0,'Cost','Cost',29,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:23:17'),(36,0,'Product 10 - int yield','Product 10 - int yield',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:23:41'),(37,0,'Electricity use','Electricity use',23,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:24:04'),(38,0,'Blooming observed','Blooming observed',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:24:45'),(39,0,'ASTM D635 burn propogation','ASTM D635 burn propogation',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:25:04'),(40,0,'ASTM D635 self extinguishing  time','ASTM D635 self extinguishing  time',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:25:17'),(41,0,'ASTM D638 tensile strength at yeild','ASTM D638 tensile strength at yeild',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:25:49'),(42,0,'ASTM D638 tensile strength at break','ASTM D638 tensile strength at break',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:26:03'),(43,0,'ISO 4892 QUV accelerated weathering - Yellowness index','ISO 4892 QUV accelerated weathering - Yellowness index',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:26:56'),(44,0,'ASTM D543 Chemical reagents resistance weight change','ASTM D543 Chemical reagents resistance weight change',43,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-08 09:26:31'),(45,0,'Price','Price',29,'active',1,2,NULL,'2020-10-06 15:37:44','2020-10-07 16:06:57'),(47,0,'SAP Number','SAP Number',18,'active',2,2,NULL,'2020-10-07 16:07:39','2020-10-08 09:28:45'),(48,0,'Acid Number','Acid Number',18,'active',2,2,NULL,'2020-10-08 09:29:23','2020-10-08 09:29:23'),(49,0,'Conversion','Conversion',17,'active',2,2,NULL,'2020-10-08 09:29:54','2020-10-08 09:29:54'),(50,0,'Free EG','Free EG',17,'active',2,2,NULL,'2020-10-08 09:30:23','2020-10-08 09:30:23'),(51,0,'Moisture Removed','Moisture Removed',7,'active',2,2,NULL,'2020-12-28 16:12:44','2020-12-28 16:12:44'),(52,0,'Heat','Heat required',43,'active',2,2,NULL,'2020-12-28 16:15:06','2020-12-28 16:15:06'),(53,0,'Required Utillity flow rate','Required Utillity flow rate',10,'active',2,2,NULL,'2020-12-28 16:15:49','2020-12-28 16:15:49'),(54,0,'Outlet Temperature feed','Outlet Temperature feed',12,'active',2,2,NULL,'2020-12-28 16:24:34','2020-12-28 16:24:34'),(55,0,'Solid Product','Solid Product',10,'active',2,2,NULL,'2020-12-28 16:25:04','2020-12-28 16:25:04'),(56,0,'Spent Liquid flowrate','Spent Liquid flowrate',10,'active',2,2,NULL,'2020-12-28 16:25:21','2020-12-28 16:25:21'),(57,0,'Rotations/minute','Rotations/minute',43,'active',2,2,NULL,'2020-12-28 16:26:07','2020-12-28 16:26:07'),(58,0,'Crystal formed','Crystal formed',10,'active',2,2,NULL,'2020-12-28 16:26:30','2020-12-28 16:26:30'),(59,0,'Saturated stream','Saturated stream',10,'active',2,2,NULL,'2020-12-28 16:26:44','2020-12-28 16:26:44'),(60,0,'Saturated stream composition','Saturated stream composition',17,'active',2,2,NULL,'2020-12-28 16:26:59','2020-12-28 16:26:59'),(61,0,'Heat absorbed/ released by crystallizer','Heat absorbed/ released by crystallizer',43,'active',2,2,NULL,'2020-12-28 16:27:34','2020-12-28 16:27:34'),(62,0,'Distillate Flow rate','Distillate Flow rate',10,'active',2,2,NULL,'2020-12-28 16:29:22','2020-12-28 16:29:22'),(63,0,'Bottom Flow rate','Bottom Flow rate',10,'active',2,2,NULL,'2020-12-28 16:29:41','2020-12-28 16:29:41'),(64,0,'Distillate composition','Distillate composition',17,'active',2,2,NULL,'2020-12-28 16:30:03','2020-12-28 16:30:03'),(65,0,'Bottom composition','Bottom composition',17,'active',2,2,NULL,'2020-12-28 16:30:25','2020-12-28 16:30:25'),(66,0,'Condensor Duty','Condensor Duty',43,'active',2,2,NULL,'2020-12-28 16:30:51','2020-12-28 16:30:51'),(67,0,'Cooling water flowrate','Cooling water flowrate',10,'active',2,2,NULL,'2020-12-28 16:31:08','2020-12-28 16:31:08'),(68,0,'Re-boiler Duty','Re-boiler Duty',43,'active',2,2,NULL,'2020-12-28 16:31:25','2020-12-28 16:31:25'),(69,0,'Steam flowrate','Steam flowrate',10,'active',2,2,NULL,'2020-12-28 16:31:43','2020-12-28 16:31:43'),(70,0,'Power',NULL,36,'active',7,7,NULL,'2021-06-01 12:23:57','2021-06-01 12:23:57'),(71,0,'H2 production',NULL,10,'active',7,7,NULL,'2021-06-01 12:24:18','2021-06-01 12:24:18'),(72,0,'gas residual',NULL,17,'active',7,7,NULL,'2021-06-01 12:27:34','2021-06-01 12:27:34'),(73,0,'Temperature',NULL,12,'active',7,7,NULL,'2021-06-01 12:28:00','2021-06-01 12:28:00'),(74,0,'Pressure',NULL,5,'active',7,7,NULL,'2021-06-01 12:28:11','2021-06-01 12:28:11'),(75,0,'Flow rate',NULL,10,'active',7,7,NULL,'2021-06-01 12:28:30','2021-06-01 12:28:30'),(76,0,'Current',NULL,52,'active',7,7,NULL,'2021-06-01 12:28:50','2021-06-01 12:28:50'),(77,0,'Voltage',NULL,53,'active',7,7,NULL,'2021-06-01 12:29:04','2021-06-01 12:29:04'),(78,0,'Log reduction microbes',NULL,55,'active',7,7,NULL,'2021-06-30 15:17:46','2021-06-30 15:17:46'),(79,0,'Filler dispersion',NULL,17,'active',12,12,NULL,'2021-07-02 16:46:32','2021-07-02 16:46:32'),(80,0,'MH(Torque maximum)',NULL,56,'active',12,12,NULL,'2021-07-02 16:47:58','2021-07-02 16:47:58'),(81,0,'ML (Torque Lowest)',NULL,56,'active',12,12,NULL,'2021-07-02 16:48:13','2021-07-02 16:48:13'),(82,0,'M100%',NULL,5,'active',12,12,NULL,'2021-07-02 16:49:17','2021-07-02 16:49:17'),(83,0,'M200%',NULL,5,'active',12,12,NULL,'2021-07-02 16:49:34','2021-07-02 16:49:34'),(84,0,'M25%',NULL,5,'active',12,12,NULL,'2021-07-02 16:49:47','2021-07-02 16:49:47'),(85,0,'M300%',NULL,5,'active',12,12,NULL,'2021-07-02 16:50:06','2021-07-02 16:50:06'),(86,0,'Tensile strength',NULL,5,'active',12,12,NULL,'2021-07-02 16:50:27','2021-07-02 16:50:27'),(87,0,'M300/M100',NULL,43,'active',12,12,NULL,'2021-07-02 16:51:28','2021-07-02 20:04:19'),(88,0,'t15',NULL,14,'active',12,12,NULL,'2021-07-02 16:52:00','2021-07-02 16:52:00'),(89,0,'t25',NULL,14,'active',12,12,NULL,'2021-07-02 16:52:13','2021-07-02 16:52:13'),(90,0,'t50',NULL,14,'active',12,12,NULL,'2021-07-02 16:52:51','2021-07-02 16:52:51'),(91,0,'t90',NULL,14,'active',12,12,NULL,'2021-07-02 16:53:23','2021-07-02 16:53:23'),(92,0,'t95',NULL,14,'active',12,12,NULL,'2021-07-02 16:53:36','2021-07-02 16:53:36'),(93,0,'ts1',NULL,14,'active',12,12,NULL,'2021-07-02 16:53:50','2021-07-02 16:53:50'),(94,0,'ts2',NULL,14,'active',12,12,NULL,'2021-07-02 16:54:02','2021-07-02 16:54:02'),(95,0,'t5',NULL,14,'active',12,12,NULL,'2021-07-02 16:54:28','2021-07-02 16:54:28'),(96,0,'G\' 0.07',NULL,5,'active',12,12,NULL,'2021-07-02 16:55:06','2021-07-02 16:55:06'),(97,0,'G\' 0.56',NULL,14,'active',12,12,NULL,'2021-07-02 16:55:27','2021-07-02 16:55:27'),(98,0,'G\' 100.02',NULL,14,'active',12,12,NULL,'2021-07-02 16:55:39','2021-07-02 16:55:39'),(99,0,'Snow Indicator',NULL,5,'active',12,12,NULL,'2021-07-02 16:57:05','2021-07-02 16:57:05'),(100,0,'G*',NULL,5,'active',12,12,NULL,'2021-07-02 16:57:33','2021-07-02 16:57:33'),(101,0,'Mooney ML(1+1.5) 135°C',NULL,60,'active',12,12,NULL,'2021-07-02 17:02:32','2021-07-02 17:02:32'),(102,0,'Mv (135°C)',NULL,60,'active',12,12,NULL,'2021-07-02 17:03:30','2021-07-02 17:03:30'),(103,0,'G\'\'',NULL,5,'active',12,12,NULL,'2021-07-02 17:05:21','2021-07-02 17:05:21'),(104,0,'Ice Indicator -5°C',NULL,43,'active',12,12,NULL,'2021-07-02 17:05:54','2021-07-02 17:06:34'),(105,0,'T tan_max',NULL,12,'active',12,12,NULL,'2021-07-02 17:06:58','2021-07-02 17:06:58'),(106,0,'tan_max',NULL,43,'active',12,12,NULL,'2021-07-02 17:07:33','2021-07-02 17:07:33'),(107,0,'tan',NULL,43,'active',12,12,NULL,'2021-07-02 17:07:53','2021-07-02 17:07:53'),(108,0,'Rebound',NULL,59,'active',12,12,NULL,'2021-07-02 17:09:17','2021-07-02 17:09:17'),(109,0,'HH (mean)',NULL,57,'active',12,12,NULL,'2021-07-02 17:09:41','2021-07-02 17:09:41'),(110,0,'epsilon_break (median)',NULL,43,'active',12,12,NULL,'2021-07-02 20:05:35','2021-07-02 20:05:35'),(111,0,'sigma_break (median)',NULL,5,'active',12,12,NULL,'2021-07-02 20:05:52','2021-07-02 20:06:12'),(112,0,'S.aureus',NULL,55,'active',12,12,NULL,'2021-07-02 22:03:53','2021-07-02 22:03:53'),(113,0,'E.coli',NULL,55,'active',12,12,NULL,'2021-07-02 22:04:11','2021-07-02 22:04:11'),(114,0,'P.aeruginosa',NULL,55,'active',12,12,NULL,'2021-07-02 22:04:35','2021-07-02 22:04:35'),(115,0,'E.hirae',NULL,55,'active',12,12,NULL,'2021-07-02 22:05:37','2021-07-02 22:05:37'),(116,0,'a* value',NULL,43,'active',7,7,NULL,'2021-07-22 19:07:05','2021-07-22 19:07:05'),(143,1,'test',NULL,2,'active',2,2,NULL,'2021-12-02 17:42:14','2021-12-02 17:42:57'),(144,3,'Test Outcome','test description',0,'inactive',0,27,'2021-12-02 18:06:38','2021-12-02 18:06:02','2021-12-02 18:06:38'),(145,3,'Test Outcome 1',NULL,0,'inactive',0,27,'2021-12-02 18:06:35','2021-12-02 18:06:02','2021-12-02 18:06:35'),(146,3,'Test Outcome','test description',0,'active',0,0,NULL,'2021-12-02 18:06:48','2021-12-02 18:06:48'),(147,3,'Test Outcome 1',NULL,0,'active',0,0,NULL,'2021-12-02 18:06:48','2021-12-02 18:06:48'),(148,3,'Test Outcome3',NULL,0,'active',0,0,NULL,'2021-12-02 18:06:48','2021-12-02 18:06:48'),(149,3,'Test Outcome','test description',0,'inactive',0,27,'2021-12-02 18:09:50','2021-12-02 18:08:54','2021-12-02 18:09:50'),(150,3,'Test Outcome 1',NULL,0,'inactive',0,27,'2021-12-02 18:09:47','2021-12-02 18:08:54','2021-12-02 18:09:47'),(151,3,'Test outcome',NULL,0,'inactive',0,27,'2021-12-02 18:09:43','2021-12-02 18:08:54','2021-12-02 18:09:43'),(152,3,'Test Outcome','test description',0,'active',0,0,NULL,'2021-12-02 18:11:10','2021-12-02 18:11:10'),(153,3,'Test Outcome 1',NULL,0,'active',0,0,NULL,'2021-12-02 18:11:10','2021-12-02 18:11:10'),(154,3,'Test Outcome',NULL,0,'active',0,0,NULL,'2021-12-02 18:11:10','2021-12-02 18:11:10'),(155,3,'Test Outcome',NULL,0,'inactive',0,27,'2021-12-02 18:15:31','2021-12-02 18:11:10','2021-12-02 18:15:31'),(156,3,'Test',NULL,3,'inactive',27,27,'2021-12-13 10:53:04','2021-12-02 18:15:11','2021-12-13 10:53:04'),(203,7,'V0 thickness (mm)',NULL,205,'inactive',0,27,'2021-12-22 17:27:02','2021-12-03 11:33:14','2021-12-22 17:27:02'),(204,7,'catalyst weight dosed',NULL,214,'inactive',0,27,'2021-12-23 10:40:30','2021-12-03 11:33:14','2021-12-23 10:40:30'),(205,7,'diluent volume hexane',NULL,215,'inactive',0,27,'2021-12-23 10:40:33','2021-12-03 11:33:14','2021-12-23 10:40:33'),(206,7,'catalyst concentration',NULL,216,'inactive',0,27,'2021-12-23 10:40:37','2021-12-03 11:33:14','2021-12-23 10:40:37'),(207,7,'catalyst volume dosed',NULL,218,'inactive',0,27,'2021-12-23 10:40:40','2021-12-03 11:33:14','2021-12-23 10:40:40'),(208,7,'cocatalyst reactor concentration',NULL,217,'inactive',0,27,'2021-12-23 10:40:44','2021-12-03 11:33:14','2021-12-23 10:40:44'),(209,7,'cocatalyst dosed volume',NULL,219,'inactive',0,27,'2021-12-23 10:40:48','2021-12-03 11:33:14','2021-12-23 10:40:48'),(210,7,'ethylene concentration measured',NULL,220,'inactive',0,27,'2021-12-23 10:41:18','2021-12-03 11:33:14','2021-12-23 10:41:18'),(211,7,'hydrogen average concentration',NULL,221,'inactive',0,27,'2021-12-23 10:41:25','2021-12-03 11:33:14','2021-12-23 10:41:25'),(212,7,'ethane concentration',NULL,222,'inactive',0,27,'2021-12-23 10:41:32','2021-12-03 11:33:14','2021-12-23 10:41:32'),(213,7,'butene average concentration',NULL,223,'inactive',0,27,'2021-12-23 10:41:37','2021-12-03 11:33:14','2021-12-23 10:41:37'),(214,7,'reaction temperature average',NULL,224,'inactive',0,27,'2021-12-23 10:41:41','2021-12-03 11:33:14','2021-12-23 10:41:41'),(215,7,'reaction pressure',NULL,225,'inactive',0,27,'2021-12-23 10:41:44','2021-12-03 11:33:14','2021-12-23 10:41:44'),(216,8,'End group (-COOH)',NULL,236,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:37:28'),(217,8,'Sb2O3 concentration',NULL,18,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:37:47'),(218,8,'Intrinsic Viscosity',NULL,237,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:38:10'),(219,8,'DEG %',NULL,229,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:38:35'),(220,8,'L* value',NULL,61,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:38:59'),(221,8,'b* value',NULL,61,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:39:59'),(222,8,'AA',NULL,0,'active',0,0,NULL,'2021-12-03 13:21:02','2021-12-03 13:21:02'),(223,8,'Vinyl',NULL,229,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:40:24'),(224,8,'Concentration',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 10:40:45'),(225,8,'Chemical Fraction',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:05:03'),(226,8,'Equivalent',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:06:00'),(227,8,'Cumulative Energy Demand',NULL,23,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:06:27'),(228,8,'Greenhouse Gas Emissions',NULL,24,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:06:54'),(229,8,'EHS',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:07:28'),(230,8,'Water use',NULL,27,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:07:57'),(231,8,'Land use - per kg product',NULL,28,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:10:53'),(232,8,'Product Yield',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:11:22'),(233,8,'Pigment/binder ratio and pigment volume concentration (PVC)',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:12:14'),(234,8,'Particle size and packing of pigments or fillers',NULL,1,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:13:04'),(235,8,'Density',NULL,8,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:13:35'),(236,8,'Ph',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:14:24'),(237,8,'Coating porosity ASTM E1920',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:14:55'),(238,8,'Transmittance',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:15:40'),(239,8,'Reflectance',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:16:19'),(240,8,'Coefficient of Friction',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:16:52'),(241,8,'Corrosion Resistance ASTM G85',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:17:24'),(242,8,'Abrasion Resistance ASTM D4060 - 14',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:17:57'),(243,8,'Water Contact Angle',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:18:24'),(244,8,'PV-COST',NULL,29,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:18:53'),(245,8,'Spreadability',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:21:00'),(246,8,'Foaming power',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:21:29'),(247,8,'Loss in weight on drying at 105C',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:21:59'),(248,8,'Fineness 150 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:22:35'),(249,8,'Fineness 75 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:23:02'),(250,8,'Cost',NULL,29,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:23:31'),(251,8,'Product 10 - int yield',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:23:58'),(252,8,'Electricity use',NULL,23,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:27:48'),(253,8,'Blooming observed',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:28:27'),(254,8,'ASTM D635 burn propogation',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:41:01'),(255,8,'ASTM D635 self extinguishing time',NULL,0,'active',0,0,NULL,'2021-12-03 13:21:02','2021-12-03 13:21:02'),(256,8,'ASTM D638 tensile strength at yeild',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:53:49'),(257,8,'ASTM D638 tensile strength at break',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 11:55:04'),(258,8,'ISO 4892 QUV accelerated weathering - Yellowness index',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:03:24'),(259,8,'ASTM D543 Chemical reagents resistance weight change',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:03:57'),(260,8,'Price',NULL,29,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:04:59'),(261,8,'SAP Number',NULL,236,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:05:24'),(262,8,'Acid Number',NULL,236,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:05:45'),(263,8,'Conversion',NULL,61,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:06:27'),(264,8,'Free EG',NULL,61,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:06:52'),(265,8,'Moisture Removed',NULL,7,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:07:19'),(266,8,'Heat',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:08:23'),(267,8,'Required Utillity flow rate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:09:00'),(268,8,'Outlet Temperature feed',NULL,12,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:09:32'),(269,8,'Solid Product',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:10:03'),(270,8,'Spent Liquid flowrate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:13:02'),(271,8,'Rotations/minute',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:16:33'),(272,8,'Crystal formed',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:14:11'),(273,8,'Saturated stream',NULL,0,'active',0,0,NULL,'2021-12-03 13:21:02','2021-12-03 13:21:02'),(274,8,'Saturated stream composition',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:17:04'),(275,8,'Heat absorbed/ released by crystallizer',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:17:37'),(276,8,'Distillate Flow rate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:26:51'),(277,8,'Bottom Flow rate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:20:13'),(278,8,'Distillate composition',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:20:43'),(279,8,'Bottom composition',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:21:52'),(280,8,'Condensor Duty',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:22:36'),(281,8,'Cooling water flowrate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:23:08'),(282,8,'Re-boiler Duty',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:23:39'),(283,8,'Steam flowrate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:24:08'),(284,8,'Power',NULL,36,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:24:53'),(285,8,'H2 production',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:25:38'),(286,8,'gas residual',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:27:11'),(287,8,'Temperature',NULL,12,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:27:41'),(288,8,'Pressure',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:28:12'),(289,8,'Flow rate',NULL,10,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:36:31'),(290,8,'Current',NULL,52,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:37:21'),(291,8,'Voltage',NULL,53,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:37:55'),(292,8,'Log reduction microbes',NULL,55,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:38:20'),(293,8,'Filler dispersion',NULL,17,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:39:02'),(294,8,'MH(Torque maximum)',NULL,56,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:39:30'),(295,8,'ML (Torque Lowest)',NULL,56,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:39:54'),(296,8,'M100%',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:40:30'),(297,8,'M200%',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:41:05'),(298,8,'M25%',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:42:19'),(299,8,'M300%',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:42:43'),(300,8,'Tensile strength',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:43:10'),(301,8,'M300/M100',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:43:37'),(302,8,'t15',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:44:05'),(303,8,'t25',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:44:42'),(304,8,'t50',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:45:25'),(305,8,'t90',NULL,0,'active',0,0,NULL,'2021-12-03 13:21:02','2021-12-03 13:21:02'),(306,8,'t95',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:46:11'),(307,8,'ts1',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:46:26'),(308,8,'ts2',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:46:39'),(309,8,'t5',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:46:55'),(310,8,'G\' 0.07',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:47:12'),(311,8,'G\' 0.56',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:47:43'),(312,8,'G\' 100.02',NULL,14,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:47:59'),(313,8,'Snow Indicator',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:48:21'),(314,8,'G*',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:48:47'),(315,8,'Mooney ML(1+1.5) 135°C',NULL,60,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:49:17'),(316,8,'Mv (135°C)',NULL,60,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:50:09'),(317,8,'G\'\'',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:50:31'),(318,8,'Ice Indicator -5°C',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:51:02'),(319,8,'T tan_max',NULL,12,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:51:44'),(320,8,'tan_max',NULL,12,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:52:16'),(321,8,'tan',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:52:47'),(322,8,'Rebound',NULL,59,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:53:16'),(323,8,'HH (mean)',NULL,57,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:53:51'),(324,8,'epsilon_break (median)',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:54:17'),(325,8,'sigma_break (median)',NULL,5,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:55:02'),(326,8,'S.aureus',NULL,55,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:55:26'),(327,8,'E.coli',NULL,55,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:55:48'),(328,8,'P.aeruginosa',NULL,55,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:56:14'),(329,8,'E.hirae',NULL,55,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:56:49'),(330,8,'a* value',NULL,43,'active',0,28,NULL,'2021-12-03 13:21:02','2022-01-13 12:56:39'),(331,3,'test',NULL,3,'inactive',27,27,'2021-12-08 10:42:02','2021-12-08 10:41:33','2021-12-08 10:42:02'),(332,3,'test','',0,'inactive',27,27,'2021-12-13 10:53:23','2021-12-13 10:49:39','2021-12-13 10:53:23'),(333,3,'HH (mean)','',0,'inactive',27,27,'2021-12-13 10:53:17','2021-12-13 10:49:39','2021-12-13 10:53:17'),(334,3,'test','',0,'inactive',27,27,'2021-12-13 10:53:09','2021-12-13 10:52:31','2021-12-13 10:53:09'),(335,3,'Test','',0,'inactive',27,27,'2021-12-13 10:53:14','2021-12-13 10:52:31','2021-12-13 10:53:14'),(336,3,'test','',0,'inactive',27,27,'2021-12-13 10:54:30','2021-12-13 10:53:57','2021-12-13 10:54:30'),(337,3,'HH mean','',0,'inactive',27,27,'2021-12-13 10:54:33','2021-12-13 10:53:57','2021-12-13 10:54:33'),(338,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:54:41','2021-12-13 10:54:41'),(339,3,'HH mean','',0,'active',27,27,NULL,'2021-12-13 10:54:41','2021-12-13 10:54:41'),(340,3,'test1','',0,'active',27,27,NULL,'2021-12-13 10:55:42','2021-12-13 10:55:42'),(341,3,'test2','',0,'active',27,27,NULL,'2021-12-13 10:55:42','2021-12-13 10:55:42'),(342,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:56:41','2021-12-13 10:56:41'),(343,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:56:41','2021-12-13 10:56:41'),(344,3,'tests','',0,'active',27,27,NULL,'2021-12-13 10:57:16','2021-12-13 10:57:16'),(345,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:57:17','2021-12-13 10:57:17'),(346,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:57:57','2021-12-13 10:57:57'),(347,3,'hh','',0,'active',27,27,NULL,'2021-12-13 10:57:57','2021-12-13 10:57:57'),(348,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:58:47','2021-12-13 10:58:47'),(349,3,'hh mean','',0,'active',27,27,NULL,'2021-12-13 10:58:47','2021-12-13 10:58:47'),(350,3,'test','',0,'active',27,27,NULL,'2021-12-13 10:59:38','2021-12-13 10:59:38'),(351,3,'hh mean','',0,'active',27,27,NULL,'2021-12-13 10:59:38','2021-12-13 10:59:38'),(352,3,'test','',0,'active',27,27,NULL,'2021-12-13 11:00:21','2021-12-13 11:00:21'),(353,3,'HH mean','',0,'active',27,27,NULL,'2021-12-13 11:00:21','2021-12-13 11:00:21'),(354,3,'test','',2,'active',27,27,NULL,'2021-12-14 09:57:50','2021-12-14 09:57:50'),(355,3,'HH (mean)','',0,'active',27,27,NULL,'2021-12-14 09:57:50','2021-12-14 09:57:50'),(356,6,'End group (-COOH)',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2022-01-03 12:42:51'),(357,6,'Sb2O3 concentration',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 15:30:32'),(358,6,'Intrinsic Viscosity',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:16:25'),(359,6,'DEG %',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:17:00'),(360,6,'L* value',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:17:44'),(361,6,'b* value',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:18:15'),(362,6,'AA',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:18:43'),(363,6,'Vinyl',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:19:14'),(364,6,'Concentration',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:32:33'),(365,6,'Chemical Fraction',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:20:11'),(366,6,'Equivalent',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:21:43'),(367,6,'Cumulative Energy Demand',NULL,23,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:22:22'),(368,6,'Greenhouse Gas Emissions',NULL,24,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:23:26'),(369,6,'EHS',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:24:00'),(370,6,'Water use',NULL,27,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:24:31'),(371,6,'Land use - per kg product',NULL,28,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:25:07'),(372,6,'Product Yield',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:25:37'),(373,6,'Pigment/binder ratio and pigment volume concentration (PVC)',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:26:12'),(374,6,'Particle size and packing of pigments or fillers',NULL,1,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:26:52'),(375,6,'Density','Density',8,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:27:24'),(376,6,'Ph',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:28:05'),(377,6,'Coating porosity ASTM E1920','Coating porosity ASTM E1920',43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:28:46'),(378,6,'Transmittance',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:29:13'),(379,6,'Reflectance',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:29:54'),(380,6,'Coefficient of Friction',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:30:24'),(381,6,'Corrosion Resistance ASTM G85',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:30:58'),(382,6,'Abrasion Resistance ASTM D4060 - 14',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:31:28'),(383,6,'Water Contact Angle',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:32:03'),(384,6,'Spreadability',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:33:01'),(385,6,'PV-COST',NULL,29,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:33:49'),(386,6,'Foaming power',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:34:30'),(387,6,'Loss in weight on drying at 105C',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:35:19'),(388,6,'Fineness 150 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:35:51'),(389,6,'Fineness 75 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:36:45'),(390,6,'Cost',NULL,29,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:37:15'),(391,6,'Product 10 - int yield',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:38:22'),(392,6,'Electricity use',NULL,23,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:39:10'),(393,6,'Blooming observed',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:39:42'),(394,6,'ASTM D635 burn propogation',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:40:17'),(395,6,'ASTM D635 self extinguishing  time',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:40:48'),(396,6,'ASTM D638 tensile strength at yeild',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:41:31'),(397,6,'ASTM D638 tensile strength at break',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:42:00'),(398,6,'ISO 4892 QUV accelerated weathering - Yellowness index',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:42:57'),(399,6,'ASTM D543 Chemical reagents resistance weight change',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:43:40'),(400,6,'Price',NULL,29,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:44:09'),(401,6,'SAP Number',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:45:02'),(402,6,'Acid Number',NULL,18,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:45:29'),(403,6,'Conversion',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:46:07'),(404,6,'Free EG',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:46:39'),(405,6,'Moisture Removed',NULL,7,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:47:13'),(406,6,'Heat',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:49:14'),(407,6,'Required Utillity flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:50:36'),(408,6,'Outlet Temperature feed',NULL,12,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:51:07'),(409,6,'Solid Product',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:51:47'),(410,6,'Spent Liquid flowrate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:53:21'),(411,6,'Rotations/minute',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:54:21'),(412,6,'Crystal formed',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:54:58'),(413,6,'Saturated stream',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:55:41'),(414,6,'Saturated stream composition',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:56:08'),(415,6,'Heat absorbed/ released by crystallizer',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:56:44'),(416,6,'Distillate Flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:57:23'),(417,6,'Bottom Flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:58:00'),(418,6,'Distillate composition',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:58:30'),(419,6,'Bottom composition',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:59:18'),(420,6,'Condensor Duty',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 16:59:56'),(421,6,'Cooling water flowrate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:00:30'),(422,6,'Re-boiler Duty',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:00:58'),(423,6,'Steam flowrate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:01:36'),(424,6,'Power',NULL,36,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:02:05'),(425,6,'H2 production',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:02:50'),(426,6,'gas residual',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:04:42'),(427,6,'Temperature',NULL,12,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:05:22'),(428,6,'Pressure',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:06:00'),(429,6,'Flow rate',NULL,10,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:06:31'),(430,6,'Current',NULL,52,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:07:01'),(431,6,'Voltage',NULL,53,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:07:32'),(432,6,'Log reduction microbes',NULL,55,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:08:11'),(433,6,'Filler dispersion',NULL,17,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:08:43'),(434,6,'MH(Torque maximum)',NULL,56,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:09:18'),(435,6,'ML (Torque Lowest)',NULL,56,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:09:58'),(436,6,'M100%',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:35:46'),(437,6,'M200%',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:36:16'),(438,6,'M25%',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:37:05'),(439,6,'M300%',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:37:33'),(440,6,'Tensile strength',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:38:08'),(441,6,'M300/M100',NULL,43,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:38:51'),(442,6,'t15',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:39:39'),(443,6,'t25',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:40:11'),(444,6,'t50',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:40:43'),(445,6,'t90',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:41:16'),(446,6,'t95',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:41:56'),(447,6,'ts1',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:42:31'),(448,6,'ts2',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:43:09'),(449,6,'t5',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:43:41'),(450,6,'G\' 0.07',NULL,5,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:44:10'),(451,6,'G\' 0.56',NULL,14,'active',0,28,NULL,'2021-12-16 15:28:08','2021-12-16 17:44:38'),(452,6,'G\' 100.02',NULL,14,'active',28,28,NULL,'2021-12-16 17:45:20','2021-12-16 17:45:20'),(453,6,'Snow Indicator',NULL,5,'active',28,28,NULL,'2021-12-16 17:45:50','2021-12-16 17:45:50'),(454,6,'G*',NULL,5,'active',28,28,NULL,'2021-12-16 17:46:23','2021-12-16 17:46:23'),(455,6,'Mooney ML(1+1.5) 135Â°C',NULL,60,'active',28,28,NULL,'2021-12-16 17:46:55','2021-12-16 17:46:55'),(456,6,'Mv (135Â°C)',NULL,60,'active',28,28,NULL,'2021-12-16 17:47:39','2021-12-16 17:47:39'),(457,6,'G\'\'',NULL,5,'active',28,28,NULL,'2021-12-16 17:48:06','2021-12-16 17:48:06'),(458,6,'Ice Indicator -5Â°C',NULL,43,'active',28,28,NULL,'2021-12-16 17:48:36','2021-12-16 17:48:36'),(459,6,'T tan_max',NULL,12,'active',28,28,NULL,'2021-12-16 17:49:01','2021-12-16 17:49:01'),(460,6,'tan_max',NULL,43,'active',28,28,NULL,'2021-12-16 17:49:29','2021-12-16 17:49:29'),(461,6,'tan',NULL,43,'active',28,28,NULL,'2021-12-16 17:50:11','2021-12-16 17:50:11'),(462,6,'Rebound',NULL,59,'active',28,28,NULL,'2021-12-16 17:50:39','2021-12-16 17:50:39'),(463,6,'HH (mean)',NULL,57,'active',28,28,NULL,'2021-12-16 17:51:15','2021-12-16 17:51:15'),(464,6,'epsilon_break (median)',NULL,43,'active',28,28,NULL,'2021-12-16 17:51:53','2021-12-16 17:51:53'),(465,6,'sigma_break (median)',NULL,5,'active',28,28,NULL,'2021-12-16 17:52:55','2021-12-16 17:52:55'),(466,6,'S.aureus',NULL,55,'active',28,28,NULL,'2021-12-16 17:54:33','2021-12-16 17:54:33'),(467,6,'E.coli',NULL,55,'active',28,28,NULL,'2021-12-16 17:55:08','2021-12-16 17:55:08'),(468,6,'P.aeruginosa',NULL,55,'active',28,28,NULL,'2021-12-16 17:55:33','2021-12-16 17:55:33'),(469,6,'E.hirae',NULL,55,'active',28,28,NULL,'2021-12-16 17:56:07','2021-12-16 17:56:07'),(470,6,'a* value',NULL,43,'active',28,28,NULL,'2021-12-16 17:56:39','2021-12-16 17:56:39'),(471,6,'VTOT',NULL,12,'active',28,28,NULL,'2021-12-16 17:57:11','2021-12-16 17:57:11'),(472,6,'Tensile modulus',NULL,5,'active',28,28,NULL,'2021-12-16 17:57:40','2021-12-16 17:57:40'),(473,6,'IZOD_impact',NULL,5,'active',28,28,NULL,'2021-12-16 17:58:09','2021-12-16 17:58:09'),(474,6,'V0 thickness',NULL,5,'active',28,28,NULL,'2021-12-16 17:58:40','2021-12-16 17:58:40'),(475,6,'Melt_volume_rate',NULL,4,'active',28,28,NULL,'2021-12-16 17:59:12','2021-12-16 17:59:12'),(476,6,'HDT',NULL,12,'active',28,28,NULL,'2021-12-16 17:59:46','2021-12-16 17:59:46'),(477,5,'Water use',NULL,27,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 13:59:39'),(478,5,'Water Contact Angle',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:00:05'),(479,5,'Vinyl',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:03:39'),(480,5,NULL,NULL,0,'inactive',0,28,'2021-12-21 14:03:44','2021-12-21 13:58:36','2021-12-21 14:03:44'),(481,5,'ts2',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:03:08'),(482,5,'ts1',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:04:08'),(483,5,'Transmittance',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:04:33'),(484,5,'Tensile strength',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:40:08'),(485,5,'Temperature',NULL,12,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:40:43'),(486,5,'tan_max',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:47:47'),(487,5,NULL,NULL,0,'inactive',0,28,'2021-12-21 14:48:04','2021-12-21 13:58:36','2021-12-21 14:48:04'),(488,5,'tan',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:48:44'),(489,5,'t95',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:49:20'),(490,5,'t90',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:49:48'),(491,5,'t50',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:50:21'),(492,5,'t5',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:50:46'),(493,5,'t25',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:51:17'),(494,5,'t15',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:51:49'),(495,5,'T tan_max',NULL,12,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:52:23'),(496,5,'System voltage',NULL,53,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:53:01'),(497,5,'System current',NULL,52,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:53:32'),(498,5,'Steam flowrate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 14:54:03'),(499,5,'Spreadability',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:07:27'),(500,5,'Spent Liquid flowrate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:07:55'),(501,5,'Solid Product',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:08:24'),(502,5,'Snow Indicator',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:08:50'),(503,5,'sigma_break (median)',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:11:49'),(504,5,'Sb2O3 concentration',NULL,18,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:12:17'),(505,5,'Saturated stream composition',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:12:49'),(506,5,'Saturated stream',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:43:21'),(507,5,'SAP Number',NULL,18,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:44:00'),(508,5,'S.aureus',NULL,55,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:44:32'),(509,5,'Rotations/minute',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:45:23'),(510,5,'Required Utillity flow rate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:45:51'),(511,5,'Reflectance',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:47:16'),(512,5,'Rebound',NULL,59,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:47:49'),(513,5,'Re-boiler Duty',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:48:27'),(514,5,'PV-COST',NULL,29,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:48:59'),(515,5,'Product Yield',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:49:34'),(516,5,'Product 10 - int yield',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 15:50:07'),(517,5,'Price',NULL,29,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:01:09'),(518,5,'Pressure',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:02:52'),(519,5,'Power',NULL,36,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:03:31'),(520,5,'Pigment/binder ratio and pigment volume concentration (PVC)',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:04:18'),(521,5,'Ph',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:04:46'),(522,5,'Particle size and packing of pigments or fillers',NULL,1,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:05:20'),(523,5,'P.aeruginosa',NULL,55,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:05:57'),(524,5,'Outlet Temperature feed',NULL,12,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:07:19'),(525,5,'Mv (135Â°C)',NULL,60,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:08:07'),(526,5,'Mooney ML(1+1.5) 135Â°C',NULL,60,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:08:56'),(527,5,'Moisture Removed',NULL,7,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:09:29'),(528,5,'ML (Torque Lowest)',NULL,56,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:09:59'),(529,5,'MH(Torque maximum)',NULL,56,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:10:39'),(530,5,'M300/M100',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:11:08'),(531,5,'M300/M100',NULL,43,'inactive',0,28,'2021-12-21 16:13:26','2021-12-21 13:58:36','2021-12-21 16:13:26'),(532,5,'M300%',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:13:12'),(533,5,'M25%',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:13:59'),(534,5,'M200%',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:14:34'),(535,5,'M100%',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:15:07'),(536,5,'Loss in weight on drying at 105C',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:15:46'),(537,5,'Log reduction microbes',NULL,55,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:16:18'),(538,5,'Land use - per kg product',NULL,28,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:16:55'),(539,5,'L* value',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:17:30'),(540,5,'ISO 4892 QUV accelerated weathering - Yellowness index',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:20:57'),(541,5,'Intrinsic Viscosity',NULL,18,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:21:32'),(542,5,'Ice Indicator -5Â°C',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:22:26'),(543,5,'HH (mean)',NULL,57,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:23:27'),(544,5,'Heat absorbed/ released by crystallizer',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:24:29'),(545,5,'Heat',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:25:05'),(546,5,'H2 production',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:25:40'),(547,5,'Greenhouse Gas Emissions',NULL,24,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:26:17'),(548,5,'gas residual',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:26:49'),(549,5,'G*',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:27:19'),(550,5,'G\'\'',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:39:20'),(551,5,'G\' 100.02',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:40:36'),(552,5,'G\' 0.56',NULL,14,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:41:13'),(553,5,'G\' 0.07',NULL,5,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:41:42'),(554,5,'Free EG',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:43:27'),(555,5,'Foaming power',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:43:56'),(556,5,'Flow rate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:46:37'),(557,5,'Fineness 75 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:47:14'),(558,5,'Fineness 150 IS sieve',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:47:46'),(559,5,'Filler dispersion',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:48:23'),(560,5,'Equivalent',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:49:08'),(561,5,'epsilon_break (median)',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:50:35'),(562,5,'End group (-COOH)',NULL,18,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:51:23'),(563,5,'Electricity use',NULL,23,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:52:40'),(564,5,'EHS',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:53:19'),(565,5,'E.hirae',NULL,55,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:54:17'),(566,5,'E.coli',NULL,55,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:55:11'),(567,5,'Distillate Flow rate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:55:44'),(568,5,'Distillate composition',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:56:13'),(569,5,'Density',NULL,8,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:56:43'),(570,5,'DEG %',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:57:44'),(571,5,'Cumulative Energy Demand',NULL,23,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:58:29'),(572,5,'Crystal formed',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:59:02'),(573,5,'Cost',NULL,29,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 16:59:36'),(574,5,'Corrosion Resistance ASTM G85',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:00:12'),(575,5,'Cooling water flowrate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:00:41'),(576,5,'Conversion',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:01:18'),(577,5,'Condensor Duty',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:01:53'),(578,5,'Concentration',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:02:22'),(579,5,'Coefficient of Friction',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:02:58'),(580,5,'Coating porosity ASTM E1920',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:03:48'),(581,5,'Chemical Fraction',NULL,18,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:04:20'),(582,5,'Bottom Flow rate',NULL,10,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:13:15'),(583,5,'Bottom composition',NULL,17,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:14:21'),(584,5,'Blooming observed',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:15:00'),(585,5,'b* value',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:15:35'),(586,5,'ASTM D638 tensile strength at yeild',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:18:09'),(587,5,'ASTM D638 tensile strength at break',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:18:39'),(588,5,'ASTM D635 self extinguishing  time',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:19:14'),(589,5,'ASTM D635 burn propogation',NULL,43,'active',0,28,NULL,'2021-12-21 13:58:36','2021-12-21 17:19:41'),(590,5,NULL,NULL,0,'inactive',0,28,'2021-12-21 17:20:47','2021-12-21 13:58:36','2021-12-21 17:20:47'),(591,5,'ASTM D543 Chemical reagents resistance weight change',NULL,43,'active',28,28,NULL,'2021-12-21 17:20:20','2021-12-21 17:20:20'),(592,5,'Acid Number',NULL,18,'active',28,28,NULL,'2021-12-21 17:21:12','2021-12-21 17:21:12'),(593,5,'Abrasion Resistance ASTM D4060 - 14',NULL,43,'active',28,28,NULL,'2021-12-21 17:21:40','2021-12-21 17:21:40'),(594,5,'AA',NULL,17,'active',28,28,NULL,'2021-12-21 17:22:11','2021-12-21 17:22:11'),(595,5,'a* value',NULL,43,'active',28,28,NULL,'2021-12-21 17:23:02','2021-12-21 17:23:02'),(596,7,'Tensile Modulus, 1 mm/min ISO 527 MPa',NULL,206,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:25:29'),(597,7,'V0 thickness (mm)',NULL,205,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:26:49'),(598,7,'Melt Volume Rate, MVR at 300°C/1.2 kg ISO 1133 cm³/10 min',NULL,207,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:26:56'),(599,7,'V0, TFOT (5 bars)',NULL,209,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:27:24'),(600,7,'Izod Impact, unnotched 80*10*3 +23°C, ISO 180/1U kJ/m²',NULL,208,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:27:29'),(601,7,'Combined HDT',NULL,210,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:27:42'),(602,7,'Polymer weight',NULL,211,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:28:14'),(603,7,'Polymer Density--densitydhpe020',NULL,212,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:28:28'),(604,7,'Catalyst yield',NULL,213,'active',0,27,NULL,'2021-12-23 10:47:36','2021-12-23 11:28:57'),(605,7,'MI21_6',NULL,0,'active',0,0,NULL,'2021-12-23 10:47:36','2021-12-23 10:47:36'),(606,9,'HH (mean)',NULL,61,'active',28,28,NULL,'2021-12-24 15:43:06','2021-12-24 15:43:06'),(607,9,'Ice Indicator (-5C)',NULL,61,'active',28,28,NULL,'2021-12-24 15:45:17','2021-12-24 15:45:17'),(608,9,'Dk',NULL,61,'active',28,28,NULL,'2021-12-24 15:45:49','2021-12-24 15:45:49'),(609,3,'123',NULL,1,'active',27,27,NULL,'2021-12-29 10:47:57','2021-12-29 10:47:57'),(610,9,'M300_M100 (median)',NULL,61,'active',28,28,NULL,'2021-12-29 17:25:33','2021-12-29 17:25:33'),(611,9,'MH',NULL,61,'active',28,28,NULL,'2021-12-29 17:28:12','2021-12-29 17:28:12'),(612,9,'sigma_break (median)',NULL,61,'active',28,28,NULL,'2021-12-29 17:29:22','2021-12-29 17:29:22'),(613,9,'tan (30C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:29:59','2021-12-29 17:29:59'),(614,9,'tan (40C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:30:46','2021-12-29 17:30:46'),(615,9,'tan (50C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:31:16','2021-12-29 17:31:16'),(616,9,'tan (60C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:31:56','2021-12-29 17:31:56'),(617,9,'Gprime 100.02',NULL,61,'active',28,28,NULL,'2021-12-29 17:35:13','2021-12-29 17:35:13'),(618,9,'M25 (median)',NULL,61,'active',28,28,NULL,'2021-12-29 17:35:44','2021-12-29 17:35:44'),(619,9,'Gstar (70C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:37:23','2021-12-29 17:37:23'),(620,9,'tan (70C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:38:47','2021-12-29 17:38:47'),(621,9,'Gprime (70C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:39:36','2021-12-29 17:39:36'),(622,9,'Gstar (30C)',NULL,61,'active',28,28,NULL,'2021-12-29 17:53:40','2021-12-29 17:53:40'),(623,9,'tan (70C)',NULL,61,'inactive',28,28,'2021-12-29 18:17:16','2021-12-29 18:11:02','2021-12-29 18:17:16'),(624,9,'Gprime (70C)',NULL,61,'inactive',28,28,'2021-12-29 18:17:30','2021-12-29 18:15:35','2021-12-29 18:17:30'),(625,9,'M300_div_M100 (median)',NULL,61,'active',28,28,NULL,'2021-12-29 18:18:08','2021-12-29 18:18:08'),(626,9,'Snow Indicator (0C)',NULL,61,'active',28,28,NULL,'2021-12-29 18:35:19','2021-12-29 18:35:19'),(627,9,'epsilon_break (median)',NULL,61,'active',28,28,NULL,'2021-12-29 18:35:46','2021-12-29 18:35:46'),(628,9,'ML(1+1.5)',NULL,61,'active',28,28,NULL,'2021-12-29 18:36:11','2021-12-29 18:36:11'),(629,9,'tan (10C)',NULL,61,'active',28,28,NULL,'2021-12-29 18:36:46','2021-12-29 18:36:46'),(630,9,'tan (0C)',NULL,61,'active',28,28,NULL,'2021-12-29 18:53:18','2021-12-29 18:53:18'),(631,9,'M100 (median)',NULL,61,'active',28,28,NULL,'2021-12-29 18:53:50','2021-12-29 18:53:50'),(632,9,'ML',NULL,61,'active',28,28,NULL,'2021-12-29 18:55:56','2021-12-29 18:55:56'),(633,9,'t15',NULL,61,'active',28,28,NULL,'2021-12-29 18:56:32','2021-12-29 18:56:32'),(634,9,'tan (-10C)',NULL,61,'active',28,28,NULL,'2021-12-30 10:59:15','2021-12-30 10:59:15'),(635,9,'Rebound',NULL,61,'active',28,28,NULL,'2021-12-30 10:59:43','2021-12-30 10:59:43'),(636,9,'ts2',NULL,61,'active',28,28,NULL,'2021-12-30 11:00:11','2021-12-30 11:00:11'),(637,9,'Snow Indicator (-10C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:00:33','2021-12-30 11:00:33'),(638,9,'Snow Indicator (-15C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:00:55','2021-12-30 11:00:55'),(639,9,'Snow Indicator (-15C)',NULL,61,'inactive',28,28,'2021-12-30 11:06:30','2021-12-30 11:00:55','2021-12-30 11:06:30'),(640,9,'Snow Indicator (-20C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:01:25','2021-12-30 11:01:25'),(641,9,'M200 (median)',NULL,61,'active',28,28,NULL,'2021-12-30 11:01:46','2021-12-30 11:01:46'),(642,9,'tan_max',NULL,61,'active',28,28,NULL,'2021-12-30 11:02:34','2021-12-30 11:02:34'),(643,9,'tan (-20C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:02:54','2021-12-30 11:02:54'),(644,9,'T tan_max',NULL,61,'active',28,28,NULL,'2021-12-30 11:03:09','2021-12-30 11:03:09'),(645,9,'t5',NULL,61,'active',28,28,NULL,'2021-12-30 11:03:27','2021-12-30 11:03:27'),(646,9,'Gdouble_prime (70C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:03:47','2021-12-30 11:03:47'),(647,9,'Gdouble_prime (20C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:04:08','2021-12-30 11:04:08'),(648,9,'tan (-30C)',NULL,61,'active',28,28,NULL,'2021-12-30 11:04:26','2021-12-30 11:04:26'),(649,5,'Total H2 production',NULL,7,'active',28,28,NULL,'2022-01-18 12:30:10','2022-01-18 12:30:10'),(650,5,'Total O2 production',NULL,7,'active',28,28,NULL,'2022-01-18 12:30:31','2022-01-18 12:30:31');
/*!40000 ALTER TABLE `experiment_outcome_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_reports`
--

DROP TABLE IF EXISTS `experiment_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `experiment_id` int NOT NULL,
  `variation_id` int NOT NULL,
  `simulation_input_id` int NOT NULL,
  `report_type` int NOT NULL DEFAULT '0',
  `output_data` json DEFAULT NULL,
  `messages` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('success','pending','failure') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_reports`
--

LOCK TABLES `experiment_reports` WRITE;
/*!40000 ALTER TABLE `experiment_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiment_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_unit_images`
--

DROP TABLE IF EXISTS `experiment_unit_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_unit_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_unit_images`
--

LOCK TABLES `experiment_unit_images` WRITE;
/*!40000 ALTER TABLE `experiment_unit_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiment_unit_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `experiment_units`
--

DROP TABLE IF EXISTS `experiment_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `experiment_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `experiment_unit_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `equipment_unit_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `experiment_units`
--

LOCK TABLES `experiment_units` WRITE;
/*!40000 ALTER TABLE `experiment_units` DISABLE KEYS */;
/*!40000 ALTER TABLE `experiment_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `flow_type_master`
--

DROP TABLE IF EXISTS `flow_type_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `flow_type_master` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `flow_type_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `flow_type_master`
--

LOCK TABLES `flow_type_master` WRITE;
/*!40000 ALTER TABLE `flow_type_master` DISABLE KEYS */;
INSERT INTO `flow_type_master` VALUES (1,0,'Main Feed','1','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(2,0,'Auxiliary Feed','1','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(3,0,'Main Product','2','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(4,0,'Co-product','2','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(5,0,'Waste','2','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(6,0,'Recycle','2','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(7,0,'Intermediate feed','3','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(8,0,'Intermediate stream','3','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(9,0,'Intermediate product','3','','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(10,0,'Heat stream','4','energy flow mass','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19'),(11,0,'Work stream','4','energy flow mass','active',1,1,NULL,'2021-12-01 18:23:19','2021-12-01 18:23:19');
/*!40000 ALTER TABLE `flow_type_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazard_categories`
--

DROP TABLE IF EXISTS `hazard_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazard_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazard_categories`
--

LOCK TABLES `hazard_categories` WRITE;
/*!40000 ALTER TABLE `hazard_categories` DISABLE KEYS */;
INSERT INTO `hazard_categories` VALUES (1,'Category 1',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(2,'Category 2',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(3,'Category 3',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(4,'Category 4',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(5,'Type A',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(6,'Type B',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(7,'Type C',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(8,'Type D',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(9,'Type E',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(10,'Type F',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(11,'Type G',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(12,'Div 1.1',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(13,'Div 1.2',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(14,'Div 1.3',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(15,'Div 1.4',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(16,'Div 1.5',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(17,'Div 1.6',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(18,'1A',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(19,'1B',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(20,'1C',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(21,'Additional category',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(22,'2A',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(23,'2B',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(24,'Compressed gas',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(25,'Liquefied gas',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(26,'Dissolved gas',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(27,'Refrigerated liquefied gas',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(28,'Unstable Explosive',NULL,1,1,'active',NULL,'2021-02-16 10:17:58','2021-02-16 10:17:58'),(29,'Chemically unstable gas A','Chemically unstable gas A',2,2,'active',NULL,'2021-02-16 13:36:10','2021-02-16 13:36:10'),(30,'Pyrophoric gas','Pyrophoric gas',2,2,'active',NULL,'2021-02-16 14:24:37','2021-02-16 14:24:37'),(31,'Category 5','Category 5',2,2,'active',NULL,'2021-02-16 16:06:14','2021-02-16 16:06:14'),(32,'Category 2A',NULL,2,2,'active',NULL,'2021-02-16 21:52:55','2021-02-16 21:52:55'),(33,'Category 2B',NULL,2,2,'active',NULL,'2021-02-16 21:55:24','2021-02-16 21:55:24');
/*!40000 ALTER TABLE `hazard_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazard_classes`
--

DROP TABLE IF EXISTS `hazard_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazard_classes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hazard_class_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazard_classes`
--

LOCK TABLES `hazard_classes` WRITE;
/*!40000 ALTER TABLE `hazard_classes` DISABLE KEYS */;
INSERT INTO `hazard_classes` VALUES (1,'Explosives',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(2,'Desensitized explosives',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(3,'Flammable gases',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(4,'Aerosols',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(5,'Flammable liquids',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(6,'Flammable solids',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(7,'Self-reactive substances and mixtures; Organic peroxides',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(8,'Pyrophoric liquids; Pyrophoric solids',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(9,'Self-heating substances and mixtures',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(10,'Substances and mixtures which in contact with water, emit flammable gases',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(11,'Oxidizing gases',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(12,'Oxidizing liquids; Oxidizing solids',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(14,'Gases under pressure',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(15,'Chemicals under pressure',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(16,'Corrosive to Metals',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(17,'Acute toxicity, oral',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(18,'Aspiration hazard',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(19,'Acute toxicity, dermal',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(20,'Hazardous to the ozone layer',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(21,'Hazardous to the aquatic environment, long-term hazard',NULL,1,1,'active',NULL,'2021-02-16 10:18:01','2021-02-16 10:18:01'),(22,'Skin corrosion/irritation',NULL,2,2,'active',NULL,'2021-02-16 16:30:43','2021-02-16 16:30:43'),(23,'Sensitization, Skin',NULL,2,2,'active',NULL,'2021-02-16 16:53:27','2021-02-16 16:53:27'),(24,'Serious eye damage/eye irritation',NULL,2,2,'active',NULL,'2021-02-16 16:57:38','2021-02-16 16:57:38'),(25,'Acute toxicity, inhalation',NULL,2,2,'active',NULL,'2021-02-16 16:57:56','2021-02-16 16:57:56'),(26,'Sensitization',NULL,2,2,'active',NULL,'2021-02-16 16:58:12','2021-02-16 22:17:29'),(27,'Reproductive toxicity',NULL,2,2,'active',NULL,'2021-02-16 17:24:01','2021-02-16 17:24:01'),(28,'Respiratory',NULL,2,2,'active',NULL,'2021-02-16 22:17:40','2021-02-16 22:17:40'),(29,'Specific target organ toxicity',NULL,2,2,'active',NULL,'2021-02-16 22:37:26','2021-02-16 22:37:26'),(30,'single exposure; Respiratory tract irritation',NULL,2,2,'active',NULL,'2021-02-16 22:37:47','2021-02-16 22:37:47'),(31,'single exposure; Narcotic effects',NULL,2,2,'active',NULL,'2021-02-16 22:41:39','2021-02-16 22:41:39'),(32,'Germ cell mutagenicity',NULL,2,2,'active',NULL,'2021-02-16 22:43:23','2021-02-16 22:43:23'),(33,'Carcinogenicity',NULL,2,2,'active',NULL,'2021-02-16 22:49:21','2021-02-16 22:49:21'),(34,'effects on or via lactation',NULL,2,2,'active',NULL,'2021-02-16 23:04:06','2021-02-16 23:04:06'),(35,'Hazardous to the aquatic environment',NULL,2,2,'active',NULL,'2021-02-17 09:29:25','2021-02-17 09:29:25'),(36,'Acute hazard',NULL,2,2,'active',NULL,'2021-02-17 09:29:45','2021-02-17 09:29:45'),(37,'Long-term hazard',NULL,2,2,'active',NULL,'2021-02-17 09:34:29','2021-02-17 09:34:29');
/*!40000 ALTER TABLE `hazard_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazard_code_types`
--

DROP TABLE IF EXISTS `hazard_code_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazard_code_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazard_code_types`
--

LOCK TABLES `hazard_code_types` WRITE;
/*!40000 ALTER TABLE `hazard_code_types` DISABLE KEYS */;
INSERT INTO `hazard_code_types` VALUES (1,'EU Hazard Statements',NULL,0,0,'active',NULL,'2020-10-14 12:32:38','2020-10-14 15:54:17'),(2,'Safe Work Australia Hazard Statements',NULL,0,0,'active',NULL,'2020-10-14 12:32:46','2020-10-14 15:54:56'),(3,'Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 15:55:19','2020-10-14 15:55:19'),(4,'GHS Hazard Statements',NULL,0,0,'active',NULL,'2020-10-14 15:55:58','2020-10-14 15:55:58'),(5,'R-Codes','R-Codes',2,2,'active',NULL,'2021-03-17 10:38:26','2021-03-17 10:38:26'),(6,'NFPA Reactivity',NULL,2,2,'active',NULL,'2021-03-17 12:07:00','2021-03-17 12:07:00'),(7,'WGK substance Class',NULL,2,2,'active',NULL,'2021-03-22 11:55:38','2021-03-22 11:55:38'),(8,'GK Code',NULL,2,2,'active',NULL,'2021-03-22 11:55:59','2021-03-22 11:55:59'),(9,'NFPA flammability',NULL,2,2,'active',NULL,'2021-03-22 12:17:42','2021-03-22 12:17:42'),(10,'NFPA health','NFPA health',2,2,'active',NULL,'2021-03-22 12:18:00','2021-03-22 12:18:00'),(11,'GHS Code','GHS Code',2,2,'active',NULL,'2021-03-22 14:09:02','2021-03-22 14:09:02');
/*!40000 ALTER TABLE `hazard_code_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazard_pictograms`
--

DROP TABLE IF EXISTS `hazard_pictograms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazard_pictograms` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hazard_pictogram` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazard_pictograms`
--

LOCK TABLES `hazard_pictograms` WRITE;
/*!40000 ALTER TABLE `hazard_pictograms` DISABLE KEYS */;
INSERT INTO `hazard_pictograms` VALUES (1,'assets/hazard_pictogram/GHS01.gif','Exploding Bomb','GHS01','Explosives',0,0,'active',NULL,'2020-10-14 15:45:20','2020-10-14 15:45:20'),(2,'assets/hazard_pictogram/GHS02.gif','Flame','GHS02','Flammables',0,0,'active',NULL,'2020-10-14 15:48:00','2020-10-14 15:48:00'),(3,'assets/hazard_pictogram/GHS05.gif','Corrosion','GHS05','Corrosives',0,0,'active',NULL,'2020-10-14 15:48:46','2020-10-14 15:48:46'),(4,'assets/hazard_pictogram/GHS03.gif','Flame Over Circle','GHS03','Oxidizers',0,0,'active',NULL,'2020-10-14 15:49:17','2020-10-14 15:49:17'),(5,'assets/hazard_pictogram/GHS04.gif','Gas Cylinder','GHS04','Compressed Gases',0,0,'active',NULL,'2020-10-14 15:49:50','2020-10-14 15:49:50'),(6,'assets/hazard_pictogram/GHS06.gif','Skull and Crossbones','GHS06','Acute Toxicity',0,0,'active',NULL,'2020-10-14 15:50:34','2020-10-14 15:50:34'),(7,'assets/hazard_pictogram/GHS07.gif','Exclamation Mark','GHS07','Irritant',0,0,'active',NULL,'2020-10-14 15:51:02','2020-10-14 15:51:02'),(8,'assets/hazard_pictogram/GHS08.gif','Health Hazard','GHS08',NULL,0,0,'active',NULL,'2020-10-14 15:51:27','2020-10-14 15:51:27'),(9,'assets/hazard_pictogram/GHS09.gif','Environment','GHS09',NULL,0,0,'active',NULL,'2020-10-14 15:51:53','2020-10-14 15:51:53');
/*!40000 ALTER TABLE `hazard_pictograms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazard_sub_code_types`
--

DROP TABLE IF EXISTS `hazard_sub_code_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazard_sub_code_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code_type_id` bigint DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazard_sub_code_types`
--

LOCK TABLES `hazard_sub_code_types` WRITE;
/*!40000 ALTER TABLE `hazard_sub_code_types` DISABLE KEYS */;
INSERT INTO `hazard_sub_code_types` VALUES (1,4,'Combined H-Codes',NULL,0,0,'active',NULL,'2020-10-14 15:59:32','2020-10-14 15:59:32'),(2,3,'General Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 15:59:53','2020-10-14 15:59:53'),(3,3,'Prevention Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 16:00:06','2020-10-14 16:00:06'),(4,3,'Response Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 16:00:21','2020-10-14 16:00:21'),(5,3,'Storage Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 16:00:41','2020-10-14 16:00:41'),(6,3,'Disposal Precautionary Statements',NULL,0,0,'active',NULL,'2020-10-14 16:00:57','2020-10-14 16:00:57'),(7,5,'Combined R-Codes',NULL,2,2,'active',NULL,'2021-03-17 11:45:50','2021-03-17 11:45:50');
/*!40000 ALTER TABLE `hazard_sub_code_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hazards`
--

DROP TABLE IF EXISTS `hazards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `hazards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `hazard_class_id` json DEFAULT NULL,
  `category_id` json DEFAULT NULL,
  `pictogram_id` bigint DEFAULT NULL,
  `code_statement_id` json DEFAULT NULL,
  `signal_word` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_statement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hazards`
--

LOCK TABLES `hazards` WRITE;
/*!40000 ALTER TABLE `hazards` DISABLE KEYS */;
INSERT INTO `hazards` VALUES (1,'[\"1\"]','[\"28\"]',1,'[\"29\", \"30\", \"35\", \"44\", \"91\", \"134\", \"135\", \"140\"]','Danger','H200','Unstable Explosive',NULL,0,0,'active',NULL,'2020-10-15 13:54:51','2020-10-15 13:54:51'),(2,'[\"1\"]','[\"12\"]',1,'[\"31\", \"35\", \"42\", \"44\", \"68\", \"74\", \"79\", \"89\", \"90\", \"134\"]','Danger','H201','Explosive; mass explosion hazard',NULL,0,0,'active',NULL,'2020-10-15 14:03:46','2020-10-15 14:03:46'),(3,'[\"1\"]','[\"13\"]',1,'[\"31\", \"44\", \"48\", \"68\", \"74\", \"79\", \"90\", \"134\", \"135\", \"170\"]','Danger','H202','Explosive; severe projection hazard',NULL,0,0,'active',NULL,'2020-10-15 14:15:12','2020-10-15 14:15:12'),(4,'[\"1\"]','[\"14\"]',1,'[\"31\", \"44\", \"48\", \"68\", \"74\", \"79\", \"90\", \"134\", \"135\", \"170\"]','Danger','H203','Explosive; fire, blast or projection hazard',NULL,0,0,'active',NULL,'2020-10-15 14:15:12','2020-10-15 14:15:12'),(5,'[\"1\"]','[\"15\"]',1,'[\"31\", \"35\", \"44\", \"74\", \"79\", \"90\", \"134\", \"135\", \"136\", \"170\"]','Warning','H204','Fire or projection hazard',NULL,0,0,'active',NULL,'2020-10-15 14:23:57','2020-10-15 14:23:57'),(6,'[\"1\"]','[\"16\"]',0,'[\"31\", \"35\", \"44\", \"68\", \"74\", \"79\", \"90\", \"134\", \"135\", \"170\"]','Danger','H205','May mass explode in fire',NULL,0,0,'active',NULL,'2020-10-28 10:35:04','2020-10-28 10:35:04'),(7,'[\"2\"]','[\"1\"]',2,'[\"31\", \"35\", \"42\", \"44\", \"63\", \"68\", \"71\", \"90\"]','Danger','H206','Fire, blast or projection hazard; increased risk of explosion if desensitizing agent is reduced',NULL,0,0,'active',NULL,'2020-10-28 10:48:52','2020-10-28 10:48:52'),(8,'[\"2\"]','[\"2\"]',2,'[\"31\", \"35\", \"42\", \"44\", \"63\", \"68\", \"71\", \"90\"]','Danger','H207','Fire or projection hazard; increased risk of explosion if desensitizing agent is reduced',NULL,0,0,'active',NULL,'2020-10-28 10:50:31','2020-10-28 10:50:31'),(9,'[\"2\"]','[\"3\"]',2,'[\"31\", \"35\", \"42\", \"44\", \"63\", \"68\", \"71\", \"90\"]','Warning','H207','Fire or projection hazard; increased risk of explosion if desensitizing agent is reduced',NULL,0,0,'active',NULL,'2020-10-28 10:52:16','2020-10-28 10:52:16'),(10,'[\"2\"]','[\"4\"]',2,'[\"31\", \"35\", \"42\", \"44\", \"63\", \"68\", \"71\"]','Warning','H208','Fire hazard; increased risk of explosion if desensitizing agent is reduced',NULL,0,0,'active',NULL,'2020-10-28 10:54:11','2020-10-28 10:54:11'),(11,'[\"3\"]','[\"18\"]',2,'[\"31\", \"46\", \"138\", \"141\"]','Danger','H220','Extremely flammable gas',NULL,0,0,'active',NULL,'2020-10-28 10:57:04','2020-10-28 10:57:04'),(12,'[\"3\"]','[\"19\"]',2,'[\"31\", \"46\", \"138\", \"141\"]','Danger','H221','Flammable gas',NULL,0,0,'active',NULL,'2020-10-28 11:11:21','2020-10-28 11:11:21'),(13,'[\"3\"]','[\"2\"]',0,'[\"31\", \"46\", \"138\", \"141\"]','Warning','H221','Flammable gas',NULL,0,0,'active',NULL,'2020-10-28 11:11:21','2020-10-28 11:14:53'),(14,'[\"4\"]','[\"1\"]',2,'[\"31\", \"32\", \"61\", \"80\"]','Danger','H222','Extremely flammable aerosol',NULL,0,0,'active',NULL,'2020-10-28 11:18:39','2020-10-28 11:18:39'),(15,'[\"4\"]','[\"2\"]',2,'[\"31\", \"32\", \"61\", \"80\"]','Warning','H223','Flammable aerosol',NULL,0,0,'active',NULL,'2020-10-28 11:18:39','2020-10-28 11:20:01'),(16,'[\"5\"]','[\"1\"]',2,'[\"31\", \"35\", \"59\", \"71\", \"75\", \"76\", \"77\", \"90\", \"151\", \"169\", \"173\"]','Danger','H224','Extremely flammable liquid and vapor',NULL,2,2,'active',NULL,'2021-02-16 13:15:33','2021-02-16 13:15:33'),(17,'[\"5\"]','[\"2\"]',2,'[\"31\", \"35\", \"59\", \"71\", \"75\", \"76\", \"77\", \"90\", \"151\", \"169\", \"173\"]','Danger','H225','Highly Flammable liquid and vapor',NULL,2,2,'active',NULL,'2021-02-16 13:16:50','2021-02-16 13:16:50'),(18,'[\"5\"]','[\"3\"]',2,'[\"31\", \"35\", \"59\", \"71\", \"75\", \"76\", \"77\", \"90\", \"151\", \"169\", \"173\"]','Warning','H226','Flammable liquid and vapor',NULL,2,2,'active',NULL,'2021-02-16 13:20:05','2021-02-16 13:20:05'),(19,'[\"5\"]','[\"4\"]',0,'[\"31\", \"35\", \"59\", \"90\", \"169\"]','Warning','H227','Combustible liquid',NULL,2,2,'active',NULL,'2021-02-16 13:21:50','2021-02-16 13:21:50'),(20,'[\"6\"]','[\"1\"]',2,'[\"31\", \"75\", \"90\", \"169\", \"173\"]','Danger','H228','Flammable solid',NULL,2,2,'active',NULL,'2021-02-16 13:27:38','2021-02-16 13:27:38'),(21,'[\"6\"]','[\"1\"]',2,'[\"31\", \"75\", \"90\", \"169\", \"173\"]','Warning','H228','Flammable solid',NULL,2,2,'active',NULL,'2021-02-16 13:27:38','2021-02-16 13:27:38'),(22,'[\"4\"]','[\"1\"]',2,'[\"31\", \"32\", \"61\", \"80\"]','Danger','H229','Pressurized container: may burst if heated',NULL,2,2,'active',NULL,'2021-02-16 13:30:27','2021-02-16 13:30:27'),(23,'[\"4\"]','[\"2\"]',2,'[\"31\", \"32\", \"61\", \"80\"]','Warning','H229','Pressurized container: may burst if heated',NULL,2,2,'active',NULL,'2021-02-16 13:30:27','2021-02-16 13:33:53'),(24,'[\"4\"]','[\"3\"]',0,'[\"31\", \"32\", \"61\", \"80\"]','Warning','H229','Pressurized container: may burst if heated',NULL,2,2,'active',NULL,'2021-02-16 13:30:27','2021-02-16 13:33:38'),(25,'[\"3\"]','[\"18\", \"29\"]',2,'[\"30\"]',NULL,'H230','May react explosively even in the absence of air',NULL,2,2,'active',NULL,'2021-02-16 13:39:36','2021-02-16 13:39:36'),(26,'[\"3\"]','[\"18\", \"29\"]',2,'[\"30\"]',NULL,'H231','May react explosively even in the absence of air at elevated pressure and/or temperature',NULL,2,2,'active',NULL,'2021-02-16 13:39:36','2021-02-16 13:39:36'),(27,'[\"3\"]','[\"18\", \"30\"]',2,'[\"66\"]','Danger','H232','May ignite spontaneously if exposed to air',NULL,2,2,'active',NULL,'2021-02-16 14:26:05','2021-02-16 14:26:05'),(28,'[\"1\"]','[\"5\"]',1,'[\"31\", \"35\", \"52\", \"55\", \"59\", \"64\", \"72\", \"90\", \"169\", \"171\"]','Danger','H240','Heating may cause an explosion',NULL,2,2,'active',NULL,'2021-02-16 14:28:54','2021-02-16 14:28:54'),(29,'[\"7\"]','[\"6\"]',0,'[\"31\", \"35\", \"52\", \"55\", \"59\", \"64\", \"72\", \"90\", \"169\", \"171\"]','Danger','H241','Heating may cause a fire or explosion',NULL,2,2,'active',NULL,'2021-02-16 14:30:14','2021-02-16 14:30:14'),(30,'[\"7\"]','[\"7\", \"8\"]',2,'[\"31\", \"35\", \"52\", \"55\", \"59\", \"64\", \"72\", \"90\", \"169\"]','Danger','H242','Heating may cause a fire',NULL,2,2,'active',NULL,'2021-02-16 15:02:43','2021-02-16 15:05:00'),(31,'[\"7\"]','[\"9\", \"10\"]',2,'[\"31\", \"35\", \"52\", \"55\", \"59\", \"64\", \"72\", \"90\", \"169\"]','Warning','H242','Heating may cause a fire',NULL,2,2,'active',NULL,'2021-02-16 15:02:43','2021-02-16 15:04:46'),(32,'[\"8\"]','[\"1\"]',2,'[\"31\", \"56\", \"66\", \"90\", \"147\", \"169\"]','Danger','H250','Catches fire spontaneously if exposed to air',NULL,2,2,'active',NULL,'2021-02-16 15:07:56','2021-02-16 15:07:56'),(33,'[\"9\"]','[\"1\"]',2,'[\"50\", \"54\", \"90\", \"97\"]','Danger','H251','Self-heating; may catch fire',NULL,2,2,'active',NULL,'2021-02-16 15:09:46','2021-02-16 15:09:46'),(34,'[\"9\"]','[\"2\"]',2,'\"\"','Warning','H252','Self-heating in large quantities; may catch fire',NULL,2,2,'active',NULL,'2021-02-16 15:10:46','2021-02-16 15:10:46'),(35,'[\"10\"]','[\"1\"]',2,'[\"35\", \"57\", \"67\", \"90\", \"96\", \"163\", \"169\"]','Danger','H260','In contact with water releases flammable gases which may ignite spontaneously',NULL,2,2,'active',NULL,'2021-02-16 15:18:30','2021-02-16 15:18:30'),(36,'[\"10\"]','[\"2\"]',2,'[\"35\", \"57\", \"67\", \"90\", \"96\", \"163\", \"169\"]','Danger','H261','In contact with water releases flammable gas',NULL,2,2,'active',NULL,'2021-02-16 15:18:30','2021-02-16 15:19:24'),(37,'[\"10\"]','[\"3\"]',2,'[\"35\", \"57\", \"90\", \"96\", \"169\"]','Warning','H261','In contact with water releases flammable gas',NULL,2,2,'active',NULL,'2021-02-16 15:18:30','2021-02-16 15:23:49'),(38,'[\"11\"]','[\"1\"]',4,'[\"46\", \"64\", \"78\", \"168\"]','Danger','H270','May cause or intensify fire; oxidizer',NULL,2,2,'active',NULL,'2021-02-16 15:25:42','2021-02-16 15:25:42'),(39,'[\"12\"]','[\"1\"]',4,'[\"31\", \"35\", \"43\", \"64\", \"65\", \"90\", \"93\", \"156\", \"169\"]','Danger','H271','May cause fire or explosion; strong Oxidizer',NULL,2,2,'active',NULL,'2021-02-16 15:27:26','2021-02-16 15:27:26'),(40,'[\"12\"]','[\"2\"]',4,'[\"31\", \"35\", \"64\", \"65\", \"90\", \"169\"]','Danger','H272','May intensify fire; oxidizer',NULL,2,2,'active',NULL,'2021-02-16 15:28:57','2021-02-16 15:28:57'),(41,'[\"12\"]','[\"3\"]',4,'[\"31\", \"35\", \"64\", \"65\", \"90\", \"169\"]','Warning','H272','May intensify fire; oxidizer',NULL,2,2,'active',NULL,'2021-02-16 15:28:57','2021-02-16 15:29:42'),(42,'[\"14\"]','[\"24\", \"25\", \"26\"]',5,'[\"60\"]','Warning','H280','Contains gas under pressure; may explode if heated',NULL,2,2,'active',NULL,'2021-02-16 15:33:34','2021-02-16 15:33:34'),(43,'[\"14\"]','[\"27\"]',5,'[\"46\", \"92\", \"107\", \"117\"]','Warning','H281','Contains refrigerated gas; may cause cryogenic burns or injury',NULL,2,2,'active',NULL,'2021-02-16 15:35:39','2021-02-16 15:35:39'),(44,'[\"15\"]','[\"1\"]',5,'[\"31\", \"32\", \"60\", \"137\", \"141\", \"169\"]','Danger','H282','Extremely flammable chemical under pressure: may explode if heated',NULL,2,2,'active',NULL,'2021-02-16 15:41:14','2021-02-16 15:41:14'),(45,'[\"15\"]','[\"2\"]',5,'[\"31\", \"32\", \"60\", \"137\", \"141\", \"169\"]','Warning','H283','Flammable chemical under pressure: may explode if heated',NULL,2,2,'active',NULL,'2021-02-16 15:42:26','2021-02-16 15:42:26'),(46,'[\"15\"]','[\"3\"]',5,'[\"31\", \"60\", \"137\"]','Warning','H284','Chemical under pressure: may explode if heated',NULL,2,2,'active',NULL,'2021-02-16 15:45:33','2021-02-16 15:45:33'),(47,'[\"16\"]','[\"1\"]',3,'[\"47\", \"72\", \"142\"]','Warning','H290','May be corrosive to metals',NULL,2,2,'active',NULL,'2021-02-16 15:58:56','2021-02-16 15:58:56'),(48,'[\"17\"]','[\"1\", \"2\"]',6,'[\"35\", \"48\", \"85\", \"86\", \"109\", \"111\", \"144\"]','Danger','H300','Fatal if swallowed',NULL,2,2,'active',NULL,'2021-02-16 16:00:38','2021-02-16 16:00:38'),(49,'[\"17\"]','[\"3\"]',6,'[\"35\", \"48\", \"85\", \"86\", \"109\", \"111\", \"144\"]','Danger','H301','Toxic if swallowed',NULL,2,2,'active',NULL,'2021-02-16 16:00:38','2021-02-16 16:00:38'),(50,'[\"17\"]','[\"4\"]',7,'[\"35\", \"85\", \"86\", \"111\", \"144\"]','Warning','H302','Harmful if swallowed',NULL,2,2,'active',NULL,'2021-02-16 16:00:38','2021-02-16 16:03:08'),(51,'[\"17\"]','[\"31\"]',0,'[\"104\"]','Warning','H302','May be harmful if swallowed',NULL,2,2,'active',NULL,'2021-02-16 16:00:38','2021-02-16 16:07:19'),(52,'[\"18\"]','[\"1\"]',8,'[\"35\", \"48\", \"112\", \"144\"]','Danger','H304','May be fatal if swallowed and enters airways',NULL,2,2,'active',NULL,'2021-02-16 16:09:56','2021-02-16 16:09:56'),(53,'[\"18\"]','[\"2\"]',8,'[\"35\", \"48\", \"112\", \"144\"]','Warning','H305','May be fatal if swallowed and enters airways',NULL,2,2,'active',NULL,'2021-02-16 16:09:56','2021-02-16 16:09:56'),(54,'[\"19\"]','[\"1\", \"2\"]',6,'[\"35\", \"48\", \"83\", \"85\", \"86\", \"90\", \"102\", \"110\", \"128\", \"130\", \"149\"]','Danger','H310','Fatal in contact with skin',NULL,2,2,'active',NULL,'2021-02-16 16:15:00','2021-02-16 16:15:00'),(55,'[\"19\"]','[\"3\"]',6,'[\"35\", \"48\", \"90\", \"102\", \"110\", \"128\", \"130\", \"149\"]','Danger','H311','Toxic in contact with skin',NULL,2,2,'active',NULL,'2021-02-16 16:15:00','2021-02-16 16:16:28'),(56,'[\"19\"]','[\"4\"]',7,'[\"35\", \"48\", \"90\", \"102\", \"110\", \"128\", \"130\", \"149\"]','Warning','H312','Harmful in contact with skin',NULL,2,2,'active',NULL,'2021-02-16 16:15:00','2021-02-16 16:17:42'),(57,'[\"19\"]','[\"31\"]',0,'[\"104\"]','Warning','H313','May be harmful in contact with skin',NULL,2,2,'active',NULL,'2021-02-16 16:15:00','2021-02-16 16:19:24'),(58,'[\"22\"]','[\"18\", \"19\", \"20\"]',3,'[\"35\", \"48\", \"81\", \"85\", \"90\", \"102\", \"109\", \"130\", \"146\", \"151\", \"153\", \"155\"]','Danger','H314','Causes severe skin burns and eye damage',NULL,2,2,'active',NULL,'2021-02-16 16:30:18','2021-02-16 16:30:58'),(59,'[\"22\"]','[\"2\"]',7,'[\"85\", \"90\", \"109\", \"129\", \"150\", \"161\"]','Warning','H315','Causes skin irritation',NULL,2,2,'active',NULL,'2021-02-16 16:49:36','2021-02-16 16:49:36'),(60,'[\"22\"]','[\"3\"]',0,'[\"161\"]','Warning','H316','Causes mild skin irritation',NULL,2,2,'active',NULL,'2021-02-16 16:50:44','2021-02-16 16:50:44'),(61,'[\"23\"]','[\"1\", \"18\", \"19\"]',7,'[\"35\", \"82\", \"88\", \"90\", \"109\", \"130\", \"150\", \"162\"]','Warning','H317','May cause an allergic skin reaction',NULL,2,2,'active',NULL,'2021-02-16 16:57:05','2021-02-16 16:57:17'),(62,'[\"24\"]','[\"1\"]',3,'[\"90\", \"102\", \"155\"]','Danger','H318','Causes serious eye damage',NULL,2,2,'active',NULL,'2021-02-16 21:16:49','2021-02-16 21:16:49'),(63,'[\"24\"]','[\"32\"]',7,'[\"85\", \"90\", \"155\", \"164\"]','Warning','H319','Causes serious eye irritation',NULL,2,2,'active',NULL,'2021-02-16 21:54:25','2021-02-16 21:54:40'),(64,'[\"24\"]','[\"33\"]',0,'[\"85\", \"90\", \"155\", \"164\"]','Warning','H320','Causes eye irritation',NULL,2,2,'active',NULL,'2021-02-16 21:56:25','2021-02-16 21:56:44'),(65,'[\"25\"]','[\"1\", \"2\"]',6,'[\"35\", \"48\", \"58\", \"81\", \"87\", \"94\", \"102\", \"108\", \"153\"]','Danger','H330','Fatal if inhaled',NULL,2,2,'active',NULL,'2021-02-16 22:05:30','2021-02-16 22:05:30'),(66,'[\"25\"]','[\"3\"]',6,'[\"35\", \"48\", \"58\", \"81\", \"87\", \"94\", \"102\", \"108\", \"153\"]','Danger','H331','Toxic if inhaled',NULL,2,2,'active',NULL,'2021-02-16 22:05:30','2021-02-16 22:07:20'),(67,'[\"25\"]','[\"4\"]',7,'[\"81\", \"87\", \"94\", \"102\", \"104\", \"108\", \"152\", \"153\"]','Warning','H332','Harmful if inhaled',NULL,2,2,'active',NULL,'2021-02-16 22:05:30','2021-02-16 22:09:33'),(68,'[\"25\"]','[\"31\"]',0,'[\"81\", \"87\", \"94\", \"102\", \"104\", \"108\", \"152\", \"153\"]','Warning','H333','May be harmful if inhaled',NULL,2,2,'active',NULL,'2021-02-16 22:05:30','2021-02-16 22:15:52'),(69,'[\"26\", \"28\"]','[\"1\", \"18\", \"19\"]',8,'[\"35\", \"82\", \"95\", \"154\", \"165\"]','Danger','H334','May cause allergy or asthma symptoms or breathing difficulties if inhaled',NULL,2,2,'active',NULL,'2021-02-16 22:36:29','2021-02-16 22:36:29'),(70,'[\"29\", \"30\"]','[\"3\"]',7,'[\"35\", \"48\", \"58\", \"82\", \"87\", \"104\", \"153\"]','Warning','H335','May cause respiratory irritation',NULL,2,2,'active',NULL,'2021-02-16 22:39:34','2021-02-16 22:39:34'),(71,'[\"29\", \"31\"]','[\"3\"]',7,'[\"35\", \"48\", \"58\", \"82\", \"87\", \"104\", \"153\"]','Warning','H336','May cause drowsiness or dizziness',NULL,2,2,'active',NULL,'2021-02-16 22:42:28','2021-02-16 22:42:55'),(72,'[\"32\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H340','May cause genetic defects',NULL,2,2,'active',NULL,'2021-02-16 22:45:12','2021-02-16 22:45:12'),(73,'[\"32\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H341','Suspected of causing genetic defects',NULL,2,2,'active',NULL,'2021-02-16 22:45:12','2021-02-16 22:46:20'),(74,'[\"33\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H350','May cause cancer',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:50:18'),(75,'[\"33\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H350i','May cause cancer by inhalation	',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:50:18'),(76,'[\"33\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H351','Suspected of causing cancer',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:51:59'),(77,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360','May damage fertility or the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(78,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360F','May damage fertility',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(79,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360D','May damage the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(80,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360FD','May damage fertility; May damage the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(81,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360Fd','May damage fertility; Suspected of damaging the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(82,'[\"27\"]','[\"18\", \"19\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Danger','H360Df','May damage the unborn child; Suspected of damaging fertility	',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:53:12'),(83,'[\"27\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H361','Suspected of damaging fertility or the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:57:38'),(84,'[\"27\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H361f','Suspected of damaging fertility',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:57:38'),(85,'[\"27\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H361d','Suspected of damaging the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:57:38'),(86,'[\"27\"]','[\"2\"]',8,'[\"29\", \"30\", \"35\", \"48\", \"91\", \"159\"]','Warning','H361fd','Suspected of damaging fertility; Suspected of damaging the unborn child',NULL,2,2,'active',NULL,'2021-02-16 22:50:18','2021-02-16 22:57:38'),(87,'[\"27\", \"34\"]','[\"21\"]',0,'[\"29\", \"81\", \"84\", \"85\", \"86\", \"159\"]',NULL,'H362','May cause harm to breast-fed children',NULL,2,2,'active',NULL,'2021-02-16 23:06:11','2021-02-16 23:06:11'),(88,'[\"29\", \"31\"]','[\"1\"]',8,'[\"35\", \"48\", \"81\", \"85\", \"86\", \"109\", \"157\"]','Danger','H370','Causes damage to organs',NULL,2,2,'active',NULL,'2021-02-17 09:23:03','2021-02-17 09:23:03'),(89,'[\"29\", \"31\"]','[\"2\"]',8,'[\"35\", \"48\", \"81\", \"85\", \"86\", \"109\", \"157\"]','Warning','H371','May cause damage to organ',NULL,2,2,'active',NULL,'2021-02-17 09:23:03','2021-02-17 09:24:35'),(90,'[\"27\", \"29\"]','[\"1\"]',8,'[\"35\", \"81\", \"85\", \"86\", \"106\"]','Danger','H372','Causes damage to organs through prolonged or repeated exposure',NULL,2,2,'active',NULL,'2021-02-17 09:26:34','2021-02-17 09:26:34'),(91,'[\"27\", \"29\"]','[\"2\"]',8,'[\"35\", \"81\", \"106\"]','Warning','H373','Causes damage to organs through prolonged or repeated exposure',NULL,2,2,'active',NULL,'2021-02-17 09:26:34','2021-02-17 09:28:08'),(92,'[\"35\", \"36\"]','[\"1\"]',9,'[\"35\", \"89\", \"143\"]','Warning','H400','Very toxic to aquatic life',NULL,2,2,'active',NULL,'2021-02-17 09:31:13','2021-02-17 09:31:13'),(93,'[\"35\", \"36\"]','[\"2\"]',0,'[\"35\", \"89\"]',NULL,'H401','Toxic to aquatic life',NULL,2,2,'active',NULL,'2021-02-17 09:31:13','2021-02-17 09:33:25'),(94,'[\"35\", \"36\"]','[\"3\"]',0,'[\"35\", \"89\"]',NULL,'H402','Harmful to aquatic life',NULL,2,2,'active',NULL,'2021-02-17 09:31:13','2021-02-17 09:34:02'),(95,'[\"35\", \"37\"]','[\"1\"]',9,'[\"35\", \"89\", \"143\"]','Warning','H410','Very toxic to aquatic life with long lasting effects',NULL,2,2,'active',NULL,'2021-02-17 09:36:00','2021-02-17 09:36:00'),(96,'[\"35\", \"37\"]','[\"2\"]',9,'[\"35\", \"89\", \"143\"]','Warning','H411','Toxic to aquatic life with long lasting effects',NULL,2,2,'active',NULL,'2021-02-17 09:36:00','2021-02-17 09:36:00'),(97,'[\"35\", \"37\"]','[\"3\"]',0,'[\"35\", \"89\"]',NULL,'H412','Harmful to aquatic life with long lasting effects',NULL,2,2,'active',NULL,'2021-02-17 09:36:00','2021-02-17 09:37:55'),(98,'[\"35\", \"37\"]','[\"4\"]',0,'[\"35\", \"89\"]',NULL,'H413','May cause long lasting harmful effects to aquatic life',NULL,2,2,'active',NULL,'2021-02-17 09:36:00','2021-02-17 09:37:55'),(99,'[\"20\"]','[\"1\"]',7,'[\"36\"]','Warning','H420','Harms publ health and the environment by destroying ozone in the upper atmosphere',NULL,2,2,'active',NULL,'2021-02-17 09:39:37','2021-02-17 09:39:37');
/*!40000 ALTER TABLE `hazards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `knowledge_banks`
--

DROP TABLE IF EXISTS `knowledge_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `knowledge_banks` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `process_id` bigint DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `knowledge_banks`
--

LOCK TABLES `knowledge_banks` WRITE;
/*!40000 ALTER TABLE `knowledge_banks` DISABLE KEYS */;
/*!40000 ALTER TABLE `knowledge_banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `list_products`
--

DROP TABLE IF EXISTS `list_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `list_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `list_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `chemical_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_name` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `molecular_formula` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cas` json DEFAULT NULL,
  `iupac` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inchi_key` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `smiles` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `list_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `organization` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `external_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ec_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `groups` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_class` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_statement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eu_hazard_statement` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_app_category` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `technical_fun` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `possible_usage` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `monitoring_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rsl_limits_table` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `product_line_restriction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `specific_restriction` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `numeric_limit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `test_methods` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `substi_option` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_of_inclusion` date DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_products`
--

LOCK TABLES `list_products` WRITE;
/*!40000 ALTER TABLE `list_products` DISABLE KEYS */;
/*!40000 ALTER TABLE `list_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mac_addresses`
--

DROP TABLE IF EXISTS `mac_addresses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mac_addresses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `mac_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mac_addresses`
--

LOCK TABLES `mac_addresses` WRITE;
/*!40000 ALTER TABLE `mac_addresses` DISABLE KEYS */;
/*!40000 ALTER TABLE `mac_addresses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_units`
--

DROP TABLE IF EXISTS `master_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_units` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `unit_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_constant` json DEFAULT NULL,
  `default_unit` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_units`
--

LOCK TABLES `master_units` WRITE;
/*!40000 ALTER TABLE `master_units` DISABLE KEYS */;
INSERT INTO `master_units` VALUES (1,0,'Distance','[{\"id\": \"1\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"2\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}, {\"id\": \"3\", \"unit_name\": \"inches\", \"unit_symbol\": \"in\"}, {\"id\": \"4\", \"unit_name\": \"meter\", \"unit_symbol\": \"m\"}, {\"id\": \"5\", \"unit_name\": \"centimetre\", \"unit_symbol\": \"cm\"}, {\"id\": \"6\", \"unit_name\": \"millimetre\", \"unit_symbol\": \"mm\"}, {\"id\": \"7\", \"unit_name\": \"micrometre\", \"unit_symbol\": \"mi\"}, {\"id\": \"8\", \"unit_name\": \"nanometre\", \"unit_symbol\": \"nm\"}, {\"id\": \"9\", \"unit_name\": \"feet\", \"unit_symbol\": \"ft\"}]','4',NULL,'active',1,27,NULL,'2020-09-27 22:40:43','2022-01-11 12:09:22'),(2,0,'Volume','[{\"id\": \"1\", \"unit_name\": \"yard3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"2\", \"unit_name\": \"bbl\", \"unit_symbol\": \"bbl\"}, {\"id\": \"3\", \"unit_name\": \"ft3\", \"unit_symbol\": \"ft^3\"}, {\"id\": \"4\", \"unit_name\": \"gal (Imperial)\", \"unit_symbol\": \"gal\"}, {\"id\": \"5\", \"unit_name\": \"gal (US)\", \"unit_symbol\": \"gal\"}, {\"id\": \"6\", \"unit_name\": \"fl. oz\", \"unit_symbol\": \"fl. oz\"}, {\"id\": \"7\", \"unit_name\": \"in3\", \"unit_symbol\": \"in3\"}, {\"id\": \"8\", \"unit_name\": \"m3\", \"unit_symbol\": \"m3\"}, {\"id\": \"9\", \"unit_name\": \"liter\", \"unit_symbol\": \"liter\"}, {\"id\": \"10\", \"unit_name\": \"cm3\", \"unit_symbol\": \"cm3\"}, {\"id\": \"11\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','8',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:40:46'),(3,0,'Molar Flowrate','[{\"id\": \"1\", \"unit_name\": \"MMscf/hr\", \"unit_symbol\": \"MMscf/hr\"}, {\"id\": \"2\", \"unit_name\": \"MMscf/day\", \"unit_symbol\": \"MMscf/day\"}, {\"id\": \"3\", \"unit_name\": \"Mscf/hr\", \"unit_symbol\": \"Mscf/hr\"}, {\"id\": \"4\", \"unit_name\": \"lb-mol/hr\", \"unit_symbol\": \"lb-mol/hr\"}, {\"id\": \"5\", \"unit_name\": \"g-mol/hr\", \"unit_symbol\": \"g-mol/hr\"}, {\"id\": \"6\", \"unit_name\": \"g-mol/day\", \"unit_symbol\": \"g-mol/day\"}]','5','Molar Flowrate','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:49:51'),(4,0,'Volumetric Flowrate','[{\"id\": \"1\", \"unit_name\": \"ft3/sec\", \"unit_symbol\": \"ft³/sec\"}, {\"id\": \"2\", \"unit_name\": \"ft3/min\", \"unit_symbol\": \"ft³/min\"}, {\"id\": \"3\", \"unit_name\": \"ft3/hr\", \"unit_symbol\": \"ft³/hr\"}, {\"id\": \"4\", \"unit_name\": \"bbl/hr\", \"unit_symbol\": \"bbl/hr\"}, {\"id\": \"5\", \"unit_name\": \"bbl/day\", \"unit_symbol\": \"bbl/day\"}, {\"id\": \"6\", \"unit_name\": \"gal/min\", \"unit_symbol\": \"gal/min\"}, {\"id\": \"7\", \"unit_name\": \"gal/day\", \"unit_symbol\": \"gal/day\"}, {\"id\": \"8\", \"unit_name\": \"m3/sec\", \"unit_symbol\": \"m³/sec\"}, {\"id\": \"9\", \"unit_name\": \"m3/min\", \"unit_symbol\": \"m³/min\"}, {\"id\": \"10\", \"unit_name\": \"m3/hr\", \"unit_symbol\": \"m³/hr\"}, {\"id\": \"11\", \"unit_name\": \"lit/sec\", \"unit_symbol\": \"lit/sec\"}, {\"id\": \"12\", \"unit_name\": \"lit/min\", \"unit_symbol\": \"lit/min\"}, {\"id\": \"13\", \"unit_name\": \"lit/hr\", \"unit_symbol\": \"lit/hr\"}, {\"id\": \"14\", \"unit_name\": \"lit/day\", \"unit_symbol\": \"lit/day\"}]','10','Volumetric Flowrate','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:50:00'),(5,0,'Pressure','[{\"id\": \"1\", \"unit_name\": \"psi\", \"unit_symbol\": \"lbf/in^2\"}, {\"id\": \"2\", \"unit_name\": \"in H2O\", \"unit_symbol\": \"in H2O\"}, {\"id\": \"3\", \"unit_name\": \"in Hg\", \"unit_symbol\": \"in Hg\"}, {\"id\": \"4\", \"unit_name\": \"torr\", \"unit_symbol\": \"torr\"}, {\"id\": \"5\", \"unit_name\": \"atm\", \"unit_symbol\": \"atm\"}, {\"id\": \"6\", \"unit_name\": \"MPa or N/mm2\", \"unit_symbol\": \"MPa or N/mm2\"}, {\"id\": \"7\", \"unit_name\": \"Barye\", \"unit_symbol\": \"Ba\"}, {\"id\": \"8\", \"unit_name\": \"GPa\", \"unit_symbol\": \"GPa\"}, {\"id\": \"9\", \"unit_name\": \"bar\", \"unit_symbol\": \"bar\"}, {\"id\": \"10\", \"unit_name\": \"ft H2O\", \"unit_symbol\": \"ft H2O\"}, {\"id\": \"11\", \"unit_name\": \"mm Hg\", \"unit_symbol\": \"mm Hg\"}, {\"id\": \"12\", \"unit_name\": \"m bar\", \"unit_symbol\": \"fm bar\"}, {\"id\": \"13\", \"unit_name\": \"Kg/cm2\", \"unit_symbol\": \"Kg/cm2\"}, {\"id\": \"14\", \"unit_name\": \"k Pa\", \"unit_symbol\": \"k Pa\"}, {\"id\": \"15\", \"unit_name\": \"Pa /Nm2\", \"unit_symbol\": \"Pa /Nm2\"}]','15',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:41:14'),(6,0,'Energy','[{\"id\": \"1\", \"unit_name\": \"hp.hr\", \"unit_symbol\": \"hp.hr\"}, {\"id\": \"2\", \"unit_name\": \"Btu\", \"unit_symbol\": \"Btu\"}, {\"id\": \"3\", \"unit_name\": \"kW.hr\", \"unit_symbol\": \"kW.hr\"}, {\"id\": \"4\", \"unit_name\": \"Cal\", \"unit_symbol\": \"Cal\"}, {\"id\": \"5\", \"unit_name\": \"kCal\", \"unit_symbol\": \"kCal\"}, {\"id\": \"6\", \"unit_name\": \"joule\", \"unit_symbol\": \"j\"}, {\"id\": \"7\", \"unit_name\": \"W.sec\", \"unit_symbol\": \"W.sec\"}, {\"id\": \"8\", \"unit_name\": \"ft3. lbf / in2\", \"unit_symbol\": \"ft3. lbf / in2\"}, {\"id\": \"9\", \"unit_name\": \"lit.atm\", \"unit_symbol\": \"lit.atm\"}, {\"id\": \"10\", \"unit_name\": \"kjoule\", \"unit_symbol\": \"KJ\"}, {\"id\": \"11\", \"unit_name\": \"Mjoule\", \"unit_symbol\": \"MJ\"}]','10','Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:50:19'),(7,0,'Mass','[{\"id\": \"1\", \"unit_name\": \"Long Ton\", \"unit_symbol\": \"Long Ton\"}, {\"id\": \"2\", \"unit_name\": \"Short Ton\", \"unit_symbol\": \"Short Ton\"}, {\"id\": \"3\", \"unit_name\": \"Metric Ton\", \"unit_symbol\": \"MT\"}, {\"id\": \"4\", \"unit_name\": \"lb\", \"unit_symbol\": \"lb\"}, {\"id\": \"5\", \"unit_name\": \"oz\", \"unit_symbol\": \"oz\"}, {\"id\": \"6\", \"unit_name\": \"kg\", \"unit_symbol\": \"kg\"}, {\"id\": \"7\", \"unit_name\": \"g\", \"unit_symbol\": \"g\"}, {\"id\": \"8\", \"unit_name\": \"mg\", \"unit_symbol\": \"mg\"}, {\"id\": \"9\", \"unit_name\": \"Grain\", \"unit_symbol\": \"Grain\"}, {\"id\": \"10\", \"unit_name\": \"Carat\", \"unit_symbol\": \"Carat\"}, {\"id\": \"11\", \"unit_name\": \"Slug\", \"unit_symbol\": \"Slug\"}, {\"id\": \"12\", \"unit_name\": \"Tonne\", \"unit_symbol\": \"Tonne\"}]','6','Mass','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:50:27'),(8,0,'Density','[{\"id\": \"1\", \"unit_name\": \"g/cm3\", \"unit_symbol\": \"g/cm3\"}, {\"id\": \"2\", \"unit_name\": \"g/ml\", \"unit_symbol\": \"g/ml\"}, {\"id\": \"3\", \"unit_name\": \"g/lit\", \"unit_symbol\": \"g/lit\"}, {\"id\": \"4\", \"unit_name\": \"g/gal\", \"unit_symbol\": \"g/gal\"}, {\"id\": \"5\", \"unit_name\": \"kg/m3\", \"unit_symbol\": \"kg/m3\"}, {\"id\": \"6\", \"unit_name\": \"lb/in3\", \"unit_symbol\": \"lb/in3\"}, {\"id\": \"7\", \"unit_name\": \"lb/ft3\", \"unit_symbol\": \"lb/ft3\"}, {\"id\": \"8\", \"unit_name\": \"lb/gal\", \"unit_symbol\": \"lb/gal\"}, {\"id\": \"9\", \"unit_name\": \"lb/bbl\", \"unit_symbol\": \"lb/bbl\"}, {\"id\": \"10\", \"unit_name\": \"oz/in3\", \"unit_symbol\": \"oz/in3\"}, {\"id\": \"11\", \"unit_name\": \"oz/gal\", \"unit_symbol\": \"oz/gal\"}, {\"id\": \"12\", \"unit_name\": \"SG (Liquid)\", \"unit_symbol\": \"SG (Liquid)\"}, {\"id\": \"13\", \"unit_name\": \"N/m3\", \"unit_symbol\": \"N/m3\"}]','5',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:41:22'),(9,0,'Area','[{\"id\": \"1\", \"unit_name\": \"m2\", \"unit_symbol\": \"m2\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:41:53'),(10,0,'Mass Flowrate','[{\"id\": \"1\", \"unit_name\": \"lb/sec\", \"unit_symbol\": \"lb/sec\"}, {\"id\": \"2\", \"unit_name\": \"lb/min\", \"unit_symbol\": \"lb/min\"}, {\"id\": \"3\", \"unit_name\": \"lb/hr\", \"unit_symbol\": \"lb/hr\"}, {\"id\": \"4\", \"unit_name\": \"lb/day\", \"unit_symbol\": \"lb/day\"}, {\"id\": \"5\", \"unit_name\": \"kg/sec\", \"unit_symbol\": \"kg/sec\"}, {\"id\": \"6\", \"unit_name\": \"kg/min\", \"unit_symbol\": \"kg/min\"}, {\"id\": \"7\", \"unit_name\": \"kg/hr\", \"unit_symbol\": \"kg/hr\"}, {\"id\": \"8\", \"unit_name\": \"kg/day\", \"unit_symbol\": \"kg/day\"}, {\"id\": \"9\", \"unit_name\": \"L ton/day\", \"unit_symbol\": \"L ton/day\"}, {\"id\": \"10\", \"unit_name\": \"S ton/day\", \"unit_symbol\": \"S ton/day\"}, {\"id\": \"11\", \"unit_name\": \"M ton/day\", \"unit_symbol\": \"M ton/day\"}, {\"id\": \"12\", \"unit_name\": \"ton/year\", \"unit_symbol\": \"ton/year\"}, {\"id\": \"13\", \"unit_name\": \"kg/year\", \"unit_symbol\": \"kg/year\"}, {\"id\": \"14\", \"unit_name\": \"ton/sec\", \"unit_symbol\": \"ton/sec\"}, {\"id\": \"15\", \"unit_name\": \"ton/min\", \"unit_symbol\": \"ton/min\"}, {\"id\": \"16\", \"unit_name\": \"ton/hr\", \"unit_symbol\": \"ton/hr\"}, {\"id\": \"17\", \"unit_name\": \"ton/day\", \"unit_symbol\": \"ton/day\"}]','8','Mass Flowrate','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:52:05'),(11,0,'Specific Energy','[{\"id\": \"1\", \"unit_name\": \"Btu/lb\", \"unit_symbol\": \"Btu/lb\"}, {\"id\": \"2\", \"unit_name\": \"cal/gr\", \"unit_symbol\": \"cal/gr\"}, {\"id\": \"3\", \"unit_name\": \"joule/gr\", \"unit_symbol\": \"joule/gr\"}, {\"id\": \"4\", \"unit_name\": \"cal/kg\", \"unit_symbol\": \"cal/kg\"}, {\"id\": \"5\", \"unit_name\": \"kcal/kg\", \"unit_symbol\": \"kcal/kg\"}, {\"id\": \"6\", \"unit_name\": \"joule/kg\", \"unit_symbol\": \"joule/kg\"}, {\"id\": \"7\", \"unit_name\": \"kJ/kg\", \"unit_symbol\": \"kJ/kg\"}, {\"id\": \"8\", \"unit_name\": \"MJ/kg\", \"unit_symbol\": \"MJ/kg\"}, {\"id\": \"9\", \"unit_name\": \"GJ/tonne\", \"unit_symbol\": \"GJ/tonne\"}]','8',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:42:15'),(12,0,'Temperature','[{\"id\": \"1\", \"unit_name\": \"Celsius\", \"unit_symbol\": \"C\"}, {\"id\": \"2\", \"unit_name\": \"Kelvin\", \"unit_symbol\": \"K\"}, {\"id\": \"3\", \"unit_name\": \"Fahrenheit\", \"unit_symbol\": \"F\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:42:27'),(13,0,'Mole','[{\"id\": \"1\", \"unit_name\": \"mol or gmol\", \"unit_symbol\": \"mol or gmol\"}, {\"id\": \"2\", \"unit_name\": \"kmol\", \"unit_symbol\": \"kmol\"}]','2','Mole','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 15:52:37'),(14,0,'Time','[{\"id\": \"1\", \"unit_name\": \"Second\", \"unit_symbol\": \"sec\"}, {\"id\": \"2\", \"unit_name\": \"Minute\", \"unit_symbol\": \"min\"}, {\"id\": \"3\", \"unit_name\": \"Hour\", \"unit_symbol\": \"hr\"}, {\"id\": \"4\", \"unit_name\": \"Day\", \"unit_symbol\": \"day\"}, {\"id\": \"5\", \"unit_name\": \"Week\", \"unit_symbol\": \"week\"}, {\"id\": \"6\", \"unit_name\": \"Year\", \"unit_symbol\": \"yr\"}]','4',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:45:12'),(15,0,'Molar Energy','[{\"id\": \"1\", \"unit_name\": \"Btu/lb-mol\", \"unit_symbol\": \"Btu/lb-mol\"}, {\"id\": \"2\", \"unit_name\": \"cal/gmol\", \"unit_symbol\": \"cal/gmol\"}, {\"id\": \"3\", \"unit_name\": \"joule/gmol\", \"unit_symbol\": \"joule/gmol\"}, {\"id\": \"4\", \"unit_name\": \"kJ/mol\", \"unit_symbol\": \"kJ/mol\"}, {\"id\": \"5\", \"unit_name\": \"MJ/mol\", \"unit_symbol\": \"MJ/mol\"}, {\"id\": \"6\", \"unit_name\": \"cal/kmol\", \"unit_symbol\": \"cal/kmol\"}, {\"id\": \"7\", \"unit_name\": \"kcal/kmol\", \"unit_symbol\": \"kcal/kmol\"}, {\"id\": \"8\", \"unit_name\": \"joule/kmol\", \"unit_symbol\": \"joule/kmol\"}, {\"id\": \"9\", \"unit_name\": \"kJ/kmol\", \"unit_symbol\": \"kJ/kmol\"}, {\"id\": \"10\", \"unit_name\": \"mJ/kmol\", \"unit_symbol\": \"mJ/kmol\"}, {\"id\": \"11\", \"unit_name\": \"J/mole\", \"unit_symbol\": \"J/mole\"}]','4',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:45:23'),(16,0,'Carbon content/GHG emissions','[{\"id\": \"1\", \"unit_name\": \"kgCO2/g\", \"unit_symbol\": \"kgCO2/g\"}, {\"id\": \"2\", \"unit_name\": \"kgCO2/kg\", \"unit_symbol\": \"kgCO2/kg\"}, {\"id\": \"3\", \"unit_name\": \"kgCO2/MT\", \"unit_symbol\": \"kgCO2/MT\"}, {\"id\": \"4\", \"unit_name\": \"gCO2/g\", \"unit_symbol\": \"gCO2/g\"}, {\"id\": \"5\", \"unit_name\": \"gCO2/kg\", \"unit_symbol\": \"gCO2/kg\"}, {\"id\": \"6\", \"unit_name\": \"gCO2/MT\", \"unit_symbol\": \"gCO2/MT\"}, {\"id\": \"7\", \"unit_name\": \"MTCO2/g\", \"unit_symbol\": \"MTCO2/g\"}, {\"id\": \"8\", \"unit_name\": \"MTCO2/kg\", \"unit_symbol\": \"MTCO2/kg\"}, {\"id\": \"9\", \"unit_name\": \"MTCO2/MT\", \"unit_symbol\": \"MTCO2/MT\"}]','2',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:45:34'),(17,0,'Weight Percent','[{\"id\": \"1\", \"unit_name\": \"mg/mg\", \"unit_symbol\": \"mg/mg\"}, {\"id\": \"2\", \"unit_name\": \"mg/g\", \"unit_symbol\": \"mg/g\"}, {\"id\": \"3\", \"unit_name\": \"mg/kg\", \"unit_symbol\": \"mg/kg\"}, {\"id\": \"4\", \"unit_name\": \"g/mg\", \"unit_symbol\": \"g/mg\"}, {\"id\": \"5\", \"unit_name\": \"g/g\", \"unit_symbol\": \"g/g\"}, {\"id\": \"6\", \"unit_name\": \"g/kg\", \"unit_symbol\": \"g/kg\"}, {\"id\": \"7\", \"unit_name\": \"kg/mg\", \"unit_symbol\": \"kg/mg\"}, {\"id\": \"8\", \"unit_name\": \"kg/g\", \"unit_symbol\": \"kg/g\"}, {\"id\": \"9\", \"unit_name\": \"kg/kg\", \"unit_symbol\": \"kg/kg\"}, {\"id\": \"10\", \"unit_name\": \"w%\", \"unit_symbol\": \"w%\"}]','10',NULL,'active',1,7,NULL,'2020-09-27 22:40:43','2021-06-23 19:32:44'),(18,0,'Weight Concentration','[{\"id\": \"1\", \"unit_name\": \"mg/m3\", \"unit_symbol\": \"mg/m3\"}, {\"id\": \"2\", \"unit_name\": \"gram/cubic meter\", \"unit_symbol\": \"g/m3\"}, {\"id\": \"3\", \"unit_name\": \"gram/liter\", \"unit_symbol\": \"g/l\"}, {\"id\": \"4\", \"unit_name\": \"kilogram/liter\", \"unit_symbol\": \"kg/l\"}, {\"id\": \"5\", \"unit_name\": \"kilogram/m3\", \"unit_symbol\": \"kg/m3\"}, {\"id\": \"6\", \"unit_name\": \"parts per billion\", \"unit_symbol\": \"ppb\"}, {\"id\": \"7\", \"unit_name\": \"parts per million water\", \"unit_symbol\": \"ppm\"}, {\"id\": \"8\", \"unit_name\": \"pound/cubic meter\", \"unit_symbol\": \"[lb/m3][avo\"}, {\"id\": \"9\", \"unit_name\": \"pound/cubic meter\", \"unit_symbol\": \"[lb/m3][met\"}, {\"id\": \"10\", \"unit_name\": \"pound/cubic meter\", \"unit_symbol\": \"[lb/m3][tro\"}, {\"id\": \"11\", \"unit_name\": \"pound/gallon\", \"unit_symbol\": \"[lb/gal][av\"}, {\"id\": \"12\", \"unit_name\": \"pound/gallon\", \"unit_symbol\": \"[lb/gal][av\"}, {\"id\": \"13\", \"unit_name\": \"pound/gallon\", \"unit_symbol\": \"[lb/gal][av\"}, {\"id\": \"14\", \"unit_name\": \"milligram/liter\", \"unit_symbol\": \"mg/l\"}, {\"id\": \"15\", \"unit_name\": \"parts per million - air\", \"unit_symbol\": \"ppm-air\"}, {\"id\": \"16\", \"unit_name\": \"mEq/kg\", \"unit_symbol\": \"mEq/kg\"}]','16',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:48:19'),(19,0,'Currency','[{\"id\": \"1\", \"unit_name\": \"US $\", \"unit_symbol\": \"USD\"}, {\"id\": \"2\", \"unit_name\": \"INR\", \"unit_symbol\": \"INR\"}, {\"id\": \"3\", \"unit_name\": \"HK\", \"unit_symbol\": \"HK\"}, {\"id\": \"4\", \"unit_name\": \"EURO\", \"unit_symbol\": \"EUR\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:48:30'),(20,0,'Catalyst Time','[{\"id\": \"1\", \"unit_name\": \"per sec\", \"unit_symbol\": \"per sec\"}, {\"id\": \"2\", \"unit_name\": \"per min\", \"unit_symbol\": \"per min\"}, {\"id\": \"3\", \"unit_name\": \"per hour\", \"unit_symbol\": \"per hour\"}, {\"id\": \"4\", \"unit_name\": \"per day\", \"unit_symbol\": \"per day\"}]','3',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:48:37'),(21,0,'Specific Heat Capacity','[{\"id\": \"1\", \"unit_name\": \"kJ/(kg K)\", \"unit_symbol\": \"kJ/(kg K)\"}, {\"id\": \"2\", \"unit_name\": \"kJ/m3/K\", \"unit_symbol\": \"kJ/m3/K\"}, {\"id\": \"3\", \"unit_name\": \"kJ/MJ/K\", \"unit_symbol\": \"kJ/MJ/K\"}, {\"id\": \"4\", \"unit_name\": \"J/(mol K)\", \"unit_symbol\": \"J/(mol K)\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:50:09'),(22,0,'Enthalpy Change of Combustion','[{\"id\": \"1\", \"unit_name\": \"MJ/kg\", \"unit_symbol\": \"MJ/kg\"}, {\"id\": \"2\", \"unit_name\": \"MJ/m3\", \"unit_symbol\": \"MJ/m3\"}, {\"id\": \"3\", \"unit_name\": \"MJ/MJ\", \"unit_symbol\": \"MJ/MJ\"}, {\"id\": \"4\", \"unit_name\": \"kJ/kg\", \"unit_symbol\": \"kJ/kg\"}, {\"id\": \"5\", \"unit_name\": \"kJ/m3\", \"unit_symbol\": \"kJ/m3\"}, {\"id\": \"6\", \"unit_name\": \"kJ/MJ\", \"unit_symbol\": \"kJ/MJ\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:49:15'),(23,0,'CED - Energy','[{\"id\": \"1\", \"unit_name\": \"MJ - CED/kg\", \"unit_symbol\": \"MJ - CED/kg\"}, {\"id\": \"2\", \"unit_name\": \"MJ - CED/m3\", \"unit_symbol\": \"MJ - CED/m3\"}, {\"id\": \"3\", \"unit_name\": \"MJ - CED/MJ\", \"unit_symbol\": \"MJ - CED/MJ\"}]','',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:49:28'),(24,0,'GHG - Energy','[{\"id\": \"1\", \"unit_name\": \"kgCO2/kg\", \"unit_symbol\": \"kgCO2/kg\"}, {\"id\": \"2\", \"unit_name\": \"kgCO2/m3\", \"unit_symbol\": \"kgCO2/m3\"}, {\"id\": \"3\", \"unit_name\": \"kgCO2/MJ\", \"unit_symbol\": \"kgCO2/MJ\"}]',NULL,'GHG - Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:17:22'),(25,0,'Non Renewable Energy Use (NREU) - Energy','[{\"id\": \"1\", \"unit_name\": \"MJ - NREU/kg\", \"unit_symbol\": \"MJ - NREU/kg\"}, {\"id\": \"2\", \"unit_name\": \"MJ - NREU/m3\", \"unit_symbol\": \"MJ - NREU/m3\"}, {\"id\": \"3\", \"unit_name\": \"MJ - NREU/MJ\", \"unit_symbol\": \"MJ - NREU/MJ\"}]',NULL,'Non Renewable Energy Use (NREU) - Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:17:33'),(26,0,'Renewable Energy Use (REU) - Energy','[{\"id\": \"1\", \"unit_name\": \"MJ - REU/kg\", \"unit_symbol\": \"MJ - REU/kg\"}, {\"id\": \"2\", \"unit_name\": \"MJ - REU/m3\", \"unit_symbol\": \"MJ - REU/m3\"}, {\"id\": \"3\", \"unit_name\": \"MJ - REU/MJ\", \"unit_symbol\": \"MJ - REU/MJ\"}]',NULL,'Renewable Energy Use (REU) - Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:17:42'),(27,0,'Water Usage - Energy','[{\"id\": \"1\", \"unit_name\": \"kg/kg\", \"unit_symbol\": \"WUENERGY\"}, {\"id\": \"2\", \"unit_name\": \"kg/m3\", \"unit_symbol\": \"WUENERGY\"}, {\"id\": \"3\", \"unit_name\": \"kg/MJ\", \"unit_symbol\": \"WUENERGY\"}]',NULL,'Water Usage - Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:17:50'),(28,0,'Land Usage - Energy','[{\"id\": \"1\", \"unit_name\": \"m2/m3\", \"unit_symbol\": \"LUENERGY\"}, {\"id\": \"2\", \"unit_name\": \"m2/MJ\", \"unit_symbol\": \"LUENERGY\"}, {\"id\": \"3\", \"unit_name\": \"m2/kg\", \"unit_symbol\": \"m2/kg\"}]',NULL,NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-02-18 14:38:26'),(29,0,'Price - Energy','[{\"id\": \"1\", \"unit_name\": \"USD/kg\", \"unit_symbol\": \"Pr Energy\"}, {\"id\": \"2\", \"unit_name\": \"USD/m3\", \"unit_symbol\": \"Pr Energy\"}, {\"id\": \"3\", \"unit_name\": \"USD/MJ\", \"unit_symbol\": \"Pr Energy\"}]',NULL,'Price - Energy','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:18:08'),(30,0,'Volume Concentration','[{\"id\": \"1\", \"unit_name\": \"dL/g\", \"unit_symbol\": \"dL/g\"}]','1','Volume Concentration','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:18:15'),(31,0,'Dynamic Viscosity','[{\"id\": \"1\", \"unit_name\": \"Pa s\", \"unit_symbol\": \"Pa s\"}, {\"id\": \"2\", \"unit_name\": \"Poise\", \"unit_symbol\": \"P\"}, {\"id\": \"3\", \"unit_name\": \"centipoise\", \"unit_symbol\": \"cP\"}, {\"id\": \"4\", \"unit_name\": \"decipoise\", \"unit_symbol\": \"dP\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:50:25'),(32,0,'Diffusivity','[{\"id\": \"1\", \"unit_name\": \"m2/s\", \"unit_symbol\": \"m2/s\"}, {\"id\": \"2\", \"unit_name\": \"cm2/s\", \"unit_symbol\": \"cm2/s\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:50:38'),(33,0,'Thermal Conductivity','[{\"id\": \"1\", \"unit_name\": \"W/(m K)\", \"unit_symbol\": \"W/(m K)\"}, {\"id\": \"2\", \"unit_name\": \"W/(m DegC)\", \"unit_symbol\": \"W/(m u00b0C)\"}, {\"id\": \"3\", \"unit_name\": \"kcal/(hr m DegC)\", \"unit_symbol\": \"kcal/(hr m u00b0C)\"}, {\"id\": \"4\", \"unit_name\": \"BTU/(hr ft DegF)\", \"unit_symbol\": \"BTU/(hr ft u00b0F)\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:50:46'),(34,0,'Surface tension','[{\"id\": \"1\", \"unit_name\": \"N/m\", \"unit_symbol\": \"N/m\"}, {\"id\": \"2\", \"unit_name\": \"J/m2\", \"unit_symbol\": \"J/m2\"}, {\"id\": \"3\", \"unit_name\": \"Dyne/cm\", \"unit_symbol\": \"Dyne/cm\"}, {\"id\": \"4\", \"unit_name\": \"mN/m\", \"unit_symbol\": \"mN/m\"}]','4',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:50:56'),(35,0,'Frequency','[{\"id\": \"1\", \"unit_name\": \"1/s\", \"unit_symbol\": \"1/s\"}, {\"id\": \"2\", \"unit_name\": \"Hz\", \"unit_symbol\": \"Hz\"}]','2','Frequency','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:19:27'),(36,0,'Power','[{\"id\": \"1\", \"unit_name\": \"Watt\", \"unit_symbol\": \"W\"}, {\"id\": \"2\", \"unit_name\": \"Milliwatt\", \"unit_symbol\": \"mW\"}, {\"id\": \"3\", \"unit_name\": \"Kilowatt\", \"unit_symbol\": \"KW\"}, {\"id\": \"4\", \"unit_name\": \"Megawatt\", \"unit_symbol\": \"MW\"}, {\"id\": \"5\", \"unit_name\": \"Gigawatt\", \"unit_symbol\": \"GW\"}, {\"id\": \"6\", \"unit_name\": \"BTU/hr\", \"unit_symbol\": \"BTU/hr\"}, {\"id\": \"7\", \"unit_name\": \"BTU/s\", \"unit_symbol\": \"BTU/s\"}, {\"id\": \"8\", \"unit_name\": \"Cal/s\", \"unit_symbol\": \"Cal/s\"}, {\"id\": \"9\", \"unit_name\": \"Kcal/s\", \"unit_symbol\": \"Kcal/s\"}, {\"id\": \"10\", \"unit_name\": \"MJ/s\", \"unit_symbol\": \"MJ/s\"}, {\"id\": \"11\", \"unit_name\": \"MJ/min\", \"unit_symbol\": \"MJ/min\"}, {\"id\": \"12\", \"unit_name\": \"MJ/hr\", \"unit_symbol\": \"MJ/hr\"}, {\"id\": \"13\", \"unit_name\": \"hp\", \"unit_symbol\": \"hp\"}, {\"id\": \"14\", \"unit_name\": \"GJ/hr\", \"unit_symbol\": \"GJ/hr\"}]','3','Power','active',1,1,NULL,'2020-09-27 22:40:43','2020-09-27 22:40:43'),(37,0,'Specific volume','[{\"id\": \"1\", \"unit_name\": \"lit/kg\", \"unit_symbol\": \"lit/kg\"}, {\"id\": \"2\", \"unit_name\": \"m3/kg\", \"unit_symbol\": \"m3/kg\"}, {\"id\": \"3\", \"unit_name\": \"cm3/g\", \"unit_symbol\": \"cm3/g\"}, {\"id\": \"4\", \"unit_name\": \"lit/g\", \"unit_symbol\": \"lit/g\"}, {\"id\": \"5\", \"unit_name\": \"ft3/kg\", \"unit_symbol\": \"ft3/kg\"}, {\"id\": \"6\", \"unit_name\": \"ft3/lb\", \"unit_symbol\": \"ft3/lb\"}]','2',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:52:19'),(38,0,'Tenacity','[{\"id\": \"1\", \"unit_name\": \"gm/denier\", \"unit_symbol\": \"gm/denier\"}, {\"id\": \"2\", \"unit_name\": \"gm/Tex\", \"unit_symbol\": \"gm/Tex\"}, {\"id\": \"3\", \"unit_name\": \"N/Tex\", \"unit_symbol\": \"N/Tex\"}, {\"id\": \"4\", \"unit_name\": \"cN/Tex\", \"unit_symbol\": \"cN/Tex\"}]','4',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:52:11'),(39,0,'Velocity','[{\"id\": \"1\", \"unit_name\": \"m/s\", \"unit_symbol\": \"m/s\"}, {\"id\": \"2\", \"unit_name\": \"km/hr\", \"unit_symbol\": \"km/hr\"}, {\"id\": \"3\", \"unit_name\": \"ft/min\", \"unit_symbol\": \"ft/min\"}, {\"id\": \"4\", \"unit_name\": \"ft/s\", \"unit_symbol\": \"ft/s\"}, {\"id\": \"5\", \"unit_name\": \"yards/min\", \"unit_symbol\": \"yards/min\"}, {\"id\": \"6\", \"unit_name\": \"mph\", \"unit_symbol\": \"mph\"}, {\"id\": \"7\", \"unit_name\": \"knots\", \"unit_symbol\": \"knots\"}]','1',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:52:04'),(40,0,'Linear density','[{\"id\": \"1\", \"unit_name\": \"tex\", \"unit_symbol\": \"tex\"}, {\"id\": \"2\", \"unit_name\": \"dtex\", \"unit_symbol\": \"dtex\"}, {\"id\": \"3\", \"unit_name\": \"den\", \"unit_symbol\": \"den\"}, {\"id\": \"4\", \"unit_name\": \"gr/yd\", \"unit_symbol\": \"gr/yd\"}, {\"id\": \"5\", \"unit_name\": \"NeL or Lea\", \"unit_symbol\": \"NeL or Lea\"}, {\"id\": \"6\", \"unit_name\": \"Nm\", \"unit_symbol\": \"Nm\"}, {\"id\": \"7\", \"unit_name\": \"NeC or Ne\", \"unit_symbol\": \"NeC or Ne\"}, {\"id\": \"8\", \"unit_name\": \"NeK or NeW\", \"unit_symbol\": \"NeK or NeW\"}, {\"id\": \"9\", \"unit_name\": \"NeS\", \"unit_symbol\": \"NeS\"}]','2',NULL,'active',1,2,NULL,'2020-09-27 22:40:43','2021-03-25 15:51:56'),(41,0,'Phase','[{\"id\": \"1\", \"unit_name\": \"Solid\", \"unit_symbol\": \"Solid\"}, {\"id\": \"2\", \"unit_name\": \"Liquid\", \"unit_symbol\": \"Liquid\"}, {\"id\": \"3\", \"unit_name\": \"Gas\", \"unit_symbol\": \"Gas\"}]','2',NULL,'active',1,3,NULL,'2020-09-27 22:40:43','2021-07-29 13:00:57'),(42,0,'Molecular Weight','[{\"id\": \"1\", \"unit_name\": \"g/mol\", \"unit_symbol\": \"g/mol\"}, {\"id\": \"2\", \"unit_name\": \"kg/mol\", \"unit_symbol\": \"kg/mol\"}]','1','Molecular Weight','active',1,1,NULL,'2020-09-27 22:40:43','2020-10-15 16:21:21'),(43,0,'Independent Unit','[{\"id\": \"1\", \"unit_name\": \"logKow\", \"unit_symbol\": \"logKow\"}, {\"id\": \"2\", \"unit_name\": \"mole/m3\", \"unit_symbol\": \"mole/m³\"}, {\"id\": \"3\", \"unit_name\": \"m3/mole\", \"unit_symbol\": \"m³/mole\"}, {\"id\": \"4\", \"unit_name\": \"m3 kg0.25/(s0.5 mol)\", \"unit_symbol\": \"m³ kg0.25/(s0.5 mol)\"}, {\"id\": \"5\", \"unit_name\": \"rpm\", \"unit_symbol\": \"rpm\"}, {\"id\": \"6\", \"unit_name\": \"Percentage\", \"unit_symbol\": \"%\"}, {\"id\": \"7\", \"unit_name\": \"meq\", \"unit_symbol\": \"meq\"}, {\"id\": \"8\", \"unit_name\": \"Bag\", \"unit_symbol\": \"Bag\"}, {\"id\": \"9\", \"unit_name\": \"Pack\", \"unit_symbol\": \"Pack\"}, {\"id\": \"10\", \"unit_name\": \"Pallets\", \"unit_symbol\": \"Pallets\"}, {\"id\": \"11\", \"unit_name\": \"Roll\", \"unit_symbol\": \"Roll\"}, {\"id\": \"12\", \"unit_name\": \"Set\", \"unit_symbol\": \"Set\"}, {\"id\": \"13\", \"unit_name\": \"Sheet\", \"unit_symbol\": \"Sheet\"}, {\"id\": \"14\", \"unit_name\": \"Stones\", \"unit_symbol\": \"Stones\"}, {\"id\": \"15\", \"unit_name\": \"Ton\", \"unit_symbol\": \"Ton\"}, {\"id\": \"16\", \"unit_name\": \"Trays\", \"unit_symbol\": \"Trays\"}, {\"id\": \"17\", \"unit_name\": \"Unit\", \"unit_symbol\": \"Unit\"}, {\"id\": \"18\", \"unit_name\": \"F/m\", \"unit_symbol\": \"F/m\"}, {\"id\": \"19\", \"unit_name\": \"J/(m3K)\", \"unit_symbol\": \"J/(m³K)\"}, {\"id\": \"20\", \"unit_name\": \"per Kelvin\", \"unit_symbol\": \"1/K\"}, {\"id\": \"21\", \"unit_name\": \"K/Pa\", \"unit_symbol\": \"K/Pa\"}, {\"id\": \"22\", \"unit_name\": \"kJ/(kg K)\", \"unit_symbol\": \"kJ/(kg K)\"}, {\"id\": \"23\", \"unit_name\": \"amu\", \"unit_symbol\": \"amu\"}, {\"id\": \"24\", \"unit_name\": \"per MPa\", \"unit_symbol\": \"MPa⁻¹\"}, {\"id\": \"25\", \"unit_name\": \"MPa m¹/²\", \"unit_symbol\": \"MPa m¹/²\"}, {\"id\": \"26\", \"unit_name\": \"µΩ cm\", \"unit_symbol\": \"µΩ cm\"}, {\"id\": \"27\", \"unit_name\": \"MPa¹/²\", \"unit_symbol\": \"MPa¹/²\"}, {\"id\": \"28\", \"unit_name\": \"Degree\", \"unit_symbol\": \"deg\"}, {\"id\": \"29\", \"unit_name\": \"cm3(STP)cm/(cm2*s*Pa)\", \"unit_symbol\": \"cm3(STP)cm/(cm2*s*Pa)\"}, {\"id\": \"30\", \"unit_name\": \"kJ/m\", \"unit_symbol\": \"kJ/m\"}, {\"id\": \"31\", \"unit_name\": \"binary\", \"unit_symbol\": \"binary\"}, {\"id\": \"32\", \"unit_name\": \"Mass Fraction\", \"unit_symbol\": \"Mass Fraction\"}, {\"id\": \"33\", \"unit_name\": \"Coefficient\", \"unit_symbol\": \"Coefficient\"}, {\"id\": \"34\", \"unit_name\": \"Index\", \"unit_symbol\": \"Index\"}, {\"id\": \"35\", \"unit_name\": \"ratio\", \"unit_symbol\": \"ratio\"}, {\"id\": \"36\", \"unit_name\": \"-\", \"unit_symbol\": \"-\"}]','36',NULL,'active',1,7,NULL,'2020-09-27 22:40:43','2021-05-20 14:52:21'),(51,0,'Eutrophication','[{\"id\": \"1\", \"unit_name\": \"gm eq PO4\", \"unit_symbol\": \"gm eq PO4\"}]','1',NULL,'active',2,2,NULL,'2021-03-04 17:09:30','2021-03-25 15:53:30'),(52,0,'electric current','[{\"id\": \"1\", \"unit_name\": \"Ampere\", \"unit_symbol\": \"A\"}]','0',NULL,'active',7,3,NULL,'2021-05-20 15:15:02','2021-07-29 12:59:38'),(53,0,'electrical voltage','[{\"id\": \"1\", \"unit_name\": \"volt\", \"unit_symbol\": \"V\"}]','0',NULL,'active',7,3,NULL,'2021-05-20 15:15:32','2021-07-29 12:59:21'),(54,0,'volume percent','[{\"id\": \"1\", \"unit_name\": \"%\", \"unit_symbol\": \"%\"}]','0',NULL,'active',7,3,NULL,'2021-06-23 19:33:23','2021-07-29 12:58:22'),(55,0,'log reduction','[{\"id\": \"1\", \"unit_name\": \"-\", \"unit_symbol\": \"-\"}]','0',NULL,'active',7,3,NULL,'2021-06-30 15:05:08','2021-07-29 13:02:11'),(56,0,'Torque','[{\"id\": \"1\", \"unit_name\": \"Deci Newton Meter\", \"unit_symbol\": \"dNm\"}, {\"id\": \"2\", \"unit_name\": \"Newton Meter\", \"unit_symbol\": \"Nm\"}]','1',NULL,'active',12,12,NULL,'2021-07-02 15:39:36','2021-07-02 20:22:53'),(57,0,'Shore (Durometer) Hardness','[{\"id\": \"1\", \"unit_name\": \"Shore A\", \"unit_symbol\": \"Sh A\"}, {\"id\": \"2\", \"unit_name\": \"Shore D\", \"unit_symbol\": \"Sh D\"}]','0',NULL,'active',12,3,NULL,'2021-07-02 15:59:14','2021-07-29 13:02:37'),(58,0,'Filler dispersion(dk)','[{\"id\": \"1\", \"unit_name\": \"Percentage\", \"unit_symbol\": \"%\"}]','0',NULL,'inactive',12,12,'2021-07-02 16:45:34','2021-07-02 16:03:33','2021-07-02 16:45:34'),(59,0,'Rebound Percentage','[{\"id\": \"1\", \"unit_name\": \"Rebound\", \"unit_symbol\": \"%\"}]','0',NULL,'active',12,12,NULL,'2021-07-02 16:07:30','2021-07-02 16:35:14'),(60,0,'Mooney Unit','[{\"id\": \"1\", \"unit_name\": \"Mooney Unit\", \"unit_symbol\": \"M.U\"}]','0',NULL,'active',12,3,NULL,'2021-07-02 17:01:35','2021-07-29 13:02:58'),(61,0,'Unitless','[{\"id\": \"1\", \"unit_name\": \"-\", \"unit_symbol\": \"-\"}]','0',NULL,'active',7,7,NULL,'2021-07-26 14:46:50','2021-07-26 14:47:00'),(62,0,'Contact time','[{\"id\": \"1\", \"unit_name\": \"Minute\", \"unit_symbol\": \"Minute\"}, {\"id\": \"2\", \"unit_name\": \"Second\", \"unit_symbol\": \"Second\"}]','0',NULL,'active',7,7,NULL,'2021-07-26 14:52:44','2021-07-26 14:53:15'),(63,0,'Raw Material Unit','[{\"id\": \"0\", \"unit_name\": \"Weight Percentage\", \"unit_symbol\": \"%\"}, {\"id\": \"1\", \"unit_name\": \"Volume Percentage\", \"unit_symbol\": \"%\"}, {\"id\": \"2\", \"unit_name\": \"Mole Percentage\", \"unit_symbol\": \"%\"}]',NULL,NULL,'active',1,1,NULL,'2021-08-02 15:25:49','2021-08-02 15:25:49'),(68,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-09 11:45:03','2021-12-09 11:44:27','2021-12-09 11:45:03'),(83,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-09 11:59:24','2021-12-09 11:57:52','2021-12-09 11:59:24'),(84,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-09 11:59:28','2021-12-09 11:57:52','2021-12-09 11:59:28'),(156,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-16 15:43:44','2021-12-09 12:54:03','2021-12-16 15:43:44'),(187,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-16 15:44:10','2021-12-13 10:33:20','2021-12-16 15:44:10'),(188,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-16 15:44:01','2021-12-13 10:34:33','2021-12-16 15:44:01'),(189,0,'Test unit','[{\"id\": \"0\", \"unit_name\": \"unit name1\", \"unit_symbol\": \"unit symbol1\"}, {\"id\": \"1\", \"unit_name\": \"unit name2\", \"unit_symbol\": \"unit symbol2\"}]','0','test description','inactive',0,27,'2021-12-13 10:34:42','2021-12-13 10:34:33','2021-12-13 10:34:42'),(194,0,'Unit Type 1','[{\"id\": \"0\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"1\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}]','0',NULL,'inactive',27,27,'2021-12-16 15:44:06','2021-12-14 16:20:07','2021-12-16 15:44:06'),(195,0,'Unit Type 2','[{\"id\": \"0\", \"unit_name\": \"yard 3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"1\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','0',NULL,'inactive',27,27,'2021-12-16 15:43:57','2021-12-14 16:20:07','2021-12-16 15:43:57'),(196,0,'Unit Type 1','[{\"id\": \"0\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"1\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}]','0',NULL,'inactive',27,27,'2021-12-16 15:43:53','2021-12-16 15:43:29','2021-12-16 15:43:53'),(197,0,'Unit Type 2','[{\"id\": \"0\", \"unit_name\": \"yard 3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"1\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','0',NULL,'inactive',27,27,'2021-12-16 15:43:49','2021-12-16 15:43:29','2021-12-16 15:43:49'),(198,0,'Unit Type 1','[{\"id\": \"0\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"1\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}]','0',NULL,'inactive',27,27,'2021-12-22 13:48:16','2021-12-17 11:04:43','2021-12-22 13:48:16'),(199,0,'Unit Type 2','[{\"id\": \"0\", \"unit_name\": \"yard 3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"1\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','0',NULL,'active',27,27,'2021-12-22 13:48:33','2021-12-17 11:04:43','2021-12-22 13:48:33'),(200,0,'Unit Type 1','[{\"id\": \"0\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"1\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}]','0',NULL,'active',27,27,'2021-12-22 13:48:33','2021-12-17 11:06:00','2021-12-22 13:48:33'),(201,0,'Unit Type 2','[{\"id\": \"0\", \"unit_name\": \"yard 3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"1\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','0',NULL,'active',27,27,'2021-12-22 13:48:33','2021-12-17 11:06:00','2021-12-22 13:48:33'),(202,0,'Test','[{\"id\": \"0\", \"unit_name\": \"mile\", \"unit_symbol\": \"mile\"}, {\"id\": \"1\", \"unit_name\": \"yard\", \"unit_symbol\": \"yd\"}]','0',NULL,'active',27,27,'2021-12-22 13:48:33','2021-12-17 11:07:24','2021-12-22 13:48:33'),(203,0,'Unit Type 2','[{\"id\": \"0\", \"unit_name\": \"yard 3\", \"unit_symbol\": \"yd^3\"}, {\"id\": \"1\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]','0',NULL,'active',27,27,'2021-12-22 13:48:33','2021-12-17 11:07:24','2021-12-22 13:48:33'),(204,0,'heat transfer coefficient','[{\"id\": \"0\", \"unit_name\": \"heat transfer coefficient\", \"unit_symbol\": null}]',NULL,NULL,'active',28,28,NULL,'2021-12-21 13:36:01','2021-12-21 13:36:01'),(205,0,'Vo thickness','[{\"id\": \"0\", \"unit_name\": \"mm\", \"unit_symbol\": \"mm\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 13:59:47','2021-12-22 13:59:47'),(206,0,'Tensile modulus','[{\"id\": \"0\", \"unit_name\": \"MPa\", \"unit_symbol\": \"MPa\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:00:28','2021-12-22 14:00:28'),(207,0,'Melt volume rate','[{\"id\": \"0\", \"unit_name\": \"cm3/10 mins\", \"unit_symbol\": \"cm3/10 mins\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:01:23','2021-12-22 14:01:23'),(208,0,'Izod Impact','[{\"id\": \"0\", \"unit_name\": \"kJ/m2\", \"unit_symbol\": \"kJ/m2\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:01:56','2021-12-22 14:01:56'),(209,0,'TFOT','[{\"id\": \"0\", \"unit_name\": \"seconds\", \"unit_symbol\": \"seconds\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:04:26','2021-12-22 14:04:26'),(210,0,'HDT','[{\"id\": \"0\", \"unit_name\": \"Celsius\", \"unit_symbol\": \"Celsius\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:05:14','2021-12-22 14:05:14'),(211,0,'Polymer weight','[{\"id\": \"0\", \"unit_name\": \"gram\", \"unit_symbol\": \"g\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:09:30','2021-12-22 14:09:30'),(212,0,'Polymer Density--densitydhpe020','[{\"id\": \"0\", \"unit_name\": \"gram/cm3\", \"unit_symbol\": \"g/cm3\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:10:19','2021-12-22 14:10:19'),(213,0,'Catalyst yield','[{\"id\": \"0\", \"unit_name\": \"kg/g\", \"unit_symbol\": \"kg/g\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:11:28','2021-12-22 14:11:28'),(214,0,'catalyst weight dosed','[{\"id\": \"0\", \"unit_name\": \"mg\", \"unit_symbol\": \"mg\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:12:05','2021-12-22 14:12:05'),(215,0,'Diluent volume hexane','[{\"id\": \"0\", \"unit_name\": \"liter\", \"unit_symbol\": \"liter\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:14:18','2021-12-22 14:14:18'),(216,0,'catalyst concentration','[{\"id\": \"0\", \"unit_name\": \"mg/ml\", \"unit_symbol\": \"mg/ml\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:14:51','2021-12-22 14:14:51'),(217,0,'Cocatalyst Reactor Concentration','[{\"id\": \"0\", \"unit_name\": \"mmol/l\", \"unit_symbol\": \"mmol/l\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:15:22','2021-12-22 14:15:22'),(218,0,'Catalyst Volume Dosed','[{\"id\": \"0\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:15:55','2021-12-22 14:15:55'),(219,0,'Cocatalyst Dosed Volume','[{\"id\": \"0\", \"unit_name\": \"ml\", \"unit_symbol\": \"ml\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:16:20','2021-12-22 14:16:20'),(220,0,'Ethylene Concentration Measured','[{\"id\": \"0\", \"unit_name\": \"mole %\", \"unit_symbol\": \"mole %\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:16:49','2021-12-22 14:16:49'),(221,0,'Hydrogen Average Concentration','[{\"id\": \"0\", \"unit_name\": \"mole %\", \"unit_symbol\": \"mole %\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:17:18','2021-12-22 14:17:18'),(222,0,'ethane Concentration','[{\"id\": \"1\", \"unit_name\": \"v %\", \"unit_symbol\": \"v %\"}]','0',NULL,'active',27,27,NULL,'2021-12-22 14:17:45','2021-12-22 14:26:15'),(223,0,'Butene Average Concentration','[{\"id\": \"0\", \"unit_name\": \"mole %\", \"unit_symbol\": \"mole %\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:18:13','2021-12-22 14:18:13'),(224,0,'ReactionTemperature_Average','[{\"id\": \"1\", \"unit_name\": \"C\", \"unit_symbol\": \"C\"}]','0',NULL,'active',27,27,NULL,'2021-12-22 14:18:52','2022-01-11 15:04:43'),(225,0,'Reaction Pressure','[{\"id\": \"0\", \"unit_name\": \"barg\", \"unit_symbol\": \"barg\"}]',NULL,NULL,'active',27,27,NULL,'2021-12-22 14:19:25','2021-12-22 14:19:25'),(226,0,'Volume oerlikon','[{\"id\": \"0\", \"unit_name\": \"m3\", \"unit_symbol\": \"m3\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:05:49','2021-12-23 12:05:49'),(227,0,'temperature oerlikon','[{\"id\": \"0\", \"unit_name\": \"Degree C\", \"unit_symbol\": \"Degree C\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:14:55','2021-12-23 12:14:55'),(228,0,'pressure oerlikon','[{\"id\": \"0\", \"unit_name\": \"bar\", \"unit_symbol\": \"bar\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:17:33','2021-12-23 12:17:33'),(229,0,'weight percentage oerlikon','[{\"id\": \"0\", \"unit_name\": \"w%\", \"unit_symbol\": \"w%\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:18:01','2021-12-23 12:18:01'),(230,0,'distance oerlikon','[{\"id\": \"0\", \"unit_name\": \"m\", \"unit_symbol\": \"m\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:18:37','2021-12-23 12:18:37'),(231,0,'distance oerlikon','[{\"id\": \"0\", \"unit_name\": \"m\", \"unit_symbol\": \"m\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:19:24','2021-12-23 12:19:24'),(232,0,'Throughput','[{\"id\": \"0\", \"unit_name\": \"t\", \"unit_symbol\": null}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:30:38','2021-12-23 12:30:38'),(233,0,'ppm','[{\"id\": \"0\", \"unit_name\": \"CatSpec\", \"unit_symbol\": null}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:33:10','2021-12-23 12:33:10'),(234,0,'EG massflow','[{\"id\": \"0\", \"unit_name\": \"kg/h\", \"unit_symbol\": \"kg/h\"}]',NULL,NULL,'active',28,28,NULL,'2021-12-23 12:51:38','2021-12-23 12:51:38'),(235,0,'reaction time','[{\"id\": \"0\", \"unit_name\": \"min\", \"unit_symbol\": \"min\"}]',NULL,NULL,'active',27,27,NULL,'2022-01-11 12:12:28','2022-01-11 12:12:28'),(236,0,'sap number,acid  number','[{\"id\": \"0\", \"unit_name\": \"sap number,acid  number\", \"unit_symbol\": null}]',NULL,NULL,'active',28,28,NULL,'2022-01-13 10:28:08','2022-01-13 10:28:08'),(237,0,'intrinsic viscosity','[{\"id\": \"0\", \"unit_name\": \"intrinsic viscosity\", \"unit_symbol\": null}]',NULL,NULL,'active',28,28,NULL,'2022-01-13 10:29:21','2022-01-13 10:29:21');
/*!40000 ALTER TABLE `master_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_02_04_000000_create_country_state_city_table',1),(2,'2014_10_12_000000_create_users_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_06_19_072641_create_vendors_table',1),(5,'2020_07_01_081349_create_chemicals_table',1),(6,'2020_07_02_072335_create_table_other_input_energy_utilities',1),(7,'2020_07_02_110257_create_table_energy_equipment',1),(8,'2020_07_02_141104_create_experiment_units_table',1),(9,'2020_07_04_121812_create_vendor_contact_details_table',1),(10,'2020_07_06_193806_create_process_simulations_table',1),(11,'2020_07_08_055723_create_table_reaction',1),(12,'2020_07_08_073108_create_process_experiments_table',1),(13,'2020_07_12_124512_create_activity_log_table',1),(14,'2020_07_13_063940_create_admin_tenants_table',1),(15,'2020_07_14_115142_create_user_menu_table',1),(16,'2020_07_21_052737_create_table_for_tenat_master_plan',1),(17,'2020_07_21_052923_create_table_for_tenat_master_organization_type',1),(18,'2020_07_21_081658_create_table_for_chemical_categories_table',1),(19,'2020_07_21_081730_create_table_for_chemical_classifications_table',1),(20,'2020_07_22_062257_create_table_for_unit_master',1),(21,'2020_07_22_112355_create_table_for_chemical_property_master',1),(22,'2020_07_23_074925_create_energy_utility_properties_table',1),(23,'2020_07_27_070447_create_table_for_chemical_sub_property_for_masters',1),(24,'2020_07_27_071222_create_table_for_process_types',1),(25,'2020_07_27_071947_create_table_for_process_status',1),(26,'2020_07_27_072015_create_table_for_process_category',1),(27,'2020_07_27_083710_create_vendor_categories_table',1),(28,'2020_07_27_091032_create_vendor_classifications_table',1),(29,'2020_07_27_110105_create_chemical_properties_table',1),(30,'2020_07_29_073204_create_table_for_energy_property_masters',1),(31,'2020_07_29_073225_create_table_for_energy_sub_property_masters',1),(32,'2020_07_29_110902_create_table_for_experiment_unit_image',1),(33,'2020_08_03_091137_create_table_for_category_list',1),(34,'2020_08_03_091356_create_table_for_classification_list',1),(35,'2020_08_04_072123_create_table_for_mfg_process_simulation_type',1),(36,'2020_08_05_071624_creeate_table_for_process_simulation_flow_type',1),(37,'2020_08_10_061940_create_product_systems_table',1),(38,'2020_08_10_071314_create_table_for_tenant_user',1),(39,'2020_08_11_062225_create_product_comparisons_table',1),(40,'2020_08_13_083512_create_process_simulation_reports_table',1),(41,'2020_08_17_071957_create_process_profiles_table',1),(42,'2020_08_29_083700_experiment_condition_master',1),(43,'2020_08_29_084132_experiment_outcome_master',1),(44,'2020_08_31_073354_create_table_for_models',1),(45,'2020_09_01_113834_create_table_for_vendor_location',1),(46,'2020_09_02_100510_create_table_for_model_files',1),(47,'2020_09_07_105940_create_knowledge_banks_table',1),(48,'2020_09_07_153713_periodi_table',1),(49,'2020_09_15_072743_create_equipment_units_table',1),(50,'2020_09_18_115930_create_table_for_reaction_properties',1),(51,'2020_09_21_132221_create_experiment_categories_table',1),(52,'2020_09_21_132243_create_experiment_classifications_table',1),(53,'2020_09_22_001945_create_product_system_profiles_table',1),(54,'2020_10_06_103922_create_table_for_hazard_class',1),(55,'2020_10_06_104255_create_table_for_hazard_pictogram',1),(56,'2020_10_06_104410_create_table_for_hazards',1),(57,'2020_10_06_104513_create_table_for_code_statements',1),(58,'2020_10_08_153201_create_process_exp_profiles_table',1),(59,'2020_10_09_123839_create_process_exp_profile_masters_table',1),(60,'2020_10_12_110042_create_table_for_hazard_category',1),(61,'2020_10_13_180726_create_table_hazard_code_type',1),(62,'2020_10_13_181314_create_table_hazard_sub_code_type',1),(63,'2020_11_23_165642_create_product_creations_table',1),(64,'2020_12_31_104110_list_products',1),(65,'2021_01_07_170039_create_table_for_currencry',1),(66,'2021_01_11_143217_create_table_for_product_type',1),(67,'2021_01_22_170343_create_process_diagrams_table',1),(68,'2021_01_29_155622_create_process_exp_energy_flows_table',1),(69,'2021_02_22_165959_create_table_for_regulatory_lists',1),(70,'2021_03_01_143101_create_table_time_zones',1),(71,'2021_03_01_172716_create_table_for_reaction_type',1),(72,'2021_03_01_172747_create_table_for_reaction_phases',1),(73,'2021_03_05_115806_create_table_for_criteria_master',1),(74,'2021_03_05_115833_create_table_for_priority_master',1),(75,'2021_05_01_140115_create_experiment_reports_table',1),(76,'2021_05_18_131316_create_notifications_table',1),(77,'2021_06_01_135733_create_process_analysis_reports_table',1),(78,'2021_06_02_130153_create_process_comaprisons_table',1),(79,'2021_06_03_113724_create_product_system_reports_table',1),(80,'2021_06_03_113803_create_product_system_comparsion_reports_table',1),(81,'2021_06_09_150658_create_table_for_db_backup',1),(82,'2021_06_16_232542_create_jobs_table',1),(83,'2021_07_07_164521_create_user_tickets_table',1),(84,'2021_07_15_113254_create_table_for_user_permissions',1),(85,'2021_07_27_154128_create_associated_models_table',1),(86,'2021_07_28_163514_create_dataset_models_table',1),(87,'2021_07_28_174753_create_data_request_models_table',1),(88,'2021_08_07_133119_create_table_for_simulate_inputes',1),(89,'2021_08_08_104130_create_table_for_variation',1),(90,'2021_08_17_134952_create_table_tenant_config',1),(91,'2021_09_20_110220_tolerance_reposts',1),(92,'2021_09_27_161342_crate_table_for_mac_address',1),(93,'2021_11_12_110143_create_table_for_project',1),(94,'2021_11_18_130003_create_table_for_data_management_data_sets',1),(95,'2021_11_18_154508_create_table_for_data_management_data_curation',1),(96,'2021_12_03_180747_create_table_curation_rule',1),(97,'2022_01_04_124835_create_tavle_blog',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_details`
--

DROP TABLE IF EXISTS `model_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `version` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `association` json DEFAULT NULL,
  `recommendations` json DEFAULT NULL,
  `list_of_models` json DEFAULT NULL,
  `assumptions` json DEFAULT NULL,
  `files` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `process_experiment_id` int NOT NULL DEFAULT '0',
  `model_type` int NOT NULL DEFAULT '0',
  `configuration` int NOT NULL DEFAULT '0',
  `flag` int NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('requested','under_process','processed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'requested',
  `operation_status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_details`
--

LOCK TABLES `model_details` WRITE;
/*!40000 ALTER TABLE `model_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_files`
--

DROP TABLE IF EXISTS `model_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_files` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `model_id` bigint DEFAULT NULL,
  `file_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_files`
--

LOCK TABLES `model_files` WRITE;
/*!40000 ALTER TABLE `model_files` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tenant_id` int NOT NULL DEFAULT '0',
  `type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periodic_tables`
--

DROP TABLE IF EXISTS `periodic_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `periodic_tables` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `atomic_no` bigint DEFAULT NULL,
  `element_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `element_sc` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `element_weight` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periodic_tables`
--

LOCK TABLES `periodic_tables` WRITE;
/*!40000 ALTER TABLE `periodic_tables` DISABLE KEYS */;
/*!40000 ALTER TABLE `periodic_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `priority_masters`
--

DROP TABLE IF EXISTS `priority_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `priority_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `priority_masters`
--

LOCK TABLES `priority_masters` WRITE;
/*!40000 ALTER TABLE `priority_masters` DISABLE KEYS */;
INSERT INTO `priority_masters` VALUES (1,0,'High','High','active',2,2,NULL,'2021-03-05 12:26:28','2021-03-05 12:55:56'),(2,0,'Medium','Medium','active',2,2,NULL,'2021-03-05 12:56:07','2021-03-05 12:56:07'),(3,0,'Low','Low','active',2,2,NULL,'2021-03-05 12:56:25','2021-03-05 12:56:25'),(5,3,'High',NULL,'active',27,27,NULL,'2021-12-08 12:54:43','2021-12-08 14:03:54'),(6,5,'High','High','active',28,28,NULL,'2021-12-24 17:13:02','2021-12-24 17:13:02'),(7,5,'Medium','Medium','active',28,28,NULL,'2021-12-24 17:13:18','2021-12-24 17:13:18'),(8,5,'Low','Low','active',28,28,NULL,'2021-12-24 17:13:40','2021-12-24 17:13:40'),(9,6,'High','High','active',28,28,NULL,'2021-12-24 17:24:35','2021-12-24 17:24:35'),(10,6,'Medium','Medium','active',28,28,NULL,'2021-12-24 17:24:48','2021-12-24 17:24:48'),(11,6,'Low','Low','active',28,28,NULL,'2021-12-24 17:24:59','2021-12-24 17:24:59');
/*!40000 ALTER TABLE `priority_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_analysis_reports`
--

DROP TABLE IF EXISTS `process_analysis_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_analysis_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `report_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `simulation_type` int NOT NULL,
  `process_simulation_id` int NOT NULL,
  `main_feedstock` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_product` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mass_balance` int NOT NULL DEFAULT '0',
  `energy_balance` int NOT NULL DEFAULT '0',
  `output_data` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_analysis_reports`
--

LOCK TABLES `process_analysis_reports` WRITE;
/*!40000 ALTER TABLE `process_analysis_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_analysis_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_categories`
--

DROP TABLE IF EXISTS `process_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_categories`
--

LOCK TABLES `process_categories` WRITE;
/*!40000 ALTER TABLE `process_categories` DISABLE KEYS */;
INSERT INTO `process_categories` VALUES (1,0,'Published Lab','This is Published Lab','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(2,0,'Internal Lab','This Internal Lab','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(3,0,'Conceptual','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(4,0,'Optimized','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(5,0,'Stoichiometric','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19');
/*!40000 ALTER TABLE `process_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_comaprisons`
--

DROP TABLE IF EXISTS `process_comaprisons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_comaprisons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `report_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `simulation_type` int NOT NULL,
  `process_simulation_ids` json NOT NULL,
  `mass_balance` int NOT NULL DEFAULT '0',
  `energy_balance` int NOT NULL DEFAULT '0',
  `output_data` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `specify_weights` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_comaprisons`
--

LOCK TABLES `process_comaprisons` WRITE;
/*!40000 ALTER TABLE `process_comaprisons` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_comaprisons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_diagrams`
--

DROP TABLE IF EXISTS `process_diagrams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_diagrams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_id` int NOT NULL,
  `flowtype` int NOT NULL,
  `from_unit` json DEFAULT NULL,
  `to_unit` json DEFAULT NULL,
  `openstream` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_diagrams`
--

LOCK TABLES `process_diagrams` WRITE;
/*!40000 ALTER TABLE `process_diagrams` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_diagrams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_exp_energy_flows`
--

DROP TABLE IF EXISTS `process_exp_energy_flows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_exp_energy_flows` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `stream_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_id` int NOT NULL,
  `experiment_unit_id` int NOT NULL,
  `energy_utility_id` int NOT NULL,
  `stream_flowtype` int NOT NULL,
  `input_output` int NOT NULL DEFAULT '0',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_exp_energy_flows`
--

LOCK TABLES `process_exp_energy_flows` WRITE;
/*!40000 ALTER TABLE `process_exp_energy_flows` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_exp_energy_flows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_exp_profile_masters`
--

DROP TABLE IF EXISTS `process_exp_profile_masters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_exp_profile_masters` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_exp_id` int NOT NULL,
  `condition` json DEFAULT NULL,
  `outcome` json DEFAULT NULL,
  `reaction` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_exp_profile_masters`
--

LOCK TABLES `process_exp_profile_masters` WRITE;
/*!40000 ALTER TABLE `process_exp_profile_masters` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_exp_profile_masters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_exp_profiles`
--

DROP TABLE IF EXISTS `process_exp_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_exp_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_exp_id` int NOT NULL,
  `variation_id` int NOT NULL DEFAULT '0',
  `experiment_unit` int NOT NULL,
  `condition` json DEFAULT NULL,
  `outcome` json DEFAULT NULL,
  `reaction` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_exp_profiles`
--

LOCK TABLES `process_exp_profiles` WRITE;
/*!40000 ALTER TABLE `process_exp_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_exp_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_experiments`
--

DROP TABLE IF EXISTS `process_experiments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_experiments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `project_id` int NOT NULL DEFAULT '0',
  `process_experiment_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  `experiment_unit` json DEFAULT NULL,
  `classification_id` json NOT NULL,
  `chemical` json NOT NULL,
  `data_source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `main_product_input` json NOT NULL,
  `main_product_output` json NOT NULL,
  `energy_id` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_experiments`
--

LOCK TABLES `process_experiments` WRITE;
/*!40000 ALTER TABLE `process_experiments` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_experiments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_profiles`
--

DROP TABLE IF EXISTS `process_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `process_id` int NOT NULL,
  `simulation_type` int NOT NULL,
  `mass_basic_io` json DEFAULT NULL,
  `mass_basic_pc` json DEFAULT NULL,
  `mass_basic_pd` json DEFAULT NULL,
  `energy_basic_io` json DEFAULT NULL,
  `energy_process_level` json DEFAULT NULL,
  `energy_detailed_level` json DEFAULT NULL,
  `equipment_capital_cost` json DEFAULT NULL,
  `key_process_info` json DEFAULT NULL,
  `quality_assesment` json DEFAULT NULL,
  `data_source_mass` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `data_source_energy` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_profiles`
--

LOCK TABLES `process_profiles` WRITE;
/*!40000 ALTER TABLE `process_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_simulation_reports`
--

DROP TABLE IF EXISTS `process_simulation_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_simulation_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `report_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_type` enum('standard','custom') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `process_simulation_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `simulation_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_simulation_reports`
--

LOCK TABLES `process_simulation_reports` WRITE;
/*!40000 ALTER TABLE `process_simulation_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_simulation_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_simulations`
--

DROP TABLE IF EXISTS `process_simulations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_simulations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `process_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_type` int DEFAULT NULL,
  `product` json NOT NULL,
  `energy` json DEFAULT NULL,
  `main_feedstock` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `simulation_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `main_product` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process_category` int DEFAULT NULL,
  `process_status` int DEFAULT NULL,
  `sim_stage` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `knowledge_bank` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_simulations`
--

LOCK TABLES `process_simulations` WRITE;
/*!40000 ALTER TABLE `process_simulations` DISABLE KEYS */;
/*!40000 ALTER TABLE `process_simulations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_statuses`
--

DROP TABLE IF EXISTS `process_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_statuses` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_statuses`
--

LOCK TABLES `process_statuses` WRITE;
/*!40000 ALTER TABLE `process_statuses` DISABLE KEYS */;
INSERT INTO `process_statuses` VALUES (1,0,'Data Report','Data Report','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(2,0,'Data Input','Data Input','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(3,0,'Data Verification','Data Verification','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(4,0,'Data Iteration','Data Iteration','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19');
/*!40000 ALTER TABLE `process_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process_types`
--

DROP TABLE IF EXISTS `process_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `process_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process_types`
--

LOCK TABLES `process_types` WRITE;
/*!40000 ALTER TABLE `process_types` DISABLE KEYS */;
INSERT INTO `process_types` VALUES (1,0,'Bio Based','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(2,0,'Fossil Based','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(3,0,'Mixed','','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19');
/*!40000 ALTER TABLE `process_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_comparisons`
--

DROP TABLE IF EXISTS `product_comparisons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_comparisons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `comparison_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `product_system` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_comparisons`
--

LOCK TABLES `product_comparisons` WRITE;
/*!40000 ALTER TABLE `product_comparisons` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_comparisons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_creations`
--

DROP TABLE IF EXISTS `product_creations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_creations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `process_id` int DEFAULT NULL,
  `simulation_type` int DEFAULT NULL,
  `new_product_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `stream_id` int DEFAULT NULL,
  `datasource` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_creations`
--

LOCK TABLES `product_creations` WRITE;
/*!40000 ALTER TABLE `product_creations` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_creations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_system_comparsion_reports`
--

DROP TABLE IF EXISTS `product_system_comparsion_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_system_comparsion_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `report_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_system_id` int NOT NULL,
  `tags` json DEFAULT NULL,
  `output_data` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_system_comparsion_reports`
--

LOCK TABLES `product_system_comparsion_reports` WRITE;
/*!40000 ALTER TABLE `product_system_comparsion_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_system_comparsion_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_system_profiles`
--

DROP TABLE IF EXISTS `product_system_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_system_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `product_system_id` int NOT NULL,
  `process_id` int NOT NULL,
  `product_input` json DEFAULT NULL,
  `product_output` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_system_profiles`
--

LOCK TABLES `product_system_profiles` WRITE;
/*!40000 ALTER TABLE `product_system_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_system_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_system_reports`
--

DROP TABLE IF EXISTS `product_system_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_system_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `report_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `report_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_system_id` int NOT NULL,
  `process_simulation_ids` json NOT NULL,
  `number_of_process` int NOT NULL DEFAULT '0',
  `output_data` json DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_system_reports`
--

LOCK TABLES `product_system_reports` WRITE;
/*!40000 ALTER TABLE `product_system_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_system_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_systems`
--

DROP TABLE IF EXISTS `product_systems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_systems` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `process` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_systems`
--

LOCK TABLES `product_systems` WRITE;
/*!40000 ALTER TABLE `product_systems` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_systems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (1,'Commercial',NULL,'active',2,2,NULL,'2021-01-11 15:30:40','2021-01-11 15:30:40'),(2,'Generic',NULL,'active',2,2,NULL,'2021-01-11 15:30:49','2021-01-11 15:30:49');
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `location` json DEFAULT NULL,
  `users` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction_phases`
--

DROP TABLE IF EXISTS `reaction_phases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction_phases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction_phases`
--

LOCK TABLES `reaction_phases` WRITE;
/*!40000 ALTER TABLE `reaction_phases` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaction_phases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction_properties`
--

DROP TABLE IF EXISTS `reaction_properties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction_properties` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `reaction_id` bigint DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('rate_parameter','equilibrium') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'rate_parameter',
  `sub_type` enum('user_input','calculation') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user_input',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction_properties`
--

LOCK TABLES `reaction_properties` WRITE;
/*!40000 ALTER TABLE `reaction_properties` DISABLE KEYS */;
/*!40000 ALTER TABLE `reaction_properties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reaction_types`
--

DROP TABLE IF EXISTS `reaction_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reaction_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reaction_types`
--

LOCK TABLES `reaction_types` WRITE;
/*!40000 ALTER TABLE `reaction_types` DISABLE KEYS */;
INSERT INTO `reaction_types` VALUES (1,0,'Irreversible','Irreversible','active',2,2,NULL,'2021-03-02 11:20:51','2021-03-02 11:35:51'),(2,0,'Reversible','Reversible','active',2,2,NULL,'2021-03-02 11:36:07','2021-03-02 11:36:07');
/*!40000 ALTER TABLE `reaction_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reactions`
--

DROP TABLE IF EXISTS `reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `reaction_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reaction_source` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reaction_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tags` json DEFAULT NULL,
  `reactant_component` json DEFAULT NULL,
  `product_component` json DEFAULT NULL,
  `chemical_reaction_left` json DEFAULT NULL,
  `chemical_reaction_right` json DEFAULT NULL,
  `reaction_reactant` json DEFAULT NULL,
  `reaction_product` json DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `balance` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reactions`
--

LOCK TABLES `reactions` WRITE;
/*!40000 ALTER TABLE `reactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `reactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regulatory_lists`
--

DROP TABLE IF EXISTS `regulatory_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regulatory_lists` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `list_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `color_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_hazard_code` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `region` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `compilation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `match_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `csv_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hazard_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_of_list` int DEFAULT NULL,
  `source_file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `converted_file` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hover_msg` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `field_of_display` json DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regulatory_lists`
--

LOCK TABLES `regulatory_lists` WRITE;
/*!40000 ALTER TABLE `regulatory_lists` DISABLE KEYS */;
/*!40000 ALTER TABLE `regulatory_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulate_inputs`
--

DROP TABLE IF EXISTS `simulate_inputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulate_inputs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experiment_id` int NOT NULL DEFAULT '0',
  `variation_id` int NOT NULL DEFAULT '0',
  `simulate_input_type` enum('reverse','forward') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'forward',
  `raw_material` json DEFAULT NULL,
  `master_condition` json DEFAULT NULL,
  `master_outcome` json DEFAULT NULL,
  `unit_condition` json DEFAULT NULL,
  `unit_outcome` json DEFAULT NULL,
  `simulation_type` json DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `note_urls` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulate_inputs`
--

LOCK TABLES `simulate_inputs` WRITE;
/*!40000 ALTER TABLE `simulate_inputs` DISABLE KEYS */;
/*!40000 ALTER TABLE `simulate_inputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `simulation_types`
--

DROP TABLE IF EXISTS `simulation_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `simulation_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `simulation_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mass_balance` json DEFAULT NULL,
  `enery_utilities` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `simulation_types`
--

LOCK TABLES `simulation_types` WRITE;
/*!40000 ALTER TABLE `simulation_types` DISABLE KEYS */;
INSERT INTO `simulation_types` VALUES (1,0,'Early 1','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}]','[]','This is simulation type Early 1 ','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(2,0,'Early 2','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}]','[]','This is simulation type Early 2','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(3,0,'Early 3','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}, {\"id\": 3, \"data_source\": \"Process Detailed\"}]','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Utility-Process Level\"}, {\"id\": 3, \"data_source\": \"Utility-Detailed Level\"}]','This is simulation type Early 3','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(4,0,'Process First','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}, {\"id\": 3, \"data_source\": \"Process Detailed\"}]','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Utility-Process Level\"}, {\"id\": 3, \"data_source\": \"Utility-Detailed Level\"}]','This is simulation type Process First','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(5,0,'Process Sim','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}, {\"id\": 3, \"data_source\": \"Process Detailed\"}]','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Utility-Process Level\"}, {\"id\": 3, \"data_source\": \"Utility-Detailed Level\"}]','This is simulation type Process Sim','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19'),(6,0,'Plant Data','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Process Chemistry\"}, {\"id\": 3, \"data_source\": \"Process Detailed\"}]','[{\"id\": 1, \"data_source\": \"Basic User Input\"}, {\"id\": 2, \"data_source\": \"Utility-Process Level\"}, {\"id\": 3, \"data_source\": \"Utility-Detailed Level\"}]','This is simulation type Plan Data','active',1,1,NULL,'2021-12-01 14:53:19','2021-12-01 14:53:19');
/*!40000 ALTER TABLE `simulation_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenant_configs`
--

DROP TABLE IF EXISTS `tenant_configs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenant_configs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `number_of_users` bigint NOT NULL DEFAULT '0',
  `two_factor_auth` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `menu_group` json DEFAULT NULL,
  `location` json DEFAULT NULL,
  `user_group` json DEFAULT NULL,
  `designation` json DEFAULT NULL,
  `user_permission` json DEFAULT NULL,
  `user_settings` json DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenant_configs`
--

LOCK TABLES `tenant_configs` WRITE;
/*!40000 ALTER TABLE `tenant_configs` DISABLE KEYS */;
INSERT INTO `tenant_configs` VALUES (1,1,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[{\"id\": 1, \"city\": \"Berlin\", \"state\": \"Berlin State\", \"status\": \"active\", \"address\": \"sadaf\", \"pincode\": \"202020\", \"country_id\": 82, \"location_name\": \"Tenant First Location\"}, {\"id\": 2, \"city\": \"Bengaluru\", \"state\": \"Karnataka\", \"status\": \"active\", \"address\": \"dsfdf\", \"pincode\": \"560078\", \"country_id\": 101, \"location_name\": \"Tenant Second Location\"}]','[{\"id\": 1, \"name\": \"Group1\", \"users\": [62, 61, 26], \"status\": \"active\", \"description\": \"Group1\", \"designation\": \"\"}, {\"id\": 2, \"name\": \"Group2\", \"users\": [24], \"status\": \"active\", \"description\": \"Group1\", \"designation\": \"\"}, {\"id\": 3, \"name\": \"group123\", \"users\": [30, 29], \"status\": \"active\", \"description\": \"desc\", \"designation\": \"\"}, {\"id\": 4, \"name\": \"BASIC\", \"users\": [45], \"status\": \"active\", \"description\": \"desc\", \"designation\": \"\"}, {\"id\": 5, \"name\": \"G1\", \"users\": [69], \"status\": \"active\", \"description\": null, \"designation\": 0}]','{\"0\": {\"id\": 1, \"name\": \"Designation1\", \"status\": \"active\", \"description\": \"Designation2\"}, \"2\": {\"id\": 3, \"name\": \"Tester\", \"status\": \"active\", \"description\": null}, \"3\": {\"id\": 4, \"name\": \"Developer\", \"status\": \"active\", \"description\": null}}','[]','{\"0\": {\"id\": 26, \"lang\": \"\", \"user_id\": 26, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"1\": {\"id\": 29, \"lang\": \"\", \"user_id\": 29, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"2\": {\"id\": 30, \"lang\": \"\", \"user_id\": 30, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"3\": {\"id\": 45, \"lang\": \"\", \"user_id\": 45, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"4\": {\"id\": 61, \"lang\": \"\", \"user_id\": 61, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"5\": {\"id\": 62, \"lang\": \"\", \"user_id\": 62, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"6\": {\"id\": 69, \"lang\": \"\", \"user_id\": 69, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"id\": 1, \"lang\": \"\", \"user_id\": 23, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}','active',1,61,NULL,'2021-08-31 13:42:54','2022-01-17 12:31:39'),(2,2,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[{\"id\": 1, \"city\": \"Berlin\", \"state\": \"Berlin State\", \"status\": \"active\", \"address\": \"sadaf\", \"pincode\": \"202020\", \"country_id\": 82, \"location_name\": \"Tenant First Location\"}, {\"id\": 2, \"city\": \"Bengaluru\", \"state\": \"Karnataka\", \"status\": \"active\", \"address\": \"dsfdf\", \"pincode\": \"560078\", \"country_id\": 101, \"location_name\": \"Tenant Second Location\"}]','[{\"id\": 1, \"name\": \"Group3\", \"status\": \"active\", \"description\": \"Group3\"}, {\"id\": 2, \"name\": \"Group4\", \"status\": \"active\", \"description\": \"Group4\"}]','[{\"id\": 1, \"name\": \"Designation3\", \"status\": \"active\", \"description\": \"Designation3\"}, {\"id\": 2, \"name\": \"Designation4\", \"status\": \"active\", \"description\": \"Designation4\"}]','[]','{\"0\": {\"id\": 26, \"lang\": \"\", \"user_id\": 26, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, \"id\": 1, \"lang\": \"\", \"user_id\": 23, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}','active',1,1,NULL,'2021-08-31 13:42:54','2021-11-24 14:57:43'),(3,3,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[{\"id\": 1, \"city\": \"Bangalore\", \"state\": \"Karnataka\", \"status\": \"active\", \"address\": null, \"pincode\": \"520007\", \"country_id\": 101, \"location_name\": \"Bangalore\"}, {\"id\": 2, \"city\": \"ertr\", \"state\": \"rtedr\", \"status\": \"active\", \"address\": null, \"pincode\": \"12344556565656\", \"country_id\": 82, \"location_name\": \"trtr\"}]','[{\"id\": 1, \"name\": \"Group\", \"users\": [58, 57], \"status\": \"active\", \"description\": null, \"designation\": 0}]','[{\"id\": 1, \"name\": \"Tester\", \"status\": \"active\", \"description\": null}, {\"id\": 2, \"name\": \"Developer\", \"status\": \"active\", \"description\": null}]','[]','[{\"id\": 31, \"lang\": \"\", \"user_id\": 31, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 34, \"lang\": \"\", \"user_id\": 34, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 35, \"lang\": \"\", \"user_id\": 35, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 36, \"lang\": \"\", \"user_id\": 36, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 37, \"lang\": \"\", \"user_id\": 37, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 38, \"lang\": \"\", \"user_id\": 38, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 39, \"lang\": \"\", \"user_id\": 39, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 46, \"lang\": \"\", \"user_id\": 46, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 47, \"lang\": \"\", \"user_id\": 47, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 48, \"lang\": \"\", \"user_id\": 48, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 49, \"lang\": \"\", \"user_id\": 49, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 57, \"lang\": \"\", \"user_id\": 57, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 58, \"lang\": \"\", \"user_id\": 58, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',27,27,NULL,'2021-12-02 10:04:57','2021-12-29 09:55:30'),(4,4,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\"], \"description\": null}','[]','[]','[]','[]','[{\"id\": 32, \"lang\": \"\", \"user_id\": 32, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',27,27,'2021-12-03 14:19:58','2021-12-02 10:06:23','2021-12-03 14:19:58'),(5,5,30,'true','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[{\"id\": 1, \"name\": \"user group1\", \"users\": [60], \"status\": \"active\", \"description\": null, \"designation\": 0}]','[]','[]','[{\"id\": 40, \"lang\": \"\", \"user_id\": 40, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 50, \"lang\": \"\", \"user_id\": 50, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 51, \"lang\": \"\", \"user_id\": 51, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 60, \"lang\": \"\", \"user_id\": 60, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',28,2,NULL,'2021-12-02 17:36:05','2022-01-05 12:56:41'),(6,6,30,'true','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[]','[]','[]','[{\"id\": 41, \"lang\": \"\", \"user_id\": 41, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',28,28,NULL,'2021-12-02 17:37:32','2021-12-28 16:35:50'),(7,7,30,'true','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[]','[]','[]','[{\"id\": 42, \"lang\": \"\", \"user_id\": 42, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 52, \"lang\": \"\", \"user_id\": 52, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',28,28,NULL,'2021-12-02 17:39:03','2021-12-28 16:35:54'),(8,8,30,'true','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[{\"id\": 1, \"name\": \"oerlikon group\", \"users\": [53, 43], \"status\": \"active\", \"description\": null, \"designation\": 0}]','[]','[]','[{\"id\": 43, \"lang\": \"\", \"user_id\": 43, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 53, \"lang\": \"\", \"user_id\": 53, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',28,28,NULL,'2021-12-02 17:43:20','2021-12-28 16:35:58'),(9,9,30,'true','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[{\"id\": 1, \"name\": \"Group1\", \"users\": [56], \"status\": \"active\", \"description\": null, \"designation\": 0}, {\"id\": 2, \"name\": \"Group2\", \"users\": [55, 54], \"status\": \"active\", \"description\": null, \"designation\": 0}]','[{\"id\": 1, \"name\": \"Designation1\", \"status\": \"active\", \"description\": \"Designation2\"}, {\"id\": 2, \"name\": \"Designation2\", \"status\": \"active\", \"description\": \"Designation2\"}]','[]','[{\"id\": 44, \"lang\": \"\", \"user_id\": 44, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 54, \"lang\": \"\", \"user_id\": 54, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 55, \"lang\": \"\", \"user_id\": 55, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}, {\"id\": 56, \"lang\": \"\", \"user_id\": 56, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',28,28,NULL,'2021-12-02 17:44:41','2021-12-28 16:36:03'),(10,10,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\", \"2\", \"3\", \"4\", \"5\", \"6\", \"7\", \"8\", \"9\", \"10\", \"11\", \"12\", \"13\", \"14\", \"15\", \"16\", \"17\", \"18\", \"19\", \"20\", \"21\", \"22\", \"23\", \"24\", \"25\", \"26\", \"27\", \"28\", \"29\"], \"description\": null}','[]','[]','[]','[]','[{\"id\": 67, \"lang\": \"\", \"user_id\": 67, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',1,1,NULL,'2022-01-12 12:15:18','2022-01-12 12:16:13'),(11,11,30,'false','{\"id\": 1, \"name\": \"Basic\", \"status\": \"active\", \"menu_list\": [\"1\"], \"description\": null}','[]','[]','[]','[]','[{\"id\": 68, \"lang\": \"\", \"user_id\": 68, \"currency\": \"\", \"timezome\": \"\", \"dateformat\": \"\", \"profile_img\": \"\", \"email_notification\": \"\"}]','active',7,7,NULL,'2022-01-12 17:13:53','2022-01-12 17:13:53');
/*!40000 ALTER TABLE `tenant_configs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenant_master_plans`
--

DROP TABLE IF EXISTS `tenant_master_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenant_master_plans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenant_master_plans`
--

LOCK TABLES `tenant_master_plans` WRITE;
/*!40000 ALTER TABLE `tenant_master_plans` DISABLE KEYS */;
INSERT INTO `tenant_master_plans` VALUES (1,'15 Days Trail','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(2,'30 Days Trail','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(3,'Monthly Subscription','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(4,'Yearly Subscription','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(5,'Simreka Demo','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17');
/*!40000 ALTER TABLE `tenant_master_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenant_master_types`
--

DROP TABLE IF EXISTS `tenant_master_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenant_master_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenant_master_types`
--

LOCK TABLES `tenant_master_types` WRITE;
/*!40000 ALTER TABLE `tenant_master_types` DISABLE KEYS */;
INSERT INTO `tenant_master_types` VALUES (1,0,'Academic Institute',NULL,'active',1,28,NULL,'2021-12-01 18:23:17','2022-01-12 16:43:59'),(2,0,'Commercial Entity','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(3,0,'Independent Consultant',NULL,'active',1,28,NULL,'2021-12-01 18:23:17','2022-01-12 16:53:41'),(4,0,'Non-Profit Organization','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(5,0,'Simreka Demo',NULL,'active',1,28,NULL,'2021-12-01 18:23:17','2022-01-12 17:18:32'),(6,0,'Research Organization','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17'),(7,0,'Other','','active',1,1,NULL,'2021-12-01 18:23:17','2021-12-01 18:23:17');
/*!40000 ALTER TABLE `tenant_master_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenant_users`
--

DROP TABLE IF EXISTS `tenant_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenant_users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` bigint DEFAULT NULL,
  `user_id` bigint DEFAULT NULL,
  `designation_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenant_users`
--

LOCK TABLES `tenant_users` WRITE;
/*!40000 ALTER TABLE `tenant_users` DISABLE KEYS */;
INSERT INTO `tenant_users` VALUES (1,1,23,0,'2021-08-31 13:42:53','2021-08-31 13:42:53'),(2,1,24,0,'2021-08-31 17:39:57','2021-08-31 17:39:57'),(3,1,25,0,'2021-08-31 17:41:10','2021-08-31 17:41:10'),(4,1,26,0,'2021-08-31 17:41:52','2021-08-31 17:41:52'),(5,1,29,1,'2021-12-01 18:46:00','2021-12-01 18:46:00'),(6,1,30,0,'2021-12-01 18:46:52','2021-12-01 18:46:52'),(7,3,31,0,'2021-12-02 10:04:57','2021-12-02 10:04:57'),(8,4,32,0,'2021-12-02 10:06:23','2021-12-02 10:06:23'),(16,6,41,0,'2021-12-02 17:37:32','2021-12-02 17:37:32'),(17,7,42,0,'2021-12-02 17:39:03','2021-12-02 17:39:03'),(18,8,43,0,'2021-12-02 17:43:20','2021-12-02 17:43:20'),(19,9,44,0,'2021-12-02 17:44:41','2021-12-02 17:44:41'),(20,1,45,0,'2021-12-03 16:55:26','2021-12-03 16:56:19'),(25,5,50,0,'2021-12-21 17:42:50','2021-12-21 17:42:50'),(26,5,51,0,'2021-12-21 17:46:13','2021-12-21 17:46:13'),(27,7,52,0,'2021-12-22 15:00:27','2021-12-22 15:00:27'),(28,8,53,0,'2021-12-24 11:50:24','2021-12-24 11:50:24'),(29,9,54,0,'2021-12-24 14:32:19','2021-12-24 14:32:19'),(30,9,55,0,'2021-12-24 14:33:10','2021-12-24 14:33:10'),(31,9,56,0,'2021-12-24 14:33:50','2021-12-24 14:33:50'),(32,3,57,0,'2021-12-28 11:20:49','2021-12-28 11:20:49'),(33,3,58,0,'2021-12-28 11:21:17','2021-12-28 11:21:17'),(34,5,60,0,'2022-01-05 12:33:01','2022-01-05 12:56:14'),(35,1,61,0,'2022-01-05 16:54:20','2022-01-05 16:54:20'),(36,1,62,0,'2022-01-05 17:41:36','2022-01-05 17:41:36'),(37,10,67,0,'2022-01-12 12:15:18','2022-01-12 12:15:18'),(38,11,68,0,'2022-01-12 17:13:53','2022-01-12 17:13:53'),(39,1,69,0,'2022-01-17 10:47:24','2022-01-17 10:47:24');
/*!40000 ALTER TABLE `tenant_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int DEFAULT NULL,
  `plan_type` int DEFAULT NULL,
  `account_details` json DEFAULT NULL,
  `billing_information` json DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `guide_document` json DEFAULT NULL,
  `note` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `ldap_auth` enum('on','off') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'off',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,'Simreka ',3,3,'{\"city\": \"Lucknow\", \"state\": \"Lucknow\", \"address\": \"Lucknow\", \"pincode\": \"226020\", \"country_id\": 101, \"account_name\": \"23455432\", \"billing_email\": \"2ewrewwr12345\", \"billing_phone_no\": \"(+23) 4532-3432-34\", \"organization_logo\": \"\", \"billing_start_from\": \"27/08/2021\"}','{\"city\": \"Lucknow\", \"state\": \"Lucknow\", \"tax_id\": \"32324242\", \"address\": \"Lucknow\", \"pincode\": \"226020\", \"country_id\": 101, \"account_name\": \"23455432\", \"billing_email\": \"2ewrewwr12345\", \"billing_phone_no\": \"(+23) 4532-3432-34\"}','test',NULL,NULL,'tets','active','off',1,1,NULL,'2021-08-31 13:42:53','2021-08-31 13:42:53'),(2,'Simreka Germany',3,3,'{\"city\": \"Lucknow\", \"state\": \"Lucknow\", \"address\": \"Lucknow\", \"pincode\": \"226020\", \"country_id\": 101, \"account_name\": \"23455432\", \"billing_email\": \"2ewrewwr12345\", \"billing_phone_no\": \"(+23) 4532-3432-34\", \"organization_logo\": \"\", \"billing_start_from\": \"27/08/2021\"}','{\"city\": \"Lucknow\", \"state\": \"Lucknow\", \"tax_id\": \"32324242\", \"address\": \"Lucknow\", \"pincode\": \"226020\", \"country_id\": 101, \"account_name\": \"23455432\", \"billing_email\": \"2ewrewwr12345\", \"billing_phone_no\": \"(+23) 4532-3432-34\"}','test',NULL,NULL,'tets','active','off',1,1,NULL,'2021-08-31 13:42:53','2021-08-31 13:42:53'),(3,'Organization1',3,3,'{\"country_id\": 0, \"account_name\": \"asdasdsad\", \"billing_email\": \"dasdasd\", \"billing_phone_no\": \"(+32) 3153-3777-99\", \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": null, \"state\": null, \"tax_id\": null, \"address\": null, \"pincode\": null, \"country_id\": 0}',NULL,NULL,NULL,NULL,'active','off',27,27,NULL,'2021-12-02 10:04:56','2021-12-02 10:04:56'),(4,'Organization2',3,3,'{\"country_id\": 0, \"account_name\": \"sdfefew232\", \"billing_email\": \"dfdggrr\", \"billing_phone_no\": \"(+12) 3568-8899-14\", \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": null, \"state\": null, \"tax_id\": null, \"address\": null, \"pincode\": null, \"country_id\": 0}',NULL,NULL,NULL,NULL,'active','off',27,27,'2021-12-03 14:19:58','2021-12-02 10:06:23','2021-12-03 14:19:58'),(5,'H2Pro',5,3,'{\"country_id\": 101, \"account_name\": \"acc\", \"billing_email\": null, \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": \"district1\", \"state\": \"district1\", \"tax_id\": null, \"address\": null, \"pincode\": \"112233\", \"country_id\": 101}',NULL,NULL,NULL,NULL,'active','off',28,28,NULL,'2021-12-02 17:36:05','2021-12-30 17:16:52'),(6,'Reckitt',5,3,'{\"country_id\": 101, \"account_name\": \"acc name 2\", \"billing_email\": null, \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": \"district2\", \"state\": \"district2\", \"tax_id\": null, \"address\": null, \"pincode\": \"112233\", \"country_id\": 101}',NULL,'{\"auth_logo\": \"\", \"main_logo\": \"assets/uploads/main_logo/check box menu .png\", \"banner_img\": \"\"}',NULL,NULL,'active','off',28,28,NULL,'2021-12-02 17:37:32','2021-12-30 17:17:05'),(7,'SABIC',5,5,'{\"country_id\": 0, \"account_name\": \"ACC NAME 3\", \"billing_email\": \"SABIC@demo.com\", \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": \"district3\", \"state\": \"district3\", \"tax_id\": null, \"address\": null, \"pincode\": null, \"country_id\": 0}',NULL,NULL,NULL,NULL,'active','off',28,28,NULL,'2021-12-02 17:39:03','2021-12-02 17:39:03'),(8,'Oerlikon',5,3,'{\"country_id\": 101, \"account_name\": \"acc name 1\", \"billing_email\": null, \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": \"district 4\", \"state\": \"district 4\", \"tax_id\": null, \"address\": null, \"pincode\": null, \"country_id\": 101}',NULL,NULL,NULL,NULL,'active','off',28,28,NULL,'2021-12-02 17:43:20','2021-12-30 17:18:24'),(9,'Apollo',5,5,'{\"country_id\": 0, \"account_name\": \"acc name 5\", \"billing_email\": \"Apollo@simrekademo\", \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"02/12/2021\"}','{\"city\": \"district 5\", \"state\": \"district 5\", \"tax_id\": null, \"address\": null, \"pincode\": \"112233\", \"country_id\": 0}',NULL,NULL,NULL,NULL,'active','off',28,28,NULL,'2021-12-02 17:44:41','2021-12-02 17:44:41'),(10,'Test tenant',1,1,'{\"country_id\": 82, \"account_name\": \"Test\", \"billing_email\": \"test@simreka.com\", \"billing_phone_no\": \"(+12) 3456-7890-04\", \"organization_logo\": \"\", \"billing_start_from\": \"12/01/2022\"}','{\"city\": \"Bangalore\", \"state\": \"Bangalore\", \"tax_id\": \"1111\", \"address\": null, \"pincode\": \"271305\", \"country_id\": 82}',NULL,NULL,NULL,NULL,'active','off',1,1,NULL,'2022-01-12 12:15:18','2022-01-12 12:15:18'),(11,'ARCUS Greencycling',5,3,'{\"country_id\": 82, \"account_name\": \"acc\", \"billing_email\": \"na\", \"billing_phone_no\": null, \"organization_logo\": \"\", \"billing_start_from\": \"12/01/2022\"}','{\"city\": null, \"state\": null, \"tax_id\": null, \"address\": null, \"pincode\": null, \"country_id\": 82}',NULL,NULL,NULL,NULL,'active','off',7,7,NULL,'2022-01-12 17:13:53','2022-01-12 17:13:53');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time_zones`
--

DROP TABLE IF EXISTS `time_zones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `time_zones` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_zone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time_zones`
--

LOCK TABLES `time_zones` WRITE;
/*!40000 ALTER TABLE `time_zones` DISABLE KEYS */;
INSERT INTO `time_zones` VALUES (1,'GMT','Greenwich Mean Time','GMT',NULL,NULL,NULL),(2,'UTC','Universal Coordinated Time	','GMT',NULL,NULL,NULL),(3,'ECT	','European Central Time	','GMT+1:00',NULL,NULL,NULL),(4,'EET	','Eastern European Time','GMT+2:00',NULL,NULL,NULL),(5,'ART	','(Arabic) Egypt Standard Time	','GMT+2:00',NULL,NULL,NULL),(6,'EAT','Eastern African Time	','GMT+3:00',NULL,NULL,NULL),(7,'MET','Middle East Time	','GMT+3:30',NULL,NULL,NULL),(8,'NET	','Near East Time	','GMT+4:00',NULL,NULL,NULL),(9,'PLT','Pakistan Lahore Time	','GMT+5:00',NULL,NULL,NULL),(10,'IST','India Standard Time	','GMT+5:30',NULL,NULL,NULL),(11,'BST','Bangladesh Standard Time	','GMT+6:00',NULL,NULL,NULL),(12,'VST','Vietnam Standard Time	','GMT+7:00',NULL,NULL,NULL),(13,'CTT','China Taiwan Time	','GMT+8:00',NULL,NULL,NULL),(14,'JST	','Japan Standard Time	','GMT+9:00',NULL,NULL,NULL),(15,'ACT	','Australia Central Time	','GMT+9:30',NULL,NULL,NULL),(16,'AET','Australia Eastern Time	','GMT+10:00',NULL,NULL,NULL),(17,'SST','Solomon Standard Time	','GMT+11:00',NULL,NULL,NULL),(18,'NST	','New Zealand Standard Time','GMT+12:00',NULL,NULL,NULL),(19,'MIT	','Midway Islands Time	','GMT-11:00',NULL,NULL,NULL),(20,'HST','Hawaii Standard Time	','GMT-10:00',NULL,NULL,NULL),(21,'AST','Alaska Standard Time	','GMT-9:00',NULL,NULL,NULL),(22,'PST	','Pacific Standard Time	','GMT-8:00',NULL,NULL,NULL),(23,'PNT','Phoenix Standard Time	','GMT-7:00',NULL,NULL,NULL),(24,'MST','Mountain Standard Time	','GMT-7:00',NULL,NULL,NULL),(25,'CST','Central Standard Time	','GMT-6:00',NULL,NULL,NULL),(26,'EST','Eastern Standard Time	','GMT-5:00',NULL,NULL,NULL),(27,'IET','Indiana Eastern Standard Time	','GMT-5:00',NULL,NULL,NULL),(28,'PRT','Puerto Rico and US Virgin Islands Time	','GMT-4:00',NULL,NULL,NULL),(29,'CNT	','Canada Newfoundland Time	','GMT-3:30',NULL,NULL,NULL),(30,'AGT','Argentina Standard Time	','GMT-3:00',NULL,NULL,NULL),(31,'BET','Brazil Eastern Time	','GMT-3:00',NULL,NULL,NULL),(32,'CAT','Central African Time	','GMT-1:00',NULL,NULL,NULL);
/*!40000 ALTER TABLE `time_zones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tolerance_reports`
--

DROP TABLE IF EXISTS `tolerance_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tolerance_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tolerance_value` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `output_data` json DEFAULT NULL,
  `messages` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('success','pending','failure') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tolerance_reports`
--

LOCK TABLES `tolerance_reports` WRITE;
/*!40000 ALTER TABLE `tolerance_reports` DISABLE KEYS */;
/*!40000 ALTER TABLE `tolerance_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_menus`
--

DROP TABLE IF EXISTS `user_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_menus` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_url` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_icon` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_menu` json DEFAULT NULL,
  `active_route` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `migrations` json DEFAULT NULL,
  `seeders` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_menus`
--

LOCK TABLES `user_menus` WRITE;
/*!40000 ALTER TABLE `user_menus` DISABLE KEYS */;
INSERT INTO `user_menus` VALUES (1,'Dashboard','dashboard','home','0','dashboard','[{\"sub_module_name\": \"profile\"}]','dashboard',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(2,'Products','product/chemical','package','0','product','[{\"sub_module_name\": \"profile\"}, {\"sub_module_name\": \"properties\"}]','product',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(3,'Process Simulation','mfg_process/simulation','target','0','mfg_process','[{\"sub_module_name\": \"profile\"}]','mfg_process/simulation',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(4,'Product System','javascript:void(0);','gift','0','product_system',NULL,'product_system',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(5,'Product System','product_system/product','gift','4','product_system','[{\"sub_module_name\": \"profile\"}]','product_system/product',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(6,'Product System Comparison','product_system/comparison','gift','4','product_system','[{\"sub_module_name\": \"profile\"}]','product_system/comparison',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(7,'Experiments','javascript:void(0);','sliders','0','experiment',NULL,'experiment',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(8,'Experiment Units','experiment/experiment_units','sliders','7','experiment','[{\"sub_module_name\": \"profile\"}]','experiment/experiment_units',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(9,'Experiments','experiment/experiment','','7','experiment','[{\"sub_module_name\": \"profile\"}, {\"sub_module_name\": \"variation\", \"sub_sub_modules\": [{\"sub_sub_module_name\": \"process_flow_table\"}, {\"sub_sub_module_name\": \"process_flow_diagram\"}, {\"sub_sub_module_name\": \"unit_specification\"}, {\"sub_sub_module_name\": \"models\"}, {\"sub_sub_module_name\": \"dataset\"}, {\"sub_sub_module_name\": \"data_request\"}, {\"sub_sub_module_name\": \"simulation_input\", \"sub_sub_sub_modules\": [{\"sub_sub_sub_module_name\": \"forward\", \"sub_sub_sub_sub_modules\": [{\"sub_sub_sub_sub_module_name\": \"raw_material\"}, {\"sub_sub_sub_sub_module_name\": \"master_condition\"}, {\"sub_sub_sub_sub_module_name\": \"unit_condition\"}, {\"sub_sub_sub_sub_module_name\": \"master_outcome\"}, {\"sub_sub_sub_sub_module_name\": \"unit_outcome\"}]}, {\"sub_sub_sub_module_name\": \"reverse\", \"sub_sub_sub_sub_modules\": [{\"sub_sub_sub_sub_module_name\": \"raw_material\"}, {\"sub_sub_sub_sub_module_name\": \"master_condition\"}, {\"sub_sub_sub_sub_module_name\": \"unit_condition\"}, {\"sub_sub_sub_sub_module_name\": \"master_outcome\"}, {\"sub_sub_sub_sub_module_name\": \"unit_outcome\"}]}]}]}]','experiment/experiment',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(10,'Plant Data','experiment/plant_data','','7','experiment','[{\"sub_module_name\": \"profile\"}]','experiment/plant_data',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(11,'Data Sets','experiment/data_sets','','7','experiment','[{\"sub_module_name\": \"profile\"}]','experiment/data_sets',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(12,'Models','models','flag','0','models','[{\"sub_module_name\": \"profile\"}]','models',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(13,'Reports','javascript:void(0);','printer','0','reports',NULL,'reports',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(14,'Process Analysis','reports/process_analysis','printer','13','reports','[{\"sub_module_name\": \"profile\"}]','reports/process_analysis',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(15,'Process Comparison','reports/process_comparison','printer','13','reports','[{\"sub_module_name\": \"profile\"}]','reports/process_comparison',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(16,'Product System','reports/product_system','printer','13','reports','[{\"sub_module_name\": \"profile\"}]','reports/product_system',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(17,'Product System Comparison','reports/product_system_comparison','','13','reports','[{\"sub_module_name\": \"profile\"}]','reports/product_system_comparison',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(18,'Experiment','reports/experiment','','13','reports','[{\"sub_module_name\": \"profile\"}]','reports/experiment',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(19,'Other Inputs','javascript:void(0);','layers','0','other_inputs',NULL,'other_inputs',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(20,'Energy & Utilities','other_inputs/energy','','19','other_inputs','[{\"sub_module_name\": \"profile\"}, {\"sub_module_name\": \"properties\"}]','other_inputs/energy',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(21,'Equipments','other_inputs/equipment','','19','other_inputs','[{\"sub_module_name\": \"profile\"}]','other_inputs/equipment',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(22,'Reactions','other_inputs/reaction','','19','other_inputs','[{\"sub_module_name\": \"profile\"}]','other_inputs/reaction',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(23,'Regulatory Lists','organization/list','flag','0','organization/list','[{\"sub_module_name\": \"profile\"}]','organization/list',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(24,'Vendors','organization/vendor','globe','0','organization/vendor','[{\"sub_module_name\": \"profile\"}]','organization/vendor',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(25,'Knowledge Bank','javascript:void(0);','hard-drive','0','knowledge_bank','[{\"sub_module_name\": \"profile\"}]','knowledge_bank',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(26,'Process Simulation','knowledge_bank/process_simulation','','25','knowledge_bank','[{\"sub_module_name\": \"profile\"}]','knowledge_bank/process_simulation',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(27,'Reports','knowledge_bank/report','','25','knowledge_bank','[{\"sub_module_name\": \"profile\"}]','knowledge_bank/report',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(28,'Data Request','data_request','server','0','data_request','[{\"sub_module_name\": \"profile\"}]','data_request',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00'),(29,'S4 HANA Cloud Connect','sap/cloud_connect','download-cloud','0','sap/cloud_connect','[{\"sub_module_name\": \"profile\"}]','sap/cloud_connect',NULL,NULL,0,0,NULL,'2020-07-14 00:00:00','2020-07-14 00:00:00');
/*!40000 ALTER TABLE `user_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL,
  `user_id` int NOT NULL,
  `user_group_id` int DEFAULT NULL,
  `designation_id` int NOT NULL,
  `permission` json DEFAULT NULL,
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
INSERT INTO `user_permissions` VALUES (1,1,1,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(2,1,2,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(3,1,3,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(4,1,4,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(5,1,5,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(6,1,6,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(7,1,7,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(8,1,12,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(9,1,21,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(10,1,27,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(11,1,28,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(12,1,33,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(13,1,63,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33'),(14,1,66,0,1,'{\"1\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 1}}, \"2\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 2}}, \"3\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 3}}, \"5\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 5}}, \"6\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 6}}, \"8\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 8}}, \"9\": {\"models\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"dataset\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"forward\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"reverse\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"variation\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"data_request\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"raw_material\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_outcome\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"master_condition\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"simulation_input\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_table\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"unit_specification\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}, \"process_flow_diagram\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 9}}, \"10\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 10}}, \"11\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 11}}, \"12\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 12}}, \"14\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 14}}, \"15\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 15}}, \"16\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 16}}, \"17\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 17}}, \"18\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 18}}, \"20\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}, \"properties\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 20}}, \"21\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 21}}, \"22\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 22}}, \"23\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 23}}, \"24\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 24}}, \"26\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 26}}, \"27\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 27}}, \"28\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 28}}, \"29\": {\"profile\": {\"method\": [\"index\", \"create\", \"edit\", \"delete\", \"store\", \"update\"], \"menu_id\": 29}}}',1,1,'','active',NULL,'2022-01-27 08:39:33','2022-01-27 08:39:33');
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tickets`
--

DROP TABLE IF EXISTS `user_tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_tickets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `title` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tickets`
--

LOCK TABLES `user_tickets` WRITE;
/*!40000 ALTER TABLE `user_tickets` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings` json DEFAULT NULL,
  `two_factor_auth` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'false',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Mohd','Kaif','mohammad.kaif@simreka.com',NULL,NULL,'admin',1,'$2y$10$g6YrGnDUA9GVPXwmneCjFuK6yfQByAiVzHri418ktDaJH5U8TfZC6',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(2,'Abhijit','Jagtap','abhijit.jagtap@simreka.com',NULL,NULL,'admin',1,'$2y$10$wDRebwPyXv/PHS9ioVRFpushe8UKETWOFSGquNHCx.8tpUdPaisqe',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(3,'Shiva','kumar','shiva.kumar@simreka.com',NULL,NULL,'admin',1,'$2y$10$j3xB6NYrk9N//1JD40/nqOmmEJ3rgp.YYjryBxdCeo2ByW5ohqSPW',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(4,'Deboprio','Ghosh','deboprio@simreka.com',NULL,NULL,'admin',1,'$2y$10$TWo3DmEatWhV1hdCwrx0R.qptgntnIrwU5NfpmHLT6ia1HuY9HnPe',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(5,'Akshay','Patel','adpatel@simreka.com',NULL,NULL,'admin',1,'$2y$10$rA04iS8VMavCaCO1pKH6pejFGC3dDJXbw/jPbkLV4zk5NALNNFGqW',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(6,'Ravi','Kulkarni','ravi.kulkarni@simreka.com',NULL,NULL,'admin',1,'$2y$10$lR1o3ApWMTigNgUePjbvn.wzT9BJYx94xhbbkk0OEp6qFf81.KO66',NULL,'false','vUrGp7u3RhP03E04zpWhv9iAG67Bzo8Xg7t1SO4AXsZaYd8HENC0o44edAl7','active',0,0,NULL,NULL,'2021-10-18 10:54:41'),(7,'Tetsuro','Nagaki ','tnagaki@simreka.com',NULL,NULL,'admin',1,'$2y$10$CRK6VSpV5kjK7wJWq5g/uOTj7NK4mzQ3uYIpqZgCBG/FhpJAIrAgm',NULL,'false',NULL,'active',0,0,NULL,NULL,NULL),(9,'Oerlikon ','Admin','skshiva90@gmail.com','(+91) 9876-5642-33',NULL,'console_admin',1,'$2y$10$PVunfuq1HN0Vsn0dGWWPHOq9ROyGbngJmdss/BECaIv6Kj41f1svK',NULL,'false',NULL,'active',0,9,NULL,NULL,'2021-05-13 11:16:11'),(11,'H2Pro','Admin','skandaent2304@gmail.com','(+98) 7654-3210-31',NULL,'console_admin',1,'$2y$10$U0rX3v1DVJ0guQ2HRAjtWu5MXECZERSj0bu8YCRCgab8Kd1ASgOZ6',NULL,'false','qDcdKQTSvpPKnecmsbFxOqFRoW37T6GiMwZ2AWI5zVuKmEymL6hydJnOXOOm','pending',3,3,NULL,'2021-05-19 15:04:59','2021-05-19 15:04:59'),(12,'Sridevi','Krishnamurthi','sridevi.k@simreka.com','98765432345',NULL,'admin',1,'$2y$10$ieXbPqTlhf6KV3Fer2v/VuUsSFW/jnz9M.lqHYDePYsnNoQfnyal6',NULL,'false','RKwZPcznfQzsU4K1vTROsB7nd3uK5JVZaY6JBp0DQoFriqbfMEps9dfl2urV','active',1,1,NULL,'2021-06-17 16:26:34','2021-06-17 16:32:07'),(13,'Samer','Alzyod','samer.alzyod@simreka.com','00000000000',NULL,'admin',0,'$2y$10$Cv95M4OmPJrRLFRbiEG9ZuSKDEgLRj38iddjynEK94cT1P3STMIZu',NULL,'false','Q0dXzydY2zrObKWbAWyLcAIq9M93vN13kJ3irhf4kPn0EBRpICUem5yjVMfw','pending',1,1,NULL,'2021-06-17 16:28:04','2021-06-17 16:28:04'),(18,'Hen','Dotan','hen@h2pro.co',NULL,NULL,'console',1,'$2y$10$wDRebwPyXv/PHS9ioVRFpushe8UKETWOFSGquNHCx.8tpUdPaisqe',NULL,'false','bS9ASKtKd1GmcXuCeEKOKAgPazsivnjsW73XaQIrJCZmCpvL5fSeZtxIpuRP','active',3,18,NULL,'2021-07-05 22:26:02','2021-07-12 22:27:14'),(19,'Moty','Moshkovich','moty@h2pro.co','972546500823',NULL,'console',1,'$2y$10$kHk3oUJtiNqNjO/JRbklj.SAf/w1l/ODcgf1ImZ2ChPGlXlpGZhoC',NULL,'false','4yau8gzih0pyfvaWJpgw0MZdTgB3ryxkgTYs2Y0ElqaE1m0vNotpSBjeTeKQ','active',3,19,NULL,'2021-07-05 22:26:26','2021-07-14 11:39:43'),(20,'Ziv','Arzi','ziv@h2pro.co',NULL,NULL,'console',1,'$2y$10$9pznQ1J.u02idzfHDELD3e.dSZPAUjeGZxMLnY4hmm34bdeyHnPwW',NULL,'false','PkPkPzeSIqWDmdejeKzwxJsAuV1tDEC1cU5NanKW6FaaSJjdASO2uAPYAOP1','active',3,20,NULL,'2021-07-05 22:29:07','2021-07-05 22:33:23'),(21,'Michael','Koene','michael.koene@simreka.com',NULL,NULL,'admin',1,'$2y$10$rhaFMXXCKLoo0fwrVU0zWuzogEoRPY5I0IDxOfNpI7VUV3F1nHM3a',NULL,'false','n50CYrZr2Pzz2bNpMmdjadnfAyHmypTIRzYjXxbPREiOPcetEYvNjRn29Jd6','active',3,3,NULL,'2021-07-13 15:21:42','2021-07-13 15:24:32'),(22,'Kaif','console','mohdkaif984@gmail.com','(+23) 4567-8987-65',NULL,'console_admin',1,'$2y$10$VeOcmgloftR5VyVhd7EoL.Ls8N/rcuqBAmeVbWL2GPlelDVuQAIBW',NULL,'false','Hfm5NyEv5yHnKja805anAgMqdbMWgSNU9TRXZIhzmQO0KDmPwj1dWO1PMP5i','active',1,1,NULL,'2021-08-30 16:23:49','2021-08-30 16:23:49'),(23,'User1','Demo','user1@demo.com','(+23) 4532-3432-34',NULL,'console_admin',1,'$2y$10$qIlm56PVg31PTb.jimR2Ae/Y0BtaDtkcYdVdx/HfU7b6mTxVPMaSS',NULL,'false','WIGtxTCKmEP9OxLmXlxX5RpaNzuLJ7ch06tBLNi7UEki5DBChwRpm4iCZazN','active',1,1,NULL,'2021-08-31 13:42:53','2021-11-24 12:25:48'),(24,'User2','Demo','user2@demo.com',NULL,NULL,'console_admin',1,'$2y$10$zUEO9T3O8DE2f5bkZOQSvugKrDMGfp/71jrBHrzsMG6n.2gQ89Z.S',NULL,'false','B1O0AJSkKNUjbLlneslRFl6tgPQvRvBdMvccCb6ixbjPvaoMd3w0CzBZwDJD','active',1,1,NULL,'2021-08-31 17:39:57','2021-08-31 17:39:57'),(25,'User3','Demo','user3@demo.com',NULL,NULL,'console_admin',1,'$2y$10$nlVoX1MQ/ylhGorg2x6Oa.T5KC5EM/KbimRxGTVUUYagAzvgd9QOa',NULL,'false','st1wd2ibJ85IGiBWFLpN8L0vuFt0Q4ZuCPd5gRZWzQwlbA6p0FNJ42yEXHdA','active',1,1,NULL,'2021-08-31 17:41:10','2021-08-31 17:41:10'),(26,'User4','Demo','user4@demo.com',NULL,NULL,'console_admin',1,'$2y$10$8xvedRBR9y7Fb5AbXJJ78uKfbI5hyORXcFI8EiV542Psp77W6veA6',NULL,'false','vM5mYgYlP88H0SXCfRusGqYSiQezAf0vcrDfplJoOIrMHyuLOKzfL4ssUrNp','active',1,1,NULL,'2021-08-31 17:41:52','2021-08-31 17:41:52'),(27,'Anupama','a','anupama.a@simreka.com',NULL,'assets/uploads/profile_image/console...jpg','admin',1,'$2y$10$UIeTCDQXe/kNI3G.UkxceulsF2aCX5sqSoHYB.fnowgzZ9/fV5OUa',NULL,'false','V8c66pPibdPTaIqakFVYcQQSZf1Zwq0Q23rGhoQj8B4Cnqj7cHrjuOqDNn4P','active',1,27,NULL,'2021-08-31 17:41:52','2022-01-18 12:20:55'),(28,'Sharath','m','sharath.m@simreka.com',NULL,NULL,'admin',1,'$2y$10$vSMNChzWRZZ836MA7RFuOullDPfzJ2L0t8Yg.IZhUjMTevYsdqkhG',NULL,'false','Lw22ZXIthXEG94lUMI3ET5XololCBkDQYEEe37wRQGXWUow9LyDaH0rxTTzi','active',1,1,NULL,'2021-08-31 17:41:52','2021-10-25 10:55:01'),(29,'user123','demo','user123@demo.com',NULL,NULL,'console_admin',0,'$2y$10$Jybu98SnXZQb8q.Nx3i06OpKyfNRZXRLLZcd2ob1qzJT1GML8KHvm',NULL,'false','BpOZ5uVoLVCivsw8DqwVRRO4hJLQkjy6txh3ygd8ZVlHw8YNtuddCMgWQAAG','active',28,28,NULL,'2021-12-01 18:46:00','2021-12-01 18:46:12'),(30,'user1234','demo','user1234@demo.com',NULL,NULL,'console_admin',0,'$2y$10$ipq3xxMbgQwEMm/xe0NRxu9.KHNkWTj3kcLqPZFjb9xpS1PPVo0Y6',NULL,'false','nLpFrZV0jt0Az955a3rJJ6iu0wzjzYypykS5MVLZ2IY4XNvMIAno2Q2eDnVY','active',28,28,NULL,'2021-12-01 18:46:52','2021-12-02 10:23:31'),(31,'asdasdsad','','dasdasd','(+32) 3153-3777-99',NULL,'console_admin',0,'$2y$10$x8ASDj81iSYneRxpjBzRM.QaKxHX93cZo92VLQCrXiHn/us/X89M2',NULL,'false','mWqHSGwZEscjzcjK6KHshnNOGrr8x6O54DPIqbO8vFPmjQwKOOG3uIWb98q6','active',27,27,NULL,'2021-12-02 10:04:57','2021-12-02 10:11:59'),(32,'sdfefew232','','dfdggrr','(+12) 3568-8899-14',NULL,'console_admin',0,'$2y$10$cmQluuj8.N81AdK1P39JsOmhAWRZlfYp.BXu.V/TBC2fuex/EN8Qu',NULL,'false','jZh2iikOfKLWkKAFtbcCPjHfsdUJVwhUU2yNE9dJ26kTt2V4zw9n0LPHGq9s','pending',27,27,'2021-12-03 14:19:58','2021-12-02 10:06:23','2021-12-03 14:19:58'),(33,'Shiva','P','shiva.p@simreka.com',NULL,NULL,'admin',1,'$2y$10$wDRebwPyXv/PHS9ioVRFpushe8UKETWOFSGquNHCx.8tpUdPaisqe',NULL,'false','T8pfwAjmpuyitDDOup9JTJJAsunJ76rPWSC9vb117plYGpqhVHPRzgXOMHjY','active',27,27,NULL,'2021-12-02 11:42:37','2022-01-13 11:57:24'),(34,'Test','User','user5356',NULL,NULL,'console_admin',0,'$2y$10$HSR/qGsuNNg7LkXDK0fFc.0yxLfpIXCW/mb9Vi3APBQX6HzHGWjzy',NULL,'false','zx3EY91jGZaEdDD7DpWoUAp07TwGxNX2QxWP4vPI3h3aSlnil22l7Ir6NFUO','active',27,27,'2021-12-07 17:49:32','2021-12-02 12:33:53','2021-12-07 17:49:32'),(35,'rer','er','fe656',NULL,NULL,'console_admin',0,'$2y$10$jC0tWQSmkPkkjnlTjM6wMeLzFNFPIss7LWtafxmQmIUFvX3EPGn3m',NULL,'false','8HCtUj2bwJeAOovgyzNmb1ryhqMVVV8bYUkfRvEYvnL1aks6NmFu4SHUQ3nj','pending',27,27,'2021-12-02 12:34:48','2021-12-02 12:34:37','2021-12-02 12:34:48'),(36,'gg','gg','678gv',NULL,NULL,'console_admin',0,'$2y$10$EBpEzJtIz6oUzizPZ93G/.ZbsH8Y2CGCsbSulrMJEkgYeREvjEsXW',NULL,'false','GdvnWbR2Mhspyiw6Apr2XW07iChO5kZMMYsFCd7DAf6T3LEzWglNIj4JG1yy','pending',27,27,'2021-12-02 12:39:49','2021-12-02 12:35:03','2021-12-02 12:39:49'),(37,'ij','uu','guy7',NULL,NULL,'console_admin',0,'$2y$10$EX8oAb3/rY71xpwq03uQVe1muFdIGVv962VysPCTK8sbq/9aJW18C',NULL,'false','pPUPDjvTNXEyQjxekLlMNKoLMWELpmkqY6qeAkixBc2nP3Z63swG3jM2myYL','pending',27,27,'2021-12-02 12:39:46','2021-12-02 12:35:22','2021-12-02 12:39:46'),(38,'gdg','fdcgb','dfgfd',NULL,NULL,'console_admin',0,'$2y$10$nlMcpwV716o.QGFnkWx24.i61YrNv6PUB1V9y63Hib2HBcBqp8Oe.',NULL,'false','5EWpwdZVGYzQtZS37YeKBZ5PCHkv8bZJw2rZyEBHOjM4zplwppxyFVVleLVx','pending',27,27,'2021-12-02 12:39:41','2021-12-02 12:35:38','2021-12-02 12:39:41'),(39,'abc','d','anupama.a+1@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$JS6dlYfLhLxPBT.J7P54YewIApy5rzr3jNCdxels4lfOYX/60OmTi',NULL,'false','FDuX59khg9RUPbAOJD8jFYVJovimef50JPDnbtzLWUAcHKzJClfeKLX2OFLx','active',27,39,'2021-12-07 17:49:37','2021-12-02 15:24:24','2021-12-07 17:49:37'),(40,'acc','','H2Pro',NULL,NULL,'console_admin',0,'$2y$10$3iDGOrBYQ9nlTsQJWnY6uuE0dgeuug5m5tjRfv54OPdvAttwvHWsG',NULL,'false','Sxrx5Ceh59uTqzvqa2PQmOkdwDk5os4bKgrqjkXGIY1pY6CI4sVPM46H1NAc','pending',28,28,'2021-12-03 10:30:50','2021-12-02 17:36:05','2021-12-03 10:30:50'),(41,'acc name','2','Reckitt@simrekademo',NULL,NULL,'console_admin',0,'$2y$10$655idRkUc5NIXj3JIXjhQeGUm7hMgQcZCYnuSESmlIdR.tRUnJuL2',NULL,'false','9nCJwS4QKzP72iYCbD6myuOwQrLZQ9KPa9HwFsluazbGOt07C8j6dOPZyyKS','active',28,28,NULL,'2021-12-02 17:37:32','2021-12-03 15:43:03'),(42,'ACC NAME','3','SABIC@demo.com',NULL,NULL,'console_admin',0,'$2y$10$KYlNwLIUakPZsXgLFvX1qOW4ar6F7mpGjwIXKexwnmqNSWE9UgH1m',NULL,'false','5BZUwY7QEZIog6CdDClNMVjuivyzWZ35gy6hwyE5cxLHt5JtxAs9Wkv8FghR','active',28,28,NULL,'2021-12-02 17:39:03','2021-12-29 09:30:57'),(43,'acc name','1','Oerlikon@demo.com',NULL,NULL,'console_admin',0,'$2y$10$CJJOaqBSGWA7qt.ZzGpwxuE38YO4xRRX6MsNZBD2E.3b.FH.N8fS6',NULL,'false','7tae17TDjkue11LumGBLiMwuYhH1VJNe2xM6p84xXt4fi5zdd2Gx1DbuwTv7','active',28,28,NULL,'2021-12-02 17:43:20','2021-12-24 11:50:34'),(44,'acc name','5','Apollo@simrekademo',NULL,NULL,'console_admin',0,'$2y$10$UyBr/QSi3jGSnGRlB0Xu6u7nCyN7x6ZQ5rxsGJOBItyIvIdjvGJ.i',NULL,'false','lDcIP7iAFXiF0lZxkzbIs4J6h9iJLkA1cSPSrHykaEly4hcGgDBHz22Mj4T9','active',28,28,NULL,'2021-12-02 17:44:41','2021-12-24 14:32:25'),(45,'sharath','m','sharath.m+1@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$Af/Ybtkf8BgqyF/DInieYeLF5vN5Qvhw1J7T4PBd.ROhA.Ksu4y/e',NULL,'false','NTHS43WIdqzxWZ96MKjhYKvGGr9FVnkMTwnjO38IDsThyubxhfEFyOAlkwim','active',28,28,NULL,'2021-12-03 16:55:26','2021-12-03 16:58:43'),(46,'Test','T','anupama.a+3@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$sYNgE0McksouKloGP2COUOGz5rEtfD1VQ/XbTb5kA.KjND4Yb0m3q',NULL,'false','XLeCluBsP3HHhDox436aRWhFYobdMkDSLmSjFrPZu06vcWJAoejE2NG649i6','active',27,27,'2021-12-07 17:56:13','2021-12-07 17:50:24','2021-12-07 17:56:13'),(47,'User','A','anupama.a+2@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$CInjlQ3nKxv7zbaTa.9.pOSZW0FNOGSnTSVz4Oxj0STLUx.i/lzNu',NULL,'false','cMxhz4yBS9XpivHyH5MdI3GdHGqNCXu3T1WpGkMFRfTswk17PFFVB3zHj03r','active',27,27,'2021-12-07 17:56:17','2021-12-07 17:50:49','2021-12-07 17:56:17'),(48,'User','A','anupama.a+@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$Zn9cYuww.GHiIqXjKzl2duN/k9g4XpAvkjpPekNzgLoQ2HABzTnD6',NULL,'false','UbqPhWlHbTeoQWO1M2TMmuEUMtwLgJAPQv48IBm10lKjt01BrIDltc6JuuJk','active',27,48,'2021-12-28 11:20:10','2021-12-07 17:57:00','2021-12-28 11:20:10'),(49,'Test','a','ravi.kulkarni+1@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$aQI6zTV3I8ZWDtUvtM2UieGgBb7xKoxXFjXr4q64EIaKuURG17xTS',NULL,'false','xZonvGC4TXmNzWrgzLMX8WBTpTYO7RMKHCKRPt4WEHd2zLDSZaFbGwtAIhXC','active',27,49,'2021-12-28 11:20:14','2021-12-07 18:09:15','2021-12-28 11:20:14'),(50,'user 1','user','sharath.m+3@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$I4hVB4XS42s6HxMheuZRB.kbsxbXKpBziE..rkcFDAb8PYF5bkJNC',NULL,'false','HEXgSNHXrw3jQaPa9t64GvGjIC2QHsQiyXo3NS1IkzfCDHxPaAZSITqnZYIs','active',28,28,NULL,'2021-12-21 17:42:50','2021-12-21 17:47:07'),(51,'user 2','user','sharath.m+4@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$Nw6oINgtlICLw2kOX7MKnu1ZCX26by83ERNm6ZDmNq9xLXc2cwPpa',NULL,'false','LN5CV5rBrRP1WJPOszLHg9JWitxFNF7n67Ys8DENPcPafBYaE9WRKpSzpWt8','active',28,28,NULL,'2021-12-21 17:46:13','2021-12-21 17:47:19'),(52,'anupama','a','anupama.a+4@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$CRp20.CN0om.upmSX5tQNu9SERXwl8zlMZcLkxMqks6G4CGc4D9LC',NULL,'false','oEix3VegIJgerZBZ2PXerWHWBPX1G53XZWk9raAgn9KKJmqKe9YPDwNxZOAP','active',27,27,NULL,'2021-12-22 15:00:27','2021-12-22 15:00:32'),(53,'oerlikon','user','sharath.m+5@simreka.com',NULL,NULL,'console_admin',0,'$2y$10$BUHy4xjwANFyBgY5PfUn3uNbXfDkkbgTdsa8aFQVODdaIXAwkOd2.',NULL,'false','YuTkszS1yaX0nE0OvFFMCayD4oyJUeFK2DTnxZB3vbf3OzqBpNNjepWsgMwW','active',28,28,NULL,'2021-12-24 11:50:24','2021-12-24 11:50:38'),(54,'George','deFaria','george.defaria@apollotyres.com',NULL,NULL,'console_admin',0,'$2y$10$UDkIp2Ssv4n4zDH7FVZUseeXO/aHH49nhp30ljKmNQPcB2c1J.Yl.',NULL,'false','cW82IHjYHXbhx0aAIqCJxq57czFgrSX8NZvM2aroUNgd3hsCidr3i6ujtXuu','active',28,28,NULL,'2021-12-24 14:32:19','2021-12-24 14:32:29'),(55,'Davide','Privitera','davide.privitera@apollotyres.com',NULL,NULL,'console_admin',0,'$2y$10$LVKy..qhv5mFqy5lZQSGFuOLWRA0T9yf3y1ngOGMk/vU7gytzvlIq',NULL,'false','i2bUfKd8iEsCOTbsXrXl8O46khnICxDVmx5iNZQX7lw4yGg9Ji67OVyf1xd5','active',28,28,NULL,'2021-12-24 14:33:10','2021-12-24 14:33:15'),(56,'Mohamed','Tharik','mohamed.tharik@Apollotyres.com',NULL,NULL,'console_admin',0,'$2y$10$L/4fcZSZAjzpj2m.WLs38OtVBlGG4BYFPL8GKgud1UpluU3wmpRCW',NULL,'false','J0ax1PSWTk9zK1ByFERO4mjdZvU4MnaxJGbVouJz7wkRr4j3uMSOydfh2RPN','active',28,28,NULL,'2021-12-24 14:33:50','2021-12-24 14:36:07'),(57,'test','t','anupama.a+5@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$jOOjtVCvz8EFNBHdbsSYQeRf.gf2TQ6TkWVR5yMlPDv8pmPStqDL6',NULL,'false','6PhgCSSU4kWRtrI5wHUEVP3CeaQkcx6lQ00B2GnSjgSj071EARAwR8bp19XK','active',27,57,NULL,'2021-12-28 11:20:49','2021-12-28 17:48:15'),(58,'ab','c','anupama.a+6@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$BSUnn1iCDMmy8Oq0upFWHeeeocrOxJ6EdXcYOQ2UUQdlWsyAZqf/u',NULL,'false','GzXmhut6NXksUsAMiDFHJoLWjP8Qae8FcjBUVNe7qQxDTHKFO0eSylzAvobD','active',27,58,NULL,'2021-12-28 11:21:17','2021-12-28 16:49:50'),(60,'console Abhijit','j','abhijit.jagtap+1@simreka.com',NULL,NULL,'console',1,'$2y$10$wDRebwPyXv/PHS9ioVRFpushe8UKETWOFSGquNHCx.8tpUdPaisqe',NULL,'false','SxYLzHrbtKQBGfOvEoiOyCKhgjg7Ra7dqWfMACaMxLCmKWecRgeuFZWd19CW','active',2,2,NULL,'2022-01-05 12:33:01','2022-01-05 16:44:43'),(61,'Anupama','A','anupama.a+7@simreka.com',NULL,NULL,'console_admin',1,'$2y$10$eAgOVKILIc9fGKsGxYNMhOP2roALuMSMbQwZR7Fnf4q6Q.s0NlJ5O',NULL,'false','GhvPexAkOX3vOYIfBtpUCc10zZ9aqvYXCoxmiGWefDmYiKjZ2LC4L6pvvFxp','active',27,61,NULL,'2022-01-05 16:54:20','2022-01-18 10:45:53'),(62,'Anu','A','anupama.a+8@simreka.com',NULL,NULL,'console',1,'$2y$10$b5.DwpIUTl116saPQiJe3OpoJyOsgUPGgWFwfe0U/OG.jIB.7nC5u',NULL,'false','Z7dSHtUQpxUZYc0VfI3NqPWSrVX0xDsjzLFMUPJfsgBaL7sajoMqPwGIGb4n','active',27,62,NULL,'2022-01-05 17:41:36','2022-01-18 12:17:29'),(63,'satish','l','satish.lanke@simreka.com',NULL,NULL,'admin',1,'$2y$10$wDRebwPyXv/PHS9ioVRFpushe8UKETWOFSGquNHCx.8tpUdPaisqe',NULL,'false','0Q8wEck0DjXZ0LMaQaRuCM1hlg0FRdlFlC0kOZAoaMGJgkkibLrWVgUb62OF','active',2,2,NULL,'2022-01-06 10:12:23','2022-01-10 12:39:33'),(66,'Abhilash','Das','abhilash.d@simreka.com',NULL,NULL,'admin',1,'$2y$10$AOuZJLs2jBhJHb88.WFH.OriYlTw.ILNc4Lf2FjisCZTGMB7/86he',NULL,'false','d2XNCbBGDwfK5m1km1eSZUjqXEnKt42qvlcIR7YK816zo1Wl9Qu2OLiXG8kW','active',1,1,NULL,'2022-01-12 12:11:11','2022-01-12 12:13:05'),(67,'Test','','test@simreka.com','(+12) 3456-7890-04',NULL,'console_admin',0,'$2y$10$Gm7pzhOLo6NwqgpiAu.U.eKbCHue1JDw3/MRmMtG4/o/EvXnfz5na',NULL,'false','fcshRa3n6qBIPebpr05YoM0PHitMLVmkdoqeYWgkEMzuzIZ8kweseY4TG2a7','pending',1,1,NULL,'2022-01-12 12:15:18','2022-01-12 12:15:18'),(68,'acc','','na',NULL,NULL,'console_admin',0,'$2y$10$sYKKkXrvKlNvYROa6uG4m.gi8F7HE3eDESjNKa53a991NYRLRpBFe',NULL,'false','wulRplxZa7o48gqN66hWP8CMboBm4v4sb8hmCY92ecOiKb1wvQXMj16mc0Tz','pending',7,7,NULL,'2022-01-12 17:13:53','2022-01-12 17:13:53'),(69,'AB','C','anupama.a+9@simreka.com',NULL,NULL,'console',1,'$2y$10$sIPOZbG9lklh.1TIuMkTsuuFQWQ8am2UoZ035T.6cM8H5ekBEgjo.',NULL,'false','uINSx5qWy5ekv34iFQhRsm4tXGskKDkXu6DOKtBcDHzoc1VBXN2ASQ1IgF99','active',61,69,NULL,'2022-01-17 10:47:24','2022-01-17 17:42:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variations`
--

DROP TABLE IF EXISTS `variations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `variations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `experiment_id` int NOT NULL DEFAULT '0',
  `process_flow_table` json DEFAULT NULL,
  `process_flow_chart` json DEFAULT NULL,
  `unit_specification` json DEFAULT NULL,
  `models` json DEFAULT NULL,
  `dataset` json DEFAULT NULL,
  `datamodel` json DEFAULT NULL,
  `notes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `note_urls` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'inactive',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variations`
--

LOCK TABLES `variations` WRITE;
/*!40000 ALTER TABLE `variations` DISABLE KEYS */;
/*!40000 ALTER TABLE `variations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_categories`
--

DROP TABLE IF EXISTS `vendor_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_categories`
--

LOCK TABLES `vendor_categories` WRITE;
/*!40000 ALTER TABLE `vendor_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_classifications`
--

DROP TABLE IF EXISTS `vendor_classifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_classifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_classifications`
--

LOCK TABLES `vendor_classifications` WRITE;
/*!40000 ALTER TABLE `vendor_classifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_classifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_contact_details`
--

DROP TABLE IF EXISTS `vendor_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_contact_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `vendor_id` bigint NOT NULL,
  `location_id` bigint NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_contact_details`
--

LOCK TABLES `vendor_contact_details` WRITE;
/*!40000 ALTER TABLE `vendor_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_contact_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendor_locations`
--

DROP TABLE IF EXISTS `vendor_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendor_locations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `vendor_id` bigint DEFAULT NULL,
  `location_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `pincode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendor_locations`
--

LOCK TABLES `vendor_locations` WRITE;
/*!40000 ALTER TABLE `vendor_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendor_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vendors`
--

DROP TABLE IF EXISTS `vendors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vendors` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tenant_id` int NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int DEFAULT NULL,
  `classificaton_id` int DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `address` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pincode` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tags` json DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_by` int NOT NULL DEFAULT '0',
  `updated_by` int NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vendors`
--

LOCK TABLES `vendors` WRITE;
/*!40000 ALTER TABLE `vendors` DISABLE KEYS */;
/*!40000 ALTER TABLE `vendors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-31 16:16:20
