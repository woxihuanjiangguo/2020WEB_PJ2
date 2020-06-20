<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$message = file_get_contents("php://input");
$message = json_decode($message, true);
$uid = preg_split("/i/",base64_decode($message['content']))[0];
$sql = "";
$infoReturn = [];

if ($message['logic'] == '7') {
    //我的图片
    $sql = "SELECT * FROM travelimage where UID in ('$uid')";
}elseif ($message['logic'] == '8'){
    //喜欢图片
    $sql = "SELECT * FROM travelimage a INNER JOIN travelimagefavor b ON a.ImageID = b.ImageID WHERE b.UID in ('$uid')";
}

$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['PATH'] == null) {
        if($row['Description']==null){
            array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => 'badpic.jpg','title'=>$row['Title'],'description'=>'No description so far']);
        }else{
            array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => 'badpic.jpg','title'=>$row['Title'],'description'=>$row['Description']]);
        }
    } else {
        if($row['Description']==null){
            array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => $row['PATH'],'title'=>$row['Title'],'description'=>'No description so far']);
        }else{
            array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => $row['PATH'],'title'=>$row['Title'],'description'=>$row['Description']]);
        }
    }
}
mysqli_free_result($result);
mysqli_close($link);
echo json_encode($infoReturn);



