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
<?php if(!empty($this->items)): ?>
<script type="text/javascript">
//<![CDATA[
    js = jQuery.noConflict();
    js(document).ready(function() {
       js('div[id^="idmatchday_"]').hide();
       js('#idmatchday_1').show();
       js('.select-matchday:eq(0)').addClass('matchbut');
       var num = 0;
       
       
       js('.select-matchday').click(function() {
            js('div[id^="idmatchday_"]').hide();
             val = js(this).text();
            js('.select-matchday:eq('+ num +')').removeClass('matchbut');
             num = val - 1;
            js('#idmatchday_'+ val).show();
            js(this).addClass('matchbut');
       });
    });
//]]>
</script>
<?php echo $this->loadTemplate('square'); ?>
<hr />
<?php echo $this->loadTemplate('body'); ?>
<?php else: ?>
<div class="alert alert-info">
<?php echo JText::_("COM_HOCKEY_NO_MATCHES"); ?>
</div>
<?php endif;?>