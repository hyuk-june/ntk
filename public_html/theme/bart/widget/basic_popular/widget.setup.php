<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

$skins = get_skin_select('popular', 'skin', 'skin', $wcfg['skin'], 'required');
?>

<table>
<tbody>
<tr>
    <th>스킨</th>
    <td>
        <?php echo $skins?>
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
        <input type="text" name="pre_word" value="<?php echo $wcfg["pre_word"]?>" size="50" class="frm_input">
        <span class="frm_info">구분자: '|', 인기검색어가 검색어갯수보다 적을때 기본검색어를 추가해서 출력합니다</span>
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
