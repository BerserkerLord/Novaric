-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-07-2021 a las 00:46:14
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `novaric`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aspersor`
--

CREATE TABLE `aspersor` (
  `codigo_producto` varchar(100) NOT NULL,
  `caudal_minimo` decimal(10,2) NOT NULL,
  `caudal_maximo` decimal(10,2) NOT NULL,
  `presion_minima` decimal(10,2) NOT NULL,
  `presion_maxima` decimal(10,2) NOT NULL,
  `alcance_minimo` decimal(10,2) NOT NULL,
  `alcance_maximo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aspersor`
--

INSERT INTO `aspersor` (`codigo_producto`, `caudal_minimo`, `caudal_maximo`, `presion_minima`, `presion_maxima`, `alcance_minimo`, `alcance_maximo`) VALUES
('7894', '0.10', '0.50', '17.00', '20.00', '10.00', '40.00'),
('7895', '0.20', '0.40', '15.00', '17.00', '20.00', '50.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `rfc` varchar(13) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apaterno` varchar(60) NOT NULL,
  `amaterno` varchar(60) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(12) NOT NULL,
  `domicilio` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cliente`
--

INSERT INTO `cliente` (`rfc`, `nombre`, `apaterno`, `amaterno`, `email`, `telefono`, `domicilio`) VALUES
('ZACD000612HG8', 'Ivan', 'Saldaña', '', 'ivan@gmail.com', '461-456-7894', 'Topacio 102 Interior 302 col SanJuanico'),
('ZACD000612HGL', 'Viridiana', 'Alvarez', 'Guatemala', 'zdariozarate@gmail.com', '456-578-4561', 'Calle 1 Colonia 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conexion`
--

