<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$s = new bt\html\BSelectbox();
if(bt\isval($wcfg['type'])) $s->selectedFromValue = $wcfg['type'];
$s->add('left', '왼쪽정렬');
$s->add('both', '배분형');
?>


    <table>
    <tbody>
    <tr>
        <th>타입</th>
        <td colspan="3">
            <select name="type">
                <?php echo $s->getOption()?>
            </select>
        </td>
    </tr>
    <tr>
        <th rowspan="8">색상</th>
        <th rowspan="4">메인메뉴</th>
        <th>바탕화면</th>
        <td>
            <input type="text" name="bgcolor" value="<?php echo bt\varset($wcfg['bgcolor'])?>" class="frm_input" size="8">
        </td>
    </tr>
    <tr>
        <th>기본</th>
        <td>
            배경색: <input type="text" name="bgcolor_n" value="<?php echo bt\varset($wcfg['bgcolor_n'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="color_n" value="<?php echo bt\varset($wcfg['color_n'])?>" class="frm_input" size="8">
            <input type="checkbox" name="bold_n" id="bold_n" value="1"<?php echo $wcfg['bold_n']=='1' ? ' checked="checked"' : '';?>>
            <label for="bold_n">굵게</label>
        </td>
    </tr>
    <tr>
        <th>마우스오버</th>
        <td>
            배경색: <input type="text" name="bgcolor_o" value="<?php echo bt\varset($wcfg['bgcolor_o'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="color_o" value="<?php echo bt\varset($wcfg['color_o'])?>" class="frm_input" size="8">
            <input type="checkbox" name="bold_o" id="bold_o" value="1"<?php echo $wcfg['bold_o']=='1' ? ' checked="checked"' : '';?>>
            <label for="bold_o">굵게</label>
        </td>
    </tr>
    <tr>
        <th>현재메뉴</th>
        <td>
            배경색: <input type="text" name="bgcolor_c" value="<?php echo bt\varset($wcfg['bgcolor_c'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="color_c" value="<?php echo bt\varset($wcfg['color_c'])?>" class="frm_input" size="8">
            <input type="checkbox" name="bold_c" id="bold_c" value="1"<?php echo $wcfg['bold_c']=='1' ? ' checked="checked"' : '';?>>
            <label for="bold_c">굵게</label>
        </td>
    </tr>
    
    <tr>
        <th rowspan="4">서브메뉴</th>
        <th>바탕화면</th>
        <td>
            <input type="text" name="s_bgcolor" value="<?php echo bt\varset($wcfg['s_bgcolor'])?>" class="frm_input" size="8">
        </td>
    </tr>
    <tr>
        <th>기본</th>
        <td>
            배경색: <input type="text" name="s_bgcolor_n" value="<?php echo bt\varset($wcfg['s_bgcolor_n'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="s_color_n" value="<?php echo bt\varset($wcfg['s_color_n'])?>" class="frm_input" size="8">
            <input type="checkbox" name="s_bold_n" id="s_bold_n" value="1"<?php echo $wcfg['s_bold_n']=='1' ? ' checked="checked"' : '';?>>
            <label for="s_bold_n">굵게</label>
        </td>
    </tr>
    <tr>
        <th>마우스오버</th>
        <td>
            배경색: <input type="text" name="s_bgcolor_o" value="<?php echo bt\varset($wcfg['s_bgcolor_o'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="s_color_o" value="<?php echo bt\varset($wcfg['s_color_o'])?>" class="frm_input" size="8">
            <input type="checkbox" name="s_bold_o" id="s_bold_o" value="1"<?php echo $wcfg['s_bold_o']=='1' ? ' checked="checked"' : '';?>>
            <label for="s_bold_o">굵게</label>
        </td>
    </tr>
    <tr>
        <th>현재메뉴</th>
        <td>
            배경색: <input type="text" name="s_bgcolor_c" value="<?php echo bt\varset($wcfg['s_bgcolor_c'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="s_color_c" value="<?php echo bt\varset($wcfg['s_color_c'])?>" class="frm_input" size="8">
            <input type="checkbox" name="s_bold_c" id="s_bold_c" value="1"<?php echo $wcfg['s_bold_c']=='1' ? ' checked="checked"' : '';?>>
            <label for="s_bold_c">굵게</label>
        </td>
    </tr>
    
    <tr>
        <th>선색깔</th>
        <td colspan="3">
            <input type="text" name="border_color" value="<?php echo bt\varset($wcfg['border_color'])?>" class="frm_input">
        </td>
    </tr>
    <tr>
        <th>상하선</th>
        <td colspan="3">
            <label>
                <input type="checkbox" name="vertical" value="1"<?php echo bt\varset($wcfg['vertical']) == '1' ? ' checked="checked"' : '';?>>
                상하선 표시함
            </label>
        </td>
    </tr>
    <tr>
        <th>구분선</th>
        <td colspan="3">
            <label>
                <input type="checkbox" name="split" value="1"<?php echo bt\varset($wcfg['split']) == '1' ? ' checked="checked"' : '';?>>
                구분선 표시함
            </label>
        </td>
    </tr>
    <tr>
        <th>화살표</th>
        <td colspan="3">
            <label>
                <input type="checkbox" name="hide_arrow" value="1"<?php echo bt\varset($wcfg['hide_arrow']) == '1' ? ' checked="checked"' : '';?>>
                화살표 불릿기호를 제거합니다
            </label>
        </td>
    </tr>
    <tr>
        <th>HOME</th>
        <td colspan="3">
            <label>
                <input type="checkbox" name="show_home" value="1"<?php echo bt\varset($wcfg['show_home']) == '1' ? ' checked="checked"' : '';?>>
                HOME 메뉴 표시함
            </label>
        </td>
    </tr>
    </tbody>
    </table>
    <div>
        ※ 메뉴구성은 관리자페이지에서 가능합니다
    </div>