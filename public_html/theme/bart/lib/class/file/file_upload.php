<?php
/**
* @file FileUpload.php
*
* @class FileUpload
*
* @bref 파일업로드 클래스
*
* @date 만든날짜가 기억이 안남 한... 2007년쯤?
*
* @author 권혁준(impactlife@naver.com)
*
* @copyright kbay.co.kr & Kwon Hyuk-June. All rights reserved.
*
* @section MODIFYINFO
* 	- 2011-03-16/권혁준 : 대대적인 업데이트 (param 배열을 인수로 넘어가게 함)
*
* @section EXAMPLE
*	NAME_ORGINAL_[...] 는 한글파일일때 서버 사정에 따라 문제가 발생할 수 있으므로 권장하지 않는다.
*
*	[폼의 file 필드 이름이 photo 일때]\n
	$fu = new FileUpload();\n
	$param = array(\n
		"mkdir" => true,                    //디렉토리가 없으면 만들것인가\n
		"updir" => "./test",                //업로드 디렉토리\n
		"field" => "photo",                 //폼 필드 이름\n
		"naming" => FileUpload::NAME_AUTO,  //실제파일명변경 규칙[NAME_ORGINAL_NUMERIC | NAME_ORIGINAL_OVERLAP | NAME_FORCE]
		"force_name" => "aaa.jpg",          //NAME_FORCE 일때 강제 지정 이름\n
		"limit_size" => 1024*1024*10,       //제한 용량\n
		"limit_width" => 30,                //가로 제한 픽셀\n
		"limit_height" => 50,               //세로 제한 픽셀\n
		"allow_ext" => "jpg|png",           //허용하는 확장자\n
		"toboo_ext" => "exe|sh",            //불가한 확장자\n
	);\n

  $info = $fu->add($param);               //세팅된 파일 정보들 배열로 리턴(DB에 입력하는 등의 용도)\n
*
*	$fu->upload();                          //실제 업로드\n
*	$res = $fu->getResult()\n
*	if(!$res->success)\n
*		echo "에러 : ".$res->message\n
*	}\n
*
*	[폼의 file 필드 이름이 photo 이고 배열일때]\n
*	$info = array();\n
*	$fu = new FileUpload();\n
*	for($i=0;$i<count($_FILES["photo"]["name"]);$i++){\n
*		$param = array(\n
*			"mkdir" => true,\n
*			"updir" => "./test",\n
*			"field" => "photo",\n
*			"naming" => FileUpload::NAME_AUTO,\n
*			"force_name" => "aaa.jpg",\n
*			"limit_size" => 1024*1024*10,\n
*			"limit_width" => 30,\n
*			"limit_height" => 50,\n
*			"allow_ext" => "jpg|png",\n
*			"toboo_ext" => "exe|sh",\n
*			"index" => $i                  //인덱스 번호\n
*		);\n
*
*		$info[] = $fu->add($param);\n
*	}\n
*	$fu->upload();\n
*	$res = $fu->getResult();\n
*	if(!$res->success){\n
*		echo "에러 : ".$res->message\n
*	}\n
*
*
*/

namespace kr\bartnet\file;

use kr\bartnet as bt;

class BFileUpload{

	const NAME_AUTO = 0;      //이름 자동생성 (날짜 시간 랜덤수등으로)
	const NAME_ORIGINAL_OVERLAP = 1;  //파일의 원래 이름으로 등록하고 중복될 경우 덮어씀
	const NAME_ORIGINAL_NUMERIC = 2;  //파일의 원래 이름으로 등록하나 중복될 경우 뒤에 "_숫자" 를 붙임
	const NAME_FORCE 			= 3;  //force_name 항목에 지정된 문자열로 이름을 강제 지정(확장자 고려안함)
	const NAME_FORCE_ADDEXT		= 4;  //force_name 항목에 지정된 문자열로 이름을 강제 지정(확장자는 업로드 파일에 따라 달라짐)

	private $FILELIST = array();
	
	public function __construct(){
	}

