<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$sql = "SELECT * FROM ".$g5["board_table"]." ORDER BY bo_table";
$result = sql_query($sql);

$s = new bt\html\BSelectbox();
while($rs = sql_fetch_array($result)){
    $s->add($rs["bo_table"], '['.$rs["bo_table"].'] '.$rs["bo_subject"]);
}

$rowcnt = 5;
$subject_len = 30;

if($rs['wg_isset']){
    $checked_name = false;
    $checked_date = false;
}else{
    $checked_name = false;
    $checked_date = true;
}

if(bt\isval($wcfg["bo_table"])){
    $s->selectedFromValue = $wcfg["bo_table"];
}
if(bt\isval($wcfg["subject_len"])){
    $subject_len = $wcfg["subject_len"];
}
if(bt\isval($wcfg["rowcnt"])){
    $rowcnt = $wcfg["rowcnt"];
}

$latest_skins = get_skin_select('latest', 'skin', 'skin', $wcfg['skin'], 'required')
?>


    <table>
    <tbody>
    <tr>
        <th>게시판ID</th>
        <td>
            <select name="bo_table">
            <?php echo $s->getOption()?>
            </select>
        </td>
    </tr>
    <tr>
        <th>최신글스킨</th>
        <td>
            <?php echo $latest_skins?>
        </td>
    </tr>
    <tr>
        <th>행갯수</th>
        <td>
            <input type="text" name="rowcnt" size="4" class="frm_input" value="<?php echo $rowcnt?>">
        </td>
    </tr>
    <tr>
        <th>제목길이</th>
        <td>
            <input type="text" name="subject_len" size="4" class="frm_input" value="<?php echo $subject_len?>">
        </td>
    </tr>
    <tr>
        <th>노출</th>
        <td>
            <label>
                <input type="checkbox" name="show_name" value="1"<?php echo bt\get_checked("1", $wcfg["show_name"], $checked_name)?>>
                작성자
            </label>
            <label>
                <input type="checkbox" name="show_date" value="1"<?php echo bt\get_checked("1", $wcfg["show_date"], $checked_date)?>>
                날짜
            </label>
        </td>
    </tr>
    <tr>
        <th>옵션</th>
        <td>
            <textarea name="options" class="frm_input" style="min-height: 200px"><?php echo $wcfg['options']?></textarea>
            <?php echo help("최신글 스킨별로 옵션이 존재할 수 있습니다.");?>
            <?php echo help("배열행태의 옵션은 JSON 형식으로 정확하게 입력해 주세요");?>
        </td>
    </tr>
    <tr>
        <th>캐시사용</th>
        <td>
            <input type="text" name="cache_min" size="4" class="frm_input" value="<?php echo $wcfg['cache_min']?>">
            <label>분 (캐시를 사용하시려면 분단위로 입력하세요)</label>
        </td>
    </tr>
    </tbody>
    </table>
