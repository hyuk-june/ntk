<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<style type="text/css">
.url{height:35px; width:200px; min-height:0; vertical-align:middle;}
</style>

<script type="text/javascript">
<!--
var _csWidget = function(){
    
    function createRow(_data){
        var data = {
            year: null,
            month: null,
            memo: ''
        }
        
        if(typeof _data == 'object') data = $.extend(data, _data);
        
        var syear = createSelect('y', data.year);
        var smonth = createSelect('m', data.month);
        var btn = $('<button type="button" class="btn btn-del mx-1">삭제</button>');
        var lbl = $('<span>※ 같은달에 여러항목이 있을때는 줄바꿈으로 구분해 주세요</span>');
        var memo = $('<textarea name="memo[]" class="required" style="width:100%;height:50px;min-height:0;" required="required">' + data.memo + '</textarea>');
        
        var wrap = $('<li></li>');
        
        wrap.append(syear);
        wrap.append(smonth);
        wrap.append(btn);
        wrap.append(lbl);
        wrap.append(memo);
            
        $('#items').append(wrap);
    }
    
    function createSelect(mode, cvalue){
        
        if(cvalue === undefined || typeof(cvalue) != 'string') cvalue = '';
        mode = mode.toLowerCase();
        
        var sel = null;
        var s = 0;
        var e = 0;
        if(mode=='y'){
            var tday = new Date();
            s = parseInt(tday.getFullYear());
            e = 1900;
            sel = $('<select name="year[]">');
            
            for(var i=s; i>=e; i--){
                var opt = $('<option>').attr('value', i).text(i);
                if(i.toString()==cvalue.toString()) opt.attr('selected', 'selected');
                sel.append(opt);
            }
            
        }else if(mode=='m'){
            s = 1;
            e = 12;
            sel = $('<select name="month[]">');
            
            for(var i=s; i<=e; i++){
                
                var j = (i < 10) ? '0' + i : i;
                var opt = $('<option>').attr('value', i).text(j);
                if(i.toString()==cvalue.toString()) opt.attr('selected', 'selected');
                sel.append(opt);
            }
        }else return;
        
        return sel;
    }
    
    function removeRow(e){
        e.preventDefault();
        var idx = $('.btn-del').index(this);
        $('#items >li').eq(idx).remove();
    }
    
    $(document).ready(function(){
        $(document).on('click', '.btn-del', removeRow);
    });
    
    return{
        createRow: createRow
    }
}

$(document).ready(function(){
    var csWidget = _csWidget();
    $('#btn_add').click(csWidget.createRow);
    
    $('.db-year').each(function(i, e){
        var data = {
            year: $('.db-year').eq(i).html(),
            month: $('.db-month').eq(i).html(),
            memo: $('.db-memo').eq(i).html()
        }
        csWidget.createRow(data);
    });
});
//-->
</script>

<!-- 자바스크립트에서 사용 -->
<?php if(isset($wcfg['year'])){?>
    <?php for($i=0; $i<count($wcfg['year']); $i++){?>
        <div style="display:none" class="db-year"><?php echo $wcfg['year'][$i]?></div>
        <div style="display:none" class="db-month"><?php echo $wcfg['month'][$i]?></div>
        <div style="display:none" class="db-memo"><?php echo $wcfg['memo'][$i]?></div>
    <?php }?>
<?php }?>
<!-- //자바스크립트에서 사용 -->

<table>
<tbody>
<tr>
    <th><label for="css">CSS</label></th>
    <td>
        <textarea name="css" id="css" style="width:100%;height:200px"><?php echo $wcfg['css']?></textarea>
    </td>
</tr>
<tr>
    <th><label for="ele_id">엘리먼트아이디</label></th>
    <td>
        <input type="text" name="ele_id" id="ele_id" required="required" class="frm_input required alnum_" value="<?php echo $wcfg['ele_id']?>">
        <?php echo help("※ 링크탭을 식별할 수 있는 html ID를 임의로 지정해주세요(영문,숫자,'_')");?>
    </td>
</tr>
<tr>
    <th>연혁정보</th>
    <td>
        <div><button type="button" id="btn_add">추가</button></div>
        <ul id="items"></ul>
    </td>
</tr>
</tbody>
</table>