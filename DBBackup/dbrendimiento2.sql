/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.7.15-log : Database - dbrendimiento
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`dbrendimiento` /*!40100 DEFAULT CHARACTER SET utf8 */;

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `afectadostareas` */

insert  into `afectadostareas`(`idafectadotarea`,`numorden`,`idtarea`,`estado`,`idempleado`,`observacion`,`fechaobs`) values (1,'1234',6,'P',2,'SE INICIA TAREA','2025-02-14 15:42:09'),(2,'1234',6,'P',3,'SE INICIA TAREA','2025-02-14 15:42:12'),(3,'1234',2,'F',2,'SE REPARO TODO Y SE OCUPO TODO EL RESPUESTO','2025-02-14 15:50:09'),(4,'1473',1,'P',1,'SE INICIA TAREA','2025-02-14 15:40:03'),(5,'1473',1,'P',2,'SE INICIA TAREA','2025-02-14 15:40:06'),(6,'1473',1,'P',3,'SE INICIA TAREA','2025-02-14 15:40:09'),(7,'1234',2,'P',2,'SE INICIA TAREA','2025-02-14 15:43:12'),(8,'1473',1,'F',1,'SE DEJA TAREA POR DAÑO HERRAMIENTA','2025-02-14 15:45:20'),(9,'1473',1,'F',2,'SE DEJA TAREA PORQUE SE MANDA A LAVADERO','2025-02-14 15:46:00'),(10,'1473',1,'F',3,'SE CIERRA TAREA CAMBIANDO MATERIALES','2025-02-14 15:46:35'),(11,'1474',1,'P',2,'SE INICIA TAREA','2025-02-14 15:47:08'),(12,'1475',1,'F',2,'SE DEJA TAREA POR DAÑO HERRAMIENTA','2025-03-01 20:15:14'),(13,'1476',2,'F',3,'SE DEJA TAREA POR DAÑO PUERTA','2025-03-01 20:15:14');

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
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

/*Data for the table `autorizaraccorden` */

