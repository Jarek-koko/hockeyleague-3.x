<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
class HockeyViewTable extends JViewLegacy
{

    function display($tpl = null)
    {

        if (!JSession::checkToken('get')) {
            echo JText::_("COM_HOCKEY_INVALID_TOKEN");
            return false;
        }
        
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');

        if ($id == 0) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $this->items = $this->get('Items');
        $this->info = $this->get('Info');


        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        parent::display('raw');
    }

}