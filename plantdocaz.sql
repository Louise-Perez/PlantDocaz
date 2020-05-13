-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  mer. 13 mai 2020 à 21:28
-- Version du serveur :  5.7.26
-- Version de PHP :  7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `plantdocaz`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonces`
--

CREATE TABLE `annonces` (
  `id` int(11) NOT NULL,
  `nom_plante` varchar(255) NOT NULL,
  `description_annonce` text NOT NULL,
  `ville_annonce` varchar(255) NOT NULL,
  `date_ajout` datetime DEFAULT CURRENT_TIMESTAMP,
  `annonce_active` tinyint(1) NOT NULL,
  `id_membres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annonces`
--

INSERT INTO `annonces` (`id`, `nom_plante`, `description_annonce`, `ville_annonce`, `date_ajout`, `annonce_active`, `id_membres`) VALUES
(2, 'Pilea', 'Je tue toute les plantes qui entrent chez moi, adoptez celle là pour lui éviter un destin funèbre..', 'Nimes', '2020-03-23 11:03:32', 0, 2),
(3, 'Cactées', 'Qui manque de soleil', 'Montreal', '2020-03-23 11:03:32', 1, 3),
(5, 'Rosier', 'Il a plus de 15 ans, mais je déménage et je n\'ai pas d\'extérieur pour le mettre ', 'Aimargues', '2020-03-23 11:03:32', 1, 2),
(6, 'Cactus ', 'Moche ', 'Aigues-Mortes', '2020-03-23 11:03:32', 1, 4),
(7, 'Pommier', 'Infecté par un vers', 'Montpellier', '2020-03-23 11:05:57', 0, 2),
(10, 'Hibiscus', 'Offert par mon ex, je ne veux plus le voir ', 'Beaulieu', '2020-03-31 14:10:30', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `nom_membres` varchar(255) NOT NULL,
  `prenom_membres` varchar(255) NOT NULL,
  `pseudo_membres` varchar(255) NOT NULL,
  `mail_membres` varchar(255) NOT NULL,
  `code_postal_membres` int(11) NOT NULL,
  `ville_membres` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `nom_membres`, `prenom_membres`, `pseudo_membres`, `mail_membres`, `code_postal_membres`, `ville_membres`, `mdp`) VALUES
(2, 'Perez', 'Louise', 'Lou', 'louise@gmail.com', 0, 'Montcalm', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(3, 'Delmas', 'Ludovic', 'Ludodu34', 'ludo@gmail.com', 0, 'Montpellier', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(4, 'Pineau', 'Aurélien', 'Pino', 'pino@gmail.com', 0, 'Aigues-Mortes', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(5, 'Green', 'Eva', 'Eva', 'eva@gmail.com', 0, 'Montpellier', '40bd001563085fc35165329ea1ff5c5ecbdbbeef'),
(7, 'Cariou', 'Yann', 'CarYan', 'yann@gmail.com', 34160, ' Beaulieu ', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_membres` (`id_membres`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonces`
--
ALTER TABLE `annonces`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonces`
--
ALTER TABLE `annonces`
  ADD CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`id_membres`) REFERENCES `membres` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
