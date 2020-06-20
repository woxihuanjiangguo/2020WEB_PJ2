<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$success = true;

$uidPid = file_get_contents("php://input");
$uidPid = json_decode($uidPid,true);

$uid = base64_decode($uidPid['uid']);
$uid = preg_split('/i/',$uid)[0];
$pid = $uidPid['pid'];
$status = $uidPid['status'];

if($status === 'liked'){
    $sql = "DELETE FROM travelimagefavor where UID in ('$uid') and ImageID in ('$pid')";
    $result = mysqli_query($link,$sql);
    echo 'cancelLike';
}else{
    $sql = "INSERT INTO travelimagefavor (UID,ImageID) VALUES ('".$uid."','".$pid."');";
    $result = mysqli_query($link,$sql);
    echo 'addLike';
}


mysqli_close($link);



