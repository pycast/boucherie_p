-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 09 fév. 2022 à 19:42
-- Version du serveur :  8.0.28-0ubuntu0.20.04.3
-- Version de PHP : 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `laBoucherie`
--

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `illustration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) NOT NULL,
  `order_online_open` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `illustration`, `recipe`, `subtitle`, `visible`, `order_online_open`) VALUES
(3, 5, 'Pommes duchesses', 'pommes-duchesses', 'De délicieuses pommes duchesses pour accompagner tous vos plats.', 200, '4e9ed01dae8f7ac5cdeeeaea90cb211a9c30203f.jpg', NULL, 'préparées par nos soins', 1, 0),
(4, 6, 'Gambas méditérannéenne', 'gambas-mediteranneenne', 'Elles apporteront de la fraîcheur à votre menu. Gambas péchées près de nos côtes.', 395, 'ec20d42912ad1c72ff4bb1f0a256e43e89f4c52b.jpg', NULL, 'Parfait pour l\'apéritif', 1, 0),
(5, 8, 'Dinde blanche', 'dinde-blanche', 'Escalopes de dinde blanche, issues d\'élévage durable.', 1090, 'cfc69943b3dab52fc38cf44786c24690f142d26f.jpg', NULL, 'Qualité française', 1, 0),
(6, 8, 'Poulet', 'poulet', 'Poulet de Licques. 100% local', 920, '80a965498e07742e71943303e2249841cd0d8fb8.jpg', NULL, 'L\'incontournable du dimanche', 1, 0),
(7, 5, 'Moelleux Carottes', 'moelleux-carottes', 'Des carottes fondantes cuites à l\'étouffée, elles s\'accorderont parfaitement avec tous types de viandes.', 190, 'fe45a9cb8fcf734c51d4c8ff8f45d2f23604d1e4.jpg', NULL, 'À la manière de nos grands-mères', 1, 0),
(8, 11, 'Filet mignon préparé', 'filet-mignon-prepare', 'Vous apprécierez cette viande moelleuse à n\'importe quelle occasion. Provenance Savoie.', 790, '329bb87c1de722802f1b79d9e79c50a28bf721eb.jpg', NULL, 'Ravira petits et grands', 1, 0),
(9, 4, 'Saumon Bellevue', 'saumon-bellevue', 'L\'incontournable des repas de fêtes. Péché en mer, origine Norvège.', 360, '58cf36f32a829eafab4107f2fa6d6701ec3132c9.jpg', NULL, 'Qualité supérieure', 1, 0),
(10, 4, 'Escargots', 'escargots', 'Préparés par nos soins, beurre d\'ail français.', 695, '92fabb094dccee1e5d1f518800550d147d68494a.jpg', NULL, 'au beurre d\'ail', 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D34A04AD12469DE2` (`category_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
