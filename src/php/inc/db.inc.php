<?php
//链接数据库
function connect($host=MY_HOST,$user=MY_USER,$pass=MY_PASS,$database=MY_DATABASE,$port=MY_PORT){
    $link = @mysqli_connect($host,$user,$pass,$database,$port);
    if(mysqli_connect_errno()){
        exit(mysqli_connect_error());
    }
    mysqli_set_charset($link,'utf8');
    return $link;
}

