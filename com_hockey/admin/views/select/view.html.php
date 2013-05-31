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
class HockeyViewSelect extends JViewLegacy
{

	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
        $this->form = HockeyHelper::getSeasonListSelect();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}

        HockeyHelper::addSubmenu('select');
        $this->sidebar = JHtmlSidebar::render();
        
        
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$canDo	= HockeyHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_SELECT') , 'logo.png');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit'))
		{
			JToolBarHelper::apply('select.apply', 'JTOOLBAR_APPLY');
		}

        JToolBarHelper::cancel('select.cancel', 'JTOOLBAR_CLOSE');
		

	}
}
