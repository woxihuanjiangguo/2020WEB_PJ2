<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$message = file_get_contents("php://input");
$message = json_decode($message, true);
$sql = "";
$infoReturn = [];

if ($message['logic'] == '0') {
    $sql = "SELECT ImageID,PATH,Title,Description FROM travelimage LIMIT 30";
}elseif ($message['logic'] == '5'){
    $searchTitle = $message['content'];
    $sql = "SELECT ImageID,PATH,Title,Description FROM travelimage where Title like '%".$searchTitle."%' LIMIT 30";
}elseif ($message['logic']=='6'){
    $searchDescription = $message['content'];
    $sql = "SELECT ImageID,PATH,Title,Description FROM travelimage where Description like '%".$searchDescription."%' LIMIT 30";
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



