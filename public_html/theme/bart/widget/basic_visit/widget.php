<?php
/*
title:방문자수 표시
description:방문자수를 출력합니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$skin = bt\binstr($wcfg['skin'], 'basic');

include_once(G5_LIB_PATH.'/visit.lib.php');
echo visit($skin); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정