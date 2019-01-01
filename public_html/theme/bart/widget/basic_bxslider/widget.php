<?php
/*
title:가로회전배너(BxSlider)
description:BxSlider를 이용한 가로로 회전하는 배너위젯입니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css" />');
add_javascript('<script type="text/javascript" src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>');
ob_start();

$vh_xs = bt\binstr($wcfg['vheight']['xs'], 200);
$vh_sm = bt\binstr($wcfg['vheight']['sm'], 300);
$vh_md = bt\binstr($wcfg['vheight']['md'], 400);
$vh_lg = bt\binstr($wcfg['vheight']['lg'], 400);
?>

<style type="text/css">
@media(max-width: 768px){.sv{height:<?php echo $vh_xs?>px;}}
@media(min-width: 768px){.sv{height:<?php echo $vh_sm?>px;}}
@media(min-width: 992px){.sv{height:<?php echo $vh_md?>px;}}
@media(min-width: 1170px){.sv{height:<?php echo $vh_lg?>px;}}

<?php for($i=0; $i<count($wcfg['vbg']); $i++){?>
.sv<?php echo ($i+1)?>{background: url(<?php echo $wcfg['vbg'][$i]?>) no-repeat; background-size:cover; background-position: center;}
<?php }?>
.bx-wrapper{border:0}
<?php echo $wcfg['css']?>
.slider-visual .sv .container{height:100%; text-align:center;}
.bx-wrapper img{/*max-width:none;*/ display:inline;}
.bx-wrapper >img{max-width:100%; display:block;}
.bx-wrapper{margin-bottom:0;}
</style>

<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

    <ul class="slider-visual">
<?php for($i=0; $i<count($wcfg['vbg']); $i++){
    $j = $i+1;
?>
        <li>
            <div class="sv sv<?php echo $j?>">
                <div class="container d-flex align-items-center">
                    <?php btb\show_widgets(__FILE__, "", "visual_inner".$j)?>
                </div>
            </div>
        </li>
<?php }?>
    </ul>

    <script type="text/javascript">
    $(document).ready(function(){
        var slider = $('.slider-visual').bxSlider({
            auto: true,
            pager: false,
            controls:true,
            useCSS: false /* 이 부분이 없으면 한바퀴돌면 깜빡인다 (왜 그런지 모르겠음) */
        });
        
        $('#btn_widget_controller').click(function(){
            var ck = get_cookie('widget-controller');
            if(ck !== undefined && ck !== ''){
                slider.stopAuto();
            }else{
                slider.startAuto();
            }
        });
    });
    </script>  