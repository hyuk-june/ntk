<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

// visit 배열변수에
// $visit[1] = 오늘
// $visit[2] = 어제
// $visit[3] = 최대
// $visit[4] = 전체
// 숫자가 들어감
preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);
settype($visit[1], "integer");
settype($visit[2], "integer");
settype($visit[3], "integer");
settype($visit[4], "integer");

add_stylesheet('<link rel="stylesheet" href="'.$visit_skin_url.'/style.css">', 0);
?>

<!-- 접속자집계 시작 { -->
<div class="bt-basic-visit">
    <div class="title title-underline">
        <span class="title-underline-focus enf">
            접속자집계
        </span>
        <span class="pull-right more">
            <?php if ($is_admin == "super") {  ?><a href="<?php echo G5_ADMIN_URL ?>/visit_list.php">상세보기</a><?php } ?>
        </span>
    </div>
    <ul>
        <li>
            <span class="lt"><i class="fa fa-paw"></i> 오늘방문수</span>
            <span class="ln"><?php echo number_format($visit[1]) ?> 명</span>
        </li>
        <li>
            <span class="lt"><i class="fa fa-paw"></i> 어제방문자</span>
            <span class="ln"><?php echo number_format($visit[2]) ?> 명</span>
        </li>
        <li>
            <span class="lt"><i class="fa fa-paw"></i> 최대방문자</span>
            <span class="ln"><?php echo number_format($visit[3]) ?> 명</span>
        </li>
        <li>
            <span class="lt"><i class="fa fa-paw"></i> 전체방문수</span>
            <span class="ln"><?php echo number_format($visit[4]) ?> 명</span>
        </li>
    </ul>
    
</div>
<!-- } 접속자집계 끝 -->