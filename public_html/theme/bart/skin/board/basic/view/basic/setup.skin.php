<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;
?>
<table class="table table-bordered">
<tbody>
<tr>
    <th>숨김</th>
    <td>
        <label>
            <input type="checkbox" name="write_hide_writer" value="1"<?php echo bt\get_checked('1', $bcfg['write_hide_writer'])?>>
            작성자
        </label>
        <label>
            <input type="checkbox" name="write_hide_datetime" value="1"<?php echo bt\get_checked('1', $bcfg['write_hide_datetime'])?>>
            날짜
        </label>
        <label>
            <input type="checkbox" name="write_hide_hit" value="1"<?php echo bt\get_checked('1', $bcfg['write_hide_hit'])?>>
            조회수
        </label>
        <label>
            <input type="checkbox" name="write_hide_cmtcnt" value="1"<?php echo bt\get_checked('1', $bcfg['write_hide_cmtcnt'])?>>
            댓글개수
        </label>
    </td>
</tr>
</tbody>
</table>