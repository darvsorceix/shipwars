-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 18 Lut 2018, 12:52
-- Wersja serwera: 5.7.19
-- Wersja PHP: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shipwars`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_player_a` text COLLATE utf8_polish_ci NOT NULL,
  `m_player_b` text COLLATE utf8_polish_ci NOT NULL,
  `m_winner` text COLLATE utf8_polish_ci NOT NULL,
  `m_time` datetime NOT NULL,
  `m_p_a_accept` int(11) NOT NULL DEFAULT '0',
  `m_p_b_accept` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `matches_details`
--

DROP TABLE IF EXISTS `matches_details`;
CREATE TABLE IF NOT EXISTS `matches_details` (
  `md_id` int(11) NOT NULL AUTO_INCREMENT,
  `md_match` int(11) NOT NULL,
  `md_player_a_fields` text COLLATE utf8_polish_ci NOT NULL,
  `md_player_b_fields` text COLLATE utf8_polish_ci NOT NULL,
  `md_player_a_points` int(11) NOT NULL DEFAULT '0',
  `md_player_b_points` int(11) NOT NULL DEFAULT '0',
  `md_turn` text COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`md_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `queue`
--

DROP TABLE IF EXISTS `queue`;
CREATE TABLE IF NOT EXISTS `queue` (
  `q_id` int(11) NOT NULL AUTO_INCREMENT,
  `q_user_id` text COLLATE utf8_polish_ci NOT NULL,
  `q_time` datetime NOT NULL,
  PRIMARY KEY (`q_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email` text NOT NULL,
  `user_login` text NOT NULL,
  `user_password` text NOT NULL,
  `user_registered` text NOT NULL,
  `user_key` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_login`, `user_password`, `user_registered`, `user_key`) VALUES
(1, 'admin@admin.pl', 'admin', '$2y$10$ztOSK9igg1cBcm13Bd8nm.zqW4AfV.EGLaIMpr3GUG2Q6n2QXFDOy', '2018-02-02 23:15:11', 'yab957e0764084679e8bff5529af5963'),
(2, 'admin2@admin.pl', 'adam', '$2y$10$XMYEazwOdLbkt1/18FKqI.2DViLXfShzy0NFh.Td9dNqyp4.o3Juu', '2018-02-02 23:15:59', 'b46e7810130ad3d63d86a3ded428157a');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
