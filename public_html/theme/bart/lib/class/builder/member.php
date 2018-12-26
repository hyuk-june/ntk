<?php
namespace kr\bartnet\builder;

use kr\bartnet as bt;

class BMember{
    
    public static function loadData($mb_id, $is_refresh=false){
        
        static $inst = array();
        
        if(count($inst) <= 0 || $is_refresh==true){
        
            $path = self::getPath($mb_id);
            if(!file_exists($path['file_path'])){
                return array();
            }
            
            $file = file($path['file_path']);
            array_shift($file);
            $str = @implode('', $file);
            $inst = @json_decode($str, true);
        }
        
        return $inst;
    }
    
    
    public static function saveData($mb_id, $data){
        
        if(!is_array($data)) return false;
        
        $mb_id = trim($mb_id);
        
        $str = @json_encode($data);
        $str = '<'.'?php exit();?'.'>'.PHP_EOL.$str;
        
        $path = self::getPath($mb_id);
        bt\file\BFiledir::autoMkdir($path['image_path']);
        
        $fp = fopen($path['data_path'].'/'.$mb_id.'.php', 'w+');
        fwrite($fp, $str);
        fclose($fp);
        
        return true;
    }
    
    
    public static function appendData($mb_id, $key, $val){
        $mdata = $self::loadData($mb_id);
        $mdata[$key] = $val;
        self::saveData($mb_id, $mdata);
    }
    
    
    public static function getPath($mb_id){
        $part = substr($mb_id, 0, 2);
        $arr = array(
            'data_path'  => G5_DATA_PATH.'/bart/member/'.$part,
            'data_url'   => G5_DATA_URL.'/bart/member/'.$part,
            'image_path' => G5_DATA_PATH.'/bart/member/'.$part.'/img',
            'image_url'  => G5_DATA_URL.'/bart/member/'.$part.'/img',
            'file_path'  => $file_path = G5_DATA_PATH.'/bart/member/'.$part.'/'.$mb_id.'.php'
        );
        return $arr;
    }
    
    
    public static function uploadPhoto($mb_id, $field_name){
        
        $path = self::getPath($mb_id);
        
        if($_FILES[$field_name]['size'] > 0){
            $fu = new bt\file\BFileUpload();
            $param = array(
                "mkdir" => true,
                "updir" => $path['image_path'],
                "field" => $field_name,
                "naming" => bt\file\BFileUpload::NAME_FORCE_ADDEXT,
                "force_name" => $mb_id,
                "limit_size" => 2*1024*1024,
                "allow_ext" => "jpeg|jpg|png|gif"
            );

            $info = $fu->add($param);

            try{
                $fu->upload();
            
                $file_path = $path['image_path'].'/'.$info['rname'];
                $thumb = new bt\image\BThumbnail(
                    $file_path,
                    $file_path,
                    60, 60,
                    array(
                        'sizefix' => true,
                        'crop_posx' => bt\image\BThumbnail::CROP_POSX_CENTER,
                        'crop_posy' => bt\image\BThumbnail::CROP_POSY_MIDDLE
                    )
                );
                $thumb->save();
                $data = self::loadData($mb_id);
                $data['mb_photo'] = $info['rname'];
                self::saveData($mb_id, $data);
            
            }catch(Exception $e){
                alert("파일업로드 에러 ".$e->getMessage());
            }
        }
    }
    
    public static function removePhoto($mb_id, $field_name){
        $path = self::getPath($mb_id);
        $data = self::loadData($mb_id);
        unlink($path['file_path']);
        $data['mb_photo'] = '';
        self::saveData($mb_id, $data);
    }
    
    public static function getPhoto($mb_id, $is_link=false){
        $path = self::getPath($mb_id);
        $data = self::loadData($mb_id);
        
        if(bt\isval($data['mb_photo']) && file_exists($path['image_path'].'/'.$data['mb_photo'])){
            $str = '<img src="'.$path['image_url'].'/'.$data['mb_photo'].'" class="user-photo img-responsive">';
        }else{
            $str = '<i class="fa fa-user user-photo"></i>';
        }
        
        if($is_link){
            $str = '<a href="#" class="myphoto">'.$str.'</a>';
        }
        return $str;
    }
}