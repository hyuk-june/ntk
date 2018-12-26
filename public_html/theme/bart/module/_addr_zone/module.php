<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

/*if(!$is_member){
    goto_url(G5_BBS_URL.'/login.php?url='.$_SERVER["REQUEST_URI"]);
}*/



$cache_dir = G5_DATA_PATH.'/bart/cache';
$cache = $cache_dir.'/address.js';

if(file_exists($cache)){
    echo file_get_contents($cache);
    exit;
}

$file = file($module_path.'/address.csv');

$jres = new bt\util\BJsonResult();

$list = array();
foreach($file as $line){
    
    $temp = explode(',', $line);
    $temp = array_map('trim', $temp);
    $si = $temp[0];
    $gun = $temp[1];
    $gu = isset($temp[2]) ? $temp[2] : null;
    
    if(!isset($list[$si]) || !is_array($list[$si])) $list[$si] = array();
    if(!isset($list[$si][$gun]) || !is_array($list[$si][$gun])) $list[$si][$gun] = array();
    if($gu != null) $list[$si][$gun][] = $gu;
}

@mkdir($cache_dir, true);
chmod($cache_dir, 0755);

$str = $jres->success($list);

$fp = fopen($cache, 'w+');
fwrite($fp, $str);
fclose($fp);

echo $str;
