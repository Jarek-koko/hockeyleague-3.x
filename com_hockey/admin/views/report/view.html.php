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
class HockeyViewReport extends JViewLegacy
{
    protected $item;
    protected $type;
    protected $type_title;
    protected $editor;
    protected $referee;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $id_match = (int) JFactory::getApplication()->input->getInt('id_match', 0);
        $id_type = (int) JFactory::getApplication()->input->getInt('type', 0);

        if ($id_match === 0) {
            throw new Exception(JText::_('COM_HOCKEY_ERROR_ID_MATCH'));
        }

        if (($id_type < 0) || ($id_type > 2 )) {
            throw new Exception(JText::_('COM_HOCKEY_ERROR_ID_TYPE'));
        }

        $model = $this->getModel();
        $this->item = $model->getItem($id_match);

        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        $this->type = $id_type;
        $this->type_title = HockeyHelper::getTypeMatch($this->type);

        //desc tabs ==============================
        $editor = JFactory::getConfig()->get('editor');
        $this->editor = JEditor::getInstance($editor);

        //ref tabs ===============================
        HockeyHelper::setValidationSelect();
        $this->ref = $model->getReferees();

        //players tabs ===========================
        $this->rows = $model->getPlayers($id_match, $this->item->team_1, $this->item->team_2);

        //goalie section ============================
        $this->select_team = $model->getNameTeames($id_match);

        //goals tabs ===============================
        HockeyHelper::setValidationPlayTime();

        $this->addToolbar();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     */
    protected function addToolbar()
    {
        JFactory::getApplication()->input->set('hidemainmenu', true);
        JToolBarHelper::title(JText::_('COM_HOCKEY_REPORT_TITLE'), 'logo.png');
        JToolBarHelper::custom('report.cancel', 'undo.png', '', 'JTOOLBAR_CLOSE', false);

        if (($this->item->uscore != 1) && ($this->type == 0)) {
            $bar = JToolbar::getInstance('toolbar');
            $title2 = JText::_('COM_HOCKEY_BAR_NEW_US');
            $tootip = ' data-content="' . JText::_('COM_HOCKEY_BAR_NEW_US_INFO') . '" rel="popover" data-placement="right" data-original-title="' . JText::_('COM_HOCKEY_BAR_NEW_US_TITLE') . '" ';
            $dhtml2 = '<button  class="btn btn-small btn-danger" ' . $tootip . '  id="result-update" onclick="Joomla.submitbutton(\'report.update\')" ><i class="icon-list-view" title="' . $title2 . '"></i> ' . $title2 . '</button>';
            $bar->appendButton('Custom', $dhtml2, 'r_update');
        }
    }

    function getToolbarResult()
    {
        $bar = new JToolBar('result_bar');
        $title = JText::_('JTOOLBAR_APPLY');
        $dhtml = '<button  class="btn btn-small btn-primary" id="result-save"><i class="icon-save-ok" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'r_save');
        return $bar->render();
    }

    function getToolbarComposition()
    {
        $bar = new JToolBar('composition_bar');
        $title = JText::_('JTOOLBAR_APPLY');
        $dhtml = '<button  class="btn btn-small btn-primary" id="composition-save"><i class="icon-save-ok" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'c_save');

        $title2 = JText::_('COM_HOCKEY_BAR_NEW_PLAYER');
        $link = JRoute::_('index.php?option=com_hockey&view=players');
        $dhtml2 = '<a href="' . $link . '" class="btn btn-small btn-danger" id="composition-add"><i class="icon-plus" title="' . $title2 . '"></i> ' . $title2 . '</a>';
        $bar->appendButton('Custom', $dhtml2, 'c_add');
        return $bar->render();
    }

    function getToolbarGoals()
    {
        $bar = new JToolBar('goals_bar');
        $title = JText::_('COM_HOCKEY_BAR_ADD');
        $dhtml = '<button  class="btn btn-small btn-primary" id="goals-add"><i class="icon-plus" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'g_add');
        return $bar->render();
    }

    function getToolbarPenalyty()
    {
        $bar = new JToolBar('penalyty_bar');
        $title = JText::_('COM_HOCKEY_BAR_ADD');
        $dhtml = '<button  class="btn btn-small btn-primary" id="penalyty-add"><i class="icon-plus" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'p_add');
        return $bar->render();
    }

    function getToolbarGoalie()
    {
        $bar = new JToolBar('goalie_bar');
        $title = JText::_('COM_HOCKEY_BAR_ADD');
        $dhtml = '<button  class="btn btn-small btn-primary" id="goalie-add"><i class="icon-plus" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'gol_add');
        return $bar->render();
    }

    function getToolbarReferees()
    {
        $bar = new JToolBar('referees_bar');
        $title = JText::_('JTOOLBAR_APPLY');
        $dhtml = '<button  class="btn btn-small btn-primary" id="ref-save"><i class="icon-save-ok" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'ref_save');
        return $bar->render();
    }

    function getToolbarDescription()
    {
        $bar = new JToolBar('description_bar');
        $title = JText::_('JTOOLBAR_APPLY');
        $dhtml = '<button  class="btn btn-small btn-primary" id="des-save"><i class="icon-save-ok" title="' . $title . '"></i> ' . $title . '</button>';
        $bar->appendButton('Custom', $dhtml, 'des_save');
        return $bar->render();
    }

    function getImageButton()
    {
       $button = '<a class="modal-button btn" rel="{handler: \'iframe\', size: {x: 800, y: 500}}" '
                 .'onclick="IeCursorFix(); return false;" '
                 .'href="'.JURI::base().'index.php?option=com_media&view=images&tmpl=component&e_name=description&asset=com_hockey" '
                 .'title="'.JText::_('COM_HOCKEY_BUTTON_IMAGE').'"><i class="icon-picture"></i> '. JText::_('COM_HOCKEY_BUTTON_IMAGE').'</a>';
        return $button;
        
    }

}
