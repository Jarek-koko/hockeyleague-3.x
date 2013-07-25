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

require_once JPATH_COMPONENT . '/helpers/hockey.php';

/**
 * Hockey model.
 */
class HockeyModelUscor extends JModelLegacy
{
     // int id season
    private $_sez = null;
    // object points system
    private $_points = null;
    // object match
    private $_match = null;
    // id_match
    private $_id = null;
    // team  1 table
    private $_team1 = null;
    // team  2 table
    private $_team2 = null;


    public function __construct() {
        parent::__construct();
        $app = JFactory::getApplication();
        $this->_id = (int) $app->input->getInt('id', 0);
        $this->_sez = (int) HockeyHelper::getSezon();
    }

    private function _getPoints() {
        $query = "SELECT * FROM #__hockey_system  WHERE id='$this->_sez' LIMIT 1";
        $this->_db->setQuery($query);
        return $this->_db->loadObject();
    }

    private function _getMatch() {
        $query = "SELECT * FROM #__hockey_match WHERE id='$this->_id' LIMIT 1";
        $this->_db->setQuery($query);
        return $this->_db->loadObject();
    }

    private function _getTeamTabela($id_team) {
        $query = "SELECT * FROM #__hockey_tables WHERE team_id ='" . $id_team . "' and id_system='$this->_sez' LIMIT 1";
        $this->_db->setQuery($query);
        return $this->_db->loadObject();
    }

    public function updateTable() {

        $this->_points = $this->_getPoints();
        $this->_match = $this->_getMatch();

        if (!isset($this->_points) || empty($this->_points)) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_SEASON_NOT_EXIST'));
            return false;
        }

        if (!isset($this->_match) || empty($this->_match)) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_MATCH_NOT_EXIST'));
            return false;
        }

        if ($this->_match->uscore == 1) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_UPDATE_IMPOSSIBLE'));
            return false;
        }


        $this->_team1 = $this->_getTeamTabela($this->_match->team_1);
        $this->_team2 = $this->_getTeamTabela($this->_match->team_2);

        if (!isset($this->_team1) || empty($this->_team1)) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_TEAM_IS_NOT_IN_THE_TABLE'));
            return false;
        }

        if (!isset($this->_team2) || empty($this->_team2)) {
            $this->setError(JText::_('COM_HOCKEY_ERROR_TEAM_IS_NOT_IN_THE_TABLE'));
            return false;
        }

        $team1 = new JObject;
        $team1->id = $this->_team1->id;
        $team2 = new JObject;
        $team2->id = $this->_team2->id;

        //*******************************************************************************
        // if team1 won
        //********************************************************************************
        if ($this->_match->score_1 > $this->_match->score_2) {

            if ($this->_match->shutouts == "T") {  // if won by shutouts
                $team1->points = $this->_team1->points + $this->_points->p_k_w;
                $team2->points = $this->_team2->points + $this->_points->p_k_p;
            } else {
                if ($this->_match->overtime == "T") { // if won in overtimes
                    $team1->points = $this->_team1->points + $this->_points->p_d_w;
                    $team2->points = $this->_team2->points + $this->_points->p_d_p;
                } else {  // if won in regular time
                    $team1->points = $this->_team1->points + $this->_points->p_w;
                    $team2->points = $this->_team2->points + $this->_points->p_p;
                }
            }
            $team1->won = $this->_team1->won + 1; // add one win
            $team2->lost = $this->_team2->lost + 1; // add one loss
        }

        //********************************************************************************
        // if  team2 won
        //********************************************************************************
        if ($this->_match->score_1 < $this->_match->score_2) {
            if ($this->_match->shutouts == "T") {   // if won by shutouts
                $team1->points = $this->_team1->points + $this->_points->p_k_p;
                $team2->points = $this->_team2->points + $this->_points->p_k_w;
            } else {
                if ($this->_match->overtime == "T") {  // if won in overtimes
                    $team1->points = $this->_team1->points + $this->_points->p_d_p;
                    $team2->points = $this->_team2->points + $this->_points->p_d_w;
                } else {   // if won in regular time
                    $team1->points = $this->_team1->points + $this->_points->p_p;
                    $team2->points = $this->_team2->points + $this->_points->p_w;
                }
            }
            $team1->lost = $this->_team1->lost + 1; // add one loss
            $team2->won = $this->_team2->won + 1;   // add one win
        }

        //********************************************************************************
        // if it was tie
         //*******************************************************************************
        if ($this->_match->score_1 == $this->_match->score_2) {
            $team1->points = $this->_team1->points + $this->_points->p_r;
            $team2->points = $this->_team2->points + $this->_points->p_r;

            $team1->ties = $this->_team1->ties + 1;   // add ties
            $team2->ties = $this->_team2->ties + 1;   // add ties
        }

        //***********************************************************************
        $team1->goals_scored = $this->_team1->goals_scored + $this->_match->score_1;
        $team1->goals_against = $this->_team1->goals_against + $this->_match->score_2;
        $team1->difference = $team1->goals_scored  - $team1->goals_against;
        $team1->matchday = $this->_team1->matchday + 1;

        $team2->goals_scored = $this->_team2->goals_scored + $this->_match->score_2;
        $team2->goals_against = $this->_team2->goals_against + $this->_match->score_1;
        $team2->difference = $team2->goals_scored  - $team2->goals_against;
        $team2->matchday = $this->_team2->matchday + 1;

        if (!$this->_db->updateObject('#__hockey_tables', $team1, 'id', false)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }

        if (!$this->_db->updateObject('#__hockey_tables', $team2, 'id', false)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        
        // set flag for block
        $matchflag = new JObject;
        $matchflag->id = $this->_match->id;
        $matchflag->uscore = 1;

        if (!$this->_db->updateObject('#__hockey_match', $matchflag, 'id', false)) {
            $this->setError($this->_db->getErrorMsg());
            return false;
        }
        return true;
    }

}