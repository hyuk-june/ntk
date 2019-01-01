<?php
/*
title:로고매니저
description:로고를 출력합니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

//add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$today = date('Y-m-d');

$logo_url = bt\binstr($wcfg['logo_url'], G5_URL);
$logo_img = bt\varset($wcfg['logo_img']);

if(is_array($wcfg['imgurl'])){
    for($i=0; $i<count($wcfg['imgurl']); $i++){
        if($today >= $wcfg['sdate'][$i] && $today <= $wcfg['edate'][$i]){
            $logo_img = $wcfg['imgurl'][$i];
            break;
        }
    }
}

if($logo_img == '') return;
?>

<div class="widget-ext-logo">
    <a href="<?php echo $logo_url?>" title="<?php echo $config['cf_title']?>"><img src="<?php echo $logo_img?>" alt="<?php echo $config['cf_title']?>" class="img-fluid"></a>
</div>


