<?php
include_once '../../inc/config.inc.php';
include_once '../../inc/db.inc.php';
$link = connect();

$country = file_get_contents("php://input");


$sql = "SELECT AsciiName,GeoNameID FROM geocities WHERE Country_RegionCodeISO in ('$country')";
$result = mysqli_query($link, $sql);
$city = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($city,['cid'=>$row['GeoNameID'],'cname'=>$row['AsciiName']]);
}


echo json_encode($city);

mysqli_free_result($result);
mysqli_close($link);
