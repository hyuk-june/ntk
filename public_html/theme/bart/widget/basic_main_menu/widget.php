<?php
/*
title:스마트메뉴
description:메인메뉴를 표시합니다
version:1.0.0
author:bartnet
single:true
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

global $menulist, $bt;

$menu_theme = 'sm-basic';

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/smartmenus/css/sm-core.css" />');
add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/smartmenus/css/'.$menu_theme.'.css" />');
add_javascript('<script style="text/javascript" src="'.$widget_url.'/smartmenus/jquery.smartmenus.js"></script>');

if(bt\varset($wcfg['type'])=='both'){
    $menucnt = count($menulist);
    if($wcfg['show_home']) $menucnt++;
    $width = (100 / $menucnt).'%';
}else{
    $width = 'auto';
}

$border_color = bt\add_string( bt\binstr($wcfg['border_color'], '#ddd'), '#');

$bgcolor = bt\add_string( bt\binstr($wcfg['bgcolor'], 'transparent'), '#');
$bgcolor_n = bt\add_string( bt\binstr($wcfg['bgcolor_n'], '#fff'), '#');
$color_n = bt\add_string( bt\binstr($wcfg['color_n'], '#333'), '#');
$bgcolor_o = bt\add_string( bt\binstr($wcfg['bgcolor_o'], '#414141'), '#');
$color_o = bt\add_string( bt\binstr($wcfg['color_o'], '#fff'), '#');
$bgcolor_c = bt\add_string( bt\binstr($wcfg['bgcolor_c'], '#333'), '#');
$color_c = bt\add_string( bt\binstr($wcfg['color_c'], '#fff'), '#');

$s_bgcolor = bt\add_string( bt\binstr($wcfg['s_bgcolor'], 'transparent'), '#');
$s_bgcolor_n = bt\add_string( bt\binstr($wcfg['s_bgcolor_n'], '#fff'), '#');
$s_color_n = bt\add_string( bt\binstr($wcfg['s_color_n'], '#333'), '#');
$s_bgcolor_o = bt\add_string( bt\binstr($wcfg['s_bgcolor_o'], '#414141'), '#');
$s_color_o = bt\add_string( bt\binstr($wcfg['s_color_o'], '#fff'), '#');
$s_bgcolor_c = bt\add_string( bt\binstr($wcfg['s_bgcolor_c'], '#333'), '#');
$s_color_c = bt\add_string( bt\binstr($wcfg['s_color_c'], '#fff'), '#');

ob_start();
?>

<style type="text/css">
/*#main_menu_container{border-top:1px solid <?php echo $border_color?>; border-bottom:1px solid <?php echo $border_color?>;}*/
#main_menu_container{background:<?php echo $bgcolor?>; border-top:1px solid <?php echo $border_color?>; border-bottom:1px solid <?php echo $border_color?>; }
#main_menu_container:after{content:'';display:block;clear:both;}
#main_menu >li{width:<?php echo $width?>; text-align:center;}

<?php if(bt\varset($wcfg['split'])!='1'){?>
#main_menu >li{border-width:0;}
<?php }else{?>
#main_menu >li{border-left:1px solid <?php echo $border_color?>;}
#main_menu >li:last-child{border-right:1px solid <?php echo $border_color?>;}
<?php }?>

/* 메인메뉴 */
#main_menu >li >a{background-color:<?php echo $bgcolor_n?>; color:<?php echo $color_n?>;}
#main_menu >li >a.current{background:<?php echo $bgcolor_c?>; color:<?php echo $color_c?>;}
#main_menu >li >a:hover,
#main-menu >li >a:active,
#main-menu >li >a:focus,
#main-menu >li >a.highlighted{background:<?php echo $bgcolor_o?>; color:<?php echo $color_o?>;}

#main_menu >li >a >.sub-arrow{border-top-color:<?php echo $color_n;?>;}
#main_menu >li >a.current >.sub-arrow{border-top-color:<?php echo $color_c?>;}
#main_menu >li >a:hover >.sub-arrow,
#main_menu >li >a:active >.sub-arrow,
#main_menu >li >a:focus >.sub-arrow,
#main_menu >li >a.highlighted >.sub-arrow{border-top-color:<?php echo $color_o?>;}



/* 서브 메뉴 */
#main_menu li ul a{background-color:<?php echo $s_bgcolor_n?>; color:<?php echo $s_color_n?>;}
#main_menu li ul a.current{background:<?php echo $s_bgcolor_c?>; color:<?php echo $s_color_c?>;}
#main_menu li ul a:hover, 
#main_menu li ul a:active, 
#main_menu li ul a:focus, 
#main_menu li ul a.highlighted {background-color:<?php echo $s_bgcolor_o?>; color:<?php echo $s_color_o?>;}
#main_menu li ul a .sub-arrow{border-left-color:<?php echo $s_color_n;?>;}

#main_menu li ul a .sub-arrow{border-left-color:<?php echo $s_color_n;?>;}
#main_menu li ul a.current .sub-arrow{border-left-color:<?php echo $s_color_c?>;}
#main_menu li ul a:hover .sub-arrow,
#main_menu li ul a:active .sub-arrow,
#main_menu li ul a:focus .sub-arrow,
#main_menu li ul a.highlighted .sub-arrow{border-left-color:<?php echo $s_color_o?>;}

<?php if($wcfg['hide_arrow']){?>
#main_menu li .sub-arrow{display:none;}
<?php }?>

</style>
    
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

<nav id="main_menu_container">
    <div class="container">
        <ul id="main_menu" class="sm <?php echo $menu_theme?>">
        <?php if(bt\varset($wcfg['show_home'])=='1'){?>
            <li><a href="<?php echo G5_URL?>"<?php echo !bt\isval($bt['curmenu']['bm_idx']) ? ' class="current"':'';?>><i class="fa fa-home"></i> HOME</a></li>
        <?php }?>
            <?php echo btb\get_menu_tag($menulist, $bt['curmenu']['bm_idx'], 'a', true);?>
        </ul>
    </div>
</nav>

<script type="text/javascript">
<!--
$(function() {
    $('#main_menu').smartmenus({
        subIndicators: true,
        subIndicatorsPos: 'append',
        subMenusMinWidth:'10em',
        /*subIndicatorsText: ' <span class="fa fa-sort-desc"></i>'*/
    });
});
//-->
</script>