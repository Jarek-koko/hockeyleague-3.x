<?php
/**
 * @version     1.0.0
 * @package     mod_topplayer
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

$sez = intval($params->get('sez', 0));
$idteam = intval($params->get('idteam', 0));
$title1 = ( $params->get('title1', 'P') );
$title2 = ( $params->get('title2', 'G') );
$title3 = ( $params->get('title3', 'A') );
$type = intval($params->get('type_of_match', 0));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/media/com_hockey/css/style.css');

require JModuleHelper::getLayoutPath('mod_topplayer', $params->get('layout', 'default'));





