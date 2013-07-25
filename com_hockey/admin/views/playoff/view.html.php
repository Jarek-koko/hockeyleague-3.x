<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
/**
 * View to edit
 */
class HockeyViewPlayoff extends JViewLegacy
{
    protected $state;
    protected $item;
    protected $form;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {

        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->form = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }


        if (($this->item->score_1 !== null) or ($this->item->score_2 !== null )) {
             $this->form->setFieldAttribute('team_1','disabled', 'true');
             $this->form->setFieldAttribute('team_2','disabled', 'true');
        }
        //set script validation
        HockeyHelper::setValidationTime();
        HockeyHelper::setValidationSelect();

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);

        $user = JFactory::getUser();
        $isNew = ($this->item->id == 0);
        if (isset($this->item->checked_out)) {
            $checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
        } else {
            $checkedOut = false;
        }
        $canDo = HockeyHelper::getActions();

        JToolBarHelper::title(JText::_('COM_HOCKEY_TITLE_PLAYOFF'), 'logo.png');

        // If not checked out, can save the item.
        if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create')))) {

            JToolBarHelper::apply('playoff.apply', 'JTOOLBAR_APPLY');
            JToolBarHelper::save('playoff.save', 'JTOOLBAR_SAVE');
        }
        if (!$checkedOut && ($canDo->get('core.create'))) {
            JToolBarHelper::custom('playoff.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
        }
        // If an existing item, can save to a copy.
        if (!$isNew && $canDo->get('core.create')) {
            JToolBarHelper::custom('playoff.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
        }
        if (empty($this->item->id)) {
            JToolBarHelper::cancel('playoff.cancel', 'JTOOLBAR_CANCEL');
        } else {
            JToolBarHelper::cancel('playoff.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}
