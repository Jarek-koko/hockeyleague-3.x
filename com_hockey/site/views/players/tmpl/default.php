<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
//calculate years of age (input string: YYYY-MM-DD)
function birthday($dage) {
    list($Y, $m, $d) = explode("-", $dage);
    return( date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y );
}
?>
<script type="text/javascript">
//<![CDATA[
js = jQuery.noConflict();
js(document).ready(function() {
    js("#tableplayers, #tableplayers1, #tableplayers2").tablesorter({sortList:[[0,0]], headers:{1:{sorter: false}, 2:{sorter: false} ,3:{sorter: false}}, widgets: ['zebra']});
});
//]]>
</script>
<div class="component-title"><?php echo JText::_('COM_HOCKEY_PLAYERS_TITLE'); ?> - <?php echo $this->team_name; ?></div>
<?php if ($this->players):
   $rows = $this->players;
   $tmp_pos = null;
   foreach ($rows as $key => $row):
   $pos = $key;
   if ($tmp_pos != $row->position): ?>
   <div class="headtab">
       <div>:: <?php echo HockeyHelper::getPositionString($row->position); ?> ::</div>
   </div>
   <table class="tableplayers" id="tableplayers<?php echo $tmp_pos; ?>">
       <thead>
        <tr>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_NR'); ?></th>
            <th> &nbsp;#&nbsp;</th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_NAME'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_DATE'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_HEIGHT'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_WEIGHT'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_AGE'); ?></th>
            <th><?php echo JText::_('COM_HOCKEY_PLAYER_OLD_TEAM'); ?></th>
        </tr>
       </thead>
       <tbody>
       <?php endif; ?>
       <tr>
           <td><?php echo ++$pos; ?></td>
           <td><?php echo $nb = ($row->number) ? $row->number : '-'; ?></td>
           <td class="al">
            <a href="<?php echo JRoute::_('index.php?option=com_hockey&view=player&id='.$row->id); ?>" class="tool_tip"  rel="<?php echo JURI::base(true).'/'.$row->photo; ?>">
              <span><?php echo $row->first_name . ' ' . $row->name ?></span>
            </a>
           </td>
           <td><?php echo ($row->date_of_birth === "0000-00-00") ? ' ' : JHTML::_('date', $row->date_of_birth, JText::_('DATE_FORMAT_LC4')); ?></td>
           <td><?php echo $row->height ?></td>
           <td><?php echo $row->weight ?></td>
           <td><?php echo ($row->date_of_birth === "0000-00-00") ? ' ' : birthday($row->date_of_birth) ?></td>
           <td><?php echo $row->team_old ?></td>
       </tr>
       <?php
      if (isset($rows[$key + 1])) {
           if (($rows[$key + 1]->position != $row->position)) {
               echo '</tbody></table>';
           }
       } else {
           echo '</tbody></table>';
       }
       $tmp_pos = $row->position;
   endforeach;
 else:
  echo "<p><b>" . JText::_('COM_HOCKEY_NO_DATA') . "</b></p>";
 endif;

