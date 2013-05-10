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
<?php if (!empty($this->sidebar)) : ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
<?php else : ?>
    <div id="j-main-container">
<?php endif; ?>
<div class="row-fluid">
    <div class="span6" >
        <div id="my_team" class="well">
            <img src="<?php echo JUri::root(true); ?>/administrator/components/com_hockey/assets/images/big-logo.png" alt="HockeLeague"/>
        </div>

        <span><?php echo JText::_('HOC_STATUS'); ?></span>
        <!-- status calendar -->
        <div class="well">
            <?php echo JText::_('HOC_MODULE_STATUS_CALENDAR'); ?>
            <?php if ($this->calendar['ok']) : ?>
                <span class="hockey-ok"><?php echo $this->calendar['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><?php echo $this->calendar['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status matchdays -->
        <div class="well">
            <?php echo JText::_('HOC_MODULE_STATUS_MATCHDAYS'); ?>
            <?php if ($this->matchdays['ok']) : ?>
                <span class="hockey-ok"><?php echo $this->matchdays['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><?php echo $this->matchdays['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status scoreboard -->
        <div class="well">
            <?php echo JText::_('HOC_MODULE_STATUS_STANDINGS'); ?>
            <?php if ($this->standings['ok']) : ?>
                <span class="hockey-ok"><?php echo $this->standings['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><?php echo $this->standings['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status topplayer -->
        <div class="well">
            <?php echo JText::_('HOC_MODULE_STATUS_TOPPLAYER'); ?>
            <?php if ($this->topplayer['ok']) : ?>
                <span class="hockey-ok"><?php echo $this->topplayer['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><?php echo $this->topplayer['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status scoreboard -->
        <div class="well">
            <?php echo JText::_('HOC_MODULE_STATUS_SCOREBOARD'); ?>
            <?php if ($this->scoreboard['ok']) : ?>
                <span class="hockey-ok"><?php echo $this->scoreboard['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><?php echo $this->scoreboard['mesg']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="span4 well" style="border: 1px solid rgb(204, 204, 204);  background: rgb(255, 255, 255) none repeat scroll 0% 0%;" >
        <p><span><?php echo JText::_('AUTHOR'); ?>:</span> <?php echo $this->info['author']; ?></p>
        <p><span><?php echo JText::_('VERSION'); ?>:</span> <?php echo $this->info['version']; ?></p>
        <p><span><?php echo JText::_('HOC_CREATIONDATE'); ?>:</span> <?php echo $this->info['creationdate']; ?></p>
        <p><span><?php echo JText::_('COPYRIGHT'); ?>:</span> <?php echo $this->info['copyright']; ?></p>
        <p><span><?php echo JText::_('AUTHOR URL'); ?>:</span> <a href="<?php echo $this->info['authorurl']; ?>"><?php echo $this->info['authorurl']; ?></a></p>
        <p><span><?php echo JText::_('GPL'); ?>:</span> <a href="<?php echo $this->info['gpllink']; ?>"><?php echo $this->info['gpl']; ?></a></p>
    </div>

</div>
</div>



