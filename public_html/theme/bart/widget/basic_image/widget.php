<?php
/*
title:이미지 위젯
description:이미지를 삽입합니다
version:1.0.0
author:NTK
single:false
*/
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

$img = '<img src="'.$wcfg['imgsrc'].'"';
if(bt\isval($wcfg['alt'])) $img .= ' alt="'.$wcfg['alt'].'"';
$img .= '>';

if(bt\isval($wcfg['link'])){
    $a_head = '<a href="'.$wcfg['link']."'";
    if(bt\isval($wcfg['title'])) $a_head .= ' title="'.$wcfg['title']."'";
    $a_head .= ' target="'.$wcfg['target']."'>";
    $a_tail = '</a>';
    
    $img = $a_head.$img.$a_tail;
}
?>

<div class="widget-basic-image" style="text-align:<?php echo $wcfg['align']?>"><?php echo $img?></div>