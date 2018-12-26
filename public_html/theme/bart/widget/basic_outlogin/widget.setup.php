<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

$skins = get_skin_select('outlogin', 'skin', 'skin', $wcfg['skin'], 'required');
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
    <th>알림페이지<br>모듈아이디</th>
    <td>
        <input type="text" name="alim_mid" id="alim_mid" class="frm_input" value="<?php echo $wcfg["alim_mid"]?>" size="20">
        <?php echo help('theme/basic 전용기능입니다');?>
    </td>
</tr>
<tr>
    <th>마이페이지<br>모듈아이디</th>
    <td>
        <input type="text" name="mypage_mid" id="mypage_mid" class="frm_input" value="<?php echo $wcfg["mypage_mid"]?>" size="20">
        <?php echo help('theme/basic 전용기능입니다');?>
    </td>
</tr>
</tbody>
</table>