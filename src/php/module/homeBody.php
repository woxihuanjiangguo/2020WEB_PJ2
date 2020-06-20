<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();
//刷新的起始位置


$sql="SELECT ImageID FROM travelimagefavor";
$result = mysqli_query($link,$sql);
//数组中的每个对象 {imageID,imageLiked}
$pics = array();
$mostPic = array();
//$info中存储一些数组[id,title,path]
$info = array();
$returnPics = array();


while($row = mysqli_fetch_assoc($result)){
    array_push($pics,$row['ImageID']);
}
$map = array_count_values($pics);
foreach ($map as $key=>$value){
    if(count($mostPic)<3){
        array_push($mostPic,$key);
    }
}

$sql = "SELECT ImageID,Title,PATH,Description FROM travelimage where 
ImageID <> '$mostPic[0]' and ImageID <> '$mostPic[1]' and ImageID <> '$mostPic[2]' 
order by RAND() LIMIT 9";
$result = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($result)){
    if($row['PATH']==null){
        array_push($returnPics,
            ['id'=>$row['ImageID'],'title'=>$row['Title'],'path'=>'badpic.jpg','description'=>$row['Description']]);
    }else{
        array_push($returnPics,
            ['id'=>$row['ImageID'],'title'=>$row['Title'],'path'=>$row['PATH'],'description'=>$row['Description']]);
    }

}
echo json_encode($returnPics);

mysqli_free_result($result);
mysqli_close($link);
