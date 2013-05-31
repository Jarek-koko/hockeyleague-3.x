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
class HockeyViewLeagues extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;
    protected $type;
    protected $matchdays;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {

        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->matchdays = $this->get('Matchdays');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        HockeyHelper::addSubmenu('leagues');

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
        require_once JPATH_COMPONENT . '/helpers/hockey.php';

        $state = $this->get('State');
        $canDo = HockeyHelper::getActions();

        JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_LEAGUES'), 'logo.png');

        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('league.add', 'JTOOLBAR_NEW');
        }

        if ($canDo->get('core.edit') && isset($this->items[0])) {
            JToolBarHelper::editList('league.edit', 'JTOOLBAR_EDIT');
        }

        if ($canDo->get('core.edit.state')) {
            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('leagues.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('leagues.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'leagues.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('leagues.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'leagues.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('leagues.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_hockey');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_hockey&view=leagues');
        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'), 
            'filter_published', 
            JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)
        );

        $options = array();
        foreach ($this->matchdays as $matchday) {
            $options[] = JHTML::_('select.option', $matchday, $matchday);
        }

        JHtmlSidebar::addFilter(
            JText::_('COM_HOCKEY_MATCHES_TYPE_FILTER_LEAGUES'), 
            'filter_id_kolejka', 
            JHtml::_('select.options', $options, "value", "text", $this->state->get('filter.id_kolejka'))
        );
    }

    protected function getSortFields()
    {
        return array(
            'a.id' => JText::_('JGRID_HEADING_ID'),
            'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
            'a.state' => JText::_('JSTATUS'),
            'a.data' => JText::_('COM_HOCKEY_MATCHES_DATA'),
        );
    }

}
