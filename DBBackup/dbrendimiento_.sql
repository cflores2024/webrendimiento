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
  `observacion` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `fechaini` datetime DEFAULT NULL,
  `fechaobs` datetime DEFAULT NULL,
  `abandona` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
  `suspendida` varchar(1) DEFAULT 'N',
  PRIMARY KEY (`idafectadotarea`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

/*Data for the table `afectadostareas` */

insert  into `afectadostareas`(`idafectadotarea`,`numorden`,`idtarea`,`estado`,`idempleado`,`observacion`,`fechaini`,`fechaobs`,`abandona`,`suspendida`) values (135,'170940',198,'F',4,'tarea ok','2025-06-03 16:34:15','2025-06-04 20:44:47','N','N'),(136,'170940',199,'F',4,'','2025-06-03 16:35:07','2025-06-04 20:44:33','N','N'),(137,'170940',198,'F',4,'tarea ok','2025-06-03 16:35:33','2025-06-04 20:44:47','S','N'),(138,'170940',202,'F',4,'','2025-06-03 16:39:39','2025-06-04 20:44:37','N','N'),(143,'171437',205,'F',195,'el cristal de ambos lados son iguales.','2025-06-04 12:20:25','2025-06-04 12:21:40','N','N'),(145,'171437',204,'F',195,'','2025-06-04 12:31:45','2025-06-04 13:38:30','N','N'),(146,'170944',191,'P',4,'SE INICIA TAREA','2025-06-04 20:20:51',NULL,'N','N'),(147,'170944',191,'P',5,'COLABORA','2025-06-04 20:21:18',NULL,'N','N'),(148,'170940',200,'P',4,'SE INICIA TAREA','2025-06-04 20:44:41',NULL,'N','N'),(149,'170942',194,'F',5,'tarea ok','2025-06-04 20:45:03','2025-06-04 20:59:22','N','N'),(150,'170942',194,'F',5,'tarea ok','2025-06-04 20:45:21','2025-06-04 20:59:22','N','N');

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
) ENGINE=InnoDB AUTO_INCREMENT=235 DEFAULT CHARSET=utf8;

/*Data for the table `autorizaraccorden` */

insert  into `autorizaraccorden`(`idautorizar`,`numorden`,`idpersona`,`estado`,`fechaautoriza`,`observacion`,`accion`,`fechaaccion`,`idempleadoaccion`) values (221,'170940',4,'B','2025-06-03 16:33:42','DESVINCULAR','B','2025-06-04 10:16:49',4),(222,'170940',5,'A','2025-06-03 16:34:06','AUTORIZA','M','2025-06-03 16:34:06',5),(223,'170940',4,'B','2025-06-03 16:34:46','DESVINCULAR','B','2025-06-04 10:16:49',4),(224,'171430',4,'A','2025-06-04 11:46:47','AUTORIZA','M','2025-06-04 11:46:47',4),(225,'171430',192,'B','2025-06-04 11:59:08','DESVINCULAR','B','2025-06-04 12:06:24',192),(226,'171430',192,'A','2025-06-04 12:06:29','AUTORIZA','M','2025-06-04 12:06:29',192),(227,'171437',195,'A','2025-06-04 12:17:52','AUTORIZA','M','2025-06-04 12:17:52',195),(228,'170942',195,'B','2025-06-04 12:30:50','DESVINCULAR','B','2025-06-04 12:30:52',195),(229,'170944',4,'A','2025-06-04 20:20:40','AUTORIZA','M','2025-06-04 20:20:40',4),(230,'170944',5,'A','2025-06-04 20:21:14','AUTORIZA','M','2025-06-04 20:21:14',5),(231,'170940',4,'A','2025-06-04 20:44:25','AUTORIZA','M','2025-06-04 20:44:25',4),(232,'170941',4,'B','2025-06-04 20:44:53','DESVINCULAR','B','2025-06-04 20:44:59',4),(233,'170942',4,'A','2025-06-04 20:45:01','AUTORIZA','M','2025-06-04 20:45:01',4),(234,'170942',5,'A','2025-06-04 20:45:18','AUTORIZA','M','2025-06-04 20:45:18',5);

/*Table structure for table `detalleorden` */

DROP TABLE IF EXISTS `detalleorden`;

