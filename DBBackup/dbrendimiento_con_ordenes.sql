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
  PRIMARY KEY (`idafectadotarea`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;

/*Data for the table `afectadostareas` */

insert  into `afectadostareas`(`idafectadotarea`,`numorden`,`idtarea`,`estado`,`idempleado`,`observacion`,`fechaini`,`fechaobs`,`abandona`) values (117,'171066',164,'P',4,'SE INICIA TAREA','2025-05-30 12:52:07',NULL,'N');

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
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8;

/*Data for the table `autorizaraccorden` */

insert  into `autorizaraccorden`(`idautorizar`,`numorden`,`idpersona`,`estado`,`fechaautoriza`,`observacion`,`accion`,`fechaaccion`,`idempleadoaccion`) values (128,'171066',4,'A','2025-05-30 12:41:17','AUTORIZA','M','2025-05-30 12:41:17',4);

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
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8;

/*Data for the table `detalleorden` */

insert  into `detalleorden`(`iddetalleorden`,`numeroorden`,`idtarea`,`fini`,`ffin`,`estado`,`observacion`,`accion`,`idempleadoaccion`,`fechaaccion`) values (212,'171068',159,NULL,NULL,'S',NULL,'M',3,'2025-05-30 11:13:50'),(213,'171068',160,NULL,NULL,'S',NULL,'M',5,'2025-05-30 11:55:21'),(214,'171068',161,NULL,NULL,'S',NULL,'M',4,'2025-05-30 12:38:29'),(215,'171068',162,NULL,NULL,'S',NULL,'M',5,'2025-05-30 11:54:51'),(216,'171067',163,NULL,NULL,'S',NULL,'M',3,'2025-05-30 11:13:38'),(217,'171066',164,'2025-05-30 12:52:07',NULL,'P',NULL,'M',4,'2025-05-30 12:52:07'),(218,'171066',165,NULL,NULL,'D',NULL,'M',3,'2025-05-30 12:41:07'),(219,'171066',166,NULL,NULL,'D',NULL,'M',3,'2025-05-30 12:41:07'),(220,'171066',167,NULL,NULL,'D',NULL,'M',3,'2025-05-30 12:41:07'),(221,'171065',168,NULL,NULL,'S',NULL,'M',3,'2025-05-27 09:57:56'),(222,'171065',169,NULL,NULL,'S',NULL,'M',5,'2025-05-27 09:58:27'),(223,'171064',164,NULL,NULL,'S',NULL,'M',4,'2025-05-28 20:22:14'),(224,'171064',170,NULL,NULL,'S',NULL,'M',3,'2025-05-28 20:21:59'),(225,'171064',171,NULL,NULL,'S',NULL,'M',3,'2025-05-28 20:21:59'),(226,'171064',172,NULL,NULL,'S',NULL,'M',3,'2025-05-28 20:21:59'),(227,'171063',172,NULL,NULL,'S',NULL,'M',4,'2025-05-28 21:35:29'),(228,'171062',174,NULL,NULL,'S',NULL,'M',4,'2025-05-28 22:25:38'),(229,'171061',164,NULL,NULL,'S',NULL,'M',4,'2025-05-29 01:11:49'),(230,'171061',175,NULL,NULL,'S',NULL,'M',5,'2025-05-30 10:05:19'),(231,'171060',164,NULL,NULL,'S',NULL,'M',5,'2025-05-30 11:09:38'),(232,'171060',167,NULL,NULL,'S',NULL,'M',4,'2025-05-30 11:09:01'),(233,'171060',176,NULL,NULL,'S',NULL,'M',3,'2025-05-30 11:08:41'),(234,'171082',177,NULL,NULL,'S',NULL,'N',1,'2025-05-26 15:42:56'),(235,'171082',178,NULL,NULL,'S',NULL,'N',1,'2025-05-26 15:43:11');

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
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

/*Data for the table `numeroorden` */

insert  into `numeroorden`(`idnumorden`,`numorden`,`fecha`,`fechaentrega`,`idcliente`,`modelo`,`numchasis`,`patente`,`kilometraje`,`fventa`,`estado`,`tituloorden`,`idpersonadisp`,`conocio`,`accion`,`fechaaccion`,`idempleadoaccion`) values (102,'171068','2025-05-09 09:58:00','2025-05-09',204,NULL,'YE05545','0','15089',NULL,'S',NULL,NULL,'Busqueda Google','M','2025-05-30 12:38:29',4),(103,'171067','2025-05-09 09:25:00','2025-05-09',205,NULL,'SY999041','0','20610',NULL,'S',NULL,NULL,'Busqueda Google','M','2025-05-30 11:13:38',3),(104,'171066','2025-05-09 08:59:00','2025-05-09',206,NULL,'SU430552','0','9630',NULL,'P','SAM 10000 km',3,'Busqueda Google','M','2025-05-30 12:52:07',4),(105,'171065','2025-05-09 08:54:00','2025-05-09',207,NULL,'RU386889','0','20258',NULL,'S',NULL,NULL,'Busqueda Google','M','2025-05-27 09:58:27',5),(106,'171064','2025-05-09 08:51:00','2025-05-09',208,NULL,'YA09674','0','10607',NULL,'S',NULL,NULL,'Referido','M','2025-05-28 20:22:14',4),(107,'171063','2025-05-09 08:35:00','2025-05-09',209,NULL,'SU451082','0','1157',NULL,'S',NULL,NULL,'Referido','M','2025-05-28 21:35:29',4),(108,'171062','2025-05-09 08:29:00','2025-05-09',210,NULL,'YS80125','0','9214',NULL,'S',NULL,NULL,'Busqueda Google','M','2025-05-28 22:25:38',4),(109,'171061','2025-05-09 08:26:00','2025-05-09',211,NULL,'RU343690','0','11173',NULL,'S',NULL,NULL,'Facebook','M','2025-05-30 10:05:19',5),(110,'171060','2025-05-09 08:25:00','2025-05-09',212,NULL,'SU427780','0','10253',NULL,'S',NULL,NULL,'Busqueda Google','M','2025-05-30 11:09:38',5),(111,'171082','2025-05-12 10:45:00','2025-05-12',214,NULL,'SU442154','0','4840',NULL,'S',NULL,NULL,'Referido','N','2025-05-26 15:43:11',4);

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
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`apellido`,`nombre`,`nombrecortousu`,`dni`,`nrosocio`,`domicilio`,`fnacimiento`,`idtipopersona`,`emailusuario`,`pass`,`urlfoto`,`tel`,`idoficina`,`aptoingreso`,`finiapto`,`ffinapto`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,'Flores','Cesar','C. L. Flores','12345678','admin','','1981-02-14',1,'admin@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/team-4.jpg','',1,'S',NULL,NULL,'M',1,'2025-05-21 16:33:42'),(2,'gerente','','gerente','123456','gerente','','2000-01-01',3,'gerente@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/84.jpg','',3,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:56'),(3,'supervisor','','supervisor','12','supervisor1','','2000-01-01',5,'supervisor@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/85.jpg','',5,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:15'),(4,'mecanico1','','mecanico1','12345','meca1','','2000-01-01',4,'mecanico1@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/86.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:34:05'),(5,'mecanico2','','mecanico2','10031245','meca2','','2000-01-01',4,'mecanico2@gmail.com','$2y$10$ivCMMVK/11C.OH1O6WdV7.lY5Iml12dqjrkAyg7daRbFunRdLqelq','avatar/136.jpg','',4,'S','2025-03-27','2025-04-27','M',1,'2025-05-21 16:33:27'),(170,'Apaza','Elias Exequiel','elias','40088831','','...','1996-02-12',4,'elias.apaza@piazzatucuman.com','$2y$10$FxHGBBHr7iImQw2wjSir7.VkExH/1OIrF92epV2VxmTjWTraGSPu.','avatar/170.jpg','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-20 16:37:17'),(171,'Apaza','Julia Nahuel','Julian','42277957','Julian','','2000-01-20',4,'julian.apaza@piazzatucuman.com','$2y$10$eT8IMnKb9.4nevQNgKOToubxIAQHFbWPVCGgm16jwxXhbkeETQXBu','avatar/171.jpg','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:27'),(172,'Farroni','Leandro Gabriel','Leandro','43002836','Leandro','','1995-06-10',4,'leandro.farroni@piazzatucuman.com','$2y$10$QvaPEVnvl2WGKqWg9oQy1uToyabfhO8paoMcjEqlDyLUFYjzriSUW','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:38'),(173,'Gambarte','Orlando Maximiliano','Orlando','32556932','Orlando','','1986-09-27',4,'orlando.bambarte@piazzatucuman.com','$2y$10$RPmvAUfM.woUypK4oNREO.fg2e7EUVSpZyQ6aMli7SJntIMlS3fwG','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:47'),(174,'Gonzales','Julian Ezequiel','Ezequiel','34159269','Ezequiel','','1989-12-18',4,'ezequiel.gonzalez@piazzatucuman.com','$2y$10$imsyvQS.wd3z9AYU69JTTOjgCqEPM2qQxTID0oCnrhSMKhMH/D75q','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:48:58'),(175,'Grima','Jesus Nazareno','Jesus','17527782','Jesus','','1965-12-24',4,'jesus.grima@piazzatucuman.com','$2y$10$WBvm.ziEyEChTvolfebdN.FXghuUydavjysdXJIb9MeIh6BTGf8rq','user.png','',4,'S','2025-05-09','2025-06-09','M',1,'2025-05-21 19:49:07'),(187,'Hladki','Daniel Eduardo','Daniel','34132944','Daniel','','2000-09-14',4,'daniel.hladki@piazzatucuman.com','$2y$10$MCrU3.LgcCYzmQgxIFEHyO8CsgY46XD0aaMlz5JKTp03aKVopDPtO','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:49:23'),(188,'Juarez','Damian Jesus','Damian','31900306','Damian','','2000-01-01',4,'damian.juarez@piazzatucuman.com','$2y$10$oh.yUrxVDmAzNKe5i1GseOvnguEh2lT4MaMKPiVkNHiIW9iO7lkpO','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:49:44'),(189,'Luna','Andres Emiliano','Andres','34285301','Andres','','2000-01-01',4,'andres.luna@piazzatucuman.com','$2y$10$SeWlFFuQD8GHPziJOnh0seCjQkVJYjqseIngpIvXE/ZaLrwH8btp.','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:50:01'),(190,'Miranda','Emanuel Carlos Exequiel','Emanuel','34185167','Emanuel','','2000-01-01',4,'emanuel.miranda@piazzatucuman.com','$2y$10$TiZNPSTbUd730.qvT5SrpuKgQQ/rRvgF/F/exW2GmyhAvqli4Ixte','user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:50:28'),(191,'Nuñez','Juan Pablo','Juan','33139104','JuanP','','2000-01-01',4,'juanpablo.nunez@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:30:51'),(192,'Orellana','Victor Manuel','Victor','37725579','Victor','','2000-01-01',4,'victor.orellana@piazzatucuman.com',NULL,'avatar/192.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:45:11'),(193,'Perez','Franco Nahuel','Franco','39575330','Franco','','2000-01-01',4,'franco.perez@piazzatucuman.com',NULL,'avatar/193.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:29:47'),(194,'Ponce','Juan Carlos','Juan','43707300','JuanC','','2000-01-01',4,'juancarlos.ponce@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:31:07'),(195,'Rodriguez','Gonzalo','Gonzalo','36584084','Gonzalo','','2000-01-01',4,'gonzalo.rodriguez@piazzatucuman.com',NULL,'avatar/195.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:32:25'),(196,'Romera','Antonio Jesus','Antonio','34911553','Antonio','','2000-01-01',4,'antonio.romera@piazzatucuman.com',NULL,'avatar/196.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:33:13'),(197,'Salas','Jorge Leandro','Jorge','34911676','Jorge','','2000-01-01',4,'jorge.salas@piazzatucuman.com',NULL,'avatar/197.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:34:03'),(198,'Sanchez','Miguel Eduardo','Miguel','26209826','Miguel','','2000-01-01',4,'miguel.sanchez@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:34:50'),(199,'Sarmiento','Ulises Marcelo','Ulises','41425075','Ulises','','2000-01-01',4,'ulises.sarmiento@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:35:47'),(200,'Torres','Francis Javier','Francis','39974833','Francis','','2000-01-01',4,'francis.torres@piazzatucuman.com',NULL,'avatar/200.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:36:40'),(201,'Urueña','Roque Gonzalo','Roque','43648849','Roque','','2000-01-01',4,'gonzalo.uruena@piazzatucuman.com',NULL,'avatar/201.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:37:37'),(202,'Zenczarki','Angel Jesus Andres','Angel','42525099','Angel','','2000-01-01',4,'angel.zenczarski@piazzatucuman.com',NULL,'user.png','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 19:38:47'),(203,'Jairala','Cecilia','Cecilia','26783330','Cecilia','','2000-01-01',3,'cecilia.jairala@piazzatucuman.com','$2y$10$KtMDYwphKV3UZefH05o0lurmSLd173GPq9bBOw.ApqMLJweuSM4F6','avatar/203.jpg','',4,'S','2025-05-21','2025-06-21','M',1,'2025-05-21 20:06:34'),(204,'','TEVES REYNALDO FABIAN',NULL,'171068',NULL,NULL,NULL,2,'rabitoyeves@gmail.com',NULL,'user.png','5493815531736',2,'N',NULL,NULL,'N',1,'2025-05-23 12:24:22'),(205,'','MERINO MARIA BELEN',NULL,'171067',NULL,NULL,NULL,2,'victoremanuelmerino@gmail.com',NULL,'user.png','5493816308582',2,'N',NULL,NULL,'N',1,'2025-05-23 12:24:32'),(206,'','GALILEA FLAVIO MARCELO',NULL,'171066',NULL,NULL,NULL,2,'galileaflavio@gmail.com',NULL,'user.png','5493813015857',2,'N',NULL,NULL,'N',1,'2025-05-23 12:24:41'),(207,'','MEDINA MONICA ALEJANDRA',NULL,'171065',NULL,NULL,NULL,2,'moni3217ca@gmail.com',NULL,'user.png','5493813396190',2,'N',NULL,NULL,'N',1,'2025-05-23 12:24:49'),(208,'','VARGAS KAREN ANALIS',NULL,'171064',NULL,NULL,NULL,2,'karenanalis30@gmail.com',NULL,'user.png','5493815674280',2,'N',NULL,NULL,'N',1,'2025-05-23 12:24:58'),(209,'','TUCCI CLAUDIO ANTONIO',NULL,'171063',NULL,NULL,NULL,2,'claudio.tucci@ar.abb.com',NULL,'user.png','5491160265714',2,'N',NULL,NULL,'N',1,'2025-05-23 12:25:06'),(210,'','APARICIO CARLOS DANIEL',NULL,'171062',NULL,NULL,NULL,2,'carlosrobertoaparicio1963@gmail.com',NULL,'user.png','5493816673515',2,'N',NULL,NULL,'N',1,'2025-05-23 12:25:11'),(211,'','GUERRERO MARIA CELESTE',NULL,'171061',NULL,NULL,NULL,2,'matiasgsalazar@gmail.com',NULL,'user.png','5493815126824',2,'N',NULL,NULL,'N',1,'2025-05-23 12:25:15'),(212,'','MEDINA ANA MARIA',NULL,'171060',NULL,NULL,NULL,2,'anamedina70@hotmail.com',NULL,'user.png','5493816125539',2,'N',NULL,NULL,'N',1,'2025-05-23 12:25:23'),(213,'safsd','sdfasdf','sdfsdf','3413421','','hjkjh','2000-01-01',5,'jhkjhkjh@rrr.com',NULL,'user.png','',4,'S','2025-05-23','2025-06-23','M',1,'2025-05-23 16:24:04'),(214,'','PAZ AMELIA PAOLA',NULL,'171082',NULL,NULL,NULL,2,'paopaz7@hotmail.com.ar',NULL,'user.png','5493814010527',2,'N',NULL,NULL,'N',3,'2025-05-26 15:38:47'),(215,'Campos','Sergio','Sergio','1','Sergio','','2000-01-01',5,'sergio.campos@piazzatucuman.com','$2y$10$KVKemTS7dDgBvf3yorV6m.34Ip.PYETaP0J7wxDHXS0xxjPnaAWNe','user.png','',4,'S','2025-05-26','2025-06-26','M',1,'2025-05-26 15:47:01');

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
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=utf8;

