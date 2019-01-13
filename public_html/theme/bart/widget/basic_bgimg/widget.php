<?php
/*
title:배경이미지위젯
description:이미지를 배경으로 삽입합니다
version:1.0.0
author:NTK
single:false
*/
if(!defined("_GNUBOARD_")) exit("Access Denied");
use kr\bartnet as bt;
ob_start();
?>
<style type="text/css">
<?php if(bt\isval($wcfg['imgsrc'])){?>
<?php echo $eid?> .widget-basic-bgimg{background: url(<?php echo $wcfg['imgsrc']?>) center no-repeat;}
<?php echo $eid?> .widget-basic-bgimg{background-size: cover;}
<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['xs']?>px;}
@media(min-width:576px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['sm']?>px;}}
@media(min-width:768px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['md']?>px;}}
@media(min-width:992px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['lg']?>px;}}
@media(min-width:1200px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['xl']?>px;}}
<?php }?>
</style>
<?php
$str = ob_get_contents();
ob_end_clean();
add_stylesheet($str);
?>

<div class="widget-basic-bgimg"></div>