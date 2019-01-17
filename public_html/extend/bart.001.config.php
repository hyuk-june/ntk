<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//===========================================================================
// 네임스페이스 단축
//===========================================================================
use kr\bartnet as bt;
use kr\bartnet\builder as btb;

//===========================================================================
// 디버그모드 or 릴리즈 모드
//===========================================================================
//디버그모드(true), 릴리즈모드(false)
define('BT_DEBUG', false);

if(BT_DEBUG) ini_set('display_errors', '1');
else ini_set('display_errors', '0');



//===========================================================================
// 상수정의
//===========================================================================
define('DS', DIRECTORY_SEPARATOR);

//DB TABLE PREFIX
define('BT_PREFIX', 'bt_');

define('BT_NAME', 'NTK 빌더');

//BART 빌더 경로
define('BT_DIR', 'bart');
define('BT_PATH', G5_PATH.'/theme/'.BT_DIR);
define('BT_URL', G5_URL.'/theme/'.BT_DIR);

//라이브러리 경로
define('BT_LIB_PATH', BT_PATH.'/lib');

//관리자 경로
define('BT_ADMIN_DIR', 'adm');
define('BT_ADMIN_PATH', BT_PATH.'/'.BT_ADMIN_DIR);
define('BT_ADMIN_URL', BT_URL.'/'.BT_ADMIN_DIR);

//위젯 경로
define('BT_WIDGET_DIR', 'widget');
define('BT_WIDGET_PATH', BT_PATH.'/'.BT_WIDGET_DIR);
define('BT_WIDGET_URL', BT_URL.'/'.BT_WIDGET_DIR);

//모듈경로
define('BT_MODULE_DIR', 'module');
define('BT_MODULE_PATH', BT_PATH.'/'.BT_MODULE_DIR);
define('BT_MODULE_URL', BT_URL.'/'.BT_MODULE_DIR);

//JS 경로
define('BT_JS_DIR', 'js');
define('BT_JS_PATH', BT_PATH.'/'.BT_JS_DIR);
define('BT_JS_URL', BT_URL.'/'.BT_JS_DIR);

//CSS 경로
define('BT_CSS_DIR', 'css');
define('BT_CSS_PATH', BT_PATH.'/'.BT_CSS_DIR);
define('BT_CSS_URL', BT_URL.'/'.BT_CSS_DIR);

//스킨 경로
define('BT_SKIN_DIR', 'skin');
define('BT_SKIN_PATH', BT_PATH.'/'.BT_SKIN_DIR);
define('BT_SKIN_URL', BT_URL.'/'.BT_SKIN_DIR);

//위젯 경로
define('BT_WIDGET_DIR', 'widget');
define('BT_WIDGET_PATH', BT_PATH.'/'.BT_WIDGET_DIR);
define('BT_WIDGET_URL', BT_URL.'/'.BT_WIDGET_DIR);

//DATA 경로
define('BT_DATA_DIR', 'bart');
define('BT_DATA_PATH', G5_DATA_PATH.'/'.BT_DATA_DIR);
define('BT_DATA_URL', G5_DATA_URL.'/'.BT_DATA_DIR);


//테마를 빌더로 선택했는지 체크
function bt_check_theme(){
    
    global $config;
    
    if($config['cf_theme'] !== BT_DIR){
        alert('먼저 그누보드 테마설정에서 '.BT_NAME.' 테마로 선택해 주세요', G5_ADMIN_URL.'/theme.php');
        exit;
    }
}

//빌더를 사용하지 않고 있으면 리턴
if(basename(G5_THEME_PATH)!=BT_DIR){
    return;
}



//===========================================================================
// 기본 함수 로드
//===========================================================================
$funcs = glob(BT_LIB_PATH.'/func/*.lib.php');
foreach($funcs as $_file){
    include_once($_file);
}
//include_once(BT_LIB_PATH.'/func/cmd.lib.php');
//include_once(BT_LIB_PATH.'/func/site.lib.php');

//===========================================================================
// 오토로드 정의
//===========================================================================

include_once(BT_LIB_PATH.'/loader.php');

//클래스 자동로드 프로시저 지정
bt\BLoader::autoloadSetup();

//BART라이브러리를 오토로드 대상으로 지정함
bt\BLoader::registAll(BT_LIB_PATH.'/class');

