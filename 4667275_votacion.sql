-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: fdb1034.awardspace.net
-- Tiempo de generación: 07-09-2025 a las 22:46:57
-- Versión del servidor: 8.0.32
-- Versión de PHP: 8.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `4667275_votacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `puesto` varchar(100) NOT NULL,
  `piso` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre`, `apellido`, `puesto`, `piso`) VALUES
(1, 'Uziel', 'Rivera Pulgarin', 'Editor', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id_registro` int NOT NULL,
  `id_persona` int NOT NULL,
  `tipo_persona` enum('empleado','visitante') NOT NULL,
  `fecha_hora_entrada` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id_registro`, `id_persona`, `tipo_persona`, `fecha_hora_entrada`) VALUES
(1, 1, 'empleado', '2025-09-07 19:56:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `correo` varchar(40) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `contrasena`, `fecha_registro`) VALUES
(8, 'Zahiragarcia@gmail.com', '$2y$10$j7mm46Cf3uKoBaz.VNC8UOYlklCxM.8su0B6AXJAlsadzEVAGKb.2', '2025-09-01 15:37:47'),
(9, 'brayan@gomail.com', '$2y$10$Mk8NwF5Cq40/5.PW3Vhz..BKx05mLzHbTcvOntZZYEc.mr7Ru5GZq', '2025-09-01 15:37:52'),
(10, 'f.palacios@gmail.com', '$2y$10$ePwAEJPqBO2HzttUfUaf1.mqPmuem9URYacPgpCPpNpt5XtSUo34O', '2025-09-01 15:37:57'),
(11, 'janeth@holi.com', '$2y$10$.9emgIRFxRbg2Jefwsf2JefoAvMV2wwcpQOsiQeRmkbp2q3Ame3nu', '2025-09-01 15:38:20'),
(12, 'alain.ac@gmail.com', '$2y$10$TIpRnYvwjk5fNvltMGeGNOCMaAWqBxxryEWFOYVLe4jzvPzzmoapa', '2025-09-01 15:38:44'),
(13, 'itzel123@gmail.com', '$2y$10$inrAurI6NwzFSaS8UVpc0.xT3vrcc.iNosDB/46QOEOIMwE0//aH.', '2025-09-01 15:40:06'),
(14, 'mariano@gmail.com', '$2y$10$ajfzTOjppN2W8GsKk8qeVekhCI1tfcWl4hVYWbVkpee9Q8awirEku', '2025-09-07 04:49:26'),
(15, 'nicacio@gmail.com', '$2y$10$55PRaA9CKilKlUIzAWQxPualIPS/2yI3CLOj2AGQ/2TouzGt97JnK', '2025-09-07 05:42:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `visitantes`
--

CREATE TABLE `visitantes` (
  `id_visitante` int NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `motivo_visita` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `votos`
--

CREATE TABLE `votos` (
  `id` int NOT NULL,
  `universidad` varchar(50) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `fecha_voto` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `votos`
--

INSERT INTO `votos` (`id`, `universidad`, `correo`, `fecha_voto`) VALUES
(5, 'uacj', 'brayan@gomail.com', '0000-00-00 00:00:00'),
(6, 'urn', 'f.palacios@gmail.com', '0000-00-00 00:00:00'),
(7, 'urn', 'janeth@holi.com', '0000-00-00 00:00:00'),
(8, 'uach', 'alain.ac@gmail.com', '0000-00-00 00:00:00'),
(9, 'uacj', 'Zahiragarcia@gmail.com', '0000-00-00 00:00:00'),
(10, 'uacj', 'itzel123@gmail.com', '0000-00-00 00:00:00'),
(11, 'urn', 'mariano@gmail.com', '0000-00-00 00:00:00'),
(12, 'uacj', 'nicacio@gmail.com', '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id_registro`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  ADD PRIMARY KEY (`id_visitante`);

--
-- Indices de la tabla `votos`
--
ALTER TABLE `votos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_voto` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id_registro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `visitantes`
--
ALTER TABLE `visitantes`
  MODIFY `id_visitante` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `votos`
--
ALTER TABLE `votos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
