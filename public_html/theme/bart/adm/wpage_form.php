<?php
$sub_menu = "801402";
include_once("./_common.php");

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '위젯페이지관리';
$administrator = 1;


//프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);

//레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);

//위젯페이지 스킨
$dir = BT_SKIN_PATH.'/wpage';
$wpage_s = bt\get_select($dir);

$pg_id = bt\varset($_GET["pg_id"]);

$w = "";
$view = array();
if(bt\isval($pg_id)){
    $sql = "SELECT * FROM ".$bt["page_table"]." WHERE pg_id='".$pg_id."'";
    $view = sql_fetch($sql);
    $w = "u";
    
    $frame_s->selectedFromValue = $view["pg_skin_frame"];
    $layout_s->selectedFromValue = $view["pg_skin_layout"];
    $wpage_s->selectedFromValue = $view["pg_skin_wpage"];
}

$g5['title'] = '위젯페이지설정';
$administrator = 1;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.BT_ADMIN_URL.'/style.css" />');
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style type="text/css">
#rowlist .row-prop{margin:4px 0; padding: 4px; border:1px solid #ddd;}
#rowlist .row-prop input[type="text"]{ height:28px; width:100%;}
#rowlist .cells{display:flex;}
#rowlist .cell{padding:10px; text-align:center; border:1px solid #ddd; flex-grow:1;}
#rowlist .cell-css{width:100%;}
#rowlist td{padding:4px;}
#rowlist td input[type="text"]{height:28px;}
</style>

<form name="fwpageform" id="fwpageform" action="./wpage_update.php" onsubmit="return fwpageform_submit(this)" method="post">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="pg_id" value="<?php echo $pg_id?>">
<section>
    <h2 class="h2_frm">위젯페이지 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
    
        <table>
        <caption>위젯페이지 설정</caption>
        <colgroup>
            <col class="grid_4">
            <col>
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
                <select name="pg_skin_frame" class="required" required="required"><?php echo $frame_s->getOption()?></select>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="pg_skin_layout">레이아웃</label></th>
            <td>
                <select name="pg_skin_layout" class="required" required="required"><?php echo $layout_s->getOption()?></select>
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
        <tr>
            <th scope="row">위젯컨테이너<br>레이아웃</th>
            <td>
                <div class="my-2">
                    <button type="button" class="btn btn_03" id="btn_add_row">행 추가</button>
                    <?php echo help('※ 한 행안에서 넓이의 총합은 12가 되어야 합니다. 각 열의 넓이는 12에서 분할해 입력해 주세요.')?>
                    <?php echo help('※ Bootstrap 의 Grid 옵션을 참조해 주세요 &lt;<a href="https://getbootstrap.com/docs/4.1/layout/grid/" target="_blank">참조</a>&gt;');?>
                    <?php echo help('※ "기본"만 입력하시면 모든 기기사이즈에서 동일한 레이아웃으로 출력됩니다.')?>
                </div>
                <ul id="rowlist">
                </ul>
                
            </td>
        </tr>
        </tbody>
        </table>
        
    </div>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="./wpage_list.php">목록</a>
</div>
</form>





<?php
//수정때 레이아웃 입력폼 복원을 위한 값
$layout_data = '';
if(bt\isval($view['pg_config'])){
    $layout_data = bt\is_json($view['pg_config']) ? $view['pg_config'] : '{}';
}
?>

<!-- javascript 에 필요한 값 -->
<div id="layout_data" style="display:none"><?php echo $layout_data?></div>
<!-- //javascript 에 필요한 값 -->

<script type="text/javascript">
<!--
//var layout_data = JSON.parse('<?php echo $layout_data?>');

