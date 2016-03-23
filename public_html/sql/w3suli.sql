-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 22, 2016 at 11:04 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `w3suli`
--

-- --------------------------------------------------------

--
-- Table structure for table `AlapAdatok`
--

CREATE TABLE IF NOT EXISTS `AlapAdatok` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `WebhelyNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `Iskola` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `Cim` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `Telefon` varchar(20) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `Stilus` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `AlapAdatok`
--

INSERT INTO `AlapAdatok` (`id`, `WebhelyNev`, `Iskola`, `Cim`, `Telefon`, `Stilus`) VALUES
(3, 'w3 Suli', 'Iskola neve', 'Cim', 'Telefon', 11);

-- --------------------------------------------------------

--
-- Table structure for table `Cikkek`
--

CREATE TABLE IF NOT EXISTS `Cikkek` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `CNev` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `CLeiras` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `CTartalom` text COLLATE utf8_hungarian_ci NOT NULL,
  `CLathatosag` tinyint(4) NOT NULL DEFAULT '1',
  `CSzerzo` int(10) NOT NULL,
  `CSzerzoNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `CLetrehozasTime` datetime NOT NULL,
  `CModositasTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `Cikkek`
--

INSERT INTO `Cikkek` (`id`, `CNev`, `CLeiras`, `CTartalom`, `CLathatosag`, `CSzerzo`, `CSzerzoNev`, `CLetrehozasTime`, `CModositasTime`) VALUES
(1, 'teszt cikk', '', 'fasfsadsdafsdf', 1, 10, 'tesztelek', '2016-02-21 08:08:21', '2016-02-21 08:08:21'),
(2, 'rrrrrrrrr', '', 'weqfwqef', 1, 10, 'tesztelek', '2016-02-21 09:13:11', '2016-02-21 09:13:11'),
(3, '1. cikk', '', '1. cikk', 1, 10, 'tesztelek', '2016-02-21 13:29:29', '2016-02-21 13:29:29'),
(4, '2. cikk', '', '2. cikk', 1, 10, 'tesztelek', '2016-02-21 13:29:57', '2016-02-21 13:29:57'),
(5, '3. cikk', '', '3. cikk', 1, 10, 'tesztelek', '2016-02-21 13:30:14', '2016-02-21 13:30:14'),
(6, '4. cikk', '', '4. cikk', 1, 10, 'tesztelek', '2016-02-21 13:30:24', '2016-02-21 13:30:24'),
(7, '5. cikk', '', '5. cikk', 1, 10, 'tesztelek', '2016-02-21 13:30:35', '2016-02-21 13:30:35'),
(8, '6. cikk', '', '6. cikk', 1, 10, 'tesztelek', '2016-02-21 13:30:52', '2016-02-21 13:30:52'),
(9, '7. cikk', '', '7. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:01', '2016-02-21 13:31:01'),
(10, '8. cikk', '', '8. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:11', '2016-02-21 13:31:11'),
(11, '9. cikk', '', '9. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:20', '2016-02-21 13:31:20'),
(12, '10. cikk', '', '10. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:37', '2016-02-21 13:31:37'),
(13, '11. cikk', '', '11. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:47', '2016-02-21 13:31:47'),
(14, '12. cikk', '', '12. cikk', 1, 10, 'tesztelek', '2016-02-21 13:31:56', '2016-02-21 13:31:56'),
(15, '13. cikk', '', '13. cikk', 1, 10, 'tesztelek', '2016-02-21 13:32:10', '2016-02-21 13:32:10'),
(16, '14. cikk', '', '14. cikk', 1, 10, 'tesztelek', '2016-02-21 13:32:20', '2016-02-21 13:32:20'),
(17, '15. cikk', '', '15. cikk', 1, 10, 'tesztelek', '2016-02-21 13:32:32', '2016-02-21 13:32:32'),
(18, '16. cikk', '', '16. cikk', 1, 10, 'tesztelek', '2016-02-21 13:32:53', '2016-02-21 13:32:53'),
(19, '17. cikk', '', '17. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:04', '2016-02-21 13:33:04'),
(20, '18. cikk', '', '18. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:14', '2016-02-21 13:33:14'),
(21, '19. cikk', '', '19. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:23', '2016-02-21 13:33:23'),
(22, '20. cikk', '', '20. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:37', '2016-02-21 13:33:37'),
(23, '21. cikk', '', '21. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:46', '2016-02-21 13:33:46'),
(24, '22. cikk', '', '22. cikk', 1, 10, 'tesztelek', '2016-02-21 13:33:58', '2016-02-21 13:33:58'),
(25, 'VÃ©lemÃ©nykifejtÃ©s', 'velemeny', 'Szerintem nagyon kirÃ¡ly lett az Ãºj verziÃ³. Drakula!', 0, 10, 'tesztelek', '2016-03-20 20:46:10', '2016-03-20 20:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `CikkKepek`
--

CREATE TABLE IF NOT EXISTS `CikkKepek` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Cid` int(10) NOT NULL,
  `KFile` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KLeiras` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KSzelesseg` smallint(6) NOT NULL DEFAULT '-1',
  `KMagassag` smallint(6) NOT NULL DEFAULT '-1',
  `KStilus` smallint(6) NOT NULL DEFAULT '0',
  `KSorszam` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `CikkKepek`
