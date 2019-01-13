<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
?>
<table>
<tr>
    <th rowspan="2">이미지</th>
    <th>URL</th>
    <td><input type="text" name="imgsrc" value="<?php echo $wcfg["imgsrc"]?>" required="required" class="required frm_input" style="width:100%"></td>
</tr>
<tr>
    <td colspan="2">
        <table>
        <thead>
        <tr>
            <th>구분</th>
            <th>xs(&lt;576px)</th>
            <th>sm(≥576px)</th>
            <th>md(≥768px)</th>
            <th>lg(≥992px)</th>
            <th>xl(≥1200px)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>세로높이</td>
            <td><input type="text" name="height[xs]" value="<?php echo $wcfg['height']['xs']?>" class="frm_input" size="4">px</td>
            <td><input type="text" name="height[sm]" value="<?php echo $wcfg['height']['sm']?>" class="frm_input" size="4">px</td>
            <td><input type="text" name="height[md]" value="<?php echo $wcfg['height']['md']?>" class="frm_input" size="4">px</td>
            <td><input type="text" name="height[lg]" value="<?php echo $wcfg['height']['lg']?>" class="frm_input" size="4">px</td>
            <td><input type="text" name="height[xl]" value="<?php echo $wcfg['height']['xl']?>" class="frm_input" size="4">px</td>
        </tr>
        </tbody>
        </table>
    </td>
</tr>
</table>