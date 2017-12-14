<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 1.12.2017
 * Time: 13.11
 */
session_start();
include_once ('config/config.php');
include_once ('functions.php');


//echo $_POST['comment'];
$Id = $_POST['postId'];
insertComment($_POST['comment'], $_SESSION['profileId'], $Id, $DBH);
redirect('tosiIndex.php');
?>