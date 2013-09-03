<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
// No direct access
defined('_JEXEC') or die;
if ($this->id_season != 0):
?>
<div class="component-title"><?php echo $this->title_head; ?></div>
<script type="text/javascript">
//<![CDATA[
    js = jQuery.noConflict();
    js(document).ready(function() {
    <?php if ($this->show_select): ?>
    js('#form-table').get(0).reset();
    <?php endif; ?>
    var sez = "<?php echo '&sez=' . $this->id_season; ?>";

    js(function() {
        js("#MainTabs").tab();
        js("#MainTabs").bind("show", function(e) {
            var contentID = js(e.target).attr("data-target");
            var contentURL = js(e.target).attr("href");
            if (typeof(contentURL) != 'undefined')
                js(contentID).load(contentURL + sez, function() {
                    js("#MainTabs").tab();
                });
            else
                js(contentID).tab('show');
        });
        js('#MainTabs a:first').tab("show");
    });

    js('#sezon_id').change(function() {
        vsez = js('#sezon_id option:selected').val();
        sez = "&sez=" + vsez;
        js('#rs, #po, #grs, #gpo').empty();
        url = js('#MainTabs a:first').attr("href");
        js('#rs').load(url + sez, function() {
            js("#MainTabs").tab();
            js('#MainTabs a:first').tab("show");
        });
    });
  });
//]]>
</script>
<?php if ($this->show_select): ?>
<div class="well">
    <form id="form-table" action="index.php" method="post" class="center">
        <?php echo $this->items; ?>      
    </form>
</div>
<?php endif; ?>
<div id="statsone-content">
<ul id="MainTabs" class="nav nav-tabs">
    <li><a data-target="#rs" data-toggle="tab" 
           href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=statsteam&id=1&<?php echo JSession::getFormToken(); ?>=1&id_team=<?php echo $this->id_team ?>&format=raw">
            <span><?php echo JText::_('COM_HOCKEY_STAT_PLAYERS_R'); ?> </span>
        </a>
    </li>
    <li><a data-target="#po" data-toggle="tab"
           href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=statsteam&id=2&<?php echo JSession::getFormToken(); ?>=1&id_team=<?php echo $this->id_team ?>&format=raw">
            <span><?php echo JText::_('COM_HOCKEY_STAT_PLAYERS_P'); ?> </span>
        </a>
    </li>
    <li><a data-target="#grs" data-toggle="tab" 
           href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=statsteam&id=3&<?php echo JSession::getFormToken(); ?>=1&id_team=<?php echo $this->id_team ?>&format=raw">
            <span><?php echo JText::_('COM_HOCKEY_STAT_GOALIES_R'); ?> </span>
        </a>
    </li>
    <li><a data-target="#gpo" data-toggle="tab" 
           href="<?php echo JURI::base(true); ?>/index.php?option=com_hockey&view=statsteam&id=4&<?php echo JSession::getFormToken(); ?>=1&id_team=<?php echo $this->id_team ?>&format=raw">
            <span><?php echo JText::_('COM_HOCKEY_STAT_GOALIES_P'); ?> </span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane" id="rs">Loading...</div>
    <div class="tab-pane" id="po">Loading...</div>
    <div class="tab-pane" id="grs">Loading...</div>
    <div class="tab-pane" id="gpo">Loading...</div>
</div>
</div>
<?php else: ?>
<div class="alert alert-error">
    <?php echo JText::_('COM_HOCKEY_NO_SEASON'); ?>
</div>
<?php endif; ?>
