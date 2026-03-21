-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: ronas_web
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

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
-- Table structure for table `catalog_specs`
--

DROP TABLE IF EXISTS `catalog_specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalog_specs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `catalog_id` bigint(20) unsigned NOT NULL,
  `spec_id` int(10) unsigned DEFAULT NULL,
  `spec_value` text NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_catalog_specs_catalog_item_id` (`catalog_id`),
  KEY `idx_catalog_specs_spec_definition_id` (`spec_id`),
  KEY `idx_catalog_specs_sort_order` (`sort_order`),
  CONSTRAINT `fk_catalog_specs_catalog_item` FOREIGN KEY (`catalog_id`) REFERENCES `catalogs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_catalog_specs_spec_definition` FOREIGN KEY (`spec_id`) REFERENCES `specs` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalog_specs`
--

LOCK TABLES `catalog_specs` WRITE;
/*!40000 ALTER TABLE `catalog_specs` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalog_specs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `catalogs`
--

DROP TABLE IF EXISTS `catalogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `service_category_id` int(10) unsigned NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `price_label` varchar(150) DEFAULT NULL,
  `location` varchar(150) DEFAULT NULL,
  `whatsapp_message` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_catalog_items_service_category_id` (`service_category_id`),
  KEY `idx_catalog_items_is_active` (`is_active`),
  KEY `idx_catalog_items_price` (`price`),
  CONSTRAINT `fk_catalog_items_service_category` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogs`
--

LOCK TABLES `catalogs` WRITE;
/*!40000 ALTER TABLE `catalogs` DISABLE KEYS */;
/*!40000 ALTER TABLE `catalogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_categories`
--

DROP TABLE IF EXISTS `service_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_service_categories_name` (`name`),
  KEY `idx_service_categories_is_active` (`is_active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_categories`
--

LOCK TABLES `service_categories` WRITE;
/*!40000 ALTER TABLE `service_categories` DISABLE KEYS */;
INSERT INTO `service_categories` VALUES (1,'Otomotif','Layanan dan katalog otomotif',NULL,NULL,1,'2026-03-19 03:32:34','2026-03-19 03:32:34'),(2,'Alat Berat','Layanan dan katalog alat berat',NULL,NULL,1,'2026-03-19 03:32:34','2026-03-19 03:32:34'),(3,'Properti','Layanan dan katalog properti',NULL,NULL,1,'2026-03-19 03:32:34','2026-03-19 03:32:34'),(4,'Travel','Layanan dan katalog travel',NULL,NULL,1,'2026-03-19 03:32:34','2026-03-19 03:32:34');
/*!40000 ALTER TABLE `service_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(150) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` enum('text','textarea','number','boolean','json','image','url','email') NOT NULL DEFAULT 'text',
  `group_name` varchar(100) NOT NULL DEFAULT 'general',
  `label` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `is_core` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_settings_key` (`key`),
  KEY `idx_settings_group_name` (`group_name`),
  KEY `idx_settings_is_core` (`is_core`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'site_name','Nama Website','text','general','Nama Website',NULL,1,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(2,'site_tagline','Tagline website','text','general','Tagline Website',NULL,0,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(3,'whatsapp_number','6281234567890','text','contact','Nomor WhatsApp',NULL,1,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(4,'contact_email','admin@example.com','email','contact','Email Kontak',NULL,0,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(5,'instagram_url','https://instagram.com/akun','url','social_media','Instagram',NULL,0,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(6,'facebook_url','https://facebook.com/akun','url','social_media','Facebook',NULL,0,'2026-03-19 03:34:36','2026-03-19 03:34:36'),(7,'logo_url','/uploads/settings/logo.png','image','branding','Logo Website',NULL,1,'2026-03-19 03:34:36','2026-03-19 03:34:36');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specs`
--

DROP TABLE IF EXISTS `specs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_category_id` int(10) unsigned NOT NULL,
  `spec_key` varchar(100) NOT NULL,
  `spec_label` varchar(120) NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_spec_definitions_category_key` (`service_category_id`,`spec_key`),
  KEY `idx_spec_definitions_service_category_id` (`service_category_id`),
  KEY `idx_spec_definitions_is_active` (`is_active`),
  KEY `idx_spec_definitions_sort_order` (`sort_order`),
  CONSTRAINT `fk_spec_definitions_service_category` FOREIGN KEY (`service_category_id`) REFERENCES `service_categories` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specs`
--

LOCK TABLES `specs` WRITE;
/*!40000 ALTER TABLE `specs` DISABLE KEYS */;
/*!40000 ALTER TABLE `specs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `testimonials`
--

DROP TABLE IF EXISTS `testimonials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `testimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(120) NOT NULL,
  `customer_title` varchar(120) DEFAULT NULL,
  `customer_city` varchar(120) DEFAULT NULL,
  `message` text NOT NULL,
  `rating` tinyint(3) unsigned DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `idx_testimonials_is_active` (`is_active`),
  CONSTRAINT `chk_testimonials_rating` CHECK (`rating` is null or `rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `testimonials`
--

LOCK TABLES `testimonials` WRITE;
/*!40000 ALTER TABLE `testimonials` DISABLE KEYS */;
/*!40000 ALTER TABLE `testimonials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('superadmin','admin') NOT NULL DEFAULT 'admin',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super Admin','superadmin','$2y$12$eOt6LTGL0bSAvR.EgEsb5.x3Nn2HH.3XUkhyCaPcrJZVLtDIEwi/2','superadmin',1,'2026-03-19 03:39:54'),(2,'Owner System','owner','$2y$12$muUA0QxiQtg6jvUhWGtw5.g.LOGuRjawjoJn.f5.IrtRECvoiWgDu','superadmin',1,'2026-03-19 03:39:54'),(3,'Admin Otomotif','admin','$2y$12$wumu4UhWmzBQJIrJtxZXm.l9K46t.LDFBe.tpBZiT/./cJI5O7KMW','admin',1,'2026-03-19 03:39:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'ronas_web'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-19 14:01:34
