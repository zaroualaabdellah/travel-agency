-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 23 juin 2025 à 14:06
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbtravel`
--

-- --------------------------------------------------------

--
-- Structure de la table `autocar`
--

CREATE TABLE `autocar` (
  `id_autocar` int(11) NOT NULL,
  `immatriculation` varchar(50) DEFAULT NULL,
  `id_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `autocar`
--

INSERT INTO `autocar` (`id_autocar`, `immatriculation`, `id_type`) VALUES
(1, '12233-A-10', 1);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `genre` char(1) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `id_ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `prenom`, `genre`, `adresse`, `id_ville`) VALUES
(1, 'zarouala', 'abdellah', 'M', '23, avenue An Nasr – Rabat', 1);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id_dep` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `id_region` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_dep`, `nom`, `code`, `id_region`) VALUES
(1, 'Dep1', '10.111.111', 1),
(2, 'Dept2', '1002.369.8', 2);

-- --------------------------------------------------------

--
-- Structure de la table `emplacement`
--

CREATE TABLE `emplacement` (
  `id_emplacement` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `id_autocar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emplacement`
--

INSERT INTO `emplacement` (`id_emplacement`, `numero`, `id_autocar`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `hotel`
--

CREATE TABLE `hotel` (
  `id_hotel` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `adresse` varchar(200) DEFAULT NULL,
  `id_ville` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `hotel`
--

INSERT INTO `hotel` (`id_hotel`, `nom`, `adresse`, `id_ville`) VALUES
(1, 'Ibis', 'rabat', 1);

-- --------------------------------------------------------

--
-- Structure de la table `passager`
--

CREATE TABLE `passager` (
  `id_passager` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `id_reservation` int(11) NOT NULL,
  `id_emplacement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `passager`
--

INSERT INTO `passager` (`id_passager`, `nom`, `prenom`, `telephone`, `id_reservation`, `id_emplacement`) VALUES
(2, 'zarouala', 'abdellah', '0695116738', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id_pays` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id_pays`, `nom`) VALUES
(1, 'Maroc'),
(2, 'France');

-- --------------------------------------------------------

--
-- Structure de la table `pointdepart`
--

