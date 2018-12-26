<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;

// 선택삭제으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_admin) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$new_skin_url.'/style.css">', 0);

$gr_s = new bt\html\BSelectbox();

//그룹 셀렉트 쿼리 다시(그누보드에서 태그수정의 기회를 안준다 ㅜㅜ)
$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
$result = sql_query($sql);
$gr_s->add('', '= 전체그룹 =');
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $gr_s->add($row['gr_id'], $row['gr_subject']);
}
?>

<div class="newpost table-type">

    <!-- 전체게시물 검색 시작 { -->
    
    <form name="fnew" method="get" class="d-flex justify-content-center border mb-3">
        <div class="row col-sm-10 p-2 mb-0">
            <div class="col-6 col-sm-3 mb-2 mb-sm-0">
                <select name="gr_id" id="gr_id" class="form-control form-control-sm">
                    <?php echo $gr_s->getOption();?>
                </select>
            </div>
            <div class="col-6 col-sm-3 mb-2 mb-sm-0">
                <select name="view" id="view" class="form-control form-control-sm">
                    <option value="">전체게시물</option>
                    <option value="w">원글만</option>
                    <option value="c">코멘트만</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 mb-2 mb-sm-0">
                <label for="mb_id" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                <input type="text" name="mb_id" value="<?php echo $mb_id ?>" id="mb_id" required="required" class="required form-control form-control-sm">
            </div>
            <div class="col-6 col-sm-3 mb-2 mb-sm-0">
                <input type="submit" value="회원아이디검색" class="btn btn-sm btn-dark btn-block">
            </div>
        </div>
    </form>
    <script>
    document.getElementById("gr_id").value = "<?php echo $gr_id ?>";
    document.getElementById("view").value = "<?php echo $view ?>";
    </script>
    <!-- } 전체게시물 검색 끝 -->

    
    <!-- 전체게시물 목록 시작 { -->
    <form name="fnewlist" method="post" action="#" onsubmit="return fnew_submit(this);">
    <input type="hidden" name="sw"       value="move">
    <input type="hidden" name="view"     value="<?php echo $view; ?>">
    <input type="hidden" name="sfl"      value="<?php echo $sfl; ?>">
    <input type="hidden" name="stx"      value="<?php echo $stx; ?>">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table; ?>">
    <input type="hidden" name="page"     value="<?php echo $page; ?>">
    <input type="hidden" name="pressed"  value="">

    <div class="list-wrap mb-2">
        <div class="list-head">
            <div class="list-row d-none d-sm-table-row">
                <?php if ($is_admin) { ?>
                <div class="list-cell list-cell-chk">
                    <label for="all_chk" class="sound_only">목록 전체</label>
                    <input type="checkbox" id="all_chk">
                </div>
                <?php } ?>
                <div class="list-cell list-cell-grp">그룹</div>
                <div class="list-cell list-cell-board">게시판</div>
                <div class="list-cell list-cell-subject">제목</div>
                <div class="list-cell list-cell-writer">이름</div>
                <div class="list-cell list-cell-datetime">일시</div>
            </div>
            <div class="list-row d-block d-sm-none">
                <div class="list-cell text-center">새 글</div>
            </div>
        </div>
        <ul class="list-body">
        <?php
        for ($i=0; $i<count($list); $i++)
        {
            $num = $total_count - ($page - 1) * $config['cf_page_rows'] - $i;
            $gr_subject = cut_str($list[$i]['gr_subject'], 20);
            $bo_subject = cut_str($list[$i]['bo_subject'], 20);
            $wr_subject = get_text(cut_str($list[$i]['wr_subject'], 80));
        ?>
            <li class="list-row">
                <?php if ($is_admin) { ?>
                <div class="list-cell list-cell-chk">
                    <label for="chk_bn_id_<?php echo $i; ?>" class="sound_only"><?php echo $num?>번</label>
                    <input type="checkbox" name="chk_bn_id[]" value="<?php echo $i; ?>" id="chk_bn_id_<?php echo $i; ?>">
                    <input type="hidden" name="bo_table[<?php echo $i; ?>]" value="<?php echo $list[$i]['bo_table']; ?>">
                    <input type="hidden" name="wr_id[<?php echo $i; ?>]" value="<?php echo $list[$i]['wr_id']; ?>">
                </div>
                <?php } ?>
                <div class="list-cell list-cell-grp"><a href="./new.php?gr_id=<?php echo $list[$i]['gr_id'] ?>" class="text-success"><?php echo $gr_subject ?></a></div>
                <div class="list-cell list-cell-board"><a href="./board.php?bo_table=<?php echo $list[$i]['bo_table'] ?>" class="text-info"><?php echo $bo_subject ?></a></div>
                <div class="list-cell list-cell-subject"><a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['comment'] ?><?php echo $wr_subject ?></a></div>
                <div class="list-cell list-cell-writer"><div><?php echo $list[$i]['name'] ?></div></div>
                <div class="list-cell list-cell-datetime"><?php echo $list[$i]['datetime2'] ?></div>
            </li>
        <?php }  ?>
        </ul>
        
    </div>
    
    <?php if ($i == 0){?>
    <div class="py-5 mb-2 border text-center">게시물이 없습니다.</div>
    <?php }?>

    <?php if ($is_admin) { ?>
    <div>
        <input type="submit" onclick="document.pressed=this.value" value="선택삭제" class="btn btn-sm btn-danger">
    </div>
    <?php } ?>
    </form>
    
</div>

<?php if ($is_admin) { ?>
<script>
$(function(){
    $('#all_chk').click(function(){
        $('[name="chk_bn_id[]"]').attr('checked', this.checked);
    });
});

function fnew_submit(f)
{
    f.pressed.value = document.pressed;

    var cnt = 0;
    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_bn_id[]" && f.elements[i].checked)
            cnt++;
    }

    if (!cnt) {
        alert(document.pressed+"할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if (!confirm("선택한 게시물을 정말 "+document.pressed+" 하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다")) {
        return false;
    }

    f.action = "./new_delete.php";

    return true;
}
</script>
<?php } ?>

<?php echo $write_pages ?>
<!-- } 전체게시물 목록 끝 -->