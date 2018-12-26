<?php
$sub_menu = "801900";
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

auth_check($auth[$sub_menu], 'w');

$g5['title'] = '사이트기본설정';
$administrator = 1;
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<style type="text/css">
#guide dl{margin-bottom:30px;}
#guide dt{font-weight:bold; margin-bottom: 5px;}
#guide dd{margin-left: 20px; margin-bottom: 10px;}
</style>

<div id="guide">

    <h2>빌더의 구조 기본개념 및 용어</h2>
    <div class="guide-img">
        <img src="<?php echo BT_ADMIN_URL?>/img/guide_1.gif" style="max-width: 600px;" >
    </div>

    <dl>
        <dt>프레임</dt>
        <dd>홈페이지 상단과 하단영역을 관장하는 영역입니다. 레이아웃의 부모입니다</dd>
        <dt>레이아웃</dt>
        <dd>프레임의 자식이며 컨텐츠가 들어갈 영역의 모양을 결정합니다</dd>
        <dt>위젯페이지</dt>
        <dd>레이아웃의 자식이며 위젯을 삽입할 수 있는 페이지입니다.</dd>
        <dt>위젯</dt>
        <dd>최신글, 로그인 등 페이지에 삽입가능한 컨트롤입니다</dd>
    </dl>

    <h2>레이아웃내에 삽입할 수 있는것들</h2>
    <div class="guide-img">
        <img src="<?php echo BT_ADMIN_URL?>/img/guide_2.gif" style="max-width: 300px;" >
        <img src="<?php echo BT_ADMIN_URL?>/img/guide_3.gif" style="max-width: 300px;" >
        <img src="<?php echo BT_ADMIN_URL?>/img/guide_4.gif" style="max-width: 300px;" >
    </div>
    <dl>
        <dt>게시판</dt>
        <dd>그누보드 게시판</dd>
        <dt>페이지</dt>
        <dd>빌더내의 페이지메뉴에서 작성하여 저장된 내용</dd>
        <dt>모듈</dt>
        <dd>그누보드에 없는 기능을 확장하여 독립적으로 작동되는 프로그램이며 레이아웃내에 간편하게 삽입할 수 있습니다</dd>
    </dl>
</div>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');