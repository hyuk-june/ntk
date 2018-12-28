<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

$mid = bt\varset($_REQUEST["mid"]); //모듈명
$sec = bt\varset($_REQUEST["sec"]); //섹션
$act = bt\varset($_REQUEST["act"]); //저장등의 액션

//===========================================================================
// 모듈페이지 정보
//===========================================================================

//직접호출이면
if($mtype == 'module'){
    // 경로 정리
    $module_path = BT_MODULE_PATH.'/'.$mid;
    $module_url = BT_MODULE_URL.'/'.$mid;
    $module_self_url = G5_URL.'/index.php?mtype=module&mid='.$mid;
    
    if(!is_dir($module_path)){
        exit('Module page not found!');
    }
    
    // 프레임과 레이아웃(기본)
    $frame_skin = bt\binstr($btcfg["bc_skin_frame"], 'basic');
    $layout_skin = bt\binstr($btcfg["bc_skin_layout"], 'basic');

//등록된 모듈 호출이면
}else{
    
    if(!bt\isval($mid)) exit();

    $Q = "SELECT * FROM ".$bt['page_table']." WHERE pg_type='mpage' AND pg_id='".$mid."'";
    $pgrow = sql_fetch($Q);
    
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

    // 경로 정리
    $module_path = BT_MODULE_PATH.'/'.$pgrow['pg_module'];
    $module_url = BT_MODULE_URL.'/'.$pgrow['pg_module'];
    $module_self_url = G5_URL.'/index.php?mtype=mpage&mid='.$pgrow['pg_id'];

    //===========================================================================
    // 모듈 존재하는지 검사
    //===========================================================================
    if(!$pgrow || !is_dir($module_path)){
        exit('Module page not found!');
    }


    //모듈옵션설정 로딩
    $mdcfg = @json_decode($pgrow['pg_config'], true);

    // 프레임과 레이아웃
    $frame_skin = bt\binstr($pgrow["pg_skin_frame"], 'basic');
    $layout_skin = bt\binstr($pgrow["pg_skin_layout"], 'basic');
}

//===========================================================================
// 모듈별 기본설정파일 존재시 로딩
//===========================================================================
@include($module_path.'/config.php');


//===========================================================================
// 메뉴에 속하지 않아서 제목, description 이 없으면 page테이블에서 직접 불러온다
//===========================================================================
//if(!is_array($bt['curpath']) || count($bt['curpath']) <= 0){
    $cur_title = bt\binstr($pgrow["pg_title"], $g5['title']);
    $cur_subtitle = $pgrow["pg_subtitle"];
    $cur_keyword = $pgrow["pg_keyword"];
    $cur_desc = $pgrow["pg_desc"];
//}

//===========================================================================
// 해당 모듈 로딩
//===========================================================================

//section별 동작
if(bt\isval($sec)){
    if(bt\isval($act)){
        include_once($module_path.'/'.$sec.'_action.php');
    }else{
        include_once($module_path.'/'.$sec.'.php');
    }
//단일모듈일 경우
}else{
    if(bt\isval($act)){
        include_once($module_path.'/action.php');
    }else{
        include_once($module_path.'/module.php');
    }
}
