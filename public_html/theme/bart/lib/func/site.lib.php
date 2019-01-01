<?php
namespace kr\bartnet\builder;

if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

/**
* @bref 사이트메뉴 출력 (스킨에서 사이드를 직접 꾸밀때 사용함: 기본적으로는 사용하지 않음)
* @param string $skin 스킨
* @param int $depth 출력 깊이(0 부터시작)
* @return
**/
function sidemenu($skin, $depth=1){
	
	global $bt, $config;

	$ms = btb\BMenu::getInstance();

	$bm_pidx = bt\binstr($bt['curpath'][0]['bm_idx'], 0);

	if($bm_pidx > 0){
		$list = $ms->getTreeList('pc', true, $bm_pidx);
	}else{
		$list = $ms->getTreeList('pc', true, '0', $depth);
	}
	
	$bm_idx = $bt['curmenu']['bm_idx'];
	
	$title = $bt['curpath'][0]['bm_name'];
	if($bm_pidx){
    	$title = $bt['curpath'][0]['bm_name'];
	}else{
		$titie =$config['cf_title'];
	}

	ob_start();
	include(BT_SKIN_PATH.'/sidemenu/'.$skin.'/sidemenu.skin.php');
	$content = ob_get_contents();
    ob_end_clean();
    
	return $content;
}


/**
* @bref 사이드바 출력
**/
function get_sidebar(){
	global $bt, $btcfg;
	
	if($bt['curmenu']){
		$sidebar = 'side_'.$bt['curmenu']['bm_sidebar'];
	//없으면 기본 사이트바
	}else{
		$sidebar = $btcfg['bc_sidebar'];
	}
	
	//return BWidgetPage::getInstance()->getParsePage($sidebar);
}


/**
* @bref 레벨변동시 쪽지 보내기 (AutoLevelUp 클래스 콜백함수)
* @param string $mb_id
* @param string $mode : up or down
* @param int $new_level : 업데이트된 레벨
* @param int $std_point : 기준 포인트
* @return
**/
function send_levelup_msg($mb_id, $mode, $new_level, $std_point){
	
	global $config, $g5;
	
	// 쪽지 INSERT
	$tmp_row = sql_fetch(" select max(me_id) as max_me_id from {$g5['memo_table']} ");
    $me_id = $tmp_row['max_me_id'] + 1;
    
    if($mode=='up'){
		$memo = number_format($std_point)."포인트를 초과하여 레벨 ".$new_level."(으)로 승격되었습니다";
	}else{
		$memo = number_format($std_point)."포인트 이하로 떨어져 레벨 ".$new_level."(으)로 강등되었습니다";
	}
        
    $arr = array();
	$arr['me_id'] = $me_id;
	$arr['me_recv_mb_id'] = $mb_id;
	$arr['me_send_mb_id'] = $config['cf_admin'];
	$arr['me_send_datetime'] = G5_TIME_YMDHIS;
	$arr['me_memo'] = $memo;
	$bdb->insert($g5['memo_table'], $arr);

	// 실시간 쪽지 알림 기능
	$sql = "UPDATE ".$g5['member_table']." SET 
		mb_memo_call = '".$bdb->esc($config['cf_admin'])."'
		WHERE mb_id='".$bdb->esc($mb_id)."'";
	$bdb->query($sql);
}


/**
* @bref 안 읽은 알림 메세지 리턴
* @return array
**/
function get_latest_alim(){
	global $bt, $member;
	
	$bdb = \bt\database\BDB::getInstance();
	
	$arr = array();
	$sql = "SELECT * FROM ".$bt['alim_table']." WHERE al_mb_id='".$member['mb_id']."' AND al_read=0 ORDER BY al_regdate DESC LIMIT 10";
	return $bdb->fetchAll($sql);
}


