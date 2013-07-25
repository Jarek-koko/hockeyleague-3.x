<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$select_team_goals = array_merge( array('0' => JText::_('COM_HOCKEY_GOALS_SELECT')) , $this->select_team);
$select_players_goals = array('0' => JText::_('COM_HOCKEY_GOALS_MUST_SELECT_TEAMS'));
$url_goals = JURI::base().'index.php?option=com_hockey&task=ajax.setGoals&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
    load_data_gol();
    
    function load_data_gol() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getTableGoals&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&format=json', 
        function(data) {
            js('#goals-content-table > tbody:last').empty();
            js.each( data, function( index, item){
                row='<tr><td><a class="btn btn-mini btn-danger" href="#" onclick="js.remove_goals('+item.id+');return false;"><i class="icon-minus" title="remove"></i></a></td><td>'
                     +item.info+'</td><td class="center">'+item.period+'</td><td class="center">'+item.time+'</td><td class="center">'+item.score+'</td><td>'+item.shooter+'</td>'
                     +'<td>'+item.assist1+'</td><td>'+item.assist2+'</td></tr>';  
                js('#goals-content-table > tbody:last').append(row);
            });
      });
    }
  // select team ajax for other select
    js('#id_team_goals').change(function() {
        js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.getSelectGoals&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&team_id='+ js('#id_team_goals option:selected').val() +'&format=json',  
            function(data) {
                var html = '';
                js.each(data,function( key, value) {
                    html += "<option value='"+ value.value +"'>"+ value.text +" </option>" ;
                });
                js('#shooter').empty().append(html);
                js('#assist1').empty().append(html);
                js('#assist2').empty().append(html);
                js('#assist1').prepend('<option value="0" selected="selected">---</option>');
                js('#assist2').prepend('<option value="0" selected="selected">---</option>');
            });
    });
     // click remove item 
     js.remove_goals = function(id){
        js('#goals-form').resetForm();
         js.getJSON('<?php echo JURI::base(); ?>index.php?option=com_hockey&task=ajax.RemoveGoals&<?php echo JSession::getFormToken();?>=1&id=<?php echo $this->item->id ;?>&item_id='+ id +'&format=json',  
           function(data) {
              load_data_gol();
           });
     };
     //  ajax submit form 
    var options = {beforeSubmit:validation, success:showResponse, url:'<?php echo $url_goals; ?>', type:'post', dataType:'json'};
    js("#goals-form").submit(function() {
        js(this).ajaxSubmit(options);
        return false;
    });
    // validation form 
    function validation() {
        if (document.formvalidator.isValid(document.id('goals-form')))
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
            js("#goals-form").resetForm();
            load_data_gol();
        } else {
            js.pop_up(data.message, false);
        }
    }
  });
</script>
<form action="index.php" method="post" id="goals-form" class="form-validate">
<div class="well well-small">
    <?php echo $this->getToolbarGoals(); ?>	
</div>
<div class="well well-small">
<div class="row-fluid">
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_INFO'); ?></div>
            <div class="controls">
                <input type="text" name="info" value=""  maxlength="3" />
            </div>
        </div>
         <div class="control-group">
            <div class="control-label"><?php echo $this->item->team1 ?></div>
            <div class="controls">
                 <input type="text" name="score1" size="3" maxlength="3" class="required validate-numeric"/>
            </div>
        </div>
        
         <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_TIME'); ?></div>
            <div class="controls">
                <input type="text" name="time" value="" aria-required="true" required="required"  maxlength="5" class="required validate-playtime" />
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_TEAM'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_team_goals, 'id_team_goals', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
         <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_ASSIST1'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_players_goals , 'assist1', 'class="inputbox"', 'value', 'text'); ?>
            </div>
        </div>
         <div class="small"> <?php echo JText::_('COM_HOCKEY_GOALS_SHORT_INFO'); ?> </div>
    </div>
    <div class="span6 form-horizontal">
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_PERIOD'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', HockeyHelper::getPeriod(), 'period_goals', 'class="validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        
        <div class="control-group">
            <div class="control-label"><?php echo $this->item->team2 ?></div>
            <div class="controls">
                 <input type="text" name="score2" size="3" maxlength="3" class="required validate-numeric"/>
            </div>
        </div>
         <div class="control-group">
            <div class="control-label">&nbsp;</div>
            <div class="controls">  &nbsp; </div>
        </div>
          <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_SHOOTER'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_players_goals , 'shooter', 'class="inputbox validate-notzero required"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo JText::_('COM_HOCKEY_GOALS_ASSIST2'); ?></div>
            <div class="controls">
                <?php echo JHTML::_('select.genericList', $select_players_goals , 'assist2', 'class="inputbox"', 'value', 'text'); ?>
            </div>
        </div>
        <div class="small"> <?php echo JText::_('COM_HOCKEY_GOALS_SHORT_INFO2'); ?> </div>
    </div>
</div>
</div>

<div class="row-fluid">
<div class="span12">
 <div class="control-group">
    <hr class="" />
 </div>
<table class="table table-striped" id="goals-content-table" >
    <thead>
        <tr>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_ACTION'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_INFO'); ?></th>
            <th  class="center"><?php echo JText::_('COM_HOCKEY_GOALS_PERIOD'); ?></th>
            <th  class="center"><?php echo JText::_('COM_HOCKEY_GOALS_TIME'); ?></th>
            <th  class="center"><?php echo JText::_('COM_HOCKEY_GOALS_SCORE'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_SHOOTER'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_ASSIST1'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_GOALS_ASSIST2'); ?></th>
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
            <td></td>
        </tr>
    </tbody>
</table>
</div>
</div>
</form>