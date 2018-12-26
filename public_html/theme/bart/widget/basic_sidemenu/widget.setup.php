<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

$skins = get_skin_select('outlogin', 'skin', 'skin', $wcfg['skin'], 'required');
?>

<table>
<tbody>
<tr>
    <th>헤더배경색</th>
    <td>
        <input type="text" name="h_bg" id="h_bg" class="frm_input" value="<?php echo $wcfg["h_bg"]?>" size="20">
    </td>
</tr>
<tr>
    <th>헤더글자색</th>
    <td>
        <input type="text" name="h_color" id="h_color" class="frm_input" value="<?php echo $wcfg["h_color"]?>" size="20">
    </td>
</tr>
</tbody>
</table>