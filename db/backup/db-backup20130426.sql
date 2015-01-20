CREATE DATABASE  IF NOT EXISTS `web10007` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `web10007`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: is.hive.no    Database: web10007
-- ------------------------------------------------------
-- Server version	5.5.21

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
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking` (
  `BookingId` int(11) NOT NULL AUTO_INCREMENT,
  `User_Ref` char(8) NOT NULL,
  `Start_Time` time NOT NULL,
  `End_Time` time NOT NULL,
  `Dato` date NOT NULL,
  `Room_Id` int(11) NOT NULL,
  `Ref_Booking` char(8) NOT NULL,
  PRIMARY KEY (`BookingId`,`Ref_Booking`),
  UNIQUE KEY `Ref_Booking_UNIQUE` (`Ref_Booking`),
  KEY `Rom_Id_idx` (`Room_Id`),
  KEY `Bruker_Ref_idx` (`User_Ref`),
  CONSTRAINT `Rom_Id` FOREIGN KEY (`Room_Id`) REFERENCES `room` (`RoomId`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Bruker_Ref` FOREIGN KEY (`User_Ref`) REFERENCES `user` (`Ref_User`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (2,'548-BRFK','08:00:01','20:00:00','2013-04-29',1,'TVN-5155'),(4,'846-NFDN','13:30:01','13:45:00','2013-04-24',2,'VHR-3318'),(5,'846-NFDN','15:00:01','20:00:00','2013-04-24',2,'HPG-4458'),(11,'846-NFDN','14:45:01','20:00:00','2013-04-24',7,'KGZ-8359'),(13,'846-NFDN','10:00:01','13:00:00','2013-04-25',7,'NGH-9936'),(22,'789-GOGF','08:00:01','10:00:00','2013-04-25',2,'DXF-2217'),(26,'514-GDBK','08:00:01','20:00:00','2013-05-02',24,'CNZ-8658'),(32,'514-GDBK','08:00:01','20:45:00','2013-04-26',18,'KFH-9753'),(33,'846-NFDN','19:45:01','20:00:00','2013-04-25',16,'ZFB-4631'),(46,'548-BRFK','11:15:01','14:45:00','2013-04-29',18,'XCZ-2655');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `PositionId` int(11) NOT NULL,
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`PositionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,'Ansatt'),(2,'Student');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room` (
  `RoomId` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  `Type` varchar(45) NOT NULL,
  PRIMARY KEY (`RoomId`,`Type`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'A2-98','Grupperom'),(2,'A1-50','Grupperom'),(6,'A2-50','Grupperom'),(7,'A2-51','Grupperom'),(8,'A1-23','Auditorium'),(9,'A2-52','Grupperom'),(10,'A2-53','Grupperom'),(11,'A2-54','Grupperom'),(12,'A2-55','Grupperom'),(13,'A2-56','Grupperom'),(14,'A2-56','Grupperom'),(15,'A2-57','Grupperom'),(16,'A1-19','Auditorium'),(17,'A1-21','Auditorium'),(18,'A1-11','Grupperom'),(19,'A1-12','Grupperom'),(20,'A1-14','Grupperom'),(21,'A1-16','Datalab'),(22,'A1-17','Datalab'),(23,'A1-30','Auditorium'),(24,'B1-43','MÃ¸terom'),(25,'B1-50','Auditorium'),(26,'B1-60','Auditorium'),(27,'B2-30','MÃ¸terom'),(28,'B2-48','MÃ¸terom'),(29,'C1-11','Grupperom'),(30,'C1-13','Grupperom'),(31,'C1-14','Grupperom'),(32,'C1-15','Grupperom'),(33,'C1-16','MÃ¸terom'),(34,'C1-17','Grupperom'),(35,'C1-18','MÃ¸terom'),(36,'C1-19','MÃ¸terom'),(37,'C1-20','Grupperom'),(38,'C1-21','MÃ¸terom'),(39,'C1-30','Grupperom'),(40,'C2-120','Auditorium'),(41,'C2-125','Auditorium'),(42,'C2-131','MÃ¸terom'),(43,'C2-74','MÃ¸terom'),(44,'C2-95','Datalab'),(45,'C2-99','Grupperom'),(46,'C2-80','Auditorium'),(47,'C3-119','MÃ¸terom'),(48,'C3-58','Grupperom'),(49,'C3-59','Grupperom'),(50,'C3-60','Grupperom'),(51,'C3-61','Auditorium'),(52,'C3-62','Grupperom'),(53,'D1-45','Auditorium'),(54,'D1-83','Grupperom'),(55,'D2-113','Grupperom'),(56,'D2-71','Grupperom'),(57,'D2-75','Auditorium'),(58,'D3-63','MÃ¸terom'),(59,'D3-71','Grupperom'),(60,'E1-13','MÃ¸terom'),(61,'E2-13','MÃ¸terom'),(62,'C1-11','Grupperom');
/*!40000 ALTER TABLE `room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roomtypes`
--

DROP TABLE IF EXISTS `roomtypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roomtypes` (
  `Roomtype` varchar(45) NOT NULL,
  PRIMARY KEY (`Roomtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomtypes`
--

LOCK TABLES `roomtypes` WRITE;
/*!40000 ALTER TABLE `roomtypes` DISABLE KEYS */;
INSERT INTO `roomtypes` VALUES ('Auditorium'),('Ballrom'),('Datalab'),('Grupperom'),('MÃ¸terom'),('Vaktrom');
/*!40000 ALTER TABLE `roomtypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `search`
--

DROP TABLE IF EXISTS `search`;
/*!50001 DROP VIEW IF EXISTS `search`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `search` (
  `Position` varchar(45),
  `Username` char(50),
  `Mail` varchar(50),
  `StartTime` time,
  `EndTime` time,
  `Dato` date,
  `BookingRef` char(8),
  `RoomName` varchar(45),
  `roomType` varchar(45)
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `setup`
--

DROP TABLE IF EXISTS `setup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setup` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Max_Hours` int(11) NOT NULL,
  `PreDays` int(2) NOT NULL,
  `Position_Id` int(11) NOT NULL,
  PRIMARY KEY (`Id`,`Max_Hours`),
  KEY `Position_Id_idx` (`Position_Id`),
  CONSTRAINT `Position_Id` FOREIGN KEY (`Position_Id`) REFERENCES `position` (`PositionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setup`
--

LOCK TABLES `setup` WRITE;
/*!40000 ALTER TABLE `setup` DISABLE KEYS */;
INSERT INTO `setup` VALUES (1,20,7,2),(2,40,14,1);
/*!40000 ALTER TABLE `setup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `time`
--

DROP TABLE IF EXISTS `time`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `time` (
  `Klokka` time NOT NULL,
  PRIMARY KEY (`Klokka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `time`
--

LOCK TABLES `time` WRITE;
/*!40000 ALTER TABLE `time` DISABLE KEYS */;
INSERT INTO `time` VALUES ('08:00:00'),('08:15:00'),('08:30:00'),('08:45:00'),('09:00:00'),('09:15:00'),('09:30:00'),('09:45:00'),('10:00:00'),('10:15:00'),('10:30:00'),('10:45:00'),('11:00:00'),('11:15:00'),('11:30:00'),('11:45:00'),('12:00:00'),('12:15:00'),('12:30:00'),('12:45:00'),('13:00:00'),('13:15:00'),('13:30:00'),('13:45:00'),('14:00:00'),('14:15:00'),('14:30:00'),('14:45:00'),('15:00:00'),('15:15:00'),('15:30:00'),('15:45:00'),('16:00:00'),('16:15:00'),('16:30:00'),('16:45:00'),('17:00:00'),('17:15:00'),('17:30:00'),('17:45:00'),('18:00:00'),('18:15:00'),('18:30:00'),('18:45:00'),('19:00:00'),('19:15:00'),('19:30:00'),('19:45:00'),('20:00:00');
/*!40000 ALTER TABLE `time` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `Username` char(50) NOT NULL,
  `Mail` varchar(50) NOT NULL,
  `Passord` char(45) NOT NULL,
  `Position_Id` int(11) NOT NULL,
  `Admin` tinyint(1) DEFAULT NULL,
  `Ref_User` char(8) NOT NULL,
  PRIMARY KEY (`UserId`,`Ref_User`),
  UNIQUE KEY `Ref_User_UNIQUE` (`Ref_User`),
  KEY `Stilling_Id_idx` (`Position_Id`),
  CONSTRAINT `Stilling_Id` FOREIGN KEY (`Position_Id`) REFERENCES `position` (`PositionId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'andlar','andersborglarsen@gmail.com','2rHXkMndjK1K2',2,1,'948-BHJH'),(3,'haolse','haavard@ringshaug.net','2rElCvCvTiVHY',2,1,'514-GDBK'),(4,'ogaute','oyvind.gautestad@gmail.com','2rJPjF4Y44IVE',2,1,'548-BRFK'),(5,'liferm','linda.fermann@gmail.com','2r5CHSllP1SYc',2,1,'846-NFDN'),(6,'student','student@hive.no','2r/8BfgCHP.mA',2,0,'789-GOGF'),(7,'ansatt','ansatt@hive.no','2ry1FYr184o6A',1,0,'418-BWFV'),(8,'admin','admin@hive.no','2rwmY/46uOHoE',1,1,'214-AGBK'),(69,'test','test@test.no','2r2nIBwJ2IrdQ',2,0,'323-WXNJ'),(73,'sara','sara@fossberg.net','2rUc81WS4G3V6',2,0,'868-PZZZ');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `search`
--

/*!50001 DROP TABLE IF EXISTS `search`*/;
/*!50001 DROP VIEW IF EXISTS `search`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`WEB10007`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `search` AS select `p`.`Type` AS `Position`,`u`.`Username` AS `Username`,`u`.`Mail` AS `Mail`,`b`.`Start_Time` AS `StartTime`,`b`.`End_Time` AS `EndTime`,`b`.`Dato` AS `Dato`,`b`.`Ref_Booking` AS `BookingRef`,`r`.`Name` AS `RoomName`,`rt`.`Roomtype` AS `roomType` from ((((`position` `p` join `roomtypes` `rt`) join `booking` `b`) join `room` `r`) join `user` `u`) where ((`b`.`Room_Id` = `r`.`RoomId`) and (`rt`.`Roomtype` = `r`.`Type`) and (`b`.`User_Ref` = `u`.`Ref_User`) and (`u`.`Position_Id` = `p`.`PositionId`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-04-26 12:18:01
