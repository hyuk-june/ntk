<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가  

use kr\bartnet as bt;

if(bt\isval($_POST["mb_birth"])){
	$sql = "UPDATE ".$g5["member_table"]." SET mb_birth='".$_POST["mb_birth"]."' WHERE mb_id='".$member["mb_id"]."'";
	sql_query($sql);
}