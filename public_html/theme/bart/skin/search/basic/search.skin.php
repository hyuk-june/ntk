<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$search_skin_url.'/style.css">', 0);

$group_select = '<label for="gr_id" class="sound_only">게시판 그룹선택</label><select name="gr_id" id="gr_id" class="form-control"><option value="">전체 분류';
$sql = " select gr_id, gr_subject from {$g5['group_table']} order by gr_id ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++)
    $group_select .= "<option value=\"".$row['gr_id']."\"".get_selected($_GET['gr_id'], $row['gr_id']).">".$row['gr_subject']."</option>";
$group_select .= '</select>';
?>

<!-- 전체검색 시작 { -->
<div class="card">
    <div class="card-body">
        <form name="fsearch" class="form" onsubmit="return fsearch_submit(this);" method="get">
        <input type="hidden" name="srows" value="<?php echo $srows ?>">

            <div class="form-row items-center">
                <div class="col-6 col-sm-2 mb-2 mb-sm-0">
                    <?php echo $group_select ?>
                    <script>document.getElementById("gr_id").value = "<?php echo $gr_id ?>";</script>
                </div>
                
                <div class="col-6 col-sm-3 mb-2 mb-sm-0">
                    <label for="sfl" class="sound_only">검색조건</label>
                    <select name="sfl" id="sfl" class="form-control">
                        <option value="wr_subject||wr_content"<?php echo get_selected($_GET['sfl'], "wr_subject||wr_content") ?>>제목+내용</option>
                        <option value="wr_subject"<?php echo get_selected($_GET['sfl'], "wr_subject") ?>>제목</option>
                        <option value="wr_content"<?php echo get_selected($_GET['sfl'], "wr_content") ?>>내용</option>
                        <option value="mb_id"<?php echo get_selected($_GET['sfl'], "mb_id") ?>>회원아이디</option>
                        <option value="wr_name"<?php echo get_selected($_GET['sfl'], "wr_name") ?>>이름</option>
                    </select>
                </div>
                <div class="col-12 col-sm-3">
                    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                    <input type="text" name="stx" value="<?php echo $text_stx ?>" id="stx" required class="form-control">
                </div>
                <div class="col-6 col-sm-1 py-2 py-sm-0">
                    <div class="form-check text-center">
                        <input type="radio" value="or" <?php echo ($sop == "or") ? "checked" : ""; ?> id="sop_or" name="sop" class="form-check-input">
                        <label for="sop_or" class="form-check-label">OR</label>
                    </div>
                </div>
                <div class="col-6 col-sm-1 py-sm-0">
                    <div class="form-check text-center">
                        <input type="radio" value="and" <?php echo ($sop == "and") ? "checked" : ""; ?> id="sop_and" name="sop" class="form-check-input">
                        <label for="sop_and" class="form-check-label">AND</label>
                    </div>
                </div>
                <div class="col-12 col-sm-2">
                    <button type="submit" class="btn btn-primary block w-100"><i class="fa fa-search" aria-hidden="true"></i> 검색</button>
                </div>
            </div>
            
            <script>
            function fsearch_submit(f)
            {
                if (f.stx.value.length < 2) {
                    alert("검색어는 두글자 이상 입력하십시오.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                // 검색에 많은 부하가 걸리는 경우 이 주석을 제거하세요.
                var cnt = 0;
                for (var i=0; i<f.stx.value.length; i++) {
                    if (f.stx.value.charAt(i) == ' ')
                        cnt++;
                }

                if (cnt > 1) {
                    alert("빠른 검색을 위하여 검색어에 공백은 한개만 입력할 수 있습니다.");
                    f.stx.select();
                    f.stx.focus();
                    return false;
                }

                f.action = "";
                return true;
            }
            </script>
            
        </fieldset>
        </form>
    </div>
</div>

<div id="sch_result">

    <?php
    if ($stx) {
        if ($board_count) {
    ?>
    <section id="sch_res_ov">
        <h2><strong><?php echo $stx ?></strong> 전체검색 결과</h2>
        <dl>
            <dt>게시판</dt>
            <dd><strong class="sch_word"><?php echo $board_count ?>개</strong></dd>
            <dt>게시물</dt>
            <dd><strong class="sch_word"><?php echo number_format($total_count) ?>개</strong></dd>
        </dl>
        <p><?php echo number_format($page) ?>/<?php echo number_format($total_page) ?> 페이지 열람 중</p>
    </section>
    <?php
        }
    }
    ?>

    <?php
    if ($stx) {
        if ($board_count) {
     ?>
    <ul id="sch_res_board">
        <li><a href="?<?php echo $search_query ?>&amp;gr_id=<?php echo $gr_id ?>" <?php echo $sch_all ?>>전체게시판</a></li>
        <?php echo $str_board_list; ?>
    </ul>
    <?php
        } else {
     ?>
    <div class="empty_list">검색된 자료가 하나도 없습니다.</div>
    <?php } }  ?>

    <hr>

    <?php if ($stx && $board_count) { ?><section class="sch_res_list"><?php }  ?>
    <?php
    $k=0;
    for ($idx=$table_index, $k=0; $idx<count($search_table) && $k<$rows; $idx++) {
     ?>
        <h2><a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><?php echo $bo_subject[$idx] ?> 게시판 내 결과</a></h2>
        <ul>
        <?php
        for ($i=0; $i<count($list[$idx]) && $k<$rows; $i++, $k++) {
            if ($list[$idx][$i]['wr_is_comment'])
            {
                $comment_def = '<span class="cmt_def"><i class="fa fa-commenting-o" aria-hidden="true"></i><span class="sound_only">댓글</span></span> ';
                $comment_href = '#c_'.$list[$idx][$i]['wr_id'];
            }
            else
            {
                $comment_def = '';
                $comment_href = '';
            }
         ?>

            <li>
                <div class="sch_tit">
                    <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" class="sch_res_title"><?php echo $comment_def ?><?php echo $list[$idx][$i]['subject'] ?></a>
                    <a href="<?php echo $list[$idx][$i]['href'] ?><?php echo $comment_href ?>" target="_blank" class="pop_a"><i class="fa fa-share-square-o" aria-hidden="true"></i>새창</a>
                </div>
                <p><?php echo $list[$idx][$i]['content'] ?></p>
                <div class="sch_info">
                    <?php echo $list[$idx][$i]['name'] ?>
                    <span class="sch_datetime"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$idx][$i]['wr_datetime'] ?></span>
                </div>
            </li>
        <?php }  ?>
        </ul>
        <div class="sch_more"><a href="./board.php?bo_table=<?php echo $search_table[$idx] ?>&amp;<?php echo $search_query ?>"><strong><i class="fa fa-plus-circle" aria-hidden="true"></i> <?php echo $bo_subject[$idx] ?></strong> 결과 더보기</a></div>

        <hr>
    <?php }  ?>
    <?php if ($stx && $board_count) {  ?></section><?php }  ?>

    <?php echo $write_pages ?>

</div>
<!-- } 전체검색 끝 -->