/**
* @bref 스킨 select 옵션
* @return string
**/
function get_skin_option($skin_type, $value='', $first_opt=array()){
	
	$dir = '';
	
    /*
	if($device=='mobile') $dir .= "/".BT_MSKIN_PATH;
	else $dir = BT_SKIN_PATH;
    */
    $dir = BT_SKIN_PATH;
	
	$dir .= "/".$skin_type;
	
	$dirs = array();
	bt\file\BFiledir::getDirEntry($dirs, $dir, 'd', 1);
	
	if(is_array($dirs)){
		$s = new bt\html\BSelectbox();
		if(is_array($first_opt) && count($first_opt) > 0){
			$s->add($first_opt[0], $first_opt[1]);
		}
		foreach($dirs as $key=>$val) $s->add(basename($val), basename($val));
		$s->selectedFromValue = $value;
		
		return $s->getOption();
	}else return;
}
/*
function get_outskin_option($type, $value='', $first_opt=array()){
    
    $type = strtolower($type);
    
    $dir = BT_PATH.'/'.$type;
    
    $dirs = array();
    bt\file\BFiledir::getDirEntry($dirs, $dir, 'd', 1);
    
    if(is_array($dirs)){
        $s = new bt\html\BSelectbox();
        if(is_array($first_opt) && count($first_opt) > 0){
            $s->add($first_opt[0], $first_opt[1]);
        }
        foreach($dirs as $key=>$val) $s->add(basename($val), basename($val));
        $s->selectedFromValue = $value;
        
        return $s->getOption();
    }else return;
}
*/

/*
function get_widget_option($device, $value='', $first_opt=array()){
    
    $dir = '';
    
    if($device=='mobile') $dir .= "/".BT_MWIDGET_PATH;
    else $dir = BT_WIDGET_PATH;
    
    $dirs = array();
    bt\file\BFiledir::getDirEntry($dirs, $dir, 'd', 1);
    
    if(is_array($dirs)){
        $s = new bt\html\BSelectbox();
        if(is_array($first_opt) && count($first_opt) > 0){
            $s->add($first_opt[0], $first_opt[1]);
        }
        foreach($dirs as $key=>$val) $s->add(basename($val), basename($val));
        $s->selectedFromValue = $value;
        
        return $s->getOption();
    }else return;
}
*/

/**
* @bref 상황에 따른 레이아웃 스킨을 결정한다
**/
function build_frame_skin(){
	global $bt, $btcfg;
	
	$bt['default_css'] = BT_URL.'/css/default.css';

	if(defined('_INDEX_')){
		$bt['frame_skin'] = bt\binstr($btcfg['bc_skin_main_frame'], $btcfg['bc_skin_frame']);
	}else{
    	$bt['frame_skin'] = bt\binstr($bt['curmenu']['bm_skin_frame'], $btcfg['bc_skin_frame']);
	}
	$bt['frame_css'] = BT_SKIN_URL.'/frame/'.$bt['frame_skin'].'/css/style.css';
}



/**
* @bref content 에서 이미지 뽑아오기(그누보드 thumbnail 라이브러리에서 발췌 후 수정)
* @param string 게시판본문
* @return string 이미지경로
**/
function get_view_image($contents)
{
	// $contents 중 img 태그 추출
    $matches = get_editor_image($contents, true);

    if(empty($matches))
        return $contents;

    $srcfiles = array();
    for($i=0; $i<count($matches[1]); $i++) {

        $img = $matches[1][$i];
        preg_match("/src=[\'\"]?([^>\'\"]+[^>\'\"]+)/i", $img, $m);
        $src = $m[1];
        preg_match("/style=[\"\']?([^\"\'>]+)/i", $img, $m);
        $style = $m[1];
        preg_match("/width:\s*(\d+)px/", $style, $m);
        $width = $m[1];
        preg_match("/height:\s*(\d+)px/", $style, $m);
        $height = $m[1];
        preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $img, $m);
        $alt = get_text($m[1]);

        // 이미지 path 구함
        $p = parse_url($src);
        if(strpos($p['path'], "/data/") != 0)
            $data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
        else
            $data_path = $p['path'];

        if(!preg_match('/^\/'.G5_DATA_DIR.'/', $data_path))
            continue;

        $srcfiles[] = G5_PATH.$data_path;
    }

    return $srcfiles;
}

//위젯컨테이너
function show_widgets($skindir, $wp_id, $wg_id){
    //include_once(BT_LIB_PATH.'/class/builder/widgets.php');
    
    $search = BT_PATH;
    
    if($skindir == 'wpage' || $skindir == 'page' || $skindir == 'mpage'){
        $wg_skindir = $skindir;
    }else{
        $wg_skindir = str_replace(DS, "^", trim(str_replace($search, "", dirname($skindir)), "/"));
    }
    
    $w = btb\BWidgets::getInstance();
    $w->showWidgetList($wg_skindir, $wp_id, $wg_id);
}


