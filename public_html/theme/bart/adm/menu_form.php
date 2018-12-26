<?php
$sub_menu = "801200";
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '사이트메뉴관리';
$administrator = 1;

$bm_idx = $_GET['bm_idx'];
$bm_pidx = $_GET['bm_pidx'];

//===========================================================================
// 메뉴타입 옵션
//===========================================================================
$type_s = new bt\html\BSelectbox();
$type_s->add('board', '게시판');
$type_s->add('page', '페이지');
$type_s->add('wpage', '위젯페이지');
$type_s->add('mpage', '모듈페이지');
$type_s->add('link', '링크');

//===========================================================================
// 게시판 목록 옵션
//===========================================================================
$board_s = new bt\html\BSelectbox();
$sql = "SELECT bo_table, bo_subject FROM ".$g5['board_table'];
$result = sql_query($sql);
while($row = sql_fetch_array($result)){
	$board_s->add($row['bo_table'], '['.$row['bo_table'].'] '.$row['bo_subject']);
}

//===========================================================================
// 스킨 옵션
//===========================================================================
// 프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);
$mframe_s = bt\get_select($dir);

// 레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);
$mlayout_s = bt\get_select($dir);


//===========================================================================
// 기타
//===========================================================================
//페이지 목록
$sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_system=0 ORDER BY pg_regdate";
$result = sql_query($sql);
$page_s = new bt\html\BSelectbox();
$wpage_s = new bt\html\BSelectbox();
$mpage_s = new bt\html\BSelectbox();
while($row = sql_fetch_array($result)){
    switch ($row['pg_type']) {
    case "page":
        $page_s->add($row['pg_id'], '['.$row['pg_id'].'] '.$row['pg_title']);
        break;
    case "wpage":
        $wpage_s->add($row['pg_id'], '['.$row['pg_id'].'] '.$row['pg_title']);
        break;
    case "mpage":
        $mpage_s->add($row['pg_id'], '['.$row['pg_id'].'] '.$row['pg_title']);
        break;
    }
}

//링크타겟옵션 만들기
$target_s = new bt\html\BSelectbox();
$target_s->add('_self', '현재창');
$target_s->add('_blank', '새창');


//접속기기 옵션 만들기
$device_s = new bt\html\BSelectbox();
$device_s->add('both', '모두');
$device_s->add('pc', 'PC');
$device_s->add('mobile', '모바일');


//수정이면
if($bm_idx){
	$sql = "SELECT a.*, b.bm_name as p_name 
		FROM ".$bt['menu_table']." a 
		LEFT OUTER JOIN ".$bt['menu_table']." b 
		ON a.bm_pidx=b.bm_idx 
		WHERE a.bm_idx=".$bm_idx;
		
	$view = sql_fetch($sql);
	$p_name = bt\binstr($view['p_name'], "최상위");
	if($view['bm_type']=='board') $board_s->selectedFromValue = $view['bm_mid'];
	
	$frame_s->selectedFromValue = $view['bm_skin_frame'];
    $mframe_s->selectedFromValue = $view['bm_skin_mframe'];
    
    $layout_s->selectedFromValue = $view['bm_skin_layout'];
    $mlayout_s->selectedFromValue = $view['bm_skin_mlayout'];
	
	if($view['bm_type']=='page') $page_s->selectedFromValue = $view['bm_mid'];
    if($view['bm_type']=='wpage') $wpage_s->selectedFromValue = $view['bm_mid'];
    if($view['bm_type']=='mpage') $mpage_s->selectedFromValue = $view['bm_mid'];
	
	$target_s->selectedFromValue = $view['bm_target'];
	$device_s->selectedFromValue = $view['bm_device'];
	
	$w = 'u';
	
//추가이면
}else{
	$bm_pidx = $_GET['bm_pidx'];
	
	//부모정보
	if((int)$bm_pidx > 0){
        $rs = btb\BMenu::getInstance()->getByIdx($bm_pidx);
		$p_name = $rs["bm_name"];
        unset($rs);
	}else{
		$p_name = "최상위";
	}
	
	$w = '';
}

add_stylesheet('<style type="text/css">'.PHP_EOL
    .'.menu_attr{display:none}'.PHP_EOL
    .'</style>');
    
add_stylesheet('<link rel="stylesheet" type="text/css" href="'.G5_ADMIN_URL.'/css/admin_extend_bt.css" />');

add_javascript('<script type="text/javascript" src="'.BT_JS_URL.'/bt.common.js"></script>');
    
include_once(G5_PATH.'/head.sub.php');
?>



