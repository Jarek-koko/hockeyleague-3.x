<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
if ($this->id_season != 0):
?>
<div class="component-title"> <?php echo $this->title_head; ?></div>
<script type="text/javascript">
//<![CDATA[
js = jQuery.noConflict();
js(document).ready(function() {
   js('#form-type-sez').get(0).reset();

    function getData(var_id, id_type) {
        var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=schedule&id='+ var_id + '&<?php echo JSession::getFormToken(); ?>=1&menu_id=<?php echo $this->menuid; ?>&type_id='+ id_type +'&format=raw';
        js.ajax({
            url: Url,
            dataType: 'html',
            cache: false,
            beforeSend: function() {
                js('#schedule-content').fadeOut();
            },
            success: function (data) { 
                js("#schedule-content").html(data).fadeIn();
            },
            error : function () {
                js("#schedule-content").html('<div class="alert alert-error"><span><?php echo JText::_('COM_HOCKEY_ERROR_PAGE') ?></span></div>');
            }
        });
    }

    js('#form-type-sez').submit(function() {
        var id_sez =  js('#sezon_id option:selected').val();
        var id_type =  js('#tom_id option:selected').val();
        getData(id_sez,id_type); 
        return false;
    });
});
//]]>
</script>
<div class="row-fluid">
<form action="index.php" method="post" id="form-type-sez">
<div class="form-horizontal span12 well">
<?php echo $this->items; ?>
<?php echo $this->stom; ?>
<button type="submit" class="btn btn-info" value="val"><?php echo JText::_('COM_HOCKEY_GO'); ?></button>
</div>     
</form>
</div>
<div id="schedule-content">
 <!-- getData ajax -->
</div>
<div>
    <span><?php echo JText::_('COM_HOCKEY_PENALTY_SHORT'); ?> -  <?php echo JText::_('COM_HOCKEY_PENALTY'); ?> </span>
    &nbsp;
    <span><?php echo JText::_('COM_HOCKEY_OVERTIME_SHORT'); ?> -  <?php echo JText::_('COM_HOCKEY_OVERTIME'); ?> </span>
</div>
<?php else: ?>
<div class="alert alert-error">
<?php echo JText::_('COM_HOCKEY_NO_SEASON'); ?>
</div>
<?php endif; ?>