<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

$message = file_get_contents("php://input");
$message = json_decode($message, true);
$sql = "";
$infoReturn = [];

if ($message['logic'] == '0') {
    $sql = "SELECT ImageID,PATH FROM travelimage LIMIT 45";
} elseif ($message['logic'] == '1') {
    $searchCountryCode = $message['content'];
    $sql = "SELECT ImageID,PATH FROM travelimage 
    where Country_RegionCodeISO in ('$searchCountryCode') LIMIT 45";
} elseif ($message['logic'] == '2') {
    $searchCityCode = $message['content'];
    $sql = "SELECT ImageID,PATH FROM travelimage 
    where CityCode in ('$searchCityCode') LIMIT 45";
} elseif ($message['logic'] == '3') {
    $searchContent = $message['content'];
    $sql="SELECT ImageID,PATH FROM travelimage
    where Content in ('$searchContent') LIMIT 45";
} elseif ($message['logic'] == '4') {
    $postAr = preg_split("/\|/",$message['content']);
    $searchContentCode = $postAr[0];
    $searchCountryCode = $postAr[1];
    $searchCityCode = $postAr[2];
    $searchContent = '';

    switch ($searchContentCode) {
        case 'S':
            $searchContent = 'scenery';
            break;
        case 'C':
            $searchContent = 'city';
            break;
        case 'P':
            $searchContent = 'people';
            break;
        case 'A':
            $searchContent = 'animal';
            break;
        case 'B':
            $searchContent = 'building';
            break;
        case 'W':
            $searchContent = 'wonder';
            break;
        case 'O':
            $searchContent = 'other';
            break;
    }

    if($searchCountryCode == '0'&&$searchCityCode=='0'){
        $sql = "SELECT ImageID,PATH FROM travelimage 
    where Content in ('$searchContent') LIMIT 45";
    }elseif ($searchCountryCode!='0'&&$searchCityCode=='0'){
        $sql = "SELECT ImageID,PATH FROM travelimage 
    where Content in ('$searchContent') and Country_RegionCodeISO in ('$searchCountryCode') LIMIT 45";
    }elseif ($searchCityCode!='0'){
        $sql = "SELECT ImageID,PATH FROM travelimage 
    where Content in ('$searchContent') and CityCode in ('$searchCityCode') LIMIT 45";
    }

}elseif ($message['logic'] == '5'){
    $searchTitle = $message['content'];
    $sql = "SELECT ImageID,PATH FROM travelimage where Title like '%".$searchTitle."%' LIMIT 45";
}

$result = mysqli_query($link, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['PATH'] == null) {
        array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => 'badpic.jpg']);
    } else {
        array_push($infoReturn, ['pid' => $row['ImageID'], 'path' => $row['PATH']]);
    }

}
mysqli_free_result($result);
mysqli_close($link);
echo json_encode($infoReturn);



