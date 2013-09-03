<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;
?>
<div class="component-title"><?php echo $this->title_head; ?></div>
<div id="myFlash">
<object type="application/x-shockwave-flash" data="<?php echo JURI::base(true); ?>/components/com_hockey/views/players_flash/tmpl/players.swf" width="800" height="600">
    <param name="movie" value="<?php echo JURI::base(true); ?>/components/com_hockey/views/players_flash/tmpl/players.swf" />
    <param name="quality" value="high"/>
    <param name=FlashVars value="myVariable=<?php echo $this->idteam; ?>&myUrl=<?php echo JURI::base(true); ?>" />
</object>
</div>



