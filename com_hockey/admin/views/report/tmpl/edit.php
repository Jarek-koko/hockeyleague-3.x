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
JHtml::_('jquery.framework',  true, true);
JHtml::_('behavior.keepalive');
// Load our Javascript
$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/jquery.form.min.js");
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/jquery.autocomplete.js");
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
 //tooltip text for button update standings 
 js('#result-update').popover({trigger: "hover", html: true});
});
Joomla.submitbutton = function(task)
{
   if (task == 'report.cancel') {
       Joomla.submitform(task, document.getElementById('report-form'));
   }
   else {
       if (task == 'report.update' && document.formvalidator.isValid(document.id('result-form'))) {
           Joomla.submitform(task, document.getElementById('report-form'));
       }

       if (task != 'report.cancel' && document.formvalidator.isValid(document.id('report-form'))) {
           Joomla.submitform(task, document.getElementById('report-form'));
       }
       else {
           alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
       }
   }
};
</script>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&layout=edit&id=' . (int) $this->item->id); ?>" 
     method="post" name="adminForm" id="report-form" class="form-validate">
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="type" value="<?php echo $this->type; ?>" />
    <input type="hidden" name="match_id" value="<?php echo $this->item->id; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<div class="container-report">
<div class="span12">
    <?php echo $this->loadTemplate('popup'); ?>
    <div class="well well-small">
    <h3>[ <?php echo HockeyHelper::getNameSez(); ?> ] - [ <?php echo $this->type_title; ?> ] - [ <?php echo $this->item->team1 ?> vs <?php echo $this->item->team2; ?> ]</h3>
    </div>
    <div class="tabbable tabs-below">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#lA" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_RESULT'); ?></a></li>
            <li><a href="#lB" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_COMPOSITION'); ?></a></li>
            <li><a href="#lC" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_GOALS'); ?></a></li>
            <li><a href="#lD" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_PENALTY'); ?></a></li>
            <li><a href="#lE" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_GOALIE'); ?></a></li>
            <li><a href="#lF" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_REFEREES'); ?></a></li>
            <li><a href="#lG" data-toggle="tab"><?php echo JText::_('COM_HOCKEY_REPORT_TITLE_NAV_DESCRIPTION'); ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="lA"><?php echo $this->loadTemplate('result'); ?></div>
            <div class="tab-pane" id="lB"><?php echo $this->loadTemplate('composition'); ?></div>
            <div class="tab-pane" id="lC"><?php echo $this->loadTemplate('goals'); ?></div>
            <div class="tab-pane" id="lD"><?php echo $this->loadTemplate('penalty'); ?></div>
            <div class="tab-pane" id="lE"><?php echo $this->loadTemplate('goalie'); ?></div>
            <div class="tab-pane" id="lF"><?php echo $this->loadTemplate('referees'); ?></div>
            <div class="tab-pane" id="lG"><?php echo $this->loadTemplate('des'); ?></div>
        </div>
    </div>
</div>
</div>