var _layout = function(_container){
    
    var container = $(_container);
    
    $(document).on('click', '.btn-del-row', function(){
        var idx = $('.btn-del-row').index(this);
        removeRow(idx);
    });
    
    $(document).on('click', '.btn-add-cell', function(){
        var idx = $('.btn-add-cell').index(this);
        console.log(idx);
        appendCol(idx);
    });
    
    $(document).on('click', '.btn-del-cell', function(){
        var idx = $('.btn-del-cell').index(this);
        removeCol(idx);
    });
    
    $(document).on('click', '.btn-stepup-row', function(){
        var idx = $('.btn-stepup-row').index(this);
        stepUp(idx);
    });
    
    $(document).on('click', '.btn-stepdn-row', function(){
        var idx = $('.btn-stepdn-row').index(this);
        stepDown(idx);
    });
    
    function setData(data){
        data = JSON.parse(data);
        
        $(data).each(function(i, row){
            appendRow(row);
        });
    }
    
    function appendRow(row){
        var cellcnt = 1;
        //console.log(cells);
        
        var rowid = createCode();
        var rowcss = '';
        if(row !== undefined){
            cellcnt = row.cols.length;
            rowid = row.rowid;
            rowcss = row.css !== undefined ? row.css : '';
            //console.log(rowid);
        }
        //console.log(cells);
        //console.log(cellcnt);
        
        var color = getRandomColor();
        
        var str = '<li class="row my-1 p-2" data-rowid="' + rowid + '">';
        str += '<button type="button" class="btn btn_02 btn-del-row mr-1">행 삭제</button>';
        str += '<button type="button" class="btn btn_01 btn-add-cell mr-1">열 추가</button>';
        str += '<button type="button" class="btn btn_01 btn-del-cell mr-1">열 삭제</button>';
        str += '<button type="button" class="btn btn_02 btn-stepup-row mr-1"><i class="fa fa-arrow-up"></i></button>';
        str += '<button type="button" class="btn btn_02 btn-stepdn-row mr-1"><i class="fa fa-arrow-down"></i></button>';
        str += 'Row ID: <strong>' + rowid + '</strong>';
        str += '<div class="row-prop">';
        str += '<span>행 CSS (선택사항) </span><input type="text" name="css[' + rowid + ']" class="row-css frm_input" value="' + rowcss + '"> ';
        str += '</div>';
        str += '<div class="cells mt-1">';
        str += '</div>';
        str += '</li>';
        
        container.append(str);
        
        //컬럼 생성
        var rowidx = $('.row', container).size()-1;
        
        for(var i=0; i<cellcnt; i++){
            var col = row !== undefined ? row.cols[i] : null;
            appendCol(rowidx, col);
        }
    }
    
    function removeRow(idx){
        $('.row', container).eq(idx).remove();
    }
    
    function appendCol(rowidx, _cell){
        //console.log(cell);
        var row = $('.row', container).eq(rowidx);
        
        var rowid = $(row).data('rowid');
        
        if($('.cell', row).size() >= 4){
            alert('4개 이상 추가할 수 없습니다');
            return;
        }
        
        
        var cell = {
            xs:{
                value: '',
                hide: false,
            },
            sm:{
                value: '',
                hide: false,
            },
            md:{
                value: '',
                hide: false,
            },
            lg:{
                value: '',
                hide: false,
            },
            xl:{
                value: '',
                hide: false,
            },
            css: ''
        }
        
        //기본값
        if(_cell !== undefined){
            cell = $.extend({}, cell, _cell);
        }
        //console.log(cell.css);
        
        
        //사이즈별 루프를 위한 값
        var types = [
            {
                size: 'xs',
                label: '기본',
            },
            {
                size: 'sm',
                label: '&ge;576px'
            },
            {
                size: 'md',
                label: '&ge;768px'
            },
            {
                size: 'lg',
                label: '&ge;992px'
            },
            {
                size: 'xl',
                label: '&ge;1200px'
            },
        ];
        
        var cellidx = $('.cell', row).size();
        
        var str = '<div class="cell mr-1">';
        str += '<table>';
        str += '<thead>';
        str += '<tr><th>화면크기</td><th>비율(x/12)</td><th>숨김</th></tr>';
        str += '</thead>';
        str += '<tbody>';
        str += '<tr>';
        
        
        $(types).each(function(i, e){
            
            var cls = '';
            var attr = '';
            if(e.size == 'xs'){
                cls = ' required';
                attr = ' required="required"';
            }
            
            var cell_value = cell[e.size].value;
            var hide_value = cell[e.size].hide;
            
            str += '<tr>';
            str += '    <th scope="row"><label for="col_' + rowid + '_' + e.size + '_' + cellidx + '">' + e.label + '</label></th>';
            str += '    <td><input type="text" name="col_' + e.size + '[' + rowid + '][' + cellidx + ']" id="col_' + rowid + '_xs_' + cellidx + '" class="frm_input' + cls + '"' + attr + ' size="4" value="' + cell_value + '"></td>';
            str += '    <td><input type="checkbox" name="hide_' + e.size + '[' + rowid + '][' + cellidx + ']" id="hide_' + rowid + '_xs_' + cellidx + '" value="1"' + (hide_value == true ? ' checked="checked"' : '') + '></td>';
            str += '</tr>';
        });
        
        
        str += '<tr>';
        str += '<th scope="row"><label for="col_css_' + rowid + '_' + cellidx + '">열 CSS</label></th>';
        str += '<td colspan="2"><input type="text" name="col_css[' + rowid + '][' + cellidx + ']" id="col_css_' + rowid + '_' + cellidx + '" class="cell-css frm_input" value="' + cell.css + '"></td>';
        str += '</tr>';
        
        str += '</tbody>';
        str += '</table>';
        str += '</div>';
        
        $('.cells', row).append(str);
    }
    
    function removeCol(idx){
        var row = $('.row', container).eq(idx);
        if($('.cell', row).size() <= 1){
            alert('최소한 하나의 열은 존재하여야 합니다');
            return;
        }
        $('.cell', row).last().remove();
    }
    
    function stepUp(idx){
        var row = $('.row', container).eq(idx);
        row.prev().before(row);
    }
    
    function stepDown(idx){
        var row = $('.row', container).eq(idx);
        row.next().after(row);
    }
    
    function createCode() {
        // I generate the UID from two parts here 
        // to ensure the random number provide enough bits.
        var firstPart = (Math.random() * 46656) | 0;
        var secondPart = (Math.random() * 46656) | 0;
        firstPart = ("000" + firstPart.toString(36)).slice(-3);
        secondPart = ("000" + secondPart.toString(36)).slice(-3);
        return (firstPart + secondPart).toLowerCase();
    }
    
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    
    return {
        setData: setData,
        appendRow: appendRow,
        removeRow: removeRow,
        appendCol: appendCol,
        removeCol: removeCol,
        stepUp: stepUp,
        stepDown: stepDown
    }
};


function fwpageform_submit(f){
    if($('#rowlist').children().size() <= 0){
        alert('위젯컨테이너 레이아웃에는 최소한 하나의 행은 존재해야 합니다');
        return false;
    }
}


var layout = _layout('#rowlist');

$(document).ready(function(){
    $('#btn_add_row').click(function(){
        layout.appendRow();
    });
    
    var data = $('#layout_data').text();
    
    if($.trim(data)!=''){
        layout.setData(data);
    }else{
        layout.appendRow();
    }
    
    
});




//-->
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');