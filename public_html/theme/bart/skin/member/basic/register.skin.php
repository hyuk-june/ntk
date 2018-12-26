<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>

<!-- 회원가입약관 동의 시작 { -->
<div class="mbskin">
    <form  name="fregister" id="fregister" action="<?php echo $register_action_url ?>" method="POST" autocomplete="off">
    <input type="hidden" name="mb_1" id="mb_type">
    <p>회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.</p>

    <section id="fregister_term">
        <h2>회원가입약관</h2>
        <textarea readonly><?php echo get_text($config['cf_stipulation']) ?></textarea>
        <fieldset class="fregister_agree">
            <label for="agree11">회원가입약관의 내용에 동의합니다.</label>
            <input type="checkbox" name="agree" value="1" id="agree11">
        </fieldset>
    </section>

    <section id="fregister_private">
        <h2>개인정보처리방침안내</h2>
        <textarea readonly><?php echo get_text($config['cf_privacy']) ?></textarea>
        <!--
        <div class="tbl_head01 tbl_wrap">
            <table>
                <caption>개인정보처리방침안내</caption>
                <thead>
                <tr>
                    <th>목적</th>
                    <th>항목</th>
                    <th>보유기간</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>이용자 식별 및 본인여부 확인</td>
                    <td>아이디, 이름, 비밀번호</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                <tr>
                    <td>고객서비스 이용에 관한 통지,<br>CS대응을 위한 이용자 식별</td>
                    <td>연락처 (이메일, 휴대전화번호)</td>
                    <td>회원 탈퇴 시까지</td>
                </tr>
                </tbody>
            </table>
        </div>
        //-->

        <fieldset class="fregister_agree">
            <label for="agree21">개인정보처리방침안내의 내용에 동의합니다.</label>
            <input type="checkbox" name="agree2" value="1" id="agree21">
        </fieldset>
    </section>

    <div class="btn_confirm text-center">
        <!--<button type="button" id="btn_comp" class="btn btn-primary">
            <span>업체회원 가입</span>
        </button>
        <button type="button" id="btn_priv" class="btn btn-success">
            <span>일반회원 가입</span>
        </button>-->
        <button type="button" id="btn_priv" class="btn btn-success">
            <span>회원가입</span>
        </button>
    </div>

    </form>

    <script>
    function fregister_submit(){
        if (!$('#agree11').is(':checked')) {
            alert("회원가입약관의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            $('#argee11').focus();
            return;
        }

        if (!$('#agree21').is(':checked')) {
            alert("개인정보처리방침안내의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
            $('#agree21').focus();
            return;
        }
        $('form[name="fregister"]').submit();
    }
    
    $('#btn_comp').click(function(){
        $('#mb_type').val('C');
        fregister_submit();
    });
    
    $('#btn_priv').click(function(){
        $('#mb_type').val('P');
        fregister_submit();
    })
    </script>
</div>
<!-- } 회원가입 약관 동의 끝 -->