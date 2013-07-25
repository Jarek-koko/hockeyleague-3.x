<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;


jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Hockey records.
 */
class HockeyModelInfo extends JModelList
{

    public function CheckModule($name)
    {

        $db = $this->getDbo();
        $query = $db->getQuery(true);
        $query->select('id');
        $query->from(' #__modules');
        $query->where('module = ' . $db->quote($name));

        $db->setQuery($query);
        $db->execute();
        $num_rows = $db->getNumRows();
        

        if ($num_rows > 0) {
            $result = Array('ok' => true, 'mesg' => JText::_('COM_HOCKEY_INSTALLED'));
            return $result;
        } else {
            $result = Array('ok' => false, 'mesg' => JText::_('COM_HOCKEY_NOT_INSTALLED'));
            return $result;
        }
    }

    public function getComponentInfo()
    {
        $info = array();

        $xml = JFactory::getXML(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'hockey.xml');

        $info['author'] = (string) $xml->author;
        $info['version'] = (string) $xml->version;
        $info['copyright'] = (string) $xml->copyright;
        $info['authorurl'] = (string) $xml->authorUrl;
        $info['creationdate'] = (string) $xml->creationDate;
        $info['gpl']  =  (string) $xml->license;
      
        return $info;
    }

}