insert  into `autorizaraccorden`(`idautorizar`,`numorden`,`idpersona`,`estado`,`fechaautoriza`,`observacion`,`accion`,`fechaaccion`,`idempleadoaccion`) values (11,'1256',7,'A','2025-02-27 14:50:52','AUTORIZA','B','2025-03-04 02:42:36',1),(12,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(13,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(14,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(15,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:01:04',1),(16,'1256',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 11:58:11',1),(18,'1472',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:00:55',1),(19,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(20,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(21,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:01:04',1),(22,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(23,'1472',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-04 03:00:55',1),(24,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:01:04',1),(25,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(26,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:01:04',1),(27,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(28,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(29,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(30,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(31,'1474',1,'B',NULL,'DESVINCULAR','B','2025-03-04 03:01:04',1),(32,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(33,'1234',1,'B','0000-00-00 00:00:00','DESVINCULAR','B','2025-03-11 12:40:10',1),(34,'1256',1,'B',NULL,'DESVINCULAR','B','2025-03-11 11:58:11',1),(35,'1234',1,'B','2025-03-11 12:31:33','DESVINCULAR','B','2025-03-11 12:40:10',1),(36,'1234',1,'B','2025-03-11 12:35:21','DESVINCULAR','B','2025-03-11 12:40:10',1),(37,'1234',1,'B','2025-03-11 12:37:49','DESVINCULAR','B','2025-03-11 12:40:10',1),(38,'1234',1,'A','2025-03-11 12:46:10','AUTORIZA','M','2025-03-11 12:46:10',1),(39,'1474',1,'A','2025-03-11 12:48:22','AUTORIZA','M','2025-03-11 12:48:22',1);

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

insert  into `detalleorden`(`iddetalleorden`,`numeroorden`,`idtarea`,`fini`,`ffin`,`estado`,`tiempotarea`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'1234',1,NULL,NULL,'D','00:00:00',NULL,'N',1,'2025-02-10 22:07:32'),(2,'1234',2,'2025-02-10 23:56:29','2025-02-10 01:56:33','F','00:48:00','Se termino en tiempo y forma tarea','M',1,'2025-02-10 22:07:58'),(3,'1234',6,NULL,NULL,'P','00:00:00',NULL,'N',1,'2025-02-10 22:08:21'),(4,'1256',1,NULL,NULL,'D',NULL,NULL,'M',1,'2025-03-04 02:42:36'),(5,'1256',2,NULL,NULL,'D',NULL,NULL,'M',1,'2025-03-04 02:42:36'),(6,'1256',6,NULL,NULL,'D',NULL,NULL,'M',1,'2025-03-04 02:42:36'),(7,'1472',1,NULL,NULL,'S',NULL,NULL,'M',1,'2025-03-04 02:42:28'),(8,'1472',2,NULL,NULL,'S',NULL,NULL,'M',1,'2025-03-04 02:42:28'),(9,'1473',1,'2025-02-14 09:23:19','2025-02-14 11:23:21','F','01:20:00','SE TERMINO OK','M',1,'2025-02-14 11:23:01'),(10,'1474',1,'2025-02-14 11:26:28',NULL,'P',NULL,NULL,'M',1,'2025-02-14 11:27:04'),(11,'1474',6,NULL,NULL,'D',NULL,NULL,'N',1,'2025-02-14 11:27:06'),(12,'1475',1,'2025-02-01 20:24:38','2025-02-03 20:25:11','F',NULL,'SE TERMINO OK','N',1,'2025-02-03 20:25:53'),(13,'1476',2,'2025-02-04 20:24:48','2025-02-06 20:25:20','F',NULL,'SE TERMINO OK','N',2,'2025-02-07 20:26:01');

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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `disciplinas` */

insert  into `disciplinas`(`iddisciplina`,`disciplina`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Esp. Hidráulica','Esp. Hidráulica','M',1,'2024-12-16 15:44:17'),(2,'Mecánico Gral.','Mecánico Gral.','M',1,'2025-01-21 10:55:33'),(3,'Supervisor','Supervisor Taller','N',1,'2025-02-01 12:56:03'),(4,'Electricista','Electicista Automotor','N',1,'2025-02-01 12:56:03'),(5,'Esp. Refrigeración','Especialista en A.C.','M',1,'2025-01-21 10:32:27'),(6,'Esp. Neumáticos','Esp. Neumáticos','M',1,'2025-01-21 10:52:04'),(11,'prueba disci modi','observacion disci nuevo','B',1,'2024-12-16 15:45:49'),(12,'prueba disci nuevo','observacion disci nuevo','B',1,'2024-12-16 15:45:34'),(23,'acuarela','va con rojo y ahora azul','B',1,'2025-01-21 10:55:10'),(24,'rtertewt','etrtertewt','B',1,'2025-01-21 10:54:44'),(25,'rtetewrt','etewt','B',1,'2025-01-21 10:54:50'),(26,'trwer','wrwe','B',1,'2025-01-21 10:54:55'),(27,'wrewr','werrewr','B',1,'2025-01-21 10:54:15'),(28,'dddd','ddeee','B',1,'2025-01-21 10:55:22'),(29,'acuarela','va con celeste','B',1,'2025-01-21 10:55:16'),(30,'rojo','no rosa','B',1,'2025-01-21 10:54:36'),(31,'borrame y limpito','yaaaa cambiadito','B',1,'2025-02-10 21:54:30'),(32,'borrame y limpito 234','yaaaa cambiadito 23','B',1,'2025-03-04 02:03:52'),(33,'borrame y limpitoDDD','yaaaa cambiadito 234DDD','B',1,'2025-03-04 02:36:03');

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
  `historial` varchar(1) DEFAULT 'N',
  `tituloorden` varchar(50) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idnumorden`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `numeroorden` */

insert  into `numeroorden`(`idnumorden`,`numorden`,`fecha`,`idcliente`,`modelo`,`numchasis`,`patente`,`kilometraje`,`fventa`,`estado`,`historial`,`tituloorden`,`accion`,`fechaaccion`,`idempleadoaccion`) values (1,'1234','2025-02-10 22:06:28',58,'FIAT UNO','ABC1234','ABC123','136000','2013-02-10','P','N','Servis por 40.000 Kms','M','2025-02-14 12:37:54',1),(2,'1256','2025-02-13 18:00:14',58,'FIAT UNO','ABC1234','ABC123','142000','2025-02-13','D','S','Servis por 10.000 Kms','M','2025-03-04 02:42:36',1),(3,'1472','2025-02-13 18:02:18',58,'FIAT UNO','ABC1234','ABC123','142000','2025-02-13','S','N','','M','2025-03-04 02:42:28',1),(4,'1473','2025-02-14 11:22:12',58,'MODELO23','WRWER4564','WERWE41','142500','2025-02-14','F','S','Servis por 20.000 Kms','M','2025-02-14 11:21:56',1),(5,'1474','2025-02-14 11:25:12',58,'WERWER33','65565EERF','54DDE65','475000','2025-02-14','P','S','Servis por 50.000 Kms','N','2025-02-14 11:25:42',1),(6,'1475','2025-02-01 20:11:28',58,'FIAT UNO','ABC1234','ABC123','65465','2013-02-10','F','N','Servis por 50.000 Kms','M','2025-02-14 11:25:42',1),(7,'1476','2025-02-04 20:11:28',58,'FIAT UNO','ABC1234','ABC123','66545','2013-02-10','F','N','Servis por 50.000 Kms','M','2025-02-14 11:25:42',1);

/*Table structure for table `oficinas` */

DROP TABLE IF EXISTS `oficinas`;

CREATE TABLE `oficinas` (
  `idoficina` int(11) NOT NULL AUTO_INCREMENT,
  `nombreoficina` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idoficina`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `oficinas` */

insert  into `oficinas`(`idoficina`,`nombreoficina`) values (1,'Cobranza'),(2,'Recursos Humano'),(3,'Administración'),(4,'Cliente');

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
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`apellido`,`nombre`,`nombrecortousu`,`dni`,`nrosocio`,`domicilio`,`fnacimiento`,`idtipopersona`,`emailusuario`,`pass`,`urlfoto`,`tel`,`idoficina`,`aptoingreso`,`finiapto`,`ffinapto`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Flores','Cesar','C. L. Floress','12345678','0','colon 123','1981-02-14',1,'admin@gmail.com','1234','team-4.jpg','4561123',3,'N',NULL,NULL,'N',1,'2024-12-04 13:01:38'),(2,'Flores','Eliseo','E. Flores','12345','1','colon 123','2016-08-03',3,'eliseo@gmail.com','1234','team-2.jpg','381-5210-952',2,'S','2025-01-25','2025-02-25','M',1,'2025-02-05 14:38:40'),(3,'Flores','Baltazar','B. Flores','1425','278','colon 123','2021-06-02',4,'baltazar@gmail.com','1234','team-1.jpg','381-1552-210',2,'S','2025-01-26','2025-02-26','M',1,'2025-02-05 14:11:33'),(4,'Flores','uno','uno','1','3','colon 11','2024-02-05',5,'uno@gmail.com','12','user.png','381-1152-210',2,'N','2025-01-26','2025-02-26','M',1,'2025-01-26 10:54:05'),(5,'Flores','dos','dos','12','3','Pension 123','2024-02-15',6,'dddd@sss.com','12','avatar/5.PNG','381-5210-592',2,'S','2025-01-25','2025-02-25','M',1,'2025-01-26 10:22:50'),(6,'FLORES','tres','tres','123','3','sss','2024-01-05',1,'ddd@dd.com','12','user.png','381-1552-210',2,'S',NULL,NULL,'M',1,'2025-01-12 09:32:29'),(7,'FLORES','CUATRO','CUATRO','1234','3','SSS','2024-01-01',8,'SDSS@DDD.COM','12','user.png','381-1552-210',2,'N',NULL,NULL,'M',1,'2024-12-14 10:12:27'),(8,'SS','CINCO','CINCO','1478','3','SSS','2024-07-15',1,'SS@EE.COM','12','user.png','1',2,'N',NULL,NULL,'N',1,'2024-12-08 09:47:39'),(9,'SSS','SEIS','SEIS','14','3','SS','2024-07-15',1,'SDDD@S.XOM','12','user.png','1',2,'N',NULL,NULL,'N',1,'2024-12-08 09:48:25'),(10,'Salas','Martin Juan','msalas','45123456','33','San loren 12','2024-08-19',1,'modi@gmail.com','C147','user.png','381-1152-210',2,'N',NULL,NULL,'N',1,'2024-12-10 10:40:07'),(11,'QQ','OCHO','OCHO','80','3','S','2024-05-12',1,'SS@DFD.COM','12','user.png','381-1152-210',3,'N','2025-01-25','2025-02-25','M',1,'2025-01-25 00:56:02'),(12,'NUEVE modi','NUEVE','Nmodi','90','3','SS','2024-06-15',1,'SSS@EE.COM','m123','user.png','',3,'N',NULL,NULL,'M',1,'2025-01-24 23:45:01'),(17,'prueba','prueba','prueba cor','140','140','prueba 12','2000-01-01',1,'prueba@22.com',NULL,'user.png','381-5421-456',3,'N',NULL,NULL,'N',1,'2024-12-14 09:35:34'),(18,'hgjhg','d','djhgjh','4','2','q','2000-01-01',1,'',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-08 12:19:16'),(20,'sdf','f','f2222','32','f','f','2000-01-01',1,'kljjk@ww.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-08 12:22:00'),(21,'pru','pru','prue','147','1234','ggg','2000-02-01',3,'gggg@ddd.vom',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-08 12:35:33'),(22,'pru','pru','prue','1479','1234','ggg','2000-02-01',3,'gggg@ddd.vom','m123','user.png','',1,'N',NULL,NULL,'N',1,'2024-12-10 11:08:07'),(23,'soc ape','soc nomb','soc1234','28753951','car1234','cordoba 12','1981-02-15',3,'tuto@hot.com',NULL,'user.png','381-5210-592',1,'N',NULL,NULL,'N',1,'2024-12-08 12:38:49'),(26,'tito','toti','tito tio','123456','vol-1234','colo 23','1952-04-02',4,'tito@gmail.com','147258','avatar/26.jpg','381-1552-210',1,'N',NULL,NULL,'M',1,'2024-12-14 09:38:41'),(27,'robot','robota','robota','258369147','fut-1234','salta 23','1981-08-02',4,'robota@gmail.com',NULL,'user.png','381-1552-210',1,'N',NULL,NULL,'N',1,'2024-12-08 22:48:46'),(28,'robot','robota','robota','2583691847','fut-1234','salta 23','1981-08-02',4,'robota@gmail.com',NULL,'user.png','381-1552-210',1,'N',NULL,NULL,'N',1,'2024-12-08 22:55:45'),(29,'que','se prueba','que se','28693258','que123','salas 123','2000-02-10',5,'tito@reto.com',NULL,'avatar/29.jpg','381-1552-452',1,'N',NULL,NULL,'M',1,'2024-12-14 10:17:11'),(30,'tec','nologia','tecnolog','147023','tec1234','salta 88','2000-08-01',5,'tegno@gmail.com',NULL,'user.png','381-1552-210',1,'N',NULL,NULL,'N',1,'2024-12-14 10:18:25'),(31,'tecno','logic','tecnolog','1237891','tec1234','tecno 123','2000-02-01',5,'tecno@gmail.com',NULL,'user.png','381-1552-210',2,'S',NULL,NULL,'N',1,'2024-12-14 10:21:37'),(32,'tecno','logic','tecnolog','123789','tec1234','tecno 123','2000-02-01',5,'tecno@gmail.com',NULL,'avatar/32.jpg','381-1552-210',2,'S',NULL,NULL,'M',1,'2024-12-14 10:23:33'),(35,'APE EMP','NOMB EMPE','APE NOMB','147258369',NULL,'COLON 12','2012-12-12',3,'EMPLE@GMAIL.COM',NULL,'user.png','381-1552-210',2,'N',NULL,NULL,'M',1,'2025-01-03 23:58:52'),(36,'ap1','nomb1','ap nomb1','11',NULL,'calle 1','2000-01-01',1,'uno@uno.com',NULL,'user.png','',2,'N',NULL,NULL,'N',1,'2024-12-17 16:12:53'),(37,'dos','ape dos','dos ape','20',NULL,'dos 2','2000-02-02',5,'dos@gmail.com',NULL,'user.png','',2,'N',NULL,NULL,'N',1,'2024-12-17 16:13:28'),(38,'tres','ape tres','tres ape','3',NULL,'calle 3','2000-03-03',6,'tres@gmail.com',NULL,'user.png','',2,'N',NULL,NULL,'N',1,'2024-12-17 16:14:00'),(39,'4 modi','cuatro modi','ape cuatro modi','44',NULL,'calle 4 modi','2004-04-04',6,'cuatromodi@gmail.com','1234','user.png','381-1552-210',2,'N',NULL,NULL,'M',1,'2024-12-18 02:01:31'),(40,'cinco','nombre 5','nom cinco','50',NULL,'calle 5','2000-05-05',5,'cinco@gmaillcom',NULL,'user.png','',2,'N',NULL,NULL,'N',1,'2024-12-17 16:19:19'),(41,'6','sies','6 seis','60',NULL,'calle 6','2000-06-06',3,'seis@gmail.com',NULL,'user.png','',1,'N',NULL,NULL,'M',1,'2024-12-18 02:04:00'),(42,'7','siete','siete','70',NULL,'calle 7','2000-07-07',5,'siete@gmail.com',NULL,'user.png','',1,'N',NULL,NULL,'N',1,'2024-12-17 16:21:33'),(43,'ocho','8','8ocho','8',NULL,'colon 8','2000-08-08',5,'ocho@gmail.com',NULL,'user.png','',1,'N',NULL,NULL,'N',1,'2024-12-17 16:22:08'),(44,'nueve','9','nueve9','9',NULL,'calle 9','2000-09-09',7,'nueve@gmail.com',NULL,'avatar/44.jpg','',1,'N',NULL,NULL,'N',1,'2024-12-18 02:05:41'),(45,'diez','10','diez10','10',NULL,'calle 10','2000-01-01',1,'diez@gmail.com',NULL,'user.png','',1,'N',NULL,NULL,'N',1,'2024-12-17 16:23:27'),(46,'once','11','once11','1111',NULL,'calle 11','2000-01-11',5,'once@gmail.com',NULL,'user.png','',2,'N',NULL,NULL,'N',1,'2024-12-17 16:24:04'),(47,'ape prof','nomb prof modi','ape prof','1237892',NULL,'prueba prof','2012-12-10',8,'profe@gmaill.com','1234','avatar/47.jpg','381-1552-210',3,'N',NULL,NULL,'M',1,'2024-12-18 12:13:53'),(48,'prof 1','ape 1','profe 1','111',NULL,'COLON 1','2000-12-15',8,'profe1@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:18:14'),(49,'prof 2','personal 2','profe dos','2',NULL,'colon 2','2000-02-02',8,'profedos@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:19:00'),(50,'prof 3','nombre 3','profe3','33',NULL,'colon 3','2000-03-03',8,'profetres@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:19:41'),(51,'prof 4','cuatro','profe4','40',NULL,'colon 4','2000-04-04',8,'profecuatro@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:23:03'),(52,'profe 5','cinco','cinco5','5',NULL,'colon 5','2000-04-04',8,'cincoprof@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:20:59'),(53,'ape 6','sies','ape6','6',NULL,'colon 6','2000-06-06',8,'seis@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:21:32'),(54,'ape 7','siete','ape7','7',NULL,'colon 7','2000-05-05',8,'siete@gmail.com',NULL,'user.png','',3,'N',NULL,NULL,'N',1,'2024-12-18 12:22:01'),(57,'Prueba borrame','Lunes','PLunes','28680798','28PLunes','Calle 78','1981-08-03',2,'cesar.flores@faz.com','4715','avatar/57.jpg','381-5210-592',4,'S','2025-02-10','2025-03-10','B',1,'2025-03-04 02:20:44'),(58,'Prueba','Cesar L','PLunes','28680798','28PLunes','Calle 21','1985-02-05',2,'usu@usu.com','1234','avatar/58.jpg','381-5210-592',4,'S','2025-03-04','2025-04-04','M',1,'2025-03-04 10:20:54'),(59,'Profe','rewr','cddddd','28680798','28PLunes','fgfdsgdf','4951-01-02',2,'cesar.flores@faz.com','1234','avatar/59.PNG','381-5210-592',4,'S','2025-03-04','2025-04-04','B',1,'2025-03-04 10:20:17');

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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

/*Data for the table `personasvsdisciplinas` */

insert  into `personasvsdisciplinas`(`idpersonavsdisciplina`,`idpersona`,`iddisciplina`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,17,1,'N',1,'2025-02-07 10:46:59'),(2,22,1,'N',1,'2025-02-07 10:46:59'),(3,44,1,'N',1,'2025-02-07 10:46:59'),(4,51,1,'N',1,'2025-02-07 10:46:59'),(5,17,2,'N',1,'2025-02-07 10:46:59'),(6,22,2,'N',1,'2025-02-07 10:46:59'),(7,44,2,'N',1,'2025-02-07 10:46:59'),(8,51,2,'N',1,'2025-02-07 10:46:59'),(9,17,3,'N',1,'2025-02-07 10:46:59'),(10,22,3,'N',1,'2025-02-07 10:46:59'),(11,44,4,'N',1,'2025-02-07 10:46:59'),(12,51,4,'N',1,'2025-02-07 10:46:59'),(13,17,5,'N',1,'2025-02-07 10:46:59'),(14,22,5,'N',1,'2025-02-07 10:46:59'),(15,57,4,'B',1,'2025-03-04 02:20:44'),(16,57,6,'B',1,'2025-03-04 02:20:44'),(17,57,2,'B',1,'2025-03-04 02:20:44'),(18,58,4,'N',1,'2025-03-04 02:11:44'),(19,58,6,'N',1,'2025-03-04 02:11:44'),(20,58,2,'N',1,'2025-03-04 02:11:44'),(21,58,3,'N',1,'2025-03-04 02:11:44'),(22,59,4,'B',1,'2025-03-04 10:20:17'),(23,59,1,'B',1,'2025-03-04 10:20:17'),(24,59,6,'B',1,'2025-03-04 10:20:17'),(25,59,2,'B',1,'2025-03-04 10:20:17'),(26,59,3,'B',1,'2025-03-04 10:20:17');

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tareas` */

insert  into `tareas`(`idtarea`,`descripciontarea`,`tiempotarea`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Cambio Filtro','00:30:00','M',1,'2025-02-14 12:45:23'),(2,'Cambio Aceite','00:30:00','M',1,'2025-02-07 12:47:48'),(3,'Cambio foco guiño derecho delantero','01:00:00','N',1,'2025-02-07 12:01:48'),(4,'Cambio de luz de freno trasera','01:00:00','N',1,'2025-02-07 12:01:48'),(5,'Cambio foco guiño izquierdo delantero','01:00:00','N',1,'2025-02-07 12:01:48'),(6,'Cambio de una cubierta','00:20:00','M',1,'2025-02-07 16:39:55'),(7,'cambio','12:00:00','B',1,'2025-02-07 12:49:31'),(8,'Cabio de una cubierta 2345','15:00:00','B',1,'2025-03-04 02:57:07');

/*Table structure for table `tipopersona` */

DROP TABLE IF EXISTS `tipopersona`;

CREATE TABLE `tipopersona` (
  `idtipopersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipopersona` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idtipopersona`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tipopersona` */

insert  into `tipopersona`(`idtipopersona`,`tipopersona`) values (1,'Administrador'),(2,'Cliente'),(3,'Recepción'),(4,'Cajero'),(5,'Deposito'),(6,'Sistemas'),(7,'Lavadero'),(8,'Tecnico');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
