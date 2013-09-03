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
<?php if ($this->player->position != 1) : ?>
    <?php if ($this->regular_stat) : ?>
        <table class="tabplayer">
            <caption><?php echo JText::_('COM_HOCKEY_PLAYER_RS') ?></caption>
            <tr>
                <th><?php echo JText::_('COM_HOCKEY_SEASON') ?></th>
                <th><?php echo JText::_('COM_HOCKEY_STATS_MATCH') ?></th>
                <th><?php echo JText::_('COM_HOCKEY_STATS_SCORED') ?></th>
                <th><?php echo JText::_('COM_HOCKEY_STATS_ASISTS') ?></th>
                <th><?php echo JText::_('COM_HOCKEY_STATS_POINTS') ?></th>
                <th><?php echo JText::_('COM_HOCKEY_STATS_PENALTY') ?></th>
            </tr>
            <?php foreach ($this->regular_stat as $row): ?>
                <?php $points = $row->assist + $row->shoot ?>
                <tr><td><?php echo $row->name ?></td>
                    <td><?php echo $row->meczy ?></td>
                    <td><?php echo $row->shoot ?></td>
                    <td><?php echo $row->assist ?></td>
                    <td><?php echo $points ?></td>
                    <td><?php echo $row->kary ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="leg_p"><?php echo JText::_('COM_HOCKEY_STATS_INFO_P') ?></div>
    <?php endif; ?>
<?php endif ?>

<?php if ($this->player->position == 1) : ?>
    <?php if ($this->regular_stat) : ?>
        <table class="tabplayer">
            <caption><?php echo JText::_('COM_HOCKEY_PLAYER_RS') ?></caption>
            <tr><th><?php echo JText::_('COM_HOCKEY_SEASON') ?></th>
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
            <?php
            foreach ($this->regular_stat as $row) :
                @$sv = ($row->total_save / ($row->total_goals + $row->total_save));
                @$gaa = ($row->total_goals * 60) / $row->time_match;
            ?>
                <tr><td><?php echo $row->name?></td>
                    <td><?php echo $row->meczy ?></td>
                    <td><?php echo $row->time_match ?></td>
                    <td><?php echo $row->total_goals ?></td>
                    <td><?php echo $row->total_save ?></td>
                    <td><?php echo round($gaa, 2) ?></td>
                    <td><?php echo round($sv, 2) ?></td>
                    <td><?php echo $row->shoot ?></td>
                    <td><?php echo $row->assist ?></td>
                    <td><?php echo $row->kary ?></td>
                </tr>
        <?php endforeach; ?>
        </table>
        <div class="leg_p"><?php echo JText::_('COM_HOCKEY_STATS_INFO_G') ?></div>
    <?php endif; ?>
<?php endif ?>
