<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$is_mobile = is_mobile();

if($is_mobile) $device = 'mobile';
else $device = 'pc';

$sql = " select * from {$g5['new_win_table']}
          where '".G5_TIME_YMDHIS."' between nw_begin_time and nw_end_time
            and nw_device IN ( 'both', '".$device."' )
          order by nw_id asc ";
$result = sql_query($sql, false);
?>

<!-- 팝업레이어 시작 { -->
<div id="hd_pop" style="width:100%; z-index: 10000;">
    <h2>팝업레이어 알림</h2>

<?php

for ($i=0; $nw=sql_fetch_array($result); $i++)
{
    // 이미 체크 되었다면 Continue
    if ($_COOKIE["hd_pops_{$nw['nw_id']}"])
        continue;
        
    $style = "width:100%; padding:10px; background: transparent;";
    if(!$is_mobile){
        $style = "top: ".$nw['nw_top']."px; left: ".$nw['nw_left']."px; min-width: ".$nw['nw_width']."px;";
    }
?>

    <div id="hd_pops_<?php echo $nw['nw_id'] ?>" class="hd_pops" style="<?php echo $style?>;">
        <div class="hd_pops_con" style="height:100%; background:#fff; min-height:<?php echo $nw['nw_height']?>px">
            <?php echo conv_content($nw['nw_content'], 1); ?>
        </div>
        <div class="hd_pops_footer">
            <button class="hd_pops_reject hd_pops_<?php echo $nw['nw_id']; ?> <?php echo $nw['nw_disable_hours']; ?>"><strong><?php echo $nw['nw_disable_hours']; ?></strong>시간 동안 다시 열람하지 않습니다.</button>
            <button class="hd_pops_close hd_pops_<?php echo $nw['nw_id']; ?>">닫기</button>
        </div>
    </div>
<?php }
if ($i == 0) echo '<span class="sound_only">팝업레이어 알림이 없습니다.</span>';
?>
</div>

<script>
$(function() {
    $(".hd_pops_reject").click(function() {
        var id = $(this).attr('class').split(' ');
        var ck_name = id[1];
        var exp_time = parseInt(id[2]);
        $("#"+id[1]).css("display", "none");
        set_cookie(ck_name, 1, exp_time, g5_cookie_domain);
    });
    $('.hd_pops_close').click(function() {
        var idb = $(this).attr('class').split(' ');
        $('#'+idb[1]).css('display','none');
    });
    $("#hd").css("z-index", 1000);
});
</script>
<!-- } 팝업레이어 끝 -->