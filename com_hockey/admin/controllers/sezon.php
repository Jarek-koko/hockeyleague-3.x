<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


jimport('joomla.application.component.controllerform');
/**
 * System controller class.
 */
class HockeyControllerSezon extends JControllerForm
{

    function __construct()
    {
        $this->view_list = 'sezons';
        parent::__construct();
    }

}