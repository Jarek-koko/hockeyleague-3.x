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
<div class="row-fluid">
<div class="component-title">
    <a href = "javascript:history.back()" class="pull-left btn btn-mini btn-info">
        <span class="icon-undo  icon-white"></span><?php echo JText::_('COM_HOCKEY_BACK'); ?>
    </a>
     <?php echo JHTML::_('date', $this->list['data'], JText::_('DATE_FORMAT_LC3')); ?>
</div>
</div>
<div id="scoreboard1">
<!-- wynik meczu -->
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
    <div class="clr">.</div>
</div>
</div>


