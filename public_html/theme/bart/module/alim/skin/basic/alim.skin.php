<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5['title'] = "알림";
include_once(G5_PATH.'/head.php');

add_stylesheet('<link rel="stylesheet" href="'.$module_skin_url.'/style.css">');
?>

<script type="text/javascript">
<!--
function falim_submit(f){
	return true;
}

var module_self_url = '';

$(function(){
    
    module_self_url = $('#module_self_url').val();
    
	$('.allcheck').click(function(){
        
        $('.chk_al_idx').prop('checked', $(this).is(":checked") );
        /*
		if($('.allcheck').data('checked')==true){
			$('.allcheck').data('checked', false);
			$('.chk_al_idx').attr('checked', false);
		}else{
			$('.allcheck').data('checked', true);
			$('.chk_al_idx').attr('checked', true);
		}
        */
	});
	
	//선택삭제
	$('.chkdel').click(function(e){
        e.preventDefault();
		$('#act').val('del');
		$('#falim').submit();
	});
	
	//삭제
	$('.al_del').click(function(e){
        e.preventDefault();
		$('#act').val('del');
		$('.chk_al_idx').attr('checked', false);
		$('.chk_al_idx', $(this).parent()).attr('checked', true);
		$('#falim').submit();
	});
	
	//읽음
	$('.chkread').click(function(e){
        e.preventDefault();
		$('#act').val('read');
		$('#falim').submit();
	});
	
	//전체보기
	$('.viewall').click(function(e){
        e.preventDefault();
		location.href=module_self_url;
	});
	
	//읽은목록
	$('.viewread').click(function(e){
        e.preventDefault();
		location.href=module_self_url + '&sfl=al_read&stx=1';
	});
	
	//안읽은목록
	$('.viewnoread').click(function(e){
        e.preventDefault();
		location.href=module_self_url + '&sfl=al_read&stx=0';
	});
});
//-->
</script>

<input type="hidden" id="module_self_url" value="<?php echo $module_self_url?>">

<h2 id="container_title"><span class="sound_only">알림 목록</span></h2>

<div id="alim">

    <!-- 페이지 정보 및 버튼 시작 { -->
    <div id="total_cnt">
        <span>Total <?php echo number_format($total_count) ?>건</span>
        <?php echo $page ?> 페이지 / 메세지 보관기간은 <?php echo $alcfg['delete_day']?>일 입니다.
    </div>
    <div>
<?php
ob_start();
?>
        <div class="alim_btn d-none d-sm-block">
        	<ul class="btn_ctrl">
        		<li><button class="chkdel btn btn-sm bg-Black">선택삭제</button></li>
        		<li><button class="chkread btn btn-sm bg-Black">읽음표시</button></li>
        	</ul>
        	
        	<ul class="btn_view">
        		<li><button class="viewall btn btn-sm bg-Black">전체보기</button></li>
        		<li><button class="viewread btn btn-sm bg-Black">읽은목록</button></li>
        		<li><button class="viewnoread btn btn-sm bg-Black">안읽은목록</button></li>
        	</ul>
        </div>
        
        <div class="dropdown d-block d-sm-none">
            <button class="btn btn-info btn-sm dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            알림관리
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <li class="dropdown-item"><a href="#" class="chkdel">선택삭제</a></li>
                <li class="dropdown-item"><a href="#" class="chkread">읽음표시</a></li>
                <li class="dropdown-divider"></li>
                <li class="dropdown-item"><a href="#" class="viewall">전체보기</a></li>
                <li class="dropdown-item"><a href="#" class="viewread">읽은목록</a></li>
                <li class="dropdown-item"><a href="#" class="viewnoread">안읽은목록</a></li>
            </ul>
        </div>
<?php
$buttons = ob_get_contents();
ob_end_clean();
echo $buttons;
?>
    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->
    
    <br style="clear:both">

    <form name="falim" id="falim" action="?mtype=module&mid=alim" onsubmit="return falim_submit(this);" method="post">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="act" id="act">
    <input type="hidden" name="mtype" value="<?php echo $mtype?>">
    <input type="hidden" name="mid" value="<?php echo $mid?>">

    <table class="table table-striped">
    <thead>
    <tr>
        <th><input type="checkbox" class="allcheck"></th>
        <th>시간</th>
        <th>메시지</th>
    </tr>
    </thead>
    <tbody>
<?php for($i=0;$i<count($list);$i++){?>
    <tr>
        <td>
    	    <label for="chk_al_idx_<?php echo $i ?>" class="sound_only"><?php echo $list[$i]['al_message'] ?></label>
            <input type="checkbox" name="chk_al_idx[]" class="chk_al_idx" value="<?php echo $list[$i]['al_idx'] ?>" id="chk_al_idx_<?php echo $i ?>">
        </td>
        <td>
            <span class="regdate"><?php echo $list[$i]['regdate']?></span>
        </td>
        <td>
            <a class="al_memo" href="<?php echo $list[$i]['alink']?>" title="<?php echo $list[$i]['al_message']?>">
	            <span class="<?php echo $list[$i]['al_read']=='0' ? 'readbefore':'';?>"><?php echo $list[$i]['al_message']?></span>
            </a>
        </td>
    </tr>
<?php }?>
    
<?php if($i<=0){?>
    <tr>
    	<td style="text-align:center" colspan="3">새로운 알림 메세지가 없습니다</td>
    </tr>
<?php }?>
    </tbody>
    </table>
    
	</form>
	
	<div>
        <?php echo $buttons?>
    </div>
    
    <br style="clear:both">
    
    <div id="page_navi"><?php echo get_paging($config['cf_write_pages'], $page, $total_page, "?$qstr&amp;page="); ?></div>
	
</div>


<?php
include_once(G5_PATH.'/tail.php');