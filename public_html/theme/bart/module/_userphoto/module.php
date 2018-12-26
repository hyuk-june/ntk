<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_member){
    alert_close("회원전용기능입니다");
}

$photo = btb\BMember::getPhoto($member['mb_id']);

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$module_url.'/module.css" />');

include_once(G5_PATH.'/head.sub.php');
?>

<h1 class="popup-title">회원사진</h1>

<div class="module-userphoto">

    <div class="thumbnail text-center">
        <?php echo $photo?>
    </div>

    <form action="<?php echo $module_self_url?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="act" id="act" value="save">
        <div class="form-group">
            <label for="mb_photo">회원사진</label>
            <input type="file" name="mb_photo" id="mb_photo">
            <p class="help-block">gif, jpeg, jpg, png 파일만 가능합니다</p>
            <p class="help-block">업로드용량제한: 2Mbyte</p>
        </div>
        
        <div class="text-center">
            <button type="submit" class="btn btn-sm btn-primary">확인</button>
            <button type="submit" class="btn btn-sm btn-primary" id="btn_del">삭제</button>
            <button type="button" class="btn btn-sm btn-default" onclick="window.close()">닫기</button>
        </div>
    </form>

</div>

<script type="text/javascript">
<!--
$(function(){
    $('#btn_del').click(function(){
        $('#act').val('del');
    })
});
//-->
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');