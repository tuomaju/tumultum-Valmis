<?php
session_start();
include_once ('config/config.php');
include_once ('functions.php');

$target_dir = "posts/";
$target_file = $target_dir . basename($_FILES["upload"]["name"]);
$uploadOk = 1;
$audioFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$newFile = $target_dir . uniqid() . '.' . $audioFileType;

// Check if image file is a actual audio or fake audio
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["upload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an audio - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an audio.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($newFile)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["upload"]["size"] > 2000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($audioFileType != "mp3" && $audioFileType != "wav" && $audioFileType != "m4a"
    && $audioFileType != "wma" && $audioFileType != "aac") {
    echo "Sorry, only mp3, wav, m4a, wma, aac files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["upload"]["tmp_name"], $newFile)) {
        echo "The file ". basename( $_FILES["upload"]["name"]). " has been uploaded.";
        makePost($newFile, $_POST["emoji1"], $_POST["emoji2"], $_POST["emoji3"], $_POST["emoji4"], $_SESSION['profileId'], $DBH);
        redirect('tosiIndex.php');
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}



?>