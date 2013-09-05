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
JLoader::register('HockeyHelper', JPATH_COMPONENT_ADMINISTRATOR. '/helpers/hockey.php');

class HockeyViewPlayers_flash extends JViewLegacy
{

    function display($tpl = null)
    {
        $rows =  $this->get('Items');
        // modify the MIME type
        $document =  JFactory::getDocument();
        $document->setMimeEncoding('text/xml');
        echo '<?xml version="1.0" encoding="UTF-8" ?>' . "\n";
        echo '<element>' . "\n";
        if (!empty($rows)) {
            foreach ($rows as $row) {
                echo "\t\t" . '<player>' . "\n";
                echo "\t\t\t" . '<name>' . $row->name . '</name>' . "\n";
                echo "\t\t\t" . '<firstname>' . $row->first_name . '</firstname>' . "\n";
                echo "\t\t\t" . '<height>' . $row->height . '</height>' . "\n";
                echo "\t\t\t" . '<weight>' . $row->weight . ' </weight>' . "\n";
                echo "\t\t\t" . '<date>' . JHTML::_('date', $row->date_of_birth, JText::_('DATE_FORMAT_LC4')) . '</date>' . "\n";
                echo "\t\t\t" . '<position>' . HockeyHelper::getPositionString((int) $row->position) . '</position>' . "\n";
                echo "\t\t\t" . '<description><![CDATA[ ' . $row->description . '   ]]> </description>' . "\n";
                echo "\t\t\t" . '<photo>/' . $row->photo . '</photo>' . "\n";
                echo "\t\t\t" . '<number>' . $row->number . '</number>' . "\n";
                echo "\t\t" . '</player>' . "\n";
            }
        }
        echo '</element>' . "\n";
    }
}
?>