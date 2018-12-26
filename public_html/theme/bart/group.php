<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/group.php');
    return;
}

if(!$is_admin && $group['gr_device'] == 'mobile')
    alert($group['gr_subject'].' 그룹은 모바일에서만 접근할 수 있습니다.');

$g5['title'] = $group['gr_subject'];
include_once(G5_THEME_PATH.'/head.php');
include_once(G5_LIB_PATH.'/latest.lib.php');

$list = array();

$sql = "SELECT m.*, b.bo_table 
		FROM bt_menu m LEFT OUTER JOIN g5_board b ON b.bo_table=m.bm_mid
		WHERE m.bm_device<>'mobile'
		AND bo_list_level <= '".$member[mb_level]."'
		AND m.bm_hide <> '1' ORDER BY bm_step";
		
$data = $bdb->fetchAll($sql);


/*$sql = "SELECT m.*, b.bo_table 
	FROM bt_menu m LEFT OUTER JOIN g5_board b ON b.bo_table=m.bm_mid
	WHERE m.bm_idx=".$bt["curmenu"]["bm_idx"]."
	AND bo_list_level <= '".$member[mb_level]."'
	AND m.bm_device<>'mobile' AND m.bm_hide <> '1'";
echo $sql;
$data = $bdb->fetchAll($sql);*/

$ms = kr\bartnet\builder\BMenu::getInstance();

$list = array();

$ms->seekSetCate($list, $data, $bt["curmenu"]["bm_idx"]);

include_once('./_head.php');
include(BT_SKIN_PATH.'/group/'.$bt["curmenu"]['bm_skin_group'].'/group.skin.php');
include_once('./_tail.php');