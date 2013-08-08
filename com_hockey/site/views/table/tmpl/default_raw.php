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
<?php if(!empty($this->items)) :?>
<script type="text/javascript">
//<![CDATA[
    js = jQuery.noConflict();
    js(document).ready(function() {
        js("#tablesorter").tablesorter({sortList: [[0, 0], [2, 1]], headers: {1: {sorter: false}}, widgets: ['zebra']});
    });
//]]>
</script>
<?php endif;?>
<div class="row-fluid">
<div class="span12">
    <table class="tableleague" id="tablesorter">
        <thead>
            <tr>
                <th> - </th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_TEAM'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_POINTS'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_M'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_W'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_R'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_P'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_PZ'); ?></th>
                <th><?php echo JText::_('COM_HOCKEY_TAB_RCA'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($this->items as $i => $item) : ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="al"><?php echo $item->team_name ?></td>
                <td><?php echo $item->points ?></td>
                <td><?php echo $item->matchday ?></td>
                <td><?php echo $item->won ?></td>
                <td><?php echo $item->ties ?></td>
                <td><?php echo $item->lost ?></td>
                <td><?php echo $item->goals_scored. '/' . $item->goals_against ?></td>
                <td><?php echo $item->difference ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<hr />
<div class="row-fluid legend-standings">
<div class="span6">
    <p><b>- <?php echo JText::_('COM_HOCKEY_TAB_LEGEND'); ?>-</b></p>
    <ul>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_POINTS'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_M'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_W'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_R'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_P'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_PZ1'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_PZ2'); ?></li>
        <li><?php echo JText::_('COM_HOCKEY_TAB_L_RCA'); ?></li>
    </ul>
</div>
<div class="span6">
    <p><b>- <?php echo JText::_('COM_HOCKEY_TAB_POINTS_SEASON') ?> -</b></p>
    <ul>
        <li><b><?php echo $this->info->p_w ?></b> <?php echo JText::_('COM_HOCKEY_TAB_MATCH_W') ?></li>
        <li><b><?php echo $this->info->p_p ?></b> <?php echo JText::_('COM_HOCKEY_TAB_MATCH_L') ?></li>
        <?php
        if ($this->info->shutouts != "T") {
            echo '<li><b>' . $this->info->p_r. '</b> ' . JText::_('COM_HOCKEY_TAB_MATCH_D') . '</li>';
        }
        if ($this->info->overtime == "T") {
            echo '<li><b>' . $this->info->p_d_w . '</b> ' . JText::_('COM_HOCKEY_TAB_MATCH_WO') . '</li><li><b>' . $this->info->p_d_p . '</b> ' . JText::_('COM_HOCKEY_TAB_MATCH_LO') . '</li>';
        }

        if ($this->info->shutouts == "T") {
            echo '<li><b>' . $this->info->p_k_w . '</b> ' . JText::_('COM_HOCKEY_TAB_MATCH_WS') . '</li><li><b>' . $this->info->p_k_p . '</b>  ' . JText::_('COM_HOCKEY_TAB_MATCH_LS') . '</li>';
        }
        ?>
    </ul>
</div>
</div>