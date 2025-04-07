/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 8.0.17 : Database - dbrendimiento
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbrendimiento` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `dbrendimiento`;

/*Table structure for table `afectadostareas` */

DROP TABLE IF EXISTS `afectadostareas`;

CREATE TABLE `afectadostareas` (
  `idafectadotarea` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) DEFAULT NULL,
  `idtarea` int(11) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'P',
  `idempleado` int(11) DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `fechaobs` datetime DEFAULT NULL,
  PRIMARY KEY (`idafectadotarea`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `afectadostareas` */

insert  into `afectadostareas`(`idafectadotarea`,`numorden`,`idtarea`,`estado`,`idempleado`,`observacion`,`fechaobs`) values (1,'1234',6,'P',2,'SE INICIA TAREA','2025-02-14 15:42:09'),(2,'1234',6,'P',3,'SE INICIA TAREA','2025-02-14 15:42:12'),(3,'1234',2,'F',2,'SE REPARO TODO Y SE OCUPO TODO EL RESPUESTO','2025-02-14 15:50:09'),(4,'1473',1,'P',1,'SE INICIA TAREA','2025-02-14 15:40:03'),(5,'1473',1,'P',2,'SE INICIA TAREA','2025-02-14 15:40:06'),(6,'1473',1,'P',3,'SE INICIA TAREA','2025-02-14 15:40:09'),(7,'1234',2,'P',2,'SE INICIA TAREA','2025-02-14 15:43:12'),(8,'1473',1,'F',1,'SE DEJA TAREA POR DAÑO HERRAMIENTA','2025-02-14 15:45:20'),(9,'1473',1,'F',2,'SE DEJA TAREA PORQUE SE MANDA A LAVADERO','2025-02-14 15:46:00'),(10,'1473',1,'F',3,'SE CIERRA TAREA CAMBIANDO MATERIALES','2025-02-14 15:46:35'),(11,'1474',1,'P',2,'SE INICIA TAREA','2025-02-14 15:47:08'),(12,'1475',1,'F',2,'SE DEJA TAREA POR DAÑO HERRAMIENTA','2025-03-01 20:15:14'),(13,'1476',2,'F',3,'SE DEJA TAREA POR DAÑO PUERTA','2025-03-01 20:15:14'),(17,'1472',1,'F',86,'Se utilizo medio bote','2025-04-07 00:27:26'),(20,'1472',2,'F',86,'Se realizo cambio de aceite ok PRUEBA FINAL','2025-04-07 00:44:16');

/*Table structure for table `autorizaraccorden` */

DROP TABLE IF EXISTS `autorizaraccorden`;

CREATE TABLE `autorizaraccorden` (
  `idautorizar` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) DEFAULT NULL,
  `idpersona` int(11) DEFAULT NULL,
  `estado` varchar(1) DEFAULT NULL,
  `fechaautoriza` datetime DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idautorizar`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

/*Data for the table `autorizaraccorden` */

