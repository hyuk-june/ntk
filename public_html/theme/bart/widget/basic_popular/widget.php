<?php
/*
title:인기검색어 위젯
version:1.0.1
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

include_once(G5_LIB_PATH.'/popular.lib.php');

$skin = bt\binstr($wcfg['skin'], 'basic');

$date_cnt = bt\binstr($wcfg['date_cnt'], 3);
$pop_cnt = bt\binstr($wcfg['pop_cnt'], 7);

echo popular($skin, $pop_cnt, $date_cnt);
