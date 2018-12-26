<?php
namespace kr\bartnet\alim;

use kr\bartnet as bt;


/**
* @bref 안 읽은 알림 메세지 리턴
* @return array
**/
function get_latest_alim(){
    global $alcfg, $member;
    
    $arr = array();
    $sql = "SELECT * FROM ".$alcfg['alim_table']." WHERE al_mb_id='".$member['mb_id']."' AND al_read='n' ORDER BY al_regdate DESC";
    $result = sql_query($sql);
    $arr = array();
    while($rs = sql_fetch_array($result)) $arr[] = $rs;
    return $arr;
}


/**
* @bref 알림등록
* @param string 회원아이디
* @param string 링크주소
* @param string 알림메세지
**/
function write_alim($mb_id, $url, $msg){    
    global $alcfg;
    
    $sql = "INSERT INTO ".$alcfg['alim_table']."(al_mb_id, al_url, al_memo, al_regdate) VALUES(
            '".btesc($mb_id)."',
            '".btesc($url)."',
            '".btesc($msg)."',
            '".date('Y-m-d H:i:s')."');";
            
    
            
    sql_query($sql);
    
    echo $sql;
    exit;
}

