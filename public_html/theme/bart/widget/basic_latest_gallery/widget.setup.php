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
$bo_opts = $s->getOption();
?>


    <table>
    <tbody>
    <tr>
        <th>게시판ID</th>
        <td>
            <select name="bo_table">
            <?php echo $bo_opts?>
            </select>
        </td>
    </tr>
    <tr>
        <th>게시물수</th>
        <td>
            <input type="text" name="rowcnt" size="4" class="frm_input" value="<?php echo bt\varset($wcfg['rowcnt'])?>">
        </td>
    </tr>
    <tr>
        <th>반응형설정</th>
        <td>
            <table>
            <thead>
            <tr>
                <th>구분</th>
                <th>lg(≥1170px)</th>
                <th>md(≥992px)</th>
                <th>sm(≥768px)</th>
                <th>xs(&lt;765px)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>행당갯수</td>
                <td><input type="text" name="numpr[lg]" value="<?php echo $wcfg['numpr']['lg']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="numpr[md]" value="<?php echo $wcfg['numpr']['md']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="numpr[sm]" value="<?php echo $wcfg['numpr']['sm']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="numpr[xs]" value="<?php echo $wcfg['numpr']['xs']?>" class="frm_input" size="4"></td>
            </tr>
            <tr>
                <td>상하여백</td>
                <td><input type="text" name="ma_w[lg]" value="<?php echo $wcfg['ma_w']['lg']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_w[md]" value="<?php echo $wcfg['ma_w']['md']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_w[sm]" value="<?php echo $wcfg['ma_w']['sm']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_w[xs]" value="<?php echo $wcfg['ma_w']['xs']?>" class="frm_input" size="4"></td>
            </tr>
            <tr>
                <td>좌우여백</td>
                <td><input type="text" name="ma_h[lg]" value="<?php echo $wcfg['ma_h']['lg']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_h[md]" value="<?php echo $wcfg['ma_h']['md']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_h[sm]" value="<?php echo $wcfg['ma_h']['sm']?>" class="frm_input" size="4"></td>
                <td><input type="text" name="ma_h[xs]" value="<?php echo $wcfg['ma_h']['xs']?>" class="frm_input" size="4"></td>
            </tr>
            </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <th>이미지크기</th>
        <td>
            <input type="text" name="thumb_w" size="4" class="frm_input" value="<?php echo bt\varset($wcfg["thumb_w"])?>">
            x
            <input type="text" name="thumb_h" size="4" class="frm_input" value="<?php echo bt\varset($wcfg["thumb_h"])?>">
            <label>미입력시 기본값 400 x 300, 반응형이라 화면에 보이는 크기는 유동적입니다</label>
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
        <th>캐시사용</th>
        <td>
            <input type="text" name="cache_min" size="4" class="frm_input" value="<?php echo $wcfg['cache_min']?>">
            <label>분 (캐시를 사용하시려면 분단위로 입력하세요)</label>
        </td>
    </tr>
    </tbody>
    </table>
