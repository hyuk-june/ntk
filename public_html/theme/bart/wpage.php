<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
define('_INDEX_', true);

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_type='wpage' AND pg_id='".$mid."'";
$pgrow = $bdb->fetch($sql);

if(!$pgrow){
    alert('해당 페이지가 존재하지 않습니다');
}

if($member['mb_level'] < $pgrow['pg_level_min'] || $member['mb_level'] > $pgrow['pg_level_max']){
    if(!$is_member){
        goto_url(G5_BBS_URL.'/login.php?url='.urlencode($_SERVER["REQUEST_URI"]));
    }else{
        alert('접근 권한이 없습니다');
    }
}

$frame_skin = ""; //프레임 스킨
$layout_skin = ""; //레이아웃 스킨
$wpage_skin = ""; //위젯페이지 스킨
$skin_path = ""; //위젯페이지 스킨경로
$skin_url = ""; //위젯페이지 스킨url

$frame_skin = bt\binstr($pgrow['pg_skin_frame'], "basic");
$layout_skin = bt\binstr($pgrow['pg_skin_layout'], "basic");
$wpage_skin = bt\binstr($pgrow['pg_skin_wpage'], "basic");

$skin_path = BT_SKIN_PATH.'/wpage/'.$wpage_skin;
$skin_url = BT_SKIN_URL.'/wpage/'.$wpage_skin;

//===========================================================================
// 메뉴에 속하지 않아서 제목, description 이 없으면 page테이블에서 직접 불러온다
//===========================================================================
//if(!is_array($bt['curpath']) || count($bt['curpath']) <= 0){
    $cur_title = bt\binstr($pgrow["pg_title"], $g5['title']);
    $cur_subtitle = $pgrow["pg_subtitle"];
    $cur_keyword = $pgrow["pg_keyword"];
    $cur_desc = $pgrow["pg_desc"];
//}

$g5['title'] = $cur_title;

$pg_id = $pgrow["pg_id"];

include_once('./_head.php');

include_once("wpage.inc.php");

include_once('./_tail.php');