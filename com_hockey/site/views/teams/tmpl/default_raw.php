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
<div id="teams-list">
<?php if (!empty($this->items)): ?>
    <?php foreach ($this->items as $row): ?>
        <div class="headtab">
             <div><?php echo $row->name ?></div>
        </div>
        <div class="row-fluid team-list">
            <div class="span2">
                <div class="thumbnail">
                    <img src="<?php echo JUri::base() . $row->logo ?>" alt="<?php echo $row->name ?>"  />
                </div>
            </div>
            <div class="span10">
                <div class="well">
                    <div><?php echo JHTML::_('content.prepare', $row->description ); ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else : ?>  
<div class="alert alert-error">
    <p><b><?php echo JText::_('COM_HOCKEY_NO_DATA') ?></b></p>
</div>
<?php endif; ?>
</div>
