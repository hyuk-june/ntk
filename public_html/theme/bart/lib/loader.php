<?php
/**
* @file Loader.php
*
* @class Loader
*
* @bref BART 빌더 파일 로더
* 
* @date 2013
*
* @author 권혁준(impactlife@naver.com)
*
* @copyright kbay.co.kr & Kwon Hyuk-June. All rights reserved.
*
* @section MODIFYINFO
* 	- 없음/없음
*
* @section Example
*   - 없음
*/
namespace kr\bartnet;

class BLoader{
	
	public static $classes = array();
	//public static $instance = array();

	/**
	* @bref 클래스 이름과 경로를 직접 지정하여 autoload 타겟으로 지정함
	* @param string $class
	* @param string $path
	**/
	public static function regist($class, $path){
		self::$classes[$class] = $path;
	}
	
	public static function upper($mat){
		return strtoupper($mat[1]);
	}
	
	/**
	* @bref 해당 디렉토리안의 파일들 모두 autoload 타겟으로 지정함
	* @param string $dirpath
	**/
	public static function registAll($dirpath){
		try{
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($dirpath),
				\RecursiveIteratorIterator::SELF_FIRST
			);
			
			foreach ($iterator as $file){
				$filename = $file->getFilename();
                
				$ext = strtolower( substr($filename, strrpos($filename, '.')+1) );
				if(!$file->isFile() || $ext != 'php') continue;
                
                $dirname = str_trim(dirname($file->getPathName()), BT_LIB_PATH.'/class/');
                
                $ns = 'kr\\bartnet\\'.str_replace('/','\\', $dirname);
				
				$class = 'B'.ucfirst( substr($filename, 0, strrpos($filename, '.')) );
				$class = preg_replace_callback("~_([a-z])~", 'self::upper', $class);
                
				self::$classes[$ns.'\\'.$class] = $file->getPath().DS.$filename;
			}
            
		}catch(UnexpectedValueException $e){
			//TODO
		}
	}
	
	/**
	* @bref autoload 프로시저
	**/
	public static function autoload($classname){
		//$classname = basename(str_replace('\\', '/', $classname));
		if(!array_key_exists($classname, self::$classes)){
			\kr\bartnet\system\BError::getInstance()->showError(0, 'class '.$classname.' not registed in BLoader');
		}else if(!file_exists(self::$classes[$classname])){
			die($classname.'.php is not exist');
		}

		@include_once(self::$classes[$classname]);
	}
	
	/**
	* @bref autoload 프로시저 지정
	**/
	public static function autoloadSetup(){
		spl_autoload_register(array(self, 'autoload'));
	}
	
	/**
	* @bref 경로 직접 지정해 등록하기
	* @param string $classpath 경로
	**/
	/*
	public static function pathImport($classpath){
		list($dir, $class, $path) = self::parseClassPath($classpath);
		//$path = G5_PATH.DS.self::getTypeDir($type).DS.$dir.DS.$mctype.DS.$path;
		self::regist($class, $path);
	}
	*/
	
	/**
	* @bref 경로 파싱
	* @param string $classpath 클래스 경로
	* @return array $arr
	**/
	/*
	public static function parseClassPath($classpath){
		$arr = array();
		$temp = explode('.', $classpath);
		$arr['dir'] = @implode(DS, $temp);
		$arr['class'] = array_pop($temp);
		$arr['path'] = $arr['dir'].DS.$arr['class'].'.php';
		return $arr;
	}
	*/
}
