<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
class HockeyModelPlayer extends JModelLegacy
{
    private $_idteam = null;
    private $_idplayer = null;
    private $_player = null;
    private $_goalie = false;


    public function __construct($config = array())
    {
        parent::__construct($config);
        $app = JFactory::getApplication();
        $this->_idplayer = (int) $app->input->get('id', 0, 'int');
    }
    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getItem()
    {
        if (!isset($this->_player)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'player-item' . $this->_idplayer;
            $this->_player = $cache->get($id);

            if ($this->_player === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('P.id,P.name,P.first_name,P.position, P.date_of_birth , P.photo, P.height, P.weight,  P.team_old ,P.team_id, P.description,P.number, T.name AS team_name')
                    ->from('#__hockey_players  P')
                    ->join('LEFT', '#__hockey_teams T ON T.id = P.team_id')
                    ->where('P.id=' . $db->Quote($this->_idplayer));

                $db->setQuery($query);

                $this->_player = $db->loadObject();
                $cache->store($this->_player, $id);
            }

            if ($this->_player != null) {
                if ($this->_player->position == 1)
                    $this->_goalie = true;
                $this->_idteam = $this->_player->team_id;
            }
        }
        return $this->_player;
    }

    public function getSelectPlayers()
    {
        if (!isset($this->_pl_list)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'player-list' . $this->_idplayer;
            $this->_pl_list = $cache->get($id);

            if ($this->_pl_list === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select("id AS value, CONCAT_WS('. ',name,LEFT(first_name,1)) AS text ")
                    ->from('#__hockey_players')
                    ->where('state=1 AND team_id=' . $db->Quote($this->_idteam))
                    ->order('name');

                $db->setQuery($query);

                $this->_pl_list = $db->loadObjectList();
                $cache->store($this->_pl_list, $id);
            }
        }
        return $this->_pl_list;
    }

    public function getStatplayer($i)
    {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'player-stats'. $this->_idplayer.$i;
            $this->_stats = $cache->get($id);

            if ($this->_stats === false) {
                $db = $this->getDbo();
                $db->getQuery(true);

                if ($this->_goalie) {
                    $query = "SELECT S.name, "
                        . "COALESCE((SELECT SUM(G.goals) "
                        . "FROM  #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.id_player=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system ),0) AS total_goals, "
                        . "COALESCE((SELECT SUM(G.save) "
                        . "FROM  #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.id_player=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system ),0) AS total_save, "
                        . "COALESCE((SELECT SUM(G.time_p) "
                        . "FROM  #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goalie G  ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.id_player=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system ),0) AS time_match, "
                        . "COALESCE((SELECT COUNT(G.shooter) "
                        . "FROM  #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.shooter=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system)  "
                        . "GROUP BY M.id_system),0) AS shoot, "
                        . "COALESCE((SELECT COUNT(G.assist1) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.assist1=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0)+ "
                        . "COALESCE((SELECT COUNT(G.assist2) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.assist2=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS assist, "
                        . "COALESCE((SELECT COUNT(P.id_player) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_players P ON (P.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND P.id_player=".$db->Quote($this->_idplayer)." AND P.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS meczy, "
                        . "COALESCE((SELECT SUM(P.time_p) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_penalty P ON (P.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND P.id_player=".$db->Quote($this->_idplayer)." AND P.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS kary "
                        . "FROM #__hockey_system S HAVING (meczy <> 0)";
                } else {
                    $query = "SELECT S.name, "
                        . "COALESCE((SELECT COUNT(G.shooter) "
                        . "FROM  #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.shooter=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system)  "
                        . "GROUP BY M.id_system),0) AS shoot, "
                        . "COALESCE((SELECT COUNT(G.assist1) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.assist1=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)."  AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0)+ "
                        . "COALESCE((SELECT COUNT(G.assist2) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND G.assist2=".$db->Quote($this->_idplayer)." AND G.id_team = ".$db->Quote($this->_idteam)."  AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS assist, "
                        . "COALESCE((SELECT COUNT(P.id_player) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_players P ON (P.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND P.id_player=".$db->Quote($this->_idplayer)." AND P.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS meczy, "
                        . "COALESCE((SELECT SUM(P.time_p) "
                        . "FROM #__hockey_match M "
                        . "LEFT JOIN #__hockey_match_penalty P ON (P.id_match = M.id) "
                        . "WHERE (M.type_of_match =".$db->Quote($i)." AND P.id_player=".$db->Quote($this->_idplayer)." AND P.id_team = ".$db->Quote($this->_idteam)." AND S.id = M.id_system) "
                        . "GROUP BY M.id_system),0) AS kary "
                        . "FROM #__hockey_system S HAVING (meczy <> 0) ";
                }
                
                $db->setQuery($query);
                $this->_stats = $db->loadObjectList();
                $cache->store($this->_stats, $id);
            }
        
        return $this->_stats;
    }
}