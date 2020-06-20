<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$uidPid = file_get_contents("php://input");
$uidPid = json_decode($uidPid,true);

$picId = $uidPid['pid'];
$uid = base64_decode($uidPid['uid']);
$uid = preg_split('/i/',$uid)[0];
$likeRepeated = false;

$sql = "SELECT * FROM travelimage where ImageID in ('$picId')";
$result = mysqli_query($link,$sql);
//第一个为基本信息，然后是用户、喜欢次数，最后是国家、城市
$infoReturn =[];
$infoToCheck=[];
$likedNum = 0;
//原图信息
while($row=mysqli_fetch_assoc($result)){
    array_push($infoReturn,['description'=>$row['Description'],'path'=>$row['PATH'],
        'content'=>$row['Content'],'title'=>$row['Title']]);
    array_push($infoToCheck,$row['UID'],$row['CityCode'],$row['Country_RegionCodeISO']);
}
//用户信息：上传者+喜欢的次数
$sql = "SELECT UserName FROM traveluser where UID in ('$infoToCheck[0]')";
$result = mysqli_query($link,$sql);
while($row=mysqli_fetch_assoc($result)){
    array_push($infoReturn,['user'=>$row['UserName']]);
}

$sql = "SELECT * FROM travelimagefavor where ImageID in ('$picId')";
$result = mysqli_query($link,$sql);
while($row=mysqli_fetch_assoc($result)){
    if($row['UID'] == $uid){
        $likeRepeated = true;
    }
    $likedNum++;
}
array_push($infoReturn,['liked'=>$likedNum]);

//城市与国家
$sql = "SELECT AsciiName FROM geocities where GeoNameID in ('$infoToCheck[1]')";
$result = mysqli_query($link,$sql);
if($infoToCheck[1]==null){
    array_push($infoReturn,['city'=>'Unknown']);
}else{
    while($row = mysqli_fetch_assoc($result)){
        array_push($infoReturn,['city'=>$row['AsciiName']]);
    }
}

$sql = "SELECT Country_RegionName FROM geocountries_regions where ISO in ('$infoToCheck[2]')";
$result = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($result)){
    array_push($infoReturn,['country'=>$row['Country_RegionName']]);
}
if($likeRepeated){
    array_push($infoReturn,['likeExists'=>'true']);
}else{
    array_push($infoReturn,['likeExists'=>'false']);
}



echo json_encode($infoReturn);

mysqli_free_result($result);
mysqli_close($link);

