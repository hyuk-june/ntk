<?php
/*
title:설문조사 위젯
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$widget_url.'/widget.css">', 0);
include_once(G5_LIB_PATH.'/poll.lib.php');

$skin = bt\binstr($wcfg['skin'], 'basic');
?>

<div class="widget-basic-poll">
    <?php echo poll($skin);?>
</div>
