<?php
session_start();
include_once('functions.php');
include_once ('config/config.php');
$_SESSION['search']='';
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
    <div id="profileModal"  class="profileModal oranssi">
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
    <div  id="makePostModal" class="makePostModal oranssi">
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
    <?php
    if($_SESSION['kirjautunut']=='yes'){

?>

<aside></aside>
<main id="indexMain">
    <ul id="posts">
        <?php
            if($_POST['emojiSearch']){
                $_SESSION['search'] = $_POST['emojiSearch'];
            }
            showPosts(getMaxId('postId', 'p_post', $DBH)[0],$_SESSION['search'], $DBH);
            $_SESSION['search']='';
        ?>
    </ul>
</main>
<aside></aside>
<?php
    }else{
        echo'Olet kirjautunut ulos.';
        echo('<button><a href="index.php">Etusivulle</a></button>');
    }
?>
<script src="js/main.js"></script>
</body>
</html>