--

INSERT INTO `CikkKepek` (`id`, `Cid`, `KFile`, `KNev`, `KLeiras`, `KSzelesseg`, `KMagassag`, `KStilus`, `KSorszam`) VALUES
(1, 2, '2_0.jpg', '', '', 0, 0, 0, 0),
(2, 2, '2_1.jpg', '', '', 0, 0, 0, 0),
(3, 2, 'cikk_2_0.jpg', '', '', 0, 0, 0, 0),
(4, 2, 'cikk_2_1.jpg', '', '', 0, 0, 0, 0),
(5, 2, 'cikk_2_2.jpg', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `FCsoportTagok`
--

CREATE TABLE IF NOT EXISTS `FCsoportTagok` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Fid` int(10) NOT NULL,
  `CSid` int(10) NOT NULL,
  `KapcsTip` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `FCsoportTagok`
--

INSERT INTO `FCsoportTagok` (`id`, `Fid`, `CSid`, `KapcsTip`) VALUES
(1, 11, 1, 0),
(2, 12, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `FelhasznaloCsoport`
--

CREATE TABLE IF NOT EXISTS `FelhasznaloCsoport` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `CsNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `CsLeiras` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `FelhasznaloCsoport`
--

INSERT INTO `FelhasznaloCsoport` (`id`, `CsNev`, `CsLeiras`) VALUES
(1, '13.I', '13.I osztÃ¡ly'),
(2, '10.K', '10.K osztÃ¡ly'),
(3, '11.A', '11.A osztÃ¡ly'),
(4, 'tanÃ¡rok', 'tanÃ¡r csoport'),
(5, 'rendszergazdÃ¡k', 'RendszergazdÃ¡k csoportja');

-- --------------------------------------------------------

--
-- Table structure for table `Felhasznalok`
--

CREATE TABLE IF NOT EXISTS `Felhasznalok` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `FNev` varchar(40) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `FFNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `FJelszo` varchar(40) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `FEmail` varchar(40) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `FSzint` tinyint(4) NOT NULL DEFAULT '0',
  `FSzerep` varchar(30) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `FKep` varchar(40) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `Felhasznalok`
--

INSERT INTO `Felhasznalok` (`id`, `FNev`, `FFNev`, `FJelszo`, `FEmail`, `FSzint`, `FSzerep`, `FKep`) VALUES
(4, 'Rendszergazda1', 'Rendszergazda', 'Rendszergazda', 'rendszergazda@rendszergazda.hu', 5, 'tanÃ¡r', ''),
(10, 'tesztelek', 'tesztelek', 'bf7fd979986bf2313dca63d533cc8a7f', 'r@r.hu', 5, 'tanÃƒÂ¡r', ''),
(11, 'TÃ³th-KovÃ¡cs GellÃ©rt', 'gelcsi', 'fd19fc4285310dd91aa4ef2b1bcd1524', 'a@a.hu', 2, 'tanulÃ³', ''),
(12, 'Beschenbacher KornÃ©l', 'bkornel', 'fd19fc4285310dd91aa4ef2b1bcd1524', 'a@a.hu', 2, 'tanulÃ³', '');

-- --------------------------------------------------------

--
-- Table structure for table `FoMenuLink`
--

CREATE TABLE IF NOT EXISTS `FoMenuLink` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `LURL` varchar(50) COLLATE utf8_hungarian_ci NOT NULL,
  `LPrioritas` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `FoMenuLink`
--

INSERT INTO `FoMenuLink` (`id`, `LNev`, `LURL`, `LPrioritas`) VALUES
(1, 'GitHub (gtportal)', 'https://github.com/gtportal/w3suli', 0),
(2, '', '', 0),
(3, '', '', 0),
(4, '', '', 0),
(5, '', '', 0),
(6, '', '', 0),
(7, '', '', 0),
(8, '', '', 0),
(9, '', '', 0),
(10, '', '', 0),
(11, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `KiegTartalom`
--

CREATE TABLE IF NOT EXISTS `KiegTartalom` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `KiegTNev` varchar(125) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KiegTTartalom` text COLLATE utf8_hungarian_ci NOT NULL,
  `KiegTPrioritas` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `KiegTartalom`
--

INSERT INTO `KiegTartalom` (`id`, `KiegTNev`, `KiegTTartalom`, `KiegTPrioritas`) VALUES
(1, '', '<a href="./letolt/w3_suli_kornel.pptx">\r\n<img src="./img/ikonok/kornel_eloadas.png" width="300">\r\n</a>', 6),
(2, '', '', 1),
(3, '', '', 2),
(4, 'TovÃ¡bbi kiemelt informÃ¡ciÃ³k', 'ÃrvÃ­ztÅ±rÅ‘ fÃºrÃ³gÃ©p', 0),
(5, '', '', 0),
(6, '', '', 0),
(7, '', '', 0),
(8, '', '', 0),
(9, '', '', 0),
(10, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `MenuPlusz`
--

CREATE TABLE IF NOT EXISTS `MenuPlusz` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `MenuPlNev` varchar(125) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `MenuPlTartalom` text COLLATE utf8_hungarian_ci NOT NULL,
  `MenuPlPrioritas` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `MenuPlusz`
--

INSERT INTO `MenuPlusz` (`id`, `MenuPlNev`, `MenuPlTartalom`, `MenuPlPrioritas`) VALUES
(1, 'Valami', 'valami', 1),
(2, '', '', 0),
(3, '', '', 0),
(4, '', '', 0),
(5, '', '', 0),
(6, '', '', 0),
(7, '', '', 0),
(8, '', '', 0),
(9, '', '', 0),
(10, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `OLathatosag`
--

CREATE TABLE IF NOT EXISTS `OLathatosag` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Oid` int(10) NOT NULL,
  `CSid` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Oldalak`
--

CREATE TABLE IF NOT EXISTS `Oldalak` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `ONev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `OUrl` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `OLathatosag` tinyint(4) NOT NULL DEFAULT '0',
  `OPrioritas` smallint(6) NOT NULL DEFAULT '0',
  `OLeiras` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `OKulcsszavak` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `OSzuloId` int(10) NOT NULL DEFAULT '0',
  `OTipus` tinyint(4) NOT NULL DEFAULT '1',
  `OTartalom` text COLLATE utf8_hungarian_ci NOT NULL,
  `OImgDir` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `OImg` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=88 ;

--
-- Dumping data for table `Oldalak`
--

INSERT INTO `Oldalak` (`id`, `ONev`, `OUrl`, `OLathatosag`, `OPrioritas`, `OLeiras`, `OKulcsszavak`, `OSzuloId`, `OTipus`, `OTartalom`, `OImgDir`, `OImg`) VALUES
(1, 'KezdÅ‘lap', 'kezdolap', 1, 1, 'KezdÅ‘lap leÃ­rÃ¡sa', 'KezdÅ‘lap kulcsszavai', 0, 0, '<section> <article> <img src="img/Shrek_fierce.jpg" alt="leÃ­rÃ¡s" title="1 cikk cÃ­me" style="float:left;"> <h2>1 cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br><br> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> <article> <img src="img/Shrek_1.jpg" alt="leÃ­rÃ¡s" title="2 cikk cÃ­me" style="float:left;"> <h2>2. cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br><br> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> </section>', '', ''),
(12, 'BejelentkezÃ©s', 'bejelentkezes', 1, 1, 'BejelentkezÃ©s leÃ­rÃ¡sa', 'BejelentkezÃ©s kulcsszavai', 1, 10, 'BejelentkezÃ©s tartalma', '', ''),
(13, 'KijelentkezÃ©s', 'kijelentkezes', 1, 1, 'KijelentkezÃ©s leÃ­rÃ¡sa', 'KijelentkezÃ©s kulcsszavai', 1, 11, 'KijelentkezÃ©s tartalma', '', ''),
(14, 'RegisztrÃ¡ciÃ³', 'regisztracio', 1, 1, 'RegisztrÃ¡ciÃ³ leÃ­rÃ¡sa', 'RegisztrÃ¡ciÃ³ kulcsszavai', 1, 12, 'RegisztrÃ¡ciÃ³ tartalma', '', ''),
(15, 'FelhasznÃ¡lÃ³ tÃ¶rlÃ©se', 'felhasznalo_torlese', 1, 1, 'FelhasznÃ¡lÃ³ tÃ¶rlÃ©se leÃ­rÃ¡sa', 'FelhasznÃ¡lÃ³ tÃ¶rlÃ©se kulcsszavai', 1, 13, 'FelhasznÃ¡lÃ³ tÃ¶rlÃ©se tartalma', '', ''),
(16, 'FelhasznÃ¡lÃ³ lista', 'felhasznalo_lista', 1, 1, 'FelhasznÃ¡lÃ³ lista leÃ­rÃ¡sa', 'FelhasznÃ¡lÃ³ lista kulcsszavai', 1, 14, 'FelhasznÃ¡lÃ³ lista tartalma', '', ''),
(17, 'AdatmÃ³dosÃ­tÃ¡s', 'adatmodositas', 1, 1, 'AdatmÃ³dosÃ­tÃ¡s leÃ­rÃ¡sa', 'AdatmÃ³dosÃ­tÃ¡s kulcsszavai', 1, 15, 'AdatmÃ³dosÃ­tÃ¡s tartalma', '', ''),
(18, 'JelszÃ³modosÃ­tÃ¡s', 'jelszomodositas', 1, 1, 'JelszÃ³modosÃ­tÃ¡s leÃ­rÃ¡sa', 'JelszÃ³modosÃ­tÃ¡s kulcsszavai', 1, 16, 'JelszÃ³modosÃ­tÃ¡s tartalma', '', ''),
(19, 'AlapbeÃ¡llÃ­tÃ¡sok', 'alapbeallitasok', 1, 1, 'AlapbeÃ¡llÃ­tÃ¡sok leÃ­rÃ¡sa', 'AlapbeÃ¡llÃ­tÃ¡sok kulcsszavai', -1, 51, 'AlapbeÃ¡llÃ­tÃ¡sok tartalma', '', ''),
(20, 'ttt', 'ttt', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', -1, 1, '<section> <article> <img src="img/Shrek_fierce.jpg" alt="leÃ­rÃ¡s" title="1 cikk cÃ­me" style="float:left;"> <h2>1 cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br><br> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> <article> <img src="img/Shrek_1.jpg" alt="leÃ­rÃ¡s" title="2 cikk cÃ­me" style="float:left;"> <h2>2. cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br><br> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> </section>', '', ''),
(21, 'shrek', 'shrek', 1, 1, 'Shrek demo tartalom.', '', 1, 1, '<section> <article> <img src="img/Shrek_fierce.jpg" alt="leÃ­rÃ¡s" title="1 cikk cÃ­me" style="float:left;"> <h2>1 cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br><br> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> <article> <img src="img/Shrek_1.jpg" alt="leÃ­rÃ¡s" title="2 cikk cÃ­me" style="float:left;"> <h2>2. cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br><br> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> </section>', '', 'shrek.jpg'),
(22, 'OsztÃ¡lyok', 'Osztalyok', 1, 48, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 2, '', '', ''),
(23, '9.H', '9_H', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, '<section> <article> <img src="img/Shrek_fierce.jpg" alt="leÃ­rÃ¡s" title="1 cikk cÃ­me" style="float:left;"> <h2>1 cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. <br><br> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> <article> <img src="img/Shrek_1.jpg" alt="leÃ­rÃ¡s" title="2 cikk cÃ­me" style="float:left;"> <h2>2. cikk cÃ­me</h2> "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br><br> Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum." </article> </section>', '', ''),
(27, '13.I', '13_I', 1, 99, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma jfcgfgjcf', '', ''),
(28, '9.A', '9_A', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', 'w3333.jpg'),
(31, 'Iskola dokumentumai', 'Iskola_dokumentumai', 1, 50, 'Iskola dokumentumai', 'Az oldal kulcsszavai', 1, 2, 'Az oldal tartalma', '', ''),
(35, 'Kieg. tartalom', 'kiegeszito_tartalom', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 52, 'Az oldal tartalma', '', ''),
(39, 'FÅ‘menÃ¼ linkek beÃ¡llÃ­tÃ¡sa', 'Fomenu_linkek_beallitasa', 1, 1, 'FÅ‘menÃ¼ linkek beÃ¡llÃ­tÃ¡sa', 'Az oldal kulcsszavai', 1, 53, '', '', ''),
(40, 'A blog-motor bemutatÃ¡sa', 'A_blog-motor_bemutatasa', 1, 100, 'W3 Suli bemutatÃ¡sa', 'W3 Suli bemutatÃ¡sa', 1, 1, '', '', ''),
(41, 'FelhasznÃ¡lÃ³i csoportok', 'Felhasznaloi_csoportok', 1, 1, 'Oldal leÃ­rÃ¡sa', 'Oldal kulcsszavai', 1, 20, 'Oldal tartalma', '', ''),
(42, 'OldaltÃ©rkÃ©p', 'oldalterkep', 1, 1, 'OldaltÃ©rkÃ©p leÃ­rÃ¡sa', 'OldaltÃ©rkÃ©p kulcsszavai', 1, 21, 'AlapbeÃ¡llÃ­tÃ¡sok tartalma', '', ''),
(43, 'MenÅ± plusz infÃ³k', 'menuplusz', 1, 1, 'MenÅ± plusz infÃ³k leÃ­rÃ¡sa', 'MenÅ± plusz infÃ³k kulcsszavai', 1, 54, 'MenÅ± plusz infÃ³k tartalma', '', ''),
(44, 'A W3 Suli projekt cÃ©lja', 'A_W3_Suli_projekt_celja', 1, 100, 'A W3 Suli projekt cÃ©lja', 'A W3 Suli projekt cÃ©lja', 40, 2, '', '', ''),
(45, 'FelhasznÃ¡lÃ¡si feltÃ©telek', 'Felhasznalasi_feltetelek', 1, 99, 'FelhasznÃ¡lÃ¡si feltÃ©telek', 'FelhasznÃ¡lÃ¡si feltÃ©telek', 40, 2, '', '', ''),
(46, 'A blog-motor letÃ¶ltÃ©se', 'A_blog-motor_letoltese', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 40, 2, 'Az oldal tartalma', '', ''),
(47, 'A blog-motor telepÃ­tÃ©se', 'A_blog-motor_telepitese', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 40, 2, 'Az oldal tartalma', '', ''),
(48, '9.K', '9_K', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(50, '9.Ny', '9_Ny', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(51, '10.A', '10_A', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(52, '10.C', '10_C', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(53, '10.H', '10_H', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(54, '10.K', '10_K', 1, 98, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(55, '11.A', '11_A', 1, 90, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(56, '11.C', '11_C', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(58, '12.A', '12_A', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(59, '12.C', '12_C', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(61, '12.H', '12_H', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(62, '11.K', '11_K', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(63, '11.H', '11_H', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(64, '13.A', '13_A', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(65, '13.B', '13_B', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(66, '13.C', '13_C', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(67, '13.D', '13_D', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(68, '13.E', '13_E', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(69, '13.G', '13_G', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(70, '13.H', '13_H', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 22, 1, 'Az oldal tartalma', '', ''),
(71, 'SzallagavatÃ³', 'Szallagavato', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 27, 1, 'Az oldal tartalma', '', ''),
(72, 'W3Suli projekt', 'W3Suli_projekt', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 27, 1, 'Az oldal tartalma', '', ''),
(73, 'CSS-ek kÃ©szÃ­tÃ©se', 'CSS-ek_keszitese', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 72, 1, 'Az oldal tartalma', '', ''),
(74, 'TesztelÃ¼nk', 'Tesztelunk', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 27, 1, 'Az oldal tartalma', '', ''),
(75, 'KÃ©pzÃ©sek', 'Kepzesek', 1, 49, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 1, 'Az oldal tartalma', '', ''),
(76, 'TanÃ¡raink', 'Tanaraink', 1, 47, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 1, 'Az oldal tartalma', '', ''),
(77, 'A W3 Suli projekt rÃ©sztvevÅ‘i', 'A_W3_Suli_projekt_resztvevoi', 1, 99, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 1, 'Az oldal tartalma', '', ''),
(78, 'Teszt kategÃ³ria', 'Teszt_kategoria', 1, 0, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 1, 'Az oldal tartalma', '', ''),
(79, 'Teszt hÃ­roldal', 'Teszt_hiroldal', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 1, 2, 'Az oldal tartalma', '', ''),
(81, 't45', 't45', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 78, 1, 'Az oldal tartalma', '', ''),
(82, 't45aaa', 't45aaa', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 81, 1, 'Az oldal tartalma', '', ''),
(86, 'ccccc', 'ccccc', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 78, 1, 'Az oldal tartalma', '', ''),
(87, 'ccccc4565', 'ccccc4565', 1, 1, 'Az oldal leÃ­rÃ¡sa', 'Az oldal kulcsszavai', 86, 1, 'Az oldal tartalma r', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `OldalCikkei`
--

CREATE TABLE IF NOT EXISTS `OldalCikkei` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Oid` int(10) NOT NULL,
  `Cid` int(10) NOT NULL,
  `CPrioritas` smallint(6) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `OldalCikkei`
--

INSERT INTO `OldalCikkei` (`id`, `Oid`, `Cid`, `CPrioritas`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(3, 78, 3, 1),
(4, 78, 4, 1),
(5, 78, 5, 1),
(6, 78, 6, 1),
(7, 78, 7, 1),
(8, 78, 8, 1),
(9, 78, 9, 1),
(10, 78, 10, 1),
(11, 78, 11, 1),
(12, 78, 12, 1),
(13, 78, 13, 1),
(14, 78, 14, 1),
(15, 78, 15, 1),
(16, 78, 16, 1),
(17, 78, 17, 1),
(18, 78, 18, 1),
(19, 78, 19, 1),
(20, 78, 20, 1),
(21, 78, 21, 1),
(22, 78, 22, 1),
(23, 78, 23, 1),
(24, 78, 24, 1),
(25, 40, 25, 1);

-- --------------------------------------------------------

--
-- Table structure for table `OldalKepek`
--

CREATE TABLE IF NOT EXISTS `OldalKepek` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Oid` int(10) NOT NULL,
  `KFile` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KNev` varchar(50) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KLeiras` varchar(255) COLLATE utf8_hungarian_ci NOT NULL DEFAULT '',
  `KSzelesseg` smallint(6) NOT NULL DEFAULT '-1',
  `KMagassag` smallint(6) NOT NULL DEFAULT '-1',
  `KStilus` smallint(6) NOT NULL DEFAULT '0',
  `KSorszam` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=31 ;

--
-- Dumping data for table `OldalKepek`
--

INSERT INTO `OldalKepek` (`id`, `Oid`, `KFile`, `KNev`, `KLeiras`, `KSzelesseg`, `KMagassag`, `KStilus`, `KSorszam`) VALUES
(6, 1, 'kezdolap_3.png', 'rrrrrrrrrrrr', 'fffffffffffffffffffffff', 0, 0, 0, 0),
(8, 1, 'kezdolap_4.png', 'hjjhkjgv', 'ghkgvhgv', 0, 0, 0, 0),
(10, 1, 'kezdolap_5.png', 'rrrrrrrrrrrrr', 'rrrrrrrrrrrrrrrr', 0, 0, 0, 0),
(13, 1, 'kezdolap_2.jpg', 'reeeeeeeeeeee', 'wwwwwwwwwwwww', 0, 0, 0, 0),
(14, 1, 'kezdolap_6.png', '', '', 0, 0, 0, 0),
(25, 1, 'kezdolap_0.jpeg', '', '', 0, 0, 0, 0),
(28, 1, 'kezdolap_8.jpg', '', '', 0, 0, 0, 0),
(29, 1, 'kezdolap_9.jpg', '', '', 0, 0, 0, 0),
(30, 1, 'kezdolap_1.jpg', '', '', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `OModeratorok`
--

CREATE TABLE IF NOT EXISTS `OModeratorok` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `Oid` int(10) NOT NULL,
  `Fid` int(10) NOT NULL DEFAULT '-1',
  `CSid` int(10) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `OModeratorok`
--

INSERT INTO `OModeratorok` (`id`, `Oid`, `Fid`, `CSid`) VALUES
(1, 1, 11, 0),
(3, 1, 12, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
