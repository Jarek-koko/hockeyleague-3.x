<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.model');
/**
 * Hockey model.
 */
class HockeyModelReport extends JModelLegacy
{

    public function getItem($id_match)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(
                array('m.id AS id', 'm.uscore', 'm.description', 'm.id_referee1', 'm.id_referee2', 'm.id_referee3', 'm.id_referee4', 'm.team_1', 'm.team_2',
                    'm.score_1', 'm.score_2', 'm.overtime', 'm.shutouts', 'm.w1p1', 'm.w2p1', 'm.w1p2', 'm.w2p2', 'm.w1p3', 'm.w2p3', 'm.w1ot', 'm.w2ot', 'm.w1so', 'm.w2so',
                    's.overtime AS ot', 's.shutouts AS shut', 't1.name AS team1', 't2.name AS team2'
            ))
            ->from('#__hockey_match AS m')
            ->join('INNER', '#__hockey_system AS s ON (m.id_system = s.id)')
            ->join('LEFT', '#__hockey_teams AS t1 ON (t1.id = m.team_1)')
            ->join('LEFT', '#__hockey_teams AS t2 ON (t2.id = m.team_2)')
            ->where('m.id = ' . $db->quote($id_match));

        $db->setQuery($query);

        try {
            $item = $db->loadObject();
        } catch (RuntimeException $e) {

            $this->setError($e->getMessage());
            return false;
        }

