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
class HockeyViewTable extends JViewLegacy
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

        //set script validation
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

		$canDo	= HockeyHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_TABLE'), 'table.png');

		// If not checked out, can save the item.
		if (($canDo->get('core.edit')||($canDo->get('core.create'))))
		{

			JToolBarHelper::apply('table.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('table.save', 'JTOOLBAR_SAVE');
		}
		if (($canDo->get('core.create'))){
			JToolBarHelper::custom('table.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}
		
		if (empty($this->item->id)) {
			JToolBarHelper::cancel('table.cancel', 'JTOOLBAR_CANCEL');
		}
		else {
			JToolBarHelper::cancel('table.cancel', 'JTOOLBAR_CLOSE');
		}

	}
}
