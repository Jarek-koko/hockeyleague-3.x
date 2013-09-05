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
<script type="text/javascript">
    var flashvars = {
        myVariable: <?php echo $this->idteam; ?>,
        myUrl: '<?php echo JURI::base(true); ?>'
    };

    var params = {
        menu: "false",
        quality: "high"
    };

    swfobject.embedSWF(
            "<?php echo JURI::base(true); ?>/components/com_hockey/views/players_flash/tmpl/players.swf",
            "myFlash", "800", "600", "9.0.0", "expressInstall.swf", flashvars, params);
</script>
<div class="component-title"><?php echo $this->title_head; ?></div>
<div id="myFlash">
</div>



