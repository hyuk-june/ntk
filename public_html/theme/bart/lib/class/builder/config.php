<?php
namespace kr\bartnet\builder;

use \kr\bartnet as bt;
use \kr\bartnet\database as bt_database;

class BConfig{
	
	private $config;
    
    private $file_path = BT_DATA_PATH.'/btb_config.php';
	
	public function __construct(){
		$this->db = bt_database\BDb::getInstance();
		$this->table = BT_PREFIX.'config';
	}
	
	public function getConfig($reflash=false){
		if(empty($config) || $reflash){
			//$sql = "SELECT * FROM ".$this->table." LIMIT 1";
			//$this->config = $this->db->fetch($sql);
            
            $fdata = new bt\file\BFileData();
            $fdata->setFilePath($this->file_path);
            $this->config = $fdata->readData();
            
			//메인 기본 스킨
			$this->config['bc_skin_frame_main'] = bt\binstr($this->config['bc_skin_frame_main'], 'basic');
            $this->config['bc_skin_layout_main'] = bt\binstr($this->config['bc_skin_layout_main'], 'basic');
            $this->config['bc_skin_frame_default'] = bt\binstr($this->config['bc_skin_frame_default'], 'basic');
            $this->config['bc_skin_layout_default'] = bt\binstr($this->config['bc_skin_layout_default'], 'basic');
            
		}
		return $this->config;
	}
	
	public static function getInstance(){
		static $inst;
		if(empty($inst)) $inst = new BConfig();
		return $inst;
	}
}