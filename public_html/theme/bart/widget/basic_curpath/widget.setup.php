<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>

<table>
<tbody>
<tr>
    <th>배경색</th>
    <td><input type="text" name="bg" id="bg" size="20" class="frm_input" value="<?php echo $wcfg['bg']?>"></td>
</tr>
<tr>
    <th>글자색</th>
    <td>
        <input type="text" name="color_t" id="color_t" size="20" class="frm_input" value="<?php echo $wcfg['color_t']?>" placeholder="제목">
        <input type="text" name="color_s" id="color_s" size="20" class="frm_input" value="<?php echo $wcfg['color_s']?>" placeholder="부제목">
        <input type="text" name="color_p" id="color_p" size="20" class="frm_input" value="<?php echo $wcfg['color_p']?>" placeholder="현재위치">
    </td>
</tr>
<tr>
    <th>선색</th>
    <td><input type="text" name="color_line" id="color_line" size="20" class="frm_input" value="<?php echo $wcfg['color_line']?>"></td>
</tr>
<tr>
    <th>선굵기</th>
    <td>
        <input type="text" name="width_line[t]" id="width_line_t" size="10" class="frm_input" value="<?php echo $wcfg['width_line']['t']?>" placeholder="Top">px
        <input type="text" name="width_line[r]" id="width_line_r" size="10" class="frm_input" value="<?php echo $wcfg['width_line']['r']?>" placeholder="Right">px
        <input type="text" name="width_line[b]" id="width_line_b" size="10" class="frm_input" value="<?php echo $wcfg['width_line']['b']?>" placeholder="Bottom">px
        <input type="text" name="width_line[l]" id="width_line_l" size="10" class="frm_input" value="<?php echo $wcfg['width_line']['l']?>" placeholder="Left">px
    </td>
</tr>
</tbody>
</table>
