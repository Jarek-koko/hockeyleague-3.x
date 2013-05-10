<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_hockey')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_hockey/assets/css/hockey.css');

$controller	= JControllerLegacy::getInstance('Hockey');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
