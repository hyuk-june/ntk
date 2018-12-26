<?php
namespace kr\bartnet\util;

use kr\bartnet as bt;

class BResult{
    
    protected $result = array(
        "success" => false,
        "data" => null,
        "message" => "",
        "code" => ""
    );
    
    protected function setResult($success, $data=null, $message="", $code=""){
        $this->result["success"] = $success;
        $this->result["data"] = $data;
        $this->result["message"] = $message;
        $this->result["code"] = $code;
    }
    
    public function error($message, $data=null, $code=""){
        $this->setResult(false, $data, $message, $code);
        return (Object)$this->result;
    }
    
    public function success($data=null, $message="", $code=""){
        $this->SetResult(true, $data, $message, $code);
        return (Object)$this->result;
    }
    
    public static function getInstance(){
        static $inst = null;
        if(is_null($inst)) $inst = new BResult();
        return $inst;
    }
}