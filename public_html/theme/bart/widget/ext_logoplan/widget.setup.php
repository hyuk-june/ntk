<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$logo_url = bt\binstr($wcfg['logo_url'], G5_URL);
?>

<script type="text/javascript">
<!--
var _csWidget = function(){
    
    function createRow(_data){
        var data = {
            sdate: '',
            edate: '',
            imgurl: ''
        }
        
        if(typeof _data == 'object') data = $.extend(data, _data);
            
        var row = $('#tpl li').clone();
        
        $('.sdate', row).val(data.sdate);
        $('.sdate', row).attr('name', 'sdate[]');
        $('.edate', row).val(data.edate);
        $('.edate', row).attr('name', 'edate[]');
        $('.imgurl', row).val(data.imgurl);
        $('.imgurl', row).attr('name', 'imgurl[]');
            
        $('#items').append(row);
    }
    
    function removeRow(e){
        e.preventDefault();
        var idx = $('#items .btn-del').index(this);
        console.log(idx);
        $('#items >li').eq(idx).remove();
    }
    
    $(document).ready(function(){
        $(document).on('click', '#items .btn-del', removeRow);
    });
    
    return{
        createRow: createRow
    }
}



$(document).ready(function(){
    var csWidget = _csWidget();
    $('#btn_add').click(csWidget.createRow);
    
    $('.db-imgurl').each(function(i, e){
        var data = {
            sdate: $('.db-sdate').eq(i).html(),
            edate: $('.db-edate').eq(i).html(),
            imgurl: $('.db-imgurl').eq(i).html()
        }
        csWidget.createRow(data);
    });
    
    $('body').on('focus', "#items .sdate, #items .edate", function(){
        $(this).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: "yy-mm-dd",
            showButtonPanel: true,
            yearRange: "c-99:c+99",
            maxDate: "+0d"
        });
    });
});
//-->
</script>

<ul id="tpl" style="display:none">
    <li style="font-size:12px;color:blue;">
        <input type="text" class="sdate frm_input" value="" size="10" placeholder="시작날짜">
        <input type="text" class="edate frm_input" value="" size="10" placeholder="마감날짜">
        <input type="text" class="imgurl frm_input" value="" size="30" placeholder="이미지URL">
        <button type="button" class="btn-del">삭제</button>
    </li>
</ul>

<!-- 자바스크립트에서 사용 -->
<?php if(isset($wcfg['imgurl'])){?>
    <?php for($i=0; $i<count($wcfg['imgurl']); $i++){?>
        <div style="display:none" class="db-sdate"><?php echo $wcfg['sdate'][$i]?></div>
        <div style="display:none" class="db-edate"><?php echo $wcfg['edate'][$i]?></div>
        <div style="display:none" class="db-imgurl"><?php echo $wcfg['imgurl'][$i]?></div>
    <?php }?>
<?php }?>
<!-- //자바스크립트에서 사용 -->

<table>
<tbody>
<tr>
    <th>URL</th>
    <td>
        <input type="text" name="logo_url" value="<?php echo $logo_url?>" class="frm_input" style="width:100%">
    </td>
</tr>
<tr>
    <th>대표로고이미지</th>
    <td><input type="text" name="logo_img" value="<?php echo $wcfg['logo_img']?>" class="frm_input" style="width:100%"></td>
</tr>
<tr>
    <th>날짜별로고</th>
    <td>
        <div><button type="button" id="btn_add">추가</button></div>
        <ul id="items"></ul>
    </td>
</tr>
</tbody>
</table>