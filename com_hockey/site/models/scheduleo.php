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
class HockeyModelScheduleo extends JModelLegacy
{
    protected $id_sezon;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $app = JFactory::getApplication();
        $this->id_sezon = (int) $app->input->get('id', 0, 'int');
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

            $id = 'scheduleo-' . $this->id_sezon;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {

                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('M.id, M.id_kolejka, M.data, M.team_1, M.team_2, M.score_1, M.score_2, M.overtime, M.shutouts, M.w1p1, M.w2p1,
                        M.w1p2, M.w2p2, M.w1p3, M.w2p3, M.w1ot, M.w2ot, M.w1so, M.w2so, M.time, T1.name AS team1, T2.name AS team2')
                    ->from('#__hockey_match  as M')
                    ->join('LEFT', '#__hockey_teams as T1 ON M.team_1 = T1.id')
                    ->join('LEFT', '#__hockey_teams as T2 ON M.team_2 = T2.id')
                    ->where('M.id_system = '. $db->Quote($this->id_sezon) .' AND M.type_of_match=2 AND M.state=1 ')
                    ->order('M.id_kolejka, M.data, M.time');

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