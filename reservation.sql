-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 01 mai 2022 à 21:02
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `reservation`
--

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `ligne` int(11) NOT NULL AUTO_INCREMENT,
  `idR` text NOT NULL,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `date_naissance` text NOT NULL,
  `age_jour_visite` text NOT NULL,
  `mail` text NOT NULL,
  `tel` text NOT NULL,
  `adresse` text NOT NULL,
  `pays` text NOT NULL,
  `billet` text NOT NULL,
  `date_reservation` text NOT NULL,
  `date_visite` text NOT NULL,
  `prix` text NOT NULL,
  PRIMARY KEY (`ligne`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`ligne`, `idR`, `nom`, `prenom`, `date_naissance`, `age_jour_visite`, `mail`, `tel`, `adresse`, `pays`, `billet`, `date_reservation`, `date_visite`, `prix`) VALUES
(5, 'adupont08-05-2022', 'DUPONT', 'Antoine', '07-08-2002', '19', 'adupon@sfr.fr', '0102030405', '90 Rue de Tolbiac 75013 PARIS', 'FR', 'G2', '01-05-2022', '08-05-2022', '00,00€');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
