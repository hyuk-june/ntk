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
    <th>출력옵션</th>
    <td>
        <label>
            <input type="checkbox" name="write_show_writer" value="1"<?php echo bt\get_checked('1', $write_show_writer, $default_checked)?>>
            작성자
        </label>
        <label>
            <input type="checkbox" name="write_show_datetime" value="1"<?php echo bt\get_checked('1', $write_show_datetime, $default_checked)?>>
            날짜
        </label>
        <label>
            <input type="checkbox" name="write_show_hit" value="1"<?php echo bt\get_checked('1', $write_show_hit, $default_checked)?>>
            조회수
        </label>
        <label>
            <input type="checkbox" name="write_show_cmtcnt" value="1"<?php echo bt\get_checked('1', $write_show_cmtcnt)?>>
            댓글개수
        </label>
    </td>
</tr>
</tbody>
</table>