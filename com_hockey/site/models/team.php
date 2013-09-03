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
class HockeyModelTeam extends JModelLegacy
{
    /**
     * Get the data for a banner.
     *
     * @return  object
     */
    public function getItem($id_team)
    {
        $id_team = (int) $id_team;
        
        if (!isset($this->_item)) {
            $cache = JFactory::getCache('com_hockey', '');
            $id = 'team-one-' . $id_team;
            $this->_item = $cache->get($id);

            if ($this->_item === false) {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->select('name, logo, description')
                    ->from('#__hockey_teams')
                    ->where('id = '.$db->Quote($id_team).' AND state=1');

                $db->setQuery($query);

                try {
                    $db->execute();
                } catch (RuntimeException $e) {
                    throw new Exception($e->getMessage(), 500);
                }

                $this->_item = $db->loadObject();
                $cache->store($this->_item, $id);
            }
        }
        return $this->_item;
    }
}