//존재하는 mid인지 확인
/*function exists_mid($mid){
    global $g5, $bt;
    $bdb = \bt\database\BDB::getInstance();
    
    $mid = trim($mid);
    
    $sql = "SELECT * FROM ".$g5['board_table']." WHERE bo_table='".$mid."'";
    $rowcnt = $bdb->rowCount();
    if($rowcnt > 0) return true;
    
    $sql = "SELECT * FROM ".$bt['page_table']." WHERE pg_id='".$mid."'";
    $rowcnt = $bdb->rowCount();
    if($rowcnt > 0) return true;
    
    $sql = "SELECT * FROM ".$bt['wpage_table']." WHERE wp_id='".$mid."'";
    $rowcnt = $bdb->rowCount();
    if($rowcnt > 0) return true;
    
    return false;
}*/
/*
function get_widget_skindir($filepath){
    $search = BT_PATH;
    return str_replace(DS, "^", trim(str_replace($search, "", dirname($filepath)), "/"));
}*/



/**
* @bref 메뉴를 ul, li 태그로 변환해 준다
* @param seetSetTreeCate 결과로 돌려받은 메뉴 Tree 배열
* @param 현재 idx
* @param 활성화 표시 클래스명을 li, a 둘중에 어디 붙일지
* @param 추가 class
*  'li': li태그에 붙을 추가 클래스,
*  'a': a태그에 붙을 추가 클래스,
*  'pre_a': a태그 앞에 붙을 내용
*  'pre_a_haschild': a태그 뒤에 붙을 내용(자식노드가 없을때)
* @return 
**/
function get_menu_tag($menu, $cur_idx='', $active_tag='a', $is_showicon=false, $cls_opt=array()){
    static $depth = 0;
    static $pidx = 0;
    static $cnt = 0;
    static $curpath = null;
    
    $cls_active = bt\binstr($cls_opt["active"], "current");
    
    
    //현재메뉴의 경로를 구해온다
    if($curpath == null){
        $curpath = btb\BMenu::getInstance()->getPath($cur_idx);
    }
    
    $str = '';
    foreach($menu as $item){
        $node = $item['node'];
        $child = $item['child'];
        
        if(($node['bm_device'] == 'pc' && is_mobile()) || ($node['bm_device'] == 'mobile' && !is_mobile())) continue;
                
        $alink = btb\BMenu::getMenuLink($node);
        
        $lcls = array();
        $acls = array();
        $lcls[] = bt\isval($cls_opt["li"]) ? $cls_opt["li"] : '';
        $acls[] = bt\isval($cls_opt["a"]) ? $cls_opt["a"] : '';
        
        $cnt++;
        
        //$item 이 현재 메뉴이면
        if($node['bm_idx']==$cur_idx){
            $pidx = $node['bm_pidx'];
            if($active_tag=="a")
                $acls[] = $cls_active;
            else
                $lcls[] = $cls_active;
        
        }else{
            //부모메뉴이면 current 클래스 추가
            for($i=0; $i<count($curpath);$i++){
                if($curpath[$i]['bm_idx']==$node["bm_idx"]){
                    if($active_tag=="a")
                        $acls[] = $cls_active;
                    else
                        $lcls[] = $cls_active;
                    break;
                }
            }
        }
        
        // li 태그 시작
        $sub_str = '';
        
        $pre_a = bt\varset($cls_opt["pre_a"]);
        
        //자식 메뉴 있으면 재귀호출
        if(count($child) > 0){
            //echo $depth.':'.$node['bm_name'].':'.count($child).'<br>';
            $depth++;
            $sub_str = PHP_EOL.'<ul>'.PHP_EOL;
            $sub_str .= btb\get_menu_tag($child, $cur_idx, $active_tag, $is_showicon, $cls_opt);
            $sub_str .= '</ul>'.PHP_EOL;
            $depth--;
            
            if(bt\isval($cls_opt["pre_a_haschild"]))
                $pre_a = $cls_opt["pre_a_haschild"];
        }
        
        //class 정리
        if(count($lcls) > 0) $lcls = ' class="'.implode(" ", $lcls).'"';
        else $lcls = '';
        
        if(count($acls) > 0) $acls = ' class="'.implode(" ", $acls).'"';
        else $acls = '';
        
        $icon = "";
        if($is_showicon){
            if(G5_IS_MOBILE){
                if(bt\isval($node['bm_micon'])) $icon = '<i class="fa fa-'.$node['bm_micon'].'"></i> ';
            }else{
                if(bt\isval($node['bm_icon'])) $icon = '<i class="fa fa-'.$node['bm_icon'].'"></i> ';
            }
        }

        //태그정리
        $str .= '<li'.$lcls.'>'.$pre_a.'<a'.$acls.' href="'.$alink.'" target="'.$node['bm_target'].'"'.$a_cls.'>'.$icon.$node['bm_name'].'</a>';
        $str .= $sub_str;
        $str .= '</li>'.PHP_EOL;
    }        
    return $str;
}


