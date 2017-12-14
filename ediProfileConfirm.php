<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 30.11.2017
 * Time: 13.51
 */

session_start();
include_once ('config/config.php');
include_once ('functions.php');

if($_POST['profileImg']) {
    editProfile($_SESSION['userId'], 'img', $_POST['profileImg'], $DBH);
}
if($_POST['profileName']) {
    editProfile($_SESSION['userId'], 'profileName', $_POST['profileName'], $DBH);
}

redirect('tosiIndex.php');

?>