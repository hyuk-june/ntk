<?php
/*
title:전체게시판 최신댓글
description:모든게시판의 댓글 출력
version:1.0.1
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$limit = bt\binstr($wcfg["rowcnt"], 5);

/*$sql_common = "  {$g5['board_new_table']} a, {$g5['board_table']} b, {$g5['group_table']} c 
    where a.bo_table = b.bo_table and b.gr_id = c.gr_id and b.bo_use_search = 1 ";
$sql_common .= " and a.wr_id = a.wr_parent ";*/
$strlen = 100;
$list = btb\get_new_data($limit, $widget_url, $strlen, true);
?>

    <div class="widget-basic-new">
        <div class="title title-underline">
            <span class="title-underline-focus enf"><a href="<?php echo G5_BBS_URL?>/new.php" title="댓글 더보기">New Comment</a></span>
            <span class="more pull-right"><a href="<?php echo G5_BBS_URL?>/new.php" title="댓글 더보기">+more</a></span>
        </div>
        <ul>
<?php
foreach($list as $row){
    
    $a_href = G5_BBS_URL.'/board.php?bo_table='.$row['bo_table'].'&wr_id='.$row['wr_id'];
    
    $datetime = str_replace('-', '.', $row['datetime2']);
    $icons = '';
    if(bt\isval($row['icon_secret'])) $icons = '<span class="icon icon-lock"></span>';
    //else if(bt\isval($row['icon_new'])) $icons = '<span class="icon icon-new"></span>';
    //else if(bt\isval($row['icon_hot'])) $icons = '<span class="icon icon-hot"></span>';
    //else $icons = '<i class="fa fa-caret-right"></i>';
    
    $subject = cut_str(strip_tags($row["wr_content"]), $strlen);
?>
            <li class="ellipsis">
                
                <span class="pull-right" data-regdate="<?php echo $row["wr_datetime"]?>">
                
                <?php if($wcfg["show_name"]){?>
                    <span class="name"><?php echo $row["name"]?></span>
                <?php }?>
                
                <?php if(!$rs['wg_isset'] || $wcfg["show_date"]){?>
                    <span class="date"><?php echo $datetime?></span>
                <?php }?>
                
                </span>
                
                <?php echo $icons?>
                <a href="<?php echo $a_href?>" title="<?php echo $row["wr_subject"]?>">
                    <?php echo $subject?>
                </a>
            </li>
<?php
}
?>
        </ul>
    </div>
    