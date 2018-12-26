<?php
/**
* @file BTError.php
*
* @class BTError
*
* @bref 에러 핸들러
* 
* @date 2012
*
* @author 권혁준(impactlife@naver.com)
*
* @copyright kbay.co.kr. & Kwon Hyuk-June. All rights reserved.
*
* @section MODIFYINFO
* 	- 없음/없음
*
* @section Example
*   - 없음
*/
namespace kr\bartnet\system;

class BError{
	/**
	* @bref 에러 핸들러 (클래스 에러는 호출순서대로 다 뿌려줘야 디버깅이 편하기 때문에 핸들러를 직접지정함)
	* @param int $errno 에러번호
	* @param string $errstr 에러메세지
	**/
	public function showError($errno, $errstr){
		
		//지정한 에러리포팅 모드가 아니면 return
		if(!(error_reporting() & $errno)){
			return;
		}
		
		if(BT_DEBUG){
			
            //echo "<!doctype html><html><body>".PHP_EOL;
            
            echo "Errno: ".$errno."<br>".PHP_EOL;
            echo "Message: ".$errstr."<br>".PHP_EOL;
            echo PHP_EOL.PHP_EOL;
            
            /*
			echo "<!doctype html><html><body>";
			echo "<div style='margin:5px auto; width:90%'>";
			echo "<h2 style='color:#f00'>OOPS! An error has occurred!</h2>";
			echo "<table style='border:2px solid #aaa; border-collapse:collapse; width:100%'>";
			echo "<col width='150'><col>";
			echo "<tbody>";
			echo "<tr><th style='border:1px solid #aaa'>Error Code</th><td style='border:1px solid #aaa'>".$errno."</td></tr>";
			echo "<tr><th style='border:1px solid #aaa'>Description</th><td style='border:1px solid #aaa'>".$errstr."</td></tr>";
			echo "</tbody>";
			echo "</table>";
            */
			
			$debug = debug_backtrace();
			
			//echo "<h3>Back Trace File List</h3>".PHP_EOL;

			//깊이가 1이면 인덱스 0부터
			//$sidx = count($debug) > 1 ? 1 : 0;
			$sidx = 0;
			
			for($i=$sidx;$i<count($debug);$i++){

                /*
				echo "<fieldset style='margin:5px 0;border:1px solid #aaa;padding:5px'>";
				echo "<legend style='position:relative;line-height:100%;font-size:14px;display:block;width:auto;height:auto;text-indent:0px;overflow:none'>Depth. ".$i."</legend>";
				echo "File : ".$debug[$i]["file"]." (Line : ".$debug[$i]["line"].")<BR>";
                */
                
                echo "Depth: ".$i."<br>".PHP_EOL;
                echo "File: ".$debug[$i]["file"]." (Line : ".$debug[$i]["line"].")<br>".PHP_EOL;
				
				if($i > 0) echo "Function : ".$debug[$i]["function"]."<BR>".PHP_EOL;
				
				if($debug[$i]["class"]!="")echo "Class : ".$debug[$i]["class"]."<BR>".PHP_EOL;
				
				//echo "</fieldset>";
                echo PHP_EOL.PHP_EOL;
			}
			echo "</div>".PHP_EOL;
			echo "</body><html>".PHP_EOL;
			
 			
 			die();
		}else{
			echo "<!doctype html><html><body>";
			echo "<p>에러가 발생했습니다</p>";
			echo "</body></html>";
		}
	}
	
	public static function getInstance(){
		static $inst;
		if(empty($inst)) $inst = new BError();
		return $inst;
	}
}