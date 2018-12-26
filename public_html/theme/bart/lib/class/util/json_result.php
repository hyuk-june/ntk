<?php
namespace kr\bartnet\util;

class BJsonResult{
	
	private $result = array(
		"success" => false,
		"data" => null,
		"message" => "",
		"code" => ""
	);
	
	public function error($msg, $data=null, $code=""){
		$this->result["success"] = false;
		$this->result["data"] = $data;
		$this->result["message"] = $msg;
		$this->result["code"] = $code;
		return $this->toJson();
	}
	
	public function success($data=null, $msg="", $code=""){
		$this->result["success"] = true;
		$this->result["data"] = $data;
		$this->result["message"] = $msg;
		$this->result["code"] = $code;
		return $this->toJson();
	}
	
	private function toJson(){
		// 한글을 \uc23948 식으로 바꾸기 때문에 안쓰려고...
		//if(phpversion() > "5.2.0"){
		//	return json_encode($this->result);
		//}else{
			return BArr::toJSON($this->result);
		//}
	}
}