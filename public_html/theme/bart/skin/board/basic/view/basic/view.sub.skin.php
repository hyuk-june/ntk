<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$sub_urls['view'].'/view.sub.skin.css" />');
?>

<article class="bo-basic-view px-1 px-sm-0">
    <header>
        <h2 class="view-title">
            <?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h2>
    </header>

    <div class="article-info">
    <?php if(!$write_hide_writer || !$write_hide_datetime || !$write_hide_hit || !$write_hide_cmtcnt){?>
        <section class="page-info">
            <h2>페이지 정보</h2>
            <dl>
            <?php if(!$write_hide_writer) { ?>
                <dt><i class="fa fa-user d-inline-block d-sm-none"></i><span class="d-none d-sm-block">작성자:</span></dt>
                <dd><?php echo $view['name'] ?><?php if ($is_ip_view) { echo '<span class="d-none class="d-sm-inline-block">&nbsp;('.$ip.')</span>'; } ?></dd>
            <?php }?>
            
            <?php if(!$write_hide_datetime) { ?>
                <dt><i class="fa fa-calendar d-inline-block d-sm-none"></i><span class="d-none d-sm-block">작성일</span></dt>
                <dd><?php echo date("m.d H:i", strtotime($view['wr_datetime'])) ?></dd>
            <?php }?>
            
            <?php if(!$write_hide_hit) { ?>
                <dt><i class="fa fa-eye d-inline d-sm-none"></i><span class="d-none d-sm-block">조회</span></dt>
                <dd><?php echo number_format($view['wr_hit']) ?></dd>
            <?php }?>
            
            <?php if(!$write_hide_cmtcnt) { ?>
                <dt><i class="fa fa-comment d-inline d-sm-none"></i><span class="d-none d-sm-block">댓글</span></dt>
                <dd><?php echo number_format($view['wr_comment']) ?></dd>
            <?php }?>
            </dl>
            <div class="clearfix"></div>
        </section>
    <?php }?>
    

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
        <!-- 첨부파일 시작 { -->
        <section class="attach-file">
            <h2>첨부파일</h2>
            <ul class="m-0">
            <?php
            // 가변 파일
            for ($i=0; $i<count($view['file']); $i++) {
                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
            ?>
                <li class="flex flex-wrap">
                    <div class="d-inline-block d-sm-block mr-2">
                        <a href="<?php echo $view['file'][$i]['href'];?>" data-point="<?php echo $view['file'][$i]['point']?>" class="view_file_download">
                            <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                            <strong><?php echo $view['file'][$i]['source'] ?></strong>
                            <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                        </a>
                <?php if((int)$view['file'][$i]['point'] < 0){?>
                        <span class="down-point"><?php echo number_format($view['file'][$i]['point'])?> Point</span>
                <?php }?>
                    </div>
                    <div class="d-inline-block d-sm-block mr-2">
                        <i class="fa fa-download">&nbsp;</i><?php echo $view['file'][$i]['download'] ?>회 다운로드
                    </div>
                    <div class="d-inline-block d-sm-block">
                        <i class="fa fa-calendar">&nbsp;</i>DATE : <?php echo $view['file'][$i]['datetime'] ?>
                    </div>
                </li>
            <?php
                }
            }
             ?>
            </ul>
        </section>
        <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
    if (bt\isval($view['link'][0]) || bt\isval($view['link'][1])) {
    ?>
        <!-- 관련링크 시작 { -->
        <section class="rel-link">
            <h2>관련링크</h2>
            <ul>
            <?php
            // 링크
            $cnt = 0;
            for ($i=1; $i<=count($view['link']); $i++) {
                if ($view['link'][$i]) {
                    $cnt++;
                    $link = cut_str($view['link'][$i], 70);
             ?>
                <li>
                    <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                        <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                        <strong><?php echo $link ?></strong>
                    </a>
                    <span class="bo_v_link_cnt"><?php echo $view['link_hit'][$i] ?>회 연결</span>
                </li>
            <?php
                }
            }
             ?>
            </ul>
        </section>
        <!-- } 관련링크 끝 -->
    <?php } ?>
    </div>
    
    <section class="view-content-wrap border-bottom mb-2">
        <h2>본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    echo get_view_thumbnail($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
        ?>
        
        <!-- 본문 내용 시작 { -->
        <div class="view-content">
        <?php
        $content =  get_view_thumbnail($view['content']);
        echo preg_replace('~(<iframe\s[^>]+>\s*<\/iframe>)~is', '<div class="embed-movie">$1</div>', $content);
        ?></div>
        <?php //echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><p><?php echo $signature ?></p><?php } ?>

        
        <div class="flex justify-between">
            <div>
                <!-- 스크랩 추천 비추천 시작 { -->
                <?php if ($scrap_href || $good_href || $nogood_href) { ?>
                <div class="view-content-btns">
                    
                    <?php if ($scrap_href) { ?>
                        <a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn-dark" onclick="win_scrap(this.href); return false;">스크랩</a>
                    <?php } ?>
                    
                    <?php if ($good_href) { ?>
                        <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn btn-danger">추천 <strong><?php echo number_format($view['wr_good']) ?></strong></a>
                    <?php } ?>
                    
                    <?php if ($nogood_href) { ?>
                        <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn btn-info">비추천  <strong><?php echo number_format($view['wr_nogood']) ?></strong></a>
                    <?php } ?>
                </div>
                <?php } else {
                    if($board['bo_use_good'] || $board['bo_use_nogood']) {
                ?>
                <div id="bo_v_act">
                    <?php if($board['bo_use_good']) { ?><span>추천 <strong><?php echo number_format($view['wr_good']) ?></strong></span><?php } ?>
                    <?php if($board['bo_use_nogood']) { ?><span>비추천 <strong><?php echo number_format($view['wr_nogood']) ?></strong></span><?php } ?>
                </div>
                <?php
                    }
                }
                ?>
                <!-- } 스크랩 추천 비추천 끝 -->
            </div>
            <div>
                <div class="view-content-btns">
                    <div class="sns-wrap mb-2 text-center"><?php include_once(G5_SNS_PATH."/view.sns.skin.php");?></div>
                </div>
            </div>
        </div>
        
    </section>
    
    
    <div class="comment-wrap">
        <?php // 코멘트 입출력
        include_once(G5_BBS_PATH.'/view_comment.php');
        ?>
    </div>
    
    
    
    <!-- 게시물 버튼 시작 { -->
    <div class="view-btns-wrap flex <?php echo ($prev_href || $next_href) ? 'justify-between' : 'justify-end';?> mb-3">
    
        <?php if ($prev_href || $next_href) { ?>
        <ul class="view-btns-navi flex">
            <?php if ($prev_href) { ?><li class="mr-1"><a href="<?php echo $prev_href ?>" class="btn btn-dark"><i class="fa fa-arrow-circle-left mr-sm-1"></i><span class="d-none d-sm-inline-block">이전글</span></a></li><?php } ?>
            <?php if ($next_href) { ?><li class="mr-1"><a href="<?php echo $next_href ?>" class="btn btn-dark"><i class="fa fa-arrow-circle-right mr-sm-1"></i><span class="d-none d-sm-inline-block">다음글</span></a></li><?php } ?>
            <?php if ($copy_href) { ?><li class="mr-1"><a href="<?php echo $copy_href ?>" class="btn btn-danger" onclick="board_move(this.href); return false;"><i class="fa fa-copy mr-1"></i><span class="d-none d-sm-inline-block">복사</span></a></li><?php } ?>
            <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn btn-danger" onclick="board_move(this.href); return false;"><i class="fa fa-arrow-right mr-1"></i><span class="d-none d-sm-inline-block">이동</span></a></li><?php } ?>
        </ul>
        <?php } ?>

        <div>
            <ul class="view-btns-ctrl d-none d-sm-flex justify-end">
                <?php if ($update_href) { ?><li class="mr-1"><a href="<?php echo $update_href ?>" class="btn btn-dark"><i class="fa fa-edit mr-1"></i>수정</a></li><?php } ?>
                <?php if ($delete_href) { ?><li class="mr-1"><a href="<?php echo $delete_href ?>" class="btn btn-dark" onclick="del(this.href); return false;"><i class="fa fa-trash-alt mr-1"></i>삭제</a></li><?php } ?>
                <?php if ($search_href) { ?><li class="mr-1"><a href="<?php echo $search_href ?>" class="btn btn-dark"><i class="fa fa-search mr-1"></i>검색</a></li><?php } ?>
                <li class="mr-1"><a href="<?php echo $list_href ?>" class="btn btn-dark"><i class="fa fa-list mr-1"></i>목록</a></li>
                <?php if ($reply_href) { ?><li class="mr-1"><a href="<?php echo $reply_href ?>" class="btn btn-dark"><i class="fa fa-reply mr-1"></i>답변</a></li><?php } ?>
                <?php if ($write_href) { ?><li class="mr-1"><a href="<?php echo $write_href ?>" class="btn btn-dark"><i class="fa fa-pencil-alt mr-1"></i>글쓰기</a></li><?php } ?>
            </ul>
            
            <div class="dropdown block d-sm-none">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="board_buttons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                    Control
                </button>

                <div class="dropdown-menu" aria-labelledby="board_buttons">
                    <?php if ($update_href) { ?><a href="<?php echo $update_href ?>" class="dropdown-item"><i class="fa fa-edit mr-1"></i>수정</a><?php } ?>
                    <?php if ($delete_href) { ?><a href="<?php echo $delete_href ?>" class="dropdown-item" onclick="del(this.href); return false;"><i class="fa fa-trash-alt mr-1"></i>삭제</a><?php } ?>
                    <?php if ($search_href) { ?><a href="<?php echo $search_href ?>" class="dropdown-item"><i class="fa fa-search mr-1"></i>검색</a><?php } ?>
                    <a href="<?php echo $list_href ?>" class="dropdown-item"><i class="fa fa-list mr-1"></i>목록</a>
                    <?php if ($reply_href) { ?><a href="<?php echo $reply_href ?>" class="dropdown-item"><i class="fa fa-reply mr-1"></i>답변</a><?php } ?>
                    <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="dropdown-item"><i class="fa fa-pencil-alt mr-1"></i>글쓰기</a><?php } ?>
                </div>
            </div>
        
        </div>
    </div>
    <!-- } 게시물 버튼 끝 -->
    
    
    
</article>


<script type="text/javascript">
<!--
/*function movieToResponsive(){
    var str = $('.view-content').html();
    $('.view-content').html('');
    $('.view-content').html(str.replace(/(<iframe\s[^>]+>\s*<\/iframe>)/ig, function(mat, p, str){
        return '<div class="embed-movie">' + p + '</div>';
    }));
}

$(document).ready(function(){
    movieToResponsive();
});*/
//-->
</script>