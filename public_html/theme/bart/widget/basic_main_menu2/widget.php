<?php
/*
title:메인메뉴2
description:전체항목이 펼쳐지는 메인메뉴
version:1.0.0
author:bartnet
single:true
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

global $menulist, $bt, $menu_theme;

$menucnt = count($menulist);
if($wcfg['show_home']) $menucnt++;
$width = (100 / $menucnt).'%';

$height = bt\binstr($wcfg['height'], 43);


$border_color = bt\add_string( bt\binstr($wcfg['border_color'], '#ddd'), '#');

$bgcolor = bt\binstr($wcfg['bgcolor'], '#'.$wcfg['bgcolor'], 'transparent');
$bgcolor_n = bt\binstr($wcfg['bgcolor_n'], '#'.$wcfg['bgcolor_n'], 'transparent');
$color_n = bt\binstr($wcfg['color_n'], '#'.$wcfg['color_n'], '#333');
$bgcolor_o = bt\binstr($wcfg['bgcolor_o'], '#'.$wcfg['bgcolor_o'], '#414141');
$color_o = bt\binstr($wcfg['color_o'], '#'.$wcfg['color_o'], '#fff');
$bgcolor_c = bt\binstr($wcfg['bgcolor_c'], '#'.$wcfg['bgcolor_c'], '#333');
$color_c = bt\binstr($wcfg['color_c'], '#'.$wcfg['color_c'], '#fff');

$s_bgcolor = bt\hex2rgba( bt\binstr($wcfg['s_bgcolor'], $wcfg['s_bgcolor'], 'fff'), .95);

$s_color_n = bt\binstr($wcfg['s_color_n'], '#'.$wcfg['s_color_n'], '#333');
$s_bgcolor_o = bt\hex2rgba( bt\binstr($wcfg['s_bgcolor_o'], $wcfg['s_bgcolor_o'], '414141'), .95);
$s_color_o = bt\binstr($wcfg['s_color_o'], '#'.$wcfg['s_color_o'], '#fff');
$s_bgcolor_c = bt\hex2rgba( bt\binstr($wcfg['s_bgcolor_c'], $wcfg['s_bgcolor_c'], '333'), .95);
$s_color_c = bt\binstr($wcfg['s_color_c'], '#'.$wcfg['s_color_c'], '#fff');

ob_start();
?>

<style type="text/css">

.gnb .gnb-bar{background:<?php echo $bgcolor?>; border-top:1px solid <?php echo $border_color?>; border-bottom:1px solid <?php echo $border_color?>; }


<?php if(bt\varset($wcfg['split'])!='1'){?>
.gnb .gnb-bar >li{border-width:0;}
<?php }else{?>
.gnb .gnb-bar ul:first-child >li{
    box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -webkit-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -o-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -ms-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -moz-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
}
<?php }?>


.gnb .gnb-bar ul:first-child >li >a{color:<?php echo $color_n?>;}

.gnb .gnb-bar ul:first-child >li >a.current{background:<?php echo $bgcolor_c?>; color:<?php echo $color_c?>;}
.gnb .gnb-bar ul:first-child >li >a:hover,
.gnb .gnb-bar ul:first-child >li >a:active,
.gnb .gnb-bar ul:first-child >li >a:focus,
.gnb .gnb-bar ul:first-child >li >a.highlighted{background:<?php echo $bgcolor_o?>; color:<?php echo $color_o?>;}

/* 서브 메뉴 */
.gnb .gnb-bar li ul a.current{background:<?php echo $s_bgcolor_c?>; color:<?php echo $s_color_c?>;}
.gnb .gnb-bar li ul a:hover, 
.gnb .gnb-bar li ul a:active, 
.gnb .gnb-bar li ul a:focus, 
.gnb .gnb-bar li ul a.highlighted {background-color:<?php echo $s_bgcolor_o?>; color:<?php echo $s_color_o?>;}

.gnb .gnb-bar{position:relative; height:<?php echo $height?>px;}
.gnb .gnb-bar ul{padding:0; margin:0; list-style:none;}
.gnb .gnb-bar a{display:block;}

/*메인메뉴*/
.gnb .gnb-bar ul:first-child >li >a{padding:0 10px;font-size:1rem; text-align:center; font-weight:bold; line-height:<?php echo $height-1?>px;}
.gnb .gnb-bar ul:first-child >li{width:<?php echo $width?>;}
.gnb .wrap{position:absolute; overflow:hidden; width:100%; top:0; bottom:0; display:none; height:auto; background:transparent; transition: background-color .25s ease-out}
.gnb.on .wrap{background-color:<?php echo $s_bgcolor?>; display:block; border-width:1px; border-bottom:2px solid <?php echo $border_color?>;}

/*서브메뉴*/
.gnb .gnb-bar ul ul{display:none; height:100%; margin-top:-<?php echo $height?>px; padding:5px; padding-top:<?php echo $height+4?>px; bottom:0;}
.gnb .gnb-bar ul ul li a{text-align:left; font-weight:normal; font-size:.9rem; padding:5px;}
.gnb.on ul li >ul{display:block; opacity:1; width:100%; 
    box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -webkit-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -moz-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -o-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
/*    -ms-box-shadow: 1px 0 0 0 */<?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
}
</style>

<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

<script type="text/javascript">
<!--
(function($){
    
    var gnb = null;
    var wrap = null;
    var sub_h = null;
    
    $.fn.fullDownMenu = function(){
        gnb = $(this);
        $('.gnb .gnb-bar ul >li').mouseover(showMenu);
        $('.gnb .gnb-bar ul >li').mouseleave(hideMenu);
        wrap = $('<div class="wrap"></div>');
        $('.gnb').after().prepend(wrap);
    }
    
    function showMenu(){
        $('.gnb').addClass('on');
        var th = $('.gnb .gnb-bar .container').outerHeight();
        var mh = $('.gnb ul:first-child >li >a').outerHeight();
        console.log('A:' + th);
        wrap.height(th);
    }
    
    function hideMenu(){
        $('.gnb').removeClass('on');
        wrap.height(0);
    }
    
})(jQuery);

$(document).ready(function(){
    $('.gnb').fullDownMenu();
});
//-->
</script>

<?php
ob_start();
?>
<ul class="d-flex">
    <?php if(bt\varset($wcfg['show_home'])=='1'){?>
    <li><a href="<?php echo G5_URL?>"<?php echo !bt\isval($bt['curmenu']['bm_idx']) ? ' class="current"':'';?>><i class="fa fa-home"></i> HOME</a></li>
<?php }?>
    <?php echo btb\get_menu_tag($menulist, $bt['curmenu']['bm_idx'], 'a', true);?>
</ul>
<?php
$str = ob_get_contents();
ob_end_clean();
?>

<div class="gnb" style="z-index:999;">
    <div class="gnb-bar">
        <div class="container">
        <?php if($wcfg['use_widget']){?>
            <div class="row">
                <div class="col-md-3">
                    <?php btb\show_widgets(__FILE__, "", "menu_widget");?>
                </div>
                <div class="col-md-9">
                    <?php echo $str?>
                </div>
            </div>
        <?php }else{?>
            <?php echo $str?>
        <?php }?>
        </div>
    </div>
</div>
