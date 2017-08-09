-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 03, 2017 at 04:37 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 5.6.30-10+deb.sury.org~xenial+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistemadecontrol`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `alumnos_porcurso`
--
CREATE TABLE `alumnos_porcurso` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Estado` int(11)
,`Id_Cargo` int(11)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Table structure for table `ano_entrega`
--

CREATE TABLE `ano_entrega` (
  `Id_Ano` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ano_entrega`
--

INSERT INTO `ano_entrega` (`Id_Ano`, `Descripcion`) VALUES
(1, '2010'),
(2, '2011'),
(3, '2012'),
(4, '2013'),
(5, '2014'),
(6, '2015'),
(7, '2016'),
(8, '2017'),
(9, '2018'),
(10, '2019'),
(11, '2020');

-- --------------------------------------------------------

--
-- Table structure for table `asistencia_alumnos`
--

CREATE TABLE `asistencia_alumnos` (
  `Dni` int(11) NOT NULL,
  `Apellidos_Nombres` varchar(400) DEFAULT NULL,
  `Fecha` date DEFAULT NULL,
  `Usuario` varchar(18) DEFAULT NULL,
  `Estado_Asistencia` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `asistencia_rte`
--

CREATE TABLE `asistencia_rte` (
  `Id_Asistencia` int(11) NOT NULL,
  `Mes` varchar(100) DEFAULT NULL,
  `Ano` int(11) DEFAULT NULL,
  `DniRte` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `atencion_equipos`
--

CREATE TABLE `atencion_equipos` (
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Fecha_Entrada` date DEFAULT NULL,
  `Id_Prioridad` int(11) NOT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Dni` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atencion_equipos`
--

INSERT INTO `atencion_equipos` (`Id_Atencion`, `NroSerie`, `Fecha_Entrada`, `Id_Prioridad`, `Usuario`, `Dni`) VALUES
(1, 'AA4074078679', '2017-04-24', 2, 'jjcervera', 90),
(2, 'AA2074076234', '2017-04-26', 3, 'jjcervera', 32304988),
(3, 'AA2074133175', '2017-04-26', 1, 'jjcervera', 42192571),
(4, 'AA9184144060', '2017-05-02', 3, 'jjcervera', 16279810),
(7, 'AA4074071743', '2017-05-22', 1, 'jjcervera', 45027501),
(8, 'AA7184070766', '2017-05-22', 1, 'jjcervera', 18266673),
(9, 'AA4074072458', '2017-05-22', 1, 'jjcervera', 49278992),
(10, 'AA4074068053', '2017-05-24', 1, 'jjcervera', 27289607);

-- --------------------------------------------------------

--
-- Table structure for table `atencion_para_st`
--

CREATE TABLE `atencion_para_st` (
  `Nro_Tiket` varchar(50) DEFAULT NULL,
  `Fecha_Retiro` date DEFAULT NULL,
  `Observacion` varchar(300) DEFAULT NULL,
  `Id_Tipo_Retiro` int(11) NOT NULL,
  `Referencia_Tipo_Retiro` varchar(50) DEFAULT NULL,
  `Fecha_Devolucion` date DEFAULT NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `atencion_para_st`
--

INSERT INTO `atencion_para_st` (`Nro_Tiket`, `Fecha_Retiro`, `Observacion`, `Id_Tipo_Retiro`, `Referencia_Tipo_Retiro`, `Fecha_Devolucion`, `Id_Atencion`, `NroSerie`) VALUES
('1484806', '2017-05-25', 'nada', 3, 'st99', '2017-05-31', 9, 'AA4074072458'),
('345345', '2017-06-23', 'nada', 3, '9999', NULL, 10, 'AA4074068053');

-- --------------------------------------------------------

--
-- Table structure for table `audittrail`
--

CREATE TABLE `audittrail` (
  `id` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  `script` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `table` varchar(255) DEFAULT NULL,
  `field` varchar(255) DEFAULT NULL,
  `keyvalue` longtext,
  `oldvalue` longtext,
  `newvalue` longtext
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audittrail`
--

INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(28, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Fecha_Actualizacion', '1', '2017-04-18', ''),
(27, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Detalle', '1', 'kjhjkh', ''),
(26, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Id_Novedad', '1', '1', ''),
(25, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', '*** Batch delete begin ***', 'novedades', '', '', '', ''),
(24, '2017-04-18 16:19:39', '/sistema/novedadesedit.php', '-1', 'U', 'novedades', 'Archivos', '1', NULL, 'Novedad1(1).jpg'),
(23, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Id_Novedad', '1', '', '1'),
(22, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Usuario', '1', '', 'Administrator'),
(21, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Fecha_Actualizacion', '1', '', '2017-04-18'),
(20, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Links', '1', '', NULL),
(19, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Archivos', '1', '', NULL),
(18, '2017-04-18 16:19:23', '/sistema/novedadesadd.php', '-1', 'A', 'novedades', 'Detalle', '1', '', 'kjhjkh'),
(17, '2017-04-18 13:40:38', '/sistema/login.php', 'admin', 'login', '::1', '', '', '', ''),
(16, '2017-04-18 13:38:57', '/sistema/logout.php', 'Administrator', 'logout', '::1', '', '', '', ''),
(29, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Usuario', '1', 'Administrator', ''),
(30, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Archivos', '1', 'Novedad1(1).jpg', ''),
(31, '2017-04-18 16:19:59', '/sistema/novedadesdelete.php', '-1', 'D', 'novedades', 'Links', '1', NULL, ''),
(32, '2017-04-18 16:20:00', '/sistema/novedadesdelete.php', '-1', '*** Batch delete successful ***', 'novedades', '', '', '', ''),
(33, '2017-04-23 00:30:34', '/logout.php', 'Administrator', 'logout', '127.0.0.1', '', '', '', ''),
(34, '2017-04-23 00:30:46', '/login.php', 'admin', 'login', '127.0.0.1', '', '', '', ''),
(35, '2017-04-23 01:50:15', '/login.php', 'admin', 'login', '90.0.0.197', '', '', '', ''),
(36, '2017-04-23 03:09:40', '/sistema/login.php', 'admin', 'login', '90.0.0.197', '', '', '', ''),
(37, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Cue', '540055800', '', '540055800'),
(38, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Nombre_Establecimiento', '540055800', '', 'BACHILLERATO ORIENTADO PROVINCIIAL N° 22 - ANDRÉS GUACURARÍ'),
(39, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Sigla', '540055800', '', 'BOP022'),
(40, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Nro_Cuise', '540055800', '', NULL),
(41, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Departamento', '540055800', '', '10'),
(42, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Localidad', '540055800', '', '36'),
(43, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Domicilio', '540055800', '', 'AV. JAURETCHE S/N'),
(44, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Telefono_Escuela', '540055800', '', '03757496067'),
(45, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Mail_Escuela', '540055800', '', 'JORGELEIVAS@HOTMAIL.COM'),
(46, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Matricula_Actual', '540055800', '', NULL),
(47, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Cantidad_Aulas', '540055800', '', NULL),
(48, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Comparte_Edificio', '540055800', '', 'NO'),
(49, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Cantidad_Turnos', '540055800', '', '3'),
(50, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Geolocalizacion', '540055800', '', NULL),
(51, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Tipo_Esc', '540055800', '', '14'),
(52, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Universo', '540055800', '', '2011'),
(53, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Tiene_Programa', '540055800', '', 'Si'),
(54, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Sector', '540055800', '', 'PUBLICO'),
(55, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Cantidad_Netbook_Conig', '540055800', '', NULL),
(56, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Cantidad_Netbook_Actuales', '540055800', '', NULL),
(57, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Nivel', '540055800', '', '2'),
(58, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Jornada', '540055800', '', '2'),
(59, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Tipo_Zona', '540055800', '', NULL),
(60, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Estado_Esc', '540055800', '', '1'),
(61, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Id_Zona', '540055800', '', '9'),
(62, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Fecha_Actualizacion', '540055800', '', '2017-04-23'),
(63, '2017-04-23 03:13:34', '/sistema/dato_establecimientoadd.php', '-1', 'A', 'dato_establecimiento', 'Usuario', '540055800', '', 'Administrator'),
(64, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', '*** Batch update begin ***', 'personas', '', '', '', ''),
(65, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Id_Sexo', '75', '3', '2'),
(66, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Id_Cargo', '75', '6', '2'),
(67, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Id_Estado', '75', '11', '6'),
(68, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Id_Curso', '75', '17', '10'),
(69, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Id_Turno', '75', '3', '2'),
(70, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Dni_Tutor', '75', '25315466', '13444992'),
(71, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Usuario', '75', NULL, 'Administrator'),
(72, '2017-04-23 03:22:43', '/sistema/personasupdate.php', '-1', 'U', 'personas', 'Fecha_Actualizacion', '75', NULL, '2017-04-23'),
(73, '2017-04-23 03:22:44', '/sistema/personasupdate.php', '-1', '*** Batch update successful ***', 'personas', '', '', '', ''),
(74, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'NombreTitular', 'jjcervera', '', 'CERVERA JUAN JOSE'),
(75, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Dni', 'jjcervera', '', '27289607'),
(76, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nombre', 'jjcervera', '', 'jjcervera'),
(77, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Password', 'jjcervera', '', '********'),
(78, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nivel_Usuario', 'jjcervera', '', '4'),
(79, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Curso', 'jjcervera', '', '10'),
(80, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Turno', 'jjcervera', '', '2'),
(81, '2017-04-23 03:23:32', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Division', 'jjcervera', '', '13'),
(82, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'NombreTitular', 'gabriel.zrt', '', 'ZARATE GABRIEL(USO ADMINISTRADOR)'),
(83, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Dni', 'gabriel.zrt', '', '90'),
(84, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nombre', 'gabriel.zrt', '', 'gabriel.zrt'),
(85, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Password', 'gabriel.zrt', '', '********'),
(86, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nivel_Usuario', 'gabriel.zrt', '', '4'),
(87, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Curso', 'gabriel.zrt', '', '10'),
(88, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Turno', 'gabriel.zrt', '', '1'),
(89, '2017-04-23 03:25:21', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Division', 'gabriel.zrt', '', '13'),
(90, '2017-04-23 03:25:47', '/sistema/logout.php', 'Administrator', 'logout', '90.0.0.197', '', '', '', ''),
(91, '2017-04-23 03:25:59', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(92, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '2', '', 'cartelera1'),
(93, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '2', '', 'conectar-igualdad-660x330.jpg'),
(94, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '2', '', NULL),
(95, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '2', '', '2017-04-23'),
(96, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '2', '', 'jjcervera'),
(97, '2017-04-23 03:34:54', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '2', '', '2'),
(98, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '3', '', 'cartelera2'),
(99, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '3', '', 'conectar-Netbooks_escolares.jpg'),
(100, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '3', '', NULL),
(101, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '3', '', '2017-04-23'),
(102, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '3', '', 'jjcervera'),
(103, '2017-04-23 03:44:23', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '3', '', '3'),
(104, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '4', '', 'cartelera3'),
(105, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '4', '', 'conectar destacadotramite-58c31946c43b3.jpg'),
(106, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '4', '', NULL),
(107, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '4', '', '2017-04-23'),
(108, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '4', '', 'jjcervera'),
(109, '2017-04-23 03:44:46', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '4', '', '4'),
(110, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '5', '', 'cartelera4'),
(111, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '5', '', 'conectar0002073381.jpg'),
(112, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '5', '', NULL),
(113, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '5', '', '2017-04-23'),
(114, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '5', '', 'jjcervera'),
(115, '2017-04-23 03:45:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '5', '', '5'),
(116, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '6', '', 'cartelera5'),
(117, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '6', '', 'conectar0004380257.jpg'),
(118, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '6', '', NULL),
(119, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '6', '', '2017-04-23'),
(120, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '6', '', 'jjcervera'),
(121, '2017-04-23 03:45:26', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '6', '', '6'),
(122, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '7', '', 'cartelera6'),
(123, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '7', '', 'conectar111.jpg'),
(124, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '7', '', NULL),
(125, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '7', '', '2017-04-23'),
(126, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '7', '', 'jjcervera'),
(127, '2017-04-23 03:45:47', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '7', '', '7'),
(128, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Detalle', '8', '', 'cartelera8'),
(129, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Archivos', '8', '', 'conectarFileAccessHandler.ashx.jpg'),
(130, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Links', '8', '', NULL),
(131, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Fecha_Actualizacion', '8', '', '2017-04-23'),
(132, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Usuario', '8', '', 'jjcervera'),
(133, '2017-04-23 03:46:08', '/sistema/novedadesadd.php', 'jjcervera', 'A', 'novedades', 'Id_Novedad', '8', '', '8'),
(134, '2017-04-23 03:47:10', '/sistema/novedadesupdate.php', 'jjcervera', '*** Batch update begin ***', 'novedades', '', '', '', ''),
(135, '2017-04-23 03:47:10', '/sistema/novedadesupdate.php', 'jjcervera', 'U', 'novedades', 'Detalle', '8', 'cartelera8', 'cartelera7'),
(136, '2017-04-23 03:47:10', '/sistema/novedadesupdate.php', 'jjcervera', '*** Batch update successful ***', 'novedades', '', '', '', ''),
(137, '2017-04-23 18:57:20', '/sistema/login.php', 'admin', 'login', '90.0.0.197', '', '', '', ''),
(138, '2017-04-23 19:00:22', '/sistema/logout.php', 'Administrator', 'logout', '90.0.0.197', '', '', '', ''),
(139, '2017-04-23 19:00:50', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(140, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(141, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2074150881', '2', '1'),
(142, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2074150881', '2', '1'),
(143, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074150881', '14', '1'),
(144, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', 'AA2074150881', 'NO', 'SI'),
(145, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074150881', NULL, '1'),
(146, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074150881', NULL, 'jjcervera'),
(147, '2017-04-23 19:06:56', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074150881', NULL, '2017-04-23'),
(148, '2017-04-23 19:06:57', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(149, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(150, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '51060735', '1', '2'),
(151, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '51060735', '1', '2'),
(152, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '51060735', '14', '8'),
(153, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '51060735', NULL, '1'),
(154, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51060735', NULL, 'jjcervera'),
(155, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51060735', NULL, '2017-04-23'),
(156, '2017-04-23 19:12:31', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(157, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroSerie', 'SZSE10IS201213970', '', 'SZSE10IS201213970'),
(158, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroMac', 'SZSE10IS201213970', '', NULL),
(159, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'SpecialNumber', 'SZSE10IS201213970', '', NULL),
(160, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ubicacion', 'SZSE10IS201213970', '', '2'),
(161, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Estado', 'SZSE10IS201213970', '', '2'),
(162, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Sit_Estado', 'SZSE10IS201213970', '', '8'),
(163, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Marca', 'SZSE10IS201213970', '', '5'),
(164, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Modelo', 'SZSE10IS201213970', '', '5'),
(165, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ano', 'SZSE10IS201213970', '', '1'),
(166, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Tiene_Cargador', 'SZSE10IS201213970', '', 'SI'),
(167, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Tipo_Equipo', 'SZSE10IS201213970', '', '1'),
(168, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Usuario', 'SZSE10IS201213970', '', 'jjcervera'),
(169, '2017-04-23 19:13:44', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Fecha_Actualizacion', 'SZSE10IS201213970', '', '2017-04-23'),
(170, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(171, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051037443', '1', '2'),
(172, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051037443', '14', '8'),
(173, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051037443', '1', '12'),
(174, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051037443', NULL, '1'),
(175, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051037443', NULL, 'jjcervera'),
(176, '2017-04-23 19:14:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051037443', NULL, '2017-04-23'),
(177, '2017-04-23 19:14:34', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(178, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(179, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051022635', '1', '2'),
(180, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051022635', '14', '8'),
(181, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051022635', NULL, '1'),
(182, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051022635', NULL, 'jjcervera'),
(183, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051022635', NULL, '2017-04-23'),
(184, '2017-04-23 19:16:02', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(185, '2017-04-23 19:16:57', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(186, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051081322', '1', '2'),
(187, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051081322', '14', '8'),
(188, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051081322', NULL, '1'),
(189, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051081322', NULL, 'jjcervera'),
(190, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051081322', NULL, '2017-04-23'),
(191, '2017-04-23 19:16:58', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(192, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(193, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '1', '', 'EN POSADAS'),
(194, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '1', '', '2017-04-23'),
(195, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '1', '', '6051081322'),
(196, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '1', '', '1'),
(197, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(198, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051081322', '1', '12'),
(199, '2017-04-23 19:18:08', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '6051081322', 'NO', 'SI'),
(200, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(201, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051073939', '1', '2'),
(202, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051073939', '14', '8'),
(203, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051073939', NULL, '1'),
(204, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051073939', NULL, 'jjcervera'),
(205, '2017-04-23 19:28:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073939', NULL, '2017-04-23'),
(206, '2017-04-23 19:28:03', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(207, '2017-04-23 19:28:44', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(208, '2017-04-23 19:28:44', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '2', '', 'EN POSADAS'),
(209, '2017-04-23 19:28:44', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '2', '', '2017-04-23'),
(210, '2017-04-23 19:28:44', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '2', '', '8051073939'),
(211, '2017-04-23 19:28:44', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '2', '', '2'),
(212, '2017-04-23 19:28:45', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(213, '2017-04-23 19:28:45', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073939', '1', '12'),
(214, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(215, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '3', '', 'EN POSADAS'),
(216, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '3', '', '2017-04-23'),
(217, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '3', '', '1051071203'),
(218, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '3', '', '3'),
(219, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(220, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051071203', '1', '2'),
(221, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051071203', '1', '2'),
(222, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051071203', '14', '8'),
(223, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051071203', '1', '12'),
(224, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051071203', NULL, '1'),
(225, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051071203', NULL, 'jjcervera'),
(226, '2017-04-23 19:30:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051071203', NULL, '2017-04-23'),
(227, '2017-04-23 19:32:17', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(228, '2017-04-23 19:32:17', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '4', '', 'EN POSADAS'),
(229, '2017-04-23 19:32:17', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '4', '', '2017-04-23'),
(230, '2017-04-23 19:32:17', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '4', '', '8051073352'),
(231, '2017-04-23 19:32:17', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '4', '', '4'),
(232, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(233, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051073352', '1', '2'),
(234, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051073352', '14', '8'),
(235, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073352', '1', '12'),
(236, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '8051073352', 'NO', 'SI'),
(237, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051073352', NULL, '1'),
(238, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051073352', NULL, 'jjcervera'),
(239, '2017-04-23 19:32:18', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073352', NULL, '2017-04-23'),
(240, '2017-04-23 19:33:28', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(241, '2017-04-23 19:33:28', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '5', '', 'EN POSADAS'),
(242, '2017-04-23 19:33:28', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '5', '', '2017-04-23'),
(243, '2017-04-23 19:33:28', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '5', '', '3051021964'),
(244, '2017-04-23 19:33:28', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '5', '', '5'),
(245, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(246, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051021964', '1', '2'),
(247, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051021964', '14', '8'),
(248, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051021964', '1', '12'),
(249, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '3051021964', 'NO', 'SI'),
(250, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051021964', NULL, '1'),
(251, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051021964', NULL, 'jjcervera'),
(252, '2017-04-23 19:33:29', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051021964', NULL, '2017-04-23'),
(253, '2017-04-23 19:35:16', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(254, '2017-04-23 19:35:16', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '6', '', 'EN POSADAS'),
(255, '2017-04-23 19:35:16', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '6', '', '2017-04-23'),
(256, '2017-04-23 19:35:16', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '6', '', '51060735'),
(257, '2017-04-23 19:35:16', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '6', '', '6'),
(258, '2017-04-23 19:35:17', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(259, '2017-04-23 19:35:17', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51060735', '1', '12'),
(260, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(261, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '7', '', 'EN POSADAS'),
(262, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '7', '', '2017-04-23'),
(263, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '7', '', 'SZSE10IS201213970'),
(264, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '7', '', '7'),
(265, '2017-04-23 19:36:31', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(266, '2017-04-23 19:43:43', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(267, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(268, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '8', '', 'EN POSADAS'),
(269, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '8', '', '2017-04-23'),
(270, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '8', '', '7051037443'),
(271, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '8', '', '8'),
(272, '2017-04-23 19:46:22', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(273, '2017-04-23 19:46:51', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '7051037443', 'NO', 'SI'),
(274, '2017-04-23 19:47:57', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(275, '2017-04-23 19:47:57', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '9', '', 'EN POSADAS'),
(276, '2017-04-23 19:47:57', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '9', '', '2017-04-23'),
(277, '2017-04-23 19:47:57', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '9', '', '1051022635'),
(278, '2017-04-23 19:47:57', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '9', '', '9'),
(279, '2017-04-23 19:47:58', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(280, '2017-04-23 19:47:58', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051022635', '1', '12'),
(281, '2017-04-23 19:47:58', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '1051022635', 'NO', 'SI'),
(282, '2017-04-23 19:50:20', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(283, '2017-04-23 19:50:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '10', '', 'EN POSADAS'),
(284, '2017-04-23 19:50:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '10', '', '2017-04-23'),
(285, '2017-04-23 19:50:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '10', '', '7051060043'),
(286, '2017-04-23 19:50:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '10', '', '10'),
(287, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(288, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051060043', '1', '2'),
(289, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051060043', '1', '2'),
(290, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051060043', '1', '12'),
(291, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051060043', NULL, '1'),
(292, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051060043', NULL, 'jjcervera'),
(293, '2017-04-23 19:50:21', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051060043', NULL, '2017-04-23'),
(294, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(295, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '11', '', 'EN POSADAS'),
(296, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '11', '', '2017-04-23'),
(297, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '11', '', '6051059958'),
(298, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '11', '', '11'),
(299, '2017-04-23 19:51:58', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(300, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051059958', '1', '2'),
(301, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051059958', '14', '8'),
(302, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051059958', '1', '12'),
(303, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '6051059958', 'NO', 'SI'),
(304, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051059958', NULL, '1'),
(305, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051059958', NULL, 'jjcervera'),
(306, '2017-04-23 19:51:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051059958', NULL, '2017-04-23'),
(307, '2017-04-23 19:53:26', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '12', 'OTRO', 'MG101A3'),
(308, '2017-04-23 19:54:02', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '5', 'OTRO', 'EXOMATE N201'),
(309, '2017-04-23 19:54:27', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '3', 'OTRO', 'SCHOOLMATE 14 TV'),
(310, '2017-04-23 19:55:29', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '2', 'OTRO', 'SUMA 1025'),
(311, '2017-04-23 19:56:04', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '8', 'OTRO', 'N150P'),
(312, '2017-04-23 19:56:35', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '1', 'OTRO', 'NVTEF10MIX'),
(313, '2017-04-23 19:57:23', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '9', 'OTRO', 'CLASS'),
(314, '2017-04-23 20:07:56', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(315, '2017-04-23 20:07:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051068377', '1', '12'),
(316, '2017-04-23 20:07:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051068377', NULL, 'jjcervera'),
(317, '2017-04-23 20:07:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051068377', NULL, '2017-04-23'),
(318, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051059696', '1', '12'),
(319, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051059696', NULL, 'jjcervera'),
(320, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051059696', NULL, '2017-04-23'),
(321, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051059801', '1', '12'),
(322, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051059801', NULL, 'jjcervera'),
(323, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051059801', NULL, '2017-04-23'),
(324, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051070163', '1', '12'),
(325, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051070163', NULL, 'jjcervera'),
(326, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051070163', NULL, '2017-04-23'),
(327, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051021078', '1', '2'),
(328, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051021078', '1', '12'),
(329, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051021078', NULL, 'jjcervera'),
(330, '2017-04-23 20:07:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051021078', NULL, '2017-04-23'),
(331, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51071627', '1', '12'),
(332, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51071627', NULL, 'jjcervera'),
(333, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51071627', NULL, '2017-04-23'),
(334, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051073336', '1', '12'),
(335, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051073336', NULL, 'jjcervera'),
(336, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051073336', NULL, '2017-04-23'),
(337, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051072342', '1', '12'),
(338, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051072342', NULL, 'jjcervera'),
(339, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051072342', NULL, '2017-04-23'),
(340, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051059685', '1', '12'),
(341, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051059685', NULL, 'jjcervera'),
(342, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051059685', NULL, '2017-04-23'),
(343, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051070489', '1', '12'),
(344, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051070489', NULL, 'jjcervera'),
(345, '2017-04-23 20:07:58', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051070489', NULL, '2017-04-23'),
(346, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051055602', '1', '12'),
(347, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051055602', NULL, 'jjcervera'),
(348, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051055602', NULL, '2017-04-23'),
(349, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073343', '1', '12'),
(350, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051073343', NULL, 'jjcervera'),
(351, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073343', NULL, '2017-04-23'),
(352, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061517', '1', '12'),
(353, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051061517', NULL, 'jjcervera'),
(354, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061517', NULL, '2017-04-23'),
(355, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051068343', '1', '12'),
(356, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051068343', NULL, 'jjcervera'),
(357, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051068343', NULL, '2017-04-23'),
(358, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051021248', '1', '12'),
(359, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051021248', NULL, 'jjcervera'),
(360, '2017-04-23 20:07:59', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051021248', NULL, '2017-04-23'),
(361, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051073291', '1', '12'),
(362, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051073291', NULL, 'jjcervera'),
(363, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051073291', NULL, '2017-04-23'),
(364, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051068259', '1', '12'),
(365, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051068259', NULL, 'jjcervera'),
(366, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051068259', NULL, '2017-04-23'),
(367, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051024077', '1', '12'),
(368, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051024077', NULL, 'jjcervera'),
(369, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051024077', NULL, '2017-04-23'),
(370, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51055879', '1', '12'),
(371, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51055879', NULL, 'jjcervera'),
(372, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51055879', NULL, '2017-04-23'),
(373, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051068255', '1', '12'),
(374, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051068255', NULL, 'jjcervera'),
(375, '2017-04-23 20:08:00', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051068255', NULL, '2017-04-23'),
(376, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051059746', '1', '12'),
(377, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051059746', NULL, 'jjcervera'),
(378, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051059746', NULL, '2017-04-23'),
(379, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051068266', '1', '12'),
(380, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051068266', NULL, 'jjcervera'),
(381, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051068266', NULL, '2017-04-23'),
(382, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051073438', '1', '12'),
(383, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051073438', NULL, 'jjcervera'),
(384, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051073438', NULL, '2017-04-23'),
(385, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051059748', '1', '12'),
(386, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051059748', NULL, 'jjcervera'),
(387, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051059748', NULL, '2017-04-23'),
(388, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051055941', '1', '12'),
(389, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051055941', NULL, 'jjcervera'),
(390, '2017-04-23 20:08:01', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051055941', NULL, '2017-04-23'),
(391, '2017-04-23 20:08:02', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(392, '2017-04-23 20:09:14', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(393, '2017-04-23 20:09:14', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051028947', '1', '12'),
(394, '2017-04-23 20:09:14', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051028947', NULL, 'jjcervera'),
(395, '2017-04-23 20:09:14', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051028947', NULL, '2017-04-23'),
(396, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073179', '1', '12'),
(397, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051073179', NULL, 'jjcervera'),
(398, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073179', NULL, '2017-04-23'),
(399, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051070490', '1', '12'),
(400, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051070490', NULL, 'jjcervera');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(401, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051070490', NULL, '2017-04-23'),
(402, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073070', '1', '12'),
(403, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051073070', NULL, 'jjcervera'),
(404, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073070', NULL, '2017-04-23'),
(405, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051072348', '1', '12'),
(406, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051072348', NULL, 'jjcervera'),
(407, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051072348', NULL, '2017-04-23'),
(408, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051071637', '1', '12'),
(409, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051071637', NULL, 'jjcervera'),
(410, '2017-04-23 20:09:15', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051071637', NULL, '2017-04-23'),
(411, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51037324', '1', '12'),
(412, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51037324', NULL, 'jjcervera'),
(413, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51037324', NULL, '2017-04-23'),
(414, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051068375', '1', '12'),
(415, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051068375', NULL, 'jjcervera'),
(416, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051068375', NULL, '2017-04-23'),
(417, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051059698', '1', '12'),
(418, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051059698', NULL, 'jjcervera'),
(419, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051059698', NULL, '2017-04-23'),
(420, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051021079', '1', '12'),
(421, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051021079', NULL, 'jjcervera'),
(422, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051021079', NULL, '2017-04-23'),
(423, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051055866', '1', '12'),
(424, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051055866', NULL, 'jjcervera'),
(425, '2017-04-23 20:09:16', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051055866', NULL, '2017-04-23'),
(426, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51072963', '1', '12'),
(427, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51072963', NULL, 'jjcervera'),
(428, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51072963', NULL, '2017-04-23'),
(429, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051073069', '1', '12'),
(430, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051073069', NULL, 'jjcervera'),
(431, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051073069', NULL, '2017-04-23'),
(432, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051073324', '1', '12'),
(433, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051073324', NULL, 'jjcervera'),
(434, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051073324', NULL, '2017-04-23'),
(435, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051027686', '1', '12'),
(436, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051027686', NULL, 'jjcervera'),
(437, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051027686', NULL, '2017-04-23'),
(438, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051061267', '1', '12'),
(439, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051061267', NULL, 'jjcervera'),
(440, '2017-04-23 20:09:17', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051061267', NULL, '2017-04-23'),
(441, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051055854', '1', '12'),
(442, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051055854', NULL, 'jjcervera'),
(443, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051055854', NULL, '2017-04-23'),
(444, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051061251', '1', '12'),
(445, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051061251', NULL, 'jjcervera'),
(446, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051061251', NULL, '2017-04-23'),
(447, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051028946', '1', '12'),
(448, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051028946', NULL, 'jjcervera'),
(449, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051028946', NULL, '2017-04-23'),
(450, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051026430', '1', '12'),
(451, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051026430', NULL, 'jjcervera'),
(452, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051026430', NULL, '2017-04-23'),
(453, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051055868', '1', '12'),
(454, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051055868', NULL, 'jjcervera'),
(455, '2017-04-23 20:09:18', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051055868', NULL, '2017-04-23'),
(456, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051059931', '1', '12'),
(457, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051059931', NULL, 'jjcervera'),
(458, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051059931', NULL, '2017-04-23'),
(459, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051073359', '1', '12'),
(460, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051073359', NULL, 'jjcervera'),
(461, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051073359', NULL, '2017-04-23'),
(462, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51068181', '1', '12'),
(463, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51068181', NULL, 'jjcervera'),
(464, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51068181', NULL, '2017-04-23'),
(465, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051028586', '1', '12'),
(466, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051028586', NULL, 'jjcervera'),
(467, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051028586', NULL, '2017-04-23'),
(468, '2017-04-23 20:09:19', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(469, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(470, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073428', '1', '12'),
(471, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051073428', NULL, 'jjcervera'),
(472, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073428', NULL, '2017-04-23'),
(473, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061229', '1', '12'),
(474, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051061229', NULL, 'jjcervera'),
(475, '2017-04-23 20:10:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061229', NULL, '2017-04-23'),
(476, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051061248', '1', '12'),
(477, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051061248', NULL, 'jjcervera'),
(478, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051061248', NULL, '2017-04-23'),
(479, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51061575', '1', '12'),
(480, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51061575', NULL, 'jjcervera'),
(481, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51061575', NULL, '2017-04-23'),
(482, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051055862', '1', '12'),
(483, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051055862', NULL, 'jjcervera'),
(484, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051055862', NULL, '2017-04-23'),
(485, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051058977', '1', '12'),
(486, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051058977', NULL, 'jjcervera'),
(487, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051058977', NULL, '2017-04-23'),
(488, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051020989', '1', '12'),
(489, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051020989', NULL, 'jjcervera'),
(490, '2017-04-23 20:10:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051020989', NULL, '2017-04-23'),
(491, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051060586', '1', '12'),
(492, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051060586', NULL, 'jjcervera'),
(493, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051060586', NULL, '2017-04-23'),
(494, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051027688', '1', '12'),
(495, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051027688', NULL, 'jjcervera'),
(496, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051027688', NULL, '2017-04-23'),
(497, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051026425', '1', '12'),
(498, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051026425', NULL, 'jjcervera'),
(499, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051026425', NULL, '2017-04-23'),
(500, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051056400', '1', '12'),
(501, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051056400', NULL, 'jjcervera'),
(502, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051056400', NULL, '2017-04-23'),
(503, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051061565', '1', '12'),
(504, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051061565', NULL, 'jjcervera'),
(505, '2017-04-23 20:10:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051061565', NULL, '2017-04-23'),
(506, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051060102', '1', '12'),
(507, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051060102', NULL, 'jjcervera'),
(508, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051060102', NULL, '2017-04-23'),
(509, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072405', '1', '12'),
(510, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072405', NULL, 'jjcervera'),
(511, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072405', NULL, '2017-04-23'),
(512, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051059044', '1', '12'),
(513, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051059044', NULL, 'jjcervera'),
(514, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051059044', NULL, '2017-04-23'),
(515, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051056297', '1', '12'),
(516, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051056297', NULL, 'jjcervera'),
(517, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051056297', NULL, '2017-04-23'),
(518, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051061573', '1', '12'),
(519, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051061573', NULL, 'jjcervera'),
(520, '2017-04-23 20:10:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051061573', NULL, '2017-04-23'),
(521, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051060662', '1', '12'),
(522, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051060662', NULL, 'jjcervera'),
(523, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051060662', NULL, '2017-04-23'),
(524, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051081409', '1', '12'),
(525, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051081409', NULL, 'jjcervera'),
(526, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051081409', NULL, '2017-04-23'),
(527, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051056341', '1', '12'),
(528, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051056341', NULL, 'jjcervera'),
(529, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051056341', NULL, '2017-04-23'),
(530, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061261', '1', '12'),
(531, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051061261', NULL, 'jjcervera'),
(532, '2017-04-23 20:10:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061261', NULL, '2017-04-23'),
(533, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051061356', '1', '12'),
(534, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051061356', NULL, 'jjcervera'),
(535, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051061356', NULL, '2017-04-23'),
(536, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051060647', '1', '12'),
(537, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051060647', NULL, 'jjcervera'),
(538, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051060647', NULL, '2017-04-23'),
(539, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073024', '1', '12'),
(540, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051073024', NULL, 'jjcervera'),
(541, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073024', NULL, '2017-04-23'),
(542, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051059959', '1', '12'),
(543, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051059959', NULL, 'jjcervera'),
(544, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051059959', NULL, '2017-04-23'),
(545, '2017-04-23 20:10:33', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(546, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(547, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051060832', '1', '12'),
(548, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051060832', NULL, 'jjcervera'),
(549, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051060832', NULL, '2017-04-23'),
(550, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051073253', '1', '12'),
(551, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051073253', NULL, 'jjcervera'),
(552, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051073253', NULL, '2017-04-23'),
(553, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061352', '1', '12'),
(554, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051061352', NULL, 'jjcervera'),
(555, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061352', NULL, '2017-04-23'),
(556, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051061355', '1', '12'),
(557, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051061355', NULL, 'jjcervera'),
(558, '2017-04-23 20:11:52', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051061355', NULL, '2017-04-23'),
(559, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51073019', '1', '12'),
(560, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51073019', NULL, 'jjcervera'),
(561, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51073019', NULL, '2017-04-23'),
(562, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051059945', '1', '12'),
(563, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051059945', NULL, 'jjcervera'),
(564, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051059945', NULL, '2017-04-23'),
(565, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051060049', '1', '12'),
(566, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051060049', NULL, 'jjcervera'),
(567, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051060049', NULL, '2017-04-23'),
(568, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072993', '1', '12'),
(569, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051072993', NULL, 'jjcervera'),
(570, '2017-04-23 20:11:53', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072993', NULL, '2017-04-23'),
(571, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051071470', '1', '12'),
(572, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051071470', NULL, 'jjcervera'),
(573, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051071470', NULL, '2017-04-23'),
(574, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051072989', '1', '12'),
(575, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051072989', NULL, 'jjcervera'),
(576, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051072989', NULL, '2017-04-23'),
(577, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051061567', '1', '12'),
(578, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051061567', NULL, 'jjcervera'),
(579, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061567', NULL, '2017-04-23'),
(580, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051060253', '1', '12'),
(581, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051060253', NULL, 'jjcervera'),
(582, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051060253', NULL, '2017-04-23'),
(583, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51060255', '1', '12'),
(584, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51060255', NULL, 'jjcervera'),
(585, '2017-04-23 20:11:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51060255', NULL, '2017-04-23'),
(586, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051060888', '1', '12'),
(587, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051060888', NULL, 'jjcervera'),
(588, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051060888', NULL, '2017-04-23'),
(589, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51030134', '1', '12'),
(590, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51030134', NULL, 'jjcervera'),
(591, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51030134', NULL, '2017-04-23'),
(592, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051056146', '1', '12'),
(593, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051056146', NULL, 'jjcervera'),
(594, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051056146', NULL, '2017-04-23'),
(595, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51061348', '1', '12'),
(596, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51061348', NULL, 'jjcervera'),
(597, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51061348', NULL, '2017-04-23'),
(598, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051059196', '1', '12'),
(599, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051059196', NULL, 'jjcervera'),
(600, '2017-04-23 20:11:55', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051059196', NULL, '2017-04-23'),
(601, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51061285', '1', '12'),
(602, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51061285', NULL, 'jjcervera'),
(603, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51061285', NULL, '2017-04-23'),
(604, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072914', '1', '12'),
(605, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072914', NULL, 'jjcervera'),
(606, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072914', NULL, '2017-04-23'),
(607, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51072996', '1', '12'),
(608, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51072996', NULL, 'jjcervera'),
(609, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51072996', NULL, '2017-04-23'),
(610, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051076939', '1', '12'),
(611, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051076939', NULL, 'jjcervera'),
(612, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051076939', NULL, '2017-04-23'),
(613, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051061568', '1', '12'),
(614, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051061568', NULL, 'jjcervera'),
(615, '2017-04-23 20:11:56', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051061568', NULL, '2017-04-23'),
(616, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051061218', '1', '12'),
(617, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051061218', NULL, 'jjcervera'),
(618, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051061218', NULL, '2017-04-23'),
(619, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051072805', '1', '12'),
(620, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051072805', NULL, 'jjcervera'),
(621, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051072805', NULL, '2017-04-23'),
(622, '2017-04-23 20:11:57', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(623, '2017-04-23 20:37:06', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(624, '2017-04-23 20:37:06', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051071100', '1', '12'),
(625, '2017-04-23 20:37:06', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051071100', NULL, 'jjcervera'),
(626, '2017-04-23 20:37:06', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051071100', NULL, '2017-04-23'),
(627, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051061240', '1', '12'),
(628, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051061240', NULL, 'jjcervera'),
(629, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061240', NULL, '2017-04-23'),
(630, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051059957', '1', '12'),
(631, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051059957', NULL, 'jjcervera'),
(632, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051059957', NULL, '2017-04-23'),
(633, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051073016', '1', '12'),
(634, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051073016', NULL, 'jjcervera'),
(635, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051073016', NULL, '2017-04-23'),
(636, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051060044', '1', '12'),
(637, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051060044', NULL, 'jjcervera'),
(638, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051060044', NULL, '2017-04-23'),
(639, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072775', '1', '12'),
(640, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051072775', NULL, 'jjcervera'),
(641, '2017-04-23 20:37:07', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072775', NULL, '2017-04-23'),
(642, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073020', '1', '12'),
(643, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051073020', NULL, 'jjcervera'),
(644, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073020', NULL, '2017-04-23'),
(645, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051061360', '1', '12'),
(646, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051061360', NULL, 'jjcervera'),
(647, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051061360', NULL, '2017-04-23'),
(648, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051060590', '1', '12'),
(649, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051060590', NULL, 'jjcervera'),
(650, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051060590', NULL, '2017-04-23'),
(651, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051061523', '1', '12'),
(652, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051061523', NULL, 'jjcervera'),
(653, '2017-04-23 20:37:08', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061523', NULL, '2017-04-23'),
(654, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051061239', '1', '12'),
(655, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051061239', NULL, 'jjcervera'),
(656, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051061239', NULL, '2017-04-23'),
(657, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051061574', '1', '12'),
(658, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051061574', NULL, 'jjcervera'),
(659, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051061574', NULL, '2017-04-23'),
(660, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51048600', '1', '12'),
(661, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51048600', NULL, 'jjcervera'),
(662, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51048600', NULL, '2017-04-23'),
(663, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051081586', '1', '12'),
(664, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051081586', NULL, 'jjcervera'),
(665, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051081586', NULL, '2017-04-23'),
(666, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051060056', '1', '12'),
(667, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051060056', NULL, 'jjcervera'),
(668, '2017-04-23 20:37:09', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051060056', NULL, '2017-04-23'),
(669, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051055888', '1', '12'),
(670, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051055888', NULL, 'jjcervera'),
(671, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051055888', NULL, '2017-04-23'),
(672, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051060050', '1', '12'),
(673, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051060050', NULL, 'jjcervera'),
(674, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051060050', NULL, '2017-04-23'),
(675, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073002', '1', '12'),
(676, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051073002', NULL, 'jjcervera'),
(677, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073002', NULL, '2017-04-23'),
(678, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051072911', '1', '12'),
(679, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051072911', NULL, 'jjcervera'),
(680, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051072911', NULL, '2017-04-23'),
(681, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072971', '1', '12'),
(682, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051072971', NULL, 'jjcervera'),
(683, '2017-04-23 20:37:10', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072971', NULL, '2017-04-23'),
(684, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051073010', '1', '12'),
(685, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051073010', NULL, 'jjcervera'),
(686, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051073010', NULL, '2017-04-23'),
(687, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072827', '1', '12'),
(688, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051072827', NULL, 'jjcervera'),
(689, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072827', NULL, '2017-04-23'),
(690, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061578', '1', '12'),
(691, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051061578', NULL, 'jjcervera'),
(692, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061578', NULL, '2017-04-23'),
(693, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051060051', '1', '12'),
(694, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051060051', NULL, 'jjcervera'),
(695, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051060051', NULL, '2017-04-23'),
(696, '2017-04-23 20:37:11', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(697, '2017-04-23 20:37:47', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(698, '2017-04-23 20:37:48', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(699, '2017-04-23 20:39:19', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(700, '2017-04-23 20:39:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051056028', '1', '12'),
(701, '2017-04-23 20:39:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051056028', NULL, 'jjcervera'),
(702, '2017-04-23 20:39:19', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051056028', NULL, '2017-04-23'),
(703, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051060101', '1', '12'),
(704, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051060101', NULL, 'jjcervera'),
(705, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051060101', NULL, '2017-04-23'),
(706, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051072930', '1', '12'),
(707, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051072930', NULL, 'jjcervera'),
(708, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051072930', NULL, '2017-04-23'),
(709, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051072920', '1', '12'),
(710, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051072920', NULL, 'jjcervera'),
(711, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051072920', NULL, '2017-04-23'),
(712, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051072254', '1', '12'),
(713, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051072254', NULL, 'jjcervera'),
(714, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051072254', NULL, '2017-04-23'),
(715, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051060799', '1', '12'),
(716, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051060799', NULL, 'jjcervera'),
(717, '2017-04-23 20:39:20', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051060799', NULL, '2017-04-23'),
(718, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51073022', '1', '12'),
(719, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51073022', NULL, 'jjcervera'),
(720, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51073022', NULL, '2017-04-23'),
(721, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051074667', '1', '12'),
(722, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051074667', NULL, 'jjcervera'),
(723, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051074667', NULL, '2017-04-23'),
(724, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051061346', '1', '12'),
(725, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051061346', NULL, 'jjcervera'),
(726, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051061346', NULL, '2017-04-23'),
(727, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061208', '1', '12'),
(728, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051061208', NULL, 'jjcervera'),
(729, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061208', NULL, '2017-04-23'),
(730, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051074505', '1', '12'),
(731, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051074505', NULL, 'jjcervera'),
(732, '2017-04-23 20:39:21', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051074505', NULL, '2017-04-23'),
(733, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051061361', '1', '12'),
(734, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051061361', NULL, 'jjcervera'),
(735, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051061361', NULL, '2017-04-23'),
(736, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51023025', '1', '12'),
(737, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51023025', NULL, 'jjcervera'),
(738, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51023025', NULL, '2017-04-23'),
(739, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061349', '1', '12'),
(740, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051061349', NULL, 'jjcervera'),
(741, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061349', NULL, '2017-04-23'),
(742, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072782', '1', '12'),
(743, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072782', NULL, 'jjcervera'),
(744, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072782', NULL, '2017-04-23'),
(745, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051080856', '1', '12'),
(746, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051080856', NULL, 'jjcervera'),
(747, '2017-04-23 20:39:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051080856', NULL, '2017-04-23'),
(748, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '51073824', '1', '12'),
(749, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '51073824', NULL, 'jjcervera'),
(750, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '51073824', NULL, '2017-04-23'),
(751, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072992', '1', '12'),
(752, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072992', NULL, 'jjcervera'),
(753, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072992', NULL, '2017-04-23'),
(754, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072910', '1', '12'),
(755, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051072910', NULL, 'jjcervera'),
(756, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072910', NULL, '2017-04-23'),
(757, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051081574', '1', '12'),
(758, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051081574', NULL, 'jjcervera'),
(759, '2017-04-23 20:39:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051081574', NULL, '2017-04-23'),
(760, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051073061', '1', '12'),
(761, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051073061', NULL, 'jjcervera'),
(762, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051073061', NULL, '2017-04-23'),
(763, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051073602', '1', '12'),
(764, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051073602', NULL, 'jjcervera'),
(765, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051073602', NULL, '2017-04-23'),
(766, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051072987', '1', '12'),
(767, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051072987', NULL, 'jjcervera'),
(768, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051072987', NULL, '2017-04-23'),
(769, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051081420', '1', '12'),
(770, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051081420', NULL, 'jjcervera'),
(771, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051081420', NULL, '2017-04-23'),
(772, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051081075', '1', '12'),
(773, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051081075', NULL, 'jjcervera'),
(774, '2017-04-23 20:39:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051081075', NULL, '2017-04-23'),
(775, '2017-04-23 20:39:25', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(776, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(777, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '12', '', 'EN POSADAS'),
(778, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '12', '', '2017-04-23'),
(779, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '12', '', '4051027688'),
(780, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '12', '', '12');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(781, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(782, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051027688', '1', '2'),
(783, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051027688', '1', '2'),
(784, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051027688', '14', '8'),
(785, '2017-04-23 20:47:27', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051027688', NULL, '1'),
(786, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroSerie', '68A3C41A1200', '', '68A3C41A1200'),
(787, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroMac', '68A3C41A1200', '', '68A3C41A1200'),
(788, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'SpecialNumber', '68A3C41A1200', '', NULL),
(789, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ubicacion', '68A3C41A1200', '', '2'),
(790, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Estado', '68A3C41A1200', '', '2'),
(791, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Sit_Estado', '68A3C41A1200', '', '8'),
(792, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Marca', '68A3C41A1200', '', '13'),
(793, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Modelo', '68A3C41A1200', '', '12'),
(794, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ano', '68A3C41A1200', '', '2'),
(795, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Tiene_Cargador', '68A3C41A1200', '', 'SI'),
(796, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Tipo_Equipo', '68A3C41A1200', '', '1'),
(797, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Usuario', '68A3C41A1200', '', 'jjcervera'),
(798, '2017-04-23 20:51:27', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Fecha_Actualizacion', '68A3C41A1200', '', '2017-04-23'),
(799, '2017-04-23 20:57:22', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(800, '2017-04-23 20:57:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '13', '', 'EN POSADAS'),
(801, '2017-04-23 20:57:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '13', '', '2017-04-23'),
(802, '2017-04-23 20:57:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '13', '', '8051061551'),
(803, '2017-04-23 20:57:22', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '13', '', '13'),
(804, '2017-04-23 20:57:23', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(805, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(806, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '14', '', 'EN POSADAS'),
(807, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '14', '', '2017-04-23'),
(808, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '14', '', '8051081038'),
(809, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '14', '', '14'),
(810, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(811, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051081038', '14', '8'),
(812, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051081038', '1', '12'),
(813, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '8051081038', 'NO', 'SI'),
(814, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051081038', NULL, '1'),
(815, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051081038', NULL, 'jjcervera'),
(816, '2017-04-23 20:58:37', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051081038', NULL, '2017-04-23'),
(817, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(818, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '15', '', 'EN POSADAS'),
(819, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '15', '', '2017-04-23'),
(820, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '15', '', '5051072862'),
(821, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '15', '', '15'),
(822, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(823, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051072862', '14', '8'),
(824, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072862', '1', '12'),
(825, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '5051072862', 'NO', 'SI'),
(826, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051072862', NULL, '1'),
(827, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072862', NULL, 'jjcervera'),
(828, '2017-04-23 21:00:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072862', NULL, '2017-04-23'),
(829, '2017-04-23 21:01:11', '/sistema/logout.php', 'jjcervera', 'logout', '90.0.0.197', '', '', '', ''),
(830, '2017-04-23 21:03:41', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(831, '2017-04-23 22:40:41', '/sistema/login.php', 'admin', 'login', '127.0.0.1', '', '', '', ''),
(832, '2017-04-23 23:00:23', '/sistema/login.php', 'admin', 'login', '127.0.0.1', '', '', '', ''),
(833, '2017-04-23 23:04:48', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(834, '2017-04-23 23:40:33', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(835, '2017-04-24 00:52:12', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(836, '2017-04-24 01:15:25', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '21', '', 'NVTEF10MIX'),
(837, '2017-04-24 01:15:25', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '21', '', '1'),
(838, '2017-04-24 01:15:25', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '21', '', '21'),
(839, '2017-04-24 01:15:40', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '1', 'NVTEF10MIX', 'OTRO'),
(840, '2017-04-24 01:15:56', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '22', '', 'SUMA 1025'),
(841, '2017-04-24 01:15:56', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '22', '', '2'),
(842, '2017-04-24 01:15:56', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '22', '', '22'),
(843, '2017-04-24 01:16:09', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '2', 'SUMA 1025', 'OTRO'),
(844, '2017-04-24 01:16:29', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '23', '', 'SCHOOLMATE 14 TV'),
(845, '2017-04-24 01:16:29', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '23', '', '3'),
(846, '2017-04-24 01:16:29', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '23', '', '23'),
(847, '2017-04-24 01:16:41', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '3', 'SCHOOLMATE 14 TV', 'OTRO'),
(848, '2017-04-24 01:16:57', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '5', 'EXOMATE N201', 'OTRO'),
(849, '2017-04-24 01:17:08', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '24', '', 'EXOMATE N201'),
(850, '2017-04-24 01:17:08', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '24', '', '5'),
(851, '2017-04-24 01:17:08', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '24', '', '24'),
(852, '2017-04-24 01:17:21', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '8', 'N150P', 'OTRO'),
(853, '2017-04-24 01:17:31', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '25', '', 'N150P'),
(854, '2017-04-24 01:17:31', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '25', '', '9'),
(855, '2017-04-24 01:17:31', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '25', '', '25'),
(856, '2017-04-24 01:17:47', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '12', 'MG101A3', 'OTRO'),
(857, '2017-04-24 01:17:58', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '26', '', 'MG101A3'),
(858, '2017-04-24 01:17:58', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '26', '', '13'),
(859, '2017-04-24 01:17:58', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '26', '', '26'),
(860, '2017-04-24 01:18:43', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'SZSE10IS201213970', '2017-04-23', '2017-04-24'),
(861, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(862, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '16', '', 'EN POSADAS'),
(863, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '16', '', '2017-04-24'),
(864, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '16', '', 'AA0163012125'),
(865, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '16', '', '16'),
(866, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(867, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'NroMac', 'AA0163012125', '6C71D94DB825', '6C71D94DB825'),
(868, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163012125', '1', '2'),
(869, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0163012125', '1', '2'),
(870, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163012125', '14', '8'),
(871, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163012125', '1', '24'),
(872, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163012125', NULL, '1'),
(873, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163012125', NULL, 'jjcervera'),
(874, '2017-04-24 01:19:39', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163012125', NULL, '2017-04-24'),
(875, '2017-04-24 01:21:58', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(876, '2017-04-24 01:21:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '17', '', 'EN POSADAS'),
(877, '2017-04-24 01:21:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '17', '', '2017-04-24'),
(878, '2017-04-24 01:21:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '17', '', 'AA2163022753'),
(879, '2017-04-24 01:21:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '17', '', '17'),
(880, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(881, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2163022753', '1', '2'),
(882, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2163022753', '1', '2'),
(883, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2163022753', '14', '8'),
(884, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA2163022753', '1', '24'),
(885, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2163022753', NULL, '1'),
(886, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2163022753', NULL, 'jjcervera'),
(887, '2017-04-24 01:21:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2163022753', NULL, '2017-04-24'),
(888, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(889, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '18', '', 'EN POSADAS'),
(890, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '18', '', '2017-04-24'),
(891, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '18', '', 'AA5163012222'),
(892, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '18', '', '18'),
(893, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(894, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA5163012222', '1', '2'),
(895, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA5163012222', '1', '2'),
(896, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5163012222', '14', '8'),
(897, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA5163012222', '1', '24'),
(898, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5163012222', NULL, '1'),
(899, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5163012222', NULL, 'jjcervera'),
(900, '2017-04-24 01:23:20', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5163012222', NULL, '2017-04-24'),
(901, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(902, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '19', '', 'EN POSADAS'),
(903, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '19', '', '2017-04-24'),
(904, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '19', '', '7051068355'),
(905, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '19', '', '19'),
(906, '2017-04-24 01:25:30', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(907, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051068355', '14', '8'),
(908, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051068355', '1', '26'),
(909, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '7051068355', 'NO', 'SI'),
(910, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051068355', NULL, '1'),
(911, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051068355', NULL, 'jjcervera'),
(912, '2017-04-24 01:25:31', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051068355', NULL, '2017-04-24'),
(913, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(914, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '20', '', 'EN POSADAS'),
(915, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '20', '', '2017-04-24'),
(916, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '20', '', 'AA0163010852'),
(917, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '20', '', '20'),
(918, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(919, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163010852', '1', '2'),
(920, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0163010852', '1', '2'),
(921, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163010852', '14', '8'),
(922, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163010852', '1', '24'),
(923, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163010852', NULL, '1'),
(924, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163010852', NULL, 'jjcervera'),
(925, '2017-04-24 01:26:12', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163010852', NULL, '2017-04-24'),
(926, '2017-04-24 01:26:58', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(927, '2017-04-24 01:26:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '21', '', 'EN POSADAS'),
(928, '2017-04-24 01:26:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '21', '', '2017-04-24'),
(929, '2017-04-24 01:26:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '21', '', 'AA0163011713'),
(930, '2017-04-24 01:26:58', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '21', '', '21'),
(931, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(932, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163011713', '1', '2'),
(933, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0163011713', '1', '2'),
(934, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163011713', '14', '8'),
(935, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163011713', '1', '24'),
(936, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163011713', NULL, '1'),
(937, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163011713', NULL, 'jjcervera'),
(938, '2017-04-24 01:26:59', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163011713', NULL, '2017-04-24'),
(939, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(940, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '22', '', 'EN POSADAS'),
(941, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '22', '', '2017-04-24'),
(942, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '22', '', 'AA1163016630'),
(943, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '22', '', '22'),
(944, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(945, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163016630', '1', '2'),
(946, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163016630', '1', '2'),
(947, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163016630', '14', '8'),
(948, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163016630', '1', '24'),
(949, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163016630', NULL, '1'),
(950, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163016630', NULL, 'jjcervera'),
(951, '2017-04-24 01:29:41', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163016630', NULL, '2017-04-24'),
(952, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(953, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051021079', '1', '2'),
(954, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051021079', '1', '2'),
(955, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051021079', '14', '8'),
(956, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051021079', '12', '26'),
(957, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051021079', NULL, '1'),
(958, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051021079', '2017-04-23', '2017-04-24'),
(959, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051055854', '1', '2'),
(960, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051055854', '1', '2'),
(961, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051055854', '14', '8'),
(962, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051055854', '12', '26'),
(963, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051055854', NULL, '1'),
(964, '2017-04-24 01:37:22', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051055854', '2017-04-23', '2017-04-24'),
(965, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051058977', '1', '2'),
(966, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051058977', '1', '2'),
(967, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051058977', '14', '8'),
(968, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051058977', '12', '26'),
(969, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051058977', NULL, '1'),
(970, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051058977', '2017-04-23', '2017-04-24'),
(971, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051061261', '1', '2'),
(972, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '8051061261', '1', '2'),
(973, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051061261', '14', '8'),
(974, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061261', '12', '26'),
(975, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051061261', NULL, '1'),
(976, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061261', '2017-04-23', '2017-04-24'),
(977, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051059959', '1', '2'),
(978, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051059959', '1', '2'),
(979, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051059959', '14', '9'),
(980, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051059959', '12', '26'),
(981, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051059959', NULL, '1'),
(982, '2017-04-24 01:37:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051059959', '2017-04-23', '2017-04-24'),
(983, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051060253', '1', '2'),
(984, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051060253', '1', '2'),
(985, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051060253', '14', '8'),
(986, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051060253', '12', '26'),
(987, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051060253', NULL, '1'),
(988, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051060253', '2017-04-23', '2017-04-24'),
(989, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051060888', '1', '2'),
(990, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '8051060888', '1', '2'),
(991, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051060888', '14', '8'),
(992, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051060888', '12', '26'),
(993, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051060888', NULL, '1'),
(994, '2017-04-24 01:37:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051060888', '2017-04-23', '2017-04-24'),
(995, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051055888', '1', '2'),
(996, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051055888', '1', '2'),
(997, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051055888', '14', '8'),
(998, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051055888', '12', '26'),
(999, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051055888', NULL, '1'),
(1000, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051055888', '2017-04-23', '2017-04-24'),
(1001, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051073061', '1', '2'),
(1002, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051073061', '1', '2'),
(1003, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051073061', '14', '8'),
(1004, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051073061', '12', '26'),
(1005, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051073061', NULL, '1'),
(1006, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051073061', '2017-04-23', '2017-04-24'),
(1007, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051038489', '1', '2'),
(1008, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051038489', '1', '2'),
(1009, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051038489', '14', '8'),
(1010, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051038489', '1', '26'),
(1011, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051038489', NULL, '1'),
(1012, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051038489', NULL, 'jjcervera'),
(1013, '2017-04-24 01:37:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051038489', NULL, '2017-04-24'),
(1014, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163018829', '1', '2'),
(1015, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163018829', '1', '2'),
(1016, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163018829', '14', '8'),
(1017, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163018829', '1', '24'),
(1018, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163018829', NULL, '1'),
(1019, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163018829', NULL, 'jjcervera'),
(1020, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163018829', NULL, '2017-04-24'),
(1021, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163020456', '1', '2'),
(1022, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163020456', '1', '2'),
(1023, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163020456', '14', '8'),
(1024, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163020456', '1', '24'),
(1025, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163020456', NULL, '1'),
(1026, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163020456', NULL, 'jjcervera'),
(1027, '2017-04-24 01:37:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163020456', NULL, '2017-04-24'),
(1028, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163040926', '1', '2'),
(1029, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163040926', '1', '2'),
(1030, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163040926', '14', '8'),
(1031, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163040926', '1', '24'),
(1032, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163040926', NULL, '1'),
(1033, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163040926', NULL, 'jjcervera'),
(1034, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163040926', NULL, '2017-04-24'),
(1035, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163011604', '1', '2'),
(1036, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4163011604', '1', '2'),
(1037, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163011604', '14', '8'),
(1038, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4163011604', '1', '24'),
(1039, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163011604', NULL, '1'),
(1040, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163011604', NULL, 'jjcervera'),
(1041, '2017-04-24 01:37:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163011604', NULL, '2017-04-24'),
(1042, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163017439', '1', '2'),
(1043, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4163017439', '1', '2'),
(1044, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163017439', '14', '8'),
(1045, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4163017439', '1', '24'),
(1046, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163017439', NULL, '1'),
(1047, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163017439', NULL, 'jjcervera'),
(1048, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163017439', NULL, '2017-04-24'),
(1049, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163019355', '1', '2'),
(1050, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4163019355', '1', '2'),
(1051, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163019355', '14', '8'),
(1052, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4163019355', '1', '24'),
(1053, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163019355', NULL, '1'),
(1054, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163019355', NULL, 'jjcervera'),
(1055, '2017-04-24 01:37:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163019355', NULL, '2017-04-24'),
(1056, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA7163012741', '1', '2'),
(1057, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA7163012741', '1', '2'),
(1058, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA7163012741', '14', '8'),
(1059, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA7163012741', '1', '24'),
(1060, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA7163012741', NULL, '1'),
(1061, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA7163012741', NULL, 'jjcervera'),
(1062, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA7163012741', NULL, '2017-04-24'),
(1063, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9163012414', '1', '2'),
(1064, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9163012414', '1', '2'),
(1065, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9163012414', '14', '8'),
(1066, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9163012414', '1', '24'),
(1067, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9163012414', NULL, '1'),
(1068, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9163012414', NULL, 'jjcervera'),
(1069, '2017-04-24 01:37:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9163012414', NULL, '2017-04-24'),
(1070, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9163012734', '1', '2'),
(1071, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9163012734', '1', '2'),
(1072, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9163012734', '14', '8'),
(1073, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9163012734', '1', '24'),
(1074, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9163012734', NULL, '1'),
(1075, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9163012734', NULL, 'jjcervera'),
(1076, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9163012734', NULL, '2017-04-24'),
(1077, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9163044903', '1', '2'),
(1078, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9163044903', '1', '2'),
(1079, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9163044903', '14', '8'),
(1080, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9163044903', '1', '24'),
(1081, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9163044903', NULL, '1'),
(1082, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9163044903', NULL, 'jjcervera'),
(1083, '2017-04-24 01:37:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9163044903', NULL, '2017-04-24'),
(1084, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0313676838', '1', '2'),
(1085, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0313676838', '1', '2'),
(1086, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0313676838', '14', '8'),
(1087, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0313676838', '1', '23'),
(1088, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0313676838', NULL, '1'),
(1089, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0313676838', NULL, 'jjcervera'),
(1090, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0313676838', NULL, '2017-04-24'),
(1091, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0313683469', '1', '2'),
(1092, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0313683469', '1', '2'),
(1093, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0313683469', '14', '8'),
(1094, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0313683469', '1', '26'),
(1095, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0313683469', NULL, '1'),
(1096, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0313683469', NULL, 'jjcervera'),
(1097, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0313683469', NULL, '2017-04-24'),
(1098, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3313679185', '1', '2'),
(1099, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3313679185', '1', '2'),
(1100, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3313679185', '14', '8'),
(1101, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA3313679185', '1', '23'),
(1102, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3313679185', NULL, '1'),
(1103, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3313679185', NULL, 'jjcervera'),
(1104, '2017-04-24 01:37:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3313679185', NULL, '2017-04-24'),
(1105, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3313687071', '1', '2'),
(1106, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3313687071', '1', '2'),
(1107, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3313687071', '14', '8'),
(1108, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA3313687071', '1', '26'),
(1109, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3313687071', NULL, '1'),
(1110, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3313687071', NULL, 'jjcervera'),
(1111, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3313687071', NULL, '2017-04-24'),
(1112, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4313675842', '1', '2'),
(1113, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4313675842', '1', '2'),
(1114, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4313675842', '14', '8'),
(1115, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4313675842', '1', '26'),
(1116, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4313675842', NULL, '1'),
(1117, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4313675842', NULL, 'jjcervera'),
(1118, '2017-04-24 01:37:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4313675842', NULL, '2017-04-24'),
(1119, '2017-04-24 01:37:33', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1120, '2017-04-24 01:38:18', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(1121, '2017-04-24 01:38:19', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '23', '', 'EN POSADAS'),
(1122, '2017-04-24 01:38:19', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '23', '', '2017-04-24'),
(1123, '2017-04-24 01:38:19', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '23', '', '7051021079'),
(1124, '2017-04-24 01:38:19', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '23', '', '23'),
(1125, '2017-04-24 01:38:19', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(1126, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1127, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051068375', '1', '2'),
(1128, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051068375', '1', '2'),
(1129, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051068375', '14', '7'),
(1130, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051068375', '12', '26'),
(1131, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051068375', NULL, '1'),
(1132, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051068375', '2017-04-23', '2017-04-24'),
(1133, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051072989', '1', '2'),
(1134, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051072989', '1', '2'),
(1135, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051072989', '14', '7'),
(1136, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051072989', '12', '26'),
(1137, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051072989', NULL, '1'),
(1138, '2017-04-24 01:50:35', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051072989', '2017-04-23', '2017-04-24'),
(1139, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051061523', '1', '2'),
(1140, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051061523', '14', '7'),
(1141, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051061523', '12', '26'),
(1142, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051061523', NULL, '1'),
(1143, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061523', '2017-04-23', '2017-04-24'),
(1144, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051056028', '1', '2'),
(1145, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051056028', '14', '7'),
(1146, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051056028', '12', '26'),
(1147, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051056028', NULL, '1'),
(1148, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051056028', '2017-04-23', '2017-04-24'),
(1149, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051081075', '1', '2'),
(1150, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '9051081075', '1', '2'),
(1151, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051081075', '14', '7'),
(1152, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051081075', '12', '26'),
(1153, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051081075', NULL, '1'),
(1154, '2017-04-24 01:50:36', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051081075', '2017-04-23', '2017-04-24'),
(1155, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051023032', '1', '2'),
(1156, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051023032', '1', '2'),
(1157, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051023032', '14', '7'),
(1158, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051023032', '1', '26'),
(1159, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051023032', NULL, '1'),
(1160, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051023032', NULL, 'jjcervera'),
(1161, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051023032', NULL, '2017-04-24'),
(1162, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051080796', '1', '2'),
(1163, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051080796', '1', '2'),
(1164, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051080796', '14', '7');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1165, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051080796', '1', '26'),
(1166, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051080796', NULL, '1'),
(1167, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051080796', NULL, 'jjcervera'),
(1168, '2017-04-24 01:50:37', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051080796', NULL, '2017-04-24'),
(1169, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051023272', '1', '2'),
(1170, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051023272', '1', '2'),
(1171, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051023272', '14', '7'),
(1172, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051023272', '1', '26'),
(1173, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051023272', NULL, '1'),
(1174, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051023272', NULL, 'jjcervera'),
(1175, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051023272', NULL, '2017-04-24'),
(1176, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051023981', '1', '2'),
(1177, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051023981', '14', '7'),
(1178, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051023981', '1', '26'),
(1179, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051023981', NULL, '1'),
(1180, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051023981', NULL, 'jjcervera'),
(1181, '2017-04-24 01:50:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051023981', NULL, '2017-04-24'),
(1182, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051030467', '1', '2'),
(1183, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051030467', '1', '2'),
(1184, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051030467', '14', '7'),
(1185, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051030467', '1', '26'),
(1186, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051030467', NULL, '1'),
(1187, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051030467', NULL, 'jjcervera'),
(1188, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051030467', NULL, '2017-04-24'),
(1189, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051079534', '1', '2'),
(1190, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051079534', '1', '2'),
(1191, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051079534', '14', '7'),
(1192, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051079534', '1', '26'),
(1193, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051079534', NULL, '1'),
(1194, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051079534', NULL, 'jjcervera'),
(1195, '2017-04-24 01:50:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051079534', NULL, '2017-04-24'),
(1196, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051079660', '1', '2'),
(1197, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051079660', '1', '2'),
(1198, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051079660', '14', '7'),
(1199, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051079660', '1', '26'),
(1200, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051079660', NULL, '1'),
(1201, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051079660', NULL, 'jjcervera'),
(1202, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051079660', NULL, '2017-04-24'),
(1203, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163016512', '1', '2'),
(1204, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0163016512', '1', '2'),
(1205, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163016512', '14', '7'),
(1206, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163016512', '1', '24'),
(1207, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163016512', NULL, '1'),
(1208, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163016512', NULL, 'jjcervera'),
(1209, '2017-04-24 01:50:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163016512', NULL, '2017-04-24'),
(1210, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163016842', '1', '2'),
(1211, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163016842', '1', '2'),
(1212, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163016842', '14', '7'),
(1213, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163016842', '1', '24'),
(1214, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163016842', NULL, '1'),
(1215, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163016842', NULL, 'jjcervera'),
(1216, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163016842', NULL, '2017-04-24'),
(1217, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163020291', '1', '2'),
(1218, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1163020291', '1', '2'),
(1219, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163020291', '14', '7'),
(1220, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163020291', '1', '24'),
(1221, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163020291', NULL, '1'),
(1222, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163020291', NULL, 'jjcervera'),
(1223, '2017-04-24 01:50:41', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163020291', NULL, '2017-04-24'),
(1224, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163015168', '1', '2'),
(1225, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4163015168', '1', '2'),
(1226, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163015168', '14', '7'),
(1227, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4163015168', '1', '24'),
(1228, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163015168', NULL, '1'),
(1229, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163015168', NULL, 'jjcervera'),
(1230, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163015168', NULL, '2017-04-24'),
(1231, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA7163012176', '1', '2'),
(1232, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA7163012176', '1', '2'),
(1233, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA7163012176', '14', '7'),
(1234, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA7163012176', '1', '24'),
(1235, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA7163012176', NULL, '1'),
(1236, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA7163012176', NULL, 'jjcervera'),
(1237, '2017-04-24 01:50:42', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA7163012176', NULL, '2017-04-24'),
(1238, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA7163038083', '1', '2'),
(1239, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA7163038083', '1', '2'),
(1240, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA7163038083', '14', '7'),
(1241, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA7163038083', '1', '24'),
(1242, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA7163038083', NULL, '1'),
(1243, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA7163038083', NULL, 'jjcervera'),
(1244, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA7163038083', NULL, '2017-04-24'),
(1245, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1313678895', '1', '2'),
(1246, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1313678895', '1', '2'),
(1247, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1313678895', '14', '7'),
(1248, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1313678895', '1', '23'),
(1249, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1313678895', NULL, '1'),
(1250, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1313678895', NULL, 'jjcervera'),
(1251, '2017-04-24 01:50:43', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1313678895', NULL, '2017-04-24'),
(1252, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA5313679857', '1', '2'),
(1253, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA5313679857', '1', '2'),
(1254, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5313679857', '14', '7'),
(1255, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA5313679857', '1', '23'),
(1256, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5313679857', NULL, '1'),
(1257, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5313679857', NULL, 'jjcervera'),
(1258, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5313679857', NULL, '2017-04-24'),
(1259, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA6313676957', '1', '2'),
(1260, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA6313676957', '1', '2'),
(1261, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA6313676957', '14', '7'),
(1262, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA6313676957', '1', '23'),
(1263, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA6313676957', NULL, '1'),
(1264, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA6313676957', NULL, 'jjcervera'),
(1265, '2017-04-24 01:50:44', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA6313676957', NULL, '2017-04-24'),
(1266, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA7313670064', '1', '2'),
(1267, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA7313670064', '1', '2'),
(1268, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA7313670064', '14', '7'),
(1269, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA7313670064', '1', '23'),
(1270, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA7313670064', NULL, '1'),
(1271, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA7313670064', NULL, 'jjcervera'),
(1272, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA7313670064', NULL, '2017-04-24'),
(1273, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9313675440', '1', '2'),
(1274, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9313675440', '1', '2'),
(1275, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9313675440', '14', '7'),
(1276, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9313675440', '1', '23'),
(1277, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9313675440', NULL, '1'),
(1278, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9313675440', NULL, 'jjcervera'),
(1279, '2017-04-24 01:50:45', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9313675440', NULL, '2017-04-24'),
(1280, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3074154561', '1', '2'),
(1281, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3074154561', '1', '2'),
(1282, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3074154561', '14', '7'),
(1283, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA3074154561', '1', '22'),
(1284, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3074154561', NULL, '1'),
(1285, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3074154561', NULL, 'jjcervera'),
(1286, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3074154561', NULL, '2017-04-24'),
(1287, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4074071077', '1', '2'),
(1288, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074071077', '1', '2'),
(1289, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074071077', '14', '7'),
(1290, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4074071077', '1', '22'),
(1291, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074071077', NULL, '1'),
(1292, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074071077', NULL, 'jjcervera'),
(1293, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074071077', NULL, '2017-04-24'),
(1294, '2017-04-24 01:50:46', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1295, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1296, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051070163', '1', '2'),
(1297, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051070163', '1', '2'),
(1298, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051070163', '14', '11'),
(1299, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051070163', '12', '26'),
(1300, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051070163', NULL, '1'),
(1301, '2017-04-24 01:55:23', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051070163', '2017-04-23', '2017-04-24'),
(1302, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051055868', '1', '2'),
(1303, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051055868', '14', '11'),
(1304, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051055868', '12', '26'),
(1305, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051055868', NULL, '1'),
(1306, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051055868', '2017-04-23', '2017-04-24'),
(1307, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051073359', '1', '2'),
(1308, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051073359', '1', '2'),
(1309, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051073359', '14', '11'),
(1310, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051073359', '12', '26'),
(1311, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051073359', NULL, '1'),
(1312, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051073359', '2017-04-23', '2017-04-24'),
(1313, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051056400', '1', '2'),
(1314, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051056400', '1', '2'),
(1315, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051056400', '14', '11'),
(1316, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051056400', '12', '26'),
(1317, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051056400', NULL, '1'),
(1318, '2017-04-24 01:55:24', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051056400', '2017-04-23', '2017-04-24'),
(1319, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051059044', '1', '2'),
(1320, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051059044', '1', '2'),
(1321, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051059044', '14', '11'),
(1322, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051059044', '12', '26'),
(1323, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051059044', NULL, '1'),
(1324, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051059044', '2017-04-23', '2017-04-24'),
(1325, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051056297', '1', '2'),
(1326, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '8051056297', '1', '2'),
(1327, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051056297', '14', '11'),
(1328, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051056297', '12', '26'),
(1329, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051056297', NULL, '1'),
(1330, '2017-04-24 01:55:25', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051056297', '2017-04-23', '2017-04-24'),
(1331, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051061573', '1', '2'),
(1332, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051061573', '14', '11'),
(1333, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051061573', '12', '26'),
(1334, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051061573', NULL, '1'),
(1335, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051061573', '2017-04-23', '2017-04-24'),
(1336, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051061356', '1', '2'),
(1337, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '9051061356', '1', '2'),
(1338, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051061356', '14', '11'),
(1339, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051061356', '12', '26'),
(1340, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051061356', NULL, '1'),
(1341, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051061356', '2017-04-23', '2017-04-24'),
(1342, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051073024', '1', '2'),
(1343, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051073024', '14', '11'),
(1344, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073024', '12', '26'),
(1345, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051073024', NULL, '1'),
(1346, '2017-04-24 01:55:26', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073024', '2017-04-23', '2017-04-24'),
(1347, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051061352', '1', '2'),
(1348, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051061352', '14', '11'),
(1349, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061352', '12', '26'),
(1350, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051061352', NULL, '1'),
(1351, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061352', '2017-04-23', '2017-04-24'),
(1352, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051061355', '1', '2'),
(1353, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051061355', '1', '2'),
(1354, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051061355', '14', '11'),
(1355, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051061355', '12', '26'),
(1356, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051061355', NULL, '1'),
(1357, '2017-04-24 01:55:27', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051061355', '2017-04-23', '2017-04-24'),
(1358, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051072993', '1', '2'),
(1359, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '9051072993', '1', '2'),
(1360, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051072993', '14', '11'),
(1361, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072993', '12', '26'),
(1362, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051072993', NULL, '1'),
(1363, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072993', '2017-04-23', '2017-04-24'),
(1364, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051056146', '1', '2'),
(1365, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051056146', '14', '11'),
(1366, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051056146', '12', '26'),
(1367, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051056146', NULL, '1'),
(1368, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051056146', '2017-04-23', '2017-04-24'),
(1369, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051072805', '1', '2'),
(1370, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051072805', '1', '2'),
(1371, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051072805', '14', '11'),
(1372, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051072805', '12', '26'),
(1373, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051072805', NULL, '1'),
(1374, '2017-04-24 01:55:28', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051072805', '2017-04-23', '2017-04-24'),
(1375, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051061240', '1', '2'),
(1376, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051061240', '1', '2'),
(1377, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051061240', '14', '11'),
(1378, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051061240', '12', '26'),
(1379, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051061240', NULL, '1'),
(1380, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061240', '2017-04-23', '2017-04-24'),
(1381, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051061574', '1', '2'),
(1382, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051061574', '14', '11'),
(1383, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051061574', '12', '26'),
(1384, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051061574', NULL, '1'),
(1385, '2017-04-24 01:55:29', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051061574', '2017-04-23', '2017-04-24'),
(1386, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051060050', '1', '2'),
(1387, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051060050', '14', '11'),
(1388, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051060050', '12', '26'),
(1389, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051060050', NULL, '1'),
(1390, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051060050', '2017-04-23', '2017-04-24'),
(1391, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051073002', '1', '2'),
(1392, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051073002', '14', '11'),
(1393, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051073002', '12', '26'),
(1394, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051073002', NULL, '1'),
(1395, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051073002', '2017-04-23', '2017-04-24'),
(1396, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051073010', '1', '2'),
(1397, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051073010', '14', '11'),
(1398, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051073010', '12', '26'),
(1399, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051073010', NULL, '1'),
(1400, '2017-04-24 01:55:30', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051073010', '2017-04-23', '2017-04-24'),
(1401, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051072827', '1', '2'),
(1402, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051072827', '14', '11'),
(1403, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072827', '12', '26'),
(1404, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051072827', NULL, '1'),
(1405, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072827', '2017-04-23', '2017-04-24'),
(1406, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051061578', '1', '2'),
(1407, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051061578', '1', '2'),
(1408, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051061578', '14', '11'),
(1409, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061578', '12', '26'),
(1410, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051061578', NULL, '1'),
(1411, '2017-04-24 01:55:31', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061578', '2017-04-23', '2017-04-24'),
(1412, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051060051', '1', '2'),
(1413, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '9051060051', '1', '2'),
(1414, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051060051', '14', '11'),
(1415, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051060051', '12', '26'),
(1416, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051060051', NULL, '1'),
(1417, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051060051', '2017-04-23', '2017-04-24'),
(1418, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051072930', '1', '2'),
(1419, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051072930', '14', '11'),
(1420, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051072930', '12', '26'),
(1421, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051072930', NULL, '1'),
(1422, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051072930', '2017-04-23', '2017-04-24'),
(1423, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051061346', '1', '2'),
(1424, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051061346', '1', '2'),
(1425, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051061346', '14', '11'),
(1426, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051061346', NULL, '1'),
(1427, '2017-04-24 01:55:32', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051061346', '2017-04-23', '2017-04-24'),
(1428, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051061349', '1', '2'),
(1429, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051061349', '14', '11'),
(1430, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051061349', '12', '26'),
(1431, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051061349', NULL, '1'),
(1432, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061349', '2017-04-23', '2017-04-24'),
(1433, '2017-04-24 01:55:33', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1434, '2017-04-24 02:03:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051070489', '1', '2'),
(1435, '2017-04-24 02:03:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051070489', '14', '2'),
(1436, '2017-04-24 02:03:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051070489', NULL, '1'),
(1437, '2017-04-24 02:03:54', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051070489', '2017-04-23', '2017-04-24'),
(1438, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1439, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051073179', '1', '2'),
(1440, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051073179', '14', '2'),
(1441, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051073179', NULL, '1'),
(1442, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051073179', '2017-04-23', '2017-04-24'),
(1443, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051055862', '1', '2'),
(1444, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051055862', '14', '2'),
(1445, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051055862', NULL, '1'),
(1446, '2017-04-24 02:05:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051055862', '2017-04-23', '2017-04-24'),
(1447, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051060102', '1', '2'),
(1448, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051060102', '14', '2'),
(1449, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051060102', NULL, '1'),
(1450, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051060102', '2017-04-23', '2017-04-24'),
(1451, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051060799', '1', '2'),
(1452, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051060799', '14', '2'),
(1453, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051060799', NULL, '1'),
(1454, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051060799', '2017-04-23', '2017-04-24'),
(1455, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051080866', '1', '2'),
(1456, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051080866', '14', '2'),
(1457, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051080866', NULL, '1'),
(1458, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051080866', NULL, 'jjcervera'),
(1459, '2017-04-24 02:05:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051080866', NULL, '2017-04-24'),
(1460, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051081677', '1', '2'),
(1461, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051081677', '14', '2'),
(1462, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051081677', NULL, '1'),
(1463, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051081677', NULL, 'jjcervera'),
(1464, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051081677', NULL, '2017-04-24'),
(1465, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051031936', '1', '2'),
(1466, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051031936', '14', '2'),
(1467, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051031936', NULL, '1'),
(1468, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051031936', NULL, 'jjcervera'),
(1469, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051031936', NULL, '2017-04-24'),
(1470, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051059955', '1', '2'),
(1471, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051059955', '14', '2'),
(1472, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051059955', NULL, '1'),
(1473, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051059955', NULL, 'jjcervera'),
(1474, '2017-04-24 02:05:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051059955', NULL, '2017-04-24'),
(1475, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051037372', '1', '2'),
(1476, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051037372', '14', '2'),
(1477, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051037372', NULL, '1'),
(1478, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051037372', NULL, 'jjcervera'),
(1479, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051037372', NULL, '2017-04-24'),
(1480, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051023607', '1', '2'),
(1481, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051023607', '14', '2'),
(1482, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051023607', NULL, '1'),
(1483, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051023607', NULL, 'jjcervera'),
(1484, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051023607', NULL, '2017-04-24'),
(1485, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051068341', '1', '2'),
(1486, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051068341', '14', '2'),
(1487, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051068341', NULL, '1'),
(1488, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051068341', NULL, 'jjcervera'),
(1489, '2017-04-24 02:05:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051068341', NULL, '2017-04-24'),
(1490, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051058939', '1', '2'),
(1491, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051058939', '14', '2'),
(1492, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051058939', NULL, '1'),
(1493, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051058939', NULL, 'jjcervera'),
(1494, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051058939', NULL, '2017-04-24'),
(1495, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163016576', '1', '2'),
(1496, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163016576', '14', '2'),
(1497, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163016576', NULL, '1'),
(1498, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163016576', NULL, 'jjcervera'),
(1499, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163016576', NULL, '2017-04-24'),
(1500, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163020080', '1', '2'),
(1501, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163020080', '14', '2'),
(1502, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163020080', NULL, '1'),
(1503, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163020080', NULL, 'jjcervera'),
(1504, '2017-04-24 02:05:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163020080', NULL, '2017-04-24'),
(1505, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163045208', '1', '2'),
(1506, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163045208', '14', '2'),
(1507, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163045208', NULL, '1'),
(1508, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163045208', NULL, 'jjcervera'),
(1509, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163045208', NULL, '2017-04-24'),
(1510, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163015065', '1', '2'),
(1511, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163015065', '14', '2'),
(1512, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163015065', NULL, '1'),
(1513, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163015065', NULL, 'jjcervera'),
(1514, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163015065', NULL, '2017-04-24'),
(1515, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163015162', '1', '2'),
(1516, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163015162', '14', '2'),
(1517, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163015162', NULL, '1'),
(1518, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163015162', NULL, 'jjcervera'),
(1519, '2017-04-24 02:05:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163015162', NULL, '2017-04-24'),
(1520, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163016687', '1', '2'),
(1521, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163016687', '14', '2'),
(1522, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163016687', NULL, '1'),
(1523, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163016687', NULL, 'jjcervera'),
(1524, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163016687', NULL, '2017-04-24'),
(1525, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163018855', '1', '2'),
(1526, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163018855', '14', '2'),
(1527, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163018855', NULL, '1'),
(1528, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163018855', NULL, 'jjcervera'),
(1529, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163018855', NULL, '2017-04-24'),
(1530, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163020567', '1', '2'),
(1531, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163020567', '14', '2'),
(1532, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163020567', NULL, '1'),
(1533, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163020567', NULL, 'jjcervera'),
(1534, '2017-04-24 02:05:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163020567', NULL, '2017-04-24'),
(1535, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2163022885', '1', '2'),
(1536, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2163022885', '14', '2'),
(1537, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2163022885', NULL, '1'),
(1538, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2163022885', NULL, 'jjcervera'),
(1539, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2163022885', NULL, '2017-04-24'),
(1540, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3163036036', '1', '2'),
(1541, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3163036036', '14', '2'),
(1542, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3163036036', NULL, '1');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1543, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3163036036', NULL, 'jjcervera'),
(1544, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3163036036', NULL, '2017-04-24'),
(1545, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163021690', '1', '2'),
(1546, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163021690', '14', '2'),
(1547, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163021690', NULL, '1'),
(1548, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163021690', NULL, 'jjcervera'),
(1549, '2017-04-24 02:05:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163021690', NULL, '2017-04-24'),
(1550, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA5163023517', '1', '2'),
(1551, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5163023517', '14', '2'),
(1552, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5163023517', NULL, '1'),
(1553, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5163023517', NULL, 'jjcervera'),
(1554, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5163023517', NULL, '2017-04-24'),
(1555, '2017-04-24 02:05:20', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1556, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1557, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051070489', '12', '26'),
(1558, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051073179', '12', '26'),
(1559, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051055862', '12', '26'),
(1560, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051060102', '12', '26'),
(1561, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051060799', '12', '26'),
(1562, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051080866', '1', '26'),
(1563, '2017-04-24 02:07:38', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051081677', '1', '26'),
(1564, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051031936', '1', '26'),
(1565, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051059955', '1', '26'),
(1566, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051037372', '1', '26'),
(1567, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051023607', '1', '26'),
(1568, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051068341', '1', '26'),
(1569, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051058939', '1', '26'),
(1570, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163016576', '1', '24'),
(1571, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163020080', '1', '24'),
(1572, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA0163045208', '1', '24'),
(1573, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163015065', '1', '24'),
(1574, '2017-04-24 02:07:39', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163015162', '1', '24'),
(1575, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163016687', '1', '24'),
(1576, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163018855', '1', '24'),
(1577, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA1163020567', '1', '24'),
(1578, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA2163022885', '1', '24'),
(1579, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA3163036036', '1', '24'),
(1580, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA4163021690', '1', '24'),
(1581, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA5163023517', '1', '24'),
(1582, '2017-04-24 02:07:40', '/sistema/equiposlist.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1583, '2017-04-24 14:36:00', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(1584, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1585, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1163019789', '1', '2'),
(1586, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1163019789', '14', '2'),
(1587, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1163019789', NULL, '1'),
(1588, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1163019789', NULL, 'jjcervera'),
(1589, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1163019789', NULL, '2017-04-24'),
(1590, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4163012788', '1', '2'),
(1591, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4163012788', '14', '2'),
(1592, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4163012788', NULL, '1'),
(1593, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4163012788', NULL, 'jjcervera'),
(1594, '2017-04-24 14:40:07', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4163012788', NULL, '2017-04-24'),
(1595, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA5163036696', '1', '2'),
(1596, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5163036696', '14', '2'),
(1597, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5163036696', NULL, '1'),
(1598, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5163036696', NULL, 'jjcervera'),
(1599, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5163036696', NULL, '2017-04-24'),
(1600, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3313679947', '1', '2'),
(1601, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3313679947', '14', '2'),
(1602, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3313679947', NULL, '1'),
(1603, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3313679947', NULL, 'jjcervera'),
(1604, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3313679947', NULL, '2017-04-24'),
(1605, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4313671536', '1', '2'),
(1606, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4313671536', '14', '2'),
(1607, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4313671536', NULL, '1'),
(1608, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4313671536', NULL, 'jjcervera'),
(1609, '2017-04-24 14:40:08', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4313671536', NULL, '2017-04-24'),
(1610, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA6313691274', '1', '2'),
(1611, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA6313691274', '14', '2'),
(1612, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA6313691274', NULL, '1'),
(1613, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA6313691274', NULL, 'jjcervera'),
(1614, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA6313691274', NULL, '2017-04-24'),
(1615, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9313674043', '1', '2'),
(1616, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9313674043', '14', '2'),
(1617, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9313674043', NULL, '1'),
(1618, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9313674043', NULL, 'jjcervera'),
(1619, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9313674043', NULL, '2017-04-24'),
(1620, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9313674384', '1', '2'),
(1621, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9313674384', '14', '2'),
(1622, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9313674384', NULL, '1'),
(1623, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9313674384', NULL, 'jjcervera'),
(1624, '2017-04-24 14:40:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9313674384', NULL, '2017-04-24'),
(1625, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4074072185', '1', '2'),
(1626, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074072185', '2', '1'),
(1627, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074072185', '14', '2'),
(1628, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074072185', NULL, '1'),
(1629, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074072185', NULL, 'jjcervera'),
(1630, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074072185', NULL, '2017-04-24'),
(1631, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4074067416', '1', '2'),
(1632, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074067416', '14', '2'),
(1633, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074067416', NULL, '1'),
(1634, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074067416', NULL, 'jjcervera'),
(1635, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074067416', NULL, '2017-04-24'),
(1636, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA4074078759', '1', '2'),
(1637, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074078759', '2', '1'),
(1638, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074078759', '14', '2'),
(1639, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074078759', NULL, '1'),
(1640, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074078759', NULL, 'jjcervera'),
(1641, '2017-04-24 14:40:10', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074078759', NULL, '2017-04-24'),
(1642, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA5074146960', '1', '2'),
(1643, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA5074146960', '2', '1'),
(1644, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5074146960', '14', '2'),
(1645, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5074146960', NULL, '1'),
(1646, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5074146960', NULL, 'jjcervera'),
(1647, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5074146960', NULL, '2017-04-24'),
(1648, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2074063262', '1', '2'),
(1649, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074063262', '14', '2'),
(1650, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074063262', NULL, '1'),
(1651, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074063262', NULL, 'jjcervera'),
(1652, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074063262', NULL, '2017-04-24'),
(1653, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2074094539', '1', '2'),
(1654, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2074094539', '2', '1'),
(1655, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074094539', '14', '2'),
(1656, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074094539', NULL, '1'),
(1657, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074094539', NULL, 'jjcervera'),
(1658, '2017-04-24 14:40:11', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074094539', NULL, '2017-04-24'),
(1659, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2074065357', '1', '2'),
(1660, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074065357', '14', '2'),
(1661, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074065357', NULL, '1'),
(1662, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074065357', NULL, 'jjcervera'),
(1663, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074065357', NULL, '2017-04-24'),
(1664, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA2074076234', '1', '2'),
(1665, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2074076234', '2', '1'),
(1666, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074076234', '14', '2'),
(1667, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074076234', NULL, '1'),
(1668, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074076234', NULL, 'jjcervera'),
(1669, '2017-04-24 14:40:12', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074076234', NULL, '2017-04-24'),
(1670, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074077630', '2', '1'),
(1671, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074077630', '14', '2'),
(1672, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074077630', NULL, '1'),
(1673, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074077630', NULL, 'jjcervera'),
(1674, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074077630', NULL, '2017-04-24'),
(1675, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA5074114658', '2', '1'),
(1676, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA5074114658', '14', '2'),
(1677, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA5074114658', NULL, '1'),
(1678, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA5074114658', NULL, 'jjcervera'),
(1679, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA5074114658', NULL, '2017-04-24'),
(1680, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3074151788', '2', '1'),
(1681, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3074151788', '14', '2'),
(1682, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3074151788', NULL, '1'),
(1683, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3074151788', NULL, 'jjcervera'),
(1684, '2017-04-24 14:40:13', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3074151788', NULL, '2017-04-24'),
(1685, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074070524', '2', '1'),
(1686, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074070524', '14', '2'),
(1687, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074070524', NULL, '1'),
(1688, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074070524', NULL, 'jjcervera'),
(1689, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074070524', NULL, '2017-04-24'),
(1690, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074070876', '2', '1'),
(1691, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074070876', '14', '2'),
(1692, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074070876', NULL, '1'),
(1693, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074070876', NULL, 'jjcervera'),
(1694, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074070876', NULL, '2017-04-24'),
(1695, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA4074070613', '2', '1'),
(1696, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA4074070613', '14', '2'),
(1697, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA4074070613', NULL, '1'),
(1698, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA4074070613', NULL, 'jjcervera'),
(1699, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA4074070613', NULL, '2017-04-24'),
(1700, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3074134314', '2', '1'),
(1701, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3074134314', '14', '2'),
(1702, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3074134314', NULL, '1'),
(1703, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3074134314', NULL, 'jjcervera'),
(1704, '2017-04-24 14:40:14', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3074134314', NULL, '2017-04-24'),
(1705, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2074127871', '2', '1'),
(1706, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074127871', '14', '2'),
(1707, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074127871', NULL, '1'),
(1708, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074127871', NULL, 'jjcervera'),
(1709, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074127871', NULL, '2017-04-24'),
(1710, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA2074094511', '2', '1'),
(1711, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074094511', '14', '2'),
(1712, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074094511', NULL, '1'),
(1713, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074094511', NULL, 'jjcervera'),
(1714, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074094511', NULL, '2017-04-24'),
(1715, '2017-04-24 14:40:15', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1716, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1717, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051073827', '2', '1'),
(1718, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051073827', '14', '12'),
(1719, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051073827', NULL, '1'),
(1720, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051073827', NULL, 'jjcervera'),
(1721, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051073827', NULL, '2017-04-24'),
(1722, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051029652', '14', '12'),
(1723, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051029652', NULL, '1'),
(1724, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051029652', NULL, 'jjcervera'),
(1725, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051029652', NULL, '2017-04-24'),
(1726, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051028943', '14', '12'),
(1727, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051028943', NULL, '1'),
(1728, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051028943', NULL, 'jjcervera'),
(1729, '2017-04-24 14:43:03', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051028943', NULL, '2017-04-24'),
(1730, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA8163018806', '2', '1'),
(1731, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA8163018806', '14', '12'),
(1732, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA8163018806', NULL, '1'),
(1733, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA8163018806', NULL, 'jjcervera'),
(1734, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA8163018806', NULL, '2017-04-24'),
(1735, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA2074094690', '14', '12'),
(1736, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA2074094690', NULL, '1'),
(1737, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA2074094690', NULL, 'jjcervera'),
(1738, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA2074094690', NULL, '2017-04-24'),
(1739, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1074167270', '14', '12'),
(1740, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1074167270', NULL, '1'),
(1741, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1074167270', NULL, 'jjcervera'),
(1742, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1074167270', NULL, '2017-04-24'),
(1743, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3163013337', '2', '1'),
(1744, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3163013337', '2', '1'),
(1745, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3163013337', '14', '12'),
(1746, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3163013337', NULL, '1'),
(1747, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3163013337', NULL, 'jjcervera'),
(1748, '2017-04-24 14:43:04', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3163013337', NULL, '2017-04-24'),
(1749, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA8163023278', '2', '1'),
(1750, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA8163023278', '2', '1'),
(1751, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA8163023278', '14', '12'),
(1752, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA8163023278', NULL, '1'),
(1753, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA8163023278', NULL, 'jjcervera'),
(1754, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA8163023278', NULL, '2017-04-24'),
(1755, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9163036123', '2', '1'),
(1756, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9163036123', '2', '1'),
(1757, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9163036123', '14', '12'),
(1758, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9163036123', NULL, '1'),
(1759, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9163036123', NULL, 'jjcervera'),
(1760, '2017-04-24 14:43:05', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9163036123', NULL, '2017-04-24'),
(1761, '2017-04-24 14:43:06', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1762, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1763, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051023449', '1', '2'),
(1764, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051023449', '1', '2'),
(1765, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051023449', '14', '7'),
(1766, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051023449', NULL, '1'),
(1767, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051023449', NULL, 'jjcervera'),
(1768, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051023449', NULL, '2017-04-24'),
(1769, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA3313671570', '1', '2'),
(1770, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA3313671570', '1', '2'),
(1771, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA3313671570', '14', '7'),
(1772, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA3313671570', NULL, '1'),
(1773, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA3313671570', NULL, 'jjcervera'),
(1774, '2017-04-24 14:46:49', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA3313671570', NULL, '2017-04-24'),
(1775, '2017-04-24 14:46:50', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1776, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(1777, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '24', '', 'ROBADA'),
(1778, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '24', '', '2017-04-24'),
(1779, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '24', '', '6051023449'),
(1780, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '24', '', '24'),
(1781, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(1782, '2017-04-24 14:47:11', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051023449', '1', '26'),
(1783, '2017-04-24 14:47:47', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_equipo', '', '', '', ''),
(1784, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Detalle', '25', '', 'ROBADA'),
(1785, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Fecha_Actualizacion', '25', '', '2017-04-24'),
(1786, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'NroSerie', '25', '', 'AA3313671570'),
(1787, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', 'A', 'observacion_equipo', 'Id_Observacion', '25', '', '25'),
(1788, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_equipo', '', '', '', ''),
(1789, '2017-04-24 14:47:48', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA3313671570', '1', '23'),
(1790, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1791, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051072992', '1', '2'),
(1792, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051072992', '1', '2'),
(1793, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051072992', '14', '11'),
(1794, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051072992', NULL, '1'),
(1795, '2017-04-24 14:51:33', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072992', '2017-04-23', '2017-04-24'),
(1796, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051072910', '1', '2'),
(1797, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '9051072910', '1', '2'),
(1798, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051072910', '14', '11'),
(1799, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051072910', NULL, '1'),
(1800, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051072910', '2017-04-23', '2017-04-24'),
(1801, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051073602', '1', '2'),
(1802, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051073602', '1', '2'),
(1803, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051073602', '14', '11'),
(1804, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051073602', NULL, '1'),
(1805, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051073602', '2017-04-23', '2017-04-24'),
(1806, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051023029', '1', '2'),
(1807, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '7051023029', '1', '2'),
(1808, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051023029', '14', '11'),
(1809, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051023029', NULL, '1'),
(1810, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051023029', NULL, 'jjcervera'),
(1811, '2017-04-24 14:51:34', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051023029', NULL, '2017-04-24'),
(1812, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051074437', '1', '2'),
(1813, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051074437', '1', '2'),
(1814, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051074437', '14', '11'),
(1815, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051074437', NULL, '1'),
(1816, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051074437', NULL, 'jjcervera'),
(1817, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051074437', NULL, '2017-04-24'),
(1818, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051073829', '1', '2'),
(1819, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051073829', '1', '2'),
(1820, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051073829', '14', '11'),
(1821, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051073829', NULL, '1'),
(1822, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051073829', NULL, 'jjcervera'),
(1823, '2017-04-24 14:51:35', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051073829', NULL, '2017-04-24'),
(1824, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051080975', '1', '2'),
(1825, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051080975', '1', '2'),
(1826, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051080975', '14', '11'),
(1827, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051080975', NULL, '1'),
(1828, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051080975', NULL, 'jjcervera'),
(1829, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051080975', NULL, '2017-04-24'),
(1830, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051074059', '1', '2'),
(1831, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051074059', '1', '2'),
(1832, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051074059', '14', '11'),
(1833, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051074059', NULL, '1'),
(1834, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051074059', NULL, 'jjcervera'),
(1835, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051074059', NULL, '2017-04-24'),
(1836, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '9051022539', '1', '2'),
(1837, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051022539', '14', '11'),
(1838, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051022539', NULL, '1'),
(1839, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051022539', NULL, 'jjcervera'),
(1840, '2017-04-24 14:51:36', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051022539', NULL, '2017-04-24'),
(1841, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051060325', '1', '2'),
(1842, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051060325', '1', '2'),
(1843, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051060325', '14', '11'),
(1844, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051060325', NULL, '1'),
(1845, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051060325', NULL, 'jjcervera'),
(1846, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051060325', NULL, '2017-04-24'),
(1847, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051060054', '1', '2'),
(1848, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051060054', '1', '2'),
(1849, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051060054', '14', '11'),
(1850, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051060054', NULL, '1'),
(1851, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051060054', NULL, 'jjcervera'),
(1852, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051060054', NULL, '2017-04-24'),
(1853, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051081717', '1', '2'),
(1854, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051081717', '14', '11'),
(1855, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051081717', NULL, '1'),
(1856, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051081717', NULL, 'jjcervera'),
(1857, '2017-04-24 14:51:37', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051081717', NULL, '2017-04-24'),
(1858, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '6051037921', '1', '2'),
(1859, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051037921', '1', '2'),
(1860, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051037921', '14', '11'),
(1861, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051037921', NULL, '1'),
(1862, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051037921', NULL, 'jjcervera'),
(1863, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051037921', NULL, '2017-04-24'),
(1864, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051072713', '1', '2'),
(1865, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051072713', '1', '2'),
(1866, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051072713', '14', '11'),
(1867, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051072713', NULL, '1'),
(1868, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051072713', NULL, 'jjcervera'),
(1869, '2017-04-24 14:51:38', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051072713', NULL, '2017-04-24'),
(1870, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '7051022117', '1', '2'),
(1871, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051022117', '14', '11'),
(1872, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051022117', NULL, '1'),
(1873, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051022117', NULL, 'jjcervera'),
(1874, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051022117', NULL, '2017-04-24'),
(1875, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051022901', '1', '2'),
(1876, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051022901', '1', '2'),
(1877, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051022901', '14', '11'),
(1878, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051022901', NULL, '1'),
(1879, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051022901', NULL, 'jjcervera'),
(1880, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051022901', NULL, '2017-04-24'),
(1881, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051072776', '1', '2'),
(1882, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051072776', '1', '2'),
(1883, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051072776', '14', '11'),
(1884, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051072776', NULL, '1'),
(1885, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051072776', NULL, 'jjcervera'),
(1886, '2017-04-24 14:51:39', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051072776', NULL, '2017-04-24'),
(1887, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '1051062658', '1', '2'),
(1888, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '1051062658', '1', '2'),
(1889, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051062658', '14', '11'),
(1890, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051062658', NULL, '1'),
(1891, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051062658', NULL, 'jjcervera'),
(1892, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051062658', NULL, '2017-04-24'),
(1893, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '4051029744', '1', '2'),
(1894, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '4051029744', '1', '2'),
(1895, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051029744', '14', '11'),
(1896, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051029744', NULL, '1'),
(1897, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051029744', NULL, 'jjcervera'),
(1898, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051029744', NULL, '2017-04-24'),
(1899, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '2051082226', '1', '2'),
(1900, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '2051082226', '1', '2'),
(1901, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051082226', '14', '11'),
(1902, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051082226', NULL, '1'),
(1903, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051082226', NULL, 'jjcervera'),
(1904, '2017-04-24 14:51:40', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051082226', NULL, '2017-04-24'),
(1905, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051024846', '1', '2'),
(1906, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051024846', '1', '2'),
(1907, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051024846', '14', '11'),
(1908, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051024846', NULL, '1'),
(1909, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051024846', NULL, 'jjcervera'),
(1910, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051024846', NULL, '2017-04-24'),
(1911, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA7163012491', '1', '2'),
(1912, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA7163012491', '1', '2'),
(1913, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA7163012491', '14', '11'),
(1914, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA7163012491', NULL, '1'),
(1915, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA7163012491', NULL, 'jjcervera'),
(1916, '2017-04-24 14:51:41', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA7163012491', NULL, '2017-04-24');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(1917, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA8163019949', '1', '2'),
(1918, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA8163019949', '1', '2'),
(1919, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA8163019949', '14', '11'),
(1920, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA8163019949', NULL, '1'),
(1921, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA8163019949', NULL, 'jjcervera'),
(1922, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA8163019949', NULL, '2017-04-24'),
(1923, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9184128036', '1', '2'),
(1924, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9184128036', '1', '2'),
(1925, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9184128036', '14', '11'),
(1926, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9184128036', NULL, '1'),
(1927, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9184128036', NULL, 'jjcervera'),
(1928, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9184128036', NULL, '2017-04-24'),
(1929, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051068257', '14', '11'),
(1930, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051068257', NULL, '1'),
(1931, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051068257', NULL, 'jjcervera'),
(1932, '2017-04-24 14:51:42', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051068257', NULL, '2017-04-24'),
(1933, '2017-04-24 14:51:43', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(1934, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(1935, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051073342', '14', '11'),
(1936, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '5051073342', 'NO', 'SI'),
(1937, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051073342', NULL, '1'),
(1938, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051073342', NULL, 'jjcervera'),
(1939, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051073342', NULL, '2017-04-24'),
(1940, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051059224', '14', '11'),
(1941, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '1051059224', 'NO', 'SI'),
(1942, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051059224', NULL, '1'),
(1943, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051059224', NULL, 'jjcervera'),
(1944, '2017-04-24 14:52:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051059224', NULL, '2017-04-24'),
(1945, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051048718', '14', '11'),
(1946, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '2051048718', 'NO', 'SI'),
(1947, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051048718', NULL, '1'),
(1948, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051048718', NULL, 'jjcervera'),
(1949, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051048718', NULL, '2017-04-24'),
(1950, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051072677', '14', '11'),
(1951, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '6051072677', 'NO', 'SI'),
(1952, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051072677', NULL, '1'),
(1953, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051072677', NULL, 'jjcervera'),
(1954, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051072677', NULL, '2017-04-24'),
(1955, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051059817', '14', '11'),
(1956, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '5051059817', 'NO', 'SI'),
(1957, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051059817', NULL, '1'),
(1958, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051059817', NULL, 'jjcervera'),
(1959, '2017-04-24 14:52:22', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051059817', NULL, '2017-04-24'),
(1960, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051072807', '14', '11'),
(1961, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '4051072807', 'NO', 'SI'),
(1962, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051072807', NULL, '1'),
(1963, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051072807', NULL, 'jjcervera'),
(1964, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051072807', NULL, '2017-04-24'),
(1965, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051072988', '14', '11'),
(1966, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '5051072988', 'NO', 'SI'),
(1967, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051072988', NULL, '1'),
(1968, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '5051072988', NULL, 'jjcervera'),
(1969, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072988', NULL, '2017-04-24'),
(1970, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051060058', '14', '11'),
(1971, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '8051060058', 'NO', 'SI'),
(1972, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051060058', NULL, '1'),
(1973, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051060058', NULL, 'jjcervera'),
(1974, '2017-04-24 14:52:23', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051060058', NULL, '2017-04-24'),
(1975, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051081036', '14', '11'),
(1976, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '1051081036', 'NO', 'SI'),
(1977, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051081036', NULL, '1'),
(1978, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051081036', NULL, 'jjcervera'),
(1979, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051081036', NULL, '2017-04-24'),
(1980, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '4051061564', '14', '11'),
(1981, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '4051061564', 'NO', 'SI'),
(1982, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '4051061564', NULL, '1'),
(1983, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '4051061564', NULL, 'jjcervera'),
(1984, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '4051061564', NULL, '2017-04-24'),
(1985, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051074974', '14', '11'),
(1986, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '6051074974', 'NO', 'SI'),
(1987, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051074974', NULL, '1'),
(1988, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051074974', NULL, 'jjcervera'),
(1989, '2017-04-24 14:52:24', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051074974', NULL, '2017-04-24'),
(1990, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051081679', '14', '11'),
(1991, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '8051081679', 'NO', 'SI'),
(1992, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051081679', NULL, '1'),
(1993, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051081679', NULL, 'jjcervera'),
(1994, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051081679', NULL, '2017-04-24'),
(1995, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051039337', '14', '11'),
(1996, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '9051039337', 'NO', 'SI'),
(1997, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051039337', NULL, '1'),
(1998, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051039337', NULL, 'jjcervera'),
(1999, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051039337', NULL, '2017-04-24'),
(2000, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051072855', '14', '11'),
(2001, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '8051072855', 'NO', 'SI'),
(2002, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051072855', NULL, '1'),
(2003, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '8051072855', NULL, 'jjcervera'),
(2004, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051072855', NULL, '2017-04-24'),
(2005, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '6051062538', '14', '11'),
(2006, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '6051062538', 'NO', 'SI'),
(2007, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051062538', NULL, '1'),
(2008, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051062538', NULL, 'jjcervera'),
(2009, '2017-04-24 14:52:25', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051062538', NULL, '2017-04-24'),
(2010, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '7051081035', '14', '11'),
(2011, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '7051081035', 'NO', 'SI'),
(2012, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '7051081035', NULL, '1'),
(2013, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '7051081035', NULL, 'jjcervera'),
(2014, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '7051081035', NULL, '2017-04-24'),
(2015, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '2051022644', '14', '11'),
(2016, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '2051022644', 'NO', 'SI'),
(2017, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '2051022644', NULL, '1'),
(2018, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '2051022644', NULL, 'jjcervera'),
(2019, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '2051022644', NULL, '2017-04-24'),
(2020, '2017-04-24 14:52:26', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2021, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2022, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '5051072782', '1', '2'),
(2023, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '5051072782', '1', '2'),
(2024, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '5051072782', '14', '11'),
(2025, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '5051072782', NULL, '1'),
(2026, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '5051072782', '2017-04-23', '2017-04-24'),
(2027, '2017-04-24 14:53:21', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2028, '2017-04-24 14:53:46', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051061346', '12', '26'),
(2029, '2017-04-24 14:54:04', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072782', '12', '26'),
(2030, '2017-04-24 14:54:22', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '8051061349', '1', '2'),
(2031, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2032, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072992', '12', '26'),
(2033, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051072910', '12', '26'),
(2034, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051073602', '12', '26'),
(2035, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051023029', '1', '26'),
(2036, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051074437', '1', '26'),
(2037, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051073829', '1', '26'),
(2038, '2017-04-24 14:55:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051080975', '1', '26'),
(2039, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051074059', '1', '26'),
(2040, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051022539', '1', '26'),
(2041, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051060325', '1', '26'),
(2042, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051060054', '1', '26'),
(2043, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051081717', '1', '26'),
(2044, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051037921', '1', '26'),
(2045, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051072713', '1', '26'),
(2046, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051022117', '1', '26'),
(2047, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051022901', '1', '26'),
(2048, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '3051072776', '1', '26'),
(2049, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051062658', '1', '26'),
(2050, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051029744', '1', '26'),
(2051, '2017-04-24 14:55:20', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051082226', '1', '26'),
(2052, '2017-04-24 14:55:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051024846', '1', '26'),
(2053, '2017-04-24 14:55:21', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051068257', '1', '26'),
(2054, '2017-04-24 14:55:21', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2055, '2017-04-24 14:56:09', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2056, '2017-04-24 14:56:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA7163012491', '1', '24'),
(2057, '2017-04-24 14:56:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA8163019949', '1', '24'),
(2058, '2017-04-24 14:56:09', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9184128036', '1', '24'),
(2059, '2017-04-24 14:56:09', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2060, '2017-04-24 14:57:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9184128036', '2', '1'),
(2061, '2017-04-24 14:57:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9184128036', '2', '1'),
(2062, '2017-04-24 14:57:05', '/sistema/equiposedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', 'AA9184128036', '24', '21'),
(2063, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2064, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051073342', '1', '26'),
(2065, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051059224', '1', '26'),
(2066, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051048718', '1', '26'),
(2067, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051072677', '1', '26'),
(2068, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051059817', '1', '26'),
(2069, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051072807', '1', '26'),
(2070, '2017-04-24 14:58:01', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '5051072988', '1', '26'),
(2071, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051060058', '1', '26'),
(2072, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '1051081036', '1', '26'),
(2073, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '4051061564', '1', '26'),
(2074, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051074974', '1', '26'),
(2075, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051081679', '1', '26'),
(2076, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '9051039337', '1', '26'),
(2077, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '8051072855', '1', '26'),
(2078, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051062538', '1', '26'),
(2079, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '7051081035', '1', '26'),
(2080, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '2051022644', '1', '26'),
(2081, '2017-04-24 14:58:02', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2082, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2083, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '41301919', '6', '1'),
(2084, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '41301919', NULL, 'jjcervera'),
(2085, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '41301919', NULL, '2017-04-24'),
(2086, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '41615919', '6', '1'),
(2087, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '41615919', NULL, 'jjcervera'),
(2088, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '41615919', NULL, '2017-04-24'),
(2089, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44435206', '6', '1'),
(2090, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44435206', NULL, 'jjcervera'),
(2091, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44435206', NULL, '2017-04-24'),
(2092, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '95339309', '6', '1'),
(2093, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '95339309', NULL, 'jjcervera'),
(2094, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '95339309', NULL, '2017-04-24'),
(2095, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44227764', '6', '1'),
(2096, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44227764', NULL, 'jjcervera'),
(2097, '2017-04-24 15:02:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44227764', NULL, '2017-04-24'),
(2098, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43010749', '6', '1'),
(2099, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43010749', NULL, 'jjcervera'),
(2100, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43010749', NULL, '2017-04-24'),
(2101, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42003264', '6', '1'),
(2102, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '42003264', NULL, 'jjcervera'),
(2103, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42003264', NULL, '2017-04-24'),
(2104, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43944672', '6', '1'),
(2105, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43944672', NULL, 'jjcervera'),
(2106, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43944672', NULL, '2017-04-24'),
(2107, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44541555', '6', '1'),
(2108, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44541555', NULL, 'jjcervera'),
(2109, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44541555', NULL, '2017-04-24'),
(2110, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42272677', '6', '1'),
(2111, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '42272677', NULL, 'jjcervera'),
(2112, '2017-04-24 15:02:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42272677', NULL, '2017-04-24'),
(2113, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44528566', '6', '1'),
(2114, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44528566', NULL, 'jjcervera'),
(2115, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44528566', NULL, '2017-04-24'),
(2116, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42762596', '6', '1'),
(2117, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '42762596', NULL, 'jjcervera'),
(2118, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42762596', NULL, '2017-04-24'),
(2119, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43547029', '6', '1'),
(2120, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43547029', NULL, 'jjcervera'),
(2121, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43547029', NULL, '2017-04-24'),
(2122, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43153355', '6', '1'),
(2123, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43153355', NULL, 'jjcervera'),
(2124, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43153355', NULL, '2017-04-24'),
(2125, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '49278992', '6', '1'),
(2126, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '49278992', NULL, 'jjcervera'),
(2127, '2017-04-24 15:02:27', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '49278992', NULL, '2017-04-24'),
(2128, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44228283', '6', '1'),
(2129, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44228283', NULL, 'jjcervera'),
(2130, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44228283', NULL, '2017-04-24'),
(2131, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '89', '6', '1'),
(2132, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '89', NULL, 'jjcervera'),
(2133, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '89', NULL, '2017-04-24'),
(2134, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45027518', '6', '1'),
(2135, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45027518', NULL, 'jjcervera'),
(2136, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45027518', NULL, '2017-04-24'),
(2137, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '92', '6', '1'),
(2138, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '92', NULL, 'jjcervera'),
(2139, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '92', NULL, '2017-04-24'),
(2140, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44072185', '6', '1'),
(2141, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44072185', NULL, 'jjcervera'),
(2142, '2017-04-24 15:02:28', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44072185', NULL, '2017-04-24'),
(2143, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45133212', '6', '1'),
(2144, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45133212', NULL, 'jjcervera'),
(2145, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45133212', NULL, '2017-04-24'),
(2146, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43944655', '6', '1'),
(2147, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43944655', NULL, 'jjcervera'),
(2148, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43944655', NULL, '2017-04-24'),
(2149, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '53538208', '6', '1'),
(2150, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '53538208', NULL, 'jjcervera'),
(2151, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '53538208', NULL, '2017-04-24'),
(2152, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45136830', '6', '1'),
(2153, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45136830', NULL, 'jjcervera'),
(2154, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45136830', NULL, '2017-04-24'),
(2155, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44880007', '6', '1'),
(2156, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44880007', NULL, 'jjcervera'),
(2157, '2017-04-24 15:02:29', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44880007', NULL, '2017-04-24'),
(2158, '2017-04-24 15:02:30', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2159, '2017-04-24 15:06:04', '/sistema/logout.php', 'jjcervera', 'logout', '90.0.0.197', '', '', '', ''),
(2160, '2017-04-24 15:06:15', '/sistema/login.php', 'admin', 'login', '90.0.0.197', '', '', '', ''),
(2161, '2017-04-24 19:35:52', '/sistema/login.php', 'admin', 'login', '90.0.0.161', '', '', '', ''),
(2162, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', '*** Batch delete begin ***', 'usuarios', '', '', '', ''),
(2163, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Nombre', 'gabriel.zrt', 'gabriel.zrt', ''),
(2164, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Password', 'gabriel.zrt', '********', ''),
(2165, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Nivel_Usuario', 'gabriel.zrt', '4', ''),
(2166, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'NombreTitular', 'gabriel.zrt', 'ZARATE GABRIEL(USO ADMINISTRADOR)', ''),
(2167, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Dni', 'gabriel.zrt', '90', ''),
(2168, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Curso', 'gabriel.zrt', '10', ''),
(2169, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Turno', 'gabriel.zrt', '1', ''),
(2170, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', 'D', 'usuarios', 'Division', 'gabriel.zrt', '13', ''),
(2171, '2017-04-24 19:46:17', '/sistema/usuariosdelete.php', '-1', '*** Batch delete successful ***', 'usuarios', '', '', '', ''),
(2172, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'NombreTitular', 'Gabriel', '', 'ZARATE GABRIEL(USO ADMINISTRADOR)'),
(2173, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Dni', 'Gabriel', '', '33147421'),
(2174, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nombre', 'Gabriel', '', 'Gabriel'),
(2175, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Password', 'Gabriel', '', '********'),
(2176, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nivel_Usuario', 'Gabriel', '', '-1'),
(2177, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Curso', 'Gabriel', '', '10'),
(2178, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Turno', 'Gabriel', '', '1'),
(2179, '2017-04-24 19:51:08', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Division', 'Gabriel', '', '13'),
(2180, '2017-04-24 19:51:25', '/sistema/logout.php', 'Administrator', 'logout', '90.0.0.161', '', '', '', ''),
(2181, '2017-04-24 19:51:33', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.161', '', '', '', ''),
(2182, '2017-04-24 19:53:57', '/sistema/login.php', 'Gabriel', 'login', '90.0.0.111', '', '', '', ''),
(2183, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '1,AA4074078679', '', '90'),
(2184, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '1,AA4074078679', '', 'AA4074078679'),
(2185, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '1,AA4074078679', '', '2017-04-24'),
(2186, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '1,AA4074078679', '', '2'),
(2187, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '1,AA4074078679', '', 'jjcervera'),
(2188, '2017-04-24 19:57:06', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '1,AA4074078679', '', '1'),
(2189, '2017-04-24 19:59:04', '/sistema/modeloedit.php', 'jjcervera', 'U', 'modelo', 'Descripcion', '9', 'CLASS', 'OTRO'),
(2190, '2017-04-24 19:59:24', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '27', '', 'CLASS'),
(2191, '2017-04-24 19:59:24', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '27', '', '10'),
(2192, '2017-04-24 19:59:24', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '27', '', '27'),
(2193, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2194, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '8051061208', '1', '2'),
(2195, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '8051061208', '1', '2'),
(2196, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '8051061208', '14', '2'),
(2197, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '8051061208', NULL, '1'),
(2198, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '8051061208', '2017-04-23', '2017-04-24'),
(2199, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', '3051050941', '1', '2'),
(2200, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '3051050941', '1', '2'),
(2201, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051050941', '14', '2'),
(2202, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051050941', NULL, '1'),
(2203, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051050941', NULL, 'jjcervera'),
(2204, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051050941', NULL, '2017-04-24'),
(2205, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0163041576', '1', '2'),
(2206, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0163041576', '1', '2'),
(2207, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0163041576', '14', '2'),
(2208, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0163041576', NULL, '1'),
(2209, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0163041576', NULL, 'jjcervera'),
(2210, '2017-04-24 20:03:16', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0163041576', NULL, '2017-04-24'),
(2211, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA0313684821', '1', '2'),
(2212, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA0313684821', '1', '2'),
(2213, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA0313684821', '14', '2'),
(2214, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA0313684821', NULL, '1'),
(2215, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA0313684821', NULL, 'jjcervera'),
(2216, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA0313684821', NULL, '2017-04-24'),
(2217, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA1074145121', '1', '2'),
(2218, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA1074145121', '1', '2'),
(2219, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA1074145121', '14', '2'),
(2220, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA1074145121', NULL, '1'),
(2221, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA1074145121', NULL, 'jjcervera'),
(2222, '2017-04-24 20:03:17', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA1074145121', NULL, '2017-04-24'),
(2223, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Ubicacion', 'AA9184144117', '1', '2'),
(2224, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', 'AA9184144117', '1', '2'),
(2225, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', 'AA9184144117', '14', '2'),
(2226, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', 'AA9184144117', NULL, '1'),
(2227, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', 'AA9184144117', NULL, 'jjcervera'),
(2228, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', 'AA9184144117', NULL, '2017-04-24'),
(2229, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '1051061351', '14', '2'),
(2230, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '1051061351', 'NO', 'SI'),
(2231, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '1051061351', NULL, '1'),
(2232, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '1051061351', NULL, 'jjcervera'),
(2233, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '1051061351', NULL, '2017-04-24'),
(2234, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '3051038787', '14', '2'),
(2235, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '3051038787', 'NO', 'SI'),
(2236, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '3051038787', NULL, '1'),
(2237, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '3051038787', NULL, 'jjcervera'),
(2238, '2017-04-24 20:03:18', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '3051038787', NULL, '2017-04-24'),
(2239, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Sit_Estado', '9051021974', '14', '2'),
(2240, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Tiene_Cargador', '9051021974', 'NO', 'SI'),
(2241, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '9051021974', NULL, '1'),
(2242, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Usuario', '9051021974', NULL, 'jjcervera'),
(2243, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '9051021974', NULL, '2017-04-24'),
(2244, '2017-04-24 20:03:19', '/sistema/equiposupdate.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2245, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Cue_Establecimiento', '540176400', '', '540176400'),
(2246, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Nombre_Establecimiento', '540176400', '', 'EPET N° 33'),
(2247, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Nombre_Directivo', '540176400', '', 'BENITEZ JULIO CESAR'),
(2248, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Cuil_Directivo', '540176400', '', '20162941063'),
(2249, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Nombre_Rte', '540176400', '', NULL),
(2250, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Tel_Rte', '540176400', '', NULL),
(2251, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Email_Rte', '540176400', '', NULL),
(2252, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Nro_Serie_Server_Escolar', '540176400', '', 'T002-4152000756'),
(2253, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Contacto_Establecimiento', '540176400', '', NULL),
(2254, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Domicilio_Escuela', '540176400', '', 'RUTAN°12'),
(2255, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Id_Provincia', '540176400', '', '1'),
(2256, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Id_Departamento', '540176400', '', '10'),
(2257, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Id_Localidad', '540176400', '', '36'),
(2258, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Fecha_Actualizacion', '540176400', '', '2017-04-24'),
(2259, '2017-04-24 20:15:03', '/sistema/establecimientos_educativos_paseadd.php', 'Gabriel', 'A', 'establecimientos_educativos_pase', 'Usuario', '540176400', '', 'Gabriel'),
(2260, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2261, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45053423', '6', '1'),
(2262, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45053423', '11', '1'),
(2263, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45053423', '17', '2'),
(2264, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45053423', '13', '1'),
(2265, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45053423', '3', '2'),
(2266, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Usuario', '45053423', NULL, 'jjcervera'),
(2267, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45053423', NULL, '2017-04-24'),
(2268, '2017-04-24 20:27:51', '/sistema/personaslist.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2269, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2270, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Sexo', '43945863', '3', '1'),
(2271, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '43945863', '6', '1'),
(2272, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '43945863', '11', '1'),
(2273, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '43945863', '17', '3'),
(2274, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '43945863', '3', '1'),
(2275, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '43945863', NULL, 'Gabriel'),
(2276, '2017-04-24 20:29:05', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '43945863', NULL, '2017-04-24'),
(2277, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Sexo', '43419988', '3', '1'),
(2278, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '43419988', '6', '1'),
(2279, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '43419988', '11', '1'),
(2280, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '43419988', '17', '3'),
(2281, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '43419988', '3', '1'),
(2282, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '43419988', NULL, 'Gabriel'),
(2283, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '43419988', NULL, '2017-04-24'),
(2284, '2017-04-24 20:29:06', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2285, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2286, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44227764', '0', '1'),
(2287, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44435593', '6', '1'),
(2288, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44435593', '11', '1'),
(2289, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44435593', '17', '2'),
(2290, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44435593', '13', '1'),
(2291, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44435593', '3', '2');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(2292, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44435593', NULL, 'jjcervera'),
(2293, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44435593', NULL, '2017-04-24'),
(2294, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44540436', '6', '1'),
(2295, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44540436', '11', '1'),
(2296, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44540436', '17', '2'),
(2297, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44540436', '13', '1'),
(2298, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44540436', '3', '2'),
(2299, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44540436', NULL, 'jjcervera'),
(2300, '2017-04-24 20:30:12', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44540436', NULL, '2017-04-24'),
(2301, '2017-04-24 20:30:13', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2302, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '44227760', '3', '2'),
(2303, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44227760', '6', '1'),
(2304, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44227760', '11', '1'),
(2305, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44227760', '17', '2'),
(2306, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44227760', '13', '1'),
(2307, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44227760', '3', '2'),
(2308, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '44227760', NULL, 'jjcervera'),
(2309, '2017-04-24 20:33:39', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44227760', NULL, '2017-04-24'),
(2310, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2311, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42026513', '6', '1'),
(2312, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42026513', '11', '1'),
(2313, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42026513', '17', '5'),
(2314, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42026513', '13', '1'),
(2315, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42026513', '3', '1'),
(2316, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42026513', NULL, 'Gabriel'),
(2317, '2017-04-24 20:36:11', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42026513', NULL, '2017-04-24'),
(2318, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42811244', '6', '1'),
(2319, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42811244', '11', '1'),
(2320, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42811244', '17', '5'),
(2321, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42811244', '13', '1'),
(2322, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42811244', '3', '1'),
(2323, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42811244', NULL, 'Gabriel'),
(2324, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42811244', NULL, '2017-04-24'),
(2325, '2017-04-24 20:36:12', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2326, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2327, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44880006', '6', '1'),
(2328, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44880006', '11', '1'),
(2329, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44880006', '17', '2'),
(2330, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44880006', '13', '1'),
(2331, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44880006', '3', '2'),
(2332, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44880006', NULL, 'jjcervera'),
(2333, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44880006', NULL, '2017-04-24'),
(2334, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44149042', '6', '1'),
(2335, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44149042', '11', '1'),
(2336, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44149042', '17', '2'),
(2337, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44149042', '13', '1'),
(2338, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44149042', '3', '2'),
(2339, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44149042', NULL, 'jjcervera'),
(2340, '2017-04-24 20:36:25', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44149042', NULL, '2017-04-24'),
(2341, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44541557', '6', '1'),
(2342, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44541557', '11', '1'),
(2343, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44541557', '17', '2'),
(2344, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44541557', '13', '1'),
(2345, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44541557', '3', '2'),
(2346, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44541557', NULL, 'jjcervera'),
(2347, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44541557', NULL, '2017-04-24'),
(2348, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42965482', '6', '1'),
(2349, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '42965482', '11', '1'),
(2350, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '42965482', '17', '2'),
(2351, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '42965482', '13', '1'),
(2352, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '42965482', '3', '2'),
(2353, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '42965482', NULL, 'jjcervera'),
(2354, '2017-04-24 20:36:26', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42965482', NULL, '2017-04-24'),
(2355, '2017-04-24 20:36:27', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2356, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2357, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42764332', '6', '1'),
(2358, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '42764332', '11', '1'),
(2359, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '42764332', '17', '2'),
(2360, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '42764332', '13', '1'),
(2361, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '42764332', '3', '2'),
(2362, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '42764332', NULL, 'jjcervera'),
(2363, '2017-04-24 20:38:56', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42764332', NULL, '2017-04-24'),
(2364, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44072177', '6', '1'),
(2365, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44072177', '11', '1'),
(2366, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44072177', '17', '2'),
(2367, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44072177', '13', '1'),
(2368, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44072177', '3', '2'),
(2369, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44072177', NULL, 'jjcervera'),
(2370, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44072177', NULL, '2017-04-24'),
(2371, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44541555', '0', '1'),
(2372, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45053478', '6', '1'),
(2373, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45053478', '11', '1'),
(2374, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45053478', '17', '2'),
(2375, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45053478', '13', '1'),
(2376, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45053478', '3', '2'),
(2377, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45053478', NULL, 'jjcervera'),
(2378, '2017-04-24 20:38:57', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45053478', NULL, '2017-04-24'),
(2379, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45053412', '6', '1'),
(2380, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45053412', '11', '1'),
(2381, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45053412', '17', '2'),
(2382, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45053412', '13', '1'),
(2383, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45053412', '3', '2'),
(2384, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45053412', NULL, 'jjcervera'),
(2385, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45053412', NULL, '2017-04-24'),
(2386, '2017-04-24 20:38:58', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2387, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2388, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '41632052', '6', '1'),
(2389, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '41632052', '11', '1'),
(2390, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '41632052', '17', '5'),
(2391, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '41632052', '13', '1'),
(2392, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '41632052', '3', '1'),
(2393, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '41632052', NULL, 'Gabriel'),
(2394, '2017-04-24 20:40:52', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '41632052', NULL, '2017-04-24'),
(2395, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '50456745', '6', '1'),
(2396, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '50456745', '11', '1'),
(2397, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '50456745', '17', '5'),
(2398, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '50456745', '13', '1'),
(2399, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '50456745', '3', '1'),
(2400, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '50456745', NULL, 'Gabriel'),
(2401, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '50456745', NULL, '2017-04-24'),
(2402, '2017-04-24 20:40:53', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2403, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2404, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43700763', '6', '1'),
(2405, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '43700763', '11', '1'),
(2406, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '43700763', '17', '2'),
(2407, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '43700763', '13', '1'),
(2408, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '43700763', '3', '2'),
(2409, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43700763', NULL, 'jjcervera'),
(2410, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43700763', NULL, '2017-04-24'),
(2411, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43153335', '6', '1'),
(2412, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '43153335', '11', '1'),
(2413, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '43153335', '17', '2'),
(2414, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '43153335', '13', '1'),
(2415, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '43153335', '3', '2'),
(2416, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43153335', NULL, 'jjcervera'),
(2417, '2017-04-24 20:41:59', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43153335', NULL, '2017-04-24'),
(2418, '2017-04-24 20:42:00', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2419, '2017-04-24 20:45:22', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '44528566', '3', '1'),
(2420, '2017-04-24 20:45:22', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44528566', '0', '1'),
(2421, '2017-04-24 21:04:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '44528566', '1', '2'),
(2422, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '43700771', '3', '1'),
(2423, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43700771', '6', '1'),
(2424, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '43700771', '11', '1'),
(2425, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '43700771', '17', '2'),
(2426, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '43700771', '13', '1'),
(2427, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '43700771', '3', '2'),
(2428, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '43700771', NULL, 'jjcervera'),
(2429, '2017-04-24 21:08:37', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43700771', NULL, '2017-04-24'),
(2430, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2431, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42466216', '6', '1'),
(2432, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42466216', '11', '1'),
(2433, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42466216', '17', '5'),
(2434, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42466216', '13', '1'),
(2435, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42466216', '3', '1'),
(2436, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42466216', NULL, 'Gabriel'),
(2437, '2017-04-24 21:12:36', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42466216', NULL, '2017-04-24'),
(2438, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42764330', '6', '1'),
(2439, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42764330', '0', '1'),
(2440, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42764330', NULL, 'Gabriel'),
(2441, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42764330', NULL, '2017-04-24'),
(2442, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42237303', '6', '1'),
(2443, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42237303', '11', '1'),
(2444, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42237303', '17', '5'),
(2445, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42237303', '13', '1'),
(2446, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42237303', '3', '1'),
(2447, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42237303', NULL, 'Gabriel'),
(2448, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42237303', NULL, '2017-04-24'),
(2449, '2017-04-24 21:12:37', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2450, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2451, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42466226', '6', '1'),
(2452, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42466226', '11', '1'),
(2453, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42466226', '17', '5'),
(2454, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42466226', '13', '1'),
(2455, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42466226', '3', '1'),
(2456, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42466226', NULL, 'Gabriel'),
(2457, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42466226', NULL, '2017-04-24'),
(2458, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42466227', '6', '1'),
(2459, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42466227', '11', '1'),
(2460, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42466227', '17', '5'),
(2461, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42466227', '13', '1'),
(2462, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42466227', '3', '1'),
(2463, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42466227', NULL, 'Gabriel'),
(2464, '2017-04-24 21:16:31', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42466227', NULL, '2017-04-24'),
(2465, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '41632059', '6', '1'),
(2466, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '41632059', '0', '1'),
(2467, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '41632059', NULL, 'Gabriel'),
(2468, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '41632059', NULL, '2017-04-24'),
(2469, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '42466223', '6', '1'),
(2470, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '42466223', '11', '1'),
(2471, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '42466223', '17', '5'),
(2472, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '42466223', '13', '1'),
(2473, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '42466223', '3', '1'),
(2474, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '42466223', NULL, 'Gabriel'),
(2475, '2017-04-24 21:16:32', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '42466223', NULL, '2017-04-24'),
(2476, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '40840179', '6', '1'),
(2477, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '40840179', '11', '1'),
(2478, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '40840179', '17', '5'),
(2479, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '40840179', '13', '1'),
(2480, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '40840179', '3', '1'),
(2481, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '40840179', NULL, 'Gabriel'),
(2482, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '40840179', NULL, '2017-04-24'),
(2483, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Cargo', '41632037', '6', '1'),
(2484, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Estado', '41632037', '11', '1'),
(2485, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Curso', '41632037', '17', '5'),
(2486, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Division', '41632037', '13', '1'),
(2487, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Id_Turno', '41632037', '3', '1'),
(2488, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Usuario', '41632037', NULL, 'Gabriel'),
(2489, '2017-04-24 21:16:33', '/sistema/personasupdate.php', 'Gabriel', 'U', 'personas', 'Fecha_Actualizacion', '41632037', NULL, '2017-04-24'),
(2490, '2017-04-24 21:16:34', '/sistema/personasupdate.php', 'Gabriel', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2491, '2017-04-24 21:21:38', '/sistema/login.php', 'admin', 'login', '90.0.0.161', '', '', '', ''),
(2492, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'NroSerie', 'AA8163016701', '', 'AA8163016701'),
(2493, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'NroMac', 'AA8163016701', '', '6C71D94DB771'),
(2494, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'SpecialNumber', 'AA8163016701', '', NULL),
(2495, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Ubicacion', 'AA8163016701', '', '2'),
(2496, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Estado', 'AA8163016701', '', '2'),
(2497, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Sit_Estado', 'AA8163016701', '', '9'),
(2498, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Marca', 'AA8163016701', '', '5'),
(2499, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Modelo', 'AA8163016701', '', '24'),
(2500, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Ano', 'AA8163016701', '', '4'),
(2501, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Tiene_Cargador', 'AA8163016701', '', 'SI'),
(2502, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Id_Tipo_Equipo', 'AA8163016701', '', '1'),
(2503, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Usuario', 'AA8163016701', '', 'Administrator'),
(2504, '2017-04-24 21:23:00', '/sistema/equiposadd.php', '-1', 'A', 'equipos', 'Fecha_Actualizacion', 'AA8163016701', '', '2017-04-24'),
(2505, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Cue_Establecimiento', '540055800', '', '540055800'),
(2506, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Nombre_Establecimiento', '540055800', '', 'B.O.P. N° 22'),
(2507, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Nombre_Directivo', '540055800', '', 'LEIVAS JORGE OSCAR'),
(2508, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Cuil_Directivo', '540055800', '', '20147750499'),
(2509, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Nombre_Rte', '540055800', '', 'CERVERA JUAN JOSÉ'),
(2510, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Tel_Rte', '540055800', '', '03757496067'),
(2511, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Email_Rte', '540055800', '', 'RTE.BOP22@GMAIL.COM'),
(2512, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Nro_Serie_Server_Escolar', '540055800', '', '0696686A055'),
(2513, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Contacto_Establecimiento', '540055800', '', NULL),
(2514, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Domicilio_Escuela', '540055800', '', '--'),
(2515, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Id_Provincia', '540055800', '', '1'),
(2516, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Id_Departamento', '540055800', '', '10'),
(2517, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Id_Localidad', '540055800', '', '36'),
(2518, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Fecha_Actualizacion', '540055800', '', '2017-04-24'),
(2519, '2017-04-24 21:26:46', '/sistema/establecimientos_educativos_paseaddopt.php', 'jjcervera', 'A', 'establecimientos_educativos_pase', 'Usuario', '540055800', '', 'jjcervera'),
(2520, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Serie_Equipo', '1', '', 'AA8163016701'),
(2521, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Id_Hardware', '1', '', '6C71D94DB771'),
(2522, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'SN', '1', '', NULL),
(2523, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Modelo_Net', '1', '', 'EXOMATE N201'),
(2524, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Marca_Arranque', '1', '', '5'),
(2525, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Nombre_Titular', '1', '', 'JARA ALDANA BELEN'),
(2526, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Dni_Titular', '1', '', '42666838'),
(2527, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Cuil_Titular', '1', '', '27426668381'),
(2528, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Nombre_Tutor', '1', '', 'GONZALEZ MARCELA'),
(2529, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'DniTutor', '1', '', '17090818'),
(2530, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Domicilio', '1', '', 'LIBERTAD'),
(2531, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Tel_Tutor', '1', '', NULL),
(2532, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'CelTutor', '1', '', NULL),
(2533, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Cue_Establecimiento_Alta', '1', '', '540176400'),
(2534, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Escuela_Alta', '1', '', 'EPET N° 33'),
(2535, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Directivo_Alta', '1', '', 'BENITEZ JULIO CESAR'),
(2536, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Cuil_Directivo_Alta', '1', '', '20162941063'),
(2537, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Dpto_Esc_alta', '1', '', 'Iguazú'),
(2538, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Localidad_Esc_Alta', '1', '', 'Puerto Libertad'),
(2539, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Domicilio_Esc_Alta', '1', '', 'RUTAN°12'),
(2540, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Rte_Alta', '1', '', 'OLMEDO RAMON'),
(2541, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Tel_Rte_Alta', '1', '', '0'),
(2542, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Email_Rte_Alta', '1', '', '0'),
(2543, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Serie_Server_Alta', '1', '', 'T002-4152000756'),
(2544, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Cue_Establecimiento_Baja', '1', '', '540055800'),
(2545, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Escuela_Baja', '1', '', 'B.O.P. N° 22'),
(2546, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Directivo_Baja', '1', '', 'LEIVAS JORGE OSCAR'),
(2547, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Cuil_Directivo_Baja', '1', '', '20147750499'),
(2548, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Dpto_Esc_Baja', '1', '', 'Iguazú'),
(2549, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Localidad_Esc_Baja', '1', '', 'Puerto Libertad'),
(2550, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Domicilio_Esc_Baja', '1', '', '--'),
(2551, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Rte_Baja', '1', '', 'CERVERA JUAN JOSÉ'),
(2552, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Tel_Rte_Baja', '1', '', '03757496067'),
(2553, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Email_Rte_Baja', '1', '', 'RTE.BOP22@GMAIL.COM'),
(2554, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Serie_Server_Baja', '1', '', '0696686A055'),
(2555, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Fecha_Pase', '1', '', '2017-04-24'),
(2556, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Id_Estado_Pase', '1', '', '2'),
(2557, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Ruta_Archivo', '1', '', NULL),
(2558, '2017-04-24 21:28:38', '/sistema/pase_establecimientoadd.php', 'jjcervera', 'A', 'pase_establecimiento', 'Id_Pase', '1', '', '1'),
(2559, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '42965485', '3', '1'),
(2560, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42965485', '6', '1'),
(2561, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '42965485', '11', '1'),
(2562, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '42965485', '17', '2'),
(2563, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '42965485', '13', '1'),
(2564, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '42965485', '3', '2'),
(2565, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '42965485', NULL, 'jjcervera'),
(2566, '2017-04-24 21:51:44', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42965485', NULL, '2017-04-24'),
(2567, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2568, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45136830', '0', '1'),
(2569, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45027501', '6', '1'),
(2570, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45027501', '11', '1'),
(2571, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45027501', '17', '2'),
(2572, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45027501', '13', '1'),
(2573, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45027501', '3', '2'),
(2574, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45027501', NULL, 'jjcervera'),
(2575, '2017-04-24 21:57:49', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45027501', NULL, '2017-04-24'),
(2576, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45027550', '6', '1'),
(2577, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45027550', '11', '1'),
(2578, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45027550', '17', '2'),
(2579, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45027550', '13', '1'),
(2580, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45027550', '3', '2'),
(2581, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45027550', NULL, 'jjcervera'),
(2582, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45027550', NULL, '2017-04-24'),
(2583, '2017-04-24 21:57:50', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2584, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2585, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45555429', '6', '1'),
(2586, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45555429', '11', '1'),
(2587, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45555429', '17', '2'),
(2588, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45555429', '13', '1'),
(2589, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45555429', '3', '2'),
(2590, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '45555429', NULL, 'jjcervera'),
(2591, '2017-04-24 22:00:34', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45555429', NULL, '2017-04-24'),
(2592, '2017-04-24 22:00:35', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2593, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2594, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43153343', '6', '1'),
(2595, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '43153343', '11', '1'),
(2596, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '43153343', '17', '2'),
(2597, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '43153343', '13', '1'),
(2598, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '43153343', '3', '2'),
(2599, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43153343', NULL, 'jjcervera'),
(2600, '2017-04-24 22:03:42', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43153343', NULL, '2017-04-24'),
(2601, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '44227758', '6', '1'),
(2602, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '44227758', '11', '1'),
(2603, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '44227758', '17', '2'),
(2604, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '44227758', '13', '1'),
(2605, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '44227758', '3', '2'),
(2606, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '44227758', NULL, 'jjcervera'),
(2607, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '44227758', NULL, '2017-04-24'),
(2608, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '43120439', '6', '1'),
(2609, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '43120439', '11', '1'),
(2610, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '43120439', '17', '2'),
(2611, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Division', '43120439', '13', '1'),
(2612, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '43120439', '3', '2'),
(2613, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Usuario', '43120439', NULL, 'jjcervera'),
(2614, '2017-04-24 22:03:43', '/sistema/personasupdate.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '43120439', NULL, '2017-04-24'),
(2615, '2017-04-24 22:03:44', '/sistema/personasupdate.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2616, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update begin ***', 'estado_actual_legajo_persona', '', '', '', ''),
(2617, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update successful ***', 'estado_actual_legajo_persona', '', '', '', ''),
(2618, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update begin ***', 'materias_adeudadas', '', '', '', ''),
(2619, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update successful ***', 'materias_adeudadas', '', '', '', ''),
(2620, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update begin ***', 'observacion_persona', '', '', '', ''),
(2621, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update successful ***', 'observacion_persona', '', '', '', ''),
(2622, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', '*** Batch update begin ***', 'equipos', '', '', '', ''),
(2623, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', 'U', 'equipos', 'Id_Estado', '6051082223', '1', '2'),
(2624, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', 'U', 'equipos', 'Id_Modelo', '6051082223', '1', '26'),
(2625, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', 'U', 'equipos', 'Id_Tipo_Equipo', '6051082223', NULL, '1'),
(2626, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', 'U', 'equipos', 'Usuario', '6051082223', NULL, 'jjcervera'),
(2627, '2017-04-24 22:23:55', '/sistema/personasedit.php', 'jjcervera', 'U', 'equipos', 'Fecha_Actualizacion', '6051082223', NULL, '2017-04-24'),
(2628, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', '*** Batch update successful ***', 'equipos', '', '', '', ''),
(2629, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', '*** Batch update begin ***', 'tutores', '', '', '', ''),
(2630, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'tutores', 'Id_Relacion', '24974378', '4', '2'),
(2631, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'tutores', 'Fecha_Actualizacion', '24974378', NULL, '2017-04-24'),
(2632, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'tutores', 'Usuario', '24974378', NULL, 'jjcervera'),
(2633, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', '*** Batch update successful ***', 'tutores', '', '', '', ''),
(2634, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '41049530', '6', '1'),
(2635, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '41049530', '11', '5'),
(2636, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '41049530', '17', '7'),
(2637, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '41049530', '3', '1'),
(2638, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '41049530', NULL, 'jjcervera'),
(2639, '2017-04-24 22:23:56', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '41049530', NULL, '2017-04-24'),
(2640, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Apellidos_Nombres', '90', 'ZARATE GABRIEL(USO ADMINISTRADOR)', 'ZARATE GABRIEL'),
(2641, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '90', '3', '1'),
(2642, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '90', '11', '6'),
(2643, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '90', '17', '10'),
(2644, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '90', '3', '1'),
(2645, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '90', NULL, 'jjcervera'),
(2646, '2017-04-24 22:29:32', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '90', NULL, '2017-04-24'),
(2647, '2017-04-24 23:32:06', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.197', '', '', '', ''),
(2648, '2017-04-25 01:42:50', '/sistema/login.php', 'jjcervera', 'login', '90.0.0.115', '', '', '', ''),
(2649, '2017-04-25 16:26:06', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2650, '2017-04-25 16:35:48', '/sistema/logout.php', 'jjcervera', 'logout', '172.16.55.7', '', '', '', ''),
(2651, '2017-04-25 16:36:02', '/sistema/login.php', 'admin', 'login', '172.16.55.7', '', '', '', ''),
(2652, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'NombreTitular', 'mpereira', '', 'PEREIRA MARGARITA'),
(2653, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Dni', 'mpereira', '', '23399095'),
(2654, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nombre', 'mpereira', '', 'mpereira'),
(2655, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Password', 'mpereira', '', '********'),
(2656, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Nivel_Usuario', 'mpereira', '', '3'),
(2657, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Curso', 'mpereira', '', '10'),
(2658, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Turno', 'mpereira', '', '2'),
(2659, '2017-04-25 16:39:26', '/sistema/usuariosadd.php', '-1', 'A', 'usuarios', 'Division', 'mpereira', '', '13'),
(2660, '2017-04-25 16:39:46', '/sistema/usuariosedit.php', '-1', 'U', 'usuarios', 'NombreTitular', 'Gabriel', 'ZARATE GABRIEL(USO ADMINISTRADOR)', NULL),
(2661, '2017-04-25 16:39:46', '/sistema/usuariosedit.php', '-1', 'U', 'usuarios', 'Nivel_Usuario', 'Gabriel', '-1', '4'),
(2662, '2017-04-25 16:40:00', '/sistema/logout.php', 'Administrator', 'logout', '172.16.55.7', '', '', '', ''),
(2663, '2017-04-25 16:40:45', '/sistema/login.php', 'mpereira', 'login', '172.16.55.7', '', '', '', ''),
(2664, '2017-04-25 17:48:46', '/sistema/logout.php', 'mpereira', 'logout', '172.16.55.7', '', '', '', ''),
(2665, '2017-04-25 17:48:59', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2666, '2017-04-25 17:49:17', '/sistema/login.php', 'mpereira', 'login', '172.16.56.3', '', '', '', ''),
(2667, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2668, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Sexo', '43700777', '3', '2');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(2669, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Cargo', '43700777', '6', '1'),
(2670, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Division', '43700777', '0', '2'),
(2671, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Usuario', '43700777', NULL, 'mpereira'),
(2672, '2017-04-25 17:51:43', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Fecha_Actualizacion', '43700777', NULL, '2017-04-25'),
(2673, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Sexo', '44072172', '3', '2'),
(2674, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Cargo', '44072172', '6', '1'),
(2675, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Estado', '44072172', '11', '1'),
(2676, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Curso', '44072172', '17', '2'),
(2677, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Division', '44072172', '13', '2'),
(2678, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Turno', '44072172', '3', '2'),
(2679, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Usuario', '44072172', NULL, 'mpereira'),
(2680, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Fecha_Actualizacion', '44072172', NULL, '2017-04-25'),
(2681, '2017-04-25 17:51:44', '/sistema/personasupdate.php', 'mpereira', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2682, '2017-04-25 17:52:51', '/sistema/personasupdate.php', 'mpereira', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2683, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Sexo', '44228283', '3', '1'),
(2684, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Division', '44228283', '0', '2'),
(2685, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Usuario', '44228283', 'jjcervera', 'mpereira'),
(2686, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Fecha_Actualizacion', '44228283', '2017-04-24', '2017-04-25'),
(2687, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Sexo', '89', '3', '1'),
(2688, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Id_Division', '89', '0', '2'),
(2689, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Usuario', '89', 'jjcervera', 'mpereira'),
(2690, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', 'U', 'personas', 'Fecha_Actualizacion', '89', '2017-04-24', '2017-04-25'),
(2691, '2017-04-25 17:52:52', '/sistema/personasupdate.php', 'mpereira', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2692, '2017-04-25 18:46:52', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2693, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '45027504', '3', '2'),
(2694, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '45027504', '6', '1'),
(2695, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '45027504', '11', '1'),
(2696, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '45027504', '17', '2'),
(2697, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45027504', '13', '3'),
(2698, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '45027504', '3', '2'),
(2699, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Usuario', '45027504', NULL, 'jjcervera'),
(2700, '2017-04-25 18:51:13', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45027504', NULL, '2017-04-25'),
(2701, '2017-04-25 19:08:29', '/sistema/personaslist.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2702, '2017-04-25 19:08:29', '/sistema/personaslist.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2703, '2017-04-25 19:56:53', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2704, '2017-04-25 19:57:26', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Descripcion', '28', '', 'EDUNEC 3'),
(2705, '2017-04-25 19:57:26', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Marca', '28', '', '13'),
(2706, '2017-04-25 19:57:26', '/sistema/modeloadd.php', 'jjcervera', 'A', 'modelo', 'Id_Modelo', '28', '', '28'),
(2707, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroSerie', 'AA9055005436', '', 'AA9055005436'),
(2708, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroMac', 'AA9055005436', '', '7427EA930DB2'),
(2709, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'SpecialNumber', 'AA9055005436', '', NULL),
(2710, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ubicacion', 'AA9055005436', '', '1'),
(2711, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Estado', 'AA9055005436', '', '1'),
(2712, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Sit_Estado', 'AA9055005436', '', '1'),
(2713, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Marca', 'AA9055005436', '', '13'),
(2714, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Modelo', 'AA9055005436', '', '28'),
(2715, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ano', 'AA9055005436', '', '7'),
(2716, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Tiene_Cargador', 'AA9055005436', '', 'SI'),
(2717, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Tipo_Equipo', 'AA9055005436', '', '1'),
(2718, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Usuario', 'AA9055005436', '', 'jjcervera'),
(2719, '2017-04-25 19:59:41', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Fecha_Actualizacion', 'AA9055005436', '', '2017-04-25'),
(2720, '2017-04-25 20:17:46', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2721, '2017-04-26 16:44:07', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2722, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '2,AA2074076234', '', '32304988'),
(2723, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '2,AA2074076234', '', 'AA2074076234'),
(2724, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '2,AA2074076234', '', '2017-04-26'),
(2725, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '2,AA2074076234', '', '3'),
(2726, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '2,AA2074076234', '', 'jjcervera'),
(2727, '2017-04-26 16:51:16', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '2,AA2074076234', '', '2'),
(2728, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2729, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '2,AA2074076234,1', '', '2'),
(2730, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '2,AA2074076234,1', '', 'AA2074076234'),
(2731, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '2,AA2074076234,1', '', '2'),
(2732, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '2,AA2074076234,1', '', '19'),
(2733, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '2,AA2074076234,1', '', 'NO SE PUEDE ACTIVAR, NO SE PUEDE CAMBIAR SERIE'),
(2734, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '2,AA2074076234,1', '', '6'),
(2735, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '2,AA2074076234,1', '', '4'),
(2736, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '2,AA2074076234,1', '', '2017-04-26'),
(2737, '2017-04-26 16:54:35', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '2,AA2074076234,1', '', '1'),
(2738, '2017-04-26 16:54:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2739, '2017-04-26 16:54:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2740, '2017-04-26 16:54:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2741, '2017-04-26 16:54:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2742, '2017-04-26 16:54:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2743, '2017-04-26 18:37:19', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2744, '2017-04-26 18:38:45', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '95339309', '0', '3'),
(2745, '2017-04-26 18:38:45', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '95339309', '2017-04-24', '2017-04-26'),
(2746, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2747, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42192571', '6', '1'),
(2748, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '42192571', '11', '1'),
(2749, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '42192571', '17', '2'),
(2750, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Division', '42192571', '13', '2'),
(2751, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '42192571', '3', '2'),
(2752, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Usuario', '42192571', NULL, 'jjcervera'),
(2753, '2017-04-26 18:41:10', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42192571', NULL, '2017-04-26'),
(2754, '2017-04-26 18:41:11', '/sistema/personaslist.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2755, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', '*** Batch update begin ***', 'personas', '', '', '', ''),
(2756, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Cargo', '42171843', '6', '1'),
(2757, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Estado', '42171843', '11', '1'),
(2758, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Curso', '42171843', '17', '2'),
(2759, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Division', '42171843', '13', '3'),
(2760, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Id_Turno', '42171843', '3', '2'),
(2761, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Usuario', '42171843', NULL, 'jjcervera'),
(2762, '2017-04-26 18:42:13', '/sistema/personaslist.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '42171843', NULL, '2017-04-26'),
(2763, '2017-04-26 18:42:14', '/sistema/personaslist.php', 'jjcervera', '*** Batch update successful ***', 'personas', '', '', '', ''),
(2764, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '3,AA2074133175', '', '42192571'),
(2765, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '3,AA2074133175', '', 'AA2074133175'),
(2766, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '3,AA2074133175', '', '2017-04-26'),
(2767, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '3,AA2074133175', '', '1'),
(2768, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '3,AA2074133175', '', 'jjcervera'),
(2769, '2017-04-26 18:53:07', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '3,AA2074133175', '', '3'),
(2770, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2771, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '3,AA2074133175,2', '', '3'),
(2772, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '3,AA2074133175,2', '', 'AA2074133175'),
(2773, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '3,AA2074133175,2', '', '2'),
(2774, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '3,AA2074133175,2', '', '17'),
(2775, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '3,AA2074133175,2', '', 'PILA MOTHER'),
(2776, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '3,AA2074133175,2', '', '1'),
(2777, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '3,AA2074133175,2', '', '7'),
(2778, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '3,AA2074133175,2', '', '2017-04-26'),
(2779, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '3,AA2074133175,2', '', '2'),
(2780, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2781, '2017-04-26 18:58:47', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2782, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2783, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2784, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Detalle', '1', '', 'SE ANOTA PEDIDO DE PILA'),
(2785, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Fecha_Actualizacion', '1', '', '2017-04-26'),
(2786, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Usuario', '1', '', 'jjcervera'),
(2787, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Atencion', '1', '', '3'),
(2788, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'NroSerie', '1', '', 'AA2074133175'),
(2789, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Historial', '1', '', '1'),
(2790, '2017-04-26 18:58:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2791, '2017-04-26 19:16:32', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2792, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'detalle_atencion', 'Id_Estado_Atenc', '2,AA2074076234,1', '4', '7'),
(2793, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2794, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2795, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2796, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2797, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Detalle', '2', '', 'RESTAURADA SOLUCIONADA'),
(2798, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Fecha_Actualizacion', '2', '', '2017-04-26'),
(2799, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Usuario', '2', '', 'jjcervera'),
(2800, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Atencion', '2', '', '2'),
(2801, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'NroSerie', '2', '', 'AA2074076234'),
(2802, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Historial', '2', '', '2'),
(2803, '2017-04-26 19:16:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2804, '2017-04-26 20:23:57', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2805, '2017-04-26 20:47:40', '/sistema/login.php', 'jjcervera', 'login', '181.88.234.91', '', '', '', ''),
(2806, '2017-04-26 20:52:40', '/sistema/login.php', 'admin', 'login', '172.16.55.1', '', '', '', ''),
(2807, '2017-04-26 20:53:07', '/sistema/ocupacion_tutoradd.php', '-1', 'A', 'ocupacion_tutor', 'Descripcion', '7', '', 'OTRO'),
(2808, '2017-04-26 20:53:07', '/sistema/ocupacion_tutoradd.php', '-1', 'A', 'ocupacion_tutor', 'Id_Ocupacion', '7', '', '7'),
(2809, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Dni_Tutor', '32435252', '', '32435252'),
(2810, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Apellidos_Nombres', '32435252', '', 'OLIVERA CARMEN ANDREA'),
(2811, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Edad', '32435252', '', NULL),
(2812, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Domicilio', '32435252', '', NULL),
(2813, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Tel_Contacto', '32435252', '', NULL),
(2814, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Fecha_Nac', '32435252', '', '1986-04-12'),
(2815, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Cuil', '32435252', '', '27324352525'),
(2816, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'MasHijos', '32435252', '', 'No'),
(2817, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Estado_Civil', '32435252', '', '4'),
(2818, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Sexo', '32435252', '', '2'),
(2819, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Relacion', '32435252', '', '2'),
(2820, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Ocupacion', '32435252', '', '7'),
(2821, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Lugar_Nacimiento', '32435252', '', NULL),
(2822, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Provincia', '32435252', '', '1'),
(2823, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Departamento', '32435252', '', '10'),
(2824, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Id_Localidad', '32435252', '', '36'),
(2825, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Fecha_Actualizacion', '32435252', '', '2017-04-26'),
(2826, '2017-04-26 20:53:57', '/sistema/tutoresadd.php', 'jjcervera', 'A', 'tutores', 'Usuario', '32435252', '', 'jjcervera'),
(2827, '2017-04-26 22:08:53', '/sistema/login.php', 'admin', 'login', '181.90.14.213', '', '', '', ''),
(2828, '2017-04-26 22:13:22', '/sistema/logout.php', 'Administrator', 'logout', '181.90.14.213', '', '', '', ''),
(2829, '2017-04-27 02:22:16', '/sistema/login.php', 'jjcervera', 'login', '190.226.199.17', '', '', '', ''),
(2830, '2017-04-27 02:40:17', '/sistema/logout.php', 'jjcervera', 'logout', '190.227.252.90', '', '', '', ''),
(2831, '2017-05-02 18:49:20', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2832, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '4,AA9184144060', '', '16279810'),
(2833, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '4,AA9184144060', '', 'AA9184144060'),
(2834, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '4,AA9184144060', '', '2017-05-02'),
(2835, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '4,AA9184144060', '', '3'),
(2836, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '4,AA9184144060', '', 'jjcervera'),
(2837, '2017-05-02 18:54:17', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '4,AA9184144060', '', '4'),
(2838, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2839, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '1,AA4074078679,3', '', '1'),
(2840, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '1,AA4074078679,3', '', 'AA4074078679'),
(2841, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '1,AA4074078679,3', '', '1'),
(2842, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '1,AA4074078679,3', '', '2'),
(2843, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '1,AA4074078679,3', '', 'PILA MOTHER'),
(2844, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '1,AA4074078679,3', '', '11'),
(2845, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '1,AA4074078679,3', '', '3'),
(2846, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '1,AA4074078679,3', '', '2017-05-02'),
(2847, '2017-05-02 18:55:24', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '1,AA4074078679,3', '', '3'),
(2848, '2017-05-02 18:55:25', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2849, '2017-05-02 18:55:25', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2850, '2017-05-02 18:55:25', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2851, '2017-05-02 18:55:25', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2852, '2017-05-02 18:55:25', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2853, '2017-05-09 18:45:31', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2854, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '5,AA9184140410', '', '24903013'),
(2855, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '5,AA9184140410', '', 'AA9184140410'),
(2856, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '5,AA9184140410', '', '2017-05-09'),
(2857, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '5,AA9184140410', '', '1'),
(2858, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '5,AA9184140410', '', 'jjcervera'),
(2859, '2017-05-09 18:48:34', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '5,AA9184140410', '', '5'),
(2860, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '6,AA9184140410', '', '24903013'),
(2861, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '6,AA9184140410', '', 'AA9184140410'),
(2862, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '6,AA9184140410', '', '2017-05-09'),
(2863, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '6,AA9184140410', '', '1'),
(2864, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '6,AA9184140410', '', 'jjcervera'),
(2865, '2017-05-09 18:51:49', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '6,AA9184140410', '', '6'),
(2866, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2867, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '6,AA9184140410,4', '', '6'),
(2868, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '6,AA9184140410,4', '', 'AA9184140410'),
(2869, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '6,AA9184140410,4', '', '2'),
(2870, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '6,AA9184140410,4', '', '2'),
(2871, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '6,AA9184140410,4', '', 'dgsddsfg'),
(2872, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '6,AA9184140410,4', '', '1'),
(2873, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '6,AA9184140410,4', '', '4'),
(2874, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '6,AA9184140410,4', '', '2017-05-09'),
(2875, '2017-05-09 18:58:32', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '6,AA9184140410,4', '', '4'),
(2876, '2017-05-09 18:58:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2877, '2017-05-09 18:58:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2878, '2017-05-09 18:58:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2879, '2017-05-09 18:58:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2880, '2017-05-09 18:58:33', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2881, '2017-05-17 09:40:12', '/sistema/login.php', 'Gabriel', 'login', '127.0.0.1', '', '', '', ''),
(2882, '2017-05-17 09:40:20', '/sistema/logout.php', 'Gabriel', 'logout', '127.0.0.1', '', '', '', ''),
(2883, '2017-05-17 09:41:11', '/sistema/login.php', 'jjcervera', 'login', '127.0.0.1', '', '', '', ''),
(2884, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2885, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '6,AA9184140410,1', '', '6'),
(2886, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '6,AA9184140410,1', '', 'AA9184140410'),
(2887, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '6,AA9184140410,1', '', '2'),
(2888, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '6,AA9184140410,1', '', '2'),
(2889, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '6,AA9184140410,1', '', 'test'),
(2890, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '6,AA9184140410,1', '', '1'),
(2891, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '6,AA9184140410,1', '', '4'),
(2892, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '6,AA9184140410,1', '', '2017-05-17'),
(2893, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '6,AA9184140410,1', '', '1'),
(2894, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2895, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2896, '2017-05-17 09:41:52', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2897, '2017-05-17 09:41:53', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2898, '2017-05-17 09:41:53', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2899, '2017-05-17 22:34:25', '/sistema/login.php', 'jjcervera', 'login', '127.0.0.1', '', '', '', ''),
(2900, '2017-05-17 22:35:12', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2901, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2902, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2903, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2904, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2905, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Detalle', '1', '', 'sgsrsg'),
(2906, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Fecha_Actualizacion', '1', '', '2017-05-17'),
(2907, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Usuario', '1', '', 'jjcervera'),
(2908, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Atencion', '1', '', '6'),
(2909, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'NroSerie', '1', '', 'AA9184140410'),
(2910, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Historial', '1', '', '1'),
(2911, '2017-05-17 22:35:13', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2912, '2017-05-19 16:12:43', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2913, '2017-05-19 16:39:18', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2914, '2017-05-19 19:43:36', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2915, '2017-05-19 19:45:45', '/sistema/dato_establecimientolist.php', 'jjcervera', '*** Batch update begin ***', 'dato_establecimiento', '', '', '', ''),
(2916, '2017-05-19 19:45:45', '/sistema/dato_establecimientolist.php', 'jjcervera', 'U', 'dato_establecimiento', 'Nro_Cuise', '540055800', NULL, '540055800'),
(2917, '2017-05-19 19:45:45', '/sistema/dato_establecimientolist.php', 'jjcervera', 'U', 'dato_establecimiento', 'Cantidad_Aulas', '540055800', NULL, '9'),
(2918, '2017-05-19 19:45:45', '/sistema/dato_establecimientolist.php', 'jjcervera', 'U', 'dato_establecimiento', 'Fecha_Actualizacion', '540055800', '2017-04-23', '2017-05-19'),
(2919, '2017-05-19 19:45:45', '/sistema/dato_establecimientolist.php', 'jjcervera', 'U', 'dato_establecimiento', 'Usuario', '540055800', 'Administrator', 'jjcervera'),
(2920, '2017-05-19 19:45:46', '/sistema/dato_establecimientolist.php', 'jjcervera', '*** Batch update successful ***', 'dato_establecimiento', '', '', '', ''),
(2921, '2017-05-19 22:50:48', '/sistema/login.php', 'jjcervera', 'login', '181.90.76.51', '', '', '', ''),
(2922, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', '*** Batch delete begin ***', 'atencion_equipos', '', '', '', ''),
(2923, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Id_Atencion', '6,AA9184140410', '6', ''),
(2924, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'NroSerie', '6,AA9184140410', 'AA9184140410', ''),
(2925, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Fecha_Entrada', '6,AA9184140410', '2017-05-09', ''),
(2926, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Id_Prioridad', '6,AA9184140410', '1', ''),
(2927, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Usuario', '6,AA9184140410', 'jjcervera', ''),
(2928, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Dni', '6,AA9184140410', '24903013', ''),
(2929, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Id_Atencion', '5,AA9184140410', '5', ''),
(2930, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'NroSerie', '5,AA9184140410', 'AA9184140410', ''),
(2931, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Fecha_Entrada', '5,AA9184140410', '2017-05-09', ''),
(2932, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Id_Prioridad', '5,AA9184140410', '1', ''),
(2933, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Usuario', '5,AA9184140410', 'jjcervera', ''),
(2934, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', 'D', 'atencion_equipos', 'Dni', '5,AA9184140410', '24903013', ''),
(2935, '2017-05-19 22:51:04', '/sistema/atencion_equiposdelete.php', 'jjcervera', '*** Batch delete successful ***', 'atencion_equipos', '', '', '', ''),
(2936, '2017-05-20 02:24:54', '/sistema/login.php', 'jjcervera', 'login', '181.110.75.14', '', '', '', ''),
(2937, '2017-05-20 18:25:10', '/sistema/login.php', 'jjcervera', 'login', '181.91.100.5', '', '', '', ''),
(2938, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '4,AA9184144060,2', '', '2'),
(2939, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '4,AA9184144060,2', '', '2'),
(2940, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '4,AA9184144060,2', '', 'Problema PILA'),
(2941, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '4,AA9184144060,2', '', '1'),
(2942, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '4,AA9184144060,2', '', '7'),
(2943, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '4,AA9184144060,2', '', '2017-05-20'),
(2944, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '4,AA9184144060,2', '', '4'),
(2945, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '4,AA9184144060,2', '', 'AA9184144060'),
(2946, '2017-05-20 18:27:54', '/sistema/detalle_atencionadd.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '4,AA9184144060,2', '', '2'),
(2947, '2017-05-22 17:19:38', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(2948, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '7,AA4074071743', '', '45027501'),
(2949, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '7,AA4074071743', '', 'AA4074071743'),
(2950, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '7,AA4074071743', '', '2017-05-22'),
(2951, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '7,AA4074071743', '', '1'),
(2952, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '7,AA4074071743', '', 'jjcervera'),
(2953, '2017-05-22 17:25:47', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '7,AA4074071743', '', '7'),
(2954, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2955, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '7,AA4074071743,3', '', '7'),
(2956, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '7,AA4074071743,3', '', 'AA4074071743'),
(2957, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '7,AA4074071743,3', '', '2'),
(2958, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '7,AA4074071743,3', '', '2'),
(2959, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '7,AA4074071743,3', '', 'bloqueada'),
(2960, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '7,AA4074071743,3', '', '1'),
(2961, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '7,AA4074071743,3', '', '3'),
(2962, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '7,AA4074071743,3', '', '2017-05-22'),
(2963, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '7,AA4074071743,3', '', '3'),
(2964, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2965, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2966, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2967, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2968, '2017-05-22 17:28:14', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2969, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '8,AA7184070766', '', '18266673'),
(2970, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '8,AA7184070766', '', 'AA7184070766'),
(2971, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '8,AA7184070766', '', '2017-05-22'),
(2972, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '8,AA7184070766', '', '1'),
(2973, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '8,AA7184070766', '', 'jjcervera'),
(2974, '2017-05-22 17:57:55', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '8,AA7184070766', '', '8'),
(2975, '2017-05-22 18:08:39', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2976, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(2977, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '8,AA7184070766,4', '', '8'),
(2978, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '8,AA7184070766,4', '', 'AA7184070766'),
(2979, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '8,AA7184070766,4', '', '2'),
(2980, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '8,AA7184070766,4', '', '2'),
(2981, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '8,AA7184070766,4', '', 'desbloqueo'),
(2982, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '8,AA7184070766,4', '', '1'),
(2983, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '8,AA7184070766,4', '', '7'),
(2984, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '8,AA7184070766,4', '', '2017-05-22'),
(2985, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '8,AA7184070766,4', '', '4'),
(2986, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(2987, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(2988, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(2989, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(2990, '2017-05-22 18:09:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(2991, '2017-05-22 18:12:28', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2992, '2017-05-22 19:15:45', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(2993, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '9,AA4074072458', '', '49278992'),
(2994, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '9,AA4074072458', '', 'AA4074072458'),
(2995, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '9,AA4074072458', '', '2017-05-22'),
(2996, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '9,AA4074072458', '', '1'),
(2997, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '9,AA4074072458', '', 'jjcervera'),
(2998, '2017-05-22 19:16:41', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '9,AA4074072458', '', '9'),
(2999, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3000, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '9,AA4074072458,5', '', '9'),
(3001, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '9,AA4074072458,5', '', 'AA4074072458'),
(3002, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '9,AA4074072458,5', '', '1'),
(3003, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '9,AA4074072458,5', '', '8'),
(3004, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '9,AA4074072458,5', '', 'DISCO DAÑADO'),
(3005, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '9,AA4074072458,5', '', '7'),
(3006, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '9,AA4074072458,5', '', '1'),
(3007, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '9,AA4074072458,5', '', '2017-05-22'),
(3008, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '9,AA4074072458,5', '', '5'),
(3009, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3010, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3011, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3012, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3013, '2017-05-22 19:17:34', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3014, '2017-05-23 16:50:12', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3015, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3016, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'detalle_atencion', 'Fecha_Actualizacion', '9,AA4074072458,5', '2017-05-22', '2017-05-23'),
(3017, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3018, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3019, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Atencion', '9,AA4074072458', '', '9'),
(3020, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'NroSerie', '9,AA4074072458', '', 'AA4074072458'),
(3021, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Nro_Tiket', '9,AA4074072458', '', '1484806');
INSERT INTO `audittrail` (`id`, `datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`) VALUES
(3022, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Tipo_Retiro', '9,AA4074072458', '', '1'),
(3023, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Referencia_Tipo_Retiro', '9,AA4074072458', '', NULL),
(3024, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Fecha_Retiro', '9,AA4074072458', '', NULL),
(3025, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Observacion', '9,AA4074072458', '', NULL),
(3026, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Fecha_Devolucion', '9,AA4074072458', '', NULL),
(3027, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3028, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3029, '2017-05-23 16:54:05', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3030, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3031, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3032, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3033, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3034, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3035, '2017-05-23 16:58:28', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3036, '2017-05-23 18:29:54', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3037, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroSerie', 'AA2074100035', '', 'AA2074100035'),
(3038, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroMac', 'AA2074100035', '', '7427EA979F46'),
(3039, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'SpecialNumber', 'AA2074100035', '', NULL),
(3040, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ubicacion', 'AA2074100035', '', '1'),
(3041, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Estado', 'AA2074100035', '', '1'),
(3042, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Sit_Estado', 'AA2074100035', '', '1'),
(3043, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Marca', 'AA2074100035', '', '2'),
(3044, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Modelo', 'AA2074100035', '', '22'),
(3045, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ano', 'AA2074100035', '', '6'),
(3046, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Tiene_Cargador', 'AA2074100035', '', 'SI'),
(3047, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Tipo_Equipo', 'AA2074100035', '', '1'),
(3048, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Usuario', 'AA2074100035', '', 'jjcervera'),
(3049, '2017-05-23 19:17:05', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Fecha_Actualizacion', 'AA2074100035', '', '2017-05-23'),
(3050, '2017-05-23 19:43:29', '/sistema/login.php', 'superadmin', 'login', '127.0.0.1', '', '', '', ''),
(3051, '2017-05-23 19:49:28', '/sistema/ocupacion_tutoradd.php', 'superadmin', 'A', 'ocupacion_tutor', 'Descripcion', '7', '', 'OTRO'),
(3052, '2017-05-23 19:49:28', '/sistema/ocupacion_tutoradd.php', 'superadmin', 'A', 'ocupacion_tutor', 'Id_Ocupacion', '7', '', '7'),
(3053, '2017-05-23 22:17:02', '/sistema/login.php', 'superadmin', 'login', '190.228.216.38', '', '', '', ''),
(3054, '2017-05-23 22:34:48', '/sistema/login.php', 'superadmin', 'login', '181.88.216.54', '', '', '', ''),
(3055, '2017-05-23 22:35:48', '/sistema/usuarioslist.php', 'superadmin', '*** Batch update begin ***', 'usuarios', '', '', '', ''),
(3056, '2017-05-23 22:35:48', '/sistema/usuarioslist.php', 'superadmin', 'U', 'usuarios', 'NombreTitular', 'mpereira', 'PEREIRA MARGARITA', NULL),
(3057, '2017-05-23 22:35:48', '/sistema/usuarioslist.php', 'superadmin', 'U', 'usuarios', 'NombreTitular', 'superadmin', 'super', NULL),
(3058, '2017-05-23 22:35:48', '/sistema/usuarioslist.php', 'superadmin', 'U', 'usuarios', 'Division', 'superadmin', '1', '13'),
(3059, '2017-05-23 22:35:48', '/sistema/usuarioslist.php', 'superadmin', '*** Batch update successful ***', 'usuarios', '', '', '', ''),
(3060, '2017-05-23 22:37:10', '/sistema/logout.php', 'superadmin', 'logout', '181.88.216.54', '', '', '', ''),
(3061, '2017-05-23 22:41:26', '/sistema/login.php', 'jjcervera', 'login', '181.88.216.54', '', '', '', ''),
(3062, '2017-05-23 23:36:33', '/sistema/logout.php', 'jjcervera', 'logout', '190.228.216.38', '', '', '', ''),
(3063, '2017-05-23 23:37:02', '/sistema/login.php', 'jjcervera', 'login', '190.228.216.38', '', '', '', ''),
(3064, '2017-05-24 12:57:49', '/sistema/login.php', 'jjcervera', 'login', '200.112.130.163', '', '', '', ''),
(3065, '2017-05-24 13:24:32', '/sistema/login.php', 'jjcervera', 'login', '200.112.130.163', '', '', '', ''),
(3066, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3067, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'detalle_atencion', 'Fecha_Actualizacion', '9,AA4074072458,5', '2017-05-23', '2017-05-24'),
(3068, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3069, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3070, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3071, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3072, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'historial_atencion', 'Fecha_Actualizacion', '2', '2017-05-23', '2017-05-24'),
(3073, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete begin ***', 'historial_atencion', '', '', '', ''),
(3074, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Historial', '3', '3', ''),
(3075, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Detalle', '3', 'Esperando retiro P/Servicio Tecnico', ''),
(3076, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Fecha_Actualizacion', '3', '2017-05-23', ''),
(3077, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Usuario', '3', 'jjcervera', ''),
(3078, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Atencion', '3', '9', ''),
(3079, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'NroSerie', '3', 'AA4074072458', ''),
(3080, '2017-05-24 13:27:44', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete successful ***', 'historial_atencion', '', '', '', ''),
(3081, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete begin ***', 'historial_atencion', '', '', '', ''),
(3082, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Historial', '4', '4', ''),
(3083, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Detalle', '4', 'Esperando retiro P/Servicio Tecnico', ''),
(3084, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Fecha_Actualizacion', '4', '2017-05-23', ''),
(3085, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Usuario', '4', 'jjcervera', ''),
(3086, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Atencion', '4', '9', ''),
(3087, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'NroSerie', '4', 'AA4074072458', ''),
(3088, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete successful ***', 'historial_atencion', '', '', '', ''),
(3089, '2017-05-24 13:27:45', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3090, '2017-05-24 14:00:51', '/sistema/login.php', 'jjcervera', 'login', '190.228.216.38', '', '', '', ''),
(3091, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Dni', '10,AA4074068053', '', '27289607'),
(3092, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'NroSerie', '10,AA4074068053', '', 'AA4074068053'),
(3093, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Fecha_Entrada', '10,AA4074068053', '', '2017-05-24'),
(3094, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Prioridad', '10,AA4074068053', '', '1'),
(3095, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Usuario', '10,AA4074068053', '', 'jjcervera'),
(3096, '2017-05-24 14:04:21', '/sistema/atencion_equiposadd.php', 'jjcervera', 'A', 'atencion_equipos', 'Id_Atencion', '10,AA4074068053', '', '10'),
(3097, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3098, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '10,AA4074068053,6', '', '10'),
(3099, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '10,AA4074068053,6', '', 'AA4074068053'),
(3100, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '10,AA4074068053,6', '', '1'),
(3101, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '10,AA4074068053,6', '', '15'),
(3102, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '10,AA4074068053,6', '', 'test cambio de estados ST'),
(3103, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '10,AA4074068053,6', '', '7'),
(3104, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '10,AA4074068053,6', '', '1'),
(3105, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '10,AA4074068053,6', '', '2017-05-24'),
(3106, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '10,AA4074068053,6', '', '6'),
(3107, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3108, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3109, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3110, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3111, '2017-05-24 14:05:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3112, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3113, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3114, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3115, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Atencion', '10,AA4074068053', '', '10'),
(3116, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'NroSerie', '10,AA4074068053', '', 'AA4074068053'),
(3117, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Nro_Tiket', '10,AA4074068053', '', '0000123'),
(3118, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Tipo_Retiro', '10,AA4074068053', '', '1'),
(3119, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Referencia_Tipo_Retiro', '10,AA4074068053', '', NULL),
(3120, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Fecha_Retiro', '10,AA4074068053', '', NULL),
(3121, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Observacion', '10,AA4074068053', '', NULL),
(3122, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'atencion_para_st', 'Fecha_Devolucion', '10,AA4074068053', '', NULL),
(3123, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3124, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3125, '2017-05-24 14:07:22', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3126, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3127, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete begin ***', 'detalle_atencion', '', '', '', ''),
(3128, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Detalle_Atencion', '10,AA4074068053,6', '6', ''),
(3129, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Tipo_Falla', '10,AA4074068053,6', '1', ''),
(3130, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Problema', '10,AA4074068053,6', '15', ''),
(3131, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Descripcion_Problema', '10,AA4074068053,6', 'test cambio de estados ST', ''),
(3132, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '10,AA4074068053,6', '7', ''),
(3133, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Estado_Atenc', '10,AA4074068053,6', '1', ''),
(3134, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Fecha_Actualizacion', '10,AA4074068053,6', '2017-05-24', ''),
(3135, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'Id_Atencion', '10,AA4074068053,6', '10', ''),
(3136, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'detalle_atencion', 'NroSerie', '10,AA4074068053,6', 'AA4074068053', ''),
(3137, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete successful ***', 'detalle_atencion', '', '', '', ''),
(3138, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3139, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3140, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete begin ***', 'atencion_para_st', '', '', '', ''),
(3141, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Nro_Tiket', '10,AA4074068053', '0000123', ''),
(3142, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Fecha_Retiro', '10,AA4074068053', NULL, ''),
(3143, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Observacion', '10,AA4074068053', NULL, ''),
(3144, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Id_Tipo_Retiro', '10,AA4074068053', '1', ''),
(3145, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Referencia_Tipo_Retiro', '10,AA4074068053', NULL, ''),
(3146, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Fecha_Devolucion', '10,AA4074068053', NULL, ''),
(3147, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'Id_Atencion', '10,AA4074068053', '10', ''),
(3148, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'atencion_para_st', 'NroSerie', '10,AA4074068053', 'AA4074068053', ''),
(3149, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete successful ***', 'atencion_para_st', '', '', '', ''),
(3150, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3151, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3152, '2017-05-24 14:11:48', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3153, '2017-05-24 19:32:26', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3154, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3155, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', 'U', 'atencion_para_st', 'Id_Tipo_Retiro', '9,AA4074072458', '1', '3'),
(3156, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', 'U', 'atencion_para_st', 'Referencia_Tipo_Retiro', '9,AA4074072458', NULL, 'st99'),
(3157, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', 'U', 'atencion_para_st', 'Fecha_Retiro', '9,AA4074072458', NULL, '1950-05-25'),
(3158, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', 'U', 'atencion_para_st', 'Observacion', '9,AA4074072458', NULL, 'nada'),
(3159, '2017-05-24 19:42:48', '/sistema/atencion_para_stlist.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3160, '2017-05-24 19:44:48', '/sistema/atencion_para_stlist.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3161, '2017-05-24 19:44:48', '/sistema/atencion_para_stlist.php', 'jjcervera', 'U', 'atencion_para_st', 'Fecha_Retiro', '9,AA4074072458', '1950-05-25', '2017-05-25'),
(3162, '2017-05-24 19:44:48', '/sistema/atencion_para_stlist.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3163, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3164, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3165, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3166, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3167, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3168, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Detalle', '5', '', 'Retirada por ST'),
(3169, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Fecha_Actualizacion', '5', '', '2017-05-24'),
(3170, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Usuario', '5', '', 'jjcervera'),
(3171, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Atencion', '5', '', '9'),
(3172, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'NroSerie', '5', '', 'AA4074072458'),
(3173, '2017-05-24 19:48:55', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Historial', '5', '', '5'),
(3174, '2017-05-24 19:48:56', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3175, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3176, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3177, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3178, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3179, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3180, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete begin ***', 'historial_atencion', '', '', '', ''),
(3181, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Historial', '5', '5', ''),
(3182, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Detalle', '5', 'Retirada por ST', ''),
(3183, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Fecha_Actualizacion', '5', '2017-05-24', ''),
(3184, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Usuario', '5', 'jjcervera', ''),
(3185, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'Id_Atencion', '5', '9', ''),
(3186, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', 'D', 'historial_atencion', 'NroSerie', '5', 'AA4074072458', ''),
(3187, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch delete successful ***', 'historial_atencion', '', '', '', ''),
(3188, '2017-05-24 19:50:04', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3189, '2017-05-29 19:44:44', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3190, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3191, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Atencion', '10,AA4074068053,7', '', '10'),
(3192, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'NroSerie', '10,AA4074068053,7', '', 'AA4074068053'),
(3193, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Falla', '10,AA4074068053,7', '', '1'),
(3194, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Problema', '10,AA4074068053,7', '', '15'),
(3195, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Descripcion_Problema', '10,AA4074068053,7', '', 'TEST'),
(3196, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Tipo_Sol_Problem', '10,AA4074068053,7', '', '7'),
(3197, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Estado_Atenc', '10,AA4074068053,7', '', '1'),
(3198, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Fecha_Actualizacion', '10,AA4074068053,7', '', '2017-05-29'),
(3199, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', 'A', 'detalle_atencion', 'Id_Detalle_Atencion', '10,AA4074068053,7', '', '7'),
(3200, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3201, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3202, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3203, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3204, '2017-05-29 19:46:06', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3205, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3206, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'detalle_atencion', 'Descripcion_Problema', '10,AA4074068053,7', 'TEST', 'TEST1'),
(3207, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3208, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3209, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3210, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3211, '2017-05-29 19:52:54', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', ''),
(3212, '2017-05-29 20:07:30', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3213, '2017-05-29 20:07:30', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update rollback ***', 'detalle_atencion', '', '', '', ''),
(3214, '2017-05-29 20:07:50', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3215, '2017-05-29 20:07:50', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update rollback ***', 'detalle_atencion', '', '', '', ''),
(3216, '2017-05-29 20:11:00', '/sistema2/atencion_para_stedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Fecha_Devolucion', '9,AA4074072458', NULL, '2017-05-31'),
(3217, '2017-05-29 20:34:41', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3218, '2017-05-29 20:34:41', '/sistema2/atencion_equiposedit.php', 'jjcervera', '*** Batch update rollback ***', 'detalle_atencion', '', '', '', ''),
(3219, '2017-06-01 20:06:43', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3220, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'NroSerie', '10,AA4074068053', '', 'AA4074068053'),
(3221, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Nro_Tiket', '10,AA4074068053', '', 'PENDIENTE'),
(3222, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Tipo_Retiro', '10,AA4074068053', '', '1'),
(3223, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Referencia_Tipo_Retiro', '10,AA4074068053', '', NULL),
(3224, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Fecha_Retiro', '10,AA4074068053', '', NULL),
(3225, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Observacion', '10,AA4074068053', '', NULL),
(3226, '2017-06-01 20:08:09', '/sistema/atencion_para_stadd.php', 'jjcervera', 'A', 'atencion_para_st', 'Id_Atencion', '10,AA4074068053', '', '10'),
(3227, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'Detalle', '7', '', 'RECEPCIONADO PARA ST'),
(3228, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'Fecha_Actualizacion', '7', '', '2017-06-01'),
(3229, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'Usuario', '7', '', 'jjcervera'),
(3230, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Atencion', '7', '', '10'),
(3231, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'NroSerie', '7', '', 'AA4074068053'),
(3232, '2017-06-01 20:08:44', '/sistema/historial_atencionadd.php', 'jjcervera', 'A', 'historial_atencion', 'Id_Historial', '7', '', '7'),
(3233, '2017-06-01 20:12:35', '/sistema/logout.php', 'jjcervera', 'logout', '172.16.55.1', '', '', '', ''),
(3234, '2017-06-01 20:14:04', '/sistema/login.php', 'superadmin', 'login', '172.16.55.1', '', '', '', ''),
(3235, '2017-06-01 20:16:58', '/sistema/usuariosedit.php', 'superadmin', 'U', 'usuarios', 'Division', 'jjcervera', '13', NULL),
(3236, '2017-06-01 20:17:13', '/sistema/usuariosedit.php', 'superadmin', 'U', 'usuarios', 'Division', 'Gabriel', '13', NULL),
(3237, '2017-06-02 16:43:06', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.7', '', '', '', ''),
(3238, '2017-06-02 18:22:37', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3239, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroSerie', 'AA9315000410', '', 'AA9315000410'),
(3240, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'NroMac', 'AA9315000410', '', 'B8AEED019FBB'),
(3241, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'SpecialNumber', 'AA9315000410', '', NULL),
(3242, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ubicacion', 'AA9315000410', '', '1'),
(3243, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Estado', 'AA9315000410', '', '1'),
(3244, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Sit_Estado', 'AA9315000410', '', '1'),
(3245, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Marca', 'AA9315000410', '', '3'),
(3246, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Modelo', 'AA9315000410', '', '3'),
(3247, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Ano', 'AA9315000410', '', '7'),
(3248, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Tiene_Cargador', 'AA9315000410', '', 'SI'),
(3249, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Id_Tipo_Equipo', 'AA9315000410', '', '1'),
(3250, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Usuario', 'AA9315000410', '', 'jjcervera'),
(3251, '2017-06-02 18:23:38', '/sistema/equiposadd.php', 'jjcervera', 'A', 'equipos', 'Fecha_Actualizacion', 'AA9315000410', '', '2017-06-02'),
(3252, '2017-06-02 19:38:09', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3253, '2017-06-02 19:40:27', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Sexo', '45133212', '3', '2'),
(3254, '2017-06-02 19:40:27', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Id_Division', '45133212', '0', '2'),
(3255, '2017-06-02 19:40:27', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Dni_Tutor', '45133212', '14755049', '32435252'),
(3256, '2017-06-02 19:40:27', '/sistema/personasedit.php', 'jjcervera', 'U', 'personas', 'Fecha_Actualizacion', '45133212', '2017-04-24', '2017-06-02'),
(3257, '2017-06-05 16:25:13', '/sistema/login.php', 'jjcervera', 'login', '172.16.55.1', '', '', '', ''),
(3258, '2017-06-06 18:11:17', '/sistema/login.php', 'jjcervera', 'login', '186.153.69.65', '', '', '', ''),
(3259, '2017-06-06 18:13:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'detalle_atencion', '', '', '', ''),
(3260, '2017-06-06 18:13:36', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'detalle_atencion', 'Fecha_Actualizacion', '10,AA4074068053,7', '2017-05-29', '2017-06-06'),
(3261, '2017-06-06 18:13:36', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'detalle_atencion', '', '', '', ''),
(3262, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'atencion_para_st', '', '', '', ''),
(3263, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Nro_Tiket', '10,AA4074068053', 'PENDIENTE', '345345'),
(3264, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Id_Tipo_Retiro', '10,AA4074068053', '1', '3'),
(3265, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Referencia_Tipo_Retiro', '10,AA4074068053', NULL, '9999'),
(3266, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Fecha_Retiro', '10,AA4074068053', NULL, '2017-06-23'),
(3267, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'atencion_para_st', 'Observacion', '10,AA4074068053', NULL, 'nada'),
(3268, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'atencion_para_st', '', '', '', ''),
(3269, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update begin ***', 'historial_atencion', '', '', '', ''),
(3270, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', 'U', 'historial_atencion', 'Fecha_Actualizacion', '7', '2017-06-01', '2017-06-06'),
(3271, '2017-06-06 18:13:37', '/sistema/atencion_equiposedit.php', 'jjcervera', '*** Batch update successful ***', 'historial_atencion', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `autoridades_escolares`
--

CREATE TABLE `autoridades_escolares` (
  `Id_Autoridad` int(11) NOT NULL,
  `Apellido_Nombre` varchar(200) DEFAULT NULL,
  `Id_Cargo` int(11) NOT NULL,
  `Cuil` varchar(100) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `Maill` varchar(100) DEFAULT NULL,
  `Id_Turno` int(11) NOT NULL,
  `Cue` varchar(100) NOT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `buscador_alumnos`
--
CREATE TABLE `buscador_alumnos` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Id_Atencion` int(11)
,`NroSerie` varchar(30)
,`Detalle` varchar(500)
,`Fecha_Actualizacion` date
,`Usuario` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `cargo_autoridad`
--

CREATE TABLE `cargo_autoridad` (
  `Id_Cargo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cargo_autoridad`
--

INSERT INTO `cargo_autoridad` (`Id_Cargo`, `Descripcion`) VALUES
(1, 'Director/a'),
(2, 'Vice Director/a'),
(3, 'Secretario');

-- --------------------------------------------------------

--
-- Table structure for table `cargo_persona`
--

CREATE TABLE `cargo_persona` (
  `Id_Cargo` int(10) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cargo_persona`
--

INSERT INTO `cargo_persona` (`Id_Cargo`, `Nombre`) VALUES
(1, 'ALUMNO'),
(2, 'DOCENTE'),
(3, 'DIRECTIVO'),
(4, 'PRECEPTOR'),
(5, 'ADMINISTRATIVO/A'),
(6, 'RTE'),
(7, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `Orden` int(11) NOT NULL,
  `Usuario` varchar(160) DEFAULT NULL,
  `Texto_Chat` varchar(500) DEFAULT NULL,
  `Hora` time DEFAULT NULL,
  `Estado` varchar(100) DEFAULT NULL,
  `Nro_Conversacion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `conversaciones`
--

CREATE TABLE `conversaciones` (
  `Nro_Conversacion` int(11) NOT NULL,
  `Usuario_1` varchar(160) DEFAULT NULL,
  `Usuario_2` varchar(200) DEFAULT NULL,
  `Fecha_Hora` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cursos`
--

CREATE TABLE `cursos` (
  `Id_Curso` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cursos`
--

INSERT INTO `cursos` (`Id_Curso`, `Descripcion`) VALUES
(1, '1'),
(2, '2'),
(3, '3'),
(4, '4'),
(5, '5'),
(6, '6'),
(7, 'EGRESOS'),
(8, 'ABANDONOS'),
(9, 'PASES'),
(10, 'PERSONAL '),
(17, 'OTRO');

-- --------------------------------------------------------

--
-- Stand-in structure for view `datosdirectivos`
--
CREATE TABLE `datosdirectivos` (
`Apellido_Nombre` varchar(200)
,`Cuil` varchar(100)
,`Telefono` int(11)
,`Celular` int(11)
,`Maill` varchar(100)
,`Fecha_Actualizacion` date
,`Cue` varchar(100)
,`Sigla` varchar(100)
,`Id_Zona` int(11)
,`Id_Cargo` int(11)
,`Id_Turno` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `datosestablecimiento`
--
CREATE TABLE `datosestablecimiento` (
`CUE` varchar(100)
,`Establecimiento` varchar(100)
,`Domicilio` varchar(200)
,`Telefono` varchar(100)
,`Mail` varchar(200)
,`Nro Matricula` int(11)
,`Cantidad Aulas` int(11)
,`Comparte Edificio` varchar(50)
,`Sigla` varchar(100)
,`Id_Departamento` int(11)
,`Id_Localidad` int(11)
,`Cantidad_Turnos` int(11)
,`Geolocalizacion` varchar(300)
,`Id_Tipo_Esc` varchar(100)
,`Universo` varchar(100)
,`Tiene_Programa` varchar(50)
,`Sector` varchar(200)
,`Cantidad_Netbook_Conig` int(11)
,`Nro_Cuise` int(11)
,`Id_Nivel` varchar(300)
,`Id_Jornada` varchar(300)
,`Tipo_Zona` varchar(100)
,`Id_Estado_Esc` int(11)
,`Id_Zona` int(11)
,`Cantidad_Netbook_Actuales` int(11)
,`Fecha_Actualizacion` date
,`Usuario` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `datosextrasescuela`
--
CREATE TABLE `datosextrasescuela` (
`Cue` varchar(100)
,`Usuario_Conig` varchar(200)
,`Password_Conig` varchar(200)
,`Tiene_Internet` varchar(100)
,`Servicio_Internet` varchar(100)
,`Estado_Internet` int(11)
,`Quien_Paga` varchar(200)
,`Sigla` varchar(100)
,`Id_Zona` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `datosservidor`
--
CREATE TABLE `datosservidor` (
`Cue` varchar(100)
,`Nro_Serie` varchar(100)
,`SN` varchar(200)
,`Cant_Net_Asoc` int(11)
,`User_Server` varchar(100)
,`Pass_Server` varchar(200)
,`User_TdServer` varchar(100)
,`Pass_TdServer` varchar(200)
,`Fecha_Actualizacion` date
,`Id_Marca` int(11)
,`Id_SO` int(11)
,`Id_Estado` int(11)
,`Id_Modelo` int(11)
,`Usuario` varchar(100)
,`Sigla` varchar(100)
,`Id_Zona` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `datos_extras_escuela`
--

CREATE TABLE `datos_extras_escuela` (
  `Cue` varchar(100) NOT NULL,
  `Usuario_Conig` varchar(200) DEFAULT NULL,
  `Password_Conig` varchar(200) DEFAULT NULL,
  `Tiene_Internet` varchar(100) DEFAULT NULL,
  `Servicio_Internet` varchar(100) DEFAULT NULL,
  `Estado_Internet` int(11) DEFAULT NULL,
  `Quien_Paga` varchar(200) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dato_establecimiento`
--

CREATE TABLE `dato_establecimiento` (
  `Cue` varchar(100) NOT NULL,
  `Sigla` varchar(100) DEFAULT NULL,
  `Nombre_Establecimiento` varchar(100) DEFAULT NULL,
  `Domicilio` varchar(200) DEFAULT NULL,
  `Mail_Escuela` varchar(200) DEFAULT NULL,
  `Telefono_Escuela` varchar(100) DEFAULT NULL,
  `Matricula_Actual` int(11) DEFAULT NULL,
  `Cantidad_Aulas` int(11) DEFAULT NULL,
  `Cantidad_Turnos` int(11) DEFAULT NULL,
  `Comparte_Edificio` varchar(50) DEFAULT NULL,
  `Geolocalizacion` varchar(300) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Id_Tipo_Esc` varchar(100) NOT NULL,
  `Universo` varchar(100) DEFAULT NULL,
  `Tiene_Programa` varchar(50) DEFAULT NULL,
  `Sector` varchar(200) DEFAULT NULL,
  `Cantidad_Netbook_Conig` int(11) DEFAULT NULL,
  `Nro_Cuise` int(11) DEFAULT NULL,
  `Id_Nivel` varchar(300) NOT NULL,
  `Id_Jornada` varchar(300) NOT NULL,
  `Tipo_Zona` varchar(100) DEFAULT NULL,
  `Id_Estado_Esc` int(11) NOT NULL,
  `Id_Zona` int(11) DEFAULT NULL,
  `Cantidad_Netbook_Actuales` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dato_establecimiento`
--

INSERT INTO `dato_establecimiento` (`Cue`, `Sigla`, `Nombre_Establecimiento`, `Domicilio`, `Mail_Escuela`, `Telefono_Escuela`, `Matricula_Actual`, `Cantidad_Aulas`, `Cantidad_Turnos`, `Comparte_Edificio`, `Geolocalizacion`, `Fecha_Actualizacion`, `Usuario`, `Id_Departamento`, `Id_Localidad`, `Id_Tipo_Esc`, `Universo`, `Tiene_Programa`, `Sector`, `Cantidad_Netbook_Conig`, `Nro_Cuise`, `Id_Nivel`, `Id_Jornada`, `Tipo_Zona`, `Id_Estado_Esc`, `Id_Zona`, `Cantidad_Netbook_Actuales`) VALUES
('540055800', 'BOP022', 'BACHILLERATO ORIENTADO PROVINCIIAL N° 22 - ANDRÉS GUACURARÍ', 'AV. JAURETCHE S/N', 'JORGELEIVAS@HOTMAIL.COM', '03757496067', NULL, 9, 3, 'NO', NULL, '2017-05-19', 'jjcervera', 10, 36, '14', '2011', 'Si', 'PUBLICO', NULL, 540055800, '2', '2', NULL, 1, 9, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `denuncia_robo_equipo`
--

CREATE TABLE `denuncia_robo_equipo` (
  `IdDenuncia` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `Quien_Denuncia` varchar(40) DEFAULT NULL,
  `DetalleDenuncia` varchar(400) DEFAULT NULL,
  `Fecha_Denuncia` date DEFAULT NULL,
  `Id_Estado_Den` int(11) NOT NULL,
  `Ruta_Archivo` varchar(500) DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `Id_Departamento` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `Id_Provincia` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`Id_Departamento`, `Nombre`, `Id_Provincia`) VALUES
(1, '25 de Mayo', 1),
(2, 'Apóstoles', 1),
(3, 'Cainguás', 1),
(4, 'Candelaria', 1),
(5, 'Capital', 1),
(6, 'Concepción', 1),
(7, 'Eldorado', 1),
(8, 'Gral. Manuel Belgrano', 1),
(9, 'Guaraní', 1),
(10, 'Iguazú', 1),
(11, 'Leandro N. Alem', 1),
(12, 'Libertador General San Martín', 1),
(13, 'Montecarlo', 1),
(14, 'Oberá', 1),
(15, 'San Ignacio', 1),
(16, 'San Javier', 1),
(17, 'San Pedro', 1);

-- --------------------------------------------------------

--
-- Table structure for table `detalle_asistencia`
--

CREATE TABLE `detalle_asistencia` (
  `Dia` int(11) NOT NULL,
  `Dias` varchar(50) DEFAULT NULL,
  `Horario` varchar(100) DEFAULT NULL,
  `Rol` varchar(10) DEFAULT NULL,
  `Observacion` varchar(200) DEFAULT NULL,
  `Id_Asistencia` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `detalle_atencion`
--

CREATE TABLE `detalle_atencion` (
  `Id_Detalle_Atencion` int(11) NOT NULL,
  `Id_Tipo_Falla` int(11) NOT NULL,
  `Id_Problema` int(11) NOT NULL,
  `Descripcion_Problema` varchar(500) DEFAULT NULL,
  `Id_Tipo_Sol_Problem` int(11) NOT NULL,
  `Id_Estado_Atenc` int(11) NOT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detalle_atencion`
--

INSERT INTO `detalle_atencion` (`Id_Detalle_Atencion`, `Id_Tipo_Falla`, `Id_Problema`, `Descripcion_Problema`, `Id_Tipo_Sol_Problem`, `Id_Estado_Atenc`, `Fecha_Actualizacion`, `Id_Atencion`, `NroSerie`) VALUES
(2, 2, 2, 'Problema PILA', 1, 7, '2017-05-20', 4, 'AA9184144060'),
(3, 2, 2, 'bloqueada', 1, 3, '2017-05-22', 7, 'AA4074071743'),
(4, 2, 2, 'desbloqueo', 1, 7, '2017-05-22', 8, 'AA7184070766'),
(5, 1, 8, 'DISCO DAÑADO', 7, 3, '2017-05-29', 9, 'AA4074072458'),
(7, 1, 15, 'TEST1', 7, 1, '2017-06-06', 10, 'AA4074068053');

-- --------------------------------------------------------

--
-- Table structure for table `devolucion_equipo`
--

CREATE TABLE `devolucion_equipo` (
  `Admin_Que_Recibe` varchar(60) DEFAULT NULL,
  `Fecha_Devolucion` date DEFAULT NULL,
  `Observacion` varchar(300) DEFAULT NULL,
  `Devuelve_Cargador` varchar(20) DEFAULT NULL,
  `Id_Estado_Devol` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Id_Autoridad` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `Id_Motivo` int(11) NOT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `Id_Division` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`Id_Division`, `Descripcion`) VALUES
(1, 'A'),
(2, 'B'),
(3, 'C'),
(4, 'D'),
(5, 'E'),
(6, 'F'),
(7, 'G'),
(8, 'H'),
(9, 'I'),
(10, 'J'),
(11, 'K'),
(12, 'L'),
(13, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `equipos`
--

CREATE TABLE `equipos` (
  `NroSerie` varchar(30) NOT NULL,
  `NroMac` varchar(30) DEFAULT NULL,
  `Id_Ubicacion` int(11) NOT NULL DEFAULT '1',
  `Id_Modelo` int(11) NOT NULL DEFAULT '24',
  `Id_Estado` int(11) NOT NULL DEFAULT '1',
  `Id_Sit_Estado` int(11) NOT NULL DEFAULT '1',
  `Id_Marca` int(11) NOT NULL DEFAULT '21',
  `Id_Ano` int(11) NOT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `SpecialNumber` varchar(30) DEFAULT NULL,
  `Tiene_Cargador` varchar(50) DEFAULT NULL,
  `Id_Tipo_Equipo` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `equipos`
--

INSERT INTO `equipos` (`NroSerie`, `NroMac`, `Id_Ubicacion`, `Id_Modelo`, `Id_Estado`, `Id_Sit_Estado`, `Id_Marca`, `Id_Ano`, `Usuario`, `Fecha_Actualizacion`, `SpecialNumber`, `Tiene_Cargador`, `Id_Tipo_Equipo`) VALUES
('9051068377', '68A3C41E55B9', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051059696', '1C659DE3C2E2', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051059801', '1C659DE3B0C2', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051070163', '68A3C41E3937', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051021078', '485D6091BBD7', 2, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51071627', '68A3C41A092C', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051073336', '68A3C4222036', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051072342', '68A3C41A05ED', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051059685', '1C659DE3C0FD', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051070489', '68A3C41B919D', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051055602', '1C659DE3B130', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051073343', '68A3C4220214', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051061517', '1C659DE3C3FB', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051068343', '68A3C41E2635', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051021248', '485D6091CED8', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051073291', '68A3C422200D', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051068259', '68A3C41E2C27', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051024077', '485D6091D6F3', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51055879', '1C659DE3C43A', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051068255', '68A3C41E2CF1', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051059746', '1C659DE3B1B2', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051068266', '68A3C41E4266', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051073438', '68A3C4222032', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051059748', '1C659DE3C0F0', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051055941', '1C659DE3C2D3', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051028947', '485D6091BE21', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051073179', '68A3C4220286', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051070490', '68A3C41B7EC4', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051073070', '68A3C42201FF', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051072348', '68A3C41A058A', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051071637', '68A3C41A07AF', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51037324', 'E0B9A514DB03', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051068375', '68A3C41E3422', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051059698', '1C659DE3B0AE', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051021079', '485D6091BBE0', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051055866', '1C659DE3C367', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51072963', '68A3C41E54CC', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051073069', '68A3C4220215', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051073324', '68A3C422037B', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051027686', '485D6091B177', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051061267', '68A3C41E3EEA', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051055854', '1C659DE3B000', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051061251', '68A3C41E5B31', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051028946', '485D6091BDEA', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051026430', 'E0B9A5155DFE', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051055868', '1C659DE3B001', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('4051059931', '68A3C41E5ACA', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051073359', '68A3C42202FA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51068181', '68A3C41E2603', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051028586', 'E0B9A5155DDE', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051073428', '68A3C422030F', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051061229', '68A3C41E4071', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051061248', '68A3C41E40A9', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51061575', '68A3C41B7E4C', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051055862', '1C659DE3C36D', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051058977', '1C659DE3B264', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051020989', '485D6091E494', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051060586', '1C659DE23AA5', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051027688', '485D6091B142', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051026425', 'E0B9A5155E15', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051056400', '1C659DE082C6', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051061565', '68A3C41B7F0B', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051060102', '68A3C41E3357', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051072405', '68A3C41A090F', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051059044', '68A3C41E3F99', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051056297', '1C659DE232A8', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051061573', '68A3C41B91B7', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('1051060662', '1C659DE239B0', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051081409', '68A3C4222B81', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051056341', '1C659DE1F783', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051061261', '68A3C41E405E', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051061356', '68A3C41E5B2E', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051060647', '1C659DE22DFE', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051073024', '68A3C41E2F06', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('3051059959', '68A3C41E3F86', 2, 26, 2, 9, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051060832', '1C659DE228E8', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051073253', '68A3C4220352', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051061352', '68A3C41E40AA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('3051061355', '68A3C41E5B38', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51073019', '68A3C41E5816', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051059945', '68A3C41A296E', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051060049', '68A3C41E5AD0', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051072993', '68A3C41E52F3', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051071470', '68A3C41A06D2', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051072989', '68A3C41E3A19', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051061567', '68A3C41B7F00', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051060253', '1C659DE3D7D7', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51060255', '1C659DE3D75B', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051060888', '68A3C41B89FC', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51030134', 'E0B9A5153525', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051056146', '1C659DE1F6C3', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('51061348', '68A3C41E5AC9', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051059196', '68A3C41A0F0D', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51061285', '68A3C41E5A4C', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051072914', '68A3C41E3303', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51072996', '68A3C41E3999', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051076939', '68A3C422011F', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051061568', '68A3C41B90D9', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051061218', '68A3C41B9192', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051072805', '68A3C41E33E5', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051071100', '68A3C41E24ED', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051061240', '68A3C41E5A7F', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051059957', '68A3C41E5C22', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051073016', '68A3C41E3979', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051060044', '68A3C41E40A6', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051072775', '68A3C41E2F05', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051073020', '68A3C41E5851', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051061360', '68A3C41E5ACD', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051060590', '1C659DE23EBE', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051061523', '68A3C41B7E2C', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('6051061239', '68A3C41E5A85', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051061574', '68A3C41B91A4', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('51048600', 'E0B9A5154004', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051081586', '68A3C4221F0F', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051060056', '68A3C41E33B7', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051055888', '1C659DE3C3BF', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051060050', '68A3C41E33B0', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('9051073002', '68A3C41E52F0', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('3051072911', '68A3C41E58C5', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051072971', '68A3C41E3976', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051073010', '68A3C41E582D', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('6051059958', '68A3C41A0FB8', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051072827', '68A3C41B98C6', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('4051061578', '68A3C41B9178', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051060051', '68A3C41E5AD9', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('6051056028', '1C659DE3B457', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('9051060101', '68A3C41E33AC', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051072930', '68A3C41E35FA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('4051072920', '68A3C41E3371', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051072254', '68A3C41A0635', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051060799', '1C659DE3DA28', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51073022', '68A3C41E583A', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051074667', '68A3C421FC7C', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051061346', '68A3C41E40A4', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051061208', '68A3C41B91A8', 2, 12, 2, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051074505', '1C659DE3D68F', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051061361', '68A3C41E5B36', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51023025', '485D6091C6B1', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051061349', '68A3C41E5ADC', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051072782', '68A3C41E58C3', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051080856', '68A3C4222BCA', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51073824', '68A3C421FCE6', 1, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051072992', '68A3C41E399B', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051072910', '68A3C41E329F', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051081574', '68A3C4221F6B', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051073061', '68A3C41A0920', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051073602', '68A3C41A05B8', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051072987', '68A3C41E3304', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051081420', '68A3C4222D8A', 1, 12, 1, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051081075', '68A3C4221EAB', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051080866', '68A3C4222C33', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51080756', '68A3C4221F4C', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051073281', '68A3C41A09A3', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051081683', '68A3C4220C3C', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51060735', '1C659DE3DA41', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051081581', '68A3C4221F6A', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051080954', '68A3C4220C22', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051081419', '68A3C4222BE3', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051023029', '485D6091C730', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('6051081322', '68A3C4222049', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051080868', '68A3C4222BC7', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051075076', '68A3C4220D47', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051074089', '68A3C41E4AA6', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051074437', '68A3C41E45CE', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051073829', '68A3C421FCA1', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051073890', '68A3C422088C', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051080975', '68A3C4222D84', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051074059', '68A3C41E35B4', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051081315', '68A3C4221EDD', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51081151', '68A3C4220C27', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051073939', '68A3C421FE03', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'NO', 1),
('8051073352', '68A3C422024D', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051022539', '485D6091EF9A', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('1051071203', '68A3C419F798', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051060325', '68A3C41E3A33', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051060054', '68A3C41E4047', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051023022', '485D6091C8DC', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051081326', '68A3C4222041', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051063632', '1C659DE3DA24', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051081717', '68A3C42220D8', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('6051060090', '68A3C41E334E', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051025187', '485D6091EE33', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051081143', '68A3C4220C32', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051037921', 'E0B9A514BFDA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051073827', '68A3C421FBAE', 1, 1, 1, 12, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('9051080809', '68A3C4222BB9', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51037556', 'E0B9A514C343', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051081677', '68A3C4221F14', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('6051023449', '485D6091E8A7', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051060097', '68A3C41E3398', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051080953', '68A3C4220C33', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051022319', '485D6091EFAE', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051050941', 'E0B9A5154F0D', 2, 1, 2, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051072713', '68A3C4220256', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051081062', '68A3C4222BBB', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051037443', 'E0B9A514DBFB', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051037105', 'E0B9A514BFF2', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51037417', 'E0B9A514D724', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051063556', '1C659DE3D552', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051061577', '68A3C41B7F06', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051037599', 'E0B9A514BCFD', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051022300', '485D6091F066', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051023032', '485D6091C6F2', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51038635', 'E0B9A514C09F', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051022117', '485D60D365DE', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('1051022901', '485D6091C4F5', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051029891', 'E0B9A5155D51', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051073833', '68A3C421FBAF', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051029897', 'E0B9A5152819', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051022902', '485D6091C51C', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51021967', '485D609189E8', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051037111', 'E0B9A514BFB2', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051036028', 'E0B9A514C815', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051080869', '68A3C4222BB5', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051080796', '68A3C4222C3E', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051060616', '68A3C41B8649', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051072776', '68A3C41E39AD', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051023272', '485D6091E8FB', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051025198', '485D6091E9AC', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051074507', '68A3C4220D52', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051029450', 'E0B9A5152849', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051023981', '485D6091ED13', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('9051061539', '68A3C41B7EFD', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051030467', 'E0B9A5157CC7', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51029642', 'E0B9A51527AB', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051029652', 'E0B9A5152773', 1, 1, 1, 12, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051072769', '68A3C41E399C', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51038871', 'E0B9A5151F9E', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051079534', '68A3C41A2330', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051023802', '485D6091C451', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051079343', '68A3C41A238F', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51038595', 'E0B9A514BFDF', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051024276', '485D6091EFFF', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051078607', '68A3C41B9A72', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051036034', 'E0B9A514BF9A', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051036871', 'E0B9A514CA2B', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051080854', '68A3C4222C30', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051031936', 'E0B9A5156B17', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051059955', '68A3C41E5C1F', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051060043', '68A3C41E563B', 2, 12, 2, 14, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051081058', '68A3C4220C18', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051079660', '68A3C41A2429', 2, 26, 2, 7, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051062658', '68A3C41B8645', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051022928', '485D60D365E5', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051021825', '485D60D360D9', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051079516', '68A3C41A270B', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051022107', '485D60D365EA', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051073716', '68A3C4220FA2', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051029744', 'E0B9A5156A18', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051029895', 'E0B9A515275F', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051082223', '68A3C41B813F', 1, 26, 2, 14, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051021964', '485D60D36606', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051037372', 'E0B9A514DB1C', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051081784', '68A3C41B9020', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051022111', '485D60D364A4', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051079734', '68A3C419FE02', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051038489', 'E0B9A514C9D7', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051022110', '485D60D36616', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051082444', '68A3C41A26C0', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051030320', 'E0B9A5157C91', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051079435', '68A3C41A23F0', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051025867', '485D6091E4E4', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051031357', 'E0B9A514DDAE', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051022641', '485D6091B734', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051079510', '68A3C41A27D3', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051022924', '485D60914BD8', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051079649', '68A3C419FDCA', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051079426', '68A3C419FE6D', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051022635', '485D6091C4DC', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051022403', '485D60D365EB', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051022401', '485D60D365F1', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051036374', 'E0B9A5151F1B', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051082226', '68A3C41E40DA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051036035', 'E0B9A514BFA7', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051038729', 'E0B9A514BFD0', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051022427', '485D6091EFB2', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051023607', '485D6091D8E0', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('6051029654', 'E0B9A5152A93', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051030131', 'E0B9A5150D0B', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051081749', '68A3C4222AFF', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051080852', '68A3C4222C31', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('3051030139', 'E0B9A51534F4', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051024846', '485D6091E875', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051022545', '485D6091CEF9', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051079422', '68A3C41A26D2', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51021972', '485D60915978', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051077859', '68A3C41A0877', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051070252', '68A3C41A114D', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('6051068341', '68A3C41E260D', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051021313', '485D6091D1B8', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051069810', '68A3C41B7B88', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051058880', '1C659DE3C177', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051059109', '1C659DE3C126', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051077309', '68A3C4221876', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051028943', '485D6091BE03', 1, 1, 1, 12, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051077333', '68A3C42219B4', 1, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051068152', '68A3C41E38BD', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051059682', '1C659DE3BD6F', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('8051069900', '68A3C41E364A', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051028870', '485D6091B14F', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051026779', '485D60916D4E', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('4051068309', '68A3C41E4259', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('51072336', '68A3C41A05E2', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('7051073293', '68A3C4222010', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051068354', '68A3C41E426C', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('9051028954', '485D60916D92', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051073123', '68A3C42222A4', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051068192', '68A3C41E4883', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('2051058939', '1C659DE3B086', 2, 26, 1, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051059787', '1C659DE3B0F3', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('1051028948', 'E0B9A5152DF5', 1, 1, 1, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163010852', '6C71D948E847', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163011713', '6C71D94DB824', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163011850', '6C71D94DB820', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163012125', '6C71D94DB825', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163012785', '6C71D9466DF8', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163012897', '6C71D9466E5B', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163016067', '6C71D94D73A7', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163016490', '6C71D94697D8', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163016512', '6C71D94696C7', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163016576', '6C71D9469723', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163018092', '6C71D9469752', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163019352', '6C71D9469693', 1, 1, 1, 14, 3, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163019409', '6C71D94696AF', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163020080', '6C71D9469749', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163022867', '6C71D948E450', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163023375', '6C71D948802C', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163041576', '6C71D98834B6', 2, 1, 2, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0163042141', '6C71D988393F', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0163045208', '6C71D9883947', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163015065', '6C71D94DB6EB', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163015120', '6C71D94DB7C4', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163015162', '6C71D947938B', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163016181', '6C71D94696DC', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163016220', '6C71D94696C3', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163016630', '6C71D948EA2D', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163016687', '6c71d9487e2f', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163016747', '6C71D9482651', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163016842', '6C71D948E970', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163017338', '6C71D948EA06', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163017697', '6C71D9487E2C', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163017746', '6C71D9490518', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018279', '6C71D94596C9', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018383', '6C71D94696E7', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018462', '6C71D946971A', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018829', '6C71D948E951', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163018855', '6C71D948E868', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163018894', '6C71D948E966', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018906', '6C71D948EA26', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163018940', '6C71D948E91E', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163019433', '6C71D9490510', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163019789', '6C71D948E978', 2, 1, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163020076', '6C71D9479343', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163020282', '6C71D94696E1', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163020291', '6C71D9469711', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163020303', '6C71D94696D2', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163020456', '6C71D947938A', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163020567', '6C71D94696B7', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1163020595', '6C71D94696BD', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163040488', '6C71D988340B', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1163040926', '6C71D96FBCE5', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2163017967', '6C71D9479319', 1, 1, 2, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2163022753', '6C71D948EB0E', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2163022885', '6C71D9467D4F', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2163023346', '6C71D9488050', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163013368', '6C71D94DB79A', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163015560', '6C71D94DC53B', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163016947', '6C71D94797DB', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163017988', '6C71D9465B24', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163023393', '6C71D948FB73', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163035925', '6C71D993ED4C', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3163036036', '6C71D96FC228', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3163042158', '6C71D9883954', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4163011604', '6C71D94DCD1A', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163012788', '6C71D94DB376', 2, 1, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163013519', '6C71D94DB34A', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4163015168', '6C71D9466BB1', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163017116', '6C71D94DCED5', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4163017439', '6C71D9466C05', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163019355', '6C71D94DB353', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163021690', '6C71D9488018', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4163023340', '6C71D948FB43', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4163040770', '6C71D96FBD58', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163011880', '6C71D94DCDB9', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163012222', '6C71D94DCCDD', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA5163021544', '6C71D946A5EC', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163021557', '6C71D94909E4', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163022296', '6C71D948802F', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163023517', '6C71D94672BF', 2, 24, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA5163024927', '6C71D9466E12', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163030577', '6C71D94672F0', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163036000', '6C71D98839E6', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163036696', '6C71D988397D', 2, 1, 1, 2, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA5163039743', '6C71D98CA522', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5163044179', '6C71D9883257', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6163020253', '6C71D948FB3A', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6163023488', '6C71D9487F8F', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6163037262', '6C71D96FBE0D', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6163037359', '6C71D9674E95', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6163038935', '6C71D98832CC', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163012176', '6C71D9466DFE', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA7163012491', '6C71D94688FF', 2, 24, 2, 11, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA7163012741', '6C71D93F4CB1', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA7163014203', '6C71D9466BDE', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163014513', '6C71D94696FC', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163019935', '6C71D948E972', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163021979', '6C71D9467D4A', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163022543', '6C71D948FB42', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163036956', '6C71D99425C3', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7163038083', '6C71D988323E', 2, 24, 2, 7, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA8163013347', '6C71D94797B9', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163015552', '6C71D9479316', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163015775', '6C71D948E927', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163016532', '6C71D94DB766', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163018806', '6C71D94DB6EF', 1, 1, 1, 12, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA8163019949', '6C71D94DCC94', 2, 24, 2, 11, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA8163022252', '6C71D946A5F2', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163022369', '6C71D9467D3D', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163022793', '6C71D948FB37', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163039303', '6C71D98839D0', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8163040439', '6C71D96FBD39', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9163012355', '6C71D94DCED8', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9163012414', '6C71D94792C8', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9163012734', '6C71D947937C', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9163013944', '6c71d9478e1c', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9163021854', '6C71D94DB7E9', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9163041467', '6C71D993EC64', 1, 1, 1, 14, 5, 4, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9163044903', '6C71D988323C', 2, 24, 2, 8, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0313676838', '240A6453C081', 2, 23, 2, 8, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0313677327', '240A6453BF4A', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0313683414', '240A6453C096', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0313683469', '240A6453C2F9', 2, 26, 2, 8, 13, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0313684821', '240A6453BF4F', 2, 1, 2, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA0313687373', '240A64534BC7', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0313687487', '240A6453B016', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA0313688648', '2016D8849A1C', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1313678895', '240A64536711', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1313694244', '240A64536655', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2313670295', '240A64536480', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2313672777', '240A6453BF54', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2313679242', '240A64536680', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313670214', '240A6453C0AD', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313671114', '240A6453C108', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313671227', '240A6453C11F', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313671403', '240A6453BFF5', 1, 1, 2, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3313671445', '240A6453C004', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313671451', '240A6453C079', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313671570', '240A6453C078', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3313675899', '240A6453BF3F', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313675935', '240A6453BFBD', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313676186', '240A6453C0F8', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313676204', '240A6453C109', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313676247', '240A6453BE8C', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313679185', '240A6453C2F4', 2, 23, 2, 8, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3313679947', '240A6453C45A', 2, 1, 1, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3313680261', '240A6453BF2B', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313683303', '240A6453BF10', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313687071', '240A6453BF91', 2, 26, 2, 8, 13, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3313687135', '240A6453C09E', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3313690917', '240A6453D272', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4313671536', '240A6453BF9F', 2, 1, 1, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4313675842', '240A6453AF87', 2, 26, 2, 8, 13, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4313684127', '240A6453C16E', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5313679857', '240A6453BFAD', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA5313688822', '240A6453C107', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5313689265', '240A6453BFA0', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5313689366', '240A6453BF43', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5313689555', '240A6453D7CB', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6313674288', '240A6453C11D', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6313675682', '240A6453BF09', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6313675780', '240A6453BFC1', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL);
INSERT INTO `equipos` (`NroSerie`, `NroMac`, `Id_Ubicacion`, `Id_Modelo`, `Id_Estado`, `Id_Sit_Estado`, `Id_Marca`, `Id_Ano`, `Usuario`, `Fecha_Actualizacion`, `SpecialNumber`, `Tiene_Cargador`, `Id_Tipo_Equipo`) VALUES
('AA6313676863', '240A6453C0F6', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA6313676957', '240A6453C0AB', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA6313684104', '240A64536431', 1, 1, 2, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA6313691274', '240A6453BE6C', 2, 1, 1, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA7313670064', '240A6453C101', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA7313670110', '240A6453C0B6', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313676474', '240A6453C001', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313676820', '240A6453BE25', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313676969', '240A6453C10F', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313677071', '240A6453C0DC', 1, 1, 1, 14, 13, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313677215', '240A6453C07F', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313677451', '240A6453C077', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680235', '240A6453BF82', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680313', '240A6453C035', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680337', '240A6453C0B7', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680341', '240A6453BE96', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680457', '240A6453C0F1', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680800', '240A6453C07A', 1, 1, 1, 14, 13, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7313680948', '240A6453C33B', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313674197', '240A6453C0B4', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313674628', '240A6453D52A', 1, 1, 1, 14, 13, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313678862', '240A6453C1A9', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313682074', '240A6453D890', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313683248', '240A6453C2B5', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA8313685865', '240A6453C51E', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313673221', '240A6453C49D', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313673506', '240A6453C484', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313673582', '240A6453C44B', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313674043', '240A6453C0F7', 2, 1, 1, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9313674126', '240A6453BFEE', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313674174', '240A6453C09B', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313674384', '240A6453D7A9', 2, 1, 1, 2, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9313675440', '240A6453BF01', 2, 23, 2, 7, 3, 5, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9313678699', '240A645379C8', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313682901', '240A6453C33D', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313685064', '240A6453BE89', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313686353', '240A6453664B', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9313693576', '240A64536479', 1, 1, 1, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074072458', '7427EA9787E6', 1, 1, 2, 12, 2, 7, 'jjcervera', '2017-05-29', 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078344', '7427EA97880C', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074079118', '7427EA9787B6', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074072185', '7427EA97884F', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074079053', '7427EA9787E5', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074071045', '7427EA97803E', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074067416', '7427EA978700', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4074091861', '7427EA978780', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074155167', '7427EA97886A', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078778', '7427EA97884A', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5074139419', '7427EA9776C5', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078759', '7427EA978016', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074068053', '7427EA97802C', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078474', '7427EA978037', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074067068', '7427EA979129', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078239', '7427EA978810', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5074102516', '7427EA978F7B', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074148705', '7427EA978754', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074070626', '7427EA9787E2', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074154561', '7427EA978737', 2, 22, 2, 7, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4074072208', '7427EA978957', 1, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074078332', '7427EA978825', 1, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074146960', '7427EA979A28', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA5074150140', '7427EA97851C', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074071077', '7427EA978644', 2, 22, 2, 7, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA4074077612', '7427EA9789A7', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5074118976', '7427EA97767B', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074150161', '7427EA978807', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074078211', '7427EA978779', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074071099', '7427EA97877D', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074064088', '7427EA9703FB', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5074146599', '7427EA9783F9', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074072229', '7427EA978773', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074067204', '7427EA9789E4', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA5074145713', '7427EA978A82', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074054619', '7427EA978FCA', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074151171', '7427EA97874C', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA4074064306', '7427EA9788F4', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074149502', '7427EA978960', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074151773', '7427EA978749', 1, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074079162', '7427EA9786B0', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074149107', '7427EA97872D', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074155181', '7427EA9789AE', 1, 1, 1, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074063262', '7427EA97A113', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA3074114134', '7427EA97A54B', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074090593', '7427EA97BC7C', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074094539', '7427EA97A011', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA2074137292', '7427EA97A7E4', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074052735', '7427EA979EF6', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074078110', '7427EA979CE2', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074133147', '7427EA97A83C', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074161883', '7427EA97A06F', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074079189', '7427EA97A19F', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074057073', '7427EA97A055', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074101593', '7427EA97A101', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074133175', '7427EA97A7E0', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074128882', '7427EA97A814', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074130965', '7427EA97A4F7', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074099879', '7427EA979E0B', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074100932', '7427EA979F18', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074166904', '7427EA979F21', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074065405', '7427EA979ED0', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074160834', '7427EA979EFA', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074052670', '7427EA97A07E', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074098410', '7427EA97A150', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074099896', '7427EA97A1F8', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074102258', '7427EA979E59', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074161831', '7427EA97A01D', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074153253', '7427EA979C5E', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074112992', '7427EA97A4F6', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074129545', 'C03FD5178777', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074166144', '7427EA97A046', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074157440', '7427EA97A669', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074087550', '7427EA97A090', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074053210', '7427EA979BB8', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074161136', '7427EA97A0B4', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074068554', '7427EA97A389', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074150002', '7427EA979E60', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074094690', '7427EA97A05D', 1, 1, 1, 12, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2074101875', '7427EA97A02C', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074062120', '7427EA979FC0', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074063537', 'C03FD5178E85', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074051003', '7427EA97A115', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074113535', '7427EA97A413', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074166427', '7427EA979C15', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074078496', '7427EA979D5D', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074098895', '7427EA97A34F', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074056677', '7427EA979C91', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074065357', '7427EA979CE4', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2074099842', '7427EA979ED6', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074102044', '7427EA979F70', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074076234', '7427EA97A086', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA1074167270', '7427EA97A030', 1, 1, 1, 12, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1074167067', '7427EA979C93', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074077580', '7427EA97A34C', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074099088', '7427EA97A359', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074133067', '7427EA97A288', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA3074100418', '7427EA97A690', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074078144', '7427EA979CE6', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074056596', '7427EA979DE7', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074062151', '7427EA979F1B', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074056771', '7427EA979FBD', 1, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074061772', '7427EA97A043', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2074098428', '7427EA97A367', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074069830', 'B8EE653B1EB2', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA1074145121', 'C03FD517CEB1', 2, 1, 2, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA2074061690', '7427EA97A031', 1, 1, 1, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184140540', 'D05349DDC51C', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184122303', 'D05349DDD6C2', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184128036', 'D05349DDDA91', 1, 21, 1, 11, 1, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9184119456', 'D05349DDDAA5', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184134907', 'D05349DDDAAF', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184138864', 'D05349DDDAE1', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184128045', 'D05349E02659', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184144060', 'D05349E02948', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184124296', 'D05349E029EC', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184144117', 'D05349E02C48', 2, 1, 2, 2, 1, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA9184135014', 'D05349E02ECD', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184144159', 'D05349E030C7', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184140410', 'D05349E03397', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184125033', 'D05349E0339F', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA9184140485', 'D05349E033AA', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA2184074637', 'D05349E034A1', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7184069173', 'D05349DDD30B', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('AA7184070766', 'D05349DDD312', 1, 1, 1, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'SI', NULL),
('5051068257', '68A3C41E3373', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('8051068396', '68A3C41E261A', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051055911', '1C659DE3C366', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051028866', '485D6091B165', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51073335', '68A3C42222BC', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051027880', 'E0B9A5156A0C', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51021241', '485D6091CEDC', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051071626', '68A3C41A0940', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051069899', '68A3C41E58D2', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051073342', '68A3C4220291', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051059224', '68A3C41E5A3B', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051048718', 'E0B9A5158422', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051072780', '68A3C41E58BF', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051061225', '68A3C41E3FD3', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051081418', '68A3C4222D95', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051081096', '68A3C4220C17', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51072724', '68A3C4221100', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051072677', '1C659DE3D69E', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051061204', '68A3C41B91A3', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051059817', '68A3C41A0FE8', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051072807', '68A3C41E33DA', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051059943', '68A3C41A1217', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051061351', '68A3C41E5B3F', 2, 1, 2, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051072862', '68A3C41E3685', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051060968', '1C659DE226F5', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051061203', '68A3C41B91E1', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51072770', '68A3C41E3993', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051072988', '68A3C41E52F2', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('5051060659', '1C659DE2315B', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051060058', '68A3C41E40B1', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051072787', '68A3C41E366F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051072777', '1C659DE3D885', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51081585', '68A3C42220AC', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051073828', '68A3C421FBB2', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051080961', '68A3C4220C2B', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51074738', '68A3C422059F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051060084', '68A3C41E564E', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051080857', '68A3C4222B94', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051072849', '68A3C41E367C', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051081036', '68A3C422068F', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051061564', '68A3C41B7F03', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('2051081713', '68A3C4222AF9', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051074974', '68A3C4220D31', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('4051072789', '68A3C41E367A', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051074266', '68A3C41E5502', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51081407', '68A3C4222AC0', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051081052', '68A3C422067F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051081679', '68A3C42220A8', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51072786', '68A3C41E39AA', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051081034', '68A3C4220C15', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51081103', '68A3C4220B48', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51081048', '68A3C4220B5F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51074436', '68A3C41B794F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51074830', '68A3C4221044', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051072837', '68A3C41E36EF', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051081681', '68A3C42220D5', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51080798', '68A3C4222BB1', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051081320', '68A3C4221EEB', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051062458', '68A3C41B88A4', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051039337', 'E0B9A5151265', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('8051072855', '68A3C41E3689', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051037456', 'E0B9A514DAC9', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051023173', '485D6091C708', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051026482', '485D60916F82', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051062538', '68A3C41B8A00', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('7051073001', '68A3C41E399D', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051074197', '68A3C41B897D', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051081038', '68A3C4220B5D', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('3051038787', 'E0B9A514BDF2', 2, 1, 2, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051021974', '485D60D364BD', 2, 1, 2, 2, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('1051030638', 'E0B9A5152770', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051023280', '485D6091E8FA', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051021973', '485D60D360BA', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('51038572', 'E0B9A514C9DB', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051081576', '68A3C422209F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051024933', '485D6091E89A', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051029648', 'E0B9A5152759', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('8051021924', '485D6091C5ED', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051021980', '485D6091802F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051081325', '68A3C4221EE3', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051038579', 'E0B9A514C978', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051081035', '68A3C4220B61', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051080871', '68A3C4222BCB', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051030132', 'E0B9A5155D39', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('4051037457', 'E0B9A514BCDD', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051022644', '485D6091CEEB', 2, 26, 2, 11, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('51079694', '68A3C41A240A', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('2051022026', '485D60D36490', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051021240', '485D6091D23F', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051079279', '68A3C41A2365', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051037451', 'E0B9A514BD1D', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051031937', 'E0B9A5156AB6', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('1051059679', '1C659DE3BFD7', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051068346', '68A3C41E3815', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051069818', '68A3C41A11C6', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('6051059885', '68A3C41A2983', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('5051077229', '68A3C4221882', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('7051068355', '68A3C41E4225', 2, 26, 2, 8, 13, 2, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'SI', 1),
('9051070253', '68A3C41B7B81', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('3051020970', '485D6091D354', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('9051068141', '68A3C41E488A', 2, 1, 2, 14, 13, 2, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3163013337', '6C71D94DB786', 1, 1, 1, 12, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA8163023278', '6C71D94DB7C6', 1, 1, 1, 12, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA9163036123', '6C71D96FC118', 1, 1, 1, 12, 5, 4, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA3313687383', '240A64536682', 2, 1, 2, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA6313673718', '240A6453BFBE', 2, 1, 2, 14, 3, 5, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151998', '7427EA978976', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074149597', '7427EA97885D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074077630', '7427EA978654', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074066582', '7427EA9786B6', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074071743', '7427EA978930', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074114658', '7427EA97869C', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074052211', '7427EA979071', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074069658', '7427EA97883D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074080593', '7427EA9787C2', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151395', '7427EA9786E2', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074155760', '7427EA978915', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074052122', '7427EA978ECD', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074078328', '7427EA978FE9', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074070085', '7427EA97860C', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074135604', '7427EA978D29', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074078679', '7427EA97802D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074121266', '7427EA978FEA', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074077629', '7427EA979010', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074072653', '7427EA978964', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074066578', '7427EA9789BE', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074079070', '7427EA978031', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074149626', '7427EA978713', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074073556', '7427EA9787DB', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074137098', '7427EA9791B7', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074072294', '7427EA97881D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074087729', '7427EA97851D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074070597', '7427EA9787E1', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151788', '7427EA97872E', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074078740', '7427EA97877F', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074114706', '7427EA978C8C', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074078764', '7427EA978628', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074152003', '7427EA978745', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074070524', '7427EA97865E', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074054631', '7427EA978689', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074071134', '7427EA9787AF', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074068804', '7427EA978F8C', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151229', '7427EA97918D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074079343', '7427EA978011', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074077643', '7427EA978763', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074070876', '7427EA978D93', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074070613', '7427EA9786AD', 2, 1, 1, 2, 2, 7, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA4074078508', '7427EA9787C1', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074068048', '7427EA978981', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151746', '7427EA978996', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074106531', '7427EA978A00', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074151336', '7427EA9790F3', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074105805', '7427EA978B97', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074119373', '7427EA978D7D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074078803', '7427EA978FF2', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074068435', '7427EA97919D', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074071020', '7427EA978827', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074151185', '7427EA97918C', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA5074124024', 'C03FD517F242', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074072193', '7427EA9789BD', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA4074064513', '7427EA9791B4', 2, 1, 2, 14, 2, 7, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074134314', '7427EA97A4EB', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA1074167717', '7427EA97A000', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074113514', '7427EA97A3FC', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074127113', '7427EA97A651', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074127871', '7427EA979D04', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA2074061738', '7427EA979FBF', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074094511', '7427EA97A047', 2, 1, 1, 2, 2, 6, 'jjcervera', '2017-04-24', 'DD7B2490A04B772C5B3E', 'NO', 1),
('AA2074168224', '7427EA97A4AE', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074163108', '7427EA97A7DF', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074077515', '7427EA97A343', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074163143', '7427EA97A294', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA3074113644', '7427EA97A427', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074062097', '7427EA979F27', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074117418', '7427EA97A53C', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074150881', '7427EA97A522', 1, 1, 1, 1, 2, 6, 'jjcervera', '2017-04-23', 'DD7B2490A04B772C5B3E', 'SI', 1),
('AA1074164447', '7427EA979E5B', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074063220', '7427EA97A0FD', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA1074139590', 'C03FD517AC74', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074099863', '7427EA979F44', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074075604', '7427EA979FA1', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074062065', '7427EA979F80', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA1074144928', '7427EA97A1AC', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074078064', '7427EA97A341', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074165055', '7427EA97A4FA', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA1074119974', 'C03FD517BC0F', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA2074168286', '7427EA97A372', 2, 1, 2, 14, 2, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('AA7184067604', 'D05349E041CB', 2, 1, 2, 14, 1, 6, NULL, NULL, 'DD7B2490A04B772C5B3E', 'NO', NULL),
('SZSE10IS201213970', NULL, 2, 5, 2, 8, 5, 1, 'jjcervera', '2017-04-24', NULL, 'SI', 1),
('8051061551', '68A3C41A1200', 2, 12, 2, 8, 13, 2, 'jjcervera', '2017-04-23', NULL, 'SI', 1),
('AA8163016701', '6C71D94DB771', 2, 24, 2, 9, 5, 4, 'Administrator', '2017-04-24', NULL, 'SI', 1),
('AA9055005436', '7427EA930DB2', 1, 28, 1, 1, 13, 7, 'jjcervera', '2017-04-25', NULL, 'SI', 1),
('AA2074100035', '7427EA979F46', 1, 22, 1, 1, 2, 6, 'jjcervera', '2017-05-23', NULL, 'SI', 1),
('AA9315000410', 'B8AEED019FBB', 1, 3, 1, 1, 3, 7, 'jjcervera', '2017-06-02', NULL, 'SI', 1);

-- --------------------------------------------------------

--
-- Table structure for table `establecimientos_educativos_pase`
--

CREATE TABLE `establecimientos_educativos_pase` (
  `Cue_Establecimiento` int(50) NOT NULL,
  `Nombre_Establecimiento` varchar(200) DEFAULT NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Domicilio_Escuela` varchar(10) DEFAULT NULL,
  `Nombre_Directivo` varchar(200) DEFAULT NULL,
  `Cuil_Directivo` varchar(50) DEFAULT NULL,
  `Nombre_Rte` varchar(200) DEFAULT NULL,
  `Tel_Rte` varchar(100) DEFAULT NULL,
  `Email_Rte` varchar(200) DEFAULT NULL,
  `Nro_Serie_Server_Escolar` varchar(200) DEFAULT NULL,
  `Contacto_Establecimiento` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `establecimientos_educativos_pase`
--

INSERT INTO `establecimientos_educativos_pase` (`Cue_Establecimiento`, `Nombre_Establecimiento`, `Id_Provincia`, `Id_Departamento`, `Id_Localidad`, `Domicilio_Escuela`, `Nombre_Directivo`, `Cuil_Directivo`, `Nombre_Rte`, `Tel_Rte`, `Email_Rte`, `Nro_Serie_Server_Escolar`, `Contacto_Establecimiento`, `Fecha_Actualizacion`, `Usuario`) VALUES
(540176400, 'EPET N° 33', 1, 10, 36, 'RUTAN°12', 'BENITEZ JULIO CESAR', '20162941063', NULL, NULL, NULL, 'T002-4152000756', NULL, '2017-04-24', 'Gabriel'),
(540055800, 'B.O.P. N° 22', 1, 10, 36, '--', 'LEIVAS JORGE OSCAR', '20147750499', 'CERVERA JUAN JOSÉ', '03757496067', 'RTE.BOP22@GMAIL.COM', '0696686A055', NULL, '2017-04-24', 'jjcervera');

-- --------------------------------------------------------

--
-- Table structure for table `estado_actual_legajo_persona`
--

CREATE TABLE `estado_actual_legajo_persona` (
  `Dni` int(11) NOT NULL,
  `Matricula` varchar(100) DEFAULT NULL,
  `Certificado_Pase` varchar(100) DEFAULT NULL,
  `Tiene_DNI` varchar(100) DEFAULT NULL,
  `Certificado_Medico` varchar(100) DEFAULT NULL,
  `Posee_Autorizacion` varchar(100) DEFAULT NULL,
  `Cooperadora` varchar(100) DEFAULT NULL,
  `Archivos Varios` text,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `estado_actual_solucion_problema`
--

CREATE TABLE `estado_actual_solucion_problema` (
  `Id_Estado_Atenc` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_actual_solucion_problema`
--

INSERT INTO `estado_actual_solucion_problema` (`Id_Estado_Atenc`, `Descripcion`) VALUES
(1, 'ESPERANDO RETIRO P/SERVICIO TECNICO'),
(2, 'EN SERVICIO TECNICO EXTERNO'),
(3, 'SOLUCIONADO, ESPERANDO RETIRO DEL TITULAR'),
(4, 'EN ESPERA DE SOLUCION'),
(5, 'ESPERANDO PAQUETE DE PROVISION'),
(6, 'ESPERANDO CARGADOR/BATERIA'),
(7, 'RETIRADA POR EL TITULAR'),
(8, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_civil`
--

CREATE TABLE `estado_civil` (
  `Id_Estado_Civil` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_civil`
--

INSERT INTO `estado_civil` (`Id_Estado_Civil`, `Descripcion`) VALUES
(1, 'SOLTERO'),
(2, 'CASADO'),
(3, 'DIVORSIADO'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_denuncia`
--

CREATE TABLE `estado_denuncia` (
  `Id_Estado_Den` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_denuncia`
--

INSERT INTO `estado_denuncia` (`Id_Estado_Den`, `Detalle`) VALUES
(1, 'PRESENTADA'),
(2, 'ACEPTADA'),
(3, 'RECHAZADA');

-- --------------------------------------------------------

--
-- Table structure for table `estado_devolucion_prestamo`
--

CREATE TABLE `estado_devolucion_prestamo` (
  `Id_Estado_Devol` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_devolucion_prestamo`
--

INSERT INTO `estado_devolucion_prestamo` (`Id_Estado_Devol`, `Detalle`) VALUES
(1, 'FUNCIONANDO'),
(2, 'DAÑADO'),
(3, 'PENDIENTE');

-- --------------------------------------------------------

--
-- Stand-in structure for view `estado_documentacion_personas`
--
CREATE TABLE `estado_documentacion_personas` (
`Apellidos_Nombres` varchar(400)
,`Matricula` varchar(100)
,`Certificado_Pase` varchar(100)
,`Tiene_DNI` varchar(100)
,`Certificado_Medico` varchar(100)
,`Posee_Autorizacion` varchar(100)
,`Cooperadora` varchar(100)
,`Dni` int(11)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Estado` int(11)
,`Id_Cargo` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `estado_equipo`
--

CREATE TABLE `estado_equipo` (
  `Id_Estado` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_equipo`
--

INSERT INTO `estado_equipo` (`Id_Estado`, `Descripcion`) VALUES
(1, 'ACTIVO'),
(2, 'INACTIVO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_equipos_piso`
--

CREATE TABLE `estado_equipos_piso` (
  `Id_Estado_Equipo_piso` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_equipos_piso`
--

INSERT INTO `estado_equipos_piso` (`Id_Estado_Equipo_piso`, `Descripcion`) VALUES
(1, 'FUNCIONANDO'),
(2, 'NO FUNCIONA'),
(3, 'EN REPARACION'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Stand-in structure for view `estado_equipos_porcurso`
--
CREATE TABLE `estado_equipos_porcurso` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Cargo` int(11)
,`Id_Estado` int(11)
,`NroSerie` varchar(30)
,`Id_Sit_Estado` int(11)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Table structure for table `estado_equipo_devuelto`
--

CREATE TABLE `estado_equipo_devuelto` (
  `Id_Estado_Devol` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_equipo_devuelto`
--

INSERT INTO `estado_equipo_devuelto` (`Id_Estado_Devol`, `Detalle`) VALUES
(1, 'FUNCIONANDO'),
(2, 'DAÑADO'),
(3, 'PENDIENTE');

-- --------------------------------------------------------

--
-- Stand-in structure for view `estado_equipo_porcurso`
--
CREATE TABLE `estado_equipo_porcurso` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Cargo` int(11)
,`Id_Estado` int(11)
,`NroSerie` varchar(30)
,`Id_Sit_Estado` int(11)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Table structure for table `estado_espera_prestamo`
--

CREATE TABLE `estado_espera_prestamo` (
  `Id_Estado_Espera` int(11) NOT NULL,
  `Detalle` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_espera_prestamo`
--

INSERT INTO `estado_espera_prestamo` (`Id_Estado_Espera`, `Detalle`) VALUES
(1, 'SOLICITADO'),
(2, 'APROBADO'),
(3, 'RECHAZADO'),
(4, 'PENDIENTE'),
(5, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_establecimiento`
--

CREATE TABLE `estado_establecimiento` (
  `Id_Estado_Esc` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_establecimiento`
--

INSERT INTO `estado_establecimiento` (`Id_Estado_Esc`, `Detalle`) VALUES
(1, 'ACTIVA'),
(2, 'INACTIVA'),
(3, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_paquete`
--

CREATE TABLE `estado_paquete` (
  `Id_Estado_Paquete` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_paquete`
--

INSERT INTO `estado_paquete` (`Id_Estado_Paquete`, `Detalle`) VALUES
(6, 'SOLICITADO'),
(2, 'RECIBIDO'),
(3, 'PENDIENTE'),
(4, 'FUNCIONO'),
(5, 'NO FUNCIONO'),
(1, 'NUEVO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_pase`
--

CREATE TABLE `estado_pase` (
  `Id_Estado_Pase` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_pase`
--

INSERT INTO `estado_pase` (`Id_Estado_Pase`, `Descripcion`) VALUES
(1, 'PENDIENTE'),
(2, 'EN CURSO'),
(3, 'FINALIZADO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_persona`
--

CREATE TABLE `estado_persona` (
  `Id_Estado` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_persona`
--

INSERT INTO `estado_persona` (`Id_Estado`, `Descripcion`) VALUES
(1, 'REGULAR'),
(2, 'ABANDONO CON EQUIPO'),
(3, 'ABANDONO SIN EQUIPO'),
(4, 'EGRESO CON EQUIPO'),
(5, 'EGRESO SIN EQUIPO'),
(6, 'ACTIVO/A'),
(7, 'LICENCIA'),
(9, 'PASE CON EQUIPO'),
(10, 'PASE SIN EQUIPO'),
(11, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_prestamo_equipo`
--

CREATE TABLE `estado_prestamo_equipo` (
  `Id_Estado_Prestamo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_prestamo_equipo`
--

INSERT INTO `estado_prestamo_equipo` (`Id_Estado_Prestamo`, `Descripcion`) VALUES
(1, 'EN CURSO'),
(2, 'FINALIZADO');

-- --------------------------------------------------------

--
-- Table structure for table `estado_server`
--

CREATE TABLE `estado_server` (
  `Id_Estado` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estado_server`
--

INSERT INTO `estado_server` (`Id_Estado`, `Descripcion`) VALUES
(1, 'FUNCIONA'),
(2, 'NO FUNCIONA'),
(3, 'EN REPARACION'),
(4, 'ESPERANDO REPARACION'),
(5, 'OTRO');

-- --------------------------------------------------------

--
-- Stand-in structure for view `estado_titulares_cursos`
--
CREATE TABLE `estado_titulares_cursos` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Cuil` varchar(30)
,`Repitente` varchar(60)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Cargo` int(11)
,`Id_Estado` int(11)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `etiquetasequipos`
--
CREATE TABLE `etiquetasequipos` (
`Apellidos_Nombres` varchar(400)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
,`Id_Cargo` int(11)
,`Id_Estado` int(11)
,`Dni` int(11)
,`NroSerie` varchar(30)
);

-- --------------------------------------------------------

--
-- Table structure for table `historial_atencion`
--

CREATE TABLE `historial_atencion` (
  `Id_Historial` int(11) NOT NULL,
  `Detalle` varchar(500) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(200) DEFAULT NULL,
  `Id_Atencion` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `historial_atencion`
--

INSERT INTO `historial_atencion` (`Id_Historial`, `Detalle`, `Fecha_Actualizacion`, `Usuario`, `Id_Atencion`, `NroSerie`) VALUES
(2, 'Esperando retiro P/Servicio Tecnico', '2017-05-24', 'jjcervera', 9, 'AA4074072458'),
(7, 'RECEPCIONADO PARA ST', '2017-06-06', 'jjcervera', 10, 'AA4074068053'),
(6, 'Volvio de Servicio Tecnico', '2017-05-29', 'jjcervera', 9, 'AA4074072458');

-- --------------------------------------------------------

--
-- Stand-in structure for view `historial_atenciones`
--
CREATE TABLE `historial_atenciones` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Id_Atencion` int(11)
,`Detalle` varchar(500)
,`Fecha_Actualizacion` date
,`Usuario` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `liberacion_equipo`
--

CREATE TABLE `liberacion_equipo` (
  `Fecha_Finalizacion` varchar(100) DEFAULT NULL,
  `Observacion` varchar(300) DEFAULT NULL,
  `Id_Modalidad` int(11) NOT NULL,
  `Id_Nivel` int(11) NOT NULL,
  `Id_Autoridad` int(11) NOT NULL,
  `Fecha_Liberacion` date DEFAULT NULL,
  `Ruta_Archivo_Copia_Titulo` text,
  `Dni_Tutor` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lista_espera_prestamo`
--

CREATE TABLE `lista_espera_prestamo` (
  `Dni` int(11) NOT NULL,
  `Apellidos_Nombres` varchar(200) DEFAULT NULL,
  `Id_Motivo_Prestamo` int(11) NOT NULL,
  `Observacion` varchar(400) DEFAULT NULL,
  `Id_Curso` int(11) NOT NULL,
  `Id_Division` int(11) NOT NULL,
  `Id_Estado_Espera` int(11) NOT NULL DEFAULT '1',
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `localidades`
--

CREATE TABLE `localidades` (
  `Id_Localidad` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `Id_Departamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `localidades`
--

INSERT INTO `localidades` (`Id_Localidad`, `Nombre`, `Id_Departamento`) VALUES
(1, 'Alba Posse', 1),
(2, 'Colonia Aurora', 1),
(3, '25 de Mayo', 1),
(4, 'Apóstoles', 2),
(5, 'Azara', 2),
(6, 'San José', 2),
(7, 'Tres Capones', 2),
(8, 'Campo Grande', 3),
(9, 'Aristóbulo del Valle', 3),
(10, 'Dos de Mayo', 3),
(11, 'Santa Ana', 4),
(12, 'Bonpland', 4),
(13, 'Candelaria', 4),
(14, 'Cerro Corá', 4),
(15, 'Loreto', 4),
(16, 'Mártires', 4),
(17, 'Profundidad', 4),
(18, 'Fachinal', 5),
(19, 'Posadas', 5),
(20, 'Garupá', 5),
(21, 'Concepción de La Sierra', 6),
(22, 'Santa María', 6),
(23, 'Eldorado', 7),
(24, '9 de Julio', 7),
(25, 'Colonia Delicia', 7),
(26, 'Colonia Victoria', 7),
(27, 'Santiago de Liniers', 7),
(28, 'Bernardo de Irigoyen', 8),
(29, 'Comandante Andrés Guacurari', 8),
(30, 'San Antonio', 8),
(31, 'El Soberbio', 9),
(32, 'San Vicente', 9),
(33, 'Puerto Esperanza', 10),
(34, 'Colonia Wanda', 10),
(35, 'Puerto Iguazú', 10),
(36, 'Puerto Libertad', 10),
(37, 'Leandro N. Alem', 11),
(38, 'Almafuerte', 11),
(39, 'Arroyo del Medio', 11),
(40, 'Caá Yari', 11),
(41, 'Cerro Azul', 11),
(42, 'Dos Arroyos', 11),
(43, 'Gobernador López', 11),
(44, 'Olegario Víctor Andrade', 11),
(45, 'Puerto Rico', 12),
(46, 'Capioví', 12),
(47, 'El Alcázar', 12),
(48, 'Garuhapé', 12),
(49, 'Puerto Leoni', 12),
(50, 'Ruiz de Montoya', 12),
(51, 'Montecarlo', 13),
(52, 'Caraguatay', 13),
(53, 'Puerto Piray', 13),
(54, 'Oberá', 14),
(55, 'Campo Ramón', 14),
(56, 'Campo Viera', 14),
(57, 'Colonia Alberdi', 14),
(58, 'General Alvear', 14),
(59, 'Guaraní', 14),
(60, 'Los Helechos', 14),
(61, 'Panambí', 14),
(62, 'San Martín', 14),
(63, 'San Ignacio', 15),
(64, 'Colonia Polana', 15),
(65, 'Corpus', 15),
(66, 'General Urquiza', 15),
(67, 'Gobernador Roca', 15),
(68, 'Hipólito Yrigoyen', 15),
(69, 'Jardín América', 15),
(70, 'Santo Pipó', 15),
(71, 'San Javier', 16),
(72, 'Florentino Ameghino', 16),
(73, 'Itacaruaré', 16),
(74, 'Mojón Grande', 16),
(75, 'San Pedro', 17),
(76, 'Cruce Caballero', 17),
(77, 'Piñalito Sur', 17),
(78, 'Paraiso', 17),
(79, 'Tobuna', 17),
(80, 'Santa Rita', 1),
(81, 'Picada Mandarina', 9),
(82, 'El Socorro', 9),
(83, 'Rio Victoria', 9),
(84, 'Martin Güemes', 9),
(85, 'Otra', 0);

-- --------------------------------------------------------

--
-- Table structure for table `marca`
--

CREATE TABLE `marca` (
  `Id_Marca` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marca`
--

INSERT INTO `marca` (`Id_Marca`, `Nombre`) VALUES
(1, 'NOVATECH'),
(2, 'BANGHO'),
(3, 'POSITIVO BGH'),
(4, 'NOBLEX'),
(5, 'EXO'),
(7, 'CORADIR'),
(8, 'LENOVO'),
(9, 'SAMSUNG'),
(10, 'CDR'),
(11, 'CDX'),
(12, 'MAGALLANE'),
(13, 'EDUNEC'),
(14, 'PULSART'),
(15, 'DEPOT'),
(16, 'CX'),
(17, 'KEN BROWN'),
(18, 'NBX'),
(19, 'NEC'),
(20, 'PC BOX'),
(21, 'OTRA');

-- --------------------------------------------------------

--
-- Table structure for table `marca_server`
--

CREATE TABLE `marca_server` (
  `Id_Marca` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `marca_server`
--

INSERT INTO `marca_server` (`Id_Marca`, `Nombre`) VALUES
(1, 'EXO'),
(2, 'HP'),
(3, 'OTRA');

-- --------------------------------------------------------

--
-- Table structure for table `materias_adeudadas`
--

CREATE TABLE `materias_adeudadas` (
  `Id_Mat_Adeuda` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Id_Materia` int(11) NOT NULL,
  `Observacion` varchar(400) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `materias_anuales`
--

CREATE TABLE `materias_anuales` (
  `Id_Materia` int(11) NOT NULL,
  `Nombre` varchar(300) DEFAULT NULL,
  `Id_Curso` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `materias_anuales`
--

INSERT INTO `materias_anuales` (`Id_Materia`, `Nombre`, `Id_Curso`) VALUES
(1, 'MATEMATICA I', 1),
(2, 'MATEMATICA II', 2),
(3, 'LENGUA III', 3),
(4, 'HISTORIA IV', 4),
(5, 'LENGUA I', 5);

-- --------------------------------------------------------

--
-- Table structure for table `modalidad_establecimiento`
--

CREATE TABLE `modalidad_establecimiento` (
  `Id_Modalidad` int(11) NOT NULL,
  `Nombre` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modalidad_establecimiento`
--

INSERT INTO `modalidad_establecimiento` (`Id_Modalidad`, `Nombre`) VALUES
(1, 'ECONOMIA Y GESTION'),
(2, 'HUMANIDADES Y CS. SOC.'),
(3, 'OTRA');

-- --------------------------------------------------------

--
-- Table structure for table `modelo`
--

CREATE TABLE `modelo` (
  `Id_Modelo` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL,
  `Id_Marca` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modelo`
--

INSERT INTO `modelo` (`Id_Modelo`, `Descripcion`, `Id_Marca`) VALUES
(20, 'OTRO', 21),
(19, 'OTRO', 20),
(18, 'OTRO', 19),
(17, 'OTRO', 18),
(16, 'OTRO', 17),
(15, 'OTRO', 16),
(14, 'OTRO', 15),
(13, 'OTRO', 14),
(12, 'OTRO', 13),
(11, 'OTRO', 12),
(10, 'OTRO', 11),
(9, 'OTRO', 10),
(8, 'OTRO', 9),
(7, 'OTRO', 8),
(6, 'OTRO', 7),
(5, 'OTRO', 5),
(4, 'OTRO', 4),
(3, 'OTRO', 3),
(2, 'OTRO', 2),
(1, 'OTRO', 1),
(26, 'MG101A3', 13),
(24, 'EXOMATE N201', 5),
(23, 'SCHOOLMATE 14 TV', 3),
(22, 'SUMA 1025', 2),
(21, 'NVTEF10MIX', 1),
(25, 'N150P', 9),
(27, 'CLASS', 10),
(28, 'EDUNEC 3', 13);

-- --------------------------------------------------------

--
-- Table structure for table `modelo_server`
--

CREATE TABLE `modelo_server` (
  `Id_Modelo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `modelo_server`
--

INSERT INTO `modelo_server` (`Id_Modelo`, `Descripcion`) VALUES
(1, 'RAQUEABLE'),
(2, 'NET SERVER'),
(3, 'TRADICIONAL'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `motivo_devolucion`
--

CREATE TABLE `motivo_devolucion` (
  `Id_Motivo` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `motivo_devolucion`
--

INSERT INTO `motivo_devolucion` (`Id_Motivo`, `Detalle`) VALUES
(1, 'ABANDÓNO'),
(9, 'OTRO'),
(5, 'PASE A ESCUELA QUE NO CORRESPONDA'),
(6, 'FINALIZO FUERA DE TERMINO'),
(7, 'PERDIDA DE REGULARIDAD');

-- --------------------------------------------------------

--
-- Table structure for table `motivo_pedido_paquetes`
--

CREATE TABLE `motivo_pedido_paquetes` (
  `Id_Motivo` int(11) NOT NULL,
  `Detalle` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `motivo_pedido_paquetes`
--

INSERT INTO `motivo_pedido_paquetes` (`Id_Motivo`, `Detalle`) VALUES
(1, 'VOLVIO DE ST CON OTRO S/N'),
(2, 'PASE DE ESCUELA'),
(3, 'NO CORRESPONDE S/N'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `motivo_prestamo_equipo`
--

CREATE TABLE `motivo_prestamo_equipo` (
  `Id_Motivo_Prestamo` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `motivo_prestamo_equipo`
--

INSERT INTO `motivo_prestamo_equipo` (`Id_Motivo_Prestamo`, `Descripcion`) VALUES
(1, 'EQUIPO EN/PARA SERVICIO TECNICO'),
(2, 'SIN EQUIPO POR ROBO/PERDIDA'),
(3, 'EQUIPO EN ESPERA EN EL LABORATORIO'),
(4, 'SIN EQUIPO POR PASE PENDIENTE'),
(5, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `motivo_reasignacion`
--

CREATE TABLE `motivo_reasignacion` (
  `Id_Motivo_Reasig` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `motivo_reasignacion`
--

INSERT INTO `motivo_reasignacion` (`Id_Motivo_Reasig`, `Descripcion`) VALUES
(1, 'SIN EQUIPO POR PASE DESDE UN PRIVADO'),
(2, 'PASE DESDE OTRA PROVINCIA'),
(3, 'NUNCA RECIBIO'),
(4, 'EQUIPO ORIGINAL CON FALLAS'),
(5, 'EQUIPO EN REPARACIÓN EXCEDIDO DE TIEMPO'),
(6, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `nivel_educativo`
--

CREATE TABLE `nivel_educativo` (
  `Id_Nivel` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nivel_educativo`
--

INSERT INTO `nivel_educativo` (`Id_Nivel`, `Detalle`) VALUES
(1, 'BASICO'),
(2, 'MEDIO'),
(3, 'SUPERIOR'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `novedades`
--

CREATE TABLE `novedades` (
  `Id_Novedad` int(11) NOT NULL,
  `Detalle` varchar(900) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(200) DEFAULT NULL,
  `Archivos` text,
  `Links` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `observacion_equipo`
--

CREATE TABLE `observacion_equipo` (
  `Id_Observacion` int(11) NOT NULL,
  `Detalle` varchar(500) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `NroSerie` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `observacion_equipo`
--

INSERT INTO `observacion_equipo` (`Id_Observacion`, `Detalle`, `Fecha_Actualizacion`, `NroSerie`) VALUES
(1, 'EN POSADAS', '2017-04-23', '6051081322'),
(2, 'EN POSADAS', '2017-04-23', '8051073939'),
(3, 'EN POSADAS', '2017-04-23', '1051071203'),
(4, 'EN POSADAS', '2017-04-23', '8051073352'),
(5, 'EN POSADAS', '2017-04-23', '3051021964'),
(6, 'EN POSADAS', '2017-04-23', '51060735'),
(7, 'EN POSADAS', '2017-04-23', 'SZSE10IS201213970'),
(8, 'EN POSADAS', '2017-04-23', '7051037443'),
(9, 'EN POSADAS', '2017-04-23', '1051022635'),
(10, 'EN POSADAS', '2017-04-23', '7051060043'),
(11, 'EN POSADAS', '2017-04-23', '6051059958'),
(12, 'EN POSADAS', '2017-04-23', '4051027688'),
(13, 'EN POSADAS', '2017-04-23', '8051061551'),
(14, 'EN POSADAS', '2017-04-23', '8051081038'),
(15, 'EN POSADAS', '2017-04-23', '5051072862'),
(16, 'EN POSADAS', '2017-04-24', 'AA0163012125'),
(17, 'EN POSADAS', '2017-04-24', 'AA2163022753'),
(18, 'EN POSADAS', '2017-04-24', 'AA5163012222'),
(19, 'EN POSADAS', '2017-04-24', '7051068355'),
(20, 'EN POSADAS', '2017-04-24', 'AA0163010852'),
(21, 'EN POSADAS', '2017-04-24', 'AA0163011713'),
(22, 'EN POSADAS', '2017-04-24', 'AA1163016630'),
(23, 'EN POSADAS', '2017-04-24', '7051021079'),
(24, 'ROBADA', '2017-04-24', '6051023449'),
(25, 'ROBADA', '2017-04-24', 'AA3313671570'),
(26, 'El equipo se encuentra Esperando retiro para Servicio Técnico', '2017-05-23', 'AA4074072458'),
(27, 'El equipo se encuentra Esperando retiro para Servicio Técnico', '2017-05-23', 'AA4074072458'),
(28, 'El equipo volvio de Servicio Técnico', '2017-05-29', 'AA4074072458');

-- --------------------------------------------------------

--
-- Table structure for table `observacion_persona`
--

CREATE TABLE `observacion_persona` (
  `Id_Observacion` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `Detalle` varchar(500) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `observacion_tutor`
--

CREATE TABLE `observacion_tutor` (
  `Id_Observacion` int(11) NOT NULL,
  `Detalle` varchar(500) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Dni_Tutor` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ocupacion_tutor`
--

CREATE TABLE `ocupacion_tutor` (
  `Id_Ocupacion` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ocupacion_tutor`
--

INSERT INTO `ocupacion_tutor` (`Id_Ocupacion`, `Descripcion`) VALUES
(7, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `paises`
--

CREATE TABLE `paises` (
  `Id_Pais` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paises`
--

INSERT INTO `paises` (`Id_Pais`, `Nombre`) VALUES
(1, 'ARGENTINA'),
(2, 'PARAGUAY'),
(3, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `paquetes_provision`
--

CREATE TABLE `paquetes_provision` (
  `NroPedido` int(10) NOT NULL,
  `Id_Hardware` varchar(20) DEFAULT NULL,
  `SN` varchar(20) DEFAULT NULL,
  `Marca_Arranque` varchar(18) DEFAULT NULL,
  `Id_Tipo_Extraccion` int(11) NOT NULL,
  `Id_Estado_Paquete` int(11) NOT NULL,
  `Id_Motivo` int(11) NOT NULL,
  `Serie_Server` varchar(100) NOT NULL,
  `Email_Solicitante` varchar(200) DEFAULT 'PENDIENTE',
  `Usuario` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Id_Tipo_Paquete` int(11) DEFAULT NULL,
  `Serie_Netbook` varchar(100) DEFAULT NULL,
  `Apellido_Nombre_Solicitante` varchar(100) DEFAULT NULL,
  `Dni` int(40) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pase_establecimiento`
--

CREATE TABLE `pase_establecimiento` (
  `Id_Pase` int(11) NOT NULL,
  `Serie_Equipo` varchar(50) DEFAULT NULL,
  `Id_Hardware` varchar(50) DEFAULT NULL,
  `SN` varchar(40) DEFAULT NULL,
  `Modelo_Net` varchar(100) DEFAULT NULL,
  `Nombre_Titular` varchar(200) DEFAULT NULL,
  `Dni_Titular` int(11) DEFAULT NULL,
  `Cuil_Titular` varchar(40) DEFAULT NULL,
  `Nombre_Tutor` varchar(200) DEFAULT NULL,
  `DniTutor` int(11) DEFAULT NULL,
  `Domicilio` varchar(200) DEFAULT NULL,
  `Tel_Tutor` varchar(50) DEFAULT NULL,
  `CelTutor` varchar(50) DEFAULT NULL,
  `Cue_Establecimiento_Alta` varchar(100) DEFAULT NULL,
  `Escuela_Alta` varchar(200) DEFAULT NULL,
  `Directivo_Alta` varchar(200) DEFAULT NULL,
  `Cuil_Directivo_Alta` varchar(30) DEFAULT NULL,
  `Dpto_Esc_alta` varchar(50) DEFAULT NULL,
  `Localidad_Esc_Alta` varchar(50) DEFAULT NULL,
  `Domicilio_Esc_Alta` varchar(200) DEFAULT NULL,
  `Rte_Alta` varchar(200) DEFAULT NULL,
  `Tel_Rte_Alta` varchar(100) DEFAULT NULL,
  `Email_Rte_Alta` varchar(200) DEFAULT NULL,
  `Serie_Server_Alta` varchar(100) DEFAULT NULL,
  `Cue_Establecimiento_Baja` varchar(100) DEFAULT NULL,
  `Escuela_Baja` varchar(200) DEFAULT NULL,
  `Directivo_Baja` varchar(200) DEFAULT NULL,
  `Cuil_Directivo_Baja` varchar(30) DEFAULT NULL,
  `Dpto_Esc_Baja` varchar(50) DEFAULT NULL,
  `Localidad_Esc_Baja` varchar(50) DEFAULT NULL,
  `Domicilio_Esc_Baja` varchar(200) DEFAULT NULL,
  `Rte_Baja` varchar(200) DEFAULT NULL,
  `Tel_Rte_Baja` varchar(100) DEFAULT NULL,
  `Email_Rte_Baja` varchar(200) DEFAULT NULL,
  `Serie_Server_Baja` varchar(100) DEFAULT NULL,
  `Fecha_Pase` date DEFAULT NULL,
  `Id_Estado_Pase` int(11) NOT NULL,
  `Marca_Arranque` varchar(20) DEFAULT NULL,
  `Ruta_Archivo` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pase_establecimiento`
--

INSERT INTO `pase_establecimiento` (`Id_Pase`, `Serie_Equipo`, `Id_Hardware`, `SN`, `Modelo_Net`, `Nombre_Titular`, `Dni_Titular`, `Cuil_Titular`, `Nombre_Tutor`, `DniTutor`, `Domicilio`, `Tel_Tutor`, `CelTutor`, `Cue_Establecimiento_Alta`, `Escuela_Alta`, `Directivo_Alta`, `Cuil_Directivo_Alta`, `Dpto_Esc_alta`, `Localidad_Esc_Alta`, `Domicilio_Esc_Alta`, `Rte_Alta`, `Tel_Rte_Alta`, `Email_Rte_Alta`, `Serie_Server_Alta`, `Cue_Establecimiento_Baja`, `Escuela_Baja`, `Directivo_Baja`, `Cuil_Directivo_Baja`, `Dpto_Esc_Baja`, `Localidad_Esc_Baja`, `Domicilio_Esc_Baja`, `Rte_Baja`, `Tel_Rte_Baja`, `Email_Rte_Baja`, `Serie_Server_Baja`, `Fecha_Pase`, `Id_Estado_Pase`, `Marca_Arranque`, `Ruta_Archivo`) VALUES
(1, 'AA8163016701', '6C71D94DB771', NULL, 'EXOMATE N201', 'JARA ALDANA BELEN', 42666838, '27426668381', 'GONZALEZ MARCELA', 17090818, 'LIBERTAD', NULL, NULL, '540176400', 'EPET N° 33', 'BENITEZ JULIO CESAR', '20162941063', 'Iguazú', 'Puerto Libertad', 'RUTAN°12', 'OLMEDO RAMON', '0', '0', 'T002-4152000756', '540055800', 'B.O.P. N° 22', 'LEIVAS JORGE OSCAR', '20147750499', 'Iguazú', 'Puerto Libertad', '--', 'CERVERA JUAN JOSÉ', '03757496067', 'RTE.BOP22@GMAIL.COM', '0696686A055', '2017-04-24', 2, '5', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `pedido_paquetes`
--
CREATE TABLE `pedido_paquetes` (
`Cue` varchar(100)
,`Sigla` varchar(100)
,`Id_Zona` int(11)
,`Id_Hardware` varchar(20)
,`SN` varchar(20)
,`Marca_Arranque` varchar(18)
,`Id_Tipo_Extraccion` int(11)
,`Id_Estado_Paquete` int(11)
,`Id_Motivo` int(11)
,`Serie_Server` varchar(100)
,`Email_Solicitante` varchar(200)
,`Id_Tipo_Paquete` int(11)
,`Serie_Netbook` varchar(100)
,`Apellido_Nombre_Solicitante` varchar(100)
,`Dni` int(40)
,`Fecha_Actualizacion` date
,`Usuario` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `pedido_st`
--
CREATE TABLE `pedido_st` (
`CUE` varchar(100)
,`Sigla` varchar(100)
,`Id_Zona` int(11)
,`DEPARTAMENTO` varchar(200)
,`LOCALIDAD` varchar(200)
,`SERIE NETBOOK` varchar(30)
,`N° TIKET` varchar(50)
,`PROBLEMA` varchar(200)
,`Id_Tipo_Retiro` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `personas`
--

CREATE TABLE `personas` (
  `Dni` int(11) NOT NULL,
  `Apellidos_Nombres` varchar(400) DEFAULT NULL,
  `Edad` varchar(5) DEFAULT NULL,
  `Domicilio` varchar(40) DEFAULT NULL,
  `Tel_Contacto` varchar(20) DEFAULT NULL,
  `Fecha_Nac` varchar(18) DEFAULT NULL,
  `Cuil` varchar(30) DEFAULT NULL,
  `Lugar_Nacimiento` varchar(200) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(18) DEFAULT NULL,
  `Cod_Postal` varchar(8) DEFAULT NULL,
  `Repitente` varchar(60) DEFAULT NULL,
  `Id_Sexo` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Id_Estado` int(11) NOT NULL,
  `Id_Curso` int(11) NOT NULL,
  `Id_Division` int(11) NOT NULL,
  `Id_Turno` int(11) NOT NULL,
  `Id_Estado_Civil` int(11) DEFAULT NULL,
  `Dni_Tutor` int(11) NOT NULL,
  `NroSerie` varchar(30) DEFAULT NULL,
  `Id_Cargo` int(11) NOT NULL,
  `Foto` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personas`
--

INSERT INTO `personas` (`Dni`, `Apellidos_Nombres`, `Edad`, `Domicilio`, `Tel_Contacto`, `Fecha_Nac`, `Cuil`, `Lugar_Nacimiento`, `Fecha_Actualizacion`, `Usuario`, `Cod_Postal`, `Repitente`, `Id_Sexo`, `Id_Departamento`, `Id_Provincia`, `Id_Localidad`, `Id_Estado`, `Id_Curso`, `Id_Division`, `Id_Turno`, `Id_Estado_Civil`, `Dni_Tutor`, `NroSerie`, `Id_Cargo`, `Foto`) VALUES
(27289607, 'CERVERA JUAN JOSE', NULL, NULL, NULL, NULL, '2027289607', NULL, NULL, NULL, '3378', 'NO', 3, 10, 1, 36, 1, 17, 13, 1, 4, 2027289607, 'AA4074068053', 1, NULL),
(25951452, 'CORREA ANA ALEJANDRA', NULL, NULL, NULL, NULL, '20259514526', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 2147483647, 'AA9184119456', 1, NULL),
(25467710, 'RIBALTOWSKI MARIA ALEJAN', NULL, NULL, NULL, NULL, '27254677103', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25467710, 'AA4074066578', 1, NULL),
(25315466, 'MARECO RAMON', NULL, NULL, NULL, NULL, '20253154668', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051068259', 1, NULL),
(25313064, 'CHAVEZ DIEGO OMAR', NULL, NULL, NULL, NULL, '23253130644', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25313064, '8051029450', 1, NULL),
(24903013, 'RODRIGUEZ CEFERINO MARTIN', NULL, NULL, NULL, NULL, '23249030139', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24903013, 'AA9184140410', 1, NULL),
(24613765, 'PETER MIRTA HAYDEE', NULL, NULL, NULL, NULL, '27246137655', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 17, 13, 1, 4, 93121680, 'AA4074054631', 1, NULL),
(23399095, 'PEREIRA MARGARITA\n', NULL, NULL, NULL, NULL, '27233990952', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA2074061738', 1, NULL),
(22164629, 'NUÑEZ RAMON', NULL, NULL, NULL, NULL, '20221646291', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22164629, 'AA4074087729', 1, NULL),
(21852797, 'WIESNER OMAR', NULL, NULL, NULL, NULL, '20218527974', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3074113685', 1, NULL),
(21814312, 'PEÑA JUAN ROLANDO', NULL, NULL, NULL, NULL, '20218143122', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21814312, 'AA9184140540', 1, NULL),
(20676271, 'MONTIEL FELIPE', NULL, NULL, NULL, NULL, '20206762714', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1074167717', 1, NULL),
(20396909, 'VINCENTI CARLOS EDGARDO', NULL, NULL, NULL, NULL, '20203969091', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20396909, '0051072336', 1, NULL),
(20297567, 'BENITEZ MARIA DEL CARMEN', NULL, NULL, NULL, NULL, '23202975674', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20297567, '4051059746', 1, NULL),
(20242760, 'ZARZA JOAQUIN MANUEL', NULL, NULL, NULL, NULL, '27202427605', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20242760, '2051080975', 1, NULL),
(20177004, 'ACOSTA REINA MONICA', NULL, NULL, NULL, NULL, '27201770049', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 2147483647, 'AA9184140485', 1, NULL),
(18719251, 'BRITOS MARIA ROSA', NULL, NULL, NULL, NULL, '27187192515', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9184128036', 1, NULL),
(18266673, 'MORA SUSANA ALICIA', NULL, NULL, NULL, NULL, '23182666734', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7184070766', 1, NULL),
(17563034, 'CESPEDES OSCAR DAVID', NULL, NULL, NULL, NULL, '20175630342', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563034, 'AA4074078508', 1, NULL),
(17019399, 'GOMEZ JOSE ONOFRE', NULL, NULL, NULL, NULL, '20170193998', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17019399, '2051055602', 1, NULL),
(16378739, 'CARDOZO NORMA GLADYS', NULL, NULL, NULL, NULL, '27163787399', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16378739, '6051073291', 1, NULL),
(16317462, 'RIVOLTA AZUCENA', NULL, NULL, NULL, NULL, '27163174621', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3074134314', 1, NULL),
(16279810, 'GALARZA ELISA ISABEL', NULL, NULL, NULL, NULL, '27162798109', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9184144060', 1, NULL),
(14775049, 'LEIVAS JORGE OSCAR', NULL, NULL, NULL, NULL, '20147750499', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3074090593', 1, NULL),
(13444992, 'PRESTADA KOLBO ELENA MARIA', NULL, NULL, NULL, NULL, '27134449921', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25315466, 'AA4074070597', 1, NULL),
(13149459, 'NUÑEZ NORMA BEATRIZ ', NULL, NULL, NULL, NULL, '27131494594', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13149459, 'AA9184138864', 1, NULL),
(11791201, 'FUEYO GRACIELA SUSANA', NULL, NULL, NULL, NULL, '27117912014', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '4051068309', 1, NULL),
(75, 'KOLBO ELENA MARIA', NULL, NULL, NULL, NULL, '27134449921', NULL, '2017-04-23', 'Administrator', '3374', 'NO', 2, 10, 1, 36, 6, 10, 13, 2, 4, 13444992, 'AA2074150881', 1, NULL),
(76, 'REM (MONTIEL )', NULL, NULL, NULL, NULL, '27147750499', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 14755049, 'AA4074067068', 1, NULL),
(78, 'PAREDES YESICA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3074070704', 1, NULL),
(79, 'VILLALBA MILAGROS LUJAN', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7313680800', 1, NULL),
(80, 'GARCIA MARCELO', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3313675935', 1, NULL),
(81, 'QUIROZ BRUNO\n', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3313670250', 1, NULL),
(82, 'RIOS GABRIEL', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA5152055537', 1, NULL),
(84, 'GODOY JONATHAN', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA2163605356', 1, NULL),
(85, 'KRON ENZO', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA4163603836', 1, NULL),
(86, 'JEJER MANUELA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051021313', 1, NULL),
(87, 'LOPEZ ROCIO BELEN', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '4051072348', 1, NULL),
(88, 'GONZALEZ CRISTIAN RAFAEL', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351080, '2051022644', 1, NULL),
(89, 'MOREL SANTIAGO', NULL, NULL, NULL, NULL, '0', NULL, '2017-04-25', 'mpereira', '3374', 'NO', 1, 10, 1, 36, 1, 2, 2, 2, 4, 14755049, 'AA2074057391', 1, NULL),
(90, 'ZARATE GABRIEL', NULL, NULL, NULL, NULL, '0', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 1, 10, 1, 36, 6, 10, 13, 1, 4, 27205363, 'AA4074078679', 1, NULL),
(91, 'ORTIGOZA YENNY LONELA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'SI', 3, 10, 1, 36, 1, 17, 13, 1, 4, 29295972, 'AA4074078803', 1, NULL),
(92, 'NASCIMENTO MELANIE', NULL, NULL, NULL, NULL, '0', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 14755049, 'AA4074072208', 1, NULL),
(93, 'DUDA ANELIS YISELA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051073827', 1, NULL),
(94, 'NUÑEZ NORMA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '7051072769', 1, NULL),
(95, 'CABRAL ANTONIO', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1163602986', 1, NULL),
(27431555, 'DOMINGUEZ SINTIA TAMARA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7184069173', 1, NULL),
(27431730, 'INSAURRALDE NIDIA BEATRIZ', NULL, NULL, NULL, NULL, '27274317308', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7184067604', 1, NULL),
(27588105, 'CABRAL RAMONA EUGENIA', NULL, NULL, NULL, NULL, '27275881053', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA5074145713', 1, NULL),
(28484452, 'PEREIRA PATRICIA', NULL, NULL, NULL, NULL, '27284844527', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051073123', 1, NULL),
(28905415, 'HOFFMANN VIVIAN MARLENE', NULL, NULL, NULL, NULL, '23289054154', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9184128045', 1, NULL),
(29295972, 'ORTEGA MARIA SOLEDAD', NULL, NULL, NULL, NULL, '27292959724', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9184135014', 1, NULL),
(29576052, 'BECK NOELIA BEATRIZ', NULL, NULL, NULL, NULL, '23295760524', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA2184074637', 1, NULL),
(31150241, 'CAR DIR - USO ESCOLAR', NULL, NULL, NULL, NULL, '20311502418', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051072775', 1, NULL),
(32118085, 'TOLEDO EVANGELINA SOLEDAD', NULL, NULL, NULL, NULL, '27321180855', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9184144117', 1, NULL),
(32304988, 'ESPINOLA GLORIA ANDREA', NULL, NULL, NULL, NULL, '27323049888', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA2074076234', 1, NULL),
(32736874, 'VAZQUEZ SELVA', NULL, NULL, NULL, NULL, '27327368740', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32736874, 'AA4074078344', 1, NULL),
(32763874, 'VAZQUEZ SELVA', NULL, NULL, NULL, NULL, '27327638740', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0051030134', 1, NULL),
(34451087, 'LOPEZ LUISA EUGENIA', NULL, NULL, NULL, NULL, '27344510879', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051072254', 1, NULL),
(34453251, 'DUDA SILVANA ANTONELLA', NULL, NULL, NULL, NULL, '27344532511', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051061229', 1, NULL),
(36097819, 'REM DAÑADA', NULL, NULL, NULL, NULL, '27360978198', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1051081683', 1, NULL),
(36097828, 'REM DAÑADA', NULL, NULL, NULL, NULL, '20360978282', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 1645198, '2051060049', 1, NULL),
(36097864, 'ZACARIAS FACUNDO MANUEL', NULL, NULL, NULL, NULL, '20360978649', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051071626', 1, NULL),
(36097876, 'PERALTA APARICIO JAVIER', NULL, NULL, NULL, NULL, '20360978762', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18266623, '0051081103', 1, NULL),
(36097880, 'REM DAÑADO', NULL, NULL, NULL, NULL, '20360978800', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051060102', 1, NULL),
(36097886, 'REM DAÑADO', NULL, NULL, NULL, NULL, '27360978864', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0051072963', 1, NULL),
(36097896, 'BAREIRO CESAR NICOLAS', NULL, NULL, NULL, NULL, '20360978967', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051024077', 1, NULL),
(36097902, 'ALFONSO RUBEN GONZALO', NULL, NULL, NULL, NULL, '20360979025', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17317752, '5051061568', 1, NULL),
(36097941, 'RAMOS ROMINA GABRIELA', NULL, NULL, NULL, NULL, '27360979410', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051026430', 1, NULL),
(36097972, 'LOPEZ VIRGINIA MICAELA', NULL, NULL, NULL, NULL, '27360979720', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051027686', 1, NULL),
(36097981, 'INSFRAN LUIS ALEJANDRO', NULL, NULL, NULL, NULL, '20360979815', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26751373, '9051072993', 1, NULL),
(36097986, 'REM DAÑADA', NULL, NULL, NULL, NULL, '27360979860', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051061204', 1, NULL),
(36097989, 'BAEZ CLAUDIO ADRIAN', NULL, NULL, NULL, NULL, '20360979890', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14493714, 'AA1163016220', 1, NULL),
(36330600, 'BLANCO SEMKE CRISTINA SOLEDAD', NULL, NULL, NULL, NULL, '24363306000', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28484452, 'AA4074078740', 1, NULL),
(36457771, 'MAIDANA PERLA SOLEDAD', NULL, NULL, NULL, NULL, '27364577716', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 36457771, 'AA5074151336', 1, NULL),
(36464258, 'AQUINO HORACIO ADRIAN', NULL, NULL, NULL, NULL, '20364642580', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29576094, '9051068152', 1, NULL),
(36464298, 'DILL AQUINO ELIANA LISANDRA', NULL, NULL, NULL, NULL, '23364642989', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '4051059931', 1, NULL),
(36464435, 'ESPINOLA SUSANA NOEMI', NULL, NULL, NULL, NULL, '27364644359', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11523433, '2051072989', 1, NULL),
(36464452, 'SAUCEDO ROSALINO SEBASTIAN', NULL, NULL, NULL, NULL, '20364644524', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078687, '0', 1, NULL),
(36464473, 'GARCIA ROMINA DENISE', NULL, NULL, NULL, NULL, '27364644731', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24147356, '9051072827', 1, NULL),
(36464476, 'PERALTA YESICA ALEJANDRA', NULL, NULL, NULL, NULL, '27364644766', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '7051055941', 1, NULL),
(36470840, 'BUENO SERGIO ARMANDO', NULL, NULL, NULL, NULL, '20364708409', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17164585, '4051061564', 1, NULL),
(36916877, 'CAMPOS SOFIA ', NULL, NULL, NULL, NULL, '27369168776', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20477476, '8051081576', 1, NULL),
(37473660, 'WIEDEMANN NANCY GRACIELA', NULL, NULL, NULL, NULL, '23374736604', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33866064, '2051059957', 1, NULL),
(38197480, 'FRANCO KAREN JOHANA', NULL, NULL, NULL, NULL, '23381974804', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '4051027688', 1, NULL),
(38567013, 'PERALTA ALBA NATALIA', NULL, NULL, NULL, NULL, '27385670139', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23218607, '5051072862', 1, NULL),
(38567020, 'GONZALEZ DEBORA ELIZABET', NULL, NULL, NULL, NULL, '27385670201', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93414178, '5051061203', 1, NULL),
(38567026, 'BRUNO SILVINA MABEL', NULL, NULL, NULL, NULL, '27385670260', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051060253', 1, NULL),
(38567027, 'IRALA FLORENCIA', NULL, NULL, NULL, NULL, '27385670279', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0051021241', 1, NULL),
(38567044, 'PERALTA DIANA BELEN', NULL, NULL, NULL, NULL, '27385670449', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23354103, '0051080798', 1, NULL),
(38567045, 'GARCIA JULIA CELESTE', NULL, NULL, NULL, NULL, '27385670457', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24545356, '5051072782', 1, NULL),
(38567046, 'PERALTA MAURICIO ALFREDO', NULL, NULL, NULL, NULL, '20385670460', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051061248', 1, NULL),
(38567048, 'BARBOZA DE MOURA ANDRES E.', NULL, NULL, NULL, NULL, '20385670487', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0051038595', 1, NULL),
(38567078, 'AVELLANEDA WILLIAN MANUEL', NULL, NULL, NULL, NULL, '20385670789', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33864936, '0051023025', 1, NULL),
(38567082, 'REY FERNANDO RAUL', NULL, NULL, NULL, NULL, '20385670827', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '5051072405', 1, NULL),
(38567083, 'SANCHEZ GRACIELA BEATRIZ', NULL, NULL, NULL, NULL, '23385670834', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051059801', 1, NULL),
(38567088, 'MARQUEZ TAMARA ROMINA', NULL, NULL, NULL, NULL, '27385670880', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '5051059817', 1, NULL),
(38567100, 'CAMACHO CARLOS ANDRES', NULL, NULL, NULL, NULL, '20385671009', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351016, '6051037921', 1, NULL),
(38691297, 'MORINIGO MARIA BELEN', NULL, NULL, NULL, NULL, '27386912977', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '5051073342', 1, NULL),
(38774296, 'BENITEZ CAROLINA SOLEDAD', NULL, NULL, NULL, NULL, '23387742964', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21750288, '4051061352', 1, NULL),
(38834024, 'MEIRA MARIA BELEN', NULL, NULL, NULL, NULL, '27388340245', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92014058, '4051072920', 1, NULL),
(39042620, 'BARRIOS NATALIA', NULL, NULL, NULL, NULL, '27390426203', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8191026029', 1, NULL),
(39042697, 'AQUINO YESICA ESTEFANI', NULL, NULL, NULL, NULL, '27390426971', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18880061, '0051081407', 1, NULL),
(39044102, 'TORALES FERNANDO ABEL(REM)', NULL, NULL, NULL, NULL, '23390441029', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1163018829', 1, NULL),
(39044106, 'SANTANDER JANINA NOELIA', NULL, NULL, NULL, NULL, '27390441067', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18781457, '7051073324', 1, NULL),
(39044108, 'GUERRERO ANIBAL FABIAN', NULL, NULL, NULL, NULL, '20390441089', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588129, '3051059044', 1, NULL),
(39044109, 'RECALDE MARCIA ESTELA', NULL, NULL, NULL, NULL, '27390441091', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33160715, '1051023022', 1, NULL),
(39044118, 'VAZQUEZ CELSO AUGUSTO', NULL, NULL, NULL, NULL, '20390441186', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225393, '3051025198', 1, NULL),
(39044122, 'MEIRA PABLO ANTONIO', NULL, NULL, NULL, NULL, '20390441224', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12803390, '8051073020', 1, NULL),
(39044123, 'RIVERO ESTEBAN FABIAN', NULL, NULL, NULL, NULL, '20390441232', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051073069', 1, NULL),
(39044130, 'FARIÑA MAURO ALBERTO', NULL, NULL, NULL, NULL, '20390441305', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18266643, '1051061225', 1, NULL),
(39044131, 'FERREIRA TAMARA SOLEDAD', NULL, NULL, NULL, NULL, '27390441318', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 8102865, '4051060586', 1, NULL),
(39044132, 'GONZALEZ MARCIO LUIS', NULL, NULL, NULL, NULL, '20390441321', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24506756, '5051061574', 1, NULL),
(39044133, 'PORTILLO TAMARA CELESTE', NULL, NULL, NULL, NULL, '27390441334', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671667, '5051025867', 1, NULL),
(39044134, 'RECALDE NOELIA BEATRIZ', NULL, NULL, NULL, NULL, '27390441342', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18639017, '7051072805', 1, NULL),
(39044138, 'FERNANDEZ GUILLERMO LEANDRO', NULL, NULL, NULL, NULL, '20390441380', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93129160, '3051081419', 1, NULL),
(39044153, 'MACHADO SONIA ELISABET', NULL, NULL, NULL, NULL, '27390441539', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94088323, '3051073010', 1, NULL),
(39044162, 'CARDOZO MAIARA BEATRIZ', NULL, NULL, NULL, NULL, '27390441628', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 10842648, '1051056341', 1, NULL),
(39044169, 'FERRERO SANDRA MICAELA', NULL, NULL, NULL, NULL, '27390441695', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14850226, '0051048600', 1, NULL),
(39044171, 'LOPEZ ALEJANDRO DE JESUS', NULL, NULL, NULL, NULL, '20390441712', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18127280, '4051060044', 1, NULL),
(39044172, 'FRANCO GLADYS MARCELA', NULL, NULL, NULL, NULL, '27390441725', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18479591, '1051081409', 1, NULL),
(39044177, 'SOTELO YESICA ALEJANDRA', NULL, NULL, NULL, NULL, '27390441776', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32736608, '0051060255', 1, NULL),
(39044182, 'FELIPE DE OLIVERA DENISSE CAROLINA', NULL, NULL, NULL, NULL, '27390441822', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18717371, '4051063556', 1, NULL),
(39044185, 'VERA ARMANDO LUIS', NULL, NULL, NULL, NULL, '20390441852', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27998799, '1051059224', 1, NULL),
(39044186, 'GONZALEZ MICAELA BEATRIZ', NULL, NULL, NULL, NULL, '27390441865', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452840, '1051072930', 1, NULL),
(39044190, 'URBINA RAMON OMAR', NULL, NULL, NULL, NULL, '20390441909', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93933962, '0051072786', 1, NULL),
(39044193, 'RIOS NERI FABIAN', NULL, NULL, NULL, NULL, '20390441933', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 98795782, '2051081713', 1, NULL),
(39044196, 'SILVERO FLORENCIA DENISSE', NULL, NULL, NULL, NULL, '27390441962', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12667675, '0051073019', 1, NULL),
(39044197, 'ALVAREZ MELIZA VANESSA', NULL, NULL, NULL, NULL, '27390441970', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21520302, '2051061573', 1, NULL),
(39046497, 'AQUINO ALEJANDRO SEBASTIAN', NULL, NULL, NULL, NULL, '20390464976', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93931449, '3051060050', 1, NULL),
(39059490, 'LUQUE DORA YAMILA', NULL, NULL, NULL, NULL, '27390594904', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93078523, '5051072914', 1, NULL),
(39219602, 'DUARTE YESICA DALILA', NULL, NULL, NULL, NULL, '27392196027', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21302590, '5051072992', 1, NULL),
(39219612, 'AMARILLA ALEXIS EZEQUIEL', NULL, NULL, NULL, NULL, '23392196129', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373604, '4051056400', 1, NULL),
(39219618, 'LOPEZ LAURA ELIZABETH', NULL, NULL, NULL, NULL, '27392196183', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20306420, '9051060101', 1, NULL),
(39219622, 'VAZQUEZ MARLENE BEATRIZ', NULL, NULL, NULL, NULL, '27392196221', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29953330, '1051071470', 1, NULL),
(39219623, 'AQUINO ANDONI NICOLAS', NULL, NULL, NULL, NULL, '20392196235', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25017244, '4051072807', 1, NULL),
(39219632, 'VELAZQUEZ BRUNO DAVID', NULL, NULL, NULL, NULL, '20392196324', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16687633, '8051073428', 1, NULL),
(39219635, 'PERALTA CARINA ANDREA', NULL, NULL, NULL, NULL, '27392196353', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23218607, '9051072910', 1, NULL),
(39219639, 'VILLALBA BELEN LILIANA', NULL, NULL, NULL, NULL, '27392196396', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25775076, '3051061361', 1, NULL),
(39219642, 'FERREIRA ADRIANA BEATRIZ', NULL, NULL, NULL, NULL, '27392196426', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051030132', 1, NULL),
(39219647, 'VELAZQUEZ CAMILA BELEN', NULL, NULL, NULL, NULL, '27392196477', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17090824, '1051072987', 1, NULL),
(39219649, 'OJEDA RECALDE DARIO ANTONIO', NULL, NULL, NULL, NULL, '20392196499', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22833044, '7051080796', 1, NULL),
(39219651, 'CARDOZO GUSTAVO JAVIER', NULL, NULL, NULL, NULL, '20392196510', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25845727, '2051080868', 1, NULL),
(39219653, 'AMARILLA MARIA ALEJANDRA', NULL, NULL, NULL, NULL, '27392196531', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078654, '6051056146', 1, NULL),
(39219654, 'DA SILVA MONICA SOLEDAD', NULL, NULL, NULL, NULL, '23392196544', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18883643, '4051079426', 1, NULL),
(39219655, 'INSFRAN MARIA ALEJANDRA', NULL, NULL, NULL, NULL, '27392196558', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26751373, '0051061285', 1, NULL),
(39219656, 'CARDOZO TAMARA ROCIO', NULL, NULL, NULL, NULL, '27392196566', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351014, '9051022107', 1, NULL),
(39219658, 'CESPEDES TAMARA MELINA', NULL, NULL, NULL, NULL, '27392196582', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23444342, '3051072911', 1, NULL),
(39219662, 'PEREZ GABRIEL ALEJANDRO', NULL, NULL, NULL, NULL, '20392196626', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16451488, '4051061578', 1, NULL),
(39219664, 'NUÑEZ FEDERICO GABRIEL', NULL, NULL, NULL, NULL, '20392196642', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22164629, '0051072996', 1, NULL),
(39219665, 'NUÑEZ FACUNDO GABRIEL', NULL, NULL, NULL, NULL, '20392196650', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22164629, '9051073002', 1, NULL),
(39219666, 'MERCADO YAMILA MARIA', NULL, NULL, NULL, NULL, '27392196663', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078633, '8051061349', 1, NULL),
(39219668, 'GONZALEZ FLAVIA FERNANDA', NULL, NULL, NULL, NULL, '23392196684', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351050, '3051061355', 1, NULL),
(39219669, 'MARECOS JUAN IGNACIO', NULL, NULL, NULL, NULL, '20392196693', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18748289, '1051022901', 1, NULL),
(39219671, 'RIVAS YENIFER', NULL, NULL, NULL, NULL, '23392196714', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27129701, '0051068181', 1, NULL),
(39219672, 'ALVAREZ SERGIO DAVID', NULL, NULL, NULL, NULL, '20392196723', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20644707, '9051080871', 1, NULL),
(39219675, 'BRUNO CRISTIAN DE LA CRUZ', NULL, NULL, NULL, NULL, '20392196758', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23161277, '5051061218', 1, NULL),
(39219685, 'KRON ADRIANA GISELA', NULL, NULL, NULL, NULL, '23392196854', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92244911, '4051076939', 1, NULL),
(39219688, 'RAMOS ANTONIO ROMAN O RAMON', NULL, NULL, NULL, NULL, '23392196889', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18797912, '6051061239', 1, NULL),
(39219691, 'MEDINA HUGO ARMANDO', NULL, NULL, NULL, NULL, '23392196919', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051059196', 1, NULL),
(39219695, 'AYALA RITA ELIZABET', NULL, NULL, NULL, NULL, '27392196957', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051060058', 1, NULL),
(39220121, 'LEIVAS LUCIA JAZMIN', NULL, NULL, NULL, NULL, '27392201217', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17093101, 'AA8163019949', 1, NULL),
(39222680, 'VERA GABRIEL JONATHAN', NULL, NULL, NULL, NULL, '20392226800', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 98789463, '1051074059', 1, NULL),
(39223644, 'SOTELO DALIA', NULL, NULL, NULL, NULL, '27392236444', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11957273, '3051060590', 1, NULL),
(39225556, 'BAREIRO MARCELA AYELEN', NULL, NULL, NULL, NULL, '27392255562', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373663, '9051022641', 1, NULL),
(39226385, 'ANTUNEZ DE SOUZA MAXIMILIANO R', NULL, NULL, NULL, NULL, '20392263854', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18104966, '7051059945', 1, NULL),
(39226655, 'CERRUDO ALBERTO MANUEL', NULL, NULL, NULL, NULL, '20392266551', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1171033410', 1, NULL),
(39228374, 'SAUCEDO ANA MARIA', NULL, NULL, NULL, NULL, '27392283744', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18234787, '5051024846', 1, NULL),
(39296623, 'VENIALGO LUCAS DANIEL', NULL, NULL, NULL, NULL, '20392966235', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18716333, '1051021973', 1, NULL),
(39526102, 'ESPINOLA NOELIA ISABEL', NULL, NULL, NULL, NULL, '27395261024', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18878780, '2051024276', 1, NULL),
(39526111, 'VAZQUEZ LUCILA VALENTINA', NULL, NULL, NULL, NULL, '27395261113', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23030529, '4051074505', 1, NULL),
(39526167, 'GONZALEZ MONICA ELIZABET', NULL, NULL, NULL, NULL, '27395261679', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 91259360, '8051073352', 1, NULL),
(39526181, 'ESPINOLA LUIS ARIEL', NULL, NULL, NULL, NULL, '23395261819', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18723466, '0051061348', 1, NULL),
(39548136, 'MORINIGO AYELEN MICAELA', NULL, NULL, NULL, NULL, '27395481369', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525163, '9051061356', 1, NULL),
(39637762, 'ENRIQUEZ ERNESTO GEDEON', NULL, NULL, NULL, NULL, '20396377625', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17439602, '8051021924', 1, NULL),
(39640111, 'LOPEZ THALIA BELEN', NULL, NULL, NULL, NULL, '27396401113', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 7540493, '2051055868', 1, NULL),
(39641301, 'LOPEZ ROCIO BELEN(REASIGNAR REM)', NULL, NULL, NULL, NULL, '27396413014', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25657785, '0051080756', 1, NULL),
(39641302, 'PERALTA FLAVIA ANAHI', NULL, NULL, NULL, NULL, '27396413022', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20242765, '3051080954', 1, NULL),
(39641310, 'AQUINO EMILIA FIORELLA', NULL, NULL, NULL, NULL, '27396413103', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0', 1, NULL),
(39641312, 'ROMERO EVELYN DAIANA', NULL, NULL, NULL, NULL, '23396413124', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13149453, '0051073022', 1, NULL),
(39641316, 'BENITEZ MARIA BELEN', NULL, NULL, NULL, NULL, '27396413162', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051073281', 1, NULL),
(39641317, 'BRUNO CAROL FIDELINA', NULL, NULL, NULL, NULL, '27396413170', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23161277, '9051060084', 1, NULL),
(39641324, 'SANTOS MALENA BELEN', NULL, NULL, NULL, NULL, '27396413243', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20982951, '2051060054', 1, NULL),
(39641342, 'CERVIAN CELESTE TAMARA', NULL, NULL, NULL, NULL, '27396413421', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14634273, '6051072677', 1, NULL),
(39641349, 'BEÑACAR FERNANDA AGUSTINA', NULL, NULL, NULL, NULL, '27396413499', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '2051070163', 1, NULL),
(39641352, 'SOSA RAUL ARMANDO', NULL, NULL, NULL, NULL, '20396413524', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18481196, '4051062458', 1, NULL),
(39641358, 'PEREIRA CINTIA VALERIA', NULL, NULL, NULL, NULL, '27396413588', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23399096, '0051037417', 1, NULL),
(39641377, 'MOLINA IVAN LIONEL', NULL, NULL, NULL, NULL, '23396413779', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12847918, '7051023607', 1, NULL),
(39641378, 'BOGADO BIANCA SOLEDAD', NULL, NULL, NULL, NULL, '27396413782', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20475190, '4051077859', 1, NULL),
(39641381, 'GONZALEZ HUGO DANIEL', NULL, NULL, NULL, NULL, '20396413818', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28553118, '6051021980', 1, NULL),
(39641387, 'BAREIRO DEDIEU YONATHAN A.', NULL, NULL, NULL, NULL, '20396413877', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25271220, '4051023280', 1, NULL),
(39641389, 'ENRIQUEZ AUGUSTO NAHUEL', NULL, NULL, NULL, NULL, '20396413893', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93427279, '3051073829', 1, NULL),
(39641393, 'ROMERO FLORENCIA MARINA', NULL, NULL, NULL, NULL, '27396413936', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 7666031, '6051073828', 1, NULL),
(39641394, 'CABAÑAS CAMILA AGUSTINA', NULL, NULL, NULL, NULL, '27396413944', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21306748, '9051079516', 1, NULL),
(39706747, 'ESPINOLA AGUSTINA BELEN', NULL, NULL, NULL, NULL, '27397067470', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18144280, '2051073359', 1, NULL),
(39722139, 'SILVERO FIAMA SAMANTHA', NULL, NULL, NULL, NULL, '27397221399', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22154727, '3051074437', 1, NULL),
(39722229, 'FRANCO BRIAN DAVID', NULL, NULL, NULL, NULL, '20397222293', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379371, '9051022539', 1, NULL),
(39722234, 'OJEDA DANIEL RAMON', NULL, NULL, NULL, NULL, '23397222349', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93974245, '8051027880', 1, NULL),
(39722253, 'IFRAN MIGUEL ANGEL', NULL, NULL, NULL, NULL, '20397222536', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 31123417, '0051038572', 1, NULL),
(39723302, 'GIMENEZ MARIANA AYELEN', NULL, NULL, NULL, NULL, '27397233028', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13943986, 'AA0163041576', 1, NULL),
(39723303, 'BAREIRO DEDIEU FLORENCIA MICAE', NULL, NULL, NULL, NULL, '27397233036', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25921220, '1051060662', 1, NULL),
(39723304, 'MERELES NICOLAS EMANUEL', NULL, NULL, NULL, NULL, '23397233049', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22334342, '1051073016', 1, NULL),
(39723306, 'AQUINO LUCAS MATIAS NAHUEL', NULL, NULL, NULL, NULL, '20397233066', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23169327, '1051061523', 1, NULL),
(39723308, 'INCHAUSTI CLAUDIA ANDREA', NULL, NULL, NULL, NULL, '27397233087', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21888316, '9051081075', 1, NULL),
(39723309, 'FERNANDEZ FEDERICO DANIEL', NULL, NULL, NULL, NULL, '20397233090', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671646, '2051078607', 1, NULL),
(39723326, 'SOSA LORENA MABEL', NULL, NULL, NULL, NULL, '27397233265', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18481196, '9051060647', 1, NULL),
(39723328, 'ENRIQUEZ ANTONIA YAMILA', NULL, NULL, NULL, NULL, '27397233281', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93670935, '1051059224', 1, NULL),
(39723333, 'RAMIREZ GRACIELA ESTER', NULL, NULL, NULL, NULL, '27397233338', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20279646, '1051037456', 1, NULL),
(39723336, 'NUÑEZ HECTOR EMANUEL', NULL, NULL, NULL, NULL, '20397233368', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0171035939', 1, NULL),
(39723337, 'COLINA SERGIO DANIEL', NULL, NULL, NULL, NULL, '20397233376', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11259396, '6051074974', 1, NULL),
(39723342, 'GONZALEZ ALEJANDRO JAVIER', NULL, NULL, NULL, NULL, '20397233422', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16194088, '6051062538', 1, NULL),
(39723346, 'BARBOZA DE MOURA MICAELA ELIZABETH', NULL, NULL, NULL, NULL, '23397233464', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30131227, '6051081749', 1, NULL),
(39723347, 'PORTILLO TATIANA GABRIELA', NULL, NULL, NULL, NULL, '27397233478', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051029654', 1, NULL),
(39723348, 'DA LUZ NICOLAS', NULL, NULL, NULL, NULL, '20397233481', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930371, '8051081038', 1, NULL),
(39723349, 'BAREIRO GLORIA CAROLINA', NULL, NULL, NULL, NULL, '27397233494', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17952123, '5051072988', 1, NULL),
(39723353, 'ROJAS ANA ELIZABET', NULL, NULL, NULL, NULL, '27397233532', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18686808, '2051036374', 1, NULL),
(39723358, 'SAUCEDO MARIANO GABRIEL', NULL, NULL, NULL, NULL, '20397233589', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078687, '8051037599', 1, NULL),
(39723364, 'CAMACHO HECTOR JUNIORS', NULL, NULL, NULL, NULL, '20397233643', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28399736, 'AA5313689366', 1, NULL),
(39723366, 'ESPINOLA JUAN ESTEBAN', NULL, NULL, NULL, NULL, '23397233669', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 5839715, '9051080866', 1, NULL),
(39723367, 'ESPINOLA CINTIA CAROLINA', NULL, NULL, NULL, NULL, '27397233672', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207965, '6051021240', 1, NULL),
(39723372, 'RODRIGUEZ CAMILA TATIANA', NULL, NULL, NULL, NULL, '27397233729', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207910, '1051081036', 1, NULL),
(39723373, 'GONZALEZ LEANDRO JULIAN', NULL, NULL, NULL, NULL, '20397233732', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23367961, '9051029891', 1, NULL),
(39723379, 'FRUTO LETICIA MAGALI', NULL, NULL, NULL, NULL, '27397233796', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22927543, '9051073024', 1, NULL),
(39723382, 'GRONDONA DAIANA EVELIN', NULL, NULL, NULL, NULL, '27397233826', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94078680, '6051056028', 1, NULL),
(39723401, 'ESCOBAR ANAEL MARIA ANA', NULL, NULL, NULL, NULL, '27397234016', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 5277686, '5051060659', 1, NULL),
(39723404, 'LEIVA YAMILA ANABEL', NULL, NULL, NULL, NULL, '27397234040', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24532265, '2051081681', 1, NULL),
(39723406, 'MARTINEZ VIVIANA ', NULL, NULL, NULL, NULL, '27397234067', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18688829, '9051060051', 1, NULL),
(39723412, 'AQUINO DAINA MORELIA', NULL, NULL, NULL, NULL, '27397234121', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25017244, '8051072855', 1, NULL),
(39723413, 'BENITEZ TAMARA SOLEDAD', NULL, NULL, NULL, NULL, '23397234134', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 0, '2051048718', 1, NULL),
(39723415, 'GARCIA MANUELA RAQUEL', NULL, NULL, NULL, NULL, '27397234156', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225305, '3051030467', 1, NULL),
(39723417, 'DUDA FERNANDA SOLEDAD', NULL, NULL, NULL, NULL, '27397234172', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16279810, '1051072777', 1, NULL),
(39723418, 'PERALTA KAREN DANILA', NULL, NULL, NULL, NULL, '27397234180', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23354103, 'AA5163021544', 1, NULL),
(39723419, 'CACERES NICOLAS FERNANDO', NULL, NULL, NULL, NULL, '20397234194', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20489451, '5051060097', 1, NULL),
(39723420, 'MACHADO CESAR OSCAR', NULL, NULL, NULL, NULL, '20397234208', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94088323, '0051074436', 1, NULL),
(39723421, 'BITANCOURT CAROLINA ESTER', NULL, NULL, NULL, NULL, '27397234210', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33487315, '1051026482', 1, NULL),
(39723426, 'MULLER YESICA DAIANA', NULL, NULL, NULL, NULL, '27397234261', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051073336', 1, NULL),
(39723427, 'SOTO ANALIA ALEJANDRA', NULL, NULL, NULL, NULL, '23397234274', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379405, '8051080961', 1, NULL),
(39723434, 'CANDIA ESTELA MARIS', NULL, NULL, NULL, NULL, '27397234342', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225381, '1051030638', 1, NULL),
(39723436, 'RECALDE FEDERICO FABIAN', NULL, NULL, NULL, NULL, '20397234364', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33160715, '0051074830', 1, NULL),
(39723437, 'RIOS GABRIELA BELEN', NULL, NULL, NULL, NULL, '27397234377', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17367441, '2051030320', 1, NULL),
(39723442, 'AVELLANEDA YAMILA GISELL', NULL, NULL, NULL, NULL, '27397234423', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32736616, '1051037105', 1, NULL),
(39723445, 'MARTINEZ RAMONA BEATRIZ', NULL, NULL, NULL, NULL, '27397234458', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21305043, '8051073939', 1, NULL),
(39723447, 'NUÑEZ RAMON LUIS', NULL, NULL, NULL, NULL, '23397234479', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13690781, '3051072849', 1, NULL),
(39723448, 'MARTINEZ NICOLAS RENE', NULL, NULL, NULL, NULL, '20397234488', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930341, '9051039337', 1, NULL),
(39723453, 'VILLALBA ENZO FRANCISCO', NULL, NULL, NULL, NULL, '20397234534', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078681, '5051073833', 1, NULL),
(39723455, 'ESPINOLA RICHARD NICOLAS', NULL, NULL, NULL, NULL, '20397234550', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225322, '4051072713', 1, NULL),
(39723464, 'BAEZ CRISTIAN EMANUEL', NULL, NULL, NULL, NULL, '23397234649', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17378944, '7051081574', 1, NULL),
(39723465, 'ANDINO ENZO JULIAN', NULL, NULL, NULL, NULL, '20397234658', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351041, '7051030131', 1, NULL),
(39723466, 'CARBALLO LUZ ROCIO', NULL, NULL, NULL, NULL, '27397234660', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25845761, '3051081581', 1, NULL),
(39723472, 'REMANTE DIS', NULL, NULL, NULL, NULL, '27397234725', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051080857', 1, NULL),
(39723474, 'GONZALEZ EMILIA ELIZABET', NULL, NULL, NULL, NULL, '27397234741', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24506756, '3051060325', 1, NULL),
(39723476, 'CUEVAS YESICA MICAELA', NULL, NULL, NULL, NULL, '27397234768', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26438512, '3051072787', 1, NULL),
(39723477, 'DUDA ANELIS YISELA', NULL, NULL, NULL, NULL, '27397234776', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16451488, '4051073602', 1, NULL),
(39723478, 'GARCIA CINTIA PAOLA', NULL, NULL, NULL, NULL, '27397234784', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24545356, '0051073824', 1, NULL),
(39723483, 'VILLALBA DAIANA BELEN', NULL, NULL, NULL, NULL, '27397234830', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22835827, '2051082226', 1, NULL),
(39723489, 'GONCALVES MAXIMILIANO', NULL, NULL, NULL, NULL, '23397234890', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9163607641', 1, NULL),
(39723490, 'VARGAS PAULO ELIAS', NULL, NULL, NULL, NULL, '20397234909', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 8102843, '6051081420', 1, NULL),
(39723492, 'SILVERO MARCELO IVAN', NULL, NULL, NULL, NULL, '20397234925', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525101, '9051061539', 1, NULL),
(39723494, 'DUARTE LEANDRO NICOLAS', NULL, NULL, NULL, NULL, '20397234941', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351038, '8051022427', 1, NULL),
(39723495, 'BENITEZ ROLANDO ESTEBAN', NULL, NULL, NULL, NULL, '23397234959', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA9163601873', 1, NULL),
(39723496, 'PERALTA FEDERICO GABRIEL', NULL, NULL, NULL, NULL, '20397234968', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23218607, '4051022924', 1, NULL),
(39723499, 'CESPEDES NAHUEL DAVID', NULL, NULL, NULL, NULL, '20397234992', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207983, '3051072776', 1, NULL),
(39813578, 'GODOY FRANCISCO MAXIMILIANO', NULL, NULL, NULL, NULL, '20398135785', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351018, '0051029642', 1, NULL),
(39820711, 'YEGROS MATIAS GABRIEL', NULL, NULL, NULL, NULL, '20398207115', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1051081062', 1, NULL),
(39820727, 'DOLDAN ELIAS LUCIANO', NULL, NULL, NULL, NULL, '20398207271', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '4031052079', 1, NULL),
(39919600, 'MEIRA CARMEN ANABEL', NULL, NULL, NULL, NULL, '27399196006', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92014058, '2051081143', 1, NULL),
(39945069, 'ERNST GUILLERMO RODOLFO', NULL, NULL, NULL, NULL, '20399450692', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26682291, '1051022635', 1, NULL),
(39945093, 'DA SILVA TAMARA JOHANA', NULL, NULL, NULL, NULL, '23399450934', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26043694, '7051073001', 1, NULL),
(40043010, 'BOGADO CESAR DANIEL', NULL, NULL, NULL, NULL, '20400430102', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17952024, '9051080809', 1, NULL),
(40043234, 'ESPINOLA LUIS EMANUEL', NULL, NULL, NULL, NULL, '20400432342', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26957899, '1051061240', 1, NULL),
(40043786, 'CACERES MIRIAM MARIANA AYELEN', NULL, NULL, NULL, NULL, '27400437861', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30574246, '4051073890', 1, NULL),
(40096807, 'ROA YOLANDA BELEN', NULL, NULL, NULL, NULL, '27400968077', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24150248, '8051081679', 1, NULL),
(40198358, 'ALARCON CAMILA ALEJANDRA', NULL, NULL, NULL, NULL, '27401983584', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225326, '8051081717', 1, NULL),
(40334863, 'DA SILVA LUCIO ARNALDO', NULL, NULL, NULL, NULL, '20403348636', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '0', 1, NULL),
(40335620, 'SAS MELANI GABRIELA', NULL, NULL, NULL, NULL, '23403356204', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051073070', 1, NULL),
(40335693, 'OLIVERA KAREN SCHARON', NULL, NULL, NULL, NULL, '27403356935', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16222266, '9051079422', 1, NULL),
(40340535, 'KOVALSKI MATIAS LEONEL', NULL, NULL, NULL, NULL, '20403405354', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525133, '5051023272', 1, NULL),
(40340562, 'FERNANDEZ ALEJANDRA ELIZABETH', NULL, NULL, NULL, NULL, '27403405626', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '7051061346', 1, NULL),
(40343046, 'BARRIOS FERNANDO LUIS', NULL, NULL, NULL, NULL, '20403430464', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20489055, '3051068346', 1, NULL),
(40411004, 'GONZALEZ DELIA ISABEL', NULL, NULL, NULL, NULL, '27404110042', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18857423, '0051072724', 1, NULL),
(40411008, 'GONZALEZ IVAN MATIAS', NULL, NULL, NULL, NULL, '20404110080', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373615, '4051036871', 1, NULL),
(40411009, 'VERA JUAN ALBERTO', NULL, NULL, NULL, NULL, '20404110099', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27998799, '8051022545', 1, NULL),
(40411019, 'LOPEZ MARIELA ELIZABET', NULL, NULL, NULL, NULL, '27404110190', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23901850, '6051038579', 1, NULL),
(40411024, 'SIMONELLI GUILLERMO A.', NULL, NULL, NULL, NULL, '20404110242', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26046660, '4051023032', 1, NULL),
(40411031, 'OLSSON VALERIA', NULL, NULL, NULL, NULL, '23404110314', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25651008, '7051081035', 1, NULL),
(40411033, 'BENITEZ ANDREA SOLEDAD', NULL, NULL, NULL, NULL, '27404110336', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18688833, '0051073335', 1, NULL),
(40411055, 'VILLALBA SONIA ELIZABETH', NULL, NULL, NULL, NULL, '27404110557', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1031052719', 1, NULL),
(40411058, 'QUINTANA MARIA DE JESUS', NULL, NULL, NULL, NULL, '27404110581', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13324713, '3051081320', 1, NULL),
(40411061, 'MUÑOZ DAIANA MARYLIN', NULL, NULL, NULL, NULL, '27404110611', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563028, 'AA7163012491', 1, NULL),
(40411066, 'LOPEZ NATALIA', NULL, NULL, NULL, NULL, '27404110662', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1021021220', 1, NULL),
(40411074, 'MORINIGO PABLO OSCAR', NULL, NULL, NULL, NULL, '20404110749', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452804, '5051079649', 1, NULL);
INSERT INTO `personas` (`Dni`, `Apellidos_Nombres`, `Edad`, `Domicilio`, `Tel_Contacto`, `Fecha_Nac`, `Cuil`, `Lugar_Nacimiento`, `Fecha_Actualizacion`, `Usuario`, `Cod_Postal`, `Repitente`, `Id_Sexo`, `Id_Departamento`, `Id_Provincia`, `Id_Localidad`, `Id_Estado`, `Id_Curso`, `Id_Division`, `Id_Turno`, `Id_Estado_Civil`, `Dni_Tutor`, `NroSerie`, `Id_Cargo`, `Foto`) VALUES
(40411077, 'BENITEZ LUCIA DEL CARMEN', NULL, NULL, NULL, NULL, '27404110778', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379332, '8051022110', 1, NULL),
(40411079, 'GONZALEZ ROCIO BELEN', NULL, NULL, NULL, NULL, '27404110794', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28266607, '2051029652', 1, NULL),
(40411080, 'RAMIREZ LETICIA FABIANA', NULL, NULL, NULL, NULL, '27404110808', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '6051080854', 1, NULL),
(40411089, 'RODRIGUEZ MAURICIO VIDAL', NULL, NULL, NULL, NULL, '20404110897', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18340655, '3051038729', 1, NULL),
(40411090, 'SANABRIA AURELIA BELEN (ROBADA)', NULL, NULL, NULL, NULL, '27404110905', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 5917679, '6051023449', 1, NULL),
(40411093, 'KRON DIEGO ORLANDO', NULL, NULL, NULL, NULL, '20404110935', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92244911, '1051079279', 1, NULL),
(40411095, 'CESPEDES ANABEL MARCELA', NULL, NULL, NULL, NULL, '27404110956', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 5982677, '4051022902', 1, NULL),
(40411098, 'ALVAREZ WALTER', NULL, NULL, NULL, NULL, '20404110986', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18685055, 'AA3163013337', 1, NULL),
(40411099, 'FLEYTAS MARCIAL RODRIGO', NULL, NULL, NULL, NULL, '20404110994', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14669378, '7051074507', 1, NULL),
(40411100, 'BARBOZA DE MOURA MARIANA ALEJANDRA', NULL, NULL, NULL, NULL, '27404111006', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30360125, 'AA7163021979', 1, NULL),
(40414038, 'GONZALEZ TERESA ITATI', NULL, NULL, NULL, NULL, '27404140383', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16955967, '0051021972', 1, NULL),
(40414745, 'SOTELO NICOLAS', NULL, NULL, NULL, NULL, '20404147456', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14417853, '8051036035', 1, NULL),
(40414878, 'PEREZ CRISTIAN JAVIER', NULL, NULL, NULL, NULL, '20404148789', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29953306, '7031056806', 1, NULL),
(40415053, 'LABAN SOFIA ITATI', NULL, NULL, NULL, NULL, '27404150532', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9051061565', 1, NULL),
(40429494, 'RAMIREZ JORGE NICOLAS', NULL, NULL, NULL, NULL, '20404294947', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26616301, '2051069810', 1, NULL),
(40495927, 'REYES JACQUELINE PATRICIA', NULL, NULL, NULL, NULL, '27404959277', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27031413, '7051072837', 1, NULL),
(40540794, 'LUQUE KAREN ROCIO', NULL, NULL, NULL, NULL, '27405407944', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93078523, '0051072770', 1, NULL),
(40791211, 'VERA ROLANDO', NULL, NULL, NULL, NULL, '20407912110', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94360522, 'AA6163038935', 1, NULL),
(40840179, 'GARCETE MAXIMILIANO RAMON', NULL, NULL, NULL, NULL, '20408401799', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 22334394, 'AA0163020080', 1, NULL),
(40874105, 'ZARZA CLAUDIA', NULL, NULL, NULL, NULL, '27408741055', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18783415, '1051061567', 1, NULL),
(40898173, 'ESPINOLA NICOLAS', NULL, NULL, NULL, NULL, '20408981736', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA8313010568', 1, NULL),
(40898177, 'MACHADO ANGEL ENZO', NULL, NULL, NULL, NULL, '20408981779', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14634258, 'AA0163016512', 1, NULL),
(40898181, 'MARQUEZ MATIAS ENRIQUE', NULL, NULL, NULL, NULL, '20408981817', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22085260, 'AA0163016576', 1, NULL),
(40898182, 'DA SILVA BENTO MARY NOELIA', NULL, NULL, NULL, NULL, '23408981824', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13590304, 'AA6313674288', 1, NULL),
(40898186, 'LOPEZ ARMANDO CESAR', NULL, NULL, NULL, NULL, '20408981868', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17952747, 'AA3313676186', 1, NULL),
(40898187, 'MERELES KAREN ALDANA', NULL, NULL, NULL, NULL, '27408981870', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 29231570, 'AA7163022543', 1, NULL),
(40898188, 'CAÑETE VIVIANA SOLEDAD', NULL, NULL, NULL, NULL, '27408981889', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24174846, '4051081784', 1, NULL),
(40898189, 'SILVERO SIXTO DANIEL', NULL, NULL, NULL, NULL, '20408981892', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588199, 'AA5163036696', 1, NULL),
(40898192, 'GAUTO MARIANO EXEQUIEL', NULL, NULL, NULL, NULL, '20408981922', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17317752, 'AA3163013368', 1, NULL),
(99999999, 'SALINAS ANDREA VANINA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452879, '3051021964', 1, NULL),
(40898197, 'GONZALEZ ARNALDO DARIO', NULL, NULL, NULL, NULL, '20408981973', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588129, '3051038787', 1, NULL),
(40898200, 'LOVERA ALICIA SOLEDAD', NULL, NULL, NULL, NULL, '27408982001', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 147750499, 'AA1074058369\n', 1, NULL),
(41049504, 'VAZQUEZ JUANA VICTORIANA', NULL, NULL, NULL, NULL, '27410495045', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23030529, '7051077333', 1, NULL),
(41049509, 'RIESS MANUEL ENRIQUE', NULL, NULL, NULL, NULL, '20410495091', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22334378, '6051031937', 1, NULL),
(41049510, 'ESPINOLA ANDREA SOLEDAD', NULL, NULL, NULL, NULL, '23410495104', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 5839715, '0051038635', 1, NULL),
(41049511, 'GONZALEZ LETIZIA', NULL, NULL, NULL, NULL, '27410495118', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18857423, '1051023802', 1, NULL),
(41049512, 'REYES EMANUEL EMILIO', NULL, NULL, NULL, NULL, '20410495121', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14078695, 'AA1163018894', 1, NULL),
(41049513, 'VENIALGO MARTIN SEBASTIAN', NULL, NULL, NULL, NULL, '23410495139', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18716333, '0051037556', 1, NULL),
(41049520, 'ALVAREZ CINTIA VIVIANA', NULL, NULL, NULL, NULL, '27410495207', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21520302, '7051023029', 1, NULL),
(41049525, 'CABAÑAS PATRICIO RAMIRO', NULL, NULL, NULL, NULL, '20410495253', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1163020291', 1, NULL),
(41049526, 'IRALA FABIO MATIAS DE LA CRUZ', NULL, NULL, NULL, NULL, '20410495261', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25606975, 'AA9313675440', 1, NULL),
(41049528, 'OLIVERA ROSEBEL GABRIEL', NULL, NULL, NULL, NULL, '20410495288', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 10001752, 'AA6313675682', 1, NULL),
(41049530, 'ZARATE LUJAN ANAMA', NULL, NULL, NULL, NULL, '27410495304', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 5, 7, 13, 1, 4, 24974378, '6051082223', 1, NULL),
(41139929, 'BAEZ EVELIN GISELLE', NULL, NULL, NULL, NULL, '27411399295', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26751381, '4051029744', 1, NULL),
(41150081, 'GALEANO OVIEDO CLAUDIO EZEQUIEL', NULL, NULL, NULL, NULL, '20411500811', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 25493219, 'AA8313678862', 1, NULL),
(41173976, 'SCHENDELBEK YAMILA GABRIELA', NULL, NULL, NULL, NULL, '27411739762', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24545326, '7051079734', 1, NULL),
(41178106, 'LANG MAURICIO ANDRES', NULL, NULL, NULL, NULL, '20411781063', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 7550124, 'AA5313679857', 1, NULL),
(41178116, 'GONCALVEZ CINTIA MICAELA', NULL, NULL, NULL, NULL, '27411781165', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29624803, '2051081034', 1, NULL),
(41178165, 'ESPINOLA HECTOR HORACIO', NULL, NULL, NULL, NULL, '20411781659', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18878780, 'AA3163035925', 1, NULL),
(41178171, 'RAMIREZ JULIO ALBERTO', NULL, NULL, NULL, NULL, '20411781713', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94348038, 'AA1163016687', 1, NULL),
(41231534, 'ALVEZ EMILIANO JAVIER', NULL, NULL, NULL, NULL, '20412315341', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '9231147399', 1, NULL),
(41289995, 'ROA YANINA ABRIL\n', NULL, NULL, NULL, NULL, '23412899954', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24150248, 'AA3163611611', 1, NULL),
(41301901, 'DA SILVA EMANUEL ALEJANDRO', NULL, NULL, NULL, NULL, '20413019010', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '5031058979', 1, NULL),
(41301904, 'GONZALEZ CRISTIAN BLADIMIR', NULL, NULL, NULL, NULL, '20413019045', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379373, 'AA7163036956', 1, NULL),
(41301908, 'LOPEZ ALVARO', NULL, NULL, NULL, NULL, '20413019088', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30521874, 'AA1163016842', 1, NULL),
(41301918, 'VILLALBA ALEJANDRO RUBEN', NULL, NULL, NULL, NULL, '20413019185', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18651255, 'AA5313689555', 1, NULL),
(41301919, 'CARDOZO ANGEL MIGUEL', NULL, NULL, NULL, NULL, '20413019193', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 0, 0, 1, 4, 93097476, 'AA5074114658', 1, NULL),
(41301921, 'DUARTE LEANDRO AGUSTIN', NULL, NULL, NULL, NULL, '20413019215', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3163612020', 1, NULL),
(41301922, 'VELAZQUEZ ANABELLA ELIZABET', NULL, NULL, NULL, NULL, '27413019228', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373601, '3051031357', 1, NULL),
(41301927, 'NUÑEZ LIZ MARIEL', NULL, NULL, NULL, NULL, '27413019279', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24134886, '5051082444', 1, NULL),
(41301928, 'RAMOS CLARISA', NULL, NULL, NULL, NULL, '27413019287', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18797912, '8051059787', 1, NULL),
(41301931, 'GONZALEZ JOAQUIN MATIAS', NULL, NULL, NULL, NULL, '20413019312', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23367961, 'AA4313671536', 1, NULL),
(41301937, 'AQUINO STEVEN GUIDO ARIEL', NULL, NULL, NULL, NULL, '20413019371', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20242734, '1051062658', 1, NULL),
(41301943, 'RAMIREZ VICTOR FERNANDO RAMON', NULL, NULL, NULL, NULL, '20413019436', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA3313683303', 1, NULL),
(41301944, 'INCHAUSTI LEANDRO JOAQUIN', NULL, NULL, NULL, NULL, '20413019444', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671609, 'AA7163012176', 1, NULL),
(41301946, 'VERA ABRAHAM ANDRES', NULL, NULL, NULL, NULL, '20413019460', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18679088, 'AA9163041467', 1, NULL),
(41301947, 'GALARZA MATIAS EZEQUIEL', NULL, NULL, NULL, NULL, '20413019479', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 4538610, '4051072789', 1, NULL),
(41301948, 'MOREL KARINA ESTER', NULL, NULL, NULL, NULL, '24413019482', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29212822, 'AA0163022867', 1, NULL),
(41301953, 'AQUINO BRIAN ALEJANDRO', NULL, NULL, NULL, NULL, '20413019533', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16009566, '7051022117', 1, NULL),
(41301954, 'RIVERO EUGENIO MARCELO', NULL, NULL, NULL, NULL, '20413019541', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 12962081, 'AA5313689265', 1, NULL),
(41301956, 'RIOS ANTONELLA MAIRA', NULL, NULL, NULL, NULL, '27413019562', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18690206, '5051059943', 1, NULL),
(41301958, 'GONZALEZ ANALIA', NULL, NULL, NULL, NULL, '27413019589', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 27454746, 'AA8163018806', 1, NULL),
(41301959, 'FERREIRA BRENDA', NULL, NULL, NULL, NULL, '27413019597', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13590395, '3051038622', 1, NULL),
(41301961, 'BENITEZ NATALIA LICET', NULL, NULL, NULL, NULL, '27413019619', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21302560, 'AA6163037359', 1, NULL),
(41301967, 'BRUNO ALEXIS FABIAN', NULL, NULL, NULL, NULL, '20413019673', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23161277, 'AA1163015065', 1, NULL),
(41301969, 'REYES MARIA FLORENCIA', NULL, NULL, NULL, NULL, '27413019694', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27031413, 'AA2163017967', 1, NULL),
(41301972, 'ESPINDOLA BRISA MALEN', NULL, NULL, NULL, NULL, '27413019724', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563013, 'AA3313676247', 1, NULL),
(41301975, 'SANTANDER PATRICIA BEATRIZ', NULL, NULL, NULL, NULL, '27413019759', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18781457, '1051063632', 1, NULL),
(41301977, 'OZUNA CRISTIAN DANIEL', NULL, NULL, NULL, NULL, '20413019773', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452730, '9051059682', 1, NULL),
(41301978, 'REYES KEVIN JAVIER', NULL, NULL, NULL, NULL, '20413019789', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32726606, '0051037324', 1, NULL),
(41301979, 'VILLALBA RAMON ALEJANDRO', NULL, NULL, NULL, NULL, '20413019792', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671610, 'AA9163036123', 1, NULL),
(41301982, 'LUQUE CAMILA MAGALI', NULL, NULL, NULL, NULL, '27413019821', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13825951, 'AA6313676957', 1, NULL),
(41301984, 'TORRES YAMILA RAMONA', NULL, NULL, NULL, NULL, '27413019848', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379330, '0051081585', 1, NULL),
(41301985, 'GIMENEZ GONZALO EZEQUIEL', NULL, NULL, NULL, NULL, '20413019851', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30131226, '2051022026', 1, NULL),
(41301986, 'COLINA ELIANA ELIZABETH', NULL, NULL, NULL, NULL, '27413019864', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11259396, '3051029648', 1, NULL),
(41301988, 'BARRETO FABIAN DAVID', NULL, NULL, NULL, NULL, '20413019886', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92226566, 'AA0313684821', 1, NULL),
(41301990, 'ACOSTA BRUNO EXEQUIEL', NULL, NULL, NULL, NULL, '20413019908', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26438563, '4051023173', 1, NULL),
(41301991, 'RODRIGUEZ TAMARA BELEN', NULL, NULL, NULL, NULL, '27413019910', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207910, '4051081315', 1, NULL),
(41301994, 'FERRERO TATIANA BELEN', NULL, NULL, NULL, NULL, '27413019945', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 14850226, 'AA4163021690', 1, NULL),
(41301995, 'OVIEDO FRANCO WALTER ELIAS', NULL, NULL, NULL, NULL, '20413019959', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17090883, 'AA7313670064', 1, NULL),
(41301997, 'RUIZ DIAZ MATIAS EZEQUIEL', NULL, NULL, NULL, NULL, '20413019975', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26438546, 'AA6163037262', 1, NULL),
(41301999, 'AVELLANEDA RODRIGO EZEQUIEL', NULL, NULL, NULL, NULL, '20413019991', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32736616, 'AA2074165055', 1, NULL),
(41302366, 'ALMADA LUIS ALBERTO', NULL, NULL, NULL, NULL, '20413023662', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22334348, '3051079534', 1, NULL),
(41305260, 'GIMENEZ GABRIEL ANTONIO', NULL, NULL, NULL, NULL, '20413052603', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11326429, 'AA3163017988', 1, NULL),
(41305262, 'GAMARRA MARIANA', NULL, NULL, NULL, NULL, '27413052624', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16700768, 'AA0313688648', 1, NULL),
(41305264, 'KRON CARLOS NAHUEL', NULL, NULL, NULL, NULL, '20413052646', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27492456, 'AA1163015162', 1, NULL),
(41305271, 'TORALES ALEJANDRO DAVID', NULL, NULL, NULL, NULL, '20413052719', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20872899, '1051023981', 1, NULL),
(41305275, 'GIMENEZ JUAN MANUEL', NULL, NULL, NULL, NULL, '20413052751', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27129758, '9051022319', 1, NULL),
(41305276, 'VELAZQUEZ SOFIA VALERIA', NULL, NULL, NULL, NULL, '27413052764', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12687633, '3051036034', 1, NULL),
(41305280, 'GONZALEZ DAIRA FLORENCIA', NULL, NULL, NULL, NULL, '27413052802', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 8540509, 'AA3313671403', 1, NULL),
(41305283, 'GONZALEZ VERONICA ALICIA', NULL, NULL, NULL, NULL, '27413052837', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20987203, 'AA1074150002', 1, NULL),
(41305284, 'DEJESUS NAHUEL NICOLAS', NULL, NULL, NULL, NULL, '20413052840', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24174890, 'AA5163024927', 1, NULL),
(41305285, 'ESPINOLA GLORIA BEATRIZ', NULL, NULL, NULL, NULL, '27413052853', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207965, '7051079343', 1, NULL),
(41305288, 'BOGADO CAROLINA MICAELA', NULL, NULL, NULL, NULL, '27413052888', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 17090851, 'AA2074062120', 1, NULL),
(41305289, 'SILGUERA PABLO JAVIER', NULL, NULL, NULL, NULL, '20413052891', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18857423, 'AA2074163108', 1, NULL),
(41305295, 'VENIALGO REBECA SOLEDAD', NULL, NULL, NULL, NULL, '27413052950', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92914621, 'AA5163021557', 1, NULL),
(41305297, 'BOBADILLA LETICIA ELISABET', NULL, NULL, NULL, NULL, '27413052977', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 24373744, 'AA0163016067', 1, NULL),
(41305299, 'FLORES TANIA ALDANA ITATI', NULL, NULL, NULL, NULL, '27413052993', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563035, 'AA7313680341', 1, NULL),
(41305659, 'OLIVERA JAIRO GASTON', NULL, NULL, NULL, NULL, '20413056595', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16222266, '9051081677', 1, NULL),
(41418906, 'FERNANDEZ DIEGO HERNAN', NULL, NULL, NULL, NULL, '20414189068', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92221847, 'AA8163022252', 1, NULL),
(41503929, 'BUENO ARIEL JOEL', NULL, NULL, NULL, NULL, '20415039299', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17164585, 'AA0163016490', 1, NULL),
(41503930, 'BUENO DARIO DE JESUS', NULL, NULL, NULL, NULL, '20415039302', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17164585, 'AA0313677327', 1, NULL),
(41503936, 'ACUÑA MARIELA MARIANA', NULL, NULL, NULL, NULL, '27415039366', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13149487, '9051068141', 1, NULL),
(41509068, 'SILVERO JONATHAN ULISES', NULL, NULL, NULL, NULL, '20415090685', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525101, '4051021078', 1, NULL),
(41586026, 'AQUINO VILLAGRA MELISSA AILEN', NULL, NULL, NULL, NULL, '27415860264', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92098092, '5051068257', 1, NULL),
(41615785, 'ACOSTA MARCOS DANIEL', NULL, NULL, NULL, NULL, '20416157856', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22894030, 'AA5163044179', 1, NULL),
(41615919, 'DA SILVA ROBERTO JUAN', NULL, NULL, NULL, NULL, '20416159190', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 1, 0, 2, 4, 25066696, 'AA4074071020', 1, NULL),
(41631255, 'PIÑEYRO CELIA FIDELINA', NULL, NULL, NULL, NULL, '27416312554', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26406459, '5051080869', 1, NULL),
(41631380, 'SOTELO DALIVANA', NULL, NULL, NULL, NULL, '27416313801', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14417853, 'AA8163022369', 1, NULL),
(41632010, 'LOPEZ NAHUEL ADRIAN', NULL, NULL, NULL, NULL, '20416320102', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 35013708, 'AA3074112992', 1, NULL),
(41632012, 'CORREA MATIAS EMANUEL', NULL, NULL, NULL, NULL, '20416320129', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17087474, '6051079660', 1, NULL),
(41632016, 'PERALTA CINDY DANIELA', NULL, NULL, NULL, NULL, '27416320166', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930306, 'AA2074068554', 1, NULL),
(41632025, 'GODOY VALERIA JAQUELINE', NULL, NULL, NULL, NULL, '27416320255', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930380, 'AA3163016947', 1, NULL),
(41632029, 'GIMENEZ MARIA SOLEDAD', NULL, NULL, NULL, NULL, '27416320298', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20941423, '4051037457', 1, NULL),
(41632032, 'LOPEZ CINTIA CAROLINA', NULL, NULL, NULL, NULL, '27416320328', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94558291, 'AA7313676474', 1, NULL),
(41632034, 'MERELES BRISA ELIZABET', NULL, NULL, NULL, NULL, '27416320344', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22334342, '6051059885', 1, NULL),
(41632035, 'BARRIOS EMILIANO NESTOR', NULL, NULL, NULL, NULL, '20416320358', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27513918, 'AA9163013944', 1, NULL),
(41632036, 'BAEZ MARIANA ELIZABETH', NULL, NULL, NULL, NULL, '27416320360', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18266673, '0051038871', 1, NULL),
(41632037, 'GIMENEZ JULIO CESAR', NULL, NULL, NULL, NULL, '20416320374', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 29295917, 'AA0163018092', 1, NULL),
(41632039, 'FERNANDEZ FLORENCIA NOELIA', NULL, NULL, NULL, NULL, '27416320395', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671612, 'AA7163014203', 1, NULL),
(41632040, 'DA SILVA BENTO YAMILA', NULL, NULL, NULL, NULL, '27416320409', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13590304, 'AA1163018906', 1, NULL),
(41632041, 'MONTIEL OCTAVIO', NULL, NULL, NULL, NULL, '20416320412', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20676271, 'AA2074133147', 1, NULL),
(41632043, 'AYALA VIRGINIA LUJAN', NULL, NULL, NULL, NULL, '27416320433', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671678, '7051074197', 1, NULL),
(41632044, 'MACHADO MARISOL VIRGINIA', NULL, NULL, NULL, NULL, '27416320441', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24989074, 'AA1163020282', 1, NULL),
(41632045, 'BENITEZ JAQUELINE GABRIELA', NULL, NULL, NULL, NULL, '23416320454', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 7588074, 'AA6163020253', 1, NULL),
(41632049, 'CUEVAS SEBASTIAN ALEJANDRO', NULL, NULL, NULL, NULL, '20416320498', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671665, '3051061267', 1, NULL),
(41632052, 'CABALLERO ESTEBAN ANGEL EZEQUIEL', NULL, NULL, NULL, NULL, '20416320528', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 12400540, 'AA0163045208', 1, NULL),
(41632053, 'AQUINO WILLIAMS JOSE', NULL, NULL, NULL, NULL, '20416320536', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25017244, 'AA5163039743', 1, NULL),
(41632056, 'BAREIRO DEDIEU KAREN MALENA', NULL, NULL, NULL, NULL, '27416320565', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25271220, 'AA0163012897', 1, NULL),
(41632057, 'GAUTO ROCIO DAIANA', NULL, NULL, NULL, NULL, '27416320573', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17317752, 'AA7313677215', 1, NULL),
(41632059, 'FLECHA ANGEL EZEQUIEL', NULL, NULL, NULL, NULL, '20416320595', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 13149481, 'AA7163014513', 1, NULL),
(41632061, 'OVIEDO ANA CARLA', NULL, NULL, NULL, NULL, '27416320611', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28905427, '3051073716', 1, NULL),
(41632064, 'VILLALBA MARCELO JOSE', NULL, NULL, NULL, NULL, '20416320641', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 14078641, 'AA4074070626', 1, NULL),
(41632074, 'ADORNO ANGEL THOMAS', NULL, NULL, NULL, NULL, '20416320749', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21598534, 'AA0163012785', 1, NULL),
(41632078, 'GONZALEZ ELIDA SOLEDAD', NULL, NULL, NULL, NULL, '27416320786', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7313680948', 1, NULL),
(41632084, 'SILGUERA MARCIA', NULL, NULL, NULL, NULL, '27416320840', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18857423, '2051081058', 1, NULL),
(41632088, 'RAMIREZ ALICIA MARIA DEL CARMEN', NULL, NULL, NULL, NULL, '27416320883', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27129701, '0051081151', 1, NULL),
(41632089, 'ALFONZO LISANDRO MANUEL', NULL, NULL, NULL, NULL, '20416320897', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 14168284, 'AA1313684828', 1, NULL),
(41632092, 'PEÑA ALEJANDRA MARIA JOSE', NULL, NULL, NULL, NULL, '27416320921', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930385, '5051061251', 1, NULL),
(41632093, 'VERA FABIOLA AYELEN', NULL, NULL, NULL, NULL, '23416320934', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225305, '8051028946', 1, NULL),
(41632099, 'CHAPARRO PAMELA ELIZABETH', NULL, NULL, NULL, NULL, '27416320999', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92289113, 'AA4163017116', 1, NULL),
(41674182, 'REM DAÑADA', NULL, NULL, NULL, NULL, '23416741824', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1051026425', 1, NULL),
(41711203, 'CAIRE YESICA FLORENCIA', NULL, NULL, NULL, NULL, '27417112036', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23405641, 'AA5163023517', 1, NULL),
(41834479, 'SALINAS ESTEFANIA ITATI', NULL, NULL, NULL, NULL, '27418344798', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452879, 'AA1313678895', 1, NULL),
(41834520, 'KRON GABRIELA ALEJANDRA', NULL, NULL, NULL, NULL, '24418345205', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27983589, '2051022111', 1, NULL),
(41834750, 'ALVEZ MATIAS DAMIAN', NULL, NULL, NULL, NULL, '20418347504', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24974408, 'AA2074117418', 1, NULL),
(41871512, 'SCHENDELBEK ALEJANDRA YANINA', NULL, NULL, NULL, NULL, '27418715125', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24545326, '1051061351', 1, NULL),
(41872301, 'MARTINEZ CELESTE SOLEDAD', NULL, NULL, NULL, NULL, '27418723012', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18438383, 'AA5163022296', 1, NULL),
(41877709, 'ORTIS PAOLA ISABEL', NULL, NULL, NULL, NULL, '27418777090', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21300844, 'AA9023009518', 1, NULL),
(41877958, 'PADILLA DEBORA CECILIA', NULL, NULL, NULL, NULL, '27418779581', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16707898, 'AA1074167270', 1, NULL),
(41951684, 'VILLALBA LUZ TATIANA', NULL, NULL, NULL, NULL, '27419516843', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21684935, '7051075076', 1, NULL),
(41953156, 'GODOY JORGE JOSE LUIS', NULL, NULL, NULL, NULL, '20419531562', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452726, 'AA3074113514', 1, NULL),
(41968170, 'RAMIREZ MILAGROS MABEL', NULL, NULL, NULL, NULL, '27419681704', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051061208', 1, NULL),
(41994942, 'SOSA CRISTIAN ISIDRO', NULL, NULL, NULL, NULL, '20419949427', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27212723, 'AA2074128882', 1, NULL),
(42001810, 'SEFSTROM YILDA ESTEFANI', NULL, NULL, NULL, NULL, '27420018105', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 36061934, 'AA3313687135', 1, NULL),
(42002960, 'PINTO LUCIA ADRIANA', NULL, NULL, NULL, NULL, '27420029603', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29050952, 'PEDIDO', 1, NULL),
(42003264, 'CANDIA TOMAS NICASIO', NULL, NULL, NULL, NULL, '20420032642', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 2, 0, 2, 4, 23225381, 'AA3074113535', 1, NULL),
(42026513, 'BARRIOS BRIAN ARIEL', NULL, NULL, NULL, NULL, '20420265132', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 29995442, 'AA3163036036', 1, NULL),
(42056846, 'ERNST CAMILA YAQUELIN', NULL, NULL, NULL, NULL, '23420568464', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24867055, 'AA2074102044', 1, NULL),
(42086892, 'MONZON MICAELA CARLA CAROLINA', NULL, NULL, NULL, NULL, '27420868923', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29007384, 'AA7313680337', 1, NULL),
(42171801, 'CESPEDES CRISTIAN ANDRES', NULL, NULL, NULL, NULL, '20421718017', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525143, '7051037443', 1, NULL),
(42171802, 'CESPEDES FABIO', NULL, NULL, NULL, NULL, '20421718025', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525143, 'AA7313680313', 1, NULL),
(42171804, 'RODRIGUEZ TAMARA SOLEDAD', NULL, NULL, NULL, NULL, '27421718046', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379316, '0051061575', 1, NULL),
(42171816, 'VAZQUEZ ANTONIA ISABEL', NULL, NULL, NULL, NULL, '23421718164', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 94314664, 'AA1163017746', 1, NULL),
(42171819, 'RIBEIRO PATRICK', NULL, NULL, NULL, NULL, '27421718194', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20242783, 'AA1163020595', 1, NULL),
(42171821, 'BITANCOURT CRISTIAN GABRIEL', NULL, NULL, NULL, NULL, '20421718211', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33487315, 'AA7313676969', 1, NULL),
(42171833, 'REM USADA', NULL, NULL, NULL, NULL, '20421718335', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 8540509, 'AA0163012125', 1, NULL),
(42171841, 'PERALTA CRISTIAN JOAQUIN', NULL, NULL, NULL, NULL, '20421718416', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21306199, 'AA0313683048', 1, NULL),
(42171843, 'CABRAL LUZ BELLA', NULL, NULL, NULL, NULL, '27421718437', NULL, '2017-04-26', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 3, 2, 4, 11963078, 'AA3074151998', 1, NULL),
(42171844, 'SCHINDLER JAQUELIN STEFANI', NULL, NULL, NULL, NULL, '27421718445', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92348565, 'AA0163042141', 1, NULL),
(42171846, 'FERNANDEZ FLORENCIA ANABELA', NULL, NULL, NULL, NULL, '27421718461', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28484489, 'AA2074101593', 1, NULL),
(42192571, 'MEINHART NICOLAS BRAIAN', NULL, NULL, NULL, NULL, '20421925713', NULL, '2017-04-26', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 2, 2, 4, 28553449, 'AA2074133175', 1, NULL),
(42237303, 'ESPINOLA MILAGROS CELESTE', NULL, NULL, NULL, NULL, '27422373034', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 18144280, 'AA1163015120', 1, NULL),
(42272620, 'RUIZ DIAZ ROCIO BELEN', NULL, NULL, NULL, NULL, '27422726204', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30520999, 'AA9313678699', 1, NULL),
(42272677, 'DA SILVA HUGO JAVIER', NULL, NULL, NULL, NULL, '20422726773', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 25066696, 'AA4074078239', 1, NULL),
(42273736, 'PEREIRA ROMINA CECILIA', NULL, NULL, NULL, NULL, '27422737362', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 23399096, 'AA4163023340', 1, NULL),
(42273737, 'CARBALLO MAGALI MARIEN', NULL, NULL, NULL, NULL, '27422737370', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25657785, 'AA2163022885', 1, NULL),
(42273738, 'PAREDES CAROLINA VERONICA', NULL, NULL, NULL, NULL, '27422737389', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23743114, 'AA5163011880', 1, NULL),
(42273741, 'GIMENEZ RENATA ELENA', NULL, NULL, NULL, NULL, '27422737419', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16194065, 'AA8163040439', 1, NULL),
(42273746, 'SIMONELLI CARLA BELEN', NULL, NULL, NULL, NULL, '27422737464', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 28553211, 'AA1163018462', 1, NULL),
(42273747, 'MENDEZ DE JESUS ALEJANDRO TOMAS', NULL, NULL, NULL, NULL, '20422737473', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27223684, 'AA3074154561', 1, NULL),
(42273750, 'ESPINOLA MARIA FLORENCIA', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1163018855', 1, NULL),
(42381033, 'FERNANDEZ EVERLIN ISABEL', NULL, NULL, NULL, NULL, '27423810330', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28718109, 'AA9313044732', 1, NULL),
(42466212, 'SERVIAN CARLA NOEMI', NULL, NULL, NULL, NULL, '27424662122', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23218902, 'AA4074067204', 1, NULL),
(42466216, 'DUARTE NATALIA NOEMI', NULL, NULL, NULL, NULL, '27424662165', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 12116241, 'AA1163016181', 1, NULL),
(42466217, 'RAMIREZ PATRICIO', NULL, NULL, NULL, NULL, '20424662179', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16451469, 'AA1163018940', 1, NULL),
(42466218, 'NUÑEZ ANGELA MARIA INES', NULL, NULL, NULL, NULL, '27424662181', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 13690781, 'AA1163040488', 1, NULL),
(42466223, 'FRANCO AGUSTINA MARIA LUJAN', NULL, NULL, NULL, NULL, '27424662238', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 25017299, 'AA8163039303', 1, NULL),
(42466226, 'ESTEVAN ,ESTELA BELEN', NULL, NULL, NULL, NULL, '27424662262', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 25467791, 'AA8163013347', 1, NULL),
(42466227, 'ESTEVAN VALERIA ALEJANDRA', NULL, NULL, NULL, NULL, '27424662270', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 25467791, 'AA8163023278', 1, NULL),
(42466228, 'COLMAN CECILIA RAMONA', NULL, NULL, NULL, NULL, '27424662289', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18788527, 'AA6313676863', 1, NULL),
(42466229, 'MARTINEZ MONICA YAQUELIN', NULL, NULL, NULL, NULL, '27424662297', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18688829, 'AA1163020567', 1, NULL),
(42514020, 'BAREIRO MARCOS ARIEL', NULL, NULL, NULL, NULL, '20425140206', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '8051061551', 1, NULL),
(42515489, 'ALMADA AXEL THIAGO', NULL, NULL, NULL, NULL, '20425154890', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16451452, 'AA4163015168', 1, NULL),
(42515569, 'VANZELLA MAXIMILIANO GABRIEL', NULL, NULL, NULL, NULL, '20425155696', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30093573, 'AA9163012355', 1, NULL),
(42515572, 'MIÑARRO ANTONELA GUADALUPE', NULL, NULL, NULL, NULL, '27425155720', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25606931, 'AA1163017697', 1, NULL),
(42515579, 'RIVAS MATIAS ADRIAN', NULL, NULL, NULL, NULL, '20425155793', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28610098, 'AA2074101053', 1, NULL),
(42515582, 'RIOS GILBERTO', NULL, NULL, NULL, NULL, '20425155823', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18795782, 'AA2074127871', 1, NULL),
(42515588, 'GONZALEZ BRISA DANIELA SOLEDAD', NULL, NULL, NULL, NULL, '27425155887', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26102039, 'AA1163019433', 1, NULL),
(42515590, 'LOPEZ VIVIANA ELIZABETH', NULL, NULL, NULL, NULL, '27425155909', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14573508, 'AA3163042158', 1, NULL),
(42615008, 'SILVERO PABLO FRANCISCO ADAN', NULL, NULL, NULL, NULL, '20426150086', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22154727, 'AA8163022793', 1, NULL),
(42666805, 'CAMACHO PAOLA ESTER', NULL, NULL, NULL, NULL, '27426668055', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28399736, 'AA4074064513', 1, NULL),
(42666806, 'GONZALEZ CRISTIAN ADRIAN', NULL, NULL, NULL, NULL, '20426668069', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 147750499, 'AA2074168224', 1, NULL),
(42666809, 'GONZALEZ JAQUELINA ANDREA', NULL, NULL, NULL, NULL, '27426668098', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25066436, 'AA3313671445', 1, NULL),
(42666810, 'GONZALEZ MATIAS ALEXIS', NULL, NULL, NULL, NULL, '20426668107', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30379373, 'AA1163019789', 1, NULL),
(42666815, 'GONZALEZ DIANA ARACELI', NULL, NULL, NULL, NULL, '27426668152', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29295985, 'AA4074070085', 1, NULL),
(42666816, 'CANOFRE ELISANA BELEN', NULL, NULL, NULL, NULL, '27426668160', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21302722, 'AA3313671227', 1, NULL),
(42666817, 'ESPINOLA MICAELA BEATRIZ', NULL, NULL, NULL, NULL, '27426668179', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18497936, 'AA9313674384', 1, NULL),
(42666820, 'DE ARRUDA BRUNO RAMON', NULL, NULL, NULL, NULL, '20426668204', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92686861, 'AA2313679242', 1, NULL),
(42666821, 'ESPINOLA MARIA DE LOS ANGELES((C.D))', NULL, NULL, NULL, NULL, '27426668217', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14168500, 'AA2163022753', 1, NULL),
(42666822, 'RAMIREZ VALERIA RAQUEL', NULL, NULL, NULL, NULL, '27426668225', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21985903, 'AA0163011850', 1, NULL),
(42666824, 'RAMIREZ VICTORIA MAGALI', NULL, NULL, NULL, NULL, '27426668241', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27513918, 'AA5163036000', 1, NULL),
(42666826, 'GAUTO MARIANA MAGDALENA', NULL, NULL, NULL, NULL, '27426668268', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21491031, 'AA2074061690', 1, NULL),
(42666828, 'KRON MILENA JANET LUJAN', NULL, NULL, NULL, NULL, '27426668284', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18774157, 'AA7163019935', 1, NULL),
(42666832, 'OJEDA ALCIDES DANIEL', NULL, NULL, NULL, NULL, '20426668328', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525143, 'AA7313680235', 1, NULL),
(42666833, 'IRALA FIORELLA LUZ MILAGROS', NULL, NULL, NULL, NULL, '27426668330', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25606975, 'AA4163013519', 1, NULL),
(42666838, 'JARA ALDANA BELEN', NULL, NULL, NULL, NULL, '27426668381', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17090818, '0', 1, NULL),
(42668153, 'FIGUEREDO BETIANA', NULL, NULL, NULL, NULL, '27426681531', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, '1051071203', 1, NULL),
(42760332, 'MARINONI LUCIANA', NULL, NULL, NULL, NULL, '27427603321', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 26207911, 'AA0163023375', 1, NULL),
(42760339, 'VILLALBA LAURA MICAELA', NULL, NULL, NULL, NULL, '27427603399', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20297693, 'AA2074063220', 1, NULL),
(42760346, 'FELIPE DE OLIVEIRA TERESA NOEMI', NULL, NULL, NULL, NULL, '27427603461', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18717371, 'AA9313674126', 1, NULL),
(42760347, 'WIEDEMANN JUAN DAVID', NULL, NULL, NULL, NULL, '20427603475', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 95120650, 'AA4313684127', 1, NULL),
(42760348, 'BENITEZ ANABELLA SOLEDAD', NULL, NULL, NULL, NULL, '27427603488', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26397418, 'AA3074150161', 1, NULL),
(42760352, 'ALVAREZ NOEMI', NULL, NULL, NULL, NULL, '27427603526', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18658055, '0051074738', 1, NULL),
(42760367, 'FERREYRA LISANDRO MAURICIO', NULL, NULL, NULL, NULL, '23427603679', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12898268, 'AA9163021854', 1, NULL),
(42762596, 'GALEANO NOELIA ELIZABETH', NULL, NULL, NULL, NULL, '27427625961', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 2, 0, 2, 4, 12687627, 'AA1074166427', 1, NULL),
(42764311, 'SOTELO ROCIO YANET', NULL, NULL, NULL, NULL, '27427643110', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14590035, 'AA4163012788', 1, NULL),
(42764315, 'QUIROGA REBECA FELICIA', NULL, NULL, NULL, NULL, '27427643153', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 33487314, 'AA1163020303', 1, NULL),
(42764325, 'CANOFRE DAIANA ESTER', NULL, NULL, NULL, NULL, '27427643250', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24865466, 'AA5074106531', 1, NULL),
(42764327, 'GARCIA JULIO EMANUEL', NULL, NULL, NULL, NULL, '20427643272', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24545356, 'AA8313683248', 1, NULL),
(42764328, 'GAUTO ALEJANDRA CELESTE', NULL, NULL, NULL, NULL, '27427643285', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 17317752, 'AA3313671114', 1, NULL),
(42764330, 'ESPINOLA JOANA MICAELA', NULL, NULL, NULL, NULL, '27427643307', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 26957899, 'AA3163015560', 1, NULL),
(42764331, 'GALL ANGEL GABRIEL', NULL, NULL, NULL, NULL, '20427643310', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588199, 'AA3074100418', 1, NULL),
(42764332, 'CACERES FEDERICO NAHUEL', NULL, NULL, NULL, NULL, '20427643329', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 20489451, 'AA8163015775', 1, NULL),
(42764336, 'SANTACRUZ LUCY GUADALUPE', NULL, NULL, NULL, NULL, '27427643366', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 5, 0, 1, 4, 94558965, 'AA1163020076', 1, NULL),
(42764337, 'BENITEZ JONATAN WALDEMAR', NULL, NULL, NULL, NULL, '23427643379', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 92050560, 'AA5313681314', 1, NULL),
(42764338, 'GONZALEZ MATIAS EMANUEL', NULL, NULL, NULL, NULL, '20427643388', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23901838, 'AA9313686353', 1, NULL),
(42811244, 'AQUINO GIMENA LARISA ARAMI', NULL, NULL, NULL, NULL, '27428112445', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 23169327, 'AA7163038083', 1, NULL),
(42811487, 'SAUCEDO FERNANDA GABRIELA', NULL, NULL, NULL, NULL, '27428114871', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30662724, 'AA5313688822', 1, NULL),
(42812324, 'MORINIGO JOSUE EDUARDO ENRIQUE', NULL, NULL, NULL, NULL, '20428123248', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207956, 'AA6163023488', 1, NULL),
(42881000, 'VILLALBA CRISTIAN SEBASTIAN', NULL, NULL, NULL, NULL, '20428810008', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 26425617, 'AA4074078474', 1, NULL),
(42891190, 'VELAZQUEZ CESAR AGUSTIN', NULL, NULL, NULL, NULL, '20428911904', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23581814, 'AA3074113644', 1, NULL),
(42965454, 'VILLALBA SEBASTIAN ALEJANDRO', NULL, NULL, NULL, NULL, '20429654549', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373643, 'AA2074127113', 1, NULL),
(42965456, 'GONZALEZ JUAN MANUEL', NULL, NULL, NULL, NULL, '20429654565', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23367961, 'AA6313675780', 1, NULL),
(42965459, 'MARTINEZ DAMARIS ANDREA', NULL, NULL, NULL, NULL, '27429654594', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA7313677451', 1, NULL),
(42965460, 'RUIZ DIAZ SABRINA AYELEN', NULL, NULL, NULL, NULL, '27429654608', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26438546, 'AA7313676820', 1, NULL),
(42965463, 'REYES ANA CLARA', NULL, NULL, NULL, NULL, '27429654632', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 27031413, 'AA8313682074', 1, NULL),
(42965475, 'MARTINEZ EMILIANO JOSE', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 14755049, 'AA2074168286', 1, NULL),
(42965478, 'VILLAVERDE CRISTINA ANABEL', NULL, NULL, NULL, NULL, '27429654780', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 28553252, 'AA9184124296', 1, NULL),
(42965480, 'CARDOZO LUCY FERNANDA', NULL, NULL, NULL, NULL, '27429654802', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93097476, 'AA1074166904', 1, NULL),
(42965482, 'BRUNO KEVIN JAVIER', NULL, NULL, NULL, NULL, '20429654824', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 23161277, 'AA3074114134', 1, NULL),
(42965485, 'MOREL FLORENTIN LORENZO', NULL, NULL, NULL, NULL, '20429654859', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 1, 10, 1, 36, 1, 2, 1, 2, 4, 16451453, 'AA3074130965', 1, NULL),
(42965490, 'CORREA CLARISA MARIANELLA', NULL, NULL, NULL, NULL, '23429654904', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17087474, 'AA0313683414', 1, NULL),
(42965590, 'OTT CESAR ANDRES', NULL, NULL, NULL, NULL, '20429655901', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26477279, 'AA4074071077', 1, NULL),
(42966635, 'MOLINA VIVIANA TAMARA', NULL, NULL, NULL, NULL, '27429666355', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25313064, 'AA5074144688', 1, NULL),
(43010749, 'BENITEZ MICAELA AYLEN', NULL, NULL, NULL, NULL, '27430107491', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 26957863, 'AA9313673506', 1, NULL),
(43070031, 'ALVAREZ ROSALBA MARISEL', NULL, NULL, NULL, NULL, '27430700311', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 18795578, 'AA9313673221', 1, NULL),
(43070036, 'GONZALEZ ADRIANA ROCIO BELEN', NULL, NULL, NULL, NULL, '27430700362', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28905451, 'AA3313679947', 1, NULL),
(43070040, 'MACHADO ESTELA NOEMI', NULL, NULL, NULL, NULL, '27430700400', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94088323, 'AA9313674043', 1, NULL),
(43070050, 'VERA ARNALDO EXEQUIEL', NULL, NULL, NULL, NULL, '20430700503', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 31701721, 'AA0313687373', 1, NULL),
(43070053, 'MARQUEZ CLAUDIA YANINA', NULL, NULL, NULL, NULL, '27430700532', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16504980, 'AA2074056771', 1, NULL),
(43070054, 'GOMEZ ARIEL GUSTAVO', NULL, NULL, NULL, NULL, '20430700547', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452837, 'AA1074159830', 1, NULL),
(43070057, 'VILLALBA ROLANDO GABRIEL', NULL, NULL, NULL, NULL, '20430700570', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18686774, 'AA2074163143', 1, NULL),
(43072342, 'NUÑEZ NATALIA BELEN', NULL, NULL, NULL, NULL, '27430723427', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29590193, 'AA9313682901', 1, NULL),
(43120439, 'VOGEL MAURICIO JOSE', NULL, NULL, NULL, NULL, '20431204399', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 25450469, 'AA6313673718', 1, NULL),
(43120822, 'RAMIREZ ENZO DANIEL', NULL, NULL, NULL, NULL, '23431208229', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94348038, 'AA2074056596', 1, NULL),
(43120823, 'RAMIREZ MIGUEL ANGEL', NULL, NULL, NULL, NULL, '20431208238', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 94348038, 'AA2074133067', 1, NULL),
(43153335, 'DUARTE MAXIMILIANO ALEJANDRO', NULL, NULL, NULL, NULL, '23431533359', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 20987006, 'AA1074129545', 1, NULL),
(43153336, 'BOBADILLA MILAGRO CELESTE', NULL, NULL, NULL, NULL, '27431533362', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24373744, 'AA2074079189', 1, NULL),
(43153337, 'CANDIA JULIO FABIAN', NULL, NULL, NULL, NULL, '20431533376', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23225381, 'AA2074157440', 1, NULL),
(43153338, 'RECALDE ELSA MAGALI', NULL, NULL, NULL, NULL, '27431533389', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33160715, 'AA4313675364', 1, NULL),
(43153340, 'RIVAS CARLA EVELYN', NULL, NULL, NULL, NULL, '27431533400', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 28484445, 'AA1313694244', 1, NULL),
(43153343, 'ZARZA NAHUEL IVAN', NULL, NULL, NULL, NULL, '20431533430', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 20242760, 'AA4074078332', 1, NULL),
(43153352, 'TORRES DANIELA PAOLA', NULL, NULL, NULL, NULL, '27431533524', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30199742, 'AA2074078064', 1, NULL),
(43153355, 'GONZALEZ MALENA AGUSTINA', NULL, NULL, NULL, NULL, '27431533559', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 2, 0, 2, 4, 20987203, 'AA2074099879', 1, NULL);
INSERT INTO `personas` (`Dni`, `Apellidos_Nombres`, `Edad`, `Domicilio`, `Tel_Contacto`, `Fecha_Nac`, `Cuil`, `Lugar_Nacimiento`, `Fecha_Actualizacion`, `Usuario`, `Cod_Postal`, `Repitente`, `Id_Sexo`, `Id_Departamento`, `Id_Provincia`, `Id_Localidad`, `Id_Estado`, `Id_Curso`, `Id_Division`, `Id_Turno`, `Id_Estado_Civil`, `Dni_Tutor`, `NroSerie`, `Id_Cargo`, `Foto`) VALUES
(43153357, 'BENITEZ LUIS GASTON', NULL, NULL, NULL, NULL, '20431533570', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18351020, 'AA3074151788', 1, NULL),
(43153358, 'BRITEZ JOSE ALFREDO', NULL, NULL, NULL, NULL, '20431533589', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29819871, 'AA4074054457', 1, NULL),
(43153733, 'DIAZ MILAGROS MARCELA', NULL, NULL, NULL, NULL, '27431537333', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21914843, 'AA8313696610', 1, NULL),
(43153738, 'BENITEZ MAURICIO NICOLAS', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA1313689882', 1, NULL),
(43153746, 'MENDOZA ALVARO RAUL', NULL, NULL, NULL, NULL, '20431537460', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 14755049, 'AA3313670020', 1, NULL),
(43153750, 'ESPINOLA SABRINA YANEL', NULL, NULL, NULL, NULL, '27431537503', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 95188467, 'AA9313685064', 1, NULL),
(43154134, 'ANTUNEZ DE SOUZA RODRIGO', NULL, NULL, NULL, NULL, '20431541344', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18104966, 'AA0313687487', 1, NULL),
(43155282, 'BENITEZ SERGIO ALVARO AGUSTIN', NULL, NULL, NULL, NULL, '20431552826', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26397418, 'AA1074119974', 1, NULL),
(43155623, 'BOGADO MIGUEL ANGEL', NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 147750499, 'AA2074101875', 1, NULL),
(43220170, 'ESPINOLA CELESTE RAMONA', NULL, NULL, NULL, NULL, '27432201703', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22266664, 'AA2313670295', 1, NULL),
(43238528, 'BENITEZ LUDMILA BELEN', NULL, NULL, NULL, NULL, '27432385286', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29813922, 'AA8313685865', 1, NULL),
(43256823, 'VILLALBA SAMUEL', NULL, NULL, NULL, NULL, '20432568238', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 93007327, 'AA3313671570', 1, NULL),
(43326559, 'BAEZ MUÑOZ ROCIO MILAGROS AYELEN', NULL, NULL, NULL, NULL, '27433265594', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 21814335, 'AA2313694996', 1, NULL),
(43330823, 'VILLALBA JULIANA', NULL, NULL, NULL, NULL, '27433308234', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18866151, 'AA5074137098', 1, NULL),
(43357120, 'SANCHEZ DIONICIA BEATRIZ', NULL, NULL, NULL, NULL, '27433571202', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14773350, 'AA9313673582', 1, NULL),
(43358073, 'FLECHA HECTOR JAVIER', NULL, NULL, NULL, NULL, '20433580738', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17345280, 'AA3313675899', 1, NULL),
(43358077, 'RIVAS FABIAN', NULL, NULL, NULL, NULL, '20433580770', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14755049, 'AA2074165857', 1, NULL),
(43358078, 'LOPEZ LUCILA MAGALI', NULL, NULL, NULL, NULL, '27433580783', NULL, NULL, NULL, '3374', 'SI', 3, 10, 1, 36, 1, 3, 0, 1, 4, 32736628, 'AA3313680261', 1, NULL),
(43358080, 'MORINIGO ANDREA JOANA', NULL, NULL, NULL, NULL, '27433580805', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27431618, 'AA3074151395', 1, NULL),
(43358081, 'DENIS CINDY MELINA CELESTE', NULL, NULL, NULL, NULL, '27433580813', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23354103, 'AA1074144928', 1, NULL),
(43358082, 'DA SILVA ROCIO JAQUELINE', NULL, NULL, NULL, NULL, '27433580821', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18883643, 'AA5074114706', 1, NULL),
(43358083, 'DA SILVA HECTOR DANIEL', NULL, NULL, NULL, NULL, '20433580835', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 31761153, 'AA4074078764', 1, NULL),
(43358086, 'LOPEZ NAIRO LAN', NULL, NULL, NULL, NULL, '23433580869', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30521304, 'AA4074071134', 1, NULL),
(43358087, 'GONZALEZ CRISTIAN ABRAHAM', NULL, NULL, NULL, NULL, '20433580878', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30574135, 'AA4074077629', 1, NULL),
(43358093, 'ESTEVAN EVA ADRIANA', NULL, NULL, NULL, NULL, '27433580937', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25467791, 'AA2313672777', 1, NULL),
(43358097, 'BARRIOS LUZ BELEN', NULL, NULL, NULL, NULL, '23433580974', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27513918, 'AA4074080593', 1, NULL),
(43419903, 'ERNST ALEX EZEQUIEL', NULL, NULL, NULL, NULL, '20434199035', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 14007318, 'AA2074063262', 1, NULL),
(43419988, 'YEGROS RODOLFO JOAQUIN', NULL, NULL, NULL, NULL, '0', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 1, 10, 1, 36, 1, 3, 13, 1, 4, 147750499, 'AA2074052735', 1, NULL),
(43420007, 'SCHUERNER JUAN DANIEL', NULL, NULL, NULL, NULL, '20434200076', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25017256, 'AA4074079162', 1, NULL),
(43517428, 'RIVAS ENRIQUE JOSE', NULL, NULL, NULL, NULL, '20435174281', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28610098, 'AA2074098428', 1, NULL),
(43528097, 'VILLALBA DE ALEXANDRO RAMON', NULL, NULL, NULL, NULL, '20435280979', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563036, 'AA2074094511', 1, NULL),
(43529718, 'SUAREZ LEONEL ANDRES', NULL, NULL, NULL, NULL, '20435297189', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24236992, 'AA2074098410', 1, NULL),
(43547004, 'BENITEZ ESTEBAN DANIEL', NULL, NULL, NULL, NULL, '20435470042', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18860668, 'AA0313676838', 1, NULL),
(43547005, 'BENITEZ RENATA', NULL, NULL, NULL, NULL, '27435470055', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18860668, 'AA3313690917', 1, NULL),
(43547009, 'BAEZ LURDES MELINA', NULL, NULL, NULL, NULL, '27435470098', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 31761047, 'AA2074099896', 1, NULL),
(43547013, 'ESPINOLA MONICA ESTELA', NULL, NULL, NULL, NULL, '27435470136', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26207965, 'AA2074100932', 1, NULL),
(43547024, 'MENDIETA MARTINEZ LUCAS IVAN', NULL, NULL, NULL, NULL, '20435470247', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 40411036, 'AA8313674197', 1, NULL),
(43547027, 'FERREIRA CARLA MARILUZ', NULL, NULL, NULL, NULL, '27435470276', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 92534497, 'AA3313670214', 1, NULL),
(43547029, 'GOMEZ EXEQUIEL ENRIQUE', NULL, NULL, NULL, NULL, '20435470298', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 18903705, 'AA4074071099', 1, NULL),
(43664476, 'MORINIGO MILAGROS SOL', NULL, NULL, NULL, NULL, '27436644766', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525163, 'AA1163016747', 1, NULL),
(43700751, 'MARQUEZ FATIMA ISABEL', NULL, NULL, NULL, NULL, '27437007514', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33075314, 'AA2074062097', 1, NULL),
(43700756, 'GIMENEZ RAMONA ROXANA', NULL, NULL, NULL, NULL, '27437007565', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11326429, 'AA2074062065', 1, NULL),
(43700763, 'CUBA JOSE ANDRES', NULL, NULL, NULL, NULL, '20437007633', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 29534996, 'AA4074072193', 1, NULL),
(43700768, 'VAZQUEZ FRANCISCA', NULL, NULL, NULL, NULL, '27437007689', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22525177, 'AA1074166144', 1, NULL),
(43700769, 'VAZQUEZ JUAN MARTIN', NULL, NULL, NULL, NULL, '20437007692', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 29953330, 'AA2074062151', 1, NULL),
(43700771, 'GONZALEZ JOSE MARTIN', NULL, NULL, NULL, NULL, '20437007714', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 1, 10, 1, 36, 1, 2, 1, 2, 4, 28553118, 'AA4074072229', 1, NULL),
(43700772, 'PONCE MOLINA LAILA MICAELA', NULL, NULL, NULL, NULL, '27437007727', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26746777, 'AA9313694033', 1, NULL),
(43700773, 'CABAÑAS ADRIAN RAMIRO', NULL, NULL, NULL, NULL, '20437007730', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17090838, 'AA6313684104', 1, NULL),
(43700777, 'WIEDEMANN NATALY RAQUEL', NULL, NULL, NULL, NULL, '27437007778', NULL, '2017-04-25', 'mpereira', '3374', 'NO', 2, 10, 1, 36, 1, 2, 2, 2, 4, 95120650, 'AA9055005436', 1, NULL),
(43758001, 'GALL ANA MARIA', NULL, NULL, NULL, NULL, '23437580014', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588199, 'AA4074077612', 1, NULL),
(43758004, 'BENITEZ JULIANA RAQUEL', NULL, NULL, NULL, NULL, '27437580044', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 147750499, 'AA1074139590', 1, NULL),
(43758006, 'VAZQUEZ GRISELDA NOEMI', NULL, NULL, NULL, NULL, '27437580060', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 32042025, 'AA2074056677', 1, NULL),
(43758010, 'VERGARA GIANELA MILAGROS', NULL, NULL, NULL, NULL, '27437580109', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23452701, 'AA4074072185', 1, NULL),
(43758017, 'LEIVA CARLOS JOAQUIN', NULL, NULL, NULL, NULL, '20437580171', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30131247, 'AA2074099842', 1, NULL),
(43758448, 'SANABRIA DAIANA ELIZABETH', NULL, NULL, NULL, NULL, '27437584481', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24079936, 'AA1074161831', 1, NULL),
(43944651, 'SANTACRUZ YULIANA VANESA', NULL, NULL, NULL, NULL, '27439446515', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 94558965, 'AA6313697987', 1, NULL),
(43944655, 'OVIEDO CRISTIAN RAMON', NULL, NULL, NULL, NULL, '20439446553', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 25493219, 'AA4074064306', 1, NULL),
(43944663, 'ROJAS KEVIN DAVID', NULL, NULL, NULL, NULL, '20439446634', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30706722, 'AA2074099928', 1, NULL),
(43944670, 'BENITEZ WALTER ORLANDO', NULL, NULL, NULL, NULL, '20439446707', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23161251, 'AA2074061772', 1, NULL),
(43944672, 'CANOFRE MYRIAM SUSANA', NULL, NULL, NULL, NULL, '27439446728', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 21302722, 'AA4074078778', 1, NULL),
(43944676, 'CUBA PATRICIA NOEMI', NULL, NULL, NULL, NULL, '27439446760', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 29534996, 'AA2074052670', 1, NULL),
(43945863, 'VOGEL TOMAS ENRIQUE', NULL, NULL, NULL, NULL, '20439458632', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 1, 10, 1, 36, 1, 3, 13, 1, 4, 25450469, 'AA2074100035', 1, NULL),
(44072172, 'WIEDEMANN ANTONELA ISABEL', NULL, NULL, NULL, NULL, '27440721724', NULL, '2017-04-25', 'mpereira', '3374', 'NO', 2, 10, 1, 36, 1, 2, 2, 2, 4, 30283746, 'AA4074071045', 1, NULL),
(44072174, 'ALVAREZ LEANDRO', NULL, NULL, NULL, NULL, '20440721746', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20644707, 'AA4074079118', 1, NULL),
(44072175, 'ESPINOLA GABRIEL MATIAS', NULL, NULL, NULL, NULL, '20440721754', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26957899, 'AA1074161883', 1, NULL),
(44072177, 'CANDIA ODILIO RAFAEL', NULL, NULL, NULL, NULL, '20440721770', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 23225381, 'AA3074151185', 1, NULL),
(44072180, 'GONZALEZ KEVIN NICOLAS', NULL, NULL, NULL, NULL, '20440721800', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23901838, 'AA2074057073', 1, NULL),
(44072182, 'KRON BRIAN DANIEL', NULL, NULL, NULL, NULL, '20440721827', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 92244911, 'AA2074078496', 1, NULL),
(44072184, 'GONZALEZ LUCAS JULIAN', NULL, NULL, NULL, NULL, '20440721843', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24174819, 'AA1074161136', 1, NULL),
(44072185, 'NERIS ADRIANA SOLEDAD', NULL, NULL, NULL, NULL, '27440721856', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 2, 0, 2, 4, 27757986, 'AA1074160834', 1, NULL),
(44072193, 'GARCIA MARTIN RODRIGO', NULL, NULL, NULL, NULL, '20440721932', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17090862, 'AA2074099088', 1, NULL),
(44073560, 'GALEANO JORGE JAVIER', NULL, NULL, NULL, NULL, '20440735607', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18876273, 'AA2074051003', 1, NULL),
(44109380, 'PAREDES SOFIA AILEN', NULL, NULL, NULL, NULL, '27441093808', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 27458774, 'AA2074065357', 1, NULL),
(44149033, 'GONZALEZ MILAGROS CELIA MARIANA', NULL, NULL, NULL, NULL, '27441490335', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28905451, 'AA2074075604', 1, NULL),
(44149042, 'BENITEZ SOFIA SOLEDAD', NULL, NULL, NULL, NULL, '27441490424', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 25643592, 'AA4074070524', 1, NULL),
(44149046, 'CAMACHO EVELIN ROCIO', NULL, NULL, NULL, NULL, '27441490467', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 28399736, 'AA3074151229', 1, NULL),
(44149048, 'MARTINEZ GILDA', NULL, NULL, NULL, NULL, '27441490483', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16671679, 'AA4074067416', 1, NULL),
(44227075, 'RUIZ DIAZ ANA BEATRIZ', NULL, NULL, NULL, NULL, '27442270754', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 30283792, 'AA2074065405', 1, NULL),
(44227757, 'REYES BRENDA FIORELLA', NULL, NULL, NULL, NULL, '27442277570', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23399095, 'AA2074077580', 1, NULL),
(44227758, 'ZARZA BELEN MAGALI', NULL, NULL, NULL, NULL, '27442277589', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 18783415, 'AA3074148705', 1, NULL),
(44227760, 'BAEZ ANA GABRIELA', NULL, NULL, NULL, NULL, '27442277600', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 2, 10, 1, 36, 1, 2, 1, 2, 4, 30250017, 'AA3074149597', 1, NULL),
(44227761, 'BAREIRO DEDIEU FIAMA AGUSTINA', NULL, NULL, NULL, NULL, '27442277619', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25271220, 'AA2074087550', 1, NULL),
(44227764, 'ALMADA IVAN ESTEFANEL', NULL, NULL, NULL, NULL, '20442277649', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 2, 1, 2, 4, 16451452, 'AA2074053210', 1, NULL),
(44227765, 'FELIPE DE OLIVERA YENIFER CECILIA', NULL, NULL, NULL, NULL, '27442277651', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18717371, 'AA1074145121', 1, NULL),
(44227769, 'UMERES DANIELA AGUSTINA', NULL, NULL, NULL, NULL, '27442277694', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 27930400, 'AA2074102258', 1, NULL),
(44228273, 'BENITEZ JOSE CLAUDIO', NULL, NULL, NULL, NULL, '20442282731', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 18127376, 'AA4074079053', 1, NULL),
(44228282, 'PERALTA ANGEL GABRIEL', NULL, NULL, NULL, NULL, '20442282820', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588199, 'AA2074098895', 1, NULL),
(44228283, 'MOREL JUAN JOSE', NULL, NULL, NULL, NULL, '20442282839', NULL, '2017-04-25', 'mpereira', '3374', 'NO', 1, 10, 1, 36, 1, 2, 2, 2, 4, 29212822, 'AA3074152003', 1, NULL),
(44278883, 'NUÑEZ AMELIA', NULL, NULL, NULL, NULL, '27442788834', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30522001, 'AA3074151773', 1, NULL),
(44388686, 'CABALLERO YAMILA AYELEN', NULL, NULL, NULL, NULL, '27443886864', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94966409, 'AA3074149626', 1, NULL),
(44389106, 'VILLALBA ELVIO NICOLAS', NULL, NULL, NULL, NULL, '20443891065', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20297693, 'AA2074078110', 1, NULL),
(44389114, 'GONZALEZ LUZ MILAGROS', NULL, NULL, NULL, NULL, '27443891140', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20987203, 'AA3074149107', 1, NULL),
(44389115, 'MORAIZ ANA MARIA', NULL, NULL, NULL, NULL, '27443891159', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 20688941, 'AA1074164447', 1, NULL),
(44394871, 'VILLALBA ANABELA BEATRIZ', NULL, NULL, NULL, NULL, '27443948711', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 31123342, 'AA5074139419', 1, NULL),
(44435206, 'LOPEZ CARLA NAELI', NULL, NULL, NULL, NULL, '27444352065', NULL, '2017-04-24', 'jjcervera', '3374', 'SI', 3, 10, 1, 36, 1, 1, 0, 2, 4, 22334390, 'AA4074069658', 1, NULL),
(44435216, 'VERGARA CARLOS DIEGO', NULL, NULL, NULL, NULL, '20444352168', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27588105, 'AA2074099863', 1, NULL),
(44435220, 'MARTINEZ LUCILA LUZ CLARITA', NULL, NULL, NULL, NULL, '27444352200', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 33864937, 'AA4074068435', 1, NULL),
(44435593, 'ALVAREZ EMANUEL MATIAS', NULL, NULL, NULL, NULL, '20444355930', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 21520302, 'AA4074077630', 1, NULL),
(44528562, 'FRANCO RODRIGO ALBERTO', NULL, NULL, NULL, NULL, '20445285626', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94544025, 'AA1074069830', 1, NULL),
(44528566, 'FRANCO FLAVIA ESTER', NULL, NULL, NULL, NULL, '27445285663', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 2, 10, 1, 36, 1, 2, 1, 2, 4, 94544025, 'AA4074052122', 1, NULL),
(44540436, 'AQUINO NURIA MAGDALENA ANAHI', NULL, NULL, NULL, NULL, '27445404360', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 23169327, 'AA5074146599', 1, NULL),
(44541555, 'CARDOZO TANIA AYELEN', NULL, NULL, NULL, NULL, '27445415559', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 18351014, 'AA4074066582', 1, NULL),
(44541556, 'ROMERO EXEQUIEL FABIAN', NULL, NULL, NULL, NULL, '20445415562', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27930380, 'AA4074079343', 1, NULL),
(44541557, 'BRUNO GABRIEL DAVID', NULL, NULL, NULL, NULL, '20445415570', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 23161277, 'AA4074078328', 1, NULL),
(44541560, 'OLSSON JUAN GABRIEL', NULL, NULL, NULL, NULL, '20445415600', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 25651008, 'AA4074077643', 1, NULL),
(44541564, 'MULLER BLANCA CELESTE', NULL, NULL, NULL, NULL, '27445415648', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 3, 0, 1, 4, 27529794, 'AA2074078144', 1, NULL),
(44880003, 'REYES MELANY DANIELA', NULL, NULL, NULL, NULL, '27448800038', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27031413, 'AA4074068804', 1, NULL),
(44880006, 'BENITEZ NAHUEL SEBASTIAN', NULL, NULL, NULL, NULL, '20448800068', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 28905427, 'AA3074151171', 1, NULL),
(44880007, 'RIOS MARIELA GISELL', NULL, NULL, NULL, NULL, '27448800070', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 18795782, 'AA4074091861', 1, NULL),
(44989503, 'GONZALEZ NATALIA ELIZ', NULL, NULL, NULL, NULL, '27449895032', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23367961, 'AA4074054619', 1, NULL),
(45027501, 'ROA SOLANA AYLEN', NULL, NULL, NULL, NULL, '27450275013', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 24150248, 'AA4074071743', 1, NULL),
(45027504, 'BENITEZ MARISA BELEN', NULL, NULL, NULL, NULL, '27450275048', NULL, '2017-04-25', 'jjcervera', '3374', 'NO', 2, 10, 1, 36, 1, 2, 3, 2, 4, 18351020, 'AA5074102516', 1, NULL),
(45027506, 'RIOS MAGALI SOLANGE', NULL, NULL, NULL, NULL, '27450275064', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 27999532, 'AA4074052211', 1, NULL),
(45027515, 'LAGROTA CELINA ANABELA', NULL, NULL, NULL, NULL, '27450275153', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 20526660, 'AA5074118976', 1, NULL),
(45027518, 'MORINIGO LUIS ARIEL', NULL, NULL, NULL, NULL, '20450275183', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 27431618, 'AA3074155167', 1, NULL),
(45027520, 'DUARTE RAMON EMANUEL', NULL, NULL, NULL, NULL, '20450275205', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 23901881, 'AA1074167067', 1, NULL),
(45027550, 'RODRIGUEZ MATIAS ADRIAN', NULL, NULL, NULL, NULL, '20450275507', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 93933962, 'AA5074135604', 1, NULL),
(45053411, 'LOPEZ FIORELLA GUADALUPE', NULL, NULL, NULL, NULL, '27450534116', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17563011, 'AA4074078211', 1, NULL),
(45053412, 'CORREA EMILIANA ALDANA', NULL, NULL, NULL, NULL, '27450534124', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 17087474, 'AA4074070876', 1, NULL),
(45053423, 'AGUIAR PABLO NAHUEL', NULL, NULL, NULL, NULL, '20450534235', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 18266619, 'AA4074073556', 1, NULL),
(45053426, 'RUIZ DIAZ JORGE RAFAEL', NULL, NULL, NULL, NULL, '23450534269', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 26438546, 'AA4074068048', 1, NULL),
(45053439, 'VILLALBA MARIO EZEQUIEL', NULL, NULL, NULL, NULL, '20450534391', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 17952747, 'AA4074078759', 1, NULL),
(45053478, 'CESPEDES LUDMILA MAGALI', NULL, NULL, NULL, NULL, '27450534787', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 26207983, 'AA3074151746', 1, NULL),
(45133212, 'OLIVERA SABRINA', NULL, NULL, NULL, NULL, '0', NULL, '2017-06-02', 'jjcervera', '3374', 'NO', 2, 10, 1, 36, 1, 2, 2, 2, 4, 32435252, 'AA9315000410', 1, NULL),
(45136830, 'REY FORENCIA MARIA BELEN', NULL, NULL, NULL, NULL, '27451368309', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 11308838, 'AA3074151813', 1, NULL),
(45340636, 'WIEDEMANN CLAUDIO FACUNDO (fernando en anses)', NULL, NULL, NULL, NULL, '23453406369', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16889307, 'AA9313674174', 1, NULL),
(45555429, 'SILVERO MILAGROS AYLEN', NULL, NULL, NULL, NULL, '27455554298', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 1, 2, 4, 22525101, 'AA5074146960', 1, NULL),
(46166200, 'FERREIRA DIEGO JONATAN(C D)', NULL, NULL, NULL, NULL, '20461662006', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18852457, 'AA5163012222', 1, NULL),
(46550064, 'PRESTES YESICA BEATRIZ', NULL, NULL, NULL, NULL, '27465500641', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 30283740, '5051021825', 1, NULL),
(46728567, 'VAZQUEZ JOSE DANIEL', NULL, NULL, NULL, NULL, '20467285670', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 18679088, 'AA3074149502', 1, NULL),
(47119661, 'AVELLANEDA ROMINA AYELEN', NULL, NULL, NULL, NULL, '23471196614', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 32736616, 'AA7313680457', 1, NULL),
(47595722, 'FRANCO JOSE WILBERTO', NULL, NULL, NULL, NULL, '23475957229', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94544025, 'AA2074094539', 1, NULL),
(47627819, 'PARRA ESCROMEDA JOSE MARIA', NULL, NULL, NULL, NULL, '27476278193', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 11523490, '8051056297', 1, NULL),
(49278945, 'ALVAREZ MARIELA BEATRIZ', NULL, NULL, NULL, NULL, '27492789459', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94730386, 'AA1074153253', 1, NULL),
(49278987, 'GAONA MALDONADO MATIAS', NULL, NULL, NULL, NULL, '23492789879', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94544048, '9051025187', 1, NULL),
(49278990, 'CHAPARRO MARCIAL', NULL, NULL, NULL, NULL, '23492789909', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94557014, 'AA2074094690', 1, NULL),
(49278992, 'LOPEZ JUNIOR SANTIAGO', NULL, NULL, NULL, NULL, '20492789926', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 94704582, 'AA4074072458', 1, NULL),
(49388079, 'AQUINO NESTOR', NULL, NULL, NULL, NULL, '23493880799', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 18880061, 'AA3313676204', 1, NULL),
(49388549, 'GONZALEZ SANTA CRUZ SERGIO', NULL, NULL, NULL, NULL, '23493885499', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 16451474, 'AA3313671451', 1, NULL),
(49477469, 'MARTINEZ CINTIA', NULL, NULL, NULL, NULL, '27494774696', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 4, 0, 1, 4, 14755049, 'AA3074019746', 1, NULL),
(49570467, 'OJEDA MARIA BELEN', NULL, NULL, NULL, NULL, '27495704675', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 1, 17, 13, 1, 4, 94593627, 'AA5074124024', 1, NULL),
(49570477, 'VILLALBA FREDI ALCIDES', NULL, NULL, NULL, NULL, '20495704778', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94864068, 'AA1163018383', 1, NULL),
(49659018, 'BENITEZ NIDIA', NULL, NULL, NULL, NULL, '27496590185', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 95268856, 'AA3074155760', 1, NULL),
(49659036, 'DUARTE DIEGO ANDRES', NULL, NULL, NULL, NULL, '20496590369', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 24555332, '8051037372', 1, NULL),
(49659076, 'VILLALBA SANDRA FABIOLA', NULL, NULL, NULL, NULL, '27496590762', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 12490169, 'AA9313693576', 1, NULL),
(49659087, 'ESQUIVEL LIZ MARIBEL', NULL, NULL, NULL, NULL, '27496590878', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94672861, 'AA3313671730', 1, NULL),
(49659099, 'BENITEZ ANA', NULL, NULL, NULL, NULL, '27496590991', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 95193378, 'AA5074105805', 1, NULL),
(49789233, 'ALTAMIRANO MICAELA', NULL, NULL, NULL, NULL, '27497892339', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 22182765, 'AA5163030577', 1, NULL),
(50456745, 'CABALLERO DIONEL DAVID', NULL, NULL, NULL, NULL, '20504567452', NULL, '2017-04-24', 'Gabriel', '3374', 'NO', 3, 10, 1, 36, 1, 5, 1, 1, 4, 94664561, 'AA2163023346', 1, NULL),
(50456746, 'CABALLERO NAYELI MARIANA', NULL, NULL, NULL, NULL, '27504567465', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94664561, 'AA5074119373', 1, NULL),
(50663132, 'MARTINEZ CESAR DARIO', NULL, NULL, NULL, NULL, '20506631328', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94473271, 'AA1163018279', 1, NULL),
(50663133, 'MARTINEZ LAURA RAMONA', NULL, NULL, NULL, NULL, '27506631330', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94473271, 'AA3163023393', 1, NULL),
(53363694, 'BENITEZ SAMANTA NOEMI', NULL, NULL, NULL, NULL, '27533636948', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 95268856, 'AA5074150140', 1, NULL),
(53538208, 'RAMIREZ ELBIO OMAR', NULL, NULL, NULL, NULL, '20535382086', NULL, '2017-04-24', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 0, 2, 4, 30379339, 'AA4074079070', 1, NULL),
(94120199, 'ALFONZO CARDOZO LIZ VALERIA', NULL, NULL, NULL, NULL, '20941201998', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94120199, '7051029895', 1, NULL),
(94746266, 'BOGADO RAMOS LIZANE PAOLA', NULL, NULL, NULL, NULL, '27947462666', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94514352, 'AA6313691274', 1, NULL),
(94859608, 'CABRAL ESTELA MARIS', NULL, NULL, NULL, NULL, '27948596089', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 94752166, '9051074667', 1, NULL),
(95058390, 'RIBEIRO MARIANO DE SOUZA LIZ BEATRIZ', NULL, NULL, NULL, NULL, '27950583903', NULL, NULL, NULL, '3374', 'NO', 3, 10, 1, 36, 11, 17, 13, 3, 4, 31379955, 'AA2074063537', 1, NULL),
(95339309, 'ACUÑA ROMERO BLANCA GUILLERMINA', NULL, NULL, NULL, NULL, '27953393099', NULL, '2017-04-26', 'jjcervera', '3374', 'NO', 3, 10, 1, 36, 1, 2, 3, 2, 4, 18686802, 'AA4074064088', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `piso_tecnologico`
--

CREATE TABLE `piso_tecnologico` (
  `Cue` varchar(100) NOT NULL,
  `Switch` varchar(100) DEFAULT NULL,
  `Estado_Switch` int(11) DEFAULT NULL,
  `Cantidad_Ap` int(11) DEFAULT NULL,
  `Cantidad_Ap_Func` int(11) DEFAULT NULL,
  `Ups` varchar(100) DEFAULT NULL,
  `Estado_Ups` int(11) DEFAULT NULL,
  `Marca_Modelo_Serie_Ups` varchar(300) DEFAULT NULL,
  `Cableado` varchar(100) DEFAULT NULL,
  `Estado_Cableado` int(11) DEFAULT NULL,
  `Porcent_Estado_Cab` int(11) DEFAULT NULL,
  `Plano_Escuela` text,
  `Porcent_Func_Piso` int(11) DEFAULT NULL,
  `Bocas_Switch` int(11) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `prestamo_equipo`
--

CREATE TABLE `prestamo_equipo` (
  `Id_Prestamo` int(11) NOT NULL,
  `Dni` int(11) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Fecha_Prestamo` date DEFAULT NULL,
  `Observacion` varchar(400) DEFAULT NULL,
  `Prestamo_Cargador` varchar(18) DEFAULT NULL,
  `Id_Estado_Prestamo` int(11) NOT NULL,
  `Id_Motivo_Prestamo` int(11) NOT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Devuelve_Cargador` varchar(20) DEFAULT NULL,
  `Id_Estado_Devol` int(11) NOT NULL DEFAULT '3',
  `Apellidos_Nombres_Beneficiario` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `problema`
--

CREATE TABLE `problema` (
  `Id_Problema` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problema`
--

INSERT INTO `problema` (`Id_Problema`, `Descripcion`) VALUES
(1, 'BATERIA'),
(2, 'BLOQUEADA'),
(3, 'BOTON ENCENDIDO'),
(4, 'CARGADOR'),
(5, 'CONFIGURACIONES INCORRECTAS'),
(6, 'CONTRASEÑA WINDOWS'),
(7, 'CONTRASEÑA BIOS'),
(8, 'DISCO'),
(9, 'FLEX DE DISCO'),
(10, 'FLEX PANTALLA'),
(11, 'GRUB'),
(12, 'IMAGEN S.O'),
(13, 'LINUX'),
(14, 'NO TOMA DESBLOQUEO/CERTIF'),
(15, 'NO ENCIENDE'),
(16, 'NO INICIA'),
(17, 'OTRO'),
(18, 'FALLA APLICACIONES'),
(19, 'OFFICE'),
(20, 'PANTALLA '),
(21, 'PARLANTE'),
(22, 'PIN DE CARGA'),
(23, 'PLACA MADRE'),
(24, 'PLACA WIFI'),
(25, 'TECLADO '),
(26, 'TOUCHPAD'),
(27, 'TV DIGITAL'),
(28, 'VIRUS'),
(29, 'WINDOWS'),
(30, 'PILA');

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE `provincias` (
  `Id_Provincia` int(11) NOT NULL,
  `Nombre` varchar(200) DEFAULT NULL,
  `Id_Pais` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provincias`
--

INSERT INTO `provincias` (`Id_Provincia`, `Nombre`, `Id_Pais`) VALUES
(1, 'MISIONES', 1);

-- --------------------------------------------------------

--
-- Table structure for table `reasignacion_equipo`
--

CREATE TABLE `reasignacion_equipo` (
  `Id_Reasignacion` int(10) NOT NULL,
  `NroSerie` varchar(30) NOT NULL,
  `Titular_Original` varchar(200) DEFAULT NULL,
  `Observacion` varchar(300) DEFAULT NULL,
  `Fecha_Reasignacion` date DEFAULT NULL,
  `Dni` int(11) NOT NULL,
  `Id_Motivo_Reasig` int(11) NOT NULL,
  `Nuevo_Titular` varchar(200) DEFAULT NULL,
  `Dni_Nuevo_Tit` int(11) DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `referente_tecnico`
--

CREATE TABLE `referente_tecnico` (
  `DniRte` int(11) NOT NULL,
  `Apellido_Nombre` varchar(100) DEFAULT NULL,
  `Id_Turno` int(11) NOT NULL,
  `Domicilio` varchar(200) DEFAULT NULL,
  `Telefono` int(11) DEFAULT NULL,
  `Celular` int(11) DEFAULT NULL,
  `Mail` varchar(200) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL,
  `Cue` varchar(100) NOT NULL,
  `Fecha_Ingreso` date DEFAULT NULL,
  `Titulo` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `referente_tecnico`
--

INSERT INTO `referente_tecnico` (`DniRte`, `Apellido_Nombre`, `Id_Turno`, `Domicilio`, `Telefono`, `Celular`, `Mail`, `Fecha_Actualizacion`, `Usuario`, `Cue`, `Fecha_Ingreso`, `Titulo`) VALUES
(27289607, 'CERVERA JUAN JOSE', 2, NULL, NULL, NULL, NULL, NULL, NULL, '540055800', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `seguimientodeequipos`
--
CREATE TABLE `seguimientodeequipos` (
`NroSerie` varchar(30)
,`Detalle` varchar(500)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `seguimientodepersonas`
--
CREATE TABLE `seguimientodepersonas` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Detalle` varchar(500)
,`Fecha_Actualizacion` date
);

-- --------------------------------------------------------

--
-- Table structure for table `servidor_escolar`
--

CREATE TABLE `servidor_escolar` (
  `Cue` varchar(100) NOT NULL,
  `Nro_Serie` varchar(100) NOT NULL DEFAULT '',
  `SN` varchar(200) DEFAULT NULL,
  `Cant_Net_Asoc` int(11) DEFAULT NULL,
  `Id_Marca` int(11) NOT NULL,
  `Id_SO` int(11) NOT NULL,
  `Id_Estado` int(11) NOT NULL,
  `Id_Modelo` int(11) NOT NULL,
  `User_Server` varchar(100) DEFAULT NULL,
  `Pass_Server` varchar(200) DEFAULT NULL,
  `User_TdServer` varchar(100) DEFAULT NULL,
  `Pass_TdServer` varchar(200) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sexo_personas`
--

CREATE TABLE `sexo_personas` (
  `Id_Sexo` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sexo_personas`
--

INSERT INTO `sexo_personas` (`Id_Sexo`, `Descripcion`) VALUES
(1, 'MASCULINO'),
(2, 'FEMENINO'),
(3, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `situacion_estado`
--

CREATE TABLE `situacion_estado` (
  `Id_Sit_Estado` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `situacion_estado`
--

INSERT INTO `situacion_estado` (`Id_Sit_Estado`, `Descripcion`) VALUES
(1, 'FUNCIONANDO'),
(2, 'EN/PARA SERVICIO TECNICO'),
(3, 'REMANENTE FUNCIONANDO'),
(4, 'REMANENTE DAÑADO'),
(14, 'OTRO'),
(7, 'ROBADO/PERDIDO'),
(8, 'TRANSFERENCIA PENDIENTE'),
(9, 'TRANSFERENCIA COMPLETA'),
(10, 'LIBERACIÓN PENDIENTE'),
(11, 'LIBERACIÓN COMPLETA'),
(12, 'EN REPARACIÓN'),
(13, 'PRESTAMO ESCOLAR'),
(15, 'OCIOSA FUNCIONANDO'),
(16, 'OCIOSA DAÑADA'),
(17, 'OBSOLETA FUNCIONANDO'),
(18, 'OBSOLETA DAÑADA');

-- --------------------------------------------------------

--
-- Table structure for table `so_server`
--

CREATE TABLE `so_server` (
  `Id_SO` int(11) NOT NULL,
  `Nombre` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `so_server`
--

INSERT INTO `so_server` (`Id_SO`, `Nombre`) VALUES
(1, 'DEBIAN'),
(2, 'UBUNTU'),
(3, 'HUAYRA'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_equipo`
--

CREATE TABLE `tipo_equipo` (
  `Id_Tipo_Equipo` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_equipo`
--

INSERT INTO `tipo_equipo` (`Id_Tipo_Equipo`, `Detalle`) VALUES
(1, 'NETBOOK'),
(2, 'SERVIDOR'),
(3, 'UPS'),
(4, 'SWITCH'),
(5, 'AP'),
(6, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_escuela`
--

CREATE TABLE `tipo_escuela` (
  `Id_Tipo_Esc` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_escuela`
--

INSERT INTO `tipo_escuela` (`Id_Tipo_Esc`, `Detalle`) VALUES
(4, 'EFA'),
(5, 'ESCUELA ESPECIAL'),
(6, 'UGL'),
(7, 'RESPONSABILIDAD EMPRESARIAL'),
(8, 'PRIMARIA DIGITAL'),
(9, 'PIE'),
(10, 'ISFD'),
(11, 'ALDEA'),
(12, 'ESCUELA SAMSUNG'),
(13, 'GURI DIGITAL'),
(14, 'ORIENTADA'),
(15, 'TECNICA'),
(17, 'RURAL'),
(18, 'ADULTO'),
(19, 'OTRA');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_extraccion`
--

CREATE TABLE `tipo_extraccion` (
  `Id_Tipo_Extraccion` int(11) NOT NULL,
  `Detalle` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_extraccion`
--

INSERT INTO `tipo_extraccion` (`Id_Tipo_Extraccion`, `Detalle`) VALUES
(1, 'NETBOOK'),
(2, 'TPMDATA'),
(3, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_falla`
--

CREATE TABLE `tipo_falla` (
  `Id_Tipo_Falla` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_falla`
--

INSERT INTO `tipo_falla` (`Id_Tipo_Falla`, `Descripcion`) VALUES
(1, 'HARDWARE'),
(2, 'SOFTWARE'),
(3, 'OTRA');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_jornada`
--

CREATE TABLE `tipo_jornada` (
  `Id_Jornada` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_jornada`
--

INSERT INTO `tipo_jornada` (`Id_Jornada`, `Detalle`) VALUES
(1, 'SIMPLE'),
(2, 'COMPLETA'),
(3, 'EXTENDIDA'),
(4, 'SIN DESCRIPCION');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_paquete`
--

CREATE TABLE `tipo_paquete` (
  `Id_Tipo_Paquete` int(11) NOT NULL,
  `Detalle` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_paquete`
--

INSERT INTO `tipo_paquete` (`Id_Tipo_Paquete`, `Detalle`) VALUES
(1, 'PROVISION'),
(2, 'MIGRACION');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_prioridad_atencion`
--

CREATE TABLE `tipo_prioridad_atencion` (
  `Id_Prioridad` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_prioridad_atencion`
--

INSERT INTO `tipo_prioridad_atencion` (`Id_Prioridad`, `Descripcion`) VALUES
(1, 'NORMAL'),
(2, 'ALTA'),
(3, 'MAXIMA');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_relacion_alumno_tutor`
--

CREATE TABLE `tipo_relacion_alumno_tutor` (
  `Id_Relacion` int(11) NOT NULL,
  `Desripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_relacion_alumno_tutor`
--

INSERT INTO `tipo_relacion_alumno_tutor` (`Id_Relacion`, `Desripcion`) VALUES
(1, 'PADRE'),
(2, 'MADRE'),
(3, 'TUTOR'),
(4, 'OTRO');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_retiro_atencion_st`
--

CREATE TABLE `tipo_retiro_atencion_st` (
  `Id_Tipo_Retiro` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_retiro_atencion_st`
--

INSERT INTO `tipo_retiro_atencion_st` (`Id_Tipo_Retiro`, `Descripcion`) VALUES
(3, 'OPERATIVO ST'),
(2, 'CORREO'),
(1, 'PENDIENTE');

-- --------------------------------------------------------

--
-- Table structure for table `tipo_solucion_problema`
--

CREATE TABLE `tipo_solucion_problema` (
  `Id_Tipo_Sol_Problem` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipo_solucion_problema`
--

INSERT INTO `tipo_solucion_problema` (`Id_Tipo_Sol_Problem`, `Descripcion`) VALUES
(1, 'DESBLOQUEAR'),
(2, 'REINSTALAR'),
(3, 'ACTIVAR'),
(4, 'SOLICITUD DE CARGADOR/BATERIA'),
(5, 'FORMATEAR'),
(6, 'RESTAURAR'),
(7, 'SERVICIO TECNICO'),
(8, 'SINCRONIZAR LLAVE'),
(9, 'SOLICITAR PAQUETE PROVISION'),
(10, 'QUITAR CONTRASEÑA'),
(11, 'OTRA');

-- --------------------------------------------------------

--
-- Stand-in structure for view `titulares-equipos-tutores`
--
CREATE TABLE `titulares-equipos-tutores` (
`Apelldio y Nombre Titular` varchar(400)
,`Dni` int(11)
,`Cuil` varchar(30)
,`Equipo Asignado` varchar(30)
,`Apellido y Nombre Tutor` varchar(400)
,`Dni Tutor` int(11)
,`Cuil Tutor` varchar(25)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `titularidad-equipos`
--
CREATE TABLE `titularidad-equipos` (
`Apellidos_Nombres` varchar(400)
,`Dni` int(11)
,`Cuil` varchar(30)
,`NroSerie` varchar(30)
,`Id_Cargo` int(11)
,`Id_Estado` int(11)
,`Id_Curso` int(11)
,`Id_Division` int(11)
,`Id_Turno` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `todas_atenciones`
--
CREATE TABLE `todas_atenciones` (
`N° Atencion` int(11)
,`Serie Equipo` varchar(30)
,`Nombre Titular` varchar(400)
,`Dni` int(11)
,`Fecha Entrada` date
,`Usuario que cargo` varchar(100)
,`Descripcion Problema` varchar(500)
,`Ultima Actualizacion` date
,`Id_Tipo_Falla` int(11)
,`Id_Problema` int(11)
,`Id_Tipo_Sol_Problem` int(11)
,`Id_Estado_Atenc` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `turno`
--

CREATE TABLE `turno` (
  `Id_Turno` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `turno`
--

INSERT INTO `turno` (`Id_Turno`, `Descripcion`) VALUES
(1, 'MAÑANA'),
(2, 'TARDE'),
(3, 'NOCHE');

-- --------------------------------------------------------

--
-- Table structure for table `turno_rte`
--

CREATE TABLE `turno_rte` (
  `Id_Turno` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `turno_rte`
--

INSERT INTO `turno_rte` (`Id_Turno`, `Descripcion`) VALUES
(1, 'MAÑANA'),
(2, 'TARDE'),
(3, 'NOCHE'),
(4, 'DOBLE TURNO');

-- --------------------------------------------------------

--
-- Table structure for table `tutores`
--

CREATE TABLE `tutores` (
  `Dni_Tutor` int(11) NOT NULL DEFAULT '0',
  `Apellidos_Nombres` varchar(400) DEFAULT NULL,
  `Edad` varchar(5) DEFAULT NULL,
  `Domicilio` varchar(40) DEFAULT NULL,
  `Tel_Contacto` varchar(20) DEFAULT NULL,
  `Fecha_Nac` date DEFAULT NULL,
  `Cuil` varchar(25) DEFAULT NULL,
  `Lugar_Nacimiento` varchar(100) DEFAULT NULL,
  `MasHijos` varchar(60) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(60) DEFAULT NULL,
  `Id_Estado_Civil` int(11) NOT NULL,
  `Id_Sexo` int(11) NOT NULL,
  `Id_Relacion` int(11) NOT NULL,
  `Id_Ocupacion` int(11) NOT NULL,
  `Id_Provincia` int(11) NOT NULL,
  `Id_Localidad` int(11) NOT NULL,
  `Id_Departamento` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tutores`
--

INSERT INTO `tutores` (`Dni_Tutor`, `Apellidos_Nombres`, `Edad`, `Domicilio`, `Tel_Contacto`, `Fecha_Nac`, `Cuil`, `Lugar_Nacimiento`, `MasHijos`, `Fecha_Actualizacion`, `Usuario`, `Id_Estado_Civil`, `Id_Sexo`, `Id_Relacion`, `Id_Ocupacion`, `Id_Provincia`, `Id_Localidad`, `Id_Departamento`) VALUES
(18852457, 'MARTINEZ MIRIAN BEATRIZ', NULL, '0', NULL, NULL, '27188524570', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18795782, 'FERNANDEZ OLGA MARIELA', NULL, 'SANTO DOMINGO', NULL, NULL, '27187957821', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18797912, 'MEDINA MERCEDES BEATRIZ', NULL, '0', NULL, NULL, '27187979124', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18783415, 'BARRIOS HILDA', NULL, 'PARQUE', NULL, NULL, '27187834150', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18788527, 'BOGADO RAMONA SELVA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18795578, 'VALENZUELA ROSA', NULL, '0', NULL, NULL, '27187955783', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18781457, 'DOMBROSKI ADREA', NULL, '0', NULL, NULL, '27187814575', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18748289, 'MARECOS ILDEFONSO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18774157, 'RIVEROS RODRIGUEZ MARIELA CARINA', NULL, '0', NULL, NULL, '27187741578', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18723466, 'ESPINOLA LEONCIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18717371, 'ROJAS FRANCISCA', NULL, '0', NULL, NULL, '27187173715', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18719251, 'BRITOS MARIA ROSA', NULL, '0', NULL, NULL, '27187192515', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18690206, 'VAZQUEZ BLANCA', NULL, '0', NULL, NULL, '27186902063', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18716333, 'LEIVA GLADYS', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18688833, 'MORINIGO ROSABELLA', NULL, '0', NULL, NULL, '27186888338', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18688829, 'CACERES LUCIA', NULL, '0', NULL, NULL, '23186888294', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18686808, 'ROJAS ALBINO', NULL, '0', NULL, NULL, '20186868081', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18686802, 'RAMOS CARLOS MIGUEL', NULL, 'SAN ANTONIO', NULL, NULL, '20186868022', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18685055, 'ALVAREZ BASILIO', NULL, '0', NULL, NULL, '20186850557', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18686774, 'VILLALBA JORGE ALBERTO', NULL, '0', NULL, NULL, '20186867743', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(18639017, 'MARTINEZ OBDULIA DE LA CRUZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18651255, 'VILLALBA SOFIA', NULL, '0', NULL, NULL, '27186512559', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18679088, 'VERA ROSA NYDIA', NULL, 'SAN ISIDRO', NULL, NULL, '27186790885', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18497936, 'GAUTO ROTELA BRIGIDA BEATRIZ', NULL, '0', NULL, NULL, '27184979360', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18438383, 'MARTINEZ LEONARDA', NULL, '0', NULL, NULL, '27184383832', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18479591, 'BAEZ SUSANA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18481196, 'DIAZ DORA CARMEN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351050, 'PERALTA ESTELA MARYS (GONZALES MARIO)', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351020, 'BENITEZ FELIPA', NULL, 'BOSSETTI', NULL, NULL, '27183510202', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351038, 'DUARTE DANIEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351018, 'GODOY ELVIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351014, 'GARCIA CLAUDINA', NULL, 'SANTO DOMINGO', NULL, NULL, '27183510148', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18351016, 'CAMACHO CARLOS ANTONIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18340655, 'RIVAS NORMA GLADYS', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18266673, 'MORA SUSANA ALICIA', NULL, '0', NULL, NULL, '23182666734', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18266623, 'PERALTA JUAN DE LA CRUZ', NULL, '0', NULL, NULL, '20182666239', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18266643, 'FRANCO EVA BEATRIZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18266619, 'AGUIAR PABLO', NULL, 'ITATI', NULL, NULL, '20182666190', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18127376, 'BENITEZ ANIBAL', NULL, '0', NULL, NULL, '20181273764', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18144280, 'SUAREZ CLAUDIA ESTELA', NULL, '0', NULL, NULL, '27181442803', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18234787, 'GONZALEZ MARIA ELENA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18104966, 'ANTUNES DE SOUZA JOSE ALBERTO', NULL, '0', NULL, NULL, '23181049669', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(18127280, 'LOPEZ JUAN CANSIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17952024, 'ALEGRE YILDA NINFA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17952123, 'BAREIRO JORGE', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17952747, 'LOPEZ CORNELIA', NULL, 'EVA PERON', NULL, NULL, '27179527478', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17563036, 'UMERES REINA', NULL, '0', NULL, NULL, '27175630363', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17563035, 'ZARATE IRENE TEODOCIA', NULL, '0', NULL, NULL, '27175630355', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17563034, 'CESPEDES OSCAR DAVID', NULL, '0', NULL, NULL, '20175630342', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17563028, 'BENITEZ RAMONA DELIA', NULL, '0', NULL, NULL, '27175630282', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17439602, 'PAIVA CONSTANCIA ESTELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17563011, 'CABRERA BEATRIZ', NULL, 'EVA PERON', NULL, NULL, '27175630118', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17563013, 'ESPINDOLA JOSE RAMON', NULL, '0', NULL, NULL, '23175630139', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(17378944, 'NUÑEZ MARIA ELENA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17367441, 'MARTINEZ AGUSTINA RAMONA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17317752, 'ALFONZO ANGELA', NULL, '0', NULL, NULL, '27173177521', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17345280, 'NUÑEZ PAULINA', NULL, '0', NULL, NULL, '27173452808', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17090862, 'ACOSTA DORA', NULL, '0', NULL, NULL, '27170908622', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17090883, 'ALDERETE FIDELINA', NULL, '0', NULL, NULL, '27170908835', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17093101, 'SUAREZ MARTHA ROSANA', NULL, '0', NULL, NULL, '27170931012', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17164585, 'CARIAGA MARIA NELIDA', NULL, '0', NULL, NULL, '27171645854', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17090838, 'CABAÑAS ANIBAL MARCELINO', NULL, '0', NULL, NULL, '20170908385', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(17090851, 'LOPEZ MIRIAM', NULL, '0', NULL, NULL, '27170908517', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(17090818, 'GONZALEZ MARCELA', NULL, '0', NULL, NULL, '27170908185', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17090824, 'VELAZQUEZ RAFAEL ANIBAL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16889307, 'GONZALEZ MARIA HILDA', NULL, '0', NULL, NULL, '27168893073', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16955967, 'MEIRA ANGELICA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17019399, 'GOMEZ JOSE ONOFRE', NULL, '0', NULL, NULL, '20170193998', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(17087474, 'DOS SANTOS MIRTA CONCEPCION', NULL, 'SAN JORGE', NULL, NULL, '27170874744', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16707898, 'HARTMANN LIDIA LUCIA', NULL, '0', NULL, NULL, '27167078988', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(16700768, 'BOGADO MARTA ELENA', NULL, '0', NULL, NULL, '27167007681', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(16671678, 'BENITEZ MARIA', NULL, '0', NULL, NULL, '27166716786', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671679, 'MARTINEZ JUAN DE LA CRUZ', NULL, 'ITATI', NULL, NULL, '23166716799', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671610, 'VILLALBA RAMON', NULL, '0', NULL, NULL, '20166716102', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671612, 'CABAÑAS LIDIA', NULL, '0', NULL, NULL, '27166716123', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671646, 'BARRETO MARIA BLANCA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671665, 'PARRA JULIA GREGORIA', NULL, '0', NULL, NULL, '27166716654', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16671667, 'QUIROGA ZUNILDA MARIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16504980, 'ESPINOLA ROSALINA ESTHER', NULL, '0', NULL, NULL, '27165049808', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(16671609, 'TORALES RAMONA', NULL, '0', NULL, NULL, '27166716093', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16451474, 'SANTACRUZ CATALINA', NULL, '0', NULL, NULL, '27164514744', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(16378739, 'CARDOZO NORMA GLADYS', NULL, '0', NULL, NULL, '27163787399', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16451452, 'BRITEZ VERONICA BEATRIZ', NULL, '0', NULL, NULL, '27164514523', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16451469, 'COLINA CLEMENTINA', NULL, '0', NULL, NULL, '27164514698', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16451453, 'MOREL JUAN VICTOR', NULL, '0', NULL, NULL, '20164514537', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(16194065, 'PARRA LEONARDA', NULL, '0', NULL, NULL, '27161940653', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16194088, 'GONZALEZ ANTONIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16222266, 'OLIVERA ANTONIO', NULL, '0', NULL, NULL, '20162222660', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16279810, 'GALARZA ELISA ISABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16317462, 'RIVOLTA LORENZA AZUCENA', NULL, '0', NULL, NULL, '27163174621', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14850226, 'FLECHA MARGARITA', NULL, '0', NULL, NULL, '27148502264', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(16009566, 'AQUINO ELENA', NULL, '0', NULL, NULL, '27160095666', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14669378, 'BOGADO JULIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14773350, 'SANCHEZ HERACLIO ALFONSO', NULL, '0', NULL, NULL, '20147733500', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(14634273, 'VILLALBA LIDIA ESTHER', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14634258, 'RAMIREZ MARTINA', NULL, '0', NULL, NULL, '27146342588', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14590035, 'GOMEZ AURORA', NULL, '0', NULL, NULL, '27145900358', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14493714, 'BAEZ ,INOCENCIO', NULL, '0', NULL, NULL, '20144937148', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14573508, 'GOMEZ CIRILA', NULL, '0', NULL, NULL, '23145735084', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14417853, 'OCAMPO CARMEN CRISTINA', NULL, '0', NULL, NULL, '27144178535', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14168500, 'ESPINOLA JORGE', NULL, '0', NULL, NULL, '20141685008', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14168284, 'ALFONZO MERCEDES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078695, 'REYES ISABELINA BEATRIZ', NULL, '0', NULL, NULL, '27140786956', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078687, 'BENITEZ FRANCISCA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078681, 'BIDEGAIN OLGA RAQUEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078654, 'LEZCANO MARIA ISABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078641, 'VILLALBA RAMON OSCAR', NULL, 'EMSA', NULL, NULL, '20140786412', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14078633, 'BAREIRO NELIDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(14007318, 'ERNST DOLI', NULL, '0', NULL, NULL, '27140073186', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(13943986, 'GIMENEZ CARLOS (ES GOMEZ MARGARITA)', NULL, '0', NULL, NULL, '23139439869', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13825951, 'LUQUE OMAR', NULL, '0', NULL, NULL, '20138259510', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(13690781, 'GULARTE LEOPOLDINA', NULL, '0', NULL, NULL, '27136907811', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13590395, 'BENITEZ FERMINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13590304, 'DA SILVA BENTO GUILLERMO LEANDRO', NULL, '0', NULL, NULL, '20135903044', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(13444992, 'KOLBO ELENA MARIA TERESA', NULL, '0', NULL, NULL, '27134449921', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13324713, 'QUINTANA ATILIO', NULL, '0', NULL, NULL, '24133247137', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13149487, 'ACUÑA MARIANO MORENO', NULL, '0', NULL, NULL, '20131494875', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13149481, 'COLINA VIDALINA', NULL, '0', NULL, NULL, '27131494810', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13149469, 'COLINA LUISA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13149459, 'NUÑEZ NORMA BEATRIZ', NULL, '0', NULL, NULL, '27131494594', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(13149453, 'ROMERO ROMAN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12962081, 'ZARZA EUGENIA', NULL, '0', NULL, NULL, '27129620817', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(12944021, 'DUDA JOSEFINA', NULL, '0', NULL, NULL, '27129440215', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12898268, 'GIMENEZ IRMA', NULL, '0', NULL, NULL, '27128982685', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12687633, 'VELAZQUEZ RUBEN', NULL, '0', NULL, NULL, '20126876336', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12803390, 'MEIRA GONZALEZ PABLO ANTONIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12847918, 'CABRERA SILVIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12667675, 'GONZALEZ FLORENCIA (SILVERO JULIO CESAR)', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12687627, 'PINTOS BRUNO', NULL, '0', NULL, NULL, '20126876271', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(12490169, 'VILLALBA HILARIA', NULL, '0', NULL, NULL, '27124901699', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(12116241, 'GOMEZ MARIA SILVANA', NULL, '0', NULL, NULL, '27121162410', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(12400540, 'RIOS EUSEBIA OLGA', NULL, '0', NULL, NULL, '27124005405', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11957273, 'SOTELO LUIS NICOLAS', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11963078, 'MEAURIO FAUSTINA', NULL, '98 VIVIENDAS', NULL, NULL, '27119630784', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11259396, 'RIOS ANGELINA', NULL, '0', NULL, NULL, '23112593969', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11308838, 'REY JOSE JULIO', NULL, 'CENTRAL', NULL, NULL, '23113088389', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(8540509, 'GONZALEZ JOSE', NULL, '0', NULL, NULL, '20085405099', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11523490, 'ESCROMEDA MARTA ELENA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11523433, 'DUARTE TEODORA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(11326429, 'GIMENEZ TEODORO', NULL, '0', NULL, NULL, '20113264293', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(10876841, 'LEDESMA REIMUNDA FELICIANA', NULL, '0', NULL, NULL, '27108768415', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(10842648, 'CARDOZO JULIO ARGENTINO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(10001752, 'VERA ELIGIO', NULL, '0', NULL, NULL, '20100017521', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(8102865, 'FERREIRA LORENZO SALVADOR', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(8102843, 'VARGAS MODESTO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(5277686, 'ESCOBAR ARMINDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(5839715, 'ESPINOLA JUAN ISIDRO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(5917679, 'BRITOS OLIMPIA EPIFANIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(5982677, 'DIAZ MARGARITA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(7540493, 'VILLALBA NICASIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(7550124, 'LANG JUAN CIRILO', NULL, '0', NULL, NULL, '20075501243', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(7588074, 'BENITEZ JOSE GERMAN', NULL, '0', NULL, NULL, '20075880740', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(7666031, 'ROMERO HUGO OSCAR', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(4538610, 'PERALTA ANTONIA', NULL, '0', NULL, NULL, '23045386100', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(798, 'ALCARAZ MIRIAM', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(799, 'COLINA JUAN RAMON', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(1645198, 'CABAÑAS EDITH NOEMI', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(764, 'DUDA MANUEL ALEJANDRO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(795, 'ANDINO JULIAN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(796, 'DUDA RITA GABRIELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(794, 'ANDINO NIDIA CRISTINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(793, 'ALVAREZ ARNALDO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(792, 'ALVAREZ GLADYS', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(791, 'BISPO MABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(788, 'ALVAREZ VALDEZ EMILIANA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(789, 'ALVAREZ EMILIANO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(790, 'VERA LUIS ALBERTO (BISPO MABEL)', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(787, 'MARTINEZ SERVIAN BLANCA BEATRIZ', NULL, '0', NULL, NULL, '27944732719', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(786, 'MARTINEZ SERVIAN MARIANA', NULL, '0', NULL, NULL, '27944732719', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(785, 'YEGROS RODOLFO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(782, 'OLIVERA ANDREA', NULL, 'SANTO DOMINGO', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(781, 'MARTINEZ JOSE DOMINGO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(779, 'JEJER MANUELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(777, 'CARDOZO NORMA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(774, 'ACOSTA ANA MARIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(776, 'CABAÑAS EDIT', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(775, 'PERALTA FRANCISCO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(773, 'BAREIRO CARMEN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(765, 'CORREA ROGELIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(772, 'VERA GLADYS', NULL, '0', NULL, NULL, '27232253059', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18857423, 'VERA BENITA', NULL, '0', NULL, NULL, '27188574233', NULL, NULL, NULL, NULL, 4, 3, 3, 6, 1, 36, 10),
(18860668, 'BENITEZ SALUSTIANO', NULL, '0', NULL, NULL, '20188606688', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(18866151, 'VILLALBA MIGUEL ANGEL', NULL, 'ALDEA', NULL, NULL, '20188661514', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18876273, 'ALMEIDA ROGELIO', NULL, '0', NULL, NULL, '20188762736', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(18878780, 'ROMAN CLOTILDE LUISA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18880061, 'AQUINO VERA OTILIA', NULL, '0', NULL, NULL, '27188800616', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(18883643, 'REYES HERMINIA', NULL, 'SAN ANTONIO', NULL, NULL, '27188836432', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(18903705, 'DAVALOS ALICIA', NULL, 'ITATI', NULL, NULL, '27189037053', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20241816, 'BOGADO MIRIAM CONCEPCION', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20242734, 'AQUINO OLGA ZULEMA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20242760, 'MORINIGO RAMONA BEATRIZ', NULL, '98 VIVIENDAS', NULL, NULL, '27202427605', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20242765, 'PERALTA SILVIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20242783, 'PERALTA GRACIELA GLADYS', NULL, '0', NULL, NULL, '27202427834', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20279646, 'PEÑA GODILA ESTHER', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20297567, 'BENITEZ MARIA DEL CARMEN', NULL, '0', NULL, NULL, '23202975674', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20297693, 'BENITEZ BENITEZ BLANCA CRISTINA', NULL, '0', NULL, NULL, '27202976935', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(20306420, 'LOPEZ MIGUEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20396909, 'VICENTI CARLOS EDGARDO', NULL, '0', NULL, NULL, '20203969091', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20475190, 'BOGADO VICTOR RAMON', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20477476, 'GRMALDI DELIA ROSA', NULL, '0', NULL, NULL, '27204774760', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20489055, 'MACHADO ZULEMA', NULL, '0', NULL, NULL, '27204890558', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20489451, 'PEDROZO MIRTA ISABEL', NULL, '0', NULL, NULL, '27204894510', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20526660, 'CAÑETE FLORES ELENA', NULL, 'PARQUE', NULL, NULL, '27205266602', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20644707, 'AQUINO GLADIS ESTER', NULL, 'ITATI', NULL, NULL, '27206447074', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20676271, 'MONTIEL FELIPE', NULL, '0', NULL, NULL, '20206762714', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(20678784, 'BITANCOURT CLARA INES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20688941, 'VALERIO MARIA', NULL, '0', NULL, NULL, '27206889417', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(20872899, 'SEGOVIA GLADYS', NULL, '0', NULL, NULL, '20208728998', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20941423, 'GONZALEZ PETRONA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(20982951, 'BENITEZ NORMA BEATRIZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20987006, 'DUARTE MARIA NIDIA', NULL, '0', NULL, NULL, '27209870067', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(20987057, 'GABRAL GLADIS E.', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(20987203, 'LOPEZ ROMUALDA MARIA', NULL, 'ITATI', NULL, NULL, '27209872035', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21300844, 'BARRETO RAMONA', NULL, 'B° BOSSETTI', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(21302560, 'DE CAMPOS MIRIAN ISABEL', NULL, '0', NULL, NULL, '27213025606', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21302722, 'DA SILVA BERNARDINA', NULL, 'PARQUE', NULL, NULL, '27213027226', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21305043, 'ALVAREZ DELIA ROSA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21306199, 'ALVAREZ EUGENIA MARTA', NULL, '0', NULL, NULL, '27213061998', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(21306748, 'INSFRAIN JULIA ELIZABETH', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21491031, 'GAUTO NORMA ESTER', NULL, '0', NULL, NULL, '23214910314', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(21520302, 'VARGAS GLADIS', NULL, 'PARQUE', NULL, NULL, '27215203021', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21598534, 'ESCURRA ROSSANA IRENE', NULL, '0', NULL, NULL, '27215985348', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21684935, 'fernandez carmen beatriz', NULL, '0', NULL, NULL, '27216849359', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(21750288, 'BENITEZ NORMA GRACIELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21814312, 'PEÑA JUAN ROLANDO', NULL, '0', NULL, NULL, '20218143122', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21814335, 'BAEZ BRUNO', NULL, '0', NULL, NULL, '20218143351', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(21852797, 'WIESNER OMAR', NULL, '0', NULL, NULL, '20218527974', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21888316, 'INCHAUSTI FABIO MARCELO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21914843, 'DIAZ ENRIQUE', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(21985903, 'JABOSKI MARIA INES', NULL, '0', NULL, NULL, '27219859037', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22085260, 'FERNANDEZ GRACIELA INES', NULL, 'Claudia estela suaez', NULL, NULL, '27220852607', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22154727, 'SILVERO ELVIO ADAN', NULL, '0', NULL, NULL, '20221547277', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22164629, 'NUÑEZ RAMON', NULL, '0', NULL, NULL, '20221646291', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22182765, 'AYALA CAYETANO', NULL, '0', NULL, NULL, '20221827652', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22266664, 'TORALES MIRTA', NULL, '0', NULL, NULL, '27222666649', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(22334342, 'BRITEZ BERNARDINA ISABEL', NULL, '0', NULL, NULL, '27223343428', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22334348, 'ALMADA ALBERTO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22334378, 'CAÑETE GLADYS DOLORES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22334390, 'GOMEZ MARGARITA', NULL, 'ITATI', NULL, NULL, '27223343908', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22334394, 'GONZALEZ NORMA ESTELA', NULL, '0', NULL, NULL, '27223343940', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22525101, 'SILVERO FERNANDO CESAR', NULL, 'SAN JOSE', NULL, NULL, '20225251011', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22525133, 'KOVALSKI SANDRO OMAR ARIEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22525143, 'CESPEDES RAMONA BEATRIZ', NULL, '0', NULL, NULL, '27225251431', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(22525163, 'VARGAS CRISTINA MABEL', NULL, '0', NULL, NULL, '27225251636', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22525177, 'VAZQUEZ FRANCISCO', NULL, '0', NULL, NULL, '20225251771', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(22773246, 'AQUINO GRACIELA', NULL, '0', NULL, NULL, '2722773246', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22833044, 'LOPEZ PAULA ANDREA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22835827, 'RAMIREZ MARIA LUISA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22894030, 'CABRAL ANGELA', NULL, '0', NULL, NULL, '27228940300', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(22927543, 'BENITEZ ANGELINA BEATRIZ', NULL, '0', NULL, NULL, '27229275432', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23030529, 'VILLALBA LEONARDA', NULL, '0', NULL, NULL, '27230305299', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23161251, 'CANOFRE TERESA', NULL, '0', NULL, NULL, '27231612519', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(23161277, 'RIVAROLA PAULA', NULL, 'CENTRAL', NULL, NULL, '27231612772', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23169327, 'CACERES PAIVA ANDREA', NULL, '98 VIVIENDAS', NULL, NULL, '27231693276', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23218902, 'MARQUEZ DELIA NOEMI', NULL, 'SAN JORGE', NULL, NULL, '27232189024', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23225322, 'AQUINO MARIA DEL ROSARIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23225326, 'ROMERO LILIANA MABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23225381, 'VILLALBA IRIS MABEL', NULL, 'PARQUE', NULL, NULL, '27232253814', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23225393, 'MIÑARRO MARIA BONIFACIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23354103, 'GIMENEZ GRACIELA ESTER', NULL, '0', NULL, NULL, '27233541031', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23367961, 'GONSALVEZ MARTINA ISABEL', NULL, 'PARQUE', NULL, NULL, '27233679610', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23399095, 'PEREIRA MARIA MARGARITA', NULL, '0', NULL, NULL, '27233990952', NULL, NULL, NULL, NULL, 4, 3, 3, 6, 1, 36, 10),
(23399096, 'PEREIRA RAMON ARSENIO', NULL, '0', NULL, NULL, '20233990966', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23405641, 'CAIRE NESTOR JAVIER', NULL, '0', NULL, NULL, '20234056418', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23444342, 'CANDIA BLANCA LIDIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452701, 'VERGARA FELIX SANDRO', NULL, 'UNIDO', NULL, NULL, '20234527011', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452726, 'VALDEZ RAMONA ESTER', NULL, '0', NULL, NULL, '27234527261', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(23452730, 'OZUNA JORGE SANDRO', NULL, '0', NULL, NULL, '20234527305', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452749, 'AGUILAR RAUL OSCAR', NULL, '0', NULL, NULL, '20234527496', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452804, 'ORTIZ CLAUDIA ELIZABETH', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452837, 'GOMEZ SIMEON', NULL, '0', NULL, NULL, '20234528379', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(23452840, 'MERELES IGNACIA BEATRIZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23452879, 'DAVALOS MONICA DOROTEA', NULL, '0', NULL, NULL, '27234528799', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(23581814, 'VELAZQUEZ ANGEL LUIS', NULL, '0', NULL, NULL, '20235818141', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(23743114, 'DUARTE MARIA EDITH', NULL, '0', NULL, NULL, '27237431141', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23901838, 'BRITEZ REINA MARINA', NULL, '0', NULL, NULL, '27239018381', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(23901850, 'LARROZA GRACIELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(23901881, 'CABRAL RAMONA ESTER', NULL, '0', NULL, NULL, '27239018810', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24079936, 'BARRETO RAFAELA', NULL, '0', NULL, NULL, '27240799362', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24134886, 'REREZ ROSA MARIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24150248, 'BENITEZ JORGELINA ELIZABETH', NULL, '10 VIVIENDAS', NULL, NULL, '27241502487', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24174819, 'BENITEZ DELIA', NULL, '0', NULL, NULL, '27241748192', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24174846, 'CAÑETE CARLOS ANTONIO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24174890, 'DEJESUS NICOLAS JAVIER', NULL, '0', NULL, NULL, '20241748902', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(24236992, 'DA ROSA LILIANA MARIEL', NULL, '0', NULL, NULL, '27242369926', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24373601, 'BAEZ MIRTA GRACIELA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24373604, 'SEGOVIA PABLO ANDRES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24373615, 'MEIRA ZULEMA MABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24373643, 'BENITEZ ISABEL PATRICIA', NULL, '0', NULL, NULL, '27243736434', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24373663, 'BENITEZ EURALIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24373744, 'ADORNO ZULMA', NULL, '0', NULL, NULL, '27243737449', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24506756, 'MARTINEZ MIRTA ELIZABETH', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24532254, 'LEZCANO SUSANA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24532265, 'LEIVA OSCAR', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24545326, 'CABALLERO SALUSTIANA', NULL, '0', NULL, NULL, '23245453264', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24545356, 'VILLALBA MIRTA GRACIELA', NULL, '0', NULL, NULL, '27245453561', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24555332, 'HERMOSILLA APOLINARIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24613765, 'PETER MARIA HAYDEE', NULL, '0', NULL, NULL, '27246137655', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24865466, 'CARMONA REINA ISABEL', NULL, 'PARQUE', NULL, NULL, '27248654665', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24867055, 'ERNST ALEJANDRO MARTIN', NULL, '0', NULL, NULL, '27248670555', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(24903013, 'RODRIGUEZ CEFERINO MARTIN', NULL, '0', NULL, NULL, '23249030139', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(24974378, 'ZARATE MONICA GUILLERMINA', NULL, '0', NULL, NULL, '0', NULL, NULL, '2017-04-24', 'jjcervera', 4, 3, 2, 6, 1, 36, 10),
(24974408, 'COSTA ALVES GRACIELA CRISTINA', NULL, '0', NULL, NULL, '27249744080', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(24989074, 'MACHADO JUAN', NULL, '0', NULL, NULL, '20249890740', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25017244, 'ZARACHO BLANCA ESTELA', NULL, '0', NULL, NULL, '27250172449', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25017256, 'SHUEMER CLAUDIO JUAN', NULL, 'UNIDO', NULL, NULL, '20250172568', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25017299, 'FRANCO ANA MARIA', NULL, '0', NULL, NULL, '27250172996', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25066436, 'GONZALEZ JUAN ASUNCION', NULL, '0', NULL, NULL, '20250664363', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(25066696, 'GULARTE LUCIA MABEL', NULL, 'SAN CAYETANO', NULL, NULL, '27250666964', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25271220, 'DEDIEU CHYNTIA VALERIA', NULL, '0', NULL, NULL, '27252712203', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(25313064, 'CHAVEZ ROSALI', NULL, 'ITATI', NULL, NULL, '23253130644', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25315466, 'MARECO RAMON', NULL, '0', NULL, NULL, '20253154668', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25450469, 'VOGEL JOSE ENRIQUE', NULL, '0', NULL, NULL, '20254504697', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(25467710, 'RIBALTOWSKI MARIA ALEJAN', NULL, '0', NULL, NULL, '27254677103', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25467791, 'ESTEVAN CARLOS ALBERTO', NULL, '0', NULL, NULL, '20254677915', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(25493219, 'OVIEDO LEONIDA DOMINGA', NULL, 'PARQUE', NULL, NULL, '27254932197', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25606931, 'ORTIGOZA LIDIA', NULL, '0', NULL, NULL, '27256069313', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25606975, 'IRALA RAMONA ELIZABETH', NULL, '0', NULL, NULL, '27256069755', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(25643592, 'VERA TERESITA', NULL, 'CENTRAL', NULL, NULL, '27256435921', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25651008, 'DOS SANTOS CARMEN', NULL, 'BOSSETTI', NULL, NULL, '27256510087', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25657785, 'GOMEZ MIRTHA SUSANA', NULL, '0', NULL, NULL, '27256577858', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25775076, 'ROMERO CECILIA NANCI', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25845727, 'CARDOZO LIDIA MARIAN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(25845761, 'SAMUDIO NOELIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26043694, 'VIERA DE LINARES RAMONA INES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26046660, 'SIMONELLI ERICO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26102039, 'VIER OFELIA', NULL, '0', NULL, NULL, '23261020394', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26207910, 'RODRIGUEZ OSVALDO ARIEL', NULL, '0', NULL, NULL, '20262079105', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26207911, 'ESCOBAR LISANDRA NOEMI', NULL, '0', NULL, NULL, '27262079118', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26207956, 'LOPEZ SUSANA RAQUEL', NULL, '0', NULL, NULL, '27262079568', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26207965, 'GODOY MARIA CAROLINA', NULL, '0', NULL, NULL, '27262079657', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(26207983, 'DEDIEU SYRIA MARLENE', NULL, '98 VIVIENDAS', NULL, NULL, '27262079835', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26397418, 'PINTOS LIDIA ISABEL', NULL, '0', NULL, NULL, '27263974188', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26406459, 'SAMUDIO FIDELINA', NULL, '0', NULL, NULL, '27264064592', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26425617, 'DA SILVA CATALINA', NULL, 'SANTO DOMINGO', NULL, NULL, '27264256173', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26438512, 'ESTECHE ROSANA MARLENE', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26438546, 'BAEZ LEOLINDA BRUNILDA', NULL, 'PARQUE', NULL, NULL, '27264385461', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26438563, 'OCAMPO SANDRA MARLENE', NULL, '0', NULL, NULL, '27264385631', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26477279, 'DE ALMEIDA LILIANA', NULL, '0', NULL, NULL, '27264772791', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26616301, 'RAMIREZ BLANCA DELICIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26682291, 'PITTKE ALEJANDRA ELIZABETH', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26746777, 'MOLINA PAULA ALEJANDRA', NULL, '0', NULL, NULL, '27267467779', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(26751309, 'DEL VALLE SUSANA GRISELDA', NULL, '0', NULL, NULL, '27267513096', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(26751373, 'ADORNO MARIA EUGENIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26751381, 'BAEZ HUGO ORLANDO', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26957863, 'BENITEZ MARIA ALEJANDRA', NULL, '0', NULL, NULL, '27269578632', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(26957899, 'CARDOZO ALBA GRACIELA', NULL, '0', NULL, NULL, '27269578993', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(26994577, 'STUMPF DELIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27031413, 'VALLEJO MARIA LAURA', NULL, 'PARQUE', NULL, NULL, '27270314134', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27129701, 'RAMIREZ JOSEFINA', NULL, '0', NULL, NULL, '27271297012', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27129758, 'GIMENEZ CLAUDIA FABIANA', NULL, '0', NULL, NULL, '27271297586', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27205363, 'SEQUEIRA ALBERTO JAVIER', NULL, '0', NULL, NULL, '20272053635', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27212723, 'OTT MARIA IGNACIA', NULL, '0', NULL, NULL, '27272127234', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27223684, 'OTT MARIA ESTER', NULL, 'SAN JOSE', NULL, NULL, '23272236844', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27431618, 'ALMEIDA MIRTA ESTELA', NULL, 'PARQUE', NULL, NULL, '27274316182', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27431730, 'INSAULRRALDE NIDIA BEATRIZ', NULL, '0', NULL, NULL, '27274317308', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27454746, 'GONZALEZ ARGENTINO ABRAHAM', NULL, '0', NULL, NULL, '20274547465', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27458774, 'JIMENEZ MARIA LAURA', NULL, '0', NULL, NULL, '27274587747', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27492456, 'ALVAREZ JULIA MABEL', NULL, '0', NULL, NULL, '27274924565', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27513918, 'RAMIREZ NELIDA', NULL, 'PARQUE', NULL, NULL, '27275139187', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27529794, 'QUIROZ NATALIA BEATRIZ', NULL, '0', NULL, NULL, '27275297947', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27588105, 'CABRAL RAMONA EUGENIA', NULL, '0', NULL, NULL, '27275881053', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27588129, 'GUERRERO PATRICIA MABEL', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27588199, 'PERALTA REGINA MABEL', NULL, 'SAN CAYETANO', NULL, NULL, '27275881991', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27757986, 'DUARTE IRIS SOLEDAD', NULL, '0', NULL, NULL, '27277579869', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27930306, 'ALCARAZ ZULMA GRACIELA', NULL, '0', NULL, NULL, '27279303062', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27930341, 'TORALES MARISA ANDREA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27930371, 'DALUZ CLAUDIA INES', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27930380, 'BENITEZ MARGARITA', NULL, 'SAN ANTONIO', NULL, NULL, '27279303801', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27930385, 'PEÑA ZORAIDA', NULL, '0', NULL, NULL, '27279303852', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27930400, 'RUIZ DIAZ MIRTA ELIZABETH', NULL, '0', NULL, NULL, '23279304004', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(27983589, 'MORINIGO NOELIA', NULL, '0', NULL, NULL, '27279835897', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(27999532, 'RIOS CLAUDIA DE LOS SANTOS', NULL, 'CENTRAL', NULL, NULL, '27279995320', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28266607, 'FLORES ROSA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28399736, 'BOBADILLA ELVA ESTELA', NULL, 'ITATI', NULL, NULL, '27283997362', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28484445, 'CESPEDES LAURA LORENA', NULL, '0', NULL, NULL, '27284844454', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(28484452, 'PEREIRA PATRICIA', NULL, '0', NULL, NULL, '27284844527', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28484489, 'GIMENEZ MARIA ISABEL', NULL, '0', NULL, NULL, '27284844896', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(28553118, 'BAEZ ANDRESA RAQUEL', NULL, 'PARQUE', NULL, NULL, '27285531182', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28553211, 'SILVA ROSAURA', NULL, '0', NULL, NULL, '27285532111', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28553252, 'RECALDE CELIA', NULL, '0', NULL, NULL, '27285532529', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(28553449, 'MEINHART MARCELINA', NULL, '0', NULL, NULL, '27285534491', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(28718109, 'MERLENDER SUSANA LEONIDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28905427, 'BENITEZ CRISTIAN ADRIAN', NULL, 'PARQUE', NULL, NULL, '20289054279', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(28905451, 'OCAMPO MARIA CRISTINA', NULL, '0', NULL, NULL, '27289054516', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(29007384, 'ACUÑA ROMINA vanesa', NULL, '0', NULL, NULL, '27290073842', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(29050952, 'WIEDEMANN GUILLERMO DAVID', NULL, '0', NULL, NULL, '20290509522', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29212822, 'VERA ROSA CRISTINA', NULL, 'ITATI', NULL, NULL, '27292128229', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29231570, 'MIÑARRO MARISA ESTER', NULL, '0', NULL, NULL, '27292315703', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29295917, 'ALVAREZ MIKI MIRIAM', NULL, '0', NULL, NULL, '27292959171', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29295972, 'ORTEGA MARIA SOLEDAD', NULL, '0', NULL, NULL, '27292959724', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29295985, 'CANOFRE RAMONA', NULL, 'ITATI', NULL, NULL, '27292959856', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29534996, 'CUBA MAXIMINA', NULL, 'UNIDO', NULL, NULL, '23295349964', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29576052, 'BECK NOELIA BEATRIZ', NULL, '0', NULL, NULL, '23295760524', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29576094, 'VALIENTE NATALIA MARIA', NULL, '0', NULL, NULL, '27295760945', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29590193, 'DA ROSA ANDREA SOLEDAD', NULL, '0', NULL, NULL, '23295901934', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(29624803, 'PAIVA ROSALIA BEATRIZ', NULL, '0', NULL, NULL, '20296248037', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29813922, 'GONCALVES ANGELICA CAROLINA', NULL, '0', NULL, NULL, '27298139222', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(29819871, 'BRITEZ EMMA RAQUEL', NULL, 'SANTO DOMINGO', NULL, NULL, '27298198717', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(29953330, 'DIAZ TERESA MARLENE', NULL, '0', NULL, NULL, '27299533307', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(29995442, 'LEDEZMA VERONICA', NULL, '0', NULL, NULL, '27299954426', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30093573, 'VANZELLA LUISA CRISTINA', NULL, '0', NULL, NULL, '27300935732', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30131226, 'DELGADO MARIA CECILIA', NULL, '0', NULL, NULL, '27301312267', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30131247, 'LEIVA CARLOS', NULL, '0', NULL, NULL, '20301312475', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(30199742, 'ZALAZAR MARIA VALERIANA', NULL, '0', NULL, NULL, '27301997421', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(30250017, 'BAEZ MIRTA LUJAN', NULL, 'ITATI', NULL, NULL, '27302500172', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30283740, 'PAIVA JOSEFINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30283746, 'ACOSTA LAURA DANIELA', NULL, 'PARQUE', NULL, NULL, '27302837460', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30283792, 'KALINOSKI MIRTA BEATRIZ', NULL, '0', NULL, NULL, '27302837924', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(30360125, 'BARBOZA DE MOURA HECTOR RENE', NULL, '0', NULL, NULL, '20303601253', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379316, 'BENITEZ LORENZA', NULL, '0', NULL, NULL, '27303793165', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379330, 'VERA NIDIA GRACIELA', NULL, '0', NULL, NULL, '27303793300', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379332, 'GARCIA AURELIANA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379339, 'RAMIREZ ELBIO', NULL, 'CENTRAL', NULL, NULL, '23303793399', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379371, 'ESPINOLA ELVIRA ELSA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379373, 'ESPINOLA MARTA GRACIELA', NULL, '0', NULL, NULL, '27303793734', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30379405, 'FERREIRA ABULDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30520999, 'MENDIETA LIDIA HORTENCIA', NULL, '0', NULL, NULL, '27305209991', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30521304, 'RODRIGUEZ DOS SANTOS MARGARITA', NULL, 'SAN CARLOS', NULL, NULL, '27305213042', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30521874, 'LOPEZ KARINA', NULL, '0', NULL, NULL, '27305218745', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(30522001, 'BENITEZ VIRGINIA', NULL, 'SAN CAYETANO', NULL, NULL, '27305220014', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30574135, 'BRITEZ MARISEL', NULL, 'PARQUE', NULL, NULL, '23305741353', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30574246, 'MIRANDA MIRIAM ELIZABETH', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30662724, 'SAUCEDO MONICA GABRIELA', NULL, '0', NULL, NULL, '23306627244', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(30706722, 'SILVA MARINA BLANCA', NULL, '0', NULL, NULL, '27307067221', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(31123342, 'VILLALBA SELVA ISABEL', NULL, 'UNIDOS', NULL, NULL, '23311233424', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(31123417, 'AMARILLA NORMA BEATRIZ', NULL, '0', NULL, NULL, '27311234175', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(31150241, 'CASCO JUAN CESAR', NULL, '0', NULL, NULL, '20311502418', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(31379955, 'RIBEIRO ROSALINA', NULL, '0', NULL, NULL, '27313799552', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(31701721, 'GONSALVES SUSANA BEATRIZ', NULL, '0', NULL, NULL, '27317017214', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(31761047, 'AYALA KARINAS RAQUEL', NULL, '0', NULL, NULL, '27317610470', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10);
INSERT INTO `tutores` (`Dni_Tutor`, `Apellidos_Nombres`, `Edad`, `Domicilio`, `Tel_Contacto`, `Fecha_Nac`, `Cuil`, `Lugar_Nacimiento`, `MasHijos`, `Fecha_Actualizacion`, `Usuario`, `Id_Estado_Civil`, `Id_Sexo`, `Id_Relacion`, `Id_Ocupacion`, `Id_Provincia`, `Id_Localidad`, `Id_Departamento`) VALUES
(31761153, 'PINTOS CINTIA VIVIANA', NULL, 'SAN ANTONIO', NULL, NULL, '27317611531', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(32042025, 'ROLON EMILIANA AGUEDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(32726606, 'MARTINEZ ESTER', NULL, '0', NULL, NULL, '27327266063', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(32736608, 'AGUILERA NORMA BEATRIZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(32736616, 'AVELLANEDA RAFAEL ANGEL', NULL, '0', NULL, NULL, '20327366166', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(32736628, 'RIVERO CARMEN', NULL, '0', NULL, NULL, '27327366284', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(32736874, 'VAZQUEZ SELVA', NULL, '0', NULL, NULL, '27327368740', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(33075314, 'CASTILLO IRENE ISABEL', NULL, '0', NULL, NULL, '24330753141', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(33160715, 'GARCIA ESTELA ETELVINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(33487314, 'VILLANUEVA ZULMA FAUSTINA', NULL, '0', NULL, NULL, '27334873140', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(33487315, 'VILLANUEVA PETRONA BALBINA', NULL, '0', NULL, NULL, '27334873159', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(33864936, 'AVELLANEDA JAVIER', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(33864937, 'ARANDA LIDIA', NULL, 'PARQUE', NULL, NULL, '27338649377', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(33866064, 'GONZALEZ SUSANA BEATRIZ', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(35013708, 'lopez natalia', NULL, '0', NULL, NULL, '23350137084', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(36061934, 'DE OLIVEIRA YESSICA ROSANA', NULL, '0', NULL, NULL, '27360619341', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(36457771, 'MAIDANA PERLA SOLEDAD', NULL, '0', NULL, NULL, '27364577716', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(40411036, 'GODOY ADELIA MARIA', NULL, '0', NULL, NULL, '27404110360', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(91259360, 'GONZALEZ ELADIO VICTOR', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92014058, 'CABRAL JUANA BAUTISTA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92050560, 'ESPINOLA SERVANDA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(92098092, 'VILLAGRA PATIÑO YSABEL', NULL, '0', NULL, NULL, '27920980924', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92221847, 'FERNANDEZ EVER NICANOR', NULL, '0', NULL, NULL, '20922218472', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92226566, 'BARRETO LEOCADIO', NULL, '0', NULL, NULL, '20922265667', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(92244911, 'GIMENEZ DIELMA FRANCISCA', NULL, '0', NULL, NULL, '27922449118', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(92289113, 'CHAPARRO ELVIO', NULL, '0', NULL, NULL, '20922891134', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92348565, 'SCHINDLER CEOLI', NULL, '0', NULL, NULL, '27923485657', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(92534497, 'TORRES FRANCO MARIA ADELAIDA', NULL, '0', NULL, NULL, '23925344974', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(92686861, 'COSTA DE SOUZA ROMILDA', NULL, '0', NULL, NULL, '2792686861', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(92914621, 'VENIALGO CABRAL ISIDORO', NULL, '0', NULL, NULL, '20929146213', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93007327, 'ZARATE SACHELARIDIS LORENZA', NULL, '0', NULL, NULL, '27930073275', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(93097476, 'CARDOZO LOPEZ JUAN JOSE', NULL, 'BARRIO SANTO DOMINGO', NULL, NULL, '20930974766', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(93121680, 'BOGADO ROBUSTIANO', NULL, '0', NULL, NULL, '20931216806', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93129160, 'GUNTHER GLADIS MARISA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93414178, 'GONZALEZ VERGARA AGUSTIN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93427279, 'ENRIQUEZ LORENA CAROLINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93670935, 'ENRIQUEZ JOSE VALDEZA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93931449, 'TROCHA ALMADA VALERIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93933962, 'RODRIGUEZ BARRIENTOS BLANCA ESTHER', NULL, 'EMPLEADO', NULL, NULL, '27939339626', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(93974245, 'ESCURRA INSFRAN ANDRESA', NULL, '0', NULL, NULL, '27939742455', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94078680, 'LOPEZ CANDIA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94088323, 'ESPINOLA DUARTE VIRGINIA', NULL, '0', NULL, NULL, '27940883232', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(94120199, 'ALFONZO DUARTE JULIAN', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94314664, 'FLORES GAONA MARCELINA', NULL, '0', NULL, NULL, '27943146646', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94348038, 'ACUÑA VAZQUEZ FLORENTINA', NULL, '0', NULL, NULL, '27943480384', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94360522, 'GONZALEZ ELIODORA', NULL, '0', NULL, NULL, '27943605225', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94514352, 'RAMOS ROMERO FRANCISCA', NULL, '0', NULL, NULL, '27945143520', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(94544025, 'CACERES RAMOS MARIA ELISANA', NULL, 'SANTO DOMINGO', NULL, NULL, '27945440258', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94544048, 'MALDONADO FELICIANA', NULL, '0', NULL, NULL, '27945440487', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94557014, 'SEGOVIA MACIEL URBANO', NULL, '0', NULL, NULL, '20945570149', NULL, NULL, NULL, NULL, 4, 3, 2, 6, 1, 36, 10),
(94558291, 'GODOY ALVAREZ ALEJANDRA', NULL, '0', NULL, NULL, '27945582915', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(94558965, 'SANTACRUZ EULOGIA', NULL, '0', NULL, NULL, '27945589650', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94593627, 'OJEDA MIRIAN ROSSANA', NULL, 'SAN CARLOS', NULL, NULL, '23945936274', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94664561, 'SANDOBAL MIRTA ELIZABET', NULL, 'BOSSETTI', NULL, NULL, '27946645619', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94672861, 'AYALA ORTIGOZA CLAUDELINA', NULL, '0', NULL, NULL, '27946728611', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(94704582, 'PORTILLO BOMBLAN ANA RAMONA', NULL, 'ITATI', NULL, NULL, '27947045828', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94730386, 'ALVAREZ MARTA', NULL, '0', NULL, NULL, '23947303864', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(94752166, 'CABRAL BENITEZ MARCIA ESTELA', NULL, '0', NULL, NULL, '27947521662', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94864068, 'RAJOY MODESTA', NULL, '0', NULL, NULL, '27948640681', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(94966409, 'JIMENEZ DE CABALLERO SONIA ELIZABETH', NULL, 'SANTO DOMINGO', NULL, NULL, '27949664096', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(95120650, 'GUTIERRES VAZQUEZ SUSANA', NULL, '0', NULL, NULL, '23951206504', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(95188467, 'PIRIS GARAY LEONARDA', NULL, '0', NULL, NULL, '27951884672', NULL, NULL, NULL, NULL, 4, 3, 1, 6, 1, 36, 10),
(95193378, 'VERA LOPEZ MIGUEL ANGEL', NULL, 'SAN ISIDRO', NULL, NULL, '20951933784', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(95268856, 'VILLALBA ROSALINA', NULL, 'SAN ISIDRO', NULL, NULL, '27952688567', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(98789463, 'BENITEZ GUILLERMINA', NULL, '0', NULL, NULL, '0', NULL, NULL, NULL, NULL, 4, 3, 4, 6, 1, 36, 10),
(32435252, 'OLIVERA CARMEN ANDREA', NULL, NULL, NULL, '1986-04-12', '27324352525', NULL, 'No', '2017-04-26', 'jjcervera', 4, 2, 2, 7, 1, 36, 10);

-- --------------------------------------------------------

--
-- Table structure for table `ubicacion_equipo`
--

CREATE TABLE `ubicacion_equipo` (
  `Id_Ubicacion` int(11) NOT NULL,
  `Descripcion` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ubicacion_equipo`
--

INSERT INTO `ubicacion_equipo` (`Id_Ubicacion`, `Descripcion`) VALUES
(1, 'DENTRO DE LA ESCUELA'),
(2, 'FUERA DE LA ESCUELA');

-- --------------------------------------------------------

--
-- Table structure for table `userlevelpermissions`
--

CREATE TABLE `userlevelpermissions` (
  `userlevelid` int(11) NOT NULL,
  `tablename` varchar(255) NOT NULL,
  `permission` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlevelpermissions`
--

INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 0),
(-2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 109),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 105),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 104),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 109),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 109),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 111),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 104),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 111),
(0, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0),
(1, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0),
(2, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0),
(3, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0),
(4, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 111),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}autoridades_escolares', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_persona', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cursos', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}denuncia_robo_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_atencion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}devolucion_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}division', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}equipos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}establecimientos_educativos_pase', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_legajo_persona', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_actual_solucion_problema', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_persona', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_civil', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_denuncia', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_pase', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_prestamo_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}liberacion_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}localidades', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_adeudadas', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}materias_anuales', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modalidad_establecimiento', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_prestamo_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_reasignacion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paises', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}nivel_educativo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_persona', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ocupacion_tutor', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pase_establecimiento', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}prestamo_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}problema', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}provincias', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}reasignacion_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}sexo_personas', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}situacion_estado', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_prioridad_atencion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_relacion_alumno_tutor', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_retiro_atencion_st', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_solucion_problema', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tutores', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ubicacion_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_devuelto', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}personas', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}dato_establecimiento', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}cargo_autoridad', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_server', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}marca_server', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}modelo_server', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}piso_tecnologico', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}referente_tecnico', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}servidor_escolar', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}so_server', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}turno_rte', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipos_piso', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}ano_entrega', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_falla', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_equipos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}atencion_para_st', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}audittrail', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}observacion_tutor', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}departamento', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_devolucion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_devolucion_prestamo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_paquete', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}paquetes_provision', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_extraccion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}motivo_pedido_paquetes', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}usuarios', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevelpermissions', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}userlevels', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_espera_prestamo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}lista_espera_prestamo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atencion', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titulares-equipos-tutores', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}titularidad-equipos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_titulares_cursos', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_documentacion_personas', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}alumnos_porcurso', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_st', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}historial_atenciones', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosestablecimiento', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosdirectivos', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datos_extras_escuela', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosservidor', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}datosextrasescuela', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}chat', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}conversaciones', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}todas_atenciones', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_rte', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}detalle_asistencia', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodeequipos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}seguimientodepersonas', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Atenciones', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de las personas', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}Estadistica de Equipos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}MarcarRetiroSt', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}asistencia_alumnos', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}zonas', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_escuela', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_jornada', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_establecimiento', 0);
INSERT INTO `userlevelpermissions` (`userlevelid`, `tablename`, `permission`) VALUES
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}novedades', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_equipo', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}estado_equipo_porcurso', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}tipo_paquete', 0),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}pedido_paquetes', 104),
(5, '{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}etiquetasequipos', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userlevels`
--

CREATE TABLE `userlevels` (
  `userlevelid` int(11) NOT NULL,
  `userlevelname` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userlevels`
--

INSERT INTO `userlevels` (`userlevelid`, `userlevelname`) VALUES
(-2, 'Anonymous'),
(-1, 'Administrator'),
(0, 'Default'),
(1, 'Anonymous'),
(2, 'Alumnos'),
(3, 'Preceptores'),
(4, 'Rte'),
(5, 'Docentes');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `Nombre` varchar(100) NOT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Nivel_Usuario` int(11) DEFAULT NULL,
  `NombreTitular` varchar(200) DEFAULT NULL,
  `Dni` int(20) DEFAULT NULL,
  `Curso` int(11) DEFAULT NULL,
  `Turno` int(11) DEFAULT NULL,
  `Division` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`Nombre`, `Password`, `Nivel_Usuario`, `NombreTitular`, `Dni`, `Curso`, `Turno`, `Division`) VALUES
('jjcervera', 'N1ngun4Cl4v3#', 4, 'CERVERA JUAN JOSE', 27289607, 10, 2, NULL),
('Gabriel', 'BoLp22@admin', 4, NULL, 33147421, 10, 1, NULL),
('mpereira', 'BOP22@pereira', 3, NULL, 23399095, 10, 2, 13),
('superadmin', 'Bolp22admin.', -1, NULL, 10000000, 1, 1, 13);

-- --------------------------------------------------------

--
-- Table structure for table `zonas`
--

CREATE TABLE `zonas` (
  `Id_Zona` int(11) NOT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `Id_Departamento` varchar(200) NOT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Usuario` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zonas`
--

INSERT INTO `zonas` (`Id_Zona`, `Descripcion`, `Id_Departamento`, `Fecha_Actualizacion`, `Usuario`) VALUES
(1, 'Zona A (Posadas)', '5', '2017-01-30', 'Administrator'),
(2, 'Zona B (Posadas)', '5', '2017-01-30', 'Administrator'),
(3, 'Zona C (Garupa(17)-Candelaria(9))', '4,5', '2017-01-30', 'Administrator'),
(4, 'Zona D (Eldorado)', '7', '2017-01-30', 'Administrator'),
(5, 'Zona E (Montecarlo)', '13', '2017-01-30', 'Administrator'),
(6, 'Zona F (25 de Mayo)', '1', '2017-01-30', 'Administrator'),
(7, 'Zona G (Gral. Manuel Belgrano)', '8', '2017-01-30', 'Administrator'),
(8, 'Zona H (San Ignacio)', '15', '2017-01-30', 'Administrator'),
(9, 'Zona I (Iguazu)', '10', '2017-01-30', 'Administrator'),
(10, 'Zona J (Lib. Gral. San Martin)', '12', '2017-01-30', 'Administrator'),
(11, 'Zona K (Obera)', '14', '2017-01-30', 'Administrator'),
(12, 'Zona L (Guaraní-25 de Mayo(1)-Cainguas(6)', '1,3,9', '2017-01-30', 'Administrator'),
(13, 'Zona M (Apostoles-Concepción(3)-San Javier(6))', '2,6,16', '2017-01-30', 'Administrator'),
(14, 'Zona O (San Pedro-Guaraní(1))', '9,17', '2017-01-30', 'Administrator'),
(15, 'Zona P (Cainguas-Obera(1))', '3,14', '2017-01-30', 'Administrator'),
(16, 'Zona Q (L. N. Alem-Apostoles(1))', '2,11', '2017-01-30', 'Administrator'),
(18, 'PENDIENTE', '', '2017-02-14', 'Administrator');

-- --------------------------------------------------------

--
-- Structure for view `alumnos_porcurso`
--
DROP TABLE IF EXISTS `alumnos_porcurso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `alumnos_porcurso`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Estado` AS `Id_Estado`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from `personas` ;

-- --------------------------------------------------------

--
-- Structure for view `buscador_alumnos`
--
DROP TABLE IF EXISTS `buscador_alumnos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`sistema`@`localhost` SQL SECURITY DEFINER VIEW `buscador_alumnos`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`historial_atencion`.`Id_Atencion` AS `Id_Atencion`,`historial_atencion`.`NroSerie` AS `NroSerie`,`historial_atencion`.`Detalle` AS `Detalle`,`historial_atencion`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`historial_atencion`.`Usuario` AS `Usuario` from (`personas` join `historial_atencion` on((`personas`.`NroSerie` = `historial_atencion`.`NroSerie`))) ;

-- --------------------------------------------------------

--
-- Structure for view `datosdirectivos`
--
DROP TABLE IF EXISTS `datosdirectivos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosdirectivos`  AS  select `autoridades_escolares`.`Apellido_Nombre` AS `Apellido_Nombre`,`autoridades_escolares`.`Cuil` AS `Cuil`,`autoridades_escolares`.`Telefono` AS `Telefono`,`autoridades_escolares`.`Celular` AS `Celular`,`autoridades_escolares`.`Maill` AS `Maill`,`autoridades_escolares`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`dato_establecimiento`.`Cue` AS `Cue`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona`,`autoridades_escolares`.`Id_Cargo` AS `Id_Cargo`,`autoridades_escolares`.`Id_Turno` AS `Id_Turno` from (`autoridades_escolares` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `autoridades_escolares`.`Cue`))) ;

-- --------------------------------------------------------

--
-- Structure for view `datosestablecimiento`
--
DROP TABLE IF EXISTS `datosestablecimiento`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosestablecimiento`  AS  select `dato_establecimiento`.`Cue` AS `CUE`,`dato_establecimiento`.`Nombre_Establecimiento` AS `Establecimiento`,`dato_establecimiento`.`Domicilio` AS `Domicilio`,`dato_establecimiento`.`Telefono_Escuela` AS `Telefono`,`dato_establecimiento`.`Mail_Escuela` AS `Mail`,`dato_establecimiento`.`Matricula_Actual` AS `Nro Matricula`,`dato_establecimiento`.`Cantidad_Aulas` AS `Cantidad Aulas`,`dato_establecimiento`.`Comparte_Edificio` AS `Comparte Edificio`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Departamento` AS `Id_Departamento`,`dato_establecimiento`.`Id_Localidad` AS `Id_Localidad`,`dato_establecimiento`.`Cantidad_Turnos` AS `Cantidad_Turnos`,`dato_establecimiento`.`Geolocalizacion` AS `Geolocalizacion`,`dato_establecimiento`.`Id_Tipo_Esc` AS `Id_Tipo_Esc`,`dato_establecimiento`.`Universo` AS `Universo`,`dato_establecimiento`.`Tiene_Programa` AS `Tiene_Programa`,`dato_establecimiento`.`Sector` AS `Sector`,`dato_establecimiento`.`Cantidad_Netbook_Conig` AS `Cantidad_Netbook_Conig`,`dato_establecimiento`.`Nro_Cuise` AS `Nro_Cuise`,`dato_establecimiento`.`Id_Nivel` AS `Id_Nivel`,`dato_establecimiento`.`Id_Jornada` AS `Id_Jornada`,`dato_establecimiento`.`Tipo_Zona` AS `Tipo_Zona`,`dato_establecimiento`.`Id_Estado_Esc` AS `Id_Estado_Esc`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona`,`dato_establecimiento`.`Cantidad_Netbook_Actuales` AS `Cantidad_Netbook_Actuales`,`dato_establecimiento`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`dato_establecimiento`.`Usuario` AS `Usuario` from `dato_establecimiento` ;

-- --------------------------------------------------------

--
-- Structure for view `datosextrasescuela`
--
DROP TABLE IF EXISTS `datosextrasescuela`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosextrasescuela`  AS  select `datos_extras_escuela`.`Cue` AS `Cue`,`datos_extras_escuela`.`Usuario_Conig` AS `Usuario_Conig`,`datos_extras_escuela`.`Password_Conig` AS `Password_Conig`,`datos_extras_escuela`.`Tiene_Internet` AS `Tiene_Internet`,`datos_extras_escuela`.`Servicio_Internet` AS `Servicio_Internet`,`datos_extras_escuela`.`Estado_Internet` AS `Estado_Internet`,`datos_extras_escuela`.`Quien_Paga` AS `Quien_Paga`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona` from (`datos_extras_escuela` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `datos_extras_escuela`.`Cue`))) ;

-- --------------------------------------------------------

--
-- Structure for view `datosservidor`
--
DROP TABLE IF EXISTS `datosservidor`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `datosservidor`  AS  select `servidor_escolar`.`Cue` AS `Cue`,`servidor_escolar`.`Nro_Serie` AS `Nro_Serie`,`servidor_escolar`.`SN` AS `SN`,`servidor_escolar`.`Cant_Net_Asoc` AS `Cant_Net_Asoc`,`servidor_escolar`.`User_Server` AS `User_Server`,`servidor_escolar`.`Pass_Server` AS `Pass_Server`,`servidor_escolar`.`User_TdServer` AS `User_TdServer`,`servidor_escolar`.`Pass_TdServer` AS `Pass_TdServer`,`servidor_escolar`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`servidor_escolar`.`Id_Marca` AS `Id_Marca`,`servidor_escolar`.`Id_SO` AS `Id_SO`,`servidor_escolar`.`Id_Estado` AS `Id_Estado`,`servidor_escolar`.`Id_Modelo` AS `Id_Modelo`,`servidor_escolar`.`Usuario` AS `Usuario`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona` from (`servidor_escolar` join `dato_establecimiento` on((`dato_establecimiento`.`Cue` = `servidor_escolar`.`Cue`))) ;

-- --------------------------------------------------------

--
-- Structure for view `estado_documentacion_personas`
--
DROP TABLE IF EXISTS `estado_documentacion_personas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_documentacion_personas`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`estado_actual_legajo_persona`.`Matricula` AS `Matricula`,`estado_actual_legajo_persona`.`Certificado_Pase` AS `Certificado_Pase`,`estado_actual_legajo_persona`.`Tiene_DNI` AS `Tiene_DNI`,`estado_actual_legajo_persona`.`Certificado_Medico` AS `Certificado_Medico`,`estado_actual_legajo_persona`.`Posee_Autorizacion` AS `Posee_Autorizacion`,`estado_actual_legajo_persona`.`Cooperadora` AS `Cooperadora`,`personas`.`Dni` AS `Dni`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Estado` AS `Id_Estado`,`personas`.`Id_Cargo` AS `Id_Cargo` from (`personas` join `estado_actual_legajo_persona` on((`personas`.`Dni` = `estado_actual_legajo_persona`.`Dni`))) ;

-- --------------------------------------------------------

--
-- Structure for view `estado_equipos_porcurso`
--
DROP TABLE IF EXISTS `estado_equipos_porcurso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_equipos_porcurso`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Id_Estado` AS `Id_Estado`,`equipos`.`NroSerie` AS `NroSerie`,`equipos`.`Id_Sit_Estado` AS `Id_Sit_Estado`,`equipos`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from (`personas` join `equipos` on((`personas`.`NroSerie` = `equipos`.`NroSerie`))) ;

-- --------------------------------------------------------

--
-- Structure for view `estado_equipo_porcurso`
--
DROP TABLE IF EXISTS `estado_equipo_porcurso`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_equipo_porcurso`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Id_Estado` AS `Id_Estado`,`equipos`.`NroSerie` AS `NroSerie`,`equipos`.`Id_Sit_Estado` AS `Id_Sit_Estado`,`equipos`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from (`personas` join `equipos` on((`personas`.`NroSerie` = `equipos`.`NroSerie`))) ;

-- --------------------------------------------------------

--
-- Structure for view `estado_titulares_cursos`
--
DROP TABLE IF EXISTS `estado_titulares_cursos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `estado_titulares_cursos`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`personas`.`Repitente` AS `Repitente`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Id_Estado` AS `Id_Estado`,`personas`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from `personas` ;

-- --------------------------------------------------------

--
-- Structure for view `etiquetasequipos`
--
DROP TABLE IF EXISTS `etiquetasequipos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `etiquetasequipos`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Id_Estado` AS `Id_Estado`,`personas`.`Dni` AS `Dni`,`personas`.`NroSerie` AS `NroSerie` from `personas` ;

-- --------------------------------------------------------

--
-- Structure for view `historial_atenciones`
--
DROP TABLE IF EXISTS `historial_atenciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `historial_atenciones`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`historial_atencion`.`Id_Atencion` AS `Id_Atencion`,`historial_atencion`.`Detalle` AS `Detalle`,`historial_atencion`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`historial_atencion`.`Usuario` AS `Usuario` from (`personas` join `historial_atencion` on((`personas`.`NroSerie` = `historial_atencion`.`NroSerie`))) ;

-- --------------------------------------------------------

--
-- Structure for view `pedido_paquetes`
--
DROP TABLE IF EXISTS `pedido_paquetes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedido_paquetes`  AS  select `dato_establecimiento`.`Cue` AS `Cue`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona`,`paquetes_provision`.`Id_Hardware` AS `Id_Hardware`,`paquetes_provision`.`SN` AS `SN`,`paquetes_provision`.`Marca_Arranque` AS `Marca_Arranque`,`paquetes_provision`.`Id_Tipo_Extraccion` AS `Id_Tipo_Extraccion`,`paquetes_provision`.`Id_Estado_Paquete` AS `Id_Estado_Paquete`,`paquetes_provision`.`Id_Motivo` AS `Id_Motivo`,`paquetes_provision`.`Serie_Server` AS `Serie_Server`,`paquetes_provision`.`Email_Solicitante` AS `Email_Solicitante`,`paquetes_provision`.`Id_Tipo_Paquete` AS `Id_Tipo_Paquete`,`paquetes_provision`.`Serie_Netbook` AS `Serie_Netbook`,`paquetes_provision`.`Apellido_Nombre_Solicitante` AS `Apellido_Nombre_Solicitante`,`paquetes_provision`.`Dni` AS `Dni`,`paquetes_provision`.`Fecha_Actualizacion` AS `Fecha_Actualizacion`,`paquetes_provision`.`Usuario` AS `Usuario` from (`paquetes_provision` join `dato_establecimiento`) where (`paquetes_provision`.`Id_Estado_Paquete` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `pedido_st`
--
DROP TABLE IF EXISTS `pedido_st`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pedido_st`  AS  select `dato_establecimiento`.`Cue` AS `CUE`,`dato_establecimiento`.`Sigla` AS `Sigla`,`dato_establecimiento`.`Id_Zona` AS `Id_Zona`,`departamento`.`Nombre` AS `DEPARTAMENTO`,`localidades`.`Nombre` AS `LOCALIDAD`,`atencion_para_st`.`NroSerie` AS `SERIE NETBOOK`,`atencion_para_st`.`Nro_Tiket` AS `N° TIKET`,`problema`.`Descripcion` AS `PROBLEMA`,`atencion_para_st`.`Id_Tipo_Retiro` AS `Id_Tipo_Retiro` from (((`dato_establecimiento` join `departamento` on((`dato_establecimiento`.`Id_Departamento` = `departamento`.`Id_Departamento`))) join `localidades` on((`dato_establecimiento`.`Id_Localidad` = `localidades`.`Id_Localidad`))) join (((`atencion_para_st` join `detalle_atencion` on(((`atencion_para_st`.`Id_Atencion` = `detalle_atencion`.`Id_Atencion`) and (`atencion_para_st`.`NroSerie` = `detalle_atencion`.`NroSerie`)))) join `problema` on((`detalle_atencion`.`Id_Problema` = `problema`.`Id_Problema`))) join `equipos` on((`atencion_para_st`.`NroSerie` = `equipos`.`NroSerie`)))) where (`atencion_para_st`.`Id_Tipo_Retiro` = 1) ;

-- --------------------------------------------------------

--
-- Structure for view `seguimientodeequipos`
--
DROP TABLE IF EXISTS `seguimientodeequipos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `seguimientodeequipos`  AS  select `equipos`.`NroSerie` AS `NroSerie`,`observacion_equipo`.`Detalle` AS `Detalle`,`observacion_equipo`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from (`equipos` join `observacion_equipo` on((`equipos`.`NroSerie` = `observacion_equipo`.`NroSerie`))) ;

-- --------------------------------------------------------

--
-- Structure for view `seguimientodepersonas`
--
DROP TABLE IF EXISTS `seguimientodepersonas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `seguimientodepersonas`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`observacion_persona`.`Detalle` AS `Detalle`,`observacion_persona`.`Fecha_Actualizacion` AS `Fecha_Actualizacion` from (`personas` join `observacion_persona` on((`personas`.`Dni` = `observacion_persona`.`Dni`))) ;

-- --------------------------------------------------------

--
-- Structure for view `titulares-equipos-tutores`
--
DROP TABLE IF EXISTS `titulares-equipos-tutores`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titulares-equipos-tutores`  AS  select `personas`.`Apellidos_Nombres` AS `Apelldio y Nombre Titular`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`personas`.`NroSerie` AS `Equipo Asignado`,`tutores`.`Apellidos_Nombres` AS `Apellido y Nombre Tutor`,`tutores`.`Dni_Tutor` AS `Dni Tutor`,`tutores`.`Cuil` AS `Cuil Tutor` from (`personas` join `tutores` on((`personas`.`Dni_Tutor` = `tutores`.`Dni_Tutor`))) ;

-- --------------------------------------------------------

--
-- Structure for view `titularidad-equipos`
--
DROP TABLE IF EXISTS `titularidad-equipos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `titularidad-equipos`  AS  select `personas`.`Apellidos_Nombres` AS `Apellidos_Nombres`,`personas`.`Dni` AS `Dni`,`personas`.`Cuil` AS `Cuil`,`personas`.`NroSerie` AS `NroSerie`,`personas`.`Id_Cargo` AS `Id_Cargo`,`personas`.`Id_Estado` AS `Id_Estado`,`personas`.`Id_Curso` AS `Id_Curso`,`personas`.`Id_Division` AS `Id_Division`,`personas`.`Id_Turno` AS `Id_Turno` from `personas` ;

-- --------------------------------------------------------

--
-- Structure for view `todas_atenciones`
--
DROP TABLE IF EXISTS `todas_atenciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `todas_atenciones`  AS  select `atencion_equipos`.`Id_Atencion` AS `N° Atencion`,`atencion_equipos`.`NroSerie` AS `Serie Equipo`,`personas`.`Apellidos_Nombres` AS `Nombre Titular`,`personas`.`Dni` AS `Dni`,`atencion_equipos`.`Fecha_Entrada` AS `Fecha Entrada`,`atencion_equipos`.`Usuario` AS `Usuario que cargo`,`detalle_atencion`.`Descripcion_Problema` AS `Descripcion Problema`,`detalle_atencion`.`Fecha_Actualizacion` AS `Ultima Actualizacion`,`detalle_atencion`.`Id_Tipo_Falla` AS `Id_Tipo_Falla`,`detalle_atencion`.`Id_Problema` AS `Id_Problema`,`detalle_atencion`.`Id_Tipo_Sol_Problem` AS `Id_Tipo_Sol_Problem`,`detalle_atencion`.`Id_Estado_Atenc` AS `Id_Estado_Atenc` from ((`atencion_equipos` join `detalle_atencion` on(((`atencion_equipos`.`Id_Atencion` = `detalle_atencion`.`Id_Atencion`) and (`atencion_equipos`.`NroSerie` = `detalle_atencion`.`NroSerie`)))) join `personas` on((`atencion_equipos`.`Dni` = `personas`.`Dni`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ano_entrega`
--
ALTER TABLE `ano_entrega`
  ADD PRIMARY KEY (`Id_Ano`);

--
-- Indexes for table `asistencia_alumnos`
--
ALTER TABLE `asistencia_alumnos`
  ADD PRIMARY KEY (`Dni`);

--
-- Indexes for table `asistencia_rte`
--
ALTER TABLE `asistencia_rte`
  ADD PRIMARY KEY (`Id_Asistencia`),
  ADD KEY `RefReferente_Tecnico139` (`DniRte`);

--
-- Indexes for table `atencion_equipos`
--
ALTER TABLE `atencion_equipos`
  ADD PRIMARY KEY (`Id_Atencion`,`NroSerie`),
  ADD KEY `RefTipo_Prioridad_Atencion54` (`Id_Prioridad`),
  ADD KEY `RefEquipos55` (`NroSerie`),
  ADD KEY `RefPersonas109` (`Dni`);

--
-- Indexes for table `atencion_para_st`
--
ALTER TABLE `atencion_para_st`
  ADD PRIMARY KEY (`Id_Atencion`,`NroSerie`),
  ADD KEY `RefTipo_Retiro_Atencion_ST65` (`Id_Tipo_Retiro`);

--
-- Indexes for table `audittrail`
--
ALTER TABLE `audittrail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `autoridades_escolares`
--
ALTER TABLE `autoridades_escolares`
  ADD PRIMARY KEY (`Id_Autoridad`),
  ADD KEY `RefCargo_Autoridad84` (`Id_Cargo`),
  ADD KEY `RefTurno85` (`Id_Turno`),
  ADD KEY `RefDato_Establecimiento105` (`Cue`);

--
-- Indexes for table `cargo_autoridad`
--
ALTER TABLE `cargo_autoridad`
  ADD PRIMARY KEY (`Id_Cargo`);

--
-- Indexes for table `cargo_persona`
--
ALTER TABLE `cargo_persona`
  ADD PRIMARY KEY (`Id_Cargo`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`Orden`),
  ADD KEY `RefConversaciones138` (`Nro_Conversacion`);

--
-- Indexes for table `conversaciones`
--
ALTER TABLE `conversaciones`
  ADD PRIMARY KEY (`Nro_Conversacion`);

--
-- Indexes for table `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`Id_Curso`);

--
-- Indexes for table `datos_extras_escuela`
--
ALTER TABLE `datos_extras_escuela`
  ADD PRIMARY KEY (`Cue`),
  ADD KEY `RefDato_Establecimiento137` (`Cue`);

--
-- Indexes for table `dato_establecimiento`
--
ALTER TABLE `dato_establecimiento`
  ADD PRIMARY KEY (`Cue`),
  ADD KEY `RefDepartamento117` (`Id_Departamento`),
  ADD KEY `RefLocalidades118` (`Id_Localidad`),
  ADD KEY `RefTipo_Escuela141` (`Id_Tipo_Esc`),
  ADD KEY `RefNivel_Establecimiento168` (`Id_Nivel`),
  ADD KEY `RefTipo_Jornada169` (`Id_Jornada`),
  ADD KEY `RefEstado_Establecimiento170` (`Id_Estado_Esc`);

--
-- Indexes for table `denuncia_robo_equipo`
--
ALTER TABLE `denuncia_robo_equipo`
  ADD PRIMARY KEY (`IdDenuncia`),
  ADD KEY `RefEstado_Deuncia25` (`Id_Estado_Den`),
  ADD KEY `RefPersonas26` (`Dni`),
  ADD KEY `RefTutores27` (`Dni_Tutor`),
  ADD KEY `RefEquipos28` (`NroSerie`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`Id_Departamento`),
  ADD KEY `RefProvincias112` (`Id_Provincia`);

--
-- Indexes for table `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  ADD PRIMARY KEY (`Dia`),
  ADD KEY `RefAsistencia_Rte140` (`Id_Asistencia`);

--
-- Indexes for table `detalle_atencion`
--
ALTER TABLE `detalle_atencion`
  ADD PRIMARY KEY (`Id_Detalle_Atencion`,`Id_Atencion`,`NroSerie`),
  ADD KEY `RefTipo_Falla59` (`Id_Tipo_Falla`),
  ADD KEY `RefProblema60` (`Id_Problema`),
  ADD KEY `RefTipo_Solucion_Problema61` (`Id_Tipo_Sol_Problem`),
  ADD KEY `RefEstado_Actual_Solucion_Problema62` (`Id_Estado_Atenc`),
  ADD KEY `RefAtencion_Equipos63` (`Id_Atencion`,`NroSerie`);

--
-- Indexes for table `devolucion_equipo`
--
ALTER TABLE `devolucion_equipo`
  ADD PRIMARY KEY (`NroSerie`),
  ADD KEY `RefEstado_Equipo_Devuleto29` (`Id_Estado_Devol`),
  ADD KEY `RefAutoridades_Escolares43` (`Id_Autoridad`),
  ADD KEY `RefPersonas120` (`Dni`),
  ADD KEY `RefTutores121` (`Dni_Tutor`),
  ADD KEY `RefMotivo_Devolucion122` (`Id_Motivo`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`Id_Division`);

--
-- Indexes for table `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`NroSerie`),
  ADD KEY `RefUbicacion_Equipo74` (`Id_Ubicacion`),
  ADD KEY `RefModelo75` (`Id_Modelo`),
  ADD KEY `RefEstado_Equipo76` (`Id_Estado`),
  ADD KEY `RefSituacion_Estado77` (`Id_Sit_Estado`),
  ADD KEY `RefMarca78` (`Id_Marca`),
  ADD KEY `RefAno_Entrega79` (`Id_Ano`);

--
-- Indexes for table `establecimientos_educativos_pase`
--
ALTER TABLE `establecimientos_educativos_pase`
  ADD PRIMARY KEY (`Cue_Establecimiento`),
  ADD KEY `RefDepartamento115` (`Id_Departamento`),
  ADD KEY `RefLocalidades44` (`Id_Localidad`),
  ADD KEY `RefProvincias45` (`Id_Provincia`);

--
-- Indexes for table `estado_actual_legajo_persona`
--
ALTER TABLE `estado_actual_legajo_persona`
  ADD PRIMARY KEY (`Dni`);

--
-- Indexes for table `estado_actual_solucion_problema`
--
ALTER TABLE `estado_actual_solucion_problema`
  ADD PRIMARY KEY (`Id_Estado_Atenc`);

--
-- Indexes for table `estado_civil`
--
ALTER TABLE `estado_civil`
  ADD PRIMARY KEY (`Id_Estado_Civil`);

--
-- Indexes for table `estado_denuncia`
--
ALTER TABLE `estado_denuncia`
  ADD PRIMARY KEY (`Id_Estado_Den`);

--
-- Indexes for table `estado_devolucion_prestamo`
--
ALTER TABLE `estado_devolucion_prestamo`
  ADD PRIMARY KEY (`Id_Estado_Devol`);

--
-- Indexes for table `estado_equipo`
--
ALTER TABLE `estado_equipo`
  ADD PRIMARY KEY (`Id_Estado`);

--
-- Indexes for table `estado_equipos_piso`
--
ALTER TABLE `estado_equipos_piso`
  ADD PRIMARY KEY (`Id_Estado_Equipo_piso`);

--
-- Indexes for table `estado_equipo_devuelto`
--
ALTER TABLE `estado_equipo_devuelto`
  ADD PRIMARY KEY (`Id_Estado_Devol`);

--
-- Indexes for table `estado_espera_prestamo`
--
ALTER TABLE `estado_espera_prestamo`
  ADD PRIMARY KEY (`Id_Estado_Espera`);

--
-- Indexes for table `estado_establecimiento`
--
ALTER TABLE `estado_establecimiento`
  ADD PRIMARY KEY (`Id_Estado_Esc`);

--
-- Indexes for table `estado_paquete`
--
ALTER TABLE `estado_paquete`
  ADD PRIMARY KEY (`Id_Estado_Paquete`);

--
-- Indexes for table `estado_pase`
--
ALTER TABLE `estado_pase`
  ADD PRIMARY KEY (`Id_Estado_Pase`);

--
-- Indexes for table `estado_persona`
--
ALTER TABLE `estado_persona`
  ADD PRIMARY KEY (`Id_Estado`);

--
-- Indexes for table `estado_prestamo_equipo`
--
ALTER TABLE `estado_prestamo_equipo`
  ADD PRIMARY KEY (`Id_Estado_Prestamo`);

--
-- Indexes for table `estado_server`
--
ALTER TABLE `estado_server`
  ADD PRIMARY KEY (`Id_Estado`);

--
-- Indexes for table `historial_atencion`
--
ALTER TABLE `historial_atencion`
  ADD PRIMARY KEY (`Id_Historial`),
  ADD KEY `RefAtencion_Equipos136` (`Id_Atencion`,`NroSerie`);

--
-- Indexes for table `liberacion_equipo`
--
ALTER TABLE `liberacion_equipo`
  ADD PRIMARY KEY (`Dni`),
  ADD KEY `RefModalidad_Establecimiento39` (`Id_Modalidad`),
  ADD KEY `RefNivel_educativo40` (`Id_Nivel`),
  ADD KEY `RefAutoridades_Escolares41` (`Id_Autoridad`),
  ADD KEY `RefTutores83` (`Dni_Tutor`),
  ADD KEY `RefEquipos87` (`NroSerie`);

--
-- Indexes for table `lista_espera_prestamo`
--
ALTER TABLE `lista_espera_prestamo`
  ADD PRIMARY KEY (`Dni`),
  ADD KEY `RefMotivo_Prestamo_Equipo131` (`Id_Motivo_Prestamo`),
  ADD KEY `RefCursos132` (`Id_Curso`),
  ADD KEY `RefDivision133` (`Id_Division`),
  ADD KEY `RefEstado_Espera_Prestamo134` (`Id_Estado_Espera`);

--
-- Indexes for table `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`Id_Localidad`),
  ADD KEY `RefDepartamento113` (`Id_Departamento`);

--
-- Indexes for table `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`Id_Marca`);

--
-- Indexes for table `marca_server`
--
ALTER TABLE `marca_server`
  ADD PRIMARY KEY (`Id_Marca`);

--
-- Indexes for table `materias_adeudadas`
--
ALTER TABLE `materias_adeudadas`
  ADD PRIMARY KEY (`Id_Mat_Adeuda`),
  ADD KEY `RefPersonas11` (`Dni`),
  ADD KEY `RefMaterias_Anuales14` (`Id_Materia`);

--
-- Indexes for table `materias_anuales`
--
ALTER TABLE `materias_anuales`
  ADD PRIMARY KEY (`Id_Materia`),
  ADD KEY `RefCursos12` (`Id_Curso`);

--
-- Indexes for table `modalidad_establecimiento`
--
ALTER TABLE `modalidad_establecimiento`
  ADD PRIMARY KEY (`Id_Modalidad`);

--
-- Indexes for table `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`Id_Modelo`),
  ADD KEY `RefMarca111` (`Id_Marca`);

--
-- Indexes for table `modelo_server`
--
ALTER TABLE `modelo_server`
  ADD PRIMARY KEY (`Id_Modelo`);

--
-- Indexes for table `motivo_devolucion`
--
ALTER TABLE `motivo_devolucion`
  ADD PRIMARY KEY (`Id_Motivo`);

--
-- Indexes for table `motivo_pedido_paquetes`
--
ALTER TABLE `motivo_pedido_paquetes`
  ADD PRIMARY KEY (`Id_Motivo`);

--
-- Indexes for table `motivo_prestamo_equipo`
--
ALTER TABLE `motivo_prestamo_equipo`
  ADD PRIMARY KEY (`Id_Motivo_Prestamo`);

--
-- Indexes for table `motivo_reasignacion`
--
ALTER TABLE `motivo_reasignacion`
  ADD PRIMARY KEY (`Id_Motivo_Reasig`);

--
-- Indexes for table `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  ADD PRIMARY KEY (`Id_Nivel`);

--
-- Indexes for table `novedades`
--
ALTER TABLE `novedades`
  ADD PRIMARY KEY (`Id_Novedad`);

--
-- Indexes for table `observacion_equipo`
--
ALTER TABLE `observacion_equipo`
  ADD PRIMARY KEY (`Id_Observacion`),
  ADD KEY `RefEquipos32` (`NroSerie`);

--
-- Indexes for table `observacion_persona`
--
ALTER TABLE `observacion_persona`
  ADD PRIMARY KEY (`Id_Observacion`),
  ADD KEY `RefPersonas16` (`Dni`);

--
-- Indexes for table `observacion_tutor`
--
ALTER TABLE `observacion_tutor`
  ADD PRIMARY KEY (`Id_Observacion`),
  ADD KEY `RefTutores33` (`Dni_Tutor`);

--
-- Indexes for table `ocupacion_tutor`
--
ALTER TABLE `ocupacion_tutor`
  ADD PRIMARY KEY (`Id_Ocupacion`);

--
-- Indexes for table `paises`
--
ALTER TABLE `paises`
  ADD PRIMARY KEY (`Id_Pais`);

--
-- Indexes for table `paquetes_provision`
--
ALTER TABLE `paquetes_provision`
  ADD PRIMARY KEY (`NroPedido`),
  ADD KEY `RefTipo_Extraccion126` (`Id_Tipo_Extraccion`),
  ADD KEY `RefEstado_Paquete127` (`Id_Estado_Paquete`),
  ADD KEY `RefMotivo_Pedido_Paquetes128` (`Id_Motivo`),
  ADD KEY `RefEquipos129` (`Serie_Server`);

--
-- Indexes for table `pase_establecimiento`
--
ALTER TABLE `pase_establecimiento`
  ADD PRIMARY KEY (`Id_Pase`),
  ADD KEY `RefEstado_Pase48` (`Id_Estado_Pase`);

--
-- Indexes for table `personas`
--
ALTER TABLE `personas`
  ADD PRIMARY KEY (`Dni`),
  ADD KEY `RefSexo_Personas2` (`Id_Sexo`),
  ADD KEY `RefProvincias5` (`Id_Provincia`),
  ADD KEY `RefLocalidades6` (`Id_Localidad`),
  ADD KEY `RefEstado_Persona7` (`Id_Estado`),
  ADD KEY `RefCursos8` (`Id_Curso`),
  ADD KEY `RefDivision9` (`Id_Division`),
  ADD KEY `RefTurno10` (`Id_Turno`),
  ADD KEY `RefEstado_Civil38` (`Id_Estado_Civil`),
  ADD KEY `RefTutores80` (`Dni_Tutor`),
  ADD KEY `RefEquipos81` (`NroSerie`),
  ADD KEY `RefCargo_Persona92` (`Id_Cargo`),
  ADD KEY `RefDepartamento116` (`Id_Departamento`);

--
-- Indexes for table `piso_tecnologico`
--
ALTER TABLE `piso_tecnologico`
  ADD PRIMARY KEY (`Cue`),
  ADD KEY `RefDato_Establecimiento104` (`Cue`);

--
-- Indexes for table `prestamo_equipo`
--
ALTER TABLE `prestamo_equipo`
  ADD PRIMARY KEY (`Id_Prestamo`),
  ADD KEY `RefEstado_Prestamo_Equipo49` (`Id_Estado_Prestamo`),
  ADD KEY `RefMotivo_Prestamo_Equipo50` (`Id_Motivo_Prestamo`),
  ADD KEY `RefEquipos108` (`NroSerie`),
  ADD KEY `RefEstado_Devolucion_Prestamo123` (`Id_Estado_Devol`),
  ADD KEY `RefLista_Espera_Prestamo135` (`Dni`);

--
-- Indexes for table `problema`
--
ALTER TABLE `problema`
  ADD PRIMARY KEY (`Id_Problema`);

--
-- Indexes for table `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`Id_Provincia`),
  ADD KEY `RefPaises114` (`Id_Pais`);

--
-- Indexes for table `reasignacion_equipo`
--
ALTER TABLE `reasignacion_equipo`
  ADD PRIMARY KEY (`Id_Reasignacion`),
  ADD KEY `RefMotivo_Reasignacion51` (`Id_Motivo_Reasig`),
  ADD KEY `RefEquipos53` (`NroSerie`),
  ADD KEY `RefPersonas102` (`Dni`);

--
-- Indexes for table `referente_tecnico`
--
ALTER TABLE `referente_tecnico`
  ADD PRIMARY KEY (`DniRte`),
  ADD KEY `RefTurno_Rte88` (`Id_Turno`),
  ADD KEY `RefDato_Establecimiento103` (`Cue`);

--
-- Indexes for table `servidor_escolar`
--
ALTER TABLE `servidor_escolar`
  ADD PRIMARY KEY (`Cue`),
  ADD KEY `RefMarca_Server94` (`Id_Marca`),
  ADD KEY `RefSO_Server95` (`Id_SO`),
  ADD KEY `RefEstado_Server96` (`Id_Estado`),
  ADD KEY `RefModelo_Server97` (`Id_Modelo`),
  ADD KEY `RefDato_Establecimiento106` (`Cue`);

--
-- Indexes for table `sexo_personas`
--
ALTER TABLE `sexo_personas`
  ADD PRIMARY KEY (`Id_Sexo`);

--
-- Indexes for table `situacion_estado`
--
ALTER TABLE `situacion_estado`
  ADD PRIMARY KEY (`Id_Sit_Estado`);

--
-- Indexes for table `so_server`
--
ALTER TABLE `so_server`
  ADD PRIMARY KEY (`Id_SO`);

--
-- Indexes for table `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  ADD PRIMARY KEY (`Id_Tipo_Equipo`);

--
-- Indexes for table `tipo_escuela`
--
ALTER TABLE `tipo_escuela`
  ADD PRIMARY KEY (`Id_Tipo_Esc`);

--
-- Indexes for table `tipo_extraccion`
--
ALTER TABLE `tipo_extraccion`
  ADD PRIMARY KEY (`Id_Tipo_Extraccion`);

--
-- Indexes for table `tipo_falla`
--
ALTER TABLE `tipo_falla`
  ADD PRIMARY KEY (`Id_Tipo_Falla`);

--
-- Indexes for table `tipo_jornada`
--
ALTER TABLE `tipo_jornada`
  ADD PRIMARY KEY (`Id_Jornada`);

--
-- Indexes for table `tipo_paquete`
--
ALTER TABLE `tipo_paquete`
  ADD PRIMARY KEY (`Id_Tipo_Paquete`);

--
-- Indexes for table `tipo_prioridad_atencion`
--
ALTER TABLE `tipo_prioridad_atencion`
  ADD PRIMARY KEY (`Id_Prioridad`);

--
-- Indexes for table `tipo_relacion_alumno_tutor`
--
ALTER TABLE `tipo_relacion_alumno_tutor`
  ADD PRIMARY KEY (`Id_Relacion`);

--
-- Indexes for table `tipo_retiro_atencion_st`
--
ALTER TABLE `tipo_retiro_atencion_st`
  ADD PRIMARY KEY (`Id_Tipo_Retiro`);

--
-- Indexes for table `tipo_solucion_problema`
--
ALTER TABLE `tipo_solucion_problema`
  ADD PRIMARY KEY (`Id_Tipo_Sol_Problem`);

--
-- Indexes for table `turno`
--
ALTER TABLE `turno`
  ADD PRIMARY KEY (`Id_Turno`);

--
-- Indexes for table `turno_rte`
--
ALTER TABLE `turno_rte`
  ADD PRIMARY KEY (`Id_Turno`);

--
-- Indexes for table `tutores`
--
ALTER TABLE `tutores`
  ADD PRIMARY KEY (`Dni_Tutor`),
  ADD KEY `RefEstado_Civil36` (`Id_Estado_Civil`),
  ADD KEY `RefSexo_Personas67` (`Id_Sexo`),
  ADD KEY `RefTipo_Relacion_Alumno_Tutor68` (`Id_Relacion`),
  ADD KEY `RefOcupacion_Tutor69` (`Id_Ocupacion`),
  ADD KEY `RefProvincias71` (`Id_Provincia`),
  ADD KEY `RefLocalidades73` (`Id_Localidad`),
  ADD KEY `RefDepartamento119` (`Id_Departamento`);

--
-- Indexes for table `ubicacion_equipo`
--
ALTER TABLE `ubicacion_equipo`
  ADD PRIMARY KEY (`Id_Ubicacion`);

--
-- Indexes for table `userlevelpermissions`
--
ALTER TABLE `userlevelpermissions`
  ADD PRIMARY KEY (`userlevelid`,`tablename`);

--
-- Indexes for table `userlevels`
--
ALTER TABLE `userlevels`
  ADD PRIMARY KEY (`userlevelid`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Nombre`);

--
-- Indexes for table `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`Id_Zona`),
  ADD KEY `RefDepartamento175` (`Id_Departamento`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ano_entrega`
--
ALTER TABLE `ano_entrega`
  MODIFY `Id_Ano` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `asistencia_rte`
--
ALTER TABLE `asistencia_rte`
  MODIFY `Id_Asistencia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atencion_equipos`
--
ALTER TABLE `atencion_equipos`
  MODIFY `Id_Atencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `audittrail`
--
ALTER TABLE `audittrail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3272;
--
-- AUTO_INCREMENT for table `autoridades_escolares`
--
ALTER TABLE `autoridades_escolares`
  MODIFY `Id_Autoridad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cargo_autoridad`
--
ALTER TABLE `cargo_autoridad`
  MODIFY `Id_Cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cargo_persona`
--
ALTER TABLE `cargo_persona`
  MODIFY `Id_Cargo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `Orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `conversaciones`
--
ALTER TABLE `conversaciones`
  MODIFY `Nro_Conversacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cursos`
--
ALTER TABLE `cursos`
  MODIFY `Id_Curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `denuncia_robo_equipo`
--
ALTER TABLE `denuncia_robo_equipo`
  MODIFY `IdDenuncia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `departamento`
--
ALTER TABLE `departamento`
  MODIFY `Id_Departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `detalle_asistencia`
--
ALTER TABLE `detalle_asistencia`
  MODIFY `Dia` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `detalle_atencion`
--
ALTER TABLE `detalle_atencion`
  MODIFY `Id_Detalle_Atencion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `Id_Division` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `estado_actual_solucion_problema`
--
ALTER TABLE `estado_actual_solucion_problema`
  MODIFY `Id_Estado_Atenc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `estado_civil`
--
ALTER TABLE `estado_civil`
  MODIFY `Id_Estado_Civil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `estado_denuncia`
--
ALTER TABLE `estado_denuncia`
  MODIFY `Id_Estado_Den` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_devolucion_prestamo`
--
ALTER TABLE `estado_devolucion_prestamo`
  MODIFY `Id_Estado_Devol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_equipo`
--
ALTER TABLE `estado_equipo`
  MODIFY `Id_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `estado_equipos_piso`
--
ALTER TABLE `estado_equipos_piso`
  MODIFY `Id_Estado_Equipo_piso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `estado_equipo_devuelto`
--
ALTER TABLE `estado_equipo_devuelto`
  MODIFY `Id_Estado_Devol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_espera_prestamo`
--
ALTER TABLE `estado_espera_prestamo`
  MODIFY `Id_Estado_Espera` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `estado_establecimiento`
--
ALTER TABLE `estado_establecimiento`
  MODIFY `Id_Estado_Esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_paquete`
--
ALTER TABLE `estado_paquete`
  MODIFY `Id_Estado_Paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `estado_pase`
--
ALTER TABLE `estado_pase`
  MODIFY `Id_Estado_Pase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_persona`
--
ALTER TABLE `estado_persona`
  MODIFY `Id_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `estado_prestamo_equipo`
--
ALTER TABLE `estado_prestamo_equipo`
  MODIFY `Id_Estado_Prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `estado_server`
--
ALTER TABLE `estado_server`
  MODIFY `Id_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `historial_atencion`
--
ALTER TABLE `historial_atencion`
  MODIFY `Id_Historial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `localidades`
--
ALTER TABLE `localidades`
  MODIFY `Id_Localidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;
--
-- AUTO_INCREMENT for table `marca`
--
ALTER TABLE `marca`
  MODIFY `Id_Marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `marca_server`
--
ALTER TABLE `marca_server`
  MODIFY `Id_Marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `materias_adeudadas`
--
ALTER TABLE `materias_adeudadas`
  MODIFY `Id_Mat_Adeuda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `materias_anuales`
--
ALTER TABLE `materias_anuales`
  MODIFY `Id_Materia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `modalidad_establecimiento`
--
ALTER TABLE `modalidad_establecimiento`
  MODIFY `Id_Modalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `modelo`
--
ALTER TABLE `modelo`
  MODIFY `Id_Modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `modelo_server`
--
ALTER TABLE `modelo_server`
  MODIFY `Id_Modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `motivo_devolucion`
--
ALTER TABLE `motivo_devolucion`
  MODIFY `Id_Motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `motivo_pedido_paquetes`
--
ALTER TABLE `motivo_pedido_paquetes`
  MODIFY `Id_Motivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `motivo_prestamo_equipo`
--
ALTER TABLE `motivo_prestamo_equipo`
  MODIFY `Id_Motivo_Prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `motivo_reasignacion`
--
ALTER TABLE `motivo_reasignacion`
  MODIFY `Id_Motivo_Reasig` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `nivel_educativo`
--
ALTER TABLE `nivel_educativo`
  MODIFY `Id_Nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `novedades`
--
ALTER TABLE `novedades`
  MODIFY `Id_Novedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `observacion_equipo`
--
ALTER TABLE `observacion_equipo`
  MODIFY `Id_Observacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `observacion_persona`
--
ALTER TABLE `observacion_persona`
  MODIFY `Id_Observacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `observacion_tutor`
--
ALTER TABLE `observacion_tutor`
  MODIFY `Id_Observacion` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ocupacion_tutor`
--
ALTER TABLE `ocupacion_tutor`
  MODIFY `Id_Ocupacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `paises`
--
ALTER TABLE `paises`
  MODIFY `Id_Pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `paquetes_provision`
--
ALTER TABLE `paquetes_provision`
  MODIFY `NroPedido` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pase_establecimiento`
--
ALTER TABLE `pase_establecimiento`
  MODIFY `Id_Pase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `prestamo_equipo`
--
ALTER TABLE `prestamo_equipo`
  MODIFY `Id_Prestamo` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `problema`
--
ALTER TABLE `problema`
  MODIFY `Id_Problema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `provincias`
--
ALTER TABLE `provincias`
  MODIFY `Id_Provincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reasignacion_equipo`
--
ALTER TABLE `reasignacion_equipo`
  MODIFY `Id_Reasignacion` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sexo_personas`
--
ALTER TABLE `sexo_personas`
  MODIFY `Id_Sexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `situacion_estado`
--
ALTER TABLE `situacion_estado`
  MODIFY `Id_Sit_Estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `so_server`
--
ALTER TABLE `so_server`
  MODIFY `Id_SO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  MODIFY `Id_Tipo_Equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `tipo_escuela`
--
ALTER TABLE `tipo_escuela`
  MODIFY `Id_Tipo_Esc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `tipo_extraccion`
--
ALTER TABLE `tipo_extraccion`
  MODIFY `Id_Tipo_Extraccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipo_falla`
--
ALTER TABLE `tipo_falla`
  MODIFY `Id_Tipo_Falla` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipo_jornada`
--
ALTER TABLE `tipo_jornada`
  MODIFY `Id_Jornada` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tipo_paquete`
--
ALTER TABLE `tipo_paquete`
  MODIFY `Id_Tipo_Paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipo_prioridad_atencion`
--
ALTER TABLE `tipo_prioridad_atencion`
  MODIFY `Id_Prioridad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tipo_relacion_alumno_tutor`
--
ALTER TABLE `tipo_relacion_alumno_tutor`
  MODIFY `Id_Relacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tipo_retiro_atencion_st`
--
ALTER TABLE `tipo_retiro_atencion_st`
  MODIFY `Id_Tipo_Retiro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `tipo_solucion_problema`
--
ALTER TABLE `tipo_solucion_problema`
  MODIFY `Id_Tipo_Sol_Problem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `turno`
--
ALTER TABLE `turno`
  MODIFY `Id_Turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `turno_rte`
--
ALTER TABLE `turno_rte`
  MODIFY `Id_Turno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ubicacion_equipo`
--
ALTER TABLE `ubicacion_equipo`
  MODIFY `Id_Ubicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `zonas`
--
ALTER TABLE `zonas`
  MODIFY `Id_Zona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
