<?php
$sub_menu = "801402";
include_once("./_common.php");
include_once(BT_LIB_PATH.'/class/html/selectbox.php');

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');


$sql = "SELECT * FROM ".$bt["page_table"]." WHERE pg_type='wpage' ORDER BY pg_regdate ASC";
$result = sql_query($sql);

$total_count = sql_num_rows($result);

//프레임 스킨 옵션
$dir = BT_SKIN_PATH.'/frame';
$frame_s = bt\get_select($dir);
$mframe_s = bt\get_select($dir);

//레이아웃 스킨 옵션
$dir = BT_SKIN_PATH.'/layout';
$layout_s = bt\get_select($dir);
$mlayout_s = bt\get_select($dir);

// 위젯페이지 스킨
$dir = BT_SKIN_PATH.'/wpage';
$wpage_s = bt\get_select($dir);
$mwpage_s = bt\get_select($dir);


$g5['title'] = '위젯페이지관리';
$administrator = 1;
include_once(G5_ADMIN_PATH.'/admin.head.php');
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    위젯페이지관리 <?php echo number_format($total_count) ?>건
</div>


<?php if ($is_admin == 'super') { ?>
<div class="btn_add01 btn_add">
    <a href="./wpage_form.php" id="pg_add">페이지 추가</a>
</div>
<?php } ?>

<form name="fwpagelist" id="fwpagelist" method="post" action="./wpage_update.php" onsubmit="return fwpagelist_submit(this);">
<input type="hidden" name="token" value="<?php echo $token ?>">
<input type="hidden" name="w" id="w" value="m">

<div class="tbl_head01 tbl_wrap">
    <table>
    <caption><?php echo $g5['title']; ?> 목록</caption>
    <thead>
    <tr>
        <th scope="col" rowspan="2">
            <label for="chkall" class="sound_only">전체</label>
            <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
        </th>
        <th scope="col" rowspan="2">페이지아이디</th>
        <th scope="col" rowspan="2">페이지제목</th>
        <th scope="colgroup" colspan="2">프레임</th>
        <th scope="colgroup" colspan="2">레이아웃</th>
        <th scope="colgroup" colspan="2">위젯페이지</th>
        <th scope="col" rowspan="2">접근레벨</th>
        <th scope="col" rowspan="2">수정</th>
        <th scope="col" rowspan="2">삭제</th>
    </tr>
    <tr>
        <th scope="col">PC</th>
        <th scope="col">모바일</th>
        <th scope="col">PC</th>
        <th scope="col">모바일</th>
        <th scope="col">PC</th>
        <th scope="col">모바일</th>
    </tr>
    </thead>
    <tbody>
<?php for ($i=0; $row=sql_fetch_array($result); $i++){?>
    <?php
    $frame_s->selectedFromValue = $row["pg_skin_frame"];
    $mframe_s->selectedFromValue = $row["pg_skin_mframe"];
    $layout_s->selectedFromValue = $row["pg_skin_layout"];
    $mlayout_s->selectedFromValue = $row["pg_skin_mlayout"];
    $wpage_s->selectedFromValue = $row["pg_skin_wpage"];
    $mwpage_s->selectedFromValue = $row["pg_skin_mwpage"];
    ?>
    <tr>
        <td class="td_chk">
            <input type="hidden" name="pg_id[<?php echo $i ?>]" value="<?php echo $row['pg_id'] ?>">
            <label for="chk_<?php echo $i; ?>" class="sound_only">선택</label>
            <input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
        </td>
        <td class="td_grid"><?php echo $row['pg_id']?></td>
        <td class="td_grid"><?php echo $row['pg_title']?></td>
        <td class="td_grid"><select name="pg_skin_frame[]"><?php echo $frame_s->getOption();?></select></td>
        <td class="td_grid"><select name="pg_skin_mframe[]"><?php echo $mframe_s->getOption();?></select></td>
        <td class="td_grid"><select name="pg_skin_layout[]"><?php echo $layout_s->getOption();?></select></td>
        <td class="td_grid"><select name="pg_skin_mlayout[]"><?php echo $mlayout_s->getOption();?></select></td>
        <td class="td_grid"><select name="pg_skin_wpage[]"><?php echo $wpage_s->getOption();?></select></td>
        <td class="td_grid"><select name="pg_skin_mwpage[]"><?php echo $mwpage_s->getOption();?></select></td>
        <td class="td_grid">
            <input type="text" name="pg_level_min[]" value="<?php echo $row['pg_level_min']?>" size="4" style="width:50px" required="required" class="requried frm_input">
            ~
            <input type="text" name="pg_level_max[]" value="<?php echo $row['pg_level_max']?>" size="4" style="width:50px" required="required" class="requried frm_input">
        </td>
        <td class="td_grid"><a href="./wpage_form.php?pg_id=<?php echo $row['pg_id']?>&<?php echo $qstr?>">수정</a></td>
        <td class="td_grid">
        <?php if($row['pg_system']!='1'){?>
            <a href="./wpage_update.php?w=d&pg_id=<?php echo $row['pg_id']?>&<?php echo $qstr?>" onclick="delCheck('<?php echo $row['pg_id']?>');return false">삭제</a>
        <?php }else{?>
            -
        <?php }?>
        </td>
    </tr>
<?php }?>
    </tbody>
    </table>
</div>

<div class="btn_list01 btn_list">
    <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value">
    <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value">
</div>

</form>


<script type="text/javascript">
<!--
function fwpagelist_submit(f)
{
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    $('#w').val('mu');
    if(document.pressed == "선택삭제") {
        $('#w').val('md');
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }
    }

    return true;
}

function delCheck(pg_id){
    if(!confirm('정말 삭제하시겠습니까?')) return;
    location.href='wpage_update.php?w=d&pg_id='+pg_id;
}
//-->
</script>

<?php
include_once(G5_ADMIN_PATH.'/admin.tail.php');     
