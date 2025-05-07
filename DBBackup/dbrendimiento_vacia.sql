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

/*Table structure for table `oficinas` */

DROP TABLE IF EXISTS `oficinas`;

CREATE TABLE `oficinas` (
  `idoficina` int(11) NOT NULL AUTO_INCREMENT,
  `nombreoficina` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idoficina`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

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

/*Table structure for table `tipopersona` */

DROP TABLE IF EXISTS `tipopersona`;

CREATE TABLE `tipopersona` (
  `idtipopersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipopersona` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`idtipopersona`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
