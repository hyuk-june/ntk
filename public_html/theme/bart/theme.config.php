<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//기본 데이타도 입력할 것인지 입력하지 않으면 false
// /data/bart 폴더가 있으면 실행하지 않음
define('_BT_DATA_', true);

function bt_check_installed(){
    
    $tables = array();
    $tables[] = "bt_alim";
    $tables[] = "bt_file_manager";
    $tables[] = "bt_frame";
    $tables[] = "bt_menu";
    $tables[] = "bt_page";
    $tables[] = "bt_widget";

    $sql = "SELECT COUNT(*) as cnt
        FROM information_schema.tables
        WHERE table_schema = '".G5_MYSQL_DB."'
        AND table_name IN ('".implode("', '", $tables)."');";

    $rs = sql_fetch($sql);
    if($rs["cnt"] < count($tables)) return false;
    return true;
}

function bt_get_install_sql($filepath){
    $line = file($filepath);
    array_shift($line);
    $str = @implode(PHP_EOL, $line);
    unset($line);

    $str = preg_replace('~\-\-[^\r\n]*[\r\n]~is', '', $str);
    $line = explode('=====123456789=====', $str);
    $line = array_map('trim', $line);
    $line = array_filter($line);
    
    return $line;
}

/**
 * Copy a file, or recursively copy a folder and its contents
 * @author      Aidan Lister <aidan@php.net>
 * @version     1.0.1
 * @link        http://aidanlister.com/2004/04/recursively-copying-directories-in-php/
 * @param       string   $source    Source path
 * @param       string   $dest      Destination path
 * @param       int      $permissions New folder creation permissions
 * @return      bool     Returns true on success, false on failure
 */
function bt_xcopy($source, $dest, $permissions = 0755)
{
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }

    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }

    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest, $permissions);
    }

    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..') {
            continue;
        }

        // Deep copy directories
        bt_xcopy("$source/$entry", "$dest/$entry", $permissions);
    }

    // Clean up
    $dir->close();
    return true;
}


//설치안되어 있으면 설치함
if($_POST["theme"]=='bart'){
    
    if(!bt_check_installed()){

        //테이블 생성하기    
        $line = bt_get_install_sql( G5_PATH.'/theme/bart/adm/schema.php' );

        foreach($line as $sql){
            try{
                sql_query($sql);
            }catch(Exception $e){}
        }
    }

    //기본데이타 입력하기
    if(_BT_DATA_ === true && !is_dir(G5_DATA_PATH.'/bart')){
        
        $line = bt_get_install_sql( G5_PATH.'/theme/bart/adm/schema_insert.php' );
        
        foreach($line as $sql){
            try{
                sql_query($sql);
            }catch(Exception $e){}
        }
        
        bt_xcopy(G5_PATH.'/theme/bart/init_data', G5_PATH.'/data/bart', 0755);
    }
}


//반응형이므로 무조건 pc 로 지정되게 한다
define('G5_THEME_DEVICE', 'pc');

$theme_config = array();

// 갤러리 이미지 수 등의 설정을 지정하시면 게시판관리에서 해당 값을
// 가져오기 기능을 통해 게시판 설정의 해당 필드에 바로 적용할 수 있습니다.
// 사용하지 않는 스킨 설정은 값을 비워두시면 됩니다.

$theme_config = array(
    'set_default_skin'          => true,   // 기본환경설정의 최근게시물 등의 기본스킨 변경여부 true, false
    'preview_board_skin'        => 'basic', // 테마 미리보기 때 적용될 기본 게시판 스킨
    'preview_mobile_board_skin' => '', // 테마 미리보기 때 적용될 기본 모바일 게시판 스킨
    'cf_member_skin'            => 'basic', // 회원 스킨
    'cf_mobile_member_skin'     => '', // 모바일 회원 스킨
    'cf_new_skin'               => 'basic', // 최근게시물 스킨
    'cf_mobile_new_skin'        => '', // 모바일 최근게시물 스킨
    'cf_search_skin'            => 'basic', // 검색 스킨
    'cf_mobile_search_skin'     => '', // 모바일 검색 스킨
    'cf_connect_skin'           => 'basic', // 접속자 스킨
    'cf_mobile_connect_skin'    => '', // 모바일 접속자 스킨
    'cf_faq_skin'               => 'basic', // FAQ 스킨
    'cf_mobile_faq_skin'        => '', // 모바일 FAQ 스킨
    'bo_gallery_cols'           => 4,       // 갤러리 이미지 수
    'bo_gallery_width'          => 174,     // 갤러리 이미지 폭
    'bo_gallery_height'         => 124,     // 갤러리 이미지 높이
    'bo_mobile_gallery_width'   => 125,     // 모바일 갤러리 이미지 폭
    'bo_mobile_gallery_height'  => 100,     // 모바일 갤러리 이미지 높이
    'bo_image_width'            => 600,     // 게시판 뷰 이미지 폭
    'qa_skin'                   => 'basic', // 1:1문의 스킨
    'qa_mobile_skin'            => ''  // 1:1문의 모바일 스킨
);
