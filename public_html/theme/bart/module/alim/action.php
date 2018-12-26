<?php
include_once("./_common.php");

include_once('lib/alim.lib.php');

if(!$is_member){
    goto_url(G5_BBS_URL.'/login.php?url='.urlencode($_SERVER["REQUEST_URI"]));
}


switch ($act) {
case "gourl":

    if(trim($_GET['al_idx']) == '') alert('잘못된 접근방법입니다');

    //읽음 표시
    $sql = "UPDATE ".$alcfg['alim_table']." SET al_read='1' WHERE al_idx=".$_GET['al_idx'];
    sql_query($sql);

    $sql = "SELECT * FROM ".$alcfg['alim_table']." WHERE al_idx=".$_GET['al_idx'];
    $row = sql_fetch($sql);

    if(!$row) alert('알림메세지가 존재하지 않습니다');

    goto_url($row['al_url']);

    break;
    
case "del":
    if(count($_POST['chk_al_idx']) > 0){
        $idxs = @implode(',', $_POST['chk_al_idx']);
        $sql = "DELETE FROM ".$alcfg['alim_table']." WHERE al_idx IN(".$idxs.");";
        sql_query($sql);
    }
    
    goto_url($module_self_url);

    break;
    
case "read":
    if(count($_POST['chk_al_idx']) > 0){
        $idxs = @implode(',', $_POST['chk_al_idx']);
        
        $sql = "UPDATE ".$alcfg['alim_table']." SET al_read='1' WHERE al_idx IN(".$idxs.");";
        sql_query($sql);
    }
    
    goto_url($module_self_url);
    
    break;
}