<?php

session_start();
require_once 'config/config.php';
echo 'Hei hei =)';
session_destroy();
redirect('index.php');
?>