CREATE TABLE `conexion` (
  `codigo_producto` varchar(100) NOT NULL,
  `diametro` decimal(10,2) NOT NULL,
  `id_extremidad1` tinyint(4) NOT NULL,
  `id_extremidad2` tinyint(4) NOT NULL,
  `id_forma_conexion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `conexion`
--

INSERT INTO `conexion` (`codigo_producto`, `diametro`, `id_extremidad1`, `id_extremidad2`, `id_forma_conexion`) VALUES
('918353', '19.05', 5, 5, 2),
('931298', '19.05', 5, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `id_departamento` tinyint(4) NOT NULL,
  `departamento` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`id_departamento`, `departamento`) VALUES
(3, 'Almacen'),
(2, 'Contabilidad'),
(1, 'Dirección'),
(4, 'RH');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_producto_compra`
--

CREATE TABLE `detalle_factura_producto_compra` (
  `id_factura` int(11) NOT NULL,
  `codigo_producto` varchar(10) NOT NULL,
  `cantidad` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_factura_producto_compra`
--

INSERT INTO `detalle_factura_producto_compra` (`id_factura`, `codigo_producto`, `cantidad`) VALUES
(2, '7894', '200.00'),
(2, '33456', '200.00'),
(2, '931298', '78.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura_producto_venta`
--

CREATE TABLE `detalle_factura_producto_venta` (
  `id_factura` int(11) NOT NULL,
  `codigo_producto` varchar(10) NOT NULL,
  `cantidad` decimal(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detalle_factura_producto_venta`
--

INSERT INTO `detalle_factura_producto_venta` (`id_factura`, `codigo_producto`, `cantidad`) VALUES
(3, '7894', '10.00'),
(3, '931298', '10.00'),
(4, '7894', '50.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `rfc` varchar(13) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apaterno` varchar(30) NOT NULL,
  `amaterno` varchar(30) DEFAULT NULL,
  `direccion` varchar(100) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `correo` varchar(60) NOT NULL,
  `contrasenia` varchar(50) NOT NULL,
  `fotografia` varchar(100) NOT NULL,
  `token` varchar(10) DEFAULT NULL,
  `id_puesto` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`rfc`, `nombre`, `apaterno`, `amaterno`, `direccion`, `usuario`, `correo`, `contrasenia`, `fotografia`, `token`, `id_puesto`) VALUES
('ZACD000612DAS', 'Darío', 'Zarate', 'Ceballos', 'Topacio 102 Interior 302 col SanJuanico', NULL, '18030948@itcelaya.edu.mx', '900150983cd24fb0d6963f7d28e17f72', 'c41a06e3dfd89931d2b9eec7da16dd86.jpg', 'r/l3r9cFdp', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_factura`
--

CREATE TABLE `estatus_factura` (
  `id_estatus_factura` smallint(6) NOT NULL,
  `estatus_factura` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estatus_factura`
--

INSERT INTO `estatus_factura` (`id_estatus_factura`, `estatus_factura`) VALUES
(1, 'Abierta'),
(2, 'Pagada'),
(3, 'Cancelada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estatus_venta`
--

CREATE TABLE `estatus_venta` (
  `id_estatus_venta` smallint(6) NOT NULL,
  `estatus_venta` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estatus_venta`
--

INSERT INTO `estatus_venta` (`id_estatus_venta`, `estatus_venta`) VALUES
(1, 'Preparando'),
(2, 'Enviado'),
(3, 'Entregado'),
(4, 'Perdido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extremidad`
--

CREATE TABLE `extremidad` (
  `id_extremidad` tinyint(4) NOT NULL,
  `extremidad` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `extremidad`
--

INSERT INTO `extremidad` (`id_extremidad`, `extremidad`) VALUES
(3, 'Anillo Compuerta Espiga'),
(2, 'Campana'),
(1, 'Casquillo'),
(5, 'Espiga'),
(4, 'Rosca Hembra');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `id_estatus_factura` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura`
--

INSERT INTO `factura` (`id_factura`, `fecha`, `id_estatus_factura`) VALUES
(2, '2021-07-07', 1),
(3, '2021-07-07', 1),
(4, '2021-07-07', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_compra`
--

CREATE TABLE `factura_compra` (
  `id_factura` int(11) NOT NULL,
  `rfc` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_compra`
--

INSERT INTO `factura_compra` (`id_factura`, `rfc`) VALUES
(2, 'RIM00062345L');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_servicio`
--

CREATE TABLE `factura_servicio` (
  `id_factura` int(11) NOT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `descripcion` varchar(100) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `domicilio` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_servicio_servicio`
--

CREATE TABLE `factura_servicio_servicio` (
  `id_factura_servicio` int(11) NOT NULL,
  `id_servicio` tinyint(4) NOT NULL,
  `monto` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura_venta`
--

CREATE TABLE `factura_venta` (
  `id_factura` int(11) NOT NULL,
  `id_estatus_venta` smallint(6) NOT NULL,
  `rfc` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `factura_venta`
--

INSERT INTO `factura_venta` (`id_factura`, `id_estatus_venta`, `rfc`) VALUES
(3, 1, 'ZACD000612HG8'),
(4, 1, 'ZACD000612HGL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forma_conexion`
--

CREATE TABLE `forma_conexion` (
  `id_forma_conexion` tinyint(4) NOT NULL,
  `forma_conexion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `forma_conexion`
--

INSERT INTO `forma_conexion` (`id_forma_conexion`, `forma_conexion`) VALUES
(4, 'Brida'),
(2, 'Cople'),
(3, 'Reducción Bushing'),
(1, 'Tee');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` tinyint(4) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `fotografia` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `marca`, `fotografia`) VALUES
(1, 'Amanco Wavin', '4c575f45759c6826b655ff453d5faf73.jpg'),
(2, 'Azud', '275a149c8b47fca3451f9867f42a39b3.png'),
(3, 'Contact', '73b0108a39eeaae6b4d12ca6dccff814.jpg'),
(4, 'Hunter', 'c5c0ee7c4675ec72cb49bf922532e338.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `miscelaneo`
--

CREATE TABLE `miscelaneo` (
  `codigo_producto` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `miscelaneo`
--

INSERT INTO `miscelaneo` (`codigo_producto`) VALUES
('1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `codigo_producto` varchar(10) NOT NULL,
  `producto` text DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `precio_publico` decimal(10,2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `existencias` decimal(20,2) NOT NULL,
  `fotografia` varchar(100) NOT NULL,
  `id_marca` tinyint(4) NOT NULL,
  `id_unidad` tinyint(4) NOT NULL
) ;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`codigo_producto`, `producto`, `costo`, `precio`, `precio_publico`, `descripcion`, `existencias`, `fotografia`, `id_marca`, `id_unidad`) VALUES
('1234', 'Pala cuadrada marca Truper', '123.00', '209.10', '210.00', 'Pala cuadrada marca Truper', '0.00', '316c6f817f5df1200845877f6d44859f.jpg', 4, 2),
('33455', 'Tubo Liso Ademe Geomega 100 160mm', '10.00', '17.00', '20.00', 'Tubo Liso Ademe Geomega 100 160mm', '0.00', 'f529a9661c14baf5ebedf7e410cc0163.png', 1, 1),
('33456', 'Tubo Liso Ademe Geomega 100 200mm', '14.00', '23.80', '30.00', 'Tubo Liso Ademe Geomega 100 200mm', '200.00', '35e6e56537a8a9dcbc85f25d242bd9f1.png', 1, 1),
('7894', 'Aspersor Serie 40', '20.00', '34.00', '40.00', 'Aspersor Serie 40', '140.00', 'b9dd53a6dc882305f0becf3e0cb35623.png', 1, 2),
('7895', 'Aspersor Wobbler', '800.00', '1360.00', '1360.00', 'Aspersor Wobbler', '0.00', '10e77b89e480022a469417fa363dc6e1.png', 4, 2),
('918353', 'Codo 45° Cédula 40 19.05mm', '15.00', '25.50', '30.00', 'Codo 45° Cédula 40 19.05mm', '0.00', 'f65495c7e0608fa07de05f334387517c.png', 2, 2),
('931298', 'Tee Cédula 40 19.05mm', '14.00', '23.80', '30.00', 'Tee Cédula 40 19.05mm', '68.00', 'fa668c20a6d38e7571d9ad77995ee2a3.png', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `rfc` varchar(13) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  `domicilio` text NOT NULL,
  `telefono` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`rfc`, `razon_social`, `domicilio`, `telefono`) VALUES
('IRG141213KL4', 'Instalación y Mantenimiento de Riego y Jardinería Roman', 'Rosa 72, Valle Hermoso, 38010 Celaya, Gto.', '123-789-4523'),
('RIM00062345L', 'Grupo RYMSA México', 'Paseo de la Hacienda #590, Las Arboledas, 38060 Celaya, Gto.', '456-782-1237'),
('VEC880326456', 'Sistemas de Riego de Celaya S.A. de C.V.', 'Cobre 107, Zona de Oro del Bajio, 38016 Celaya, Gto', '461-406-2574');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puesto`
--

CREATE TABLE `puesto` (
  `id_puesto` tinyint(4) NOT NULL,
  `puesto` varchar(30) NOT NULL,
  `id_departamento` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `puesto`
--

INSERT INTO `puesto` (`id_puesto`, `puesto`, `id_departamento`) VALUES
(1, 'Administrador', 1),
(2, 'Contador', 2),
(3, 'Encargado de Inventario', 3),
(4, 'Encargado de Almacen', 3),
(5, 'Director de Recursos Humanos', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` tinyint(4) NOT NULL,
  `servicio` varchar(60) NOT NULL,
  `descripcion` text NOT NULL,
  `fotografia` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id_servicio`, `servicio`, `descripcion`, `fotografia`) VALUES
(1, 'Riego por Goteo', 'Los sistemas de riego por goteo permiten conducir el agua mediante una red de tuberías y aplicarla a los cultivos a través de emisores que entregan pequeños volúmenes de agua en forma periódica.', 'eb765a78e1bb62f956ff66ce90149f02.jpg'),
(2, 'Riego por Aspersión', 'Novedades Agrícolas es una empresa especializada en sistemas de riego.\\r\\nDesde sus inicios realiza diseños e instalaciones de Riego por Aspersión para hacer un reparto lo más homogéneo posible del agua, teniendo en cuenta los factores climáticos (viento, el tipo y altura del cultivo, necesidades del cultivo, la orografía del terreno, etc.).', '9ff32c71a72a82913de8572e36b17e6c.jpeg'),
(3, 'Riego Automático', 'Para el óptimo manejo del riego siempre resulta conveniente, en la medida de lo posible, disponer de sistemas automáticos de control del riego', '7540871c2225c15d8c115963ad292cfd.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tuberia`
--

CREATE TABLE `tuberia` (
  `codigo_producto` varchar(100) NOT NULL,
  `diametro` decimal(10,2) NOT NULL,
  `longitud` decimal(10,2) NOT NULL,
  `id_extremidad1` tinyint(4) NOT NULL,
  `id_extremidad2` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tuberia`
--

INSERT INTO `tuberia` (`codigo_producto`, `diametro`, `longitud`, `id_extremidad1`, `id_extremidad2`) VALUES
('33455', '160.00', '5.75', 2, 2),
('33456', '200.00', '5.75', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id_unidad` tinyint(4) NOT NULL,
  `unidad` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id_unidad`, `unidad`) VALUES
(2, 'Pieza'),
(1, 'Tramo');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aspersor`
--
ALTER TABLE `aspersor`
  ADD PRIMARY KEY (`codigo_producto`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`rfc`),
  ADD UNIQUE KEY `UQ_CLIENTE` (`email`);

--
-- Indices de la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD PRIMARY KEY (`codigo_producto`),
  ADD KEY `FK2_CONEXION` (`id_extremidad1`),
  ADD KEY `FK3_CONEXION` (`id_extremidad2`),
  ADD KEY `FK4_CONEXION` (`id_forma_conexion`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`id_departamento`),
  ADD UNIQUE KEY `UQ_DEPARTAMENTO` (`departamento`);

--
-- Indices de la tabla `detalle_factura_producto_compra`
--
ALTER TABLE `detalle_factura_producto_compra`
  ADD KEY `FK1_DETALLE_FACTURA_PRODUCTO` (`id_factura`),
  ADD KEY `FK2_DETALLE_FACTURA_PRODUCTO` (`codigo_producto`);

--
-- Indices de la tabla `detalle_factura_producto_venta`
--
ALTER TABLE `detalle_factura_producto_venta`
  ADD KEY `FK1_DETALLE_FACTURA_VENTA` (`id_factura`),
  ADD KEY `FK2_DETALLE_FACTURA_VENTA` (`codigo_producto`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`rfc`),
  ADD UNIQUE KEY `UQ_EMPLEADO` (`correo`),
  ADD KEY `FK_EMPLEADO1` (`id_puesto`);

--
-- Indices de la tabla `estatus_factura`
--
ALTER TABLE `estatus_factura`
  ADD PRIMARY KEY (`id_estatus_factura`);

--
-- Indices de la tabla `estatus_venta`
--
ALTER TABLE `estatus_venta`
  ADD PRIMARY KEY (`id_estatus_venta`);

--
-- Indices de la tabla `extremidad`
--
ALTER TABLE `extremidad`
  ADD PRIMARY KEY (`id_extremidad`),
  ADD UNIQUE KEY `UQ_EXTREMIDAD` (`extremidad`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `FK_FACTURA` (`id_estatus_factura`);

--
-- Indices de la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `FK_FACTURA_COMPRA` (`rfc`);

--
-- Indices de la tabla `factura_servicio`
--
ALTER TABLE `factura_servicio`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `FK1_FACTURA_SERVICIO` (`rfc`);

--
-- Indices de la tabla `factura_servicio_servicio`
--
ALTER TABLE `factura_servicio_servicio`
  ADD KEY `FK_FACTURA_SERVICIO_SERVICIO1` (`id_factura_servicio`),
  ADD KEY `FK_FACTURA_SERVICIO_SERVICIO2` (`id_servicio`);

--
-- Indices de la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD PRIMARY KEY (`id_factura`),
  ADD KEY `FK1_FACTURA_VENTA` (`id_estatus_venta`),
  ADD KEY `FK2_FACTURA_VENTA` (`rfc`);

--
-- Indices de la tabla `forma_conexion`
--
ALTER TABLE `forma_conexion`
  ADD PRIMARY KEY (`id_forma_conexion`),
  ADD UNIQUE KEY `UQ_FORMA_CONEXION` (`forma_conexion`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`),
  ADD UNIQUE KEY `UQ_MARCA` (`marca`);

--
-- Indices de la tabla `miscelaneo`
--
ALTER TABLE `miscelaneo`
  ADD PRIMARY KEY (`codigo_producto`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`codigo_producto`),
  ADD KEY `FK2_PRODUCTO` (`id_unidad`),
  ADD KEY `FK3_PRODUCTO` (`id_marca`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`rfc`),
  ADD UNIQUE KEY `UQ_PROVEEDOR` (`rfc`);

--
-- Indices de la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD PRIMARY KEY (`id_puesto`),
  ADD UNIQUE KEY `UQ_PUESTO` (`puesto`),
  ADD KEY `FK_PUESTO` (`id_departamento`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `tuberia`
--
ALTER TABLE `tuberia`
  ADD PRIMARY KEY (`codigo_producto`),
  ADD KEY `FK2_TUBERIA` (`id_extremidad1`),
  ADD KEY `FK3_TUBERIA` (`id_extremidad2`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id_unidad`),
  ADD UNIQUE KEY `UQ_UNIDAD` (`unidad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `id_departamento` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `estatus_factura`
--
ALTER TABLE `estatus_factura`
  MODIFY `id_estatus_factura` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estatus_venta`
--
ALTER TABLE `estatus_venta`
  MODIFY `id_estatus_venta` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `extremidad`
--
ALTER TABLE `extremidad`
  MODIFY `id_extremidad` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `forma_conexion`
--
ALTER TABLE `forma_conexion`
  MODIFY `id_forma_conexion` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `puesto`
--
ALTER TABLE `puesto`
  MODIFY `id_puesto` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id_unidad` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aspersor`
--
ALTER TABLE `aspersor`
  ADD CONSTRAINT `FK1_ASPERSOR` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `conexion`
--
ALTER TABLE `conexion`
  ADD CONSTRAINT `FK1_CONEXION` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`),
  ADD CONSTRAINT `FK2_CONEXION` FOREIGN KEY (`id_extremidad1`) REFERENCES `extremidad` (`id_extremidad`),
  ADD CONSTRAINT `FK3_CONEXION` FOREIGN KEY (`id_extremidad2`) REFERENCES `extremidad` (`id_extremidad`),
  ADD CONSTRAINT `FK4_CONEXION` FOREIGN KEY (`id_forma_conexion`) REFERENCES `forma_conexion` (`id_forma_conexion`);

--
-- Filtros para la tabla `detalle_factura_producto_compra`
--
ALTER TABLE `detalle_factura_producto_compra`
  ADD CONSTRAINT `FK1_DETALLE_FACTURA_PRODUCTO` FOREIGN KEY (`id_factura`) REFERENCES `factura_compra` (`id_factura`),
  ADD CONSTRAINT `FK2_DETALLE_FACTURA_PRODUCTO` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `detalle_factura_producto_venta`
--
ALTER TABLE `detalle_factura_producto_venta`
  ADD CONSTRAINT `FK1_DETALLE_FACTURA_VENTA` FOREIGN KEY (`id_factura`) REFERENCES `factura_venta` (`id_factura`),
  ADD CONSTRAINT `FK2_DETALLE_FACTURA_VENTA` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD CONSTRAINT `FK_EMPLEADO1` FOREIGN KEY (`id_puesto`) REFERENCES `puesto` (`id_puesto`);

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `FK_FACTURA` FOREIGN KEY (`id_estatus_factura`) REFERENCES `estatus_factura` (`id_estatus_factura`);

--
-- Filtros para la tabla `factura_compra`
--
ALTER TABLE `factura_compra`
  ADD CONSTRAINT `FK_FACTURA_COMPRA` FOREIGN KEY (`rfc`) REFERENCES `proveedor` (`rfc`);

--
-- Filtros para la tabla `factura_servicio`
--
ALTER TABLE `factura_servicio`
  ADD CONSTRAINT `FK1_FACTURA_SERVICIO` FOREIGN KEY (`rfc`) REFERENCES `cliente` (`rfc`),
  ADD CONSTRAINT `FK2_FACTURA_SERVICIO` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`);

--
-- Filtros para la tabla `factura_servicio_servicio`
--
ALTER TABLE `factura_servicio_servicio`
  ADD CONSTRAINT `FK_FACTURA_SERVICIO_SERVICIO1` FOREIGN KEY (`id_factura_servicio`) REFERENCES `factura_servicio` (`id_factura`),
  ADD CONSTRAINT `FK_FACTURA_SERVICIO_SERVICIO2` FOREIGN KEY (`id_servicio`) REFERENCES `servicio` (`id_servicio`);

--
-- Filtros para la tabla `factura_venta`
--
ALTER TABLE `factura_venta`
  ADD CONSTRAINT `FK1_FACTURA_VENTA` FOREIGN KEY (`id_estatus_venta`) REFERENCES `estatus_venta` (`id_estatus_venta`),
  ADD CONSTRAINT `FK2_FACTURA_VENTA` FOREIGN KEY (`rfc`) REFERENCES `cliente` (`rfc`);

--
-- Filtros para la tabla `miscelaneo`
--
ALTER TABLE `miscelaneo`
  ADD CONSTRAINT `FK1_MISCELANEO` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `FK2_PRODUCTO` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`),
  ADD CONSTRAINT `FK3_PRODUCTO` FOREIGN KEY (`id_marca`) REFERENCES `marca` (`id_marca`);

--
-- Filtros para la tabla `puesto`
--
ALTER TABLE `puesto`
  ADD CONSTRAINT `FK_PUESTO` FOREIGN KEY (`id_departamento`) REFERENCES `departamento` (`id_departamento`);

--
-- Filtros para la tabla `tuberia`
--
ALTER TABLE `tuberia`
  ADD CONSTRAINT `FK1_TUBERIA` FOREIGN KEY (`codigo_producto`) REFERENCES `producto` (`codigo_producto`),
  ADD CONSTRAINT `FK2_TUBERIA` FOREIGN KEY (`id_extremidad1`) REFERENCES `extremidad` (`id_extremidad`),
  ADD CONSTRAINT `FK3_TUBERIA` FOREIGN KEY (`id_extremidad2`) REFERENCES `extremidad` (`id_extremidad`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
