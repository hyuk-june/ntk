<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$skins = get_skin_select('connect', 'skin', 'skin', $wcfg['skin'], 'required');
?>


    <table>
    <tbody>
    <tr>
        <th>스킨</th>
        <td>
            <?php echo $skins?>
        </td>
    </tr>
    </tbody>
    </table>
