<?php
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_admin){
    alert_close("권한이 없습니다");
}

$list = file("icon_list.txt");

include_once(G5_PATH.'/head.sub.php');

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.G5_THEME_CSS_URL.'/css/font-awesome/fontawesome.min.css" />');

?>

<style type="text/css">
body{padding-top:100px;}
.icon-name{ left:0; top:0; width:100%; position:fixed; background:#2d2d2d; color:#aaa; padding:0 10px;}
.icon-name .wrap{position:relative; padding: 5px 0;}
.icon-name .wrap input{border:1px solid #ddd; font-size:16px; padding:4px;}
.icon-name .wrap .btn{line-height:28px; padding:0 10px; border:1px solid #aaa; color:#ddd;}
.icon-name .wrap .btn:hover{text-decoration: none; background:#000; color:#fff;}
ul{list-style:none; padding:0; margin:0;}
li{float:left; padding:10px;}
li a{font-size:18px;}
li a span{font-size:11px;}
</style>

<div class="icon-name">
    <table class="wrap">
    <tr>
        <th>아이콘명</th>
        <td><input type="text" id="icon_name" class="frm_input" size="20"></td>
        <td align="right"><a href="#" class="btn btn-close">닫기</a></td>
    </tr>
    <tr>
        <th>태그</th>
        <td colspan="2"><input type="text" id="icon_tag" class="frm_input" style="width:100%"></td>
    </tr>
    </table>
</div>
<ul>
<?php foreach($list as $item){?>
    <li>
        <!-- <a href="#" class="icon" data-icon="<?php echo $item?>" title="<?php echo $item?>"><i class="fa fa-<?php echo $item?>"></i>  <span class=""><?php echo 'fa-'.$item?></span></a> -->
        <a href="#" class="icon" data-icon="<?php echo $item?>" title="<?php echo $item?>"><i class="<?php echo $item?>"></i>  <span class=""><?php echo $item?></span></a>
    </li>
<?php }?>
</ul>

<script type="text/javascript">
<!--
$(function(){
   $('.icon').click(function(evt){
       evt.preventDefault();
      $('#icon_name').val($(this).data('icon'));
      $('#icon_name').select();
      $('#icon_tag').val('<i class="fa fa-' + $(this).data('icon') + '"></i>');
   });
   
   $('.btn-close').click(function(){
      window.close(); 
   });
});
//-->
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');