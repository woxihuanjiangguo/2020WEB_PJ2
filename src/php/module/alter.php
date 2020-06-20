<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$pid = file_get_contents("php://input");
$pid = json_decode($pid);
$originalInfo = [];

$sql = "SELECT * FROM travelimage where ImageID in ('$pid')";
$result = mysqli_query($link,$sql);

while($row = mysqli_fetch_assoc($result)){
    if($row['CityCode']==''){
        array_push($originalInfo,['content'=>$row['Content'],'title'=>$row['Title'],
            'description'=>$row['Description'],'cid'=>0,'iso'=>$row['Country_RegionCodeISO'],
            'path'=>$row['PATH']]);
    }else{
        array_push($originalInfo,['content'=>$row['Content'],'title'=>$row['Title'],
            'description'=>$row['Description'],'cid'=>$row['CityCode'],'iso'=>$row['Country_RegionCodeISO'],
            'path'=>$row['PATH']]);
    }

}

echo json_encode($originalInfo);
