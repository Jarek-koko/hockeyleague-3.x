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
 * Player controller class.
 */
class HockeyControllerSelect extends JControllerForm
{

    function __construct()
    {
        $this->view_list = 'select';
        parent::__construct();

        $this->registerTask('apply', 'save');
    }

    /**
     * Overrides parent save method to check the submitted passwords match.
     *
     * @param   string  $key     The name of the primary key of the URL variable.
     * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
     *
     * @return  boolean  True if successful, false otherwise.
     *
     * @since   1.6
     */
    public function save($key = null, $urlVar = null)
    {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

       $sezon_id = (int) $this->input->post->get('sezon_id', 0, 'int');

        if ((isset($sezon_id)) && $sezon_id != 0) {
            $this->setMessage(JText::_('COM_HOCKEY_SELECT_ACTIVE'), 'message');
            $this->setRedirect(JRoute::_('index.php?option=com_hockey&view=leagues', false));
            JFactory::getApplication()->setUserState('hockey_sezon_id', $sezon_id);
            
        } else {
           
            $this->setMessage(JText::_('COM_HOCKEY_SELECT_NOT_SAVE'), 'warning');
            $this->setRedirect(JRoute::_('index.php?option=com_hockey&view=select', false));
        }
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
        $this->setRedirect('index.php?option=com_hockey');
    }

}