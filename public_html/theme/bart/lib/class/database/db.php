<?php
/**
* @file DB.php
*
* @class Database, DB
*
* @bref SQL Query 보조클래스 (자주 쓰는 쿼리문 자꾸 쓰기 짜증나서 만듬)
* 
* @date 2013.12.
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

namespace kr\bartnet\database;

use \kr\bartnet as bt;

if(!function_exists("sql_errno")){
function sql_errno(){
    global $connect_db;
    if(function_exists('mysqli_errno') && G5_MYSQLI_USE) {
        return mysqli_errno($connect_db);
    }else{
        return mysql_errno($connect_db);
    }
}}

class BDb{
	
	private $debug = false;
	private $query_view;
	
	/**
	* @bref 문자열일경우 query를 실행해서 리소스로 리턴
	* @param mixed $var
	* @return resource
	**/
	protected function getResource($var){
		if(!is_resource($var) && !is_object($var)) $var = $this->query($var);
		return $var;
	}
	
	/**
	* @bref 쿼리문을 보이게 함(디버그용)
	* @param boolean $b
	**/
	public function showQuery($b){
		$this->query_view = $b;
	}
	
	/**
	* @bref 디버그 모드 세팅 (단지 에러가 나면 뿌린다)
	* @param boolean $b
	**/
	public function setDebug($b){
		$this->debug = $b;
	}
		
	/**
	* @bref 배열의 값을 escape시키고 쿼리문으로 만듬( $key의 첫번째 문자가 ':' 이면 따옴표 안침)
	* @param array $arr
	* @return string
	**/
	public function arrToStr($arr){
		$temp = array();
		foreach($arr as $key => $val){
			if(substr($key,0,1)==':') $temp[] = substr($key, 1).'='.escape_trim($val);
			else $temp[] = $key."='".escape_trim($val)."'";
		}
		return @implode(", ", $temp);
	}
	
	/**
	* @bref 쿼리 실행
	* @param string $sql
	* @return resource
	**/
	public function query($sql){
		if($this->query_view) echo '<p>'.$sql.'</p>';
		$res = sql_query($sql, $this->debug);
		if(!$res) $this->error(sql_errno(), sql_error_info(), $sql);
		return $res;
	}
	
	/**
	* @bref 에러처리
	* @param int $errno
	* @param string $errmsg
	* @param string $sql
	**/
	private function error($errno, $errmsg, $sql){
		if($this->debug){
			$errmsg .= '<p style="font-weight:bold">::SQL::</p><p style="color:#FC6727">'.$sql.'</p>';
			BTError::getInstance()->showError($errono, $errmsg);
		}
	}

	/**
	* @bref mysql_fetch_assoc
	* @param mixed $var
	* @return array
	**/	
	public function fetch($var){
		$var = $this->getResource($var);
		return sql_fetch_array($var);
	}
	
	/**
	* @bref mysql_result
	* @param int $i
	* @param int $j
	* @return mixed
	**/
	/*public function result($var, $i=0, $j=0){
		$var = $this->getResource($var);
		return sql_query($var, $i, $j);
	}*/
	
	/**
	* @bref mysql_insert_id();
	* @return int
	**/
	public function insertId(){
		return sql_insert_id();
	}
	
	/**
	* @bref mysql_affected_rows
	* @return int
	**/
	public function affectedRow(){
		global $g5;

		if(!$link)
			$link = $g5['connect_db'];

		$rows = 0;
		if(function_exists('mysqli_affected_rows') && G5_MYSQLI_USE)
			$rows = mysqli_affected_rows($link);
		else
			$rows = mysql_affected_rows($link);
			
		return $rows;
	}
	
	public function fieldLen($result){
		global $g5;

		if(!$link)
			$link = $g5['connect_db'];
		
		$len = 0;
		if(function_exists('mysqli_field_len') && G5_MYSQLI_USE)
			$len = mysqli_field_count($link);
		else
			$len = mysql_field_len($link);
			
		return $len;
	}
	
	/**
	* @bref mysql_num_rows
	* @param mixed $var
	* @return int
	**/
	public function rowCount($var){
		$var = $this->getResource($var);
		return sql_num_rows($var);
	}
	
	/**
	* @bref Insert
	* @param string $table
	* @param array $arr
	* @return resource
	**/
	public function insert($table, $arr){
		$sql = "INSERT INTO ".$table." SET ".$this->arrToStr($arr);
		return $this->query($sql);
	}
	
	/**
	* @bref Update
	* @param string $table
	* @param array $arr
	* @param string $where
	* @return resource
	**/
	public function update($table, $arr, $where){
		$sql = "UPDATE ".$table." SET ".$this->arrToStr($arr)." WHERE ".$where;
		return $this->query($sql, true);
	}
	
	/**
	* @bref Delete
	* @param string $table
	* @param string $where
	* @return resource
	**/
	public function delete($table, $where){
		$sql = "DELETE FROM ".$table." WHERE ".$where;
		return $this->query($sql);
	}
	
	/**
	* @bref 모두 fetch_array 해서 배열에 담음
	* @param [string|resource] $var
	* @return array
	**/
	public function fetchAll($var){
		
		$list = array();
		$var = $this->getResource($var);
	    while($row = $this->fetch($var)){
	    	$list[] = $row;
	    }
	    return $list;
	}
	
	/**
	* @bref 쿼리 실행 후 결과를 모두 fetch - 첨자를 뒤집어서 리턴한다
	* @param [string|resource] $var
	* @return array
	**/
	/*
	public function fetchAllReverse($var){
		$list = Array();
		$var = $this->getResource($var);
		$fcnt = sql_field_len($var);
		for($i=0; $row = $this->fetch($var); $i++){
			for($j=0; $j<$fcnt; $j++){
				$field = sql_field_name($var, $j);
				$list[$field][$i] = $row[$field];
			}
		}
		return $list;
	}
	*/
	
	/**
	* @bref escape (그누보드 함수에게 맡긴다)
	* @param mixed $param
	* @return string
	**/
	public function esc($param){
		return escape_trim($param);
	}
	
	/**
	* @bref 배열을 모두 escape
	* @param &array $arr
	**/
	public function escapeAll(&$arr){
		foreach($arr as $key => $val){
			if(is_array($val)){
				$this->escapeAll($arr[$key]);
			}else{
				$arr[$key] = $this->esc($val);
			}
		}
	}
	
    /**
    * @bref 싱글턴
    * @return Bdb
    **/
	public static function getInstance(){
		static $inst;
		if(empty($inst)) $inst = new BDb();
		
		return $inst;
	}
}