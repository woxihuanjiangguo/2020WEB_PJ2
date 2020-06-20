<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$loginInfo = file_get_contents("php://input");
$loginInfo = json_decode($loginInfo,true);

$sql = 'SELECT UserName,UID,Pass FROM traveluser';
$result = mysqli_query($link,$sql);
//第一个代表用户名存在，第二个代表密码正确与否，第三个为id值
$infoCorrect = array(false,false,0);

while($row = mysqli_fetch_assoc($result)){
    if($loginInfo['username']==$row['UserName']){
        $infoCorrect[0] = true;
        if(sha1($loginInfo['username'].$loginInfo['userpass']) == $row['Pass']){
            $infoCorrect[1] = true;
            $infoCorrect[2] = $row['UID'];
        }
    }
}

//返回值
var_dump(json_encode($infoCorrect));

//释放
mysqli_free_result($result);
mysqli_close($link);
