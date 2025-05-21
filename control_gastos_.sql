-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2025 a las 12:54:50
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_gastos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos_fijos`
--

CREATE TABLE `gastos_fijos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_gasto` varchar(100) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `gastos_fijos`
--

INSERT INTO `gastos_fijos` (`id`, `usuario_id`, `nombre_gasto`, `monto`, `fecha`, `categoria`, `descripcion`, `created_at`) VALUES
(38, 16, 'Internet', 250000.00, '2025-05-15', 'Juguetes y juegos', 'xdd', '2025-05-21 08:42:42'),
(39, 16, 'Internet', 1201000.00, '2200-02-20', 'Alimentación', '', '2025-05-21 10:29:31'),
(40, 16, 'Internet', 225000.00, '2025-05-08', 'Alimentación', '', '2025-05-21 10:33:31'),
(41, 16, '200000', 2000000.00, '2025-04-30', 'Alimentación', '', '2025-05-21 10:38:33'),
(42, 16, 'xd', 120000.00, '2025-05-16', 'Automóviles y Accesorios', 'xd', '2025-05-21 10:40:50'),
(44, 17, 'Internetxds', 250000.00, '2025-05-09', 'Otro', '1200', '2025-05-21 10:48:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_ahorros`
--

CREATE TABLE `historial_ahorros` (
  `id` int(11) NOT NULL,
  `meta_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `cantidad` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `descripcion1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial_ahorros`
--

INSERT INTO `historial_ahorros` (`id`, `meta_id`, `usuario_id`, `cantidad`, `fecha`, `descripcion1`) VALUES
(59, 23, 16, 2000.00, '2025-05-21 09:28:58', ''),
(60, 23, 16, 20000.00, '2025-05-21 09:29:22', ''),
(61, 23, 16, 500000.00, '2025-05-21 09:30:00', ''),
(64, 23, 16, 20000.00, '2025-05-21 09:32:55', ''),
(66, 23, 16, 2000.00, '2025-05-21 09:39:34', ''),
(67, 23, 16, 2000.00, '2025-05-21 09:39:43', ''),
(68, 23, 16, 5000.00, '2025-05-21 09:39:48', ''),
(70, 23, 16, 50000.00, '2025-05-21 09:40:27', ''),
(72, 25, 16, 2000.00, '2025-05-21 09:41:05', ''),
(73, 23, 16, 2000.00, '2025-05-21 09:41:56', ''),
(74, 23, 16, 2000.00, '2025-05-21 09:42:05', ''),
(75, 25, 16, 20000.00, '2025-05-21 09:43:25', ''),
(76, 25, 16, 100000.00, '2025-05-21 09:43:30', ''),
(77, 25, 16, 800000.00, '2025-05-21 09:43:45', ''),
(78, 23, 16, 50000.00, '2025-05-21 09:49:01', ''),
(79, 25, 16, 20000.00, '2025-05-21 09:49:16', ''),
(80, 25, 16, 50000.00, '2025-05-21 09:49:20', ''),
(81, 23, 16, 50000.00, '2025-05-21 09:59:55', ''),
(82, 23, 16, 20000.00, '2025-05-21 10:00:23', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `metas_ahorro`
--

CREATE TABLE `metas_ahorro` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_meta` varchar(255) NOT NULL,
  `cantidad_meta` decimal(10,2) NOT NULL,
  `fecha_limite` date NOT NULL,
  `descripcion` text DEFAULT NULL,
  `creada_en` timestamp NOT NULL DEFAULT current_timestamp(),
  `cumplida` tinyint(1) DEFAULT 0,
  `ahorrado` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `metas_ahorro`
--

INSERT INTO `metas_ahorro` (`id`, `usuario_id`, `nombre_meta`, `cantidad_meta`, `fecha_limite`, `descripcion`, `creada_en`, `cumplida`, `ahorrado`) VALUES
(23, 16, '120000', 2500000.00, '2025-05-08', '20320', '2025-05-21 09:01:22', 0, 725000.00),
(25, 16, 'd', 3200000.00, '2025-05-24', '', '2025-05-21 09:40:45', 0, 992000.00),
(26, 16, 'xx', 200.00, '2025-05-06', 'x', '2025-05-21 10:03:11', 0, 0.00),
(27, 17, 'Fondo para Negocio Propio', 5000000.00, '2025-05-24', 'xd', '2025-05-21 10:43:27', 0, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `password`, `fecha_registro`, `ultimo_login`) VALUES
(13, 'Maicol', '1m@gmail.com', '$2y$10$u6.MaKf897ZEyfKhZcKTYOfidFq5uNYoObc4ZfGmVSMyqNFcMdR1m', '2025-05-20 10:27:05', NULL),
(14, 'Prueba', 'p1@gmail.com', '$2y$10$x5iI3Yjd.nHqryw0frni..1d7DdjXSXO/Wadh2aNza3oxn.4IyTvW', '2025-05-20 10:37:46', NULL),
(15, 'Pruebas', 'prueba123@gmail.com', '$2y$10$YmrVxhTCYPhBx1wLUEmb4O.eP0RAZiRJHhOTfzgUB46X3SzY1gI2K', '2025-05-20 11:23:37', NULL),
(16, 'maicol', '1@gmail.com', '$2y$10$pkyaqoWsnBCfO/Wg/cuWy.3vohDjex4fgXjnqM3dNl4YOylWfQ68y', '2025-05-21 08:42:07', NULL),
(17, 'maicol2', '2@gmail.com', '$2y$10$nftxqVbwN/QES/d8A6Xb4Ohpfqr5pKcduLaDukWvD2Yn/J9ZrGj4S', '2025-05-21 10:43:09', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `meta_id` (`meta_id`);

--
-- Indices de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `gastos_fijos`
--
ALTER TABLE `gastos_fijos`
  ADD CONSTRAINT `fk_gastos_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_ahorros`
--
ALTER TABLE `historial_ahorros`
  ADD CONSTRAINT `historial_ahorros_ibfk_1` FOREIGN KEY (`meta_id`) REFERENCES `metas_ahorro` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `metas_ahorro`
--
ALTER TABLE `metas_ahorro`
  ADD CONSTRAINT `fk_metas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
