<?php
/*
title:알리미
description:내게 온 소식목록입니다
version:1.0.0
author:bartnet
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\loan as btl;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$widget_url.'/style.css" />');
?>

<?php
if(!$is_member){
?>
    <div class="alert alert-right" role="alert">
        회원로그인 후 사용할 수 있습니다
    </div>
<?php
    return;
}?>

<?php
$rowcnt = bt\binstr($wcfg['rowcnt'], 5);

$Q = "SELECT * FROM ".$alcfg['alim_table']." WHERE mb_id='".$member['mb_id']."'
    ORDER BY al_regdate DESC LIMIT ".$rowcnt;

$result = sql_query($Q);

$line_height = bt\binstr($wcfg["line_height"], 30);

$a_href = '?mtype=mpage&mid='.$wcfg['mid'];
?>

<div class="widget-alim">

    <div class="title title-underline">
        <span class="title-underline-focus enf"><a href="<?php echo $a_href?>" title="주문내역 더보기">알리미</a></span>
        <span class="more float-right"><a href="<?php echo $a_href?>" title="주문내역 더보기">+more</a></span>
    </div>
    
    <ul class="list">
<?php for($i=0; $rs = sql_fetch_array($result); $i++){?>
        <li class="list-row" style="line-height:<?php echo $line_height?>px">
            <span class="al-read al-read-<?php echo $rs['al_read']?> float-right font-weight-bold" style="line-height:<?php echo $line_height?>px"><?php echo $rs['al_read']=='1' ? '읽음' : '안읽음'?></span>
            <span class="al-regdate"><?php echo $rs['al_regdate']?></span>
            <span class="al-message"><?php echo $rs['al_message']?></span>
        </li>
<?php }?>
<?php if($i==0){?>
        <li class="blank">알림 목록이 없습니다</li>
<?php }?>
    </ul>
</div>