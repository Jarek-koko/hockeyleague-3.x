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
        
        if (localStorage.getItem('sp-content<?php echo $this->menuid; ?>')) {
            js("#schedulep-content").html(localStorage.getItem('sp-content<?php echo $this->menuid; ?>')).fadeIn();
            if ( localStorage.getItem("sp-select<?php echo $this->menuid; ?>")) {
                var optionValue = localStorage.getItem("sp-select<?php echo $this->menuid; ?>");
                js("#sezon_id").val(optionValue).find("option[value=" + optionValue +"]").attr('selected', true);
            }
        } else {
            getData(<?php echo $this->id_season; ?>);   
        }
  
        function getData(var_id) {
            var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=schedulep&id='+ var_id + '&<?php echo JSession::getFormToken(); ?>=1&menu_id=<?php echo $this->menuid; ?>&format=raw';
            js.ajax({
                url: Url,
                dataType: 'html',
                cache: false,
                beforeSend: function() {
                    js('#schedulep-content').fadeOut();
                },
                success: function (data) { 
                    js("#schedulep-content").html(data).fadeIn();
                    localStorage.setItem('sp-content<?php echo $this->menuid; ?>', data);
                },
                error : function () {
                    js("#schedulep-content").html('<div class="alert alert-error"><span><?php echo JText::_('COM_HOCKEY_ERROR_PAGE') ?></span></div>');
                }
            });
        }
        
        js('#sezon_id').change(function() { 
            var id_sez =  js('#sezon_id option:selected').val();
            localStorage.setItem('sp-select<?php echo $this->menuid; ?>', id_sez);
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
<div id="schedulep-content">
 <!-- getData ajax -->
</div>
<?php else: ?>
<div class="alert alert-error">
<?php echo JText::_('COM_HOCKEY_NO_SEASON'); ?>
</div>
<?php endif; ?>


