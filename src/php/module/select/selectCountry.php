<?php
include_once '../../inc/config.inc.php';
include_once '../../inc/db.inc.php';
$link = connect();

$sql = "SELECT Country_RegionName,ISO FROM geocountries_regions";
$result = mysqli_query($link,$sql);
$country = array();

while($row = mysqli_fetch_assoc($result)){
    array_push($country,['iso'=>$row['ISO'],'countryName'=>$row['Country_RegionName']]);
}

echo json_encode($country);

mysqli_free_result($result);
mysqli_close($link);
