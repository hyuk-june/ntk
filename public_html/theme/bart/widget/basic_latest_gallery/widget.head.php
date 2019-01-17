<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$col['xs'] = bt\binstr($wcfg['numpr']['xs'], 2);
$col['sm'] = bt\varset($wcfg['numpr']['sm']);
$col['md'] = bt\varset($wcfg['numpr']['md']);
$col['lg'] = bt\varset($wcfg['numpr']['lg']);
$col['xl'] = bt\varset($wcfg['numpr']['xl']);

ob_start();
?>
<style type="text/css">
<?php echo $eid?> .widget-basic-latest-gallery ul li{
    width:<?php echo round(100 / $col['xs'], 6)?>%;
}

<?php if(bt\isval($col['sm'])){?>
@media(min-width:576px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['sm'], 4)?>%;
    }
}
<?php }?>

<?php if(bt\isval($col['md'])){?>
@media(min-width:768px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['md'], 4)?>%;
    }
}
<?php }?>

<?php if(bt\isval($col['lg'])){?>
@media(min-width:992px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['lg'], 4)?>%;
    }
}
<?php }?>

<?php if(bt\isval($col['xl'])){?>
@media(min-width:1200px){
    <?php echo $eid?> .widget-basic-latest-gallery ul li{
        width:<?php echo round(100 / $col['xl'], 4)?>%;
    }
}
<?php }?>
</style>
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);