<?php
 session_start();
?>
<form id="registerForm" action="confirm.php" method="post">
    <input class="indexform" type="text"  name="data[username]" placeholder="Käyttäjätunnus" required>
    <input class="indexform" type="email" name="data[email]" placeholder="Sähköposti" required>
    <input class="indexform" type="password" name="data[pwd]" placeholder="Salasana" required>
    <input id="registerSubmit" class="indexbtn sendCommentBtn vaalea" type="submit" value="Tallenna">
</form>

<?php
echo $_SESSION['laiton'];
?>


