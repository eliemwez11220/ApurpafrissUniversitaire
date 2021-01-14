-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 29 juil. 2019 à 08:06
-- Version du serveur :  10.1.37-MariaDB
-- Version de PHP :  7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `ci_apurpafriss_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `annee_academ`
--

CREATE TABLE `annee_academ` (
  `id` int(11) NOT NULL,
  `annee` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `annee_academ`
--

INSERT INTO `annee_academ` (`id`, `annee`) VALUES
(1, '2019-2020');

-- --------------------------------------------------------

--
-- Structure de la table `comptes`
--

CREATE TABLE `comptes` (
  `id` int(11) NOT NULL,
  `num_compte` varchar(30) NOT NULL,
  `solde_courant` float DEFAULT NULL,
  `total_entree` float DEFAULT NULL,
  `total_sortie` float DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes`
--

INSERT INTO `comptes` (`id`, `num_compte`, `solde_courant`, `total_entree`, `total_sortie`, `devise`) VALUES
(3, '01030116002-30', 55000, 60000, 5000, 'CDF'),
(4, '011030026003-31', 632.5, 675, 42.5, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `id` int(11) NOT NULL,
  `mat_et` varchar(10) NOT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `postnom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `genre` varchar(10) DEFAULT NULL,
  `date_naiss` date DEFAULT NULL,
  `lieu_naiss` varchar(50) DEFAULT NULL,
  `telephone` varchar(13) DEFAULT NULL,
  `adresse` text,
  `statut` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `mat_et`, `nom`, `postnom`, `prenom`, `genre`, `date_naiss`, `lieu_naiss`, `telephone`, `adresse`, `statut`) VALUES
(5, 'EW6475875', 'Mwez', 'Rubuz', 'Elie', 'masculin', '2001-04-13', 'lushi', '0987686876', 'kilobelobe', 'online'),
(6, 'EG983117-', 'Mwange', 'Mulashi', 'Trinith', 'feminin', '1994-07-10', 'Likasi', '0999800110', '33, kisangani, dilolo', NULL),
(7, 'EL756959', 'KOKO', 'LOLO', 'POPO', 'feminin', '2001-07-12', 'LIKASI', '0977090011', 'KATUBA', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `fixations`
--

CREATE TABLE `fixations` (
  `id` int(11) NOT NULL,
  `type_frais` varchar(50) NOT NULL,
  `montant_fixe` float NOT NULL,
  `devise` varchar(30) DEFAULT NULL,
  `id_promotion` int(11) NOT NULL,
  `delai` date DEFAULT NULL,
  `annee` varchar(10) NOT NULL,
  `taux_change` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `fixations`
--

INSERT INTO `fixations` (`id`, `type_frais`, `montant_fixe`, `devise`, `id_promotion`, `delai`, `annee`, `taux_change`) VALUES
(10, 'Attestation de fréquentation', 30000, 'CDF', 1, '2019-07-23', '2019-2020', 1600),
(11, 'Entérinement diplôme', 75, 'USD', 10, '2019-07-23', '2019-2020', 1600),
(12, 'Stage', 30, 'USD', 13, '2019-07-23', '2019-2020', 1600),
(13, 'Minerval', 330, 'USD', 4, '2019-07-23', '2019-2020', 1600),
(14, 'Rélévé de côtes', 15, 'USD', 10, '2019-07-23', '2019-2020', 1600),
(15, 'Minerval', 330, 'USD', 3, '2019-07-23', '2019-2020', 1600),
(16, 'Minerval', 300, 'USD', 6, '2019-07-23', '2019-2020', 1600),
(17, 'Minerval', 330, 'USD', 2, '2019-07-23', '2019-2020', 1600),
(18, 'Attestation de fréquentation', 15, 'USD', 2, '2019-07-23', '2019-2020', 1600),
(19, 'Fiche de recherche', 20000, 'CDF', 1, '2019-07-23', '2019-2020', 1600),
(20, 'Stage', 30, 'USD', 6, '2019-08-01', '2019-2020', 1600);

-- --------------------------------------------------------

--
-- Structure de la table `identifications`
--

CREATE TABLE `identifications` (
  `id` int(11) NOT NULL,
  `mat_et` varchar(10) NOT NULL,
  `id_promotion` int(11) NOT NULL,
  `annee` varchar(10) NOT NULL,
  `date_identif` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `identifications`
--

INSERT INTO `identifications` (`id`, `mat_et`, `id_promotion`, `annee`, `date_identif`) VALUES
(5, 'EW6475875', 6, '2019-2020', '2019-07-24'),
(6, 'EG983117-', 5, '2019-2020', '2019-07-24'),
(7, 'EL756959', 6, '2019-2020', '2019-07-24');

-- --------------------------------------------------------

--
-- Structure de la table `mouvements`
--

CREATE TABLE `mouvements` (
  `id` int(11) NOT NULL,
  `sous_compte` varchar(50) NOT NULL,
  `num_compte` varchar(30) NOT NULL,
  `montant_soutire` float DEFAULT NULL,
  `motif` text,
  `date_mouv` date DEFAULT NULL,
  `taux` float DEFAULT NULL,
  `annee` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mouvements`
--

INSERT INTO `mouvements` (`id`, `sous_compte`, `num_compte`, `montant_soutire`, `motif`, `date_mouv`, `taux`, `annee`) VALUES
(1, 'patrimoines', '01030116002-30', 5000, 'achat papiers', '2019-07-23', 1600, '2019-2020'),
(2, 'patrimoines', '011030026003-31', 8000, 'achat ancres', '2019-07-23', 1600, '2019-2020'),
(3, 'agents', '011030026003-31', 60000, 'Achat papiers', '2019-07-24', 1600, '2019-2020');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` int(11) NOT NULL,
  `date_paiement` date DEFAULT NULL,
  `date_apurement` date DEFAULT NULL,
  `bordereau` text,
  `type_frais` varchar(50) NOT NULL,
  `mat_et` varchar(10) NOT NULL,
  `num_compte` varchar(30) NOT NULL,
  `annee` varchar(10) NOT NULL,
  `montant_verse` float DEFAULT NULL,
  `devise` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `date_paiement`, `date_apurement`, `bordereau`, `type_frais`, `mat_et`, `num_compte`, `annee`, `montant_verse`, `devise`) VALUES
(6, '2019-07-18', '2019-07-23', '76895695869', 'Attestation de fréquentation', 'EG467303', '011030026003-31', '2019-2020', 15, 'USD'),
(7, '2019-07-21', '2019-07-23', '49838493749894', 'Attestation de fréquentation', 'EG467303', '01030116002-30', '2019-2020', 30000, 'CDF'),
(8, '2019-07-13', '2019-07-24', 'JFGKFDGJFKGJKGK', 'Attestation de fréquentation', 'EA414002', '01030116002-30', '2019-2020', 30000, 'CDF'),
(9, '2019-07-19', '2019-07-24', 'JGKFDJGKDFJGF', 'Minerval', 'EI674499', '011030026003-31', '2019-2020', 330, 'USD'),
(10, '2019-07-19', '2019-07-24', 'sjfhdjfhkjdsjfdjkfkj', 'Minerval', 'EW6475875', '011030026003-31', '2019-2020', 300, 'USD'),
(11, '2019-07-24', '2019-07-24', 'fhdisfhdsfhidifdis', 'Stage', 'EW6475875', '011030026003-31', '2019-2020', 30, 'USD');

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `id_promotion` int(11) NOT NULL,
  `promotion` varchar(50) NOT NULL,
  `effectif` int(11) NOT NULL,
  `departement` varchar(50) NOT NULL,
  `code_option` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`id_promotion`, `promotion`, `effectif`, `departement`, `code_option`) VALUES
(1, 'G1', 300, 'Informatique', 'CSI'),
(2, 'G1', 100, 'Informatique', 'Réseaux'),
(3, 'G2', 400, 'Informatique', 'CSI'),
(4, 'G3', 160, 'Informatique', 'CSI'),
(5, 'L1', 200, 'Informatique', 'CSI'),
(6, 'L2', 140, 'Informatique', 'CSI'),
(7, 'G2', 120, 'Informatique', 'Réseaux'),
(8, 'G3', 110, 'Informatique', 'Réseaux'),
(9, 'L1', 80, 'Informatique', 'Réseaux'),
(10, 'L2', 70, 'Informartique', 'Réseaux'),
(11, 'G1', 180, 'Statistique', 'Math appliquées'),
(12, 'G2', 145, 'Statistique', 'Math appliquées'),
(13, 'G3', 139, 'Statistique', 'Math appliquées'),
(14, 'L1', 125, 'Statistique', 'Math appliquées'),
(15, 'L2', 110, 'Statistique', 'Math appliquées');

-- --------------------------------------------------------

--
-- Structure de la table `sous_comptes`
--

CREATE TABLE `sous_comptes` (
  `id` int(11) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `solde_courant` float DEFAULT NULL,
  `total_entree` float DEFAULT NULL,
  `total_sortie` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sous_comptes`
--

INSERT INTO `sous_comptes` (`id`, `designation`, `solde_courant`, `total_entree`, `total_sortie`) VALUES
(6, 'agents', 294000, 354000, 60000),
(7, 'enseignants', 427200, 427200, 0),
(8, 'etat', 0, 0, 0),
(9, 'patrimoines', 345800, 358800, 13000);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `nom_ut` varchar(50) NOT NULL,
  `role_ut` varchar(50) NOT NULL,
  `mot_pass` varchar(50) NOT NULL,
  `date_creat` date NOT NULL,
  `photo_ut` varchar(50) NOT NULL DEFAULT 'user1.jpg',
  `nom_comp` varchar(50) DEFAULT NULL,
  `mat_et` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom_ut`, `role_ut`, `mot_pass`, `date_creat`, `photo_ut`, `nom_comp`, `mat_et`) VALUES
(6, 'admin@iss.cd', 'admin', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'Mr admin', 'AI765182'),
(7, 'comptable@iss.cd', 'comptable', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'Mr comptable', 'AE708162-'),
(8, 'sga@iss.cd', 'sga', '53a1b3684812907853701b951b04804b8765f7fc', '2019-07-24', 'iss.jpg', 'Mr sga', 'AA107315'),
(9, 'financier@iss.cd', 'financier', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'Mr financier', 'AR5106345'),
(11, 'et@gmail.com', 'etudiant', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'mukendi mudibu felly', 'EI674499'),
(12, 'ngala@gmail.com', 'etudiant', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'ngala mulume kashama jean pierre', 'EG467303'),
(13, 'emar@gmail.com', 'etudiant', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'Mwez Rubuz Elie', 'EW6475875'),
(14, 'sec@iss.cd', 'sga', '4ce280da1fc78fcbaa5c7ecfcad538b278e0a908', '2019-07-24', 'user1.jpg', 'sec', 'AE513186');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annee_academ`
--
ALTER TABLE `annee_academ`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `annee` (`annee`);

--
-- Index pour la table `comptes`
--
ALTER TABLE `comptes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_compte` (`num_compte`) USING BTREE;

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mat_et` (`mat_et`);

--
-- Index pour la table `fixations`
--
ALTER TABLE `fixations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annee` (`annee`),
  ADD KEY `id_promotion` (`id_promotion`),
  ADD KEY `type_frais` (`type_frais`);

--
-- Index pour la table `identifications`
--
ALTER TABLE `identifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mat_et` (`mat_et`),
  ADD KEY `id_promotion` (`id_promotion`),
  ADD KEY `code_annee` (`annee`);

--
-- Index pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sous_compte` (`sous_compte`),
  ADD KEY `num_compte` (`num_compte`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `annee` (`annee`),
  ADD KEY `num_compte` (`num_compte`),
  ADD KEY `mat_et` (`mat_et`),
  ADD KEY `type_frais` (`type_frais`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id_promotion`);

--
-- Index pour la table `sous_comptes`
--
ALTER TABLE `sous_comptes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_ut` (`nom_ut`),
  ADD KEY `mat_et` (`mat_et`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annee_academ`
--
ALTER TABLE `annee_academ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `comptes`
--
ALTER TABLE `comptes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `etudiants`
--
ALTER TABLE `etudiants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `fixations`
--
ALTER TABLE `fixations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `identifications`
--
ALTER TABLE `identifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id_promotion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `sous_comptes`
--
ALTER TABLE `sous_comptes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fixations`
--
ALTER TABLE `fixations`
  ADD CONSTRAINT `fixations_ibfk_1` FOREIGN KEY (`annee`) REFERENCES `annee_academ` (`annee`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fixations_ibfk_2` FOREIGN KEY (`id_promotion`) REFERENCES `promotions` (`id_promotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `identifications`
--
ALTER TABLE `identifications`
  ADD CONSTRAINT `identifications_ibfk_2` FOREIGN KEY (`mat_et`) REFERENCES `etudiants` (`mat_et`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `identifications_ibfk_3` FOREIGN KEY (`id_promotion`) REFERENCES `promotions` (`id_promotion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `identifications_ibfk_4` FOREIGN KEY (`annee`) REFERENCES `annee_academ` (`annee`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
