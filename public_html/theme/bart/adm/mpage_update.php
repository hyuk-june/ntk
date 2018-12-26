<?php
$sub_menu = "801403";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

use kr\bartnet as bt;

if($w=='u' || $w==''){
    $pg_id = $_POST["pg_id"];
    $pg_module = $_POST["pg_module"];
    $pg_title = $_POST["pg_title"];
    $pg_subtitle = $_POST["pg_subtitle"];
    $pg_keyword = $_POST["pg_keyword"];
    $pg_desc = $_POST["pg_desc"];
    $pg_skin_frame = $_POST["pg_skin_frame"];
    $pg_skin_layout = $_POST["pg_skin_layout"];
    $pg_level_min = $_POST["pg_level_min"];
    $pg_level_max = $_POST["pg_level_max"];
    
    unset($_POST["token"]);
    unset($_POST["pg_id"]);
    unset($_POST["pg_module"]);
    unset($_POST["pg_title"]);
    unset($_POST["pg_subtitle"]);
    unset($_POST["pg_keyword"]);
    unset($_POST["pg_desc"]);
    unset($_POST["pg_skin_frame"]);
    unset($_POST["pg_skin_layout"]);
    unset($_POST["pg_level_min"]);
    unset($_POST["pg_level_max"]);
    
    unset($_POST["w"]);
    
    $pg_config = @json_encode($_POST);
}



switch($w){
    case 'u':
        if(!bt\isval($pg_id)){
            alert("아이디값이 없습니다");
        }
        
        $sql = "UPDATE ".$bt['page_table']." SET
            pg_module='".$pg_module."',
            pg_title='".$pg_title."',
            pg_subtitle='".$pg_subtitle."',
            pg_keyword='".$pg_keyword."',
            pg_desc='".$pg_desc."',
            pg_skin_frame='".$pg_skin_frame."',
            pg_skin_layout='".$pg_skin_layout."',
            pg_level_min='".$pg_level_min."',
            pg_level_max='".$pg_level_max."',
            pg_config = '".$pg_config."'
            WHERE pg_id='".$pg_id."'";
            
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
    
        if(!bt\isval($pg_id)){
            alert("아이디값이 없습니다");
        }
    
        $sql = "SELECT count(*) as cnt FROM ".$bt['page_table']." WHERE pg_id='".$pg_id."'";
        $rs = sql_fetch($sql);
        if((int)$rs["cnt"] > 0){
            alert("이미 존재하는 페이지아이디입니다\n페이지아이디는 페이지,위젯페이지,모듈페이지 모두에서 유일한 값이어야 합니다");
        }
    
        $sql = "INSERT INTO ".$bt['page_table']." SET
            pg_id='".$pg_id."',
            pg_type='mpage',
            pg_module='".$pg_module."',
            pg_title='".$pg_title."',
            pg_subtitle='".$pg_subtitle."',
            pg_keyword='".$pg_keyword."',
            pg_desc='".$pg_desc."',
            pg_skin_frame='".$pg_skin_frame."',
            pg_skin_layout='".$pg_skin_layout."',
            pg_config = '".$pg_config."',
            pg_level_min='".$pg_level_min."',
            pg_level_max='".$pg_level_max."',
            pg_regdate='".G5_TIME_YMDHIS."'";
        sql_query($sql);
    break;
}

goto_url("mpage_list.php");