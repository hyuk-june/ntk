<?php
/*
title: 링크탭
description: 링크 탭
version:1.0.1
author:NTK
single:false
*/
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

if(!isset($wcfg['url'])) return;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$width = 'auto';

$cls_ul = array();
$cls_li = array();
$sty_ul = array();
$sty_li = array();
$sty_txt = array();
$width = 'auto';

$cls_ul[] = 'flex flex-wrap';

//박스 정렬
if($wcfg['flex_align']=='left'){
    $cls_ul[] = 'justify-start';
}else if($wcfg['flex_align']=='right'){
    $cls_ul[] = 'justify-end';
}else{
    $cls_ul[] = 'justify-between';
    $width = (round(100 / count($wcfg['url']), 4)).'%';
}

//셀정렬
if($wcfg['text_align']=='left'){
    $cls_li[] = 'text-left';
}else if($wcfg['text_align']=='right'){
    $cls_li[] = 'text-right';
}else{
    $cls_li[] = 'text-center';
}

//라인
if($wcfg['line_hide']!=='1'){
    //$cls_ul[] = 'shadow-border';
    $cls_li[] = 'shadow-border';
    
    //$sty_ul[] = 'box-shadow-color: #'.trim(bt\binstr($wcfg['line_color'], 'ddd'), '#');
    $sty_li[] = 'color: #'.trim(bt\binstr($wcfg['line_color'], 'ddd'), '#');
}

//폰트 칼라
if($wcfg['text_color']!==''){
    $sty_txt[] = 'color: #'.trim($wcfg['text_color'], '#');
}

$class_ul = '';
$class_li = '';
if(count($cls_ul) > 0) $class_ul = ' class="'.@implode(' ', $cls_ul).'"';
if(count($cls_li) > 0) $class_li = ' class="'.@implode(' ', $cls_li).'"';

$style_ul = '';
$style_li = '';
if(count($sty_ul) > 0) $style_ul = ' style="'.@implode('; ', $sty_ul).'"';
if(count($sty_li) > 0) $style_li = ' style="'.@implode('; ', $sty_li).'"';

$style_txt = '';
if(count($sty_txt) > 0) $style_txt = ' style="'.@implode('; ', $sty_txt).'"';

ob_start();
?>

<style type="text/css">
.widget-basic-linktab ul li{flex-basis: <?php echo $width?>}
@media(max-width:576px){
    <?php if(count($wcfg['url']) >= 2){?>
    .widget-basic-linktab ul li{flex-basis: 50%;}
    <?php }?>
}
</style>

<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

<?php if(isset($wcfg['url'])){?>
<div class="widget-basic-linktab">
    <ul<?php echo $class_ul?><?php echo $style_ul?>>

<?php for($i=0; $i<count($wcfg['url']); $i++){?>
        <li<?php echo $class_li?><?php echo $style_li?>><a href="<?php echo $wcfg['url'][$i]?>"<?php echo $style_txt?>><?php echo $wcfg['text'][$i]?></a></li>
<?php }?>

    </ul>
</div>
<?php }?>