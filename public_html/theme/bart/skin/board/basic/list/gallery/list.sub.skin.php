<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$sub_urls['list'].'/list.sub.skin.css" />');

$col['xs'] = bt\binstr($bcfg['numpr']['xs'], 2);
$col['sm'] = bt\binstr($bcfg['numpr']['sm'], 2);
$col['md'] = bt\binstr($bcfg['numpr']['md'], 4);
$col['lg'] = bt\binstr($bcfg['numpr']['lg'], 4);
$col['xl'] = bt\binstr($bcfg['numpr']['xl'], 6);

ob_start();
?>
<style type="text/css">
.bo-list-gallery ul.plist >li{ width:<?php echo round(100 / $col['xs'], 4)?>%;}

@media(max-width:576px){
    .bo-list-gallery ul.plist >li{ width:<?php echo round(100 / $col['sm'], 4)?>%;}
}

@media(min-width:768px){
    .bo-list-gallery ul.plist >li{ width:<?php echo round(100 / $col['md'], 4)?>%; }
}

@media(min-width:992px){
    .bo-list-gallery ul.plist >li{ width:<?php echo round(100 / $col['lg'], 4)?>%; }
}

@media(min-width:1200px){
    .bo-list-gallery ul.plist >li{ width:<?php echo round(100 / $col['xl'], 4)?>%; }
}
</style>
<?php
$style = ob_get_contents();
add_stylesheet($style);
ob_end_clean();
?>

