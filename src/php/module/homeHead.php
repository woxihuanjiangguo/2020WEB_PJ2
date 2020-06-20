<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$sql="SELECT ImageID FROM travelimagefavor";
$result = mysqli_query($link,$sql);
//数组中的每个对象 {imageID,imageLiked}
$pics = array();
$mostPic = array();
//$info中存储一些数组[id,title,path]
$info = array();

while($row = mysqli_fetch_assoc($result)){
    array_push($pics,$row['ImageID']);
}
$map = array_count_values($pics);
foreach ($map as $key=>$value){
    if(count($mostPic)<3){
        array_push($mostPic,$key);
    }
}
$sql = "SELECT ImageID,Title,PATH FROM travelimage where ImageID in('$mostPic[0]','$mostPic[1]','$mostPic[2]')";
$result = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($result)){
    if($row['PATH']==null){
        array_push($info,['id'=>$row['ImageID'],'title'=>$row['Title'],'path'=>'badpic.jpg']);
    }else{
        array_push($info,['id'=>$row['ImageID'],'title'=>$row['Title'],'path'=>$row['PATH']]);
    }

}

echo json_encode($info);

mysqli_free_result($result);
mysqli_close($link);