CREATE TABLE `pointdepart` (
  `id_point_depart` int(11) NOT NULL,
  `lieu` varchar(100) DEFAULT NULL,
  `id_ville` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `pointdepart`
--

INSERT INTO `pointdepart` (`id_point_depart`, `lieu`, `id_ville`) VALUES
(1, 'Rue Koweit', 1);

-- --------------------------------------------------------

--
-- Structure de la table `programmation`
--

CREATE TABLE `programmation` (
  `id_programmation` int(11) NOT NULL,
  `date_depart` date DEFAULT NULL,
  `date_retour` date DEFAULT NULL,
  `prix_base` decimal(10,2) DEFAULT NULL,
  `id_voyage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `programmation_autocar`
--

CREATE TABLE `programmation_autocar` (
  `id_programmation` int(11) NOT NULL,
  `id_autocar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `programmation_pointdepart`
--

CREATE TABLE `programmation_pointdepart` (
  `id_programmation` int(11) NOT NULL,
  `id_point_depart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

CREATE TABLE `region` (
  `id_region` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `id_pays` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id_region`, `nom`, `id_pays`) VALUES
(1, 'Rabat', 1),
(2, 'Paris', 2);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id_reservation` int(11) NOT NULL,
  `date_reservation` date DEFAULT NULL,
  `assurance_annulation` tinyint(1) DEFAULT NULL,
  `chambre_supplementaire` tinyint(1) DEFAULT NULL,
  `id_client` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id_reservation`, `date_reservation`, `assurance_annulation`, `chambre_supplementaire`, `id_client`) VALUES
(1, '2025-06-23', 1, 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `typeautocar`
--

CREATE TABLE `typeautocar` (
  `id_type` int(11) NOT NULL,
  `nom_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `typeautocar`
--

INSERT INTO `typeautocar` (`id_type`, `nom_type`, `description`) VALUES
(1, 'MiniBus', '');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `id_client` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'client',
  `actif` tinyint(1) DEFAULT 1,
  `date_creation` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `id_client`, `username`, `mot_de_passe`, `role`, `actif`, `date_creation`) VALUES
(1, 1, 'zaro', '$2y$10$/VNAB7d5mvGVgXdGILsT1.9y6GMnSREBRppIhkTY5hjXAPk9bcWh2', 'client', 1, '2025-06-23 10:29:17');

-- --------------------------------------------------------

--
-- Structure de la table `ville`
--

CREATE TABLE `ville` (
  `id_ville` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  `id_dep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ville`
--

INSERT INTO `ville` (`id_ville`, `nom`, `code_postal`, `id_dep`) VALUES
(1, 'Rabat', '27200', 1),
(2, 'Casa', '27500', 1);

-- --------------------------------------------------------

--
-- Structure de la table `voyage`
--

CREATE TABLE `voyage` (
  `id_voyage` int(11) NOT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  `type_voyage` varchar(50) DEFAULT NULL,
  `pension` varchar(20) DEFAULT NULL,
  `id_hotel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `autocar`
--
ALTER TABLE `autocar`
  ADD PRIMARY KEY (`id_autocar`),
  ADD KEY `id_type` (`id_type`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `id_ville` (`id_ville`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_dep`),
  ADD KEY `id_region` (`id_region`);

--
-- Index pour la table `emplacement`
--
ALTER TABLE `emplacement`
  ADD PRIMARY KEY (`id_emplacement`),
  ADD KEY `id_autocar` (`id_autocar`);

--
-- Index pour la table `hotel`
--
ALTER TABLE `hotel`
  ADD PRIMARY KEY (`id_hotel`),
  ADD KEY `id_ville` (`id_ville`);

--
-- Index pour la table `passager`
--
ALTER TABLE `passager`
  ADD PRIMARY KEY (`id_passager`),
  ADD KEY `id_reservation` (`id_reservation`),
  ADD KEY `id_emplacement` (`id_emplacement`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id_pays`);

--
-- Index pour la table `pointdepart`
--
ALTER TABLE `pointdepart`
  ADD PRIMARY KEY (`id_point_depart`),
  ADD KEY `id_ville` (`id_ville`);

--
-- Index pour la table `programmation`
--
ALTER TABLE `programmation`
  ADD PRIMARY KEY (`id_programmation`),
  ADD KEY `id_voyage` (`id_voyage`);

--
-- Index pour la table `programmation_autocar`
--
ALTER TABLE `programmation_autocar`
  ADD PRIMARY KEY (`id_programmation`,`id_autocar`),
  ADD KEY `id_autocar` (`id_autocar`);

--
-- Index pour la table `programmation_pointdepart`
--
ALTER TABLE `programmation_pointdepart`
  ADD PRIMARY KEY (`id_programmation`,`id_point_depart`),
  ADD KEY `id_point_depart` (`id_point_depart`);

--
-- Index pour la table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`id_region`),
  ADD KEY `id_pays` (`id_pays`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_client` (`id_client`);

--
-- Index pour la table `typeautocar`
--
ALTER TABLE `typeautocar`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `id_client` (`id_client`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `ville`
--
ALTER TABLE `ville`
  ADD PRIMARY KEY (`id_ville`),
  ADD KEY `id_dep` (`id_dep`);

--
-- Index pour la table `voyage`
--
ALTER TABLE `voyage`
  ADD PRIMARY KEY (`id_voyage`),
  ADD KEY `id_hotel` (`id_hotel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `autocar`
--
ALTER TABLE `autocar`
  MODIFY `id_autocar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_dep` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `emplacement`
--
ALTER TABLE `emplacement`
  MODIFY `id_emplacement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `hotel`
--
ALTER TABLE `hotel`
  MODIFY `id_hotel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `passager`
--
ALTER TABLE `passager`
  MODIFY `id_passager` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id_pays` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `pointdepart`
--
ALTER TABLE `pointdepart`
  MODIFY `id_point_depart` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `programmation`
--
ALTER TABLE `programmation`
  MODIFY `id_programmation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `region`
--
ALTER TABLE `region`
  MODIFY `id_region` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `typeautocar`
--
ALTER TABLE `typeautocar`
  MODIFY `id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `ville`
--
ALTER TABLE `ville`
  MODIFY `id_ville` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `voyage`
--
ALTER TABLE `voyage`
  MODIFY `id_voyage` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `autocar`
--
ALTER TABLE `autocar`
  ADD CONSTRAINT `autocar_ibfk_1` FOREIGN KEY (`id_type`) REFERENCES `typeautocar` (`id_type`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `departement`
--
ALTER TABLE `departement`
  ADD CONSTRAINT `departement_ibfk_1` FOREIGN KEY (`id_region`) REFERENCES `region` (`id_region`);

--
-- Contraintes pour la table `emplacement`
--
ALTER TABLE `emplacement`
  ADD CONSTRAINT `emplacement_ibfk_1` FOREIGN KEY (`id_autocar`) REFERENCES `autocar` (`id_autocar`);

--
-- Contraintes pour la table `hotel`
--
ALTER TABLE `hotel`
  ADD CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `passager`
--
ALTER TABLE `passager`
  ADD CONSTRAINT `passager_ibfk_1` FOREIGN KEY (`id_reservation`) REFERENCES `reservation` (`id_reservation`),
  ADD CONSTRAINT `passager_ibfk_2` FOREIGN KEY (`id_emplacement`) REFERENCES `emplacement` (`id_emplacement`);

--
-- Contraintes pour la table `pointdepart`
--
ALTER TABLE `pointdepart`
  ADD CONSTRAINT `pointdepart_ibfk_1` FOREIGN KEY (`id_ville`) REFERENCES `ville` (`id_ville`);

--
-- Contraintes pour la table `programmation`
--
ALTER TABLE `programmation`
  ADD CONSTRAINT `programmation_ibfk_1` FOREIGN KEY (`id_voyage`) REFERENCES `voyage` (`id_voyage`);

--
-- Contraintes pour la table `programmation_autocar`
--
ALTER TABLE `programmation_autocar`
  ADD CONSTRAINT `programmation_autocar_ibfk_1` FOREIGN KEY (`id_programmation`) REFERENCES `programmation` (`id_programmation`),
  ADD CONSTRAINT `programmation_autocar_ibfk_2` FOREIGN KEY (`id_autocar`) REFERENCES `autocar` (`id_autocar`);

--
-- Contraintes pour la table `programmation_pointdepart`
--
ALTER TABLE `programmation_pointdepart`
  ADD CONSTRAINT `programmation_pointdepart_ibfk_1` FOREIGN KEY (`id_programmation`) REFERENCES `programmation` (`id_programmation`),
  ADD CONSTRAINT `programmation_pointdepart_ibfk_2` FOREIGN KEY (`id_point_depart`) REFERENCES `pointdepart` (`id_point_depart`);

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `region_ibfk_1` FOREIGN KEY (`id_pays`) REFERENCES `pays` (`id_pays`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`);

--
-- Contraintes pour la table `ville`
--
ALTER TABLE `ville`
  ADD CONSTRAINT `ville_ibfk_1` FOREIGN KEY (`id_dep`) REFERENCES `departement` (`id_dep`);

--
-- Contraintes pour la table `voyage`
--
ALTER TABLE `voyage`
  ADD CONSTRAINT `voyage_ibfk_1` FOREIGN KEY (`id_hotel`) REFERENCES `hotel` (`id_hotel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
