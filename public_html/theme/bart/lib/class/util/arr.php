<?php
namespace kr\bartnet\util;

class BArr{

	/**
	* @bref 배열에서 값이 없는 것들을 모두 날리고 리턴
	* @param &array $arr : 처리할 배열
	* @return
	**/
	public static function unsetblank(&$arr){
		
		foreach($arr as $key => $val){
			if(is_array($arr[$key])){
				self::unsetblank($arr[$key]);
			}else{
				if(trim($arr[$key])==''){
					array_splice($arr, $key, 1);
				}
			}
		}
	}

	/**
	* @bref 연관배열을 QueryString 으로 만든다
	* @param array $arr : QueryString으로 만들 배열
	* @return string : QueryString으로 만들어진 문자열
	**/
	public static function arrayToQuerystring($arr){
		if(!is_array($arr) || count($arr) <= 0) return;

		$temp = array();
		foreach($arr as $key=>$value){
			array_push($temp, $key.'='.$value);
		}
		return @implode("&", $temp);
	}
	
	public static function multiply($arr){
		$res = 1;
		foreach($arr as $k=>$v){
			$res *= $v;
		}
		return $res;
	}
	
	/**
	* @bref print_r
	* @param array $arr
	* @return
	**/
	public static function printr($arr){
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	
	/**
	* @bref 배열을 json으로
	* @param array
	* @return string
	**/
	public static function toJSON($data) {
		
		switch (gettype($data)) {
			case 'boolean':
				return $data?'true':'false';
			case 'integer':
			case 'double':
				return $data;
			case 'string':
				return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"', chr(10)=>"\\n", "\r"=>"\\n", "\t"=>"\\t", "\0"=>"", "\x0B"=>"")).'"';
			case 'object':
				$data = get_object_vars($data);
			case 'array':
				$rel = false;
				$key = array_keys($data);
				foreach ($key as $v){
					if (!is_int($v)){
						$rel = true;
						break;
					}
				}

				$arr = array();
				foreach ($data as $k=>$v) {
					$arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').self::toJSON($v);
				}

				return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
			default:
				return '""';
		}
	}
    
    public static function insert(&$array, $value, $index){
        return $array = array_merge(array_splice($array, max(0, $index - 1)), array($value), $array);
    }
    
    
    //깊은 array_map
    public static function bt_array_map($func, &$arr){
        if(!is_array($arr)) return;
        foreach($arr as $key=>$value){
            if(is_array($arr[$key])){
                bt_array_map($func, $arr[$key]);
            }else{
                $arr[$key] = call_user_func($func, $value);
            }
        }
        
        return $arr;
    }

}
