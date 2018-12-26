<?php
namespace kr\bartnet\file;

class BFiledir{

	/**
	* @bref 파일 이름과 확장자를 배열로 나눠서 리턴 (내장함수 pathinfo 를 사용했으나 한글이 제대로 안된다)
	* @param $file_name
	* return array
	**/
	public static function parseFilename($file_name){
		$arr = array();

		$pos = strrpos($file_name, '/');
		if($pos > -1)$file_name = substr($file_name, $pos+1);
		$pos = strrpos($file_name, '.');
		
		if(!$pos){
			return array(0=>$file_name, 1=>null, 'name'=>$file_name, 'extension'=>null);
		}

		$name = substr($file_name, 0, $pos);
		$extension = substr($file_name, $pos+1);
		$arr[0] = $name;
		$arr[1] = $extension;
		$arr['name'] = $name;
		$arr['extension'] = $extension;

		return $arr;
	}

	/**
	* @bref
	*   - 확장자 알아내기
	**/
	public static function getExtName($str){
		/*
		//구버전
		$pos = strpos($str, ".");
		if($pos > -1){
			return substr($str, $pos+1, strlen($str));
		}else return null;
		*/
		$cnt = preg_match("~.+\.([a-z0-9]+)$~i", $str, $mat);
		if($cnt > 0){
			return $mat[1];
		}
		return null;
	}

	/**
	* @bref
	*   - 지정한 풀경로 탐색하며 만들기
	**/
	public static function autoMkdir($dir, $perm=0755){
		//디렉토리생성
		$dir = str_replace('\\', '/', $dir);
		$arr = explode('/', $dir);
		$arrdir = array();
		
		for($i=0;$i<count($arr); $i++){
			
			if($arr[$i] == '.' || $arr[$i] == '..' || trim($arr[$i]) == ''){
				$arrdir[$i] = $arr[$i];
				continue;
			}
			
			$parent = implode('/', $arr);
			$arrdir[$i] = $arr[$i];
			$path = implode('/', $arrdir);
			
			try{
				if(!@is_dir($path)){
					
					//if(!is_writable($path)){
						//show_error(lang('cannot_create_directory').' - '.$path);
					//}
					
					if(!@mkdir($path, $perm, true))
						return false;
						//alert(
						//show_error(lang('filedir_cannot_createfile_perm').' - '.realpath($parent));
					
					if(!@chmod($path, $perm))
						return false;
						//show_error(lang('filedir_connot_changeperm').' - '.realpath($path));
				}
			}catch(Exception $e){}
//			exec('chmod -R 0707 '.$temp);
			
		}
		return @implode('/', $arrdir);
	}

	/**
	* @bref
	*   - 파일 내용 읽기
	**/
	public static function readFileContent($filepath, $mode='r'){
		$fp = fopen($filepath, $mode);
		$str = '';
		if(is_resource($fp)){
			while(!feof($fp)){
				$str .= fread($fp, 4096);
			}
			fclose($fp);
		}
		return $str;
	}
	
	/**
	* @bref 파일 쓰기
	**/
	public static function writeFileContent($filepath, $content, $mode='w+'){
		$fp = fopen($filepath, $mode);
		if(!fwrite($fp, $content)) return FALSE;
		fclose($fp);
		return TRUE;
	}

	/**
	* @bref
	*   - 파일용량을 단위별로 표시(2008. 6. 10)
	**/
	public static function getByteView($fs_size, $fs_decimal='', $tail_mark=''){
		$fs_temp = $fs_size;
		$fs_decimal = ($fs_decimal) ? $fs_decimal : 2;
		$fs_unit = Array(' ', ' K', ' M', ' G', ' T');
		for($i=0; $i<4; $i++, $fs_temp/=1024) if($fs_temp < 1024) break;
		$fs_number = explode('.', round($fs_temp, $fs_decimal));
		$fs_number[0] = number_format($fs_number[0]);
		return @implode('.', $fs_number) . $fs_unit[$i].$tail_mark;
	}

	/**
	* @bref
	*   - 지정한 디렉토리내의 파일 목록 반환
	*   - 모두:'a',폴더:'d',파일:'f'    ext:확장자필터
	**/
	public static function getDirEntry(&$result, $dir, $kind='a', $depth=0, $ext=''){
		
		static $cur_depth = 1;
		
		if(!is_dir($dir)) return;
		
		if(!($RD = opendir($dir))){
			return;
		}
				
		while($entry = readdir($RD)){
			if($entry != '.' && $entry != '..'){
				if($kind=='d'){
					if(is_dir($dir.'/'.$entry)){
						$result[] = $dir.'/'.$entry;
					}
				}else if($kind=='f'){
					if(is_file($dir.'/'.$entry)){
						if($ext){
							$temp = self::parseFilename($entry);
							if($temp['extension']==$ext){
								$result[] = $dir.'/'.$entry;
							}
						}else{
							$result[] = $dir.'/'.$entry;
						}
					}
				}else{
					$result[] = $dir.'/'.$entry;
				}
				
				if(($cur_depth < $depth || $depth <= 0) && is_dir($dir.'/'.$entry)){
					$cur_depth++;
					self::getDirEntry($result, $dir.'/'.$entry, $kind, $depth, $ext);
					$cur_depth--;
				}
			}
		}
		
		//sort($result);
		closedir($RD);
	}
    
    
    /**
    * @desc 디렉터리삭제(하위 디렉터리 및 파일 모두 삭제)
    * @param sring dirpath
    * @return void
    **/
    public static function rmdirAll($dir) {
        
        if (!file_exists($dir)) return;
        
        $dhandle = opendir($dir);
        
        if ($dhandle) {
            
            while ($fname = readdir($dhandle)) {
                
                if (($fname == '.') || ($fname == '..')) continue;
                
                if (is_dir( $dir.'/'.$fname )) {
                    
                    self::rmdirAll($dir.'/'.$fname);
                    
                } else {
                    unlink($dir.'/'.$fname);
                }
            }
        
            closedir($dhandle);
        }
        rmdir($dir);
    }
	
	/**
	* @bref 파일 퍼미션을 0707 형식으로 리턴한다
	* @return string
	**/
	public static function perm($path){
		return substr(sprintf('%o', $path), -4);
	}

}
