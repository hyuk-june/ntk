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
use kr\bartnet\builder as btb;
ob_start();
?>
<style type="text/css">
.widget-basic-bgimg{overflow:hidden;}
.widget-basic-bgimg >.child{width: 100%;}
<?php if(bt\isval($wcfg['imgsrc'])){?>
<?php echo $eid?> .widget-basic-bgimg{background: url(<?php echo $wcfg['imgsrc']?>) center no-repeat; position:relative;}
<?php echo $eid?> .widget-basic-bgimg{background-size: cover;}
<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['xs']?>px;}
@media(min-width:576px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['sm']?>px;}}
@media(min-width:768px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['md']?>px;}}
@media(min-width:992px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['lg']?>px;}}
@media(min-width:1200px){<?php echo $eid?> .widget-basic-bgimg{height:<?php echo $wcfg['height']['xl']?>px;}}
<?php }?>

<?php if($wcfg['valign']=='top'){?>
<?php echo $eid?> .widget-basic-bgimg {display:block;}
<?php echo $eid?> .widget-basic-bgimg >.child{top:<?php echo bt\binstr($wcfg['margin'], '0')?>px; position:absolute;}
<?php }else if($wcfg['valign']=='bot'){?>
<?php echo $eid?> .widget-basic-bgimg {display:block;}
<?php echo $eid?> .widget-basic-bgimg >.child{bottom:<?php echo bt\binstr($wcfg['margin'], '0')?>px; position:absolute;}
<?php }else{?>
<?php echo $eid?> {display:table; width:100%;}
<?php echo $eid?> .widget-basic-bgimg {display:table-cell; vertical-align:middle;}
<?php echo $eid?> .widget-basic-bgimg >.child{position:relative;}
<?php }?>
</style>
<?php
$str = ob_get_contents();
ob_end_clean();
add_stylesheet($str);

global $pg_id;
?>

<div class="widget-basic-bgimg">
    <div class="child"><?php echo btb\show_widgets(__FILE__, $pg_id, $wcfg['wg_eid'])?></div>
</div>