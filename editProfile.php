<?php
session_start();
include_once ('config/config.php');
include_once ('functions.php');
?>

<?php
    echo '<div class="editProfileInfo">';
    echo '<h2>Muokkaa profiilia</h2>';
    echo '<img class="profileimg" src="' . getProfile($_SESSION['profileId'], $DBH)->img .  '">';
    echo '<p>Käyttäjätunnus: ' . $_SESSION['username']. '</p>';
    echo '<p>Sähköposti: '.$_SESSION['email'] .'</p>';
    echo '<p>Nimi: ' . getProfile($_SESSION['profileId'], $DBH)->profileName.'</p>';
    echo '<p>Suosio: '.getProfileScore($_SESSION['profileId'], $DBH)[0] .'</p>';
    echo '</div>';
?>

<br>
<form class="editProfileForm" method="POST" action="ediProfileConfirm.php">
    <input id="giveName" type="text" name="profileName" placeholder="Anna uusi nimi" maxlength="15">
    <div class="profileImages">
        <label class="editProfileLabel">
            <input class="editProfileInput" type="radio" name="profileImg" value="profile_images/placeholder.jpg">
            <img class="editProfileImg" src="profile_images/placeholder.jpg">
        </label>
        <label class="editProfileLabel">
            <input class="editProfileInput" type="radio" name="profileImg" value="profile_images/placeholder2.jpg">
            <img class="editProfileImg" src="profile_images/placeholder2.jpg">
        </label>
        <br>
        <label class="editProfileLabel">
            <input class="editProfileInput" type="radio" name="profileImg" value="profile_images/placeholder3.jpg">
            <img class="editProfileImg" src="profile_images/placeholder3.jpg">
        </label>
        <label class="editProfileLabel">
            <input class="editProfileInput" type="radio" name="profileImg" value="profile_images/placeholder4.jpg">
            <img class="editProfileImg" src="profile_images/placeholder4.jpg">
        </label>
    </div>
    <input id="saveProfile" class="sendCommentBtn tumma" type="submit" value="Tallenna">
</form>