function get_name($member){
    $name = '';
    if($member['mb_nick']!='') $name = $member['mb_nick'];
    else if($member['mb_name']!='') $name = $member['mb_name'];
    else $name = $member['mb_id'];
    return $name;
}


/**
* @bref 어제 이하의 시간은 문자열로 보여줌, 그 이상은 날짜형식 그대로
* @param string 'YYYY-mm-dd H:i:s'
* @return string
**/
function get_date_tostr($strdate){
    
    $regdate = strtotime(substr($strdate, 0, 10));
    $regtime = strtotime($strdate);
    
    $nowdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    $nowtime = time();
    
    $difdate = $nowdate - $regdate;
    $diftime = $nowtime - $regtime;
    
    $day=round($difdate / 86400);
    
    if($day > 0){
        if($day == 1) $res = '어제';
        else if($day == 2) $res = '이틀 전';
        else $res = substr($strdate,0,10);
        
    }else{
        $hour = round($diftime / (60*60));
        if($hour > 0) $res = $hour.'시간 전';
        else{
            $min = round($diftime / 60);
            if($min) $res = $min.'분 전';
            else $res = $diftime.'초 전';
        }
    }
    return $res;
}


function get_latest_data($bo_table, $limit, $widget_url, $where="", $orderby=""){
    
    global $g5;
    
    $multi = false;
    
    if(is_array($bo_table)){
        if(count($bo_table) <= 0) return;
        $bo_table = implode("', '", $bo_table);
        $multi = true;
    }else if(!bt\isval($bo_table)) return;
    
    //$board 가 배열이 아니라 문자열이면
    if(is_string($bo_table)){
        $sql = "SELECT * FROM ".$g5['board_table']." WHERE bo_table IN ('".$bo_table."')";
        $bresult = sql_query($sql);
    }
    
    $list = array();
    while($brs = sql_fetch_array($bresult)){
        
        if(bt\isval($where)) $where = ' AND '.$where;
        
        if(bt\isval($orderby)){
            $order = " ORDER BY ".$orderby;
        }else{
            $order = " ORDER BY wr_num";
        }
        
        $write_table = $g5['write_prefix'].$brs['bo_table'];
        
        //본문글 추출
        $sql = "SELECT * FROM ".$write_table." WHERE wr_is_comment = 0 ".$where.$order." limit 0, ".$limit;
        $result = sql_query($sql);
        
        if($multi){
            $list[$brs["bo_table"]] = array();
            $lst = &$list[$brs["bo_table"]];
        }else{
            $lst = &$list;
        }
        
        $lst['board'] = $brs;
        $lst['list'] = array();
        
        for ($i=0; $row = sql_fetch_array($result); $i++) {
            $lst['list'][] = get_list($row, $brs, $widget_url, $subject_len);
        }
    }
        
    return $list;
}


/**
* @bref 새글 or 새댓글
* @param true 일 경우 댓글
* @return array
**/
function get_new_data($rowcnt, $widget_url, $subject_len, $is_reply=false){
    
    global $g5, $config;
    
    if($is_reply) $sign = '<>';
    else $sign = '=';
    
    $sql = "SELECT * FROM ".$g5['board_new_table']." n
    INNER JOIN ".$g5['board_table']." b ON n.bo_table=b.bo_table
    WHERE b.bo_use_search=1 AND n.wr_id ".$sign." n.wr_parent
    ORDER BY n.bn_id DESC
    LIMIT ".$rowcnt;
    
    $bdb = bt\database\BDb::getInstance();
    $result = $bdb->query($sql);
    
    $list = array();
    
    while($nrs = $bdb->fetch($result)){
    
        $tmp_write_table = $g5['write_prefix'].$nrs['bo_table'];
        $row = $bdb->fetch(" select * from ".$tmp_write_table." where wr_id = '".$nrs['wr_id']."' ");
        
        $temp = get_list($row, $nrs, $widget_url, $subject_len);
        $temp["bo_table"] = $nrs["bo_table"];
        $list[] = $temp;
    }
    
    return $list;
}


