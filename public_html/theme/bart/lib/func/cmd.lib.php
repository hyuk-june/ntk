<?php
namespace kr\bartnet;

/**
* @desc 상대url, 절대url을 도메인포함 full url로 만든다
* @param string 기본URL
* @param string 상대or절대 url
* @return string
**/
function get_fullurl($std_url, $url){
	
	$url = preg_replace("~^//~", "http://", $url);
	
	if(preg_match('~(?:^[a-z]+\:)~i', $url)){
		return $url;
	}
	
	$std = parse_url($std_url);
	$std_url = $std['scheme'].'://'.$std['host'];
	if(isset($std['path'])) $std_url .= $std['path'];
	
	$std['host'] = trim($std['host'], '/');
	
	if(preg_match('/^[^.\/]/i', $url)){
		$str = $std['scheme'].'://'.$std['host'];
		if(isset($std['path'])) $str .= substr($std['path'], 0, strrpos($std['path'], '/'));
		$str .= '/'.$url;
		return $str;
	}
	
	if(substr($url,0,1) == '/'){
		return $std['scheme'].'://'.$std['host'].$url;
	}
	
	if(substr($url, 0, 2)=='./'){
		$std['path'] = substr($std['path'], 0, strrpos($std['path'], '/'));
		$str = $std['scheme'].'://'.$std['host'];
		if(isset($std['path']) && trim($std['path'])!='') $str .= '/'.trim($std['path'], '/');
		$str .= '/'.substr($url, 2);
		return $str;
	}
	
	if(substr($url, 0, 3)=='../'){
		
		while(substr($url, 0, 3) == '../'){
			$std_url = preg_replace('~//*[^/]+$~i', '', $std_url, 1);
			//$std_url = preg_replace('/\/[^\/]+$/i', '', $std_url, 1);
			$url = substr($url, 3);
		}
		
		extract(parse_url($std_url));
		
		if(isset($path)){
			$std_url = preg_replace('~//*[^/]+$~i', '', $std_url, 1);
		}
		
		return $std_url."/".$url;
	}
	
	return $url;
	
	/*
	if(substr($url, 0, 3)=='../'){
		
		while(substr($url, 0, 3) == '../'){
			$std_url = preg_replace('/[^\/]+\/[^\/]*$/i', '', $std_url, 1);
			$url = substr($url, 3);
		}
		
		return $std_url.$url;
	}
	
	return $url;
	*/
}

/**
* @desc Undefined Varient 에러방지(존재하지 않는 변수를 할당한다)
* @param reference 변수
* @param mixed 디폴트값
* @return mixed
**/
function varset(&$var, $default=NULL){
	$var = isset($var) ? $var : $default; 
	return $var;
}

/**
 * @desc 값이 있으면 TRUE, 정의가 안됐거나 NULL이거나 ''이면 FALSE
 * @param mixed 변수
 * @return boolean
 **/
function isval(&$var){
	$var = varset($var);
    if(is_array($var)) return TRUE;
	return trim($var)!='' ? TRUE : FALSE;
}


/**
* @desc 값이 존재하면 해당값을 존재하지 않으면 기본값을 리턴
* @param mixed 검사대상변수
* @param mixed 기본값
* @return mixed
**/
/*function binstr(&$var, $replace){
	$var = varset($var);
	return isval($var) ? $var : $replace;
}*/

function binstr(&$var, $a, $b=''){
    $var = varset($var);
    if(isval($var)){
        if(isval($b)) return $a;
        else return $var;
    }else{
        if(isval($b)) return $b;
        return $a;
    }
}


/**
* @desc 깊은 array_map
* @param callback 함수
* @param &array 배열
* @return $arr
**/
function array_map_recursive($func, &$arr){
    
	if(!is_array($arr)) return;
	foreach($arr as $key=>$value){
		if(is_array($arr[$key])){
			array_map_recursive($func, $arr[$key]);
		}else{
			$arr[$key] = call_user_func($func, $value);
		}
	}
    
	return $arr;
}


/**
* @desc 메모리 사용량을 표시
* @param boolean 시작일때 true
**/
function show_memory($is_start=false){
	if($is_start){
    	echo 'Start: ' . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n".PHP_EOL;
	}else{
		echo 'Peak: ' . number_format(memory_get_peak_usage(), 0, '.', ',') . " bytes\n".PHP_EOL;
    	echo 'End: ' . number_format(memory_get_usage(), 0, '.', ',') . " bytes\n".PHP_EOL;
	}
}


/**
* @desc html엔티티문자를 utf-8로 변경
* @param string html엔티티문자
* @return string
**/
function entities_to_unicode($str) {
    $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    $str = preg_replace_callback("/(&#[0-9]+;)/", function($mat){
        return mb_convert_encoding($mat[1], "UTF-8", "HTML-ENTITIES");
    }, $str);
    return $str;
}



/**
* @desc 쿠키에서 특정 가져옴
* @param string 전체쿠키문자열
* @param string 쿠키이름
* @return string or false
**/
function get_cookie_prop($cookie_content, $property){
	if(strpos($cookie_content, $property) !== false){
		$property = str_replace("{$property}=", "|{$property}=", $cookie_content);
		$property = substr($property, strpos($property, '|')    + 1); 
		$property = substr($property, 0, strpos($property, ';') + 1);
		return $property;
	}
	return false;
}


