<?php
/**
 * @version     1.0.0
 * @package     mod_standings
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
?>
<div>
<table class="tabb">
<thead>
<tr>
    <th><?php echo $title1; ?></th>
    <th><?php echo $title2; ?></th>
    <th><?php echo $title3; ?></th>
</tr>
</thead>
<tbody>
<?php foreach ($rows as $key => $row) : ?>
<tr class="<?php echo ($row->group == $group1) ? $class1 : $class2; ?>">
    <td><?php echo ++$key; ?></td>
    <td><?php echo $row->name; ?></td>
    <td><?php echo $row->points; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>