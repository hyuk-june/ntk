<?php
/*
title:다음지도
description:다음지도 위젯
version:1.0.1
author:NTK
single:false
*/

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!bt\isval($wcfg['daum_map_apikey'])) return;

add_javascript('<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey='.$wcfg['daum_map_apikey'].'&libraries=services,clusterer,drawing"></script>');
add_javascript('<script type="text/javascript" src="'.$widget_url.'/widget.js"></script>');
?>
<div class="widget-basic-daum-map">
    <div class="map" style="width:100%;"></div>
</div>

<?php if(bt\isval($eid)){?>
<script type="text/javascript">
<!--
$(document).ready(function(){
    if(typeof daum !== 'undefined') $('<?php echo $eid?> .map').daumMap('<?php echo $wcfg['address']?>', '<?php echo $wcfg['label']?>');
});
//-->
</script>
<?php }?>

