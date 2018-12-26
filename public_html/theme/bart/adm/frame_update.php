<?php
include_once('./_common.php');

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

use kr\bartnet as bt;

function buildData(){
    $arr = $_POST;
    unset(
        $arr['fs_idx'],
        $arr['actmode'],
        $arr['fs_skin'],
        $arr['fs_path'],
        $arr['fs_mtype'],
        $arr['fs_mid']
    );
    return @json_encode($arr);
}

$actmode = $_REQUEST["actmode"];


switch($actmode){
    case 'edit':
    
        $arr = array();
        $arr['fs_skin'] = $_POST["fs_skin"];
        $arr['fs_path'] = '';
        $arr['fs_mtype'] = '';
        $arr['fs_mid'] = '';
        
        if($_POST['fs_private']=='1'){
            $arr['fs_path'] = $_POST["fs_path"];
            $arr['fs_mtype'] = $_POST["fs_mtype"];
            $arr['fs_mid'] = $_POST["fs_mid"];
        }else{
            $Q = "DELETE FROM ".$bt['frame_table']."
            WHERE fs_skin='".$_POST['fs_skin']."'
            AND fs_path='".$_POST['fs_path']."'
            AND fs_mtype='".$_POST['fs_mtype']."'
            AND fs_mid='".$_POST['fs_mid']."'
            AND fs_private='1' LIMIT 1";
            sql_query($Q);
        }
        
        $arr['fs_private'] = $_POST['fs_private'];
        $arr['fs_config'] = buildData();
        $arr['fs_regdate'] = G5_TIME_YMDHIS;


        $Q = "SELECT * FROM ".$bt['frame_table']."
            WHERE fs_skin='".$arr['fs_skin']."'
            AND fs_path='".$arr['fs_path']."'
            AND fs_mtype='".$arr['fs_mtype']."'
            AND fs_mid='".$arr['fs_mid']."'
            AND fs_private='".$arr['fs_private']."' LIMIT 1";
        $rs = sql_fetch($Q);
        
        //존재하면 수정
        if($rs){
            $bdb->update($bt['frame_table'], $arr, 'fs_idx='.$rs["fs_idx"]);

        //존재하지 않으면 삽입
        }else{
            $bdb->insert($bt['frame_table'], $arr);
        }
        
    break;
    
    
    case 'del':
        
        $Q = "DELETE FROM ".$bt['frame_table']." WHERE fs_idx=".$_GET["fs_idx"];
        sql_query($Q);
        
    break;
    
    
    /*case 'new':
        $arr = array();
        $arr['fs_skin'] = $_POST["fs_skin"];
        if($_POST['fs_private']=='1'){
            $arr['fs_path'] = $_POST["fs_path"];
            $arr['fs_mtype'] = $_POST["fs_mtype"];
            $arr['fs_mid'] = $_POST["fs_mid"];
        }
        $arr['fs_private'] = $_POST['fs_private'];
        $arr['fs_config'] = buildData();
        $arr['fs_regdate'] = G5_TIME_YMDHIS;
        $bdb->insert($bt['frame_table'], $arr);
        
    break;*/
}

echo <<<HEREDOC
<script type="text/javascript">
opener.document.location.reload();
window.close();
</script>
HEREDOC;
?>