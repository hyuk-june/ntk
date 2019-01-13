<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;
?>

<?php
$layout_data = @json_decode($pgrow['pg_config'], true);
if(!is_array($layout_data)) $layout_data = array();


foreach($layout_data as $row){
    
    $rowid = $row["rowid"];
    $cols = $row["cols"];
    
    if(!is_array($row)) continue;
    
    //행 css
    $rowcss = bt\isval($row['css']) ? ' style="'.$row['css'].'"' : '';
    
    echo '<div class="row-wrap"'.$rowcss.'><div class="row">'.PHP_EOL;
    
    $i=1;
    foreach($cols as $col){
        
        if(!is_array($col)) continue;
        
        $clist = array();
        
        //사이즈별 컬럼 넓이 정리
        foreach($col as $size => $item){
            
            if(!is_array($item) || $size == 'css') continue;
            
            if($item["hide"]=="1") $hides[$size] = "none";
            
            if(!bt\isval($item["value"])) continue;
            
            $str = 'col';
            if($size=='xs') $clist[] = $str.'-'.$item["value"];
            else $clist[] = $str.'-'.$size.'-'.$item["value"];
        }
        
        //사이즈별 숨김설정 정리
        $hides = array(
            'xs' => 'block',
            'sm' => 'block',
            'md' => 'block',
            'lg' => 'block',
            'xl' => 'block'
        );
        
        foreach($hides as $size => $show){
            if($size=='xs') $clist[] = 'd-'.$show;
            else $clist[] = 'd-'.$size.'-'.$show;
        }
        
        //열 css
        $colcss = bt\isval($col['css']) ? ' style="'.$col['css'].'"' : '';
        
        //위젯들 출력
        $cls = @implode(' ', $clist);
        echo '<div class="'.$cls.'">'.PHP_EOL;
        echo '<div class="bt-widgets"'.$colcss.'>'.PHP_EOL;
        btb\show_widgets('wpage', $pg_id, "sid_".$rowid."_".$i);
        echo '</div>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
        
        $i++;
    }
    
    echo "</div></div>".PHP_EOL;
}