<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

include_once($board_skin_path.'/lib/board.lib.php');

//게시판 추가 설정
$bcfg = btbo\get_config($bo_table);

//서브스킨경로
$sub_paths = array(
    'list' => $board_skin_path.'/list/'.bt\binstr($bcfg['skin_list'], 'basic'),
    'view' => $board_skin_path.'/view/'.bt\binstr($bcfg['skin_view'], 'basic'),
    'write' => $board_skin_path.'/write/'.bt\binstr($bcfg['skin_write'], 'basic'),
);

//서브스킨URL
$sub_urls = array(
    'list' => $board_skin_url.'/list/'.bt\binstr($bcfg['skin_list'], 'basic'),
    'view' => $board_skin_url.'/view/'.bt\binstr($bcfg['skin_view'], 'basic'),
    'write' => $board_skin_url.'/write/'.bt\binstr($bcfg['skin_write'], 'basic'),
);

//목록 필드출력 여부
$list_show_writer = true;
$list_show_datetime = true;
$list_show_hit = true;
$list_show_good = false;
$list_show_nogood = false;

if(count($bcfg) > 0){
    $list_show_writer = $bcfg['list_show_writer'];
    $list_show_datetime = $bcfg['list_show_datetime'];
    $list_show_hit = $bcfg['list_show_hit'];
    $list_show_good = $bcfg['list_show_good'];
    $list_show_nogood = $bcfg['list_show_nogood'];
}

//읽기 필드출력 여부
$write_show_writer = true;
$write_show_datetime = true;
$write_show_hit = true;
$write_show_cmtcnt = true;

if(count($bcfg) > 0){
    $write_show_writer = $bcfg['write_show_writer'];
    $write_show_datetime = $bcfg['write_show_datetime'];
    $write_show_hit = $bcfg['write_show_hit'];
    $write_show_cmtcnt = $bcfg['write_show_cmtcnt'];
}


$str = <<< HEREDOC
<script type="text/javascript">
<!--
var board_skin_url = '{$board_skin_url}';
//-->
</script>
HEREDOC;

add_stylesheet($str);