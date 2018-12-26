<?php
namespace kr\bartnet\system;

interface BIEventDispatcher{
	
	public function addEventListener($eventname, $method, $object=null);
	public function dispatchEvent($eventname);
	public function existCallback($eventname);
	
}

abstract class BEventDispatcher{

    private $starr = array();

    public function __construct(){}
    
    public function __destruct(){
		$this->starr = null;
		unset($this->starr);
    }

    /**
    * @bref 메쏘드 또는 함수 등록
    **/
    public function addEventListener($eventname, $method, &$object=null){
        array_push($this->starr, array("eventname"=>(string)($eventname), "method"=>(string)$method, "object"=>$object));
    }
    
    public function setEventListener($eventname, $method, &$object=null){
    	$this->starr = array(
    		array("eventname"=>(string)($eventname), "method"=>(string)$method, "object"=>$object)
    	);
	}

    /**
    * @bref 콜백 실행
    **/
    public function dispatchEvent($eventname/*,...*/){
    	
        $args = func_get_args();
        array_shift($args); //첫번째 인자인 eventname는 args에서 제외시킨다

        for($i=0;$i<count($this->starr);$i++){
        	$eventname = (string)$eventname;
        	if($this->starr[$i]["eventname"]==$eventname){
			$func = null;

        		if(is_object($this->starr[$i]["object"])){
				$func = array($this->starr[$i]["object"], $this->starr[$i]["method"]);
        		}else{
        			$func = $this->starr[$i]["method"];
        		}

			if(count($args) > 0){
				call_user_func_array($func, $args);
			}else{
				call_user_func($func);
			}

        	}
        }
    }

    /**
    * @bref 해당 콜백이 등록되어 있는지 검사
    **/
    public function existCallback($eventname){

    	$eventname = (string)$eventname;
    	
    	for($i=0;$i<count($this->starr);$i++){
    		if($this->starr[$i]["eventname"]==$eventname && isset($this->starr[$i]["method"])){
    			return true;
    		}
    	}
    	return false;
    }
}