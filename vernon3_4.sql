-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 29 juil. 2021 à 10:16
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
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `price` int(10) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `pwd`, `name`, `avatar`, `created_at`, `role`) VALUES
(2, 'admin@admin.com', '$argon2i$v=19$m=65536,t=4,p=1$MktKY29JeHh5MUwwVXNvbw$WNpm5t95NbUw7IlEhHeJb8CArEV0+FKJJcKJRrWQBGM', 'admin', './asset/upload/coverDeadPrez.jpg', '2021-07-27 16:17:49', 'ROLE_ADMIN'),
(4, 'azerty@azerty.com', '$argon2i$v=19$m=65536,t=4,p=1$OVZvQmZHZ2M3SFhCNE5CYQ$Jq4Xl7I5jpXLDn5NIXPdm4QoFo3hNx5xiTH4Cm2cfIc', 'azerty', './asset/upload/coverPharcyde.jpg', '2021-07-29 08:58:34', 'ROLE_USER'),
(5, 'azerty1@azerty.com', '$argon2i$v=19$m=65536,t=4,p=1$eEE5ZzVxcHZLNE9aRGg5Qw$BlVIEEr+2FKVlsYGyA3HjWEHCiWWoBmIEjJgeqO4Ac4', 'azerty', './asset/upload/coverDeadPrez.jpg', '2021-07-29 12:01:41', 'ROLE_USER'),
(6, 'azerty2@azerty.com', '$argon2i$v=19$m=65536,t=4,p=1$VHhkWlpmMXMvZkQuMmw2cg$F+oYX9niFQVB5qoJGSU271h6t2bQN0f38D+KmfGX4d8', 'aeztzetzet', './asset/upload/coverSoulOf.jpg', '2021-07-29 12:08:56', 'ROLE_USER');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
