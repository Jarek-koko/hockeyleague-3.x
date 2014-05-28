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
class HockeyModelModmatch extends JModelLegacy
{
    protected $_id;
    protected $_sez;
    protected $_short;
    protected $_item;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $app = JFactory::getApplication();
        $this->_id = (int) $app->input->get('id', 0, 'get', 'INT');
        $this->_sez = (int) $app->input->get('sez', 0, 'get', 'INT');
        $this->_short = (int) $app->input->get('st', 0, 'get', 'INT');
    }

    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getItems()
    {
        if (!isset($this->_item)) {
            $sname = ($this->_short) ? ' short ' : ' name ';
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'modmatch-' . $this->_id . '-' . $sname;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select("t3.$sname as team1,t2.$sname as team2, t1.score_1, t1.score_2")
                    ->from('#__hockey_match t1')
                    ->join('INNER', '#__hockey_teams t2 ON (t2.id = t1.team_2)')
                    ->join('INNER', '#__hockey_teams t3 ON (t3.id = t1.team_1)')
                    ->where('t1.id_system=' . $db->Quote($this->_sez) . ' AND t1.state=1 AND t1.id_kolejka='. $db->Quote($this->_id).' AND t1.type_of_match=0 ');

                $db->setQuery($query);

                $this->_item = $db->loadObjectList();
                $cache->store($this->_item, $id);
            }
        }
        return $this->_item;
    }
}