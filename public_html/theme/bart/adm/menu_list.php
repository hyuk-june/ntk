<?php
$sub_menu = "801200";
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '사이트메뉴관리';
//$administrator = 1;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.G5_THEME_CSS_URL.'/font-awesome.min.css" />');

$colspan=13;

//메뉴 탐색기 생성
$mm = btb\BMenu::getInstance();

//메뉴목록 구함
$list = $mm->getList('both');

//메뉴타입
$type_s = new bt\html\BSelectbox();
$type_s->add('board', '게시판');
$type_s->add('page', '페이지');
$type_s->add('wpage', '위젯페이지');
$type_s->add('mpage', '모듈');
$type_s->add('link', '링크');

//PC용 프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);

//PC용 레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);

//링크타겟옵션 만들기
$target_s = new bt\html\BSelectbox();
$target_s->add('_self', '현재창');
$target_s->add('_blank', '새창');

//접속기기 옵션 만들기
$device_s = new bt\html\BSelectbox();
$device_s->add('both', '모두');
$device_s->add('pc', 'PC');
$device_s->add('mobile', '모바일');

include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style type='text/css'>
.type_group{color:#808000}
.type_board{color:#777}
.type_page{color:#8080FF}
.type_link{color:#FC6727}
.td_skin{width:120px;text-align:center}
.cell-name i{display:inline-block; margin-right:5px;}
.cell-name i.disable{color:#ccc;}
.cell-name .btn-up{color:red}
.cell-name .btn-dn{color:blue}
.cell-name .btn-add{color:green}
</style>

<script type="text/javascript" src="<?php echo G5_THEME_JS_URL?>/bt.common.js"></script>

<script type="text/javascript">
<!--
function openEditor(){
	var qstr = '';
	
	if(arguments[0]!=undefined && arguments[0].trim()!='') qstr = '?bm_pidx=' + arguments[0];
	if(arguments[1]!=undefined && arguments[1].trim()!='') qstr = '?bm_idx=' + arguments[1];
	
	var url = './menu_form.php' + qstr;
	Bt.win.open(url, 'wmenu', 600, 850, true, true);
}

function chkDel(bm_idx){
	if(!confirm('정말 삭제할까요?')) return;
	location.href='./menu_update.php?w=d&bm_idx=' + bm_idx;
}
//-->
</script>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    생성된 메뉴수 <?php echo number_format(count($list)) ?>
</div>

<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
    <a href="./menu_form.php" onclick="openEditor();return false;" id="mm_add">최상위 메뉴 추가</a>
</div>
<?php } ?>

<form name="fmenulist" id="fmenulist" action="./menu_update.php" onsubmit="return fmenulist_submit(this);" method="post">
<input type="hidden" name="w" value="mu">
<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">
            <label for="chkall" class="sound_only">그룹 전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col">메뉴아이디</th>
        <th scope="col">메뉴이름</th>
        <th scope="col">메뉴타입</th>
        <th scope="col">링크타겟</th>
        <th scope="col">프레임</th>
        <th scope="col">레이아웃</th>
        <th scope="col">접속기기</th>
        <th scope="col">수정</th>
        <th scope="col">삭제</th>
    </tr>
    </thead>
    <tbody>
	<?php
    for ($i=0;$i<count($list);$i++)
    {
    	$row = $list[$i];
        
        $bm_name = $row['bm_name'];
    	
    	if($row['bm_type']=='board') $bm_type = "게시판";
    	else if($row['bm_type']=='page') $bm_type = "페이지";
        else if($row['bm_type']=='wpage') $bm_type = "위젯페이지";
        else if($row['bm_type']=='mpage') $bm_type = "모듈";
    	else if($row['bm_type']=='link') $bm_type = "링크";
    	
        $s_upd = '<a href="./menu_form.php?w=u&amp;bm_idx='.$row['bm_idx'].'" onclick="openEditor(\'\', \''.$row['bm_idx'].'\');return false" class="button"><i class="fa fa-pencil fa-lg"></i></a>';
        $s_del = '<a href="./menu_update.php?w=d&amp;bm_idx='.$row['bm_idx'].'" onclick="chkDel(\''.$row['bm_idx'].'\');return false"><i class="fa fa-remove fa-lg"></i></a>';
        
        //위로 버튼
        if($row['ulink']) $s_up = '<a class="btn-up" href="./menu_update.php?w=up&amp;bm_idx='.$row['bm_idx'].'&amp;bm_pidx='.$row['bm_pidx'].'&amp;bm_step='.$row['bm_step'].'" title="위로이동"><i class="fa fa-arrow-up fa-lg"></i></a>';
        else $s_up = '<i class="fa fa-arrow-up fa-lg disable"></i>';
        
        //아래로 버튼
        if($row['dlink']) $s_dn = '<a class="btn-dn" href="./menu_update.php?w=dn&amp;bm_idx='.$row['bm_idx'].'&amp;bm_pidx='.$row['bm_pidx'].'&amp;bm_step='.$row['bm_step'].'" title="아래로이동"><i class="fa fa-arrow-down fa-lg"></i></a>';
        else $s_dn = '<i class="fa fa-arrow-down fa-lg disable"></i>';
        
        //하위메뉴추가 버튼
        $s_add = '<a class="btn-add" href="./menu_update.php?w=&amp;bm_pidx='.$row['bm_idx'].'" title="하위메뉴추가" onclick="openEditor(\'./menu_form.php?w=&amp;bm_pidx='.$row['bm_idx'].'\');return false;"><i class="fa fa-plus fa-lg"></i></a>';

        $bg = 'bg'.($i%2);
        
        //SelectBox 들
        $target_s->selectedFromValue = $row['bm_target'];
        
        $frame_s->selectedFromValue = $row['bm_skin_frame'];
        
        $layout_s->selectedFromValue = $row['bm_skin_layout'];
        
        $device_s->selectedFromValue = $row['bm_device'];
        
        $padding_left = $row['bm_depth'] * 20 + 4;
        
        $alink = btb\BMenu::getMenuLink($row);
        
        if($row['bm_type']=='board' || $row['bm_type']=='page' || $row['bm_type']=='wpage' || $row['bm_type']=='mpage') $att = $row['bm_mid'];
        else if($row['bm_type']=='link') $att = '바로가기';
    ?>
    <tr>
    	<td class="td_chk">
            <input type="hidden" name="bm_idx[<?php echo $i ?>]" value="<?php echo $row['bm_idx'] ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only"><?php echo $row['gr_subject'] ?> 그룹</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td>
            <a href="<?php echo $alink?>" target="_blank"><?php echo $row['bm_mid']?></a>
        </td>
        <td class="cell-name" style="text-align:left;padding-left:<?php echo $padding_left?>px">
            <?php //echo (int)$row['bm_depth'] > 0 ? '<i class="fa fa-arrow-right"></i> ':'';?>
            <?php echo $s_up?><?php echo $s_dn?><?php echo $s_add?> <?php echo get_text($bm_name)?>
        </td>
        <td><span class="type_<?php echo $row['bm_type']?>"><?php echo $bm_type?></span></td>
        <td>
        	<label for="bm_target_<?php echo $i; ?>" class="sound_only">타겟</label>
            <select name="bm_target[<?php echo $i ?>]"><?php echo $target_s->getOption()?></select>
        </td>
        <td>
        <?php if($row["bm_type"]=="board" || $row["bm_type"]=="link"){?>
        	<select name="bm_skin_frame[<?php echo $i ?>]"><?php echo $frame_s->getOption()?></select>
        <?php }else{?>
            -
        <?php }?>
        </td>
        <td>
        <?php if($row["bm_type"]=="board" || $row["bm_type"]=="link"){?>
            <select name="bm_skin_layout[<?php echo $i ?>]"><?php echo $layout_s->getOption()?></select>
        <?php }else{?>
            -
        <?php }?>
        </td>
        <td>
        	<label for="bm_device_<?php echo $i?>" class="sound_only">접속기기</label>
        	<select name="bm_device[<?php echo $i?>]"><?php echo $device_s->getOption()?></select>
        </td>
        <td class="td_grid">
        	<?php echo $s_upd?>
        </td>
        <td class="td_grid">
        	<?php echo $s_del?>
        </td>
    </tr>

	<?php
    }
    if ($i == 0)
        echo '<tr><td colspan="'.$colspan.'" class="empty_table">자료가 없습니다.</td></tr>';
    ?>
    </tbody>
	</table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" onclick="document.pressed=this.value" value="선택수정" class="btn btn_01">
    <a href="./menu_form.php" onclick="openEditor();return false;" id="mm_add" class="btn btn_01">최상위 메뉴 추가</a>
</div>

</form>

<script type="text/javascript">
<!--
function moduleSetup(bm_idx){
    Bt.win.open('module_setup.php?bm_idx=' + bm_idx, 'msetup', 800, 800, 'true', 'true');
}
//-->
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');