<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

include_once(G5_EDITOR_LIB);

$editor_js = '';
$editor_js .= get_editor_js('html');
$editor_js .= chk_editor_js('html');
?>

<table>
<tbody>
<tr>
    <th>HTML</th>
    <td>
        <?php echo editor_html("html", $wcfg['html'], true); ?>
    </td>
</tr>
</tbody>
</table>

<script type="text/javascript">
<!--
function frmCheck(){
    <?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>
    return true;
}

$(document).ready(function(){
    $('#frm_widget').submit(frmCheck);
});
//-->
</script>