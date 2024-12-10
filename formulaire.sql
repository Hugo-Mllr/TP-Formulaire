-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 09 déc. 2024 à 11:34
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `formulaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `compte_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mdp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nom` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`compte_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



-- --------------------------------------------------------

--
-- Structure de la table `contrats`
--

DROP TABLE IF EXISTS `contrats`;
CREATE TABLE IF NOT EXISTS `contrats` (
  `contrat_id` int NOT NULL AUTO_INCREMENT,
  `compte_id` int NOT NULL,
  `contrat_nature` varchar(255) NOT NULL,
  `contrat_name` varchar(255) NOT NULL,
  `contrat_adresse` varchar(255) NOT NULL,
  `contrat_date` date NOT NULL,
  `contrat_repartition` varchar(255) NOT NULL,
  `contrat_clause_duree` varchar(255) NOT NULL,
  `contrat_juridiction` varchar(255) NOT NULL,
  `contrat_lieu` varchar(255) NOT NULL,
  `contrat_nom_avocat` varchar(255) NOT NULL,
  `contrat_date_jour` varchar(10) NOT NULL,
  `contrat_nb_copie` int NOT NULL,
  `contrat_modal_banc` int DEFAULT NULL,
  PRIMARY KEY (`contrat_id`) USING BTREE,
  KEY `compte_id` (`compte_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


-- --------------------------------------------------------

--
-- Structure de la table `contrat_partenaires`
--

DROP TABLE IF EXISTS `contrat_partenaires`;
CREATE TABLE IF NOT EXISTS `contrat_partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contrat_id` int DEFAULT NULL,
  `partenaire_id` int DEFAULT NULL,
  `partenaire_contribution` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `partenaire_id` (`partenaire_id`),
  KEY `contrat_id` (`contrat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `contrat_partenaires`
--



-- --------------------------------------------------------

--
-- Structure de la table `partenaires`
--

DROP TABLE IF EXISTS `partenaires`;
CREATE TABLE IF NOT EXISTS `partenaires` (
  `partenaire_id` int NOT NULL AUTO_INCREMENT,
  `partenaire_nom` varchar(255) NOT NULL,
  `partenaire_prenom` varchar(255) NOT NULL,
  PRIMARY KEY (`partenaire_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `partenaires`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
