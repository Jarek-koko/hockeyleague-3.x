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



class HockeyModelMatchday extends JModelLegacy
{
    public function getItem()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('tm.id AS value, tm.name AS text')
            ->from('#__hockey_tables AS t')
            ->join('INNER', '#__hockey_teams AS tm ON tm.id = t.team_id' )
            ->where('t.id_system=' . $db->quote(HockeyHelper::getSezon()))
            ->where('t.state = 1');
        $db->setQuery($query);
        
        try {
            $items = $db->loadObjectList();
        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage(), 500);
            return false;
        }
        return $items;
    }
}