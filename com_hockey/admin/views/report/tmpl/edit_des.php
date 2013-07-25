<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$url_des = JURI::base().'index.php?option=com_hockey&task=ajax.setDescription&' . JSession::getFormToken() . '=1&id=' . $this->item->id. '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
    //  ajax submit form 
    var options = { success: showResponse, url: '<?php echo $url_des; ?>',type: 'post', dataType: 'json'};

    js("#des-form").submit(function(e) {
       <?php echo $this->editor->save('description'); ?>
        js(this).ajaxSubmit(options);
        return false;
    });

    // show Response for saving 
    function showResponse(data) {
        if (data.status === "1" ) {
            js.pop_up(data.message, true);
        } else {
            js.pop_up(data.message, false);
        }
    }
});
</script>
<form action="index.php" method="post" id="des-form">
<div class="well well-small">
    <?php echo $this->getToolbarDescription(); ?>	
</div>
<div class="row-fluid">
    <div class="span12 form-horizontal">
        <div class="control-group">
            <?php echo $this->editor->display("description", $this->item->description , "100%", "400", "150", "10", false);  ?>
             <?php echo $this->getImageButton(); ?>
        </div>
    </div>
</div>
</form>