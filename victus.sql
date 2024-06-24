-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 24-06-2024 a las 02:02:14
-- Versión del servidor: 10.6.18-MariaDB-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `victus`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animes`
--

CREATE TABLE `animes` (
  `ani_id` int(11) NOT NULL COMMENT 'Internal Id to identify every line',
  `name` text NOT NULL COMMENT 'Name of the anime',
  `type` tinytext DEFAULT NULL,
  `Status` mediumtext DEFAULT NULL,
  `Season` smallint(6) DEFAULT NULL,
  `Episodes` int(11) DEFAULT NULL COMMENT 'Episodes that it has the entire season',
  `Last_Episode` int(11) DEFAULT NULL COMMENT 'Last episode uploaded',
  `upload_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Auto date save of the upload ',
  `link_anime` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE `animes` (
  `ani_id` int(11) NOT NULL COMMENT 'Internal Id to identify every line',
  `name` text NOT NULL COMMENT 'Name of the anime',
  `type` tinytext DEFAULT NULL,
  `Status` mediumtext DEFAULT NULL,
  `Season` smallint(6) DEFAULT NULL,
  `Episodes` int(11) DEFAULT NULL COMMENT 'Episodes that it has the entire season',
  `Last_Episode` int(11) DEFAULT NULL COMMENT 'Last episode uploaded',
  `upload_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Auto date save of the upload ',
  `link_anime` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `internalID` int(11) NOT NULL,
  `telegramID` decimal(11,0) NOT NULL,
  `dateCreation` datetime NOT NULL DEFAULT current_timestamp(),
  `nameUser` varchar(20) DEFAULT NULL,
  `LastNameUsr` varchar(20) DEFAULT NULL,
  `UsrName` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `user_animes` (
  `dataID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ani_id` int(11) NOT NULL COMMENT 'Here is where you can save the ID of the anime to search it on the animes table',
  `time_Added` datetime NOT NULL DEFAULT current_timestamp(),
  `lastCapNoti` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
