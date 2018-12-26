<?php
if(!defined("_GNUBOARD_")) exit("Access Denied");

if(!function_exists('sql_affected_rows')){
function sql_affected_rows($link=null){
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];

    if(function_exists('mysqli_affected_rows') && G5_MYSQLI_USE)
        return mysqli_affected_rows($link);
    else
        return mysql_affected_rows($link);
}}


if(!function_exists('sql_field_len')){
function sql_field_len($result){
    
    global $g5;

    if(!$link)
        $link = $g5['connect_db'];
    
    if(function_exists('mysqli_field_len') && G5_MYSQLI_USE)
        mysqli_field_count($link);
    else
        mysql_field_len($link);
}}
