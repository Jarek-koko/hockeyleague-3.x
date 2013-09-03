<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
class HockeyViewSchedulep extends JViewLegacy
{

    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            echo JText::_("COM_HOCKEY_INVALID_TOKEN");
            return false;
        }

        $app = JFactory::getApplication();
        $menu_id = (int) $app->input->get('menu_id', 0, 'int');
        $id =       (int) $app->input->get('id', 0, 'int');

        if (($menu_id == 0) ||($id == 0) ) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $this->params = $app->getParams('com_hockey');
        $this->items = $this->get('Items');

        $menu = JFactory::getApplication()->getMenu();
        $this->opt = $menu->getItem($menu_id);

        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        
        $this->params->merge($this->opt->params);
        parent::display('raw');
    }

}