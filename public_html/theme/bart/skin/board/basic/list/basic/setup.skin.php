<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;
?>
<table class="table table-bordered">
<tbody>
<tr>
    <th>헤더색상</th>
    <td><input type="text" name="list_head_color" value="<?php echo $bcfg["list_head_color"]?>" placeholder="#414141"></td>
</tr>
<tr>
    <th>숨김</th>
    <td>
        <label>
            <input type="checkbox" name="list_hide_writer" value="1"<?php echo bt\get_checked('1', $bcfg['list_hide_writer'])?>>
            작성자
        </label>
        <label>
            <input type="checkbox" name="list_hide_datetime" value="1"<?php echo bt\get_checked('1', $bcfg['list_hide_datetime'])?>>
            날짜
        </label>
        <label>
            <input type="checkbox" name="list_hide_hit" value="1"<?php echo bt\get_checked('1', $bcfg['list_hide_hit'])?>>
            조회수
        </label>
        <label>
            <input type="checkbox" name="list_hide_good" value="1"<?php echo bt\get_checked('1', $bcfg['list_hide_good'])?>>
            추천
        </label>
        <label>
            <input type="checkbox" name="list_hide_nogood" value="1"<?php echo bt\get_checked('1', $bcfg['list_hide_nogood'])?>>
            비추천
        </label>
        <div class="form-text text-muted">'추천,비추천'은 기본설정에서 '사용'에 체크되어 있어야 적용됩니다</div>
    </td>
</tr>
</tbody>
</table>