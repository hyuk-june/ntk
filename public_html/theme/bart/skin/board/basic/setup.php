<?php
include_once("./_common.php");
include_once("./lib/board.lib.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

$bo_table = $_REQUEST["bo_table"];

include_once("board.cmm.php");

$actmode = bt\varset($_POST["actmode"]);

if($actmode=="save"){
    
    $bo_table = $_POST["bo_table"];
    
    unset($_POST["actmode"]);
    unset($_POST["bo_table"]);
    btbo\set_config($bo_table, $_POST);
    
    goto_url('setup.php?bo_table='.$bo_table);
}

include_once(G5_PATH.'/head.sub.php');

$dir = $board_skin_path.'/list';
$skin_list_s = bt\get_select($dir);

$dir = $board_skin_path.'/view';
$skin_view_s = bt\get_select($dir);

$dir = $board_skin_path.'/write';
$skin_write_s = bt\get_select($dir);

if(bt\isval($bcfg['skin_list'])){
    $skin_list_s->selectedFromValue = $bcfg['skin_list'];
}else{
    $skin_list_s->selectedFromValue = 'basic';
}
if(bt\isval($bcfg['skin_view'])){
    $skin_view_s->selectedFromValue = $bcfg['skin_view'];
}else{
    $skin_view_s->selectedFromValue = 'basic';
}
if(bt\isval($bcfg['skin_write'])){
    $skin_write_s->selectedFromValue = $bcfg['skin_write'];
}else{
    $skin_write_s->selectedFromValue = 'basic';
}

$s = new bt\html\BSelectbox();
$s->add('normal', '일반형');
$s->add('both', '전체채움');
$s->add('divide', '컬럼갯수지정');
if(bt\isval($bcfg['ca_type'])){
    $s->selectedFromValue = $bcfg['ca_type'];
}
$ca_type_opt = $s->getOption();
?>

<style type="text/css">
.table{background-color:#fff; margin:0;}
.sec-title{border-bottom:2px solid #aaa !important; border-top:1px solid #aaa !important; background-color:#e1e1e1}
th{width:120px}
select{height:26px;}
</style>

<script type="text/javascript" src="<?php echo $board_skin_url?>/js/board.js"></script>
<script type="text/javascript">
<!--
var board_skin_url = '<?php echo $board_skin_url?>';
var bo_table = '<?php echo $bo_table?>';

$(function(){
    $('.skin').each(function(i, e){
        var skin = $(e).val();
        var mode = $(e).data('mode');
        Bt.board.loadSetupSkin(bo_table, mode, skin);
    });
   
    $('.skin').change(function(){
        var skin = $(this).val();
        var mode = $(this).data('mode');
        Bt.board.loadSetupSkin(bo_table, mode, skin);
    });
    
    $('#btn_close').click(function(){
        window.close();
    });
});
//-->
</script>

<h1 class="popup-title mb-0">게시판 추가설정</h1>

<form id="frm_setup" action="setup.php" method="post" class="mb-5">
<input type="hidden" name="actmode" value="save">
<input type="hidden" name="bo_table" value="<?php echo $bo_table?>">
<table class="table table-bordered mb-10">
<thead>
<tr>
    <th colspan="2" class="sec-title">기본설정</th>
</tr>
</thead>
<tbody>
<tr>
    <th>카테고리타입</th>
    <td>
        <select name="ca_type">
            <?php echo $ca_type_opt?>
        </select>
        <input type="text" name="ca_col_cnt" value="<?php echo bt\varset($bcfg['ca_col_cnt'])?>" size="4" class="text-right">개
    </td>
</tr>
<tr>
    <th>개별포인트사용</th>
    <td>
        <div>
            <input type="checkbox" name="use_point_down" id="use_point_down" value="1"<?php echo $bcfg['use_point_down']=='1' ? ' checked="checked"' : '';?>>
            <label for="use_point_down">다운로드에 개별포인트를 사용합니다</label>
        </div>
    </td>
</tr>
<tr>
    <th>보상포인트률</th>
    <td>
        <input type="text" name="reward_point" value="<?php echo $bcfg['reward_point']?>" size="5"> %
        <div class="form-text text-muted">개별포인트사용시 작성자에게 돌려줄 포인트율(%)입니다</div>
    </td>
</tr>
</tbody>
</table>

<table class="table table-bordered">
<thead>
<tr>
    <th colspan="2" class="sec-title">목록스킨</th>
</tr>
</thead>
<tbody>
<tr>
    <th>스킨선택</th>
    <td>
        <select name="skin_list" id="skin_list" class="skin" data-mode="list">
            <?php echo $skin_list_s->getOption();?>
        </select>
    </td>
</tr>
</tbody>
</table>

<div id="skin_list_wrap" class="skin-opt ma-t-10 ma-b-20"></div>


<table class="table table-bordered">
<thead>
<tr>
    <th colspan="2" class="sec-title">내용스킨</th>
</tr>
</thead>
<tbody>
<tr>
    <th>스킨선택</th>
    <td>
        <select name="skin_view" id="skin_view" class="skin" data-mode="view">
            <?php echo $skin_view_s->getOption();?>
        </select>
    </td>
</tr>
</tbody>
</table>

<div id="skin_view_wrap" class="skin-opt ma-t-10 ma-b-20"></div>



<table class="table table-bordered">
<thead>
<tr>
    <th colspan="2" class="sec-title">쓰기스킨</th>
</tr>
</thead>
<tbody>
<tr>
    <th>스킨선택</th>
    <td>
        <select name="skin_write" id="skin_write" class="skin" data-mode="write">
            <?php echo $skin_write_s->getOption();?>
        </select>
    </td>
</tr>
</tbody>
</table>

<div id="skin_write_wrap" class="skin-opt ma-t-10 ma-b-20"></div>



<div class="text-center mt-5">
    <button type="submit" id="btn_submit" class="btn bg-BlackLight">확인</button>
    <button type="button" id="btn_close" class="btn bg-BlackLight">닫기</button>
</div>
</form>

<script type="text/javascript">
<!--
$(function(){
    $('#btn_vdlist').toggle('#vdlist');
});
//-->
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');