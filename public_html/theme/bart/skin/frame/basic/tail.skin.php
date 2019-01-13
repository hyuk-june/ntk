<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

include_once(BT_SKIN_PATH.'/layout/'.$layout_skin.'/layout_tail.skin.php');

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$footer_bg = '#'.trim(bt\binstr($fcfg['footer_bg'], '325859'), '#');
$footer_color = '#'.trim(bt\binstr($fcfg['footer_color'], '000000'), '#');
add_stylesheet('<style type="text/css">.tail{background-color:'.$footer_bg.'; color:'.$footer_color.';}</style>');
?>  
</div>


<div class="bt-frame">
    <div class="d-block d-sm-none">
        <div class="container">
            <div class="row">
                <div class="col-2 col-sm-4"></div>
                <div class="col-2 col-sm-4"></div>
            </div>
        </div>
    </div>


    <!-- } 콘텐츠 끝 -->

    
    <!-- 하단 시작 { -->
    <div class="tail">
        <div class="tail-widgets">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail1");?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail2");?>
                    </div>
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail3");?>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail4");?>
                    </div>
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail5");?>
                    </div>
                    <div class="col">
                        <?php echo btb\show_widgets(__FILE__, "", "tail6");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="float-btns">
    <a href="http://kbay.co.kr/" class="float-btn" id="btn_scroll_top" title="도움말" target="_blank"><i class="fa fa-question-circle"></i></a>
    <a href="#" class="float-btn" id="btn_scroll_top" title="상단으로"><i class="fa fa-arrow-up"></i></a>
<?php if($is_admin){?>
    <a href="#" class="float-btn" id="btn_frame_controller" title="프레임설정"><i class="fa fa-window-maximize"></i></a>
    <a href="#" class="float-btn" id="btn_widget_controller" title="위젯편집"><i class="fa fa-cog"></i></a>
<?php }?>
</div>

<script type="text/javascript">
<!--
$(document).ready(function(){
    var pad = ($('.tail').outerHeight() + 10) + 'px';
    $('body').css('padding-bottom', pad);
});
//-->
</script>

<?php include_once("slide_menu.php");?>