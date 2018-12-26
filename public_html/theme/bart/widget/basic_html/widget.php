<?php
/*
title:HTML위젯
description:텍스트나 HTML을 삽입할 수 있습니다
version:1.0.0
author:bartnet
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");


$css = '<style type="text/css">'.PHP_EOL
.$wcfg["css"].PHP_EOL
.'</style>'.PHP_EOL;

add_stylesheet($css);
?>
<div class="widget-basic-html">
    <?php echo stripcslashes($wcfg["html"]);?>
</div>


