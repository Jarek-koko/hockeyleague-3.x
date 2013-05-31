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
    if (task == 'select.cancel') {
        Joomla.submitform(task, document.getElementById('select-form'));
    }
    else {
        if (task != 'select.cancel' && document.formvalidator.isValid(document.id('select-form'))) {
            Joomla.submitform(task, document.getElementById('select-form'));
        }
        else {
            alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
        }
    }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&view=select'); ?>" method="post" 
             name="adminForm" id="select-form" class="form-validate">
<?php if (!empty($this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
    <?php echo $this->sidebar; ?>
</div>
<?php endif; ?>
<div id="j-main-container" class="span10">
    <div class="row-fluid">
        <div class="span4 hidden-phone"> </div>
        <div class="span2 form-vertical">
            <fieldset class="adminform well">
               <div class="control-group">
                   <div class="control-label"><?php echo JText::_('COM_HOCKEY_FORM_LBL_SELECT_SEASON') ?></div>
                    <div class="controls"><?php echo $this->form; ?></div>
               </div>
                <input type="hidden" name="task" value="" />
                <?php echo JHtml::_('form.token'); ?>
            </fieldset>
        </div>
        <div class="span4 hidden-phone"> </div>
    </div>
</div>
</form>