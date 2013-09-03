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
    js = jQuery.noConflict();
    js(document).ready(function() {
        js('.menu-player').dropit();
    });
</script>
<div class="headtab-p"> 
<div id="m_l">
     <span class="namep">:: <?php echo $this->player->first_name . ' ' . $this->player->name ?> ::</span>
</div>
<div id="m_p">
    <ul class="menu-player">
        <li>
            <a href="#" class="btn btn-small"><span class="icon-arrow-down-2" ></span> <span><?php echo JText::_('COM_HOCKEY_SELECT_PLAYER'); ?></span></a>
            <ul>
                <?php foreach ($this->selpl as $player) : ?>
                    <li><a href="<?php echo JRoute::_('index.php?option=com_hockey&view=player&id=' . $player->value); ?>"><span><?php echo $player->text; ?></span></a></li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>
</div>
<div class="clr"></div>
</div>

