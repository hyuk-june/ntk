<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);

if($_POST["mb_1"]=="C" || $member["mb_1"]=="C"){
    include_once($member_skin_path."/register_form_company.skin.php");
}else{
    include_once($member_skin_path."/register_form_private.skin.php");
}