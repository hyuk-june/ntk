<?php
namespace kr\bartnet\builder;

if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;

class BWidgets{
    
    public function showWidgetList($wg_skindir, $pg_id, $wg_id){
        global $bt, $is_admin;
        $sql = "SELECT * FROM ".$bt['widget_table']."
            WHERE wg_skindir='".$wg_skindir."'
            AND wp_id='".$pg_id."'
            AND wg_id='".$wg_id."'
            ORDER BY wg_step";
                    
        $result = sql_query($sql);
        
        echo '<div class="bt-widget-container">';
        if($is_admin){
            echo '<div class="control-header justify-content-between px-1">'.PHP_EOL;
            echo '<span class="text-light">위젯컨테이너</span>'.PHP_EOL;
            echo '<i class="fa fa-plus" data-wg_skindir="'.$wg_skindir.'" data-wp_id="'.$pg_id.'" data-wg_id="'.$wg_id.'"></i>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        echo '<div class="widget-list">'.PHP_EOL;
        
        while($rs = sql_fetch_array($result)){
            $this->showWidget($rs);
        }
        
        echo '</div>'.PHP_EOL;
        echo '</div>';
    }
    
    /*
    public function addWidgetGroup($wg_id, $wg_widget){
        $content = file_get_contents(G5_DATA_PATH.'/wgroup/'.$wg_id);
        $content = @json_decode($content, true);
        if(!is_array($content)) $content = array();
        $content[] = array('');
    }
    */
    
    
    //위젯출력
    private function showWidget($rs){
        global $config, $g5, $bt, $is_admin, $is_member, $member, $is_auth, $bdb;
        
        $path = BT_WIDGET_PATH;
        $url = BT_WIDGET_URL;
        
        //사용자 설정을 디코드 한다
        $wcfg = @json_decode($rs["wg_data"], true);
        if(!is_array($wcfg)) $wcfg = array();
        $wcfg = array_map_deep('stripslashes', $wcfg);
        
        //레코드와 설정을 합친다
        $wcfg = array_merge($rs, $wcfg);
        unset($rs);
        
        //위젯 경로
        $widget_path = $path.'/'.$wcfg['wg_name'];
        $widget_url = $url.'/'.$wcfg["wg_name"];
        
        //안쪽, 바깥쪽 여백 정리
        $margin = explode('|', $wcfg['wg_margin']);
        $padding = explode('|', $wcfg['wg_padding']);
        $margin = array_map(array($this, 'addPixel'), $margin);
        $padding = array_map(array($this, 'addPixel'), $padding);
        $margin = @implode(' ', $margin);
        $padding = @implode(' ', $padding);
        
        //class, id , attr 정리
        $class = bt\varset($wcfg['wg_class']);
        $eid = bt\isval($wcfg['wg_eid']) ? '#'.$wcfg['wg_eid'] : '';
        $attr = bt\varset($wcfg['wg_attr']);
        
        //한번이라도 세팅 저장 했는지
        $isset = (boolean)$wcfg['wg_isset'];
        
        //css 출력
        if(bt\isval($wcfg['wg_style'])){
            ob_start();
            echo <<<HEREDOC
<style type="text/css">
{$wcfg['wg_style']}
</style>
HEREDOC;
            $str = ob_get_contents();
            ob_end_clean();
            add_stylesheet($str);
        }
        
        //위젯 컨트롤러 Element Start
        echo '<div class="bt-widget" style="margin: '.$margin.'; padding: '.$padding.'">'.PHP_EOL;
        
        //관리자패널
        if($is_admin){
            echo '<div class="control-header justify-content-between px-1">'.PHP_EOL;
                echo '<span class="text-light">'.$wcfg["wg_name"].'</span>'.PHP_EOL;
                echo '<i class="fa fa-cog" data-wg_idx="'.$wcfg["wg_idx"].'"></i>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        
            echo '<div class="bt-widget-body">'.PHP_EOL;
            echo '<div class="'.$class.'" '.$attr.'>'.PHP_EOL;
        }
        
        //위젯에 고유의 id 세팅
        echo '<div id="'.$wcfg['wg_eid'].'">';
        
        //위젯내에서 함수를 부를 수 있어서 임시로 global로 등록함
        $GLOBALS['wcfg'] = $wcfg;
        
        //위젯 헤더 (캐시에 포함안시킬 선처리 파일)
        if(file_exists($widget_path.'/widget.head.php'))
            include_once($widget_path.'/widget.head.php');
        
        //위젯파일 로딩
        if(isset($wcfg['wg_cache_min']) && (int)bt\varset($wcfg['wg_cache_min']) > 0){
            $this->showCache($wcfg, $widget_path, $widget_url);
        }else{
            @include($widget_path."/widget.php");
        }
        
        
        //위젯 헤더 (캐시에 포함안시킬 후처리 파일)
        if(file_exists($widget_path.'/widget.tail.php'))
            include_once($widget_path.'/widget.tail.php');
        
        echo '</div>';
        
        //global 해제
        unset($GLOBALS['wcfg']);
        
        //위젯 컨트롤러 Element End
        if($is_admin){
            echo '</div>'.PHP_EOL;
            echo '</div>'.PHP_EOL;
        }
        echo '</div>'.PHP_EOL;
    }
    
    
    private function showCache(&$wcfg, $widget_path, $widget_url){
        global $config, $g5, $bt, $is_admin, $is_member, $member, $is_auth, $bdb;
        
        $stdtime = date('Y-m-d H:i:s', strtotime(G5_TIME_YMDHIS.' -'.((int)$wcfg['wg_cache_min']).' minutes'));

        //캐시시간이 지났거나 캐시가 없으면
        if($stdtime > $wcfg['wg_cache_date'] || trim($wcfg['wg_cache'])==''){
            ob_start();
            include($widget_path."/widget.php");
            $widget = ob_get_contents();
            ob_end_clean();
            
            $arr = array();
            $arr['wg_cache'] = $widget;
            $arr['wg_cache_date'] = G5_TIME_YMDHIS;
            $bdb->update($bt['widget_table'], $arr, "wg_idx=".$wcfg['wg_idx']);
            echo $widget;
        }else{
            echo $wcfg['wg_cache'];
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
    
    //엘리컨트 아이디 생성
    public static function createElementID(){
        
        global $bt;
        
        $cnt = 0;
        do{
            $len = 6;
            $chars = "abcdefghijklmnopqrstuvwxyz123456789";

            srand((double)microtime()*1000000);

            $i = 0;
            $wg_eid = "";

            while ($i < $len) {
                $num = rand() % strlen($chars);
                $tmp = substr($chars, $num, 1);
                $wg_eid .= $tmp;
                $i++;
            }
            $wg_eid = 'eid_'.$wg_eid;
            
            $sql = "SELECT * FROM ".$bt['widget_table']." WHERE wg_eid='".$wg_eid."' LIMIT 1";
            $rs = sql_fetch($sql);
            if(!$rs){
                return $wg_eid;
            }
            $cnt++;
        }while($cnt < 5);

        return false;
    }
}