// 게시글리스트 썸네일 생성
function get_list_thumbnail($bo_table, $wr_id, $thumb_width, $thumb_height, $options=array())
{
    global $g5, $config;
    $filename = $alt = "";
    $edt = false;

    $sql = " select bf_file, bf_content from {$g5['board_file_table']}
                where bo_table = '$bo_table' and wr_id = '$wr_id' and bf_type between '1' and '3' order by bf_no limit 0, 1 ";
    $row = sql_fetch($sql);

    if($row['bf_file']) {
        $filename = $row['bf_file'];
        $filepath = G5_DATA_PATH.'/file/'.$bo_table;
        $alt = get_text($row['bf_content']);
        $srcfile = $filepath."/".$filename;
    } else {

        $write_table = $g5['write_prefix'].$bo_table;
        $sql = " select wr_content from $write_table where wr_id = '$wr_id' ";
        $write = sql_fetch($sql);
        $matches = get_editor_image($write['wr_content'], false);
        
        for($i=0; $i<count($matches[1]); $i++)
        {
            $edt = true;
            
            // 이미지 path 구함
            $p = parse_url($matches[1][$i]);
            if(strpos($p['path'], '/'.G5_DATA_DIR.'/') != 0)
                $data_path = preg_replace('/^\/.*\/'.G5_DATA_DIR.'/', '/'.G5_DATA_DIR, $p['path']);
            else
                $data_path = $p['path'];

            $srcfile = G5_PATH.$data_path;

            if(preg_match("/\.({$config['cf_image_extension']})$/i", $srcfile) && is_file($srcfile)) {
                $size = @getimagesize($srcfile);
                if(empty($size))
                    continue;

                $filename = basename($srcfile);
                $filepath = dirname($srcfile);

                preg_match("/alt=[\"\']?([^\"\']*)[\"\']?/", $matches[0][$i], $malt);
                $alt = get_text($malt[1]);

                break;
            }
            
        }
    }

    if(!$filename){
        $filename = 'blank_img.gif';
        $filepath = G5_DATA_PATH.'/file/'.$bo_table;
        $srcfile = G5_THEME_PATH.'/img/blank_img.gif';
        $data_path = '/img/blank_img.gif';
    }

    //$tname = thumbnail($filepath.'/'.$filename, $filepath, $filepath, $thumb_width, $thumb_height, $is_create, $is_crop, $crop_mode, $is_sharpen, $um_value);
    $temp = bt\image\BThumbnail::makeThumb($srcfile, $filepath, $thumb_width, $thumb_height, $options);
    $tname = $temp["filename"];
    
    if($tname) {
        if($edt) {
            // 오리지날 이미지
            $ori = G5_URL.$data_path;
            // 썸네일 이미지
            $src = G5_URL.str_replace($filename, $tname, $data_path);
        } else {
            $ori = G5_DATA_URL.'/file/'.$bo_table.'/'.$filename;
            $src = G5_DATA_URL.'/file/'.$bo_table.'/'.$tname;
        }
        
        //echo $src.'<br>';
    } else {
        return false;
    }

    $thumb = array("src"=>$src, "ori"=>$ori, "alt"=>$alt);

    return $thumb;
}


function add_exp($member, $point){
    
}


