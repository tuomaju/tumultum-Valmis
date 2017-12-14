<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 4.12.2017
 * Time: 15.44
 */
session_start();
include_once ("config/config.php");
include_once ("functions.php");
?>

<form class="searchForm" method="post" action="tosiIndex.php">
    <!--<p>Hae emojilla: </p>-->
    <input type="text" id="searchEmoji" class="inputEmoji" name="emojiSearch" placeholder="Hae">
    <input type="submit" id="searchBtn" value="" name="search">

</form>
