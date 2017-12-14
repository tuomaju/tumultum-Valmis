<?php
session_start();
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 28.11.2017
 * Time: 12.42
 */
?>

<form action="postConfirm.php" method="post" enctype="multipart/form-data">
    <h2>Uusi julkaisu</h2>
    <div id="emojiContainerMakepost">
        <input placeholder="" type="text" name="emoji1" class="inputEmoji vaalea">
        <input placeholder="" type="text" name="emoji2" class="inputEmoji vaalea">
        <input placeholder="" type="text" name="emoji3" class="inputEmoji vaalea">
        <input placeholder="" type="text" name="emoji4" class="inputEmoji vaalea">
    </div>
    <br>
    <input type="file" accept="audio/*" capture="microphone" name="upload" id="upload" class="uploadFile">
    <label for="upload"><img class="tumma" src="icons/mikki.svg"></label>
    <br>
    <div class="makePostSubmit">
        <input class="sendPostBtn" type="submit" value="Lähetä" name="submit">
    </div>
</form>



