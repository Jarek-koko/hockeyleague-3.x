<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


class HockeyControllerAjax extends JControllerLegacy
{
  public function getTableStandings()
    {
        if (!JSession::checkToken('get')) {
            $this->message = array('status' => '0', 'message' => JText::_('JINVALID_TOKEN'));
            return false;
        }
        
       // $data = $this->model->getTableGoals();
        
       $data = array('status' => '1', 'message' => JText::_('OK'));


//        if ($this->model->getError()) {
//            $response = array();
//            echo json_encode($response);
//            return;
//        }
        echo json_encode($data);
    }

}
