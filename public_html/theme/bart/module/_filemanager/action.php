<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

$act = $_REQUEST["act"];


switch($act){
    case 'upload':
    
        $jres = new bt\util\BJsonResult();
    
        $fu = new bt\file\BFileUpload();
        
        $ymd = date('Ymd');
        $updir = G5_DATA_PATH."/bart/file/".$ymd;
        
        $info = array();
        for($i=0;$i<count($_FILES["attach"]["name"]);$i++){
            $param = array(
                "mkdir" => true,                            //디렉토리가 없으면 만들것인가
                "updir" => $updir,       //업로드 디렉토리
                "field" => "attach",                         //폼 필드 이름
                "naming" => bt\file\BFileUpload::NAME_AUTO,  //실제파일명변경 규칙[NAME_ORGINAL_NUMERIC | NAME_ORIGINAL_OVERLAP | NAME_FORCE]
                "limit_size" => 1024*1024*5,                //제한 용량
                "limit_width" => 2000,
                "limit_height" => 2000,
                "allow_ext" => "jpg|jpeg|png|gif",           //허용하는 확장자
                "index" => $i
            );

            $info[] = $fu->add($param);                       //세팅된 파일 정보들 배열로 리턴(DB에 입력하는 등의 용도)
        }

        try{
            $fu->upload();                              //실제 업로드
            
            
            $list = array();
            for($i=0; $i<count($info); $i++){
                $arr = array();
                $arr['fm_name'] = $info[$i]['name'];
                $arr['fm_rname'] = $info[$i]['rname'];
                $arr['fm_type'] = $info[$i]['type'];
                $arr['fm_ext'] = $info[$i]['extension'];
                $arr['fm_size'] = $info[$i]['size'];
                $arr['fm_width'] = $info[$i]['width'];
                $arr['fm_height'] = $info[$i]['height'];
                $arr['fm_dir'] = $ymd;
                $arr['fm_regdate'] = G5_TIME_YMDHIS;
                
                $bdb->insert($bt['fmgr_table'], $arr);
                
                //썸네일 만들기
                if(@is_array(getimagesize($updir.'/'.$info[$i]['rname']))){
                    //echo $updir.'/'.$info[$i]['rname'].PHP_EOL;
                    $thumb = bt\image\BThumbnail::makeThumb($updir.'/'.$info[$i]['rname'], $updir, 200, 200,
                        array(
                            'sizefix' => true,
                            'append_size' => false,
                            'crop_posx' => bt\image\BThumbnail::CROP_POSX_CENTER,
                            'crop_posy' => bt\image\BThumbnail::CROP_POSY_MIDDLE
                        )
                    );
                }
                
                $list[] = $arr;
            }
            
            echo $jres->success($list);
            exit;
            
        }catch(Exception $e){
            echo $jres->error("파일업로드 에러 - ".$e->getMessage());
            exit;
        }
    
        break;
        
        
    case 'list':
    
        $jres = new bt\util\BJsonResult();
        
        $Q = "SELECT * FROM ".$bt['fmgr_table']." WHERE fm_dir='".trim($_GET['dir'])."'";
        $result = sql_query($Q);
        
        $list = array();
        while($rs = sql_fetch_array($result)){
            
            $updir = G5_DATA_PATH.'/bart/file/'.$rs['fm_dir'];
        
            $r = getimagesize($updir.'/'.$rs['fm_rname']);
            
            //썸네일 만들기
            if(@is_array(getimagesize($updir.'/'.$rs['fm_rname'])) &&
                file_exists($updir.'/'.$rs['fm_rname'])){
                    
                $thumb = bt\image\BThumbnail::makeThumb($updir.'/'.$rs['fm_rname'], $updir, 200, 200,
                    array(
                        'sizefix' => true,
                        'append_size' => false,
                        'crop_posx' => bt\image\BThumbnail::CROP_POSX_CENTER,
                        'crop_posy' => bt\image\BThumbnail::CROP_POSY_MIDDLE
                    )
                );
                
                $rs['thumb'] = $thumb['filename'];
            }
            
            $list[] = $rs;
        }
        
        
        echo $jres->success($list);
        exit;
        
        
    case 'del':
    
        
    
        $jres = new bt\util\BJsonResult();
        
        $fm_idx = bt\varset($_GET["fm_idx"]);
        if(!bt\isval($fm_idx)){
            echo $jres->error('잘못된 접근입니다');
            exit;
        }
        
        $Q = "SELECT * FROM ".$bt['fmgr_table']." WHERE fm_idx=".$fm_idx;
        $rs = sql_fetch($Q);
        
        $updir = G5_DATA_PATH.'/bart/file/'.$rs['fm_dir'];
        
        $Q = "DELETE FROM ".$bt['fmgr_table']." WHERE fm_idx=".$fm_idx;
        sql_query($Q);
        
        @unlink($updir.'/'.$rs['fm_rname']);
        @unlink($updir.'/thumb-'.$rs['fm_rname']);
        
        echo $jres->success();
}