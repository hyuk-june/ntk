<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$col['xs'] = bt\binstr($wcfg['numpr']['xs'], 2);
$col['sm'] = bt\binstr($wcfg['numpr']['sm'], 3);
$col['md'] = bt\binstr($wcfg['numpr']['md'], 4);
$col['lg'] = bt\binstr($wcfg['numpr']['lg'], 6);
$col['xl'] = bt\binstr($wcfg['numpr']['xl'], 6);

ob_start();
?>
<style type="text/css">
<?php echo $eid?> .widget-basic-latest-gallery ul li{
    width:<?php echo round(100 / $col['xs'], 6)?>%;
}

@media(min-width:576px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['sm'], 4)?>%;
    }
}

@media(min-width:768px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['md'], 4)?>%;
    }
}

@media(min-width:992px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['lg'], 4)?>%;
    }
}

@media(min-width:1200px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['xl'], 4)?>%;
    }
}
</style>
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);