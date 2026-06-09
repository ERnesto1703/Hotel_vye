-- Script de inicialización SQL para XAMPP / phpMyAdmin
-- Base de Datos: hotel_maya_bay

CREATE DATABASE IF NOT EXISTS `hotel_maya_bay` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `hotel_maya_bay`;

-- 1. Estructura de la tabla `habitaciones`
CREATE TABLE IF NOT EXISTS `habitaciones` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `estado` varchar(255) NOT NULL DEFAULT 'disponible',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `habitaciones_numero_unique` (`numero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Estructura de la tabla `camionetas`
CREATE TABLE IF NOT EXISTS `camionetas` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `placa` varchar(255) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `camionetas_placa_unique` (`placa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Estructura de la tabla `reservas_habitacion`
CREATE TABLE IF NOT EXISTS `reservas_habitacion` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente` varchar(255) NOT NULL,
  `cliente_email` varchar(255) NOT NULL,
  `cliente_telefono` varchar(255) NOT NULL,
  `habitacion_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservas_habitacion_habitacion_id_foreign` (`habitacion_id`),
  CONSTRAINT `reservas_habitacion_habitacion_id_foreign` FOREIGN KEY (`habitacion_id`) REFERENCES `habitaciones` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Estructura de la tabla `reservas_traslado`
CREATE TABLE IF NOT EXISTS `reservas_traslado` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `reserva_habitacion_id` bigint(20) UNSIGNED NOT NULL,
  `camioneta_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `num_pasajeros` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservas_traslado_reserva_habitacion_id_foreign` (`reserva_habitacion_id`),
  KEY `reservas_traslado_camioneta_id_foreign` (`camioneta_id`),
  CONSTRAINT `reservas_traslado_camioneta_id_foreign` FOREIGN KEY (`camioneta_id`) REFERENCES `camionetas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reservas_traslado_reserva_habitacion_id_foreign` FOREIGN KEY (`reserva_habitacion_id`) REFERENCES `reservas_habitacion` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- DATOS DE PRUEBA (SEEDING)
-- --------------------------------------------------------

-- Sembrar `habitaciones` (15 Estándar, 15 Familiar, 10 Premium)
INSERT INTO `habitaciones` (`numero`, `tipo`, `precio`, `estado`, `created_at`, `updated_at`) VALUES
('Habitación 101', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 102', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 103', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 104', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 105', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 106', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 107', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 108', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 109', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 110', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 111', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 112', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 113', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 114', 'estandar', 120.00, 'disponible', NOW(), NOW()),
('Habitación 115', 'estandar', 120.00, 'disponible', NOW(), NOW()),

('Habitación 201', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 202', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 203', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 204', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 205', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 206', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 207', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 208', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 209', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 210', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 211', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 212', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 213', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 214', 'familiar', 180.00, 'disponible', NOW(), NOW()),
('Habitación 215', 'familiar', 180.00, 'disponible', NOW(), NOW()),

('Suite 301', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 302', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 303', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 304', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 305', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 306', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 307', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 308', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 309', 'premium', 280.00, 'disponible', NOW(), NOW()),
('Suite 310', 'premium', 280.00, 'disponible', NOW(), NOW());

-- Sembrar `camionetas` (3 Vehículos)
INSERT INTO `camionetas` (`placa`, `capacidad`, `created_at`, `updated_at`) VALUES
('ABC-123', 6, NOW(), NOW()),
('DEF-456', 8, NOW(), NOW()),
('GHI-789', 10, NOW(), NOW());
