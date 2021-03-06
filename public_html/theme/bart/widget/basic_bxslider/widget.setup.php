<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<style type="text/css">
.vbg{height:35px; width:200px; min-height:0; vertical-align:middle;}
</style>

<script type="text/javascript">
<!--
var _csWidget = function(){
    
    function createRow(vbg){
        
        if(vbg==undefined) vbg = '';
                
        var str = '<li><input type="text" name="vbg[]" class="value frm_input" placeholder="이미지URL" size="50" value="' + vbg + '">&nbsp;'
            + '<button type="button" class="btn-del btn">삭제</button>';
            
        $('#items').append(str);
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
    $('#btn_add').click(function(){
        csWidget.createRow()
    });
    
    $('.db-vbg').each(function(i, e){
        csWidget.createRow($('.db-vbg').eq(i).html());
    });
});
//-->
</script>
<!-- 자바스크립트에서 사용 -->
<?php if(isset($wcfg['vbg'])){?>
    <?php for($i=0; $i<count($wcfg['vbg']); $i++){?>
        <div style="display:none" class="db-vbg"><?php echo $wcfg['vbg'][$i]?></div>
    <?php }?>
<?php }?>
<!-- //자바스크립트에서 사용 -->

<table>
<tbody>
<tr>
    <th>이미지 URL</th>
    <td>
        <div><button type="button" id="btn_add">추가</button></div>
        <ul id="items"></ul>
    </td>
</tr>
<tr>
    <th>세로크기</th>
    <td>
        <table>
        <thead>
        <tr>
            <th>xs(&lt;576px)</th>
            <th>sm(≥576px)</th>
            <th>md(≥768px)</th>
            <th>lg(≥992px)</th>
            <th>xl(≥1200px)</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="text" name="vheight[xs]" value="<?php echo $wcfg['vheight']['xs']?>" class="frm_input text-right" size="4">px</td>
            <td><input type="text" name="vheight[sm]" value="<?php echo $wcfg['vheight']['sm']?>" class="frm_input text-right" size="4">px</td>
            <td><input type="text" name="vheight[md]" value="<?php echo $wcfg['vheight']['md']?>" class="frm_input text-right" size="4">px</td>
            <td><input type="text" name="vheight[lg]" value="<?php echo $wcfg['vheight']['lg']?>" class="frm_input text-right" size="4">px</td>
            <td><input type="text" name="vheight[xl]" value="<?php echo $wcfg['vheight']['xl']?>" class="frm_input text-right" size="4">px</td>
        </tr>
        </tbody>
        </table>
    </td>
</tr>
<tr>
    <th>배경고정</th>
    <td>
        <input type="checkbox" name="fixed" id="fixed" value="1"<?php echo $wcfg['fixed']=='1' ? ' checked="checked"' : '';?>>
        <label for="fixed">슬라이딩과 스크롤시 배경을 고정시킵니다</label>
    </td>
</tr>
</tbody>
</table>