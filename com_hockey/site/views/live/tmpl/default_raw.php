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
<!-- scoreboard -->
<div id="scoreboard1">
<div id="board">
    <div id="sc_l">
        <p class="game_info"><?php echo JHTML::_('date', $this->list['data'], JText::_('DATE_FORMAT_LC3')); ?></p>
        <p class="game_team"><span><?php echo $this->list['home']; ?></span></p>
         <div class="logo-b">
        <?php if (JFile::exists(JPATH_ROOT.'/'.$this->list['logo1'])) {
                echo '<img class="lo" src="' . JURI::base(true) . '/' . $this->list['logo1'] . '" alt="logo1" />';
            } else {
                echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo1" />';
            } ?>
         </div>
    </div> <!-- #sc_l -->
    <div id="sc_m">
        <div id="sc_m_penalty">
           <?php if ($this->list['w1so'] != null || $this->list['w2so'] != null): ?>
            <span><?php echo JText::_('COM_HOCKEY_SHOUTOUTS') ;?></span>
            <?php elseif ($this->list['w1ot'] != null || $this->list['w2ot'] != null): ?>
            <span><?php echo JText::_('COM_HOCKEY_OVERTIME') ;?></span>
            <?php endif; ?>
        </div>
        <div class="game_score">
            <span id="sc_m_l_score"><?php echo $this->list['score_1']; ?></span>
            <span id="sc_m_m_score">:</span>
            <span id="sc_m_r_score"><?php echo $this->list['score_2']; ?></span>
        </div> <!-- .game_score -->
        <ul id="game_score_sub">
            <?php if ($this->list['w1p1'] != null): ?>
                <li>
                    <span><?php echo JText::_('COM_HOCKEY_1P') ?></span>
                    <span><?php echo $this->list['w1p1'] . ' : ' . $this->list['w2p1']; ?></span>
                    <span></span>
                </li>
                <li>
                    <span><?php echo JText::_('COM_HOCKEY_2P') ?></span>
                    <span><?php echo $this->list['w1p2'] . ' : ' . $this->list['w2p2']; ?></span>
                    <span></span>
                </li>
                <li>
                    <span><?php echo JText::_('COM_HOCKEY_3P') ?></span>
                    <span><?php echo $this->list['w1p3'] . ' : ' . $this->list['w2p3']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
            <?php if ($this->list['w1ot'] != null || $this->list['w2ot'] != null): ?>
                <li>
                    <span><?php echo JText::_('COM_HOCKEY_OT') ?></span>
                    <span><?php echo $this->list['w1ot'] . ' : ' . $this->list['w2ot']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
            <?php if ($this->list['w1so'] != null || $this->list['w2so'] != null): ?>
                <li>
                    <span><?php echo JText::_('COM_HOCKEY_SO') ?></span>
                    <span><?php echo $this->list['w1so'] . ' : ' . $this->list['w2so']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
        </ul> <!-- #game_score_sub -->
    </div> <!-- #sc_m -->
    <div id="sc_r">
        <p class="game_info"><span><?php echo $this->list['place']; ?></span></p>
        <p class="game_team"><span><?php echo $this->list['visitor'] ?></span></p>
        <div class="logo-b">
        <?php  if (JFile::exists(JPATH_ROOT.'/'. $this->list['logo2'])) {
                echo '<img class="lo" src="' . JURI::base(true) . '/' . $this->list['logo2'] . '" alt="logo2" />';
            } else {
                echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo2" />';
        } ?>
        </div>
    </div> <!-- #sc_r -->
  <?php if ($this->end == 1): ?>
    <div id="sc_more_info">
        <span><?php echo JText::_('COM_HOCKEY_END_OF_MATCH') ?></span>
    </div>
   <?php else: ?>
    <div id="sc_more_info">
        <span><?php echo JText::_('COM_HOCKEY_LIVE') ?></span>
    </div>
    <?php endif; ?>
    <div class="clr">.</div>
</div>
</div>
<!-- end scoreboard -->

<hr />
<div id="report-body" class="rp"> 
    <div class="row-fluid">
        <div class="span12 opis">
            <div class="par"><?php echo JText::_('COM_HOCKEY_RECAP'); ?></div>
            <div style="padding: 5px; text-align: left;"><?php echo JHTML::_('content.prepare', $this->list ['description']); ?></div>
        </div>
    </div>
  <hr />
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
  <hr />
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
<hr />
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
<hr />    
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
</div>


