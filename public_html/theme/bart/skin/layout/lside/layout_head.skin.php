<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<div class="middle ma-t-10">
    <div class="container">
        <div class="row">
            <aside class="col-lg-3 visible-lg">
                <?php btb\show_widgets(__FILE__, "", "side");?>
            </aside>
            <div class="col-lg-9">