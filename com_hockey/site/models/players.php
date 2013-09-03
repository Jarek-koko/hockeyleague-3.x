<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class HockeyModelPlayers extends JModelLegacy
{
    private $_team;

    public function setTeam($id)
    {
        $this->_team = (int) $id;
    }

    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getItems()
    {
        if (!isset($this->_item)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'players-list' . $this->_team;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('P.id, P.name, P.first_name ,P.position, P.date_of_birth , P.photo, P.height, P.weight, P.team_old, P.number')
                    ->from('#__hockey_players  P')
                    ->where('P.state=1 AND P.team_id=' . $db->Quote($this->_team))
                    ->order('P.position ,P.name, P.first_name');

                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }

                $this->_item = $db->loadObjectList();
                $cache->store($this->_item, $id);
            }
        }

        return $this->_item;
    }

    public function getNameTeam()
    {
        if (!isset($this->_name)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'players-team' . $this->_team;
            $this->_name = $cache->get($id);

            if ($this->_name === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('name')
                    ->from('#__hockey_teams')
                    ->where('id=' . $db->Quote($this->_team));
                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }

                $this->_name = $db->loadResult();
                $cache->store($this->_name, $id);
            }
        }
        return $this->_name;
    }
}