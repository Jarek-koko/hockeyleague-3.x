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


$add_month = $params->get('add_month', '0');
$show_tooltips = $params->get('show_tooltips', '1');
$idteam  = intval($params->get( 'idteam', '0' ));
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$sez = intval($params->get('sez', 0));
$uri = JFactory::getURI();
$config = JFactory::getConfig();
$tzoffset = $config->get('config.offset');
$time = time() + ($tzoffset * 60 * 60);
$today_month = date('m', $time); 
$today_year = date('Y', $time); 
$today = date('j', $time); 
//$today_month    = 1;
//$today_year     = 2011;
//$today          = 26;


$app = JFactory::getApplication();
$post_month = (int) $app->input->get('month', 0, 'int');
$post_year = (int) $app->input->get('year', 0, 'int');

if (($post_month < 1) OR ($post_month > 12) OR ($post_month == 0)) {
    $post_month = $today_month;
}

if (($post_year < 1970) OR ($post_year > 2500) OR ($post_year == 0)) {
    $post_year = $today_year;
}

$post_month = $post_month + $add_month;
if ($post_month > 12) {
    $post_month = $post_month - 12;
    $post_year = $post_year + 1;
}

$prev_year = $post_year;
$next_year = $post_year;

$prev_month = $post_month - 1;
if ($prev_month < 1) {
    $prev_month = 12;
    $prev_year = $prev_year - 1;
}

$next_month = $post_month + 1;
if ($next_month > 12) {
    $next_month = 1;
    $next_year = $next_year + 1;
}

//url buton 
$back = '<a class="btn btn-mini" href="javascript:submitForm(' . $prev_month . ',' . $prev_year . ')"><i class="icon-undo"></i></a>';
$next = '<a class="btn btn-mini" href="javascript:submitForm(' . $next_month . ',' . $next_year . ')"><i class="icon-redo"></i></a>';

$first_of_month = gmmktime(0, 0, 0, $post_month, 1, $post_year);
list($month, $post_year, $weekday) = explode(',', gmstrftime('%m,%Y,%w', $first_of_month));

$weekday = ($weekday + 6 ) % 7;

$title = JString::strtoupper(date('F', mktime(0, 0, 0, $month + 1, 0, 0)));

$days = modcalendarHelper::getmatchdays($post_month, $post_year, $params);

require JModuleHelper::getLayoutPath('mod_calendar', $params->get('layout', 'default'));