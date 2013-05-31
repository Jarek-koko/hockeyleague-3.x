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
?>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
    if (task == 'sezon.cancel') {
        Joomla.submitform(task, document.getElementById('sezon-form'));
    }
    else {

        if (task != 'sezon.cancel' && document.formvalidator.isValid(document.id('sezon-form'))) {
            Joomla.submitform(task, document.getElementById('sezon-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&layout=edit&id=' . (int) $this->item->id); ?>" 
      method="post" name="adminForm" id="sezon-form" class="form-validate">
<div class="row-fluid">
    <div class="span10 form-horizontal">      
        <fieldset class="adminform well">
            <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_HOCKEY_EDIT_SEZON') ); ?>
             <div class="control-group">
                <div class="control-label"><?php echo JText::_('COM_HOCKEY_NOTE_SEZON'); ?></div>
                <div class="controls"><?php echo JText::_('COM_HOCKEY_UNIQUE_SEZON'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('year'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('year'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_w'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_w'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_r'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_r'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_p'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_p'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('overtime'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('overtime'); ?></div>
            </div>  
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_d_w'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_d_w'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_d_p'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_d_p'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('shutouts'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('shutouts'); ?></div>
            </div>

            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_k_w'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_k_w'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('p_k_p'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('p_k_p'); ?></div>
            </div>           
            <?php echo JHtml::_('bootstrap.endTab'); ?>

            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'publishing', JText::_('JGLOBAL_FIELDSET_PUBLISHING', true)); ?>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('created'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('created'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('modified_by'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('modified_by'); ?></div>
            </div>
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('modified'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('modified'); ?></div>
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
            <div class="control-group">
                <div class="control-label"><?php echo $this->form->getLabel('ordering'); ?></div>
                <div class="controls"><?php echo $this->form->getInput('ordering'); ?></div>
            </div>
        </fieldset>
         <input type="hidden" name="task" value="" />
         <?php echo JHtml::_('form.token'); ?>
    </div>
    <!-- End Sidebar -->
</div>
</form>