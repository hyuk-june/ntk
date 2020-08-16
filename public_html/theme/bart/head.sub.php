<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';


$cur_title = bt\binstr($cur_title, $g5['title']);
/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<!--<meta content="width=device-width,initial-scale=1" name=viewport>-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php
if (G5_IS_MOBILE) {
    echo '<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=10,user-scalable=yes">'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    //echo '<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">'.PHP_EOL;
}

if($config['cf_add_meta'])
    echo $config['cf_add_meta'].PHP_EOL;
?>
<?php include_once(G5_THEME_PATH.'/seo.php');?>
<link rel="stylesheet" href="<?php echo G5_JS_URL ?>/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo G5_CSS_URL?>/default.css" />
<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="<?php echo G5_THEME_CSS_URL?>/default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo G5_THEME_CSS_URL?>/colorset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo G5_THEME_CSS_URL?>/animate.css" />
<?php if(bt\isval($btcfg['bc_font_url'])){?>
<link href="<?php echo $btcfg['bc_font_url']?>" rel="stylesheet">
<?php }?>
<?php if(bt\isval($btcfg['bc_font_family'])){?>
<style type="text/css">
* {font-family:<?php echo $btcfg['bc_font_family']?>;}
</style>
<?php }?>
<!-- 확장 기본로딩 css -->
<?php
$files = glob(BT_CSS_PATH.'/extends/*.css');
foreach($files as $_file){
    $fname = basename($_file);
?>
<link rel="stylesheet" type="text/css" href="<?php echo BT_CSS_URL.'/extends/'.$fname?>" />
<?php }?>
<!-- 확장 기본로딩 css -->

<!-- 그누보드 필수 js -->
<script src="<?php echo BT_JS_URL?>/jquery-1.11.1.js"></script>
<script src="<?php echo G5_JS_URL ?>/common.js"></script>
<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
<!-- //그누보드 필수 js -->

<!-- NTK빌더 필수 js 파일 로딩 -->
<script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo BT_JS_URL?>/bt.common.js"></script>
<script type="text/javascript" src="<?php echo BT_JS_URL?>/bt.builder.js"></script>
<script type="text/javascript" src="<?php echo BT_JS_URL?>/wow.min.js"></script>
<!-- //NTK빌더 필수 js 파일 로딩 -->

<!-- 그누보드의 특성상 </title> 다음에 <link> 태그 반드시 와야 해서 강제로 빈 <link>넣어 줌 -->
<title><?php echo $g5_head_title; ?></title><link /> 

<!-- 확장 기본 js 파일 로딩 -->
<?php
$files = glob(BT_JS_PATH.'/extends/*.js');
foreach($files as $_file){
    $fname = basename($_file);
?>
<script type="text/javascript" src="<?php echo BT_JS_URL.'/extends/'.$fname?>"></script>
<?php }?>
<!-- //확장 기본 js 파일 로딩 -->

<!--[if lte IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo $config['cf_editor'];?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
var bt_url       = g5_url + '/theme/bart';
var frame_skin   = "<?php echo $frame_skin?>";

$(function(){
   $('iframe').contents().find('#smart_editor').css({'min-width': 0, 'width': '100%'});
});
</script>
<?php
if(G5_IS_MOBILE) {
    echo '<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>'.PHP_EOL; // overflow scroll 감지
}
if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>

</head>
<body>
<h1 id="main_title"><?php echo $g5['title']?></h1>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    //echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    //echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}

//===========================================================================
// 프레임
//===========================================================================
$frame_path = BT_SKIN_PATH.'/frame/'.$frame_skin;
$frame_url = BT_SKIN_URL.'/frame/'.$frame_skin;


//===========================================================================
// 레이아웃
//===========================================================================
$layout_path = BT_SKIN_PATH.'/layout/'.$layout_skin;
$layout_url = BT_SKIN_URL.'/layout/'.$layout_skin;


//===========================================================================
// 프레임을 테마같이 쓰기 위해 해당프레임의 head.sub.php 를 불러온다(해당 파일에서 css, javascript 등 세팅) 
//===========================================================================
if(file_exists($frame_path.'/head.sub.php')){
    @include_once($frame_path.'/head.sub.php');
}