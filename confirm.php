<?php
session_start();
include_once ('config/config.php');

$data = $_POST['data'];
//tallennetaan sessiomuuttujaan :)
$_SESSION['lomakedata'] = serialize($data);
//var_dump( $data);
//var_dump($_SESSION['lomakedata']);
//Ovatko email ja käyttis laillisia
if(filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    if(preg_match("/^[a-öA-Ö ]*$/",$data['username'])) {
        redirect("saveUser.php");
        echo '<br>';
        $_SESSION['laiton'] = '';
    }else {
        echo("<h3>LAITON KÄYTTÄJÄNIMESSÄ: <br />"
            .$data['username'] ."</h3>");
        $_SESSION['laiton'] = 'Laiton käyttätunnus';
    }
}else{
    echo("<h3>LAITON SÄHKÖPOSTIOSOITE: <br />"
        .$data['email']."</h3>");
    $_SESSION['laiton'] = 'Laiton sähköpostiosoite';
}
echo '<a href="index.php">Takaisin</a>';
?>
