<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
use kr\bartnet\board as btbo;

add_stylesheet('<link rel="stylesheet" type="text/css" href="'.$sub_urls['write'].'/write.sub.skin.css" />');
?>
    <div class="bo-basic-write">
<?php if($option){?>
        <div class="form-group row">
            <div for="wr_name" class="col-form-label col-form-label-sm col-sm-2">옵션</div>
            <div class="col-sm-10">
                <?php echo $option?>
            </div>
        </div>
<?php }?>
    
<?php if ($is_name) { ?>
        <div class="form-group row">
            <label for="wr_name" class="col-form-label col-form-label-sm col-sm-2">이름</label>
            <div class="col-sm-3">
                <input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required="required" class="form-control form-control-sm required" size="10" maxlength="20">
            </div>
        </div>
<?php } ?>

<?php if ($is_password) { ?>
        <div class="form-group row">
            <label for="wr_password" class="col-form-label col-form-label-sm col-sm-2">비밀번호</label>
            <div class="col-sm-3">
                <input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="form-control form-control-sm <?php echo $password_required ?>" maxlength="20">
            </div>
            <div class="form-text text-muted">
                글 삭제시 사용되오니 반드시 숙지해 두시기 바랍니다
            </div>
        </div>
<?php } ?>

<?php if ($is_email) { ?>
        <div class="form-group row">
            <label for="wr_email" class="col-form-label col-form-label-sm col-sm-2">이메일</label>
            <div class="col-sm-5">
                <input type="email" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="form-control form-control-sm email" size="50" maxlength="100">
            </div>
        </div>
<?php } ?>

<?php if ($is_homepage) { ?>
        <div class="form-group row">
            <label for="wr_homepage" class="col-form-label col-form-label-sm col-sm-2">홈페이지</label>
            <div class="col-sm-10">
                <input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="form-control" size="50">
            </div>
        </div>
<?php } ?>


<?php if ($is_category) { ?>
        <div class="form-group row">
            <label for="ca_name" class="col-form-label col-form-label-sm col-sm-2">카테고리</label>
            <div class="col-sm-3">
                <select name="ca_name" id="ca_name" required="required" class="form-control form-control-sm required" >
                    <option value="">선택하세요</option>
                    <?php echo $category_option ?>
                </select>
            </div>
        </div>
<?php } ?>
        
    
        <div class="form-group row">
            <label for="wr_subject" class="col-form-label col-form-label-sm col-sm-2">제목</label>
            <div class="col-sm-10">
                <div id="autosave_wrapper">
                    <div class="input-group">
                        <input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required="required" class="form-control form-control-sm required" size="50" maxlength="255">
                        <span class="input-group-btn">
                            <button type="button" id="btn_autosave" class="btn">임시 저장된 글 (<span id="autosave_count"><?php echo $autosave_count; ?></span>)</button>
                        </span>
                    </div>
                <?php if ($is_member) { // 임시 저장된 글 기능 ?>
                        <script src="<?php echo G5_JS_URL; ?>/autosave.js"></script>
                        <?php if($editor_content_js) echo $editor_content_js; ?>
                    <div id="autosave_pop">
                        <strong>임시 저장된 글 목록</strong>
                        <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
                        <ul></ul>
                        <div><button type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></button></div>
                    </div>
                <?php } ?>
                    
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="wr_content">
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <p id="char_count_desc">이 게시판은 최소 <strong><?php echo $write_min; ?></strong>글자 이상, 최대 <strong><?php echo $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
                <?php } ?>
                <?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
                <?php if($write_min || $write_max) { ?>
                <!-- 최소/최대 글자 수 사용 시 -->
                <div id="char_count_wrap"><span id="char_count"></span>글자</div>
                <?php } ?>
            </div>
        </div>

        <?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
        <div class="form-group row">
            <label for="wr_link<?php echo $i ?>" class="col-sm-2 control-label">링크 #<?php echo $i ?></label>
            <div class="col-sm-10">
                <input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="form-control form-control-sm " size="50">
            </div>
        </div>
        <?php } ?>

        <?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">파일 #<?php echo $i+1 ?></label>
            <div class="col-sm-10">
                <input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="form-control form-control-sm">
                <?php if ($is_file_content) { ?>
                <input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="form-control form-control-sm">
                <?php } ?>
                <?php if($w == 'u' && $file[$i]['file']) { ?>
                <input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
                <?php } ?>
            </div>
        </div>
        
            <?php if($bcfg['use_point_down']){?>
        <div class="form-group row">
            <label for="opts_point_down_<?php echo $i?>" class="col-sm-2">다운로드포인트</label>
            <div class="col-sm-2">
                <input type="text" name="opts[point_down][]" id="opts_point_down_<?php echo $i?>" class="form-control form-control-sm text-right" placeholder="point" value="<?php echo $opts['point_down'][$i]?>">
            </div>
        </div>
            <?php }?>
        <?php } ?>
        
        <?php if($bcfg['use_point_view']){?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">내용보기포인트</label>
            <div class="col-sm-2">
                <input type="text" name="opts[point_view]" class="form-control form-control-sm text-right" placeholder="point" value="<?php echo $opts['point_view']?>">
            </div>
        </div>
        <?php }?>
        
        <?php if ($is_guest) { //자동등록방지  ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">자동등록방지</label>
            <div class="col-sm-10">
                <?php echo $captcha_html ?>
            </div>
        </div>
        <?php } ?>
        
    </div>
    
    
    <div class="text-center">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn btn-danger">
        <a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn btn-outline-dark">취소</a>
    </div>
    
    <script type="text/javascript">
    <!--
    function getSrtUrl(){
        
        if(performance === undefined) return;
        //performance.getEntriesByType("resource")
        
        var capture_resource = performance.getEntriesByType("resource");
        console.log(capture_resource);
        for (var i = 0; i < capture_resource.length; i++) {
            if (capture_resource[i].initiatorType == "xmlhttprequest") {
                console.log(capture_resource[i].name);
                if (capture_resource[i].name.indexOf('timedtext') > -1) {
                    //capture_newtwork_request.push(capture_resource[i].name)
                    alert(capture_resource[i].name);
                }
            }
        }
    }
    //-->
    </script>