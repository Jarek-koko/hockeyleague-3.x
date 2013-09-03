<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class HockeyViewSchedule extends JViewLegacy
{
    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            echo JText::_("COM_HOCKEY_INVALID_TOKEN");
            return false;
        }

        $app = JFactory::getApplication();
        $menu_id = (int) $app->input->get('menu_id', 0, 'int');
        $id =  (int) $app->input->get('id', 0, 'int');
        $type_id =  (int) $app->input->get('type_id', 0, 'int');

        $a = array(0,1,2);
        if (($menu_id == 0) ||($id == 0) || (!in_array($type_id, $a, true))) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $this->params = $app->getParams('com_hockey');
        $menu = JFactory::getApplication()->getMenu();
        $this->opt = $menu->getItem($menu_id);
        $this->params->merge($this->opt->params);
        
        $model = $this->getModel();
        $model->setIdTeam($this->params->get('idteam'));
        $this->items = $model->getItems();
        
        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        parent::display('raw');
    }
}