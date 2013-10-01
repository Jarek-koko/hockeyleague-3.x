<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
jimport('joomla.application.component.view');

class HockeyViewModcal extends JViewLegacy
{
    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            JError::raiseError(404, JText::_("COM_HOCKEY_INVALID_TOKEN"));
            return false;
        }

        $app = JFactory::getApplication();
        $date =      $app->input->get->get('mdate', null, 'cmd');
        $sez = (int) $app->input->get->get('sez', 0, 'int');

        if ($sez == 0) {
            JError::raiseError(404, JText::_("Data not found"));
            return;
        }

        if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)) {
            JError::raiseError(404, JText::_("Data not found"));
            return;
        }

        $this->id_team = (int) $app->input->get('id', 0 , 'int');
        $this->list = $this->get('Items');

        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');

        parent::display($tpl);
    }
}