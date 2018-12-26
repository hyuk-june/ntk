<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$frame_url.'/js/jquery.accordion_menu/css/jquery.accordion_menu.css" />');
add_javascript('<script type="text/javascript" src="'.$frame_url.'/js/jquery.accordion_menu/jquery.accordion_menu.js"></script>');
?>


<div id="slide_mask"></div>

<div id="slide_menu" class="slide-wrap">

    <?php btb\show_widgets(__FILE__, "", "slide_1");?>

    <h4>Menu</h4>
    <div id="accmenu">
        <ul>
            <?php echo btb\get_menu_tag($menulist, $bt['curmenu']['bm_idx']);?>
        </ul>
    </div>
    
    <?php btb\show_widgets(__FILE__, "", "slide_2");?>
</div>

<script type="text/javascript">
<!--
$(function(){
   $('#accmenu').accordionMenu();
});
//-->
</script>