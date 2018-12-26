<?php
namespace kr\bartnet\util;

class BDateUtil{
	
	/**
	* @bref 날짜차이를 문자열로 리턴
	* @param string 'Y-m-d H:i:s'
	* @return string
	**/
	public static function getDateDiffToStr($strdate){
	
		$regdate = strtotime(substr($strdate, 0, 10));
		$regtime = strtotime($strdate);
		
		$nowdate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$nowtime = time();
		
		$difdate = $nowdate - $regdate;
		$diftime = $nowtime - $regtime;
		
		$day=round($difdate / 86400);
		
		if($day > 0){
			if($day == 1) $res = '어제';
			else if($day == 2) $res = '이틀 전';
			else $res = substr($strdate,0,10);
			
		}else{
			$hour = round($diftime / (60*60));
			if($hour > 0) $res = $hour.'시간 전';
			else{
				$min = round($diftime / 60);
				if($min) $res = $min.'분 전';
				else $res = $diftime.'초 전';
			}
		}
		return $res;
	}
	
}
