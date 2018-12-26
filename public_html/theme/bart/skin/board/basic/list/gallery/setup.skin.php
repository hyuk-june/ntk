<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

if(!btbo\exists_configfile($bo_table)){
    $default_checked = true;
}else{
    $default_checked = false;
}

?>
<table class="table table-bordered">
<tbody>
<tr>
    <th>헤더색상</th>
    <td><input type="text" name="list_head_color" value="<?php echo $bcfg["list_head_color"]?>" placeholder="#414141"></td>
</tr>
<tr>
    <th>출력옵션</th>
    <td>
        <label>
            <input type="checkbox" name="list_show_writer" value="1"<?php echo bt\get_checked('1', $bcfg['list_show_writer'], $default_checked)?>>
            작성자
        </label>
        <label>
            <input type="checkbox" name="list_show_datetime" value="1"<?php echo bt\get_checked('1', $bcfg['list_show_datetime'], $default_checked)?>>
            날짜
        </label>
        <label>
            <input type="checkbox" name="list_show_hit" value="1"<?php echo bt\get_checked('1', $bcfg['list_show_hit'], $default_checked)?>>
            조회수
        </label>
        <label>
            <input type="checkbox" name="list_show_good" value="1"<?php echo bt\get_checked('1', $bcfg['list_show_good'])?>>
            추천
        </label>
        <label>
            <input type="checkbox" name="list_show_nogood" value="1"<?php echo bt\get_checked('1', $bcfg['list_show_nogood'])?>>
            비추천
        </label>
    </td>
</tr>
<tr>
    <th>반응형설정</th>
    <td>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th>구분</th>
            <th>lg(≥1170px)</th>
            <th>md(≥992px)</th>
            <th>sm(≥768px)</th>
            <th>xs(&lt;765px)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>행당갯수</td>
            <td><input type="text" name="numpr[lg]" value="<?php echo $bcfg['numpr']['lg']?>" size="4"></td>
            <td><input type="text" name="numpr[md]" value="<?php echo $bcfg['numpr']['md']?>" size="4"></td>
            <td><input type="text" name="numpr[sm]" value="<?php echo $bcfg['numpr']['sm']?>" size="4"></td>
            <td><input type="text" name="numpr[xs]" value="<?php echo $bcfg['numpr']['xs']?>" size="4"></td>
        </tr>
        <tr>
            <td>상하여백</td>
            <td><input type="text" name="ma_w[lg]" value="<?php echo $bcfg['ma_w']['lg']?>" size="4"></td>
            <td><input type="text" name="ma_w[md]" value="<?php echo $bcfg['ma_w']['md']?>" size="4"></td>
            <td><input type="text" name="ma_w[sm]" value="<?php echo $bcfg['ma_w']['sm']?>" size="4"></td>
            <td><input type="text" name="ma_w[xs]" value="<?php echo $bcfg['ma_w']['xs']?>" size="4"></td>
        </tr>
        <tr>
            <td>좌우여백</td>
            <td><input type="text" name="ma_h[lg]" value="<?php echo $bcfg['ma_h']['lg']?>" size="4"></td>
            <td><input type="text" name="ma_h[md]" value="<?php echo $bcfg['ma_h']['md']?>" size="4"></td>
            <td><input type="text" name="ma_h[sm]" value="<?php echo $bcfg['ma_h']['sm']?>" size="4"></td>
            <td><input type="text" name="ma_h[xs]" value="<?php echo $bcfg['ma_h']['xs']?>" size="4"></td>
        </tr>
        </tbody>
        </table>
    </td>
    </tr>
    <tr>
    <th>썸네일크기</th>
    <td>
        <input type="text" name="thumb_w" size="4" value="<?php echo bt\varset($bcfg["thumb_w"])?>">
        x
        <input type="text" name="thumb_h" size="4" value="<?php echo bt\varset($bcfg["thumb_h"])?>">
        <label>미입력시 기본값 400 x 300, 반응형이라 화면에 보이는 크기는 유동적입니다</label>
    </td>
</tr>
</tbody>
</table>