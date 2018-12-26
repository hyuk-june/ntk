<?php
$sub_menu = "801401";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

use kr\bartnet as bt;

switch($w){
    case 'u':
        if(!bt\isval($_POST["pg_id"])){
            alert("아이디값이 없습니다");
        }
        
        $sql = "UPDATE ".$bt['page_table']." SET
            pg_title='".$_POST["pg_title"]."',
            pg_subtitle='".$_POST["pg_subtitle"]."',
            pg_keyword='".$_POST["pg_keyword"]."',
            pg_desc='".$_POST["pg_desc"]."',
            pg_skin_frame='".$_POST["pg_skin_frame"]."',
            pg_skin_layout='".$_POST["pg_skin_layout"]."',
            pg_content='".$_POST["pg_content"]."',
            pg_level_min='".$_POST["pg_level_min"]."',
            pg_level_max='".$_POST["pg_level_max"]."'
            WHERE pg_id='".$_POST["pg_id"]."'";
        sql_query($sql);
    break;
    
    
    case 'd':
        if(!bt\isval($_GET["pg_id"])){
            alert("아이디값이 없습니다");
        }
        
        $sql = "DELETE FROM ".$bt['page_table']." WHERE pg_id='".$_GET["pg_id"]."'";
        sql_query($sql);
    break;
    
    
    case 'mu':
        for ($i=0; $i<count($_POST['chk']); $i++) {
            
            // 실제 번호를 넘김
            $k = $_POST['chk'][$i];
            
            $pg_id = $_POST['pg_id'][$k];
            $pg_skin_frame = $_POST["pg_skin_frame"][$k];
            $pg_skin_layout = $_POST["pg_skin_layout"][$k];
            $pg_level_min = $_POST["pg_level_min"][$k];
            $pg_level_max = $_POST["pg_level_max"][$k];
            
            $sql = "UPDATE ".$bt['page_table']." SET
                pg_skin_frame='".$pg_skin_frame."',
                pg_skin_layout='".$pg_skin_layout."',
                pg_level_min='".$pg_level_min."',
                pg_level_max='".$pg_level_max."'
                WHERE pg_id='".$pg_id."'";
            sql_query($sql);
        }
    
    break;
    
    case 'md':
        $aidx = array();
        for ($i=0; $i<count($_POST['chk']); $i++) {
            
            // 실제 번호를 넘김
            $k = $_POST['chk'][$i];
            
            $aidx[] = $_POST['pg_id'][$k];
        }
        
        if(count($aidx) > 0){
            $sidx = @implode("','", $aidx);
            $sql = "DELETE FROM ".$bt['page_table']." WHERE pg_id IN('".$sidx."')";
            sql_query($sql);
        }
    break;
    
    
    case '':
    
        if(!bt\isval($_POST["pg_id"])){
            alert("아이디값이 없습니다");
        }
    
        $sql = "SELECT count(*) as cnt FROM ".$bt['page_table']." WHERE pg_id='".$_POST["pg_id"]."'";
        $rs = sql_fetch($sql);
        if((int)$rs["cnt"] > 0){
            alert("이미 존재하는 아이디입니다");
        }
    
        $sql = "INSERT INTO ".$bt['page_table']." SET
            pg_id='".$_POST["pg_id"]."',
            pg_type='page',
            pg_title='".$_POST["pg_title"]."',
            pg_subtitle='".$_POST["pg_subtitle"]."',
            pg_keyword='".$_POST["pg_keyword"]."',
            pg_desc='".$_POST["pg_desc"]."',
            pg_skin_frame='".$_POST["pg_skin_frame"]."',
            pg_skin_layout='".$_POST["pg_skin_layout"]."',
            pg_content='".$_POST["pg_content"]."',
            pg_level_min='".$_POST["pg_level_min"]."',
            pg_level_max='".$_POST["pg_level_max"]."',
            pg_regdate='".G5_TIME_YMDHIS."'";
        sql_query($sql);
    break;
}

goto_url("page_list.php");