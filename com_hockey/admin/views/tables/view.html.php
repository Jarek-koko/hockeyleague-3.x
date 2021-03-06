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
 * View class for a list of Hockey.
 */
class HockeyViewTables extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		HockeyHelper::addSubmenu('tables');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/hockey.php';

		$state	= $this->get('State');
		$canDo	= HockeyHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_TABLES'), 'tables.png');

        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('table.add', 'JTOOLBAR_NEW');
        }

        if ($canDo->get('core.edit') && isset($this->items[0])) {
            JToolBarHelper::editList('table.edit', 'JTOOLBAR_EDIT');
        }


		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('tables.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('tables.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'tables.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('tables.archive','JTOOLBAR_ARCHIVE');
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'tables.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('tables.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_hockey');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_hockey&view=tables');
        
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)
		);

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('COM_HOCKEY_TABLES_CURRENT_ORDER'),
		'a.matchday' => JText::_('COM_HOCKEY_TABLES_MATCHDAY'),
		'a.points' => JText::_('COM_HOCKEY_TABLES_POINTS'),
		'a.won' => JText::_('COM_HOCKEY_TABLES_WON'),
		'a.ties' => JText::_('COM_HOCKEY_TABLES_TIES'),
		'a.lost' => JText::_('COM_HOCKEY_TABLES_LOST'),
		'a.goals_scored' => JText::_('COM_HOCKEY_TABLES_GOALS_SCORED'),
		'a.goals_against' => JText::_('COM_HOCKEY_TABLES_GOALS_AGAINST'),
		'a.difference' => JText::_('COM_HOCKEY_TABLES_DIFFERENCE'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.group' => JText::_('COM_HOCKEY_TABLES_GROUP'),
		'a.state' => JText::_('JSTATUS'),
		);
	}
}
