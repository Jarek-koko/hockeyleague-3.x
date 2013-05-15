<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
/**
 * Hockey helper.
 */
class HockeyHelper
{

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '')
    {
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_INFO'), 'index.php?option=com_hockey', ("info" === $vName));
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_PLAYERS'), 'index.php?option=com_hockey&view=players', ("players" === $vName));
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_TEAMS'), 'index.php?option=com_hockey&view=teams', ("teams" === $vName));
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_REFEREES'), 'index.php?option=com_hockey&view=referees', ("referees" === $vName));
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_SEASON'), 'index.php?option=com_hockey&view=sezons', ("sezons" === $vName));
        JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_SELECTSEASON'), 'index.php?option=com_hockey&view=select', ("select" === $vName));
       
        if (HockeyHelper::getSezon()) {
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_MATCHES'), 'index.php?option=com_hockey&view=league', ("league" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_PLAYOFF'), 'index.php?option=com_hockey&view=playoff', ("playoff" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_SPARRING'), 'index.php?option=com_hockey&view=sparring', ("sparring" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_TABLE'), 'index.php?option=com_hockey&view=tabela', ("tabela" === $vName));
        }
    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions()
    {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_hockey';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete','hockey.manage.sezon'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    /**
     *  return nr season 
     * @static int $sezon
     * @return int
     */
    public static function getSezon()
    {
        static $sezon = null;

        if ($sezon === null) {
            $session = JFactory::getSession();
            $sezon = (int) $session->get('sezon', 0);
        }
        return $sezon;
    }

    /**
     * name of the season
     * @return string
     */
    public static function getNameSez()
    {

        if ($sez = HockeyHelper::getSezon()) {

            $db = JFactory::getDBO();
            $query = $db->getQuery(true);

            $query->select(array('name'));
            $query->from('#__hockey_system');
            $query->where('id = ' . $db->quote($sez));
            $db->setQuery($query, 0, 1);
            $row = $db->loadAssoc();
            return $row['name'];
        } else {
            return JText::_('COM_HOCKEY_SELECT_NO_SEZ');
        }
    }

}
