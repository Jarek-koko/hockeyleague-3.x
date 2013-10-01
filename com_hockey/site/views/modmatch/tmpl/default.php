<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
?>
<table class="mday">
<thead>
<tr>
    <th><?php echo JText::_('COM_HOCKEY_MODULE_HOME') ?></th>
    <th><?php echo JText::_('COM_HOCKEY_MODULE_SCORE'); ?></th>
    <th><?php echo JText::_('COM_HOCKEY_MODULE_VISITOR'); ?></th>
 </tr>
</thead>
<tbody>
<?php $k = 0;
foreach ($this->items as $row ) :
    $style = ($k == 0) ? 'row1' : 'row2';
   if ($row->score_1==null) $row->score_1=' - ';
   if ($row->score_2==null) $row->score_2=' - ';
   ?>
   <tr class="<?php echo $style;?>">
       <td><?php echo $row->team1; ?></td>
       <td><?php echo $row->score_1; ?> : <?php echo $row->score_2; ?></td>
       <td><?php echo $row->team2; ?></td>
   </tr>
<?php $k = 1- $k; endforeach; ?>
</tbody>
</table>