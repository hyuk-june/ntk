<?php
ini_set('display_errors', true);

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use \kr\bartnet as bt;

/***********************************************

<<필독!! 안내 및 주의사항>>

★★★ index.php 파일은 절대 변경하시면 안됩니다. ★★★

빌더의 모든 URL은 index.php 를 경유하여 처리됩니다.
메인 파일을 하드코딩하여 임의의 페이지로 만들기를 원할때는 모듈로 작성해서 빌더 기본설정에서 선택해 주시면 됩니다
기타 외부 파일을 홈페이지에 삽일할 때도 반드시 모듈(module)로 작성해 주세요
그렇지 않으면 제목 및 현재위치가 출력되지 않습니다
위젯 및 모듈 작성방법은 홈페이지(kbay.co.kr)를 참조해주세요
    
***********************************************/


/***********************************************
mtype 이 없으면 메인으로 취급
***********************************************/

if(!bt\isval($mtype)){

    define('_MAIN_', true);
    
    $temp = explode('|', $btcfg['bc_pg_id']);
    
    if(count($temp) == 2){
        $mtype = $temp[0];
        $mid = $temp[1];
    }else{
        include_once('./_head.php');
        echo '<div class="alert alert-light">메인페이지가 세팅되지 않았습니다</div>';
        include_once('./_tail.php');
        exit;
    }
}

/***********************************************
mtype 별로 분기함
***********************************************/

switch($mtype){
	
	/*case 'group':
		include(BT_PATH.'/group.php');
		break;*/
	
    //페이지
	case 'page':
		include(BT_PATH.'/page.php');
		break;
    
    //위젯페이지
    case 'wpage':
        include(BT_PATH.'/wpage.php');
        break;
    
    //모듈페이지
    case 'mpage':
        include(BT_PATH.'/module.php');
        break;
        
    //모듈직접호출
    case 'module':
        include(BT_PATH.'/module.php');
        break;
}