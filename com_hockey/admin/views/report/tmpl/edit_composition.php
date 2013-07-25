<?php
/**
 * @version     1.0.0
 * @package     com_hockey
 * @copyright   Copyright (C) 2013. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Klich Jarosław
 */
defined('_JEXEC') or die;
$countP = count($this->rows);
$url_player = JURI::base().'index.php?option=com_hockey&task=ajax.setComposition&' . JSession::getFormToken() . '=1&id=' . $this->item->id . '&format=json';
?>
<script type="text/javascript">
js = jQuery.noConflict();
js(document).ready(function() {
    // config jQuery Form Plugin 
    var options = {success: showResponse, url: '<?php echo $url_player; ?>', type: 'post', dataType: 'json'};

    js("#play-form").submit(function(e) {
        js(this).ajaxSubmit(options);
        return false;
    });
    // show Response for saving 
    function showResponse(data) {
       if (data.status === "1" ) {
            js.pop_up(data.message, true);
        } else {
            js.pop_up(data.message, false);
        }
    }

    js('#play-form input[type="checkbox"]').change(function() {
        ob = js(this).parent("label:first");
        if (js(this).is(':checked')) {
            ob.addClass('btn-info');
            js(this).prev().removeClass('icon-remove').addClass('icon-plus');
        } else {
            ob.removeClass('btn-info');
            js(this).prev().removeClass('icon-plus').addClass('icon-remove');
        }
    });
});
</script>
<form action="index.php" method="post" id="play-form">
<div class="well well-small">
    <?php echo $this->getToolbarComposition(); ?>	
</div>
<div class="row-fluid center"><?php echo JText::_('COM_HOCKEY_INFO_SELECT_PLAYERS'); ?></div>
<div class="row-fluid" id="composition">
    <div class="span4">
        <div class="center">
            <h4><?php echo $this->item->team1; ?></h4>
        </div>
        <div class="cthem">
            <div>
            <?php for ($i = 0; $i < $countP; $i++) : ?>
                <?php if ($this->rows[$i]['team_id'] == $this->item->team_1) : ?>
                    <?php
                    if ($this->rows[$i]['id_player'] == null) {
                        $check = '';
                        $icon = 'icon-remove';
                        $styleCheck = '';
                    } else {
                        $check = ' checked = "checked" ';
                        $icon = 'icon-plus';
                        $styleCheck = 'btn-info';
                    }
                    ?>
                    <label class="btn btn-block <?php echo $styleCheck; ?>">
                        <i class="<?php echo $icon; ?> icon-white"></i>
                        <input type="checkbox" name="players1[]" <?php echo $check; ?>  value="<?php echo $this->rows[$i]['id']; ?>" />  
                        <span class="sp_b"><?php echo $this->rows[$i]['name'] . ' ' . $this->rows[$i]['first_name']; ?></span>
                    </label>
                <?php endif; ?>
            <?php endfor; ?>
            </div>
        </div>
    </div>
    <div class="span4"></div>
    <div class="span4">
        <div class="center">
            <h4><?php echo $this->item->team2; ?></h4>
        </div>
        <div class="cthem">       
            <div>
            <?php for ($i = 0; $i < $countP; $i++) : ?>
                <?php if ($this->rows[$i]['team_id'] == $this->item->team_2) : ?>
                    <?php
                    if ($this->rows[$i]['id_player'] == null) {
                        $check = '';
                        $icon = 'icon-remove';
                        $styleCheck = '';
                    } else {
                        $check = ' checked = "checked" ';
                        $icon = 'icon-plus';
                        $styleCheck = 'btn-info';
                    }
                    ?>
                    <label class="btn btn-block <?php echo $styleCheck; ?>">
                        <i class="<?php echo $icon; ?> icon-white"></i>
                        <input type="checkbox" name="players2[]" <?php echo $check; ?>  value="<?php echo $this->rows[$i]['id']; ?>" />  
                        <span class="sp_b"><?php echo $this->rows[$i]['name'] . ' ' . $this->rows[$i]['first_name']; ?></span>
                    </label>
                <?php endif; ?>
            <?php endfor; ?>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="team_1" value="<?php echo $this->item->team_1; ?>" />
<input type="hidden" name="team_2" value="<?php echo $this->item->team_2; ?>" />
</form>