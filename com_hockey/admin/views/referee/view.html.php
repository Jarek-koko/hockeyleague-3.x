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
class HockeyViewReferee extends JViewLegacy
{
	protected $state;
	protected $item;
	protected $form;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$canDo		= HockeyHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_REFEREE'), 'logo.png');

		// If not checked out, can save the item.
		if (($canDo->get('core.edit')||($canDo->get('core.create'))))
		{
			JToolBarHelper::apply('referee.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('referee.save', 'JTOOLBAR_SAVE');
		}
		if (($canDo->get('core.create'))){
			JToolBarHelper::custom('referee.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('referee.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('referee.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}
