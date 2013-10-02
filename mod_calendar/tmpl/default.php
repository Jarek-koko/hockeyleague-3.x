<?php
/**
 * @version     1.0.0
 * @package     mod_calendar
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;

if ($show_tooltips == 1) :
?>
<script type="text/javascript">
//<![CDATA[
js = jQuery.noConflict();
js(document).ready(function() {
js("td.qhome").hover(function(e) {
    var str = ValidateDate(js('span', this).first().text());
    if (str) {
        js("body").append('<div id="qtooltip"><div><img src="<?php echo JURI::base(true); ?>/media/com_hockey/images/loading.gif" /></div></div>');
        var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=modcal&mdate=' + js('span', this).first().text() + '&id=<?php echo $idteam; ?>&<?php echo JSession::getFormToken(); ?>=1&sez=<?php echo $sez; ?>&format=raw';
        js.ajax({
            url: Url,
            dataType: 'html',
            cache: false,
            success: function(data) {
                js("#qtooltip").html(data);
            },
            error: function() {
                js("#qtooltip").html('<p>Data not found</p>');
            }
        });
        js("#qtooltip").css("top", (js(this).offset().top - 140) + "px").css("left", (js(this).offset().left - 350) + "px").fadeIn("fast");
    }
},function() { js("#qtooltip").remove(); });
});

function ValidateDate(dtValue) {
    var dtRegex = new RegExp(/\d{4}-((0\d)|(1[012]))-(([012]\d)|3[01])/);
    return dtRegex.test(dtValue);
}

function submitForm(month, year) {
    var f = document.formCal;
    if (f) {
        f.elements['month'].value = month;
        f.elements['year'].value = year;
        f.submit();
    }
}
//]]>
</script>
<?php endif ?>
<div class="calq">
<form action="<?php echo $uri->toString(); ?>" method="post" name="formCal">
<div id="qnav">
    <span class="prev"><?php echo $back; ?></span>
    <span class="actual"><b><?php echo JText::_($title) ?></b></span>
    <span class="next"><?php echo $next; ?></span>
</div>
<table>
<tr>
    <th scope="col"><?php echo JText::_('MOD_CAL_MONDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_TUESDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_WEDNESDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_THURSDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_FRIDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_SATURDAY'); ?></th>
    <th scope="col"><?php echo JText::_('MOD_CAL_SANDAY'); ?></th>
</tr>
<tr>
<?php
$show = null;

for ($counti = 0; $counti < $weekday; $counti++) {
    $show .= '<td class="empty">&nbsp;</td>';
}

for ($day = 1, $days_in_month = gmdate('t', $first_of_month); $day <= $days_in_month; $day++, $weekday++) {

    if ($weekday == 7) {
        $weekday = 0;
        $show .= "</tr>\n<tr>";
    }

    if (($day == $today) & ($today_month == $month) & ($today_year == $post_year)) {
        $idtoday = 'id="today"';
    } else {
        $idtoday = '';
    }

    if (isset($days[$day])) {
        $show .= '<td class="qhome" ' . $idtoday . '><span style="display:none">' . $days[$day][0] . '</span><span class="qtooltip">' . $day . '</span></td>';
    } else {
        $show .= '<td ' . $idtoday . '>' . $day . '</td>';
    }
}

for ($counti = $weekday; $counti < 7; $counti++) {
    $show .= '<td class="empty">&nbsp;</td>';
}
echo $show;
?>
</tr>
</table>
<div class="row-fluid">
    <div class="span2"><div class="squ">&nbsp;</div></div>
    <div class="span10"> - <?php echo JText::_('MOD_CAL_MATCH'); ?></div>
</div>
<input type="hidden" name="month" value="" />
<input type="hidden" name="year" value="" />
</form>
</div>