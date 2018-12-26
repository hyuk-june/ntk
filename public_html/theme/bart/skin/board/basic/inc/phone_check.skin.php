<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

include_once($board_skin_path.'/lib/reqloan.lib.php');

$refresh_check = bt\varset($_GET["refresh_check"]); //재인증 요구
$pnum = $_POST["pnum"]; //입력한 폰번호

$self_url = G5_URL.$_SERVER["DOCUMENT_URI"].'?'.bt\pop_qstr($_SERVER["QUERY_STRING"], 'refresh_check');

if(bt\isval($refresh_check)){
    $_SESSION['bt_pnum'] = '';
    unset($_SESSION['bt_pnum']);
    
    ob_clean(); //기존 html이 출력되지 않게 한다
    header('Location: '.$self_url);
    exit;
}

if(bt\isval($pnum)){
    
    $_SESSION['bt_pnum'] = $pnum;
    
    ob_clean(); //기존 html이 출력되지 않게 한다
    header("Location: ".$self_url);
    exit;
}

if(!$is_member && !bt\isval($_SESSION['bt_pnum'])){
    
    //ob_clean(); //기존 html이 출력되지 않게 한다
    
    $path = dirname(__FILE__);

    add_javascript('<script type="text/javascript" src="'.BT_JS_URL.'/jquery.phoneInput.js"></script>');
    
    //include(G5_THEME_PATH.'/head.sub.php');
    //include(G5_THEME_PATH.'/head.php');
    
    //include_once(G5_BBS_PATH.'/board_head.php');
    ?>
    
    
    <div class="row">
        <div class="col-sm-6">
            <div class="card" style="max-width: 500px;">
                <div class="card-header">
                    <h1 class="card-title font-size-3">글작성하기</h1>
                    <p>
                        <span class="text-primary font-weight-bold">회원가입 No!</span> <span class="text-success font-weight-bold">개인정보 No!</span><br>
                        <span class="text-info font-weight-bold"><?php echo $config['cf_title']?></span>의 편리한 대출시스템을 경험해 보세요<br>
                    </p>
                </div>
                <div class="card-body text-center" style="height:70px;">
                    <a href="<?php echo G5_BBS_URL.'/write.php?bo_table='.$bo_table?>" class="btn btn-sm btn-primary">글작성하기</a>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6">
    
                <!--<div id="phone_form" class="d-flex justify-content-center mt-5 p-3">-->
                    
                    <div class="card" style="max-width: 500px;">
                        <div class="card-header">
                            <h1 class="card-title font-size-3">내글찾기</h1>
                            <p>
                                정보보호를 위해 본인의 글만 확인할 수 있습니다<br>
                                글작성시 등록한 휴대폰번호를 입력해 주세요
                            </p>
                        </div>
                        
                        <div class="card-body" style="height:70px;">
                            <form action="<?php echo $self_url?>" method="post">
                                <input type="hidden" name="bo_table" value="<?php echo $bo_table?>">
                                <div class="form-group row mb-0">
                                    <label for="pnum" class="col-sm-3 col-form-label">휴대폰번호</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="pnum" id="pnum" class="pnum required form-control form-control-sm">
                                    </div>
                                    <div class="col-sm-4">
                                        <button type="submit" class="btn btn-sm btn-primary">확인</button>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        
                    </div>
                <!--</div>-->

                <script type="text/javascript">
                <!--
                $('.pnum').phoneInput();
                //-->
                </script>
            </div>
        </div>
        
    </div>
    
<?php
    include_once(G5_BBS_PATH.'/board_tail.php');
    include(G5_THEME_PATH.'/tail.sub.php');
    
    exit();
    
}else if(!$is_member){
    
    $self_url = G5_URL.$_SERVER["REQUEST_URI"];
?>
    <div class="text-right my-2">
        <a href="<?php echo $self_url?>&refresh_check=true" class="btn btn-sm btn-dark">휴대폰번호로 검색</a>
    </div>
    
<?php
}
?>


