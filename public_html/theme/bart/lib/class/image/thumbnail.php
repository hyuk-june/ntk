<?php
/**
* @file BThumbnail.php
*
* @class BThumbnail
*
* @bref 썸네일 만들기

	필수 인클루드 : _es/helper/ImageUtil.php

	new BThumbnail(string 원본경로, string 저장경로, int 가로최대크기, int 세로최대크기, array 옵션)

	- 옵션 -

	transparent  :  바탕을 투명으로 (GD가 깨끗하게 생성해내지 못해 비추)

	bgcolor : 바탕색 (ffffff 형식)

	quaility : 1~100 (기본값 : 75)

	filter : png필터 (되는지 안해봤다. 귀찮음)

	sizefix : 고정크기 (나머지부분은 잘라낸다)

	crop_posx : 고정크기일때 가로 기준위치 (CROP_POSX_[LEFT|CENTER|RIGHT])

	crop_posy : 고정크기일때 세로 기준위치 (CROP_POSY_[TOP|MIDDLE|BOTTOM])

	watermark_path : 워터마크 경로

	watermark_pos : 워터마크 위치, 이미지를 9등분했을때의 위치 (WM_[LEFT|CENTER|RIGHT]_[TOP_MIDDLE_BOTTOM])

	watermark_padding : 이미지 가장자리에서 얼만큼 떨어져 출력할 것인가(기본값 : 5)


*
* @date 2011.03.24
*
* @author 권혁준(impactlife@naver.com)
*
* @copyright kbay.co.kr & Kwon Hyuk-June. All rights reserved.
*
* @section MODIFYINFO
* 	- 2011.03.31/권혁준
* 	- 정사각형 축소 오차 해결
*  	- 고정크기 추가
*  	- CROP 위치 계산 수정
*
* @section Example

	$img_path = "./_es/data/product/goods/w.jpg";

	$options = array(

		"transparent" => true,

		"bgcolor" => #ffffff,

		"quaility" => 90,

		"filter" => "",

		"sizefix" => true,

		"crop_posx" => BThumbnail::CROP_POSX_RIGHT,

		"crop_posy" => BThumbnail::CROP_POSY_MIDDLE,

		"quality" => 100,

		"watermark_path" => "./_es/adm/img/wm_horizon_t.png",

		"watermark_pos" => BThumbnail::WM_RIGHT_BOTTOM,

		"watermark_padding" => 10

	);

	$t = new BThumbnail($img_path, "", 300, 300, $options);

	$t->printScreen();


	★★★★★ 간편하게 하기 ★★★★★★

	Thumbnail::makeThumb(...) 파라미터는 해당 메쏘드 참조

*/

namespace kr\bartnet\image;

use kr\bartnet as bt;

class BThumbnail{

	// Crop 기준 위치
	const CROP_POSX_LEFT = 0;
	const CROP_POSX_CENTER = 1;
	const CROP_POSX_RIGHT = 2;
	const CROP_POSY_TOP = 3;
	const CROP_POSY_MIDDLE = 4;
	const CROP_POSY_BOTTOM = 5;

	// 워터마크 9 SLICE 위치
	const WM_LEFT_TOP = 0;      //좌상
	const WM_CENTER_TOP = 1;    //중상
	const WM_RIGHT_TOP = 2;     //우상
	const WM_LEFT_MIDDLE = 3;   //좌가운데
	const WM_CENTER_MIDDLE = 4; //중가운데
	const WM_RIGHT_MIDDLE = 5;  //우가운데
	const WM_LEFT_BOTTOM = 6;   //좌하
	const WM_CENTER_BOTTOM = 7; //중하
	const WM_RIGHT_BOTTOM = 8;  //우하

	//옵션 기본값
	private $options = array(
		"transparent" => false,
		"bgcolor" => "#ffffff",
		"quaility" => 90,
		"filter" => "",
		"sizefix" => false,
		"crop_posx" => bt\image\BThumbnail::CROP_POSX_LEFT,
		"crop_posy" => bt\image\BThumbnail::CROP_POSY_TOP,
		"quality" => 90,
		"watermark_path" => "",
		"watermark_pos" => bt\image\BThumbnail::WM_RIGHT_BOTTOM,
		"watermark_padding" => 10,
		"is_anigif_thumb" => false,
        "append_size" => true
	);

	private $src_path;
	private $save_path;
	private $max_w;
	private $max_h;
	private $image_type;
	private $thumb_w;
	private $thumb_h;
	private $dst_img;
	private $rate; //축소비율

