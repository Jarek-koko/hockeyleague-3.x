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
/**
 * View to edit
 */
class HockeyViewMatchday extends JViewLegacy
{
    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $this->item = $this->get('Item');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        HockeyHelper::setValidationPlayTime();
        HockeyHelper::setValidationSelect();
        
        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolBarHelper::title(JText::_('COM_HOCKEY_MATCHDAY_TITLE'), 'logo.png');
        JToolBarHelper::custom('league.cancel', 'undo.png', '', 'JTOOLBAR_CLOSE', false);
    }

}
