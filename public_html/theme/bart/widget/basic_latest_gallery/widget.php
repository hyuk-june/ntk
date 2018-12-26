<?php
/*
title:최신글 갤러리 위젯
description:기본적인 최신글 갤러리 위젯
version:1.0.0
author:bartnet
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

if(bt\isval($wcfg['bo_table'])){

    $temp = btb\get_latest_data($wcfg['bo_table'], bt\binstr($wcfg['rowcnt'], 6), $widget_url);
    $board = $temp['board'];
    $list = $temp['list'];
    
    if(bt\isval($wcfg['thumb_w'])) $thumb_w = $wcfg['thumb_w'];
    else $thumb_w = 400;
    if(bt\isval($wcfg['thumb_h'])) $thumb_h = $wcfg['thumb_h'];
    else $thumb_h = 300;
    
    $a_href = G5_BBS_URL.'/board.php?bo_table='.$wcfg['bo_table'];
?>
    <div class="widget-basic-latest-gallery">
        <div class="title title-underline">
            <span class="title-underline-focus enf"><a href="<?php echo $a_href?>" title="<?php echo $board['bo_subject']?> 더보기"><?php echo $board['bo_subject']?></a></span>
            <span class="more float-right"><a href="<?php echo $a_href?>" title="<?php echo $board['bo_subject']?> 더보기">+more</a></span>
        </div>
        <ul>
    <?php
    foreach($list as $row){
        $a_href = G5_BBS_URL.'/board.php?bo_table='.$wcfg['bo_table'].'&wr_id='.$row['wr_id'];
        $datetime = str_replace('-', '.', $row['datetime2']);
        $icons = '';
        if(bt\isval($row['icon_secret'])) $icons = '<span class="icon icon-lock"></span>';
        else if(bt\isval($row['icon_new'])) $icons = '<span class="icon icon-new"></span>';
        else if(bt\isval($row['icon_hot'])) $icons = '<span class="icon icon-hot"></span>';
        else $icons = '<i class="fa fa-caret-right"></i>';
        
        $thumb = btb\get_list_thumbnail(
            $board['bo_table'], $row['wr_id'], $thumb_w, $thumb_h, 
            array(
                "sizefix" => true,
                "crop_posx" => bt\image\BThumbnail::CROP_POSX_CENTER,
                "crop_posy" => bt\image\BThumbnail::CROP_POSY_MIDDLE,
                "is_anigif_thumb" => true
            )
        );
        
        if($thumb){
            $img = '<img src="'.$thumb['src'].'" class="img-fluid" alt="'.$row["subject"].'">';
        }else{
            $img = '<div class="blank-img">이미지 없음</div>';
        }
    ?>
            <li>
                <div class="thumb"><a href="<?php echo $a_href?>"><?php echo $img?></a></div>
                <div class="desc ellipsis">
                    <a href="<?php echo $a_href?>" title="<?php echo $row["subject"]?>">
                        <?php echo $icons?>
                        <?php echo $row["subject"]?>
                    </a>
                </div>
            <?php if(bt\isval($wcfg['show_name']) || bt\isval($wcfg['show_date'])){?>
                <div class="foot ellipsis">
                    <span class="pull-right" data-regdate="<?php echo $row["datetime"]?>">
                    <?php if((int)$row["wr_comment"]){?>
                        <span class="cmt-cnt">+<?php echo $row["wr_comment"]?></span>
                    <?php }?>
                    </span>
                <?php if($wcfg['show_name']){?>
                    <span class="name"><?php echo $row['wr_name'];?></span>
                <?php }?>
                <?php if(!$rs['wg_isset'] || $wcfg['show_date']){?>
                    <span class="date"><?php echo $datetime;?></span>
                <?php }?>
                </div>
            <?php }?>
            </li>
    <?php }?>
        </ul>
    </div>
<?php }?>