/**
* @desc 디렉토리 목록으로 세팅된 BSelectBox 객체를 리턴
* @param string 디렉토리경로
* @return BSelectbox
**/
function get_select($dir_path){
    $dirs = array();
    file\BFiledir::getDirEntry($dirs, $dir_path, 'd', 1);
    $s = new html\BSelectbox();
    foreach($dirs as $key=>$val) $s->add(basename($val), basename($val));
    return $s;
}


/**
* @desc 체크박스 checked 표시
* @param string 체크박스value
* @param string 현재값
* @param boolean 기본체크여부
* @return string
**/
function get_checked($std_val, &$cur_val){
    
    $str = '';
    
    //if(!isset($cur_val)) echo ' XXX';
    if($std_val == $cur_val){
        $str = ' checked="checked"';
    }
    return $str;
}


/**
* @desc 쿼리 스트링에 새로운항목 추가, 존재할시 덮어씀
* @param string 원본쿼리스트링
* @param array 추가할항목key&value
* @return string
**/
function add_qstr($qstr, $arr){
    
    $qstr = binstr($qstr, "");
    $qstr = str_replace('&amp;', '&', $qstr);
    
    $temp = array();
    parse_str($qstr, $temp);
    foreach($arr as $key => $val) $temp[$key] = $val;
    
    $temp2 = array();
    foreach($temp as $key => $val) $temp2[] = $key.'='.$val;
    return @implode('&amp;', $temp2);
}


/**
* @desc 쿼리 스트링에 지정된 키 항목 삭제
* @param string 원본쿼리스트링
* @param array 삭제할 항목의 키 array
* @return string
**/
function pop_qstr($qstr, $arr){
    
    $qstr = binstr($qstr, "");
    
    $qstr = str_replace('&amp;', '&', $qstr);
    
    
    if(!is_array($arr)) $arr = array($arr);
    
    $res = array();
    $temp = array();
    parse_str($qstr, $temp);
    foreach($temp as $key => $val){
        if(in_array($key, $arr)) continue;
        $res[] = $key.'='.$val;
    }
    return implode('&amp;', $res);
}


/**
* @desc 문자에 add_string 이 없으면 추가함
* @param string 원본문자열
* @param string 추가할문자열
* @param boolean 뒤에추가할지여부
* @return string
**/
function add_string($str, $add_string, $tail=false){
    if($tail){
        if(substr($str, -strlen($add_string)) !== $add_string){
            $str = $str . $add_string;
        }
    }else{
        if(substr($str, 0, strlen($add_string)) !== $add_string){
            $str = $add_string.$str;
        }
    }
    return $str;
}


/**
* @desc 문자열 단위의 트림(trim 은 문자 단위로만 됨)
* @param string 원본문자열
* @param string 삭제할문자열
* @param boolean 뒷부분인지여부
* @return string
**/
function str_trim($str, $subtract, $is_back=false){
    $len = strlen($subtract);
    
    if($is_back){
        $temp = substr($str, -$len);
        if($temp == $subtract) $str = substr($str, 0, -$len);
    }else{
        $temp = substr($str, 0, $len);
        if($temp == $subtract) $str = substr($str, $len);
    }
    return $str;
}


/**
* @desc 소수점 자리수를 유동적으로
* @param string 숫자
* @param int 자리수
* @param string 소수점 문자
* @param string 숫자구분자
* @return string
**/
function number_format($number,$precision=0,$dec_point='.',$thousands_sep=','){
    return trim(number_format($number,$precision,$dec_point,$thousands_sep),'0'.$dec_point);
}


/**
* @desc 한글 초성 구하기
* @param string 문자열
* @return string 2문자
**/
function get_choseong($str){
    $ch = mb_substr($str,0,1, "utf-8");
    
    $han = array();
    $han["가"] = array("AC00", "B097");
    $han["나"] = array("B098", "B2E3");
    $han["다"] = array("B2E4", "B77B");
    $han["라"] = array("B77C", "B9C7");
    $han["마"] = array("B9C8", "BC13");
    $han["바"] = array("BC14", "C0AB");
    $han["사"] = array("C0AC", "C543");
    $han["아"] = array("C544", "C78F");
    $han["자"] = array("C790", "CC27");
    $han["차"] = array("CC28", "CE73");
    $han["카"] = array("CE74", "D0BF");
    $han["타"] = array("D0C0", "D30B");
    $han["파"] = array("D30C", "D557");
    $han["하"] = array("D558", "D7A3");
    
    foreach($han as $key=>$item){
        $r = preg_match("~[\x{".$item[0]."}-\x{".$item[1]."}]~iu", $ch);
        if($r){
            return $key;
        }
    }
        
    $r = preg_match("~[a-z]~i", $ch);
    if($r) return "en";
    
    $r = preg_match("~[0-9]~i", $ch);
    if($r) return "nu";
    
    return "et";
}


/**
* @desc convert hex color to rgb[a]
* @param string 색깔코드
* @param int 투명도
* @return string rgb[a]
* @link https://mekshq.com/how-to-convert-hexadecimal-color-code-to-rgb-or-rgba-using-php/
**/
function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
    if ($color[0] == '#' ) {
        $color = substr( $color, 1 );
    }

    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
    } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
    } else {
            return $default;
    }

    //Convert hexadec to rgb
    $rgb =  array_map('hexdec', $hex);

    //Check if opacity is set(rgba or rgb)
    if($opacity){
        if(abs($opacity) > 1)
            $opacity = 1.0;
        $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
    } else {
        $output = 'rgb('.implode(",",$rgb).')';
    }

    //Return rgb(a) color string
    return $output;
}


function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}