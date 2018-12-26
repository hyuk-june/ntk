<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가  

use kr\bartnet as bt;

add_javascript(G5_POSTCODE_JS, 0);

include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

set_session("ss_memtype", "C");

if($is_member){
    $updir_path = G5_DATA_PATH."/bart/member/".substr($member['mb_id'], 0, 2);
    $updir_url = G5_DATA_URL."/bart/member/".substr($member['mb_id'], 0, 2);
}
?>

<style type="text/css">
#fregisterform {width:100%;}
</style>

<!-- 회원정보 입력/수정 시작 { -->
<div>
	
    <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
    <?php if($config['cf_cert_use'] && ($config['cf_cert_ipin'] || $config['cf_cert_hp'])) { ?>
    <script src="<?php echo G5_JS_URL ?>/certify.js"></script>
    <?php } ?>
    
    <h2>업체회원 <?php echo $w=="u" ? "정보수정" : "가입";?></h2>

    <form id="fregisterform" class="mx-auto" name="fregisterform" action="<?php echo $register_action_url ?>" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
    
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="url" value="<?php echo $urlencode ?>">
    <input type="hidden" name="agree" value="<?php echo $agree ?>">
    <input type="hidden" name="agree2" value="<?php echo $agree2 ?>">
    <input type="hidden" name="cert_type" value="<?php echo $member['mb_certify']; ?>">
    <input type="hidden" name="cert_no" value="">
    
    <?php if (isset($member['mb_sex'])) {  ?><input type="hidden" name="mb_sex" value="<?php echo $member['mb_sex'] ?>"><?php }  ?>
    <?php if (isset($member['mb_nick_date']) && $member['mb_nick_date'] > date("Y-m-d", G5_SERVER_TIME - ($config['cf_nick_modify'] * 86400))) { // 닉네임수정일이 지나지 않았다면  ?>
    <input type="hidden" name="mb_nick_default" value="<?php echo get_text($member['mb_nick']) ?>">
    <input type="hidden" name="mb_nick" value="<?php echo get_text($member['mb_nick']) ?>">
    <?php }  ?>

    

    
    <div class="card mb-3">
        <div class="card-header">
            <strong>기본정보 입력</strong>
        </div>
    
        <div class="card-body">
        
            <div class="form-group row">
                <label for="reg_mb_id" class="col-sm-2 col-form-label">아이디</label>
                <div class="col-sm-4">
                    <input type="text" id="reg_mb_id" name="mb_id" value="<?php echo $member['mb_id'] ?>" <?php echo $required ?> <?php echo $readonly ?> class="form-control form-control-sm <?php echo $required ?> <?php echo $readonly ?>" minlength="3" maxlength="20" placeholder="아이디">
                    <div id="msg_mb_id"></div>
                    <div class="form-text text-muted">영문자, 숫자, _ 만 입력 가능. 최소 3자이상</div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="reg_mb_password" class="col-sm-2 col-form-label">비밀번호</label>
                <div class="col-sm-4">
                    <input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="form-control form-control-sm <?php echo $required ?>" minlength="3" maxlength="20">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="reg_mb_password_re" class="col-sm-2 col-form-label">비밀번호 확인</label>
                <div class="col-sm-4">
                    <input type="password" name="mb_password_re" id="reg_mb_password_re" <?php echo $required ?> class="form-control form-control-sm <?php echo $required ?>" minlength="3" maxlength="20">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="reg_mb_name" class="col-sm-2 col-form-label">이름</label>
                <div class="col-sm-4">
                    <input type="text" id="reg_mb_name" name="mb_name" value="<?php echo get_text($member['mb_name']) ?>" <?php echo $required ?> <?php echo $readonly; ?> class="form-control form-control-sm <?php echo $required ?> <?php echo $readonly ?>">
                </div>
            </div>
            
        <?php if($config['cf_cert_use']) {?>
        	<div class="form-group row">
        		<label class="col-sm-2 col-form-label">본인확인</label>
        		<div class="col-sm-10">
                    
           	<?php if($config['cf_cert_ipin']){?>
                    <button type="button" id="win_ipin_cert" class="btn btn-info btn-sm mr-2">아이핀 본인확인</button>
            <?php }?>
            
            <?php if($config['cf_cert_hp']){?>
       		        <button type="button" id="win_hp_cert" class="btn btn-info btn-sm">휴대폰 본인확인</button>
            <?php }?>
            	</div>
                <noscript>본인확인을 위해서는 자바스크립트 사용이 가능해야합니다.</noscript>
            </div>
            
            <?php
            if ($config['cf_cert_use'] && $member['mb_certify']) {
                if($member['mb_certify'] == 'ipin')
                    $mb_cert = '아이핀';
                else
                    $mb_cert = '휴대폰';
            ?>
            <div class="form-group row">
				<!--<div id="msg_certify" class="col-sm-6">-->
				<div class="offset-sm-2 col-sm-4">
				    <span class="form-text text-muted"><strong><?php echo $mb_cert; ?> 본인확인</strong><?php if ($member['mb_adult']) { ?> 및 <strong>성인인증</strong><?php } ?> 완료</span>
				</div>
            </div>
			<?php }?>
        <?php } ?>
        
        
        <?php if ($config['cf_cert_use']) { ?>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-4">
                    <div class="form-text text-muted">아이핀 본인확인 후에는 이름이 자동 입력되고 휴대폰 본인확인 후에는 이름과 휴대폰번호가 자동 입력되어 수동으로 입력할수 없게 됩니다.</div>
                </div>
            </div>
        <?php } ?>
                        
        <?php if(!$config['cf_cert_use']){?>
            <div class="form-group row">
                <label for="reg_mb_email" class="col-sm-2 col-form-label">생년</label>
                <div class="col-sm-4">
                    <input type="text" name="mb_birth" id="mb_birth" class="form-control form-control-sm" readonly="readonly" value="<?php echo $member["mb_birth"]?>">
                </div>
            </div>
        <?php }?>
        
            <div class="form-group row">
                <label for="reg_mb_tel" class="col-sm-2 col-form-label">대표전화번호</label>
                <div class="col-sm-4">
                    <input type="text" name="mb_tel" value="<?php echo get_text($member['mb_tel']) ?>" id="reg_mb_tel" class="form-control form-control-sm required" maxlength="20">
                    <input type="hidden" name="old_mb_tel" value="<?php echo get_text($member['mb_tel']) ?>">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="reg_mb_hp" class="col-sm-2 col-form-label">휴대폰번호</label>
                <div class="col-sm-4">
                    <input type="text" name="mb_hp" value="<?php echo get_text($member['mb_hp']) ?>" id="reg_mb_hp" class="form-control form-control-sm required" maxlength="20">
                    <?php if ($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
                    <input type="hidden" name="old_mb_hp" value="<?php echo get_text($member['mb_hp']) ?>">
                    <?php } ?>
                </div>
            </div>
            
            <!--<div class="form-group form-group-sm">
                <label for="" class="col-sm-2 control-label">주소</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-2">
                            <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="form-control <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder="우편번호">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn_frmline" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
                        </div>
                    </div>
                    <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="form-control frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="기본주소">
                    <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="form-control frm_address" size="50" placeholder="상세주소">
                    <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="form-control frm_address" size="50" readonly="readonly" placeholder="참고항목">
                    <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                </div>
            </div>-->
        </div>
    </div>
    
    
    
    <div class="card mb-3">
        <div class="card-header">
            <strong>부가정보</strong>
        </div>
    
        <div class="card-body">
        
            <div class="form-group row">
                <label for="reg_mb_nick" class="col-sm-2 col-form-label">업소/점포명</label>
                <div class="col-sm-4">
                    <input type="hidden" name="mb_nick_default" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>">
                    <input type="text" name="mb_nick" value="<?php echo isset($member['mb_nick'])?get_text($member['mb_nick']):''; ?>" id="reg_mb_nick" required class="form-control form-control-sm required nospace" maxlength="20">
                    <div class="form-text text-muted">공백없이 한글,영문,숫자만 입력 가능 (한글2자, 영문4자 이상)</div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">사업장 소재지</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <input type="text" name="mb_zip" value="<?php echo $member['mb_zip1'].$member['mb_zip2']; ?>" id="reg_mb_zip" <?php echo $config['cf_req_addr']?"required":""; ?> class="form-control form-control-sm <?php echo $config['cf_req_addr']?"required":""; ?>" size="5" maxlength="6" placeholder="우편번호">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-info" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
                        </div>
                    </div>
                    <input type="text" name="mb_addr1" value="<?php echo get_text($member['mb_addr1']) ?>" id="reg_mb_addr1" <?php echo $config['cf_req_addr']?"required":""; ?> class="form-control form-control-sm frm_address <?php echo $config['cf_req_addr']?"required":""; ?>" size="50" placeholder="기본주소">
                    <input type="text" name="mb_addr2" value="<?php echo get_text($member['mb_addr2']) ?>" id="reg_mb_addr2" class="form-control form-control-sm frm_address" size="50" placeholder="상세주소">
                    <input type="text" name="mb_addr3" value="<?php echo get_text($member['mb_addr3']) ?>" id="reg_mb_addr3" class="form-control form-control-sm frm_address" size="50" readonly="readonly" placeholder="참고항목">
                    <input type="hidden" name="mb_addr_jibeon" value="<?php echo get_text($member['mb_addr_jibeon']); ?>">
                </div>
            </div>
        
            <div class="form-group row">
                <label for="mb_pic" class="col-sm-2 col-form-label">본인사진</label>
                <div class="col-sm-4">
                    <input type="file" name="mb_pic" id="mb_pic" class="form-control-file">
                    <div class="form-text text-muted">gif,jpg,jpeg,png만 가능합니다.</div>
                </div>
            </div>
            <?php if ($w == 'u' && bt\isval($member[MB_PIC]) && file_exists($updir_path.'/'.$member[MB_PIC])) {  ?>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-4">
                    <img src="<?php echo $updir_url.'/'.$member[MB_PIC] ?>" alt="본인사진" class="img-thumbnail">
                    <div class="caption checkbox">
                        <label>
                            <input type="checkbox" name="del_mb_pic" value="1" id="del_mb_pic">
                            삭제
                        </label>
                    </div>
                </div>
            </div>
            <?php }  ?>
        
            <div class="form-group row">
                <label for="mb_logo" class="col-sm-2 col-form-label">업체로고</label>
                <div class="col-sm-4">
                    <input type="file" name="mb_logo" id="mb_logo" class="form-control-file">
                    <div class="form-text text-muted">gif,jpg,jpeg,png만 가능합니다.</div>
                </div>
            </div>
            <?php if ($w == 'u' && bt\isval($member[MB_LOGO]) && file_exists($updir_path.'/'.$member[MB_LOGO])) {  ?>
            <div class="form-group row">
            	<div class="offset-sm-2 col-sm-4">
                    <img src="<?php echo $updir_url.'/'.$member[MB_LOGO] ?>" alt="로고이미지" class="img-thumbnail">
                    <div class="caption checkbox">
                    	<label>
                    		<input type="checkbox" name="del_mb_logo" value="1" id="del_mb_logo">
                    		삭제
                    	</label>
                    </div>
                    
                </div>
            </div>
            <?php }  ?>
            
            <div class="form-group row">
                <label for="mb_spic" class="col-sm-2 col-form-label">매장사진</label>
                <div class="col-sm-4">
                    <input type="file" name="mb_spic" id="mb_spic" class="form-control-file">
                    <div class="form-text text-muted">gif,jpg,jpeg,png만 가능합니다.</div>
                </div>
            </div>
            <?php if ($w == 'u' && bt\isval($member[MB_SPIC]) && file_exists($updir_path.'/'.$member[MB_SPIC])) {  ?>
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-4">
                    <img src="<?php echo $updir_url.'/'.$member[MB_SPIC] ?>" alt="매장사진" class="img-thumbnail">
                    <div class="caption checkbox">
                        <label>
                            <input type="checkbox" name="del_mb_spic" value="1" id="del_mb_spic">
                            삭제
                        </label>
                    </div>
                </div>
            </div>
            <?php }  ?>
            
                        
            <div class="form-group row">
                <label for="reg_mb_email" class="col-sm-2 col-form-label">E-mail</label>
                <div class="col-sm-4">
                    <?php if ($config['cf_use_email_certify']) {  ?>
                    <span class="frm_info">
                        <?php if ($w=='') { echo "E-mail 로 발송된 내용을 확인한 후 인증하셔야 회원가입이 완료됩니다."; }  ?>
                        <?php if ($w=='u') { echo "E-mail 주소를 변경하시면 다시 인증하셔야 합니다."; }  ?>
                    </span>
                    <?php }  ?>
                    <input type="hidden" name="old_email" value="<?php echo $member['mb_email'] ?>">
                    <input type="text" name="mb_email" value="<?php echo isset($member['mb_email'])?$member['mb_email']:''; ?>" id="reg_mb_email" required class="form-control form-control-sm email required" size="70" maxlength="100">
                </div>
            </div>
            
            <div class="form-group row">
                <label for="" class="col-sm-2 col-form-label">자동등록방지</label>
                <div class="col-sm-10">
                    <?php echo captcha_html(); ?>
                </div>
            </div>
        
        </div>
        
    </div>
    
    <div class="btn_confirm text-center">
        <input type="submit" value="<?php echo $w==''?'회원가입':'정보수정'; ?>" id="btn_submit" class="btn btn-primary" accesskey="s">
        <a href="<?php echo G5_URL ?>" class="btn btn-success">취소</a>
    </div>
    
    </form>
    

</div>
<!-- } 회원정보 입력/수정 끝 -->



    <script>
    $(function() {
        $("#reg_zip_find").css("display", "inline-block");

        <?php if($config['cf_cert_use'] && $config['cf_cert_ipin']) { ?>
        // 아이핀인증
        $("#win_ipin_cert").click(function() {
            if(!cert_confirm())
                return false;

            var url = "<?php echo G5_OKNAME_URL; ?>/ipin1.php";
            certify_win_open('kcb-ipin', url);
            return;
        });

        <?php } ?>
        <?php if($config['cf_cert_use'] && $config['cf_cert_hp']) { ?>
        // 휴대폰인증
        $("#win_hp_cert").click(function() {
            if(!cert_confirm())
                return false;

            <?php
            switch($config['cf_cert_hp']) {
                case 'kcb':
                    $cert_url = G5_OKNAME_URL.'/hpcert1.php';
                    $cert_type = 'kcb-hp';
                    break;
                case 'kcp':
                    $cert_url = G5_KCPCERT_URL.'/kcpcert_form.php';
                    $cert_type = 'kcp-hp';
                    break;
                case 'lg':
                    $cert_url = G5_LGXPAY_URL.'/AuthOnlyReq.php';
                    $cert_type = 'lg-hp';
                    break;
                default:
                    echo 'alert("기본환경설정에서 휴대폰 본인확인 설정을 해주십시오");';
                    echo 'return false;';
                    break;
            }
            ?>

            certify_win_open("<?php echo $cert_type; ?>", "<?php echo $cert_url; ?>");
            return;
        });
        <?php } ?>
    });

    // submit 최종 폼체크
    function fregisterform_submit(f)
    {
        // 회원아이디 검사
        if (f.w.value == "") {
            var msg = reg_mb_id_check();
            if (msg) {
                alert(msg);
                f.mb_id.select();
                return false;
            }
        }

        if (f.w.value == "") {
            if (f.mb_password.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }

        if (f.mb_password.value != f.mb_password_re.value) {
            alert("비밀번호가 같지 않습니다.");
            f.mb_password_re.focus();
            return false;
        }

        if (f.mb_password.value.length > 0) {
            if (f.mb_password_re.value.length < 3) {
                alert("비밀번호를 3글자 이상 입력하십시오.");
                f.mb_password_re.focus();
                return false;
            }
        }

        // 이름 검사
        if (f.w.value=="") {
            if (f.mb_name.value.length < 1) {
                alert("이름을 입력하십시오.");
                f.mb_name.focus();
                return false;
            }

            /*
            var pattern = /([^가-힣\x20])/i;
            if (pattern.test(f.mb_name.value)) {
                alert("이름은 한글로 입력하십시오.");
                f.mb_name.select();
                return false;
            }
            */
        }

        <?php if($w == '' && $config['cf_cert_use'] && $config['cf_cert_req']) { ?>
        // 본인확인 체크
        if(f.cert_no.value=="") {
            alert("회원가입을 위해서는 본인확인을 해주셔야 합니다.");
            return false;
        }
        <?php } ?>

        // 닉네임 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_nick.defaultValue != f.mb_nick.value)) {
            var msg = reg_mb_nick_check();
            if (msg) {
                alert(msg);
                f.reg_mb_nick.select();
                return false;
            }
        }

        // E-mail 검사
        if ((f.w.value == "") || (f.w.value == "u" && f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }

        <?php if (($config['cf_use_hp'] || $config['cf_cert_hp']) && $config['cf_req_hp']) {  ?>
        // 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
        <?php } ?>

        if (typeof f.mb_icon != "undefined") {
            if (f.mb_icon.value) {
                if (!f.mb_icon.value.toLowerCase().match(/.(gif)$/i)) {
                    alert("회원아이콘이 gif 파일이 아닙니다.");
                    f.mb_icon.focus();
                    return false;
                }
            }
        }

        if (typeof(f.mb_recommend) != "undefined" && f.mb_recommend.value) {
            if (f.mb_id.value == f.mb_recommend.value) {
                alert("본인을 추천할 수 없습니다.");
                f.mb_recommend.focus();
                return false;
            }

            var msg = reg_mb_recommend_check();
            if (msg) {
                alert(msg);
                f.mb_recommend.select();
                return false;
            }
        }

        <?php echo chk_captcha_js();  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }
    
    $("#mb_birth").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yymmdd", showButtonPanel: true, yearRange: "c-99:c+99" });
    </script>