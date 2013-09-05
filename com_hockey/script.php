<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
/**
 * Script file of Hockey League component
 */
class com_hockeyInstallerScript
{
    /**
     * method to install the component
     *
     * @return void
     */
    function install($parent)
    {
        // $parent is the class calling this method
        //  echo '<p>Welcome to the Hockey League</p>';
        //copy sampel media
        $parent = $parent->getParent();
        $parent->parseMedia($this->image_path());
    }

    /**
     * method to uninstall the component
     *
     * @return void
     */
    function uninstall($parent)
    {
        // $parent is the class calling this method
        //echo '<p>Goodbye my Lord</p>';
        $parent = $parent->getParent();
        $parent->removeFiles($this->image_path());
    }

    /**
     * method to update the component
     *
     * @return void
     */
    function update($parent)
    {
        // $parent is the class calling this method
        echo '<p>Check if everything is ok</p>';

        //copy sampel media
        $parent = $parent->getParent();
        $parent->parseMedia($this->image_path());
    }

    /**
     * method to run before an install/update/uninstall method
     *
     * @return void
     */
    function preflight($type, $parent)
    {
        $jversion = new JVersion();
        if (version_compare($jversion->getShortVersion(), '3.0', 'lt')) {
            Jerror::raiseWarning(null, 'Cannot install Hockey League in a Joomla release prior to 3.0');
            return false;
        }
    }

    /**
     * method to run after an install/update/uninstall method
     *
     * @return void
     */
    function postflight($type, $parent)
    {
        echo '<div><b><p>Installation Status :</p></b>';
        if ($direxists[] = JFolder::exists(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'hockey')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b>Directory not created, you must create manually. - /images/hockey </p>';
        }

        if ($direxists[] = JFolder::exists(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'hockey' . DIRECTORY_SEPARATOR . 'players')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey/players</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b>Directory not created, you must create manually - /images/hockey/players</p>';
        }

        if ($direxists[] = JFolder::exists(JPATH_SITE . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'hockey' . DIRECTORY_SEPARATOR . 'teams')) {
            echo '<p><b><span style="color:green;">FINISHED : - </span></b> Directory created - /images/hockey/teams</p>';
        } else {
            echo '<p><b><span style="color:red;">Note : - </span></b>Directory not created, you must create manually - /images/hockey/teams</p>';
        }

        echo '<br />';
        if (in_array(false, $direxists)) :
            echo '<code>Please check following directories:
                <ul>
                    <li>/images/hockey</li>
                    <li>/images/hockey/teams</li>
                    <li>/images/hockey/players</li>
                </ul></code>';
        endif;
        echo '</div>';
    }

    function image_path()
    {
        $mediaXML = new SimpleXMLElement('
			<media folder="images" destination="../images/hockey">
			<filename>teams/nologo.png</filename>
			<filename>teams/index.html</filename>
			<filename>players/nophoto.jpg</filename>
			<filename>players/index.html</filename>
			</media>');

        // $newsXML->asXML();
        return $mediaXML;
    }
}
