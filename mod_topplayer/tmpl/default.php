<?php
/**
 * @version     1.0.0
 * @package     mod_topplayer
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
?>
<script type="text/javascript">
//<![CDATA[
 js = jQuery.noConflict();
    js(document).ready(function() {
   
    js(function() {
        js("#TopTabs").tab();
        js("#TopTabs").bind("show", function(e) {
            var contentID = js(e.target).attr("data-target");
            var contentURL = js(e.target).attr("href");
            if (typeof(contentURL) != 'undefined')
                js(contentID).load(contentURL , function() {
                    js("#TopTabs").tab();
                });
            else
                js(contentID).tab('show');
        });
        js('#TopTabs a:first').tab("show");
    });
  });
//]]>
</script>
<div id="topplayers">
    <ul id="TopTabs" class="nav nav-tabs">
        <li><a data-target="#topp1" data-toggle="tab" 
               href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=modtop&id=1&sez=<?php echo $sez ?>&type=<?php echo $type ?>&idteam=<?php echo $idteam ?>&<?php echo JSession::getFormToken(); ?>=1&format=raw">
                <span><?php echo $title1; ?> </span>
            </a>
        </li>
        <li><a data-target="#topp2" data-toggle="tab"
               href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=modtop&id=2&sez=<?php echo $sez ?>&type=<?php echo $type ?>&idteam=<?php echo $idteam ?>&<?php echo JSession::getFormToken(); ?>=1&format=raw">
                <span><?php echo $title2; ?> </span>
            </a>
        </li>
        <li><a data-target="#topp3" data-toggle="tab" 
               href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=modtop&id=3&sez=<?php echo $sez ?>&type=<?php echo $type ?>&idteam=<?php echo $idteam ?>&<?php echo JSession::getFormToken(); ?>=1&format=raw">
                <span><?php echo $title3; ?> </span>
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" id="topp1">Loading...</div>
        <div class="tab-pane" id="topp2">Loading...</div>
        <div class="tab-pane" id="topp3">Loading...</div>
    </div>
</div>