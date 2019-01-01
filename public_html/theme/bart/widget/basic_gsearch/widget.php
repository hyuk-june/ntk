<?php
/*
title:전체검색
description:게시판 전체에서 검색합니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/widget.css" />');

$date_cnt = bt\binstr($wcfg['date_cnt'], 3);
$pop_cnt = bt\binstr($wcfg['pop_cnt'], 7);

$date_gap = date("Y-m-d", G5_SERVER_TIME - ($date_cnt * 86400));
$sql = "select pp_word, count(*) as cnt
    from {$g5['popular_table']} where pp_date between '$date_gap' and '".G5_TIME_YMD."' group by pp_word order by cnt desc, pp_word limit 0, $pop_cnt ";

$result = $bdb->query($sql);


$pre_word = array();
if(bt\isval($wcfg['pre_word'])){
    $pre_word = @explode('|', $wcfg['pre_word']);
}else{
    $pre_word = array('NTK빌더', '케이베이', 'kbay', '파이팅', '인기');
}
$list = $pre_word;

for ($i=0; $row=$bdb->fetch($result); $i++) {
    $list[$i] = $row['pp_word'];
    // 스크립트등의 실행금지
    //$list[$i]['pp_word'] = get_text($list[$i]['pp_word']);
}

$list = array_unique($list);
@shuffle($list);

$list = array_splice($list, 0, 5);
?>

<div class="widget-basic-gsearch">
    <form name="fsearchbox" method="get" action="<?php echo G5_BBS_URL ?>/search.php" onsubmit="return fsearchbox_submit(this);">
        <input type="hidden" name="sfl" value="wr_subject||wr_content">
        <input type="hidden" name="sop" value="and">
        <div class="input-group input-group-lg">
            
            <label for="sch_stx" class="sound_only">검색어 필수</label>
            <input type="text" name="stx" id="sch_stx" class="form-control" placeholder="전체검색">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
            </span>

            <script type="text/javascript">
            function fsearchbox_submit(f)
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

                return true;
            }
            </script>
        </div>
    </form>
    <div>
    <?php if($wcfg['popular']=='1'){?>
        <ul>
        <?php for ($i=0; $i<count($list); $i++) {  ?>
            <li><a href="<?php echo G5_BBS_URL ?>/search.php?sfl=wr_subject&amp;sop=and&amp;stx=<?php echo urlencode($list[$i]) ?>"><?php echo get_text($list[$i]); ?></a></li>
        <?php }  ?>
        </ul>
    <?php }?>
    </div>
</div>