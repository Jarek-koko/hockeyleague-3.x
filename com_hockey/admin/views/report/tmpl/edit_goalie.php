<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$select_team_goalie = array_merge( array('0' => JText::_('COM_HOCKEY_GOALIE_SELECT')) , $this->select_team);
$select_players_goalie = array('0' => JText::_('COM_HOCKEY_GOALIE_MUST_SELECT_TEAMS'));
$url_goalie = JURI::base().'index.php?option=com_hockey&task=ajax.setGoalie&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
     load_data();
    // load data from  ajax json and create table
    function load_data() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getTableGoalie&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&format=json', 
        function(data) {
            js('#content-table > tbody:last').empty();
            js.each( data, function( index, item){
                    row='<tr><td><a class="btn btn-mini btn-danger" href="#" onclick="js.remove_item('+item.id+');return false;"><i class="icon-minus" title="remove"></i></a></td><td>'
                         + item.name+'</td><td>'+item.player+'</td><td class="center">'+item.save+'</td><td class="center">'+item.goals+'</td><td class="center">'+item.time_p+'</td></tr>';  
                    js('#content-table > tbody:last').append(row);
            });
      });
    }
    // select team ajax for second select
    js('#id_team').change(function() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getSelectGoalie&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&team_id='+ js('#id_team option:selected').val() +'&format=json',  
            function(data) {
                var html = '';
                js.each(data,function( key, value) {
                    html += "<option value='"+ value.value +"'>"+ value.text +" </option>" ;
                });
                js('#id_player').empty().append(html);
            });
    });
    // click remove item 
     js.remove_item = function(id){
         js('#goalie-form').resetForm();
          js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.RemoveGoalie&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&item_id='+ id +'&format=json',  
            function(data) {
               load_data();
            });
     };
     
     //  ajax submit form 
    var options = {beforeSubmit:validation, success:showResponse, url:'<?php echo $url_goalie; ?>', type:'post', dataType:'json'};
    js("#goalie-form").submit(function() {
        js(this).ajaxSubmit(options);
        return false;
    });
    //  validation form 
    function validation() {
        if (document.formvalidator.isValid(document.id('goalie-form')))
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
            js("#goalie-form").resetForm();
            load_data();
        } else {
            js.pop_up(data.message, false);
        }
    }
  });
</script>
<form action="index.php" method="post" id="goalie-form" class="form-validate">
<div class="well well-small">
    <?php echo $this->getToolbarGoalie(); ?>	
</div>
<div class="well well-small"> 
<div class="row-fluid">
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALIE_TEAM'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_team_goalie, 'id_team', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALIE_PLAYER'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_players_goalie, 'id_player', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALIE_SAVE'); ?></div>
            <div class="controls">
                <input type="text" name="save" value="" aria-required="true" required="required"  maxlength="3" class="required validate-numeric" />
            </div>
        </div>
    </div>
     <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALIE_GOALSALLOWED'); ?></div>
            <div class="controls">
                <input type="text" name="goals" value="" aria-required="true" required="required"  maxlength="3" class="required validate-numeric" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALIE_TIMEP'); ?></div>
            <div class="controls">
                <input type="text" name="time_p" value="" aria-required="true" required="required" maxlength="3" class="required validate-numeric" />&nbsp;min
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
<table class="table table-striped" id="content-table" >
<thead>
    <tr>
        <th><?php echo JText::_('COM_HOCKEY_GOALIE_ACTION'); ?></th>
        <th><?php echo JText::_('COM_HOCKEY_GOALIE_TEAM'); ?></th>
        <th><?php echo JText::_('COM_HOCKEY_GOALIE_PLAYER'); ?></th>
        <th class="center"><?php echo JText::_('COM_HOCKEY_GOALIE_SAVE'); ?></th>
        <th class="center"><?php echo JText::_('COM_HOCKEY_GOALIE_GOALSALLOWED'); ?></th>
        <th class="center"><?php echo JText::_('COM_HOCKEY_GOALIE_TIMEP'); ?></th>
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
    </tr>
</tbody>
</table>
</div>
</div>
</form>