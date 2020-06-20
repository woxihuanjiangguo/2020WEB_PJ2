<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();
$logInfo = file_get_contents("php://input");
$logInfo = json_decode($logInfo,true);


$salt = "ilikeweb";
var_dump(base64_encode($logInfo['userid'].$salt));


