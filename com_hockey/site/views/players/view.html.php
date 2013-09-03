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

class HockeyViewPlayers extends JViewLegacy
{
    protected $params;
    protected $team_name;

    public function display($tpl = null)
    {
        JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR. '/helpers/hockey.php');
        JHtml::_('jquery.framework',  true, true);
        $document = JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/media/com_hockey/js/jquery.tablesorter.js');
        $document->addScript(JURI::base(true) . '/media/com_hockey/js/tooltip.js');

        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');

        $model = $this->getModel();
        $model->setTeam($this->params->get('idteam'));

        $this->team_name = $model->getNameTeam();
        $this->players = $model->getItems();
        
        $this->_prepareDocument();
        parent::display($tpl);
    }

    /**
     * Prepares the document
     */
    protected function _prepareDocument()
    {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_HOCKEY_PLAYERS_TITLE_HEAD'));
        }
        $title = $this->params->get('page_title', '');
        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
        } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
            $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
        }
        $this->document->setTitle($title);

        if ($this->params->get('menu-meta_description')) {
            $this->document->setDescription($this->params->get('menu-meta_description'));
        }

        if ($this->params->get('menu-meta_keywords')) {
            $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
        }

        if ($this->params->get('robots')) {
            $this->document->setMetadata('robots', $this->params->get('robots'));
        }
    }
}
?>