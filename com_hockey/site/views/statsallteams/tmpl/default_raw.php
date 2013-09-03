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
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function()
{
    jQuery(" #tableplayers1, #tableplayers2, #tableplayers3, #tableplayers4").tablesorter({widgets:['zebra']});
});
//]]>
</script>
<div class="headtab">
    <div><?php echo $this->title; ?></div>
</div>
<?php if (($this->id == 4) || ($this->id == 3)) : ?>
<table  class="tableplayers" id="tableplayers<?php echo $this->id ?>" border="0" cellpadding="0" cellspacing="1">
    <thead>
        <tr>
            <th>*</th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_POS') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_TEAM') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_MATCH') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_MIN_PLAYED') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_AGAINST') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_SAVE') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GAA') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_SAVE_PORCENTAGE') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_SCORED') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_ASISTS') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_PENALTY') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->lista as  $key => $row) :
            $uri = JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id);
            @$sv = ($row->total_save / ($row->total_goals + $row->total_save));
            @$gaa = ($row->total_goals * 60) / $row->time_match;
            ?>
            <tr><td><?php echo ++$key ?></td>
                <td><?php echo HockeyHelper::getPositionShort($row->position) ?></td>
                <td style="text-align:left; padding-left: 10px;"><a href="<?php echo $uri ?>"><?php echo $row->first_name ?> <?php echo $row->name ?></a></td>
                <td style="text-align:left; padding-left: 10px;"><?php echo $row->team ?></td>
                <td><?php echo $row->mecze ?></td>
                <td><?php echo $row->time_match ?></td>
                <td><?php echo $row->total_goals ?></td>
                <td><?php echo $row->total_save ?></td>
                <td><?php echo round($gaa, 2) ?></td>
                <td><?php echo round($sv, 2) ?></td>
                <td><?php echo $row->bramki ?></td>
                <td><?php echo $row->asysty ?></td>
                <td><?php echo $row->kary ?></td>
            </tr>
            <?php endforeach; ?>
    </tbody></table>
<div class="leg_p"><?php echo JText::_('COM_HOCKEY_STATS_INFO_G') ?><br /><?php echo JText::_('COM_HOCKEY_STATS_INFO') ?></div>
<?php else : ?>
<table  class="tableplayers" id="tableplayers<?php echo $this->id ?>" border="0" cellpadding="0" cellspacing="1">
    <thead>
        <tr>
            <th>*</th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_POS') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_TEAM') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_MATCH') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_POINTS') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_SCORED') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_ASISTS') ?></th>
            <th><?php echo JText::_('COM_HOCKEY_STATS_PENALTY') ?></th>
        </tr>
    </thead><tbody>
    <?php foreach ($this->lista as  $key => $row) :  $uri = JRoute::_('index.php?option=com_hockey&view=player&id=' . $row->id); ?>
        <tr><td><?php echo ++$key ?></td>
            <td><?php echo HockeyHelper::getPositionShort($row->position) ?></td>
            <td style="text-align:left; padding-left: 10px;"><a href="<?php echo $uri ?>"><?php echo $row->first_name ?> <?php echo $row->name ?></a></td>
            <td style="text-align:left; padding-left: 10px;"><?php echo $row->team ?></td>
            <td><?php echo $row->mecze ?></td>
            <td><?php echo $row->punkty ?></td>
            <td><?php echo $row->bramki ?></td>
            <td><?php echo $row->asysty ?></td>
            <td><?php echo $row->kary ?></td>
        </tr>
    <?php endforeach; ?>
</tbody></table>
<div class="leg_p"><?php echo JText::_('COM_HOCKEY_STATS_INFO_P') ?><br /><?php echo JText::_('COM_HOCKEY_STATS_INFO') ?></div>
<?php endif ?>