/*Data for the table `personasvsdisciplinas` */

insert  into `personasvsdisciplinas`(`idpersonavsdisciplina`,`idpersona`,`iddisciplina`,`accion`,`idempleadoaccion`,`fechaaccion`) values (1,1,1,'N',1,'2025-03-15 13:44:55'),(2,2,1,'N',1,'2025-03-27 09:18:47'),(3,3,5,'N',1,'2025-05-09 16:21:36'),(4,171,4,'N',1,'2025-05-09 16:23:08'),(5,172,4,'N',1,'2025-05-09 16:25:48'),(6,173,4,'N',1,'2025-05-09 16:27:00'),(7,174,4,'N',1,'2025-05-09 16:28:22'),(8,175,4,'N',1,'2025-05-09 16:29:38'),(9,4,4,'N',1,'2025-05-09 16:29:38'),(10,5,4,'N',1,'2025-05-09 16:29:38'),(155,187,4,'N',1,'2025-05-21 16:48:38'),(156,188,4,'N',1,'2025-05-21 16:50:21'),(157,189,4,'N',1,'2025-05-21 16:51:17'),(158,190,4,'N',1,'2025-05-21 16:52:03'),(159,191,4,'N',1,'2025-05-21 16:52:48'),(160,192,4,'N',1,'2025-05-21 16:53:26'),(161,193,4,'N',1,'2025-05-21 16:54:01'),(162,194,4,'N',1,'2025-05-21 19:30:33'),(163,195,4,'N',1,'2025-05-21 19:31:58'),(164,196,4,'N',1,'2025-05-21 19:33:00'),(165,197,4,'N',1,'2025-05-21 19:33:48'),(166,198,4,'N',1,'2025-05-21 19:34:38'),(167,199,4,'N',1,'2025-05-21 19:35:34'),(168,200,4,'N',1,'2025-05-21 19:36:28'),(169,201,4,'N',1,'2025-05-21 19:37:25'),(170,202,4,'N',1,'2025-05-21 19:38:33'),(171,203,3,'N',1,'2025-05-21 20:05:41'),(172,204,2,'N',1,'2025-05-23 12:24:22'),(173,205,2,'N',1,'2025-05-23 12:24:32'),(174,206,2,'N',1,'2025-05-23 12:24:41'),(175,207,2,'N',1,'2025-05-23 12:24:49'),(176,208,2,'N',1,'2025-05-23 12:24:58'),(177,209,2,'N',1,'2025-05-23 12:25:06'),(178,210,2,'N',1,'2025-05-23 12:25:11'),(179,211,2,'N',1,'2025-05-23 12:25:15'),(180,212,2,'N',1,'2025-05-23 12:25:23'),(181,213,5,'N',1,'2025-05-23 16:23:03'),(182,214,2,'N',3,'2025-05-26 15:38:47'),(183,215,5,'N',1,'2025-05-26 15:46:32');

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
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

