<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<!--<div class="visual">
    <div style="width:100%;height:<?php echo $vh?>px;background:url(/theme/bart/img/visual.jpg) bottom center /cover">
</div>-->

<div class="middle ma-t-10">
    <div class="visual-top"><?php btb\show_widgets(__FILE__, $pg_id, "visual_top")?></div>
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-9">