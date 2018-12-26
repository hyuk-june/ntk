<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

include_once($board_skin_path.'/lib/board.lib.php');

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

include_once("board.cmm.php");

//옵션데이타
$opt_data = array();

@include_once($sub_paths['write'].'/write_update.sub.skin.php');

//옵션저장
btbo\save_option($bo_table, $wr_id, $opt_data);