//===========================================================================
// 에러핸들러 정의
//===========================================================================
set_error_handler(array(bt\system\BError::getInstance(), 'showError'));

//===========================================================================
// 테이블 정의
//===========================================================================

$bt = array();
$bt['alim_table']   = BT_PREFIX.'alim';
$bt['fmgr_table']   = BT_PREFIX.'file_manager';
$bt['frame_table']  = BT_PREFIX.'frame';
$bt['menu_table']	= BT_PREFIX.'menu';
$bt['page_table']	= BT_PREFIX.'page';
$bt['widget_table'] = BT_PREFIX.'widget';


//===========================================================================
// 메뉴 로드
//===========================================================================
/* @var BMenu */
$btmenu = bt\builder\BMenu::getInstance();

$device = 'pc';
$menulist = $btmenu->getTreeList($device, true, '0');


//===========================================================================
// 기본 인스턴스 생성
//===========================================================================
//NTK config 로드
$btcfg = bt\builder\BConfig::getInstance()->getConfig();
bt\array_map_recursive('stripslashes', $btcfg);

/* @var Bdb */
$bdb = bt\database\BDB::getInstance();
$bdb->setDebug(G5_DISPLAY_SQL_ERROR);

//===========================================================================
// 현재위치 파악
//===========================================================================
if($mtype && $mid){
	$bt['curmenu'] = $btmenu->getByMid($mtype, $mid);
}else{
	if($bo_table){
		$bt['curmenu'] = $btmenu->getByMid('board', $bo_table);
	}else{
		$bt['curmenu'] = $btmenu->getByCurrentURL();
	}
}

$bt['curpath'] = $btmenu->getPath($bt['curmenu']['bm_idx']);

$cur_title = "";
//$cur_maintitle = "";
$cur_subtitle = "";
$cur_keyword = "";
$cur_desc = "";

if(isset($bt['curmenu'])){
    $cur_title = $bt['curmenu']['bm_name'];
    //$cur_maintitle = $cur_title;
    $cur_subtitle = $bt['curmenu']['bm_subtitle'];
}

if(trim($cur_title)=='' && $bo_table){
    $cur_title = $board['bo_subject'];
}

//현재위치 (BreadCrumb 를 위한)
$cur_path_list = bt\builder\BMenu::getPathList($bt['curpath']);


//===========================================================================
// 기본 프레임 및 레이아웃 세팅
//===========================================================================
$frame_default = bt\binstr($btcfg['bc_skin_frame_default'], 'basic');
$frame_skin = bt\binstr($bt['curmenu']['bm_skin_frame'], $frame_default);

$layout_default = bt\binstr($btcfg['bc_skin_layout_default'], 'basic');
$layout_skin = bt\binstr($bt['curmenu']['bm_skin_layout'], $layout_default);


//===========================================================================
// 사이드메뉴 정의
//===========================================================================
//메뉴에 지정된 사이드바가 있으면
if(bt\isval($bt['curmenu'])){
	$bt['sidebar'] = 'side_'.$bt['curmenu']['bm_sidebar'];
//없으면 기본 사이트바
}else{
	$bt['sidebar'] = $btcfg['bc_sidebar'];
}

//===========================================================================
// 접근권한 체크
//===========================================================================
if($bt['curmenu']['bm_perm'] > $member['mb_level']){
	if(!$member['mb_id']){
		$url = G5_BBS_URL.'/login.php?'.$qstr.'&url='.urlencode($_SERVER['PHP_SELF'].'?bo_table='.$bo_table);
		echo <<<EOT
		<script type="text/javascript">
			alert('접근 권한이 없습니다.\\n회원이시라면 로그인 후 이용해 보십시오.');
			document.location.replace('$url');
		</script>
EOT;
		exit;
		
	}else{
		echo <<<EOT
		<script type="text/javascript">
			alert('회원님의 등급으로 접근할 수 없는 메뉴입니다');
			document.location.replace($url);
		</script>
EOT;
		exit;
	}
}

//그누보드 코어 보존을 위해 이걸로 작업함, 도저히 방법이 없다 ㅜㅜ
register_shutdown_function('kr\bartnet\builder\BShutdownScript::execute');

if($bo_table) $pg_id = $bo_table;