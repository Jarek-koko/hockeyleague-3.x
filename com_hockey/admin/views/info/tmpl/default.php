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
<form action="<?php echo JRoute::_('index.php?option=com_hockey'); ?>" method="post" name="adminForm" id="adminForm">
<?php if (!empty($this->sidebar)) : ?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif; ?>
<div id="ht" class="row-fluid">
    <div class="span6" >
        <div id="my_team" class="well">
            <img src="<?php echo JUri::root(true); ?>/administrator/components/com_hockey/assets/images/big-logo.png" alt="HockeLeague"/>
        </div>

        <span><?php echo JText::_('COM_HOCKEY_STATUS'); ?></span>
        <!-- status calendar -->
        <div class="well well-small">
            <?php echo JText::_('COM_HOCKEY_MODULE_STATUS_CALENDAR'); ?>
            <?php if ($this->calendar['ok']) : ?>
                <span class="hockey-ok"><i class="icon-ok"></i><?php echo $this->calendar['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><i class="icon-remove"></i><?php echo $this->calendar['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status matchdays -->
        <div class="well well-small">
            <?php echo JText::_('COM_HOCKEY_MODULE_STATUS_MATCHDAYS'); ?>
            <?php if ($this->matchdays['ok']) : ?>
                <span class="hockey-ok"><i class="icon-ok"></i><?php echo $this->matchdays['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><i class="icon-remove"></i><?php echo $this->matchdays['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status scoreboard -->
        <div class="well well-small">
            <?php echo JText::_('COM_HOCKEY_MODULE_STATUS_STANDINGS'); ?>
            <?php if ($this->standings['ok']) : ?>
                <span class="hockey-ok"><i class="icon-ok"></i><?php echo $this->standings['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><i class="icon-remove"></i><?php echo $this->standings['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status topplayer -->
        <div class="well well-small">
            <?php echo JText::_('COM_HOCKEY_MODULE_STATUS_TOPPLAYER'); ?>
            <?php if ($this->topplayer['ok']) : ?>
                <span class="hockey-ok"><i class="icon-ok"></i><?php echo $this->topplayer['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><i class="icon-remove"></i><?php echo $this->topplayer['mesg']; ?></span>
            <?php endif; ?>
        </div>

        <!-- status scoreboard -->
        <div class="well well-small">
            <?php echo JText::_('COM_HOCKEY_MODULE_STATUS_SCOREBOARD'); ?>
            <?php if ($this->scoreboard['ok']) : ?>
                <span class="hockey-ok"><i class="icon-ok"></i><?php echo $this->scoreboard['mesg']; ?></span>
            <?php else : ?>
                <span class="hockey-error"><i class="icon-remove"></i><?php echo $this->scoreboard['mesg']; ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="span4" id="info-space">
        <div class="well">
            <p><span><?php echo JText::_('COM_HOCKEY_AUTHOR'); ?>:</span> <?php echo $this->info['author']; ?></p>
            <p><span><?php echo JText::_('COM_HOCKEY_VERSION'); ?>:</span> <?php echo $this->info['version']; ?></p>
            <p><span><?php echo JText::_('COM_HOCKEY_CREATIONDATE'); ?>:</span> <?php echo $this->info['creationdate']; ?></p>
            <p><span><?php echo JText::_('COM_HOCKEY_COPYRIGHT'); ?>:</span> <?php echo $this->info['copyright']; ?></p>
            <p><span><?php echo JText::_('COM_HOCKEY_AUTHOR_URL'); ?>:</span> <a href="<?php echo $this->info['authorurl']; ?>"><?php echo $this->info['authorurl']; ?></a></p>
            <p><span><?php echo JText::_('COM_HOCKEY_GPL'); ?>:</span> <a href="http://www.gnu.org/licenses/gpl-2.0.html"><?php echo $this->info['gpl']; ?></a></p>
        </div>
    </div>
</div>
</div>
</form>



