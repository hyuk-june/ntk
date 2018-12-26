<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

if(!$is_member && !bt\isval($_SESSION['bt_pnum'])){
    
    ob_clean(); //헤더가 출력되지 않게 한다
    
    $path = dirname(__FILE__);
    
    include(G5_THEME_PATH.'/head.sub.php');
    
    include_once($board_skin_path.'/inc/phone_check.skin.php');
    
    include(G5_THEME_PATH.'/tail.sub.php');
    
    exit();
}