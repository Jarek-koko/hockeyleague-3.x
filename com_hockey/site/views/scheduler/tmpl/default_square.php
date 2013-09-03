<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
?>
<div class="row-fluid">
<div class="span12">
<div class="well">
<p><b><?php echo JText::_('COM_HOCKEY_SELECT_MATCHDAY') ?></b></p>
<table class="matchdays-pick">
    <tr>
       <?php  
        $matchdays =  $this->matchdays;
        $c = count($matchdays);
        $a = $c % 13;
        $b = ($a == 0) ? 0 : 13 - $a;
        $nr = $b + $c;
        $boulid = '';
        for ($i = 1; $i <= $nr; $i++) {
            $boulid .= '<td>';
            if (!empty($matchdays[$i - 1])) {
                $boulid .= '<a class="select-matchday btn btn-small" href="#">' . $matchdays[$i - 1] . '</a>';
            } else {
               // $boulid .= '--';
            }
            $boulid .= '</td>';
            if (($i % 13 == 0) && ($i != $nr))
                $boulid .= '</tr><tr>';
        }
        echo $boulid;
        ?>
    </tr>
</table>
</div>
</div>
</div>