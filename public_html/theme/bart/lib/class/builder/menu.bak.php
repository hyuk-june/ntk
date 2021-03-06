<?php
/**
* @file Menu.php
*
* @class Menu
*
* @bref 메뉴 모델
*
* @date 2013.12.
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

class BMenu{
	
	private $table;
	/* @var Bdb */
	private $db;
	
	public function __construct(){
		$this->table = BT_PREFIX.'menu';
		$this->db = BDb::getInstance();
	}
	
	private function getRow($where){
		$sql = "SELECT * FROM ".$this->table." WHERE ".$where;
		return $this->db->fetch($sql);
	}
	
	/**
	* @bref $data_list 데이타를 $res_array에 리스트 구조로 담기
	* @param array $res_array 결과담을 배열
	* @param array $data_list 데이타담긴 배열
	* @param string $pidx 부모노드 번호
	* @return
	**/
	public function seekSetCate(&$res_array, &$data_list, $pidx){
		static $idx = 0;
		$temp = array();
		for($i=0;$i<count($data_list);$i++){
			if($data_list[$i]['bm_pidx']==$pidx){
				//step 필드를 키로 준다
				$temp[$data_list[$i]['bm_step']] = $data_list[$i];
			}
		}
		
		//키에 의해 정렬한다 (카테고리 순서(bm_step) 적용)
		ksort($temp);

		$rowcnt = count($temp);

		//자식개수
		if($idx > 0) $res_array[$idx-1]['_childcnt_'] = $rowcnt;
		
		
		foreach($temp as $item){
			
			$res_array[$idx] = $item;
			//올리기 버튼 가능한지 여부(관리자용)
			if($item["bm_step"] > 1 && $rowcnt > 1){
				$res_array[$idx]["ulink"] = true;
			}else{
				$res_array[$idx]["ulink"] = false;
			}
			//내리기 버튼 가능한지 여부(관리자용)
			if(($item["bm_step"] < $rowcnt) && $rowcnt > 1){
				$res_array[$idx]["dlink"] = true;
			}else{
				$res_array[$idx]["dlink"] = false;
			}

			$idx++;
			
			$this->seekSetCate($res_array, $data_list, $item['bm_idx']);
		}
	}
	
	/**
	* @bref $data_list 데이타를 $res_array에 트리구조로 담기
	* @param array $res_array 결과담을 배열
	* @param array $data_list 데이타담긴 배열
	* @param string $pidx 부모노드 번호
	* @return
	**/
	public function seekTreeSetCate(&$res_array, &$data_list, $pidx, $lmt_depth=-1){
		
		//bm_pidx 값이 일치하는 형제들만 뽑는다
		$temp = array();
		for($i=0;$i<count($data_list);$i++){
			if($data_list[$i]['bm_pidx']==$pidx){
				//step 필드를 키로 준다
				$key = $data_list[$i]['bm_step']-1;
				$temp[$key] = $data_list[$i];
			}
		}
		
		//bm_step값에 따라 정렬한다.
		ksort($temp);
		
		$rowcnt = count($temp);

		$idx = 0;
		foreach($temp as $item){
			
			if($lmt_depth > -1 && $item['bm_depth'] > $lmt_depth) return;
			
			//$child = array();
			$res_array[$idx] = array('node' => $item, 'child' => array());
			
			//올리기 버튼 가능한지 여부(관리자용)
			if($item["bm_step"] > 1 && $rowcnt > 1){
				$item["ulink"] = true;
			}else{
				$item["ulink"] = false;
			}
			//내리기 버튼 가능한지 여부(관리자용)
			if(($item["bm_step"] < $rowcnt) && $rowcnt > 1){
				$item["dlink"] = true;
			}else{
				$item["dlink"] = false;
			}
			
			$this->seekTreeSetCate($res_array[$idx]['child'], $data_list, $item['bm_idx'], $lmt_depth);
			$idx++;
		}
	}
	
	/**
	* @bref 메뉴 목록 리턴
	* @param string $device both|pc|mobile
	* @param boolean $only_show 숨김모드 제외여부
	* @return array
	**/
	private function getDataList($device='both', $only_show=false){
		
		//똑같은 쿼리 두번이상 실행하는것 막기위해
		static $qlist = array();
		
		$key = $device.'_'.(string)$only_show.'_'.$lmt_depth;
		
		$device = strtolower($device);
		
		$aw = array();
		if($device == 'pc') $aw[] = "bm_device <> 'mobile'";
		else if($device == 'mobile') $aw[] = "bm_device <> 'pc'";
		
		if($only_show) $aw[] = "bm_hide=0";
		
		if(count($aw) > 0) $wsql = " WHERE ".@implode(' AND ', $aw);
		
		if(count($qlist[$key]) <= 0){
			$sql = "SELECT * FROM ".$this->table.$wsql;
			$qlist[$key] = $this->db->fetchAll($sql);
		}
		return $qlist[$key];
	}

	/**
	* @bref 메뉴 리스트구조로 리턴
	* @param string $device both|pc|mobile
	* @param boolean $only_show 숨김모드 제외여부
	* @return string $bm_pidx 부모 bm_pidx
	**/
	public function getList($device='both', $only_show=false, $bm_pidx=0){
	
		$list = $this->getDataList($device, $only_show);
		
		$res = array();
		$this->seekSetCate($res, $list, $bm_pidx);
		return $res;
	}
	
	/**
	* @bref 메뉴를 트리구조로 리턴
	* @param string $device both|pc|mobile
	* @param boolean $only_show 숨김모드 제외여부
	* @return string $bm_pidx 부모 bm_pidx
	**/
	public function getTreeList($device='both', $only_show=false, $bm_pidx='0', $lmt_depth=-1){
		
		$list = $this->getDataList($device, $only_show, $lmt_depth);
		
		$res = array();
		$this->seekTreeSetCate($res, $list, $bm_pidx, $lmt_depth);
		
		//자식이 없는 노드일경우 따로 뽑아줘야 함
		/*
		if(count($res) <= 0){
			$item = $this->getNode('bm_idx', $bm_pidx, $device, $only_show);
			if(count($item) > 0) $res[] = array('node' => $item);
		}
		*/
		return $res;
	}
	
	/**
	* @bref 노드 하나 리턴
	* @param string $key
	* @param string $val
	* @param string $device both|pc|mobile
	* @param boolean $only_show 숨김모드 제외여부
	* @return
	**/
	public function getNode($key, $val, $device='both', $only_show=false){
		$list = $this->getDataList($device, $only_show);
		for($i=0;$i<count($list);$i++){
			if($list[$i][$key] == $val){
				return $list[$i];
			}
		}
	}
	
	/**
	* @bref 현재 메뉴idx 로 부모로부터 자기까지 경로를 배열로 리턴
	* @param string $bm_idx
	* @return array
	**/
	private function seekSetPath(&$res, &$list, $bm_idx){
		
		for($i=0;$i<count($list);$i++){
			if($list[$i]['bm_idx'] == $bm_idx){
				$res[] = array();
				$idx = count($res) - 1;
				$res[$idx] = $list[$i];
				if((int)$list[$i]['bm_pidx'] > 0) $this->seekSetPath($res, $list, $list[$i]['bm_pidx']);
				break;
			}
		}
	}
	
	/**
	* @bref $bm_idx 로 현재경로를 리턴
	* @param string $bm_idx
	* @return array
	**/
	public function getPath($bm_idx){
		$list = $this->getDataList();
		
		$res = array();
		$this->seekSetPath($res, $list, $bm_idx);
		$res = array_reverse($res);
		return $res;
	}
	
	/**
	* @bref bm_type과 bm_mid로 해당 노드를 찾음
	* @param string $bm_type
	* @param string $bm_mid
	* @return array or null
	**/
	public function getByMid($bm_type, $bm_mid){
		$list = $this->getDataList();
        
		for($i=0;$i<count($list);$i++){
			if($list[$i]['bm_type'] == $bm_type && $list[$i]['bm_mid'] == $bm_mid){
				return $list[$i];
			}
		}
	}
	
	/**
	* @bref bm_idx 로 해당 노드를 찾음
	* @param string $bm_idx
	* @return array of null;
	**/
	public function getByIdx($bm_idx){
		$list = $this->getDataList();

		for($i=0;$i<count($list);$i++){
			if($list[$i]['bm_idx'] == $bm_idx){
				return $list[$i];
			}
		}
	}
	
	public function getByURL($url){
		
		$tmp = parse_url($url);

		$list = $this->getDataList();

		for($i=0;$i<count($list);$i++){
			if($list[$i]['bm_url'] == $url){
				return $list[$i];
			}
		}
	}
	
	public static function getInstance(){
		static $inst;
		if(empty($inst)) $inst = new BMenu();
		return $inst;
	}
	
	/**
	* @bref 메뉴 링크 구하기
	* @param array $mitem 메뉴노드 배열
	* @return string
	**/
	public static function getMenuLink($mitem){
		
		//게시판
		if($mitem['bm_type']=='board'){
			$alink  = G5_BBS_URL.'/board.php?bo_table='.$mitem['bm_mid'];
			
		//외부링크
		}else if($mitem['bm_type']=='link'){
			$alink = $mitem['bm_url'];
			
		//그룹 or 페이지
		}else{
			$alink  = G5_URL.'/?bm_idx='.$mitem['bm_idx'];
		}
		return $alink;
	}

	/**
	* @bref 현재 위치 문자열로 리턴
	* @param array $arr 메뉴 데이타 배열
	* @param string $separ 중간 구분 문자
	* @return string $atag_attr a 태그 추가 애트리뷰트
	**/
	public function getPathString($arr, $separ='', $atag_attr=''){

		$res = array();
		for($i=0;$i<count($arr);$i++){
			
			$alink = self::getMenuLink($arr[$i]);
			
			$res [] = '<li><a href="'.$alink.'"'.$atag_attr.' target="'.$arr[$i]['bm_target'].'"><span>'.$arr[$i]['bm_name'].'</span></a></li>';
		}
		
		return implode($separ, $res);
	}
	
	/**
	* @bref bootstrap 메뉴형식으로 출력한다
	* @param 
	* @param 
	* @return 
	**/
	public function printNavBar($menu, $cur_idx=''){
		static $depth = 0;
		static $pidx = 0;
		static $cnt = 0;
		static $curpath = null;
		
		//현재메뉴의 경로를 구해온다
		if($curpath == null){
			$curpath = self::getPath($cur_idx);
		}
		
		$str = '';
		foreach($menu as $item){
			$node = $item['node'];
			$child = $item['child'];
			
			$alink = self::getMenuLink($node);
			
			$lcls = array();
			
			$cnt++;
			
			//$item 이 현재 메뉴이면
			if($node['bm_idx']==$cur_idx){
				$pidx = $node['bm_pidx'];
				$lcls[] = 'active';
			
			}else{
				//부모메뉴이면 current 클래스 추가
				for($i=0; $i<count($curpath);$i++){
					if($curpath[$i]['bm_idx']==$node["bm_idx"]){
						$lcls[] = 'active';
						break;
					}
				}
			}
			
			// li 태그 시작
			$sub_str = '';
			$caret = '';
			
			//자식 메뉴 있으면 재귀호출
			if(count($child) > 0){
				//echo $depth.':'.$node['bm_name'].':'.count($child).'<br>';
				if($depth == 0){
					$lcls[] = 'dropdown';
					$caret = ' <span class="caret"></span>';
				}else{
					$lcls[] = 'dropdown-submenu';
					$caret = '';
				}
				$depth++;
				$sub_str = PHP_EOL.'<ul class="dropdown-menu">'.PHP_EOL;
				$sub_str .= $this->printNavBar($child, $cur_idx);
				$sub_str .= '</ul>'.PHP_EOL;
				$depth--;
			}
			
			//class 정리
			if(count($lcls) > 0) $l_cls = ' class="'.implode(" ", $lcls).'"';
			else $l_cls = '';
			
			//태그정리			
			$str .= '<li'.$l_cls.'><a href="'.$alink.'" target="'.$node['bm_target'].'"'.$a_cls.'>'.$node['bm_name'].$caret.'</a>';
			$str .= $sub_str;
			$str .= '</li>'.PHP_EOL;
		}		
		return $str;
	}
}
