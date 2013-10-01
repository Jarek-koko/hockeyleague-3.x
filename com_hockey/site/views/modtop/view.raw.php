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

class HockeyViewModtop extends JViewLegacy
{
    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            JError::raiseError(404, JText::_("COM_HOCKEY_INVALID_TOKEN"));
            return false;
        }

        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $sez = (int) $app->input->get('sez', 0, 'int');
        $type = (int) $app->input->get('type', 0, 'int');

        $a = array(1, 2, 3);
        $b = array(0, 1, 2);
        if ( ($sez == 0) || (!in_array($id, $a, true)) || (!in_array($type, $b, true)) ) {
            JError::raiseError(404, JText::_("Data not found"));
            return false;
        }

        $items = $this->get('Items');
        $this->items = &$items;

        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        parent::display($tpl);
    }
}
?>