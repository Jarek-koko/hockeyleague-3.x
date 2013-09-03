<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
echo $this->loadTemplate('scoreboard');
?>
<div id="report-body" class="rp"> 
    <?php echo JHtml::_('bootstrap.startTabSet', 'Tab_rep', array('active' => 'recap')); ?>
    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'recap', JText::_('COM_HOCKEY_RECAP')); ?>
    <div class="row-fluid">
        <div class="span12 opis">
            <div class="par"><?php echo JText::_('COM_HOCKEY_RECAP'); ?></div>
            <div style="padding: 5px; text-align: left;"><?php echo JHTML::_('content.prepare', $this->list ['description']); ?></div>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>

    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'goal', JText::_('COM_HOCKEY_GOAL')); ?>
    <div class="row-fluid">
        <div class="span12">
            <?php if ($this->goals) : ?>
                <div class="headtab">
                    <div> <?php echo JText::_('COM_HOCKEY_GOAL'); ?></div>
                </div>
                <table id="tabgoal">
                    <thead>
                        <tr>
                        <th><?php echo JText::_('COM_HOCKEY_SCORE'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_TIME'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_SHOOTER'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_ASSIST1'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_ASSIST2'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_INFO'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tmp_pos = null;
                        for ($i = 0, $n = count($this->goals); $i < $n; $i++) {
                            $row = &$this->goals [$i];
                            $kow = &$this->goals [$i + 1];
                            if ($tmp_pos != $row->period) { ?>
                                <tr><td colspan="6" class="ck"><?php echo ($row->period == 4) ? JText::_('COM_HOCKEY_OVERTIME') : JText::_('COM_HOCKEY_PERIOD') . ' ' . $row->period; ?></td></tr>
                            <?php } ?>
                            <tr style="text-align: center;">
                                <td><?php echo $row->score1; ?> : <?php echo $row->score2; ?></td>
                                <td><?php echo $row->time; ?></td>
                                <td><?php echo $row->shooter; ?></td>
                                <td><?php echo $row->assist1; ?></td>
                                <td><?php echo $row->assist2; ?></td>
                                <td><?php echo $row->info; ?></td>
                            </tr>
                            <?php
                            $tmp_pos = $row->period;
                        }
                        ?>
                    </tbody>
                </table>
                <p style="text-align: center; padding-bottom:20px;"><?php echo JText::_('COM_HOCKEY_INFO_TEXT'); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>
    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'penalyty', JText::_('COM_HOCKEY_PENALYTY')); ?>
    <div class="row-fluid">
        <div class="span12">
            <?php if ($this->penalty) : ?>
                <div class="headtab">
                    <div><?php echo JText::_('COM_HOCKEY_PENALYTY'); ?></div>
                </div>
                <table id="tabpenalyty">
                    <thead>
                        <tr>
                        <th><?php echo JText::_('COM_HOCKEY_TIME'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_PLAYER'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_PENALTY_NAME'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_MIN'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php
                        for ($i = 0, $n = count($this->penalty); $i < $n; $i++) {
                            $row = &$this->penalty [$i];
                            $kow = &$this->penalty [$i + 1];
                            if ($tmp_pos != $row->period) {  ?>
                            <tr><td colspan="4" class="ck"><?php echo ($row->period == 4) ? JText::_('COM_HOCKEY_OVERTIME') : JText::_('COM_HOCKEY_PERIOD') . ' ' . $row->period; ?></td></tr>
                            <?php } ?>
                            <tr style="text-align: center;">
                                <td><?php echo $row->time; ?></td>
                                <td><?php echo $row->player; ?></td>
                                <td><?php echo $row->note; ?></td>
                                <td><?php echo $row->time_p; ?> min</td>
                            </tr>
                            <?php
                            $tmp_pos = $row->period;
                        }
                        ?>
                    </tbody>
                </table>
            <?php endif ?>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>   

    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'refefees', JText::_('COM_HOCKEY_REFEREES')); ?>
    <div class="row-fluid">
        <div class="span6 ref">
            <div class="par"><?php echo JText::_('COM_HOCKEY_REFEREES'); ?></div>
            <ul><li><?php echo ($this->list['referee1']) ? $this->list['referee1'] : "--"; ?></li>
                <li><?php echo ($this->list['referee4']) ? $this->list['referee4'] : "--"; ?></li>
            </ul>
        </div>
        <div class="span6 ref">
            <div class="par"><?php echo JText::_('COM_HOCKEY_LINESMEN'); ?></div>
            <ul><li><?php echo ($this->list['referee2']) ? $this->list['referee2'] : "--"; ?></li>
                <li><?php echo ($this->list['referee3']) ? $this->list['referee3'] : "--"; ?></li>
            </ul>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>   
    
    
    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'player_stats', JText::_('COM_HOCKEY_PLAYER_STATS')); ?>
    <div class="row-fluid">
        <div class="span6">
            <div class="headtab">
                <div><?php echo $this->list ['home']; ?></div>
            </div>
            <table id="tabplayerstats1">
                <thead>
                    <tr>
                    <th>#</th>
                    <th><?php echo JText::_('COM_HOCKEY_POS'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_PLAYER_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_POINTS'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_GOAL_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_ASSIST'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_PIM'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0, $j = 1, $players = count($this->players); $i < $players; $i++) {
                        if ($this->players[$i]->id_team == $this->list ['team_1']) {
                            echo '<tr>';
                            echo '<td>' . $j++ . '</td>';
                            echo '<td>' . HockeyHelper::getPositionShort((int) $this->players[$i]->position) . '</td>';
                            echo '<td style="text-align:left; padding-left:5px;">' . $this->players[$i]->name . '</td>';
                            echo '<td>' . ($this->players[$i]->bramki + $this->players[$i]->asysta) . '</td>';
                            echo '<td>' . $this->players[$i]->bramki . '</td>';
                            echo '<td>' . $this->players[$i]->asysta . '</td>';
                            echo '<td>' . $this->players[$i]->kary . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>    
        </div>
        <div class="span6">
            <div class="headtab">
                <div><?php echo $this->list ['visitor']; ?></div>
            </div>
            <table id="tabplayerstats2">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo JText::_('COM_HOCKEY_POS'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_PLAYER_R'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_POINTS'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_GOAL_R'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_ASSIST'); ?></th>
                        <th><?php echo JText::_('COM_HOCKEY_PIM'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0, $j = 1, $players = count($this->players); $i < $players; $i++) {
                        if ($this->players[$i]->id_team == $this->list ['team_2']) {
                            echo '<tr>';
                            echo '<td>' . $j++ . '</td>';
                            echo '<td>' . HockeyHelper::getPositionShort((int) $this->players[$i]->position) . '</td>';
                            echo '<td style="text-align:left; padding-left:5px;">' . $this->players[$i]->name . '</td>';
                            echo '<td>' . ($this->players[$i]->bramki + $this->players[$i]->asysta) . '</td>';
                            echo '<td>' . $this->players[$i]->bramki . '</td>';
                            echo '<td>' . $this->players[$i]->asysta . '</td>';
                            echo '<td>' . $this->players[$i]->kary . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?> 
    
    <!-- Start TAB -->
    <?php echo JHtml::_('bootstrap.addTab', 'Tab_rep', 'goalie_stats', JText::_('COM_HOCKEY_GOALIE_STATS')); ?>
    <div class="row-fluid">
        <div class="span12">
            <div class="headtab">
                <div><?php echo $this->list ['home']; ?></div>
            </div>
            <table id="tabgoaliestats1">
                <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo JText::_('COM_HOCKEY_GOALIES_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_TOI'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_SAVE'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_GA'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_SV'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_GOAL_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_ASSIST'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_PIM'); ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0, $j = 1, $goalie = count($this->goalie); $i < $goalie; $i++) {
                        if ($this->goalie[$i]->id_team == $this->list ['team_1']) {
                            echo '<tr>';
                            echo '<td>' . $j++ . '</td>';
                            echo '<td style="text-align:left; padding-left:5px;">' . $this->goalie[$i]->name . '</td>';
                            echo '<td>' . $this->goalie[$i]->time_p . '</td>';
                            echo '<td>' . $this->goalie[$i]->save . '</td>';
                            echo '<td>' . $this->goalie[$i]->goals . '</td>';
                            echo '<td>' . round($this->goalie[$i]->save / ($this->goalie[$i]->goals + $this->goalie[$i]->save), 2);
                            echo '<td>' . $this->goalie[$i]->bramki . '</td>';
                            echo '<td>' . $this->goalie[$i]->asysta . '</td>';
                            echo '<td>' . $this->goalie[$i]->kary . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div class="headtab">
                <div><?php echo $this->list ['visitor']; ?></div>
            </div>
            <table id="tabgoaliestats2">
                <thead>
                    <tr>
                    <th>#</th>
                    <th><?php echo JText::_('COM_HOCKEY_GOALIES_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_TOI'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_SAVE'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_GA'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_SV'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_GOAL_R'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_ASSIST'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_PIM'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0, $j = 1, $goalie = count($this->goalie); $i < $goalie; $i++) {
                        if ($this->goalie[$i]->id_team == $this->list ['team_2']) {
                            echo '<tr>';
                            echo '<td>' . $j++ . '</td>';
                            echo '<td style="text-align:left; padding-left:5px;">' . $this->goalie[$i]->name . '</td>';
                            echo '<td>' . $this->goalie[$i]->time_p . '</td>';
                            echo '<td>' . $this->goalie[$i]->save . '</td>';
                            echo '<td>' . $this->goalie[$i]->goals . '</td>';
                            echo '<td>' . round($this->goalie[$i]->save / ($this->goalie[$i]->goals + $this->goalie[$i]->save), 2);
                            echo '<td>' . $this->goalie[$i]->bramki . '</td>';
                            echo '<td>' . $this->goalie[$i]->asysta . '</td>';
                            echo '<td>' . $this->goalie[$i]->kary . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>    
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
</div>


