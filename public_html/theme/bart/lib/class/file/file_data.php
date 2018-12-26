<?php
namespace kr\bartnet\file;

use kr\bartnet as bt;

class BFileData{
    
    protected $file_path = '';
    
    //생성할 경로(파일이름 포함)
    public function setFilePath($file_path){
        $this->file_path = $file_path;
    }
    
    public function saveData($data, $perm=0755){
        
        //디렉터리 만들기
        //@mkdir(dirname($this->file_path), $perm, true);  <-- 퍼미션설정 오류가 있다
        bt\file\BFiledir::autoMkdir(dirname($this->file_path), $perm);
        
        $str = '<'.'?php exit();?>'.PHP_EOL;
        $str .= trim(@json_encode($data));
        
        $fp = fopen($this->file_path, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
    
    public function readData(){
        
        $data = null;
        
        if(file_exists($this->file_path)){
            $temp = file($this->file_path);
            if(is_array($temp) && count($temp) >= 2){
                array_shift($temp);
                $data = @json_decode($temp[0], true);
            }
        }
        
        return $data;
    }
    
}
