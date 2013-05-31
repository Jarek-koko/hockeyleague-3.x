<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
class HockeyController extends JControllerLegacy
{
    /**
     *
     * @var array -  all views which need to be checked 
     * if season was selected 
     */
    public $views_check = array("table", "tables", "league", "leagues", "playoff", "playoffs", "sparring", "sparrings", "report", "matchdays", "matchday");

    /**
     * Method to display a view.
     *
     * @param	boolean			$cachable	If true, the view output will be cached
     * @param	array			$urlparams	An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
     *
     * @return	JController		This object to support chaining.
     * @since	1.5
     */
    public function display($cachable = false, $urlparams = false)
    {
        require_once JPATH_COMPONENT . '/helpers/hockey.php';

        $view = JFactory::getApplication()->input->getCmd('view', 'info');
        JFactory::getApplication()->input->set('view', $view);

        if ($view == 'sezons' || $view == 'sezon') {
            $this->ACLCheck();
        }


        if (in_array($view, $this->views_check)) {
            $this->SezonCheck();
        }

        parent::display($cachable, $urlparams);

        return $this;
    }

    /**
     * Method to check authorisation for section sezon
     * @return boolean
     */
    private function ACLCheck()
    {
        if (!JFactory::getUser()->authorise('hockey.manage.sezon', 'com_hockey')) {
            $this->setError(JText::_('JERROR_ALERTNOAUTHOR'));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect(JRoute::_('index.php?option=com_hockey&view=info', false));
            return false;
        }

        return true;
    }

    /**
     * Method to check season selected  
     * @return boolean 
     */
    public function SezonCheck()
    {
        if (!HockeyHelper::getSezon()) {
            $this->setError(JText::_('COM_HOCKEY_MUST_SELECT_SEASON'));
            $this->setMessage($this->getError(), 'notice');
            $this->setRedirect(JRoute::_('index.php?option=com_hockey&view=select', false));
            return false;
        }
        return true;
    }

}
