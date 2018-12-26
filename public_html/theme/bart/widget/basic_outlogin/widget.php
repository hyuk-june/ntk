<?php
/*
title:외부로그인 위젯
version:1.0.0
author:bartnet
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

include_once(G5_LIB_PATH.'/outlogin.lib.php');

echo btb\outlogin($wcfg['skin']);