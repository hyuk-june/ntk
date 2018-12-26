<?php
namespace kr\bartnet\board;

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!defined("_GNUBOARD_")) exit("Access Denied");

function exists_configfile($bo_table){
    $filepath = BT_DATA_PATH.'/bcfg/'.$bo_table.'/config.php';
    if(file_exists($filepath)) return true;
    else return false;
}

function get_config($bo_table){
    
    //싱글턴을 사용하면 안된다
    //static $bcfg = null;
    //if(is_array($bcfg)) return $bcfg;
    
    $filepath = BT_DATA_PATH.'/bcfg/'.$bo_table.'/config.php';
    
    if(!file_exists($filepath)) return array();
    $list = file($filepath);
    array_shift($list);
    $content = trim(@implode('', $list));
    
    if($content=='') return array();
    return @json_decode($content, true);
    //return $bcfg;
}


function set_config($bo_table, $data){

    $str = '<'.'?php exit();?>'.PHP_EOL;
    
    $temp['opt_step'] = '';
    $temp['opt_code'] = '';
    $temp['opt_name'] = '';
    $temp['opt_type'] = '';
    $temp['opt_value'] = '';
    $temp['opt_attr'] = '';
    $temp['opt_help'] = '';
    
    $keys = array('opt_step', 'opt_code', 'opt_name', 'opt_type', 'opt_value', 'opt_attr', 'opt_help');
    
    for($i=0; $i<count($data['opt_name'])-1; $i++){
        for($j=$i; $j<count($data['opt_name']); $j++){
            if($data['opt_step'][$i] > $data['opt_step'][$j]){
                
                $temp = '';
                foreach($keys as $key){
                    $temp = $data[$key][$i];
                    $data[$key][$i] = $data[$key][$j];
                    $data[$key][$j] = $temp;
                }
            }
        }
    }
    
    $str .= trim(@json_encode($data));
    
    if(!is_dir(BT_DATA_PATH.'/bcfg/'.$bo_table)) mkdir(BT_DATA_PATH.'/bcfg/'.$bo_table, 0755, true);
    $fp = fopen(BT_DATA_PATH.'/bcfg/'.$bo_table.'/config.php', 'w+');
    fwrite($fp, $str);
    fclose($fp);
}

function get_skin_list($mode){
    
    global $board_skin_path;
    
    $dirpath = $board_skin_path;
    
    if($mode=='list'){
        $dirpath .= '/list';
    }else if($mode=='view'){
        $dirpath .= '/view';
    }else if($mode=='write'){
        $dirpath .= '/write';
    }
    
    $list = array();
    bt\file\BFiledir::getDirEntry($list, $dirpath, 'd');
    return $list;
}


/**
* @bref 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
**/
function get_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    if ($cur_page > 1) {
        $str .= '<li class="page-item"><a class="page-link" href="'.$url.'1'.$add.'"><i class="fa fa-step-backward">&nbsp;</i><span class="hidden-xs">처음</span></a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li class="page-item"><a class="page-link" href="'.$url.($start_page-1).$add.'"><i class="fa fa-chevron-left">&nbsp;</i><span class="hidden-xs">이전</span></a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            if ($cur_page != $k)
                $str .= '<li class="page-item"><a class="page-link" href="'.$url.$k.$add.'">'.$k.'</a></li>'.PHP_EOL;
            else
                $str .= '<li class="page-item active"><a class="page-link" href="#">'.$k.'</a></li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li class="page-item"><a class="page-link" href="'.$url.($end_page+1).$add.'"><i class="fa fa-chevron-right">&nbsp;</i><span class="hidden-xs">다음</span></a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<li class="page-item"><a class="page-link" href="'.$url.$total_page.$add.'"><i class="fa fa-step-forward">&nbsp;</i><span class="hidden-xs">맨끝</span></a></li>'.PHP_EOL;
    }

    if ($str)
        return '<div class="pagination-wrap d-flex justify-content-center"><ul class="pagination">'.$str.'</ul></div>';
    else
        return "";
}


