<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$select_team_pen = array_merge(array('0' => JText::_('COM_HOCKEY_PENALTY_SELECT')), $this->select_team);
$select_players_pen = array('0' => JText::_('COM_HOCKEY_PENALTY_MUST_SELECT_TEAMS'));
$url_penalty = JURI::base() . 'index.php?option=com_hockey&task=ajax.setPenalty&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
$url_autocomplete = JURI::base() . 'index.php?option=com_hockey&task=ajax.getNote&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
    load_data_penalty();

    function load_data_penalty() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getTablePenalty&<?php echo JSession::getFormToken(); ?>=1&id=<?php echo $this->item->id; ?>&format=json',
        function(data) {
            js('#penalty-content-table > tbody:last').empty();
            js.each(data, function(index, item) {
                row = '<tr><td><a class="btn btn-mini btn-danger" href="#" onclick="js.remove_penalty(' + item.id + ');return false;"><i class="icon-minus" title="remove"></i></a></td><td class="center">'
                        + item.period + '</td><td>' + item.time + '</td><td>' + item.team + '</td><td>' + item.player + '</td><td>' + item.note + '</td>'
                        + '<td class="center">' + item.time_p + '</td></tr>';
                js('#penalty-content-table > tbody:last').append(row);
            });
        });
    }

    // select team ajax for other select
    js('#id_team_penalty').change(function() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getSelectPenalty&<?php echo JSession::getFormToken(); ?>=1&id=<?php echo $this->item->id; ?>&team_id=' + js('#id_team_penalty option:selected').val() + '&format=json',
        function(data) {
            var html = '';
            js.each(data, function(key, value) {
                html += "<option value='" + value.value + "'>" + value.text + " </option>";
            });
            js('#id_player_penalty').empty().append(html);
        });
    });

    // click remove item 
    js.remove_penalty = function(id) {
        js('#penalty-form').resetForm();
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.RemovePenalty&<?php echo JSession::getFormToken(); ?>=1&id=<?php echo $this->item->id; ?>&item_id=' + id + '&format=json',
        function(data) {
            load_data_penalty();
        });
    };

    // ajax submit form 
    var options = {beforeSubmit: validation, success: showResponse, url: '<?php echo $url_penalty; ?>', type: 'post', dataType: 'json'};
    js("#penalty-form").submit(function() {
        js(this).ajaxSubmit(options);
        return false;
    });
    //  validation form 
    function validation() {
        if (document.formvalidator.isValid(document.id('penalty-form')))
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
            js("#penalty-form").resetForm();
            load_data_penalty();
        } else {
            js.pop_up(data.message, false);
        }
    }
    // autocomplete fild note
    var a = js('#note').autocomplete({
        serviceUrl: '<?php echo  $url_autocomplete; ?>',
        deferRequestBy: 0, 
        minChars: 2
    });

});
</script>
<form action="index.php" method="post" id="penalty-form" class="form-validate">
<div class="well well-small">
    <?php echo $this->getToolbarPenalyty(); ?>	
</div>
<div class="well well-small"> 
<div class="row-fluid">
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_PERIOD'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', HockeyHelper::getPeriod(), 'period_penalty', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_TIME'); ?></div>
            <div class="controls">
                <input type="text" name="time" value="" aria-required="true" required="required"  maxlength="5" class="required validate-playtime" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_TEAM'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_team_pen, 'id_team_penalty', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
    </div>
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_PLAYER'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_players_pen, 'id_player_penalty', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_NOTE'); ?></div>
            <div class="controls">
                <input type="text" name="note" id="note" value="" aria-required="true" required="required" maxlength="50" class="required" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_PENALTY_TIMEP'); ?></div>
            <div class="controls">
                <input type="text" name="time_p" value="" aria-required="true" required="required"  maxlength="3" class="required validate-numeric" />&nbsp;min
            </div>
        </div>
    </div>
</div>
</div>
<div class="row-fluid">
<div class="span12">
<div class="control-group">
    <hr class="" />
</div>
<table class="table table-striped" id="penalty-content-table" >
    <thead>
        <tr>
            <th><?php echo JText::_('COM_HOCKEY_PENALTY_ACTION'); ?></th>
            <th class="center"><?php echo JText::_('COM_HOCKEY_PENALTY_PERIOD'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PENALTY_TIME'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PENALTY_TEAM'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PENALTY_PLAYER'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PENALTY_NOTE'); ?></th>
            <th class="center"><?php echo JText::_('COM_HOCKEY_PENALTY_TIMEP'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>
</div>
</div>
</form>