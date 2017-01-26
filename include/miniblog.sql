-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Mer 25 Janvier 2017 à 22:13
-- Version du serveur :  5.7.17-0ubuntu0.16.04.1
-- Version de PHP :  7.0.13-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `miniblog`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `admin`
--

INSERT INTO `admin` (`id`, `login`, `email`, `password`) VALUES
(1, 'admin', 'admin@email.truc', '‹mêÔH6S');

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE `billets` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL,
  `id_auteur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `billets`
--

INSERT INTO `billets` (`id`, `titre`, `contenu`, `date_creation`, `id_auteur`) VALUES
(1, 'Recette du veloutÃ© d\'endives', 'Temps de prÃ©paration : 15 minutes\r\nTemps de cuisson : 20 minutes\r\n\r\nIngrÃ©dients (pour 6 personnes) :\r\n- 2 kg d\'endives\r\n- 750 g de pommes de terre\r\n- 60 g de beurre\r\n- 2 cubes de bouillon de volaille\r\n- crÃ¨me liquide \r\n- quelques pluches de cerfeuil\r\n- sel, poivre\r\n\r\nPrÃ©paration de la recette :\r\n\r\nEbouillantez les endives pour enlever l\'amertume.\r\nFaites-les revenir en petits morceaux dans le beurre et ajoutez les pommes de terre en petits cubes.\r\nCouvrez le tout avec 2 litres d\'eau et incorporez les cubes de bouillon.\r\nLaissez cuire 20-30 minutes, mixez, rectifiez l\'assaisonnement en sel et poivre puis ajoutez plus ou moins de crÃ¨me selon le goÃ»t.\r\nAu moment de servir parsemez de pluches de cerfeuil.', '2017-01-14 14:28:04', 1),
(4, 'Un nouvel article', 'Oui bon ok c\'est moins impressionnant qu\'\r\nÂ«Un nouvel espoirÂ» mais c\'est dÃ©jÃ  pas mal !', '2017-01-16 19:03:05', 7),
(5, 'La revanche du blog', 'Bon ok Star Wars c\'est bien donc voici un petit jeu sympathique si vous vous sentez l\'Ã¢me rebelle et que vous aimez la course au HIGH SCORE ;)\r\n\r\nhttp://work.goodboydigital.com/starwars/fighter/?arcade=true\r\n\r\n', '2017-01-16 19:37:36', 8);

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE `commentaires` (
  `id` int(11) NOT NULL,
  `id_billet` int(11) NOT NULL,
  `afficher` tinyint(1) NOT NULL,
  `id_auteur` int(11) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`id`, `id_billet`, `afficher`, `id_auteur`, `pseudo`, `contenu`, `date_creation`) VALUES
(1, 1, 1, 1, 'jordan', 'Ã‡a donne faim !', '2017-01-14 14:35:21'),
(5, 1, 1, 5, 'Canou', 'Hum oh oui oui oui ', '2017-01-14 17:09:01');

-- --------------------------------------------------------

--
-- Structure de la table `parametres`
--

CREATE TABLE `parametres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `valeur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `parametres`
--

INSERT INTO `parametres` (`id`, `nom`, `valeur`) VALUES
(1, 'modeValidationCommentaires', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `email`) VALUES
(1, 'Jordan', 'j.brito@nagaelya.org'),
(2, 'invité', 'NULL'),
(5, 'Canou', 'c_laurendon@orange.fr'),
(8, 'admin', 'admin@email.truc');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parametres`
--
ALTER TABLE `parametres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `commentaires`
--
ALTER TABLE `commentaires`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `parametres`
--
ALTER TABLE `parametres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
