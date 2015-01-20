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
) ENGINE=InnoDB AUTO_INCREMENT=254 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking`
--

LOCK TABLES `booking` WRITE;
/*!40000 ALTER TABLE `booking` DISABLE KEYS */;
INSERT INTO `booking` VALUES (26,'514-GDBK','08:00:01','20:00:00','2013-05-02',24,'CNZ-8658'),(47,'514-GDBK','12:00:01','16:30:00','2013-04-27',2,'KGH-7249'),(48,'161-ZFMB','08:00:01','11:00:00','2013-04-27',54,'NKS-6166'),(54,'214-AGBK','17:30:01','18:00:00','2013-04-27',8,'MRZ-1273'),(59,'846-NFDN','13:00:01','18:00:00','2013-04-27',17,'MPY-7886'),(60,'846-NFDN','10:00:01','12:00:00','2013-04-27',2,'ZYW-4973'),(62,'241-GSCS','10:15:01','20:00:00','2013-04-27',66,'JVV-6244'),(63,'241-GSCS','08:00:01','14:00:00','2013-04-29',66,'HCX-1375'),(64,'241-GSCS','08:00:01','11:00:00','2013-04-29',18,'VCX-8322'),(69,'846-NFDN','14:00:01','19:15:00','2013-05-01',17,'SWS-9416'),(75,'948-BHJH','10:45:01','20:00:00','2013-04-27',45,'DFQ-8183'),(76,'846-NFDN','09:00:01','13:00:00','2013-04-28',25,'QWK-6617'),(77,'846-NFDN','08:00:01','09:00:00','2013-04-28',25,'STD-3281'),(78,'846-NFDN','10:00:01','12:00:00','2013-04-29',16,'SKX-7831'),(79,'846-NFDN','14:15:01','16:45:00','2013-04-29',16,'YFY-5954'),(80,'846-NFDN','12:15:01','14:00:00','2013-04-30',16,'BVH-3962'),(81,'846-NFDN','14:15:01','15:45:00','2013-05-01',16,'NKB-4453'),(82,'846-NFDN','11:15:01','17:00:00','2013-04-28',20,'JWP-8855'),(83,'846-NFDN','12:00:01','15:00:00','2013-04-28',18,'SVJ-8432'),(84,'846-NFDN','12:00:01','14:00:00','2013-05-06',16,'PZM-9619'),(85,'214-AGBK','08:00:01','20:00:00','2013-05-03',16,'QGZ-7326'),(86,'846-NFDN','08:00:01','12:00:00','2013-05-07',16,'TRX-8647'),(87,'846-NFDN','12:00:01','16:00:00','2013-05-08',16,'FCM-7444'),(91,'323-WXNJ','08:30:01','20:00:00','2013-04-28',19,'JRP-4492'),(94,'177-NGDF','13:00:01','13:15:00','2013-04-28',2,'TTV-3439'),(95,'177-NGDF','14:00:01','14:15:00','2013-04-28',66,'KQN-2167'),(96,'323-WXNJ','08:00:01','16:00:00','2013-04-29',19,'MXC-4473'),(97,'323-WXNJ','08:00:01','08:15:00','2013-04-29',20,'PHG-8974'),(100,'323-WXNJ','12:00:01','12:15:00','2013-04-30',19,'XMG-2918'),(106,'177-NGDF','16:00:01','18:15:00','2013-04-28',7,'SYH-7824'),(107,'846-NFDN','18:30:01','20:00:00','2013-04-28',16,'QMD-5937'),(108,'177-NGDF','18:00:01','19:00:00','2013-04-28',59,'CGS-8977'),(109,'177-NGDF','18:00:01','19:00:00','2013-04-28',66,'RHT-1268'),(111,'177-NGDF','17:00:01','20:00:00','2013-04-28',6,'NHZ-2285'),(112,'177-NGDF','16:15:01','19:00:00','2013-04-28',9,'BXG-1995'),(113,'177-NGDF','11:00:01','12:00:00','2013-04-29',23,'JQZ-5142'),(114,'177-NGDF','17:45:01','20:00:00','2013-05-05',44,'RJY-2452'),(115,'846-NFDN','08:30:01','10:30:00','2013-04-29',68,'MDN-9911'),(116,'846-NFDN','08:30:01','10:30:00','2013-04-30',19,'GCQ-6968'),(117,'527-FRNB','08:00:01','14:00:00','2013-04-30',62,'HCH-2819'),(118,'527-FRNB','13:30:01','17:00:00','2013-04-29',11,'KTW-2969'),(119,'117-JKDT','10:45:01','14:30:00','2013-04-29',8,'DFB-3756'),(120,'117-JKDT','13:00:01','15:00:00','2013-04-30',23,'VPM-7267'),(121,'117-JKDT','08:30:01','12:00:00','2013-05-03',2,'SMJ-7989'),(122,'161-ZFMB','13:00:01','15:30:00','2013-04-30',40,'FHQ-5644'),(123,'161-ZFMB','17:30:01','19:00:00','2013-05-02',51,'KWN-6289'),(124,'161-ZFMB','08:00:01','11:00:00','2013-05-10',51,'YHR-5662'),(125,'795-TKHQ','11:15:01','14:00:00','2013-05-02',11,'TGM-4983'),(126,'795-TKHQ','08:30:01','14:30:00','2013-05-03',54,'FDH-5311'),(127,'795-TKHQ','17:30:01','19:45:00','2013-05-01',6,'GGN-3481'),(128,'516-MWBD','11:30:01','17:30:00','2013-05-03',34,'TKP-8526'),(129,'516-MWBD','09:30:01','12:00:00','2013-05-10',21,'YKP-3256'),(130,'516-MWBD','16:00:01','19:00:00','2013-05-09',61,'MFV-5977'),(131,'516-MWBD','08:45:01','11:30:00','2013-05-08',23,'FYN-1962'),(133,'516-MWBD','12:00:01','14:15:00','2013-05-03',37,'VDT-5645'),(134,'747-GJYP','11:45:01','16:00:00','2013-05-02',33,'DGZ-5154'),(135,'747-GJYP','08:00:01','09:15:00','2013-05-02',11,'THS-8437'),(136,'747-GJYP','16:00:01','18:30:00','2013-05-03',12,'CRT-2474'),(137,'323-GHZD','10:15:01','12:00:00','2013-05-03',27,'KDG-8213'),(138,'323-GHZD','09:30:01','15:00:00','2013-05-05',36,'SFG-4427'),(139,'782-ZJTF','13:45:01','18:00:00','2013-05-03',6,'SQH-5377'),(140,'782-ZJTF','11:15:01','14:00:00','2013-04-30',11,'TKJ-4477'),(141,'863-ZXYK','08:00:01','13:00:00','2013-05-04',11,'TRZ-2889'),(143,'791-YKNH','14:00:01','18:30:00','2013-05-02',27,'PDN-1422'),(144,'791-YKNH','09:30:01','14:00:00','2013-05-01',33,'PRM-2743'),(145,'171-YTTB','08:30:01','10:30:00','2013-05-02',27,'MMH-9263'),(146,'171-YTTB','10:00:01','15:00:00','2013-05-03',44,'FVW-9782'),(147,'582-JSVS','10:45:01','13:00:00','2013-05-03',57,'DQQ-7715'),(148,'582-JSVS','08:30:01','09:45:00','2013-05-03',57,'WWC-3358'),(149,'582-JSVS','12:30:01','15:30:00','2013-05-02',49,'KZB-6819'),(150,'563-GFMK','09:00:01','15:00:00','2013-05-05',43,'VSB-5958'),(151,'563-GFMK','15:00:01','18:00:00','2013-05-02',39,'PFX-5774'),(152,'462-XQJZ','11:00:01','15:00:00','2013-05-03',36,'BGH-2616'),(153,'752-KKYG','10:30:01','12:00:00','2013-05-02',54,'JGN-6214'),(154,'752-KKYG','13:00:01','15:00:00','2013-05-03',11,'MCV-9261'),(155,'943-WFKJ','08:30:01','11:00:00','2013-05-04',10,'WDY-3471'),(156,'943-WFKJ','10:00:01','13:00:00','2013-05-03',9,'BKS-2344'),(157,'529-BMMR','09:45:01','11:00:00','2013-05-03',12,'CBF-6892'),(158,'671-XVQB','09:00:01','11:30:00','2013-05-03',8,'KJX-1453'),(160,'671-XVQB','12:00:01','13:30:00','2013-05-02',8,'FNN-9695'),(161,'177-NGDF','10:30:01','14:45:00','2013-05-03',23,'PWJ-2567'),(162,'527-FRNB','13:15:01','15:00:00','2013-05-02',2,'TBX-9165'),(163,'234-SRRK','13:00:01','14:00:00','2013-05-03',2,'RHJ-2937'),(164,'234-SRRK','10:00:01','14:15:00','2013-05-05',6,'QKW-7416'),(165,'792-YZSX','08:00:01','12:00:00','2013-05-03',21,'TNF-4775'),(166,'792-YZSX','10:00:01','13:00:00','2013-05-12',19,'MXH-3747'),(167,'792-YZSX','08:00:01','11:00:00','2013-05-11',16,'CNG-5375'),(168,'792-YZSX','12:00:01','18:00:00','2013-05-09',22,'JFZ-5515'),(169,'792-YZSX','09:15:01','13:00:00','2013-05-08',21,'QYJ-3549'),(170,'792-YZSX','13:00:01','15:00:00','2013-05-07',51,'QJZ-6571'),(171,'792-YZSX','11:00:01','16:00:00','2013-05-06',34,'PTZ-6625'),(172,'792-YZSX','15:00:01','15:30:00','2013-05-04',13,'ZQM-7784'),(173,'123-FPTN','13:15:01','15:00:00','2013-05-01',44,'MWG-3461'),(174,'123-FPTN','08:45:01','12:00:00','2013-05-10',13,'ZDN-1841'),(175,'123-FPTN','12:00:01','13:30:00','2013-05-09',35,'BYT-8698'),(176,'123-FPTN','11:00:01','13:00:00','2013-05-13',58,'BFF-1924'),(177,'123-FPTN','08:00:01','10:30:00','2013-05-08',1,'CXM-4482'),(178,'123-FPTN','09:00:01','11:15:00','2013-05-07',31,'ZQH-4859'),(179,'975-FMKR','12:00:01','13:00:00','2013-05-10',59,'TMJ-4211'),(180,'975-FMKR','10:00:01','14:00:00','2013-05-13',21,'VZK-5366'),(181,'975-FMKR','08:00:01','09:30:00','2013-05-08',33,'YQJ-7785'),(182,'427-MBXJ','09:30:01','13:15:00','2013-05-17',18,'JZF-8469'),(183,'427-MBXJ','10:00:01','14:00:00','2013-05-24',68,'DHC-4818'),(184,'427-MBXJ','14:00:01','18:00:00','2013-06-06',20,'GHS-4548'),(185,'427-MBXJ','10:00:01','14:30:00','2013-05-22',17,'GYP-1458'),(186,'427-MBXJ','10:00:01','12:00:00','2013-05-06',24,'JFK-9655'),(187,'893-GXTJ','08:15:01','12:45:00','2013-05-08',51,'TGZ-6237'),(188,'653-KRCW','08:15:01','11:45:00','2013-05-15',68,'KTF-5446'),(189,'653-KRCW','12:00:01','13:45:00','2013-05-10',18,'VQZ-5795'),(190,'653-KRCW','10:15:01','13:15:00','2013-05-16',8,'TKK-6446'),(191,'427-MBXJ','12:45:01','16:15:00','2013-05-01',12,'DTN-3675'),(192,'427-MBXJ','16:15:01','19:30:00','2013-05-02',6,'HGS-6647'),(193,'655-QBPT','11:15:01','12:15:00','2013-05-14',8,'VSC-1843'),(194,'427-MBXJ','14:15:01','16:30:00','2013-05-03',19,'YJN-6836'),(195,'655-QBPT','12:00:01','13:00:00','2013-05-16',23,'QTN-1542'),(196,'283-GFVF','11:00:01','13:00:00','2013-05-31',56,'RFY-4338'),(197,'427-MBXJ','08:00:01','19:00:00','2013-05-04',8,'JRG-6256'),(198,'427-MBXJ','08:30:01','13:00:00','2013-05-05',21,'RNW-5563'),(199,'283-GFVF','09:00:01','14:00:00','2013-05-24',56,'HDX-4784'),(200,'427-MBXJ','12:45:01','15:15:00','2013-05-06',66,'TYM-5369'),(201,'283-GFVF','09:00:01','15:00:00','2013-05-17',56,'CMV-8769'),(202,'427-MBXJ','12:00:01','15:15:00','2013-05-07',18,'JBW-4156'),(203,'427-MBXJ','09:45:01','17:15:00','2013-05-08',42,'VRF-3367'),(204,'167-VJHP','09:00:01','13:00:00','2013-05-23',54,'VPX-1825'),(205,'283-GFVF','12:00:01','15:00:00','2013-05-10',56,'CKT-3482'),(206,'427-MBXJ','08:00:01','20:00:00','2013-05-09',8,'VKC-3849'),(207,'427-MBXJ','14:00:01','15:00:00','2013-05-10',19,'QZM-5283'),(208,'427-MBXJ','08:00:01','16:00:00','2013-05-11',18,'XQZ-8521'),(209,'283-GFVF','12:00:01','15:00:00','2013-05-10',46,'CBP-5663'),(210,'167-VJHP','10:00:01','17:00:00','2013-05-11',54,'TTF-5749'),(211,'427-MBXJ','12:00:01','20:00:00','2013-05-13',40,'VXQ-4628'),(212,'427-MBXJ','16:00:01','20:00:00','2013-05-14',8,'ZQS-6452'),(213,'283-GFVF','08:00:01','15:00:00','2013-05-15',34,'TWD-1745'),(214,'167-VJHP','08:00:01','11:00:00','2013-05-14',54,'KBP-1554'),(215,'427-MBXJ','14:00:01','17:00:00','2013-05-14',66,'KPH-2243'),(216,'427-MBXJ','14:00:01','16:30:00','2013-05-15',18,'KGM-7421'),(217,'427-MBXJ','15:00:01','18:00:00','2013-05-16',21,'GGR-5694'),(218,'427-MBXJ','14:00:01','16:00:00','2013-05-17',8,'VHC-7993'),(219,'167-VJHP','08:00:01','12:00:00','2013-05-17',55,'TRT-7638'),(220,'427-MBXJ','10:45:01','17:15:00','2013-05-18',18,'HYF-3688'),(221,'427-MBXJ','09:30:01','16:45:00','2013-05-20',21,'QSN-7219'),(222,'167-VJHP','16:00:01','20:00:00','2013-05-20',32,'FYY-7244'),(223,'283-GFVF','12:00:01','16:00:00','2013-05-06',59,'PSM-7882'),(224,'167-VJHP','11:00:01','15:00:00','2013-05-23',8,'JFQ-6365'),(225,'283-GFVF','09:00:01','15:00:00','2013-05-13',59,'PBF-1739'),(226,'653-KRCW','08:00:01','20:00:00','2013-05-31',8,'SHG-9216'),(227,'653-KRCW','08:00:01','20:00:00','2013-05-30',8,'MMR-2617'),(228,'653-KRCW','10:00:01','18:00:00','2013-05-29',8,'RRX-2535'),(229,'653-KRCW','12:00:01','16:00:00','2013-05-28',8,'SBH-9722'),(230,'283-GFVF','10:15:01','17:00:00','2013-05-21',51,'NMB-8234'),(231,'653-KRCW','14:15:01','15:30:00','2013-05-27',23,'HDK-1793'),(232,'283-GFVF','08:00:01','12:00:00','2013-05-27',28,'WJN-2689'),(233,'653-KRCW','09:15:01','16:00:00','2013-05-23',23,'FMN-9442'),(234,'283-GFVF','08:00:01','12:00:00','2013-05-24',35,'BGG-4183'),(235,'653-KRCW','13:00:01','13:30:00','2013-05-15',21,'PGB-4428'),(236,'283-GFVF','08:00:01','19:00:00','2013-05-07',41,'RVP-6189'),(237,'655-QBPT','10:30:01','13:15:00','2013-05-23',2,'FBF-6363'),(238,'653-KRCW','12:00:01','15:00:00','2013-05-15',8,'VMM-2812'),(239,'167-VJHP','12:00:01','16:00:00','2013-05-24',8,'JSB-4651'),(240,'653-KRCW','11:15:01','16:30:00','2013-05-13',8,'VMY-6168'),(241,'653-KRCW','14:30:01','17:30:00','2013-05-09',18,'HXB-2837'),(242,'283-GFVF','13:00:01','17:00:00','2013-05-16',51,'JMM-2327'),(243,'863-ZXYK','12:00:01','16:00:00','2013-05-06',8,'WFW-7694'),(244,'827-PCJD','10:30:01','15:15:00','2013-05-13',66,'QSW-9881'),(245,'167-VJHP','08:00:01','13:00:00','2013-05-25',68,'VCG-3233'),(246,'827-PCJD','12:00:01','19:00:00','2013-05-12',21,'NCK-4884'),(247,'655-QBPT','10:00:01','11:45:00','2013-05-22',21,'BGP-5125'),(248,'655-QBPT','09:00:01','12:00:00','2013-05-01',2,'ZHC-4375'),(249,'214-AGBK','11:00:01','15:00:00','2013-05-27',8,'RJV-5159'),(250,'214-AGBK','12:45:01','16:15:00','2013-05-16',6,'QHM-1469'),(251,'655-QBPT','13:15:01','16:00:00','2013-05-21',2,'KSW-4119'),(252,'214-AGBK','11:00:01','18:30:00','2013-05-17',23,'ZXQ-1277'),(253,'655-QBPT','13:00:01','16:00:00','2013-05-23',33,'KTT-9678');
/*!40000 ALTER TABLE `booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookinghistory`
--

DROP TABLE IF EXISTS `bookinghistory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookinghistory` (
  `bookingId` int(11) NOT NULL DEFAULT '0',
  `User_Ref` char(8) DEFAULT NULL,
  `Start_Time` time DEFAULT NULL,
  `End_Time` time DEFAULT NULL,
  `Dato` date DEFAULT NULL,
  `Room_Id` int(8) DEFAULT NULL,
  `Ref_Booking` char(8) DEFAULT NULL,
  PRIMARY KEY (`bookingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookinghistory`
--

LOCK TABLES `bookinghistory` WRITE;
/*!40000 ALTER TABLE `bookinghistory` DISABLE KEYS */;
/*!40000 ALTER TABLE `bookinghistory` ENABLE KEYS */;
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
  PRIMARY KEY (`RoomId`,`Type`),
  KEY `type_idx` (`Type`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room`
