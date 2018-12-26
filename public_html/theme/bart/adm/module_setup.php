<?php
$sub_menu = "801403";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

use kr\bartnet as bt;

$jres = new bt\util\BJsonResult();

$module = bt\varset($_GET["module"]);

if(!bt\isval($module)){
    echo $jres->error('모듈명이 전달되지 않았습니다');
    exit;
}

$filename = BT_MODULE_PATH.'/'.$module.'/setup.php';
if(!file_exists($filename)){
    echo $jres->success();
    exit;
}

echo $jres->success(file_get_contents($filename));