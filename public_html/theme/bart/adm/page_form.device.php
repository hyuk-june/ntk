<?php
$sub_menu = "801401";
include_once("./_common.php");
include_once(G5_EDITOR_LIB);

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '페이지관리';
$administrator = 1;


// 프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);
$mframe_s = bt\get_select($dir);

// 레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);
$mlayout_s = bt\get_select($dir);

$pg_id = bt\varset($_GET["pg_id"]);

$w = "";
if(bt\isval($pg_id)){
    $sql = "SELECT * FROM ".$bt["page_table"]." WHERE pg_id='".$pg_id."'";
    $view = sql_fetch($sql);
    $w = "u";
    
    $frame_s->selectedFromValue = $view["pg_skin_frame"];
    $mframe_s->selectedFromValue = $view["pg_skin_mframe"];
    $layout_s->selectedFromValue = $view["pg_skin_layout"];
    $mlayout_s->selectedFromValue = $view["pg_skin_mlayout"];
}

$editor_js = '';
$editor_js .= get_editor_js('pg_content');
$editor_js .= chk_editor_js('pg_content');

$editor_js2 = '';
$editor_js2 .= get_editor_js('pg_mcontent');
$editor_js2 .= chk_editor_js('pg_mcontent');


$g5['title'] = '페이지설정';
$administrator = 1;
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style type="text/css">
#fpageform .tbl_frm01 th{width:100px !important;}
</style>

<form name="fpageform" id="fpageform" action="./page_update.php" onsubmit="return fpageform_submit(this)" method="post">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="pg_id" value="<?php echo $pg_id?>">
<section>
    <h2 class="h2_frm">페이지 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
    
        <table>
        <caption>페이지 설정</caption>
        <colgroup>
            <col class="grid_2">
            <col class="grid_7">
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="pg_id">페이지아이디</label></th>
            <td><input type="text" name="pg_id" id="pg_id" value="<?php echo $view["pg_id"]?>"<?php echo $w=="u" ? 'disabled="disabled"':""?> class="required frm_input" size="20"></td>
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
                PC: <select name="pg_skin_frame" class="required" required="required"><?php echo $frame_s->getOption()?></select>
                모바일: <select name="pg_skin_mframe" class="required" required="required"><?php echo $mframe_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_skin_layout">레이아웃</label></th>
            <td>
                PC: <select name="pg_skin_layout" class="required" required="required"><?php echo $layout_s->getOption()?></select>
                모바일: <select name="pg_skin_mlayout" class="required" required="required"><?php echo $mlayout_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_content">PC내용</label></th>
            <td colspan="2">
                <?php echo editor_html("pg_content", $view['pg_content'], true); ?>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_mcontent">모바일내용</label></th>
            <td colspan="2">
                <span class="frm_info">입력하지 않았을 시 PC내용이 출력됩니다</span>
                <?php echo editor_html("pg_mcontent", $view['pg_mcontent'], true); ?>
            </td>
        </tr>
        <tr>
            <th scope="row">접근레벨</th>
            <td>
                <input type="text" name="pg_level_min" value="<?php echo bt\binstr($view["pg_level_min"], 1);?>" size="4" required="required" class="required frm_input">
                ~
                <input type="text" name="pg_level_max" value="<?php echo bt\binstr($view["pg_level_max"], 10)?>" size="4" required="required" class="required frm_input">
            </td>
        </tr>
        </tbody>
        </table>
        
    </div>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./page_list.php">목록</a>
</div>
</form>

<script type="text/javascript">
<!--
function fpageform_submit(f){
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
    <?php //echo $editor_js2; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
    
    return true;
}
//-->
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');