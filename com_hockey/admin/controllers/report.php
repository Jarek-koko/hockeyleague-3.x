<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
/**
 * Report controller class.
 */
class HockeyControllerReport extends JControllerForm
{

    function __construct()
    {
        parent::__construct();
    }

    /**
     * Method override to check if you can add a new record.
     *
     * @param   array  $data  An array of input data.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowAdd($data = array())
    {
        $user = JFactory::getUser();
        $categoryId = JArrayHelper::getValue($data, 'catid', $this->input->getInt('filter_category_id'), 'int');
        $allow = null;

        if ($categoryId) {
            // If the category has been passed in the URL check it.
            $allow = $user->authorise('core.create', $this->option . '.category.' . $categoryId);
        }

        if ($allow === null) {
            // In the absense of better information, revert to the component permissions.
            return parent::allowAdd($data);
        } else {
            return $allow;
        }
    }
    
    
    
    /**
     * method update standings 
     */
    function update()
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $model = $this->getModel('uscor');
        if ($model->updateTable()) {
            $msg = JText::_('Update completed');
            $type = 'message';
        } else {
            $msg = $model->getError();
            $type = 'error';
        }

        $type = $this->input->getInt('type', 0);

        switch ($type) {
            case 2:
                $view = 'sparrings';
                break;
            case 1:
                $view = 'playoffs';
                break;
            case 0:
                $view = 'leagues';
                break;
            default:
                $view = 'leagues';
                break;
        }
        $view = $this->getTypeView();
        $link = 'index.php?option=com_hockey&view=' . $view;
        $this->setRedirect($link, $msg, $type);
    }

    /**
     * Cancel operation
     *
     * @return  void
     *
     * @since   3.0
     */
    public function cancel($key = null)
    {
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $view = $this->getTypeView();
        $this->setRedirect('index.php?option=com_hockey&view=' . $view);
    }

    /**
     * private function return typ of view
     * 
     * @return string
     */
    private function getTypeView()
    {
       $type = (int) $this->input->getInt('type', 0);
        switch ($type) {
            case 2:
                $view = 'sparrings';
                break;
            case 1:
                $view = 'playoffs';
                break;
            case 0:
                $view = 'leagues';
                break;
            default:
                $view = 'leagues';
                break;
        }
        return $view;
    }

}