<form name="fmenuform" id="fmenuform" action="./menu_update.php" onsubmit="return fmenuform_submit(this)" method="post">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="bm_idx" value="<?php echo $bm_idx?>">
<input type="hidden" name="bm_pidx" value="<?php echo $bm_pidx?>">
<section>
    <h2 class="h2_frm">메뉴 설정</h2>

    <div class="tbl_frm01 tbl_wrap">
        <table>
        <caption>게시판 기본 설정</caption>
        <tbody>
        <tr>
            <th scope="row"><label for="bm_code">상위메뉴</label></th>
            <td><?php echo $p_name?></td>
        </tr>
        <tr>
        	<th scope="row"><label for="bm_type">메뉴타입</label></th>
        	<td>
        		<span class="frm_info" style="margin-top:5px">해당메뉴를 클릭했을때 화면에 표시할 모듈타입을 정의합니다.</span>
        		<span class="frm_info">하위메뉴는 메뉴타입과 상관없이 추가할 수 있습니다</span>
        		
        		<input type="radio" name="bm_type" class="bm_type" id="bm_type_1" value="board" <?php echo !bt\isval($view['bm_type']) || $view['bm_type']=='board'?"checked='checked'":'';?> >
        		<label for="bm_type_1">게시판</label>
        		
        		<input type="radio" name="bm_type" class="bm_type" id="bm_type_2" value="page" <?php echo $view['bm_type']=='page'?"checked='checked'":'';?> >
        		<label for="bm_type_2">페이지</label>
                
                <input type="radio" name="bm_type" class="bm_type" id="bm_type_3" value="wpage" <?php echo $view['bm_type']=='wpage'?"checked='checked'":'';?> >
                <label for="bm_type_3">위젯페이지</label>
                
                <input type="radio" name="bm_type" class="bm_type" id="bm_type_4" value="mpage" <?php echo $view['bm_type']=='mpage'?"checked='checked'":'';?> >
                <label for="bm_type_4">모듈페이지</label>
        		
        		<input type="radio" name="bm_type" class="bm_type" id="bm_type_5" value="link" <?php echo $view['bm_type']=='link'?"checked='checked'":'';?> >
        		<label for="bm_type_5">링크</label>
        		
        	</td>
        </tr>
        <tr class="title">
            <th scope="row"><label for="bm_name">메뉴이름</label></th>
            <td><input type="text" name="bm_name" value="<?php echo $view['bm_name']?>" class="frm_input" size="20" maxlength="20" /></td>
        </tr>
        <tr class="subtitle">
            <th scope="row"><label for="bm_subtitle">부제목</label></th>
            <td><input type="text" name="bm_subtitle" value="<?php echo $view['bm_subtitle']?>" class="frm_input" size="40" /></td>
        </tr>
        <tr>
        	<th scope="row"><label for="bm_target">링크타겟</label></th>
        	<td><select name="bm_target"><?php echo $target_s->getOption()?></select></td>
        </tr>
        <tr>
        	<th scope="row"><label for="bm_device">접속기기</label></th>
        	<td><select name="bm_device"><?php echo $device_s->getOption()?></select></td>
        </tr>
        <tr class="skins">
        	<th scope="row"><label for="bm_skin_frame">프레임</label></th>
        	<td><select name="bm_skin_frame" id="bm_skin_frame"><?php echo $frame_s->getOption()?></select></td>
        </tr>
        <tr class="skins">
            <th scope="row"><label for="bm_skin_layout">레이아웃</label></th>
            <td><select name="bm_skin_layout" id="bm_skin_layout"><?php echo $layout_s->getOption()?></select></td>
        </tr>
        <tr>
            <th scope="row"><label for="bm_icon">아이콘</label></th>
            <td><input type="text" name="bm_icon" id="bm_icon" value="<?php echo $view["bm_icon"]?>" class="frm_input">
                [<a href="#" onclick="openIcons();">아이콘보기</a>]
            </td>
        </tr>
        </table>
        
        
    	<table id="attr_board" class="menu_attr">
        <caption>게시판</caption>
        <tbody>
        <tr>
        	<th scope="row"><label for="bo_table">게시판선택</label></th>
        	<td><select name="bo_table"><?php echo $board_s->getOption()?></select>
        		<span class="frm_info">1.다른메뉴에서 사용중인 게시판은 선택할 수 없습니다</span>
        		<span class="frm_info">2.게시판 설정에 반드시 아래와 같이 입력하셔야 메뉴가 적용됩니다.</span>
        		<span class="frm_info">
        		상단파일경로 : _head.php<br />
        		하단파일경로 : _tail.php
        		</span>
        	</td>
        </tr>
        </tbody>
    	</table>
    	
    	<table id="attr_page" class="menu_attr">
        <caption>페이지</caption>
        <tbody>
        <tr>
        	<th scope="row"><label for="pg_id">페이지선택</label></th>
        	<td><select name="pg_id" id="pg_id"><?php echo $page_s->getOption()?></select>
        		<span class="frm_info" style="margin-top:5px">다른메뉴에서 사용중인 페이지는 선택하지 마세요</span>
        	</td>
        </tr>
        </tbody>
    	</table>
        
        <table id="attr_wpage" class="menu_attr">
        <caption>위젯페이지</caption>
        <tbody>
        <tr>
            <th scope="row"><label for="wp_id">위젯페이지선택</label></th>
            <td><select name="wp_id" id="wp_id"><?php echo $wpage_s->getOption()?></select>
                <span class="frm_info" style="margin-top:5px">다른메뉴에서 사용중인 페이지는 선택하지 마세요</span>
            </td>
        </tr>
        </tbody>
        </table>
        
        <table id="attr_mpage" class="menu_attr">
        <caption>모듈페이지</caption>
        <tbody>
        <tr>
            <th scope="row"><label for="mp_id">모듈페이지선택</label></th>
            <td>
                <select name="mp_id" id="mp_id"><?php echo $mpage_s->getOption()?></select>
            </td>
        </tr>
        </tbody>
        </table>
    	
    	<table id="attr_link" class="menu_attr">
        <caption>링크</caption>
        <tbody>
        <tr>
            <th scope="row"><label for="bm_mid">메뉴ID</label></th>
            <td>
                <span class="frm_info">중복되지 않는 메뉴ID를 입력해주세요</span>
                <span class="frm_info">해당페이지가 사이트내부에 있을경우 소스 최상단에 아래처럼 추가해주세요</span>
                <span class="frm_info">아래코드를 적용할 경우 현재위치와 메뉴위치가 활성화됩니다</span>
                <span class="frm_info">
                    &lt;?php<br>
                    $mid="아래 입력한 메뉴ID";
                </span>
                <input type="text" name="bm_mid" value="<?php echo $view['bm_mid']?>" class="frm_input" size="20" maxlength="40" />
            </td>
        </tr>
    	<tr>
        	<th scope="row"><label for="bm_url">URL</label></th>
        	<td>
                <span class="frm_info" style="margin-top:5px">연결할 페이지의 URL을 입력해주세요</span>
                <span class="frm_info">예) http://www.google.co.kr/page.html</span>
                <input type="text" name="bm_url" value="<?php echo $view['bm_url']?>" class="frm_input" size="50" maxlength="255" />
        	</td>
        </tr>
        </table>
        
    </div>
