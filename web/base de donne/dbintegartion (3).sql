-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 09 mars 2023 à 00:59
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dbintegartion`
--

-- --------------------------------------------------------

--
-- Structure de la table `blog`
--

CREATE TABLE `blog` (
                        `id` int(11) NOT NULL,
                        `idut_id` int(11) DEFAULT NULL,
                        `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `date` date NOT NULL,
                        `description_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `image_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `blog`
--

INSERT INTO `blog` (`id`, `idut_id`, `titre`, `date`, `description_b`, `image_b`) VALUES
    (1, 1, 'evennement', '2022-01-01', 'rien', '');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_d`
--

CREATE TABLE `categorie_d` (
                               `id` int(11) NOT NULL,
                               `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_d`
--

INSERT INTO `categorie_d` (`id`, `nom`, `description`) VALUES
                                                           (1, 'plastique', 'rien22'),
                                                           (3, 'choix', NULL),
                                                           (4, 'compostage', 'compostage'),
                                                           (6, 'deche', 'rien');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_p`
--

CREATE TABLE `categorie_p` (
                               `id` int(11) NOT NULL,
                               `nom_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `description_cat` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                               `date_creation` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_p`
--

INSERT INTO `categorie_p` (`id`, `nom_c`, `description_cat`, `date_creation`) VALUES
                                                                                  (1, 'ppppppppp', 'aaaaaaaaaa', '2023-03-08'),
                                                                                  (2, 'produit d\'entretient', 'produit d\'entretient biologique sans effets secondaires', '2023-03-09'),
                                                                                  (3, 'produits alimentaire', 'produits alimentaire biologique qui n\'affectent pas la sante de l\'etre humain', '2023-03-10'),
                                                                                  (4, 'Decor naturelle', 'decoration de maison et outils de maison cree de matiere naturelle', '2023-03-12'),
                                                                                  (5, 'plantes naturelles', 'plantes naturelles pour decoration', '2023-03-14');

-- --------------------------------------------------------

--
-- Structure de la table `collecte`
--

CREATE TABLE `collecte` (
                            `id` int(11) NOT NULL,
                            `idusercollect_id` int(11) DEFAULT NULL,
                            `iddon_id` int(11) DEFAULT NULL,
                            `etat_c` int(11) NOT NULL,
                            `typevehicule` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                            `contact` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `collecte`
--

INSERT INTO `collecte` (`id`, `idusercollect_id`, `iddon_id`, `etat_c`, `typevehicule`, `contact`) VALUES
                                                                                                       (1, 1, 24, 1, 'rien', '99088487'),
                                                                                                       (2, 1, 6, 2, 'voiture', '99887766'),
                                                                                                       (3, 2, 7, 1, 'motor', '112345667'),
                                                                                                       (4, 3, 8, 1, 'dzedqf', '99088');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
                            `id` int(11) NOT NULL,
                            `panier_id` int(11) DEFAULT NULL,
                            `date_commande` date NOT NULL,
                            `nom_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `prix_total` double NOT NULL,
                            `mail_client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `adresse_livraison` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                            `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `panier_id`, `date_commande`, `nom_client`, `prix_total`, `mail_client`, `adresse_livraison`, `status`) VALUES
                                                                                                                                          (1, 1, '2023-03-08', 'OumeimaTemani', 129, 'oumeimatm@gmail.com', 'korba', 'En cours'),
                                                                                                                                          (2, 2, '2023-03-08', 'OumeimaTemani', 43, 'oumeimatm@gmail.com', 'korba', 'En cours');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
                               `id` int(11) NOT NULL,
                               `id_blog_id` int(11) DEFAULT NULL,
                               `date_cm` date NOT NULL,
                               `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `auteur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                               `isactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
                                               `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
                                               `executed_at` datetime DEFAULT NULL,
                                               `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
                                                                                           ('DoctrineMigrations\\Version20230305172412', '2023-03-08 10:32:35', 395),
                                                                                           ('DoctrineMigrations\\Version20230308093254', '2023-03-08 10:33:03', 12),
                                                                                           ('DoctrineMigrations\\Version20230308113739', '2023-03-08 12:37:49', 190);

-- --------------------------------------------------------

--
-- Structure de la table `don`
--

CREATE TABLE `don` (
                       `id` int(11) NOT NULL,
                       `iduserdon_id` int(11) DEFAULT NULL,
                       `id_categorie_id` int(11) DEFAULT NULL,
                       `poids` int(11) DEFAULT NULL,
                       `description_d` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                       `etat` int(11) NOT NULL,
                       `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `don`
--

INSERT INTO `don` (`id`, `iduserdon_id`, `id_categorie_id`, `poids`, `description_d`, `etat`, `date`) VALUES
                                                                                                          (2, 1, 3, 50, 'test test test test', 1, '2023-02-27'),
                                                                                                          (3, 1, 1, 44, 'rien', 1, '2023-02-23'),
                                                                                                          (5, 1, 3, 9, 'rien', 2, '2023-02-02'),
                                                                                                          (6, 1, 3, 1, 'd', 1, '2023-02-28'),
                                                                                                          (7, 2, 1, 2, 'dzd', 3, NULL),
                                                                                                          (8, 1, 1, 3, 'd', 1, '2023-02-01'),
                                                                                                          (9, 2, 3, 3, 'd', 1, NULL),
                                                                                                          (10, 2, 3, 6, NULL, 1, NULL),
                                                                                                          (11, 2, 1, 64, 'rien1', 1, NULL),
                                                                                                          (15, 1, 1, 3, 'tdytf', 1, NULL),
                                                                                                          (16, NULL, 4, 10, 'dèche de fruits', 1, '2023-03-03'),
                                                                                                          (17, NULL, 4, 50, 'testd', 1, '2023-03-06'),
                                                                                                          (18, NULL, 1, 3, 'rient', 1, '2023-03-06'),
                                                                                                          (19, NULL, 4, 10, '666666', 1, '2023-03-05'),
                                                                                                          (20, NULL, 4, 3, 'chiheb', 1, '2023-03-06'),
                                                                                                          (21, NULL, 4, 12, 'dechee', 1, '2023-03-10'),
                                                                                                          (22, NULL, 4, 3, 'testEmail', 1, '2023-03-11'),
                                                                                                          (23, NULL, 4, 10, 'test2mail', 1, '2023-03-16'),
                                                                                                          (24, NULL, 4, 3, 'ddddddd', 1, '2022-05-02'),
                                                                                                          (25, NULL, 4, 3, 'ddddddd', 1, '2022-02-02'),
                                                                                                          (26, NULL, 4, 4, 'mail3', 1, '2023-03-23'),
                                                                                                          (27, NULL, 3, 13, 'mail nchlh lekhra', 1, '2023-03-11'),
                                                                                                          (28, NULL, 3, 5, 'mail 1002', 1, '2023-03-23'),
                                                                                                          (29, NULL, 3, 20, '151515', 1, NULL),
                                                                                                          (30, 2, 3, 10, 'dddddddddd', 1, NULL),
                                                                                                          (31, NULL, 3, 55, 'testmail', 1, NULL),
                                                                                                          (32, NULL, 3, 20, 'rient', 1, '2023-03-11'),
                                                                                                          (33, NULL, 3, 13, 'test222', 1, '2023-03-11'),
                                                                                                          (34, NULL, 6, 13, 'rienee', 1, '2023-03-18'),
                                                                                                          (35, NULL, 6, 16, 'ddddd', 1, '2023-03-27'),
                                                                                                          (36, NULL, 1, 11, '111dddd', 1, '2023-03-23'),
                                                                                                          (37, NULL, 1, 13, 'eeeeeeeeeee', 1, '2023-03-19'),
                                                                                                          (38, NULL, 1, 11, 'eeeee', 1, '2023-03-09'),
                                                                                                          (39, NULL, 1, 13, 'dedqd', 1, '2023-03-24');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
                                      `id` bigint(20) NOT NULL,
                                      `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
                                      `created_at` datetime NOT NULL,
                                      `available_at` datetime NOT NULL,
                                      `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
                          `id` int(11) NOT NULL,
                          `date_ajout` date NOT NULL,
                          `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `date_ajout`, `quantite`) VALUES
                                                          (1, '2023-03-08', NULL),
                                                          (2, '2023-03-08', NULL),
                                                          (3, '2023-03-08', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `panier_produit`
--

CREATE TABLE `panier_produit` (
                                  `panier_id` int(11) NOT NULL,
                                  `produit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier_produit`
--

INSERT INTO `panier_produit` (`panier_id`, `produit_id`) VALUES
                                                             (1, 1),
                                                             (2, 1),
                                                             (3, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
                           `id` int(11) NOT NULL,
                           `iduserproduit_id` int(11) DEFAULT NULL,
                           `idcat_p_id` int(11) DEFAULT NULL,
                           `nom_p` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `prix_p` double NOT NULL,
                           `description_p` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                           `image_p` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                           `stock` int(11) DEFAULT NULL,
                           `quantiteproduit` int(11) DEFAULT NULL,
                           `image_qr_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `iduserproduit_id`, `idcat_p_id`, `nom_p`, `prix_p`, `description_p`, `image_p`, `stock`, `quantiteproduit`, `image_qr_code`) VALUES
                                                                                                                                                               (1, NULL, 1, 'produit1', 43, 'produit 1 categorie 1', 'ee4f8bea904b6307a0b6061518ec5c38.jpg', 0, 1, '64086950242ac.png'),
                                                                                                                                                               (4, NULL, 2, 'Savon noir liquide à l\'huile de lin', 7.8, 'Nous reversons aussi 1% de notre chiffre d’affaires à la protection de la planète et nous soutenons les actions de la LPO (Ligue de Protection des Oiseaux) en faveur de la biodiversité.\r\n\r\nBouteille d\'1L\r\n\r\nPoids net 1.026000\r\nRéférence 1333080', '24e178863606e3cd15d65c0580d48a37.png', 45, NULL, '6408cabd2758d.png'),
                                                                                                                                                               (5, NULL, 2, 'Nettoyant multi-surfaces à la menthe et à l\'eucalyptus', 10.55, 'Spray de 750 ml\r\n\r\nPoids net 0.750000\r\nRéférence 1333803\r\nCONSEILS D’UTILISATION\r\nPour nettoyer et faire briller les sanitaires ( robinetterie, lavabos, carrelage) vaporiser sur la surface, laisser agir, frotter si besoin, rincer puis essuyer. Pour respecter l\'environnement, suivre les dosages préconisés.', '871a2574501ca62b1d20ab9de9d9ce8a.png', 33, 1, '6408cb1e26dab.png'),
                                                                                                                                                               (6, NULL, 2, 'Nettoyant pour sols à l\'huile essentielle de menthe', 3.8, 'Poids net 1.000000\r\nRéférence 24704\r\nCONSEILS D’UTILISATION\r\n1/ Utilisation diluée : 1 à 2 bouchons pour 5L d\'eau idéalement tiède. Inutile de rincer.\r\n2/ Utilisation pure : quelques gouttes sur une éponge humide ou directement sur les taches. Frotter puis rincer. Pour respecter la qualité de l\'air intérieur utiliser jusqu\'à 1 bouchon de 30 ml par m².', '754d9e9fd99ef039bee3892364da653a.png', 32, NULL, '6408cb8bc5bff.png'),
                                                                                                                                                               (7, NULL, 2, 'Senteur orange cannelle', 12.3, 'Flacon de 10 ml - 0.33fl.oz.\r\nPoids net 0.009000\r\nRéférence 1336121\r\nCONSEILS D’UTILISATION\r\nEn cuisine : Pour réaliser un dessert Orange Cannelle, mélanger 1 à 2 gouttes directement à votre pâte (gâteaux, madeleines, crêpes, salade de fruits). Ceci parfumera agréablement vos plats. Ne pas dépasser la dose journalière de 2 gouttes. A consommer dans le cadre d\'une alimentation variée et équilibrée et d\'un mode de vie sain.', 'a23ddb20aa8102c2550e86b07dde25c5.png', 42, NULL, '6408cbdaddb26.png'),
                                                                                                                                                               (8, NULL, 3, 'Huile d\'olive', 19.6, 'Valeurs nutritionnelles\r\npar 100ml\r\n \r\nEnergie\r\n(821Kcal / 3374 Kj)\r\nMatières Grasses\r\n91,2g\r\nAcides gras Saturés\r\n19,3g\r\nAcides gras Mono-insaturés\r\n57,3g\r\nAcides gras Poly-insaturés\r\n14,5g', '012996d0b22613f9215c2886f36bf0be.png', 45, NULL, '6408cc9092c41.png'),
(9, NULL, 3, 'Tomates & cajou façon pesto à tartiner', 5.56, 'Composition :\r\nTomates concassées 20% (tomates, jus de tomates, acidifiant : acide citrique), huile de colza, concentré de tomates 17%, poivron, basilic 9%, fromage* italien, eau, carottes, noix de cajou * 3,5%, ail, sel, épices et aromates, sucre, arôme naturel. *Ingrédients allergènes. Traces possibles de crustacés, mollusque, moutarde, poisson, œuf.', '0cbb7bc213a71c8c3603102ca3477fe6.jpg', 54, NULL, '6408cdd0bc49e.png'),
(10, NULL, 4, 'Miroir en rotin', 58.9, 'Matériau écologique : Ce miroir est fabriqué à partir de matériaux naturels, beaux et respectueux de l\'environnement, inodores, résistants et difficiles à endommager.\r\nMiroir fait à la main : Le miroir géométrique en rotin suspendu est fabriqué à la main et convient parfaitement à la décoration intérieure.', 'e4b2776e861b1553e1c631fb08e2a6ae.jpg', 30, NULL, '6408e31647549.png'),
                                                                                                                                                               (11, NULL, 5, 'OFFICE Plante', 78.5, 'Hauteur 120 cm Vert 10 Feuilles Ami des Arbres Plante décorative', '893de86257478c8302a413bdcca4110d.jpg', 4, NULL, '6408e485335bd.png'),
                                                                                                                                                               (12, NULL, 3, 'Haricot mungo (soja vert) bio - Graines à germer', 13.6, 'Le soja vert est un des piliers de la cuisine asiatique, il s\'agit du haricot Mungo. Vous les trouver assez facilement en version pousse fraîche dans vos magasins spécialisés. \r\nComposition\r\n100% graines à germer de haricot Mungo (vigna radiata), issues de l\'agriculture biologique. Origine : Chine', 'bb8d698e46b8db3b21b133dfbb9eb6f4.jpg', 67, NULL, '6408e4c7b6ca3.png'),
                                                                                                                                                               (13, NULL, 3, 'Farine de manioc bio sans gluten', 5.7, 'Base d\'un grand nombre de plats africains, le manioc se décline ici sous forme de farine.\r\n\r\nLa farine de manioc peut être consommée sous forme d\'une sorte de pâte/purée, ou servir à la préparation de pains et desserts, en alternative à la farine de blé. Une des grandes différences avec la farine de blé est que la farine de manioc est fermentée.', '991e38e296539fda7853b9887533e8f3.jpg', 56, NULL, '6408e4f7396f6.png'),
                                                                                                                                                               (14, NULL, 5, 'HOMCOM Bambou', 34.6, '1,5 m en pot pour décoration intérieure ou extérieure', '77ce7f356df33ea15136cf550da866dd.jpg', 10, NULL, '6408e5236acb4.png'),
                                                                                                                                                               (15, NULL, 2, 'Bio ménage sol - 5 L - agrumes', 10.6, 'Bio ménage sol LE VRAI. - Nettoie sans mousser toutes les surfaces lavables, odorise, assainit. - Parfum : agrumes. - Quantité : 5 L. - Apte au contact alimentaire après rinçage à l\'eau potable', 'ef9e735aef6f39eae09c39e26be5d857.png', 56, NULL, '6408e5f01f2ba.png'),
(16, NULL, 3, 'Farine de riz complet bio', 8.65, 'Naturellement sans gluten, le riz est la céréale la plus digeste et la plus assimilable.\r\nComposition\r\nTraces possibles de céréales contenant du gluten, soja, fruits à coques, sésame.', '8bd527f183432214aac7bc47cdb0f2d5.jpg', 44, NULL, '6408e63acd044.png'),
(17, NULL, 3, 'Assortiment de pâtes demi-complètes bio', 21.4, 'Des pâtes de toutes les formes pour tous les goûts mais toujours délicieuses, c\'est ce qui vous attend avec cet assortiment de 3 paquets de pâte demi-complètes bio', '35b26586671f6b9dc669597535d1c4a7.jpg', 45, NULL, '6408e682b4982.png'),
                                                                                                                                                               (18, NULL, 5, 'Outsunny Ficus', 56.6, 'pot de pépinière pour décoration intérieure et extérieure - 1,4 m', '95f27a1e1e10c72d3aa61a30d7b4b67b.jpg', 7, NULL, '6408e6c87781e.png');

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

CREATE TABLE `rendezvous` (
                              `id` int(11) NOT NULL,
                              `idcollecte_id` int(11) DEFAULT NULL,
                              `date_rv` date DEFAULT NULL,
                              `adresse_rv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                              `etat_rv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id`, `idcollecte_id`, `date_rv`, `adresse_rv`, `etat_rv`) VALUES
    (1, 3, '2023-03-09', 'bizerte', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
                        `id` int(11) NOT NULL,
                        `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
                        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                        `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `datenaissance` date NOT NULL,
                        `cin` int(11) DEFAULT NULL,
                        `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `ville` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `isactive` int(11) DEFAULT NULL,
                        `reset_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`, `photo`, `datenaissance`, `cin`, `region`, `ville`, `adresse`, `isactive`, `reset_token`) VALUES
                                                                                                                                                                       (1, 'khaled.lajimi@esprit.tn', '[\"ROLE_ADMIN\"]', '$2y$13$tO/tO7s73Hpq3xZlh0GONuKIrGFHYRfpijPTYgniNlVTZu/Qco6HC', 'khaled', 'lajimi', NULL, '2018-02-19', 12345678, 'ben arous', 'mourouj', 'mourouj', 0, ''),
                                                                                                                                                                       (2, 'khadija.chaari@esprit.tn', '[]', '$2y$13$uevd0c4Eh2eLKMv5gfCAmubFCiPNT76MBJfhzMgM.cI54liYeCSOO', 'khadija', 'chaari', NULL, '2018-04-18', 12345678, 'ariena', 'sokra', 'ariena sokra', 0, ''),
                                                                                                                                                                       (3, 'chiheb@gmail.com', '[]', '123456', 'menjli', 'chiheb', 'rien', '2023-03-10', 123, NULL, NULL, NULL, 1, ''),
                                                                                                                                                                       (4, 'chiheb.menjli@esprit.tn', '[\"ROLE_ADMIN\"]', '$2y$13$j7zlxhAz5RFNXeVi0mKEMeJP56N5L39Fz95STJzihoBI5tENzc0wi', 'menjli', 'chiheb', NULL, '2018-01-01', 12345678, 'tunis', 'Hrairia', '7 street Toulaiha Ghdir golla', NULL, NULL),
                                                                                                                                                                       (5, 'chiheb1@gmail.com', '[\"ROLE_DONNEUR\"]', '123456', 'menjli', 'chiheb', 'rien', '2018-01-01', 12345678, 'tunis', 'Hrairia', '7 street Toulaiha Ghdir golla', 1, NULL),
                                                                                                                                                                       (6, 'dhia@gmail.com', '[\"ROLE_COLLECTEUR\"]', '$2y$13$1saSV9A6OiH5vM9ncSlvSetPCtphbckzyMrFd7sRYlqeH6.MPsFRK', 'hamdani', 'dhia', NULL, '2018-01-01', 12345678, 'tunis', 'Hrairia', 'tunis', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blog`
--
ALTER TABLE `blog`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C01551435C48DF52` (`idut_id`);

--
-- Index pour la table `categorie_d`
--
ALTER TABLE `categorie_d`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_p`
--
ALTER TABLE `categorie_p`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `collecte`
--
ALTER TABLE `collecte`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_55AE4A3D1F813DCD` (`iddon_id`),
  ADD KEY `IDX_55AE4A3D36200F3A` (`idusercollect_id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6EEAA67DF77D927C` (`panier_id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BC47DD7E7` (`id_blog_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
    ADD PRIMARY KEY (`version`);

--
-- Index pour la table `don`
--
ALTER TABLE `don`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F8F081D9DE6F9A9F` (`iduserdon_id`),
  ADD KEY `IDX_F8F081D99F34925F` (`id_categorie_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
    ADD PRIMARY KEY (`id`);

--
-- Index pour la table `panier_produit`
--
ALTER TABLE `panier_produit`
    ADD PRIMARY KEY (`panier_id`,`produit_id`),
  ADD KEY `IDX_D31F28A6F77D927C` (`panier_id`),
  ADD KEY `IDX_D31F28A6F347EFB` (`produit_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
    ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC275330C349` (`iduserproduit_id`),
  ADD KEY `IDX_29A5EC27649DDC1E` (`idcat_p_id`);

--
-- Index pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C09A9BA8B7CBEA69` (`idcollecte_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `blog`
--
ALTER TABLE `blog`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `categorie_d`
--
ALTER TABLE `categorie_d`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `categorie_p`
--
ALTER TABLE `categorie_p`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `collecte`
--
ALTER TABLE `collecte`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `don`
--
ALTER TABLE `don`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
    MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blog`
--
ALTER TABLE `blog`
    ADD CONSTRAINT `FK_C01551435C48DF52` FOREIGN KEY (`idut_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `collecte`
--
ALTER TABLE `collecte`
    ADD CONSTRAINT `FK_55AE4A3D1F813DCD` FOREIGN KEY (`iddon_id`) REFERENCES `don` (`id`),
  ADD CONSTRAINT `FK_55AE4A3D36200F3A` FOREIGN KEY (`idusercollect_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
    ADD CONSTRAINT `FK_6EEAA67DF77D927C` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
    ADD CONSTRAINT `FK_67F068BC47DD7E7` FOREIGN KEY (`id_blog_id`) REFERENCES `blog` (`id`);

--
-- Contraintes pour la table `don`
--
ALTER TABLE `don`
    ADD CONSTRAINT `FK_F8F081D99F34925F` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie_d` (`id`),
  ADD CONSTRAINT `FK_F8F081D9DE6F9A9F` FOREIGN KEY (`iduserdon_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `panier_produit`
--
ALTER TABLE `panier_produit`
    ADD CONSTRAINT `FK_D31F28A6F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_D31F28A6F77D927C` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
    ADD CONSTRAINT `FK_29A5EC275330C349` FOREIGN KEY (`iduserproduit_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_29A5EC27649DDC1E` FOREIGN KEY (`idcat_p_id`) REFERENCES `categorie_p` (`id`);

--
-- Contraintes pour la table `rendezvous`
--
ALTER TABLE `rendezvous`
    ADD CONSTRAINT `FK_C09A9BA8B7CBEA69` FOREIGN KEY (`idcollecte_id`) REFERENCES `collecte` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
