<?php
session_start();
if (isset ($_GET['tformNo'])){
    $tformNo = $_GET['tformNo'];
    unset($_SESSION[$tformNo]);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "REDIRECT OUT BECAUSE NOT SET";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

?>