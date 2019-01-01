<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

include_once('lib/board.lib.php');

//게시판 추가설정 불러오기
$bcfg = btbo\get_config($bo_table);

//옵션불러오기
$opts = btbo\load_option($bo_table, $wr_id);

//===========================================================================
// 포인트 다시 정리
//===========================================================================
//다운로드 개별 포인트가 입력되어 있으면
if(bt\isval($opts['point_down'][$no]) && (int)$opts['point_down'][$no] > 0){
    $board['bo_download_point'] = abs($opts['point_down'][$no]) * -1;
}


//===========================================================================
// 작성자에게 포인트 리워드
//===========================================================================
//세션이 있으면 통과

if (get_session($ss_name)) return;

//작성자가 회원이 아니라면 통과
if(!bt\isval($write['mb_id'])) return;

//작성자가 자신이거나 관리자라면 통과
if (($write['mb_id'] && $write['mb_id'] == $member['mb_id']) || $is_admin) return;

//보상포인트율이 설정되지 않았으면 통과
if(!bt\isval($bcfg['reward_point']) || (int)$bcfg['reward_point'] <= 0) return;


//보상포인트 계산
$reward_point = round(abs($board['bo_download_point']) / $bcfg['reward_point']);

//포인트 지급
insert_point($write['mb_id'], $reward_point, "{$board['bo_subject']} $wr_id 파일 다운로드 보상", $bo_table, $wr_id, "다운로드보상");