<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
/**
 * Hockey model.
 */
class HockeyModelStatsteam extends JModelLegacy
{
    private $_myteam = null;

    public function setTeam($idteam)
    {
        $this->_myteam = (int) $idteam;
    }

    public function getListPlayers($type, $sez)
    {
        $cache = JFactory::getCache('com_hockey', '');
        $id = 'stats-player' . $this->_myteam .$sez.$type ;
     
        $this->_stats = $cache->get($id);

        if ($this->_stats === false) {
            $db = $this->getDbo();
            $db->getQuery(true);
            $query = "SELECT P.id,P.first_name,P.name,P.photo,P.position, "
                . "COALESCE(( SELECT COUNT(G.shooter) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.shooter = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0) AS bramki, "
                . "COALESCE(( SELECT COUNT(G.assist1) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist1 = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0) + "
                . "COALESCE(( SELECT COUNT(G.assist2) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist2 = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS asysty, "
                . "COALESCE(( SELECT COUNT(G.id_player) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_players  G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS mecze, "
                . "COALESCE(( SELECT COUNT(G.shooter) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.shooter = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0) + "
                . "COALESCE((SELECT COUNT(G.assist1) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist1 = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0) + "
                . "COALESCE(( SELECT COUNT(G.assist2) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist2 = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS punkty, "
                . "COALESCE(( SELECT SUM(G.time_p) "
                . "FROM #__hockey_match M "
                . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
                . "WHERE (M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND  G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS kary "
                . "FROM #__hockey_players AS P "
                . "WHERE (P.position!=1 ) HAVING mecze <>'0' "
                . "ORDER BY punkty DESC , bramki DESC, mecze DESC";

            $db->setQuery($query);
            $this->_stats = $db->loadObjectList();
            $cache->store($this->_stats, $id);
        } 
        
        return $this->_stats;
    }

    public function getListGolies($type, $sez)
    {
        $cache = JFactory::getCache('com_hockey', '');
        $id = 'stats-golies' . $this->_myteam . $sez . $type;
        $this->_lists = $cache->get($id);

        if ($this->_lists === false) {
            $db = $this->getDbo();
            $db->getQuery(true);

        $query = "SELECT P.id,P.first_name,P.name,P.photo,P.position, "
            . "COALESCE(( SELECT sum(G.goals) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0) AS total_goals, "
            . "COALESCE(( SELECT sum(G.save) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0) AS total_save, "
            . "COALESCE(( SELECT sum(G.time_p) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goalie G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0) AS time_match, "
            . "COALESCE(( SELECT COUNT(G.shooter) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.shooter = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0) AS bramki, "
            . "COALESCE(( SELECT COUNT(G.assist1) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist1 = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0) + "
            . "COALESCE(( SELECT COUNT(G.assist2) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.assist2 = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS asysty, "
            . "COALESCE(( SELECT COUNT(G.id_player) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_players  G ON (G.id_match = M.id) "
            . "WHERE ( M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS mecze, "
            . "COALESCE(( SELECT SUM(G.time_p) "
            . "FROM #__hockey_match M "
            . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
            . "WHERE (M.type_of_match =".$db->Quote($type)." AND G.id_player = P.id AND M.id_system=".$db->Quote($sez)." AND G.id_team = ".$db->Quote($this->_myteam)." )),0)  AS kary "
            . "FROM #__hockey_players AS P "
            . "WHERE (P.position=1 ) HAVING mecze <>'0' ";
            
            $db->setQuery($query);
            $this->_lists = $db->loadObjectList();
            $cache->store($this->_lists, $id);

            }
        return $this->_lists;
    }
}