insert  into `autorizaraccorden`(`idautorizar`,`numorden`,`idpersona`,`estado`,`fechaautoriza`,`observacion`,`accion`,`fechaaccion`,`idempleadoaccion`) values (11,'1256',7,'A','2025-02-27 14:50:52','AUTORIZA','B','2025-03-27 15:21:32',84),(12,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(13,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(14,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(15,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-31 12:05:41',1),(16,'1256',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-27 15:21:32',84),(18,'1472',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:31:07',84),(19,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(20,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(21,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-31 12:05:41',1),(22,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(23,'1472',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-27 15:31:07',84),(24,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-31 12:05:41',1),(25,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(26,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-31 12:05:41',1),(27,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(28,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(29,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(30,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(31,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-31 12:05:41',1),(32,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(33,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 13:21:50',1),(34,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(35,'1234',1,'B','2025-03-11 12:31:33','DESVINCULAR','B','2025-03-11 13:21:50',1),(36,'1234',1,'B','2025-03-11 12:35:21','DESVINCULAR','B','2025-03-11 13:21:50',1),(37,'1234',1,'B','2025-03-11 12:37:49','DESVINCULAR','B','2025-03-11 13:21:50',1),(38,'1234',1,'B','2025-03-11 12:46:10','DESVINCULAR','B','2025-03-11 13:21:50',1),(39,'1474',1,'B','2025-03-11 12:48:22','DESVINCULAR','B','2025-03-31 12:05:41',1),(40,'1256',1,'B','2025-03-12 23:33:33','DESVINCULAR','B','2025-03-27 15:21:32',84),(41,'1256',1,'B','2025-03-12 23:33:33','DESVINCULAR','B','2025-03-27 15:21:32',84),(42,'1474',1,'B','2025-03-12 23:45:18','DESVINCULAR','B','2025-03-31 12:05:41',1),(43,'1256',77,'A','2025-03-15 14:13:32','AUTORIZA','B','2025-03-27 15:21:32',84),(44,'1256',78,'B',NULL,'DESVINCULAR','B','2025-03-27 15:21:32',84),(45,'1472',1,'N','2025-03-25 10:47:37','NO AUTORIZA','B','2025-03-27 15:31:07',84),(46,'1472',84,'A','2025-03-27 09:26:09','AUTORIZA','B','2025-03-27 15:31:07',84),(47,'1472',84,'A','2025-03-27 15:33:56','AUTORIZA','M','2025-03-27 15:33:56',84),(48,'1256',86,'B','2025-03-31 12:19:47','DESVINCULAR','B','2025-04-06 16:48:40',86),(49,'1234',86,'B',NULL,'DESVINCULAR','B','2025-04-06 16:48:37',86),(50,'1234',86,'B','2025-04-06 16:44:42','DESVINCULAR','B','2025-04-06 16:48:37',86),(51,'1472',86,'A','2025-04-06 16:49:20','AUTORIZA','M','2025-04-06 16:49:20',3);

/*Table structure for table `detalleorden` */

DROP TABLE IF EXISTS `detalleorden`;

CREATE TABLE `detalleorden` (
  `iddetalleorden` int(11) NOT NULL AUTO_INCREMENT,
  `numeroorden` varchar(30) DEFAULT NULL,
  `idtarea` int(11) DEFAULT NULL,
  `fini` datetime DEFAULT NULL,
  `ffin` datetime DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'S',
  `tiempotarea` time DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalleorden`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `detalleorden` */

insert  into `detalleorden`(`iddetalleorden`,`numeroorden`,`idtarea`,`fini`,`ffin`,`estado`,`tiempotarea`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'1234',1,NULL,NULL,'D','00:00:00',NULL,'N',1,'2025-02-10 22:07:32'),(2,'1234',2,'2025-02-10 23:56:29','2025-02-10 01:56:33','F','00:48:00','Se termino en tiempo y forma tarea','M',1,'2025-02-10 22:07:58'),(3,'1234',6,NULL,NULL,'P','00:00:00',NULL,'N',1,'2025-02-10 22:08:21'),(4,'1256',1,NULL,NULL,'D',NULL,NULL,'M',84,'2025-03-27 15:21:32'),(5,'1256',2,NULL,NULL,'D',NULL,NULL,'M',84,'2025-03-27 15:21:32'),(6,'1256',6,NULL,NULL,'D',NULL,NULL,'M',84,'2025-03-27 15:21:32'),(7,'1472',1,'2025-04-07 00:26:16','2025-04-07 00:27:26','F',NULL,'Se utilizo medio bote','M',86,'2025-04-07 00:27:26'),(8,'1472',2,'2025-04-07 00:43:28','2025-04-07 00:44:16','F',NULL,'Se realizo cambio de aceite ok PRUEBA FINAL','M',86,'2025-04-07 00:44:16'),(9,'1473',1,'2025-02-14 09:23:19','2025-02-14 11:23:21','F','01:20:00','SE TERMINO OK','M',1,'2025-02-14 11:23:01'),(10,'1474',1,'2025-02-14 11:26:28',NULL,'P',NULL,NULL,'M',1,'2025-02-14 11:27:04'),(11,'1474',6,NULL,NULL,'D',NULL,NULL,'N',1,'2025-02-14 11:27:06'),(12,'1475',1,'2025-02-01 20:24:38','2025-02-03 20:25:11','F',NULL,'SE TERMINO OK','N',1,'2025-02-03 20:25:53'),(13,'1476',2,'2025-02-04 20:24:48','2025-02-06 20:25:20','F',NULL,'SE TERMINO OK','N',2,'2025-02-07 20:26:01');

/*Table structure for table `disciplinas` */

DROP TABLE IF EXISTS `disciplinas`;

CREATE TABLE `disciplinas` (
  `iddisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `disciplina` varchar(30) DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `disciplinas` */

insert  into `disciplinas`(`iddisciplina`,`disciplina`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Administración','Gestión del sistema','N',1,'2025-03-25 10:45:35'),(2,'Clientes','Clientes','M',1,'2025-03-25 10:45:14'),(3,'Gerencia','Oficina de gerencia y dirección','N',1,'2025-02-01 12:56:03'),(4,'Mecanico','Oficina Tecnica','N',1,'2025-02-01 12:56:03');

/*Table structure for table `historialafectadostareas` */

DROP TABLE IF EXISTS `historialafectadostareas`;

CREATE TABLE `historialafectadostareas` (
  `idhistorial` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) DEFAULT NULL,
  `idtarea` int(11) DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'P',
  `idempleado` int(11) DEFAULT NULL,
  `observacion` varchar(100) DEFAULT NULL,
  `fechaobs` datetime DEFAULT NULL,
  `accion` varchar(1) DEFAULT 'N',
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`idhistorial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `historialafectadostareas` */

/*Table structure for table `numeroorden` */

DROP TABLE IF EXISTS `numeroorden`;

CREATE TABLE `numeroorden` (
  `idnumorden` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `numchasis` varchar(30) DEFAULT NULL,
  `patente` varchar(30) DEFAULT NULL,
  `kilometraje` varchar(10) DEFAULT NULL,
  `fventa` date DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'S',
  `tituloorden` varchar(50) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idnumorden`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `numeroorden` */

insert  into `numeroorden`(`idnumorden`,`numorden`,`fecha`,`idcliente`,`modelo`,`numchasis`,`patente`,`kilometraje`,`fventa`,`estado`,`tituloorden`,`accion`,`fechaaccion`,`idempleadoaccion`) values (1,'1234','2025-02-10 22:06:28',82,'FIAT UNO','A','ABC123','136000','2013-02-10','P','Service por 40.000 Kms','M','2025-02-14 12:37:54',1),(2,'1256','2025-02-13 18:00:14',82,'FIAT UNO','A','ABC123','142000','2025-02-13','D','fgsdf','M','2025-03-27 15:21:32',84),(3,'1472','2025-02-13 18:02:18',82,'FIAT UNO','A','ABC123','142000','2025-02-13','F','SAM 10000 km','M','2025-04-07 00:44:16',86),(4,'1473','2025-02-14 11:22:12',82,'MODELO23','B','WERWE41','142500','2025-02-14','F','Service por 20.000 Kms','M','2025-02-14 11:21:56',1),(5,'1474','2025-02-14 11:25:12',82,'WERWER33','C','54DDE65','475000','2025-02-14','P','Service por 50.000 Kms','N','2025-02-14 11:25:42',1),(6,'1475','2025-02-01 20:11:28',82,'FIAT UNO','A','ABC123','65465','2013-02-10','F','Service por 50.000 Kms','M','2025-02-14 11:25:42',1),(7,'1476','2025-02-04 20:11:28',82,'FIAT UNO','A','ABC123','66545','2013-02-10','F','Service por 50.000 Kms','M','2025-02-14 11:25:42',1);

/*Table structure for table `oficinas` */

DROP TABLE IF EXISTS `oficinas`;

CREATE TABLE `oficinas` (
  `idoficina` int(11) NOT NULL AUTO_INCREMENT,
  `nombreoficina` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idoficina`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `oficinas` */

insert  into `oficinas`(`idoficina`,`nombreoficina`) values (1,'Adminstración'),(2,'Cliente'),(3,'Gerencia'),(4,'Mecanica'),(5,'Otros');

/*Table structure for table `personas` */

DROP TABLE IF EXISTS `personas`;

CREATE TABLE `personas` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `apellido` varchar(30) DEFAULT NULL,
  `nombre` varchar(30) DEFAULT NULL,
  `nombrecortousu` varchar(15) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `nrosocio` varchar(20) DEFAULT NULL,
  `domicilio` varchar(60) DEFAULT NULL,
  `fnacimiento` date DEFAULT NULL,
  `idtipopersona` int(11) DEFAULT NULL,
  `emailusuario` varchar(30) DEFAULT NULL,
  `pass` varchar(30) DEFAULT NULL,
  `urlfoto` varchar(100) DEFAULT 'user.png',
  `tel` varchar(20) DEFAULT NULL,
  `idoficina` int(11) DEFAULT NULL,
  `aptoingreso` varchar(1) DEFAULT 'N',
  `finiapto` date DEFAULT NULL,
  `ffinapto` date DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpersona`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`apellido`,`nombre`,`nombrecortousu`,`dni`,`nrosocio`,`domicilio`,`fnacimiento`,`idtipopersona`,`emailusuario`,`pass`,`urlfoto`,`tel`,`idoficina`,`aptoingreso`,`finiapto`,`ffinapto`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Flores','Cesar','C. L. Flores','12345678','0','colon 123','1981-02-14',3,'admin@gmail.com','1234','avatar/team-4.jpg','',3,'S',NULL,NULL,'M',1,'2025-03-27 09:16:07'),(2,'gerente','','gerente','123456','gerente','calle 23','2000-01-01',3,'gerente@gmail.com','1234','avatar/84.jpg','',4,'S','2025-03-27','2025-04-27','M',84,'2025-03-27 15:19:11'),(3,'supervisor','','supervisor','12','supervisor1','c','2000-01-01',1,'supervisor@gmail.com','1234','avatar/85.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-03-27 09:18:20'),(79,'gerente','','gerente','1','gerente','salta 1','2000-01-01',4,'gerente@gmail.com',NULL,'user.png','',4,'S','2025-03-24','2025-04-24','B',1,'2025-03-24 23:36:38'),(80,'gerente','','gerente','123456','gerente','salta 1','2000-01-01',4,'gerente@gmail.com',NULL,'avatar/29.jpg','',4,'S','2025-03-24','2025-04-24','B',1,'2025-03-27 09:16:38'),(81,'administrador','','administrador','12345','admin1','salta 1','2000-01-01',2,'administrador@gmail.com',NULL,'user.png','',4,'S','2025-03-25','2025-04-25','B',1,'2025-03-27 09:16:12'),(82,'Perez','Juan','...','','','salta 123','0000-00-00',2,'cliente@gmail.com',NULL,'avatar/82.jpg','741155',2,'N','0000-00-00','0000-00-00','N',1,'2025-03-27 09:09:25'),(83,'prueba gerente','gerente prue','prugere','28680','gere1234','gere123','2000-02-01',4,'gere@gere.com',NULL,'user.png','381-5120-569',4,'S','2025-03-27','2025-04-27','B',1,'2025-03-27 09:07:36'),(86,'mecanico','','mecanico','12345','meca1','calle 23','2000-01-01',4,'mecanico@gmail.com','1234','avatar/86.jpg','',4,'S','2025-03-27','2025-04-27','M',86,'2025-03-31 12:19:10');

/*Table structure for table `personasvsdisciplinas` */

DROP TABLE IF EXISTS `personasvsdisciplinas`;

CREATE TABLE `personasvsdisciplinas` (
  `idpersonavsdisciplina` int(11) NOT NULL AUTO_INCREMENT,
  `idpersona` int(11) DEFAULT NULL,
  `iddisciplina` int(11) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`idpersonavsdisciplina`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

/*Data for the table `personasvsdisciplinas` */

insert  into `personasvsdisciplinas`(`idpersonavsdisciplina`,`idpersona`,`iddisciplina`,`accion`,`idempleadoaccion`,`fechaaccion`) values (43,1,3,'N',1,'2025-03-15 13:44:55'),(48,79,4,'B',1,'2025-03-24 23:36:38'),(49,80,4,'B',1,'2025-03-27 09:16:38'),(50,81,2,'B',1,'2025-03-27 09:16:12'),(51,82,3,'B',1,'2025-03-27 09:09:25'),(52,83,4,'B',1,'2025-03-27 09:07:36'),(53,84,3,'N',1,'2025-03-27 09:10:20'),(54,85,1,'N',1,'2025-03-27 09:18:06'),(55,86,4,'N',1,'2025-03-27 09:18:47');

/*Table structure for table `tareas` */

DROP TABLE IF EXISTS `tareas`;

CREATE TABLE `tareas` (
  `idtarea` int(11) NOT NULL AUTO_INCREMENT,
  `descripciontarea` varchar(100) DEFAULT NULL,
  `tiempotarea` time DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`idtarea`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `tareas` */

insert  into `tareas`(`idtarea`,`descripciontarea`,`tiempotarea`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Cambio Filtro','00:30:00','M',1,'2025-02-14 12:45:23'),(2,'Cambio Aceite','00:30:00','M',1,'2025-02-07 12:47:48'),(3,'Cambio foco guiño derecho delantero','01:00:00','N',1,'2025-02-07 12:01:48'),(4,'Cambio de luz de freno trasera','01:00:00','N',1,'2025-02-07 12:01:48'),(5,'Cambio foco guiño izquierdo delantero','01:00:00','N',1,'2025-02-07 12:01:48'),(6,'Cambio de una cubierta','00:20:00','M',1,'2025-02-07 16:39:55'),(7,'cambio','12:00:00','B',1,'2025-02-07 12:49:31'),(8,'Cabio de una cubierta 2345','15:00:00','B',1,'2025-03-04 02:57:07'),(9,'dedsde','12:00:00','B',1,'2025-03-25 10:46:53'),(10,'pruebadfsdf','12:00:00','B',85,'2025-03-27 09:24:25');

/*Table structure for table `tipopersona` */

DROP TABLE IF EXISTS `tipopersona`;

CREATE TABLE `tipopersona` (
  `idtipopersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipopersona` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idtipopersona`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tipopersona` */

insert  into `tipopersona`(`idtipopersona`,`tipopersona`) values (1,'Administración'),(2,'Cliente'),(3,'Gerente'),(4,'Mecanico'),(5,'Otros');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
