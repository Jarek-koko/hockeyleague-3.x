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
class HockeyModelPlayers_flash extends JModelLegacy
{
    protected $id_team;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $app = JFactory::getApplication();
        $this->id_team = (int) $app->input->get('id', 0, 'int');
    }

    /**
     * Get the data.
     *
     * @return  object
     */
    public function getItems()
    {

        if (!isset($this->_item)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'players_flash_' . $this->id_team;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {

                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select(' * ')
                    ->from('#__hockey_players')
                    ->where('team_id = '.$db->Quote($this->id_team).' AND state=1')
                    ->order('name, first_name');

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
}