/**
* @desc 후처리기, 그누보드 코어를 보존하기 위한 편법, /extend/bt.config.php 에서 호출함
**/
function post_processor(){
    
    global $is_member, $member;
    
    $list = get_included_files();
    $list = array_map(function($str){
        return bt\str_trim($str, G5_PATH);
    }, $list);
    
    //alert.php 가 인클루드 되어 있으면 작업에 오류가 있었다고 판단함
    if($is_member && !in_array('/bbs/alert.php', $list)){
        
        //게시판 글쓰기일때
        if(in_array('/bbs/write_update.skin.php', $list)){
            
            global $board;
            
            //TODO: 경험치 추가
            btb\add_exp($member, $board['bo_write_point']);
            
        //로그인일때
        }else if(in_array('/bbs/login_check.php', $list)){
            
            global $config;
            
            //TODO: 경험치 추가
            btb\add_exp($member, $config['cf_login_point']);
            
        //코멘트 쓰기일때
        }else if(in_array('/bbs/write_comment_update.php', $list)){
            
        }
    }
}


function get_module($mp_id){
    
    global $bt;
    
    static $module = array();
    
    if(isset($module[$mp_id])) return $module[$mp_id];
    
    $sql = "SELECT * FROM ".$bt['mpage_table']." WHERE mp_id='".$mp_id."'";
    $row = sql_fetch($sql);
    if(!$row) return;
    
    $row['config'] = @json_decode($row['mp_setup'], true);
    $module[$mp_id] = $row;
    
    return $row;
}

function get_sido_from_addr($addr){
    $pos = strpos($addr, ' ');
    return substr($addr, 0, $pos);
}


// 한페이지에 보여줄 행, 현재페이지, 총페이지수, URL
function get_paging($write_pages, $cur_page, $total_page, $url, $add="")
{
    //$url = preg_replace('#&amp;page=[0-9]*(&amp;page=)$#', '$1', $url);
    $url = preg_replace('#&amp;page=[0-9]*#', '', $url) . '&amp;page=';

    $str = '';
    
    if ($cur_page > 1) {
        $str .= '<li class="page-item"><a class="page-link" href="'.$url.'1'.$add.'">처음</a></li>'.PHP_EOL;
    }

    $start_page = ( ( (int)( ($cur_page - 1 ) / $write_pages ) ) * $write_pages ) + 1;
    $end_page = $start_page + $write_pages - 1;

    if ($end_page >= $total_page) $end_page = $total_page;

    if ($start_page > 1) $str .= '<li class="page-item"><a class="page-link" href="'.$url.($start_page-1).$add.'">이전</a></li>'.PHP_EOL;

    if ($total_page > 1) {
        for ($k=$start_page;$k<=$end_page;$k++) {
            $cls = "";
            if ($cur_page == $k) $cls = " active";
            $str .= '<li class="page-item'.$cls.'"><a class="page-link" href="'.$url.$k.$add.'">'.$k.'<span class="sound_only">페이지</span></a></li>'.PHP_EOL;
        }
    }

    if ($total_page > $end_page) $str .= '<li class="page-item"><a class="page-link" href="'.$url.($end_page+1).$add.'">다음</a></li>'.PHP_EOL;

    if ($cur_page < $total_page) {
        $str .= '<li class="page-item"><a class="page-link" href="'.$url.$total_page.$add.'">맨끝</a></li>'.PHP_EOL;
    }

    if ($str){
        return '<nav aria-label="Pagging" class="mx-auto my-3"><ul class="pagination justify-content-center">'.$str.'</ul></nav>';
    }else{
        return "";
    }
}


/**
* @desc URL로부터 프레임정보를 얻음
* @param string URL
* @return Array
**/
function parse_frame($url){
    $temp = parse_url( urldecode($url) );
    $path = str_replace(DS, '^', trim($temp['path'], DS));
    
    $mtype = '';
    $mid = '';

    if(isset($temp['query'])){
        
        parse_str($temp['query'], $qs);
        
        if(isset($qs['bo_table'])){
            $mtype = 'board';
        }else if(isset($qs['mtype'])){
            $mtype = $qs['mtype'];
        }
        if(isset($qs['mid'])){
            $mid = $qs['mid'];
        }
    }
    
    // '/', '/index.php', '/???' 도 index.php 로 인식하도록 path를 공백으로 준다
    if($_SERVER['SCRIPT_NAME'] == '/index.php' && $mtype == '' && $mid == ''){
        $path = '';
    }
    
    return array(
        'path' => $path,
        'mtype' => $mtype,
        'mid' => $mid
    );
}

