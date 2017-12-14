<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 5.12.2017
 * Time: 14.30
 */
session_start();
include_once ('config/config.php');
include_once ('functions.php');

$profileId = $_REQUEST['profileId'];
?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>tumultum</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:600" rel="stylesheet">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body class="tumma">
<div class="modal">
    <div id="profileModal" class="modal-content profileModal oranssi">
        <div id="profileModalMain">
            <span id="closeProfileModal" class="closeModal">&times;</span>
            <?php
            include "search.php";
            ?>
            <div id="profile" class="vaalea">
                <div id="searchAndProfile">
                    <?php
                    include "profile.php";
                    ?>
                </div>
                <div id="editProfile">
                    <?php
                    include "editProfile.php";
                    ?>
                </div>
                <button class="sendCommentBtn tumma" id='editProfileBtn'>Muokkaa</button>
            </div>
        </div>
        <div id="profileModalFooter">
            <button id="logOutBtn" class="sendCommentBtn vaalea"><a href="logout.php">Kirjaudu ulos</a></button>
        </div>
    </div>
</div>

<div class="modal">
    <div id="makePostModal" class="modal-content makePostModal oranssi">
        <span id="closePostModal" class="closeModal">&times;</span>
        <div id="makePost">
            <?php
            include "makePost.php";
            ?>
        </div>
    </div>
</div>
<header id="stickyHeader" class="tumma">
    <img src="icons/menu.svg" id="openProfileModal">
    <a href="tosiIndex.php">
        <h1>tumultum</h1>
    </a>

    <img src="icons/menu2.svg" id="openMakePostModal">
</header>
<aside></aside>
<main id="indexMain">
    <?php
        echo '<div id="showProfile" class="vaalea" >';
        echo '<div id="showProfileInfo" class="vaalea" >';
        echo '<img class="profileimg" src="' . getProfile($profileId, $DBH)->img .  '">';
        echo '<p>' . getProfile($profileId, $DBH)->profileName.'</p>';
        echo '<p id="profileScore" class="vaalea">'. getProfileScore($profileId, $DBH)[0].'</p>';
        echo '</div>';
        echo '<ul class="vaalea" id="posts">';
        showProfilePosts($profileId ,$DBH);
        echo '</ul>';
        echo '</div>';
    ?>
</main>
<aside></aside>

<script src="js/main.js"></script>
</body>
</html>

