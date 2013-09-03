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

class HockeyViewStatsallteams extends JViewLegacy
{

    function display($tpl = null)
    {
        if (!JSession::checkToken('get')) {
            echo JText::_("COM_HOCKEY_INVALID_TOKEN");
            return false;
        }

        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');
        $sez = (int) $app->input->get('sez', 0, 'int');
        $limit = (int) $app->input->get('limit', 0, 'int');
      
        $a = array(0,25,50,75,100);
        if (($id == 0) || ($sez == 0) || (!in_array($limit, $a, true)) ) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR . '/helpers/hockey.php');
        $document = JFactory::getDocument();
        $document->setMimeEncoding('text/plain');
        $model = $this->getModel();
        $model->setLimit($limit);

        switch ($id) {
            case 4:
                $lista = $model->getListGolies(1, $sez);
                $title = JText::_('COM_HOCKEY_STAT_GOLIES_PLAYOFF');
                break;
            case 3:
                $lista = $model->getListGolies(0, $sez);
                $title = JText::_('COM_HOCKEY_STAT_GOLIES_SEASON_R');
                break;
            case 2:
                $lista = $model->getListPlayers(1, $sez);
                $title = JText::_('COM_HOCKEY_STAT_PLAYERS_PLAYOFF');
                break;
            default:
                $lista = $model->getListPlayers(0, $sez);
                $title = JText::_('COM_HOCKEY_STAT_PLAYERS_SEASON_R');
                break;
        }
        
        $this->lista = $lista;
        $this->title = $title;
        $this->id =$id;
        parent::display('raw');
    }
}
?>