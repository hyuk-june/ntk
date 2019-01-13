<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

$target_s = new bt\html\BSelectbox();
if(bt\isval($wcfg['target'])) $target_s->selectedFromValue = $wcfg['target'];
$target_s->add('_self', '현재창');
$target_s->add('_blank', '새창');

$align_s = new bt\html\BSelectbox();
$align_s->add('left', '왼쪽정렬');
$align_s->add('center', '중앙정렬');
$align_s->add('right', '오른쪽정렬');
?>
<table>
<tr>
    <th rowspan="3">이미지</th>
    <th>URL</th>
    <td><input type="text" name="imgsrc" value="<?php echo $wcfg["imgsrc"]?>" required="required" class="required frm_input" style="width:100%"></td>
</tr>
<tr>
    <th>alt 속성</th>
    <td><input type="text" name="alt" value="<?php echo $wcfg["alt"]?>" class="frm_input" style="width:100%"></td>
</tr>
<tr>
    <th>가로정렬</th>
    <td>
        <select name="align" class="frm_input">
            <?php echo $align_s->getOption();?>
        </select>
    </td>
</tr>
<tr>
    <th rowspan="3">링크</th>
    <th>URL</th>
    <td><input type="text" name="link" value="<?php echo $wcfg["link"]?>" class="frm_input" style="width:100%"></td>
</tr>
<tr>
    <th>title 속성</th>
    <td><input type="text" name="title" value="<?php echo $wcfg["title"]?>" class="frm_input" style="width:100%"></td>
</tr>
<tr>
    <th>target</th>
    <td>
        <select name="target" class="frm_input">
            <?php echo $target_s->getOption();?>
        </select>
    </td>
</tr>
</table>