<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

include_once($board_skin_path.'/lib/board.lib.php');

use kr\bartnet as bt;
use kr\bartnet\board as btbo;

//코멘트 알림 보내기
btbo\send_alim_comment();