	/**
	* @bref 항목 추가
	**/
	public function add($param){
		
		//업로드 디렉토리의 마지막 문자에 "/" 제거
		$param["updir"] = rtrim($param['updir'],"/");

		$FILE = array();
		$field = $param["field"];
		if(isset($param['index'])){
			
			$arr_key = $param['index'];
			if((int)bt\varset($_FILES[$field]['size'][$arr_key]) <= 0) return;
			
			$arr_key = $param['index'];
			
			$parse_name = BFiledir::parseFilename($_FILES[$field]['name'][$arr_key]);
			$param["strip_name"] = $parse_name["name"];
			$param["extension"] = $parse_name["extension"];

			$FILE['param'] = $param;
			$FILE['tmp_name'] = $_FILES[$field]['tmp_name'][$arr_key];
			$FILE['name'] = $_FILES[$field]['name'][$arr_key];
			$FILE['size'] = $_FILES[$field]['size'][$arr_key];
			$FILE['type'] = $_FILES[$field]['type'][$arr_key];
			$FILE['error'] = $_FILES[$field]['error'][$arr_key];
			$FILE['updir'] = $param["updir"];
			$FILE['rname'] = $this->getRealFileName($FILE);
			$FILE['extension'] = strtolower($param['extension']);
			$FILE['mkdir'] = $param['mkdir'];
			list($FILE['width'], $FILE['height']) = $this->getImgSize($FILE);

		}else{
			
			if((int)bt\varset($_FILES[$field]['size']) <= 0) return;
			
			$parse_name = BFiledir::parseFilename($_FILES[$field]['name']);
			$param["strip_name"] = $parse_name["name"];
			$param["extension"] = $parse_name["extension"];

			$FILE['param'] = $param;
			$FILE['tmp_name'] = $_FILES[$field]['tmp_name'];
			$FILE['name'] = $_FILES[$field]['name'];
			$FILE['size'] = $_FILES[$field]['size'];
			$FILE['type'] = $_FILES[$field]['type'];
			$FILE['error'] = $_FILES[$field]['error'];
			$FILE['updir'] = $param["updir"];
			$FILE['rname'] = $this->getRealFileName($FILE);
			$FILE['extension'] = strtolower($param['extension']);
			$FILE['mkdir'] = $param["mkdir"];
			list($FILE['width'], $FILE['height']) = $this->getImgSize($FILE);

		}
		
		array_push($this->FILELIST, $FILE);
		return $FILE;
	}

	/**
	* @bref 이미지 사이즈 구하기
	**/
	private function getImgSize($FILE){
		$arr = array(0,0);
		if(strstr($FILE["type"], "image")==true){
			list($arr[0], $arr[1]) = getimagesize($FILE["tmp_name"]);
		}
		return $arr;
	}

	/**
	* @bref ADD 된 모든 파일의 정보
	**/
	public function getFileList(){
		return $this->FILELIST;
	}

	/**
	* @bref 업로드
	**/
	public function upload(){
		try{
			//유효성 검사
			foreach($this->FILELIST as $item){
				$this->checkDir($item);
				$this->checkLimitPixel($item);
				$this->checkLimitSize($item);
				$this->checkAllowExt($item);
				$this->checkDenyExt($item);
			}

			//실제 업로드
			for($i=0;$i<count($this->FILELIST);$i++){
				$res = move_uploaded_file(
					$this->FILELIST[$i]['tmp_name'],
					$this->FILELIST[$i]['updir']."/".
					$this->FILELIST[$i]['rname']
				);

				if(!$res) throw new \Exception(
					"파일 업로드 실패 - ".$this->FILELIST[$i]["name"]
				);
			}
			
		}catch(\Exception $e){
			throw $e;
		}
	}

	/**
	* @bref 디렉토리 체크
	**/
	private function checkDir($FILE){
		if(!is_dir($FILE['updir'])){
			if($FILE["mkdir"]){
				BFiledir::autoMkDir($FILE['updir'], 0755);
			}else{
				throw new \Exception("디렉터리 생성 실패 - ".$FILE["updir"]);
			}
		}
	}

