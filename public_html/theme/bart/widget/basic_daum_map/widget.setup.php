<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>

<table>
<tbody>
<tr>
    <th><label for="ele_id">엘리먼트아이디</label></th>
    <td>
        <input type="text" name="ele_id" id="ele_id" required="required" class="frm_input required alnum_" value="<?php echo $wcfg['ele_id']?>">
        <?php echo help("※ 링크탭을 식별할 수 있는 html ID를 임의로 지정해주세요(영문,숫자,'_')");?>
    </td>
</tr>
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
</tbody>
</table>