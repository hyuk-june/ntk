<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_member){
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode($_SERVER["REQUEST_URI"]));
}

//===========================================================================
// 목록
//===========================================================================
// 설정일이 지난 메모 삭제
$sql = "DELETE FROM ".$alcfg['alim_table']."
    WHERE mb_id='".$member['mb_id']."'
    AND al_regdate < '".date("Y-m-d H:i:s", G5_SERVER_TIME - (86400 * $alcfg['delete_day']))."' ";

sql_query($sql);


$sql_search = " WHERE mb_id='".$member['mb_id']."'";
if (bt\isval($stx)) {

    $sql_search .= " AND ( ";
    switch ($sfl) {
        default :
            $sql_search .= " ({$sfl} LIKE '%{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

$sql = "SELECT count(*) as cnt FROM ".$alcfg['alim_table'].$sql_search;
$temp = sql_fetch($sql);
$total_count = $temp['cnt'];

$rows = $alcfg['page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if (!$page) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = "SELECT * FROM ".$alcfg['alim_table'].$sql_search." ORDER BY al_regdate DESC LIMIT ".$from_record.", ".$rows;
$result = sql_query($sql);

$list = array();
for($i=0;$row = sql_fetch_array($result);$i++){
    $row['readstr'] = $row['al_read']=='1' ? '읽음' : '안읽음';
    $row['regdate'] = btb\get_date_tostr($row['al_regdate']);
    $row['alink']    = $module_self_url.'&act=gourl&al_idx='.$row['al_idx'];
    $list[] = $row;
}

//스킨경로
$module_skin_path = $module_path.'/skin/basic';
$module_skin_url = $module_url.'/skin/basic';

include_once($module_skin_path.'/alim.skin.php');