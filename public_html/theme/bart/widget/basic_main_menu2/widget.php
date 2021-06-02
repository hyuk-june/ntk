<?php
/*
title:메인메뉴2
description:전체항목이 펼쳐지는 메인메뉴
version:1.0.1
author:NTK
single:false
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

if(bt\varset($wcfg['vertical'])=='1') $vborder = 'border-top: 1px solid '.$border_color.'; border-bottom: 1px solid '.$border_color;
?>
<link rel="stylesheet" type="text/css" href="<?php echo $widget_url?>/widget.css" />
<style type="text/css">

<?php echo $eid?> .gnb { position: relative; }
<?php echo $eid?> .gnb .gnb-bar{background:<?php echo $bgcolor?>; <?php echo $vborder?>; }


<?php if(bt\varset($wcfg['split'])!='1'){?>
<?php echo $eid?> .gnb .gnb-bar >li{border-width:0;}
<?php }else{?>
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li{
    box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -webkit-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -o-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -ms-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
    -moz-box-shadow: 1px 0 0 0 <?php echo $border_color?>, 1px 0 0 0 <?php echo $border_color?> inset;
}
<?php }?>


<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a{color:<?php echo $color_n?>;}

<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a.current{background:<?php echo $bgcolor_c?>; color:<?php echo $color_c?>;}
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a:hover,
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a:active,
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a:focus,
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a.highlighted{background:<?php echo $bgcolor_o?>; color:<?php echo $color_o?>;}

/* 서브 메뉴 */
<?php echo $eid?> .gnb .gnb-bar li ul a.current{background:<?php echo $s_bgcolor_c?>; color:<?php echo $s_color_c?>;}
<?php echo $eid?> .gnb .gnb-bar li ul a:hover, 
<?php echo $eid?> .gnb .gnb-bar li ul a:active, 
<?php echo $eid?> .gnb .gnb-bar li ul a:focus, 
<?php echo $eid?> .gnb .gnb-bar li ul a.highlighted {background-color:<?php echo $s_bgcolor_o?>; color:<?php echo $s_color_o?>;}

<?php echo $eid?> .gnb .gnb-bar{position:relative; height:<?php echo $height?>px;}
<?php echo $eid?> .gnb .gnb-bar ul{padding:0; margin:0; list-style:none;}
<?php echo $eid?> .gnb .gnb-bar a{display:block;}

/*메인메뉴*/
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li >a{padding:0 10px;font-size:1rem; text-align:center; font-weight:bold; line-height:<?php echo $height-1?>px;}
<?php echo $eid?> .gnb .gnb-bar ul:first-child >li{width:<?php echo $width?>;}
<?php echo $eid?> .gnb .wrap{position:absolute; overflow:hidden; width:100%; top:0; bottom:0; display:none; height:auto; background:transparent; transition: background-color .25s ease-out}
<?php echo $eid?> .gnb.on .wrap{background-color:<?php echo $s_bgcolor?>; display:block; border-width:1px; border-bottom:2px solid <?php echo $border_color?>;}

/*서브메뉴*/
<?php echo $eid?> .gnb .gnb-bar ul ul{ display:none; height:100%; margin-top:-<?php echo $height?>px; padding:5px; padding-top:<?php echo $height+4?>px; bottom:0;}
<?php echo $eid?> .gnb .gnb-bar ul ul li a{text-align:left; font-weight:normal; font-size:.9rem; padding:5px;}
<?php echo $eid?> .gnb.on ul li >ul{display:block; opacity:1; width:100%; 
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
(function($){
    
    var eid = '<?php echo $eid?>';
    
    var gnb = null;
    var wrap = null;
    var sub_h = null;
    
    $.fn.fullDownMenu = function(){
        gnb = $(this);
        $(eid + ' .gnb .gnb-bar ul >li').mouseover(showMenu);
        $(eid + ' .gnb .gnb-bar ul >li').mouseleave(hideMenu);
        wrap = $('<div class="wrap"></div>');
        $(eid + ' .gnb').after().prepend(wrap);
    }
    
    function showMenu(){
        $(eid + ' .gnb').addClass('on');
        var th = $(eid + ' .gnb .gnb-bar .container').outerHeight();
        var mh = $(eid + ' .gnb ul:first-child >li >a').outerHeight();
        wrap.height(th);
    }
    
    function hideMenu(){
        $(eid + ' .gnb').removeClass('on');
        wrap.height(0);
    }
    
    $(document).ready(function(){
        $(eid + ' .gnb').fullDownMenu();
    });
    
})(jQuery);
</script>

<?php
ob_start();
?>
<ul class="flex">
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
            <div class="flex">
                <div class="w-3/12">
                    <?php btb\show_widgets(__FILE__, "", "menu_widget");?>
                </div>
                <div class="w-9/12">
                    <?php echo $str?>
                </div>
            </div>
        <?php }else{?>
            <?php echo $str?>
        <?php }?>
        </div>
    </div>
</div>
