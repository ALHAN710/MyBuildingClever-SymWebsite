-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mer. 30 déc. 2020 à 00:25
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mybuildingclever`
--

-- --------------------------------------------------------

--
-- Structure de la table `data_mod`
--

DROP TABLE IF EXISTS `data_mod`;
CREATE TABLE IF NOT EXISTS `data_mod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `smartmod_id` int(11) NOT NULL,
  `pmax` double DEFAULT NULL,
  `pmoy` double DEFAULT NULL,
  `qmax` double DEFAULT NULL,
  `qmoy` double DEFAULT NULL,
  `smax` double DEFAULT NULL,
  `smoy` double DEFAULT NULL,
  `cosmin` double DEFAULT NULL,
  `cosmn` double DEFAULT NULL,
  `vmin` double DEFAULT NULL,
  `vmax` double DEFAULT NULL,
  `vmoy` double DEFAULT NULL,
  `ea` double DEFAULT NULL,
  `er` double DEFAULT NULL,
  `eaindex` double DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5378B2FD17587D82` (`smartmod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `devices`
--

DROP TABLE IF EXISTS `devices`;
CREATE TABLE IF NOT EXISTS `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alerte` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `streaming_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notification_message` longtext COLLATE utf8mb4_unicode_ci,
  `connection_state` tinyint(1) DEFAULT NULL,
  `activation` tinyint(1) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ipaddress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `appliancespec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `programming` json DEFAULT NULL,
  `smartmeterspec` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `devices`
--

INSERT INTO `devices` (`id`, `name`, `type`, `alerte`, `module_id`, `streaming_url`, `notification_message`, `connection_state`, `activation`, `slug`, `ipaddress`, `appliancespec`, `programming`, `smartmeterspec`) VALUES
(1, 'Jardin', 'Camera', NULL, '22114224', 'https://pichon.net/eum-consequatur-qui-fuga-ducimus.html', 'Alerte Intrusion dans Jardin', NULL, NULL, 'jardin', NULL, NULL, NULL, NULL),
(2, 'Boutique Bali', 'Camera', NULL, '84708549', 'http://marty.fr/ex-minus-reiciendis-animi-sit', 'Alerte Intrusion dans Boutique Bali', NULL, NULL, 'boutique-bali', NULL, NULL, NULL, NULL),
(3, 'Garage', 'Alarm', NULL, '78623806', NULL, NULL, NULL, NULL, 'garage', NULL, NULL, NULL, NULL),
(4, 'Jardin', 'Alarm', NULL, '60288263', NULL, NULL, NULL, NULL, 'jardin', NULL, NULL, NULL, NULL),
(5, 'Garage', 'Emergency', NULL, '66065513', NULL, NULL, NULL, NULL, 'garage', NULL, NULL, NULL, NULL),
(6, 'Garage', 'Emergency', NULL, '81367917', NULL, NULL, NULL, NULL, 'garage', NULL, NULL, NULL, NULL),
(7, 'Boutique Bali', 'Sensor', 'Intrusion', '24530723', NULL, 'Alerte Intrusion dans la pièce suivante : Boutique Bali', NULL, 0, 'boutique-bali', NULL, NULL, NULL, NULL),
(8, 'Jardin', 'Sensor', 'Intrusion', '67238256', NULL, 'Alerte Intrusion dans la pièce suivante : Jardin', NULL, 1, 'jardin', NULL, NULL, NULL, NULL),
(9, 'Magasin', 'Sensor', 'Fire', '59843136', NULL, 'URGENT URGENT URGENT !!!\r\nAlerte Incendie dans la pièce suivante : Magasin', NULL, 0, 'magasin', NULL, NULL, NULL, NULL),
(10, 'Salon', 'Sensor', 'Fire', '82175717', NULL, 'URGENT URGENT URGENT !!!\r\nAlerte Incendie dans la pièce suivante : Salon', NULL, 1, 'salon', NULL, NULL, NULL, NULL),
(11, 'Boutique Bali', 'Sensor', 'Flood', '26532028', NULL, 'URGENT URGENT URGENT !!!\r\nAlerte Inondation dans la pièce suivante : Boutique Bali', NULL, 0, 'boutique-bali', NULL, NULL, NULL, NULL),
(12, 'Jardin', 'Sensor', 'Flood', '55563229', NULL, 'URGENT URGENT URGENT !!!\r\nAlerte Inondation dans la pièce suivante : Jardin', NULL, 1, 'jardin', NULL, NULL, NULL, NULL),
(13, 'Magasin', 'Sensor', 'Opening', '20722540', NULL, 'URGENT URGENT URGENT !!!\\nAlerte Effraction de l\'ouverture suivante : Magasin', NULL, 0, 'magasin', NULL, NULL, NULL, NULL),
(14, 'Cuisine', 'Sensor', 'Opening', '42101571', NULL, 'URGENT URGENT URGENT !!!\\nAlerte Effraction de l\'ouverture suivante : Cuisine', NULL, 1, 'cuisine', NULL, NULL, NULL, NULL),
(15, 'Kitchen', 'Light', 'Intrusion', '2133363', NULL, NULL, NULL, NULL, 'kitchen', NULL, 'Interior', '{\"0\": {\"Td\": 5, \"To\": [17, 58], \"WF\": [17, 57], \"Mod\": 1, \"Auto\": 1}, \"1\": {\"Td\": 5, \"To\": [22, 30], \"WF\": [18, 0], \"Mod\": 1, \"Auto\": 1}, \"2\": {\"Td\": 1, \"To\": [20, 47], \"WF\": [19, 40], \"Mod\": 1, \"Auto\": 1}, \"3\": {\"Td\": 20, \"To\": [23, 30], \"WF\": [18, 0], \"Mod\": 1, \"Auto\": 0}, \"4\": {\"Td\": 0, \"To\": [-1, -1], \"WF\": [-1, -1], \"Mod\": 0, \"Auto\": 0}, \"5\": {\"Td\": 0, \"To\": [-1, -1], \"WF\": [-1, -1], \"Mod\": 0, \"Auto\": 0}, \"6\": {\"Td\": 0, \"To\": [-1, -1], \"WF\": [-1, -1], \"Mod\": 0, \"Auto\": 1}, \"outName\": \"Kitchen\"}', NULL),
(16, 'Dining room', 'Light', NULL, '2', NULL, NULL, NULL, NULL, 'dining-room', NULL, 'Interior', NULL, NULL),
(17, 'Living room', 'Light', 'Intrusion', '3', NULL, NULL, NULL, NULL, 'living-room', NULL, 'Interior', '{\"0\": {\"Td\": 0, \"To\": [-1, -1], \"WF\": [-1, -1], \"Mod\": 0, \"Auto\": 0}, \"1\": {\"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Mod\": 1, \"Auto\": 1}, \"2\": {\"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Mod\": 1, \"Auto\": 1}, \"3\": {\"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Mod\": 1, \"Auto\": 1}, \"4\": {\"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Mod\": 1, \"Auto\": 1}, \"5\": {\"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Mod\": 1, \"Auto\": 1}, \"6\": {\"Td\": 60, \"To\": [16, 30], \"WF\": [9, 0], \"Mod\": 1, \"Auto\": 1}, \"outName\": \"Living room\"}', NULL),
(18, 'Bedroom', 'Light', NULL, '4', NULL, NULL, NULL, NULL, 'bedroom', NULL, 'Interior', NULL, NULL),
(19, 'Bathroom', 'Light', NULL, '5', NULL, NULL, NULL, NULL, 'bathroom', NULL, 'Interior', NULL, NULL),
(20, 'Front doors', 'Light', NULL, '6', NULL, NULL, NULL, NULL, 'front-doors', NULL, 'Exterior', NULL, NULL),
(21, 'Back doors', 'Light', 'Intrusion', '7', NULL, NULL, NULL, NULL, 'back-doors', NULL, 'Exterior', NULL, NULL),
(22, 'Pool', 'Light', NULL, '8', NULL, NULL, NULL, NULL, 'pool', NULL, 'Exterior', NULL, NULL),
(23, 'Garage', 'Light', NULL, '9', NULL, NULL, NULL, NULL, 'garage', NULL, 'Exterior', NULL, NULL),
(24, 'Wash Machine', 'Appliance', NULL, '10', NULL, NULL, NULL, NULL, 'wash-machine', NULL, 'Wash Machine', '[]', NULL),
(25, 'Fridge', 'Appliance', NULL, '11', NULL, NULL, NULL, NULL, 'fridge', NULL, 'Fridge', '[]', NULL),
(26, 'TV', 'Appliance', NULL, '12', NULL, NULL, NULL, NULL, 'tv', NULL, 'Tv', '[]', NULL),
(27, 'Fridge', 'Smart Meter', NULL, '13', NULL, NULL, NULL, NULL, 'fridge', NULL, NULL, '[]', 'Socket'),
(28, 'ENEO', 'Smart Meter', NULL, '14', NULL, NULL, NULL, NULL, 'eneo', NULL, NULL, '[]', 'Home'),
(29, 'Living room', 'Climate', NULL, '3135571', NULL, NULL, NULL, NULL, 'living-room', NULL, 'Clim', '{\"0\": {\"BF\": [-1, -1], \"Td\": 0, \"To\": [-1, -1], \"WF\": [-1, -1], \"Bto\": [-1, -1], \"Mod\": 0, \"Auto\": 0, \"BTMod\": 0}, \"1\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Bto\": [14, 25], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"2\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Bto\": [14, 25], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"3\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Bto\": [14, 25], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"4\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Bto\": [14, 25], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"5\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [8, 0], \"Bto\": [14, 25], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"6\": {\"BF\": [12, 25], \"Td\": 60, \"To\": [17, 30], \"WF\": [9, 0], \"Bto\": [15, 45], \"Mod\": 1, \"Auto\": 1, \"BTMod\": 1}, \"TON\": 30, \"RegF\": 1, \"TOFF\": 10, \"ProgF\": 1, \"BreakF\": 1, \"outName\": \"Living room\"}', NULL),
(30, 'Bedroom', 'Climate', NULL, '16', NULL, NULL, NULL, NULL, 'bedroom', NULL, 'Clim', '[]', NULL),
(31, 'Kitchen', 'Climate', NULL, '17', NULL, NULL, NULL, NULL, 'kitchen', NULL, 'Clim', '[]', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200501051638', '2020-08-06 22:17:49'),
('20200501055650', '2020-08-06 22:17:54'),
('20200501143522', '2020-08-06 22:17:56'),
('20200502221558', '2020-08-06 22:17:56'),
('20200503093336', '2020-08-06 22:17:56'),
('20200504165549', '2020-08-06 22:17:57'),
('20200810035745', '2020-08-10 03:59:40'),
('20200826021352', '2020-08-26 02:14:46'),
('20200908105817', '2020-09-08 10:59:42'),
('20200908131734', '2020-09-08 13:18:04'),
('20200908191833', '2020-09-08 19:19:09');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`id`, `titre`) VALUES
(1, 'ROLE_SUPER_ADMIN'),
(2, 'ROLE_ADMIN');

-- --------------------------------------------------------

--
-- Structure de la table `role_user`
--

DROP TABLE IF EXISTS `role_user`;
CREATE TABLE IF NOT EXISTS `role_user` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `IDX_332CA4DDD60322AC` (`role_id`),
  KEY `IDX_332CA4DDA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `role_user`
