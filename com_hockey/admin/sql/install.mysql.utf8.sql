SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__hockey_match` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `druzyna1` int(11) NOT NULL DEFAULT '0',
  `druzyna2` int(11) NOT NULL DEFAULT '0',
  `wynik_1` tinyint(4) unsigned DEFAULT NULL,
  `wynik_2` tinyint(4) unsigned DEFAULT NULL,
  `m_dogr` enum('T','F') DEFAULT NULL,
  `m_karne` enum('T','F') DEFAULT NULL,
  `id_kolejka` int(10) NOT NULL DEFAULT '0',
  `data` date DEFAULT NULL,
  `time` varchar(5) NOT NULL DEFAULT '00:00',
  `id_system` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
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
  `text` text,
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

CREATE TABLE IF NOT EXISTS `#__hockey_players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwisko` varchar(50) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `pozycja` tinyint(4) DEFAULT '1',
  `data_u` date DEFAULT NULL,
  `wzrost` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `waga` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `klub` int(11) NOT NULL DEFAULT '0',
  `klubold` varchar(50) DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `foto` varchar(100) DEFAULT NULL,
  `opis` text,
  `review_date` datetime NOT NULL,
  `nr` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `nazwisko` (`nazwisko`),
  KEY `klub` (`klub`),
  KEY `pozycja` (`pozycja`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hockey_referee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lname` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `review_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `nazwisko` (`lname`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hockey_system` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(50) NOT NULL,
  `p_w` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_r` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_p` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `p_d_w` tinyint(3) unsigned DEFAULT '0',
  `p_d_p` tinyint(3) unsigned DEFAULT '0',
  `dogr` enum('T','F') NOT NULL DEFAULT 'F',
  `p_k_w` tinyint(3) unsigned DEFAULT '0',
  `p_k_p` tinyint(3) unsigned DEFAULT '0',
  `karne` enum('T','F') NOT NULL DEFAULT 'F',
  `rok` varchar(10) DEFAULT NULL,
  `myteam` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nazwa` (`nazwa`),
  KEY `NewIndex1` (`myteam`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hockey_tabela` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `punkty` int(11) DEFAULT '0',
  `kolejka` tinyint(3) unsigned DEFAULT '0',
  `wygrane` tinyint(3) unsigned DEFAULT '0',
  `remisy` tinyint(3) unsigned DEFAULT '0',
  `przegrane` tinyint(3) unsigned DEFAULT '0',
  `b_strzelone` smallint(5) unsigned DEFAULT '0',
  `b_stracone` smallint(5) unsigned DEFAULT '0',
  `roznica` smallint(6) DEFAULT '0',
  `id_system` int(11) NOT NULL DEFAULT '0',
  `ordering` tinyint(3) unsigned DEFAULT '0',
  `grupa` tinyint(3) unsigned DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `tabela_system` (`id_system`),
  CONSTRAINT `FK_#__hockey_tabela` FOREIGN KEY (`id_system`) REFERENCES `#__hockey_system` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__hockey_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `short` varchar(12) NOT NULL,
  `logo` varchar(30) DEFAULT NULL,
  `published` tinyint(1) NOT NULL,
  `description` text,
  `review_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;