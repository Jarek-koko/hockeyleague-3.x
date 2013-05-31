<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Referees list controller class.
 */
class HockeyControllerReferees extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function getModel($name = 'Referee', $prefix = 'HockeyModel',  $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix,  $config);
		return $model;
	}

}