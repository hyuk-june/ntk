<?php
/*
title:전체게시판 새글
description:모든게시판에서 댓글을 제외한 새글 출력
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$limit = bt\binstr($wcfg["rowcnt"], 5);

$strlen = 100;
$list = btb\get_new_data(10, $widget_url, $strlen);
/*$wcfg["show_name"] = bt\binstr($wcfg["show_name"], "1");
$wcfg["show_date"] = bt\binstr($wcfg["show_date"], "1");*/
?>

    <div class="widget-basic-new">
        <div class="title title-underline">
            <span class="title-underline-focus enf"><a href="<?php echo G5_BBS_URL?>/new.php" title="새글 더보기">New Post</a></span>
            <span class="more pull-right"><a href="<?php echo G5_BBS_URL?>/new.php" title="새글 더보기">+more</a></span>
        </div>
        <ul>
<?php
foreach($list as $row){
    
    $a_href = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&wr_id='.$row['wr_id'];
    $datetime = str_replace('-', '.', $row['datetime2']);
    $icons = '';
    if(bt\isval($row['icon_secret'])) $icons = '<span class="icon icon-lock"></span>';
    else if(bt\isval($row['icon_new'])) $icons = '<span class="icon icon-new"></span>';
    else if(bt\isval($row['icon_hot'])) $icons = '<span class="icon icon-hot"></span>';
    else $icons = '<i class="fa fa-caret-right icon"></i>';
    
?>
            <li class="ellipsis">
                
                <span class="float-right" data-regdate="<?php echo $row["wr_datetime"]?>">
                
                <?php if((int)$row["wr_comment"]){?>
                    <span class="cmt-cnt">+<?php echo $row["wr_comment"]?></span>
                <?php }?>
                
                <?php if($wcfg["show_name"]){?>
                    <span class="name"><?php echo $row["name"]?></span>
                <?php }?>
                
                <?php if(!$rs['wg_isset'] || $wcfg["show_date"]){?>
                    <span class="date"><?php echo $datetime?></span>
                <?php }?>
                
                </span>
                
                <?php echo $icons?>
                <a href="<?php echo $a_href?>" title="<?php echo $row["subject"]?>">
                    <?php echo $row["subject"]?>
                </a>
            </li>

<?php
}
?>
        </ul>
    </div>
    