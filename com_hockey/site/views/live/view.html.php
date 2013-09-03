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
class HockeyViewLive extends JViewLegacy
{
    protected $items;


    public function display($tpl = null)
    {
        $app = JFactory::getApplication('site');
        $this->params = $app->getParams('com_hockey');
        $this->menuid = $app->getMenu()->getActive()->id;

      
        $id_match = (int) $this->params->get('id_match', 0);
      
        $message1 = $this->params->get('message1', 'no match');
        $time = (int) $this->params->get('time');
        $time = (1000 * $time);

        if ($id_match == 0) {
            echo '<div class="alert alert-info"><span>' . $message1 . '</span></div>';
            return;
        }
        
        $this->title_head = $this->params->get('titlehead');
        $this->time = $time;
        $this->_prepareDocument();
        parent::display($tpl);
    }

    protected function _prepareDocument() {

        $app = JFactory::getApplication();
        $menus = $app->getMenu();
        $title = null;

        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', $this->params->get('titlehead'));
        }
        $title = $this->params->get('page_title', '');

        if (empty($title)) {
            $title = $app->getCfg('sitename');
        } elseif ($app->getCfg('sitename_pagetitles', 0)) {
            $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
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
