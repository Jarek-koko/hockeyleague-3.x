<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;
jimport('joomla.application.component.view');
/**
 * View to edit
 */
class HockeyViewReport extends JViewLegacy
{
    protected $items;

    /**
     * Display the view
     */
    public function display($tpl = null)
    {
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $tmpl = $app->input->get('tmpl', NULL ,'string');

        if ($id == 0) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $this->button_back = '<a href="javascript:history.back()" class="pull-left btn btn-mini btn-info"><span class="icon-undo  icon-white"></span>'.JText::_('COM_HOCKEY_BACK').'</a>';
   
        if ($tmpl == 'component') {
            $this->button_back = '';
            // Load bootstrap
            JHtml::_('bootstrap.loadCss');
        }
        
        $model = $this->getModel();
        $list = $model->getList();

        if (count($list)) {
            $this->players = $model->getPlayers();
            $this->goals = $model->getGoals();
            $this->penalty = $model->getPenalty();
            $this->goalie = $model->getGoalie();
    
            $this->list = $list;
            $this->document->setTitle($list['home'] . ' - ' . $list['visitor']);

            if ($this->list['w1so'] != null || $this->list['w2so'] != null || $this->list['w1ot'] != null || $this->list['w2ot'] != null) {
                $doc = JFactory::getDocument();
                $style = '.board .sc_m_penalty { visibility: visible;}';
                $doc->addStyleDeclaration($style);
            }

            JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/hockey.php');
            parent::display($tpl);
        } else {
            echo '<div class="alert alert-info">' . JText::_("COM_HOCKEY_NO_REPORT") . '</div>';
        }
    }
}
