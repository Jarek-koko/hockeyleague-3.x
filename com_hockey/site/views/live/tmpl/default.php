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
//<![CDATA[
js = jQuery.noConflict();
js(document).ready(function()
{
    var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=live&<?php echo JSession::getFormToken(); ?>=1&menu_id=<?php echo $this->menuid; ?>&format=raw';
    (function request() {
        js.ajax({
            url: Url,
            dataType: 'html',
            cache: false,
            beforeSend: function() {
                js('#live').html("<img src='<?php echo JURI::base(true); ?>/media/com_hockey/images/loading.gif' />");
            },
            success: function(data) {
                js("#live").html(data);
            },
            error: function() {
                js("#live").html('<div class="alert alert-error"><span><?php echo JText::_('COM_HOCKEY_ERROR_PAGE') ?></span></div>');
            }
        });
        //calling the anonymous function after x milli seconds
        setTimeout(request, <?php echo $this->time; ?>);
    })(); //self Executing anonymous function
});
//]]>
</script>
<div class="row-fluid">
    <div class="component-title"><?php echo $this->title_head; ?></div>
</div>
<div id="live">
</div>