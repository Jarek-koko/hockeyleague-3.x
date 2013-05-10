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
class HockeyViewInfo extends JViewLegacy
{
	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
	    $model = $this->getModel();
        $info = $model->getComponentInfo();

        $calendar = $model->CheckModule("mod_calendar");
        $matchdays = $model->CheckModule("mod_matchdays");
        $scoreboard = $model->CheckModule("mod_scoreboard");
        $standings = $model->CheckModule("mod_standings");
        $topplayer = $model->CheckModule("mod_topplayer");

        $this->info = $info;
        $this->calendar =$calendar;
        $this->matchdays = $matchdays;
        $this->scoreboard = $scoreboard;
        $this->standings = $standings;
        $this->topplayer = $topplayer;

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		HockeyHelper::addSubmenu('info');
        
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

		$canDo	= HockeyHelper::getActions();

		JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_SYSTEMS'), 'systems.png');

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_hockey');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_hockey&view=info');
        
        $this->extra_sidebar = '';
	}
   
}
