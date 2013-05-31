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
 * Table controller class.
 */
class HockeyControllerTable extends JControllerForm
{

    function __construct() {
        $this->view_list = 'tables';
        parent::__construct();
    }

}