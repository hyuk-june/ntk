<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);

global $wcfg;
?>

<div class="bt-basic-outlogin">

    <div class="status-logout">
        
        <form name="frm_outlogin" class="frm-outlogin" action="<?php echo G5_BBS_URL?>/login_check.php" method="post" autocomplete="off">
            <input type="hidden" name="url" value="<?php echo $urlencode ?>">
            <div class="input-info">
                <input type="text" name="mb_id" class="ol-id" required class="required" maxlength="20">
                <input type="password" name="mb_password" class="ol-pw" required class="required" maxlength="40">
                <button type="submit" class="ol-submit">
                    <i class="fa fa-power-off"></i>
                    로그인
                </button>
            </div>
            <div class="service">
                <div class="float-left">
                    <input type="checkbox" name="auto_login" class="auto-logo" value="1">
                    <label>자동로그인</label>
                </div>
                <div class="float-right">
                    <a href="<?php echo G5_BBS_URL ?>/register.php"><b>회원가입</b></a>
                    <span class="spl">|</span>
                    <a href="<?php echo G5_BBS_URL ?>/password_lost.php">정보찾기</a>
                </div>
            </div>
        </form>
        
        <?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include_once(get_social_skin_path().'/social_outlogin.skin.1.php');
        ?>
    </div>

</div>


<script>
$(function() {

    $(".auto-login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                return false;
        }
    });
});

function fhead_submit(f)
{
    return true;
}
</script>