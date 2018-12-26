<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

include_once($board_skin_path.'/lib/board.lib.php');

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

include_once("board.cmm.php");

//옵션데이타
$opt_data = array();

@include_once($sub_paths['write'].'/write_update.head.sub.skin.php');