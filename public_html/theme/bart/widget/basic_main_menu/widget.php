<?php
/*
title:스마트메뉴
description:메인메뉴를 표시합니다
version:1.0.1
author:NTK
single:false
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

$border_color = btb\colorformat($wcfg['border_color'], 'ddd');

$bgcolor = btb\colorformat($wcfg['bgcolor'], 'transparent');
$bgcolor_n = btb\colorformat($wcfg['bgcolor_n'], 'transparent');
$color_n = btb\colorformat($wcfg['color_n'], '333');
$bgcolor_o = btb\colorformat($wcfg['bgcolor_o'], '414141');
$color_o = btb\colorformat($wcfg['color_o'], 'fff');
$bgcolor_c = btb\colorformat($wcfg['bgcolor_c'], '333');
$color_c = btb\colorformat($wcfg['color_c'], 'fff');

$bold_n = $wcfg['bold_n']=='1' ? 'bold' : 'normal';
$bold_o = $wcfg['bold_o']=='1' ? 'bold' : 'normal';
$bold_c = $wcfg['bold_c']=='1' ? 'bold' : 'normal';

$s_bgcolor = btb\colorformat($wcfg['s_bgcolor'], 'transparent');
$s_bgcolor_n = btb\colorformat($wcfg['s_bgcolor_n'], 'fff');
$s_color_n = btb\colorformat($wcfg['s_color_n'], '333');
$s_bgcolor_o = btb\colorformat($wcfg['s_bgcolor_o'], '414141');
$s_color_o = btb\colorformat($wcfg['s_color_o'], 'fff');
$s_bgcolor_c = btb\colorformat($wcfg['s_bgcolor_c'], '333');
$s_color_c = btb\colorformat($wcfg['s_color_c'], 'fff');

$s_bold_n = $wcfg['s_bold_n']=='1' ? 'bold' : 'normal';
$s_bold_o = $wcfg['s_bold_o']=='1' ? 'bold' : 'normal';
$s_bold_c = $wcfg['s_bold_c']=='1' ? 'bold' : 'normal';


ob_start();

if(bt\varset($wcfg['vertical'])=='1') $vborder = 'border-top: 1px solid '.$border_color.'; border-bottom: 1px solid '.$border_color;
?>

<style type="text/css">
/*#main_menu_container{border-top:1px solid <?php echo $border_color?>; border-bottom:1px solid <?php echo $border_color?>;}*/
<?php echo $eid?> nav{background:<?php echo $bgcolor?>; <?php echo $vborder?>; }
<?php echo $eid?> nav:after{content:'';display:block;clear:both;}
<?php echo $eid?> .main-menu >li{width:<?php echo $width?>; text-align:center;}

<?php if(bt\varset($wcfg['split'])!='1'){?>
<?php echo $eid?> .main-menu >li{border-width:0;}
<?php }else{?>
<?php echo $eid?> .main-menu >li{border-left:1px solid <?php echo $border_color?>;}
<?php echo $eid?> .main-menu >li:last-child{border-right:1px solid <?php echo $border_color?>;}
<?php }?>

/* 메인메뉴 */
<?php echo $eid?> .main-menu >li >a{background-color:<?php echo $bgcolor_n?>; color:<?php echo $color_n?>; font-weight:<?php echo $bold_n?>;}
<?php echo $eid?> .main-menu >li >a.current{background:<?php echo $bgcolor_c?>; color:<?php echo $color_c?>; font-weight:<?php echo $bold_o?>;}
<?php echo $eid?> .main-menu >li >a:hover,
<?php echo $eid?> .main-menu >li >a:active,
<?php echo $eid?> .main-menu >li >a:focus,
<?php echo $eid?> .main-menu >li >a.highlighted{background:<?php echo $bgcolor_o?>; color:<?php echo $color_o?>; font-weight:<?php echo $bold_c?>;}

<?php echo $eid?> .main-menu >li >a >.sub-arrow{border-top-color:<?php echo $color_n;?>;}
<?php echo $eid?> .main-menu >li >a.current >.sub-arrow{border-top-color:<?php echo $color_c?>;}
<?php echo $eid?> .main-menu >li >a:hover >.sub-arrow,
<?php echo $eid?> .main-menu >li >a:active >.sub-arrow,
<?php echo $eid?> .main-menu >li >a:focus >.sub-arrow,
<?php echo $eid?> .main-menu >li >a.highlighted >.sub-arrow{border-top-color:<?php echo $color_o?>;}



/* 서브 메뉴 */
<?php echo $eid?> .main-menu li ul a{background-color:<?php echo $s_bgcolor_n?>; color:<?php echo $s_color_n?>; font-weight:<?php echo $s_bold_n?>;}
<?php echo $eid?> .main-menu li ul a.current{background:<?php echo $s_bgcolor_c?>; color:<?php echo $s_color_c?>;font-weight:<?php echo $s_bold_o?>;}
<?php echo $eid?> .main-menu li ul a:hover, 
<?php echo $eid?> .main-menu li ul a:active, 
<?php echo $eid?> .main-menu li ul a:focus, 
<?php echo $eid?> .main-menu li ul a.highlighted {background-color:<?php echo $s_bgcolor_o?>; color:<?php echo $s_color_o?>; font-weight:<?php echo $s_bold_c?>;}
<?php echo $eid?> .main-menu li ul a .sub-arrow{border-left-color:<?php echo $s_color_n;?>;}

<?php echo $eid?> .main-menu li ul a .sub-arrow{border-left-color:<?php echo $s_color_n;?>;}
<?php echo $eid?> .main-menu li ul a.current .sub-arrow{border-left-color:<?php echo $s_color_c?>;}
<?php echo $eid?> .main-menu li ul a:hover .sub-arrow,
<?php echo $eid?> .main-menu li ul a:active .sub-arrow,
<?php echo $eid?> .main-menu li ul a:focus .sub-arrow,
<?php echo $eid?> .main-menu li ul a.highlighted .sub-arrow{border-left-color:<?php echo $s_color_o?>;}

<?php if($wcfg['hide_arrow']){?>
<?php echo $eid?> .main-menu li .sub-arrow{display:none;}
<?php }?>

</style>
    
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

<nav>
    <div class="container">
        <ul class="main-menu sm <?php echo $menu_theme?>">
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
    $('<?php echo $eid?> .main-menu').smartmenus({
        subIndicators: true,
        subIndicatorsPos: 'append',
        subMenusMinWidth:'10em',
        /*subIndicatorsText: ' <span class="fa fa-sort-desc"></i>'*/
    });
});
//-->
</script>