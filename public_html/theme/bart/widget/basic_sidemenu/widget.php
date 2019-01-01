<?php
/*
title:사이드메뉴
description:기본적인 사이드메뉴 위젯
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$btmenu = btb\BMenu::getInstance();

if($bt['curpath']){
    $bm_pidx = $bt['curpath'][0]['bm_idx'];
}else{
    $bm_pidx = 0;
}

if($bm_pidx > 0){
    $list = $btmenu->getTreeList('pc', true, $bm_pidx);
}else{
    $list = $btmenu->getTreeList('pc', true, '0', 0);
}

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$h_bg = '#'.trim(bt\binstr($wcfg['h_bg'], '49505a'), '#');
$h_color = '#'.trim(bt\binstr($wcfg['h_color'], 'fff'), '#');

ob_start();
?>
<style type="text/css">
.widget-basic-sidemenu .card-heading{background-color:<?php echo $h_bg?>; color:<?php echo $h_color?>;}
</style>
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>


<?php if(count($list)){?>
<nav class="widget-basic-sidemenu card card-default">
    <h2 id="side-title" class="card-heading">
<?php if($bm_pidx > 0){?>
    <?php echo $bt['curpath'][0]['bm_name']?>
<?php }else{?>
    <?php echo $config['cf_title']?>
<?php }?>
    </h2>
    <ul class="card-body">
        <?php echo btb\get_menu_tag($list, $bt['curmenu']['bm_idx']);?>
    </ul>
</nav>
<?php }?>