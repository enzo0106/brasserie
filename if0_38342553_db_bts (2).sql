-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : sql211.infinityfree.com
-- Généré le :  jeu. 17 avr. 2025 à 05:27
-- Version du serveur :  10.6.19-MariaDB
-- Version de PHP :  7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `if0_38342553_db_bts`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_commande` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `statut` enum('en attente','validée','expédiée','livrée') DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `client_id`, `date_commande`, `total`, `statut`) VALUES
(1, 18, '2025-04-16 14:03:40', '15.80', 'en attente'),
(2, 21, '2025-04-17 09:04:23', '5.20', 'en attente'),
(3, 21, '2025-04-17 09:12:00', '5.20', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produits`
--

CREATE TABLE `commande_produits` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `commande_id`, `produit_id`, `quantite`) VALUES
(1, 3, 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

CREATE TABLE `detail_commande` (
  `id` int(11) NOT NULL,
  `commande_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `finances`
--

CREATE TABLE `finances` (
  `id` int(11) NOT NULL,
  `type` enum('recette','dépense') NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `date_finance` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `matieres_premieres`
--

CREATE TABLE `matieres_premieres` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `unite` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `date_ajout` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `description`, `prix`, `stock`) VALUES
(2, 'La Nulos', NULL, '1.30', 62),
(3, 'La Divinouze', NULL, '1.50', 72),
(4, 'L\'Expulsion', NULL, '1.80', 100),
(5, 'La Sans-Abris', NULL, '1.40', 90),
(6, 'La Comatose', NULL, '2.10', 91),
(7, 'La Déchéance', NULL, '1.90', 82),
(8, 'Pack Découverte', NULL, '7.50', 29),
(9, 'L\'Expulsion', NULL, '15.90', 84);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('admin','direction','brasseur','caissier','client') NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `date_creation`) VALUES
(1, 'dujardin', 'jean', 'test@gmail.com', '$2y$10$sYZeVcUk345S8eGdma.VgerBR.qeYOlejZ8mF2hnKhtIH6xWGuRIu', 'admin', '2025-03-10 21:32:22'),
(2, 'fifi', 'fafa', 'fifi@gmail.com', '1234', 'caissier', '2025-03-25 15:46:44'),
(7, 'gigi', 'rouroux', '1@ruru', '', 'caissier', '2025-03-25 19:08:08'),
(8, 'alkapote', 'alk', 'alk@pote.gg', '', 'client', '2025-03-26 08:32:50'),
(6, 'akliouch', 'jeremy', '1@1.1', '', 'client', '2025-03-25 19:07:22'),
(9, 'gougou', 'gaga', 'gagu@gaga', '', 'caissier', '2025-03-26 08:42:03'),
(11, 'fefe', 'rouroux', 'test@test', '', 'admin', '2025-04-10 07:09:24'),
(12, 'jamm', 'jymm', 'jymm@gmail.com', '$2y$10$bMe7Uv26cC4M7LW0bi40BuDJJLVf6.Z8mJPfxSzdlWwAKlpjaSvuC', 'admin', '2025-04-10 07:38:29'),
(13, 'hh', 'hh', 'uuuu@mail.com', '$2y$10$69uNc01lkpB9lJaLIfVv9u9uXEnwr.r3wna5FkleF.rC7Zxu1FFBS', 'client', '2025-04-14 16:45:25'),
(14, 'aa', 'aa', 'uuu@mail.com', '$2y$10$w33t85y3SXvdcsSwHCrT0eC3a004vL7FpkQ1etVm72R/Aw07ULaAO', 'client', '2025-04-14 16:48:35'),
(15, 'a', 'a', 'uu@mail.com', '$2y$10$Wh5O983YKUvb7egoGerMc./ltR67QWPAOFp3WnciLuXGdOqdEiFoC', '', '2025-04-14 16:49:27'),
(16, 'zz', 'zz', 'teeeeest@gmail.com', '$2y$10$3huUPsj0oAvq7nzYbVYouO491luyEADtJ9ymcWHqkh1/weMVV6NOi', 'admin', '2025-04-15 11:38:22'),
(17, 'caissier', 'caissier', 'caissier@gmail.com', '$2y$10$rcsBGVua1jit7t3wSxeFZOP8Fvf8dV/NagvMNWtiaePi6cRVStDqG', 'caissier', '2025-04-16 13:18:11'),
(18, 'brasseur', 'brasseur', 'brasseur@gmail.com', '$2y$10$0hGQyphOCkoTzAKzauU6a.W0Dl8IcIL4685xU9qK8Ve67l0qpHTnq', 'brasseur', '2025-04-16 13:19:04'),
(19, 'deudon', 'clarisse', 'clarisse@gmail.com', '$2y$10$2NZouPcW9Xf9yqM2C658NeV37fA9OcQ0eq03fob/HiNZpQo9DqNeC', 'admin', '2025-04-16 13:33:00'),
(20, 'elias', 'bouz', 'elias@elias.com', '$2y$10$/8dE3U7JNhBdlzjYE1XYbus.VLDZXA/9dRE.iF95haW.DRU6njylu', 'brasseur', '2025-04-16 14:04:34'),
(21, 'cai', 'cai', 'cai@test.com', '$2y$10$pZQ8ivh08DRBf1XLS9umaud5E327vviXFJVk8AdgDL0bPY9TCgKyi', 'caissier', '2025-04-16 14:22:24'),
(22, 'client', 'client', 'client@gmail.com', '$2y$10$/luV6nRKdSJ9LLHQRrehE.hH1/4aGOcJdkau9NK9Jb8C4O8PhekPi', 'client', '2025-04-17 06:57:52'),
(23, 'fefe', 'enzo', '11@1.1', '$2y$10$vpyCczkSCvqRzHo8uFylVeofguUjJ9rKlnhG8sKnws2QZIOSoo/Cm', 'client', '2025-04-17 09:03:40'),
(24, 'gg', 'gg', 'gg@gg.gg', '$2y$10$Vdp0K9vch3dsK.uiMHTGAeibCHO.jj5j36oDudvwNPNpCZh8Q/yk.', 'direction', '2025-04-17 09:24:53');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(11) NOT NULL,
  `caissier_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `date_vente` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id`, `caissier_id`, `client_id`, `date_vente`, `total`) VALUES
(1, 17, 8, '2025-04-16 20:21:47', '0.00'),
(2, 17, 8, '2025-04-16 20:22:38', '0.00'),
(3, 17, 8, '2025-04-16 20:22:52', '47.60'),
(4, 17, 8, '2025-04-16 20:31:06', '0.00'),
(5, 17, 8, '2025-04-16 20:31:09', '0.00'),
(6, 17, 8, '2025-04-16 20:31:34', '47.60'),
(7, 17, 8, '2025-04-16 20:34:22', '47.60'),
(8, 17, 6, '2025-04-16 20:35:59', '6.50'),
(9, 17, 6, '2025-04-16 20:43:57', '6.50'),
(10, 17, 6, '2025-04-16 20:44:04', '0.00'),
(11, 17, 8, '2025-04-17 06:58:56', '16.80'),
(12, 17, 8, '2025-04-17 06:59:04', '16.80'),
(13, 17, 8, '2025-04-17 06:59:50', '16.80'),
(14, 17, 8, '2025-04-17 06:59:56', '16.80'),
(15, 17, 8, '2025-04-17 07:00:13', '16.80'),
(16, 17, 22, '2025-04-17 07:00:48', '151.80'),
(17, 17, 22, '2025-04-17 07:01:03', '151.80'),
(18, 17, 14, '2025-04-17 07:21:27', '315.00'),
(19, 17, 14, '2025-04-17 07:21:31', '0.00'),
(20, 17, 6, '2025-04-17 07:25:21', '87.00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `commande_id` (`commande_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `finances`
--
ALTER TABLE `finances`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `matieres_premieres`
--
ALTER TABLE `matieres_premieres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `caissier_id` (`caissier_id`),
  ADD KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `detail_commande`
--
ALTER TABLE `detail_commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `finances`
--
ALTER TABLE `finances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `matieres_premieres`
--
ALTER TABLE `matieres_premieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `fk_commande` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produit` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
