<?php
$sub_menu = "801100";
include_once('./_common.php');

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

$arr = array();


//===========================================================================
// 로고파일 업로드 시
//===========================================================================
/*if($_FILES['bc_logo']['size'] > 0){
	$fu = new bt\file\BFileUpload();
	$param = array(
		"mkdir" => true,                    		//디렉토리가 없으면 만들것인가
		"updir" => G5_DATA_PATH."/file/logo",        //업로드 디렉토리
		"field" => "bc_logo",                 		//폼 필드 이름
		"naming" => bt\file\BFileUpload::NAME_FORCE_ADDEXT,  //실제파일명변경 규칙[NAME_ORGINAL_NUMERIC | NAME_ORIGINAL_OVERLAP | NAME_FORCE]
		"force_name" => "logo",          			//NAME_FORCE 일때 강제 지정 이름
		"limit_size" => 1024*1024,       			//제한 용량
//		"limit_width" => 200,                		//가로 제한 픽셀
//		"limit_height" => 70,               		//세로 제한 픽셀
		"allow_ext" => "jpg|png|gif"           		//허용하는 확장자
	);

	$info = $fu->add($param);               		//세팅된 파일 정보들 배열로 리턴(DB에 입력하는 등의 용도)

	try{
		$fu->upload();                          	//실제 업로드
	}catch(Exception $e){
		alert("파일업로드 에러 ".$e->getMessage());
	}
	
	$arr['bc_logo']			= $info['rname'];
	$arr['bc_logo_width']	= $info['width'];
	$arr['bc_logo_height']	= $info['height'];

}*/

//===========================================================================
// 모바일 로고파일 업로드 시
//===========================================================================
/*if($_FILES['bc_mlogo']['size'] > 0){
	$fu = new BFileUpload();
	$param = array(
		"mkdir" => true,                    		//디렉토리가 없으면 만들것인가
		"updir" => G5_DATA_PATH."/file/logo",        //업로드 디렉토리
		"field" => "bc_mlogo",                 		//폼 필드 이름
		"naming" => BFileUpload::NAME_FORCE_ADDEXT,  //실제파일명변경 규칙[NAME_ORGINAL_NUMERIC | NAME_ORIGINAL_OVERLAP | NAME_FORCE]
		"force_name" => "mlogo",          			//NAME_FORCE 일때 강제 지정 이름
		"limit_size" => 1024*1024,       			//제한 용량
//		"limit_width" => 200,                		//가로 제한 픽셀
//		"limit_height" => 70,               		//세로 제한 픽셀
		"allow_ext" => "jpg|png|gif"           		//허용하는 확장자
	);

	$info = $fu->add($param);               		//세팅된 파일 정보들 배열로 리턴(DB에 입력하는 등의 용도)

	try{
		$fu->upload();                          	//실제 업로드
	}catch(Exception $e){
		alert("파일업로드 에러 ".$e->getMessage());
	}
	
	$arr['bc_mlogo']			= $info['rname'];
	$arr['bc_mlogo_width']	= $info['width'];
	$arr['bc_mlogo_height']	= $info['height'];

}*/

//===========================================================================
// 데이타 필드 처리
//===========================================================================
//$arr['bc_width'] 		    = bt_binstr($_POST['bc_width'], 90);
$arr['bc_image_width']	    = bt\binstr($_POST['bc_image_width'], 600);

$arr['bc_skin_frame_main'] 	    = bt\binstr($_POST['bc_skin_frame_main'], 'basic');
$arr['bc_skin_mframe_main']	    = bt\binstr($_POST['bc_skin_mframe_main'], 'basic');
$arr['bc_skin_frame_default']    = bt\binstr($_POST['bc_skin_frame_default'], 'basic');
$arr['bc_skin_mframe_default']   = bt\binstr($_POST['bc_skin_mframe_default'], 'basic');

$arr['bc_skin_layout_main']      = bt\binstr($_POST['bc_skin_layout_main'], 'basic');
$arr['bc_skin_mlayout_main']     = bt\binstr($_POST['bc_skin_mlayout_main'], 'basic');
$arr['bc_skin_layout_default']   = bt\binstr($_POST['bc_skin_layout_default'], 'basic');
$arr['bc_skin_mlayout_default']  = bt\binstr($_POST['bc_skin_mlayout_default'], 'basic');

$arr['bc_pg_id']        = bt\binstr($_POST["bc_pg_id"], "basic");

$arr['bc_font_family'] = $_POST["bc_font_family"];
$arr['bc_font_url'] = $_POST["bc_font_url"];

//===========================================================================
// 데이타 갱신
//===========================================================================
/*
$sql = "SELECT COUNT(*) as cnt FROM ".$bt['config_table'];
//$bdb->showQuery(true);
$rs = $bdb->fetch($sql);
if($rs["cnt"] > 0){
	$bdb->update($bt['config_table'], $arr, '1');
}else{
	$bdb->insert($bt['config_table'], $arr);
}
*/
$fdata = new bt\file\BFileData();
$fdata->setFilePath(BT_DATA_PATH.'/btb_config.php');
$fdata->saveData($arr);


//===========================================================================
// 서브 SQL 쿼리 실행
//===========================================================================
$list = glob(BT_ADMIN_PATH.'/sql.*.php');
foreach($list as $file){
    @include_once($file);
}


alert('적용되었습니다', './config_form.php', false);
