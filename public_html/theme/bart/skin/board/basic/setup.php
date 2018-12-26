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
body{background-color:#f5f5f5;}
.table{background-color:#fff; margin:0;}
.sec-title{border-bottom:2px solid #aaa !important; border-top:1px solid #aaa !important; background-color:#e1e1e1}
th{width:120px}
td{}

#tbl_ropt th, #tbl_ropt td{padding:.2rem; text-align:center;}
#tbl_ropt .btn {padding:.1rem .2rem !important;}
</style>

<script type="text/javascript" src="<?php echo $board_skin_url?>/js/board.js"></script>
<script type="text/javascript">
<!--
var board_skin_url = '<?php echo $board_skin_url?>';
var bo_table = '<?php echo $bo_table?>';


var optmgr = function(){
    var gidx = 0;
        
    function createCode() {
        // I generate the UID from two parts here 
        // to ensure the random number provide enough bits.
        var firstPart = (Math.random() * 46656) | 0;
        var secondPart = (Math.random() * 46656) | 0;
        firstPart = ("000" + firstPart.toString(36)).slice(-3);
        secondPart = ("000" + secondPart.toString(36)).slice(-3);
        return (firstPart + secondPart).toUpperCase();
    }
    
    function createGroup(item){
        
        var opt_step = '';
        var opt_code = '';
        var opt_name = '';
        var opt_type = '';
        var opt_value = '';
        var opt_attr = '';
        var opt_help = '';
        var opt_tpl = '';
        
        //console.log(createCode());
        
        if(item !== undefined){
            opt_step = item.step !== undefined && item.step.trim() != '' ? item.step : '';
            opt_code = item.code !== undefined && item.code.trim() != '' ? item.code : '';//createCode();
            opt_name = item.name !== undefined && item.name.trim() != '' ? item.name : '';
            opt_type = item.type !== undefined && item.type.trim() != '' ? item.type : '';
            opt_value = item.value !== undefined && item.value.trim() != '' ? item.value : '';
            opt_attr = item.attr !== undefined && item.attr.trim() != '' ? item.attr : '';
            opt_help = item.help !== undefined && item.help.trim() != '' ? item.help : '';
            opt_tpl = item.tpl !== undefined && item.tpl.trim() != '' ? item.tpl : '';
        }else{
            opt_code = '';//createCode();
        }
        
        var str = '<tr>';
        str += '<td><input type="text" name="opt_step[]" value="' + opt_step + '" size="4"></td>';
        str += '<td><input type="text" name="opt_code[]" value="' + opt_code + '" size="10"></td>';
        str += '<td><input type="text" name="opt_name[]" class="required" required="required" value="' + opt_name + '"></td>';
        
        str += '<td>';
        str += '<select name="opt_type[]">';
        str += '<option value="text"';
        str += opt_type=='text' ? ' selected="selected"' : '';
        str += '>Text</option>' ;
        str += '<option value="textbox"';
        str += opt_type=='textbox' ? ' selected="selected"' : '';
        str += '>TextBox</option>' ;
        str += '<option value="checkbox"';
        str += opt_type=='checkbox' ? ' selected="selected"' : '';
        str += '>Checkbox</option>';
        str += '<option value="radio"';
        str += opt_type=='radio' ? ' selected="selected"' : '';
        str += '>Radio</option>';
        str += '<option value="select"';
        str += opt_type=='select' ? ' selected="selected"' : '';
        str += '>Select</option>';
        str += '</td>';
        
        str += '<td><input type="text" name="opt_value[]" value="' + opt_value + '"></td>';
        str += '<td><input type="text" name="opt_attr[]" class="" value="' + opt_attr + '"></td>';
        str += '<td><input type="text" name="opt_help[]" class="" value="' + opt_help + '"></td>';
        str += '<td><input type="text" name="opt_tpl[]" class="" value="' + opt_tpl + '"></td>';
        str += '<td><button type="button" class="btn btn-opt-del">삭제</button></td>';
        
        str += '</tr>';
        
        gidx++;
        
        return $(str);
    }
    
    return {
        createGroup: createGroup
    }
}

var om = optmgr();

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
    
    $('#btn_opt_add').click(function(){
        var grp = om.createGroup();
        $('#ropt').append(grp);
    });
    
    $(document).on('click', '.btn-opt-del', function(){
        var idx = $('#ropt tr').index($(this).parent().parent());
        $('#ropt tr').eq(idx).remove();
    });
    
    $('.db-opt-name').each(function(i, e){
        var item = {
            step: $('.db-opt-step').eq(i).val(),
            code: $('.db-opt-code').eq(i).val(),
            name: $('.db-opt-name').eq(i).val(),
            type: $('.db-opt-type').eq(i).val(),
            value: $('.db-opt-value').eq(i).val(),
            attr: $('.db-opt-attr').eq(i).val(),
            help: $('.db-opt-help').eq(i).val(),
            tpl: $('.db-opt-tpl').eq(i).val(),
        }
        var grp = om.createGroup(item);
        $('#ropt').append(grp);
    });
});
//-->
</script>

<?php if(isset($bcfg['opt_name']) && is_array($bcfg['opt_name'])){?>
    <?php for($i=0; $i<count($bcfg["opt_name"]); $i++){?>
<input type="hidden" name="opt_step[]" class="db-opt-step" value="<?php echo $bcfg["opt_step"][$i]?>">
<input type="hidden" name="opt_code[]" class="db-opt-code" value="<?php echo $bcfg["opt_code"][$i]?>">
<input type="hidden" name="opt_name[]" class="db-opt-name" value="<?php echo $bcfg["opt_name"][$i]?>">
<input type="hidden" name="opt_type[]" class="db-opt-type" value="<?php echo $bcfg["opt_type"][$i]?>">
<input type="hidden" name="opt_value[]" class="db-opt-value" value="<?php echo $bcfg["opt_value"][$i]?>">
<input type="hidden" name="opt_attr[]" class="db-opt-attr" value="<?php echo $bcfg["opt_attr"][$i]?>">
<input type="hidden" name="opt_help[]" class="db-opt-help" value="<?php echo $bcfg["opt_help"][$i]?>">
<input type="hidden" name="opt_tpl[]" class="db-opt-tpl" value="<?php echo $bcfg["opt_tpl"][$i]?>">
    <?php }?>
<?php }?>

<h1 class="popup-title">게시판 추가설정</h1>

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
</tbody>
</table>
<!--
<table class="table table-bordered mb-10">
<thead>
<tr>
    <th colspan="2" class="sec-title">추가입력사항&nbsp;<button type="button" id="btn_opt_add" class="btn btn-success">추가</button></th>
</tr>
</thead>
<tbody>
<tr>
    <td>
        <div class="form-text text-muted">복수의 옵션은 '|'문자로 구분해 주세요</div>
        <div class="form-text text-muted">- 옵션예) 빨강|노랑|초록</div>
        <div class="form-text text-muted">- 옵션예) 1000^1,000원|2000^2,000원|3000^3,000원</div>
        <div class="form-text text-muted">값템플릿: 예)"나의 이름은 {:value:}입니다"일 경우 {:value:}가 입력값으로 치환됩니다</div>
        <div class="form-text text-muted">여러개의 제약속성은 쉽표(,)로 구분해 주세요</div>
        <div class="form-text text-muted"><a data-toggle="collapse" href="#vdlist" role="button" aria-expanded="false" aria-controls="vdlist">제약속성 보기</a></div>
        <div id="vdlist" class="collapse">
            <div class="card">
                <div class="card-body">
                    <fieldset>
                        <legend>제약속성</legend>
                        <ul>
                            <li><strong>required:true</strong> - 필수입력</li>
                            <li><strong>equal:['엘리먼트 id']</strong> - 두값이 동일해야 함</li>
                            <li><strong>minlen:[n]</strong> - 최소입력 글자 수</li>
                            <li><strong>maxlen:[n]</strong> - 최대입력 글자 수</li>
                            <li><strong>email:true</strong> - 이메일 형식</li>
                            <li><strong>korean:true</strong> - 한글만 입력 가능</li>
                            <li><strong>memberid:true</strong> - 회원아이디 형식</li>
                            <li><strong>nospace:true</strong> - 공백포함불가</li>
                            <li><strong>numeric:true</strong> - 숫자만 입력</li>
                            <li><strong>alpha:true</strong> - 영문자만 입력</li>
                            <li><strong>alpha_numeric:true</strong> - 영문자,숫자만 입력</li>
                            <li><strong>phone:true</strong> - 전화번호 형식</li>
                            <li><strong>korean_alpha_numeric:true</strong> - 한글,영문,숫자만 가능</li>
                            <li><strong>groupcheck:true</strong> - 최소 한개이상 선택</li>
                            <li><strong>unique:[url]</strong> - 중복체크(url의 결과값: {success:[true|false],message:null})</li>
                        </ul>
                    </fieldset>
                </div>
            </div>
        </div>
        <table class="table" id="tbl_ropt">
        <thead>
        <tr>
            <th>순서</th>
            <th>코드</th>
            <th>제목</th>
            <th>입력타입</th>
            <th>옵션</th>
            <th>제약속성</th>
            <th>도움말</th>
            <th>값템플릿</th>
            <th>삭제</th>
        </tr>
        </thead>
        <tbody id="ropt">
        </tbody>
        </table>
    </td>
</tr>
</tbody>
</tr>
</table>
//-->

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



<div class="text-center">
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