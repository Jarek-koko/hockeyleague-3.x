<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

if (!empty($this->items)):
    echo $this->loadTemplate('body');
else: ?>
<div class="alert alert-info">
<?php echo JText::_("COM_HOCKEY_NO_MATCHES"); ?>
</div>
<?php endif; ?>