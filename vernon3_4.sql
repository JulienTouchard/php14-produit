-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mer. 28 juil. 2021 à 13:50
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `vernon3_4`
--

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `name` varchar(20) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pwd`, `name`, `avatar`, `created_at`, `role`) VALUES
(2, 'admin@admin.com', '$argon2i$v=19$m=65536,t=4,p=1$MktKY29JeHh5MUwwVXNvbw$WNpm5t95NbUw7IlEhHeJb8CArEV0+FKJJcKJRrWQBGM', 'admin', './asset/upload/coverDeadPrez.jpg', '2021-07-27 16:17:49', 'ROLE_ADMIN'),
(3, 'azerty@azerty.com', '$argon2i$v=19$m=65536,t=4,p=1$aGlodU5XSDlBaloyMmZXUw$oJZ/KiFFLIVw6CzWZCtYX2CDoYHSmiODwEhboUX8oN4', 'azerty', './asset/upload/coverSoulOf.jpg', '2021-07-28 15:23:31', 'ROLE_USER');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