	/**
	* @bref 픽셀크기 검사
	**/
	private function checkLimitPixel($FILE){
		
		$param = $FILE["param"];

		if(strstr($FILE["type"], "image") == FALSE){
			return;
			//throw new Exception(lang('fileupload_not_image'));
		}

		if(isset($param['limit_width']) && (double)$param["limit_width"] > 0 &&
		(double)$FILE["width"] > (double)$param["limit_width"]){
			throw new \Exception('이미지 가로크기 초과'
				.' '.number_format($param["limit_width"])
				.' - FileName : '.$FILE["name"]
			);
		}
		if(isset($param['limit_height']) && (double)$param["limit_height"] > 0 &&
		(double)$FILE["height"] > (double)$param["limit_height"]){
			throw new \Exception('이미지 세로크기 초과'
				.' '.number_format($param["limit_height"])
				.' - FileName : '.$FILE["name"]
			);
		}
	}

	/**
	* @bref 제한 용량 검사
	**/
	private function checkLimitSize($FILE){

		$param = $FILE["param"];

		if(isset($param['limit_size']) && (double)$param["limit_size"] > 0 &&
		(double)$FILE["size"] > (double)$param["limit_size"]){
			throw new \Exception('파일용량 초과'
				.' '.number_format($param["limit_size"])
				.' - FileName : '.$FILE["name"]
			);
		}
	}

	/**
	* @bref 허용된 확장자인지 검사
	**/
	private function checkAllowExt($FILE){

		$param = $FILE["param"];
		if(!isset($param['allow_ext']) || trim($param['allow_ext'])=='') return;
		
		if(!bt\isval($param["allow_ext"])) return;
		$aext = explode("|", trim(strtolower($param["allow_ext"])));
		if(count($aext) <= 0) return;
		
		if(!in_array(strtolower($param['extension']), $aext)){
			throw new \Exception('업로드 가능한 파일은 다음과 같습니다'
				.' '.str_replace("|", ", ",	$param['allow_ext'])
				.'- FileName : '.$FILE["name"]
			);
		}
	}

	/**
	* @bref 제한된 확장자인지 검사
	**/
	private function checkDenyExt($FILE){

		if(!isset($param["deny_ext"]) || trim($param['deny_ext'])=='') return;
		$adeny = explode("|", trim(strtolower($param["deny_ext"])));
		if(count($adeny) <= 0) return;

		/*
		// 아파치 MultiView 옵션이 true 일경우 보안취약점이 발생함
		if(count($aDeny) <=0) return;
		$temp = BFiledir::extractFileName($fname);
		if(in_array($temp['ext'], $aDeny)){
			$isDeny = true;
		}
		*/
		/*
		업데이트 : 2010.12.09
		MultiView 보안문제점 때문에 파일이름 전체에 확장자가 속해 있는지 검사
		xxx.php.ko, xxx.php.jp  등의 업로드 방지
		실제 금지 확장자는 외부에서 세팅해야 함
		*/
		//TODO: mime type 으로 변경해야 할것 같다.

		foreach($adeny as $key=>$value){
			if(strstr($FILE["rname"], ".".$value)){
				throw new \Exception(
					'허용되지 않는 파일입니다'
					.' '.$value
					.' - FileName : '.$FILE["name"]
				);
			}
		}
	}

	/**
	* @bref 파일 실제이름 만들기
	**/
	private function getRealFileName($FILE){

		$ret = "";

		$param = $FILE["param"];

		switch($param["naming"]){

			case self::NAME_ORIGINAL_OVERLAP :
				$ret = $FILE["name"];
				break;

			case self::NAME_ORIGINAL_NUMERIC :
				$ret = $param["strip_name"].".".$param["extension"];
				$i = 1;
				while(is_file($param["updir"]."/".$ret)){
					$ret = $param["strip_name"]."_".($i++).".".$param["extension"];
				}
				break;

			case self::NAME_FORCE :
				if(!bt\isval($param["force_name"])){
					throw new \Exception('파일이름이 지정되지 않았습니다');
				}
				$ret = $param["force_name"];
				break;
				
			case self::NAME_FORCE_ADDEXT :
				if(!bt\isval($param["force_name"])){
					throw new \Exception('파일이름이 지정되지 않았습니다');
				}
				$ret = $param["force_name"].".".$param["extension"];
				break;

			default : // NAME_AUTO
				//time과 shuffle로 이름만듦
				$temp = str_split(sprintf("%05s", mt_rand(10000, 99999)), 1);
				shuffle($temp);
				$temp = @implode("", $temp);
				$ret = date("Ymd_His_").$temp.".".$param["extension"];
		}
		return $ret;
	}
}
