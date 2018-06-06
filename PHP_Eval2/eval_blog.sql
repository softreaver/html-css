-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 25 mai 2018 à 13:58
-- Version du serveur :  5.7.19
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `eval_blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(8) NOT NULL,
  `auteur` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `contenu` text COLLATE utf8_unicode_ci NOT NULL,
  `dateModif` int(11) NOT NULL,
  `auteurModif` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`ID`, `titre`, `date`, `auteur`, `contenu`, `dateModif`, `auteurModif`) VALUES
(1, 'Le Web \"Commun\"', 20180522, 'Laurent', 'Tout le monde passe par la car c\'est la que se situe Youtube, Facebook, Twitter et bien d\'autres encore. Jusque la rien de bien compliqué !', 0, ''),
(2, 'Le Web \"Surface\"', 20180522, 'Laurent', 'On s\'enfonce d\'un niveau et on retrouve des sites comme Reddit ,les sites d\'adresses e-mail temporaire, les hébergements web, les bases de données, et j\'en passe. On peut même y retrouver des passages vers le \"Deep Web\" mais ca on vera plus tard.', 0, ''),
(3, 'Le \"Bergie\" Web', 20180522, 'Chris', 'Le dernier niveau dans lequel vous pouvez y avoir accès librement, les site comme 4chan en font partie, des résultats de recherche Google bloqués sont dans ce niveau. 99% du net serai à ce niveau, autant dire que \"ce perdre sur le net peut surement arrive', 0, ''),
(4, 'Le \"Deep\" Web', 20180522, 'Céline', 'La on commence à entrer dans les abysses du web, le côté obscure de la force, pour y arriver il vous faudra un VPN pour éviter les problèmes, un peu comme le réseau Tor, et un mental de choc !\r\n\r\nCar ce que vous pouvez voir la-bas n\'est pas très légal.', 20180525, 'Laurent'),
(5, 'Le \"Marianas\" Web', 20180522, 'Chris', 'Alors la pour y accéder faut être bon en information quantique mais qui possède suffisament de connaissance dans ce domaine ? Certains voient peut être ou je veux en venir car oui c\'est bien le gouvernement. Bon c\'est pas impossible d\'y accéder.', 20180525, 'Chris'),
(15, 'test 2 avec ckeditor', 20180525, 'Laurent', '\r\n                            \r\n                                                        \r\n<strong>Anthony Fardet :</strong> Ce sont des formulations industrielles possédant une longue liste d’ingrédients et/ou d’additifs d’utilisation exclusivement industrielle (généralement supérieure à 4 ou 5). <strong>Ils sont de deux types :</strong><p></p>\r\n\r\n<p>–<strong> Les aliments résultant d’une recombinaison d’ingrédients</strong> et/ou additifs comme les barres chocolatées ou les sodas : ce sont de nouvelles matrices alimentaires artificielles créées de toutes pièces par l’Homme. On ne peut pas les trouver dans la nature.</p>\r\n\r\n<p>–<strong> Les plats préparés</strong> (qui contiennent à la base de vrais aliments) avec de nombreux ingrédients et/ou additifs industriels.</p>\r\n\r\n<p>Ils ont aussi d’autres caractéristiques, mais pas forcément tous :<br>\r\n– Des <strong>emballages très colorés</strong> pour attirer le consommateur;<br>\r\n– Des personnages de l’univers des enfants pour les séduire;<br>\r\n– Des mentions du type « enrichi en… », « céréales complètes », « riche en… » donnant la <strong>fausse impression d’aliments bons pour la santé alors que ce n’est pas le cas;</strong><br>\r\n– Ils sont <strong>souvent enrichis en sucre, sel et gras.</strong></p>\r\n\r\n<p>Les principaux aliments ultra-transformés sont les <strong>snacks sucrés, salés et gras, les sodas, les yaourts à boire</strong>, les céréales du petit-déjeuner pour enfants, beaucoup de <strong>plats préparés industriels, les barres chocolatées, beaucoup de confiseries</strong>, les margarines, les produits de panification industriels et de <strong>nombreux desserts lactés</strong>.</p>\r\n\r\n<p><a href=\"https://www.flickr.com/photos/doreesday/397835228/in/photolist-Ba1y5-4k928u-coLcny-cxnuRJ-ceXuaj-dMTCDz-bRX8w-8cgHFK-7a9ypS-dqbSdv-875LLg-FJZjng-7Ck5v-a51rQX-8k4saN-6FWkBt-bwUWHY-5Pikw5-cca2wG-irDrhr-5g5LJ2-8Vf5Fv-8iWM4Z-9YBQx4-5yxXNQ-9PxG6j-aVHBjn-nviNs7-5Bztbg-5bCR6-9DW5f3-fGjL74-2q9s6-cs6qTj-LxfGg-i1R3KF-5bHmby-94SxsH-7XxBBV-oanDGj-rFmVM6-kaUQX-64pyZz-rm9aK-8R4xzK-9xUZYr-5hr4Mh-y92Va-AtgCQR-nvJHJ7\"><img alt=\"little junk foods\" src=\"https://farm1.staticflickr.com/146/397835228_5304421a5f_o.jpg\" style=\"height:600px; width:800px\"></a><strong>Mr M. : Donc, ces « faux aliments » ont peu à peu colonisé les rayons des supermarchés pour devenir aujourd’hui la norme ?</strong><br>\r\n<br>\r\nA. F. : Oui. Il est difficile de donner une date exacte car cela s’est fait progressivement ; mais il est très probable que <strong>leur arrivée massive date des années 80</strong>. Cependant, dans les pays émergents, leur arrivée est brutale et se substitue progressivement à l’alimentation traditionnelle locale, comme au Brésil, au Mexique ou dans les îles du Pacifique. <strong>Il s’ensuit une explosion des prévalences d’obésité et de diabète de type 2.</strong></p>\r\n\r\n<blockquote>\r\n<p><strong>CE COCKTAIL RÉPÉTÉ TOUS LES JOURS EST TRÈS DÉLÉTÈRE POUR LA SANTÉ, À LA FOIS À COURT, MOYEN ET LONG TERME.</strong></p>\r\n</blockquote>\r\n\r\n<p><strong>Mr M. : Ces pseudo-aliments posent-t-ils concrètement des problèmes pour la santé humaine ?</strong></p>\r\n\r\n<p>A.F. : Oui, quand ces aliments deviennent la base de notre alimentation comme cela devient de plus en plus le cas, notamment dans les pays anglo-saxons où on peut trouver <strong>jusqu’à 80% des aliments en rayon qui sont ultra-transformés</strong>. Ils posent problème pour la santé pour trois raisons principales :</p>\r\n\r\n<p>1)<strong> Ils sont peu rassasiants car riches en sucres et gras,</strong> les deux nutriments les moins rassasiant par rapport aux fibres et protéines plutôt caractéristiques des produits peu transformés, protéines et fibres constituant l’architecture naturelle de ces aliments ; en outre, beaucoup sont liquides et semi-solides, voire possèdent une texture facilement friable à la mastication : or les aliments liquides et semi-solides sont moins rassasiants que les aliments solides plutôt caractéristiques des aliments moins transformés ; car le temps de contact avec la muqueuse digestive et le temps de mastication sont plus courts ;</p>\r\n\r\n<p>2) Ils sont pour beaucoup <strong>hyperglycémiants</strong> en raison des sucres simples ajoutés et de leur texture déstructurée qui ralentit moins la digestion de l’amidon comme dans les féculents raffinées ; or <strong>les aliments riches en sucres facilement digestibles et absorbables « fatiguent » l’insuline</strong> avec des pics très fréquents de glucose sanguin ; menant à plus long terme au <strong>diabète de type 2</strong> ; mais aussi à l’<strong>obésité</strong> car l’excès de sucres (principalement glucose et fructose) se transforme en matières grasses hépatiques (stéatose) et sous-cutanées ;</p>\r\n\r\n<p>3) Ils sont <strong>riches en calories « vides »,</strong> à savoir leur densité énergétique est élevée avec une teneur en composés bioactifs protecteurs faibles, telles que fibres, vitamines, minéraux et autres antioxydants.</p>\r\n\r\n<p><strong>Ce cocktail répété tous les jours est très délétère pour la santé, à la fois à court, moyen et long terme.</strong></p>\r\n                                                                                                ', 20180525, 'Laurent');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`ID`, `nom`, `prenom`, `email`, `pseudo`, `password`, `admin`) VALUES
(5, 'DUPOND', 'Laurent', 'softreaver.dev@gmail.com', 'Laurent', 'tt', 1),
(6, 'MILAZZO', 'Christopher', 'mydel13@yahoo.fr', 'Chris', 'tt', 1),
(7, 'FORGEOT', 'Delphine', 'mydel@gmail.fr', 'mydel', 'tt', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
