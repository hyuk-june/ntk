<?php
$sub_menu = "801402";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

use kr\bartnet as bt;

function buildColumnData(){
    
    $i=0;
    $arr = array();
    //행갯수만큼 루프
    foreach($_POST["col_xs"] as $rowid => $xs){
        
        $sm = $_POST["col_sm"][$rowid];
        $md = $_POST["col_md"][$rowid];
        $lg = $_POST["col_lg"][$rowid];
        $xl = $_POST["col_xl"][$rowid];
        
        $hide_xs = $_POST["hide_xs"][$rowid];
        $hide_sm = $_POST["hide_sm"][$rowid];
        $hide_md = $_POST["hide_md"][$rowid];
        $hide_lg = $_POST["hide_lg"][$rowid];
        $hide_xl = $_POST["hide_xl"][$rowid];
        
        $cell_css = $_POST["col_css"][$rowid];
        
        $arr[$i] = array('rowid' => $rowid, 'css' => $_POST['css'][$rowid], 'cols' => array());
        
        
        //칼럼갯수만큼 후프
        for($j=0; $j<count($xs); $j++){
            $arr[$i]['cols'][] = array(
                'xs' => array('value' => $xs[$j], 'hide' => $hide_xs[$j]),
                'sm' => array('value' => $sm[$j], 'hide' => $hide_sm[$j]),
                'md' => array('value' => $md[$j], 'hide' => $hide_md[$j]),
                'lg' => array('value' => $lg[$j], 'hide' => $hide_lg[$j]),
                'xl' => array('value' => $xl[$j], 'hide' => $hide_xl[$j]),
                'css' => $cell_css[$j]
            );
        }
        $i++;
    }
    
    return @json_encode($arr);
}

switch($w){
    case 'u':
        if(!bt\isval($_POST["pg_id"])){
            alert("아이디값이 없습니다");
        }
        
        $pg_config = buildColumnData();
        
        $sql = "UPDATE ".$bt['page_table']." SET
            pg_title='".$_POST["pg_title"]."',
            pg_subtitle='".$_POST["pg_subtitle"]."',
            pg_keyword='".$_POST["pg_keyword"]."',
            pg_desc='".$_POST["pg_desc"]."',
            pg_skin_frame='".$_POST["pg_skin_frame"]."',
            pg_skin_layout='".$_POST["pg_skin_layout"]."',
            pg_skin_wpage='".$_POST["pg_skin_wpage"]."',
            pg_config = '".$pg_config."',
            pg_level_min='".$_POST["pg_level_min"]."',
            pg_level_max='".$_POST["pg_level_max"]."'
            WHERE pg_id='".$_POST["pg_id"]."'";
            
        sql_query($sql);
    break;
    
    
    case 'd':
        if(!bt\isval($_GET["pg_id"])){
            alert("아이디값이 없습니다");
        }
        
        $sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_id='".$_GET["pg_id"]."'";
        $rs = sql_fetch($sql);
        if($rs['pg_system']=='1'){
            alert('해당 항목은 기본페이지이므로 삭제할 수 없습니다');
        }
        
        //위젯삭제
        $sql = "DELETE FROM ".$bt['widget_table']." WHERE wp_id='".$_GET["pg_id"]."'";
        sql_query($sql);
                
        //위젯페이지 삭제
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
            $pg_skin_wpage = $_POST["pg_skin_wpage"][$k];
            $pg_level_min = $_POST["pg_level_min"][$k];
            $pg_level_max = $_POST["pg_level_max"][$k];
            
            $sql = "UPDATE ".$bt['page_table']." SET
                pg_skin_frame='".$pg_skin_frame."',
                pg_skin_layout='".$pg_skin_layout."',
                pg_skin_wpage='".$pg_skin_wpage."',
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
            
            $sql = "DELETE FROM ".$bt['widget_table']." WHERE wp_id IN('".$sidx."')";
            sql_query($sql);
            
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
        
        $pg_config = buildColumnData();
        
        $sql = "INSERT INTO ".$bt['page_table']." SET
            pg_id='".$_POST["pg_id"]."',
            pg_type='wpage',
            pg_title='".$_POST["pg_title"]."',
            pg_subtitle='".$_POST["pg_subtitle"]."',
            pg_keyword='".$_POST["pg_keyword"]."',
            pg_desc='".$_POST["pg_desc"]."',
            pg_skin_frame='".$_POST["pg_skin_frame"]."',
            pg_skin_layout='".$_POST["pg_skin_layout"]."',
            pg_skin_wpage='".$_POST["pg_skin_wpage"]."',
            pg_config = '".$pg_config."',
            pg_level_min='".$_POST["pg_level_min"]."',
            pg_level_max='".$_POST["pg_level_max"]."',
            pg_regdate='".G5_TIME_YMDHIS."'";
        sql_query($sql);
    break;
}

goto_url("wpage_list.php");