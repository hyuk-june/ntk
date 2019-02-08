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
$list_hide_writer = true;
$list_hide_datetime = true;
$list_hide_hit = true;
$list_hide_good = false;
$list_hide_nogood = false;

//읽기 필드출력 여부
$write_hide_writer = true;
$write_hide_datetime = true;
$write_hide_hit = true;
$write_hide_cmtcnt = true;

if(count($bcfg) > 0){
    $list_hide_writer = isset($bcfg['list_hide_writer']) ? true : false;
    $list_hide_datetime = isset($bcfg['list_hide_datetime']) ? true : false;
    $list_hide_hit = isset($bcfg['list_hide_hit']) ? true : false;
    $list_hide_good = isset($bcfg['list_hide_good']) ? true : false;
    $list_hide_nogood = isset($bcfg['list_hide_nogood']) ? true : false;

    $write_hide_writer = isset($bcfg['write_hide_writer']) ? true : false;
    $write_hide_datetime = isset($bcfg['write_hide_datetime']) ? true : false;
    $write_hide_hit = isset($bcfg['write_hide_hit']) ? true : false;
    $write_hide_cmtcnt = isset($bcfg['write_hide_cmtcnt']) ? true : false;
}



$str = <<< HEREDOC
<script type="text/javascript">
<!--
var board_skin_url = '{$board_skin_url}';
//-->
</script>
HEREDOC;

add_stylesheet($str);