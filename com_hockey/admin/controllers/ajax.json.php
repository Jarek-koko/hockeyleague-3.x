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
    protected $id_match;
    protected $message;
    protected $succes_save;
    protected $error_save;
    protected $model;

    public function __construct($config = array())
    {
        parent::__construct($config);
        $this->succes_save = array('status' => '1', 'message' => JText::_('COM_HOCKEY_SAVE_SUCCESS'));
        $this->error_save = array('status' => '0', 'message' => JText::_('COM_HOCKEY_SAVE_ERROR'));
        $this->model = $this->getModel('Report');
    }

    private function check_request()
    {
        if (!JSession::checkToken('get')) {
            $this->message = array('status' => '0', 'message' => JText::_('JINVALID_TOKEN'));
            return false;
        }

        $app = JFactory::getApplication();
        $this->id_match = (int) $app->input->getInt('id', 0);

        if ($this->id_match == 0) {
            $this->message = array('status' => '0', 'message' => JText::_('COM_HOCKEY_EMPTY_ID_MATCH'));
            return false;
        }


        return true;
    }

    public function getSelectGoalie()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $app = JFactory::getApplication();
        $team_id = (int) $app->input->getInt('team_id', 0);

        $data = $this->model->getSelectGoalie($team_id);

        if ($this->model->getError()) {
            $response = array(array('value' => '0', 'text' => JText::_('COM_HOCKEY_NO_GOALIES')));
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function getSelectGoals()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $app = JFactory::getApplication();
        $team_id = (int) $app->input->getInt('team_id', 0);

        $data = $this->model->getSelectGoals($team_id);

        if ($this->model->getError()) {
            $response = array(array('value' => '0', 'text' => JText::_('COM_HOCKEY_NO_PLAYER')));
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function getSelectPenalty()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $app = JFactory::getApplication();
        $team_id = (int) $app->input->getInt('team_id', 0);

        $data = $this->model->getSelectPenalty($team_id);

        if ($this->model->getError()) {
            $response = array(array('value' => '0', 'text' => JText::_('COM_HOCKEY_NO_PLAYER')));
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function getNote()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $app = JFactory::getApplication();
        $query = $app->input->getString('query');
        $data = $this->model->getNote($query);

        if ($this->model->getError()) {
            return;
        }
        echo json_encode(array('suggestions' => $data));
    }

    public function getTableGoalie()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $data = $this->model->getTableGoalie();

        if ($this->model->getError()) {
            $response = array();
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function getTableGoals()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $data = $this->model->getTableGoals();

        if ($this->model->getError()) {
            $response = array();
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function getTablePenalty()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $data = $this->model->getTablePenalty();
        if ($this->model->getError()) {
            $response = array();
            echo json_encode($response);
            return;
        }
        echo json_encode($data);
    }

    public function RemovePenalty()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->RemovePenalty();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function RemoveGoalie()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->RemoveGoalie();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function RemoveGoals()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->RemoveGoals();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setGoalie()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->setGoalie();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setGoals()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->setGoals();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setPenalty()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }
        $this->model->setPenalty();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setResult()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $this->model->setResult();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setDescription()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $this->model->setDescription();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setReferees()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $this->model->setReferees();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }
        echo json_encode($this->succes_save);
    }

    public function setComposition()
    {
        if (!$this->check_request()) {
            echo json_encode($this->message);
            return;
        }

        $this->model->setComposition();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }

        echo json_encode($this->succes_save);
    }

    public function setMatchday()
    {
        if (!JSession::checkToken('get')) {
            echo json_encode(array('status' => '0', 'message' => JText::_('JINVALID_TOKEN')));
            return;
        }
        $this->model->setMatchday();

        if ($this->model->getError()) {
            echo json_encode($this->error_save);
            return;
        }

        $succes_save = array('status' => '1', 'message' => JText::_('COM_HOCKEY_SAVE_SUCCESS'));
        echo json_encode($succes_save);
        return;
    }

}
