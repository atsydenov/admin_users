-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: sibers
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

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
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `second_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sex` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT 'Дата обновления',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin','admin','admin','admin','male','2019-01-07','2019-01-08 13:17:58','2019-01-09 21:17:11'),(3,'alexx','user','alexx','alexx','alexx','male','2019-01-09','2019-01-09 21:29:30','2019-01-09 21:31:16'),(5,'qwerty','user','qwerty','qwerty','qwerty','female','2019-01-03','2019-01-09 21:36:04','2019-01-13 15:47:47'),(6,'zxczxc','user','zxczxc','zxczxc','zxczxc','female','2019-01-01','2019-01-09 22:28:39','2019-01-13 00:45:43'),(7,'qweqwe','user','qweqwe','qweqwe','qweqwe','male','2019-01-10','2019-01-09 22:32:18','2019-01-09 22:32:18'),(8,'yuiop','user','yuiop','yuiop','yuiop','female','2016-07-13','2019-01-09 23:23:25','2019-01-13 15:48:11'),(9,'cvbnm','user','cvbnm','cvbnm','cvbnm','female','2019-01-01','2019-01-09 23:24:32','2019-01-09 23:24:32'),(14,'gggggx','user','ggggg','ggggg','ggggg','female','2005-02-06','2019-01-13 02:05:40','2019-01-13 17:56:39'),(15,'xxxxxsss','user','xxxxx','xxxxx','xxxxx','female','2007-06-12','2019-01-13 05:18:29','2019-01-13 17:56:57'),(21,'ttttt','user','ttttt','ttttt','ttttt','female','2019-01-08','2019-01-13 05:22:01','2019-01-13 05:22:01'),(22,'lllll','user','lllll','lllll','lllll','male','2019-01-13','2019-01-13 05:22:21','2019-01-13 17:46:04'),(29,'fffffxx','user','fffff','fffff','fffff','female','2019-01-13','2019-01-13 05:25:09','2019-01-13 17:56:28'),(31,'sssss','user','sssss','sssss','sssss','male','2019-01-16','2019-01-13 05:25:53','2019-01-13 05:25:53'),(32,'mmmmm','user','mmmmm','mmmmm','mmmmm','female','2019-01-13','2019-01-13 05:31:10','2019-01-13 13:37:18'),(48,'bbbbb','user','bbbbb','bbbbb','bbbbb','male','2012-06-14','2019-01-13 17:47:26','2019-01-13 17:47:26');
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

-- Dump completed on 2019-01-14  1:01:40
