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

        $script = "jQuery(document).ready(function(){ \n";
        $script .= "jQuery('#submenu li:eq(0)').before('<li class=\"nav-header\">" . JText::_('COM_HOCKEY_NAV_MAIN') . "</li>'); \n";

        if (self::getSezon()) {
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_TABLE'), 'index.php?option=com_hockey&view=tables', ("tables" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_MATCHES'), 'index.php?option=com_hockey&view=leagues', ("leagues" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_PLAYOFF'), 'index.php?option=com_hockey&view=playoffs', ("playoffs" === $vName));
            JHtmlSidebar::addEntry(JText::_('COM_HOCKEY_NAV_SPARRING'), 'index.php?option=com_hockey&view=sparrings', ("sparrings" === $vName));

            $script .= "jQuery('#submenu li').slice(-4).addClass('menu-border');\n";
            $script .= "jQuery('#submenu li:eq(7)').before('<li class=\"nav-header\">" . JText::_('COM_HOCKEY_NAV_MSEASON') . " " . self::getNameSez() . "</li>');\n";
        }

        $script .= "});\n";
        JFactory::getDocument()->addScriptDeclaration($script);
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
            'core.admin', 'core.manage', 'core.create',
            'core.edit', 'core.edit.own', 'core.edit.state',
            'core.delete', 'hockey.manage.sezon'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }

    /**
     *  Method return id season selected
     * @return int or null
     */
    public static function getSezon()
    {
        return (int) JFactory::getApplication()->getUserState('hockey_sezon_id', null);
    }

    /**
     *  Method return all period in match 
     * @return array
     */
    public static function getPeriod()
    {
        $position = array(
            '1' => array('value' => '1', 'text' => JText::_('COM_HOCKEY_PERIOD_1')),
            '2' => array('value' => '2', 'text' => JText::_('COM_HOCKEY_PERIOD_2')),
            '3' => array('value' => '3', 'text' => JText::_('COM_HOCKEY_PERIOD_3')),
            '4' => array('value' => '4', 'text' => JText::_('COM_HOCKEY_PERIOD_OVERTIME'))
        );
        return $position;
    }

    /**
     * Method return name of the season selected
     * @return string
     */
    public static function getNameSez()
    {
        if ($sez = self::getSezon()) {
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

    /*
     * Method return all positions 
     * @return array
     */

    public static function getPositionSelect()
    {
        $position = array(
            '0' => array('value' => '1', 'text' => JText::_('COM_HOCKEY_POSITION_GOALTENDER')),
            '1' => array('value' => '2', 'text' => JText::_('COM_HOCKEY_POSITION_DEFENCEMEN')),
            '2' => array('value' => '3', 'text' => JText::_('COM_HOCKEY_POSITION_FORWARD'))
        );
        return $position;
    }

    /*
     * Method return one string translated position 
     * @return string name position
     */

    public static function getPositionString($pos)
    {
        switch ($pos) {
            case 1:
                $tmp = JText::_('COM_HOCKEY_POSITION_GOALTENDER');
                break;
            case 2:
                $tmp = JText::_('COM_HOCKEY_POSITION_DEFENCEMEN');
                break;
            case 3:
                $tmp = JText::_('COM_HOCKEY_POSITION_FORWARD');
                break;
            default:
                $tmp = '';
        }
        return $tmp;
    }

    /*
     * Method return one string translated short position
     * @param int $pos
     * @return string name position
     */

    public static function getPositionShort($pos)
    {
        switch ($pos) {
            case 1:
                $tmp = JText::_('COM_HOCKEY_P_GOALIES_SHORT');
                break;
            case 2:
                $tmp = JText::_('COM_HOCKEY_P_DEFENCEMENS_SHORT');
                break;
            case 3:
                $tmp = JText::_('COM_HOCKEY_P_FORWARDS_SHORT');
                break;
            default:
                $tmp = '';
        }
        return $tmp;
    }

    /**
     * Method return one string type of match 
     * @param int $type
     * @return string
     */
    public static function getTypeMatch($type)
    {
        switch ($type) {
            case 0:
                $tmp = JText::_('COM_HOCKEY_MATCHES');
                break;
            case 1:
                $tmp = JText::_('COM_HOCKEY_PLAYOFF');
                break;
            case 2:
                $tmp = JText::_('COM_HOCKEY_SPARRING');
                break;
            default:
                $tmp = '';
                break;
        }
        return $tmp;
    }

    /**
     * Method return  list of season in form select html
     * @return string 
     */
    public static function getSeasonListSelect()
    {
        // Load the finder types.
        //SELECT `id`, `name` FROM `#__hockey_system` WHERE state=1 ORDER BY id DESC
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('s.name AS text, s.id AS value')
            ->from('#__hockey_system AS s')
            ->where('s.state=1')
            ->order('s.id DESC');
        $db->setQuery($query);

        $rows = $db->loadObjectList();
        // Compile the options.
        $options = array();
        $options[] = JHtml::_('select.option', '0', JText::_('COM_HOCKEY_SELECT_SEZON'));

        if (!empty($rows)) {
            foreach ($rows as $item) {
                $options[] = JHtml::_('select.option', $item->value, $item->text);
            }
        }
        return JHtml::_('select.genericlist', $options, 'sezon_id', '', 'value', 'text', self::getSezon());
    }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string	Script files
     */
    public static function setValidationTime()
    {
        $sc = "window.addEvent('domready', function() {
                 document.formvalidator.setHandler('timematch', function(value) {
                 regex = /^([01]?[0-9]|2[0-3]):[0-5][0-9]/;
                 return regex.test(value);
                });});";
        JFactory::getDocument()->addScriptDeclaration($sc);
    }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string	Script files
     */
    public static function setValidationPlayTime()
    {
        $sc = "window.addEvent('domready', function() {
                 document.formvalidator.setHandler('playtime', function(value) {
                 regex=  /^(\d{2})+(\:|\-|\.)+(\d{2})$/;
                 return regex.test(value);
                });});";
        JFactory::getDocument()->addScriptDeclaration($sc);
    }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string	Script files
     */
    public static function setValidationSelect()
    {
        $sc1 = "window.addEvent('domready', function() {
                 document.formvalidator.setHandler('notzero',function(value) {
                    return  (value!='0') ? true : false;
                });});";
        JFactory::getDocument()->addScriptDeclaration($sc1);
    }

    /**
     * Method to get the script that have to be included on the form
     *
     * @return string	Script files
     */
    public static function setValidationMatchday()
    {
        $sc1 = "window.addEvent('domready', function() {
                 document.formvalidator.setHandler('matchday',function(value) {
                 regex=/^(\d|-)?(\d|,)*\.?\d*$/;
                    return ((value > 0 && value < 100) &&  regex.test(value)) ? true : false;
                });});";
        JFactory::getDocument()->addScriptDeclaration($sc1);
    }

}
