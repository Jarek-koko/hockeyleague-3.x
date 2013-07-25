<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$url_result  = JURI::base().'index.php?option=com_hockey&task=ajax.setResult&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
     stat_box();
    // ajax submit form
    var options = {target: null, beforeSubmit: validation, success: showResponse, url: '<?php echo $url_result; ?>', type:'post', dataType:'json'};

    js("#result-form").submit(function(e) {
        js(this).ajaxSubmit(options);
        return false;
    });
    // validation form 
    function validation() {
        if (document.formvalidator.isValid(document.id('result-form')))
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
    // checkbox system
    function check_box(ob, box) {
        var $this = js(ob).parent("label:first");
        if (js(ob).is(':checked')) {
            $this.addClass('active');
            box.show();
        } else {
            $this.removeClass('active');
            box.hide();
        }
    }
    // function for showing or hiding  button checkbox 
    function stat_box()
    {
        if (js("#shutouts").length > 0) {
            check_box(js("#shutouts"), js('#shutouts-box'));

            js('#shutouts').click(function() {
                check_box(this, js('#shutouts-box'));
            });
        }

        if (js("#overtime").length > 0) {
            check_box(js("#overtime"), js('#overtime-box'));

            js('#overtime').click(function() {
                check_box(this, js('#overtime-box'));
            });
        }
    }
});
</script>
<form action="index.php" method="post" id="result-form" class="form-validate">
<div class="well well-small">
    <?php echo $this->getToolbarResult(); ?>	
</div>
<?php if (($this->item->uscore == 1) && ($this->type !=0) ): ?>
<div class="alert alert-error">
    <?php echo JText::_('COM_HOCKEY_NOTE_USCORE'); ?>
</div>
<?php endif; ?>
<div id="result-box">
<div class="row center">
    <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_HOME'); ?></div>
    <div class="span6"><?php echo JText::_('COM_HOCKEY_RESULT_SCORE'); ?></div>
    <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_VISITORS'); ?></div>
</div>
<div class="row center">
    <div class="span3" id="team_1"><?php echo $this->item->team1 ?></div>
    <div class="span6">
        <input type="text" name="score_1" value="<?php echo $this->item->score_1 ?>" size="3" maxlength="3" class="required validate-numeric input-mini"/>
        <span>:</span>
        <input type="text" name="score_2" value="<?php echo $this->item->score_2 ?>" size="3" maxlength="3" class="required validate-numeric input-mini"/>
    </div>
    <div class="span3" id="team_2"><?php echo $this->item->team2 ?></div>
</div> 
<div class="row top-buffer center">
        <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_PERIOD'); ?></div>
        <div class="span6"><?php echo JText::_('COM_HOCKEY_RESULT_HOME') . ' : ' . JText::_('COM_HOCKEY_RESULT_VISITORS'); ?></div>
        <div class="span3"></div>
</div>
<div class="row center">
    <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_T1'); ?></div>
    <div class="span6">
        <input type="text" name="w1p1" value="<?php echo $this->item->w1p1 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
        <span>:</span>
        <input type="text" name="w2p1" value="<?php echo $this->item->w2p1 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
    </div>
     <div class="span3"></div>
</div>
<div class="row center">
    <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_T2'); ?></div>
    <div class="span6">
        <input type="text" name="w1p2"  value="<?php echo $this->item->w1p2 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
        <span>:</span>
        <input type="text" name="w2p2"  value="<?php echo $this->item->w2p2 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
    </div>
    <div class="span3"></div>
</div>
<div class="row center">
    <div class="span3"><?php echo JText::_('COM_HOCKEY_RESULT_T3'); ?></div>
    <div class="span6">
        <input type="text" name="w1p3"  value="<?php echo $this->item->w1p3 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
        <span>:</span>
        <input type="text" name="w2p3"  value="<?php echo $this->item->w2p3 ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
    </div>
     <div class="span3"></div>
</div>
<?php if (($this->item->ot == "T") || ($this->type != 0)) : ?>
<div class="row top-buffer center" id="overtime-box">
    <div class="span3">
        <?php echo JText::_('COM_HOCKEY_RESULT_OT'); ?>
    </div>
    <div class="span6">
        <input type="text" name="w1ot"  value="<?php echo $this->item->w1ot ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
        <span>:</span>
        <input type="text" name="w2ot"  value="<?php echo $this->item->w2ot ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
    </div>
    <div class="span3"></div>
</div>
<?php endif; ?>

<?php if (($this->item->ot == "T") || ($this->type != 0)) : ?>
   <?php $checkout_o = ($this->item->overtime == 'T') ?  ' checked = "checked" ' : ' '; ?>
<div class="row top-buffer center">
    <div class="span3"></div>
    <div class="span6 input-append">
        <label for="overtime" class="btn btn-block">
            <input  type="checkbox" <?php echo $checkout_o; ?>  name="overtime" id="overtime"  value="T"/> 
            <span class="sp_b"><?php echo JText::_('COM_HOCKEY_RESULT_OVERTIME'); ?></span>
        </label>
    </div>
     <div class="span3"></div>
</div>
<?php endif; ?>

<?php if (($this->item->shut == "T") || ($this->type != 0)) : ?>
<div class="row top-buffer center" id="shutouts-box">
    <div class="span3">
        <?php echo JText::_('COM_HOCKEY_RESULT_SO'); ?>
    </div>
    <div class="span6">
        <input type="text" name="w1so" value="<?php echo $this->item->w1so ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
        <span>:</span>
        <input type="text" name="w2so" value="<?php echo $this->item->w2so ?>" size="2" maxlength="2" class="validate-numeric input-mini" />
    </div>
    <div class="span3"></div>
</div>
<?php endif; ?>

<?php if (($this->item->shut == "T") || ($this->type != 0)) : ?>
<?php $checkout_s = ($this->item->shutouts == 'T') ?  ' checked = "checked" ' : ' '; ?>
<div class="row top-buffer center">
    <div class="span3"></div>
    <div class="span6 input-append">
        <label for="shutouts" class="btn btn-block">
            <input  type="checkbox" <?php echo $checkout_s; ?> name="shutouts" id="shutouts" value="T" /> 
            <span class="sp_b"><?php echo JText::_('COM_HOCKEY_RESULT_SHOOTOUTS'); ?></span>
        </label>
    </div>
    <div class="span3"></div>
</div>
<?php endif; ?>
</div>
<input type="hidden" name="uscore" value="<?php echo $this->item->uscore; ?>" />
</form>