</section>

<div class="btn_confirm01 btn_confirm">
    <input type="submit" value="확인" class="btn_submit" accesskey="s">
    <a href="menu_list.php?<?php echo $qstr ?>" onclick="window.close();return false">창닫기</a>
</div>
</form>



<script type="text/javascript">
<!--
function showAttr(){
    
    var mode = $('.bm_type:checked').val();

    $('.title').hide();
    $('.subtitle').hide();
    $('.menu_attr').hide();
    $('.skins').hide();
    
    if(mode == 'board'){
        $('#attr_board').show();
        $('.title').show();
        $('.subtitle').show();
        $('.skins').show();
        
    }else if(mode == 'page'){
        $('#attr_page').show();
        
    }else if(mode == 'wpage'){
        $('#attr_wpage').show();
        
    }else if(mode == 'mpage'){
        $('#attr_mpage').show();
        
    }else if(mode == 'link'){
        $('.title').show();
        $('.subtitle').show();
        $('#attr_link').show();
        $('.skins').show();
    }
}

function fmenuform_submit(f){
    var bm_type = $('.bm_type:checked').val();

    if(bm_type == 'board'){
        if(f.bm_name.value == ''){
            alert('메뉴이름을 입력해 주세요');
            f.bm_name.focus();
            return false;
            
        }else if(f.bo_table.value == ''){
            alert('게시판을 선택해 주세요');
            f.bo_table.focus();
            return false;
        }
    }else if(bm_type == 'page'){
        if(f.pg_id.value == ''){
            alert('페이지를 선택해 주세요');
            f.pg_id.focus();
            return false;
        }
    }else if(bm_type == 'wpage'){
        if(f.wp_id.value == ''){
            alert('위젯페이지를 선택해 주세요');
            f.wp_id.focus();
            return false;
        }
    }else if(bm_type == 'mpage'){
        if(f.mp_id.value == ''){
            alert('모듈을 선택해 주세요');
            f.mp_id.focus();
            return false;
        }
    }else if(bm_type == 'link'){
        if(f.bm_name.value == ''){
            alert('메뉴이름을 입력해 주세요');
            f.bm_name.focus();
            return false;
            
        }else if(f.bm_url.value.trim() == ''){
            alert('URL을 입력해 주세요');
            f.bm_url.focus();
            return false;
        }else if(f.bm_mid.value.trim() == ''){
            alert('메뉴ID를 입력해 주세요');
            f.bm_mid.focus();
            return false;
        }
    }
    return true;
}

function openIcons(){
    Bt.win.open('icon_list.php', 'icon_win', 500, 800, true);
}

$(function(){
    showAttr();
    $('.bm_type').click(showAttr);
});
//-->
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>