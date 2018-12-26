<?php
namespace kr\bartnet\file;

class BDataCache extends BFileData{
    
    private $expire_sec = 0;
    
    
    public function setExpire($expire_sec){
        $this->expire_sec = (int)$expire_sec;
    }
    
    
    public function readCacheData(){
        
        $data = null;
        
        if($this->expire_sec <= 0) return $data;
        
        if(file_exists($this->file_path)){
        
            //파일 생성일자
            $create_time = filemtime($this->file_path);

            //기준시간 = 생성일자 + 캐시유지시간
            $std_time = date('Y-m-d H:i:s', strtotime('+'.$this->expire_sec.' seconds', $create_time));

            //현재시간이 기준시간을 초과하지 않았으면 리프레시 안하게
            if(G5_TIME_YMDHIS < $std_time){
                $data = $this->readData();
            }
        }
        
        return $data;
    }
    
}
