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
    if (task == 'table.cancel') {
        Joomla.submitform(task, document.getElementById('table-form'));
    }
    else {

        if (task != 'table.cancel' && document.formvalidator.isValid(document.id('table-form'))) {
            Joomla.submitform(task, document.getElementById('table-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&layout=edit&id=' . (int) $this->item->id); ?>" method="post"
      name="adminForm" id="table-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform well">
                <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_HOCKEY_FIELDSET_TABLE_DET')); ?>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('team_id'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('team_id'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('matchday'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('matchday'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('points'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('points'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('won'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('won'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('ties'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('ties'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('lost'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('lost'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('goals_scored'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('goals_scored'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('goals_against'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('goals_against'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('difference'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('difference'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('group'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('group'); ?></div>
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
            </fieldset>
            <input type="hidden" name="task" value="" />
            <?php echo $this->form->getInput('id_system',null , HockeyHelper::getSezon()); ?>
            <?php echo JHtml::_('form.token'); ?>
        </div>
        <!-- End Sidebar -->
    </div>
</form>