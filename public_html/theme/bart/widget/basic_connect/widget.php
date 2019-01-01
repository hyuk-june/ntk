<?php
/*
title: 현재접속자
description:현재접속자 수 위젯
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

include_once(G5_LIB_PATH.'/connect.lib.php');

$skin = bt\binstr($wcfg['skin'], 'basic');

echo connect($skin);