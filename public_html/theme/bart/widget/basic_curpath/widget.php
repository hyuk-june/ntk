<?php
/*
title:타이틀 & 현재위치
description:현재페이지의 제목과 위치를 출력하는 위젯입니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

global $cur_path_list, $cur_path, $cur_title, $cur_subtitle;


$bg = btb\colorformat($wcfg['bg']);
$color_t = btb\colorformat($wcfg['color_t']);
$color_s = btb\colorformat($wcfg['color_s']);
$color_p = btb\colorformat($wcfg['color_p']);
$color_line = btb\colorformat($wcfg['color_line'], 'ddd');

$w_t = bt\binstr($wcfg['width_line']['t'], '0').'px';
$w_r = bt\binstr($wcfg['width_line']['r'], '0').'px';
$w_b = bt\binstr($wcfg['width_line']['b'], '0').'px';
$w_l = bt\binstr($wcfg['width_line']['l'], '0').'px';


add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

ob_start();
?>
<style type="text/css">
<?php echo $eid?> .widget-basic-curpath {background: <?php echo $bg?>; border-style:solid; border-color:<?php echo $color_line;?>; border-width: <?php echo $w_t?> <?php echo $w_r?> <?php echo $w_b?> <?php echo $w_l?>;}

<?php echo $eid?> .widget-basic-curpath .page-title{color:<?php echo $color_t?>;}
<?php echo $eid?> .widget-basic-curpath .page-desc{color:<?php echo $color_s?>;}
<?php echo $eid?> .widget-basic-curpath .breadcrumb,
<?php echo $eid?> .widget-basic-curpath .breadcrumb a{color:<?php echo $color_p?>;}
</style>

<?php
$str = ob_get_contents();
ob_end_clean();
add_stylesheet($str);
?>
<div class="widget-basic-curpath">
    <div class="content-title p-2">
        <div class="container enf">
        <?php if (bt\isval($cur_path_list) && count($cur_path_list)>0) { ?>
            <div class="curpos">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo G5_URL?>">Home</a></li>
            <?php for($i=0; $i<count($cur_path_list); $i++){
                $cls = 'breadcrumb-item';
                if($i == count($cur_path_list)-1) $cls .= ' active';
            ?>
                    <li class="<?php echo $cls?>">
                        <a href="<?php echo $cur_path_list[$i]['link']?>" target="<?php echo $cur_path_list[$i]['target']?>">
                            <?php echo $cur_path_list[$i]['text']?>
                        </a>
                    </li>
                    
                <?php }?>
                   <?php echo $cur_path?>
                </ul>
            </div>
        <?php }?>
            <div class="title-wrap">
                <!--<i class="fa fa-map-marker"></i>-->
                <h2 class="page-title font-weight-bold mt-2"><?php echo $cur_title?></h2>
                <?php if(bt\isval($cur_subtitle)){?>
                <small class="page-desc mt-2" style="display:block;">
                    <?php echo $cur_subtitle?>
                </small>
                <?php }?>
            </div>
        </div>
    </div>
</div>