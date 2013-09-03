<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

class HockeyHelper
{
	 /**
     * Method return  list of season in form select html
     * @return string 
     */
    public static function getSeasonListSelect($idseason)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
            ->select('s.name AS text, s.id AS value')
            ->from('#__hockey_system AS s')
            ->order('s.id DESC');
        $db->setQuery($query);

        $rows = $db->loadObjectList();
        // Compile the options.
        $options = array();
    
        if (!empty($rows)) {
            foreach ($rows as $item) {
                $options[] = JHtml::_('select.option', $item->value, $item->text);
            }
        }
        return JHtml::_('select.genericlist', $options, 'sezon_id', '', 'value', 'text', $idseason);
    }

}

