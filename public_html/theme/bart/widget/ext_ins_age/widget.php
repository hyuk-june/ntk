<?php
/*
title: 보험나이계산기
description: 보험나이계산기
version:1.0.0
author:NTK
single:false
*/

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!defined("_GNUBOARD_")) exit("Access Denied");

add_stylesheet($css);

$n_date = '';
$b_date = '';
$sex = '';
if ($_GET["n_date"] && $_GET["b_date"]) {
    $n_date = $_GET["n_date"];
    $b_date = $_GET["b_date"];
    $sex = $_GET["sex"];
    $ndate = new DateTime($n_date);
    $bdate = new DateTime($b_date);
    
    $diff = date_diff($bdate, $ndate);
    $age = $diff->y;
    if ($diff->m >= 6) $age++;
    
    $next_date = date('Y-m-d', strtotime($n_date.' +1 month'));
}

parse_str($_SERVER["QUERY_STRING"], $qs);
unset($qs['n_date']);
unset($qs['b_date']);

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');
?>
<div class="widget-ins-age border p-2">
    <form name="fcalc">
    <?php foreach($qs as $key => $value){?>
        <input type="hidden" name="<?php echo $key?>" value="<?php echo $value?>">
    <?php }?>
        <div class="form-group row">
            <label for="now" class="col-form-label col-sm-2">성별</label>
            <div class="col-sm-10">
                <input type="radio" name="sex" value="남" id="rdo_lewd" class="input_rdo" checked="checked">
                <label for="rdo_lewd">&nbsp;남성</label>
                <input type="radio" name="sex" value="여" id="rdo_insult" class="input_rdo">
                <label for="rdo_insult">&nbsp;여성</label>
            </div>
        </div>
        <div class="form-group row">
            <label for="now" class="col-form-label col-sm-2">보험계약일</label>
            <div class="col-sm-10">
                <input type="text" id="n_date" name="n_date" class="form-control" placeholder="보험계약일" readonly="readonly" value="<?php echo $n_date?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="now" class="col-form-label col-sm-2">생년월일</label>
            <div class="col-sm-10">
                <input type="text" id="b_date" name="b_date" class="form-control" placeholder="생년월일" readonly="readonly" value="<?php echo $b_date?>">
            </div>
        </div>
        <button type="submit" class="btn-submit btn-block btn btn-lg btn-primary">보험나이 계산하기</button>
    </form>
<?php if($age) {?>
    <div class="card mt-2">
        <div class="card-body text-center">
            <p class="my-4" style="text-decoration: underline; font-size: 1.5rem;">보험계약일에 해당하는 보험나이는 <strong style="color: #ff8000;"><?php echo $age?></strong>세 입니다.</p>
            <p>
                다음 보험상령일은 <?php echo $next_date?>입니다.<br />
                <?php echo $next_date?>부터 보험나이 상승으로 보험료 인상이 예상됩니다.
            </p>
        </div>
    </div>
    <a href="<?php echo G5_BBS_URL?>/write.php?bo_table=silbi&birth=<?php echo $b_date?>&sex=<?php echo $sex?>" class="btn-submit btn-block btn btn-lg btn-danger"><?php echo $age?>세 실비보험 견적조회하기</a>
<?php }?>
</div>

<script type="text/javascript">
<!--
$(function(){
    $("#n_date, #b_date").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99"});
});
//-->
</script>


