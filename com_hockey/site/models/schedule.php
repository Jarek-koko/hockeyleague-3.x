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
class HockeyModelSchedule extends JModelLegacy
{
    private $_idsezon = null;
    private $_tom = null;
    private $_list = null;
    private $_idteam = 0;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $app = JFactory::getApplication();
        $this->_idsezon = (int) $app->input->get('id', 0, 'int');
        $this->_tom = (int) $app->input->get('type_id', 0, 'int');
    }

    public function setIdTeam($idteam)
    {
        $this->_idteam = (int) $idteam;
    }

    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getItems()
    {
        if (!isset($this->_list)) {
            
            $myteam = ($this->_idteam != 0 ) ? $this->_idteam : false;

            $where = '';
            if ($myteam) {
                $where = ' AND (M.team_1=' . $myteam . ' OR M.team_2=' . $myteam . ') ';
            }

            switch ($this->_tom) {
                case 2:
                    $tom = ' AND (M.type_of_match=2) ';
                    break;
                case 1:
                    $tom = ' AND (M.type_of_match=1) ';
                    break;
                default:
                    $tom = ' AND (M.type_of_match=0) ';
                    break;
            }
            
            $db = $this->getDbo();
            $query = $db->getQuery(true)
                    ->select('M.id, M.data, T1.name AS team1, T2.name AS team2, M.team_1, M.team_2, M.score_1, M.score_2, M.overtime, M.shutouts ,M.id_kolejka ,M.type_of_match,
                         MONTH(M.data) as mm ,M.w1p1,M.w2p1,M.w1p2,M.w2p2,M.w1p3,M.w2p3,M.w1ot,M.w2ot,M.w1so,M.w2so,M.time ')
                    ->from('#__hockey_match M')
                    ->join('LEFT', '#__hockey_teams T1 ON (M.team_1=T1.id) ')
                    ->join('LEFT', '#__hockey_teams T2 ON (M.team_2=T2.id) ')
                    ->where('M.state=1 ' . $where . ' ' . $tom . ' AND M.id_system=' . $db->Quote($this->_idsezon))
                    ->order('M.data,M.id_kolejka');

            $db->setQuery($query);

            $this->_list = $db->loadObjectList();
        }
        return $this->_list;
    }

}