<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$id_kol = null;
$rows = $this->items;
?>
<div class="bb">
<div class="row-fluid">
<div class="span12">
<?php foreach ($rows as $key => $row) : ?>
    <div id="idmatchday_<?php echo $row->id_kolejka; ?>" >
    <?php if ($id_kol != $row->id_kolejka ): ?> 
        <div class="headtab">
            <div>:: <?php echo JText::_('COM_HOCKEY_MATCHDAY'); ?> - <?php echo $row->id_kolejka;  ?> ::</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th><?php echo JText::_('COM_HOCKEY_DATE'); ?></th>
                    <th><?php echo JText::_('COM_HOCKEY_HOME'); ?></th>
                    <th>&nbsp;</th>
                    <th><?php echo JText::_('COM_HOCKEY_VISITORS'); ?></th>
                    <th>- - -</th>
                    <th>- - -</th>
                </tr>
            </thead>
            <tbody>
     <?php endif; ?>
    <tr>
        <td>
          <?php echo JHTML::_('date', $row->data, JText::_('DATE_FORMAT_LC4')); ?>
          <?php if ( $this->opt->params->get('show_time')) echo '&nbsp;&nbsp;&nbsp;'.$row->time;  ?>
        </td>
        <td><?php echo $row->team1; ?></td>
        <td>
            <?php
            echo ($row->score_1 != null ? $row->score_1 : '-');
            echo ' : ';
            echo ($row->score_2 != null ? $row->score_2 : '-');
            echo '<span class="smp">(';
            echo ($row->w1p1 != null ? $row->w1p1 : '-') . ':' . ($row->w2p1 != null ? $row->w2p1 : '-') . ', '
            . ($row->w1p2 != null ? $row->w1p2 : '-') . ':' . ($row->w2p2 != null ? $row->w2p2 : '-') . ', '
            . ($row->w1p3 != null ? $row->w1p3 : '-') . ':' . ($row->w2p3 != null ? $row->w2p3 : '-');
            echo ')</span>';
            ?>
        </td>
        <td><?php echo $row->team2; ?></td>
        <td>
            <?php
            if ($row->shutouts == "T")
                echo JText::_('COM_HOCKEY_PENALTY_SHORT');
            elseif ($row->overtime == "T")
                echo JText::_('COM_HOCKEY_OVERTIME_SHORT');
            else
                echo '---';
            ?>
        </td>
        <td>
            <?php
            $idlink =  $this->opt->params->get('idteamlink');
            if (($row->score_1 != null) && ($row->score_2 != null) && (($idlink == 0 ) || ($idlink == $row->team_1 ) || ($idlink == $row->team_2 ))) {
                echo '<a class="btn btn-small btn-info" href="' . JRoute::_('index.php?option=com_hockey&view=report&id=' . $row->id) . '">'. JText::_('COM_HOCKEY_SHOW') . '</a>';
            }
            ?>
        </td>
    </tr>
    <?php 
        if (isset($rows[$key + 1])) {
            if (($rows[$key + 1]->id_kolejka != $row->id_kolejka)) {
                echo '</tbody></table>';
            }
        } else {
            echo '</tbody></table>';
        }
        $id_kol = $row->id_kolejka;
     ?>
  </div>
<?php endforeach; ?>
</div>
</div>
</div>
<div>
    <span><?php echo JText::_('COM_HOCKEY_PENALTY_SHORT'); ?> -  <?php echo JText::_('COM_HOCKEY_PENALTY'); ?> </span>
    &nbsp;
    <span><?php echo JText::_('COM_HOCKEY_OVERTIME_SHORT'); ?> -  <?php echo JText::_('COM_HOCKEY_OVERTIME'); ?> </span>
</div>