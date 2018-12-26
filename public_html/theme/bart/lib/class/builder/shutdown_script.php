<?php
namespace kr\bartnet\builder;

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

class BShutdownScript{
    
    
    public static function execute(){
        $search = G5_PATH;
        $fpath = trim(str_replace($search, "", $_SERVER["SCRIPT_FILENAME"]), "/");
        
        static $inst = null;
        
        if($inst==null) $inst = new BShutdownScript();
        
        switch ($fpath) {
        
        //글쓰기 일때
        case "bbs/write_update.php":
        
            global $w, $wr_id, $write, $bo_table, $write_table;
        
            //답변글 쓰기이고 $wr_id 가 세팅되어 있으면 성공으로 판단한다
            if($w=='r' && $wr_id){
                if(bt\isval($write['mb_id'])){
                    $row = get_write($write_table, $wr_id);
                    
                    btb\send_alim(
                        $write['mb_id'],
                        G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id,
                        '[답변글등록] '.$row['wr_subject']
                    );
                }
            }
            
            break;
        
        //댓글일때
        case "bbs/write_comment_update.php":
            
            //write_comment_update.sns.php 를 include 했으면 성공으로 판단한다
            $files = get_included_files();
            $files = array_map('basename', $files);
            if(in_array('write_comment_update.sns.php', $files)){
                
                global $w, $write, $wr_id, $comment_id, $bo_table, $write_table, $reply_array;
                
                //코멘트 쓰기 or 댓글의 댓글이면
                if($w=='c'){
                    //코멘트의 코멘트
                    if($reply_array){
                        $prow = get_write($write_table, $reply_array['wr_id']);
                        $row = get_write($write_table, $comment_id);
                        $subject = cut_str($row['wr_content'], 30);
                        
                        btb\send_alim(
                            $prow['mb_id'],
                            G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'#c_'.$comment_id,
                            '[댓글등록됨] '.$subject
                        );
                        
                    //원글의 코멘트
                    }else{
                        $row = get_write($write_table, $comment_id);
                        $subject = cut_str($row['wr_content'], 30);
                        btb\send_alim(
                            $write['mb_id'],
                            G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id.'#c_'.$comment_id,
                            '[댓글답변글] '.$subject
                        );
                    }
                }
            }
        
            break;
        }
    }
}
