<h2>Profiili</h2>

<?php
/**
 * Created by PhpStorm.
 * User: Tume
 * Date: 10/12/2017
 * Time: 17:31
 */

echo '<img class="profileimg" src="' . getProfile($_SESSION['profileId'], $DBH)->img .  '">';
echo '<p>'.getProfile($_SESSION['profileId'], $DBH)->profileName.'</p>';
echo '<p id="profileScore" class="vaalea">'. getProfileScore($_SESSION['profileId'], $DBH)[0].'</p>';
?>