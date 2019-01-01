<?php
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_admin){
    alert_close("권한이 없습니다");
}
if(!$wg_idx){
    alert_close("잘못된 경로로 접근했습니다");
}

$actmode = bt\varset($_REQUEST["actmode"]);
$wg_idx = bt\varset($_REQUEST["wg_idx"]);

$sql = "SELECT * FROM ".$bt["widget_table"]." WHERE wg_idx=".$wg_idx;
$rs = sql_fetch($sql);

$wcfg = @json_decode($rs["wg_data"], true);
$wcfg = array_map_deep('stripslashes', $wcfg);
if(!is_array($wcfg)) $wcfg = array();

$widget_path = BT_WIDGET_PATH.'/'.$rs["wg_name"];
$widget_url = BT_WIDGET_URL.'/'.$rs["wg_name"];


if($actmode=="save"){
    
    $wg_margin = @implode('|', $_POST["wg_margin"]);
    $wg_padding = @implode('|', $_POST["wg_padding"]);
    $wg_class = $_POST["wg_class"];
    $wg_attr = $_POST["wg_attr"];
    
    unset($_POST["actmode"]);
    unset($_POST["wg_idx"]);
    unset($_POST["wg_margin"]);
    unset($_POST["wg_padding"]);
    unset($_POST["wg_class"]);
    unset($_POST["wg_attr"]);
    
    @include_once($widget_path.'/widget.setup.before.php');
    
    $wg_data = @json_encode($_POST);
    
    $arr = array();
    $arr['wg_step'] = $_POST["wg_step"];
    $arr['wg_data'] = $wg_data;
    $arr['wg_margin'] = $wg_margin;
    $arr['wg_padding'] = $wg_padding;
    $arr['wg_class'] = $wg_class;
    $arr['wg_attr'] = $wg_attr;
    $arr['wg_isset'] = '1';
    $bdb->update($bt["widget_table"], $arr, "wg_idx=".$wg_idx);
    
    @include_once($widget_path.'/widget.setup.after.php');
    
    echo <<<HEREDOC
    <script type="text/javascript">
    opener.document.location.reload();
    window.close();
    </script>
HEREDOC;
    exit;
}else if($actmode=="del"){
    if(!bt\isval($wg_idx)){
        alert('입력값이 잘못되었습니다');
        exit;
    }
    $sql = "DELETE FROM ".$bt["widget_table"]." WHERE wg_idx=".$wg_idx;
    
    $bdb->query($sql);
        echo <<<HEREDOC
    <script type="text/javascript">
    opener.document.location.reload();
    window.close();
    </script>
HEREDOC;
    exit;
}



$g5['title'] = $rs['wg_name'].' [ '.trim($rs['wp_id'].' - '.$rs['wg_id'], ' -').' ] 위젯설정';

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.BT_ADMIN_URL.'/style.css" />');
include(G5_PATH.'/head.sub.php');

function zeroset($var){
    if(trim($var)=='') $var = '0';
    return $var;
}

$wg_margin = explode("|", $rs["wg_margin"]);
$wg_padding = explode("|", $rs["wg_padding"]);
?>

<form id="frm_widget" action="widget_setup.php" method="post">
<input type="hidden" name="actmode" id="actmode" value="save">
<input type="hidden" name="wg_idx" id="wg_idx" value="<?php echo $wg_idx?>">

<style type="text/css">
.new_win{padding:4px;}
th, td{border:1px solid #ddd !important; padding:6px;}
tbody th{width:120px;}
table{margin-bottom:10px}
.new_win{margin-bottom:10px;}
h1{padding:10px; font-size:18px; color:#fff; background:#333; border-bottom:2px solid #000; min-width:0;}
</style>

<h1><?php echo $g5['title']; ?></h1>

<div class="new_win">
    <table>
    <thead>
    <tr>
        <th>순서</th>
        <td colspan="4"><input type="text" name="wg_step" id="wg_step" value="<?php echo $rs['wg_step']?>" size="4" required="required" class="required frm_input"></td>
    </tr>
    <tr>
        <th>여백</th>
        <th>상</th>
        <th>우</th>
        <th>하</th>
        <th>좌</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th>외부</th>
        <td><input type="text" name="wg_margin[]" size="6" value="<?php echo bt\binstr($wg_margin[0],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_margin[]" size="6" value="<?php echo bt\binstr($wg_margin[1],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_margin[]" size="6" value="<?php echo bt\binstr($wg_margin[2],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_margin[]" size="6" value="<?php echo bt\binstr($wg_margin[3],'0')?>" required="required" class="required frm_input">px</td>
    </tr>
    <tr>
        <th>내부</th>
        <td><input type="text" name="wg_padding[]" size="6" value="<?php echo bt\binstr($wg_padding[0],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_padding[]" size="6" value="<?php echo bt\binstr($wg_padding[1],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_padding[]" size="6" value="<?php echo bt\binstr($wg_padding[2],'0')?>" required="required" class="required frm_input">px</td>
        <td><input type="text" name="wg_padding[]" size="6" value="<?php echo bt\binstr($wg_padding[3],'0')?>" required="required" class="required frm_input">px</td>
    </tr>
    <tr>
        <th>CSS 클래스</th>
        <td colspan="4">
            <input type="text" name="wg_class" id="wg_class" class="frm_input" style="width:100%" value="<?php echo bt\varset($rs['wg_class'])?>">
            <?php echo help('위젯을 둘러싸고 있는 엘리먼트에 CSS 클래스를 지정할 수 있습니다<br>BootStrap4의 CSS클래스를 지원합니다');?>
        </td>
    </tr>
    <tr>
        <th>애트리뷰트</th>
        <td colspan="4">
            <input type="text" name="wg_attr" id="wg_attr" class="frm_input" style="width:100%" value="<?php echo bt\varset($rs['wg_attr'])?>">
            <?php echo help('위젯을 둘러싸고 있는 엘리먼트에 기타 속성태그를 지정할 수 있습니다
                거의 사용할 일이 없기는 합니다
                예) data-widget-name="나의위젯"');?>
        </td>
    </tr>
    <tr>
        <th>이미지파일관리</th>
        <td colspan="4">
            <strong>[<a href="#" id="btn_fmgr">이미지파일 매니저</a>]</strong>
            이미지가 필요할 경우 업로드 후 URL 복사하여 사용하세요
        </td>
    </tr>
    </tbody>
    </table>
    
    <?php @include_once($widget_path.'/widget.setup.php');?>
</div>

<div class="btn_confirm01 btn_confirm text-center">
    <input type="submit" value="확인" class="btn_submit" accesskey="s" style="user-select: auto;">
    <a href="#" onclick="delCheck('<?php echo $wg_idx?>');">삭제</a>
    <a href="#" onclick="window.close()">취소</a>
</div>
</form>

<script type="text/javascript">
<!--
function delCheck(wg_idx){
    if(!confirm('정말 삭제할까요?')) return;
    location.href='?actmode=del&wg_idx=' + wg_idx;
}

$(document).ready(function(){
    $('#btn_fmgr').click(function(e){
        e.preventDefault();
        window.open(g5_url + '/index.php?mtype=module&mid=_filemanager', 'fmgr_win', 'width=810, height=800, scrollbars=no');
    })
});
//-->
</script>

<?php
include(G5_PATH.'/tail.sub.php');