        if (empty($item)) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_CANNOT_FIND_MATCH'));
            return false;
        }

        return $item;
    }

    public function getReferees()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("id AS value, CONCAT_WS( ' ', name, first_name ) AS text")
            ->from('#__hockey_referees')
            ->where('state=1')
            ->order('text');

        $db->setQuery($query);

        try {
            $options = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }

        return $options;
    }

    public function getPlayers($id_match, $id_team1, $id_team2)
    {
        $id_match = (int) $id_match;
        $id_team1 = (int) $id_team1;
        $id_team2 = (int) $id_team2;

        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('p.id, mp.id_player ,p.name, p.first_name, p.position, p.team_id')
            ->from('#__hockey_players AS p')
            ->join('LEFT', '#__hockey_match_players AS mp ON (p.id = mp.id_player AND mp.id_match=' . $db->quote($id_match)
                . ' AND (mp.id_team=' . $db->quote($id_team1) . ' OR mp.id_team=' . $db->quote($id_team2) . '))')
            ->where('p.state=1 AND (p.team_id=' . $db->quote($id_team1) . ' OR p.team_id=' . $db->quote($id_team2) . ')')
            ->order('p.team_id , p.name');
        $db->setQuery($query);

        try {
            $data = $db->loadAssocList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getTableGoalie()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("g.*,t.name, CONCAT_WS( ' ', p.first_name, p.name ) AS player ")
            ->from('#__hockey_match_goalie AS g')
            ->join('LEFT', '#__hockey_players p ON (p.id = g.id_player) ')
            ->join('LEFT', '#__hockey_teams t ON (t.id = g.id_team) ')
            ->where('g.id_match =' . $db->quote($id));
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getTableGoals()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("g.id, g.time, g.period, IFNULL( info ,' ') AS info ,CONCAT_WS( ':', g.score1, g.score2 ) AS score  ,CONCAT_WS( ' ', p1.first_name, p1.name ) AS shooter , CONCAT_WS( ' ', p2.first_name, p2.name ) AS assist1, CONCAT_WS( ' ', p3.first_name, p3.name ) AS assist2 ")
            ->from('#__hockey_match_goals AS g')
            ->join('LEFT', '#__hockey_players p1 ON (p1.id = g.shooter) ')
            ->join('LEFT', '#__hockey_players p2 ON (p2.id = g.assist1) ')
            ->join('LEFT', '#__hockey_players p3 ON (p3.id = g.assist2) ')
            ->where('g.id_match =' . $db->quote($id))
            ->order('g.score1 , g.score2');
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getTablePenalty()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("p.id, p.time, p.note, p.time_p, p.period, t.name AS team, CONCAT_WS( ' ', pl.first_name, pl.name ) AS player ")
            ->from('#__hockey_match_penalty AS p')
            ->join('LEFT', '#__hockey_players pl ON (pl.id = p.id_player) ')
            ->join('LEFT', '#__hockey_teams t ON (t.id = p.id_team) ')
            ->where('p.id_match =' . $db->quote($id))
            ->order('p.period, p.time');
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getSelectGoalie($team_id)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("id as value , CONCAT_WS( ' ',first_name , name ) AS text")
            ->from("#__hockey_players")
            ->where(" team_id=" . $db->quote($team_id) . " AND position='1'  AND state ='1' ")
            ->order('name');
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getSelectGoals($team_id)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("id as value , CONCAT_WS( ' ',first_name , name ) AS text")
            ->from("#__hockey_players")
            ->where(" team_id=" . $db->quote($team_id) . " AND state ='1' ")
            ->order('name');
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getSelectPenalty($team_id)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select("id as value , CONCAT_WS( ' ',first_name , name ) AS text")
            ->from("#__hockey_players")
            ->where(" team_id=" . $db->quote($team_id) . " AND state ='1' ")
            ->order('name');
        $db->setQuery($query);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getNote($search)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->select("note AS value, note AS data");
        $query->from("#__hockey_match_penalty");
        $search = $db->Quote($db->escape($search, true) . '%');
        $query->where('note LIKE ' . $search);
        $query->group('note');
        $query->order('COUNT(*)', 'desc');
        $db->setQuery($query, 0, 5);
        try {
            $data = $db->loadObjectList();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return $data;
    }

    public function getNameTeames($id)
    {
        $db = JFactory::getDBO();
        $query = "(SELECT t1.id as value, t1.name as text "
            . "FROM #__hockey_match AS m "
            . "LEFT JOIN #__hockey_teams AS t1 ON  ( t1.id = m.team_1) "
            . "WHERE m.id =" . $db->quote($id)
            . ") UNION ALL ("
            . "SELECT t2.id as value, t2.name as text "
            . "FROM #__hockey_match AS m "
            . "LEFT JOIN #__hockey_teams AS t2 ON  ( t2.id = m.team_2) "
            . "WHERE m.id =" . $db->quote($id) . ')';
        $db->setQuery($query);
        $teams = $db->loadObjectList();

        if (empty($teams)) {
            $teams = new JObject;
            $teams->value = 0;
            $teams->text = JText::_('COM_HOCKEY_ERROR_NO_TEAMS');
        }
        return $teams;
    }

    public function RemoveGoalie()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('item_id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->delete("#__hockey_match_goalie")
            ->where('id=' . $db->quote($id));
        $db->setQuery($query);
        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    public function RemoveGoals()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('item_id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->delete("#__hockey_match_goals")
            ->where('id=' . $db->quote($id));
        $db->setQuery($query);
        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    public function RemovePenalty()
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('item_id', 0, 'int');
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->delete("#__hockey_match_penalty")
            ->where('id=' . $db->quote($id));
        $db->setQuery($query);
        try {
            $db->execute();
        } catch (RuntimeException $e) {
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    public function setPenalty()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $obj = new JObject;
        $obj->id_match = (int) $app->input->get('id', 0, 'int');
        $obj->time = $app->input->get('time', null, 'string');
        $obj->time_p = (int) $app->input->get('time_p', 0, 'int');
        $obj->note = $app->input->get('note', null, 'string');
        $obj->id_player = (int) $app->input->get('id_player_penalty', 0, 'int');
        $obj->id_team = (int) $app->input->get('id_team_penalty', 0, 'int');
        $obj->period = (int) $app->input->get('period_penalty', 0, 'int');

        if (!$db->insertObject('#__hockey_match_penalty', $obj)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setGoalie()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $obj = new JObject;
        $obj->id_match = (int) $app->input->get('id', 0, 'int');
        $obj->id_player = (int) $app->input->get('id_player', 0, 'int');
        $obj->time_p = (int) $app->input->get('time_p', 0, 'int');
        $obj->goals = (int) $app->input->get('goals', 0, 'int');
        $obj->save = (int) $app->input->get('save', 0, 'int');
        $obj->id_team = (int) $app->input->get('id_team', 0, 'int');

        if (!$db->insertObject('#__hockey_match_goalie', $obj)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setGoals()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $obj = new JObject;
        $obj->id_match = (int) $app->input->get('id', 0, 'int');
        $obj->shooter = (int) $app->input->get('shooter', 0, 'int');
        $obj->assist1 = (int) $app->input->get('assist1', null, 'int');
        $obj->assist2 = (int) $app->input->get('assist2', null, 'int');
        $obj->time = $app->input->get('time', null, 'string');
        $obj->score1 = (int) $app->input->get('score1', 0, 'int');
        $obj->score2 = (int) $app->input->get('score2', 0, 'int');
        $obj->id_team = (int) $app->input->get('id_team_goals', 0, 'int');
        $obj->period = (int) $app->input->get('period_goals', 0, 'int');
        $obj->info = $app->input->get('info', null, 'string');

        if (!$db->insertObject('#__hockey_match_goals', $obj)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setResult()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();

        $id = $app->input->get('id', 0, 'int');
        $score_1 = $app->input->get('score_1', 0, 'int');
        $score_2 = $app->input->get('score_2', 0, 'int');
        $w1p1 = $app->input->get('w1p1', null, 'string');
        $w2p1 = $app->input->get('w2p1', null, 'string');
        $w1p2 = $app->input->get('w1p2', null, 'string');
        $w2p2 = $app->input->get('w2p2', null, 'string');
        $w1p3 = $app->input->get('w1p3', null, 'string');
        $w2p3 = $app->input->get('w2p3', null, 'string');
        $w1ot = $app->input->get('w1ot', null, 'string');
        $w2ot = $app->input->get('w2ot', null, 'string');
        $w1so = $app->input->get('w1so', null, 'string');
        $w2so = $app->input->get('w2so', null, 'string');
        $overtime = $app->input->get('overtime', null, 'string');
        $shutouts = $app->input->get('shutouts', null, 'string');

        $obj = new JObject;
        $obj->id = (int) $id;
        $obj->score_1 = (int) $score_1;
        $obj->score_2 = (int) $score_2;
        $obj->w1p1 = ($w1p1 !== "") ? (int) $w1p1 : NULL;
        $obj->w2p1 = ($w2p1 !== "") ? (int) $w2p1 : NULL;
        $obj->w1p2 = ($w1p2 !== "") ? (int) $w1p2 : NULL;
        $obj->w2p2 = ($w2p2 !== "") ? (int) $w2p2 : NULL;
        $obj->w1p3 = ($w1p3 !== "") ? (int) $w1p3 : NULL;
        $obj->w2p3 = ($w2p3 !== "") ? (int) $w2p3 : NULL;

        if ($overtime == "T") {
            $obj->overtime = "T";
            $obj->w1ot = ($w1ot !== "") ? (int) $w1ot : NULL;
            $obj->w2ot = ($w2ot !== "") ? (int) $w2ot : NULL;
        } else {
            $obj->overtime = "F";
            $obj->w1ot = NULL;
            $obj->w2ot = NULL;
        }

        if ($shutouts == "T") {
            $obj->shutouts = "T";
            $obj->w1so = ($w1so !== "") ? (int) $w1so : NULL;
            $obj->w2so = ($w2so !== "") ? (int) $w2so : NULL;
        } else {
            $obj->shutouts = "F";
            $obj->w1so = NULL;
            $obj->w2so = NULL;
        }

        if (!$db->updateObject('#__hockey_match', $obj, 'id', true)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setDescription()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $id = $app->input->get('id', 0, 'int');
        $description = $app->input->get('description', null, 'RAW');

        $obj = new JObject;
        $obj->id = (int) $id;
        $obj->description = $description;

        if (!$db->updateObject('#__hockey_match', $obj, 'id', true)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setReferees()
    {
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $id = $app->input->get('id', 0, 'int');
        $id_referee1 = $app->input->get('id_referee1', 0, 'int');
        $id_referee2 = $app->input->get('id_referee2', 0, 'int');
        $id_referee3 = $app->input->get('id_referee3', 0, 'int');
        $id_referee4 = $app->input->get('id_referee4', 0, 'int');

        $obj = new JObject;
        $obj->id = (int) $id;
        $obj->id_referee1 = ($id_referee1 != 0) ? $id_referee1 : NULL;
        $obj->id_referee2 = ($id_referee2 != 0) ? $id_referee2 : NULL;
        $obj->id_referee3 = ($id_referee3 != 0) ? $id_referee3 : NULL;
        $obj->id_referee4 = ($id_referee4 != 0) ? $id_referee4 : NULL;

        if (!$db->updateObject('#__hockey_match', $obj, 'id', true)) {
            $this->setError($db->getErrorMsg());
            return false;
        }
        return true;
    }

    public function setMatchday()
    {
        JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/hockey.php');
        $db = JFactory::getDbo();
        $app = JFactory::getApplication();
        $date = JFactory::getDate();
        $user = JFactory::getUser();
        $query = $db->getQuery(true);

        $nr = $app->input->get('nr_match', 0, 'int');
        $id_system = HockeyHelper::getSezon();
        $type_of_match = 0;
        $state = 1;
        $created_by = $user->get('id');
        $created = $date->toSql();

        $columns = array('team_1', 'team_2', 'id_kolejka', 'data', 'time', 'id_system',
            'state', 'type_of_match', 'place', 'created', 'created_by'
        );
        $query->insert('#__hockey_match');
        $query->columns($db->quoteName($columns));

        for ($i = 1; $i <= $nr; $i++) {
            $id_kolejka = $app->input->get('id_kolejka' . $i, 0, 'int');
            $data = $app->input->get('data' . $i, null, 'cmd');
            $time = $app->input->get('time' . $i, null, 'string');
            $place = $app->input->get('place' . $i, null, 'string');
            $team_1 = $app->input->get('team_1' . $i, 0, 'int');
            $team_2 = $app->input->get('team_2' . $i, 0, 'int');

            $values = array($db->quote($team_1), $db->quote($team_2), $db->quote($id_kolejka), $db->quote($data),
                $db->quote($time), $db->quote($id_system), $db->quote($state), $db->quote($type_of_match),
                $db->quote($place), $db->quote($created), $db->quote($created_by)
            );
            $query->values(implode(',', $values));
        }

        $db->setQuery($query);
        try {

            $db->execute();
        } catch (RuntimeException $e) {

            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }

    public function setComposition()
    {
        $app = JFactory::getApplication();
        $id = $app->input->get('id', 0, 'int');

        $players1 = $app->input->get('players1', null, 'array');
        $players2 = $app->input->get('players2', null, 'array');

        $team1 = $app->input->get('team_1', null, 'int');
        $team2 = $app->input->get('team_2', null, 'int');

        // Delete the old composition team.
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->delete($db->quoteName('#__hockey_match_players'))
            ->where($db->quoteName('id_match').' = '.$db->quote($id));
        $db->setQuery($query);
        $db->execute();

        if (count($players1)) {
            if (!$this->_savePlayers($id, $players1, $team1)) {
                return false;
            }
        }

        if (count($players2)) {
            if (!$this->_savePlayers($id, $players2, $team2)) {
                return false;
            }
        }
        return true;
    }

    private function _savePlayers($id_match, $players, $team)
    {
        $id_match = (int) $id_match;
        $team = (int) $team;
        JArrayHelper::toInteger($players);
        $count = count($players);
        if ($count) {
            $db = JFactory::getDBO();
            $query = $db->getQuery(true);

            $query->insert('#__hockey_match_players');
            $query->columns(array($db->quoteName('id_match'), $db->quoteName('id_player'), $db->quoteName('id_team')));

            foreach ($players as $player) {
                $query->values( $db->quote($id_match). ',' . $db->quote($player). ',' .$db->quote($team));
            }
            $db->setQuery($query);
            return (boolean) $db->execute();
        }
        return false;
    }

}