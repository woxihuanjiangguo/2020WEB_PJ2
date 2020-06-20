<?php
include_once '../../inc/config.inc.php';
include_once '../../inc/db.inc.php';
$link = connect();

$mostCity = [];
$city = [];
$mostCountry = [];
$country = [];
$countryName=[];
$cityName=[];


$sql = "SELECT CityCode,Country_RegionCodeISO FROM travelimage";
$result = mysqli_query($link, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    if($row['CityCode']==null){
    }else{
        array_push($city, $row['CityCode']);
    }
    array_push($country, $row['Country_RegionCodeISO']);
}
$mapCity = array_count_values($city);
arsort($mapCity,1);
$mapCountry = array_count_values($country);
arsort($mapCountry,1);


foreach ($mapCity as $key => $value) {
    if(count($mostCity)<3){
        array_push($mostCity, $key);
    }

}
foreach ($mapCountry as $key => $value) {
    if(count($mostCountry)<3) {
        array_push($mostCountry, $key);
    }
}
$sql = "SELECT AsciiName,GeoNameID FROM geocities where GeoNameID in('$mostCity[0]','$mostCity[1]','$mostCity[2]')";
$sql2 = "SELECT Country_RegionName,ISO FROM geocountries_regions where ISO in('$mostCountry[0]','$mostCountry[1]','$mostCountry[2]')";

$result = mysqli_query($link,$sql);
while($row = mysqli_fetch_assoc($result)){
    array_push($cityName,['name'=>$row['AsciiName'],'cid'=>$row['GeoNameID']]);
}
$result = mysqli_query($link,$sql2);
while($row = mysqli_fetch_assoc($result)){
    array_push($countryName,['name'=>$row['Country_RegionName'],'iso'=>$row['ISO']]);
}

echo json_encode(array($countryName,$cityName));

mysqli_free_result($result);
mysqli_close($link);