/**
* @bref get_content_deco 함수 콜백 (익명함수는 5.4부터 지원되기 때문)
**/
function _get_content_deco_img($mat){
    //이미지를 반응형으로
    return '<img '.$mat[1].' class="img-responsive">';
}


function _get_content_deco_video($mat){
    //TODO: 비디오도 반응형으로
}


/**
* @bref 본문 추가 변경사항 적용
**/
function get_content_deco($content){
    
    $str = get_view_thumbnail($content);
    $str = preg_replace_callback('~<img\s+([^>]+)>~is', 'kr\bartnet\board\_get_content_deco_img', $str);
    //$str = preg_replace_callback('~<img\s+([^>]+)>~is', 'kr\bartnet\board\_get_content_deco_video', $str);
    return $str;
}


/**
* @bref 코멘트 쓸때 알림보내기
**/
function send_alim_comment(){
    global $comment_id, $member, $wr, $w, $bo_table, $reply_array, $write_table;
    
    //댓글 쓰기 했을때
    if($w=='c'){
        
        if(isset($reply_array)){
            $sql = "SELECT * FROM ".$write_table." WHERE wr_id=".$_POST["comment_id"];
            $rs = sql_fetch($sql);
            
            if(trim($rs['mb_id'])=='' || $rs['mb_id']==$member['mb_id']) return;
            $kind = "내 댓글";
            $to_id = $rs['mb_id'];
        }else{
            if(trim($wr['mb_id'])=='' || $wr['mb_id']==$member['mb_id']) return;
            $kind = "내 글";
            $to_id = $wr['mb_id'];
        }
        
        $url = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr['wr_id'].'#c_'.$comment_id;
        $message = btb\get_name($member).' 님이 '.$kind.'에 댓글을 달았습니다';
        
        
        $alim = btb\BAlim::getInstance();
        $alim->send($to_id, $url, $message);
    }
}


/**
* @bref 답변글 쓸때 알림보내기
**/
function send_alim_reply(){
    global $reply_array, $r, $member, $bo_table, $write_table, $wr_id;
        
    if($w = 'r'){
        
        $sql = "SELECT * FROM ".$write_table." WHERE wr_id=".$wr_id;
        $write = sql_fetch($sql);
        
        if($write['mb_id']=='' || $member['mb_id'] == $reply_array['mb_id']) return;
        
        $url = G5_BBS_URL.'/board.php?bo_table='.$bo_table.'&wr_id='.$wr_id;
        $message = btb\get_name($member).' 님이 답변글을 달았습니다';
        
        $to_id = $reply_array['mb_id'];
        
        $alim = btb\BAlim::getInstance();
        $alim->send($to_id, $url, $message);
    }
}

//게시판 추가옵션저장
function save_option($bo_table, $wr_id, $data=array()){
    
    $str = '<'.'?php exit();?'.'>'.PHP_EOL;
    
    if(isset($_POST["opt_code"]) && count($_POST["opt_code"]) > 0){
        $opts = array();

        for($i=0; $i<count($_POST["opt_code"]); $i++){
            $opts[$_POST["opt_code"][$i]] = $_POST["opt_value"][$i];
        }

        $data['options'] = $opts;
    }
            
    $str .= @json_encode($data);
    $fp = fopen(G5_DATA_PATH.'/file/'.$bo_table.'/opt_'.$wr_id.'.php', 'w+');
    fwrite($fp, $str);
    fclose($fp);
}

//게시판 추가옵션로드
function load_option($bo_table, $wr_id){
    $file_path = G5_DATA_PATH.'/file/'.$bo_table.'/opt_'.$wr_id.'.php';

    if(!file_exists($file_path)) return;
    $line = file($file_path);
    array_shift($line);
    return @json_decode( @implode('', $line), true);
}