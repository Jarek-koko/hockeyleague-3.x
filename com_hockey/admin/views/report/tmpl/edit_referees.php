<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$ref = array_merge(array('0' => JText::_('COM_HOCKEY_REF_SELECT')), $this->ref);
$url_ref = JURI::base() . 'index.php?option=com_hockey&task=ajax.setReferees&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        //  ajax submit form 
        var options = {success: showResponse, beforeSubmit: validation, url: '<?php echo $url_ref; ?>', type: 'post', dataType: 'json'};

        js("#ref-form").submit(function(e) {
            js(this).ajaxSubmit(options);
            return false;
        });
        //  validation form 
        function validation() {
            if (document.formvalidator.isValid(document.id('ref-form')))
            {
                return true;
            }
            else
            {
                js.pop_up('<?php echo JText::_('JGLOBAL_VALIDATION_FORM_FAILED'); ?>', false);
                return false;
            }
        }
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
<form action="index.php" method="post" id="ref-form" class="form-validate">
<div class="well well-small">
    <?php echo $this->getToolbarReferees() ?>	
</div>
<div class="well well-small"> 
<div class="row-fluid">
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_SELECT_REFERER'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericlist', $ref, 'id_referee1', ' class="inputbox validate-notzero required" ', 'value', 'text', $this->item->id_referee1); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_SELECT_LINESMEN'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericlist', $ref, 'id_referee2', 'class="inputbox"', 'value', 'text', $this->item->id_referee2); ?>
            </div>
        </div>
    </div>
    <div class="span6 form-horizontal">
         <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_SELECT_LINESMEN'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericlist', $ref, 'id_referee3', 'class="inputbox"', 'value', 'text', $this->item->id_referee3); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_SELECT_REFERER2'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericlist', $ref, 'id_referee4', 'class="inputbox"', 'value', 'text', $this->item->id_referee4); ?>
            </div>
        </div>
    </div>
</div>
</div>
</form>