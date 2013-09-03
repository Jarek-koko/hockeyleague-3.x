<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class HockeyViewLive extends JViewLegacy
{

    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            echo JText::_("COM_HOCKEY_INVALID_TOKEN");
            return false;
        }

        $app = JFactory::getApplication();
        $menu_id = (int) $app->input->get('menu_id', 0, 'int');

        if (($menu_id == 0)) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $this->params = $app->getParams('com_hockey');
        $menu = JFactory::getApplication()->getMenu();
        $this->opt = $menu->getItem($menu_id);

        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        
        $this->params->merge($this->opt->params);

        $id_match = (int) $this->params->get('id_match', 0);
        $this->end = (int) $this->params->get('end', 0);

        if ($id_match == 0) {
            return;
        }

        $model = $this->getModel();
        $model->setId($id_match);
        $list = $model->getList();

        if (count($list)) {
            $this->players = $model->getPlayers();
            $this->goals = $model->getGoals();
            $this->penalty = $model->getPenalty();

            $this->list = $list;
            $this->document->setTitle($list['home'] . ' - ' . $list['visitor']);

            if ($this->list['w1so'] != null || $this->list['w2so'] != null || $this->list['w1ot'] != null || $this->list['w2ot'] != null) {
                $doc = JFactory::getDocument();
                $style = '#board #sc_m_penalty { visibility: visible;}';
                $doc->addStyleDeclaration($style);
            }
            JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/hockey.php');
            parent::display('raw');
        } else {
            echo '<div class="alert alert-info">' . JText::_("COM_HOCKEY_NO_REPORT") . '</div>';
        }
    }

}
