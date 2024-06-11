-- MariaDB dump 10.19-11.1.3-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: termin
-- ------------------------------------------------------
-- Server version	11.1.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES
(3,37),
(3,39),
(3,40),
(3,54),
(3,56),
(3,72),
(3,73),
(4,54),
(4,57),
(5,56),
(21,40),
(23,71),
(26,84);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES
(53,3,'w','2024-05-08 07:40:21',0),
(54,3,'www','2024-05-08 07:41:25',2),
(55,4,'piss','2024-05-08 08:07:22',0),
(56,5,'dwadwa','2024-05-08 08:11:43',2),
(57,4,'dwadwa','2024-05-13 08:49:41',1),
(58,22,'\" or \"\"=\"','2024-05-14 11:15:40',0),
(59,22,'\"','2024-05-14 11:15:55',0),
(60,22,'‏','2024-05-14 11:16:08',0),
(61,22,'<h1>test</h1>','2024-05-14 11:16:19',0),
(63,22,'\'','2024-05-14 11:19:46',0),
(64,22,'`','2024-05-14 11:19:49',0),
(66,22,'<h1','2024-05-14 11:20:42',0),
(67,22,'test','2024-05-14 11:20:49',0),
(70,22,'&lt;script&gt;window.location = &quot;https://www.youtube.com/watch?v=k9o02JvHvuk&quot;&lt;/script&gt;','2024-05-14 11:25:18',0),
(71,22,'&lt;h1&gt;test&lt;/h1&gt;','2024-05-14 11:40:24',1),
(72,23,'poob','2024-05-14 11:54:26',1),
(73,24,'test','2024-05-14 12:04:54',1),
(74,25,'poob','2024-05-15 08:35:21',0),
(75,25,'horizon on top','2024-05-15 08:36:23',0),
(76,25,'horizon on top','2024-05-15 08:36:25',0),
(77,25,'horizon on top','2024-05-15 08:36:26',0),
(78,25,'horizon on top','2024-05-15 08:36:26',0),
(79,25,'horizon on top','2024-05-15 08:36:26',0),
(80,25,'horizon on top','2024-05-15 08:36:27',0),
(81,25,'horizon on top','2024-05-15 08:36:27',0),
(82,25,'horizon on top','2024-05-15 08:36:43',0),
(84,26,'post!','2024-05-16 10:50:50',1),
(85,4,'www','2024-05-20 15:36:55',0),
(86,3,'www','2024-05-20 15:37:04',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES
(6,3,54,'pee','2024-05-08 07:46:45'),
(7,3,53,'www','2024-05-08 07:48:17'),
(8,3,53,'sex','2024-05-08 07:48:20'),
(9,3,53,'among us','2024-05-08 07:48:23'),
(10,5,55,'piss','2024-05-08 08:11:02'),
(11,5,56,'dwadwadw','2024-05-08 08:12:00'),
(12,5,56,'s','2024-05-08 09:20:33'),
(13,5,56,'pp','2024-05-08 09:25:40'),
(14,3,56,'wow','2024-05-13 07:10:37'),
(15,4,57,'dwadwadwa','2024-05-13 08:49:52'),
(16,4,57,'dwadwawawadwdwadwdwdwa','2024-05-13 09:48:57'),
(17,23,71,'<style>html{transform: rotate(179deg)</style>','2024-05-14 11:56:12'),
(18,23,71,'the poob','2024-05-14 11:57:20');
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isadmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(3,'amlgus','$2y$10$0UzjZQBWErU5J/KAezObKexaO7SS6pOfm4N8Gn/DssOrt1Q9z4xkO',1),
(4,'amogus','$2y$10$t.tDeXX7SowjmJdGXaz3euEP9ivnWgBbju7zVcOruGWl3iCJ.J5NK',0),
(5,'fuioiewf','$2y$10$ZcNSE7pOLR9YWCnHjaZWFu/LLXAp.vQlm0fEcrc3XTz2u339sGDNC',1),
(6,'sex','$2y$10$hD76Tv3A9QVoq6ptJGkRg.3l7b/4RtEyVslzUm.0LzDTThBBGYi5a',0),
(7,'wuhdiua','$2y$10$ongHIpVjqYhYSRo9oSfNOe1GWDwXo9MeMuTGCdGdTTk9EfJ/yz4za',0),
(9,'why','$2y$10$wdN1o/VyHjx7TKoyReVvh.2KRcqRHjeLl4gwxnLbfqd35ZGNYYMDK',0),
(10,'poop','$2y$10$CQUXnAH1G0DXPGCQs.LtPeyvqvEPMeKmu4u5EcwrKTtNwkaCd.Jom',0),
(11,'sex','$2y$10$jnK/KM0luDGLQR8X27iP3.NMSkn1dkWXumqJv637Q6dDtpf8Od8ba',0),
(13,'test','$2y$10$TtzxK4zFAFULFUG4J4gk3ODZ1RYXiZNxeifEE7kADtQuBVCng8HXS',0),
(14,'kulbruker','$2y$10$evrGO4ZzFvmL1qrFsbXhL.i8HYSx5/gGwgL43a.DzhSXW93wiGovy',0),
(15,'nikowom','$2y$10$xAOvZmKGxfEVdMAHhFULf.fWG2.vDD.J8DlZy47fulwqVzklb7ZBu',0),
(16,'alf_morten','$2y$10$SuWw0gczPKD1IBUPykzS6OvleW3pH8NiXoHYDeZbHnujYjnexEMnG',0),
(17,'suhuhshu','uwuiuh#ui',0),
(18,'root','$2y$10$KegI0glUah2LyQmdDUH/vObGCfunubjYO.llS9JWwUZ8FFwZJhrEG',0),
(19,'vringe','$2y$10$2IrZy53Clizb/RPzRAffYOTKOq1cC2nV5YRqpb2aYrgqZNJZuzKq.',0),
(20,'huda','$2y$10$wuXoFlGLoBOY0NHEO8R05.Axjf7yhuA0PsSkjx2LucKFR3f81Hrna',0),
(21,'morius','$2y$10$zOiwMZhkTQTlyWfZ.GbCVugQATyjxVoLS4f4lAoZPV9rLhuxj8k/O',0),
(22,'poobmaster','$2y$10$ex.5l/dipwk5D9G7e1GeYOZEVXX709TuTjnJ1utlIKbGKWM4q4t5O',0),
(23,'<style>html{transform: rotate(179deg)</style>','$2y$10$0eEFnRXLMlKt4LDED0t2OuuwPxI401QtdzwpJtxpSDEgNKVpy2xHC',0),
(24,'\"','$2y$10$VCZF6KBi1m/1UMxAy3VW0OruvWdY5OP3jw61eaTuSabWNdo1RWpVu',0),
(25,'\\','$2y$10$fgWrEXuieuSH2UST16zZf.KrJwpGyx.zF6xwHw1Ac3IHm/E5nzn8a',0),
(26,'username','$2y$10$TBa/hRi2cYvVmSIVC1F2OePpe48LWsvZZ7fKsHQWQqnjv1pOQpwXq',0);
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

-- Dump completed on 2024-05-21 22:14:15
