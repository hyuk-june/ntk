<?php
namespace kr\bartnet\util;

class BKoreaArea{
    
    private static $areas = array(
        '서울' => '서울특별시',
        '인천' => '인천광역시',
        '대전' => '대전광역시',
        '대구' => '대구광역시',
        '부산' => '부산광역시',
        '울산' => '울산광역시',
        '광주' => '광주광역시',
        '세종' => '세종특별자치시',
        '경기' => '경기도',
        '충북' => '충청북도',
        '충남' => '충청남도',
        '전북' => '전라북도',
        '전남' => '전라남도',
        '경북' => '경상북도',
        '경남' => '경상남도',
        '강원' => '강원도',
        '제주' => '제주특별자치도'
    );
    
    public static function getShortList(){
        return array_keys(self::$areas);
    }
    
    public static function getLongList(){
        return array_values(self::$areas);
    }
    
    public static function getList(){
        return self::$areas;
    }
    
    public static function getShort($long){
        array_search($long, self::$areas);
    }
    
    public static function getLong($short){
        return self::$areas[$short];
    }
}
