<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>
<table>
<tr>
    <th>높이</th>
    <td><input type="text" name="height" value="<?php echo $wcfg["height"]?>" size="6" required="required" class="required frm_input">px</td>
</tr>
<tr>
    <th>URL</th>
    <td><input type="text" name="src" value="<?php echo $wcfg["src"]?>" size="40" required="required" class="required frm_input"></td>
</tr>
</table>