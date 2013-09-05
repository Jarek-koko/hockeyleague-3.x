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

class HockeyViewPlayers_flash extends JViewLegacy
{

    function display($tpl = null)
    {
        $this->params = JFactory::getApplication()->getParams();
        $this->title_head = $this->params->get('title_head', JText::_('COM_HOCKEY_PLAYERS_TITLE_HEAD'));

        JHtml::_('jquery.framework',  true, true);
        $document = JFactory::getDocument();
        $document->addScript(JURI::base(true) . '/media/com_hockey/js/swfobject.js');
        
        $this->idteam = $this->params->get('idteam');
        $this->title_head = $this->title_head;

        $this->_prepareDocument();
        parent::display($tpl);
    }

    protected function _prepareDocument()
    {
        $app = JFactory::getApplication();
        $menus = $app->getMenu();

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_HOCKEY_PLAYERS_TITLE_HEAD'));
        }

        $title = $this->params->get('page_title', $this->title_head);

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