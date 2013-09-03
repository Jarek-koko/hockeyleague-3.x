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


class HockeyViewPlayer extends JViewLegacy
{
    function display($tpl = null)
    {
        JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR. '/helpers/hockey.php');
        JHtml::_('jquery.framework',  true, true);
        $document = JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/media/com_hockey/js/dropit.js');
        $app = JFactory::getApplication();
        $id = (int) $app->input->get('id', 0, 'int');

        if ($id == 0) {
            echo JText::_("COM_HOCKEY_INVALID_PARAM");
            return false;
        }

        $model = $this->getModel();
        $player = $model->getItem();

        if (is_object($player)) {
            $this->regular_stat = $model->getStatplayer(0);
            $this->playoff_stat = $model->getStatplayer(1);
            $this->selpl        = $model->getSelectPlayers();
            $this->player       = $player;

            $document = JFactory::getDocument();
            $document->setTitle($player->first_name . ' ' . $player->name);

            parent::display($tpl);
        }
        else echo "<p><b>" . JText::_('COM_HOCKEY_NO_DATA') . "</b></p>";
    }
}
?>