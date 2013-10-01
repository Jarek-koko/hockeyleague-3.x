<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class modCalendarHelper {

     static function getmatchdays($post_month, $post_year, &$params) {
        
    
        $sez = intval($params->get('sez', 0));
        $db =  JFactory::getDBO ();
        $query = "SELECT  m.data AS dates, DAYOFMONTH(m.data) AS days "
                . "FROM #__hockey_match m "
                . "WHERE (m.id_system=" . $db->Quote($sez) . ") "
                . "AND (MONTH(m.data)=" . $db->Quote($post_month) . ") "
                . "AND (YEAR(m.data)=" . $db->Quote($post_year) . ") "
                . "AND (m.state=1)  "
                . "GROUP BY days  "
                . "ORDER BY days";

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
        }
        
        $events = $db->loadObjectList();
        $days = array();

        foreach ($events as $event) {
            $days [$event->days] = array($event->dates);
        }
        return $days;
    }
}
