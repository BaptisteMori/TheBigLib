-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 31 mars 2019 à 12:18
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `thebiglib`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `description` longtext,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `name`, `password`, `email`, `description`, `token`) VALUES
(11, 'testeur', '$2y$10$fT3jq8.fqgvVQZry24yHAeorA4HDxgP.5Vwd5vAr1LHtoYMcMLBR2', 'test@test.com', 'testeur professionnel de test professionnels', NULL),
(21, 'totototo', '$2y$10$f3MYFTvm5R600/ZG8iXI0uSKZR0br9T9r99LuTZ/UjseBvcLe0alm', 'toto@toto.fr', 'salut', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `followedauthor`
--

DROP TABLE IF EXISTS `followedauthor`;
CREATE TABLE IF NOT EXISTS `followedauthor` (
  `author_id` int(11) NOT NULL,
  `followed_id` int(11) NOT NULL,
  PRIMARY KEY (`author_id`,`followed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `followedscript`
--

DROP TABLE IF EXISTS `followedscript`;
CREATE TABLE IF NOT EXISTS `followedscript` (
  `author_id` int(11) NOT NULL,
  `script_id` int(11) NOT NULL,
  PRIMARY KEY (`author_id`,`script_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `script`
--

DROP TABLE IF EXISTS `script`;
CREATE TABLE IF NOT EXISTS `script` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `description` longtext NOT NULL,
  `date` datetime NOT NULL,
  `language` varchar(50) NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
