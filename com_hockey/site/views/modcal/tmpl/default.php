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
<?php if ($this->id_team != 0): //display matches for one team ?>
<?php foreach ($this->list as $row ) : ?>
<div class="row-fluid">
    <div class="span12">
        <div class="pop-title"><?php echo JHTML::_('date', $row->data, JText::_('DATE_FORMAT_LC3')); ?>&nbsp;&nbsp;<?php echo $row->time; ?></div>
    </div>
</div>
<div class="row-fluid">
    <span class="span6 team-name"><?php echo $row->home ?></span>
    <span class="span6 team-name"><?php echo $row->visitor ?></span>
</div> 
<div class="row-fluid pop-pading">
    <div class="span4 logo">
        <?php
        if (JFile::exists(JPATH_ROOT . '/' . $row->logo1 )) {
            echo '<img class="lo" src="' . JURI::base(true) . '/' . $row->logo1. '" alt="logo1" />';
        } else {
            echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo1" />';
        }
        ?>
    </div>
    <div class="span4 score">
        <?php
        if ($row->score_1 != null) {
            echo $row->score_1 . ' : ' . $row->score_2;
        }
        else
            echo ' - vs - ';
        ?>
    </div>
    <div class="span4 logo">
        <?php
        if (JFile::exists(JPATH_ROOT . '/' . $row->logo2)) {
            echo '<img class="lo" src="' . JURI::base(true) . '/' . $row->logo2 . '" alt="logo2" />';
        } else {
            echo '<img class="lo" src="' . JURI::base(true) . '/images/hockey/teams/nologo.png" alt="logo2" />';
        }
        ?>
    </div>
</div>
<?php endforeach;?>
<?php else: //display all matches  ?>
<?php foreach ($this->list as $row ) : ?>
<div class="row-fluid">
    <div class="span12">
         <div class="pop-title"><?php echo JHTML::_('date', $row->data, JText::_('DATE_FORMAT_LC3')); ?>&nbsp;&nbsp;<?php echo $row->time; ?></div>
     </div>
</div>
<div class="row-fluid pop-pading">
    <div class="span5 team-name"><?php echo $row->home ?></div>
    <div class="span2 score-m">
    <?php
        if ($row->score_1 != null) {
            echo $row->score_1 . ' : ' . $row->score_2;
        } else    echo ' - vs - ';
    ?>
     </div>
     <div class="span5 team-name"><?php echo $row->visitor ?></div>
 </div>
<?php endforeach;?>
<?php endif; ?>
