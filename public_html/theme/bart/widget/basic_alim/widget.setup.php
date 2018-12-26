<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

$skins = get_skin_select('outlogin', 'skin', 'skin', $wcfg['skin'], 'required');
?>

<table>
<tbody>
<tr>
    <th>알림페이지<br>모듈아이디</th>
    <td>
        <input type="text" name="mid" id="mid" class="frm_input" value="<?php echo $wcfg["mid"]?>" size="20">
    </td>
</tr>
</tbody>
</table>