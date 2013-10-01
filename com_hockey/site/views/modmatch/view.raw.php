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
class HockeyViewModmatch extends JViewLegacy
{

    function display($tpl = null)
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get->get('id', 0, 'INT');
        $sez = (int) $app->input->get->get('sez', 0, 'INT');

        if (($id == 0) || ($sez == 0)) {
            JError::raiseError(404, JText::_("Data not found"));
            return;
        }

        $this->items = $this->get('Items');

        if (empty($this->items)) {
            JError::raiseError(404, JText::_("Data not found"));
            return;
        }

        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        parent::display($tpl);
    }
}