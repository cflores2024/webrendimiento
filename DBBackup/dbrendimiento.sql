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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

/*Data for the table `afectadostareas` */

insert  into `afectadostareas`(`idafectadotarea`,`numorden`,`idtarea`,`estado`,`idempleado`,`observacion`,`fechaobs`) values (44,'10031245',84,'F',137,'tarea ok','2025-04-26 22:09:25'),(45,'10031244',85,'F',86,'tarea ok','2025-04-27 02:17:17'),(46,'170804',86,'P',137,'SE INICIA TAREA','2025-04-27 00:08:43'),(47,'170803',87,'F',86,'tarea ok','2025-04-27 03:27:41'),(48,'170803',88,'P',86,'SE INICIA TAREA','2025-04-27 03:27:43');

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
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

/*Data for the table `autorizaraccorden` */

insert  into `autorizaraccorden`(`idautorizar`,`numorden`,`idpersona`,`estado`,`fechaautoriza`,`observacion`,`accion`,`fechaaccion`,`idempleadoaccion`) values (69,'10031245',86,'A','2025-04-26 21:11:25','AUTORIZA','M','2025-04-26 21:11:25',86),(70,'10031245',137,'B','2025-04-26 21:46:06','DESVINCULAR','B','2025-04-26 22:07:48',137),(71,'10031245',137,'A','2025-04-26 22:08:18','AUTORIZA','M','2025-04-26 22:08:18',137),(72,'10031244',137,'B','2025-04-26 22:22:38','DESVINCULAR','B','2025-04-27 00:03:27',137),(73,'10031244',86,'A','2025-04-26 23:57:23','AUTORIZA','M','2025-04-26 23:57:23',86),(74,'10031244',137,'A','2025-04-27 00:04:57','AUTORIZA','M','2025-04-27 00:04:57',137),(75,'170804',137,'A','2025-04-27 00:08:31','AUTORIZA','M','2025-04-27 00:08:31',137),(76,'170804',86,'A','2025-04-27 00:10:49','AUTORIZA','M','2025-04-27 00:10:49',86),(77,'170803',86,'A','2025-04-27 03:22:14','AUTORIZA','M','2025-04-27 03:22:14',86);

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
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8;

/*Data for the table `detalleorden` */

