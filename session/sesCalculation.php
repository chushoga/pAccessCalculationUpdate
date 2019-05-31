<?php session_start(); date_default_timezone_set('Asia/Tokyo'); require_once '../master/dbconnect.php';
if(isset($_GET['rate1'])){
    $_SESSION['rate1'] = $_GET['rate1'];
    $_SESSION['percent1'] = $_GET['percent1'];
} else {
    $_SESSION['rate1'] = 0;
    $_SESSION['percent1'] = 0;
}
if(isset($_GET['rate2'])){
    $_SESSION['rate2'] = $_GET['rate2'];
    $_SESSION['percent2'] = $_GET['percent2'];
} else {
    $_SESSION['rate2'] = 0;
    $_SESSION['percent2'] = 0;
}
if(isset($_GET['maker'])){
    $maker = strstr($_GET['maker'], 'year');
    $table = strstr($_GET['maker'], ';', true);
    $_SESSION['maker'] = $maker;
    $_SESSION['makertable'] = $table;
} else {
    $_SESSION['maker'] = 0;
    $_SESSION['makertable'] = 0;
}
// ----------------------------

if(isset($_GET['currency1'])){
    $_SESSION['currency1'] = $_GET['currency1'];
} else {
    $_SESSION['currency1'] = 0;
}
if(isset($_GET['currency2'])){
    $_SESSION['currency2'] = $_GET['currency2'];
} else {
    $_SESSION['currency2'] = 0;
}
//-----------------------------

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
?>