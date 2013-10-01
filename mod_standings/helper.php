<?php
/**
 * @version     1.0.0
 * @package     mod_standings
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class ModStandingsHelper
{
    public static function getList(&$params)
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $sez = intval($params->get('sez', 0));
        $sname = intval($params->get('sname', 0));
        $sname = ($sname) ? ' tm.short as name ' : ' tm.name ';

        if ($sez == 0) {
            return NULL;
        }

        $query->select("$sname ,t.points ,t.group ")
                ->from('#__hockey_tables t')
                ->join('INNER', '#__hockey_teams tm ON (tm.id = t.team_id)')
                ->where("t.id_system = " . $db->Quote($sez) . " AND t.state = 1")
                ->order('t.group ASC, t.points DESC, t.ordering ASC');

        $db->setQuery($query);

        try {
            $db->execute();
        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
        }

        return $db->loadObjectList();
    }
}
