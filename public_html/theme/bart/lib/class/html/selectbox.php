<?php
/**
* @file SelectBox.php
*
* @class SelectBox
*
* @bref select 박스 출력
*
* @date 2009
*
* @author 권혁준(impactlife@naver.com)
*
* @copyright kbay.co.kr. All rights reserved.
*
* @section MODIFYINFO
* 	- 2011.03.03/권혁준 : getOption 추가(select태그와 분리)
* 	- 2012.11.30/권혁준 : clear 추가
*   - 2013.12.23/권혁준 : selectedIndex 초기화값 null 에서 -1로 변경(버그 있었음)
*
* @section Example
*
  $sb = new SelectBox();

  $sb->selectedIndex = 3; // 또는 $sb->selectedIndexFromValue = 'mb_level';

  $sb->add(1, '1레벨');

  $sb->add(2, '2레벨');

  $sb->add(3, '3레벨');

  //select 태그 포함할때

  $leveltag = $sb->getTag('skey', "class='select' id='skey'");

  //option 태그만 필요할때
  
  $leveloption = $sb->getOption();
*/

namespace kr\bartnet\html;

class BSelectbox{

	public $selectedIndex = -1;
	public $selectedFromValue = '';
	private $option = array();

	public function __get($name){
		try{
			$this->checkProperty($name);
			return $this->$name;
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function __set($name, $value){
		try{
			$this->checkProperty($name);
			$this->$name = $value;
		}catch(Exception $e){
			echo $e->getMessage();
		}
	}
    
	public function add($value, $text){
		$this->option[(string)$value] = $text;
	}

	/**
	* @bref select 태그 포함
	**/
	public function getTag($name="", $attr=""){
		$str  = "<select name='".$name."' ".$attr.">\n";
		$str .= $this->getOption();
		$str .= "</select>\n";
		return $str;
	}
	
	public function clear(){
		$this->option = array();
	}

	/**
	* @bref 옵션만
	**/
	public function getOption(){
		$i = 0;
		$str = '';
		foreach($this->option as $key=>$value){
			if((int)$this->selectedIndex == $i)
				$selected = " selected='selected'";
			else if((string)$this->selectedFromValue == (string)$key) $selected = " selected='selected'";
			else $selected = "";
			$str .= "<option value='".$key."'".$selected.">".$value."</option>\n";
			$i++;
		}
		return $str;
	}

	private function checkProperty($name){
		if(!property_exists(__CLASS__, $name)){
			throw new Exception('존재하지 않는 Property['.$name.']를 호출하였습니다<br />');
		}
	}
}