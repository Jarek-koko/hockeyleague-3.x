<?php
/**
 * @version     1.0.0
 * @package     mod_standings
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$rows = ModStandingsHelper::getList($params);
if (!count($rows)) {
    return;
}

$title1 = $params->get('title1', 'P');
$title2 = $params->get('title2', 'Team');
$title3 = $params->get('title3', 'Ptk');
$group1 = $params->get('group1', '0');
$group2 = $params->get('group2', '1');
$class1 = $params->get('class1', 'tab20');
$class2 = $params->get('class2', 'tab21');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

JHtml::_('jquery.framework');
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base(true) . '/media/com_hockey/css/style.css');

require JModuleHelper::getLayoutPath('mod_standings', $params->get('layout', 'default'));
