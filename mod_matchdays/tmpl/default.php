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
<script type="text/javascript">
//<![CDATA[
js =jQuery.noConflict();
js(document).ready(function() {
    var numMatchday = '<?php echo $id; ?>';
    var numSeason = '<?php echo $sez; ?>';
    var numSname = '<?php echo $sname; ?>';
    var title  = '<?php echo $title; ?>';
    var stat = 0;

    getData(numMatchday,numSeason,numSname,stat);
    js("#dayNav span.actual b").text( title + ' - ' + numMatchday);
    js("#dayNav span:first").click(function () { numMatchday--; stat = 1;getData(numMatchday,numSeason,numSname,stat); });
    js("#dayNav span:last").click(function () {  numMatchday++; stat = 2;getData(numMatchday,numSeason,numSname,stat); });
    
   
    function getData(id,se,st,stats) {
        var Url = '<?php echo JURI::base(); ?>' + 'index.php?option=com_hockey&view=modmatch&id='+ id +'&sez='+ se +'&st='+ st +'&format=raw';
        js.ajax({
            url: Url,
            dataType: 'html',
            cache: false,
            beforeSend: function() {
               js('#modmatch').fadeOut();
            },
            success: function (data) { 
                js("#modmatch").html(data).fadeIn();
                js("#dayNav span.actual b").text( title + ' - ' + numMatchday);
            },
            error : function () {
                if (stats == 1){ numMatchday ++; js("#modmatch").fadeIn();}
                if (stats == 2){ numMatchday --; js("#modmatch").fadeIn();}
                if (stats == 0){ js("#modmatch").html('<p>Data not found</p>').fadeIn();}
            }
        });
    }
});
//]]>
</script>
<div id="matchdayNav">
<div id="dayNav">
    <span class="prev"><a href="#prev" class="btn btn-mini"><i class="icon-undo"></i></a></span>
    <span class="actual"><b><?php echo $title; ?></b></span>
    <span class="next"><a href="#next" class="btn btn-mini"><i class="icon-redo"></i></a></span>
</div>
</div>
<div id="modmatch">
</div>



