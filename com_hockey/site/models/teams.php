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
class HockeyModelTeams extends JModelLegacy
{
    protected $id_sezon;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $app = JFactory::getApplication();
        $this->id_sezon = (int) $app->input->get('id', 0, 'int');
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

            $id = 'teams-' . $this->id_sezon;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {

                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('N.name, N.logo, N.description')
                    ->from('#__hockey_tables AS T')
                    ->join('INNER', '#__hockey_teams AS N ON T.team_id = N.id')
                    ->where('T.id_system = ' . $db->Quote($this->id_sezon) . ' AND T.state=1')
                    ->order('N.name');

                $db->setQuery($query);
                $this->_item = $db->loadObjectList();
                $cache->store($this->_item, $id);
            }
        }
        return $this->_item;
    }
}