<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$col['lg'] = bt\binstr($wcfg['numpr']['lg'], 6);
$col['md'] = bt\binstr($wcfg['numpr']['md'], 4);
$col['sm'] = bt\binstr($wcfg['numpr']['sm'], 3);
$col['xs'] = bt\binstr($wcfg['numpr']['xs'], 2);

$ma_w['lg'] = bt\binstr($wcfg['ma_w']['lg'], 5);
$ma_w['md'] = bt\binstr($wcfg['ma_w']['md'], 5);
$ma_w['sm'] = bt\binstr($wcfg['ma_w']['sm'], 10);
$ma_w['xs'] = bt\binstr($wcfg['ma_w']['xs'], 15);

$ma_h['lg'] = bt\binstr($wcfg['ma_h']['lg'], 5);
$ma_h['md'] = bt\binstr($wcfg['ma_h']['md'], 5);
$ma_h['sm'] = bt\binstr($wcfg['ma_h']['sm'], 10);
$ma_h['xs'] = bt\binstr($wcfg['ma_h']['xs'], 15);


ob_start();
?>
<style type="text/css">

@media(max-width:750px){
    .widget-basic-latest-gallery ul {margin-left: -<?php echo $ma_w['xs']?>px; margin-right: -<?php echo $ma_w['xs']?>px;}
    .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['xs'], 4)?>%;
        padding: <?php echo $ma_h['xs']?>px <?php echo $ma_w['xs']?>px;
    }
    
}

@media(min-width:750px){
    .widget-basic-latest-gallery ul {margin-left: -<?php echo $ma_w['sm']?>px; margin-right: -<?php echo $ma_w['sm']?>px;}
    .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['sm'], 4)?>%;
        padding: <?php echo $ma_h['sm']?>px <?php echo $ma_w['sm']?>px;
    }
}

@media(min-width:970px){
    .widget-basic-latest-gallery ul {margin-left: -<?php echo $ma_w['md']?>px; margin-right: -<?php echo $ma_w['md']?>px;}
    .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['md'], 4)?>%;
        padding: <?php echo $ma_h['md']?>px <?php echo $ma_w['md']?>px;
    }
}

@media(min-width:1170px){
    .widget-basic-latest-gallery ul {margin-left: -<?php echo $ma_w['lg']?>px; margin-right: -<?php echo $ma_w['lg']?>px;}
    .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['lg'], 4)?>%;
        padding: <?php echo $ma_h['lg']?>px <?php echo $ma_w['lg']?>px;
    }
}
</style>
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);