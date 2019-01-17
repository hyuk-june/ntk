<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");
?>
    <table class="table table-sm table-bordered">
    <thead>
    <tr>
        <th>기능</th>
        <th colspan="3">내용</th>
    </tr>
    <tr>
        <th>상단여백</th>
        <td colspan="3">
            <input type="text" name="margin_top" class="form-control form-control-sm form-control-inline text-right" size="5" value="<?php echo $fcfg['margin_top']?>">px
        </td>
    </tr>
    <tr>
        <th>하단여백</th>
        <td colspan="3">
            <input type="text" name="margin_bot" class="form-control form-control-sm form-control-inline text-right" size="5" value="<?php echo $fcfg['margin_bot']?>">px
        </td>
    </tr>
    <tr>
        <th>사이드위젯</th>
        <td colspan="3">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="hide_wing" id="hide_wing" value="1"<?php echo $fcfg['hide_wing']=='1' ? ' checked="checked"':'';?>>
                <label for="hide_wing" class="form-check-label">
                    좌,우의 위젯컨테이너를 숨깁니다
                </label>
            </div>
        </td>
    </tr>
    <tr>
        <th>사이드위젯높이</th>
        <td>
            <input type="text" name="wing_top" class="form-control form-control-sm form-control-inline text-right" size="5" value="<?php echo $fcfg['wing_top']?>">px
        </td>
        <th>스크롤시 높이</th>
        <td>
            <input type="text" name="wing_scroll_top" class="form-control form-control-sm form-control-inline text-right" size="5" value="<?php echo $fcfg['wing_scroll_top']?>">px
        </td>
    </tr>
    <tr>
        <th>하단배경색</th>
        <td colspan="3">
            <input type="text" class="form-control form-control-sm" name="footer_bg" id="footer_bg" value="<?php echo $fcfg['footer_bg']?>">
            <label for="footer_bg" class="form-check-label">
                하단 푸터의 배경색을 설정합니다. 예) #aaaaaa;
            </label>
        </td>
    </tr>
    <tr>
        <th>하단글자색</th>
        <td colspan="3">
            <input type="text" class="form-control form-control-sm" name="footer_color" id="footer_color" value="<?php echo $fcfg['footer_color']?>">
            <label for="footer_color" class="form-check-label">
                하단 푸터의 기본 글자색을 설정합니다. 예) #000000;
            </label>
        </td>
    </tr>
    <tr>
        <th>모바일헤더 배경식</th>
        <td colspan="3">
            <input type="text" class="form-control form-control-sm" name="mheader_bg" id="mheader_bg" value="<?php echo $fcfg['mheader_bg']?>">
            <label for="mheader_bg" class="form-check-label">
                모바일 상단 배경색을 설정합니다. 예) #aaaaaa;
            </label>
        </td>
    </tr>
    <tr>
        <th>모바일헤더 글자색</th>
        <td colspan="3">
            <input type="text" class="form-control form-control-sm" name="mheader_color" id="mheader_color" value="<?php echo $fcfg['mheader_color']?>">
            <label for="mheader_color" class="form-check-label">
                모바일 상단 글자색을 설정합니다. 예) #000000;
            </label>
        </td>
    </tr>
    </thead>
    </table>