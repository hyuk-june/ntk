<?php
include_once("./_common.php");

use kr\bartnet as bt;

$module = bt\varset($_GET["module"]);
$pg_id = bt\varset($_GET["pg_id"]);

$mdcfg = array();

if(bt\isval($pg_id)){
    $sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_id='".$pg_id."'";
    $rs = sql_fetch($sql);
    if(trim($rs['pg_config'])!=''){
        $mdcfg = @json_decode($rs['pg_config'], true);
    }
}

$filepath = BT_MODULE_PATH.'/'.$module.'/setup.php';

if(file_exists($filepath)){
    include_once($filepath);
}else{
    echo '이 모듈에는 설정옵션이 없습니다';
}
