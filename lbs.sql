-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 10 Janvier 2017 à 15:44
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lbs`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(64) DEFAULT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `description`) VALUES
(1, 'salades', 'Nos bonnes salades, fraichement livrées par nos producteurs bios et locaux'),
(2, 'crudités', 'Nos crudités variées  et préparées avec soin, issues de producteurs locaux et bio pour la plupart.'),
(3, 'viandes', 'Nos viandes finement découpées et cuites comme vous le préférez. Viande issue délevages certifiés et locaux.'),
(4, 'Fromages', 'Nos fromages bios et au lait cru. En majorité des AOC.'),
(5, 'Sauces', 'Toutes les sauces du monde !');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `montant` float NOT NULL,
  `dateretrait` date DEFAULT NULL,
  `etat` int(11) DEFAULT NULL,
  `token` varchar(500) DEFAULT NULL,
  `montant` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commande`
--

INSERT INTO `commande` (`id`, `montant`, `dateretrait`, `etat`) VALUES
(1, 0, '2017-01-04', 1);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id_sandwich` int(11) NOT NULL,
  `id_ingredient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `nom` varchar(64) DEFAULT NULL,
  `cat_id` int(11) NOT NULL,
  `description` text,
  `fournisseur` varchar(128) DEFAULT NULL,
  `img` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ingredient`
--

INSERT INTO `ingredient` (`id`, `nom`, `cat_id`, `description`, `fournisseur`, `img`) VALUES
(1, 'laitue', 1, 'belle laitue verte', 'ferme "la bonne salade"', NULL),
(2, 'roquette', 1, 'la roquette qui pète ! bio, bien sur, et sauvage', 'ferme "la bonne salade"', NULL),
(3, 'mâche', 1, 'une mâche toute jeune et croquante', 'ferme "la bonne salade"', NULL),
(4, 'carottes', 2, 'belles carottes bio, rapées avec amour', 'au jardin sauvage', NULL),
(5, 'concombre', 2, 'concombre de jardin, bio et bien frais', 'au jardin sauvage', NULL),
(6, 'avocat', 2, 'avocats en direct du Mexique !', 'la huerta bonita, Puebla', NULL),
(7, 'blanc de poulet', 3, 'blanc de poulet émincé, et grillé comme il faut', 'élevage "le poulet volant"', NULL),
(8, 'magret de canard', 3, 'magret de canard grillé, puis émincé', 'le colvert malin', NULL),
(9, 'steack haché', 3, 'notre steack haché saveur, 5% MG., préparé juste avant cuisson.\nViande de notre producteur local.', 'ferme "la vache qui plane"', NULL),
(10, 'munster', 4, 'Du munster de Munster, en direct. Pour amateurs avertis !', 'fromagerie "le bon munster de toujours"', NULL),
(11, 'chèvre frais', 4, 'un chèvre frais onctueux et goutu !', 'A la chèvre rieuse', NULL),
(12, 'comté AOC 18mois', 4, 'le meilleur comté du monde !', 'fromagerie du jura', NULL),
(13, 'vinaigrette huile d\'olive', 5, 'la vinaigrette éternelle, à l\'huile d\'olive et moutarde à l\'ancienne.', 'Le Bon Sandwich', NULL),
(14, 'salsa jalapeña', 5, 'sauce très légérement pimentée :-)', 'El Yucateco', NULL),
(15, 'salsa habanera', 5, 'Pour initiés uniquement, dangereux sinon !', 'EL yucateco', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `sandwich`
--

CREATE TABLE `sandwich` (
  `id` int(11) NOT NULL,
  `taillepain` int(11) DEFAULT NULL,
  `typepain` int(11) DEFAULT NULL,
  `id_commande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`id_sandwich`,`id_ingredient`),
  ADD KEY `FK_contenir_id_ingredient` (`id_ingredient`),
  ADD KEY `id` (`id_sandwich`),
  ADD KEY `id_2` (`id_sandwich`);

--
-- Index pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ingredient_cat_id` (`cat_id`);

--
-- Index pour la table `sandwich`
--
ALTER TABLE `sandwich`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_sandwich_id_commande` (`id_commande`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT pour la table `sandwich`
--
ALTER TABLE `sandwich`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `FK_contenir_id` FOREIGN KEY (`id_sandwich`) REFERENCES `sandwich` (`id`),
  ADD CONSTRAINT `FK_contenir_id_ingredient` FOREIGN KEY (`id_ingredient`) REFERENCES `ingredient` (`id`);

--
-- Contraintes pour la table `ingredient`
--
ALTER TABLE `ingredient`
  ADD CONSTRAINT `FK_ingredient_cat_id` FOREIGN KEY (`cat_id`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `sandwich`
--
ALTER TABLE `sandwich`
  ADD CONSTRAINT `FK_sandwich_id_commande` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
