<?php
/*
title: WYSIWYG HTML 에디터 위젯
description: 비주얼 HTML 에디터 위젯입니다
version:1.0.0
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");
?>
<div class="widget-basic-dhtml">
    <?php echo stripcslashes($wcfg["html"]);?>
</div>