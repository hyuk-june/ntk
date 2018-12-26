<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>

<table>
<tbody>
<tr>
    <th>인기검색어</th>
    <td>
        <label>
            <input type="checkbox" name="popular" value="1"<?php echo $wcfg["popular"]=='1'? ' checked="checked"':'';?>>
            사용함
        </label>
    </td>
</tr>
<tr>
    <th>검색어갯수</th>
    <td>
        <input type="text" name="pop_cnt" value="<?php echo $wcfg["pop_cnt"]?>" size="4" class="frm_input">
        개
    </td>
</tr>
<tr>
    <th>기본검색어</th>
    <td>
        <span class="frm_info">인기검색어가 검색어갯수보다 적을때 추가해서 출력합니다</span>
        <span class="frm_info">여러개 입력시 '|'문자로 구분해 주세요</span>
        <input type="text" name="pre_word" value="<?php echo $wcfg["pre_word"]?>" size="50" class="frm_input">
    </td>
</tr>
<tr>
    <th>적용일수</th>
    <td>
        <input type="text" name="date_cnt" value="<?php echo $wcfg["date_cnt"]?>" size="4" class="frm_input">
        일 이전까지의 데이타를 적용
    </td>
</tr>
</tbody>
</table>