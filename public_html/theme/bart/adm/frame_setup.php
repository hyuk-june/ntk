<?php
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '프레임설정';
$administrator = 1;

if(!bt\isval($_GET["url"]) || !bt\isval($_GET["frame_skin"])){
    die('잘못된 접근입니다');
    exit();
}

include_once(BT_PATH.'/head.sub.php');

$url = urldecode($_GET["url"]);
$frame_skin = $_GET["frame_skin"];

$qs = btb\parse_frame($url);
$fcfg = btb\get_frame_config($_GET["frame_skin"], $url, true);

if(!is_array($fcfg['_private'])) $fcfg['private'] = array();

$path = bt\binstr($qs['path'], '');
$mtype = bt\binstr($qs['mtype'], '');
$mid = bt\binstr($qs['mid'], '');

$fs_idx = $fcfg['fs_idx'];
?>

<form name="frameform" id="frameform" action="./frame_update.php" method="post">
    <input type="hidden" name="actmode" value="edit">
    <input type="hidden" name="fs_skin" value="<?php echo $frame_skin?>">
    <input type="hidden" name="fs_path" value="<?php echo $path?>">
    <input type="hidden" name="fs_mtype" value="<?php echo $mtype?>">
    <input type="hidden" name="fs_mid" value="<?php echo $mid?>">
    <section>
        <h2 class="alert alert-primary font-size-3 mb-0">프레임 설정</h2>
        <div class="p-2">
        
            <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th scope="col">기능</th>
                <th scope="col">내용</th>
            </tr>
            <tr>
                <th scope="row">이페이지에서만 적용</th>
                <td><input type="checkbox" name="fs_private" value="1"<?php echo $fcfg['fs_private']=='1' ? ' checked="checked"' : '';?>></td>
            </tr>
            </thead>
            </table>
        
            <?php if(file_exists(BT_SKIN_PATH.'/frame/'.$frame_skin.'/frame.setup.php')){?>
                <?php include_once(BT_SKIN_PATH.'/frame/'.$frame_skin.'/frame.setup.php');?>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mr-2">확인</button>
                <?php if($fs_idx){?>
                    <button type="button" class="btn btn-danger mr-2 btn-del" data-fs_idx="<?php echo $fs_idx?>">데이타삭제</button>
                <?php }?>
                    <button type="button" class="btn btn-info btn-close">닫기</button>
                </div>
            <?php }else{?>
                <div class="mb-5">해당 프레임은 설정옵션이 존재하지 않습니다</div>
                <div class="text-center">
                    <button type="button" class="btn btn-info btn-close">닫기</button>
                </div>
            <?php }?>
        </div>
    </section>
</form>

<div class="alert alert-light">
    ※ 로컬: 해당페이지에서만 적용
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
    $('.btn-close').click(function(){
        window.close();
    });
    
    $('.btn-del').click(function(){
        if(!confirm('설정된 데이타를 삭제합니다')) return;
        location.href='frame_update.php?actmode=del&fs_idx=' + $(this).data('fs_idx');
    })
});
//-->
</script>

<?php
include_once(BT_PATH.'/tail.sub.php');