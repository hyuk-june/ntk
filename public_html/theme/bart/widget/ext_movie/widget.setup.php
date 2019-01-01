<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
?>

<table>
<tbody>
<tr>
    <th>동영상삽입<br>스크립트</th>
    <td>
        <textarea name="mov_script" id="mov_script" style="width:100%;min-height:200px"><?php echo $wcfg['mov_script']?></textarea>
    </td>
</tr>
</tbody>
</table>