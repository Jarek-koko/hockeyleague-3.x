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
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_INFO'), 'index.php?option=com_hockey', ("info" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_PLAYERS'), 'index.php?option=com_hockey&view=players', ("players" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_TEAMS'), 'index.php?option=com_hockey&view=teams', ("teams" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_REFEREES'), 'index.php?option=com_hockey&view=referees', ("referees" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_SEASON'), 'index.php?option=com_hockey&view=sezon', ("sezon" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_SELECTSEASON'), 'index.php?option=com_hockey&view=select', ("select" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_MATCHES'), 'index.php?option=com_hockey&view=league', ("league" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_PLAYOFF'), 'index.php?option=com_hockey&view=playoff', ("playoff" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_SPARRING'), 'index.php?option=com_hockey&view=sparring', ("sparring" === $vName));
        JHtmlSidebar::addEntry(JText::_('HOC_NAV_TABLE'), 'index.php?option=com_hockey&view=tabela', ("tabela" === $vName));
       
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
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

}