--

INSERT INTO `role_user` (`role_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(2, 3);

-- --------------------------------------------------------

--
-- Structure de la table `security_system`
--

DROP TABLE IF EXISTS `security_system`;
CREATE TABLE IF NOT EXISTS `security_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activation` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `security_system`
--

INSERT INTO `security_system` (`id`, `activation`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verified` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `avatar`, `hash`, `phone_number`, `country_code`, `verification_code`, `verified`, `created_at`) VALUES
(1, 'Pascal', 'ALHADOUM', 'alhadoumpascal@gmail.com', NULL, '$2y$13$p0YQbng7kcYZEwSz0jfDseGhinENt2xHxyDDFvMi72c/qhEwGRY1C', '690442311', '+237', NULL, 1, '2020-08-06 23:34:05'),
(2, 'Cabrel', 'MBAKAM', 'cabrelmbakam@gmail.com', NULL, '$2y$13$yMC9nbSHQ/6N1XFgWBTosuAQWcT6/VgY2B9HOgJE0CBjXIUbH9xTe', '690304593', '+237', NULL, 1, '2020-08-06 23:34:07'),
(3, 'Naomi', 'DINAMONA', 'dinamonanaomi@gmail.com', NULL, '$2y$13$isR3pHZ1dJu.ceilEIzNZ.7asKA1xwS3DiMkdIwWtHDyPZE8y50Gi', '654289625', '+237', NULL, 1, '2020-08-06 23:34:09'),
(4, 'David', 'Levy', 'stephanie98@andre.fr', NULL, '$2y$13$qx46ofd.8N9nE4mAoo9QP.6zYH5Or.gmzHdGhVlesJC9pP2s0Yc.q', '08 99 61 53 10', '+237', NULL, 1, '2020-08-06 23:34:12'),
(5, 'Alfred', 'Pereira', 'bonnin.francois@pascal.com', NULL, '$2y$13$cGKjpy5jIpP0oNdPV8iVB.gd4euSi78cgTQ98T88o6x5U9dhWa672', '1 21 01 89 28', '+237', NULL, 1, '2020-08-06 23:34:14'),
(6, 'Jean', 'Lambert', 'lemaitre.christine@morel.fr', NULL, '$2y$13$Rf6YundWvaCzaTEwXVkJaOTz37Q4/p47OL9YCjQ0A.xroUidLJnDW', '0574225399', '+237', NULL, 1, '2020-08-06 23:34:16');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `data_mod`
--
ALTER TABLE `data_mod`
  ADD CONSTRAINT `FK_5378B2FD17587D82` FOREIGN KEY (`smartmod_id`) REFERENCES `devices` (`id`);

--
-- Contraintes pour la table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `FK_332CA4DDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_332CA4DDD60322AC` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
