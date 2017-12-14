<?php
session_start();
require_once('config/config.php');

SSLon();

$userdata = unserialize($_SESSION['lomakedata']);  //sessiomuuttujasta taulukoksi
$email = $userdata['email'];
$username = $userdata['username'];
$pwd = $userdata['pwd'];
$placeholderImg = 'profile_images/placeholder2.jpg';

try {
    $STH = $DBH->prepare("SELECT * FROM p_user WHERE email= '$email' OR username='$username'");   //myös username tähän ettei samoja usernameja
    $STH->execute($userdata);

    if($STH->rowCount() == 0){ //rekisteröidään
    $pwd = md5($userdata['pwd'].'&8gT');  //hashataan salasana suolalla
        try {
            $STH2 = $DBH->prepare("INSERT INTO p_user (username, email, pwd, admin)
            VALUES ('$username', '$email','$pwd', 0);");
                if($STH2->execute($userdata)){
                    try {
                        try {
                            $STH4 = $DBH->prepare("INSERT INTO p_profile (img, profileUser, profileName)
                            VALUES ('$placeholderImg', ".$DBH->lastInsertId().", '$username')");
                            $STH4->execute();
                        }catch(PDOException $e){
                            echo'Profillia ei luotu';
                            echo'<button id="registerBackBtn" class="sendCommentBtn"><a href="index.php">Takaisin</a></button>';
                        }
                        session_destroy();
                        redirect('index.php');
                    } catch(PDOException $e) {
                        echo 'Käyttäjän tietojen hakuerhe';
                        file_put_contents('log/DBErrors.txt', 'tallennaKayttaja 3:
                        '.$e->getMessage()."\n", FILE_APPEND);
                    }
                }
        }catch(PDOException $e) {
            echo 'Tietojen lisäyserhe';
            file_put_contents('log/DBErrors.txt', 'tallennaKayttaja 2: '.$e->getMessage()."\n",
                FILE_APPEND);
            echo'<button id="registerBackBtn" class="sendCommentBtn"><a href="index.php">Takaisin</a></button>';
        }
    }else{
            echo 'Käyttäjä on jo olemassa.';
        echo'<button id="registerBackBtn" class="sendCommentBtn"><a href="index.php">Takaisin</a></button>';
        }
} catch(PDOException $e) {	echo 'Tietokantaerhe.';
    file_put_contents('log/DBErrors.txt', 'tallennaKayttaja 1: '.$e->getMessage()."\n", FILE_APPEND);
    echo'<button id="registerBackBtn" class="sendCommentBtn"><a href="index.php">Takaisin</a></button>';
}
?>
