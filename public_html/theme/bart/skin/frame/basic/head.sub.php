<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet\builder as btb;

$dir = basename(dirname(__FILE__));
$temp = parse_url($_SERVER["REQUEST_URI"]);

$fcfg = btb\get_frame_config($dir, $_SERVER["REQUEST_URI"]);

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$frame_url.'/css/frame.css" />');
?>
<style type="text/css">
/*.container{width:1000px !important;}
.d-none{display:block !important;}*/
</style>