	public function __construct($src_path, $save_path, $max_w, $max_h, $options=array()){
		
		foreach($options as $key => $value){
			$this->options[$key] = $value;
		}
		$this->src_path = $src_path;
		$this->save_path = $save_path;
		$this->max_w = $max_w;
		$this->max_h = $max_h;

		$this->build();
	}
	
	public function __destruct(){
		$this->options = null;
		$this->src_path = null;
		$this->save_path = null;
		$this->max_w = null;
		$this->max_h = null;
		$this->image_type = null;
		$this->thumb_w = null;
		$this->thumb_h = null;
		$this->dst_img = null;
		$this->rate = null;
		
		unset(
			$this->options,
			$this->src_path,
			$this->save_path,
			$this->max_w,
			$this->max_h,
			$this->image_type,
			$this->thumb_w,
			$this->thumb_h,
			$this->dst_img,
			$this->rate
		);
		
	}

	private function build(){


		//원본 불러오기
		$src_img = bt\image\BImageutil::imageCreateFromPath($this->src_path);

		//원본 크기 및 타입 구하기
		list($src_ow, $src_oh, $this->image_type) = bt\image\BImageutil::getImageSize($this->src_path);

		//고정폭이면
		if(trim($this->options["sizefix"])==true){

			$this->thumb_w = $this->max_w;
			$this->thumb_h = $this->max_h;

			$t_wrate = $this->thumb_w / $this->thumb_h;
			$t_hrate = $this->thumb_h / $this->thumb_w;
			$o_rate = $src_ow / $src_oh;

			$wres = $o_rate - $t_wrate;

			//원본 가로가 클때
			if($src_ow > $src_oh){
				if($wres > 0){
					$src_w = $src_oh * $t_wrate;
					$src_h = $src_oh;
				}else{
					$src_w = $src_ow;
					$src_h = $src_ow * $t_hrate;
				}
			//원본 세로가 클때
			}else{
				if($wres > 0){
					$src_w = $src_oh * $t_wrate;
					$src_h = $src_oh;
				}else{
					$src_w = $src_ow;
					$src_h = $src_ow * $t_hrate;
				}
			}
            
		//일반 축소이면
		}else{
			$src_w = $src_ow;
			$src_h = $src_oh;
			//썸네일 크기 비율대로 조정한 값, 비율값 얻기
			list($this->thumb_w, $this->thumb_h, $this->rate) = bt\image\BImageutil::rateLimit(
				$this->src_path, $this->max_w, $this->max_h
			);
		}

		if(trim($this->options["crop_posx"]) != ""){

			switch((int)$this->options["crop_posx"]){
			case self::CROP_POSX_LEFT:
				$src_x = 0;
				break;
			case self::CROP_POSX_CENTER:
				$src_x = $src_ow / 2 - $src_w / 2;
				break;
			case self::CROP_POSX_RIGHT:
				$src_x = $src_ow - $src_w;
				break;
			}
		}

		//세로 CROP옵션이 있고 세로가 가로보다 클때 (정사각형으로 만듬)
		if(trim($this->options["crop_posy"]) != ""){

			switch((int)$this->options["crop_posy"]){
			case self::CROP_POSY_TOP:
				$src_y = 0;
				break;
			case self::CROP_POSY_MIDDLE:
				$src_y = $src_oh / 2 - $src_h / 2;
				break;
			case self::CROP_POSY_BOTTOM:
				$src_y = $src_oh - $src_h;
				break;
			}
		}

		//빈이미지 생성(dst_img)
		$this->dst_img = bt\image\BImageutil::makeBlankImage(
			$this->thumb_w, $this->thumb_h,
			$this->options["bgcolor"], $this->options["transparent"]
		);


		//지정한 크기대로 dst_img에 복사
		imagecopyresampled(
			$this->dst_img, $src_img, 0, 0, $src_x, $src_y,
			$this->thumb_w, $this->thumb_h, $src_w, $src_h
		);
		
		imagedestroy($src_img);

		//워터마크 붙이기
		$this->pasteWatermark();
		
		//imagedestroy($this->dst_img); 다른곳에서 한다
	}

	//===========================================================================
	// 화면에 출력
	//===========================================================================
	public function printScreen(){
		bt\image\BImageutil::imageOutput($this->image_type, $this->dst_img, "",
			$this->options["quality"], $this->options["filter"]);
	}

