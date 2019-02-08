<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

global $wcfg;

add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);

$sql = "SELECT * FROM bt_alim WHERE mb_id='".$member['mb_id']."' AND al_read=0 ORDER BY al_idx DESC";
$aresult = sql_query($sql);
$acnt = sql_num_rows($aresult);
?>

<div class="bt-basic-outlogin">

    <!-- 로그인 후 아웃로그인 시작 { -->
    <div class="status-login">
        <div class="info">
            <div class="profile float-left"><?php echo btb\BMember::getPhoto($member['mb_id'], true);?></div>
            <ul class="summary float-left">
                <li class="item-nick"><strong><?php echo $nick ?>님</strong></li>
                <li class="item-point">Point: <strong><a href="<?php echo G5_BBS_URL ?>/point.php" target="_blank" class="ol-after-pt" class="win_point"><?php echo $point ?></a></strong></li>
                <li class="item-level">Level: <?php echo $member["mb_level"]?></li>
            </ul>
        </div>
        <div class="clearfix"></div>
        <ul class="service">
            <li>
                <a href="#" class="show-alim">
                    <i class="fa fa-bullhorn"></i>
                    알림
                <?php if($acnt > 0){?>
                    <span class="al-cnt bg-CadetBlue"><?php echo $acnt?></span>
                <?php }?>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/memo.php" target="_blank" class="win_memo">
                    <i class="fa fa-envelope"></i>
                    쪽지
                <?php if($memo_not_read > 0){?>
                    <span class="al-cnt bg-CadetBlue"><?php echo $memo_not_read ?></span>
                <?php }?>
                </a>
            </li>
            <li>
                <a href="<?php echo G5_BBS_URL ?>/scrap.php" target="_blank" class="win_scrap">
                    <i class="fa fa-paperclip"></i>
                    스크랩
                </a>
            </li>
            <li>
                <a href="<?php echo G5_URL?>/index.php?mtype=wpage&mid=<?php echo $wcfg['mypage_mid']?>">
                    <i class="fa fa-address-card"></i>
                    MyPage
                </a>
            </li>
        </ul>
        <div class="ol-alim-wrap">
            <div class="ol-alim">
                <div class="alim-title">
                    <div class="float-left"><a href="<?php echo G5_URL?>/?mtype=mpage&mid=<?php echo $wcfg['alim_mid']?>" class="text-primary">모두보기</a></div>
                    <div class="float-right"><a href="#" class="btn-close-alim"><i class="fa fa-close"></i></a></div>
                </div>
                <div class="clearfix"></div>
                <ul>
            <?php while($ars = sql_fetch_array($aresult)){?>
                    <li><a href="<?php echo G5_URL?>/index.php?mtype=mpage&mid=alim&actmode=gourl&al_idx=<?php echo $ars["al_idx"]?>"><?php echo $ars["al_message"]?></li>
            <?php }?>
            <?php if($ars <= 0){?>
                    <li>새로운 알림이 없습니다</li>
            <?php }?>
                </ul>
            </div>
        </div>
        <div class="buttons">
            <?php if ($is_admin == 'super' || $is_auth) {  ?><a href="<?php echo G5_ADMIN_URL ?>">관리자 모드</a><span class="spl">|</span><?php }  ?>
            <a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=register_form.php">정보수정</a>
            <span class="spl">|</span>
            <a href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
        </div>
    </div>



<script>
// 탈퇴의 경우 아래 코드를 연동하시면 됩니다.
function member_leave()
{
    if (confirm("정말 회원에서 탈퇴 하시겠습니까?"))
        location.href = "<?php echo G5_BBS_URL ?>/member_confirm.php?url=member_leave.php";
}

function toggle_alim(evt){
    evt.preventDefault();
    var index = $('.show-alim').index(this);
    console.log(index);
    
    var div = $('.ol-alim').eq(index);
    if(div.is(':visible')){
        console.log('visible');
        div.hide();
    }else{
        console.log('hidden');
        div.show();
    }
}

function close_alim(evt){
    evt.preventDefault();
    var index = $('.btn-close-alim').index(this);
    $('.ol-alim').eq(index).hide();
}

$(document).ready(function(){
    $('.show-alim').off('click').on('click', toggle_alim);
    $('.btn-close-alim').off('click').on('click', close_alim);
});
</script>
<!-- } 로그인 후 아웃로그인 끝 -->

</div>