<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$g5['title'] = "모듈페이지란?";
include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$module_url.'/style.css" />');
?>
<?php echo btb\show_widgets(__FILE__, $pg_id, "moddesc_top");?>

<div class="card mb-3 custom-module">
    <div class="card-body">
        <h4 class="card-title">모듈페이지란?</h4>
        <div class="card-body">
            <ol>
                <li>모듈페이지란 그누보드에 존재하지 않는 기능을 추가로 만들어서 빌더에 탑재할 수 있는 기능입니다</li>
                <li>"/theme/bart/module/모듈디렉토리명" 위치에 해당모듈을 만들면 관리자페이지에서 선택하여 작동시킬 수 있습니다</li>
                <li>복잡한 모듈의 경우 파일을 분할하여 "...&sec=파일명" 파라미터로 접근할 수 있습니다</li>
                <li>전송된 데이타를 저장하는 경우에도 파일명을 "XXX_action.php" 로 만들고 "sec" 파라미터를 넘기면 됩니다</li>
                <li>분할하지 않을 경우는 module.php 와 action.php 로 간단히 만들 수 있습니다</li>
                <li>본 페이지는 모듈페이지의 샘플입니다</li>
            </ol>
            <br>
            [<a href="http://kbay.co.kr/guide/mpage.php" target="_blank" title="kbay ntk빌더 모듈페이지 도움말">모듈페이지 도움말</a>]
        </div>
    </div>
</div>

<form name="falim" id="falim" action="?mtype=module&mid=moddesc" onsubmit="return falim_submit(this);" method="post">
    <input type="hidden" name="act" id="act" value="new">
    <input type="hidden" name="mtype" value="<?php echo $mtype?>">
    <input type="hidden" name="mid" value="<?php echo $mid?>">
    
    <div class="form-group">
        <label for="title">title</label>
        <input type="text" name="title" id="title" class="form-control">
    </div>
    
    <div class="form-group">
        <label for="title">content</label>
        <textarea name="content" id="content" class="form-control"></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">전송테스트</button>
</form>

<?php echo btb\show_widgets(__FILE__, $pg_id, "moddesc_bot");?>



<?php
include_once(G5_PATH.'/tail.php');