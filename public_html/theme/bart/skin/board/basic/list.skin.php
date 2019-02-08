<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
add_javascript('<script type="text/javascript" src="'.$board_skin_url.'/js/board.js"></script>');
include_once($board_skin_path.'/lib/board.lib.php');

//게시판 추가 설정
include_once('board.cmm.php');

$ca_style = array();

if(bt\isval($bcfg['ca_type']) && bt\isval($categories)){
    $ca_cnt = count($categories);

    if($bcfg['ca_type']=='both'){
        $width = 100 / ($ca_cnt+1);
        $ca_style[] = 'width:'.$width.'%';
    }else if($bcfg['ca_type']=='divide' && (int)bt\varset($bcfg['ca_col_cnt']) > 0){
        $width = 100 / $bcfg['ca_col_cnt'];
        $ca_style[] = 'width:'.$width.'%';
    }
}
$s_ca_style = '';
if(count($ca_style) > 0) $s_ca_style = @implode(';', $ca_style);

$str = <<< HEREDOC
<style type="text/css">
#bo_cate_ul {overflow:hidden;}
#bo_cate_ul li{float:left;{$s_ca_style};}
</style>
HEREDOC;

add_stylesheet($str);
?>

<?php
//목록 위젯
if(!$wr_id){
    echo btb\show_widgets(__FILE__, $bo_table, "board_top");
}
?>

<!-- 게시판 목록 시작 { -->
<div class="bt-board p-1 p-sm-0">

    <!-- //게시판 페이지 정보 및 버튼 끝 -->

    <?php include_once($sub_paths['list'].'/list.sub.skin.php');?>

    <?php if($is_checkbox) { ?>
    <noscript>
    <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
    </noscript>
    <?php } ?>

</div>


<?php
if(!$wr_id){
    echo btb\show_widgets(__FILE__, $bo_table, "board_bot");
}
?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        $('#btn_submit').val('선택복사');
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        $('#btn_submit').val('선택이동');
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
        $('#btn_submit').val('선택삭제');
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
