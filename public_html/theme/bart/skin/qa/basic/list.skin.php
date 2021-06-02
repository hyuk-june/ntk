<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 6;

if ($is_checkbox) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<div class="qa-list p-1 p-sm-0">
    <?php if ($category_option) { ?>
    <!-- 카테고리 시작 { -->
    <nav class="mb-2">
        <h2 class="d-none"><?php echo $qaconfig['qa_title'] ?> 카테고리</h2>
        <ul id="bo_cate" class="flex flex-wrap">
            <?php echo $category_option ?>
        </ul>
    </nav>
    <!-- } 카테고리 끝 -->
    <?php } ?>

     <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="flex justify-between mb-2">
        <div>
            <span>Total <?php echo number_format($total_count) ?>건</span>
            <?php echo $page ?> 페이지
        </div>

        <?php if ($admin_href || $write_href) { ?>
        <ul class="flex justify-end">
            <?php if ($admin_href) { ?><li><a href="<?php echo $admin_href ?>" class="btn btn-sm btn-danger mr-1">관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-sm btn-primary">문의등록</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fqalist" id="fqalist" action="./qadelete.php" class="mb-2" onsubmit="return fqalist_submit(this);" method="post">
    
        <input type="hidden" name="stx" value="<?php echo $stx; ?>">
        <input type="hidden" name="sca" value="<?php echo $sca; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">

        <div class="list-wrap mb-2">
            <div class="list-head">
                <div class="list-row">
                    <div class="list-cell list-cell-num">번호</div>
            <?php if ($is_checkbox) { ?>
                    <div class="list-cell list-cell-chk">
                        <label for="chkall" class="sound_only">현재 페이지 게시물 전체</label>
                        <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);">
                    </div>
            <?php } ?>
                    <div class="list-cell list-cell-cate">분류</div>
                    <div class="list-cell list-cell-subject">제목</div>
                    <div class="list-cell list-cell-writer">글쓴이</div>
                    <div class="list-cell list-cell-status">상태</div>
                    <div class="list-cell list-cell-datetime">등록일</div>
                </div>
            </div>
            
            <ul class="list-body">
        <?php
        for ($i=0; $i<count($list); $i++) {
        ?>
                <li class="list-row">
                    <div class="list-cell list-cell-num"><?php echo $list[$i]['num']; ?></div>
            <?php if ($is_checkbox) { ?>
                    <div class="list-cell list-cell-chk">
                        <label for="chk_qa_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject']; ?></label>
                        <input type="checkbox" name="chk_qa_id[]" value="<?php echo $list[$i]['qa_id'] ?>" id="chk_qa_id_<?php echo $i ?>">
                    </div>
            <?php } ?>
                    <div class="list-cell list-cell-cate"><?php echo $list[$i]['category']; ?></div>
                    <div class="list-cell list-cell-subject">
                        <a href="<?php echo $list[$i]['view_href']; ?>">
                            <?php echo $list[$i]['subject']; ?>
                        </a>
                        <?php echo $list[$i]['icon_file']; ?>
                    </div>
                    <div class="list-cell list-cell-writer"><?php echo $list[$i]['name']; ?></div>
                    <div class="list-cell list-cell-status td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></div>
                    <div class="list-cell list-cell-datetime"><?php echo $list[$i]['date']; ?></div>
                </li>
        <?php
        }
        ?>
            

        <?php if ($i == 0) { echo '<li class="list-row"><div class="list-cell cell-empty">게시물이 없습니다.</div></li>'; } ?>
            </ul>
        </div>
    

        <div class="flex justify-between">
            <?php if ($is_checkbox) { ?>
            <ul>
                <li><input type="submit" name="btn_submit" class="btn btn-sm btn-danger" value="선택삭제" onclick="document.pressed=this.value"></li>
            </ul>
            <?php } ?>

            <ul class="flex">
                <?php if ($list_href) { ?><li class="mr-1"><a href="<?php echo $list_href ?>" class="btn btn-sm btn-dark">목록</a></li><?php } ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-sm btn-primary">문의등록</a></li><?php } ?>
            </ul>
        </div>

    </form>


    <?php if($is_checkbox) { ?>
    <noscript>
    <p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
    </noscript>
    <?php } ?>

    <!-- 페이지 -->
    <div class="text-center mb-2">
        <?php echo preg_replace('/(\.php)(&amp;|&)/i', '$1?', btb\get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './qalist.php'.$qstr.'&amp;page=') );?>
    </div>

    <!-- 게시판 검색 시작 { -->

    <form name="fsearch" method="get" class="flex justify-center">
        <div class="input-group input-group-sm col-sm-3">
            <input type="hidden" name="sca" value="<?php echo $sca ?>">
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" id="stx" required  class="required form-control form-control-sm" size="15" maxlength="15">
            <div class="input-group-append">
                <input type="submit" value="검색" class="btn btn-sm btn-dark">
            </div>
        </div>
        
    </form>

    <!-- } 게시판 검색 끝 -->
    
</div>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fqalist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]")
            f.elements[i].checked = sw;
    }
}

function fqalist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_qa_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다"))
            return false;
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->