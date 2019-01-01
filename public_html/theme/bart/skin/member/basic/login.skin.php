<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">');
//add_stylesheet('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">');

add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

add_javascript('<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>');
add_javascript('<script src="https://use.fontawesome.com/4ef133e081.js"></script>');


if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) {
	add_javascript('<script src="'.G5_JS_URL.'/certify.js"></script>');
}
?>

<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>

<?php } ?>

<style type="text/css">
h4{margin:0; padding:10px;vertical-align: middle; width:100%;}

#login_wrap, #cert_wrap, #social{
	background-color:#fff;
	padding:10px;
}

#login_wrap{
    border-right: 2px dashed #ddd;
}

#cert_wrap .tab-content {
	border:1px solid #ddd;
	padding : 5px 15px;
	margin-top:-1px;
	
}

#cert_wrap .nav-pills > li > a {
  border-radius: 0;
}

#cert_wrap button{
	position:relative; display:block; margin:0 auto; 
}

#social{
    position: relative;
    height:100%;
}

#sns_login{
    border:0 !important;
    margin:0 !important;
    height: auto;
    overflow: hidden;
    min-height:100% !important;
    padding:0 !important;
}

#sns_login h3{display:none;}

@media(min-width:768px){
	#loginbox{margin-top:100px; margin-bottom:100px;}
	#login_wrap, #cert_wrap{height:260px}
	#cert_wrap .tab-content{height:200px; padding-top:80px}
	
}

@media(max-width:768px){
	#loginbox{margin-bottom:50px}
	#cert_wrap{}
	#cert_wrap .tab-content{height:80px; padding-top:20px}
}

</style>

<div class="container" id="loginbox">
	<div id="login_logo"><a href="<?php echo G5_URL?>"><img src="<?php echo G5_THEME_IMG_URL?>/logo.png"></a></div>
	<div class="row">
		<div class="col-sm-offset-2 col-sm-8 well">
			
			<div id="login_wrap" class="col-sm-6">
				<div id="mb_login" class="mbskin">
					<form name="flogin" class="form" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
					<input type="hidden" name="url" value="<?php echo $login_url ?>">

					<div class="form-group">
    					<label for="login_id">아이디</label>
					    <input type="text" name="mb_id" id="login_id" placeholder="아이디" required class="form-control required" maxLength="20">
					</div>
					<div class="form-group">
					    <label for="login_pw">비밀번호</label>
					    <input type="password" name="mb_password" id="login_pw" placeholder="비밀번호(필수)" required class="form-control required" maxLength="20">
					</div>
					<div class="form-group">
					    <input type="checkbox" name="auto_login" id="login_auto_login">
					    <label for="login_auto_login">자동로그인</label>
					</div>
					<div class="form-group">
    					<button type="submit" class="btn btn-primary">로그인</button>
    					<a href="<?php echo G5_URL?>"><button type="button" class="btn btn-default">메인화면</button></a>
					</div>

					</form>

				</div>
			</div>
		<?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])){?>
			<div id="cert_wrap" class="col-sm-6">
				<form id="fregisterform" name="fregisterform" action="<?php echo BT_GUIN_PATH."/adult_check.php"?>" method="post">
				<input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    			<input type="hidden" name="cert_no" value="">
				<ul class="nav nav-tabs">
					<li data-toggle="tab" class="active"><a href="#" class="btn-certtype" data-type="ipin">아이핀인증</a></li>
				<?php if($config['cf_cert_hp']){?>
					<li data-toggle="tab"><a href="#" class="btn-certtype" data-type="hp">휴대폰인증</a></li>
				<?php }?>
				</ul>
				
				<div class="tab-content clearfix">
					<div class="tab-pane active">
						<button type="button" id="btn_ipin" class="btn-cert btn btn-success">아이핀으로 인증하기</button>
					</div>
				<?php if($config['cf_cert_hp']){?>
					<div class="tab-pane">
						<button type="button" id="btn_hp" class="btn-cert btn btn-danger">휴대폰으로 인증하기</button>
					</div>
				<?php }?>
				</div>
				</form>
			</div>
		<?php }else{?>
			<div id="social" class="col-sm-6">
				<?php
                // 소셜로그인 사용시 소셜로그인 버튼
                @include_once(get_social_skin_path().'/social_login.skin.php');
                ?>
			</div>
		<?php }?>
		</div>
        
	</div>
    
	<div class="row">
		<div class="col-sm-offset-2 col-sm-10">
			<section>
				<h2>회원로그인 안내</h2>
				<p>
					회원아이디 및 비밀번호가 기억 안나실 때는 아이디/비밀번호 찾기를 이용하십시오.<br>
					아직 회원이 아니시라면 회원으로 가입 후 이용해 주십시오.
				</p>
				<div>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php" target="_blank" id="login_password_lost">
			            <button type="button" class="btn btn-info">아이디 비밀번호 찾기</button>
					</a>
					<a href="./register.php">
			            <button type="button" class="btn btn-default">회원 가입</button>
					</a>
				</div>
			</section>
		</div>
	</div>
</div>


<?php
$cert_hp = $config["cf_cert_hp"];
$cert_url = "";
$cert_type = "";
switch($config['cf_cert_hp']) {
	case "kcb":
		$cert_url = G5_OKNAME_URL.'/hpcert1.php';
		$cert_type = 'kcb-hp';
		break;
		
	case "kcp":
		$cert_url = "";
		$cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
        $cert_type = 'kcp-hp';
		break;
		
	default:
		$cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
        $cert_type = 'lg-hp';
		break;
}
?>

<!-- 성인인증 시도시 필요한 설정값 -->
<input type="hidden" id="cf_cert_url" value="<?php echo $cert_url?>">
<input type="hidden" id="cf_cert_type" value="<?php echo $cert_type?>">
<input type="hidden" id="cf_cert_ipin_url" value="<?php echo G5_OKNAME_URL.'/ipin1.php'?>">
<!-- //성인인증 시도시 필요한 설정값 -->

<!-- 성인인증 후 javascript 처리를 위해 (실제값은 필요없음) -->
<input type="hidden" name="cert_type">
<input type="hidden" name="mb_name">
<input type="hidden" name="mb_hp">
<input type="hidden" name="cert_no">
<!-- //성인인증 후 javascript 처리를 위해 (실제값은 필요없음) -->

<script>
function toggleCertType(){
	var idx = $(".btn-certtype").index(this);
	$('.tab-content .tab-pane').removeClass('active');
	$('.tab-content .tab-pane').eq(idx).addClass('active');
}

function openCertHP() {
    if(!cert_confirm())
        return false;

    var cert_hp = $('#cf_cert_hp').val();
    var cert_url = $('#cf_cert_url').val();
    var cert_type = $('#cf_cert_type').val();
    
    if(cert_hp==''){
    	alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");
    	return;
	}

    certify_win_open(cert_type, cert_url);
    return;
}

function openCertIPIN() {
	if(!cert_confirm())
		return false;

	var url = $('#cf_cert_ipin_url').val();
	certify_win_open('kcb-ipin', url);
	return;
}


$(function(){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
    
    $('.btn-certtype').click(toggleCertType);
    
    $('#btn_ipin').click(openCertIPIN);
    $('#btn_hp').click(openCertHP);
    
    //성인인증 완료되면 메인으로 이동
    $('input[name="cert_no"]').on('input', function(){
		location.href=g5_url;
    });
});

function flogin_submit(f)
{
    return true;
}
</script>
