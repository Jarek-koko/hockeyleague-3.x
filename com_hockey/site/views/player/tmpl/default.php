<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

function birthday($dage) {
    list($Y, $m, $d) = explode("-", $dage);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}
?> 
<div class="component-title"><?php echo JText::_('COM_HOCKEY_PLAYER_TITLE'); ?> - <?php echo $this->player->name ?></div>
<div  id="players">
    <?php echo $this->loadTemplate('select') ?>
    <div class="row-fluid info-player">
        <div class="span4">
            <div class="photo-pl"> 
               <img src="<?php echo  JURI::base(true) .'/'. $this->player->photo; ?>" alt="<?php echo $this->player->name ?>" class="imgp" />
            </div>
        </div>
        <div class="span4">
            <div id="info-player-d">
            <p><?php echo JText::_('COM_HOCKEY_POSITION') ?> - <?php echo HockeyHelper::getPositionString((int) $this->player->position) ?></p>
            <p><?php echo JText::_('COM_HOCKEY_PLAYER_DATE') ?> - <?php echo ($this->player->date_of_birth === "0000-00-00") ? ' ' : JHTML::_('date', $this->player->date_of_birth, JText::_('DATE_FORMAT_LC4')); ?></p>
            <p><?php echo JText::_('COM_HOCKEY_PLAYER_AGE') ?> -  <?php echo ($this->player->date_of_birth === "0000-00-00") ? ' ' : birthday($this->player->date_of_birth); ?></p>
            <p><?php echo JText::_('COM_HOCKEY_PLAYER_WEIGHT') ?> - <?php echo $this->player->weight ?> kg</p>
            <p><?php echo JText::_('COM_HOCKEY_PLAYER_HEIGHT') ?> - <?php echo $this->player->height ?> cm </p>
            <p><?php echo JText::_('COM_HOCKEY_PLAYER_OLD_TEAM') ?> - <?php echo $this->player->team_old ?></p>
            </div>
        </div>
        <div class="span4">
            <div class="number-pl"><div id="nrp"><?php echo ($this->player->number != 0) ? $this->player->number : '?'; ?></div></div>
        </div>
    </div>
    <div class="row-fluid">
        <?php echo JHtml::_('bootstrap.startTabSet', 'Tab_player', array('active' => 'desc')); ?>
            <!-- Start TAB -->
            <?php echo JHtml::_('bootstrap.addTab', 'Tab_player', 'desc', JText::_('COM_HOCKEY_PLAYER_NOTES')); ?>
             <div class="box-tab-player"><?php echo $this->player->description ?></div>
            <?php echo JHtml::_('bootstrap.endTab'); ?> 
             <!-- Start TAB -->
            <?php echo JHtml::_('bootstrap.addTab', 'Tab_player', 'regular', JText::_('COM_HOCKEY_PLAYER_REGULAR')); ?>
            <div class="box-tab-player"><?php echo $this->loadTemplate('regular') ?></div>
            <?php echo JHtml::_('bootstrap.endTab'); ?> 
              <!-- Start TAB -->
            <?php echo JHtml::_('bootstrap.addTab', 'Tab_player', 'playoff', JText::_('COM_HOCKEY_PLAYER_PLAYOFF')); ?>
            <div class="box-tab-player"><?php echo $this->loadTemplate('playoff') ?></div>
            <?php echo JHtml::_('bootstrap.endTab'); ?> 
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>  
    </div>
</div>