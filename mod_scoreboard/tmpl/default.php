<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

if ($popup == 1){
$link = ($show_button) ? JRoute::_('index.php?option=com_hockey&view=report&id=' . $list['id'] . '&tmpl=component') : false;
} else {
$link = ($show_button) ? JRoute::_('index.php?option=com_hockey&view=report&id=' . $list['id']) : false;
}
?>
<div class="sb">
<?php if ($show_countdown ==1) : ?>
<div id="countdown<?php echo $module->id; ?>" class="countdown">
    <div class="cd_row">
        <div class="cd_section">
             <span class="cd_amount" id="day<?php echo $module->id; ?>">0</span>
            <br /><?php echo $tday; ?>
        </div>
        <div class="cd_section">
            <span class="cd_amount" id="hour<?php echo $module->id; ?>">0</span>
            <br /><?php echo $thour; ?>
        </div>
        <div class="cd_section">
            <span class="cd_amount" id="minutes<?php echo $module->id; ?>">0</span>
            <br /><?php echo $tminute; ?>
        </div>
        <div class="cd_section">
            <span class="cd_amount" id="seconds<?php echo $module->id; ?>">0</span>
            <br /><?php echo $tsecond; ?>
        </div>
        <div style="clear:both;"></div>
    </div>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery.noConflict();
jQuery(document).ready(function() {update<?php echo $module->id; ?>();});
function update<?php echo $module->id; ?>()
{
     this.date1 = new Date();
     this.date2 = new Date (<?php echo $year.",".--$month.",".$day.",".$hour.",".$minute.",".$second; ?>);
     this.sec = (this.date2 - this.date1) / 1000;
     this.n = 24 * 3600;

    if (this.sec > 0) {
        this.day = Math.floor (this.sec / this.n);
        this.hour = Math.floor ((this.sec - (this.day * this.n)) / 3600);
        this.min = Math.floor ((this.sec - ((this.day * this.n + this.hour * 3600))) / 60);
        this.sec = Math.floor (this.sec - ((this.day * this.n + this.hour * 3600 + this.min * 60)));
        if (this.day < 10) {  this.day = "0"+ this.day; }
        if (this.hour < 10) { this.hour = "0"+ this.hour;}
        if (this.min < 10) {  this.min = "0"+ this.min; }
        if (this.sec < 10)  { this.sec = "0"+ this.sec; }

        jQuery('#day<?php echo $module->id; ?>').html("<b>"+this.day+"</b>");
        jQuery('#hour<?php echo $module->id; ?>').html("<b>"+this.hour+"</b>");
        jQuery('#minutes<?php echo $module->id; ?>').html("<b>"+this.min+"</b>");
        jQuery('#seconds<?php echo $module->id; ?>').html("<b>"+this.sec+"</b>");
    }
    else if (Math.abs(this.sec) < (2 * 3600)) {
        jQuery('#countdown<?php echo $module->id; ?>').html('<span><b class="mstart"><?php echo $mstart; ?></b><span>');
    }
    else {
        jQuery('#countdown<?php echo $module->id; ?>').css('display', 'none');
    }
    setTimeout('update<?php echo $module->id; ?>()', 1000);
};
//]]>
</script>
<?php endif; ?>
<div class="scoreboard">
   <?php if (!empty($info)) :?>
        <div><?php echo $info; ?></div>
   <?php endif; ?>
<!-- wynik meczu -->
<div class="board">
    <div class="sc_l">
        <p class="game_info"><?php echo JHTML::_('date', $list['data'], JText::_('DATE_FORMAT_LC3')); ?> - <?php echo $list['time']; ?></p>
        <p class="game_team"><span><?php echo $list['home']; ?></span></p>
         <div class="logo-b">
        <?php if (JFile::exists(JPATH_ROOT.'/'.$list['logo1'])) {
                echo '<img class="lo" src="' . JURI::base(true) . '/' . $list['logo1'] . '" alt="logo1" />';
            } else {
                echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo1" />';
            } ?>
         </div>
    </div> <!-- #sc_l -->
    <div class="sc_m">
        <div class="sc_m_penalty">
           <?php if ($list['w1so'] != null || $list['w2so'] != null): ?>
            <span><?php echo JText::_('MOD_SCOREBOARD_SHOUTOUTS') ;?></span>
            <?php elseif ($list['w1ot'] != null || $list['w2ot'] != null): ?>
            <span><?php echo JText::_('MOD_SCOREBOARD_OVERTIME') ;?></span>
            <?php endif; ?>
        </div>
        <div class="game_score">
            <span class="sc_m_l_score"><?php echo (!empty($list['score_1']) ) ? $list['score_1'] : '-'; ?></span>
            <span class="sc_m_m_score">:</span>
            <span class="sc_m_r_score"><?php echo (!empty($list['score_2']) ) ? $list['score_2'] : '-'; ?></span>
        </div> <!-- .game_score -->
        <ul class="game_score_sub">
            <?php if ($list['w1p1'] != null): ?>
                <li>
                    <span><?php echo JText::_('MOD_SCOREBOARD_1P') ?></span>
                    <span><?php echo $list['w1p1'] . ' : ' . $list['w2p1']; ?></span>
                    <span></span>
                </li>
                <li>
                    <span><?php echo JText::_('MOD_SCOREBOARD_2P') ?></span>
                    <span><?php echo $list['w1p2'] . ' : ' . $list['w2p2']; ?></span>
                    <span></span>
                </li>
                <li>
                    <span><?php echo JText::_('MOD_SCOREBOARD_3P') ?></span>
                    <span><?php echo $list['w1p3'] . ' : ' . $list['w2p3']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
            <?php if ($list['w1ot'] != null || $list['w2ot'] != null): ?>
                <li>
                    <span><?php echo JText::_('MOD_SCOREBOARD_OT') ?></span>
                    <span><?php echo $list['w1ot'] . ' : ' . $list['w2ot']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
            <?php if ($list['w1so'] != null || $list['w2so'] != null): ?>
                <li>
                    <span><?php echo JText::_('MOD_SCOREBOARD_SO') ?></span>
                    <span><?php echo $list['w1so'] . ' : ' . $list['w2so']; ?></span>
                    <span></span>
                </li>
            <?php endif; ?>
        </ul> <!-- #game_score_sub -->
    </div> <!-- #sc_m -->
    <div class="sc_r">
        <p class="game_info"><span><?php echo $list['place']; ?></span></p>
        <p class="game_team"><span><?php echo $list['visitor'] ?></span></p>
        <div class="logo-b">
        <?php  if (JFile::exists(JPATH_ROOT.'/'. $list['logo2'])) {
                echo '<img class="lo" src="' . JURI::base(true) . '/' . $list['logo2'] . '" alt="logo2" />';
            } else {
                echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo2" />';
        } ?>
        </div>
    </div> <!-- #sc_r -->
    <?php  if ($link): ?> 
    <div class="sc_more_info">
           <?php if ($popup == 1) : ?>
              <?php JHTML::_('behavior.modal'); ?>
                 <a class="modal" href="<?php echo $link ?>" rel="{handler:'iframe', size: {x:'<?php echo $width; ?>', y:'<?php echo $height; ?>'}}"><span class="link_rel"><?php echo $title; ?></span></a>
             <?php else: ?>
                 <a class="modal" href="<?php echo $link ?>"><span class="link_rel"><?php echo $title; ?></span></a>
           <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="clr">.</div>
</div>
</div>
</div>