function get_frame_config($frame_skin, $url, $refresh=false){
    
    global $bt;
    static $rs = null;
    
    if(!$refresh && $rs !== null) return $rs;
    
    $f = parse_frame($url);
    
    //지역설정이 있는지 체크   
    $Q = "SELECT * FROM ".$bt['frame_table']." 
        WHERE fs_skin='".$frame_skin."' 
        AND fs_path='".$f['path']."' 
        AND fs_mtype='".$f['mtype']."' 
        AND fs_mid='".$f['mid']."'
        AND fs_private='1'";
    
    $rs = sql_fetch($Q);
    
    //지역설정이 없으면 전역설정 불러옴
    if(!$rs){
        $Q = "SELECT * FROM ".$bt['frame_table']." 
        WHERE fs_skin='".$frame_skin."'
        AND fs_path='' 
        AND fs_mtype='' 
        AND fs_mid=''
        AND fs_private='0'";
        $rs = sql_fetch($Q);
    }
    
    if(!$rs) return;
    $arr = @json_decode($rs['fs_config'], true);
    if(is_array($arr)){
        $rs = array_merge($rs, $arr);
    }
    return $rs;
}

//알림보내기
function send_alim($to_id, $url, $message){
    
    global $member;
    
    $to_id = trim($to_id);
    
    if(($to_id == $member['mb_id']) ||
        !bt\isval($to_id) || !bt\isval($member['mb_id'])) return;
    
    $arr = array();
    $arr['mb_id'] = $to_id;
    $arr['al_url'] = $url;
    $arr['al_message'] = $message;
    $arr['al_regdate'] = G5_TIME_YMDHIS;
    
    /* @var bt\database\BDB */
    $bdb = bt\database\BDb::getInstance();
    $bdb->insert(BT_PREFIX.'alim', $arr);
}


// 외부로그인(그누보드의 outlogin 은 include_once 로 되어 있어 한번밖에 include 되지 않아 따로 만듬)
function outlogin($skin_dir='basic')
{
    global $config, $member, $g5, $urlencode, $is_admin, $is_member;

    if (array_key_exists('mb_nick', $member)) {
        $nick  = get_text(cut_str($member['mb_nick'], $config['cf_cut_name']));
    }
    if (array_key_exists('mb_point', $member)) {
        $point = number_format($member['mb_point']);
    }

    if(preg_match('#^theme/(.+)$#', $skin_dir, $match)) {
        if (G5_IS_MOBILE) {
            $outlogin_skin_path = G5_THEME_MOBILE_PATH.'/'.G5_SKIN_DIR.'/outlogin/'.$match[1];
            if(!is_dir($outlogin_skin_path))
                $outlogin_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/outlogin/'.$match[1];
            $outlogin_skin_url = str_replace(G5_PATH, G5_URL, $outlogin_skin_path);
        } else {
            $outlogin_skin_path = G5_THEME_PATH.'/'.G5_SKIN_DIR.'/outlogin/'.$match[1];
            $outlogin_skin_url = str_replace(G5_PATH, G5_URL, $outlogin_skin_path);
        }
        $skin_dir = $match[1];
    } else {
        if (G5_IS_MOBILE) {
            $outlogin_skin_path = G5_MOBILE_PATH.'/'.G5_SKIN_DIR.'/outlogin/'.$skin_dir;
            $outlogin_skin_url = G5_MOBILE_URL.'/'.G5_SKIN_DIR.'/outlogin/'.$skin_dir;
        } else {
            $outlogin_skin_path = G5_SKIN_PATH.'/outlogin/'.$skin_dir;
            $outlogin_skin_url = G5_SKIN_URL.'/outlogin/'.$skin_dir;
        }
    }

    // 읽지 않은 쪽지가 있다면
    if ($is_member) {
        $sql = " select count(*) as cnt from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_read_datetime = '0000-00-00 00:00:00' ";
        $row = sql_fetch($sql);
        $memo_not_read = $row['cnt'];

        $is_auth = false;
        $sql = " select count(*) as cnt from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' ";
        $row = sql_fetch($sql);
        if ($row['cnt'])
            $is_auth = true;
    }

    $outlogin_url        = login_url($urlencode);
    $outlogin_action_url = G5_HTTPS_BBS_URL.'/login_check.php';

    ob_start();
    if ($is_member)
        include ($outlogin_skin_path.'/outlogin.skin.2.php');
    else // 로그인 전이라면
        include ($outlogin_skin_path.'/outlogin.skin.1.php');
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}