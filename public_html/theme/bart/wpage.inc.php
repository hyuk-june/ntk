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
    
    echo '<div class="row">'.PHP_EOL;
    
    $i=1;
    foreach($cols as $col){
        
        if(!is_array($col)) continue;
        
        $clist = array();
        
        foreach($col as $size => $item){
            
            if(!is_array($item)) continue;
            
            if($size=='xs'){
                if(bt\isval($item["value"])) $clist[] = 'col-'.$item["value"];
                if($item["hide"]=="1") $clist[] = 'd-none';
                else if(bt\isval($item["value"])) $clist[] = 'd-block';
            }else{
                if(bt\isval($item["value"])) $clist[] = 'col-'.$size.'-'.$item["value"];
                if($item["hide"]=="1") $clist[] = 'd-'.$size.'-none';
                else if(bt\isval($item["value"])) $clist[] = 'd-'.$size.'-block';
            }
        }
        
        $cls = @implode(' ', $clist);
        
        echo '<div class="bt-widgets '.$cls.'">'.PHP_EOL;
        btb\show_widgets('wpage', $pg_id, "sid_".$rowid."_".$i);
        echo '</div>'.PHP_EOL;
        
        $i++;
    }
    
    echo "</div>".PHP_EOL;
}
?>

