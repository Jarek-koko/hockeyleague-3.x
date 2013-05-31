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
    if (task == 'player.cancel') {
        Joomla.submitform(task, document.getElementById('player-form'));
    }
    else {
        if (task != 'player.cancel' && document.formvalidator.isValid(document.id('player-form'))) {
            Joomla.submitform(task, document.getElementById('player-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&layout=edit&id=' . (int) $this->item->id); ?>" method="post" 
      enctype="multipart/form-data" name="adminForm" id="player-form" class="form-validate">
    <div class="row-fluid">
        <div class="span10 form-horizontal">
            <fieldset class="adminform well">
                <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_HOCKEY_FIELDSET_PLAYER_DET')); ?>

                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('first_name'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('first_name'); ?></div>
                </div>
                <div class="control-group">
					<div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
					<div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
				</div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('number'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('number'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('position'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('position'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('date_of_birth'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('date_of_birth'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('height'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('height'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('weight'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('weight'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('team_id'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('team_id'); ?></div>
                </div>

                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('team_old'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('team_old'); ?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this->form->getLabel('photo'); ?></div>
                    <div class="controls"><?php echo $this->form->getInput('photo'); ?></div>
                </div>
                <?php echo JHtml::_('bootstrap.endTab'); ?>

                <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'personal', JText::_('COM_HOCKEY_FIELDSET_PLAYER_DESC', true)); ?>
                <div class="control-group">
                    <?php echo $this->form->getLabel('description'); ?>
                </div>
                <div class="control-group">
                   <?php echo $this->form->getInput('description'); ?>
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
             <?php echo JHtml::_('form.token'); ?>
        </div>
        <!-- End Sidebar -->

    </div>
</form>