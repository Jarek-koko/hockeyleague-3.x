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
class HockeyModelTable extends JModelLegacy
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

            $id = 'standings-' . $this->id_sezon;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {

                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('Team.name AS team_name ,' . 'Tb.* ')
                    ->from('#__hockey_tables  as Tb')
                    ->join('LEFT', '#__hockey_teams as Team ON Tb.team_id = Team.id')
                    ->where('Tb.id_system = ' . $db->Quote($this->id_sezon) . ' AND Tb.state=1')
                    ->order('Tb.group ASC, Tb.points DESC, Tb.ordering ASC');

                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    JError::raiseError(500, $e->getMessage());
                }

                $this->_item = $db->loadObjectList();
                $cache->store($this->_item, $id);
            }
        }

        return $this->_item;
    }

    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getInfo()
    {

        if (!isset($this->_info)) {
            $cache = JFactory::getCache('com_hockey', '');

            $id = 'standings-info-' . $this->id_sezon;

            $this->_info = $cache->get($id);

            if ($this->_info === false) {

                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select(' * ')
                    ->from('#__hockey_system')
                    ->where('id = ' . $db->Quote($this->id_sezon));
                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    JError::raiseError(500, $e->getMessage());
                }

                $this->_info = $db->loadObject();
                $cache->store($this->_info, $id);
            }
        }
        return $this->_info;
    }

}