	//===========================================================================
	// 파일에 저장
	//===========================================================================
	public function save(){
		bt\image\BImageutil::imageOutput($this->image_type, $this->dst_img, $this->save_path,
			bt\varset($this->options["quality"]), bt\varset($this->options["fileter"]));
	}

	//===========================================================================
	// 워터마크 만들기
	//===========================================================================
	public function pasteWatermark(){
		if(trim($this->options["watermark_path"])=="") return;
		if(!is_file($this->options["watermark_path"])) return;

		//워터마크 이미지 불러와서 축소하기
		$wm_img = bt\image\BImageutil::imageCreateFromPath($this->options["watermark_path"]);

		//썸네일 이미지리소스를 9등분으로 나눠서 좌표정보 얻기
		$info9 = bt\image\BImageutil::getInfo9($this->dst_img);

		//9등분중에서 선택한 해당구역의 좌표 얻기
		$item = $info9->items[$this->options["watermark_pos"]];

		//워터마크 실제 크기 구함
		list($wm_ow, $wm_oh) = getimagesize($this->options["watermark_path"]);

		//워터마크 크기가 썸네일 크기보다 크지 않도록 축소
		list($wm_w, $wm_h) = BImageutil::rateLimit(
			$this->options["watermark_path"], $this->thumb_w-50, $this->thumb_h-50
		);

		//워터마크 left 좌표 구하기
		if($item["align"]=="left"){
			$wm_x = $item["left"] + $this->options["watermark_padding"];
		}else if($item["align"]=="right"){
			$wm_x = $this->thumb_w - $wm_w - $this->options["watermark_padding"];
		}else{
			$wm_x = $this->thumb_w / 2 - $wm_w / 2;
		}

		//워터마크 top 좌표 구하기
		if($item["valign"]=="top"){
			$wm_y = $item["top"] + $this->options["watermark_padding"];
		}else if($item["valign"]=="bottom"){
			$wm_y = $this->thumb_h - $wm_h - $this->options["watermark_padding"];
		}else{
			$wm_y = $this->thumb_h / 2 - $wm_h / 2;
		}

		imagecopyresampled($this->dst_img, $wm_img,	$wm_x, $wm_y, 0, 0, $wm_w, $wm_h, $wm_ow, $wm_oh);

		//show_used_memory();
		
		imagedestroy($wm_img);

		unset($wm_img);
		unset($info9);
	}

	//===========================================================================
	// 썸네일 실제 싸이즈 리턴
	//===========================================================================
	public function getThumbSize(){
		return array(
			$this->thumb_w,
			$this->thumb_h,
			"thumb_w" => $this->thumb_w,
			"thumb_h" => $this->thumb_h
		);
	}

	//===========================================================================
	// 썸네일 간편 만들기
	//===========================================================================
	public static function makeThumb($src_path, $thumb_dir, $w, $h, $options=array()){
        
		$temp  = bt\file\BFiledir::parseFilename($src_path);
		$fname = $temp["name"];
		$ext   = $temp["extension"];
        
        $arr = null;

		//원본파일이 없으면
		if($fname!="" && is_file($src_path)){
			//애니메이션 GIF이면 원본그대로
			if(bt\image\BImageutil::isAnimatedGif($src_path) && $options['is_anigif_thumb']==false){
				list($t_w, $t_h) = BImageutil::rateLimit($src_path, $w, $h);
				$filename = $fname.'.'.$ext;
				$arr = array(
					$fname.'.'.$ext,
					$t_w,
					$t_h,
					'filename'	=> $filename,
					'width'		=> $t_w,
					'height'	=> $t_h
				);
				
			//애니메이션이 아니면
			}else{
                if($options['append_size'] == true){
            	    $filename = 'thumb-'.$fname."_".$w."_".$h.".".$ext;
                }else{
                    $filename = 'thumb-'.$fname.".".$ext;
                }

				$thumb_path = $thumb_dir."/".$filename;
				
				bt\file\BFiledir::autoMkDir($thumb_dir, 0755);

				//썸네일이 존재하지 않으면
				if(!is_file($thumb_path)){
					$t = new bt\image\BThumbnail($src_path, $thumb_path, $w, $h, $options);
					$t->save();
					list($t_w, $t_h) = $t->getThumbSize();
				
				//썸네일이 존재하면
				}else{
					list($t_w, $t_h) = bt\image\BImageutil::getImageSize($thumb_path);
				}

				$arr = array(
					$filename,
					$t_w,
					$t_h,
					"filename" => $filename,
					"width" => $t_w,
					"height" => $t_h
				);
			}
		}

		return $arr;
	}
}

