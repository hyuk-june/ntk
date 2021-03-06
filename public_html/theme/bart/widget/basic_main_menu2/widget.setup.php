<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>


    <table>
    <tbody>
    <tr>
        <th>로고영역사용</th>
        <td colspan="3">
            <label>
                <input type="checkbox" name="use_widget" value="1"<?php echo bt\varset($wcfg['use_widget']) == '1' ? ' checked="checked"' : '';?>>
                왼쪽에 로고등의 위젯영역을 사용하시려면 체크하세요
            </label>
        </td>
    </tr>
    <tr>
        <th>메뉴높이</th>
        <td colspan="3">
            <input type="text" name="height" value="<?php echo bt\varset($wcfg['height'])?>" class="frm_input" size="8">px
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
        </td>
    </tr>
    <tr>
        <th>마우스오버</th>
        <td>
            배경색: <input type="text" name="bgcolor_o" value="<?php echo bt\varset($wcfg['bgcolor_o'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="color_o" value="<?php echo bt\varset($wcfg['color_o'])?>" class="frm_input" size="8">
        </td>
    </tr>
    <tr>
        <th>현재메뉴</th>
        <td>
            배경색: <input type="text" name="bgcolor_c" value="<?php echo bt\varset($wcfg['bgcolor_c'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="color_c" value="<?php echo bt\varset($wcfg['color_c'])?>" class="frm_input" size="8">
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
            글자색: <input type="text" name="s_color_n" value="<?php echo bt\varset($wcfg['s_color_n'])?>" class="frm_input" size="8">
        </td>
    </tr>
    <tr>
        <th>마우스오버</th>
        <td>
            배경색: <input type="text" name="s_bgcolor_o" value="<?php echo bt\varset($wcfg['s_bgcolor_o'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="s_color_o" value="<?php echo bt\varset($wcfg['s_color_o'])?>" class="frm_input" size="8">
        </td>
    </tr>
    <tr>
        <th>현재메뉴</th>
        <td>
            배경색: <input type="text" name="s_bgcolor_c" value="<?php echo bt\varset($wcfg['s_bgcolor_c'])?>" class="frm_input" size="8">
            글자색: <input type="text" name="s_color_c" value="<?php echo bt\varset($wcfg['s_color_c'])?>" class="frm_input" size="8">
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