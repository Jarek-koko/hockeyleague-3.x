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


class HockeyViewSchedule extends JViewLegacy {

  public function display($tpl = null) {
      
        JLoader::register('HockeyHelper', JPATH_COMPONENT . '/helpers/hockey.php');
        
        $app = JFactory::getApplication();
        $this->params = $app->getParams('com_hockey');
        $this->id_season = (int) $this->params->get('idseason', 0 );
        $this->title_head = $this->params->get('title_head',  JText::_('COM_HOCKEY_SCHEDULE_TITLE_HEAD'));
       
        $this->items = HockeyHelper::getSeasonListSelect($this->id_season);
        $this->menuid = $app->getMenu()->getActive()->id;
        
        
        $stom = array();
        $stom[] = JHTML::_('select.option', '0', JText::_('COM_HOCKEY_REGULAR_SEASON_SELECT'));
        $stom[] = JHTML::_('select.option', '1', JText::_('COM_HOCKEY_PLAYOFF_SELECT'));
        $stom[] = JHTML::_('select.option', '2', JText::_('COM_HOCKEY_OTHER_SELECT'));
        $tom = JHTML::_('select.genericlist', $stom, 'tom_id', 'class="inputbox" size="1" ', 'value', 'text');
        
        $this->stom = $tom;
        
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

        // Because the application sets a default page title,
        // we need to get it from the menu item itself
        $menu = $menus->getActive();
        if ($menu) {
            $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
        } else {
            $this->params->def('page_heading', JText::_('COM_HOCKEY_SCHEDULE_TITLE_HEAD'));
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