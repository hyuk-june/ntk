<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$flex_align_s = new bt\html\BSelectbox();
$flex_align_s->add('between', '배분형');
$flex_align_s->add('left', '왼쪽정렬');
$flex_align_s->add('right', '오른쪽정렬');

if($wcfg['flex_align']){
    $flex_align_s->selectedFromValue = $wcfg['flex_align'];
}

$text_align_s = new bt\html\BSelectbox();
$text_align_s->add('center', '가운데');
$text_align_s->add('left', '왼쪽정렬');
$text_align_s->add('right', '오른쪽정렬');

if($wcfg['text_align']){
    $text_align_s->selectedFromValue = $wcfg['text_align'];
}
?>

<style type="text/css">
.url{height:35px; width:200px; min-height:0; vertical-align:middle;}
</style>

<script type="text/javascript">
<!--
var _csWidget = function(){
    
    function createRow(_data){
        var data = {
            url: '',
            text: ''
        }
        
        if(typeof _data == 'object') data = $.extend(data, _data);
                console.log(data);
        var str = '<li style="font-size:12px;color:blue"><input type="text" name="url[]" class="url frm_input" value="' + data.url + '" size="40" placeholder="URL">'
            + '<input type="text" name="text[]" class="text frm_input" placeholder="텍스트" value="' + data.text + '">'
            + '<button type="button" class="btn-del">삭제</button>';
            
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
    $('#btn_add').click(csWidget.createRow);
    
    $('.db-url').each(function(i, e){
        var data = {
            url: $('.db-url').eq(i).html(),
            text: $('.db-text').eq(i).html()
        }
        csWidget.createRow(data);
    });
});
//-->
</script>

<!-- 자바스크립트에서 사용 -->
<?php if(isset($wcfg['url'])){?>
    <?php for($i=0; $i<count($wcfg['url']); $i++){?>
        <div style="display:none" class="db-url"><?php echo $wcfg['url'][$i]?></div>
        <div style="display:none" class="db-text"><?php echo $wcfg['text'][$i]?></div>
    <?php }?>
<?php }?>
<!-- //자바스크립트에서 사용 -->

<table>
<tbody>
<tr>
    <th>탭</th>
    <td>
        <div><button type="button" id="btn_add">추가</button></div>
        <ul id="items"></ul>
    </td>
</tr>
<tr>
    <th><label>선 감춤</label></th>
    <td>
        <input type="checkbox" name="line_hide" id="line_hide" value="1"<?php echo $wcfg['line_hide']=='1' ? ' checked="checked"':'';?>>
        <label for="line_hide">선을 감춥니다</label>
    </td>
</tr>
<tr>
    <th><label for="line_color">선색상</label></th>
    <td>
        <input type="text" name="line_color" id="line_color" class="frm_input" value="<?php echo $wcfg['line_color']?>">
    </td>
</tr>
<tr>
    <th><label for="text_color">글자색상</label></th>
    <td>
        <input type="text" name="text_color" id="text_color" class="frm_input" value="<?php echo $wcfg['text_color']?>">
    </td>
</tr>
<tr>
    <th><label for="flex_align">박스배치</label></th>
    <td>
        <select name="flex_align" id="flex_align">
            <?php echo $flex_align_s->getOption();?>
        </select>
    </td>
</tr>
<tr>
    <th><label for="text_align">글자배치</label></th>
    <td>
        <select name="text_align" id="text_align">
            <?php echo $text_align_s->getOption();?>
        </select>
    </td>
</tr>
</tbody>
</table>