<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(is_mobile()) $vh = '100';
else if(defined('_INDEX_')) $vh = '300';
else $vh = '200';
?>

<!--<div class="visual">
    <div style="width:100%;height:<?php echo $vh?>px;background:url(/theme/bart/img/visual.jpg) bottom center /cover">
</div>-->

<div class="middle ma-t-10">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-9">