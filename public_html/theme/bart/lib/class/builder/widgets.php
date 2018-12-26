<?php
namespace kr\bartnet\builder;

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

class BWidgets{
    
    public function showWidgetList($wg_skindir, $wp_id, $wg_id){
        global $bt, $is_admin;
        $sql = "SELECT * FROM ".$bt['widget_table']."
            WHERE wg_skindir='".$wg_skindir."'
            AND wp_id='".$wp_id."'
            AND wg_id='".$wg_id."'
            ORDER BY wg_step";
                    
        $result = sql_query($sql);
        
        echo '<div class="bt-widget-container">';
        if($is_admin){
            echo '<div class="control-header justify-content-between px-1">'.PHP_EOL;
            echo '<span class="text-light">위젯컨테이너</span>'.PHP_EOL;
            echo '<i class="fa fa-plus" data-wg_skindir="'.$wg_skindir.'" data-wp_id="'.$wp_id.'" data-wg_id="'.$wg_id.'"></i>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        echo '<div class="widget-list">'.PHP_EOL;
        
        while($rs = sql_fetch_array($result)){
            $this->showWidget($rs);
        }
        
        
        echo '</div>'.PHP_EOL;
        echo '</div>';
    }
    
    
    public function addWidgetGroup($wg_id, $wg_widget){
        $content = file_get_contents(G5_DATA_PATH.'/wgroup/'.$wg_id);
        $content = @json_decode($content, true);
        if(!is_array($content)) $content = array();
        $content[] = array('');
    }
    
    
    private function showWidget($rs){
        global $config, $g5, $bt, $is_admin, $is_member, $member, $is_auth, $bdb;
        
        $path = BT_WIDGET_PATH;
        $url = BT_WIDGET_URL;
        
        $wcfg = @json_decode($rs["wg_data"], true);
        if(!is_array($wcfg)) $wcfg = array();
        
        $wcfg = array_map_deep('stripslashes', $wcfg);
        
        $widget_path = $path.'/'.$rs['wg_name'];
        $widget_url = $url.'/'.$rs["wg_name"];
        
        $margin = explode('|', $rs['wg_margin']);
        $padding = explode('|', $rs['wg_padding']);
        $margin = array_map(array($this, 'addPixel'), $margin);
        $padding = array_map(array($this, 'addPixel'), $padding);
        $margin = @implode(' ', $margin);
        $padding = @implode(' ', $padding);
        
        $class = bt\varset($rs['wg_class']);
        $attr = bt\varset($rs['wg_attr']);
        
        //한번이라도 세팅 저장 했는지
        $isset = (boolean)$rs['wg_isset'];
        
        //위젯 컨트롤러 Element Start
        echo '<div class="bt-widget" style="margin: '.$margin.'; padding: '.$padding.'">'.PHP_EOL;
        if($is_admin){
            echo '<div class="control-header justify-content-between px-1">'.PHP_EOL;
                echo '<span class="text-light">'.$rs["wg_name"].'</span>'.PHP_EOL;
                echo '<i class="fa fa-cog" data-wg_idx="'.$rs["wg_idx"].'"></i>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        
        
            echo '<div class="bt-widget-body">'.PHP_EOL;
            echo '<div class="'.$class.'" '.$attr.'>'.PHP_EOL;
        }
        
        
        $GLOBALS['wcfg'] = $wcfg;
        
        //위젯 헤더 (캐시에 포함안시킬 선처리 파일)
        if(file_exists($widget_path.'/widget.head.php'))
            include_once($widget_path.'/widget.head.php');
        
        //위젯파일 로딩
        if(isset($wcfg['cache_min']) && (int)bt\varset($wcfg['cache_min']) > 0){
            $this->showCache($wcfg, $widget_path, $widget_url, $rs);
        }else{
            @include($widget_path."/widget.php");
        }
        
        
        //위젯 헤더 (캐시에 포함안시킬 후처리 파일)
        if(file_exists($widget_path.'/widget.tail.php'))
            include_once($widget_path.'/widget.tail.php');
            
        unset($GLOBALS['wcfg']);
        
        //위젯 컨트롤러 Element End
        if($is_admin){
            echo '</div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        echo '</div>'.PHP_EOL;
    }
    
    
    private function showCache(&$wcfg, $widget_path, $widget_url, &$rs){
        global $config, $g5, $bt, $is_admin, $is_member, $member, $is_auth, $bdb;
        
        $stdtime = date('Y-m-d H:i:s', strtotime(G5_TIME_YMDHIS.' -'.((int)$wcfg['cache_min']).' minutes'));

        //캐시시간이 지났거나 캐시가 없으면
        if($stdtime > $rs['wg_cache_date'] || trim($rs['wg_cache'])==''){
            ob_start();
            include($widget_path."/widget.php");
            $widget = ob_get_contents();
            ob_end_clean();
            
            $arr = array();
            $arr['wg_cache'] = $widget;
            $arr['wg_cache_date'] = G5_TIME_YMDHIS;
            $bdb->update($bt['widget_table'], $arr, "wg_idx=".$rs['wg_idx']);
            echo $widget;
        }else{
            echo $rs['wg_cache'];
        }
    }
    
    
    private function addPixel($item){
        return $item.'px';
    }
    
    
    public static function getInstance(){
        static $inst = null;
        
        if($inst == null) $inst = new BWidgets();
        return $inst;
    }
}
