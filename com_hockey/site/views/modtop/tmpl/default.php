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
<table class="ttop">
<tbody>
<?php foreach ($this->items as $i => $row) : ?>
<tr>
    <td><?php echo ++$i ?></td>
    <td class="ttop1"><a href="<?php echo JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id, false); ?>"><?php echo $row->name; ?></a></td>
    <td><?php echo $row->points ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>