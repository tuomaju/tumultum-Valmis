<?php
/**
 * Created by PhpStorm.
 * User: tuomaju
 * Date: 30.11.2017
 * Time: 13.37
 */

session_start();
include_once ('config/config.php');
include_once ('functions.php');
?>

<?php
    $postId = $j;
?>

<ul class="comments">
    <?php
        showComments($postId, $DBH);
    ?>
</ul>
<br>

<?php
/*
    echo'<textarea class="commentTextarea" name="comment" form="commentForm" cols="40" rows="5" placeholder="Sano jotain mukavaa :^)" maxlength="140">';
    echo'</textarea><!-- tähän regex -->';
*/
    echo'<form class="commentForm" method="post" action="makeComment.php">';
        echo '<input type="text" hidden name="postId" value="'. $postId .'">';
        echo '<input class="commentTextarea" type="text" name="comment" maxlength="140" placeholder="Kommentoi">';
        echo'<input class="sendCommentBtn tumma" type="submit" value="Lähetä">';
    echo'</form>';
?>
