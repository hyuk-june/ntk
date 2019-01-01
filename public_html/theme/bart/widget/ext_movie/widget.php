<?php
/*
title:동영상
description:Youtube등의 동영상을 반응형으로 출력합니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');
?>
<div class="widget-ext-movie">
    <?php echo $wcfg['mov_script'];?>
</div>