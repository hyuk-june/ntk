<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

$height['xs'] = bt\binstr($wcfg['height']['xs'], 200);
$height['sm'] = bt\varset($wcfg['height']['sm']);
$height['md'] = bt\varset($wcfg['height']['md']);
$height['lg'] = bt\varset($wcfg['height']['lg']);
$height['xl'] = bt\varset($wcfg['height']['xl']);

ob_start();
?>
<style type="text/css">
<?php echo $eid?> .widget-basic-daum-map .map{
    height: <?php echo $height['xs']?>px;
}

<?php if(bt\isval($height['sm'])){?>
@media(min-width:576px){
    <?php echo $eid?> .widget-basic-daum-map .map{
        height: <?php echo $height['sm']?>px;
    }
}
<?php }?>

<?php if(bt\isval($height['md'])){?>
@media(min-width:768px){
    <?php echo $eid?> .widget-basic-daum-map .map{
        height: <?php echo $height['md']?>px;
    }
}
<?php }?>

<?php if(bt\isval($height['lg'])){?>
@media(min-width:992px){
    <?php echo $eid?> .widget-basic-daum-map .map{
        height: <?php echo $height['lg']?>px;
    }
}
<?php }?>

<?php if(bt\isval($height['xl'])){?>
@media(min-width:1200px){
    <?php echo $eid?> .widget-basic-daum-map .map{
        height: <?php echo $height['xl']?>px;
    }
}
<?php }?>
</style>
<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);