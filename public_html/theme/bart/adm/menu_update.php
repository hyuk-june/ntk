<?php
$sub_menu = "801200";
include_once('./_common.php');

use kr\bartnet as bt;

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super' && $w == '') alert('최고관리자만 접근 가능합니다.');

switch($w){
//===========================================================================
// 수정
//===========================================================================
	case 'u':
        
		$arr = array();
		$arr['bm_name']			= $_POST['bm_name'];
        $arr['bm_subtitle']         = $_POST['bm_subtitle'];
		$arr['bm_type']			= $_POST['bm_type'];
		$arr['bm_target']		= $_POST['bm_target'];
		$arr['bm_skin_frame']	= $_POST['bm_skin_frame'];
        $arr['bm_skin_layout']  = $_POST['bm_skin_layout'];
        $arr['bm_icon']         = $_POST["bm_icon"];
        
        if(!bt\isval($_POST["bm_name"]) && ($arr['bm_type']=='board' || $arr['bm_type']=='link')){
            alert("메뉴이름을 입력해 주세요");
        }
		
		if($arr['bm_type']=='board') $arr['bm_mid'] = $_POST['bo_table'];
		else if($arr['bm_type']=='page') $arr['bm_mid'] = $_POST['pg_id'];
        else if($arr['bm_type']=='wpage') $arr['bm_mid'] = $_POST['wp_id'];
        else if($arr['bm_type']=='mpage') $arr['bm_mid'] = $_POST["mp_id"];
        else if(bt\isval($_POST["wp_id"])) $arr['bm_mid'] = $_POST["bm_mid"];
		else $arr['bm_mid'] = '';
		
		$arr['bm_device']	    = $_POST['bm_device'];
		$arr['bm_url']		    = $_POST['bm_url'];
        
		$bdb->update($bt['menu_table'], $arr, 'bm_idx='.$bdb->esc($_POST['bm_idx']));
		
		echo "<script type='text/javascript'>opener.document.location.reload();</script>";
		alert_close('수정되었습니다', false);
		
		break;

//===========================================================================
// 삭제
//===========================================================================
	case 'd':
	
		$bm_idx = $bdb->esc($_GET['bm_idx']);
		
		$sql = "SELECT count(*) as cnt FROM ".$bt['menu_table']." WHERE bm_pidx=".$bm_idx;
		$row = $bdb->fetch($sql);
		$child_cnt = $row['cnt'];
		
		if($child_cnt > 0) alert('하위에 자식메뉴가 존재하여 삭제할 수 없습니다');
		
		$sql = "SELECT * FROM ".$bt['menu_table']." WHERE bm_idx=".$bm_idx;
		$row = $bdb->fetch($sql);
		
		$sql = "UPDATE ".$bt['menu_table']." SET bm_step=bm_step-1
			WHERE bm_pidx=".$row["bm_pidx"]." AND bm_step > ".$row["bm_step"];
		$bdb->query($sql);
		
		$bdb->delete($bt['menu_table'], "bm_idx=".$bm_idx);
		
		goto_url('./menu_list.php');
		
		break;

//===========================================================================
// 멀티수정
//===========================================================================
	case 'mu':
	
		for ($i=0; $i<count($_POST['chk']); $i++) {
			
			// 실제 번호를 넘김
        	$k = $_POST['chk'][$i];
        	
        	$arr = array();
        	$arr['bm_target']		= $_POST['bm_target'][$k];
        	$arr['bm_skin_frame']	= $_POST['bm_skin_frame'][$k];
            $arr['bm_skin_layout']  = $_POST['bm_skin_layout'][$k];
        	$arr['bm_device']		= $_POST['bm_device'][$k];
        	
        	//$bdb->showQuery(true);
        	$bdb->update( $bt['menu_table'], $arr, "bm_idx=".$bdb->esc($_POST['bm_idx'][$k]) );
		}
		
		alert('수정 되었습니다', './menu_list.php', false);
		
		break;

//===========================================================================
// 위로 이동
//===========================================================================
	case 'up':
	
		$sql = "UPDATE ".$bt['menu_table']." SET bm_step=bm_step+1 WHERE bm_pidx=".$bm_pidx." AND bm_step=".((int)$bm_step-1);
		$bdb->query($sql);
		
		$sql = "UPDATE ".$bt['menu_table']." SET bm_step=".((int)$bm_step-1)." WHERE bm_idx=".$bm_idx;
		$bdb->query($sql);
		
		goto_url('./menu_list.php');
		
		break;

//===========================================================================
// 아래로 이동
//===========================================================================
	case 'dn':
	
		$sql = "UPDATE ".$bt['menu_table']." SET bm_step=bm_step-1 WHERE bm_pidx=".$bm_pidx." AND bm_step=".((int)$bm_step+1);
		$bdb->query($sql);

		$sql = "UPDATE ".$bt['menu_table']." SET bm_step=".((int)$bm_step+1)." WHERE bm_idx=".$bm_idx;
		$bdb->query($sql);
		
		goto_url('./menu_list.php');
	
		break;

//===========================================================================
// 입력
//===========================================================================
	default:
	
		$bm_pidx = bt\binstr( $bdb->esc($_POST['bm_pidx']), 0);

		//부모정보
		if((int)$bm_pidx > 0){
			$sql = "SELECT bm_depth FROM ".$bt['menu_table']." WHERE bm_idx=".$bm_pidx;
			$prs = $bdb->fetch($sql);
			$bm_depth = $prs["bm_depth"] + 1;
		}else{
			$bm_depth = 0;
		}

		//카테고리 순서 구하기 = 형제 카테고리 중 가장 마지막 순서 + 1
		$sql = "SELECT max(bm_step) as bm_step FROM ".$bt['menu_table']." WHERE bm_pidx=".$bm_pidx;
		$rs = $bdb->fetch($sql);
		$bm_step = (int)$rs["bm_step"] + 1;
		
		$arr = array();
		$arr['bm_pidx']			= $bm_pidx;
		$arr['bm_name']			= $_POST['bm_name'];
        $arr['bm_subtitle']         = $_POST['bm_subtitle'];
		$arr['bm_type']			= $_POST['bm_type'];
		$arr['bm_target']		= $_POST['bm_target'];
		$arr['bm_step']			= $bm_step;
		$arr['bm_depth']		= $bm_depth;
		$arr['bm_skin_frame']	= $_POST['bm_skin_frame'];
        $arr['bm_skin_layout']  = $_POST['bm_skin_layout'];
        $arr['bm_icon']         = $_POST["bm_icon"];
        
        if(!bt\isval($_POST["bm_name"]) && ($arr['bm_type']=='board' || $arr['bm_type']=='link')){
            alert("메뉴이름을 입력해 주세요");
        }
        		
		if($arr['bm_type']=='board') $arr['bm_mid'] = $_POST['bo_table'];
		else if($arr['bm_type']=='page') $arr['bm_mid'] = $_POST['pg_id'];
        else if($arr['bm_type']=='wpage') $arr['bm_mid'] = $_POST['wp_id'];
        else if($arr['bm_type']=='mpage') $arr['bm_mid'] = $_POST["mp_id"];
        else if($arr['bm_type']=='link') $arr['bm_mid'] = $_POST["bm_mid"];
        else alert("잘못된 접근입니다");
		
		$arr['bm_device']		= $_POST['bm_device'];
		$arr['bm_url']			= $_POST['bm_url'];
		$arr['bm_regdate']		= date('Y-m-d H:i:s');
	    
		//카테고리 등록
		$bdb->insert($bt['menu_table'], $arr);

		echo "<script type='text/javascript'>opener.document.location.reload();</script>";
		alert_close('추가되었습니다', false);
		//카테고리 경로코드 입력
		/*
		$bm_idx = DB::insertId();

		$arr = array();
		$arr['bm_path'] = $bm_path."_".$bm_idx;
		DB::update($this->table, $arr, "bm_idx=".$bm_idx);
		*/
}
