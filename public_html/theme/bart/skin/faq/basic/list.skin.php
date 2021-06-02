<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$faq_skin_url.'/style.css">', 0);
?>

<div class="faq p-1 p-sm-0">

    <!-- FAQ 시작 { -->
    <?php if ($himg_src){?>
    <div id="faq_himg" class="faq_img"><img src="<?php echo $himg_src?>" alt=""></div>
    <?php }?>

    <!--상단 HTML-->
    <?php if(bt\isval($fm['fm_head_html'])){?>
    <div id="faq_hhtml"><?php echo conv_content($fm['fm_head_html'], 1)?></div>
    <?php }?>

    <?php if( count($faq_master_list) ){?>
    <nav class="cate-wrap mb-2">
        <h2 class="d-none">자주하시는질문 분류</h2>
        <ul class="cate-list flex flex-wrap">
            <?php
            foreach( $faq_master_list as $v ){
                $category_msg = '';
                $category_option = '';
                if($v['fm_id'] == $fm_id){ // 현재 선택된 카테고리라면
                    $category_option = ' id="bo_cate_on"';
                    $category_msg = '<span class="sound_only">열린 분류 </span>';
                }
            ?>
            <li><a href="<?php echo $category_href;?>?fm_id=<?php echo $v['fm_id'];?>" <?php echo $category_option;?> ><?php echo $category_msg.$v['fm_subject'];?></a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
    <?php } ?>

    
    <div class="faq-list">
        <?php // FAQ 내용
        if( count($faq_list) ){
        ?>
        
        <section class="list-item">
            <h2 class="d-none"><?php echo $g5['title']; ?> 목록</h2>
            <div class="accordion" id="faq_list_wrap">
                <?php
                $i=1;
                foreach($faq_list as $key=>$v){
                    if(empty($v))
                        continue;
                ?>
                <div class="card">
                    <div class="card-header" id="question_<?php echo $i?>">
                        <h5 class="mb-0 flex" data-toggle="collapse" data-target="#answer_<?php echo $i?>" aria-expanded="true" aria-controls="collapseOne">
                            <span class="tit-bg align-middle font-size-4 bg-danger">Q</span>
                            <div class="question pl-5 font-size-2 font-weight-normal"><?php echo conv_content($v['fa_subject'], 1); ?></div>
                        </h5>
                    </div>
                    
                    <div id="answer_<?php echo $i?>" class="collapse" aria-labelledby="question_<?php echo $i?>" data-parent="#faq_list_wrap">
                        <div class="card-body p-3">
                            <span class="tit-bg align-middle font-size-4 bg-primary">A</span>
                            <div class="answer pl-5 font-size-2 font-weight-normal"><?php echo conv_content($v['fa_content'], 1); ?></div>
                        </div>
                    </div>

                </div>
                <?php
                    $i++;
                }
                ?>
            </div>
        </section>
        <?php } else {
            if($stx){
                echo '<p class="empty-list border my-3 p-3">검색된 게시물이 없습니다.</p>';
            } else {
                echo '<div class="empty-list border my-3 p-3">등록된 FAQ가 없습니다.';
                if($is_admin)
                    echo '<br><a href="'.G5_ADMIN_URL.'/faqmasterlist.php">FAQ를 새로 등록하시려면 FAQ관리</a> 메뉴를 이용하십시오.';
                echo '</div>';
            }
        }
        ?>
    </div>

    
    <?php echo btb\get_paging($page_rows, $page, $total_page, $_SERVER['SCRIPT_NAME'].'?'.$qstr.'&amp;page='); ?>

    <!-- 하단 HTML -->
    <?php if(bt\isval($fm['fm_head_html'])){?>
    <div id="faq_thtml"><?php echo conv_content($fm['fm_tail_html'], 1)?></div>
    <?php }?>
    <!-- //하단 HTML -->
    
    <?php if ($timg_src){?>
    <div id="faq_timg" class="faq_img"><img src="<?php echo $timg_src?>" alt=""></div>
    <?php }?>

    <form name="faq_search_form" method="get" class="flex justify-center row">
        <div class="input-group col-sm-3">
            <input type="hidden" name="fm_id" value="<?php echo $fm_id;?>">
            <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
            <input type="text" name="stx" value="<?php echo $stx;?>" required id="stx" class="form-control form-control-sm required" size="15" maxlength="15">
            <div class="input-group-append">
                <input type="submit" value="검색" class="btn btn-sm btn-dark">
            </div>
        </div>
    </form>
    <!-- } FAQ 끝 -->

    <?php if ($admin_href){?>
    <div class="text-right my-2"><a href="<?php echo $admin_href?>" class="btn btn-sm btn-danger">FAQ 수정</a></div>
    <?php }?>
</div>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>
<script>
$(function() {
    $(".closer_btn").on("click", function() {
        $(this).closest(".con_inner").slideToggle();
    });
});

function faq_open(el)
{
    var $con = $(el).closest("li").find(".con_inner");

    if($con.is(":visible")) {
        $con.slideUp();
    } else {
        $("#faq_con .con_inner:visible").css("display", "none");

        $con.slideDown(
            function() {
                // 이미지 리사이즈
                $con.viewimageresize2();
            }
        );
    }

    return false;
}
</script>