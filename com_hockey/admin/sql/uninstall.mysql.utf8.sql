ALTER TABLE `#__hockey_match`
  DROP FOREIGN KEY `FK_#__hockey_match`;

ALTER TABLE `#__hockey_match_goalie`
  DROP FOREIGN KEY `FK_#__hockey_match_goalie`;

ALTER TABLE `#__hockey_match_goals`
  DROP FOREIGN KEY `FK_#__hockey_match_goals`;

ALTER TABLE `#__hockey_match_penalty`
  DROP FOREIGN KEY `FK_#__hockey_match_penalty`;

ALTER TABLE `#__hockey_match_players`
  DROP FOREIGN KEY `FK_#__hockey_players_in_match`;

ALTER TABLE `#__hockey_tabela`
  DROP FOREIGN KEY `FK_#__hockey_tabela`;


DROP TABLE IF EXISTS `#__hockey_tabela`;
DROP TABLE IF EXISTS `#__hockey_match_goals`;
DROP TABLE IF EXISTS `#__hockey_match_goalie`;
DROP TABLE IF EXISTS `#__hockey_match_penalty`;
DROP TABLE IF EXISTS `#__hockey_match_players`;
DROP TABLE IF EXISTS `#__hockey_match`;
DROP TABLE IF EXISTS `#__hockey_players`;
DROP TABLE IF EXISTS `#__hockey_referee`;
DROP TABLE IF EXISTS `#__hockey_teams`;
DROP TABLE IF EXISTS `#__hockey_system`;
