<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

$skins = get_skin_select('outlogin', 'skin', 'skin', $wcfg['skin'], 'required');
?>

<table>
<tbody>
<tr>
    <th rowspan="3">헤더</th>
    <td rowspan="3"></td>
    <th>선색</th>
    <td><input type="text" name="h_line" id="h_line" class="frm_input" value="<?php echo $wcfg["h_line"]?>" size="20"></td>
</tr>
<tr>
    <th>배경색</th>
    <td><input type="text" name="h_bg" id="h_bg" class="frm_input" value="<?php echo $wcfg["h_bg"]?>" size="20"></td>
</tr>
<tr>
    <th>글자색</th>
    <td><input type="text" name="h_color" id="h_color" class="frm_input" value="<?php echo $wcfg["h_color"]?>" size="20"></td>
</tr>
<tr>
    <th rowspan="5">서브메뉴</th>
    <th></th>
    <th>선색</th>
    <td><input type="text" name="s_line" id="s_line" class="frm_input" value="<?php echo $wcfg["s_line"]?>" size="20"></td>
</tr>
<tr>
    <th rowspan="2">기본</th>
    <th>배경색</th>
    <td><input type="text" name="s_bg" id="s_bg" class="frm_input" value="<?php echo $wcfg["s_bg"]?>" size="20"></td>
</tr>
<tr>
    <th>글자색</th>
    <td><input type="text" name="s_color" id="s_color" class="frm_input" value="<?php echo $wcfg["s_color"]?>" size="20"></td>
</tr>
<tr>
    <th rowspan="2">활성</th>
    <th>배경색</th>
    <td><input type="text" name="s_bg_a" id="s_bg_a" class="frm_input" value="<?php echo $wcfg["s_bg_a"]?>" size="20"></td>
</tr>
<tr>
    <th>글자색</th>
    <td><input type="text" name="s_color_a" id="s_color_a" class="frm_input" value="<?php echo $wcfg["s_color_a"]?>" size="20"></td>
</tr>
</tbody>
</table>