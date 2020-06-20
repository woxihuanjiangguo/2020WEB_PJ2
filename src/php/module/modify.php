<?php
include_once '../inc/config.inc.php';
include_once '../inc/db.inc.php';
$link = connect();

//title description content country city
$newPicInfo = json_decode($_POST['param']);
$uid = preg_split("/i/",base64_decode($newPicInfo->uid))[0];
$pid = $newPicInfo->pid;
$city = $newPicInfo->city;
$country = $newPicInfo->country;
$title = $newPicInfo->title;
$description = $newPicInfo->description;
$content = $newPicInfo->content;
$ifAlter = $newPicInfo->ifAlter;
$pid = $newPicInfo->pid;
$oldPath = "";

//查一遍原来的路径
$addedsql = "SELECT PATH FROM travelimage where ImageID in ('$pid')";
$resultx = mysqli_query($link,$addedsql);
while ($row = mysqli_fetch_assoc($resultx)){
    $oldPath = $row['PATH'];
}


//随机文件名
$newPath = rand(1000000000000, time());
if($ifAlter){
    if(file_exists('../../../img/travel-images/large/'.$oldPath)){
        unlink('../../../img/travel-images/large/'.$oldPath);

        $allowedExts = array("jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);     // 获取文件后缀名
        if ((($_FILES["file"]["type"] == "image/jpeg")
                || ($_FILES["file"]["type"] == "image/jpg")
                || ($_FILES["file"]["type"] == "image/pjpeg")
                || ($_FILES["file"]["type"] == "image/x-png")
                || ($_FILES["file"]["type"] == "image/png"))
            && ($_FILES["file"]["size"] < 10240000)   // 小于 10 mb
            && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "bad";
            } else {
                if (file_exists("../../../img/travel-images/large/" . $newPath . "." . $extension)) {
                    echo "bad";
                } else {
                    $newFileName = $newPath . "." . $extension;
                    if($city==0){
                        //无城市
                        $sql1 = "UPDATE travelimage SET Title = '$title',Description = '$description',Country_RegionCodeISO = '$country',PATH = '$newFileName',Content = '$content'
WHERE ImageID = '$pid'";
                        $result = mysqli_query($link,$sql1);
                    }else{
                        $sql2 = "UPDATE travelimage SET Title = '$title',Description = '$description',CityCode = '$city',Country_RegionCodeISO = '$country',PATH = '$newFileName',Content = '$content'
WHERE ImageID = '$pid'";
                        $result = mysqli_query($link,$sql2);
                    }
                    move_uploaded_file($_FILES["file"]["tmp_name"],
                        "../../../img/travel-images/large/" . $newPath . "." . $extension);
                    echo "good";
                }
            }
        } else {
            echo "bad";
        }
    }else{
        echo "bad";
    }
}else{
    if($city==0){
        //无城市
        $sql1 = "UPDATE travelimage SET Title = '$title',Description = '$description',Country_RegionCodeISO = '$country',Content = '$content'
WHERE ImageID = '$pid'";
        $result = mysqli_query($link,$sql1);
    }else{
        $sql2 = "UPDATE travelimage SET Title = '$title',Description = '$description',CityCode = '$city',Country_RegionCodeISO = '$country',Content = '$content'
WHERE ImageID = '$pid'";
        $result = mysqli_query($link,$sql2);
    }
    echo "good";
}

