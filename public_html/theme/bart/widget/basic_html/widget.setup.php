<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<style type="text/css">
.html{width:100%; min-height:400px;}
</style>


<table>
<tbody>
<tr>
    <th>HTML</th>
    <td>
        <textarea name="html" class="html"><?php echo stripslashes($wcfg["html"])?></textarea>
    </td>
</tr>
</tbody>
</table>