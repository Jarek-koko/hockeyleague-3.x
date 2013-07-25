SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__hockey_system` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `p_w` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_r` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_p` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_d_w` tinyint(3) unsigned DEFAULT '0',
  `p_d_p` tinyint(3) unsigned DEFAULT '0',
  `overtime` enum('T','F') NOT NULL DEFAULT 'F',
  `p_k_w` tinyint(3) unsigned DEFAULT '0',
  `p_k_p` tinyint(3) unsigned DEFAULT '0',
  `shutouts` enum('T','F') NOT NULL DEFAULT 'F',
  `year` varchar(10) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hockey_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL,
  `position` tinyint(4) DEFAULT '1',
  `date_of_birth` date DEFAULT NULL,
  `height` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `weight` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `team_id` int(11) NOT NULL DEFAULT '0',
  `team_old` varchar(50) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `photo` varchar(255) DEFAULT NULL,
  `description` text,
  `number` tinyint(3) unsigned DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `team_id` (`team_id`),
  KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hockey_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `short` varchar(12) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `description` text,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hockey_referees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alias` VARCHAR(255) NOT NULL DEFAULT '',
  `first_name` varchar(50) NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hockey_tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `points` int(11) DEFAULT '0',
  `matchday` tinyint(3) unsigned DEFAULT '0',
  `won` tinyint(3) unsigned DEFAULT '0',
  `ties` tinyint(3) unsigned DEFAULT '0',
  `lost` tinyint(3) unsigned DEFAULT '0',
  `goals_scored` smallint(5) unsigned DEFAULT '0',
  `goals_against` smallint(5) unsigned DEFAULT '0',
  `difference` smallint(6) DEFAULT '0',
  `id_system` int(11) NOT NULL DEFAULT '0',
  `ordering` int(11) unsigned DEFAULT '0',
  `group` tinyint(3) unsigned DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tabela_system` (`id_system`),
  CONSTRAINT `FK_#__hockey_tabela` FOREIGN KEY (`id_system`) REFERENCES `#__hockey_system` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hockey_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_1` int(11) NOT NULL DEFAULT '0',
  `team_2` int(11) NOT NULL DEFAULT '0',
  `score_1` tinyint(4) unsigned DEFAULT NULL,
  `score_2` tinyint(4) unsigned DEFAULT NULL,
  `overtime` enum('T','F') DEFAULT NULL,
  `shutouts` enum('T','F') DEFAULT NULL,
  `id_kolejka` int(10) NOT NULL DEFAULT '0',
  `data` date DEFAULT NULL,
  `time` varchar(5) NOT NULL DEFAULT '00:00',
  `id_system` int(11) NOT NULL DEFAULT '0',
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `type_of_match` tinyint(1) NOT NULL DEFAULT '0',
  `w1p1` tinyint(3) unsigned DEFAULT NULL,
  `w2p1` tinyint(3) unsigned DEFAULT NULL,
  `w1p2` tinyint(3) unsigned DEFAULT NULL,
  `w2p2` tinyint(3) unsigned DEFAULT NULL,
  `w1p3` tinyint(3) unsigned DEFAULT NULL,
  `w2p3` tinyint(3) unsigned DEFAULT NULL,
  `w1ot` tinyint(3) unsigned DEFAULT NULL,
  `w2ot` tinyint(3) unsigned DEFAULT NULL,
  `uscore` tinyint(1) DEFAULT '0',
  `w1so` tinyint(3) unsigned DEFAULT NULL,
  `w2so` tinyint(3) unsigned DEFAULT NULL,
  `id_referee1` int(11) DEFAULT NULL,
  `id_referee2` int(11) DEFAULT NULL,
  `id_referee3` int(11) DEFAULT NULL,
  `id_referee4` int(11) DEFAULT NULL,
  `description` text,
  `place` VARCHAR(255)  NOT NULL ,
  `ordering` INT(11)  NOT NULL ,
  `created` DATETIME NOT NULL  DEFAULT '0000-00-00 00:00:00',
  `created_by` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
  `modified` DATETIME NOT NULL  DEFAULT '0000-00-00 00:00:00',
  `modified_by` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
  `checked_out` INT(11)  NOT NULL ,
  `checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id_system` (`id_system`),
  KEY `id_kolejka` (`id_kolejka`),
  KEY `type_of_match` (`type_of_match`),
  CONSTRAINT `FK_#__hockey_match` FOREIGN KEY (`id_system`) REFERENCES `#__hockey_system` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `#__hockey_match_goalie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_match` int(11) NOT NULL,
  `id_player` int(11) NOT NULL,
  `time_p` tinyint(4) unsigned DEFAULT NULL,
  `goals` tinyint(4) unsigned DEFAULT NULL,
  `save` tinyint(4) unsigned DEFAULT NULL,
  `id_team` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex0` (`id_player`),
  KEY `NewIndex1` (`id_match`),
  KEY `NewIndex2` (`id_team`),
  CONSTRAINT `FK_#__hockey_match_goalie` FOREIGN KEY (`id_match`) REFERENCES `#__hockey_match` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__hockey_match_goals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_match` int(11) NOT NULL,
  `shooter` int(11) NOT NULL,
  `assist1` int(11) DEFAULT NULL,
  `assist2` int(11) DEFAULT NULL,
  `time` varchar(5) DEFAULT NULL,
  `score1` tinyint(4) unsigned NOT NULL,
  `score2` tinyint(4) unsigned NOT NULL,
  `id_team` int(11) NOT NULL,
  `period` tinyint(1) DEFAULT NULL,
  `info` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex0` (`id_match`),
  KEY `NewIndex1` (`id_team`),
  KEY `NewIndex2` (`shooter`),
  KEY `NewIndex3` (`assist1`),
  KEY `NewIndex4` (`assist2`),
  CONSTRAINT `FK_#__hockey_match_goals` FOREIGN KEY (`id_match`) REFERENCES `#__hockey_match` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__hockey_match_penalty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_match` int(11) NOT NULL,
  `time` varchar(5) DEFAULT NULL,
  `id_player` int(11) NOT NULL,
  `note` varchar(50) NOT NULL,
  `id_team` int(11) NOT NULL,
  `time_p` tinyint(4) NOT NULL,
  `period` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex0` (`id_match`),
  KEY `NewIndex1` (`id_player`),
  KEY `NewIndex2` (`id_team`),
  CONSTRAINT `FK_#__hockey_match_penalty` FOREIGN KEY (`id_match`) REFERENCES `#__hockey_match` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `#__hockey_match_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_match` int(11) NOT NULL,
  `id_player` int(11) NOT NULL,
  `id_team` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `NewIndex0` (`id_match`),
  KEY `NewIndex1` (`id_player`),
  KEY `NewIndex2` (`id_team`),
  CONSTRAINT `FK_#__hockey_players_in_match` FOREIGN KEY (`id_match`) REFERENCES `#__hockey_match` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;