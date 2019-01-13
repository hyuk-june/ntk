<?php
/*
title:회사연혁
description:회사연혁을 출력하는 위젯입니다
version:1.0.1
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

$list = array();
for($i=0; $i<count($wcfg['year']); $i++){
    $year = $wcfg['year'][$i];
    $month = $wcfg['month'][$i];
    $memo = $wcfg['memo'][$i];
    
    if(!is_array($list[$year])) $list[$year] = array();
    if(!is_array($list[$year][$month])) $list[$year][$month] = array();
    $list[$year][$month] = array_merge($list[$year][$month], explode(PHP_EOL, $memo));
}

krsort($list);
foreach($list as $key => $item){
    krsort($list[$key]);
    
    //krsort(&$item);
}

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');
?>

<div class="widget-basic-cp-history">
    <ul class="list-year py-2">
<?php foreach($list as $year => $yitem){?>
        <li class="d-flex">
            <div class="mr-4 my-3"><span class="year"><?php echo $year?>.</span></div>
            <ul class="list-month w-100">
    <?php foreach($yitem as $month => $mitem){?>
                <li class="d-flex py-3">
                    <div class="mr-4"><span class="month"><?php echo sprintf('%02d', $month)?></span></div>
                    <ul>
        <?php for($i=0; $i<count($mitem); $i++){?>
                        <li><?php echo $mitem[$i]?></li>
        <?php }?>
                    </ul>
                </li>
    <?php }?>
            </ul>
        </li>
<?php }?>
    </ul>
</div>