/*Data for the table `tareas` */

insert  into `tareas`(`idtarea`,`descripciontarea`,`tiempotarea`,`accion`,`idempleadoaccion`,`fechaaccion`) values (158,'prueba GENERAL 3',1747962000,'B',1,'2025-05-22 15:41:04'),(159,'NO FUNCIONA LA ALTA Y LA BAJA LADO DERECHO',0,'N',1,'2025-05-23 12:24:22'),(160,'8710',0,'N',1,'2025-05-23 12:24:22'),(161,'8754',43,'M',4,'2025-05-30 12:38:29'),(162,'8786',2,'M',5,'2025-05-24 11:58:41'),(163,'Servicio de 20.000 Km',0,'N',1,'2025-05-23 12:24:32'),(164,'Servicio de 10.000 Km',64,'M',4,'2025-05-27 10:52:03'),(165,'CONTROL TREN DELANTERO',0,'N',1,'2025-05-23 12:24:41'),(166,'VERIFICAR CHAPON QUE NO SE ENCUENTRE SUELTO YA QUE ROZA EN CALLE',0,'N',1,'2025-05-23 12:24:41'),(167,'8817',0,'N',1,'2025-05-23 12:24:41'),(168,'Servicio de 20.000 Km (SAM - PV)',0,'N',1,'2025-05-23 12:24:49'),(169,'RUIDO EN ZONA DELANTERA AL ANDAR',0,'N',1,'2025-05-23 12:24:49'),(170,'CONTROL SIENTE RUIDO EN ALGUNOS DE LOS PARLANTES COMO SATURADO',0,'N',1,'2025-05-23 12:24:58'),(171,'AGREGAR LIQUIDO LIMPIA PARABRISAS',0,'N',1,'2025-05-23 12:24:58'),(172,'8835',0,'N',1,'2025-05-23 12:24:58'),(173,'CONTROL CAMARA QUEDA TRABADA EN MARCHA ATRAS CUANDO VA EN DRIVE LE PASA SEGUIDO Y DEBE APAGARLO AL V',0,'N',1,'2025-05-23 12:25:06'),(174,'Servicio de 10.000 Km (sam)',0,'N',1,'2025-05-23 12:25:11'),(175,'8724',0,'N',1,'2025-05-23 12:25:15'),(176,'8829',0,'N',1,'2025-05-23 12:25:23'),(177,'CTRL SE ENCENDIO TESTIGO DE MOTOR',3,'M',4,'2025-05-26 15:42:56'),(178,'ACT-8817',0,'N',3,'2025-05-26 15:38:47');

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
