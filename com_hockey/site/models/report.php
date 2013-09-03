<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;
/**
 * Hockey model.
 */
class HockeyModelReport extends JModelLegacy
{
    protected $_id;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $app = JFactory::getApplication();
        $this->_id = (int) $app->input->get('id', 0, 'int');
    }

    public function getList()
    {
        if (!isset($this->_list)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'list-' . $this->_id;
            $this->_list = $cache->get($id);

            if ($this->_list === false) {

                $query = "SELECT t2.name AS home, t1.w1p1, t1.w2p1, t1.w1p2, t1.w2p2, t1.w1p3, t1.w2p3, t1.w1ot, t1.w2ot, t1.w1so, t1.w2so, t3.name AS visitor, t1.team_1, t1.team_2, t1.data,"
                    . "t1.score_1, t1.score_2, t2.logo AS logo1, t3.logo AS logo2, t1.place, "
                    . "CONCAT_WS( ' ', r1.name, r1.first_name ) AS referee1, "
                    . "CONCAT_WS( ' ', r2.name, r2.first_name ) AS referee2, "
                    . "CONCAT_WS( ' ', r3.name, r3.first_name ) AS referee3, "
                    . "CONCAT_WS( ' ', r4.name, r4.first_name ) AS referee4, t1.description "
                    . "FROM #__hockey_match t1 "
                    . "LEFT JOIN #__hockey_teams t2 ON ( t2.id = t1.team_1 ) "
                    . "LEFT JOIN #__hockey_teams t3 ON ( t3.id = t1.team_2 ) "
                    . "LEFT JOIN #__hockey_referees r1 ON (r1.id = t1.id_referee1) "
                    . "LEFT JOIN #__hockey_referees r2 ON (r2.id = t1.id_referee2) "
                    . "LEFT JOIN #__hockey_referees r3 ON (r3.id = t1.id_referee3) "
                    . "LEFT JOIN #__hockey_referees r4 ON (r4.id = t1.id_referee4) "
                    . "WHERE t1.id =" . $this->_db->Quote($this->_id);

                $this->_db->setQuery($query);

                try {
                    $this->_db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }

                $this->_list = $this->_db->loadAssoc();
                $cache->store($this->_list, $id);
            }
        }
        return $this->_list;
    }

    public function getPenalty()
    {
        if (!isset($this->_penl)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'penl-' . $this->_id;
            $this->_penl = $cache->get($id);

            if ($this->_penl === false) {

                $query = "SELECT t1.*, CONCAT_WS( ' ', t2.first_name, t2.name ) AS player "
                    . "FROM #__hockey_match_penalty t1 "
                    . "LEFT JOIN #__hockey_players t2 ON ( t2.id = t1.id_player ) "
                    . "WHERE t1.id_match=" . $this->_db->Quote($this->_id)
                    . " ORDER BY t1.period, t1.time";

                $this->_db->setQuery($query);

                try {
                    $this->_db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }

                $this->_penl = $this->_db->loadObjectList();
                $cache->store($this->_penl, $id);
            }
        }
        return $this->_penl;
    }

    public function getGoals()
    {
        if (!isset($this->_goals)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'goals-' . $this->_id;
            $this->_goals = $cache->get($id);

            if ($this->_goals === false) {

                $query = "SELECT t1.*, "
                    . "CONCAT_WS( ' ', t2.first_name, t2.name ) AS shooter, "
                    . "CONCAT_WS( ' ', t3.first_name, t3.name ) AS assist1, "
                    . "CONCAT_WS( ' ', t4.first_name, t4.name ) AS assist2  "
                    . "FROM #__hockey_match_goals t1 "
                    . "LEFT JOIN #__hockey_players t2 ON ( t2.id = t1.shooter ) "
                    . "LEFT JOIN #__hockey_players t3 ON ( t3.id = t1.assist1 ) "
                    . "LEFT JOIN #__hockey_players t4 ON ( t4.id = t1.assist2 ) "
                    . "WHERE t1.id_match=" . $this->_db->Quote($this->_id)
                    . " ORDER BY t1.period, t1.score1, t1.score2 ASC";

                $this->_db->setQuery($query);

                try {
                    $this->_db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }
                $this->_goals = $this->_db->loadObjectList();
                $cache->store($this->_goals, $id);
            }
        }
        return $this->_goals;
    }

    public function getPlayers()
    {
        if (!isset($this->_play)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'play-' . $this->_id;
            $this->_play = $cache->get($id);

            if ($this->_play === false) {
                $query = "SELECT M.id, CONCAT_WS('.', LEFT(P.first_name,1),P.name) AS name , M.id_team, P.position, P.number, "
                    . "COALESCE(( SELECT COUNT(G.shooter) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.shooter = P.id )),0) AS bramki, "
                    . "COALESCE(( SELECT COUNT(G.assist1) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.assist1 = P.id )),0) + "
                    . "COALESCE(( SELECT COUNT(G.assist2) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.assist2 = P.id )),0) AS asysta, "
                    . "COALESCE(( SELECT SUM(G.time_p) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
                    . "WHERE (M.id =" . $this->_db->Quote($this->_id) . " AND G.id_player = P.id )),0)  AS kary "
                    . "FROM #__hockey_match_players M "
                    . "INNER JOIN #__hockey_players P ON (P.id = M.id_player) "
                    . "WHERE M.id_match=" . $this->_db->Quote($this->_id) . " AND P.position <> 1 "
                    . "ORDER BY M.id_team, P.position, P.name ";

                $this->_db->setQuery($query);

                try {
                    $this->_db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }
                $this->_play = $this->_db->loadObjectList();
                $cache->store($this->_play, $id);
            }
        }
        return $this->_play;
    }

    public function getGoalie()
    {

        if (!isset($this->_golie)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'golie-' . $this->_id;
            $this->_golie = $cache->get($id);

            if ($this->_golie === false) {
                $query = "SELECT M.id,CONCAT_WS('.', LEFT(P.first_name,1),P.name) AS name , M.id_team, P.position, P.number, M.time_p, M.goals, M.save, "
                    . "COALESCE(( SELECT COUNT(G.shooter) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.shooter = P.id )),0) AS bramki, "
                    . "COALESCE(( SELECT COUNT(G.assist1) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.assist1 = P.id )),0) + "
                    . "COALESCE(( SELECT COUNT(G.assist2) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_goals G ON (G.id_match = M.id) "
                    . "WHERE ( M.id=" . $this->_db->Quote($this->_id) . " AND G.assist2 = P.id )),0) AS asysta, "
                    . "COALESCE(( SELECT SUM(G.time_p) "
                    . "FROM #__hockey_match M "
                    . "INNER JOIN #__hockey_match_penalty G ON (G.id_match = M.id) "
                    . "WHERE (M.id =" . $this->_db->Quote($this->_id) . " AND G.id_player = P.id )),0)  AS kary "
                    . "FROM #__hockey_match_goalie M "
                    . "INNER JOIN #__hockey_players P ON (P.id = M.id_player) "
                    . "WHERE M.id_match=" . $this->_db->Quote($this->_id) . " AND P.position = 1 "
                    . "ORDER BY M.id_team, P.position, P.name";

                $this->_db->setQuery($query);
                try {
                    $this->_db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }
                $this->_golie = $this->_db->loadObjectList();
                $cache->store($this->_golie, $id);
            }
        }
        return $this->_golie;
    }

}