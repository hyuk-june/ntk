<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_javascript('<script style="text/javascript" src="'.$frame_url.'/js/frame.js"></script>');
ob_start();

$margin_top = bt\binstr($fcfg['margin_top'], '0');
$margin_bot = bt\binstr($fcfg['margin_bot'], '0');
$wing_top = bt\binstr($fcfg['wing_top'], '0');
$mheader_bg = '#'.trim(bt\binstr($fcfg['mheader_bg'], '333'), '#');
$mheader_color = '#'.trim(bt\binstr($fcfg['mheader_color'], 'fff'), '#');
?>
<style type="text/css">
#content_wrap{margin-top:<?php echo $margin_top?>px; margin-bottom:<?php echo $margin_bot?>px;}
#wing{top:<?php echo $fcfg['wing_top']?>px;}
#mobile_header{background-color:<?php echo $mheader_bg?>}
#mobile_color,
#mobile_color *,
#btn_toggle_menu{color:<?php echo $mheader_color?> !important;}
</style>

<?php
$style = ob_get_contents();
ob_end_clean();
add_stylesheet($style);
?>

<?php
if(defined('_MAIN_')) { // index에서만 실행
    include G5_THEME_PATH.'/newwin.inc.php'; // 팝업레이어
}
?>


<!--[if lte IE 7]>
<style type="text/css">
html .jqueryslidemenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

<div class="bt-frame">

    <aside class="tnb d-none d-md-block">
	    <div class="container">
            <?php if($is_admin){?>
            <nav class="float-left">
                <ul class="adm-menu">
                    <li><a href="#" id="btn_favorite" title="즐겨찾기"><i class="fa fa-bookmark"></i></a></li>
                </ul>
            </nav>
            <?php }?>
            
		    <nav class="float-right">
			    <ul class="tnb-menu">
		    <?php if($is_member){?>
			    <?php if ($is_admin) {  ?>
            	    <li><a href="<?php echo G5_ADMIN_URL ?>/"><i class="fa fa-cog"></i> 관리자</a></li>
                <?php }  ?>
            	    <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php"><i class="fa fa-edit"></i> 정보수정</a></li>
				    <li><a href="<?php echo G5_BBS_URL ?>/logout.php"><i class="fa fa-power-off"></i> 로그아웃</a></li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" id="tnb_dropdown_menu1" data-toggle="dropdown"><i class="fa fa-plus"></i> 추가메뉴</a>
                        <ul class="dropdown-menu" aria-labelledby="tnb_dropdown_menu1">
                            <li><a href="<?php echo G5_BBS_URL ?>/faq.php"><i class="fa fa-question"></i> FAQ</a></li>
                            <li><a href="<?php echo G5_BBS_URL ?>/qalist.php"><i class="fa fa-comment-o"></i> 1:1문의</a></li>
                            <li><a href="<?php echo G5_URL?>/bbs/new.php"><i class="fa fa-plus-square"></i> 새글</a></li>
                            <li><a href="<?php echo G5_URL?>/bbs/current_connect.php"><i class="fa fa-user"></i> 현재접속자</a></li>
                        </ul>
                    </li>
		    <?php }else{?>
				    <li><a href="<?php echo G5_URL?>/bbs/login.php"><i class="fa fa-sign-in"></i> 로그인</a></li>
				    <li><a href="<?php echo G5_URL?>/bbs/register.php"><i class="fa fa-sign-in"></i> 회원가입</a></li>
		    <?php }?>
			    </ul>
		    </nav>
	    </div>
    </aside>

    <header class="header d-none d-md-block">
	    <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <?php btb\show_widgets(__FILE__, "", "logo")?>
                    
		            <!--<a class="logo" href="<?php echo G5_URL?>">
			            <img src="<?php echo G5_THEME_URL?>/img/logo.png">
		            </a>-->
                </div>
                <div class="col-md-4">
                    <?php btb\show_widgets(__FILE__, "", "header_mid")?>
                </div>
                <div class="col-md-4">
                    <?php btb\show_widgets(__FILE__, "", "header_right")?>
                </div>
            </div>
	    </div>
    </header>

    <div class="menubar">
	    
        <!-- 모바일 헤더 -->
	    <div id="mobile_header" class="container d-block d-md-none">
            <div class="d-flex justify-content-between">
			    <div id="mobile-logo">
                    <?php btb\show_widgets(__FILE__, "", "logo-m")?>
			    </div>
			    <div>
                    <div class="d-flex align-items-center" style="height:100%;">
				        <a href="#" id="btn_toggle_menu" class="btn btn-default">
					        <i class="fa fa-bars"></i>
				        </a>
                    </div>
			    </div>
            </div>
	    </div>
        <!-- //모바일 헤더 -->
	    
	    
        <div class="d-none d-md-block">
	        <?php btb\show_widgets(__FILE__, "", "main_menu");?>
        </div>
        
    </div>

    <!-- 콘텐츠 시작 { -->
</div>

<div id="content_wrap">
    <?php if(bt\varset($fcfg['hide_wing'])!='1'){?>
    <div id="wing" class="d-none d-xl-block<?php echo !defined('_MAIN_') ? ' sub':'';?>">
        <div class="container">
            <aside id="lside">
                <?php echo btb\show_widgets(__FILE__, "", "wing_lside")?>
            </aside>

            <aside id="rside">
                <?php echo btb\show_widgets(__FILE__, "", "wing_rside")?>
            </aside>
        </div>
    </div>
    <?php }?>
<?php
include_once($layout_path.'/layout_head.skin.php');