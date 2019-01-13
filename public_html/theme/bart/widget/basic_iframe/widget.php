<?php
/*
title:IFRAME 위젯
description:IFRAME 페이지를 삽입합니다
version:1.0.1
author:NTK
single:false
*/
if(!defined("_GNUBOARD_")) exit("Access Denied");

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');
?>

<div class="widget-basic-iframe">
    <iframe src="<?php echo $wcfg["src"]?>" style="width:100%;height:<?php echo $wcfg["height"]?>px"></iframe>
</div>