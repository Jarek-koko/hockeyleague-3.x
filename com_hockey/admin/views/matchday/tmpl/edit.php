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
JHtml::_('jquery.framework', true, true);
JHtml::_('behavior.keepalive');

$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/jquery.form.min.js");
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/zebra_datepicker.js");
$document->addScript(JURI::root(true) . "/administrator/components/com_hockey/assets/js/jquery.timePicker.js");
$select_team = array_merge(array('0' => JText::_('COM_HOCKEY_FORM_MATCHDAY_SELECT_TEAM')), $this->item);
$url = JURI::base() . 'index.php?option=com_hockey&task=ajax.setMatchday&' . JSession::getFormToken() . '=1&format=json';
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        // timePicer
        js("#time_e").timePicker({
            startTime: "07:00",
            endTime: "23:45", 
            show24Hours: true,
            separator: ':',
            step: 15
        });
        // insert timepicker
        js("#time_e").change(function() {
            js('.input_time').each(function() {
                js(this).val(js('#time_e').val());
            });
        });
        //datePicker and insert 
        js('#data_e').Zebra_DatePicker({
            offset: [5, 200],
            onSelect: function(value) {
                js('.input_data').each(function() {
                    js(this).val(value);
                });
            }
        });
        //matchday and insert
        js('#matchday_e').blur(function() {
            js('.input_id_kolejka').each(function() {
                js(this).val(js('#matchday_e').val());
            });
        });

        js('#remove-input').hide();
        // cloning rows input form
        js("#add-input").click(function() {
            var num = js('.clonedInput').length, // how many "duplicatable" input fields we currently have
            newNum = new Number(num + 1), // the numeric ID of the new input field being added
            newElem = js('#entry' + num).clone().attr('id', 'entry' + newNum);
            // matchday
            newElem.find('.label_id_kolejka').attr('for', 'id_kolejka' + newNum);
            newElem.find('.input_id_kolejka').attr('id', 'id_kolejka' + newNum).attr('name', 'id_kolejka' + newNum).val('');
            // date
            newElem.find('.label_data').attr('for', 'data' + newNum);
            newElem.find('.input_data').attr('id', 'data' + newNum).attr('name', 'data' + newNum);
            // time
            newElem.find('.label_time').attr('for', 'time' + newNum);
            newElem.find('.input_time').attr('id', 'time' + newNum).attr('name', 'time' + newNum).val('00:00');
            // place
            newElem.find('.label_place').attr('for', 'place' + newNum);
            newElem.find('.input_place').attr('id', 'place' + newNum).attr('name', 'place' + newNum).val('');
            // team_1
            newElem.find('.label_team_1').attr('for', 'team_1' + newNum);
            newElem.find('.input_team_1').attr('id', 'team_1' + newNum).attr('name', 'team_1' + newNum).val();
            // team_2
            newElem.find('.label_team_2').attr('for', 'team_2' + newNum);
            newElem.find('.input_team_2').attr('id', 'team_2' + newNum).attr('name', 'team_2' + newNum).val();
            js('#nr_match').val(newNum);
            js('#entry' + num).after(newElem);
            // max 15 row
            if (newNum == 15) {
                js('#add-input').hide();
            }
            if (newNum >= 2) {
                js('#remove-input').show();
            }
        });

        js('#remove-input').click(function() {
            var num = js('.clonedInput').length;
            js('#entry' + num).remove();
            if (num - 1 === 1)
                js('#remove-input').hide();
            // enable the "add" button
            js('#add-input:hidden').show();
            js('#nr_match').val(num - 1);
        });

        // ajax submit form ==== //
        var options = {target: null, beforeSubmit: validation, success: showResponse, url: '<?php echo $url; ?>', type: 'post', dataType: 'json'};
       
        js("#matchday-form").submit(function() {
            js(this).ajaxSubmit(options);
            return false;
        });
     
        // validation form 
        function validation() {
            if (document.formvalidator.isValid(document.id('matchday-form'))) {
                return true;
            } else {
                js.pop_up('<?php echo JText::_('JGLOBAL_VALIDATION_FORM_FAILED'); ?>', false);
                return false;
            }
        }
      
        function showResponse(data) {
            if (data.status === "1" ) {
                js.pop_up(data.message, true);
                js('#matchday-form').resetForm();              
            } else {
                js.pop_up(data.message, false);
            }
        }
    });
    Joomla.submitbutton = function(task)
    {
        if (task == 'league.cancel') {
            Joomla.submitform(task, document.getElementById('admin-form'));
        }
    };
</script>
<?php echo $this->loadTemplate('popup'); ?>
<form action="index.php" method="post" id="matchday-form" class="form-validate form-inline span12">
<div class="well">   
    <div class="span6">
        <button class="btn btn-success btn-small" id="save-input" href="#"><i class="icon-apply icon-white"></i> <?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_SAVE'); ?></button>
        <a class="btn btn-primary btn-small" id="add-input" href="#"><i class="icon-plus"></i> <?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_ADD_MATCH'); ?></a>
        <a class="btn btn-danger btn-small" id="remove-input" href="#"><i class="icon-minus"></i> <?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_REMOVE_MATCH'); ?></a>
    </div>
    <div class="span2"><label for="matchday_e" ><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_MATCHDAY'); ?> </label> <input id="matchday_e" type="text" size="4" class="input-mini"></div>
    <div class="span2"><label for="data_e" ><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_DATE'); ?> </label> <input  id="data_e"  type="text" name="date_e" value="" class="datepicker input-small" /></div>
    <div class="span2"><label for="time_e" ><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_TIME'); ?> </label> <input id="time_e" type="text" size="6" autocomplete="OFF" class="input-mini"></div>
</div>
<div class="row-fluid">
    <div id="entry1" class="clonedInput">
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label for="id_kolejka1" class="required label_id_kolejka"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_MATCHDAY'); ?></label><br />
                    <input type="text" name="id_kolejka1" id="id_kolejka1" value="" class="input_id_kolejka validate-numeric input-mini" required="required" aria-required="true"/>   
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label  for="data1" class="label_data"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_DATE'); ?></label><br />
                    <input  id="data1" type="text"  name="data1" value="<?php echo date('Y-m-d'); ?>" class="input_data  input-small" />
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label for="time1" class="label_time"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_TIME'); ?></label><br />
                    <input type="text" name="time1" id="time1" value="00:00" class="input_time input-mini validate-timematch" size="6"/> 
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label  for="place1" class="label_place"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_PLACE'); ?></label><br />
                    <input type="text" name="place1" id="place1" value="" class="input_place span12" size="40"/>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label for="team_11" class="label_team_1"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_HOME'); ?></label><br />
                    <?php echo JHTML::_('select.genericList', $select_team, 'team_11', 'class="input_team_1 validate-notzero span12"', 'value', 'text'); ?>
                </div>
            </div>
        </div>
        <div class="span2">
            <div class="control-group">
                <div class="controls">
                    <label for="team_21" class="label_team_2"><?php echo JText::_('COM_HOCKEY_FORM_MATCHDAY_VISITORS'); ?></label><br />
                    <?php echo JHTML::_('select.genericList', $select_team, 'team_21', 'class="input_team_2 validate-notzero span12"', 'value', 'text'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="nr_match" id="nr_match" value="1" />
</form>
<form action="<?php echo JRoute::_('index.php?option=com_hockey&view=leagues'); ?>" method="post" id="admin-form">
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>