<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$registerInfo = file_get_contents("php://input");
$registerInfo = json_decode($registerInfo,true);

$sql = 'SELECT UserName,Email FROM traveluser';
$result = mysqli_query($link,$sql);
//第一个代表用户名重复，第二个代表邮箱重复，第三个为id值
$repeatExist = array(false,false,0);

while($row = mysqli_fetch_assoc($result)){
    if($registerInfo['username']==$row['UserName']){
        $repeatExist[0] = true;
    }
    if($registerInfo['email']==$row['Email']){
        $repeatExist[1] = true;
    }
}
$hashSaltPass = sha1($registerInfo['username'].$registerInfo['password']);
if((!$repeatExist[0])&&(!$repeatExist[1])){
    $sql2 = "INSERT INTO traveluser (UserName,Email,Pass,State,DateJoined,DateLastModified)
VALUES ('".$registerInfo['username']."','".$registerInfo['email']."','".$hashSaltPass."',1,current_date,current_date);";
    mysqli_query($link, $sql2);
}

//若没有问题 返回新用户id
if(!$repeatExist[0]&&!$repeatExist[1]){
    $newIdQuery = mysqli_query($link,"SELECT max(UID) FROM traveluser");
    while($row = mysqli_fetch_assoc($newIdQuery)){
        $repeatExist[2] = $row['max(UID)'];
    }


}
//返回值
var_dump(json_encode($repeatExist));

//释放
mysqli_free_result($result);
mysqli_close($link);





