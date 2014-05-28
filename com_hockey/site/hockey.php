<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


jimport ('joomla.html.html.bootstrap');
jimport('joomla.application.component.controller');


 //Execute the task.
$controller	= JControllerLegacy::getInstance('Hockey');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
