<?php
include_once("./_common.php");

use kr\bartnet as bt;
use kr\bartnet\builder as btb;

if(!$is_admin){
    alert_close("권한이 없습니다");
}
if(!$wg_skindir || !$wg_id){
    alert_close("잘못된 경로로 접근했습니다");
}

//위젯 정보 리턴
function get_widget_info($widget_name){
    
    $arr = array(
        'title' => '',
        'description' => '',
        'version' => '',
        'author' => '',
        'single' => ''
    );
    
    $file = file_get_contents(BT_WIDGET_PATH.'/'.$widget_name.'/widget.php');
    $pat = '~<\?php\s*/\*(.+?)\*/~is';
    preg_match($pat, $file, $mat);
    if(trim($mat[1])=='') return $arr;
    
    
    $pat = '~([a-z]+)\s*\:\s*([^\n]+)~is';
    preg_match_all($pat, $mat[1], $mat);
    
    for($i=0;$i<count($mat[1]); $i++){
        $key = strtolower(trim($mat[1][$i]));
        $val = strtolower(trim($mat[2][$i]));
        $arr[$key] = $val;
    }
    return $arr;
}


if(bt\isval($_POST["wg_name"])){
    
    $winfo = get_widget_info($_POST["wg_name"]);
    
    if(strtolower($winfo['single'])=='true'){
        $sql = "SELECT count(*) as cnt
        FROM ".$bt['widget_table']."
        WHERE wg_skindir='".$_POST["wg_skindir"]."'
        AND wp_id='".$_POST["wp_id"]."'
        AND wg_id='".$_POST["wg_id"]."'";
        
        $rs = sql_fetch($sql);

        if((int)$rs['cnt'] > 0){
            alert('싱글위젯은 페이지당 하나만 추가할 수 있습니다');
        }
    }
    
    $sql = "SELECT max(wg_step) as wg_step
        FROM ".$bt['widget_table']."
        WHERE wg_skindir='".$_POST["wg_skindir"]."'
        AND wp_id='".$_POST["wp_id"]."'
        AND wg_id='".$_POST["wg_id"]."'";
    $rs = sql_fetch($sql);
    $wg_step = (int)$rs['wg_step'] + 1;
    
    $arr = array();
    $arr['wg_skindir'] = $_POST["wg_skindir"];
    $arr['wp_id'] = $_POST["wp_id"];
    $arr['wg_id'] = $_POST["wg_id"];
    $arr['wg_name'] = $_POST["wg_name"];
    $arr['wg_step'] = $wg_step;
    
    $bdb->insert($bt['widget_table'], $arr);
    
    echo <<<HEREDOC
    <script type="text/javascript">
    opener.document.location.reload();
    window.close();
    </script>
HEREDOC;
    
    exit();
}





$path = BT_WIDGET_PATH;

$dirs = array();
bt\file\BFiledir::getDirEntry($dirs, $path, 'd', 1);

sort($dirs);

$g5['title'] = '위젯추가';
include_once(G5_PATH.'/head.sub.php');
?>
<style type="text/css">
.td_apply{width:40px; text-align:center;}
.btn{border:1px solid #ddd; color:#333; background:#fff; padding:3px; margin:0;}
.btn:hover{ background:#eee;}
.widget-info{margin:0; padding:0; list-style:none;}
</style>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="tbl_head01 tbl_wrap">
    <table>
    <thead>
    <tr>
        <th scope="col">위젯ID</th>
        <th scope="col">위젯이름</th>
        <th scope="col">위젯정보</th>
        <th scope="col">적용</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($dirs as $dir){
        $widget = basename($dir);
        $winfo = get_widget_info($widget);
    ?>
    <tr>
        <td><?php echo $widget?></td>
        <td><?php echo isset($winfo['title']) ? $winfo['title'] : '-';?></td>
        <td class="td_left">
            <ul class="widget-info">
            <?php
            foreach($winfo as $key => $val){
                
                if($key=='title') continue;
                
                if($key=='description'){
                    $title = '설명';
                }else if($key=='version'){
                    $title = '버전';
                }else if($key=='author'){
                    $title = '작성자';
                }else if($key=='single'){
                    $title = '싱글위젯';
                }else{
                    $title = $key;
                }
                
                if(bt\isval($val)){
            ?>
                <li><span><?php echo $title?>:</span> <?php echo $val?></li>
            <?php
                }
            }?>
            </ul>
        </td>
        <td><button class="btn btn_apply" data-widget="<?php echo $widget?>">적용</button></td>
    </tr>
    <?php
    }
    ?>
    </tbody>
    </table>
    </div>
</div>

<form id="frm_widget_append" action="widget_append.php" method="post">
<input type="hidden" name="wg_skindir" id="wg_skindir" value="<?php echo $wg_skindir?>">
<input type="hidden" name="wp_id" id="wp_id" value="<?php echo $wp_id?>">
<input type="hidden" name="wg_id" id="wg_id" value="<?php echo $wg_id?>">
<input type="hidden" name="wg_name" id="wg_name" value="">
</form>

<script type="text/javascript">
<!--
$(function(){
    $('.btn_apply').click(function(){
        $('#wg_name').val($(this).data('widget'));
        $('#frm_widget_append').submit();
    });
})
//-->
</script>

<?php
include_once(G5_PATH.'/tail.sub.php');