<div class="bo-list-gallery">
    
    <!-- 게시판 페이지 정보 및 버튼 시작 -->
    <div class="bo-head-btns mb-2 d-sm-flex">
        <div>
            <!-- 게시판 검색 시작 -->
            <div id="bo_sch">
                <form name="fsearch" method="get">
                    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
                    <input type="hidden" name="sca" value="<?php echo $sca ?>">
                    <input type="hidden" name="sop" value="and">
                    <label for="sfl" class="sound_only">검색대상</label>
                    
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="sfl" id="sfl">
                                <option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
                                <option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
                                <option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
                                <option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
                                <option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
                                <option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
                                <option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
                            </select>
                        </div>
                        <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
                        <input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="required form-control form-control-sm" maxlength="20">
                        <div class="input-group-append">
                            <input type="submit" value="검색" class="btn btn-outline-secondary">
                        </div>
                        <!--<div class="input-group-append">
                            
                        </div>-->
                    </div>
                </form>
            </div>
            <!-- //게시판 검색 끝 -->
        </div>
        
        <div class="page-info d-none d-sm-block"><span>Total <?php echo number_format($total_count) ?>건</span> <?php echo $page ?> 페이지</div>
        
    </div>
    <div class="clearfix"></div>


    <!-- 카테고리 -->
    <?php $category_href = G5_BBS_URL.'/board.php?bo_table='.$bo_table;?>
    <?php if ($is_category) { ?>    
        <!-- PC용 카테고리 -->
        <nav class="category d-none d-sm-block">
            <h2><?php echo $board['bo_subject'] ?> 카테고리</h2>
            <ul id="bo_cate_ul">
                <li<?php echo !bt\isval($sca) ? ' class="active"':''?>>
                    <a href="<?php echo $category_href?>">
                        전체
                    </a>
                </li>
            <?php
            for ($i=0; $i<count($categories); $i++) {
                $active = "";
                if($categories[$i]==$sca) $active = "active";
            ?>
                <li class="<?php echo $active?>">
                    <a href="<?php echo $category_href."&amp;sca=".urlencode($categories[$i])?>">
                        <?php echo $categories[$i]?>
                    </a>
                </li>
            <?php }?>
            </ul>
        </nav>
        <!-- //PC용 카테고리 -->
        
        <!-- 모바일용 카테고리 -->
        <div id="bo_cate_m" class="category dropdown d-sm-none mb-2">
            <button class="btn btn-default dropdown-toggle d-block" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                카테고리
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <?php
            for ($i=0; $i<count($categories); $i++) {
                $active = "";
                if($categories[$i]==$sca) $active = "active";
            ?>
                <li class="<?php echo $active?>">
                    <a href="<?php echo $category_href."&amp;sca=".urlencode($categories[$i])?>">
                        <?php echo $categories[$i]?>
                    </a>
                </li>
            <?php }?>
            </ul>
        </div>
        <!-- //모바일용 카테고리 -->
    <?php } ?>
    <!-- //카테고리 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
        <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
        <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
        <input type="hidden" name="stx" value="<?php echo $stx ?>">
        <input type="hidden" name="spt" value="<?php echo $spt ?>">
        <input type="hidden" name="sca" value="<?php echo $sca ?>">
        <input type="hidden" name="sst" value="<?php echo $sst ?>">
        <input type="hidden" name="sod" value="<?php echo $sod ?>">
        <input type="hidden" name="page" value="<?php echo $page ?>">
        <input type="hidden" name="sw" value="">
        <input type="hidden" name="btn_submit" id="btn_submit">
    
    
        <ul class="plist d-flex flex-wrap">
    <?php
    for ($i=0; $i<count($list); $i++) {
        
        $cls = array();
        if ($wr_id == $list[$i]['wr_id']){
            $strnum = "<span class=\"bo_current\">열람중</span>";
            $cls[] = ' row-current';
        }else{
            $strnum = $list[$i]['num'];
        }
        if(count($cls) > 0) $tdcls = ' '.@implode('', $cls);
        else $tdcls = '';
        
        $thumb_w = bt\binstr($bcfg["thumb_w"], 400);
        $thumb_h = bt\binstr($bcfg["thumb_h"], 300);
        
        $thumb = btb\get_list_thumbnail(
            $board['bo_table'], $list[$i]['wr_id'], $thumb_w, $thumb_h, 
            array(
                "sizefix" => true,
                "crop_posx" => bt\image\BThumbnail::CROP_POSX_CENTER,
                "crop_posy" => bt\image\BThumbnail::CROP_POSY_MIDDLE,
                "is_anigif_thumb" => true
            )
        );
        
        if($thumb){
            $img = '<img src="'.$thumb['src'].'" class="img-fluid" alt="'.$list[$i]["subject"].'">';
        }else{
            $img = '<div class="blank-img">이미지 없음</div>';
        }
    ?>
            <li>
            
                <div class="num sound_only"><?php echo $strnum?></div>
            
        <?php if ($is_checkbox) { ?>
            
                    <label for="chk_wr_id_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['subject'] ?></label>
                    <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            
        <?php } ?>
                <div class="cell-subject">
                
                    <div class="thumb"><a href="<?php echo $list[$i]['href'] ?>"><?php echo $img?></a></div>
                    
                    <div class="desc ellipsis">
                    
        <?php if ($is_category && $list[$i]['ca_name']) {?>
                        <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="bo_cate_link"><?php echo $list[$i]['ca_name'] ?></a>
        <?php } ?>
                        <?php
                        // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                        // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                        if (isset($list[$i]['icon_new'])) echo $list[$i]['icon_new'];
                        if (isset($list[$i]['icon_hot'])) echo $list[$i]['icon_hot'];
                        if (isset($list[$i]['icon_link'])) echo $list[$i]['icon_link'];
                        if (isset($list[$i]['icon_secret'])) echo $list[$i]['icon_secret'];
                        ?>
        
                        <a href="<?php echo $list[$i]['href'] ?>" title="<?php echo $list[$i]["subject"]?>">
                            <?php echo $icons?>
                            <?php echo $list[$i]["subject"]?>
                            
                            <?php if((int)$list[$i]["wr_comment"] > 0){?>
                                <span class="cmt-cnt float-right">+<?php echo $list[$i]["wr_comment"]?></span>
                            <?php }?>
                        </a>
                    </div>
        
                    <div class="foot">
                        <ul>
                    <?php if($list_show_writer){?>
                            <li>
                                <span class="writer sv_use"><i class="fa fa-user"></i> <?php echo $list[$i]['name'];?></span>
                            </li>
                    <?php }?>
                    
                    <?php if($list_show_hit){?>
                            <li>
                                <span class="hit"><i class="fa fa-eye"></i> <?php echo number_format($list[$i]["wr_hit"]);?></span>
                            </li>
                    <?php }?>
                    
                    <?php if($list_show_datetime){?>
                            <li>
                                <span class="datetime"><i class="fa fa-calendar"></i> <?php echo $list[$i]["datetime"];?></span>
                            </li>
                    <?php }?>
                
                        
                <?php if($list_show_good || $list_show_nogood){?>
                            <li>
                                <div class="status-row">
                            
                    <?php if($list_show_good){?>
                                    <span class="good"><i class="fa fa-thumbs-o-up"></i> <?php echo number_format($list[$i]["wr_good"]);?></span>
                    <?php }?>
                        
                    <?php if($list_show_nogood){?>
                                    <span class="nogood"><i class="fa fa-thumbs-o-down"></i> <?php echo number_format($list[$i]["wr_nogood"]);?></span>
                    <?php }?>
                                </div>
                            </li>
                        </ul>
            <?php }?>
                    </div>
                </div>
            </li>
    <?php }?>
        </ul>
    