--

LOCK TABLES `room` WRITE;
/*!40000 ALTER TABLE `room` DISABLE KEYS */;
INSERT INTO `room` VALUES (1,'A2-98','MÃ¸terom'),(2,'A1-50','Grupperom'),(6,'A2-50','Grupperom'),(7,'A2-51','Grupperom'),(8,'A1-23','Grupperom'),(9,'A2-52','Grupperom'),(10,'A2-53','Grupperom'),(11,'A2-54','Grupperom'),(12,'A2-55','Grupperom'),(13,'A2-56','MÃ¸terom'),(14,'A2-56','Grupperom'),(15,'A2-57','MÃ¸terom'),(16,'A1-19','MÃ¸terom'),(17,'A1-21','Auditorium'),(18,'A1-11','Auditorium'),(19,'A1-12','MÃ¸terom'),(20,'A1-14','Auditorium'),(21,'A1-16','Datalab'),(22,'A1-17','MÃ¸terom'),(23,'A1-30','Grupperom'),(24,'B1-43','Auditorium'),(25,'B1-50','Auditorium'),(26,'B1-60','Auditorium'),(27,'B2-30','Grupperom'),(28,'B2-48','Auditorium'),(29,'C1-11','MÃ¸terom'),(30,'C1-13','MÃ¸terom'),(31,'C1-14','MÃ¸terom'),(32,'C1-15','Grupperom'),(33,'C1-16','Grupperom'),(34,'C1-17','MÃ¸terom'),(35,'C1-18','MÃ¸terom'),(36,'C1-19','Grupperom'),(37,'C1-20','MÃ¸terom'),(38,'C1-21','MÃ¸terom'),(39,'C1-30','Grupperom'),(40,'C2-120','Datalab'),(41,'C2-125','Auditorium'),(42,'C2-131','Datalab'),(43,'C2-74','Grupperom'),(44,'C2-95','Grupperom'),(45,'C2-99','MÃ¸terom'),(46,'C2-80','Auditorium'),(47,'C3-119','MÃ¸terom'),(48,'C3-58','MÃ¸terom'),(49,'C3-59','Grupperom'),(50,'C3-60','MÃ¸terom'),(51,'C3-61','Datalab'),(52,'C3-62','MÃ¸terom'),(53,'D1-45','Auditorium'),(54,'D1-83','Grupperom'),(55,'D2-113','MÃ¸terom'),(56,'D2-71','Auditorium'),(57,'D2-75','Grupperom'),(58,'D3-63','MÃ¸terom'),(59,'D3-71','Datalab'),(61,'E2-13','MÃ¸terom'),(62,'C1-11','Grupperom'),(66,'A1-10','MÃ¸terom'),(68,'A1-12','Auditorium');
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
  `TypeId` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`TypeId`,`Roomtype`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roomtypes`
--

LOCK TABLES `roomtypes` WRITE;
/*!40000 ALTER TABLE `roomtypes` DISABLE KEYS */;
INSERT INTO `roomtypes` VALUES ('Auditorium',1),('Datalab',3),('MÃ¸terom',6);
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
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'andlar','andersborglarsener@a.no','2refrVn5aC2Xw',2,1,'948-BHJH'),(3,'haolse','haavard@ringshaug.net','2rElCvCvTiVHY',2,1,'514-GDBK'),(5,'liferm','linda.fermann@gmail.com','2r5CHSllP1SYc',2,1,'846-NFDN'),(6,'student','student@hive.no','2r/8BfgCHP.mA',2,0,'789-GOGF'),(7,'ansatt','ansatt@hive.no','2ry1FYr184o6A',1,0,'418-BWFV'),(8,'admin','admin@hive.no','2rwmY/46uOHoE',1,1,'214-AGBK'),(69,'testtest','testtest@testtest.no','2rFQtA4P9GKvM',2,0,'323-WXNJ'),(74,'therese','therese@hive.no','2rVkRQ5halO1A',1,0,'161-ZFMB'),(75,'gustav','gustav@student.hive.no','2rLHi8g8cyeHI',2,0,'117-JKDT'),(78,'fredrik','fredrik@student.hive.no','2rVrmy4kDLubc',2,0,'795-TKHQ'),(79,'junimarie','junimarie@student.hive.no','2refrVn5aC2Xw',2,0,'241-GSCS'),(80,'henriette','henriette@student.hive.no','2rfaWiM0QT3A2',2,0,'747-GJYP'),(81,'susanne','susanne@student.hive.no','2ri2gyr6pyQfU',2,0,'323-GHZD'),(83,'markus','markus@student.hive.no','2rmd/NalSK1AY',2,0,'782-ZJTF'),(84,'karianne','karianne@student.hive.no','2rWgMXfxh./TY',2,0,'863-ZXYK'),(85,'petter','petter@student.hive.no','2rsFh0m5qfJys',2,0,'791-YKNH'),(86,'christian','christian@student.hive.no','2r8EoxF1Yj.pY',2,0,'171-YTTB'),(89,'morgan','morgan@student.hive.no','2r25ploGmR7Gg',2,0,'582-JSVS'),(90,'marianne','marianne@student.hive.no','2rxj1IVNp0oy6',2,0,'563-GFMK'),(92,'matias','matias@student.hive.no','2rLSMAycc19Yw',2,0,'462-XQJZ'),(93,'kristine','kristine@student.hive.no','2rvjtR8cZP/4I',2,0,'752-KKYG'),(97,'reidar','reidar@student.hive.no','2rls/HYZfWpgc',2,0,'943-WFKJ'),(107,'carina','carina@student.hive.no','2rVsBWz3VZbeY',2,0,'529-BMMR'),(108,'anders','anders@student.hive.no','2rmbjrzXnbxeY',2,0,'671-XVQB'),(111,'henrik','henrik@student.hive.no','2rZsIYjvy871A',2,0,'177-NGDF'),(112,'ogauteStudent','ogaute@hive.no','2rYXlwNkrDG.k',2,0,'288-HMPN'),(113,'ogaute','oyvind.gautestad@gmail.com','2rJPjF4Y44IVE',2,1,'141-SMMF'),(114,'margrete','margrete@hive.no','2r39PwABRMmQQ',1,0,'516-MWBD'),(115,'kristoffer','kristoffer@student.hive.no','2rblZ2ukEQj.M',2,0,'527-FRNB'),(116,'morten','morten@student.hive.no','2rD3FHCt.v0sg',2,0,'234-SRRK'),(118,'merete','merete@hive.no','2rmFz54bYBeGg',1,0,'792-YZSX'),(119,'birger','birger@hive.no','2rDrYiXmz2grQ',1,0,'123-FPTN'),(121,'robert','robert@hive.no','2rmlgE6BBf3rY',1,0,'975-FMKR'),(122,'marthine','martine@hive.no','2r5zXyuewryi2',1,0,'378-XHWD'),(123,'theodor','theodor@hive.no','2rgUqJTGQcUf2',1,0,'831-HGBP'),(124,'ingrid','ingrid@hive.no','2ru6wU5cOodg6',1,0,'429-RDJR'),(125,'kasper','kasper@hive.no','2rosZKDbspIqs',1,0,'893-GXTJ'),(126,'andlars','andlars@hive.no','2rsn5vy.teS86',2,0,'116-CZFJ'),(127,'daniel','daniel@hive.no','2rOjjgWGSvybk',1,0,'463-BTKV'),(128,'sandra','sandra@hive.no','2rnqbyxtwd1gg',1,0,'932-NJJV'),(129,'monika','monika@hive.no','2rpk5xocDeKkM',1,0,'981-MRXM'),(130,'andrea','andrea@hive.no','2rUoAcqRUTbO.',1,0,'225-WKWF'),(131,'jesper','jesper@hive.no','2r0z4vLj7reGc',1,0,'971-FSPV'),(132,'magnus','magnus@hive.no','2rY8UTQEnCTQ6',1,0,'671-XKWP'),(133,'kamilla','kamilla@hive.no','2ru9/HGM20.ug',1,0,'827-PCJD'),(134,'pernille','pernille@hive.no','2rNjWomFrrq2M',1,0,'732-FSGK'),(135,'ulrikke','ulrikke@hive.no','2r3Eo/oo5ELUg',1,0,'292-ZBZM'),(136,'aleksander','aleksander@hive.no','2rj0ZvsR3rOjA',1,0,'784-TMHZ'),(137,'amalie','amalie@hive.no','2rxOd1rR9OblE',1,0,'322-GNCS'),(138,'andreas','andreas@hive.no','2rq39oADNTM3M',1,1,'653-KRCW'),(139,'tobias','tobias@hive.no','2rfhSNg4Iwhi.',1,1,'167-VJHP'),(140,'sunniva','sunniva@hive.no','2rHXkMndjK1K2',1,1,'283-GFVF'),(141,'mathilde','mathilde@hive.no','2rwAxkE9u6tKU',1,1,'469-RHMQ'),(142,'sebastian','sebastian@hive.no','2rnL.PHxegE3c',1,1,'655-QBPT'),(143,'yvonne','yvonne@hive.no','2rVmOeQj6V0cA',1,1,'839-YJGF'),(144,'aurora','aurora@hive.no','2rhZh5ML1pihc',1,1,'427-MBXJ');
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

-- Dump completed on 2013-04-29 10:07:21
