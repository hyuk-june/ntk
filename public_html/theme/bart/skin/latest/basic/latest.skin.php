<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

global $wcfg;
?>

    <div class="bt-basic-latest">
        <div class="title title-underline">
            <span class="title-underline-focus enf"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>"><?php echo $bo_subject?></a></span>
            <span class="more float-right"><a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=<?php echo $bo_table ?>" title="<?php echo $bo_subject?> 더보기">+more</a></span>
        </div>
        <ul>
    
    <?php
    for ($i=0; $i<count($list); $i++) {

        $a_href = $list[$i]['href'];
        
        $datetime = str_replace('-', '.', $list[$i]['datetime2']);
        $icons = '';
        
        if ($list[$i]['icon_new']) $icons .= '<span class="icon icon-new"></span>';
        if ($list[$i]['icon_hot']) $icons .= '<span class="icon icon-hot"></span>';
        if ($list[$i]['icon_file']) $icons .= '<span class="icon icon-file"></span>';
        if ($list[$i]['icon_link']) $icons .= '<span class="icon icon-link"></span>';
        if ($list[$i]['icon_secret']) $icons .= '<span class="icon icon-secret"></span>';
    ?>  
            <li class="ellipsis">
                
                <span class="float-right" data-regdate="<?php echo $list[$i]["wr_datetime"]?>">
                
                <?php if((int)$list[$i]["wr_comment"]){?>
                    <span class="cmt-cnt">+<?php echo $list[$i]["wr_comment"]?></span>
                <?php }?>
                
                <?php if($wcfg["show_name"]){?>
                    <span class="name"><?php echo $list[$i]["name"]?></span>
                <?php }?>
                
                <?php if(!$rs['wg_isset'] || $wcfg["show_date"]){?>
                    <span class="date"><?php echo $datetime?></span>
                <?php }?>
                
                </span>
                
                <?php echo $icons?>
                <a href="<?php echo $a_href?>" title="<?php echo $list[$i]["subject"]?>">
                    <?php echo $list[$i]["subject"]?>
                </a>
            </li>
    <?php }?>
    <?php if (count($list) == 0) { //게시물이 없을 때  ?>
            <li>게시물이 없습니다.</li>
    <?php }  ?>
        </ul>
    </div>