<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$message = file_get_contents("php://input");
$message = json_decode($message, true);
$uid = preg_split("/i/",base64_decode($message['uid']))[0];
$pid = $message['pid'];
$sql = "";


if($message['request']=='0'){
    $sql="DELETE FROM travelimagefavor WHERE UID in ('$uid') and ImageID in ('$pid')";
    $result = mysqli_query($link,$sql);
}elseif($message['request']=='1'){
    $sql="SELECT PATH FROM travelimage where ImageID in ('$pid')";
    $result = mysqli_query($link,$sql);
    $oldPath = "";
    while($row = mysqli_fetch_assoc($result)){
        $oldPath = $row['PATH'];
    }
    if(file_exists('../../../img/travel-images/large/'.$oldPath)){
        unlink('../../../img/travel-images/large/'.$oldPath);
    }
    $sql2 = "DELETE FROM travelimage where ImageID in ('$pid')";
    $result = mysqli_query($link,$sql2);
    $sql3 = "DELETE FROM travelimagefavor WHERE ImageID in ('$pid')";
    $result = mysqli_query($link,$sql3);
}


