<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<section class="qa-cmt">
    <div class="flex justify-between mb-2">
        <h2>답변: <?php echo get_text($answer['qa_subject']); ?></h2>
        <div>
            <a href="<?php echo $rewrite_href; ?>" class="btn btn-sm btn-dark">추가질문</a>
        </div>
    </div>

    <div class="border p-3">
        <div class="qa-datetime mb-2">
            <?php echo $answer['qa_datetime']; ?>
        </div>

        <div class="qa-content mb-2">
            <?php echo conv_content($answer['qa_content'], $answer['qa_html']); ?>
        </div>

        <div class="text-right">
            <?php if($answer_update_href) { ?>
            <a href="<?php echo $answer_update_href; ?>" class="btn btn-sm btn-dark">답변수정</a>
            <?php } ?>
            <?php if($answer_delete_href) { ?>
            <a href="<?php echo $answer_delete_href; ?>" class="btn btn-sm btn-dark ml-1" onclick="del(this.href); return false;">답변삭제</a>
            <?php } ?>
        </div>
    </div>
</section>