<?php if (count($list) == 0) {?>
        <div class="border p-5 mt-2 text-center">게시물이 없습니다.</div>
    <?php }?>
        
        

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
        <div class="d-flex mt-2 <?php echo ($is_checkbox) ? 'justify-content-between' : 'justify-content-end'?>">
            <?php if ($is_checkbox) { ?>
            <div>
                <ul class="btn-bo-adm d-none d-sm-flex">
                    <li><button type="submit" onclick="document.pressed='선택삭제'" class="btn btn-danger mr-1"><i class="fa fa-trash-alt"></i><span class="d-none d-sm-inline">&nbsp;선택삭제</span></button></li>
                    <li><button type="submit" onclick="document.pressed='선택복사'" class="btn btn-danger mr-1"><i class="fa fa-copy"></i><span class="d-none d-sm-inline">&nbsp;선택복사</span></button></li>
                    <li><button type="submit" onclick="document.pressed='선택이동'" class="btn btn-danger mr-1"><i class="fa fa-arrows-alt"></i><span class="d-none d-sm-inline">&nbsp;선택이동</span></button></li>
                    <li><a href="<?php echo $admin_href ?>" class="btn btn-danger mr-1"><i class="fa fa-cog"></i><span class="d-none d-sm-inline">&nbsp;기본설정</span></a></li>
                    <li><a href="#" onclick="Bt.board.openConfig('<?php echo $bo_table?>');" class="btn btn-danger"><i class="fa fa-cogs"></i><span class="d-none d-sm-inline">&nbsp;기타설정</span></a></li>
                </ul>
                
                <div class="dropdown d-block d-sm-none">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="board_buttons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                        Control
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="board_buttons">
                        <li class="dropdown-item"><a href="#" id="btn_del" onclick="document.pressed='선택삭제'"><i class="fa fa-trash-alt mr-1"></i>선택삭제</a></li>
                        <li class="dropdown-item"><a href="#" id="btn_copy" onclick="document.pressed='선택복사'"><i class="fa fa-copy mr-1"></i>선택복사</a></li>
                        <li class="dropdown-item"><a href="#" id="btn_move" onclick="document.pressed='선택이동'"><i class="fa fa-arrows-alt mr-1"></i>선택이동</a></li>
                        <li class="dropdown-item"><a href="<?php echo $admin_href ?>"><i class="fa fa-cog mr-1"></i>기본설정</a></li>
                        <li class="dropdown-item"><a href="#" onclick="Bt.board.openConfig('<?php echo $bo_table?>');"><i class="fa fa-cogs mr-1"></i>기타설정</a></li>
                    </ul>
                </div>
            </div>
            <?php } ?>
            
            <?php if ($list_href || $write_href) { ?>
            <ul class="btn-bo-user">
                <?php if ($rss_href) { ?><li class="float-left"><a href="<?php echo $rss_href ?>" class="btn btn-dark mr-1"><i class="fa fa-rss"></i>&nbsp;RSS</a></li><?php } ?>
                <?php if ($list_href) { ?><li class="float-left"><a href="<?php echo $list_href ?>" class="btn btn-dark mr-1"><i class="fa fa-list"></i>&nbsp;목록</a></li><?php } ?>
                <?php if ($write_href) { ?><li class="float-left"><a href="<?php echo $write_href ?>" class="btn btn-danger"><i class="fa fa-pencil-alt"></i>&nbsp;글쓰기</a></li><?php } ?>
            </ul>
            <?php } ?>
        </div>
        <div class="clearfix"></div>
    <?php } ?>
    </form>
    
    
    <!-- 페이지 -->
    <div class="text-center">
        <?php echo btb\get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');?>
    </div>
    
</div>