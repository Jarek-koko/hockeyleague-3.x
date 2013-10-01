<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

$id = intval($params->get('id', 0));
$sez = intval($params->get('sez', 0));
$sname = intval($params->get('sname', 0));

if (($id == 0) || ($sez == 0)) {
    echo "Select season and current matchday";
    return;
}

$title = $params->get('title', 'Matchday');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_matchdays', $params->get('layout', 'default'));
