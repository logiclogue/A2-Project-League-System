
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";






CREATE TABLE IF NOT EXISTS `results` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `tournament_id` mediumint(8) unsigned NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `result_user_maps` (
  `result_id` mediumint(8) unsigned NOT NULL,
  `user_id` mediumint(8) unsigned NOT NULL,
  `score` tinyint(3) unsigned NOT NULL,
  `rating` smallint(6) NOT NULL,
  `rating_change` smallint(6) NOT NULL,
  PRIMARY KEY (`result_id`, `user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `tournaments` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `tournament_user_maps` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `tournament_id` mediumint(8) unsigned NOT NULL,
  `is_league_manager` tinyint(1) NOT NULL,
  `is_player` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_id`,`tournament_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL UNIQUE,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `hash` varchar(60) NOT NULL,
  `home_phone` varchar(20) DEFAULT NULL,
  `mobile_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

