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
class HockeyViewPlayers extends JViewLegacy
{
    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        $this->all_teams = $this->get('Teams');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        HockeyHelper::addSubmenu('players');

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

        JToolBarHelper::title(JText::_('COM_HOCKEY_PLAYERS_TITLE') , 'logo.png');


        if ($canDo->get('core.create')) {
            JToolBarHelper::addNew('player.add', 'JTOOLBAR_NEW');
        }

        if ($canDo->get('core.edit') && isset($this->items[0])) {
            JToolBarHelper::editList('player.edit', 'JTOOLBAR_EDIT');
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('players.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('players.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'players.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('players.archive', 'JTOOLBAR_ARCHIVE');
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'players.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('players.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_hockey');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_hockey&view=players');

        JHtmlSidebar::addFilter(
            JText::_('JOPTION_SELECT_PUBLISHED'),
            'filter_published', 
            JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state') , true)
        );

        JHtmlSidebar::addFilter(
            JText::_('COM_HOCKEY_PLAYERS_TEAM_FILTER'),
            'filter_team_id', 
            JHtml::_('select.options',  $this->all_teams , "value", "text", $this->state->get('filter.team_id'))
        );

        JHtmlSidebar::addFilter(
            JText::_('COM_HOCKEY_PLAYERS_POSITION_FILTER'), 
            'filter_position', 
            JHtml::_('select.options', HockeyHelper::getPositionSelect(), "value", "text", $this->state->get('filter.position'))
        );
    }

    protected function getSortFields()
    {
        return array(
            'a.id' => JText::_('JGRID_HEADING_ID'),
            'a.state' => JText::_('JSTATUS'),
            'team' => JText::_('COM_HOCKEY_PLAYERS_TEAM'),
            'a.name' => JText::_('COM_HOCKEY_PLAYERS_NAME'),
            'a.first_name' => JText::_('COM_HOCKEY_PLAYERS_FIRST_NAME'),
            'a.position' => JText::_('COM_HOCKEY_PLAYERS_POSITION'),
        );
    }

}
