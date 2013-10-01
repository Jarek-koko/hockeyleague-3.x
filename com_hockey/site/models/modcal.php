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
class HockeyModelModcal extends JModelLegacy
{
    protected $_mdate;
    protected $_year;
    protected $_month;
    protected $_day;
    protected $_id_team;
    protected $_sez;

    public function __construct($config = array())
    {
        parent::__construct($config);
        
        $app = JFactory::getApplication();
        $this->_mdate = $app->input->get('mdate', null, 'cmd');
        $this->_id_team =   (int) $app->input->get('id', 0 , 'int');
        $this->_sez =       (int) $app->input->get('sez', 0, 'int');
        
        list( $this->_year, $this->_month, $this->_day ) = explode('-', $this->_mdate);
    }

    public function getItems()
    {
        if (!checkdate($this->_month, $this->_day, $this->_year)) {
            JError::raiseError(404, JText::_("Data not found"));
            return false;
        }

        $db = $this->getDbo();

        if ($this->_id_team != 0) {
            $where = " AND (m.team_1=".$db->Quote($this->_id_team)." OR  m.team_2=".$db->Quote($this->_id_team).") ";
        } else {
            $where = "";
        }

        $query = "SELECT t2.name AS home, t3.name AS visitor, m.team_1, m.team_2, m.data, m.time, "
                . "m.score_1, m.score_2, t2.logo AS logo1, t3.logo AS logo2 "
                . "FROM #__hockey_match m "
                . "LEFT JOIN #__hockey_teams t2 ON ( t2.id = m.team_1 ) "
                . "LEFT JOIN #__hockey_teams t3 ON ( t3.id = m.team_2 ) "
                . "WHERE (m.id_system=" .$db->Quote($this->_sez).") "
                . "AND (DAY(m.data) = ".$db->Quote($this->_day).") "
                . "AND (MONTH(m.data)=".$db->Quote($this->_month).") "
                . "AND (YEAR(m.data)=".$db->Quote($this->_year).") AND (m.state=1)  "
                .$where;

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
        }
        return $db->loadObjectList();
    }

}