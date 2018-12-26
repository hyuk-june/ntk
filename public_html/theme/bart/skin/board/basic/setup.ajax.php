<?php
include_once("./_common.php");

include_once("./lib/board.lib.php");

use kr\bartnet\board as btbo;

include('board.cmm.php');
//$bo_table = $_GET["bo_table"];
$mode = $_GET["mode"];
$skin = $_GET["skin"];

$filepath = $mode.'/'.$skin.'/setup.skin.php';

if(file_exists($filepath)){
    include_once($filepath);
}else{
    if($mode=='list') $strmode = '목록';
    else if($mode=='view') $strmode = '내용';
    else if($mode=='write') $strmode = '쓰기';
    echo '<div class="text-center">이 '.$strmode.'스킨에는 설정옵션이 없습니다</div>';
}