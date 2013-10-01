<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$list = modScoreboardHelper::getList($params);
if (!count($list)) {
    echo "<h3>" . JText::_('MOD_SCOREBOARD_BAD_ID') . "</h3>";
    return;
}

$info =     $params->get('info', '');
$title =    $params->get('title', 'Raport');
$width =    (int) $params->get('width', 800);
$height =   (int) $params->get('height', 600);
$popup =    (int) $params->get('popup', 1);

$show_countdown = (int) $params->get('show_countdown', 1);
$show_button =    (int) $params->get('show_button', 1);
$get_gt =         (int) $params->get('get_gt', 0);

if ($get_gt == 0) {
    $day = (int) $params->get('day', 01);
    $month = (int) $params->get('month', 01);
    $year = (int) $params->get('year', 2012);
    $hour = (int) $params->get('hour', 01);
    $minute = (int) $params->get('minute', 01);
    $second = (int) $params->get('second', 01);
} else {
    $arraydate = explode("-", $list['date']);
    $arraytime = explode(":", $list['time']);
    $day = (int) $arraydate[2];
    $month = (int) $arraydate[1];
    $year = (int) $arraydate[0];
    $hour = (int) $arraytime[0];
    $minute = (int) $arraytime[1];
    $second = (int) '00';
}

$mstart =   $params->get('m_start', 'Match is underway');
$tday =     $params->get('t_day', 'Days');
$thour =    $params->get('t_hour', 'Hours');
$tminute =  $params->get('t_minute', 'Minutes');
$tsecond =  $params->get('t_second', 'Seconds');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_scoreboard', $params->get('layout', 'default'));