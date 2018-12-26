<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_member){
    alert_close("회원전용기능입니다");
}

if($act=='save'){
    btb\BMember::uploadPhoto($member['mb_id'], 'mb_photo');
    goto_url($module_self_url);
}else if($act=='del'){
    btb\BMember::removePhoto($member['mb_id'], 'mb_photo');
    goto_url($module_self_url);
}