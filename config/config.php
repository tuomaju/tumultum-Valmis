<?php
$user = 'sannaluo';
$pass = 'sannamysli';
$host = 'mysql.metropolia.fi';
$dbname = 'sannaluo';


session_save_path('/home1-3/t/tuomaju/public_html/2.vuosi2.jakso/projekti/session');
 ini_set('session.gc_probability', 1);
// Cookie voimassa kunnes selain suljetaan eli myös sessio vanhenee silloin
session_set_cookie_params ( 0, '/~tuomaju/2.vuosi2.jakso/projekti/' );
session_start();


try {
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

    $DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    $DBH->exec("SET NAMES utf8;");
} catch(PDOException $e) {
    echo "Yhteysvirhe.";
    file_put_contents('log/DBErrors.txt', 'Connection: '.$e->getMessage()."\n", FILE_APPEND);
}

function redirect($url){
    if (!headers_sent()){
        header('Location: '.$url); exit;
    }else{
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

function SSLon(){
    if($_SERVER['HTTPS'] != 'on'){
        $url = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        redirect($url);
    }
}

function SSLoff(){
    if($_SERVER['HTTPS'] == 'on'){
        $url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        redirect($url);
    }
}
?>

