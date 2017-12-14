<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 5.12.2017
 * Time: 10.08
 */

session_start();
include ('functions.php');
include ('config/config.php');

$postId = $_REQUEST['postId'];

echo $postId;

addLike($postId, $_SESSION['profileId'], -1, $DBH);

redirect('tosiIndex.php');


?>