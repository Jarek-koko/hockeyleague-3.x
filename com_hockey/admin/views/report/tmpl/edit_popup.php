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
js = jQuery.noConflict();
js(document).ready(function() {
js.pop_up = function (msg, status) {
        js('#system-message-container').html('');
        var alertclass = ((status) ? "alert-success" : "alert-error");
        js('#ajax-message').html('<h3>' + msg + '</h3>');
        js('#ajax-info').addClass(alertclass);
        js('#ajax-info').show().delay(1500).fadeOut(function() {
            js('#ajax-info').removeClass(alertclass);
            js('#ajax-message').html('');
        });
    };
});

// function for closing message alert 
js('#x').live('click', function() {
    js(this).parent().hide();
});
</script>
<div class= "alert fade in" id="ajax-info" style="display:none">
    <a class="close" id="x" href="#">&times;</a>
    <span id="ajax-message"></span>
</div>