CREATE TABLE `detalleorden` (
  `iddetalleorden` int(11) NOT NULL AUTO_INCREMENT,
  `numeroorden` varchar(30) DEFAULT NULL,
  `idtarea` int(11) DEFAULT NULL,
  `fini` datetime DEFAULT NULL,
  `ffin` datetime DEFAULT NULL,
  `estado` varchar(1) DEFAULT 'S',
  `observacion` varchar(100) DEFAULT NULL,
  `accion` varchar(1) DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  PRIMARY KEY (`iddetalleorden`)
) ENGINE=InnoDB AUTO_INCREMENT=476 DEFAULT CHARSET=utf8;

/*Data for the table `detalleorden` */

insert  into `detalleorden`(`iddetalleorden`,`numeroorden`,`idtarea`,`fini`,`ffin`,`estado`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (460,'170944',191,'2025-06-04 20:20:51',NULL,'P',NULL,'M',4,'2025-06-04 20:20:51'),(461,'170943',192,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:03:57'),(462,'170943',193,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:03:57'),(463,'170942',194,'2025-06-04 20:45:03','2025-06-04 20:59:22','F','tarea ok','M',5,'2025-06-04 20:00:22'),(464,'170941',195,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:04:42'),(465,'170941',196,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:04:42'),(466,'170941',197,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:04:42'),(467,'170940',198,'2025-06-03 16:34:15','2025-06-04 20:44:47','F','tarea ok','M',4,'2025-06-04 20:44:47'),(468,'170940',199,'2025-06-03 16:35:07','2025-06-04 20:44:33','F','','M',4,'2025-06-04 20:44:33'),(469,'170940',200,'2025-06-04 20:44:41',NULL,'P',NULL,'M',4,'2025-06-04 20:44:41'),(470,'170940',201,NULL,NULL,'D',NULL,'M',4,'2025-06-03 16:05:10'),(471,'170940',202,'2025-06-03 16:39:39','2025-06-04 20:44:37','F','','M',4,'2025-06-04 20:44:37'),(472,'171430',203,NULL,NULL,'D',NULL,'M',192,'2025-06-04 12:11:37'),(473,'171430',202,NULL,NULL,'D',NULL,'M',192,'2025-06-04 12:07:32'),(474,'171437',204,'2025-06-04 12:31:45','2025-06-04 13:38:30','F','','M',195,'2025-06-04 13:38:30'),(475,'171437',205,'2025-06-04 12:20:25','2025-06-04 12:21:40','F','el cristal de ambos lados son iguales.','M',195,'2025-06-04 12:21:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `disciplinas` */

insert  into `disciplinas`(`iddisciplina`,`disciplina`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Administración','Gestión del sistema','N',1,'2025-03-25 10:45:35'),(2,'Clientes','Clientes','M',1,'2025-03-25 10:45:14'),(3,'Gerente','Oficina de gerencia','N',1,'2025-02-01 12:56:03'),(4,'Mecanico','Oficina Tecnica','N',1,'2025-02-01 12:56:03'),(5,'Supervisor','Oficina de supervisión de mecanicos','N',1,'2025-02-01 12:56:03'),(37,'Lavanderia 1234','ddddddd','B',1,'2025-05-22 15:35:28');

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
  `conocio` varchar(100) DEFAULT NULL,
  `accion` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `idempleadoaccion` int(11) DEFAULT NULL,
  PRIMARY KEY (`idnumorden`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8;

/*Data for the table `numeroorden` */

insert  into `numeroorden`(`idnumorden`,`numorden`,`fecha`,`fechaentrega`,`idcliente`,`modelo`,`numchasis`,`patente`,`kilometraje`,`fventa`,`estado`,`tituloorden`,`idpersonadisp`,`conocio`,`accion`,`fechaaccion`,`idempleadoaccion`) values (193,'170944','2025-04-30 13:07:00','2025-04-30',219,NULL,'YH69072','0','41757',NULL,'P','tarea para cesar',3,NULL,'M','2025-06-04 20:20:51',4),(194,'170943','2025-04-30 09:43:00','2025-04-30',220,NULL,'3026712','0','89529',NULL,'D','CESAR ORDEN 170943',1,NULL,'M','2025-06-03 16:03:57',4),(195,'170942','2025-04-30 09:34:00','2025-04-30',221,NULL,'YH69072','0','49000',NULL,'F','CESAR ORDEN 170942',1,NULL,'M','2025-06-04 20:00:22',5),(196,'170941','2025-04-30 09:32:00','2025-04-30',222,NULL,'RU387377','0','19722',NULL,'D','CESAR ORDEN 170941',1,NULL,'M','2025-06-03 16:04:42',4),(197,'170940','2025-04-30 09:10:00','2025-04-30',223,NULL,'SU431337','0','9424',NULL,'P','CESAR ORDEN 170940',1,NULL,'M','2025-06-04 20:44:47',4),(198,'171430','2025-06-04 08:58:00','2025-06-04',224,NULL,'RU362126','0','30498',NULL,'D','171430',1,'Referido','M','2025-06-04 12:11:37',192),(199,'171437','2025-06-04 09:56:00','2025-06-04',225,NULL,'YZ42728','0','14827',NULL,'F','servicio 20000 km',1,'Referido','M','2025-06-04 13:38:30',195);

/*Table structure for table `oficinas` */

DROP TABLE IF EXISTS `oficinas`;

CREATE TABLE `oficinas` (
  `idoficina` int(11) NOT NULL AUTO_INCREMENT,
  `nombreoficina` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idoficina`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `oficinas` */

insert  into `oficinas`(`idoficina`,`nombreoficina`) values (1,'Adminstración'),(2,'Cliente'),(3,'Gerencia'),(4,'Mecanica'),(5,'Supervisión'),(6,'Otros');

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
  `emailusuario` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`apellido`,`nombre`,`nombrecortousu`,`dni`,`nrosocio`,`domicilio`,`fnacimiento`,`idtipopersona`,`emailusuario`,`pass`,`urlfoto`,`tel`,`idoficina`,`aptoingreso`,`finiapto`,`ffinapto`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Flores','Cesar','C. L. Flores','12345678','admin','','1981-02-14',1,'admin@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/team-4.jpg','',1,'S',NULL,NULL,'M',1,'2025-05-21 16:33:42'),(2,'gerente','','gerente','123456','gerente','','2000-01-01',3,'gerente@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/84.jpg','',3,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:56'),(3,'supervisor','','supervisor','12','supervisor1','','2000-01-01',5,'supervisor@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/85.jpg','',5,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:15'),(4,'mecanico1','','mecanico1','12345','meca1','','2000-01-01',4,'mecanico1@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/86.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:34:05'),(5,'mecanico2','','mecanico2','10031245','meca2','','2000-01-01',4,'mecanico2@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/136.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:27'),(170,'Apaza','Elias Exequiel','elias','40088831','','...','1996-02-12',4,'elias.apaza@piazzatucuman.com','$2y$10$FxHGBBHr7iImQw2wjSir7.VkExH/1OIrF92epV2VxmTjWTraGSPu.','avatar/170.jpg','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-20 16:37:17'),(171,'Apaza','Julia Nahuel','Julian','42277957','Julian','','2000-01-20',4,'julian.apaza@piazzatucuman.com','$2y$10$eT8IMnKb9.4nevQNgKOToubxIAQHFbWPVCGgm16jwxXhbkeETQXBu','avatar/171.jpg','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:27'),(172,'Farroni','Leandro Gabriel','Leandro','43002836','Leandro','','1995-06-10',4,'leandro.farroni@piazzatucuman.com','$2y$10$QvaPEVnvl2WGKqWg9oQy1uToyabfhO8paoMcjEqlDyLUFYjzriSUW','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:38'),(173,'Gambarte','Orlando Maximiliano','Orlando','32556932','Orlando','','1986-09-27',4,'orlando.bambarte@piazzatucuman.com','$2y$10$RPmvAUfM.woUypK4oNREO.fg2e7EUVSpZyQ6aMli7SJntIMlS3fwG','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:47'),(174,'Gonzales','Julian Ezequiel','Ezequiel','34159269','Ezequiel','','1989-12-18',4,'ezequiel.gonzalez@piazzatucuman.com','$2y$10$imsyvQS.wd3z9AYU69JTTOjgCqEPM2qQxTID0oCnrhSMKhMH/D75q','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:58'),(175,'Grima','Jesus Nazareno','Jesus','17527782','Jesus','','1965-12-24',4,'jesus.grima@piazzatucuman.com','$2y$10$WBvm.ziEyEChTvolfebdN.FXghuUydavjysdXJIb9MeIh6BTGf8rq','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:49:07'),(187,'Hladki','Daniel Eduardo','Daniel','34132944','Daniel','','2000-09-14',4,'daniel.hladki@piazzatucuman.com','$2y$10$MCrU3.LgcCYzmQgxIFEHyO8CsgY46XD0aaMlz5JKTp03aKVopDPtO','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:49:23'),(188,'Juarez','Damian Jesus','Damian','31900306','Damian','','2000-01-01',4,'damian.juarez@piazzatucuman.com','$2y$10$oh.yUrxVDmAzNKe5i1GseOvnguEh2lT4MaMKPiVkNHiIW9iO7lkpO','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:49:44'),(189,'Luna','Andres Emiliano','Andres','34285301','Andres','','2000-01-01',4,'andres.luna@piazzatucuman.com','$2y$10$SeWlFFuQD8GHPziJOnh0seCjQkVJYjqseIngpIvXE/ZaLrwH8btp.','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:50:01'),(190,'Miranda','Emanuel Carlos Exequiel','Emanuel','34185167','Emanuel','','2000-01-01',4,'emanuel.miranda@piazzatucuman.com','$2y$10$TiZNPSTbUd730.qvT5SrpuKgQQ/rRvgF/F/exW2GmyhAvqli4Ixte','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:50:28'),(191,'Nuñez','Juan Pablo','Juan','33139104','JuanP','','2000-01-01',4,'juanpablo.nunez@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:30:51'),(192,'Orellana','Victor Manuel','Victor','37725579','Victor','','2000-01-01',4,'victor.orellana@piazzatucuman.com','$2y$10$JiQgeRBHPAfXmU.7RoZsOuZZHmjuI30XT55w5daBuf/w3sOZ3TZhu','avatar/192.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-06-04 11:55:43'),(193,'Perez','Franco Nahuel','Franco','39575330','Franco','','2000-01-01',4,'franco.perez@piazzatucuman.com',NULL,'avatar/193.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:29:47'),(194,'Ponce','Juan Carlos','Juan','43707300','JuanC','','2000-01-01',4,'juancarlos.ponce@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:31:07'),(195,'Rodriguez','Gonzalo','Gonzalo','36584084','Gonzalo','','2000-01-01',4,'gonzalo.rodriguez@piazzatucuman.com','$2y$10$omKjy9DP0fxUtx7h/zY9lOjjWCZ8/Vl/.eQ379mPwIM6kihRIFXpW','avatar/195.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-06-04 12:15:27'),(196,'Romera','Antonio Jesus','Antonio','34911553','Antonio','','2000-01-01',4,'antonio.romera@piazzatucuman.com',NULL,'avatar/196.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:33:13'),(197,'Salas','Jorge Leandro','Jorge','34911676','Jorge','','2000-01-01',4,'jorge.salas@piazzatucuman.com',NULL,'avatar/197.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:34:03'),(198,'Sanchez','Miguel Eduardo','Miguel','26209826','Miguel','','2000-01-01',4,'miguel.sanchez@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:34:50'),(199,'Sarmiento','Ulises Marcelo','Ulises','41425075','Ulises','','2000-01-01',4,'ulises.sarmiento@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:35:47'),(200,'Torres','Francis Javier','Francis','39974833','Francis','','2000-01-01',4,'francis.torres@piazzatucuman.com',NULL,'avatar/200.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:36:40'),(201,'Urueña','Roque Gonzalo','Roque','43648849','Roque','','2000-01-01',4,'gonzalo.uruena@piazzatucuman.com',NULL,'avatar/201.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:37:37'),(202,'Zenczarki','Angel Jesus Andres','Angel','42525099','Angel','','2000-01-01',4,'angel.zenczarski@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:38:47'),(203,'Jairala','Cecilia','Cecilia','26783330','Cecilia','','2000-01-01',3,'cecilia.jairala@piazzatucuman.com','$2y$10$KtMDYwphKV3UZefH05o0lurmSLd173GPq9bBOw.ApqMLJweuSM4F6','avatar/203.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 20:06:34'),(215,'Campos','Sergio','Sergio','1','Sergio','','2000-01-01',5,'sergio.campos@piazzatucuman.com','$2y$10$KVKemTS7dDgBvf3yorV6m.34Ip.PYETaP0J7wxDHXS0xxjPnaAWNe','user.png','',4,'S','2025-05-26','2025-06-26','M',1,'2025-05-26 15:47:01'),(219,'','RODRIGUEZ VALERIA DEL VALLE',NULL,'170944',NULL,NULL,NULL,2,'valejmta@gmail.com',NULL,'user.png','5493814739246',2,'N',NULL,NULL,'N',4,'2025-06-03 16:03:27'),(220,'','PIAZZA S.A',NULL,'170943',NULL,NULL,NULL,2,'postventa@piazzatucuman.com',NULL,'user.png','4306261',2,'N',NULL,NULL,'N',4,'2025-06-03 16:03:57'),(221,'','SANGUINO DOMINGA MARTA',NULL,'170942',NULL,NULL,NULL,2,'mirandaclaudio684@gmail.com',NULL,'user.png','5493815016610',2,'N',NULL,NULL,'N',4,'2025-06-03 16:04:21'),(222,'','LOPEZ FRANCO NAHUEL',NULL,'170941',NULL,NULL,NULL,2,'raulgonzalo01041992@gmail.com',NULL,'user.png','5493815519567',2,'N',NULL,NULL,'N',4,'2025-06-03 16:04:42'),(223,'','HERRERA PABLO GERARDO',NULL,'170940',NULL,NULL,NULL,2,'pgherre@gmail.com',NULL,'user.png','5493815092802',2,'N',NULL,NULL,'N',4,'2025-06-03 16:05:10'),(224,'','GARCIA CORONEL FRANCO',NULL,'171430',NULL,NULL,NULL,2,'francogarcia1695@gmail.com',NULL,'user.png','5491165693944',2,'N',NULL,NULL,'N',4,'2025-06-04 11:46:36'),(225,'','SILVETTI JUAN IGNACIO',NULL,'171437',NULL,NULL,NULL,2,'ingjsilvetti@gmail.com',NULL,'user.png','5493814765076',2,'N',NULL,NULL,'N',195,'2025-06-04 12:17:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8;

/*Data for the table `personasvsdisciplinas` */

insert  into `personasvsdisciplinas`(`idpersonavsdisciplina`,`idpersona`,`iddisciplina`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,1,1,'N',1,'2025-03-15 13:44:55'),(2,2,1,'N',1,'2025-03-27 09:18:47'),(3,3,5,'N',1,'2025-05-09 16:21:36'),(4,171,4,'N',1,'2025-05-09 16:23:08'),(5,172,4,'N',1,'2025-05-09 16:25:48'),(6,173,4,'N',1,'2025-05-09 16:27:00'),(7,174,4,'N',1,'2025-05-09 16:28:22'),(8,175,4,'N',1,'2025-05-09 16:29:38'),(9,4,4,'N',1,'2025-05-09 16:29:38'),(10,5,4,'N',1,'2025-05-09 16:29:38'),(155,187,4,'N',1,'2025-05-21 16:48:38'),(156,188,4,'N',1,'2025-05-21 16:50:21'),(157,189,4,'N',1,'2025-05-21 16:51:17'),(158,190,4,'N',1,'2025-05-21 16:52:03'),(159,191,4,'N',1,'2025-05-21 16:52:48'),(160,192,4,'N',1,'2025-05-21 16:53:26'),(161,193,4,'N',1,'2025-05-21 16:54:01'),(162,194,4,'N',1,'2025-05-21 19:30:33'),(163,195,4,'N',1,'2025-05-21 19:31:58'),(164,196,4,'N',1,'2025-05-21 19:33:00'),(165,197,4,'N',1,'2025-05-21 19:33:48'),(166,198,4,'N',1,'2025-05-21 19:34:38'),(167,199,4,'N',1,'2025-05-21 19:35:34'),(168,200,4,'N',1,'2025-05-21 19:36:28'),(169,201,4,'N',1,'2025-05-21 19:37:25'),(170,202,4,'N',1,'2025-05-21 19:38:33'),(171,203,3,'N',1,'2025-05-21 20:05:41'),(172,204,2,'N',1,'2025-05-23 12:24:22'),(173,205,2,'N',1,'2025-05-23 12:24:32'),(174,206,2,'N',1,'2025-05-23 12:24:41'),(175,207,2,'N',1,'2025-05-23 12:24:49'),(176,208,2,'N',1,'2025-05-23 12:24:58'),(177,209,2,'N',1,'2025-05-23 12:25:06'),(178,210,2,'N',1,'2025-05-23 12:25:11'),(179,211,2,'N',1,'2025-05-23 12:25:15'),(180,212,2,'N',1,'2025-05-23 12:25:23'),(181,213,5,'N',1,'2025-05-23 16:23:03'),(182,214,2,'N',3,'2025-05-26 15:38:47'),(183,215,5,'N',1,'2025-05-26 15:46:32'),(187,219,2,'N',4,'2025-06-03 16:03:27'),(188,220,2,'N',4,'2025-06-03 16:03:57'),(189,221,2,'N',4,'2025-06-03 16:04:21'),(190,222,2,'N',4,'2025-06-03 16:04:42'),(191,223,2,'N',4,'2025-06-03 16:05:10'),(192,224,2,'N',4,'2025-06-04 11:46:36'),(193,225,2,'N',195,'2025-06-04 12:17:41');

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
) ENGINE=InnoDB AUTO_INCREMENT=206 DEFAULT CHARSET=utf8;

/*Data for the table `tareas` */

insert  into `tareas`(`idtarea`,`descripciontarea`,`tiempotarea`,`accion`,`idempleadoaccion`,`fechaaccion`) values (191,'PRESUPUESTO DE CHAPA Y PINTURA',0,'N',4,'2025-06-03 16:03:27'),(192,'Servicio de 90.000 Km',0,'N',4,'2025-06-03 16:03:57'),(193,'RUIDO AL PONER LA MARCHA ATRAS',0,'N',4,'2025-06-03 16:03:57'),(194,'Servicio de 50.000 Km',14,'M',5,'2025-06-04 20:59:22'),(195,'Servicio de 20.000 Km (SAM - PV)',0,'N',4,'2025-06-03 16:04:42'),(196,'AL GIRAR EL VOLANTE SE SIENTE QUE VIBRA',0,'N',4,'2025-06-03 16:04:42'),(197,'CONTROL CARROCERIA',0,'N',4,'2025-06-03 16:04:42'),(198,'Servicio de 10.000 Km (SAM)',1690,'M',4,'2025-06-04 20:44:47'),(199,'CONTROL TREN DELANTERO',1689,'M',4,'2025-06-04 20:44:33'),(200,'8817',0,'N',4,'2025-06-03 16:05:10'),(201,'CONTROL NOTO QUE BAJO EL NIVEL DE LIQUIDO REFRIGRANTE',0,'N',4,'2025-06-03 16:05:10'),(202,'SALIDA DE RUTA',1684,'M',4,'2025-06-04 20:44:37'),(203,'Servicio de 30.000 Km',0,'N',4,'2025-06-04 11:46:36'),(204,'Servicio de 20.000 Km BONIFICADO PV',66,'M',195,'2025-06-04 13:38:30'),(205,'CTRL NOTA QUE EL ESPEJO RETROVISOR DERECHO NO ES IGUAL AL CRISTAL DEL IZQ',1,'M',195,'2025-06-04 12:21:40');

/*Table structure for table `tareassuspendidas` */

DROP TABLE IF EXISTS `tareassuspendidas`;

CREATE TABLE `tareassuspendidas` (
  `idtareasuspendida` int(11) NOT NULL AUTO_INCREMENT,
  `numorden` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `idtarea` int(11) DEFAULT NULL,
  `idempleado` int(11) DEFAULT NULL,
  `observacion` varchar(200) DEFAULT NULL,
  `fechaaccion` datetime DEFAULT NULL,
  `suspendida` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'N',
  PRIMARY KEY (`idtareasuspendida`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/*Data for the table `tareassuspendidas` */

insert  into `tareassuspendidas`(`idtareasuspendida`,`numorden`,`idtarea`,`idempleado`,`observacion`,`fechaaccion`,`suspendida`) values (21,'171430',203,4,'','2025-06-04 11:47:41','S'),(22,'171430',203,4,'Reactivar Tarea','2025-06-04 11:48:31','N'),(23,'171437',204,195,'','2025-06-04 13:06:53','S'),(24,'171437',204,195,'Reactivar Tarea','2025-06-04 13:38:13','N');

/*Table structure for table `tipopersona` */

DROP TABLE IF EXISTS `tipopersona`;

CREATE TABLE `tipopersona` (
  `idtipopersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipopersona` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idtipopersona`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `tipopersona` */

insert  into `tipopersona`(`idtipopersona`,`tipopersona`) values (1,'Administración'),(2,'Cliente'),(3,'Gerente'),(4,'Mecanico'),(5,'Supervisor'),(6,'Otros');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
