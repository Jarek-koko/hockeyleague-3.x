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
<div class="component-title"><?php echo $this->title_head ; ?></div>
<script type="text/javascript">
//<![CDATA[
js = jQuery.noConflict();
js(document).ready(function() {

<?php if ($this->show_select): ?>
   js('#form-table').get(0).reset();
<?php endif; ?>
    getData(<?php echo $this->id_season; ?>);   

    function getData(var_id) {
        var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=teams&id='+ var_id + '&<?php echo JSession::getFormToken(); ?>=1&format=raw';
        js.ajax({
            url: Url,
            dataType: 'html',
            cache: false,
            beforeSend: function() {
                 js('#table-standing-content').html("<div class='loading'><img src='<?php echo JURI::base(true); ?>/media/com_hockey/images/loading.gif' /></div>");
            },
            success: function (data) { 
                 js('#table-standing-content').hide().html(data).fadeIn();        
            },
            error : function () {
                js("#table-standing-content").html('<div class="alert alert-error"><span><?php echo JText::_('COM_HOCKEY_ERROR_PAGE') ?></span></div>');
            }
        });
    }

    js('#sezon_id').change(function() { 
        var id_sez =  js('#sezon_id option:selected').val();
        getData(id_sez);   
    });
});
//]]>
</script>
<?php if ($this->show_select): ?>
<div class="well">
<form id="form-table" action="index.php" method="post" class="center">
    <?php echo $this->items; ?>      
</form>
</div>
<?php endif; ?>
<div id="table-standing-content">
 <!-- getData ajax -->
</div>
<?php else: ?>
<div class="alert alert-error">
<?php echo JText::_('COM_HOCKEY_NO_SEASON'); ?>
</div>
<?php endif; ?>