insert  into `detalleorden`(`iddetalleorden`,`numeroorden`,`idtarea`,`fini`,`ffin`,`estado`,`tiempotarea`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (140,'10031245',84,'2025-04-26 21:11:40','2025-04-26 22:09:25','F','00:00:00','tarea ok','M',137,'2025-04-26 22:09:25'),(141,'10031244',85,'2025-04-26 22:26:45','2025-04-27 02:17:17','F','00:00:00','tarea ok','M',86,'2025-04-27 02:17:17'),(142,'170804',86,'2025-04-27 00:08:43',NULL,'P','00:00:00',NULL,'M',137,'2025-04-27 00:08:43'),(143,'170803',87,'2025-04-27 03:22:23','2025-04-27 03:27:41','F','00:00:00','tarea ok','M',86,'2025-04-27 03:27:41'),(144,'170803',88,'2025-04-27 03:27:43',NULL,'P','00:00:00',NULL,'M',86,'2025-04-27 03:27:43'),(145,'170803',89,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 00:27:05'),(146,'170802',90,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:51'),(147,'170801',91,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:52'),(148,'170800',92,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:55'),(149,'170800',93,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:55'),(150,'170800',94,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:55'),(151,'170800',95,NULL,NULL,'D','00:00:00',NULL,'M',3,'2025-04-27 03:21:55');

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

/*Table structure for table `numeroorden` */

DROP TABLE IF EXISTS `numeroorden`;

CREATE TABLE `numeroorden` (
  `idnumorden` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `fechaentrega` date DEFAULT NULL,
  `idcliente` int(11) DEFAULT NULL,
  `modelo` varchar(30) DEFAULT NULL,
  `numchasis` varchar(30) DEFAULT NULL,
  `patente` varchar(30) DEFAULT NULL,
  `kilometraje` varchar(10) DEFAULT NULL,
  `fventa` date DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'S',
  `tituloorden` varchar(50) DEFAULT NULL,
  `idpersonadisp` int(11) DEFAULT NULL,
  `accion` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idnumorden`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

/*Data for the table `numeroorden` */

insert  into `numeroorden`(`idnumorden`,`numorden`,`fecha`,`fechaentrega`,`idcliente`,`modelo`,`numchasis`,`patente`,`kilometraje`,`fventa`,`estado`,`tituloorden`,`idpersonadisp`,`accion`,`fechaaccion`,`idempleadoaccion`) values (51,'10031245','2025-03-21 16:15:00','2025-03-21',136,NULL,'SYG97014','0','1',NULL,'F','Orden de trabajo N° 10031245',3,'M','2025-03-26 22:09:25',137),(52,'10031244','2025-04-22 16:13:00','2025-04-22',138,NULL,'SYA25790','0','1',NULL,'F','Orden de trabajo N° 10031244',3,'M','2025-04-27 02:17:17',86),(53,'170804','2025-04-21 17:27:00','2025-04-21',139,NULL,'YB68916','0','4137',NULL,'P','Orden de trabajo N° 170804',3,'M','2025-04-27 00:08:43',137),(54,'170803','2025-04-21 16:25:00','2025-04-21',140,NULL,'JU008745','0','114968',NULL,'P','Orden de trabajo N° 170803',3,'M','2025-04-27 03:27:43',86),(55,'170802','2025-04-21 16:22:00','2025-04-21',141,NULL,'24952','0','126666',NULL,'D','Orden de trabajo N° 170802',3,'M','2025-04-27 03:21:51',3),(56,'170801','2025-04-21 14:35:00','2025-04-21',142,NULL,'RU377194','0','16818',NULL,'D','Orden de trabajo N° 170801',3,'M','2025-04-27 03:21:52',3),(57,'170800','2025-04-21 14:22:00','2025-04-28',143,NULL,'YE98234','0','18499',NULL,'D','Orden de trabajo N° 170800',3,'M','2025-04-27 03:21:55',3);

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
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`apellido`,`nombre`,`nombrecortousu`,`dni`,`nrosocio`,`domicilio`,`fnacimiento`,`idtipopersona`,`emailusuario`,`pass`,`urlfoto`,`tel`,`idoficina`,`aptoingreso`,`finiapto`,`ffinapto`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Flores','Cesar','C. L. Flores','12345678','0','colon 123','1981-02-14',3,'admin@gmail.com','1234','avatar/team-4.jpg','',3,'S',NULL,NULL,'M',1,'2025-03-27 09:16:07'),(2,'gerente','','gerente','123456','gerente','calle 23','2000-01-01',3,'gerente@gmail.com','1234','avatar/84.jpg','',4,'S','2025-03-27','2025-04-27','M',84,'2025-03-27 15:19:11'),(3,'supervisor','','supervisor','12','supervisor1','c','2000-01-01',1,'supervisor@gmail.com','1234','avatar/85.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-03-27 09:18:20'),(86,'mecanico1','','mecanico1','12345','meca1','calle 23','2000-01-01',4,'mecanico1@gmail.com','1234','avatar/86.jpg','',4,'S','2025-03-27','2025-04-27','M',86,'2025-03-31 12:19:10'),(136,'','SILVETTI JORGE IGNACIO',NULL,'10031245',NULL,NULL,NULL,2,'postventa@piazzatucuman.com',NULL,'user.png','4233332',2,'N',NULL,NULL,'N',3,'2025-04-26 21:10:03'),(137,'mecanico2','','mecanico2','12','meca2','caa','2000-01-01',4,'mecanico2@gmail.com','1234','avatar/team-2.jpg','4545',4,'S','2025-03-27','2025-04-27','M',1,'2025-04-26 21:10:03'),(138,'',NULL,NULL,'10031244',NULL,NULL,NULL,2,'postventa@piazzatucuman.com',NULL,'user.png','42333321',2,'N',NULL,NULL,'N',3,'2025-04-26 22:16:27'),(139,'','PIAZZATEST DRIVE',NULL,'170804',NULL,NULL,NULL,2,'123@123.COM',NULL,'user.png','111111',2,'N',NULL,NULL,'N',3,'2025-04-27 00:08:04'),(140,'','USADOS PIAZZA',NULL,'170803',NULL,NULL,NULL,2,'gabrielmuntaner1@hotmail.com',NULL,'user.png','5493814066405',2,'N',NULL,NULL,'N',3,'2025-04-27 00:27:00'),(141,'','USADOS PIAZZA',NULL,'170802',NULL,NULL,NULL,2,'postventa@piazzatucuman.com',NULL,'user.png','4233332',2,'N',NULL,NULL,'N',3,'2025-04-27 03:21:12'),(142,'','RODRIGUEZ GUILLERMO SEBASTIAN',NULL,'170801',NULL,NULL,NULL,2,'gr0715037@gmail.com',NULL,'user.png','5493813548582',2,'N',NULL,NULL,'N',3,'2025-04-27 03:21:30'),(143,'','PAZ POSSE MARIA SUSANA',NULL,'170800',NULL,NULL,NULL,2,'msusanapazposse@gmail.com',NULL,'user.png','5493814496449',2,'N',NULL,NULL,'N',3,'2025-04-27 03:21:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

/*Data for the table `personasvsdisciplinas` */

insert  into `personasvsdisciplinas`(`idpersonavsdisciplina`,`idpersona`,`iddisciplina`,`accion`,`idempleadoaccion`,`fechaaccion`) values (43,1,3,'N',1,'2025-03-15 13:44:55'),(55,86,4,'N',1,'2025-03-27 09:18:47'),(102,136,2,'N',3,'2025-04-26 21:10:03'),(103,137,4,'N',1,'2025-04-26 21:10:03'),(104,138,2,'N',3,'2025-04-26 22:16:27'),(105,139,2,'N',3,'2025-04-27 00:08:04'),(106,140,2,'N',3,'2025-04-27 00:27:00'),(107,141,2,'N',3,'2025-04-27 03:21:12'),(108,142,2,'N',3,'2025-04-27 03:21:30'),(109,143,2,'N',3,'2025-04-27 03:21:41');

/*Table structure for table `tareas` */

DROP TABLE IF EXISTS `tareas`;

CREATE TABLE `tareas` (
  `idtarea` int(11) NOT NULL AUTO_INCREMENT,
  `descripciontarea` varchar(100) DEFAULT NULL,
  `tiempotarea` decimal(10,0) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`idtarea`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;

/*Data for the table `tareas` */

insert  into `tareas`(`idtarea`,`descripciontarea`,`tiempotarea`,`accion`,`idempleadoaccion`,`fechaaccion`) values (84,'REPARA PINTURA CAPOT(CALIBRE)',1745755204,'N',1,'2025-04-27 18:02:54'),(85,'PINT PTA DEL IZQ (CALIBRE)',1440,'M',86,'2025-04-27 02:17:17'),(86,'NO FUNCIONA LE ONE TOUCH DE LA VENTANILLA DELANTERA DERECHA (52224965)',0,'N',3,'2025-04-27 00:08:04'),(87,'REP PRAGO DEL  Y TRAS',1440,'M',86,'2025-04-27 03:27:41'),(88,'REP TASPA DE BAUL',0,'N',3,'2025-04-27 00:27:00'),(89,'REP PTA DEL DER Y ZOCALO DER',0,'N',3,'2025-04-27 00:27:00'),(90,'REPARAR Y PINTAR PARAG TRAS, GUARD TRAS IZQ Y CAPOT',0,'N',3,'2025-04-27 03:21:12'),(91,'REPARACION DE CH Y P PUERTA TRASERA DERECHA',0,'N',3,'2025-04-27 03:21:30'),(92,'SE ENCIENDEN VARIOS TESTIGOS EN PANTALLA',0,'N',3,'2025-04-27 03:21:41'),(93,'NO FUNCIONAN LOS SENSORES DE MARCHA ATRAS',0,'N',3,'2025-04-27 03:21:41'),(94,'PARPADEA EL KILOMETRAJE',0,'N',3,'2025-04-27 03:21:41'),(95,'8789',0,'N',3,'2025-04-27 03:21:41');

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
