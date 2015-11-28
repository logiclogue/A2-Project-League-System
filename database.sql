n SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 28, 2015 at 11:48 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `computing_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` mediumint(8) unsigned NOT NULL,
  `player1_id` mediumint(8) unsigned NOT NULL,
  `player2_id` mediumint(8) unsigned NOT NULL,
  `player1_score` tinyint(3) unsigned NOT NULL,
  `player2_score` tinyint(3) unsigned NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--

CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tournament_user_maps`
--

CREATE TABLE IF NOT EXISTS `tournament_user_maps` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `tournament_id` mediumint(8) unsigned NOT NULL,
  `is_league_manager` tinyint(1) NOT NULL,
  `is_player` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `hash` varchar(60) NOT NULL,
  `home_phone` varchar(20) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `hash`, `home_phone`, `mobile_number`) VALUES
(23, 'test', 'Jordan', 'Lord', '$2y$10$APlS.VOXfFn3ANvZPHtvJuy9zeyLQ96fEjbDQuJLdDV2mep.sP.OG', NULL, NULL);

