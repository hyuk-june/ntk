<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

if(!btbo\exists_configfile($bo_table)){
    $default_checked = true;
}else{
    $default_checked = false;
}
?>
<table class="table table-bordered">
<tbody>
<tr>
    <th>헤더색상</th>
    <td><input type="text" name="list_head_color" value="<?php echo $bcfg["list_head_color"]?>" placeholder="#414141"></td>
</tr>
<tr>
    <th>출력옵션</th>
    <td>
        <label>
            <input type="checkbox" name="list_show_writer" value="1"<?php echo bt\get_checked('1', $list_show_writer, $default_checked)?>>
            작성자
        </label>
        <label>
            <input type="checkbox" name="list_show_datetime" value="1"<?php echo bt\get_checked('1', $list_show_datetime, $default_checked)?>>
            날짜
        </label>
        <label>
            <input type="checkbox" name="list_show_hit" value="1"<?php echo bt\get_checked('1', $list_show_hit, $default_checked)?>>
            조회수
        </label>
        <label>
            <input type="checkbox" name="list_show_good" value="1"<?php echo bt\get_checked('1', $list_show_good)?>>
            추천
        </label>
        <label>
            <input type="checkbox" name="list_show_nogood" value="1"<?php echo bt\get_checked('1', $list_show_nogood)?>>
            비추천
        </label>
        <div class="form-text text-muted">'추천,비추천'은 기본설정에서 '사용'에 체크되어 있어야 적용됩니다</div>
    </td>
</tr>
</tbody>
</table>