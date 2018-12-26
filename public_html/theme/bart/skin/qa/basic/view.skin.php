<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$qa_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->

<article class="qa-view">
    <header>
        <h1>
            <?php
            echo $view['category'].' | '; // 분류 출력 끝
            echo $view['subject']; // 글제목 출력
            ?>
        </h1>
    </header>

    <section class="page-info mb-2">
        <h2 class="d-none">페이지 정보</h2>
        작성자 <strong><?php echo $view['name'] ?></strong>
        <span class="sound_only">작성일</span><strong><?php echo $view['datetime']; ?></strong>
    </section>

    <?php if($view['download_count']) { ?>
    <!-- 첨부파일 시작 { -->
    <section class="attach-file mb-2">
        <h2 class="d-none">첨부파일</h2>
        <ul>
        <?php
        // 가변 파일
        for ($i=0; $i<$view['download_count']; $i++) {
         ?>
            <li>
                <a href="<?php echo $view['download_href'][$i];  ?>" class="view_file_download">
                    <img src="<?php echo $qa_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['download_source'][$i] ?></strong>
                </a>
            </li>
        <?php
        }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if($view['email'] || $view['hp']) { ?>
    <section class="mb-2 border-bottom">
        <h2 class="d-none">연락처</h2>
        <dl class="d-flex">
            <?php if($view['email']) { ?>
            <dt class="col-sm-2 p-2">이메일</dt>
            <dd class="col-sm-4 p-2"><?php echo $view['email']; ?></dd>
            <?php } ?>
            <?php if($view['hp']) { ?>
            <dt class="col-sm-2 p-2">휴대폰</dt>
            <dd class="col-sm-4 p-2"><?php echo $view['hp']; ?></dd>
            <?php } ?>
        </dl>
    </section>
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
    <div class="d-flex justify-content-between mb-2">
        <?php
        ob_start();
         ?>
        <?php if ($prev_href || $next_href) { ?>
        <ul class="d-flex">
            <?php if ($prev_href) { ?><li class="mr-1"><a href="<?php echo $prev_href ?>" class="btn btn-sm btn-dark">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn btn-sm btn-dark">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>

        <ul class="d-flex">
            <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn btn-sm btn-dark mr-1">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn btn-sm btn-dark mr-1" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <li><a href="<?php echo $list_href ?>" class="btn btn-sm btn-dark mr-1">목록</a></li>
            <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn btn-sm btn-primary">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
        ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <section class="content-wrap border-top">
        <h2 class="d-none">파일</h2>
        <?php
        // 파일 출력
        if($view['img_count']) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<$view['img_count']; $i++) {
                //echo $view['img_file'][$i];
                echo get_view_thumbnail($view['img_file'][$i], $qaconfig['qa_image_width']);
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"><?php echo get_view_thumbnail($view['content'], $qaconfig['qa_image_width']); ?></div>
        <!-- } 본문 내용 끝 -->

        <?php if($view['qa_type']) { ?>
        <div id="bo_v_addq"><a href="<?php echo $rewrite_href; ?>" class="btn_b01">추가질문</a></div>
        <?php } ?>

    </section>

    <div class="mb-3">
    <?php
    // 질문글에서 답변이 있으면 답변 출력, 답변이 없고 관리자이면 답변등록폼 출력
    if(!$view['qa_type']) {
        if($view['qa_status'] && $answer['qa_id'])
            include_once($qa_skin_path.'/view.answer.skin.php');
        else
            include_once($qa_skin_path.'/view.answerform.skin.php');
    }
    ?>
    </div>

    <?php if($view['rel_count']) { ?>
    <section class="rel-list qa-list mb-2">
        <h2 class="d-none">연관질문</h2>

        <div class="list-wrap">
            <div class="list-head">
                <div class="list-row">
                    <div class="list-cell list-cell-cate">분류</div>
                    <div class="list-cell list-cell-subject">제목</div>
                    <div class="list-cell list-cell-status">상태</div>
                    <div class="list-cell list-cell-datetime">등록일</div>
                </div>
            </div>
            <ul class="list-body">
            <?php
            for($i=0; $i<$view['rel_count']; $i++) {
            ?>
                <li class="list-row">
                    <div class="list-cell list-cell-cate"><?php echo get_text($rel_list[$i]['category']); ?></div>
                    <div class="list-cell list-cell-subject">
                        <a href="<?php echo $rel_list[$i]['view_href']; ?>">
                            <?php echo $rel_list[$i]['subject']; ?>
                        </a>
                    </div>
                    <div class="list-cell list-cell-status td_stat <?php echo ($list[$i]['qa_status'] ? 'txt_done' : 'txt_rdy'); ?>"><?php echo ($rel_list[$i]['qa_status'] ? '답변완료' : '답변대기'); ?></div>
                    <div class="list-cell list-cell-datetime"><?php echo $rel_list[$i]['date']; ?></div>
                </li>
            <?php
            }
            ?>
            </ul>
        </div>
    </section>
    <?php } ?>

    <!-- 링크 버튼 시작 { -->
    <div class="d-flex justify-content-between mb-2">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});
</script>