<?php
$sub_menu = "801403";
include_once("./_common.php");

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '모듈페이지관리';
$administrator = 1;

//===========================================================================
// selectbox 정리
//===========================================================================

//프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);

//레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);

//모듈 옵션
$dir = BT_MODULE_PATH;
$dirs = array();
bt\file\BFiledir::getDirEntry($dirs, $dir, 'd', 1);
sort($dirs);
$module_s = new bt\html\BSelectbox();
foreach($dirs as $key=>$val){
    $val = basename($val);
    if(substr($val, 0, 1)=='_') continue; // '_'가 붙은 모듈은 시스템 모듈임
    else $text = $val;
    
    $module_s->add(basename($val), $text);
}


//===========================================================================
// 기존 데이타 로딩
//===========================================================================
$pg_id = bt\varset($_GET["pg_id"]);

$w = "";
if(bt\isval($pg_id)){
    $sql = "SELECT * FROM ".$bt["page_table"]." WHERE pg_id='".$pg_id."'";
    $view = sql_fetch($sql);
    $w = "u";
    
    $frame_s->selectedFromValue = $view["pg_skin_frame"];
    $layout_s->selectedFromValue = $view["pg_skin_layout"];
    $module_s->selectedFromValue = $view['pg_module'];
}

$g5['title'] = '모듈페이지설정';
$administrator = 1;
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style type="text/css">
#fmpageform .tbl_frm01 th{width:100px !important;}
</style>

<form name="fmpageform" id="fmpageform" action="./mpage_update.php" onsubmit="return fmpageform_submit(this)" method="post">
<input type="hidden" name="w" id="w" value="<?php echo $w ?>">
<input type="hidden" name="pg_id" id="pg_id" value="<?php echo $pg_id?>">
<section>
    <h2 class="h2_frm">모듈페이지 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
    
        <table>
        <caption>모듈페이지 설정</caption>
        <colgroup>
            <col class="grid_2">
            <col class="grid_7">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="pg_id">페이지아이디</label></th>
            <td><input type="text" name="pg_id" id="pg_id" value="<?php echo $view["pg_id"]?>"<?php echo $w=="u" ? 'disabled="disabled"':""?> class="required frm_input" size="50"></td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_title">페이지제목</label></th>
            <td><input type="text" name="pg_title" id="pg_title" value="<?php echo $view["pg_title"]?>" class="required frm_input" required="required" size="70"></td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_subtitle">부제목</label></th>
            <td><input type="text" name="pg_subtitle" id="pg_subtitle" value="<?php echo $view["pg_subtitle"]?>" class="frm_input" size="70"></td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_keyword">Keyword</label></th>
            <td><input type="text" name="pg_keyword" id="pg_keyword" value="<?php echo $view["pg_keyword"]?>" class="frm_input" style="width:100%"></td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_desc">Description</label></th>
            <td><input type="text" name="pg_desc" id="pg_desc" value="<?php echo $view["pg_desc"]?>" class="frm_input" style="width:100%"></td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_skin_frame">프레임</label></th>
            <td>
                <select name="pg_skin_frame" id="pg_skin_frame" class="required" required="required"><?php echo $frame_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_skin_layout">레이아웃</label></th>
            <td>
                <select name="pg_skin_layout" id="pg_skin_layout" class="required" required="required"><?php echo $layout_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row">접근레벨</th>
            <td>
                <input type="text" name="pg_level_min" id="pg_level_min" value="<?php echo bt\binstr($view["pg_level_min"], 1);?>" size="4" required="required" class="required frm_input">
                ~
                <input type="text" name="pg_level_max" id="pg_level_max" value="<?php echo bt\binstr($view["pg_level_max"], 10)?>" size="4" required="required" class="required frm_input">
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_skin_layout">모듈</label></th>
            <td>
                <select name="pg_module" id="pg_module" class="required" required="required"><?php echo $module_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_setup">모듈설정</label></th>
            <td>
                <div id="md_setup_wrap">
                </div>
            </td>
        </tr>
        </tbody>
        </table>
        
    </div>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./mpage_list.php">목록</a>
</div>
</form>

<script type="text/javascript">
<!--
function loadModuleSetupForm(){
    var module = $('#pg_module').val();
    var pg_id = $('#pg_id').val();
    if(module == '') return;

    $('#md_setup_wrap').load(
        '<?php echo BT_ADMIN_URL?>/module_option.php?module=' + module + '&pg_id=' + pg_id,
        function(responseText, statusText, xhr){
            if(statusText == "success"){
                $('#md_setup_wrap').html(responseText);
            }else{
                alert('모듈 로딩에 실패 했습니다');
            }
        }
    );
}

$(function(){
    loadModuleSetupForm();
    $('#pg_module').change(loadModuleSetupForm);
});
//-->
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');