<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>

<table>
<tbody>
<tr>
    <th><label for="daum_map_apikey">다음지도 API키</label></th>
    <td>
        <input type="text" name="daum_map_apikey" id="daum_map_apikey" required="required" class="frm_input required" size="40" value="<?php echo $wcfg['daum_map_apikey']?>">
    </td>
</tr>
<tr>
    <th><label for="address">주소</label></th>
    <td>
        <input type="text" name="address" id="address" value="<?php echo $wcfg["address"]?>" size="80" class="frm_input">
    </td>
</tr>
<tr>
    <th><label for="label">상호/위치명</label></th>
    <td>
        <input type="text" name="label" id="label" value="<?php echo $wcfg["label"]?>" size="80" class="frm_input">
    </td>
</tr>
<tr>
    <th><label for="label">세로크기</label></th>
    <td>
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
            <td>세로크기</td>
            <td><input type="text" name="height[xs]" value="<?php echo $wcfg['height']['xs']?>" class="frm_input" size="4"></td>
            <td><input type="text" name="height[sm]" value="<?php echo $wcfg['height']['sm']?>" class="frm_input" size="4"></td>
            <td><input type="text" name="height[md]" value="<?php echo $wcfg['height']['md']?>" class="frm_input" size="4"></td>
            <td><input type="text" name="height[lg]" value="<?php echo $wcfg['height']['lg']?>" class="frm_input" size="4"></td>
            <td><input type="text" name="height[xl]" value="<?php echo $wcfg['height']['xl']?>" class="frm_input" size="4"></td>
        </tr>
        </tbody>
        </table>
    </td>
</tr>
</tbody>
</table>