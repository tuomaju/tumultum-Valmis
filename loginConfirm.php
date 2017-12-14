<?php
session_start();
require_once('config/config.php');
?>
<?php
/**
 * Etsii annetun käyttäjän tiedot kannasta
 * @param $user
 * @param $pwd
 * @param $DBH
 * @return $row käyttäjäolio ,boolean false jos annettua käyttäjää ja salasanaa löydy
 */
function login($user, $pwd,  $DBH) {

    $hashpwd = hash('md5', $pwd.'&8gT');
    $userdata = array('username' => $user, 'pwd' => $hashpwd);

    try {
        $STH = $DBH->prepare("SELECT * FROM p_user AS u, p_profile AS p WHERE u.username = '$user' AND
        u.pwd = '$hashpwd' AND p.profileUser = u.userId");

        $STH->execute($userdata);
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $row = $STH->fetch();
        //var_dump( $row);
        if($STH->rowCount() > 0){
            return $row;
        } else {
            return false;
        }
    } catch(PDOException $e) {
        echo "Login DB error.";
        file_put_contents('log/DBErrors.txt', 'Login: '.$e->getMessage()."\n", FILE_APPEND);
    }
}


SSLon();

$user = login($_POST['username'], $_POST['pwd'], $DBH);
//print_r($user);
if(!$user){
    $_SESSION['loggausvirhe'] = 'jep';
    echo('xd');

   redirect('index.php');

} else {
    unset($_SESSION['loggausvirhe']);
    //Jos käyttäjä tunnistettiin, talletetaan tiedot sessioon
    $_SESSION['kirjautunut'] = 'yes';
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['email']=$user->email;
	$_SESSION['userId']=$user->userId;
	$_SESSION['profileId']=$user->profileId;

	//$_SESSION['email'] = $user->email;
	//print_r($_SESSION['userId']);
	//Jos loggaus onnistuu niin palataan pääsivulle
	redirect('tosiIndex.php');
}

?>
