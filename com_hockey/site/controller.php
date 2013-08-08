<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

class HockeyController extends JControllerLegacy
{

     
    public function display($cachable = false, $urlparams = false)
	{
		// Set the default view name and format from the Request.
		$vName = $this->input->get('view', 'table');
		$this->input->set('view', $vName);
        
        $document = JFactory::getDocument();
        $document->addStyleSheet(JURI::base(true) . '/media/com_hockey/css/style.css');

		return parent::display($cachable, $urlparams);
	}
}