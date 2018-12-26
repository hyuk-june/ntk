<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가  

use kr\bartnet as bt;

//include_once(BT_LIB_PATH."/file/file_uploader.php");

$memtype = get_session("ss_memtype");
if(!bt\isval($memtype)){
	alert("잘못된 접근입니다");
}
${MB_TYPE} = $memtype;


//업로드 디렉토리
if($is_member){
    $updir_path = G5_DATA_PATH."/bart/member/".substr($member['mb_id'], 0, 2);
}else{
    $updir_path = G5_DATA_PATH."/bart/member/".substr($_POST['mb_id'], 0, 2);
}


//===========================================================================
// 업체회원
//===========================================================================
if($memtype=="C"){

    //기존파일이름들
    $mb_pic = bt\binstr($member[MB_PIC], ''); //본인사진
    $mb_logo = bt\binstr($member[MB_LOGO], ''); //업체로고
    $mb_spic = bt\binstr($member[MB_SPIC], ''); //매장사진
    
    //본인사진 삭제 체크했으면
    if(bt\isval($_POST["del_mb_pic"])){
    	@unlink($updir_path.'/'.$member[MB_PIC]);
    	$mb_pic = "";
	}
    
    //로고 삭제 체크했으면
    if(bt\isval($_POST["del_mb_logo"])){
        @unlink($updir_path.'/'.$member[MB_LOGO]);
        $mb_logo = "";
    }
    
    //매장사진 삭제 체크했으면
    if(bt\isval($_POST["del_mb_spic"])){
        @unlink($updir_path.'/'.$member[MB_SPIC]);
        $mb_spic = "";
    }

    
    /*---------------------------
     업로드
    -----------------------------*/
    $fu = new bt\file\BFileUpload();
    //공통파리미터
    $param = array(
        "mkdir" => true,
        "updir" => $updir_path,
        "allow_ext" => "jpg|jpeg|png|gif"
    );
    
    $info = array();
    
    //필드 추가
    if(isset($_FILES["mb_pic"]) && is_uploaded_file($_FILES["mb_pic"]["tmp_name"])){
        $param["field"] = "mb_pic";
        $info['mb_pic'] = $fu->add($param);
    }
    
    if(isset($_FILES["mb_logo"]) && is_uploaded_file($_FILES["mb_logo"]["tmp_name"])){
        $param["field"] = "mb_logo";
        $info['mb_logo'] = $fu->add($param);
    }
    
    if(isset($_FILES["mb_spic"]) && is_uploaded_file($_FILES["mb_spic"]["tmp_name"])){
        $param["field"] = "mb_spic";
        $info['mb_spic'] = $fu->add($param);
    }
    
    
    if(isset($info['mb_pic']) || isset($info['mb_logo']) || isset($info['mb_spic'])){
        
        try{
            
            /*---------------------------
             실제 업로드
            -----------------------------*/
            $fu->upload();
            
            
            /*---------------------------
             썸네일 작업
            -----------------------------*/
            foreach($info as $key => $item){
                
                if(!isset($info[$key])) continue;
                
                $file_name = $info[$key]["rname"];
                
                $data = null;
                
                if($key=='mb_pic'){
                    $data = bt\image\BThumbnail::makeThumb(
                        $updir_path."/".$file_name,
                        $updir_path,
                        300,
                        400,
                        array(
                            'transparent' => true,
                            'sizefix' => true,
                            'crop_posx' => bt\image\BThumbnail::CROP_POSX_CENTER,
                            'crop_posy' => bt\image\BThumbnail::CROP_POSY_MIDDLE
                        )
                    );
                }else if($key=='mb_logo'){
                    $data = bt\image\BThumbnail::makeThumb(
                        $updir_path."/".$file_name,
                        $updir_path,
                        300,
                        300,
                        array(
                            'transparent' => true,
                            'sizefix' => true,
                            'crop_posx' => bt\image\BThumbnail::CROP_POSX_CENTER,
                            'crop_posy' => bt\image\BThumbnail::CROP_POSY_MIDDLE
                        )
                    );
                    
                }else if($key=='mb_spic'){
                    $data = bt\image\BThumbnail::makeThumb(
                        $updir_path."/".$file_name,
                        $updir_path,
                        800,
                        800
                    );
                }else{
                    continue;
                }
                
                //썸네일로 저장
                if($data == null) throw new \Exception('썸네일 생성 실패');
                    
                //원본삭제
                @unlink($updir_path."/".$file_name);
                    
                //썸네일을 원본이름으로 변경
                @rename($updir_path."/".$data['filename'], $updir_path."/".$file_name);
                
                //필드이름
                ${$key} = $file_name;
                
                //수정일때
                if($w=="u"){
                    if($key=='mb_pic'){
                        @unlink($updir_path."/".$member[MB_PIC]);
                    }else if($key=='mb_logo'){
                        @unlink($updir_path."/".$member[MB_LOGO]);
                    }else if($key=='mb_spic'){
                        @unlink($updir_path."/".$member[MB_SPIC]);
                    }
                }
            }
            
        }catch(Exception $e){
            alert($e->getMessage());
        }
    }
    
    ${MB_PIC} = $mb_pic;
    ${MB_LOGO} = $mb_logo;
    ${MB_SPIC} = $mb_spic;
    
    
}else if($memtype=="P"){
	
	$mb_pic = bt\binstr($member[MB_PIC], "");
	
	if(bt\isval($_POST["del_mb_pic"])){
    	@unlink($updir_path."/".$member[MB_PIC]);
    	$mb_pic = "";
	}

    $fu = new bt\file\BFileUpload();
    $param = array(
        "mkdir" => true,
        "updir" => $updir_path,
        "thumb_width" => 300,
        "thumb_height" => 300,
        //"limit_size" => 1024*1024*1,
        "allow_ext" => "jpg|jpeg|png|gif"
    );
    
    $info = array();
    if(isset($_FILES["mb_pic"]) && is_uploaded_file($_FILES["mb_pic"]["tmp_name"])){
        $param["field"] = "mb_pic";
        $info['mb_pic'] = $fu->add($param);
    }
    
    if(isset($info['mb_pic'])){
        
        try{
            $fu->upload();
            
            if(isset($info['mb_pic'])){
                ${MB_PIC} = $info['mb_pic']["rname"];
                if($w=="u"){
                    @unlink($updir_path."/".$member[MB_PIC]);
                }
            }
            
        }catch(Exception $e){
            alert($e->getMessage());
        }
    }
}

set_session("ss_memtype", "");