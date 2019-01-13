<?php
/*
title: 새글 위젯
description:기본적인 모든게시판 새글 위젯
version:1.0.1
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!bt\isval($wcfg['bo_table'])) return;


include_once(G5_LIB_PATH.'/latest.lib.php');

$options = str_replace(array('\r','\n', '\''), array('', '', '"'),  $wcfg['options']);

try{
    $options = @json_decode($options, true);
}catch(Excpetion $e){}

try{
    echo latest($wcfg['skin'], $wcfg['bo_table'], $wcfg['rowcnt'], $wcfg['subject_len'], $wcfg['wg_cache_min'], $options);
}catch(Exception $e){}