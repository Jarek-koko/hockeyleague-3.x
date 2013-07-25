<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/jquery.timePicker.js");
?>
<script type="text/javascript">
 js = jQuery.noConflict();
    js(document).ready(function() {
        js("#jform_time").timePicker({
            startTime: "07:00",
            endTime: "23:45", // Using Date object here.
            show24Hours: true,
            separator: ':',
            step: 15
        });
 });
    
Joomla.submitbutton = function(task)
{
    if (task == 'league.cancel') {
        Joomla.submitform(task, document.getElementById('league-form'));
    }
    else {

        if (task != 'league.cancel' && document.formvalidator.isValid(document.id('league-form'))) {
            Joomla.submitform(task, document.getElementById('league-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&layout=edit&id=' . (int) $this->item->id); ?>" method="post" 
      name="adminForm" id="league-form" class="form-validate">
<div class="row-fluid">
<div class="span10 form-horizontal">
    <fieldset class="adminform well">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_HOCKEY_FIELDSET_MATCH_DET')); ?>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('team_1'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('team_1'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('team_2'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('team_2'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('id_kolejka'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('id_kolejka'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('data'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('data'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('time'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('time'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('place'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('place'); ?></div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>    
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
        </div>
         <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('created'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </fieldset>
</div>
<!-- End content -->
<!-- Begin Sidebar -->
<div class="span2">
    <h4><?php echo JText::_('JDETAILS'); ?></h4>
    <hr />
    <fieldset class="form-vertical">
    <div class="control-group">
        <div class="control-label"><?php echo $this->form->getLabel('state'); ?></div>
        <div class="controls"><?php echo $this->form->getInput('state'); ?></div>
    </div>
    </fieldset>
     <input type="hidden" name="task" value="" />
     <?php echo $this->form->getInput('id_system',null , HockeyHelper::getSezon()); ?>
     <?php echo $this->form->getInput('type_of_match',null , 0); ?>
     <?php echo JHtml::_('form.token'); ?>
</div>
    <!-- End Sidebar --> 
    <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
    <input type="hidden" name="jform[score_1]" value="<?php echo $this->item->score_1; ?>" />
    <input type="hidden" name="jform[score_2]" value="<?php echo $this->item->score_2; ?>" />
    <input type="hidden" name="jform[overtime]" value="<?php echo $this->item->overtime; ?>" />
    <input type="hidden" name="jform[shutouts]" value="<?php echo $this->item->shutouts; ?>" />
    <input type="hidden" name="jform[w1p1]" value="<?php echo $this->item->w1p1; ?>" />
    <input type="hidden" name="jform[w2p1]" value="<?php echo $this->item->w2p1; ?>" />
    <input type="hidden" name="jform[w1p2]" value="<?php echo $this->item->w1p2; ?>" />
    <input type="hidden" name="jform[w2p2]" value="<?php echo $this->item->w2p2; ?>" />
    <input type="hidden" name="jform[w1p3]" value="<?php echo $this->item->w1p3; ?>" />
    <input type="hidden" name="jform[w2p3]" value="<?php echo $this->item->w2p3; ?>" />
    <input type="hidden" name="jform[w1ot]" value="<?php echo $this->item->w1ot; ?>" />
    <input type="hidden" name="jform[w2ot]" value="<?php echo $this->item->w2ot; ?>" />
    <input type="hidden" name="jform[w1so]" value="<?php echo $this->item->w1so; ?>" />
    <input type="hidden" name="jform[w2so]" value="<?php echo $this->item->w2so; ?>" />
    <input type="hidden" name="jform[uscore]" value="<?php echo $this->item->uscore; ?>" />
    <input type="hidden" name="jform[id_referee1]" value="<?php echo $this->item->id_referee1; ?>" />
    <input type="hidden" name="jform[id_referee2]" value="<?php echo $this->item->id_referee2; ?>" />
    <input type="hidden" name="jform[id_referee3]" value="<?php echo $this->item->id_referee3; ?>" />
    <input type="hidden" name="jform[id_referee4]" value="<?php echo $this->item->id_referee4; ?>" />
    <input type="hidden" name="jform[description]" value="<?php echo $this->item->description; ?>" />
    </div>
</form>