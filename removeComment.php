<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 5.12.2017
 * Time: 14.55
 */
session_start();
include_once ('config/config.php');
include_once ('functions.php');

$commentId = $_REQUEST['commentId'];
removeComment($commentId, $DBH);
redirect('tosiIndex.php');

?>