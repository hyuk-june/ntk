<?php
/*
title:인기검색어 위젯
version:1.0.0
author:bartnet
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");


// 인기검색어 출력
// $skin_dir : 스킨 디렉토리
// $pop_cnt : 검색어 몇개
// $date_cnt : 몇일 동안

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

global $wcfg;

//임의의 검색어가 있으면
$temp = @explode('|', $wcfg['pre_word']);

foreach($temp as $word){
    $list[] = array('pp_word' => $word);
}

//임의의 검색어도 없으면 기본문자
if(count($list) <= 0){
    $list[] = array('pp_word' => 'NTK빌더');
    $list[] = array('pp_word' => '홈페이지빌더');
    $list[] = array('pp_word' => '케이베이');
    $list[] = array('pp_word' => 'kbay');
}

$list = array_splice($list, 0, $pop_cnt);
    
@shuffle($list);



add_stylesheet('<link rel="stylesheet" href="'.$popular_skin_url.'/style.css">', 0);
?>

<!-- 인기검색어 시작 { -->
<section class="bt-basic-popular">
    <div class="title title-underline">
        <span class="title-underline-focus enf">인기검색어</span>
    </div>
    <div class="d-flex">
        <ul>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]['pp_word']) ?>"><?php echo get_text($list[$i]['pp_word']); ?></a></li>
        <?php }  ?>
        </ul>
    </div>
</section>
<!-- } 인기검색어 끝 -->
