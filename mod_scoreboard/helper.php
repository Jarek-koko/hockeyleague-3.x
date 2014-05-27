<?php
/**
 * @version     1.0.0
 * @package     mod_scoreboard
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
class modScoreboardHelper
{
    public static function getList(&$params)
    {
        $db = JFactory::getDBO();
        $id = intval($params->get('id', 0));
        $id = ($id == 0) ? ' (SELECT id FROM #__hockey_match ORDER BY id DESC LIMIT 1) ' : $id;

        $query = "SELECT t1.id, t2.name AS home,t1.w1p1,t1.w2p1,t1.w1p2,t1.w2p2,t1.time,t1.data , t1.place,"
            . "t1.w1p3,t1.w2p3,t1.w1ot,t1.w2ot,t1.w1so,t1.w2so,t3.name AS visitor,"
            . "t1.score_1, t1.score_2, t2.logo AS logo1,t3.logo AS logo2 "
            . "FROM #__hockey_match t1 "
            . "LEFT JOIN #__hockey_teams t2 ON (t2.id = t1.team_1) "
            . "LEFT JOIN #__hockey_teams t3 ON (t3.id = t1.team_2) "
            . "WHERE t1.id =" . $db->Quote($id) . " LIMIT 1";

        $db->setQuery($query);

        try {
            $row = $db->loadAssoc();

        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $row;
    }

}
