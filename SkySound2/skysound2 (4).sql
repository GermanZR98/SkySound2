-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2019 a las 14:54:24
-- Versión del servidor: 10.1.30-MariaDB
-- Versión de PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `skysound2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canciones`
--

CREATE TABLE `canciones` (
  `idcancion` int(11) NOT NULL,
  `artista` varchar(50) DEFAULT NULL,
  `ncancion` varchar(255) DEFAULT NULL,
  `reproduccion` int(50) DEFAULT NULL,
  `cancion` varchar(255) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `album` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `canciones`
--

INSERT INTO `canciones` (`idcancion`, `artista`, `ncancion`, `reproduccion`, `cancion`, `genero`, `album`) VALUES
(3, 'Zomboy', 'Nuclear', NULL, NULL, 'Dubstep', 'Bomba'),
(4, 'Camela', 'SueÃ±o contigo', NULL, NULL, 'Flamenco', 'Las aceitunas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

CREATE TABLE `comentario` (
  `idcomentario` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `idcancion` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`idcomentario`, `comentario`, `idcancion`, `nombre`) VALUES
(185, 'Me gusta', 3, 'TheZambrana98'),
(186, 'No me gusta', 3, 'Juan23'),
(187, 'No me gusta Camela', 4, 'Sergio ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idusuario` int(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `contrasena` varchar(33) NOT NULL,
  `nombreusuario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idusuario`, `correo`, `contrasena`, `nombreusuario`) VALUES
(1, 'germandaw98@gmail.com', 'hola', 'TheZambrana98'),
(29, 'admin@admin.com', 'admin', 'admin'),
(37, 'jesus@jesus.com', '123456', '123456');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canciones`
--
ALTER TABLE `canciones`
  ADD PRIMARY KEY (`idcancion`);

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`idcomentario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idusuario`),
  ADD UNIQUE KEY `idusuario` (`idusuario`),
  ADD UNIQUE KEY `nombreusuario` (`nombreusuario`),
  ADD UNIQUE KEY `nombreusuario_2` (`nombreusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canciones`
--
ALTER TABLE `canciones`
  MODIFY `idcancion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `idcomentario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idusuario` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
