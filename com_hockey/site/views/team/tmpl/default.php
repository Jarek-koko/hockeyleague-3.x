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
<div class="component-title"><?php echo $this->item->name; ?></div>
<div id="teams-list">
<?php if (!empty($this->item)): ?>
<div class="row-fluid">
    <div class="span2">
        <div class="thumbnail">
            <img src="<?php echo JUri::base() . $this->item->logo ?>" alt="<?php echo $this->item->name ?>"  />
        </div>
    </div>
    <div class="span10">
        <div class="well">
            <div><?php echo JHTML::_('content.prepare', $this->item->description ); ?></div>
        </div>
    </div>
</div>
<?php else : ?>  
<div class="alert alert-error">
    <p><b><?php echo JText::_('COM_HOCKEY_NO_DATA') ?></b></p>
</div>
<?php endif; ?>
</div>
