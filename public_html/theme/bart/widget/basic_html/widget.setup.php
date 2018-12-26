<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<style type="text/css">
textarea{width:100%; min-height:400px;}
</style>


<table>
<tbody>
<tr>
    <th>CSS</th>
    <td>
        <textarea name="css"><?php echo stripslashes($wcfg["css"])?></textarea>
    </td>
</tr>
<tr>
    <th>HTML</th>
    <td>
        <textarea name="html"><?php echo stripslashes($wcfg["html"])?></textarea>
    </td>
</tr>
</tbody>
</table>