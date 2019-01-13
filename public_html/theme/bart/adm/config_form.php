<?php
$sub_menu = "801100";
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '사이트기본설정';
$administrator = 1;

include_once(G5_ADMIN_PATH.'/admin.head.php');

bt\array_map_recursive('stripslashes', $btcfg);

//===========================================================================
// 기본설정
//===========================================================================
$frame_main_opts = btb\get_skin_option('frame', $btcfg['bc_skin_frame_main']);

$layout_main_opts = btb\get_skin_option('layout', $btcfg['bc_skin_layout_main']);

$frame_default_opts = btb\get_skin_option('frame', $btcfg['bc_skin_frame_default']);

$layout_default_opts = btb\get_skin_option('layout', $btcfg['bc_skin_layout_default']);

$wpage_main_opts = btb\get_skin_option('wpage', $btcfg['bc_skin_wpage_main']);


//페이지 목록
$Q = "SELECT * FROM ".$bt['page_table']." WHERE pg_system=0 ORDER BY pg_type, pg_title";
$result = sql_query($Q);

$page_main_s = new bt\html\BSelectbox();
$page_main_s->selectedFromValue = $btcfg['bc_pg_id'];
while($wrs = sql_fetch_array($result)){
    $str = '';
    if($wrs['pg_type']=='wpage'){
        $str = '[위젯페이지] ';
    }else if($wrs['pg_type']=='page'){
        $str = '[페이지] ';
    }else if($wrs['pg_type']=='mpage'){
        $str = '[모듈페이지] ';
    }
    $page_main_s->add($wrs['pg_type'].'|'.$wrs['pg_id'], $str.$wrs['pg_title'].'('.$wrs['pg_id'].')' );
}

/*$alim_opts = bt_get_skin_option('alim', 'pc');
$malim_opts = bt_get_skin_option('alim', 'pc', $btcfg['bc_skin_malim']);*/
?>

<script type="text/javascript">
<!--
function cfgform_submit(f){

	return true;
}
//-->
</script>


<form name="cfgform" id="cfgform" action="./config_update.php" method="post" enctype="multipart/form-data" onsubmit="return cfgform_submit(this)">
<input type="hidden" name="token" value="" id="token">
<section>
    <div class="tbl_frm01 tbl_wrap">
    
    	<table>
        <caption>사이트기본설정</caption>
        <colgroup>
            <col class="grid_3">
            <col>
        </colgroup>
        <tbody>
        <tr>
            <th scope="row"><label for="bc_image_width">페이지 이미지 크기</label></th>
            <td><span class="frm_info">페이지생성시 이미지의 가로폭이 아래 이상이면 썸네일로 크기를 조절합니다</span>
            	<input type="text" name="bc_image_width" value="<?php echo $btcfg['bc_image_width']?>" class="frm_input" size="5" maxlength="4" required='' class="required frm_input" />px
            </td>
        </tr>
        <tr>
        	<th scope="row"><label for="bc_skin_frame_main">메인프레임</label></th>
        	<td>
        		<select name="bc_skin_frame_main" id="bc_skin_frame_main" required="required" class="required"><?php echo $frame_main_opts?></select>
        	</td>
        </tr>
        <tr>
            <th scope="row"><label for="bc_skin_layout_main">메인레이아웃</label></th>
            <td>
                <select name="bc_skin_layout_main" id="bc_skin_layout_main" required="required" class="required"><?php echo $layout_main_opts?></select>
                <!--Mobile : <select name="bc_skin_mlayout_main" id="bc_skin_mlayout_main"><?php echo $mlayout_main_opts?></select>-->
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bc_skin_frame_default">기본프레임</label></th>
            <td>
                <select name="bc_skin_frame_default" id="bc_skin_frame_default" required="required" class="required"><?php echo $frame_default_opts?></select>
                <!--Mobile : <select name="bc_skin_mframe_default" id="bc_skin_mframe_default"><?php echo $mframe_default_opts?></select>-->
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bc_skin_layout_default">기본레이아웃</label></th>
            <td>
                <select name="bc_skin_layout_default" id="bc_skin_layout_default" required="required" class="required"><?php echo $layout_default_opts?></select>
                <!--Mobile : <select name="bc_skin_mlayout_default" id="bc_skin_mlayout_default"><?php echo $mlayout_default_opts?></select>-->
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bc_skin_wpage_main">메인페이지</label></th>
            <td>
                <select name="bc_pg_id" id="bc_pg_id" required="required" class="required"><?php echo $page_main_s->getOption()?></select>
                <div>
                    ※ 목록이 존재하지 않을 경우 "위젯페이지관리", "페이지관리", "모듈페이지관리" 중에서 한개를 생성 후 선택해 주세요
                </div>
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="bc_font">기본글꼴</label></th>
            <td>
                <dl>
                    <dt>font-family</dt>
                    <dd><input type="text" name="bc_font_family" class="frm_input" value="<?php echo $btcfg['bc_font_family']?>"></dd>
                    <dt>font css URL</dt>
                    <dd><input type="text" name="bc_font_url" class="frm_input" style="width:100%;" value="<?php echo $btcfg['bc_font_url']?>"></dd>
                </dl>
            </td>
        </tr>
        </tbody>
        </table>
    
    </div>
    
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="적용하기" class="btn_submit" accesskey="s">
</div>

</form>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');
?>