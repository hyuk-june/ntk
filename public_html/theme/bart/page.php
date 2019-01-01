<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

include_once(G5_LIB_PATH.'/thumbnail.lib.php');

include_once('./_common.php');

$sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_id='".$mid."'";
$pgrow = $bdb->fetch($sql);

$pg_id = $pgrow["pg_id"];

if(!$pgrow){
    alert('해당 페이지가 존재하지 않습니다');
}

if($member['mb_level'] < $pgrow['pg_level_min'] || $member['mb_level'] > $member['mb_level']){
    if(!$is_member){
        goto_url(G5_BBS_URL.'/login.php?url='.urlencode($_SERVER["REQUEST_URI"]));
    }else{
        alert('접근 권한이 없습니다');
    }
}


$frame_skin = bt\binstr($pgrow["pg_skin_frame"], 'basic');
$layout_skin = bt\binstr($pgrow["pg_skin_layout"], 'basic');
$content = $pgrow['pg_content'];


//===========================================================================
// 메뉴에 속하지 않아서 제목, description 이 없으면 page테이블에서 직접 불러온다
//===========================================================================
//if(!is_array($bt['curpath']) || count($bt['curpath']) <= 0){
    $cur_title = bt\binstr($pgrow["pg_title"], $g5['title']);
    $cur_subtitle = $pgrow["pg_subtitle"];
    $cur_keyword = $pgrow["pg_keyword"];
    $cur_desc = $pgrow["pg_desc"];
//}


$g5['title'] = $cur_title;
include_once('./_head.php');
?>

<?php btb\show_widgets('page', $pg_id, "page_top");?>
<section>
	<?php echo get_view_thumbnail($content, $btcfg['bc_image_width']);?>
</section>
<?php btb\show_widgets('page', $pg_id, "page_bot");?>

<?php
include_once('./_tail.php');